<?php

namespace App\Models;

use App\Enums\TypeProductCart;
use App\Models\online_medicine\ProductMedicine;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id', 
        'product_id', 
        'quantity', 
        'type_product', 
        'type_cart', 
        'type_delivery', 
        'price', 
        'total_price', 
        'status', 
        'prescription_id', 
        'note'
    ];

    public function users()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function products()
    {
        if ($this->type_product == TypeProductCart::MEDICINE) {
            return $this->belongsTo(ProductMedicine::class, 'product_id', 'id');
        } else {
            return $this->belongsTo(ProductInfo::class, 'product_id', 'id');
        }
    }
}
