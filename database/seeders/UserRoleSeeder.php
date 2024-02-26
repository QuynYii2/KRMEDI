<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminRole = Role::where('name', \App\Enums\Role::ADMIN)->first();
        $normalRole = Role::where('name', \App\Enums\Role::PAITENTS)->first();
        $medicalRole = Role::where('name', \App\Enums\Role::DOCTORS)->first();
        $businessRole = Role::where('name', \App\Enums\Role::HOSPITALS)->first();

        $admin = User::where('email', 'admin@gmail.com')->first();
        $normal = User::where('email', 'normal@gmail.com')->first();
        $medical = User::where('email', 'medical@gmail.com')->first();
        $business = User::where('email', 'business@gmail.com')->first();

        $user_roles = [
            [
                'user_id' => $admin->id,
                'role_id' => $adminRole->id
            ],
            [
                'user_id' => $normal->id,
                'role_id' => $normalRole->id
            ],
            [
                'user_id' => $medical->id,
                'role_id' => $medicalRole->id
            ],
            [
                'user_id' => $business->id,
                'role_id' => $businessRole->id
            ],
        ];

        DB::table('role_users')->insert($user_roles);
    }
}
