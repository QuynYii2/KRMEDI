@extends('layouts.admin')
@section('title')
    {{ __('home.Detail') }}
@endsection
@section('main-content')
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">{{ __('home.Booking Detail') }}</h1>
    <div class="container-fluid">
        <div class="row">
            @php
                $clinic = \App\Models\Clinic::find($booking->clinic_id);
            @endphp
            <div class="form-group col-md-6">
                <label for="clinic_id">Tên phòng khám / Bệnh viện</label>
                <input disabled type="text" class="form-control" id="clinic_id"
                       value="{{ $clinic ? $clinic->name : '' }}">
            </div>
            <div class="form-group col-md-3">
                <label for="check_in">Giờ vào</label>
                <input disabled type="text" class="form-control" id="check_in"
                       value="{{ \Carbon\Carbon::parse($booking->check_in)->format('s:i:H d-m-Y') }}">
            </div>
            <div class="form-group col-md-3">
                <label for="check_out">Giờ ra</label>
                <input disabled type="text" class="form-control" id="check_out"
                       value="{{ \Carbon\Carbon::parse($booking->check_out)->format('s:i:H d-m-Y') }}">
            </div>
        </div>
        @php
            $department = \App\Models\Department::find($booking->department_id);
            $doctor = \App\Models\User::find($booking->doctor_id);
        @endphp
        <div class="row">
            <div class="form-group col-md-6">
                <label for="department_id">Chuyên khoa</label>
                <input disabled type="text" class="form-control" id="department_id" value="{{ $department->name ?? "" }}">
            </div>
            <div class="form-group col-md-6">
                <label for="doctor_id">Bác sĩ</label>
                <input disabled type="text" class="form-control" id="doctor_id" value="{{ $doctor->username ?? "" }}">
            </div>
        </div>
        @if($booking->member_family_id == null)
        <div class="form-group">
            <label for="medical_history">Lịch sử bệnh</label>
            <input disabled type="text" class="form-control" id="medical_history"
                   value="{!! strip_tags(\Illuminate\Support\Facades\Auth::user()->medical_history)  !!}">
        </div>
        @endif
        <div class="row">
            <div class="form-group col-md-4">
                <label for="status">Trạng thái</label>
                <input disabled type="text" class="form-control" id="status" value="{{ $booking->status }}">
            </div>
            @if($booking->member_family_id)
                @php
                    $family = \App\Models\FamilyManagement::find($booking->member_family_id);
                @endphp

                <div class="form-group col-md-4">
                    <label for="member_family_id">Người thân</label>
                    <input disabled type="text" class="form-control" id="member_family_id" value="{{ $family->name }}">
                </div>
            @endif
        </div>
        @if(count($data_product)>0)
            <h5>Danh sách đơn thuốc</h5>
            <form id="form" action="{{ route('web.users.my.bookings.add-cart', $booking->id) }}" method="post"
                  enctype="multipart/form-data">
                @csrf
            @foreach($data_product as $index => $pro)
                <div class=" d-flex align-items-center justify-content-between border p-3">
                    <div class="prescription-group d-flex align-items-center">
                        <div class="row w-100">
                            <div class="form-group">
                                <label for="medicine_name">Medicine Name</label>
                                <input type="text" class="form-control medicine_name " name="medicines[{{$index}}][medicine_name]" value="{{$pro['medicine_name']}}" readonly>
                                <input type="text" hidden class="form-control medicine_id_hidden" name="medicines[{{$index}}][medicine_id_hidden]" value="{{$pro['medicine_id_hidden']}}">
                            </div>
                            <div class="form-group">
                                <label for="medicine_ingredients">Medicine Ingredients</label>
                                <input type="text" class="form-control medicine_ingredients " name="medicines[{{$index}}][medicine_ingredients]"  value="{{$pro['medicine_ingredients']}}">
                            </div>
                            <div class="form-group">
                                <label for="quantity">{{ __('home.Quantity') }}</label>
                                <input type="number" min="1" class="form-control quantity" value="{{$pro['quantity']}}" name="medicines[{{$index}}][quantity]" readonly>
                            </div>
{{--                            <div class="form-group">--}}
{{--                                <label for="detail_value">Note</label>--}}
{{--                                <input type="text" class="form-control note" value="{{$pro['note']}}" name="medicines[{{$index}}][note]" readonly>--}}
{{--                            </div>--}}
{{--                            <div class="form-group">--}}
{{--                                <label for="treatment_days">Số ngày điều trị</label>--}}
{{--                                <input type="number" min="1" class="form-control treatment_days" readonly name="medicines[{{$index}}][treatment_days]" value="{{$pro['treatment_days']}}">--}}
{{--                            </div>--}}
                            <div class="form-group">
                                <label for="detail_value">Thời gian uống</label>
                                <select class="form-control detail_value" multiple style="height: 155px;" readonly="">
                                    <option value="1" @if(in_array(1, $pro['note_date'])) selected @endif>Trước ăn sáng</option>
                                    <option value="2" @if(in_array(2, $pro['note_date'])) selected @endif>Sau ăn sáng</option>
                                    <option value="3" @if(in_array(3, $pro['note_date'])) selected @endif>Trước ăn trưa</option>
                                    <option value="4" @if(in_array(4, $pro['note_date'])) selected @endif>Sau ăn trưa</option>
                                    <option value="5" @if(in_array(5, $pro['note_date'])) selected @endif>Trước ăn tối</option>
                                    <option value="6" @if(in_array(6, $pro['note_date'])) selected @endif>Sau ăn tối</option>
                                </select>
                            </div>
                            <div class="d-flex">
                                <div class="form-group w-50 mr-2">
                                    <label for="treatment_days">Ngày bắt đầu điều trị</label>
                                    <input type="date" class="form-control treatment_days" value="{{$pro['date_start']}}" readonly>
                                </div>
                                <div class="form-group w-50">
                                    <label for="treatment_days">Ngày kết thúc điều trị</label>
                                    <input type="date" class="form-control treatment_days" value="{{$pro['date_end']}}" readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
                <button type="submit" class="btn btn-primary mt-4">Mua hàng</button>
                </form>
            <a href="{{route('web.users.my.bookings.prescription-download',$booking->id)}}" class="btn btn-success mt-3">Tải đơn thuốc</a>
        @endif
        @if($booking->prescription_file)
            <div class="mb-3 mt-3">
                <a href="{{ asset($booking->prescription_file) }}"
                   class="btn btn-success"
                   download>
                    Tải xuống đơn thuốc dạng PDF
                </a>
            </div>
        @endif
        <div class="form-group ms-4 mt-4">
            <input disabled class="form-check-input" {{ $booking->is_result == 1 ? 'checked' : '' }} type="checkbox"
                   id="is_result">
            <label class="form-check-label" for="is_result">
                Result
            </label>
        </div>
        @if($booking->status == \App\Enums\BookingStatus::CANCEL)
            <div class="form-group">
                <label for="reason_cancel">Reason Cancel</label>
                <input disabled type="text" class="form-control" id="reason_cancel"
                       value="{{ $booking->reason_cancel }}">
            </div>
        @endif
        @if($booking->is_result == 1 && $booking->status == \App\Enums\BookingStatus::COMPLETE)
            <div class="d-flex align-items-center justify-content-start w-50">
                <a target="_blank" href="{{ route('web.users.booking.result', ['id' => $booking->id]) }}" class="btn btn-primary">
                    View result
                </a>
            </div>
        @endif
    </div>
@endsection
