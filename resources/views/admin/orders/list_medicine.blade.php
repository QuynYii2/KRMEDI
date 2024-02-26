@extends('layouts.admin')
@section('title')
    {{ __('home.List Order') }}
@endsection
@section('main-content')
    <h3 class="text-center">{{ __('home.Order Management') }}</h3>
    <div class="d-flex align-items-center justify-content-start">
        <div class="mb-3 col-md-3">
            <input class="form-control" id="inputSearchOrder" type="text" placeholder="Search.."/>
        </div>
    </div>
    <br>
    <table class="table table-striped" id="tableOrderManagement">
        <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">{{ __('home.Full Name') }}</th>
            <th scope="col">{{ __('home.Email') }}</th>
            <th scope="col">{{ __('home.PhoneNumber') }}</th>
            <th scope="col">{{ __('home.Địa chỉ') }}</th>
            <th scope="col">{{ __('home.Total Product Price') }}</th>
            <th scope="col">{{ __('home.Total Shipping Price') }}</th>
            <th scope="col">{{ __('home.Total Discount Price') }}</th>
            <th scope="col">{{ __('home.Total Price') }}</th>
            <th scope="col">{{ __('home.Order Method') }}</th>
            <th scope="col">{{ __('home.Status') }}</th>
            <th scope="col">{{ __('home.Action') }}</th>
        </tr>
        </thead>
        <tbody id="tbodyTableOrderManagement">

        </tbody>
    </table>

    <script>
        let accessToken = `Bearer ` + token;
        let headers = {
            "Authorization": accessToken
        };

        $(document).ready(function () {
            loadOrders();
        })

        async function loadOrders() {
            let orderUrl = `{{ route('medical.api.orders.list') }}`;
            orderUrl = orderUrl + `?user_id={{ Auth::user()->id }}` + `&type={{ \App\Enums\TypeProductCart::MEDICINE }}`;

            await $.ajax({
                url: orderUrl,
                method: "GET",
                headers: headers,
                success: function (response) {
                    renderOrders(response);
                },
                error: function (error) {
                    console.log(error);
                }
            });
        }

        async function renderOrders(response) {
            let html = ``;
            for (let i = 0; i < response.length; i++) {
                let data = response[i];

                let orderDetailUrl = `{{ route('view.admin.orders.detail', ['id'=> ':id']) }}`;
                orderDetailUrl = orderDetailUrl.replace(':id', '');

                html = html + `<tr>
                                        <th scope="row">${i + 1}</th>
                                        <td>${data.full_name}</td>
                                        <td>${data.email}</td>
                                        <td>${data.phone}</td>
                                        <td>${data.address}</td>
                                        <td>${data.total_price}</td>
                                        <td>${data.shipping_price}</td>
                                        <td>${data.discount_price}</td>
                                        <td>${data.total}</td>
                                        <td>${data.order_method}</td>
                                        <td>${data.status}</td>
                                        <td>
                                            <a href="${orderDetailUrl + data.id}" class="btn btn-success" >{{ __('home.Detail') }}</a>
                                            <button type="button" class="btn btn-danger" id="btnDelete" onclick="confirmDeleteOrder('${data.id}')">{{ __('home.Delete') }}</button>
                                        </td>
                                    </tr>`;
            }
            $('#tbodyTableOrderManagement').empty().append(html);
            loadPaginate('tableOrderManagement', 20);
            searchMain('inputSearchOrder', 'tableOrderManagement');
        }

        function confirmDeleteOrder(id) {
            if (confirm('Are you sure you want to delete!')) {
                deleteOrder(id);
            }
        }

        async function deleteOrder(id) {
            let orderDeleteUrl = `{{ route('medical.api.orders.delete', ['id'=>':id']) }}`;
            orderDeleteUrl = orderDeleteUrl.replace(':id', id);

            await $.ajax({
                url: orderDeleteUrl,
                method: "DELETE",
                headers: headers,
                success: function (response) {
                    alert('Delete success!');
                    window.location.reload();
                },
                error: function (error) {
                    console.log(error);
                }
            });
        }
    </script>
@endsection
