<?php

namespace App\Http\Controllers\admin;

use App\Enums\TypeProductCart;
use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

    public function orderStatus(Request $request)
    {
        $order = Order::find($request->id);
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
        }


        return response()->json(['error' => 0, 'message' => 'Gửi yêu cầu hoàn hàng thành công']);
    }
}
