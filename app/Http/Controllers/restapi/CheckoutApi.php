<?php

namespace App\Http\Controllers\restapi;

use App\Enums\CartStatus;
use App\Enums\OrderItemStatus;
use App\Enums\OrderStatus;
use App\Enums\TypeProductCart;
use App\Events\AhamoveEvent;
use App\Http\Controllers\Controller;
use App\Http\Controllers\MailController;
use App\Models\Cart;
use App\Models\Notification;
use App\Models\online_medicine\ProductMedicine;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\ProductInfo;
use App\Models\Role;
use App\Models\User;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Enums\Constants;
use App\Models\AhaOrder;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use Pusher\Pusher;

class CheckoutApi extends Controller
{
    public function checkoutByImm(Request $request)
    {
        try {
            $success = $this->checkout($request);
            if ($success) {
                return response()->json($success);
            }
            return response('Checkout error!', 400);
        } catch (\Exception $exception) {
            return response($exception, 400);
        }
    }

    public function checkout($request)
    {
        // $discount_price_exchange = $request->input('discount_price_exchange');
        // if ($discount_price_exchange > 999) {
        //     $point_exchange = intval($discount_price_exchange / 1000);
        // } else {
        //     $point_exchange = 0;
        // }

        $userID = intval($request->input('user_id'));

        // if ($discount_price_exchange) {
        //     $user = User::find($userID);
        //     $user->points = $point_exchange;
        //     $user->save();
        // }

        $full_name = $request->input('full_name');
        $email = $request->input('email');
        $phone = $request->input('phone');
        $address = $request->input('address_checkout');


        $total = intval($request->input('total_fee'));

        $ship = intval($request->input('shipping_fee'));
        $discount = intval($request->input('discount_fee'));
        $totalOrder = intval($request->input('total_order'));

        $orderMethod = $request->input('order_method');

        $prescription_id = $request->input('prescription_id');

        $order = new Order();

        $order->user_id = $userID;

        $order->full_name = $full_name;
        $order->email = $email;
        $order->phone = $phone;
        $order->address = $address;

        $order->total_price = $total;
        $order->shipping_price = $ship;
        $order->discount_price = $discount;
        $order->total = $totalOrder;
        $order->aha_order_id = $request->input('aha_order_id') ?? null;

        $order->order_method = $orderMethod;
        $order->status = OrderStatus::PROCESSING;

        $order->prescription_id = $prescription_id;

        $order->save();

        if ($prescription_id) {
            $carts = Cart::where('user_id', $userID)->where('prescription_id', $prescription_id)->get();
        } else {
            $carts = Cart::where('user_id', $userID)->whereNull('prescription_id')->get();
        }
        $items = [];
        foreach ($carts as $cart) {
            if ($cart->type_product == TypeProductCart::MEDICINE) {
                $product = ProductMedicine::find($cart->product_id);
            } else {
                $product = ProductInfo::find($cart->product_id);
            }

            $orderItem = new OrderItem();
            $orderItem->order_id = $order->id;

            $orderItem->product_id = $cart->product_id;
            $orderItem->quantity = $cart->quantity;
            $orderItem->price = $total;

            $orderItem->type_product = $cart->type_product;

            $orderItem->status = OrderItemStatus::ACTIVE;
            $orderItem->save();

            $product->quantity -= $cart->quantity;
            $product->save();
            $items[] = [
                '_id' => $product->id,
                'num' => $cart->quantity,
                'name' => $product->name,
                'price' => $product->price * $cart->quantity
            ];
            if ($prescription_id) {
                $cart->price = $product->price;
                $cart->total_price = $product->price * $cart->quantity;
                $cart->save();
            }else {
                $cart->delete();
            }
        }

        $orderData = [
            'path' => [
                [
                    'address' => '102 P. Nguyễn Thanh Bình, La Khê, Hà Đông, Hà Nội, Việt Nam',
                    'short_address' => 'Xã La Khê',
                    'name' => 'Hoàng Nguyễn',
                    'mobile' => '0978125456',
                    'remarks' => 'Call me'
                ],
                [
                    'address' => $address,
                    'name' => $full_name,
                    'mobile' => $phone
                ]
            ],
        ];

        $pathJson = json_encode($orderData['path']);
        $itemsJson = json_encode($items);

        $params = [
            'token' => 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJhaGEiLCJ0eXAiOiJ1c2VyIiwiY2lkIjoiODQ5NjgyMjgyMjkiLCJzdGF0dXMiOiJPTkxJTkUiLCJlb2MiOm51bGwsIm5vYyI6IkRBRkMiLCJjdHkiOiJTR04iLCJhY2NvdW50X3N0YXR1cyI6IkFDVElWQVRFRCIsImV4cCI6MTc0OTA5Nzg2MSwicGFydG5lciI6ImRhZmMiLCJ0eXBlIjoiYXBpIn0.qnG31ReIFLc46M7XJcD8IVskl-XBuPvoxXQagvVE2D0',
            'order_time' => '0',
            'path' => $pathJson,
            'service_id' => 'SGN-BIKE',
            'requests' => '[]',
            'items' => $itemsJson
        ];
        $url = 'https://apistg.ahamove.com/v1/order/create?' . http_build_query($params);
        $response = Http::post($url);
        if ($response->successful()) {
            $data = $response->json();
            $order->aha_order_id = $data['order_id'];
            $order->save();
        } else {
            $errorCode = $response->status();
            $errorMessage = $response->body();
            dd("Error {$errorCode}: {$errorMessage}");
        }
        $roleAdmin = Role::where('name', \App\Enums\Role::ADMIN)->first();
        $role_user = DB::table('role_users')->where('role_id', $roleAdmin->id)->first();
        $admin = User::where('id', $role_user->user_id)->first();
        (new MailController())->sendEmail($email, 'support_krmedi@gmail.com', 'Order success', 'Notification of successful order placement!');
        (new MailController())->sendEmail($admin->email, 'support_krmedi@gmail.com', 'Order created', 'A new order has just been created!');
        if ($prescription_id) {
            $order->getPrescriptionOrderDetails();
        }else{
            $order->getOrderDetails();
        }
        return $order;
    }

    public function returnCheckoutVNPay(Request $request)
    {
        try {
            $response = null;
            $vnp_ResponseCode = $request->input('vnp_ResponseCode');
            $response['vnp_ResponseCode'] = $vnp_ResponseCode;
            return response()->json($response);
        } catch (\Exception $exception) {
            return response((new MainApi())->returnMessage('Error, Please try again!'), 400);
        }
    }

    public function showPoint(Request $request)
    {
        $user_id = $request->input('user_id');
        $user = User::find($user_id);

        if (!$user) {
            return response((new MainApi())->returnMessage('User not found!'), 404);
        }

        $point = $user->points;
        $price_discount_max = $point * 1000;
        return response()->json(['price_discount_max' => $price_discount_max], 200);
    }

    public function statusOrder(Request $request)
    {
        try {
            $validated = Validator::make($request->all(), [
                '_id' => 'required',
                'supplier_id' => 'nullable',
                'shared_link' => 'nullable',
                'path' => 'nullable',
                'status' => 'nullable'
            ]);

            if ($validated->fails()) {
                return response()->json(['error' => -1, 'message' => $validated->errors()->first()], 400);
            }

            AhaOrder::updateOrCreate([
                '_id' => $request->_id
            ], [
                '_id' => $request->_id,
                'supplier_id' => $request->supplier_id ?? "",
                'shared_link' => $request->shared_link ?? "",
                'path' => $request->path ? json_encode($request->path) : null,
                'status' => $request->status ?? "",
            ]);

            $order = Order::where('aha_order_id', $request->_id)->first();

            if (empty($order)) {
                return response()->json(['status' => false, 'message' => 'Đơn hàng không tồn tại'], 400);
            }

            $order->status = $request->status;
            $order->save();

            if ($request->status == "ACCEPTED") {
                $carts = Cart::where('prescription_id', $order->prescription_id)->get();
                foreach ($carts as $cart) {
                    $cart->status = CartStatus::COMPLETE;
                    $cart->save();
                }
            }

            $data = $request->all();
            $user = User::find($order->user_id);
            $token = $user->token_firebase;
            $response = $this->sendNotification($token, $data);
            $notification = Notification::create([
                'title' => 'Thay đổi trạng thái đơn hàng',
                'sender_id' => $user->id,
                'follower' => $user->id,
                'target_url' => route('view.web.orders.index'),
                'description' => 'Trạng thái đơn hàng của bạn đã thay đổi, Vui lòng vào kiểm tra!',
            ]);
            $notification->save();
            $order_item = OrderItem::where('order_id',$order->id)->first();
            if ($order_item->type_product == "MEDICINE"){
                $product_medicine = ProductMedicine::find($order_item->product_id);
                $order->user_shop = $product_medicine->user_id;
            }else{
                $product_info = ProductInfo::find($order_item->product_id);
                $order->user_shop = $product_info->created_by;
            }
            $options = array(
                'cluster' => 'ap1',
                'encrypted' => true
            );

            $PUSHER_APP_KEY = '3ac4f810445d089829e8';
            $PUSHER_APP_SECRET = 'c6cafb046a45494f80b2';
            $PUSHER_APP_ID = '1714303';

            $pusher = new Pusher($PUSHER_APP_KEY, $PUSHER_APP_SECRET, $PUSHER_APP_ID, $options);

            //DATA WEB CALL WEB
            $pusher->trigger('aha-move-events', 'aha-move-events', $order);

            return response()->json(['status' => true, 'message' => 'Cập nhật trạng thái đơn hàng thành công'], 200);
        } catch (\Exception $e) {
            return response(['status' => false, 'message' => $e->getMessage()], 400);
        }
    }

    public function sendNotification($device_token, $data)
    {
        $client = new Client();
        $YOUR_SERVER_KEY = Constants::GG_KEY;

        $response = $client->post('https://fcm.googleapis.com/fcm/send', [
            'headers' => [
                'Authorization' => 'key=' . $YOUR_SERVER_KEY,
                'Content-Type' => 'application/json',
            ],
            'json' => [
                'to' => $device_token,
                'data' => $data,
                'notification' => [
                    'title' => 'Cập nhật trạng thái đơn hàng thành công',
                    'body' => 'order',
                ],
                'web' => [
                    'notification' => 'Cập nhật trạng thái đơn hàng thành công',
                ],
            ],
        ]);

        return $response->getBody();
    }

    public function calcDiscount(Request $request)
    {
        $price = $request->input('price');
        $user_id = $request->input('user_id');

        $response['status'] = 200;
        $response['discount'] = 0;
        $response['price'] = $price;
        $user = User::find($user_id);
        if (!$user) {
            $response['status'] = 404;
            $response['message'] = 'User not found!';
            return response((new MainApi())->returnMessage($response['message']), $response['status']);
        }

        $point = $user->points;
        $point_to_money = $point * 1000;
        if ($point > 0) {
            $point_exchange = 0; /* Tiền thừa*/
            if ($price < $point_to_money) {
                $point_money_exchange = $point_to_money - $price;
                $point_exchange = intval($point_money_exchange / 1000);
                $discount = $price;
                $price = 0;
            } else {
                $discount = $point_to_money;
                $price = $price - $point_to_money;
            }
            $response['point_exchange'] = $point_exchange;
            $response['discount'] = $discount;
            $response['price'] = $price;
        }

        return response()->json($response);
    }
}
