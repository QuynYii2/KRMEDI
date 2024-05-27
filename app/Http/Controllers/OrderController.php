<?php

namespace App\Http\Controllers;

use App\Enums\OrderStatus;
use App\Enums\OrderType;
use App\Enums\TypeProductCart;
use App\Models\Cart;
use App\Models\OrderItem;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->get('status');
        $key_search = $request->get('key_search');
        $date_range = $request->get('date_range');

        $ordersQuery = DB::table('orders')
            ->where('user_id', Auth::id())
            ->when($status, function ($query, $status) {
                return $query->where('status', $status);
            })
            ->when($key_search, function ($query, $key_search) {
                return $query->where(function ($q) use ($key_search) {
                    $q->whereExists(function ($subQuery) use ($key_search) {
                        $subQuery->select(DB::raw(1))
                            ->from('order_items')
                            ->join('product_medicines', 'product_medicines.id', '=', 'order_items.product_id')
                            ->whereColumn('order_items.order_id', '=', 'orders.id')
                            ->where('product_medicines.name', 'LIKE', '%' . $key_search . '%');
                    })
                        ->orWhereExists(function ($subQuery) use ($key_search) {
                            $subQuery->select(DB::raw(1))
                                ->from('order_items')
                                ->join('product_infos', 'product_infos.id', '=', 'order_items.product_id')
                                ->whereColumn('order_items.order_id', '=', 'orders.id')
                                ->where('product_infos.name', 'LIKE', '%' . $key_search . '%');
                        });
                });
            })
            ->when($date_range, function ($query, $date_range) {
                $dates = explode(' - ', $date_range);
                if (count($dates) == 2) {
                    $start_date = Carbon::createFromFormat('Y-m-d', trim($dates[0]))->startOfDay();
                    $end_date = Carbon::createFromFormat('Y-m-d', trim($dates[1]))->endOfDay();
                    return $query->whereBetween('created_at', [$start_date, $end_date]);
                }
            })
            ->orderBy('id', 'desc')
            ->paginate(20);

        $orders = $ordersQuery->through(function ($order) {
            if ($order->prescription_id) {
                $orderItems = Cart::where('prescription_id', $order->prescription_id)->get();
            } else {
                $orderItems = OrderItem::where('order_id', $order->id)->get();
            }

            $order->total_order_items = $orderItems->count();
            $order->order_items = $orderItems;

            $products = $orderItems->map(function ($orderItem) {
                if ($orderItem->type_product == TypeProductCart::MEDICINE) {
                    return DB::table('product_medicines')
                        ->join('users', 'users.id', '=', 'product_medicines.user_id')
                        ->where('product_medicines.id', $orderItem->product_id)
                        ->select('product_medicines.*', 'users.username')
                        ->first();
                } else {
                    return DB::table('product_infos')
                        ->join('users', 'users.id', '=', 'product_infos.created_by')
                        ->where('product_infos.id', $orderItem->product_id)
                        ->select('product_infos.*', 'users.username')
                        ->first();
                }
            });

            $order->total_products = $products->count();
            $order->products = $products;

            return $order;
        });

        return view('ui.orders.list',compact('orders'));
    }
}
