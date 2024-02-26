<?php

namespace App\Models\online_medicine;

use App\Models\DrugIngredients;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductMedicine extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'name_en', 'name_laos',
        'brand_name', 'brand_name_en', 'brand_name_laos',
        'category_id', 'object_', 'filter_', 'price', 'status',
        'description', 'description_en', 'description_laos',
        'thumbnail', 'gallery', 'unit_price', 'quantity', 'is_prescription',

        'shape', 'unit_quantity', 'manufacturing_country', 'manufacturing_company',
        'specifications', 'short_description', 'short_description_en', 'short_description_laos',
        'number_register', 'side_effects', 'uses', 'user_manual',
        'notes', 'preserve', 'proved_by',
    ];

    public function DrugIngredient()
    {
        return $this->hasMany(DrugIngredients::class, 'product_id');
    }
}
