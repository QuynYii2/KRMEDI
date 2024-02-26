<?php

namespace App\Http\Controllers;

use App\Enums\CategoryProductStatus;
use App\Enums\CategoryStatus;
use App\Enums\ProductStatus;
use App\Models\Category;
use App\Models\online_medicine\CategoryProduct;
use App\Models\ProductInfo;

class ProductInfoController extends Controller
{
    public function index()
    {
        $products = ProductInfo::where('status', ProductStatus::ACTIVE)->get();
        return response()->json($products);
    }

    public function show($id)
    {
        $product = ProductInfo::find($id);
        if (!$product || $product->status != ProductStatus::ACTIVE) {
            return response("Product not found", 404);
        }
        return response()->json($product);
    }

    public function createProduct()
    {
        $categories = Category::where('status', CategoryStatus::ACTIVE)->get();
        return view('admin.product.tab-create-products', compact('categories'));
    }

    public function edit($id)
    {
        $product = ProductInfo::find($id);
        $isAdmin = (new MainController())->checkAdmin();
        $provinces = \App\Models\Province::find($product->province_id)->get();
        if (!$product || $product->status == ProductStatus::DELETED) {
            return redirect(route('homeAdmin.list.product'));
        }
        $categories = Category::where('status', CategoryStatus::ACTIVE)->get();
        return view('admin.product.tab-edit-product', compact('product', 'provinces', 'isAdmin', 'categories'));
    }
}
