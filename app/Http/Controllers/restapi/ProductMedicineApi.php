<?php

namespace App\Http\Controllers\restapi;

use App\Enums\online_medicine\OnlineMedicineStatus;
use App\Enums\TypeProductCart;
use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\MedicalResults;
use App\Models\online_medicine\ProductMedicine;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProductMedicineApi extends Controller
{
    public function getAllProduct(Request $request)
    {
        $keyword = $request->input('keyword');

        $products = DB::table('product_medicines')
            ->where('product_medicines.status', OnlineMedicineStatus::APPROVED)
            ->when($keyword, function ($query) use ($keyword) {
                $query->where(function ($sup_query) use ($keyword) {
                    $sup_query->where('product_medicines.uses', 'like', '%' . $keyword . '%')
                        ->orWhere('product_medicines.specifications', 'like', '%' . $keyword . '%')
                        ->orWhere('product_medicines.name', 'like', '%' . $keyword . '%')
                        ->orWhere('product_medicines.name_en', 'like', '%' . $keyword . '%')
                        ->orWhere('product_medicines.name_laos', 'like', '%' . $keyword . '%');
                });
                $query->join('drug_ingredients', 'drug_ingredients.product_id', '=', 'product_medicines.id')
                    ->orWhere('drug_ingredients.component_name', 'like', '%' . $keyword . '%');
            })
            ->orderByDesc('product_medicines.id')
            ->get();
        return response()->json($products);
    }

    public function findMedicineByCategory($id)
    {
        $productMedicines = DB::table('product_medicines')
            ->join('users', 'users.id', '=', 'product_medicines.user_id')
            ->where('product_medicines.category_id', $id)
            ->where('product_medicines.status', OnlineMedicineStatus::APPROVED)
            ->select('product_medicines.*', 'users.address_code')
            ->get();
        return response()->json($productMedicines);
    }

    public function getAllProductByExcelFile(Request $request)
    {
        try {
            if ($request->hasFile('prescriptions')) {
                $item = $request->file('prescriptions');
                $itemPath = $item->store('file_excel', 'public');
                $file_excel = asset('storage/' . $itemPath);
            } else {
                return response((new MainApi())->returnMessage('File prescriptions not empty!'), 400);
            }
            $products = [];
            if ($file_excel) {
                $products = (new BookingResultApi())->getListProductFromExcel($file_excel);
            }
            return response()->json($products);
        } catch (\Exception $exception) {
            return response((new MainApi())->returnMessage('Error, Please try again!'), 400);
        }
    }

    public function getAllProductByExcelFileBlade(Request $request)
    {
        try {
            if ($request->hasFile('prescriptions')) {
                $item = $request->file('prescriptions');
                $itemPath = $item->store('file_excel', 'public');
                $file_excel = asset('storage/' . $itemPath);
            } else {
                return response((new MainApi())->returnMessage('File prescriptions not empty!'), 400);
            }
            $products = [];
            if ($file_excel) {
                $products = (new BookingResultApi())->getListProductFromExcel($file_excel);
            }
            if (count($products) > 0) {
                $userID = Auth::user()->id;
                $typeProduct = TypeProductCart::MEDICINE;
                $this->addProductCart($products, $userID, $typeProduct);
                return response((new MainApi())->returnMessage('Update success!'), 200);
            }
            return response((new MainApi())->returnMessage('No valid product found!'), 201);
        } catch (\Exception $exception) {
            return response((new MainApi())->returnMessage('Error, Please try again!'), 400);
        }
    }

    public function addProductCart($products, $userID, $typeProduct)
    {
        foreach ($products as $product) {
            $cart = Cart::where('user_id', $userID)
                ->where('product_id', $product->id)
                ->where('type_product', $typeProduct)
                ->first();
            if ($cart) {
                $cart->quantity = $cart->quantity + 1;
            } else {
                $cart = new Cart();
                $cart->product_id = $product->id;
                $cart->quantity = 1;
                $cart->user_id = $userID;
                $cart->type_product = $typeProduct;
            }
            $cart->save();
        }
    }

    public function detail($id)
    {
        $product = ProductMedicine::find($id);
        if (!$product || $product->status != OnlineMedicineStatus::APPROVED) {
            return response((new MainApi())->returnMessage('Not found'), 404);
        }
        return response()->json($product);
    }

    function addProductFromExcelFile($id)
    {
        $result = MedicalResults::find($id);
        $file_excel = $result->prescriptions;
        $products = [];
        if ($file_excel) {
            $products = (new BookingResultApi())->getListProductFromExcel($file_excel);
        }
        if (count($products) > 0) {
            $userID = Auth::user()->id;
            $typeProduct = TypeProductCart::MEDICINE;
            $this->addProductCart($products, $userID, $typeProduct);
            return response((new MainApi())->returnMessage('Success!'), 200);
        }
        return response((new MainApi())->returnMessage('No valid product found!'), 201);
    }
}
