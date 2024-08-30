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
    <link href="{{ asset('css/listbooking.css') }}" rel="stylesheet">
    <div>
        <h1 class="h3 mb-2 text-gray-800" style="font-weight: bold">Thông tin người khám</h1>
        <div class="d-flex align-items-center">
            <p class="mb-2" style="font-weight: bold">Khách hàng: </p>
            <p class="mb-2 ml-3" style="font-weight: bold">{{$user->name}}</p>
        </div>
        <div class="d-flex align-items-center">
            <p style="font-weight: bold">Số điện thoại: </p>
            <p class="ml-3" style="font-weight: bold">{{$user->phone}}</p>
        </div>
    </div>
    <form action="{{route('homeAdmin.list.booking.history',$id)}}" method="get">
        <div class="card-body d-flex align-items-end flex-wrap p-0 pb-3">
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
            <button type="submit" class="btn btn-warning mx-3 text-search-booking" name="excel" value="1">Tìm kiếm</button>
            <a href="{{route('homeAdmin.list.booking.history',$id)}}" class="btn btn-dark mr-3">Làm mới</a>
        </div>
    </form>
    <div class="table-responsive">
        <table class="table table-striped text-nowrap" id="tableBooking">
            <thead>
            <tr>
                <th scope="col">Stt</th>
                <th scope="col">Ngày/giờ khám</th>
                <th scope="col">Nơi khám</th>
                <th scope="col">Chuyên khoa</th>
                <th scope="col">Tên bác sĩ</th>
                <th scope="col">Đơn thuốc</th>
                <th scope="col">Kết quả khám</th>
            </tr>
            </thead>
            <tbody>
            @foreach($listData as $index => $item)
                <tr>
                    <th scope="row">{{ $index + 1 }}</th>
                    <td>
                        {{$item->check_in}}
                    </td>
                    <td>
                        @php
                            $clinic = \App\Models\Clinic::where('id',$item->clinic_id)->pluck('name')->first();
                        @endphp
                        {{$clinic}}
                    </td>
                    @php
                        $doctor = \App\Models\User::find($item->doctor_id);
                        $department = \App\Models\Department::find($item->department_id);
                    @endphp
                    <td>{{$department ? $department->name : ''}}</td>
                    <td>{{$doctor ? $doctor->username : ''}}</td>
                    <td >
                        <div class="d-flex justify-content-center">
                            <a data-toggle="modal"
                               data-target="#modal-don-thuoc-{{$index}}"><img src="{{asset('img/kq-kham.png')}}" alt=""></a>
                        </div>
                    </td>
                    <td >
                        <div class="d-flex justify-content-center">
                            @if (isset($item->extend['booking_results']))
                                <a href="{{ route('web.users.booking.result', ['id' => $item->id]) }}" target="_blank" class="btn btn-success me-2"><i class="fa-regular fa-eye"></i></a>
                            @else
                                Chưa có kết quả khám
                            @endif
                        </div>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <div class="d-flex justify-content-center align-items-center">
            {{ $listData->links() }}
        </div>
    </div>

    @foreach($listData as $index => $val)
        <div class="modal fade" id="modal-don-thuoc-{{$index}}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Thông tin đơn thuốc</h1>
                        <button type="button" class="btn-close"  data-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        @if(isset($val->product) && count($val->product)>0)
                        <div class="table-responsive">
                            <table class="table table-striped text-nowrap" id="tableBooking">
                                <thead>
                                <tr>
                                    <th scope="col">Stt</th>
                                    <th scope="col">Sản phẩm</th>
                                    <th scope="col">Số lượng</th>
                                    <th scope="col">Số ngày điều trị</th>
                                    <th scope="col">Lưu ý</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($val->product as $index => $item)
                                    <tr>
                                        <th scope="row">{{ $index + 1 }}</th>
                                        <td>
                                            {{$item['medicine_name']}}
                                        </td>
                                        <td>
                                            <p class="text-center">{{$item['quantity']}}</p>
                                        </td>
                                        <td><p class="text-center">{{$item['treatment_days']}}</p></td>
                                        <td>{{$item['note']}}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        @else
                            <p style="color: red;text-align: center">Không có đơn thuốc nào</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
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
