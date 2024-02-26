<?php

namespace App\Http\Controllers\restapi\admin;

use App\Enums\OrderItemStatus;
use App\Enums\OrderStatus;
use App\Enums\TypeProductCart;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminOrderApi extends Controller
{
    public function getAll(Request $request)
    {
        $userID = $request->input('user_id');
        $type = $request->input('type');
        $status = $request->input('status');
        if (!$userID) {
            return response('UserID not found', 400);
        }
        $role_user = DB::table('role_users')->where('user_id', $userID)->first();
        $userRoleNames = Role::where('id', $role_user->role_id)->pluck('name');
        $isAdmin = false;
        if ($userRoleNames[0] == 'ADMIN') {
            $isAdmin = true;
        }

        if ($isAdmin) {
            $orders = DB::table('orders')
                ->where('status', '!=', OrderStatus::DELETED)
                ->when($status, function ($query) use ($status) {
                    $query->where('status', $status);
                })
                ->orderBy('id', 'desc')
                ->cursor()
                ->map(function ($item) {
                    $orderItems = OrderItem::where('order_id', $item->id)
                        ->where('status', OrderItemStatus::ACTIVE)
                        ->get();
                    $order = (array)$item;
                    $order['count_item_order'] = count($orderItems);
                    $order['order_items'] = $orderItems;
                    return $order;
                });
        } else {
            if ($status) {
                if ($type == TypeProductCart::MEDICINE) {
                    $orders = DB::table('orders')
                        ->join('order_items', 'order_items.order_id', '=', 'orders.id')
                        ->join('product_medicines', 'order_items.product_id', '=', 'product_medicines.id')
                        ->where('product_medicines.user_id', $userID)
                        ->where('orders.type_product', TypeProductCart::MEDICINE)
                        ->where('orders.status', '!=', OrderStatus::DELETED)
                        ->where('orders.status', '=', $status)
                        ->select('orders.*')
                        ->get();
                } else {
                    $orders = DB::table('orders')
                        ->join('order_items', 'order_items.order_id', '=', 'orders.id')
                        ->join('product_infos', 'order_items.product_id', '=', 'product_infos.id')
                        ->where('orders.type_product', TypeProductCart::FLEA_MARKET)
                        ->where('product_infos.created_by', $userID)
                        ->where('orders.status', '!=', OrderStatus::DELETED)
                        ->where('orders.status', '=', $status)
                        ->select('orders.*')
                        ->get();
                }

            } else {
                if ($type == TypeProductCart::MEDICINE) {
                    $orders = DB::table('orders')
                        ->join('order_items', 'order_items.order_id', '=', 'orders.id')
                        ->join('product_medicines', 'order_items.product_id', '=', 'product_medicines.id')
                        ->where('product_medicines.user_id', $userID)
                        ->where('orders.type_product', TypeProductCart::MEDICINE)
                        ->where('orders.status', '!=', OrderStatus::DELETED)
                        ->select('orders.*')
                        ->get();
                } else {
                    $orders = DB::table('orders')
                        ->join('order_items', 'order_items.order_id', '=', 'orders.id')
                        ->join('product_infos', 'order_items.product_id', '=', 'product_infos.id')
                        ->where('orders.type_product', TypeProductCart::FLEA_MARKET)
                        ->where('product_infos.created_by', $userID)
                        ->where('orders.status', '!=', OrderStatus::DELETED)
                        ->select('orders.*')
                        ->get();

                }
            }
//            $mergedOrders = $orders1->merge($orders2);
//            $orders = $mergedOrders->toArray();
        }
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

    public function updateStatus($id, Request $request)
    {
        try {
            $order = Order::find($id);
            if (!$order || $order->status == OrderStatus::DELETED) {
                return response('Not found', 404);
            }

            $status = $request->input('status');
            if (!$status || $status == OrderStatus::DELETED) {
                $status = OrderStatus::PROCESSING;
            }

            $order->status = $status;
            $success = $order->save();

            if ($success) {
                return response()->json($order);
            }
            return response('Update error!', 400);
        } catch (\Exception $exception) {
            return response($exception, 400);
        }
    }

    public function delete($id)
    {
        try {
            $order = Order::find($id);
            if (!$order || $order->status == OrderStatus::DELETED) {
                return response('Not found', 404);
            }

            $order->status = OrderStatus::DELETED;
            $success = $order->save();

            if ($success) {
                return response('Delete success!', 200);
            }
            return response('Delete error!', 400);
        } catch (\Exception $exception) {
            return response($exception, 400);
        }
    }
}
