<?php

namespace App\Http\Controllers;

use App\Enums\AddressStatus;
use App\Enums\OrderMethod;
use App\Http\Controllers\restapi\CheckoutApi;
use App\Models\Address;
use App\Models\Cart;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function index()
    {
        $carts = Cart::where('user_id', Auth::user()->id)->get();
        $addresses = DB::table('addresses')
            ->where('addresses.status', '!=', AddressStatus::DELETED)
            ->where('addresses.user_id', Auth::user()->id)
            ->orderBy('addresses.id', 'desc')
            ->join('provinces', 'provinces.id', '=', 'addresses.province_id')
            ->join('districts', 'districts.id', '=', 'addresses.district_id')
            ->join('communes', 'communes.id', '=', 'addresses.commune_id')
            ->select('addresses.*',
                'provinces.full_name as provinces_name',
                'districts.full_name as districts_name',
                'communes.full_name as communes_name')
            ->get();
        return view('checkout.checkout', compact('carts', 'addresses'));
    }

    public function checkoutByImm(Request $request)
    {
        try {
            $success = (new CheckoutApi())->checkout($request);
            if ($success) {
                alert()->success('Success', 'Checkout success!');
                return redirect(route('home'));
            }
            alert()->error('Error', 'Checkout error!');
            return back();
        } catch (\Exception $exception) {
            alert()->error('Error', $exception->getMessage());
            return back();
        }
    }

    public function returnCheckout(Request $request)
    {
        $url = session('url_prev', '/');

        if ($request->vnp_ResponseCode == "00") {
            if (Auth::check()) {
                $listValue = session('listValue');
                $arrayValue = explode(',', $listValue);

                $request->merge([
                    '_token' => $arrayValue[0],
                    'full_name' => $arrayValue[1],
                    'email' => $arrayValue[2],
                    'phone' => $arrayValue[3],
                    'address_checkout' => $arrayValue[4],
                    'order_method' => OrderMethod::ELECTRONIC_WALLET,
                    'user_id' => $arrayValue[5],
                    'total_fee' => $arrayValue[6],
                    'shipping_fee' => $arrayValue[7],
                    'discount_fee' => $arrayValue[8],
                    'total_order' => $arrayValue[9],
                ]);

                (new CheckoutApi())->checkout($request);
                return view('checkout.vnpay_return');
            }

            alert()->error('errors', 'errors');
            return redirect($url)->with('errors', 'Lỗi trong quá trình thanh toán phí dịch vụ');
        }
        session()->forget('url_prev');
        return redirect($url)->with('errors', 'Lỗi trong quá trình thanh toán phí dịch vụ');
    }

    public function checkoutByVNPay(Request $request)
    {
        $emailTo = $request->input('email');
        session(['emailTo' => $emailTo]);
        $money = $request->input('total_order');
        $money = $money . '00';
        $money = (int)$money;
        session(['cost_id' => $request->id]);
        session(['url_prev' => url()->previous()]);
        $vnp_TmnCode = "DX99JC99";
        $vnp_HashSecret = "NTMFIAYIYAEFEAMZVWNCESERJMBVROKS";
        $vnp_ReturnUrl = route('return.checkout.payment');
        $vnp_TxnRef = date("YmdHis");
        $vnp_Amount = $money;
        $vnp_Locale = 'vn';
        $user = Auth::user();
        $vnp_IpAddr = $request->input('address_checkout');
        $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
        $vnp_apiUrl = "http://sandbox.vnpayment.vn/merchant_webapi/merchant.html";
        $apiUrl = "https://sandbox.vnpayment.vn/merchant_webapi/api/transaction";
        $startTime = date("YmdHis");
        $expire = date('YmdHis', strtotime('+15 minutes', strtotime($startTime)));

        $token = $request->input('_token');

        $full_name = $request->input('full_name');
        $email = $request->input("email");
        $phone = $request->input('phone');
        $address = $request->input('address_checkout');

        $user_id = $request->input('user_id');

        $total = $request->input("total_fee");
        $shippingPrice = $request->input('shipping_fee');
        $salePrice = $request->input('discount_fee');
        $vnpAmount = $request->input('total_order');

        $array[] = $token;

        $array[] = $full_name;
        $array[] = $email;
        $array[] = $phone;
        $array[] = $address;

        $array[] = $user_id;

        $array[] = $total;
        $array[] = $shippingPrice;
        $array[] = $salePrice;
        $array[] = $vnpAmount;

        $listValue = implode(',', $array);

        session(['listValue' => $listValue]);

        $inputData = array(
            "vnp_Version" => "2.1.0",
            "vnp_TmnCode" => $vnp_TmnCode,
            "vnp_Amount" => $vnp_Amount,
            "vnp_Command" => "pay",
            "vnp_CreateDate" => date('YmdHis'),
            "vnp_CurrCode" => "VND",
            "vnp_IpAddr" => $vnp_IpAddr,
            "vnp_Locale" => $vnp_Locale,
            "vnp_OrderInfo" => "Thanh toan GD:" . $vnp_TxnRef,
            "vnp_OrderType" => "270000",
            "vnp_ReturnUrl" => $vnp_ReturnUrl,
            "vnp_TxnRef" => $vnp_TxnRef,
        );
        if (isset($vnp_BankCode) && $vnp_BankCode != "") {
            $inputData['vnp_BankCode'] = $vnp_BankCode;
        }
        ksort($inputData);
        $query = "";
        $i = 0;
        $hashdata = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashdata .= urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
            $query .= urlencode($key) . "=" . urlencode($value) . '&';
        }

        $vnp_Url = $vnp_Url . "?" . $query;
        if (isset($vnp_HashSecret)) {
            $vnpSecureHash = hash_hmac('sha512', $hashdata, $vnp_HashSecret);//
            $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
        }
        return redirect($vnp_Url);
    }
}
