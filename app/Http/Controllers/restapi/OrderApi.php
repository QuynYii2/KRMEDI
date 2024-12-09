<?php

namespace App\Http\Controllers\restapi;

use App\Enums\OrderStatus;
use App\Enums\OrderType;
use App\Enums\TypeProductCart;
use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Notification;
use App\Models\online_medicine\ProductMedicine;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\ProductInfo;
use App\Models\User;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Pusher\Pusher;

class OrderApi extends Controller
{
    public function getAllByUser($id, Request $request)
    {
        $status = $request->input('status');
        $type = $request->input('type');

        $orders = DB::table('orders')
            ->where('user_id', $id)
            ->where(function ($query) use ($status) {
                if ($status) {
                    $query->where('status', '=', $status);
                } else {
                    $query->where('status', '!=', OrderStatus::DELETED);
                }
            })->where(function ($query) use ($type) {
                if ($type == OrderType::SHOPPING) {
                    $query->where('prescription_id', '=', null);
                } else if ($type == OrderType::PRESCRIPTION) {
                    $query->where('prescription_id', '!=', null);
                }
            })
            ->orderBy('id', 'desc')
            ->cursor()
            ->map(function ($item) {
                if ($item->prescription_id) {
                    $order_items = Cart::where('prescription_id', $item->prescription_id)->get();
                } else {
                    $order_items = OrderItem::where('order_id', $item->id)->get();
                }
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
        $order = Order::with('ahaOrder')->find($id);
        $ahaOrder = $order->ahaOrder;
        if ($ahaOrder) {
            $decodedPath = json_decode($ahaOrder->path, true);

            $ahaOrder->path = $decodedPath;
        }
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

    public function cancelAhamove($id)
    {
        $token = $this->getTokenAhamove();
        $orderId = $id;

        $client = new Client();

        try {
            $response = $client->request('GET', 'https://apistg.ahamove.com/v1/order/cancel', [
                'query' => [
                    'token' => $token,
                    'order_id' => $orderId,
                    'comment' => 'Người gửi yêu cầu hủy đơn',
                ]
            ]);

            $order = Order::where('aha_order_id',$id)->first();
            $order->status = 'CANCELED';
            $order->save();

            return \redirect()->back()->with(['success' => 'Hủy đơn hàng thành công']);

        } catch (\Exception $exception){
            return \redirect()->back()->with(['error' => $exception->getMessage()]);
        }

}

    public function statusOrder(Request $request,$id)
    {
        $order = Order::find($id);
        if ($order->status == 'COMPLETED') {
            $gallery = null;
            if ($request->hasFile('file')) {
                $item = $request->file('file');
                $itemPath = $item->store('gallery', 'public');
                $gallery = asset('storage/' . $itemPath);
            }
            $order->status = 'REFUND';
            $order->type_order = 0;
            $order->reason_refund = $request->reason_refund;
            $order->image_reason = $gallery;
            $order->save();
        }
        $user = User::find($order->user_id);
        $notification = Notification::create([
            'title' => 'Thay đổi trạng thái đơn hàng',
            'sender_id' => $user->id,
            'follower' => $user->id,
            'target_url' => route('view.web.orders.index'),
            'description' => 'Trạng thái đơn hàng của bạn đã thay đổi, Vui lòng vào kiểm tra!',
        ]);
        $notification->save();
        $user_product = [];
        $order_item = OrderItem::where('order_id',$order->id)->get();
        foreach ($order_item as $item){
            if ($item->type_product == TypeProductCart::MEDICINE){
                $user = DB::table('product_medicines')
                    ->join('users', 'users.id', '=', 'product_medicines.user_id')
                    ->where('product_medicines.id', $item->product_id)
                    ->select( 'users.id')
                    ->first();
                $url = route('view.admin.orders.index');
            }else{
                $user = DB::table('product_infos')
                    ->join('users', 'users.id', '=', 'product_medicines.created_by')
                    ->where('product_infos.id', $item->product_id)
                    ->select('users.id')
                    ->first();
                $url = route('view.admin.orders.list');
            }
            if ($user && !in_array($user->id, $user_product)) {
                $user_product[$user->id] = $url;
            }
        }

        foreach ($user_product as $key => $val){
            $notificationAdmin = Notification::create([
                'title' => 'Yêu cầu hoàn đơn hàng',
                'sender_id' => $key,
                'follower' => $key,
                'target_url' => $val,
                'description' => 'Có đơn hàng yêu cầu hoàn trả, Vui lòng vào kiểm tra!',
            ]);
            $notificationAdmin->save();
            $options = array(
                'cluster' => 'ap1',
                'encrypted' => true
            );

            $PUSHER_APP_KEY = '3ac4f810445d089829e8';
            $PUSHER_APP_SECRET = 'c6cafb046a45494f80b2';
            $PUSHER_APP_ID = '1714303';

            $pusher = new Pusher($PUSHER_APP_KEY, $PUSHER_APP_SECRET, $PUSHER_APP_ID, $options);

            $requestData = [
                'user_id' => $key,
                'title' => 'Có đơn hàng yêu cầu hoàn trả',
            ];

            $pusher->trigger('noti-events', 'noti-events', $requestData);
        }


        return \redirect()->route('view.web.orders.index')->with(['success' => 'Xét trạng thái đơn hàng thành công']);
    }

    public function refundApproval($id)
    {
        $order = Order::find($id);
        $order->type_order = 1;
        $order->save();
        $notificationAdmin = Notification::create([
            'title' => 'Yêu cầu hoàn đơn hàng',
            'sender_id' => $order->user_id,
            'follower' => $order->user_id,
            'target_url' => route('view.web.orders.index'),
            'description' => 'Yêu cầu hoàn hàng của bạn đã được duyệt, Vui lòng vào kiểm tra!',
        ]);
        $notificationAdmin->save();
        $options = array(
            'cluster' => 'ap1',
            'encrypted' => true
        );

        $PUSHER_APP_KEY = '3ac4f810445d089829e8';
        $PUSHER_APP_SECRET = 'c6cafb046a45494f80b2';
        $PUSHER_APP_ID = '1714303';

        $pusher = new Pusher($PUSHER_APP_KEY, $PUSHER_APP_SECRET, $PUSHER_APP_ID, $options);

        $requestData = [
            'user_id' => $order->user_id,
            'title' => 'Yêu cầu hoàn hàng của bạn đã được duyệt, Vui lòng vào kiểm tra!',
        ];

        $pusher->trigger('noti-events', 'noti-events', $requestData);

        $options = array(
            'cluster' => 'ap1',
            'encrypted' => true
        );

        $pusher = new Pusher($PUSHER_APP_KEY, $PUSHER_APP_SECRET, $PUSHER_APP_ID, $options);

        //DATA WEB CALL WEB
        $pusher->trigger('aha-move-events', 'aha-move-events', $order);

        return \redirect()->back()->with(['success' => 'Duyệt hoàn hàng thành công']);
    }

    public function deleteOrder($id, Request $request)
    {
    }

    public function getPrescriptionOrderByUserID($id)
    {
        try {
            if (!$id) {
                return response()->json(['error' => -1, 'message' => "You must provide user id"], 400);
            }

            $orderModel = new Order();
            $getOrder = $orderModel->getOrderPrescriptionDetails($id);

            return response()->json(['error' => 0, 'data' => $getOrder]);
        } catch (\Exception $e) {
            return response(['error' => -1, 'message' => $e->getMessage()], 400);
        }
    }
}
