<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Http\Controllers\TranslateController;
use App\Models\online_medicine\CategoryProduct;
use Illuminate\Http\Request;

class BackendCategoryProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categoryProducts = CategoryProduct::paginate(20);
        return view('admin.category_product.index', compact('categoryProducts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.category_product.create');
    }

    /**
     * Display the specified resource.
     */
    public function show(CategoryProduct $categoryProduct)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $categoryProduct = CategoryProduct::find($id);
        return view('admin.category_product.edit', compact('categoryProduct'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // tìm kiếm categoryProduct theo id, và chuyển status = 0
        $categoryProduct = CategoryProduct::find($id);
        // nếu tìm thấy, thì sửa status = Inactive và thông báo
        if ($categoryProduct) {
            $categoryProduct->status = 0;
            $success = $categoryProduct->update();
            if ($success) {
                return response('Xóa danh mục thành công !!!', 200);
            } else {
                return response('Xóa danh mục thất bại !!!', 400);
            }
        } else {
            return response('Không tìm thấy danh mục !!!', 400);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $id = $request->input('id');
        $params = $request->only('name', 'status',);

        // kiểm tra 1 trong những name phải khác null
        if (empty($params['name']) || empty($params['name_en']) || empty($params['name_laos'])) {
            return response('Tên danh mục không được để trống', 400);
        }

        $translate = new TranslateController();
        $params['name_en'] = $translate->translateText($params['name'], 'en');
        $params['name_laos'] = $translate->translateText($params['name'], 'lo');

        $categoryProduct = CategoryProduct::find($id);

        if ($request->hasFile('thumbnail')) {
            $item = $request->file('thumbnail');
            $itemPath = $item->store('product', 'public');
            $thumbnail = asset('storage/' . $itemPath);
        } else {
            $thumbnail = $categoryProduct->thumbnail;
        }

        $categoryProduct->fill($params);
        $categoryProduct->thumbnail = $thumbnail;

        $success = $categoryProduct->update();

        if ($success) {
            return response('Cập nhật danh mục thành công', 200);
        } else {
            return response('Cập nhật danh mục thất bại', 400);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $params = $request->only('name', 'status',);

        // kiểm tra 1 trong những name phải khác null
        if (empty($params['name'])) {
            return response('Tên danh mục không được để trống', 400);
        }
        $translate = new TranslateController();
        $params['name_en'] = $translate->translateText($params['name'], 'en');
        $params['name_laos'] = $translate->translateText($params['name'], 'lo');

        if ($request->hasFile('thumbnail')) {
            $item = $request->file('thumbnail');
            $itemPath = $item->store('product', 'public');
            $thumbnail = asset('storage/' . $itemPath);
        } else {
            return response('Thumbnail không được để trống', 400);
        }

        $categoryProduct = new CategoryProduct();

        $categoryProduct->fill($params);
        $categoryProduct->thumbnail = $thumbnail;

        $success = $categoryProduct->save();

        if ($success) {
            return response('Thêm danh mục thành công', 200);
        } else {
            return response('Thêm danh mục thất bại', 400);
        }
    }
}
