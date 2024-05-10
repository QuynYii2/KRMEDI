<?php

namespace App\Http\Controllers\restapi;

use App\Enums\MessageStatus;
use App\Enums\online_medicine\OnlineMedicineStatus;
use App\Enums\PrescriptionResultStatus;
use App\Enums\TypeProductCart;
use App\Enums\UserStatus;
use App\Events\NewMessage;
use App\ExportExcel\MedicineExport;
use App\Http\Controllers\Controller;
use App\Imports\ExcelImportClass;
use App\Models\Cart;
use App\Models\Chat;
use App\Models\Message;
use App\Models\online_medicine\ProductMedicine;
use App\Models\PrescriptionResults;
use App\Models\User;
use Faker\Provider\Uuid;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Str;

class PrescriptionResultApi extends Controller
{
    public function listPrescription(Request $request)
    {
        $prescriptions = PrescriptionResults::where('status', PrescriptionResultStatus::ACTIVE)
            ->orderByDesc('id')
            ->get();
        return response()->json($prescriptions);
    }

    public function listPrescriptionByUser(Request $request)
    {
        $user_id = $request->input('user_id');

        $prescriptions = DB::table('prescription_results')
            ->where('user_id', $user_id)
            ->where('status', PrescriptionResultStatus::ACTIVE)
            ->orderByDesc('id')
            ->cursor()
            ->map(function ($item) {
                $created = User::find($item->created_by);
                $prescription = (array)$item;
                $prescription['created'] = $created->toArray();
                return $prescription;
            });
        return response()->json($prescriptions);
    }

    public function listPrescriptionByDoctor(Request $request)
    {
        $doctor_id = $request->input('doctor_id');
        $prescriptions = DB::table('prescription_results')
            ->where('created_by', $doctor_id)
            ->where('status', PrescriptionResultStatus::ACTIVE)
            ->orderByDesc('id')
            ->cursor()
            ->map(function ($item) {
                $user = User::find($item->user_id);
                $prescription = (array)$item;
                $prescription['user'] = $user->toArray();
                return $prescription;
            });
        return response()->json($prescriptions);
    }

    public function createPrescription(Request $request)
    {
        try {
            $chatUserId = $request->input('chatUserId');

            $email = '';
            $full_name = '';
            if ($chatUserId) {
                $user = User::where('id', $chatUserId)
                    ->where('status', '!=', UserStatus::DELETED)->first();
                if ($user) {
                    $email = $user->email;
                    $full_name = $user->name ?? 'No name';
                }else{
                    $full_name = $request->input('full_name');
                    $email = $request->input('email');
                }
            } else {
                $full_name = $request->input('full_name');
                $email = $request->input('email');
            }

            $user = User::where('email', $email)
                ->where('status', '!=', UserStatus::DELETED)
                ->first();

            if (!$user) {
                return response((new MainApi())->returnMessage('User not found!'), 400);
            }

            $user_id = $user->id;

            $created_by = $request->input('created_by');

            $prescriptions = $request->input('prescriptions');

            $notes = $request->input('notes');
            $notes_en = $request->input('notes_en') ?? $notes;
            $notes_laos = $request->input('notes_laos') ?? $notes;

            $status = $request->input('status') ?? PrescriptionResultStatus::ACTIVE;

            $prescription_result = new PrescriptionResults();

            $prescription_result->full_name = $user->username;
            $prescription_result->email = $email;
            $prescription_result->user_id = $user_id;

            $prescription_result->created_by = $created_by;

            $prescription_result->prescriptions = $prescriptions;

            $prescription_result->notes = $notes;
            $prescription_result->notes_en = $notes_en;
            $prescription_result->notes_laos = $notes_laos;

            $prescription_result->status = $status;
            $success = $prescription_result->save();

            //Add to cart as prescription
            $cartApi = new CartApi();
            $cartRequest = new Request();

            $cartRequest->merge([
                'user_id' => $user_id,
                'products' => json_decode($request->input('products') ?? [], true),
                'doctor_id' => $created_by,
            ]);
            $response = $cartApi->addToCartV2($cartRequest);
            $prescription_id = null;
            if ($response) {
                $prescription_id = json_decode($response->getContent())->data[0]->prescription_id;
            }

            $this->noti_after_create_don_thuoc($email, $prescription_id ?? $prescription_result->id);


            if ($success) {
                return response()->json($prescription_id ?? $prescription_result);
            }
            return response((new MainApi())->returnMessage('Error, Create error!'), 400);
        } catch (\Exception $exception) {
            return response((new MainApi())->returnMessage($exception->getMessage()), 400);
        }
    }

    private function noti_after_create_don_thuoc($email, $prescription_id)
    {
        $user = User::where('email', $email)->first();

        if (!$user) {
            return;
        }

        $type = 'DonThuocMoi';

        $message = Message::create([
            'from' => Auth::id(),
            'to' => $user->id,
            'text' => 'Bạn có đơn thuốc',
            'uuid_session' => $prescription_id,
            'type' => $type,
        ]);

        Chat::create([
            'from_user_id' => Auth::id(),
            'to_user_id' => $user->id,
            'chat_message' => 'Bạn có đơn thuốc',
            'message_status' => MessageStatus::UNSEEN,
            'uuid_session' => $prescription_id,
            'type' => $type,
        ]);

        $cartApi = new CartApi();
        $cartRequest = new Request();

        $cartRequest->merge([
            'prescription_id' => $prescription_id,
        ]);
        $response = $cartApi->searchCart($cartRequest);
        $cartData = $response->getData()->data;
        $carts = [];

        foreach ($cartData as $data) {
            $cart = [
                'product_name' => $data->product_medicine->name ?? '',
                'product_thumbnail' => $data->product_medicine->thumbnail ?? '',
                'quantity' => $data->quantity ?? 0,
                'treatment_days' => $data->treatment_days ?? 0,
                'note' => $data->note ?? '',
            ];
            $carts[] = $cart;
        }
        $message['carts'] = $carts;
        $message['prescription_id'] = $prescription_id;

        broadcast(new NewMessage($message));
    }

    public function exportAndDownload(Request $request)
    {
        try {
            $prescription_id = $request->input('prescription_id');
            $prescription = PrescriptionResults::find($prescription_id);
            if (!$prescription || $prescription->status == PrescriptionResultStatus::DELETED) {
                return response((new MainApi())->returnMessage('Not found!'), 400);
            }

            $medicines = '[' . $prescription->prescriptions . ']';
            $medicines = json_decode($medicines, true);
            if (is_array($medicines)) {
                return Excel::download(new MedicineExport($medicines), 'prescription.xlsx');
            }
            return response((new MainApi())->returnMessage('No prescription!'), 400);
        } catch (\Exception $exception) {
            return response((new MainApi())->returnMessage('Error, Please try again!'), 400);
        }
    }

    public function uploadExcelFile(Request $request)
    {
        try {
            $prescription_id = $request->input('prescription_id');
            $prescription = PrescriptionResults::find($prescription_id);
            if (!$prescription || $prescription->status == PrescriptionResultStatus::DELETED) {
                return response((new MainApi())->returnMessage('Not found!'), 400);
            }

            $medicines = '[' . $prescription->prescriptions . ']';
            $medicines = json_decode($medicines, true);
            if (is_array($medicines)) {
                $fileName = 'prescription_' . time() . '.xlsx';
                $folderPath = 'exports';
                Excel::store(new MedicineExport($medicines), $folderPath . '/' . $fileName, 'public');
                $new_file = 'storage/' . $folderPath . '/' . $fileName;
                return response(['uri' => $new_file]);
            }
            return response((new MainApi())->returnMessage('No prescription!'), 400);
        } catch (\Exception $exception) {
            return response((new MainApi())->returnMessage('Error, Please try again!'), 400);
        }
    }

    public function addProductToCart(Request $request)
    {
        try {
            $userID = $request->input('user_id');

            $user = User::find($userID);
            if (!$user) {
                return response((new MainApi())->returnMessage('User not found!'), 404);
            }

            $prescription_id = $request->input('prescription_id');
            $prescription = PrescriptionResults::find($prescription_id);
            if (!$prescription || $prescription->status == PrescriptionResultStatus::DELETED) {
                return response((new MainApi())->returnMessage('Not found!'), 400);
            }

            $medicines = '[' . $prescription->prescriptions . ']';
            $medicines = json_decode($medicines, true);

            $fileName = 'prescription_' . time() . '.xlsx';
            $folderPath = 'exports';

            if (is_array($medicines)) {
                Excel::store(new MedicineExport($medicines), $folderPath . '/' . $fileName, 'public');


                $new_file = 'storage/' . $folderPath . '/' . $fileName;
                $file_excel = public_path($new_file);

                if ($file_excel) {
                    $reader = Excel::toCollection(new ExcelImportClass, $file_excel)->first();

                    $count = 0;
                    foreach ($reader->skip(1) as $row) {
                        $nameMedicine = $row[0];

                        $ingredientMedicine = explode(',', $row[1]);

                        $quantity = $row[2];

                        $product = ProductMedicine::where(function ($query) use ($nameMedicine) {
                            $query->orWhere('name', 'LIKE', '%' . $this->normalizeString($nameMedicine) . '%');
                        })
                            ->where(function ($query) use ($ingredientMedicine) {
                                $query->orWhere(function ($subQuery) use ($ingredientMedicine) {
                                    foreach ($ingredientMedicine as $item) {
                                        $subQuery->whereHas('DrugIngredient', function ($q) use ($item) {
                                            $q->where('component_name', 'LIKE', '%' . $this->normalizeString($item) . '%');
                                        });
                                    }
                                });
                            })
                            ->where('status', OnlineMedicineStatus::APPROVED)
                            ->first();

                        $typeProduct = TypeProductCart::MEDICINE;
                        if ($product) {
                            $cart = Cart::where('user_id', $userID)
                                ->whereNull('prescription_id')
                                ->where('product_id', $product->id)
                                ->where('type_product', $typeProduct)
                                ->first();
                            if ($cart) {
                                $cart->quantity = $cart->quantity + (int)$quantity;
                            } else {
                                $cart = new Cart();
                                $cart->product_id = $product->id;
                                $cart->quantity = (int)$quantity;
                                $cart->user_id = $userID;
                                $cart->type_product = $typeProduct;
                            }
                            $cart->save();
                            $count = $count + 1;
                        }
                    }
                    if ($count > 0) {
                        return response((new MainApi())->returnMessage('Add to cart success!'), 200);
                    }
                    return response((new MainApi())->returnMessage('No product!'), 201);
                }
            }
            return response((new MainApi())->returnMessage('Excel file not found!'), 400);
        } catch (\Exception $exception) {
            return response((new MainApi())->returnMessage('Error, Please try again!'), 400);
        }
    }

    private function normalizeString($str)
    {
        return strtolower(trim($str));
    }

    public function addProductToCartV2(Request $request)
    {
        try {
            $userID = $request->input('user_id');

            $user = User::find($userID);
            if (!$user) {
                return response((new MainApi())->returnMessage('User not found!'), 404);
            }

            $prescription_id = $request->input('prescription_id');
            $prescription = PrescriptionResults::find($prescription_id);
            if (!$prescription || $prescription->status == PrescriptionResultStatus::DELETED) {
                return response((new MainApi())->returnMessage('Not found!'), 400);
            }

            $count = 0;

            $medicines = '[' . $prescription->prescriptions . ']';
            $medicines = json_decode($medicines, true);
            foreach ($medicines as $row) {

                $product = ProductMedicine::where('id', $row['medicine_id'])
                    ->where('status', OnlineMedicineStatus::APPROVED)
                    ->first();

                $typeProduct = TypeProductCart::MEDICINE;
                if ($product) {
                    $cart = Cart::where('user_id', $userID)
                        ->whereNull('prescription_id')
                        ->where('product_id', $product->id)
                        ->where('type_product', $typeProduct)
                        ->first();

                    $quantityProduct = $product->quantity;

                    if ($cart) {
                        if ($cart->quantity + (int)$row['quantity'] > $quantityProduct) {
                            return response((new MainApi())->returnMessage('Số lượng sản phẩm ' . $product->name . ' không đủ!'), 400);
                        }
                        $cart->quantity = $cart->quantity + (int)$row['quantity'];
                    } else {
                        if ((int)$row['quantity'] > $quantityProduct) {
                            return response((new MainApi())->returnMessage('Số lượng sản phẩm ' . $product->name . ' không đủ!'), 400);
                        }

                        $cart = new Cart();
                        $cart->product_id = $product->id;
                        $cart->quantity = (int)$row['quantity'];
                        $cart->user_id = $userID;
                        $cart->type_product = $typeProduct;
                    }
                    $cart->save();
                    $count = $count + 1;
                }
            }
            if ($count > 0) {
                $prescription->isFirstBuy = true;
                $prescription->save();
                return response((new MainApi())->returnMessage(
                    'Thêm sản phẩm vào giỏ hàng thành công!'
                ), 200);
            }
            return response((new MainApi())->returnMessage(
                'Không có sản phẩm nào được thêm vào giỏ hàng!'
            ), 201);
        } catch (\Exception $exception) {

            return response((new MainApi())->returnMessage($exception->getMessage()), 400);
        }
    }
    public function handleCallHistory(Request $request)
    {
        $id = $request->id;
        $counter = $request->counter;
        $user = User::find($id);

        if (!$user) {
            return;
        }

        $type = 'EndCall-'. $counter;

        $uuid = Str::uuid()->toString();

        $message = Message::create([
            'from' => $user->id,
            'to' => Auth::id(),
            'text' => 'Bạn đã kết thúc cuộc gọi',
            'uuid_session' => $uuid,
            'type' => $type,
        ]);

        Chat::create([
            'from_user_id' => $user->id,
            'to_user_id' => Auth::id(),
            'chat_message' => 'Bạn đã kết thúc cuộc gọi',
            'message_status' => MessageStatus::UNSEEN,
            'uuid_session' => $uuid,
            'type' => $type,
        ]);

        broadcast(new NewMessage($message));
    }    

    public function getListMedicine(Request $request)
    {
        $name_search = $request->input('name_search');
        $drug_ingredient_search = $request->input('drug_ingredient_search');
        $object_search = $request->input('object_search');

        $listMedicine = ProductMedicine::where('quantity', '>', 0);

        if ($drug_ingredient_search) {
            $listMedicineId = DrugIngredients::where('component_name', 'like', '%' . $drug_ingredient_search . '%')->pluck('product_id');
            $listMedicine = $listMedicine->whereIn('id', $listMedicineId);
        }

        if ($name_search) {
            $listMedicine = $listMedicine->where('name', 'like', '%' . $name_search . '%');
        }

        if ($object_search) {
            $listMedicine = $listMedicine->where('object_', $object_search);
        }

        $listMedicine = $listMedicine->get();
        return response()->json($listMedicine);
    }
}
