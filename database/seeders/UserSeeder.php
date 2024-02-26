<?php

namespace Database\Seeders;

use App\Enums\TypeUser;
use App\Enums\UserStatus;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'demo',
                'last_name' => 'demo',
                'email' => 'normal@gmail.com',
                'password' => Hash::make('123456'),
                'username' => 'normal',
                'phone' => '0989889889',
                'address_code' => 'code',
                'type' => TypeUser::PAITENTS,
                'status' => UserStatus::ACTIVE,
            ],
            [
                'name' => 'demo',
                'last_name' => 'demo',
                'email' => 'medical@gmail.com',
                'password' => Hash::make('123456'),
                'username' => 'medical',
                'phone' => '0989889889',
                'address_code' => 'code',
                'type' => TypeUser::DOCTORS,
                'status' => UserStatus::ACTIVE,
            ],
            [
                'name' => 'demo',
                'last_name' => 'demo',
                'email' => 'business@gmail.com',
                'password' => Hash::make('123456'),
                'username' => 'business',
                'phone' => '0989889889',
                'address_code' => 'code',
                'type' => TypeUser::HOSPITALS,
                'status' => UserStatus::ACTIVE,
            ],
            [
                'name' => 'demo',
                'last_name' => 'demo',
                'email' => 'admin@gmail.com',
                'password' => Hash::make('123456'),
                'username' => 'admin',
                'phone' => '0989889889',
                'address_code' => 'code',
                'type' => TypeUser::OTHERS,
                'status' => UserStatus::ACTIVE,
            ],
        ];

        DB::table('users')->insert($users);
    }
}
