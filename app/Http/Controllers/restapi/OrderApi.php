<?php

namespace App\Http\Controllers\restapi;

use App\Enums\OrderStatus;
use App\Enums\TypeProductCart;
use App\Http\Controllers\Controller;
use App\Models\online_medicine\ProductMedicine;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\ProductInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderApi extends Controller
{
    public function getAllByUser($id, Request $request)
    {
        $status = $request->input('status');

        $orders = DB::table('orders')
            ->where('user_id', $id)
            ->where(function ($query) use ($status) {
                if ($status) {
                    $query->where('status', '=', $status);
                } else {
                    $query->where('status', '!=', OrderStatus::DELETED);
                }
            })
            ->orderBy('id', 'desc')
            ->cursor()
            ->map(function ($item) {
                $order_items = OrderItem::where('order_id', $item->id)->get();
                $order = (array)$item;
                $order['total_order_items'] = $order_items->count();
                $order['order_items'] = $order_items->toArray();
                $array_products = null;
                foreach ($order_items as $order_item) {
                    if ($order_item->type_product == TypeProductCart::MEDICINE) {
                        $product = DB::table('product_medicines')
                            ->join('users', 'users.id', '=', 'product_medicines.user_id')
                            ->where('product_medicines.id', $order_item->product_id)
                            ->select('product_medicines.*', 'users.username')
                            ->first();
                    } else {
                        $product = DB::table('product_infos')
                            ->join('users', 'users.id', '=', 'product_medicines.created_by')
                            ->where('product_infos.id', $order_item->product_id)
                            ->select('product_infos.*', 'users.username')
                            ->first();
                    }
                    $array_products[] = $product;
                }
                $order['total_products'] = $array_products ? count($array_products) : 0;
                $order['products'] = $array_products;
                return $order;
            });

        return response()->json($orders);
    }

    public function detail($id)
    {
        $order = Order::find($id);
        if (!$order || $order->status == OrderStatus::DELETED) {
            return response('Not found', 404);
        }
        return response()->json($order);
    }

    /* Only cancel order when status of order is Processing or */
    public function cancelOrder($id, Request $request)
    {
        try {
            $order = Order::find($id);
            if ($order->status == OrderStatus::PROCESSING) {
                $order->status = OrderStatus::CANCELED;

                $order_items = OrderItem::where('order_id', $order->id)->get();
                foreach ($order_items as $item) {
                    $typeProduct = $item->type_product;
                    if ($typeProduct == TypeProductCart::MEDICINE) {
                        $product = ProductMedicine::find($item->product_id);
                    } else {
                        $product = ProductInfo::find($item->product_id);
                    }
                    $product->quantity = $product->quantity + $item->quantity;
                    $product->save();
                }

                $success = $order->save();
                if ($success) {
                    return response('Cancel order success!', 200);
                }
                return response('Cancel order error!', 400);
            }
            return response('Error, Please try again!', 400);
        } catch (\Exception $exception) {
            return response($exception, 400);
        }
    }

    public function deleteOrder($id, Request $request)
    {

    }
}
