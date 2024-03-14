<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $table = 'orders';
    protected $primaryKey = 'id';
    protected $fillable = [
        'user_id',
        'full_name',
        'email',
        'phone',
        'address',
        'total_price',
        'shipping_price',
        'discount_price',
        'total',
        'order_method',
        'status',
        'created_at',
        'type_product',
        'aha_order_id'
    ];
}
