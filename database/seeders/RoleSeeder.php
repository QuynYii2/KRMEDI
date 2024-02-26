<?php

namespace Database\Seeders;

use App\Enums\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
//            ['name' => Role::BUSINESS],
//            ['name' => Role::MEDICAL],
//            ['name' => Role::NORMAL],
            ['name' => Role::PHARMACEUTICAL_COMPANIES],
            ['name' => Role::HOSPITALS],
            ['name' => Role::CLINICS],
            ['name' => Role::PHARMACIES],
            ['name' => Role::SPAS],
            ['name' => Role::OTHERS],
            ['name' => Role::DOCTORS],
            ['name' => Role::PHAMACISTS],
            ['name' => Role::THERAPISTS],
            ['name' => Role::ESTHETICIANS],
            ['name' => Role::NURSES],
            ['name' => Role::PAITENTS],
            ['name' => Role::NORMAL_PEOPLE],
            ['name' => Role::ADMIN],
        ];

        DB::table('roles')->insert($roles);
    }
}
