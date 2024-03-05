@extends('layouts.admin')
@section('title')
    {{ __('home.Detail Order') }}
@endsection
@section('main-content')
    <h3 class="text-center">{{ __('home.Detail Order') }}</h3>
    <div class="container">
        <div class="row">
            <div class="form-group col-md-4">
                <label for="full_name">{{ __('home.Full Name') }}</label>
                <input disabled type="text" class="form-control" id="full_name" value="{{ $order->full_name }}">
            </div>
            <div class="form-group col-md-4">
                <label for="email">{{ __('home.Email') }}</label>
                <input disabled value="{{ $order->email }}" type="email" class="form-control" id="email">
            </div>
            <div class="form-group col-md-4">
                <label for="phone">{{ __('home.PhoneNumber') }}</label>
                <input disabled value="{{ $order->phone }}" type="text" class="form-control" id="phone">
            </div>
        </div>
        <div class="form-group">
            <label for="address">{{ __('home.Addresses') }}</label>
            <input disabled value="{{ $order->address }}" type="text" class="form-control" id="address"
                   placeholder="Apartment, studio, or floor">
        </div>
        <div class="row">
            <div class="form-group col-md-3">
                <label for="total_price">{{ __('home.Total Product Price') }}</label>
                <input disabled value="{{ $order->total_price }}" type="text" class="form-control" id="total_price">
            </div>
            <div class="form-group col-md-3">
                <label for="shipping_price">{{ __('home.Total Shipping Price') }}</label>
                <input disabled value="{{ $order->shipping_price }}" type="text" class="form-control"
                       id="shipping_price">
            </div>
            <div class="form-group col-md-3">
                <label for="discount_price">{{ __('home.Total Discount Price') }}</label>
                <input disabled value="{{ $order->discount_price }}" type="text" class="form-control"
                       id="discount_price">
            </div>
            <div class="form-group col-md-3">
                <label for="total">{{ __('home.Total Price') }}</label>
                <input disabled value="{{ $order->total }}" type="text" class="form-control" id="total">
            </div>
        </div>
        <div class="row">
            <div class="form-group col-md-6">
                <label for="order_method">{{ __('home.Order Method') }}</label>
                <input disabled value="{{ $order->order_method }}" type="text" class="form-control" id="order_method">
            </div>
            <div class="form-group col-md-6">
                <label for="status">{{ __('home.Status') }}</label>
                <select id="status" class="form-select">
                    @foreach($status as $item)
                        @if($item != 'DELETED')
                            <option
                                {{ $item == $order->status ? 'selected' : '' }} value="{{ $item }}">{{ $item }}</option>
                        @endif
                    @endforeach
                </select>
            </div>
        </div>
        <h3 class="mt-3">{{ __('home.Order Item') }}</h3>
        <table class="table table-striped" id="tableOrderItem">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">{{ __('home.Product name') }}</th>
                <th scope="col">{{ __('home.Quantity') }}</th>
                <th scope="col">{{ __('home.Price') }}</th>
            </tr>
            </thead>
            <tbody>
            @foreach($orderItems as $orderItem)
                <tr>
                    <th scope="row">{{ $loop->index + 1 }}</th>
                    <td>
                        @php
                            if ($order->type_product == \App\Enums\TypeProductCart::MEDICINE){
                                $product = \App\Models\online_medicine\ProductMedicine::find($orderItem->product_id);
                            } else {
                                $product = \App\Models\ProductInfo::find($orderItem->product_id);
                            }
                        @endphp
                        {{ $product->name }}
                    </td>
                    <td>{{$orderItem->quantity}}</td>
                    <td>{{$orderItem->price}}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <div class="text-center mt-3 ">
            <button type="button" class="btn btn-primary" id="btnSaveOrder">{{ __('home.Save') }}</button>
        </div>
    </div>

    <script>
        let accessToken = `Bearer ` + token;
        let headers = {
            "Authorization": accessToken
        };

        $(document).ready(function () {
            $('#btnSaveOrder').on('click', function () {
                updateOrder();
            })

            async function updateOrder() {
                let orderUrl = `{{ route('view.admin.orders.index') }}`;
                let orderUpdateUrl = `{{ route('medical.api.orders.update', $order->id) }}`;

                let data = {
                    'status': $('#status').val()
                };

                await $.ajax({
                    url: orderUpdateUrl,
                    method: "PUT",
                    headers: headers,
                    data: data,
                    success: function (response) {
                        alert('Update success!')
                        window.location.href = orderUrl;
                    },
                    error: function (error) {
                        console.log(error);
                    }
                });
            }
        })
    </script>
@endsection
