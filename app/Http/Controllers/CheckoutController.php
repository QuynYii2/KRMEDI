<?php

namespace App\Http\Controllers;

use App\Enums\AddressStatus;
use App\Enums\CartStatus;
use App\Enums\OrderMethod;
use App\Http\Controllers\restapi\CheckoutApi;
use App\Models\Address;
use App\Models\Cart;
use App\Models\District;
use App\Models\Province;
use App\Models\Role;
use App\Models\User;
use App\Services\FundiinService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    public $fundiinService;

    public function __construct(FundiinService $fundiinService)
    {
        $this->fundiinService = $fundiinService;
    }
    public function index(Request $request)
    {
        if (isset($request->prescription_id) && $request->prescription_id) {
            $carts = Cart::where('prescription_id', $request->prescription_id)->get();
        } else {
            $carts = Cart::where('user_id', Auth::user()->id)->whereNull('prescription_id')->get();
        }

        $addresses = DB::table('addresses')
            ->where('addresses.status', '!=', AddressStatus::DELETED)
            ->where('addresses.user_id', Auth::user()->id)
            ->orderBy('addresses.id', 'desc')
            ->join('provinces', 'provinces.id', '=', 'addresses.province_id')
            ->join('districts', 'districts.id', '=', 'addresses.district_id')
            ->join('communes', 'communes.id', '=', 'addresses.commune_id')
            ->select(
                'addresses.*',
                'provinces.full_name as provinces_name',
                'districts.full_name as districts_name',
                'communes.full_name as communes_name'
            )
            ->get();

        if (!Auth::user()->province_id || !Auth::user()->district_id){
            alert()->error('Error', 'Vui lòng cập nhật địa chỉ để tiếp tục');
            return back();
        }

        $province_name = Province::where('code',Auth::user()->province_id)->first()->name;
        $district_name = District::where('code',Auth::user()->district_id)->first()->name;
        $total_fee = 0;
        $url = 'https://apistg.ahamove.com/v1/order/estimated_fee';
        $path = json_encode([
            [
                "address" => "La Khe, Ha Dong, Hà Nội",
                "short_address" => "La Khe",
                "name" => "KRMEDI",
                "mobile" => "0973566792",
                "remarks" => "call me"
            ],
            [
                "address" => Auth::user()->detail_address.', '.$province_name.', '.$district_name,
                "name" => Auth::user()->name,
                "mobile" => Auth::user()->phone
            ]
        ]);

        $params = [
            'token' => $this->getTokenAhamove(),
            'order_time' => 0,
            'path' => $path,
            'service_id' => 'SGN-BIKE',
            'requests' => json_encode([])
        ];

        $response = Http::asForm()->withHeaders([
            'Cache-Control' => 'no-cache',
            'Content-Type' => 'application/x-www-form-urlencoded',
        ])->post($url, $params);

        if ($response->successful()) {
            $data = $response->json();
            $total_fee = $data['total_fee'];
        } else {
            $errorCode = $response->status();
            $errorMessage = $response->body();

            alert()->error('Error', 'Khoảng cách không phù hợp để mua hàng');
            return back();
        }

        return view('checkout.checkout', compact('carts', 'addresses','total_fee'));
    }

    public function checkoutByImm(Request $request)
    {
        try {
            $success = (new CheckoutApi())->checkout($request);
            if ($success) {
                session()->flash('checkout_success', true);
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
            $vnpSecureHash = hash_hmac('sha512', $hashdata, $vnp_HashSecret); //
            $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
        }
        return redirect($vnp_Url);
    }

    public function checkoutByFundiin(Request $request)
    {
        //Get Product Detail
        $totalOrder = $request->input('total_order');
        $quantity = $request->input('quantity_payment');
        $productID = $request->input('product_id');
        $productPrice = $request->input('product_price');
        $productName = $request->input('product_name');
        $productDescription = $request->input('product_description');
        $productDescription = htmlspecialchars(strip_tags($productDescription), ENT_QUOTES, 'UTF-8');
        $productCategory = $request->input('product_category');
        $productImage = $request->input('product_image');
        $productImageArray = explode(',', $productImage);
        $productUnitPrice = $request->input('product_unit_price');

        //Get customer detail
        $firstName = $request->input('first_name');
        $lastName = $request->input('last_name');
        $email = $request->input("email");
        $phone = $request->input('phone');
        $gender = $request->input('gender');
        $birthday = $request->input('birthday');
        $province = $request->input('province');
        $district = $request->input('district');
        $address = $request->input('address_checkout');

        //Send request to Fundiin
        $endpoint = 'https://gateway-sandbox.fundiin.vn/v2/payments';

        $clientId = config('fundiin.clientId');
        $merchantId = config('fundiin.merchantId');
        $secretKey = config('fundiin.secretKey');

        function generateReferenceId($length = 30) {
            $characters = '0123456789';
            $charactersLength = strlen($characters);
            $randomString = '';
            for ($i = 0; $i < $length; $i++) {
                $randomString .= $characters[rand(0, $charactersLength - 1)];
            }
            return $randomString;
        }
        $referenceId = generateReferenceId();

        $data = [
            "merchantId" => $merchantId,
            "referenceId" => $referenceId,
            "requestType" => "installment",
            "paymentMethod" => "WEB",
            "terminalType" => "DESKTOP_BROWSER",
            "lang" => "vi",
            "extraData" => "jsonstring",
            "description" => "description",
            "successRedirectUrl" => "https://google.com",
            "unSuccessRedirectUrl" => route('return.checkout.payment'),
            "installment" => [
                "packageCode" => "045000"
            ],
            "amount" => [
                "currency" => $productUnitPrice,
                "value" => $totalOrder
            ],
            "items" => [
                [
                    "productId" => $productID,
                    "productName" => $productName,
                    "description" => $productDescription,
                    "category" => $productCategory,
                    "quantity" => $quantity,
                    "price" => $productPrice,
                    "currency" => $productUnitPrice,
                    "totalAmount" => $totalOrder,
                    "imageUrl" => "https://krmedi.vn" . $productImageArray[0]
                ]
            ],
            "customer" => [
                "phoneNumber" => $phone,
                "email" => $email,
                "firstName" => $firstName,
                "lastName" => $lastName,
                "gender" => $gender,
                "dateOfBirth" => $birthday,
            ],
            "shipping" => [
                "city" => $province,
                "zipCode" => "00700",
                "district" => $district,
                "ward" => "",
                "street" => $address,
                "streetNumber" => $address,
                "houseNumber" => $address,
                "houseExtension" => null,
                "country" => "VN"
            ],
            "sendEmail" => true
        ];

        $result = $this->fundiinService->execPostRequest($endpoint, $data, $clientId, $secretKey);
        $jsonResult = json_decode($result, true);

        if (isset($jsonResult['error'])) {
            return response()->json(['error' => 'Request failed', 'details' => $jsonResult], 403);
        }

        if($jsonResult['resultStatus'] == "APPROVED"){
            return redirect($jsonResult['paymentUrl']);
        }else{
            toast('Đã có lỗi xảy ra, vui lòng kiểm tra lại!', 'error', 'top-left');
            return back();
        }
    }

    public function rePurchasePrescription(Request $request)
    {
        try {
            $prescription_id = $request->prescription_id;
            if (!$prescription_id) {
                alert()->error('Error', 'Not have prescription_id');
                return back();
            }

            $carts = Cart::where('prescription_id', $prescription_id)->get();

            $new_prescription_id = strtoupper(Str::random(3)) . '_' . time();

            //Duplicate cart
            foreach ($carts as $cart) {
                $newCart = $cart->replicate();
                $newCart->prescription_id = $new_prescription_id;
                $newCart->doctor_id = null;
                $newCart->status = CartStatus::PENDING;
                $newCart->save();
            }

            // Call the index method and pass the new prescription_id
            return $this->index($request->merge(['prescription_id' => $new_prescription_id]));
        } catch (\Exception $e) {
            alert()->error('Error', $e->getMessage());
            return back();
        }
    }

    public function deleteAddress(Request $request)
    {
        $address = Address::find($request->id);
        if ($address) {
            $address->delete();
            return response()->json(['status' => 'success']);
        } else {
            return response()->json(['status' => 'error', 'message' => 'Address not found'], 404);
        }
    }
}
