@extends('layouts.admin')
@section('title')
    {{ __('home.List Booking') }}
@endsection
@section('page-style')
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <style>
        @media (max-width: 767px) {
            .line-fillter-user{
                margin-bottom: 15px;
            }
            .text-search-booking{
                margin-left: 0px!important;
            }
        }
    </style>
@endsection
@section('main-content')
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">{{ __('home.List Booking') }}</h1>
{{--    <div class="d-flex align-items-center justify-content-start">--}}
{{--        <div class="mb-3 col-md-3">--}}
{{--            <input class="form-control" id="inputSearchBooking" type="text" placeholder="Search.."/>--}}
{{--        </div>--}}
{{--    </div>--}}
    @php
        $role_id = \App\Models\RoleUser::where('user_id',\Illuminate\Support\Facades\Auth::id())->first();
        $role_name = \App\Models\Role::find($role_id->role_id);
    @endphp
    @if($role_name->name != 'DOCTORS')
    <form action="{{route('homeAdmin.list.booking')}}" method="get">
        @else
            <form action="{{route('homeAdmin.list.booking.doctor')}}" method="get">
                @endif
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
{{--                    <option class="bg-white" @if(request()->get('status') == 'DELETE') selected @endif value="DELETE">DELETE</option>--}}
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
        <div class="d-flex align-items-end flex-wrap mb-3">
                <div class="col-lg-3 col-md-5 col-12 px-1 line-fillter-user">
                    <lable>Người khám bệnh</lable>
                    <select class="form-select w-100" name="user_id" >
                        <option class="bg-white" value="">--Tên người khám--</option>
                        @foreach($users as $user)
                            <option class="bg-white" value="{{$user->id}}" @if(request()->get('user_id') == $user->id) selected @endif>{{$user->name}}</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="btn btn-warning mx-3 text-search-booking" name="excel" value="1">Tìm kiếm</button>
                @if($role_name->name != 'DOCTORS')
                <a href="{{route('homeAdmin.list.booking')}}" class="btn btn-dark mr-3">Làm mới</a>
                    @else
                    <a href="{{route('homeAdmin.list.booking.doctor')}}" class="btn btn-dark mr-3">Làm mới</a>
                @endif
            <button type="submit" class="btn btn-info" name="excel" value="2">Xuất Excel</button>
        </div>
    </form>
    <br>
    <link href="{{ asset('css/listbooking.css') }}" rel="stylesheet">
    <div class="table-responsive">
        <table class="table table-striped text-nowrap" id="tableBooking">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">{{ __('home.Người đăng ký') }}</th>
                <th scope="col">{{ __('home.clinics') }}</th>
                <th scope="col">{{ __('home.giờ vào') }}</th>
                <th scope="col">{{ __('home.Department') }}</th>
                <th scope="col">{{ __('home.Doctor Name') }}</th>
                <th scope="col">{{ __('home.Trạng thái') }}</th>
                <th scope="col">{{ __('home.Thao tác') }}</th>
            </tr>
            </thead>
            <tbody>
            @foreach($bookings as $item)
                <tr>
                    <th scope="row">{{ $loop->index + 1 }}</th>
                    <td>
                        @php
                            $user_name = \App\Models\User::find($item->user_id);
                        @endphp
                        {{$user_name->name}}
                        <br>
                        <a href="{{route('homeAdmin.list.booking.history',$item->user_id)}}" target="_blank" class="d-inline-block mt-2">Chi tiết lịch sử</a>
                    </td>
                    <td>
                        @php
                            $clinic = \App\Models\Clinic::where('id',$item->clinic_id)->pluck('name')->first();
                        @endphp
                        {{$clinic}}
                    </td>
                    <td>{{$item->check_in}} </td>
                    @php
                        $doctor = \App\Models\User::find($item->doctor_id);
                        $department = \App\Models\Department::find($item->department_id);
                    @endphp
                    <td>{{$department ? $department->name : ''}}</td>
                    <td>{{$doctor ? $doctor->username : ''}} - {{$doctor ? $doctor->email : ''}}</td>
                    <td>{{$item->status}}</td>
                    <td class="d-flex">
                        {{--                        <form action="{{ route('web.booking.result.list', $item->id) }}" method="get">--}}
                        {{--                            <button type="submit" class="btn btn-secondary">--}}
                        {{--                                <i class="fa-solid fa-eye"></i>--}}
                        {{--                            </button>--}}
                        {{--                        </form>--}}
                        <form action="{{route('api.backend.booking.edit',$item->id)}}" method="get">
                            <button type="submit" class="btn btn-primary">
                                @if($role_name->name != 'DOCTORS')
                                <i class="fa-solid fa-pen-to-square"></i>
                                @else
                                <i class="bi bi-eye-fill"></i>
                                    @endif
                            </button>
                        </form>
                        @if($role_name->name != 'DOCTORS')
                        <form action="{{route('api.backend.booking.delete',$item->id)}}" method="post">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="ml-3 btn btn-primary btn-danger">
                                <i class="fa-regular fa-trash-can"></i>
                            </button>
                        </form>
                            @endif
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <div class="d-flex justify-content-center align-items-center">
            {{ $bookings->links() }}
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        @if(session('error'))
        Swal.fire({
            icon: 'error',
            title: 'Permission Denied',
            text: '{{ session('error') }}',
        });
        @endif
        $(document).ready(function () {
            searchMain('inputSearchBooking', 'tableBooking');
        })
    </script>
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
