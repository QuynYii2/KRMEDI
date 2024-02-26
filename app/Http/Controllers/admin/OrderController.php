<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;

class OrderController extends Controller
{
    public function list()
    {
        return view('admin.orders.list');
    }

    public function index()
    {
        return view('admin.orders.list_medicine');
    }

    public function detail($id)
    {
        $order = Order::find($id);
        $reflector = new \ReflectionClass('App\Enums\OrderStatus');
        $status = $reflector->getConstants();

        $orderItems = OrderItem::where('order_id', $id)->get();
        return view('admin.orders.detail', compact('order', 'status', 'orderItems'));
    }
}
