<?php

namespace App\Models;

use App\Enums\TypeProductCart;
use App\Models\online_medicine\ProductMedicine;
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
        'aha_order_id',
        'prescription_id'
    ];

    public function getOrderDetails()
    {
        $order_items = OrderItem::where('order_id', $this->id)->get();
        $this->total_order_items = $order_items->count();
        $this->order_items = $order_items;
        
        $array_products = [];
        foreach ($order_items as $order_item) {
            if ($order_item->type_product == TypeProductCart::MEDICINE) {
                $product = ProductMedicine::join('users', 'users.id', '=', 'product_medicines.user_id')
                    ->where('product_medicines.id', $order_item->product_id)
                    ->select('product_medicines.*', 'users.username')
                    ->first();
            } else {
                $product = ProductInfo::join('users', 'users.id', '=', 'product_infos.created_by')
                    ->where('product_infos.id', $order_item->product_id)
                    ->select('product_infos.*', 'users.username')
                    ->first();
            }
            $array_products[] = $product;
        }
        $this->total_products = count($array_products);
        $this->products = $array_products;
    }
}
