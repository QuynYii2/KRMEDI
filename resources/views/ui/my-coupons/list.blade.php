@extends('layouts.admin')
@section('title')
    My Coupons
@endsection

@section('main-content')
    <h3 class="text-center">My Coupons</h3>
    <div class="d-flex align-items-center justify-content-between">
        <div class="mb-3 col-md-3">
            <input class="form-control" id="inputSearchCoupons" type="text" placeholder="Search.."/>
        </div>
    </div>
    <br>
    <div class="container-fluid">
        <table class="table" id="tableMyCoupons">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Name</th>
                <th scope="col">Email</th>
                <th scope="col">Phone</th>
                <th scope="col">Coupon Code</th>
                <th scope="col">Coupon Title</th>
                <th scope="col">Coupon Type</th>
                <th scope="col">Coupon Status</th>
                <th scope="col">Status</th>
            </tr>
            </thead>
            <tbody id="tbodyMyCoupons">

            </tbody>
        </table>
    </div>

    <script>
        let accessToken = `Bearer ` + token;
        let headers = {
            'Authorization': accessToken
        };

        $(document).ready(function () {
            loadCoupons();
        })

        async function loadCoupons() {
            loadingMasterPage();
            let orderUrl = `{{ route('api.backend.coupons-apply.my.coupon') }}`;

            await $.ajax({
                url: orderUrl,
                method: 'GET',
                headers: headers,
                success: function (response) {
                    loadingMasterPage()
                    renderCoupons(response);
                },
                error: function (error) {
                    loadingMasterPage()
                    console.log(error);
                }
            });
        }

        async function renderCoupons(response) {
            let html = ``;
            for (let i = 0; i < response.length; i++) {
                let data = response[i];
                let coupon = data.coupon_info;
                html += ` <tr>
                <th scope="row">${i + 1}</th>
                <td>${data.name}</td>
                <td>${data.email}</td>
                <td>${data.phone}</td>
                <td>${coupon.code}</td>
                <td>${coupon.title}</td>
                <td>${coupon.type}</td>
                <td>${coupon.status}</td>
                <td>${data.status}</td>
            </tr>`;
            }

            $('#tbodyMyCoupons').empty().append(html);
            loadPaginate('tableMyCoupons', 20);
            searchMain('inputSearchCoupons', 'tableMyCoupons');
        }
    </script>
@endsection
