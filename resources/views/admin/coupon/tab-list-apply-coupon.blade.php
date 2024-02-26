@php use App\Enums\CouponApplyStatus;use App\Models\Coupon; @endphp
@php @endphp
@extends('layouts.admin')
@section('title', 'List Coupon')
@section('main-content')
    <link href="{{ asset('css/tablistapplycoupon.css') }}" rel="stylesheet">
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">{{ __('home.List Apply of Coupon') }}</h1>


    <div class="">
        <table class="table table-striped">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">{{ __('home.Tên coupon') }}</th>
                <th scope="col">{{ __('home.tên người đăng ký') }}</th>
                <th scope="col">{{ __('home.Email người đăng ký') }}</th>
                <th scope="col">{{ __('home.loại hình đăng ký') }}</th>
                <th scope="col">{{ __('home.Link social người đăng ký') }}</th>
                <th scope="col">{{ __('home.Trạng thái') }}</th>
                <th scope="col">{{ __('home.Thao tác') }}</th>
            </tr>
            </thead>
            <tbody>
            @foreach($applyCoupons as $index => $applyCoupon)
                <tr>
                    <td>{{ ++$index }}</td>
                    <td>{{ Coupon::getNameCoupon($applyCoupon->coupon_id) }}</td>
                    <td>{{ Coupon::getNameUser($applyCoupon->user_id) }}</td>
                    <td>{{ $applyCoupon->email }}</td>
                    <td>{{ $applyCoupon->sns_option }}</td>
                    <td>{{ $applyCoupon->link_ }}</td>
                    <td>{{ $applyCoupon->status }}</td>
                    <td>
                        <button type="button" class="btn btn-danger" data-toggle="tooltip" data-placement="bottom"
                                title="Invalid" onclick="changeStatusApplyCoupon(INVALID, '{{ $applyCoupon->id }}')">
                            <i class="fa-solid fa-ban"></i></button>
                        <button type="button" class="btn btn-primary" data-toggle="tooltip" data-placement="bottom"
                                title="Valid" onclick="changeStatusApplyCoupon(VALID, '{{ $applyCoupon->id }}')">
                            <i class="fa-solid fa-check"></i></button>
                        <button type="button" class="btn btn-success" data-toggle="tooltip" data-placement="bottom"
                                title="Reward" onclick="changeStatusApplyCoupon(REWARD, '{{ $applyCoupon->id }}')">
                            <i class="fa-solid fa-medal"></i></button>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <div class="d-flex justify-content-center align-items-center">
            {{ $applyCoupons->links() }}
        </div>
    </div>

    <script>
        const INVALID = '{{ CouponApplyStatus::INVALID }}';
        const VALID = '{{ CouponApplyStatus::VALID }}';
        const REWARD = '{{ CouponApplyStatus::REWARDED }}';

        async function changeStatusApplyCoupon(status, idApplyCoupon) {
            let result = confirm('{{ __('home.Bạn có chắc chắn muốn thay đổi trạng thái của coupon này') }}?');
            if (!result) {
                return;
            }
            loadingMasterPage();
            let url = '{{ route('api.backend.coupons-apply.update-status') }}';
            const headers = {
                'Authorization': `Bearer ${token}`
            };
            const formData = new FormData();

            formData.append('status', status);
            formData.append('id', idApplyCoupon);

            try {
                $.ajax({
                    url: url,
                    method: 'POST',
                    headers: headers,
                    contentType: false,
                    cache: false,
                    processData: false,
                    data: formData,
                    success: function (data) {
                        alert(data);
                        loadingMasterPage();
                        window.location.reload();
                    },
                    error: function (exception) {
                        alert(exception.responseText);
                        loadingMasterPage();
                    }
                });
            } catch (error) {
                loadingMasterPage();
            }
        }
    </script>

@endsection
