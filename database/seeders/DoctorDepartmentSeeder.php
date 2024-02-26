<?php

namespace Database\Seeders;

use App\Enums\DoctorDepartmentStatus;
use App\Models\DoctorDepartment;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DoctorDepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $departments = [
            [
                'name' => 'Chấn thương chỉnh hình',
                'name_en' => 'Orthopedic',
                'name_laos' => 'Orthopedic',
                'user_id' => 1,
                'status' => DoctorDepartmentStatus::ACTIVE,
            ],
            [
                'name' => 'Răng-Hàm-Mặt',
                'name_en' => 'Dentomaxillofacial',
                'name_laos' => 'Dentomaxillofacial',
                'user_id' => 2,
                'status' => DoctorDepartmentStatus::ACTIVE,
            ],
            [
                'name' => 'Xương khớp',
                'name_en' => 'Osteoarthritis',
                'name_laos' => 'Osteoarthritis',
                'user_id' => 1,
                'status' => DoctorDepartmentStatus::ACTIVE,
            ],
            [
                'name' => 'Da liễu',
                'name_en' => 'Dermatology',
                'name_laos' => 'Dermatology',
                'user_id' => 1,
                'status' => DoctorDepartmentStatus::ACTIVE,
            ]
        ];

        DoctorDepartment::insert($departments);
    }
}
