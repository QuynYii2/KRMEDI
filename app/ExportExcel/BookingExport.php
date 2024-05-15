<?php

namespace App\ExportExcel;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class BookingExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public $bookings;

    function __construct($bookings)
    {
        $this->bookings = $bookings;
    }

    public function collection()
    {
        $arr = [];
        $listData = $this->bookings;

        foreach ($listData as $key => $item) {
            $myArr = [
                $key + 1,
                $item->name_clinic,
                $item->check_in,
                $item->service_names,
                $item->status,
            ];
            array_push($arr, $myArr);
        }
        return collect($arr);
    }

    public function headings(): array
    {
        return ["STT", "Phòng khám", "Giờ vào khám", "Dịch vụ", "Trạng thái"];
    }
}
