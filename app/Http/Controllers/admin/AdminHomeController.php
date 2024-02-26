<?php

namespace App\Http\Controllers\admin;

use App\Enums\CategoryProductStatus;
use App\Enums\online_medicine\OnlineMedicineStatus;
use App\Http\Controllers\Controller;
use App\Models\online_medicine\CategoryProduct;
use App\Models\online_medicine\ProductMedicine;
use Illuminate\Http\Request;

class AdminHomeController extends Controller
{
    public function showAllProductMedicine()
    {
        $products = ProductMedicine::where('status', '!=', OnlineMedicineStatus::DELETED)
            ->orderByDesc('id')
            ->get();
        $categories = CategoryProduct::where('status', CategoryProductStatus::ACTIVE)
            ->orderByDesc('id')
            ->get();
        $array_company = null;
        $array_country = null;
        foreach ($products as $product) {
            if ($product->manufacturing_company){
                $array_company[] = $product->manufacturing_company;
                $array_company = array_unique($array_company);
            }

            if ($product->manufacturing_country){
                $array_country[] = $product->manufacturing_country;
                $array_country = array_unique($array_country);
            }
        }
        return view('admin.admin.product-medicine.list-products', compact('products', 'categories',
           'array_company', 'array_country'));
    }

    public function detailProductMedicine($id)
    {
        $product = ProductMedicine::find($id);
        return view('admin.admin.product-medicine.detail-product', compact('product'));
    }
}
