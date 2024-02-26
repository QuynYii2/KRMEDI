<?php

namespace App\Http\Controllers;

use App\Imports\ExcelImportClass;
use App\Models\online_medicine\ProductMedicine;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;

class ImportController extends Controller
{
    public function showForm()
    {
        return view('upload-form');
    }

    public function importExcel(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls',
        ]);

        $reader = Excel::toCollection(new ExcelImportClass, $request->file('file')->store('temp'))->first();

        $nameMedicineArray = [];
        $thanhPhanThuocArray = [];

        foreach ($reader->skip(1) as $row) {
            $nameMedicineArray[] = $row[0];

            $thanhPhanThuocArray[] = explode(',', $row[1]);
        }

        $products = ProductMedicine::where(function ($query) use ($nameMedicineArray) {
            foreach ($nameMedicineArray as $nameMedicine) {
                $query->orWhere('name', 'LIKE', '%' . $this->normalizeString($nameMedicine) . '%');
            }
        })
            ->where(function ($query) use ($thanhPhanThuocArray) {
                foreach ($thanhPhanThuocArray as $thanhPhanArray) {
                    $query->orWhere(function ($subQuery) use ($thanhPhanArray) {
                        foreach ($thanhPhanArray as $thanhPhan) {
                            $subQuery->whereHas('DrugIngredient', function ($q) use ($thanhPhan) {
                                $q->where('component_name', 'LIKE', '%' . $this->normalizeString($thanhPhan) . '%');
                            });
                        }
                    });
                }
            })
            ->get();

        return $products;
    }

    /**
     * Hàm chuẩn hóa chuỗi
     *
     * @param string $str
     * @return string
     */
    private function normalizeString($str)
    {
        return strtolower(trim($str));
    }
}
