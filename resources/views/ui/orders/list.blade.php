@extends('layouts.admin')
@section('title')
    {{ __('home.List Order') }}
@endsection
<style>
    .product-thumbnail {
        max-width: 100px;
        border: 1px solid #ccc;
        margin-right: 10px;
    }
</style>
@section('main-content')
    <h3 class="text-center">{{ __('home.Order Management') }}</h3>
    <br>
    <div class="container">
        <ul class="nav nav-tabs" id="myTabOrder" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="all_order_tab" data-bs-toggle="tab" data-bs-target="#all_order"
                        type="button" role="tab" aria-controls="all_order" aria-selected="true">
                    All Order
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="process_order_tab" data-bs-toggle="tab" data-bs-target="#process_order"
                        type="button" role="tab" aria-controls="process_order" aria-selected="false">
                    Processing Order
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="wait_payment_order_tab" data-bs-toggle="tab"
                        data-bs-target="#wait_payment_order" type="button" role="tab" aria-controls="wait_payment_order"
                        aria-selected="false">
                    Waiting Payment Order
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="ship_order_tab" data-bs-toggle="tab" data-bs-target="#ship_order"
                        type="button" role="tab" aria-controls="ship_order" aria-selected="false">
                    Shipping Order
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="deliver_order_tab" data-bs-toggle="tab" data-bs-target="#deliver_order"
                        type="button" role="tab" aria-controls="deliver_order" aria-selected="false">
                    Deliver Order
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="cancel_order_tab" data-bs-toggle="tab" data-bs-target="#cancel_order"
                        type="button" role="tab" aria-controls="cancel_order" aria-selected="false">
                    Cancel Order
                </button>
            </li>
        </ul>
        <div class="tab-content" id="myTabOrderContent">
            <div class="tab-pane fade show active" id="all_order" role="tabpanel" aria-labelledby="all_order_tab">
                <div class="list-order mt-3 list_all_order">

                </div>
            </div>
            <div class="tab-pane fade" id="process_order" role="tabpanel" aria-labelledby="process_order_tab">
                <div class="list-order mt-3 list_process_order">

                </div>
            </div>
            <div class="tab-pane fade" id="wait_payment_order" role="tabpanel" aria-labelledby="wait_payment_order_tab">
                <div class="list-order mt-3 list_wait_payment_order">

                </div>
            </div>
            <div class="tab-pane fade" id="ship_order" role="tabpanel" aria-labelledby="ship_order_tab">
                <div class="list-order mt-3 list_ship_order">

                </div>
            </div>
            <div class="tab-pane fade" id="deliver_order" role="tabpanel" aria-labelledby="deliver_order_tab">
                <div class="list-order mt-3 list_deliver_order">

                </div>
            </div>
            <div class="tab-pane fade" id="cancel_order" role="tabpanel" aria-labelledby="cancel_order_tab">
                <div class="list-order mt-3 list_cancel_order">

                </div>
            </div>
        </div>
    </div>

    <script>
        let accessToken = `Bearer ` + token;
        let headers = {
            'Authorization': accessToken
        };

        $(document).ready(function () {
            loadOrders('');

            $('#all_order_tab').click(function () {
                loadOrders('');
            })

            $('#process_order_tab').click(function () {
                loadOrders('PROCESSING');
            })

            $('#wait_payment_order_tab').click(function () {
                loadOrders('WAITING FOR PAYMENT');
            })

            $('#ship_order_tab').click(function () {
                loadOrders('SHIPPING');
            })

            $('#deliver_order_tab').click(function () {
                loadOrders('DELIVERED');
            })

            $('#cancel_order_tab').click(function () {
                loadOrders('CANCELED');
            })
        })

        async function loadOrders(status) {
            loadingMasterPage();
            let orderUrl = `{{ route('restapi.api.orders.list.user', ['id'=>Auth::user()->id]) }}` + `?status=${status}`;

            await $.ajax({
                url: orderUrl,
                method: 'GET',
                headers: headers,
                success: function (response) {
                    loadingMasterPage()
                    renderOrders(response, status);
                },
                error: function (error) {
                    loadingMasterPage()
                    console.log(error);
                }
            });
        }

        async function renderOrders(response, status) {
            let html = ``;
            for (let i = 0; i < response.length; i++) {
                let data = response[i];
                let products = ``;
                let username = ``;
                let product_item = data.products;
                let order_item = data.order_items;
                if (product_item) {
                    for (let j = 0; j < product_item.length; j++) {
                        products = products + `<div class="d-flex align-items-center">
                                <img src="${product_item[j].thumbnail}"
                                     alt="" class="product-thumbnail">
                                <div class="product-info">
                                    <div class="product-name">
                                        ${product_item[j].name}
                                    </div>
                                    <div class="product-action d-flex align-items-center justify-content-between">
                                        <p class="quantity">
                                            x${order_item[j].quantity}
                                        </p>
                                        <p class="price">
                                            ${product_item[j].price}
                                        </p>
                                    </div>
                                </div>
                            </div>`;
                    }

                    username = `<b>${product_item[0].username}</b>`;
                }

                html = html + `<div class="order-item p-2 border mt-2">
                         <div class="shop-info">
                            ${username}
                        </div>
                        <div class="order-info">
                            ${products}
                        </div>
                    </div>`;
            }

            switch (status) {
                case 'PROCESSING':
                    $('.list_process_order').empty().append(html);
                    break;
                case 'WAITING FOR PAYMENT':
                    $('.list_wait_payment_order').empty().append(html);
                    break;
                case 'SHIPPING':
                    $('.list_ship_order').empty().append(html);
                    break;
                case 'DELIVERED':
                    $('.list_deliver_order').empty().append(html);
                    break;
                case 'CANCELED':
                    $('.list_cancel_order').empty().append(html);
                    break;
                default:
                    $('.list_all_order').empty().append(html);
                    break;
            }
        }

        function confirmCancelOrder(id) {
            if (confirm('Are you sure you want to cancel!')) {
                cancelOrder(id);
            }
        }

        async function cancelOrder(id) {
            let orderCancelUrl = ``;
            orderCancelUrl = orderCancelUrl.replace(':id', id);

            await $.ajax({
                url: orderCancelUrl,
                method: 'DELETE',
                headers: headers,
                success: function (response) {
                    alert('Cancel success!');
                    window.location.reload();
                },
                error: function (error) {
                    console.log(error);
                }
            });
        }
    </script>
@endsection
