‹@extends('layouts.master')

@section('title', 'View Cart')

@section('content')
    <?php
    $vnp_SecureHash = $_GET['vnp_SecureHash'];
    $inputData = array();
    foreach ($_GET as $key => $value) {
        if (substr($key, 0, 4) == "vnp_") {
            $inputData[$key] = $value;
        }
    }

    unset($inputData['vnp_SecureHash']);
    ksort($inputData);
    $i = 0;
    $hashData = "";
    $vnp_HashSecret = "NTMFIAYIYAEFEAMZVWNCESERJMBVROKS";
    foreach ($inputData as $key => $value) {
        if ($i == 1) {
            $hashData = $hashData . '&' . urlencode($key) . "=" . urlencode($value);
        } else {
            $hashData = $hashData . urlencode($key) . "=" . urlencode($value);
            $i = 1;
        }
    }

    $secureHash = hash_hmac('sha512', $hashData, $vnp_HashSecret);
    ?>
        <!--Begin display -->
    @include('layouts.partials.header')
    @include('component.banner')
    <div class="container justify-content-center">
        <div class="animation-ctn" id="animation-ctn">
            <div class="icon icon--order-success svg">
                <svg xmlns="http://www.w3.org/2000/svg" width="154px" height="154px">
                    <g fill="none" stroke="#28a745" stroke-width="2">
                        <circle cx="77" cy="77" r="72"
                                style="stroke-dasharray:480px, 480px; stroke-dashoffset: 960px;"></circle>
                        <circle id="colored" fill="#28a745" cx="77" cy="77" r="72"
                                style="stroke-dasharray:480px, 480px; stroke-dashoffset: 960px;"></circle>
                        <polyline class="st0" stroke="#fff" stroke-width="10" points="43.5,77.8 63.7,97.9 112.2,49.4 "
                                  style="stroke-dasharray:100px, 100px; stroke-dashoffset: 200px;"/>
                    </g>
                </svg>
                <h2>{{ __('home.Payment Success') }}</h2>
            </div>
        </div>
        <div class="row" id="form-paymentSuccess">
            <div class="form-group col-12 col-md-6">
                <label>{{ __('home.Mã đơn hàng') }}:</label>
                <label><?php echo $_GET['vnp_TxnRef'] ?></label>
            </div>
            <div class="form-group col-12 col-md-6">
                <label>{{ __('home.Số tiền') }} </label>
                <label><?php
                       $vnp_Amount = $_GET['vnp_Amount'];

                       if (isset($vnp_Amount) && is_numeric($vnp_Amount)) {
                           $formattedAmount = number_format($vnp_Amount / 100, 2, '.', ',');
                           $formattedAmount = rtrim($formattedAmount, '0');
                           $formattedAmount = rtrim($formattedAmount, '.');
                           echo $formattedAmount . " VND";
                       } else {
                           echo  __('home.Không có thông tin số tiền hợp lệ');
                       }
                       ?></label>
            </div>
            <div class="form-group col-12 col-md-6">
                <label>{{ __('home.Ngân hàng thanh toán') }}:</label>
                <label><?php echo $_GET['vnp_BankCode'] ?></label>
            </div>
            <div class="form-group col-12 col-md-6">
                <label>{{ __('home.Thời gian thanh toán') }}:</label>
                <label><?php
                       $vnp_PayDate = $_GET['vnp_PayDate'];
                       if (isset($vnp_PayDate) && strtotime($vnp_PayDate) !== false) {
                           $formattedDate = date("Y-m-d H:i:s", strtotime($vnp_PayDate));
                           echo $formattedDate;
                       } else {
                           echo __('home.Không có thông tin ngày giờ hợp lệ');
                       }
                       ?></label>
            </div>
            <div class="form-group col-12 col-md-6">
                <label>{{ __('home.Mã GD Tại VNPAY') }}:</label>
                <label><?php echo $_GET['vnp_TransactionNo'] ?></label>
            </div>
            <div class="form-group col-12 col-md-6">
                <label>{{ __('home.Nội dung thanh toán') }}:</label>
                <label><?php echo $_GET['vnp_OrderInfo'] ?></label>
            </div>
            <div class="form-group col-12 col-md-6">
                <label>{{ __('home.Mã phản hồi (vnp_ResponseCode)') }}:</label>
                <label><?php echo $_GET['vnp_ResponseCode'] ?></label>
            </div>
            <div class="form-group col-12 col-md-6">
                <label>{{ __('home.Kết quả') }}:</label>
                <label>
                    <?php
                    if ($secureHash == $vnp_SecureHash) {
                        if ($_GET['vnp_ResponseCode'] == '00') {
                            echo "<span style='color:blue'>Giao dịch thành công</span>";
                        } else {
                            echo "<span style='color:red'>Giao dịch không thành công</span>";
                        }
                    } else {
                        echo "<span style='color:red'>Chữ ký không hợp lệ</span>";
                    }
                    ?>

                </label>
            </div>
        </div>
        <a class="btn-success btn button" href="{{ route('home') }}">{{ __('home.Home') }}</a>
    </div>
@endsection
