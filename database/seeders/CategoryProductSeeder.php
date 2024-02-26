<?php

namespace Database\Seeders;

use App\Models\online_medicine\CategoryProduct;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

class CategoryProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Antibiotics',
                'name_en' => 'Antibiotics',
                'name_laos' => 'Antibiotics',
                'status' => true,
            ],
            [
                'name' => 'Recommended',
                'name_en' => 'Recommended',
                'name_laos' => 'Recommended',
                'status' => true,
            ],
            [
                'name' => 'medicine',
                'name_en' => 'medicine',
                'name_laos' => 'medicine',
                'status' => true,
            ],
            [
                'name' => 'Functional Foods',
                'name_en' => 'Functional',
                'name_laos' => 'Foods',
                'status' => true,
            ]
        ];
        CategoryProduct::insert($categories);
    }
}
