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
    @media(min-width: 992px)
    {
    .col-lg-6 {
        width: 49.6%!important;
    }

    }
</style>
@section('main-content')
    <h3 class="text-center">{{ __('home.Order Management') }}</h3>
    <br>
    @if (session('success'))
        <div class="alert alert-primary alert-dismissible fade show" role="alert">
            {{session('success')}}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    <div class="container">
        <ul class="nav nav-tabs" id="myTabOrder" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="all_order_tab" data-bs-toggle="tab" data-bs-target="#all_order"
                        type="button" role="tab" aria-controls="all_order" aria-selected="true">
                    Tất cả đơn hàng
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="process_order_tab" data-bs-toggle="tab" data-bs-target="#process_order"
                        type="button" role="tab" aria-controls="process_order" aria-selected="false">
                    Tìm tài xế
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="wait_payment_order_tab" data-bs-toggle="tab"
                        data-bs-target="#wait_payment_order" type="button" role="tab" aria-controls="wait_payment_order"
                        aria-selected="false">
                    Đang chờ giao hàng
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="ship_order_tab" data-bs-toggle="tab" data-bs-target="#ship_order"
                        type="button" role="tab" aria-controls="ship_order" aria-selected="false">
                    Đang giao hàng
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="deliver_order_tab" data-bs-toggle="tab" data-bs-target="#deliver_order"
                        type="button" role="tab" aria-controls="deliver_order" aria-selected="false">
                    Đã giao hàng
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="cancel_order_tab" data-bs-toggle="tab" data-bs-target="#cancel_order"
                        type="button" role="tab" aria-controls="cancel_order" aria-selected="false">
                    Đơn hàng hủy
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="refund_order_tab" data-bs-toggle="tab" data-bs-target="#refund_order"
                        type="button" role="tab" aria-controls="refund_order" aria-selected="false">
                    Đơn hàng hoàn
                </button>
            </li>
        </ul>
        <div class="tab-content" id="myTabOrderContent">
            <div class="tab-pane fade show active" id="all_order" role="tabpanel" aria-labelledby="all_order_tab">
                <div class="list-order mt-3 list_all_order row justify-content-between">

                </div>
            </div>
            <div class="tab-pane fade" id="process_order" role="tabpanel" aria-labelledby="process_order_tab">
                <div class="list-order mt-3 list_process_order row justify-content-between">

                </div>
            </div>
            <div class="tab-pane fade" id="wait_payment_order" role="tabpanel" aria-labelledby="wait_payment_order_tab">
                <div class="list-order mt-3 list_wait_payment_order row justify-content-between">

                </div>
            </div>
            <div class="tab-pane fade" id="ship_order" role="tabpanel" aria-labelledby="ship_order_tab">
                <div class="list-order mt-3 list_ship_order row justify-content-between">

                </div>
            </div>
            <div class="tab-pane fade" id="deliver_order" role="tabpanel" aria-labelledby="deliver_order_tab">
                <div class="list-order mt-3 list_deliver_order row justify-content-between">

                </div>
            </div>
            <div class="tab-pane fade" id="cancel_order" role="tabpanel" aria-labelledby="cancel_order_tab">
                <div class="list-order mt-3 list_cancel_order row justify-content-between">

                </div>
            </div>
            <div class="tab-pane fade" id="refund_order" role="tabpanel" aria-labelledby="refund_order_tab">
                <div class="list-order mt-3 list_refund_order row justify-content-between">

                </div>
            </div>
        </div>

        <div class="box-content-order"></div>
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
                loadOrders('ASSIGNING');
            })

            $('#wait_payment_order_tab').click(function () {
                loadOrders('ACCEPTED');
            })

            $('#ship_order_tab').click(function () {
                loadOrders('IN PROCESS');
            })

            $('#deliver_order_tab').click(function () {
                loadOrders('COMPLETED');
            })

            $('#cancel_order_tab').click(function () {
                loadOrders('CANCELED');
            })

            $('#refund_order_tab').click(function () {
                loadOrders('REFUND');
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
            let model = ``;
            for (let i = 0; i < response.length; i++) {
                let data = response[i];
                let products = ``;
                let username = ``;
                let product_item = data.products;
                let order_item = data.order_items;
                if (product_item) {
                    for (let j = 0; j < product_item.length; j++) {
                        let formattedPrice = new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(product_item[j].price);
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
                                             ${formattedPrice}
                                        </p>
                                    </div>
                                    ${status == ''?`<div class="product-name mb-3">
                                        Trạng thái đơn hàng: ${data.status}
                                    </div>`:``}
                                    ${data.status == 'COMPLETED'? `<button data-bs-toggle="modal" data-bs-target="#staticBackdrop${j}" class="btn btn-danger">Hoàn đơn</button>`:''}
                                    ${data.status == 'REFUND' && data.type_order == 0?`<div class="product-name mb-3" style="color: red">
                                                    Hoàn hàng: chờ duyệt
                                     </div>`:``}
                                    ${data.status == 'REFUND' && data.type_order == 1?`<div class="product-name mb-3" style="color: green">
                                                    Hoàn hàng: đã duyệt
                                     </div>`:``}
                                </div>
                            </div>`;
                        if (data.status == 'COMPLETED'){
                            model += `<div class="modal fade" id="staticBackdrop${j}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel${j}" aria-hidden="true">
                                      <div class="modal-dialog">
                                        <div class="modal-content">
                                          <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="staticBackdropLabel">Lý do hoàn đơn</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                          </div>
                                            <form action="${window.location.origin}/orders/status/${data.id}" method="post" id="bookingHospitalForm" enctype="multipart/form-data">
                                            @csrf
                                          <div class="modal-body">
                                                <lable style="font-size: 15px">Lý do hoàn đơn</lable>
                                                <textarea name="reason_refund" class="w-100 mt-2" rows="3" required></textarea>
                                                 <div class="row mt-3">
                                                    <div class="col-12">Hình ảnh :</div>
                                                    <div class="col-12">
                                                        <div class="form-control position-relative" style="padding-top: 50%">
                                                            <button type="button" class="position-absolute border-0 bg-transparent select-image" data-target="file${j}" style="top: 50%;left: 50%;transform: translate(-50%,-50%)">
                                                                <i style="font-size: 30px" class="bi bi-download"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <input type="file" name="file" id="file${j}" accept="image/x-png,image/gif,image/jpeg" hidden>
                                          </div>
                                          <div class="modal-footer">
                                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">hủy</button>
                                            <button type="submit" class="btn btn-success">Hoàn đơn</button>
                                          </div>
                                           </form>
                                        </div>
                                      </div>
                                    </div>`
                        }
                    }

                    username = `<b>${product_item[0].username}</b>`;
                }

                html = html + `<div class="order-item p-2 border mt-2 col-lg-6 col-12">
                         <div class="shop-info">
                            <b>Shop: </b> ${username}
                        </div>
                        <div class="order-info">
                            ${products}
                        </div>
                    </div>`;
            }

            switch (status) {
                case 'ASSIGNING':
                    $('.list_process_order').empty().append(html);
                    break;
                case 'ACCEPTED':
                    $('.list_wait_payment_order').empty().append(html);
                    break;
                case 'IN PROCESS':
                    $('.list_ship_order').empty().append(html);
                    break;
                case 'COMPLETED':
                    $('.list_deliver_order').empty().append(html);
                    break;
                case 'CANCELED':
                    $('.list_cancel_order').empty().append(html);
                    break;
                case 'REFUND':
                    $('.list_refund_order').empty().append(html);
                    break;
                default:
                    $('.list_all_order').empty().append(html);
                    break;
            }
            $('.box-content-order').empty().append(model);
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

        let parent;
        $(document).on("click", ".select-image", function () {
            let target = $(this).data('target');
            $('#'+target ).click();
            parent = $(this).parent();
            $('#'+target).change(function(e){
                imgPreview(this);
            });
        });

        function imgPreview(input) {
            let file = input.files[0];
            let mixedfile = file['type'].split("/");
            let filetype = mixedfile[0];
            if(filetype == "image"){
                let reader = new FileReader();
                reader.onload = function(e){
                    $("#preview-img").show().attr("src", );
                    let html = '<div class="position-absolute w-100 h-100 div-file" style="top: 0; left: 0;z-index: 10">' +
                        '<button type="button" class="position-absolute clear border-0 bg-danger p-0 d-flex justify-content-center align-items-center" style="top: -10px;right: -10px;width: 30px;height: 30px;border-radius: 50%"><i class="bi bi-x-lg text-white"></i></button>'+
                        '<img src="'+e.target.result+'" class="w-100 h-100" style="object-fit: cover">' +
                        '</div>';
                    parent.html(html);
                }
                reader.readAsDataURL(input.files[0]);
            }else {
                alert("Invalid file type");
            }
        }
        $(document).on("click", "button.clear", function () {
            $(".div-file").remove();
            let html = '<button type="button" class="position-absolute border-0 bg-transparent select-image" style="top: 50%;left: 50%;transform: translate(-50%,-50%)">\n' +
                '                                    <i style="font-size: 30px" class="bi bi-download"></i>\n' +
                '                                </button>';
            parent.html(html);
            $('input[type="file"]').val("");
        });
    </script>
@endsection
