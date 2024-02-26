<?php

namespace App\Models;

use App\Models\online_medicine\ProductMedicine;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DrugIngredients extends Model
{
    use HasFactory;
    protected $table = 'drug_ingredients';
    protected $fillable = ['component_name', 'product_id'];


    public function product()
    {
        return $this->belongsTo(ProductMedicine::class, 'product_id');
    }


}
