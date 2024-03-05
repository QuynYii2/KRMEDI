<?php

namespace App\Http\Controllers\restapi\admin;

use App\Enums\online_medicine\OnlineMedicineStatus;
use App\Http\Controllers\Controller;
use App\Models\online_medicine\ProductMedicine;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminProductMedicineApi extends Controller
{
    function filterProduct(Request $request)
    {
        $stock = $request->input('stock');
        $status = $request->input('status');

        $products = DB::table('product_medicines')
            ->where('status', '!=', OnlineMedicineStatus::DELETED)
            ->when($stock, function ($query) use ($stock) {
                if ($stock == 'out') {
                    $query->where('quantity', 0);
                } elseif ($stock == 'in') {
                    $query->where('quantity', '>', 0);
                }
            })
            ->when($status, function ($query) use ($status) {
                $query->where('status', '=', $status);
            })
            ->orderByDesc('id')
            ->get();
        return response()->json($products);
    }

    function searchProduct(Request $request)
    {
        $stock = $request->input('stock');
        $status = $request->input('status');
        $keyword = $request->input('keyword');
        $company = $request->input('company');
        $country = $request->input('country');
        $object = $request->input('object');
        $filter = $request->input('filter');
        $category = $request->input('category');

        $products = DB::table('product_medicines')
            ->where('product_medicines.status', '!=', OnlineMedicineStatus::DELETED)
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
            ->when($stock, function ($query) use ($stock) {
                if ($stock == 'out') {
                    $query->where('product_medicines.quantity', 0);
                } elseif ($stock == 'in') {
                    $query->where('product_medicines.quantity', '>', 0);
                }
            })
            ->when($company, function ($query) use ($company) {
                $query->where('product_medicines.manufacturing_company', '=', $company);
            })
            ->when($country, function ($query) use ($country) {
                $query->where('product_medicines.manufacturing_country', '=', $country);
            })
            ->when($status, function ($query) use ($status) {
                $query->where('product_medicines.status', '=', $status);
            })
            ->when($category, function ($query) use ($category) {
                $query->where('product_medicines.category_id', '=', $category);
            })
            ->when($object, function ($query) use ($object) {
                $query->where('product_medicines.object_', '=', $object);
            })
            ->when($filter, function ($query) use ($filter) {
                $query->where('product_medicines.filter_', '=', $filter);
            })
            ->orderByDesc('product_medicines.id')
            ->get();
        return response()->json($products);
    }

    public function changeStatus(Request $request)
    {
        try {
            $id = $request->input('product_id');
            $user_id = $request->input('user_id');
            $productMedicine = ProductMedicine::find($id);

            if ($productMedicine->status == OnlineMedicineStatus::PENDING) {
                $productMedicine->status = OnlineMedicineStatus::APPROVED;
            } else {
                $productMedicine->status = OnlineMedicineStatus::PENDING;
            }

            $productMedicine->proved_by = $user_id;
            $productMedicine->save();
            return response()->json($productMedicine);
        } catch (\Exception $exception) {
            return response($exception, 400);
        }
    }
}
