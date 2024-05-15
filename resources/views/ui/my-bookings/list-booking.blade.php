@extends('layouts.admin')
@section('title')
    {{ __('home.List Booking') }}
@endsection
@section('page-style')
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
@endsection
@section('main-content')
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">{{ __('home.List Booking') }}</h1>
    <link href="{{ asset('css/listbooking.css') }}" rel="stylesheet">
    <form action="{{route('web.users.my.bookings.list')}}" method="get">
    <div class="card-body d-flex align-items-center flex-wrap p-0 pb-3">
        <div class="col-lg-3 col-md-6 col-12 px-1">
            <lable>Từ khóa</lable>
            <input type="text" class="form-control" name="key_search" placeholder="Tìm kiếm..." value="{{request()->get('key_search')}}">
        </div>
        <div class="col-lg-3 col-md-6 col-6 px-1">
            <lable>Chuyên khoa</lable>
            <select class="form-select w-100" name="specialist" >
                <option class="bg-white" value="">--Chuyên khoa--</option>
                @foreach($department as $departments)
                    <option class="bg-white" value="{{$departments->id}}" @if(request()->get('specialist') == $departments->id) selected @endif>{{$departments->name}}</option>
                    @endforeach
            </select>
        </div>
        <div class="col-lg-2 col-md-4 col-6 px-1">
            <lable>Dịch vụ</lable>
            <select class="form-select w-100" name="service" >
                <option class="bg-white" value="">--Dịch vụ--</option>
                @foreach($service as $services)
                <option class="bg-white" value="{{$services->id}}" @if(request()->get('service') == $services->id) selected @endif>{{$services->name}}</option>
                    @endforeach
            </select>
        </div>
        <div class="col-lg-2 col-md-4 col-6 px-1">
            <lable>Trạng thái</lable>
            <select class="form-select w-100" name="status" >
                <option class="bg-white" value="">--Trạng thái--</option>
                <option class="bg-white" @if(request()->get('status') == 'APPROVED') selected @endif value="APPROVED">APPROVED</option>
                <option class="bg-white" @if(request()->get('status') == 'PENDING') selected @endif value="PENDING">PENDING</option>
                <option class="bg-white" @if(request()->get('status') == 'COMPLETE') selected @endif value="COMPLETE">COMPLETE</option>
                <option class="bg-white" @if(request()->get('status') == 'CANCEL') selected @endif value="CANCEL">CANCEL</option>
            </select>
        </div>
        <div class="col-lg-2 col-md-4 col-6 px-1">
            <lable>Thời gian khám</lable>
            <div class="position-relative">
                <i class="bi bi-calendar4-week" style="position: absolute;top: 50%;transform: translateY(-50%);left: 10px"></i>
                <input type="text" id="date_range" class="form-control" name="date_range" value="{{request()->get('date_range')}}" style="padding-left: 33px">
            </div>
        </div>
    </div>
    <div class="d-flex align-items-center justify-content-between mb-3">
        <div class="d-flex align-items-center">
            <button type="submit" class="btn btn-warning mr-3" name="excel" value="1">Tìm kiếm</button>
            <a href="{{route('web.users.my.bookings.list')}}" class="btn btn-dark">Làm mới</a>
        </div>
        <button type="submit" class="btn btn-info" name="excel" value="2">Xuất Excel</button>
    </div>
    </form>
    <div class="">
        <table class="table table-striped" id="tableBooking">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">{{ __('home.clinics') }}</th>
                <th scope="col">{{ __('home.giờ vào') }}</th>
                <th scope="col">{{ __('home.dịch vụ') }}</th>
                <th scope="col">{{ __('home.Trạng thái') }}</th>
                <th scope="col">{{ __('home.Thao tác') }}</th>
            </tr>
            </thead>
            <tbody>
            @foreach($bookings as $item)
                <tr>
                    <th scope="row">{{ $loop->index + 1 }}</th>
                    <td>@php
                            $clinic = \App\Models\Clinic::where('id',$item->clinic_id)->pluck('name')->first();
                        @endphp
                        {{$clinic}}
                    </td>
                    <td>{{$item->check_in}} </td>
                    @php
                        $service_name = explode(',', $item->service);
                        $services = \App\Models\ServiceClinic::whereIn('id', $service_name)->get();
                        $service_names = $services->pluck('name')->implode(', ');
                    @endphp
                    <td>{{$service_names}}</td>
                    <td>{{$item->status}}</td>
                    <td class="d-flex">
                        <form action="{{ route('web.users.my.bookings.detail', $item->id) }}" method="get">
                            <button type="submit" class="btn btn-primary">
                                <i class="fa-solid fa-eye"></i>
                            </button>
                        </form>
                        <form action="{{ route('web.users.my.bookings.generate', $item->id) }}" method="get">
                            <button type="submit" class="btn btn-success">
                                <i class="fa-solid fa-qrcode"></i>
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <div class="d-flex justify-content-center align-items-center">
            {{ $bookings->links() }}
        </div>
    </div>
@endsection
@section('page-script')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <script>
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
