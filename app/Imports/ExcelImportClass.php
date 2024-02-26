<?php

namespace App\Imports;

use App\Models\online_medicine\ProductMedicine;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class ExcelImportClass implements ToModel, WithChunkReading
{
    public function model(array $row)
    {
        return new ProductMedicine([
            'name' => $row[0],
        ]);
    }

    public function chunkSize(): int
    {
        return 1000;
    }
}
