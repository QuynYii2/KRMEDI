<?php

namespace App\ExportExcel;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class MedicineExport implements FromCollection, WithHeadings
{
    protected $medicines;

    public function __construct(array $medicines)
    {
        $this->medicines = $medicines;
    }

    public function collection()
    {
        return collect($this->medicines);
    }

    public function headings(): array
    {
        return [
            'name_medicine',
            'thanh_phan_thuoc',
            'so_luong',
        ];
    }
}
