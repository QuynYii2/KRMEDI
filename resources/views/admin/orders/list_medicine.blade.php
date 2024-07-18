@extends('layouts.admin')
@section('title')
    {{ __('home.List Order') }}
@endsection
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
@section('main-content')
    <h3 class="text-center">{{ __('home.Order Management') }}</h3>
    <form action="{{route('view.admin.orders.index')}}" method="get">
        <div class="card-body d-flex align-items-end flex-wrap p-0 pb-3">
            <div class="col-lg-3 col-md-6 col-12 px-1">
                <lable>Từ khóa</lable>
                <input type="text" class="form-control" name="key_search" placeholder="Tìm kiếm..." value="{{request()->get('key_search')}}">
            </div>
            <div class="col-lg-2 col-md-4 col-6 px-1">
                <lable>Trạng thái</lable>
                <select class="form-select w-100" name="status" >
                    <option class="bg-white" value="">--Trạng thái--</option>
                    <option class="bg-white" @if(request()->get('status') == 'ASSIGNING') selected @endif value="ASSIGNING">ASSIGNING</option>
                    <option class="bg-white" @if(request()->get('status') == 'ACCEPTED') selected @endif value="ACCEPTED">ACCEPTED</option>
                    <option class="bg-white" @if(request()->get('status') == 'IN PROCESS') selected @endif value="IN PROCESS">IN PROCESS</option>
                    <option class="bg-white" @if(request()->get('status') == 'COMPLETED') selected @endif value="COMPLETED">COMPLETED</option>
                    <option class="bg-white" @if(request()->get('status') == 'CANCELED') selected @endif value="CANCELED">CANCELED</option>
                    <option class="bg-white" @if(request()->get('status') == 'REFUND') selected @endif value="REFUND">REFUND</option>
                </select>
            </div>
            <div class="col-lg-2 col-md-4 col-6 px-1">
                <lable>Thời gian mua hàng</lable>
                <div class="position-relative">
                    <i class="bi bi-calendar4-week" style="position: absolute;top: 50%;transform: translateY(-50%);left: 10px"></i>
                    <input type="text" id="date_range" class="form-control" name="date_range" value="{{request()->get('date_range')}}" style="padding-left: 33px">
                </div>
            </div>
            <div class="col-md-4 col-12 px-0 mt-2">
                <button type="submit" class="btn btn-warning mx-2">Tìm kiếm</button>
                <a href="{{route('view.admin.orders.index')}}" class="btn btn-dark">Làm mới</a>
            </div>
        </div>
    </form>
    <br>
    <div class="table-responsive">
        <table class="table table-striped text-nowrap" id="tableOrderManagement">
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
                @if(count($orders)>0)
                    @foreach($orders as $key => $item)
                        <tr>
                            <th scope="row">{{$key + 1}}</th>
                            <td>{{$item->full_name}}</td>
                            <td>{{$item->email}}</td>
                            <td>{{$item->phone}}</td>
                            <td>{{$item->address}}</td>
                            <td>{{number_format($item->total_price)}}</td>
                            <td>{{number_format($item->shipping_price)}}</td>
                            <td>{{number_format($item->discount_price)}}</td>
                            <td>{{number_format($item->total)}}</td>
                            <td>{{$item->order_method}}</td>
                            <td>{{$item->status}}</td>
                            <td>
                                <a href="{{route('view.admin.orders.detail',$item->id)}}" class="btn btn-success" >{{ __('home.Detail') }}</a>
                                <button type="button" class="btn btn-danger" id="btnDelete" onclick="confirmDeleteOrder({{$item->id}})">{{ __('home.Delete') }}</button>
                            </td>
                        </tr>
                        @endforeach
                    @endif
            </tbody>
        </table>
        <div class="d-flex justify-content-center align-items-center mt-3">
            {{ $orders->links() }}
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <script src="https://js.pusher.com/7.0/pusher.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/laravel-echo@1.11.2/dist/echo.iife.js"></script>
    <script>
        var pushers = new Pusher('3ac4f810445d089829e8', {
            cluster: 'ap1',
            encrypted: true
        });

        var channels = pushers.subscribe('aha-move-events');
        channels.bind('aha-move-events', function(data) {
            let currentUserId = "{{\Illuminate\Support\Facades\Auth::id()}}";
            if (data.user_shop == currentUserId){
                function sendNotifications(title, options) {
                    if (Notification.permission === "granted") {
                        new Notification(title, options);
                    }
                }
                function requestNotificationPermissions() {
                    if (Notification.permission === "granted") {
                        sendNotifications('Thông báo đã đơn hàng', { body: 'Trạng thái đơn hàng của '+data.full_name+' đã được thay đổi thành '+data.status });
                    } else if (Notification.permission !== "denied") {
                        Notification.requestPermission().then(permission => {
                            if (permission === "granted") {
                                sendNotifications('Thông báo đơn hàng', { body: 'Trạng thái đơn hàng của '+data.full_name+' đã được thay đổi thành '+data.status });
                            }
                        });
                    }
                }
                requestNotificationPermissions();
            }

        });

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

        $(function() {
            $('#date_range').on('focus', function() {
                $('#date_range').daterangepicker({
                    locale: {
                        format: 'YYYY-MM-DD',
                        applyLabel: "Apply",
                        cancelLabel: "Cancel",
                        customRangeLabel: "Custom Range"
                    },
                    ranges: {
                        'Hôm nay': [moment(), moment()],
                        'Hôm qua': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                        '7 Ngày trước': [moment().subtract(6, 'days'), moment()],
                        '30 Ngày trước': [moment().subtract(29, 'days'), moment()],
                        'Tháng này': [moment().startOf('month'), moment().endOf('month')],
                        'Tháng trước': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                    },
                    opens: 'left'
                });
            });
        });
    </script>
@endsection
