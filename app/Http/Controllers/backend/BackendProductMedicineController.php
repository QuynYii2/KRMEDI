<?php

namespace App\Http\Controllers\backend;

use App\Enums\online_medicine\OnlineMedicineStatus;
use App\Http\Controllers\Controller;
use App\Http\Controllers\restapi\MainApi;
use App\Http\Controllers\TranslateController;
use App\Models\DrugIngredients;
use App\Models\online_medicine\CategoryProduct;
use App\Models\online_medicine\ProductMedicine;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BackendProductMedicineController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user_id = Auth::check() ? Auth::user()->id : '';
        $isAdmin = (new MainApi())->isAdmin($user_id);
        if ($isAdmin) {
            $productMedicines = ProductMedicine::where('status', '!=', OnlineMedicineStatus::DELETED)
                ->orderBy('created_at', 'DESC')
                ->paginate(20);
        } else {
            $productMedicines = ProductMedicine::where('status', '!=', OnlineMedicineStatus::DELETED)
                ->where('user_id', $user_id)
                ->orderBy('created_at', 'DESC')
                ->paginate(20);
        }
        return view('admin.product_medicine.index', compact('productMedicines'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categoryProductMedicine = CategoryProduct::where('status', 1)->get();
        $reflector = new \ReflectionClass('App\Enums\online_medicine\ShapeProduct');
        $shapes = $reflector->getConstants();
        $reflector = new \ReflectionClass('App\Enums\online_medicine\UnitQuantityProduct');
        $unit_quantity = $reflector->getConstants();
        return view('admin.product_medicine.create', compact('categoryProductMedicine', 'shapes', 'unit_quantity'));
    }

    /**
     * Display the specified resource.
     */
    public function show(ProductMedicine $productMedicine)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $productMedicine = ProductMedicine::find($id);
        $categoryProductMedicine = CategoryProduct::where('status', 1)->get();
        $drugIngredient = DrugIngredients::where('product_id', $id)->first();

        $drugIngredients = $drugIngredient->component_name;
        $list_drugIngredients = explode(',', $drugIngredients);

        $reflector = new \ReflectionClass('App\Enums\online_medicine\ShapeProduct');
        $shapes = $reflector->getConstants();
        $reflector = new \ReflectionClass('App\Enums\online_medicine\UnitQuantityProduct');
        $unit_quantity = $reflector->getConstants();
        return view('admin.product_medicine.edit',
            compact('productMedicine', 'categoryProductMedicine',
                'drugIngredient', 'shapes', 'unit_quantity', 'list_drugIngredients'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $productMedicine = ProductMedicine::find($id);
        // nếu tìm thấy, thì sửa status = Inactive và thông báo
        if ($productMedicine) {
            $productMedicine->status = OnlineMedicineStatus::DELETED;
            $success = $productMedicine->update();
            if ($success) {
                return response('Xóa sản phẩm thành công !!!', 200);
            } else {
                return response('Xóa sản phẩm thất bại !!!', 400);
            }
        } else {
            return response('Không tìm thấy sản phẩm !!!', 400);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        try {
            $params = $request->only('name', 'brand_name', 'category_id', 'object_', 'filter_',
                'price', 'status', 'description', 'unit_price', 'quantity',
                'manufacturing_country', 'manufacturing_company', 'unit_quantity',

                'short_description', 'short_description',
                'uses', 'user_manual',
                'notes', 'preserve', 'side_effects',

                'shape', 'specifications', 'number_register', 'proved_by');

            $translate = new TranslateController();

            //check name
            if (empty($params['name'])) {
                return response('Tên sản phẩm không được để trống', 400);
            }
            $params['name'] = $translate->translateText($params['name'], 'vi');
            $params['name_en'] = $translate->translateText($params['name'], 'en');
            $params['name_laos'] = $translate->translateText($params['name'], 'lo');
            //check short_description
//            if (empty($params['short_description'])) {
//                return response('Mô tả sản phẩm không được để trống', 400);
//            }
//            $params['short_description'] = $translate->translateText($params['short_description'], 'vi');
//            $params['short_description_en'] = $translate->translateText($params['short_description'], 'en');
//            $params['short_description_laos'] = $translate->translateText($params['short_description'], 'lo');
            //check description
            if (empty($params['description'])) {
                return response('Mô tả sản phẩm không được để trống', 400);
            }
//            $params['description'] = $translate->translateText($params['description'], 'vi');
//            $params['description_en'] = $translate->translateText($params['description'], 'en');
//            $params['description_laos'] = $translate->translateText($params['description'], 'lo');
            //check brand_name
            if (empty($params['brand_name'])) {
                return response('Tên thương hiệu không được để trống', 400);
            }
            $params['brand_name'] = $translate->translateText($params['brand_name'], 'vi');
            $params['brand_name_en'] = $translate->translateText($params['brand_name'], 'en');
            $params['brand_name_laos'] = $translate->translateText($params['brand_name'], 'lo');

            //check thumbnail, nếu rỗng thì không thêm vào
            if ($request->hasFile('thumbnail')) {
                $item = $request->file('thumbnail');
                $itemPath = $item->store('product_medicine', 'public');
                $thumbnail = asset('storage/' . $itemPath);
                $params['thumbnail'] = $thumbnail;
            }
            $productMedicine = ProductMedicine::find($request->input('id'));
            $gallery = $productMedicine->gallery;
            if ($request->hasFile('gallery')) {
                $galleryPaths = array_map(function ($image) {
                    $itemPath = $image->store('gallery', 'public');
                    return asset('storage/' . $itemPath);
                }, $request->file('gallery'));
                $gallery = implode(',', $galleryPaths);
            }

            $productMedicine->gallery = $gallery;
            $productMedicine->type_product = $request->type_product;
            $productMedicine->user_manual = $request->user_manual;
            $productMedicine->uses = $request->uses;
            $productMedicine->side_effects = $request->side_effects;

            $is_prescription = (bool)$request->input('is_prescription');
            $params['is_prescription'] = $is_prescription;

            $productMedicine->fill($params);

            $success = $productMedicine->save();

            if ($success) {
                $drugIngredient = DrugIngredients::where('product_id', $request->input('id'))->first();

                if (!$drugIngredient) {
                    $drugIngredient = new DrugIngredients();
                    $drugIngredient->product_id = $productMedicine->id;
                }

                $drugIngredient->component_name = ($request->input('ingredient') ?? '');
                $success = $drugIngredient->save();
            }

            if ($success) {
                return response((new MainApi())->returnMessage('Cập nhật sản phẩm thành công'), 200);
            } else {
                return response((new MainApi())->returnMessage('Cập nhật sản phẩm thất bại'), 400);
            }
        } catch (\Exception $exception) {
            return response((new MainApi())->returnMessage($exception->getMessage()), 400);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $params = $request->only('name', 'brand_name', 'category_id', 'object_', 'filter_',
                'price', 'status', 'description', 'unit_price', 'quantity',
                'manufacturing_country', 'manufacturing_company', 'unit_quantity',

                'short_description', 'short_description',
                'uses', 'user_manual',
                'notes', 'preserve', 'side_effects',

                'shape', 'specifications', 'number_register', 'proved_by');

            $translate = new TranslateController();

            //check name
            if (empty($params['name'])) {
                return response('Tên sản phẩm không được để trống', 400);
            }
            $params['name'] = $translate->translateText($params['name'], 'vi');
            $params['name_en'] = $translate->translateText($params['name'], 'en');
            $params['name_laos'] = $translate->translateText($params['name'], 'lo');
            //check short_description
//            if (empty($params['short_description'])) {
//                return response('Mô tả sản phẩm không được để trống', 400);
//            }
//            $params['short_description'] =
//            $params['short_description'] = $translate->translateText($params['short_description'], 'vi');
//            $params['short_description_en'] = $translate->translateText($params['short_description'], 'en');
//            $params['short_description_laos'] = $translate->translateText($params['short_description'], 'lo');
            //check description
            if (empty($params['description'])) {
                return response('Mô tả sản phẩm không được để trống', 400);
            }
//            $params['description'] = $translate->translateText($params['description'], 'vi');
//            $params['description_en'] = $translate->translateText($params['description'], 'en');
//            $params['description_laos'] = $translate->translateText($params['description'], 'lo');
            //check brand_name
            if (empty($params['brand_name'])) {
                return response('Tên thương hiệu không được để trống', 400);
            }
            $params['brand_name'] = $translate->translateText($params['brand_name'], 'vi');
            $params['brand_name_en'] = $translate->translateText($params['brand_name'], 'en');
            $params['brand_name_laos'] = $translate->translateText($params['brand_name'], 'lo');

            if ($request->hasFile('thumbnail')) {
                $item = $request->file('thumbnail');
                $itemPath = $item->store('product_medicine', 'public');
                $thumbnail = asset('storage/' . $itemPath);
                $params['thumbnail'] = $thumbnail;
            }elseif ($request->input('thumbnail')) {
                $thumbnailUrl = $request->input('thumbnail');
                $thumbnailContents = file_get_contents($thumbnailUrl);
                $thumbnailName = 'product_medicine/' . Str::random(40) . '.jpg';
                Storage::disk('public')->put($thumbnailName, $thumbnailContents);
                $thumbnail = asset('storage/' . $thumbnailName);
                $params['thumbnail'] = $thumbnail;
            } else {
                return response('Ảnh đại diện không được để trống', 400);
            }

            $galleryPaths = [];

            if ($request->hasFile('gallery')) {
                foreach ($request->file('gallery') as $image) {
                    $itemPath = $image->store('gallery', 'public');
                    $galleryPaths[] = asset('storage/' . $itemPath);
                }
            }

            if ($request->input('existing_images')) {
                foreach ($request->input('existing_images') as $existingImageUrl) {
                    $imageContents = file_get_contents($existingImageUrl);
                    if ($imageContents !== false) {
                        $imageName = 'gallery/' . Str::random(40) . '.jpg';
                        Storage::disk('public')->put($imageName, $imageContents);
                        $galleryPaths[] = asset('storage/' . $imageName);
                    }
                }
            }

            //check gallery not null
            if (count($galleryPaths)<=0) {
                return response('Ảnh chi tiết không được để trống', 400);
            }

            $gallery = implode(',', $galleryPaths);

            $id_kiotviet = null;
            if ($request->get('id_kiotviet')) {
                $id_kiotviet = $request->get('id_kiotviet');
            }
            $dataProduct = ProductMedicine::where('user_id',$request->input('user_id'))->where('id_kiotviet',$id_kiotviet)->whereNotNull('id_kiotviet')->first();
            if (isset($dataProduct)){
                $dataProduct->quantity = $request->get('quantity');
                $dataProduct->save();
                $success = true;
            }else{
                $productMedicine = new ProductMedicine();

                $productMedicine->gallery = $gallery;
                $productMedicine->user_id = $request->input('user_id');
                $productMedicine->type_product = $request->type_product;
                $productMedicine->id_kiotviet = $id_kiotviet;

                $is_prescription = (bool)$request->input('is_prescription');

                $params['status'] = OnlineMedicineStatus::PENDING;
                $params['is_prescription'] = $is_prescription;

                $productMedicine->fill($params);

                $success = $productMedicine->save();

                if ($success) {
                    $drugIngredient = new DrugIngredients();
                    $drugIngredient->product_id = $productMedicine->id;
                    $drugIngredient->component_name = $request->input('ingredient');

                    $success = $drugIngredient->save();
                }
            }

            if ($success) {
                return response((new MainApi())->returnMessage('Thêm sản phẩm thành công'), 200);
            } else {
                return response((new MainApi())->returnMessage('Thêm sản phẩm thất bại'), 400);
            }
        } catch (\Exception $exception) {
            return response((new MainApi())->returnMessage($exception->getMessage()), 400);
        }
    }

    public function listProductKiotviet(Request $request)
    {
        $token = $this->getAccessToken();
        $category = $this->getGoodsKiotViet($token);
        $categories = $category['data'];
        $endpoint = 'https://public.kiotapi.com/products';
        $pageSize = 20;
        $currentPage  = $request->page??1;
        $currentItem = ($currentPage - 1) * $pageSize;
        $Category_id = $request->id_category??'';
        $user = Auth::user();
        $response = Http::withHeaders([
            'Retailer' => $user->retailer_kiot_viet??'krmedi',
            'Authorization' => 'Bearer ' . $token,
        ])->get($endpoint,[
            'pageSize' => $pageSize,
            'currentItem' => $currentItem,
            'categoryId' => $Category_id,
        ]);

        $products  = $response->json();
        $totalItems = $products['total'];
        $paginator = collect($products['data']);
        $paginator = new LengthAwarePaginator(
            $paginator,
            $totalItems,
            $pageSize,
            $currentPage,
            ['path' => url()->current(), 'query' => $request->except('page')]
        );

        return view('admin.product_medicine.index-kiotviet', compact( 'paginator','categories','Category_id'));
    }

    public function createProductKiotViet($id)
    {
        $token = $this->getAccessToken();
        $data = $this->getProductsKiotViet($token,$id);
        $categoryProductMedicine = CategoryProduct::where('status', 1)->get();
        $reflector = new \ReflectionClass('App\Enums\online_medicine\ShapeProduct');
        $shapes = $reflector->getConstants();
        $reflector = new \ReflectionClass('App\Enums\online_medicine\UnitQuantityProduct');
        $unit_quantity = $reflector->getConstants();

        return view('admin.product_medicine.create-kiotviet', compact('categoryProductMedicine','data','unit_quantity','shapes'));
    }
}
