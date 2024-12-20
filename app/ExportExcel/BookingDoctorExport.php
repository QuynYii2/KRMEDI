<?php

namespace App\ExportExcel;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class BookingDoctorExport implements FromCollection, WithHeadings
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
                $item->user_name??'',
                $item->phone,
                $item->address,
                $item->name_clinic,
                $item->check_in,
                $item->department??'',
                $item->doctor_name,
                $item->booking_for,
                $item->insurance,
                $item->insurance_date,
                $item->status,
            ];
            array_push($arr, $myArr);
        }
        return collect($arr);
    }

    public function headings(): array
    {
        return ["STT","Người đăng ký","SĐT người đăng ký","Địa chỉ người đăng ký", "Phòng khám", "Giờ vào khám", "Phòng","Tên bác sĩ", "Đặt khám cho", "Bảo hiểm","Hạn bảo hiểm", "Trạng thái"];
    }
}
