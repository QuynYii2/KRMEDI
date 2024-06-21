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
                                        <td>{{$item['detail_value']}}</td>
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
@endsection
