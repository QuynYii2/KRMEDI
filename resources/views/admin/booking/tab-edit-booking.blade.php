@extends('layouts.admin')
@section('title')
    {{ __('home.Edit') }}
@endsection
@section('page-style')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet"/>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css"/>
    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css"/>
    <style>
        .spinner {
            border: 2px solid rgba(0, 0, 0, 0.1);
            border-left-color: #000;
            border-radius: 50%;
            width: 16px;
            height: 16px;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }
            100% {
                transform: rotate(360deg);
            }
        }

    </style>
@endsection
@section('main-content')
    @php
        use Illuminate\Support\Facades\Auth;
        use App\Enums\online_medicine\ObjectOnlineMedicine;
    @endphp
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3  text-gray-800">{{ __('home.List Booking') }}</h1>
            <a href="{{route('api.backend.booking.create.item',$dataBooking->id)}}" class="btn btn-success">Trả kết
                quả</a>
        </div>

        @foreach($bookings_edit as $value)
            <form id="form" action="{{ route('api.backend.booking.update', $value->id) }}" method="post"
                  class="mb-5 pb-4" style="border-bottom: 1px solid black"
                  enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <input type="text" class="form-control" name="type" value="{{$value->type}}" hidden>
                    <div class="col-md-3 form-group">
                        <label for="user">{{ __('home.Tên người đăng ký') }}</label>
                        @php
                            $user_name = \App\Models\User::where('id', $value->user_id)->value('name');
                        @endphp
                        <input type="text" class="form-control" id="user" name="user" value="{{ $user_name }}"
                               disabled>
                    </div>
                    <div class="col-md-3 form-group">
                        <label for="clinic_id">{{ __('home.BusinessName') }}</label>
                        @php
                            $clinic_name = \App\Models\Clinic::where('id', $value->clinic_id)->value('name');
                        @endphp
                        <input type="text" class="form-control" id="user" name="clinic_id" value="{{ $clinic_name }}"
                               disabled>
                    </div>
                    <div class="col-md-3 form-group">
                        <label for="department_id">{{ __('home.Department') }}</label>
                        @php
                            $department = \App\Models\Department::find($value->department_id);
                            $listDepartment = \App\Models\Department::where('status','ACTIVE')->get();
                        @endphp
                        {{--                    @if($department)--}}
                        {{--                        <input type="text" class="form-control" id="departments_id" name="departments_id"--}}
                        {{--                               value="{{ $department ? $department->id : '' }}" hidden>--}}
                        {{--                    <input type="text" class="form-control"--}}
                        {{--                        value="{{ $department ? $department->name : '' }}" disabled>--}}
                        {{--                        @else--}}
                        <select class="form-select" id="departments_id" name="departments_id"
                                @if($isDoctor) disabled @endif>
                            @foreach($listDepartment as $item_department)
                                <option value="{{ $item_department->id }}"
                                        @if($item_department->id == $value->department_id) selected @endif>{{ $item_department->name }}</option>
                            @endforeach
                        </select>
                        {{--                    @endif--}}
                    </div>
                    <div class="col-md-3 form-group">
                        <label for="doctor_id">{{ __('home.Doctor Name') }}</label>
                        @php
                            $doctor = \App\Models\User::where('id', $value->doctor_id)->first();
                            $doctor_info = '';
                            if ($doctor) {
                                $doctor_info = $doctor->username . '-' . $doctor->email;
                            }
                        @endphp
                        {{--                    <input type="text" class="form-control" id="doctor_id" name="doctor_id" value="{{ $doctor_info }}"--}}
                        {{--                        disabled>--}}
                        <select class="form-select" id="doctor_id" name="doctor_id" @if($isDoctor) disabled @endif>
                            <option value="">Bác sĩ phụ trách</option>
                            @foreach($value->list_doctor as $item_doctor)
                                <option value="{{ $item_doctor->id }}"
                                        @if($item_doctor->id == $value->doctor_id) selected @endif>{{ $item_doctor->name??$item_doctor->username }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3 form-group">
                        <label for="check_in">{{ __('home.Thời gian bắt đầu') }}</label>
                        <input disabled type="datetime-local" class="form-control" id="check_in" name="check_in"
                               value="{{ $value->check_in }}">
                    </div>
                    <div class="col-md-3 form-group">
                        <label for="check_out">{{ __('home.Thời gian kết thúc') }}</label>
                        <input disabled type="datetime-local" class="form-control" id="check_out" name="check_out"
                               value="{{ $value->check_out }}">
                    </div>
                    <div class="booking-item d-flex w-auto" data-booking-id="{{ $value->id }}">
                        <div class="col-md-12 form-group">
                            <label for="booking_status">{{ __('home.Trạng thái') }}</label>
                            <select class="form-select booking_status" id="booking_status_{{$value->id}}" name="status">
                                <option value="{{ \App\Enums\BookingStatus::PENDING }}"
                                    {{ $value->status === \App\Enums\BookingStatus::PENDING ? 'selected' : '' }}>
                                    {{ \App\Enums\BookingStatus::PENDING }}
                                </option>
                                <option value="{{ \App\Enums\BookingStatus::COMPLETE }}"
                                    {{ $value->status === \App\Enums\BookingStatus::COMPLETE ? 'selected' : '' }}>
                                    {{ \App\Enums\BookingStatus::COMPLETE }}
                                </option>
                                <option value="{{ \App\Enums\BookingStatus::APPROVED }}"
                                    {{ $value->status === \App\Enums\BookingStatus::APPROVED ? 'selected' : '' }}>
                                    {{ \App\Enums\BookingStatus::APPROVED }}
                                </option>
                                <option value="{{ \App\Enums\BookingStatus::CANCEL }}"
                                    {{ $value->status === \App\Enums\BookingStatus::CANCEL ? 'selected' : '' }}>
                                    {{ \App\Enums\BookingStatus::CANCEL }}
                                </option>
                            </select>
                        </div>
                        <div class=" col-md-12 form-group mt-4">
                            <label for="services"></label>
                            <input type="checkbox" name="is_result" {{ $value->is_result == 1 ? 'checked' : '' }}
                            class="is_result" id="is_result_{{ $value->id }}" value="1">
                            <label for="is_result">{{ __('home.Result') }}</label>
                            @if (isset(Auth::user()->extend['isActivated']) && Auth::user()->extend['isActivated'])
                                @if (
                                    $value->is_result == 1 &&
                                        $value->status === \App\Enums\BookingStatus::COMPLETE &&
                                        $user_zalo_id != 0)
                                    <a href="{{ route('admin.send.booking.result', ['id' => $value->id, 'userId' => $user_zalo_id]) }}"
                                       class="btn btn-outline-dark ms-5">Gửi thông báo qua zalo</a>
                                @endif
                            @endif
                        </div>
                    </div>
                </div>
                <div class="row d-flex flex-wrap">
                    <div class="col-6 form-group">
                        <label for="service">Dịch vụ</label>
                        <input type="text" class="form-control" id="service" value="{{ $value->name_service }}" disabled>
                    </div>
                    <div class="col-6 form-group">
                        <label for="service">Thành tiền</label>
                        <input type="text" class="form-control" id="service" value="{{ number_format($value->total_service) }} VND" disabled>
                    </div>
                </div>
                <div class="row" id="showReasonCancel_{{$value->id}}">
                    @if($value->reason_cancel)
                        <label for="reason_text">Lí do hủy: </label>
                        <input type="text" class="form-control" id="reason_text" disabled
                               value="{{ $value->reason_cancel }}">
                    @endif
                </div>

                {{-- @if ($bookings_edit->is_result == 1 && $bookings_edit->status === \App\Enums\BookingStatus::COMPLETE) --}}
                <div id="trackFile_{{$value->id}}" style="display: none;">
                    <div id="repeater_{{$value->id}}">
                        <div data-repeater-list="booking_result_list">
                            @forelse ($value->repeaterItems as $index => $item)
                                <div class="d-flex align-items-center row" data-repeater-item>
                                    <div class="col-md-1">
                                        <button type="button" data-repeater-delete class="btn btn-danger mt-3"><i
                                                class="fa-solid fa-x"></i></button>
                                    </div>
                                    <div class="col-md-3 firstSelector">
                                        <div class="form-group">
                                            <label for="selectType{{ $index }}">Loại khám bệnh:</label>
                                            <select id="selectType{{ $index }}" class="form-control selectType"
                                                    name="select">
                                                @foreach($departments as $item_departments)
                                                    <option value="{{$item_departments->name}}"
                                                        {{ $item['selectValue'] === $item_departments->name ? 'selected' : '' }}>
                                                        {{$item_departments->name}}</option>
                                                @endforeach
                                                {{--                                                <option value="Khám bệnh"--}}
                                                {{--                                                    {{ $item['selectValue'] === 'Khám bệnh' ? 'selected' : '' }}>--}}
                                                {{--                                                    Khám bệnh</option>--}}
                                                {{--                                            <option value="Siêu âm"--}}
                                                {{--                                                {{ $item['selectValue'] === 'Siêu âm' ? 'selected' : '' }}>--}}
                                                {{--                                                Siêu--}}
                                                {{--                                                âm</option>--}}
                                                {{--                                            <option value="XQuang"--}}
                                                {{--                                                {{ $item['selectValue'] === 'XQuang' ? 'selected' : '' }}>--}}
                                                {{--                                                XQuang--}}
                                                {{--                                            </option>--}}
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3 select2Div">
                                        <div class="form-group">
                                            <label for="in_charged_{{ $index }}">Bác sĩ phụ trách:</label>
                                            <select id="in_charged_{{ $index }}" class="form-select doctor_selector"
                                                    name="doctor_id">
                                                @if ($item['doctorId'] && $item['doctorName'])
                                                    <option value="{{ $item['doctorId'] }}">{{ $item['doctorName'] }}
                                                    </option>
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="file">Tài liệu khám bệnh:</label>
                                            <input type="file" name="file" class="form-control-file"
                                                   accept=".pdf, .jpg, .jpeg, .png, .gif">
                                            <input type="hidden" name="file_urls" value="{{ $item['fileUrl'] }}">
                                        </div>
                                    </div>
                                    @if (Storage::exists(str_replace('/storage', 'public', $item['fileUrl'])))
                                        <div class="col-md-2 viewFile">
                                            <a target="_blank" href="{{ asset($item['fileUrl']) }}">Xem tài liệu
                                                khám</a>
                                        </div>
                                    @endif
                                </div>
                            @empty
                                <div class="d-flex align-items-center row" data-repeater-item>
                                    <div class="col-md-1">
                                        <button type="button" class="btn btn-danger mt-3" data-repeater-delete><i
                                                class="fa-solid fa-x"></i></button>
                                    </div>
                                    <div class="col-md-3 firstSelector">
                                        <div class="form-group">
                                            <label for="selectType">Select:</label>
                                            <select class="form-control selectType" name="select">
                                                @foreach($departments as $item_departments)
                                                    <option
                                                        value="{{$item_departments->name}}">{{$item_departments->name}}</option>
                                                @endforeach
                                                {{--                                            <option value="Khám bệnh">Khám bệnh</option>--}}
                                                {{--                                            <option value="Siêu âm">Siêu âm</option>--}}
                                                {{--                                            <option value="XQuang">XQuang</option>--}}
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3 select2Div">
                                        <div class="form-group">
                                            <label for="in_charged">Bác sĩ phụ trách:</label>
                                            <select class="form-select doctor_selector" name="doctor_id"></select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="file">Tài liệu khám bệnh:</label>
                                            <input type="file" name="file" class="form-control-file"
                                                   accept=".pdf, .jpg, .jpeg, .png, .gif">
                                        </div>
                                    </div>
                                </div>
                            @endforelse
                        </div>
                        {{--                    @if(!$isDoctor)--}}
                        <button data-repeater-create type="button" class="btn btn-primary" id="addBtn"><i
                                class="fa-solid fa-plus"></i></button>
                        {{--                        @endif--}}
                    </div>
                    </br>
                </div>
                {{-- @endif --}}

                <div class="mt-3">
                    <h5>Danh sách đơn thuốc</h5>
                    @if(isset($value->prescription_product)&&count($value->prescription_product)>0)
                        @foreach($value->prescription_product as $pro)
                            <div class=" d-flex align-items-center justify-content-between border p-3">
                                <div class="prescription-group d-flex align-items-center">
                                    <div class="row w-100">
                                        <div class="form-group">
                                            <label for="medicine_name">Medicine Name</label>
                                            <input type="text" class="form-control medicine_name "
                                                   value="{{$pro['medicine_name']}}" readonly>
                                        </div>
                                        <div class="form-group">
                                            <label for="medicine_ingredients">Medicine Ingredients</label>
                                            <input type="text" class="form-control medicine_ingredients " readonly
                                                   value="{{$pro['medicine_ingredients']}}">
                                        </div>
                                        <div class="form-group">
                                            <label for="quantity">{{ __('home.Quantity') }}</label>
                                            <input type="number" min="1" class="form-control quantity"
                                                   value="{{$pro['quantity']}}" readonly>
                                        </div>
                                        @if($pro['note'])
                                        <div class="form-group">
                                            <label for="detail_value">Note</label>
                                            <input type="text" class="form-control note" value="{{$pro['note']}}"
                                                   readonly>
                                        </div>
                                            @else
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
                                        @endif
                                        @if(isset($pro['date_start']) && isset($pro['date_end']))
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
                                            @else
                                            <div class="form-group">
                                                <label for="treatment_days">Số ngày điều trị</label>
                                                <input type="number" min="1" class="form-control treatment_days" readonly
                                                       value="{{$pro['treatment_days']}}">
                                            </div>
                                            @endif

                                    </div>
                                </div>
                            </div>
                        @endforeach
                        <a href="{{route('web.users.my.bookings.prescription-download',$value->id)}}"
                           class="btn btn-success mt-3">Tải đơn thuốc</a>
                    @endif
                    <div class="modal-body">
                        <div class="list-service-result-don-thuoc mt-2 mb-3" data-prescription-id="{{ $value->id }}">
                            <div id="list-service-result-don-thuoc-{{ $value->id }}">

                            </div>
                            @if(!$isDoctor)
                                <button type="button" class="btn btn-outline-primary mt-3 btn-add-medicine-loading"
                                        data-prescription-id="{{ $value->id }}">
                                    <span class="spinner-border spinner-border-sm" role="status"
                                          aria-hidden="true"></span>
                                    Đang tải...
                                </button>
                                <button type="button" class="btn btn-outline-primary mt-3 btn-add-medicine-booking"
                                        data-prescription-id="{{ $value->id }}" style="display:none;">
                                    Tạo đơn
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
                @if(empty($value->prescription_file))
                    @if(!$isDoctor)
                        <div class="mt-3">
                            <h5>Tải đơn thuốc lên</h5>
                            <input type="file" class="mt-2" name="prescription_file"
                                   accept=".pdf,.doc,.docx,.xls,.xlsx,.png,.jpg,.jpeg">
                        </div>
                    @endif
                @else
                    <div class="mb-3">
                        <a href="{{ asset($value->prescription_file) }}"
                           class="btn btn-success"
                           download>
                            Tải xuống đơn thuốc dạng PDF
                        </a>
                    </div>
                @endif

                {{--            @if(!$isDoctor)--}}
                <input type="text" name="services" id="services" class="form-control d-none">
                @if ($value->is_result == 1 && $value->status === \App\Enums\BookingStatus::COMPLETE)
                    @if (isset($value->extend['booking_results']))
                        <button type="button" class="btn btn-success mt-4 me-2"><i class="fa-regular fa-eye"
                                                                                   onclick="window.location.href = '{{ route('web.users.booking.result', ['id' => $value->id]) }}';"></i>
                        </button>
                    @endif
                @endif
                <div class="d-flex justify-content-center">
                    <button type="submit" class="btn btn-primary up-date-button mt-4">{{ __('home.Save') }}</button>
                </div>
                {{--                @endif--}}
            </form>
        @endforeach
    </div>

    <div class="modal fade" id="modal-add-medicine-widget-chat-booking" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl">
            <div class="modal-content">
                <div class="modal-header ">
                    <form class="row w-100">
                        <div class="col-sm-4">
                            <div class="form-group position-relative">
                                <label for="inputSearchNameMedicine" class="form-control-feedback"></label>
                                <input type="search" id="inputSearchNameMedicine"
                                       class="form-control handleSearchMedicine"
                                       placeholder="Tìm kiếm theo tên thuốc">
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group position-relative">
                                <label for="inputSearchDrugIngredient" class="form-control-feedback"></label>
                                <input type="search" id="inputSearchDrugIngredient"
                                       class="form-control handleSearchMedicine"
                                       placeholder="Tìm kếm theo thành phần thuốc">
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group position-relative">
                                <label for="inputSearchNameMedicine" class="form-control-feedback"></label>
                                <select class="form-select position-relative handleSearchMedicineChange"
                                        id="object_search"
                                >
                                    <option value="{{ \App\Enums\online_medicine\ObjectOnlineMedicine::KIDS }}">
                                        {{ __('home.For kids') }}</option>
                                    <option value="{{ ObjectOnlineMedicine::FOR_WOMEN }}">{{ __('home.For women') }}
                                    </option>
                                    <option
                                        value="{{ ObjectOnlineMedicine::FOR_MEN }}">{{ __('home.For men') }}</option>
                                    <option value="{{ ObjectOnlineMedicine::FOR_ADULT }}">{{ __('home.For adults') }}
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group position-relative">
                                <label for="inputSearchClinic" class="form-control-feedback"></label>
                                <input type="search" id="inputSearchClinic" class="form-control handleSearchMedicine"
                                       placeholder="Tìm kiếm theo nhà thuốc">
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-body find-my-medicine-2">
                    <div class="row" id="modal-list-medicine-widget-chat-booking">

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                </div>
            </div>
        </div>
    </div>

    {{-- Handle JS --}}
    <script src="{{ asset('js/jquery.repeater.js') }}"></script>
    <script>
        $(document).ready(function () {
            function showOrHidden(bookingId) {
                let value = $('#booking_status_' + bookingId).val();
                let html = `<div class="form-group">
                        <label for="reason_text_${bookingId}">Lí do hủy: </label>
                        <input type="text" class="form-control" id="reason_text_${bookingId}" name="reason_text" value="{{ $dataBooking->reason_cancel }}">
                        <p class="small text-danger mt-1" id="support_reason_${bookingId}">Vui lòng chọn/nhập lý do hủy</p>
                        <ul class="list-reason" style="list-style: none; padding-left: 0">`;

                @foreach ($reasons as $reason)
                    html += `<li class="new-select">
                        <input onchange="changeReason('${bookingId}');" class="reason_item"
                               value="{{ $reason }}"
                               id="reason_{{ $reason }}_${bookingId}"
                               name="reason_item_${bookingId}"
                               type="radio" {{ $reason == 'Other' ? 'checked' : '' }}>
                        <label for="reason_{{ $reason }}_${bookingId}">{{ $reason }}</label>
                    </li>`;
                @endforeach

                    html += `</ul></div>`;

                if (value === `{{ \App\Enums\BookingStatus::CANCEL }}`) {
                    $('#showReasonCancel_' + bookingId).empty().append(html);
                } else {
                    $('#showReasonCancel_' + bookingId).empty();
                }
            }

            // Gán sự kiện thay đổi cho từng trạng thái booking
            $(".booking_status").change(function () {
                let bookingId = $(this).closest('.booking-item').data('booking-id');
                showOrHidden(bookingId);
            });
        });

        function changeReason(bookingId) {
            let value = $('input[name="reason_item_' + bookingId + '"]:checked').val();
            if (value !== 'Other') {
                $('#support_reason_' + bookingId).addClass('d-none');
                $('#reason_text_' + bookingId).val(value).prop('disabled', false);
            } else {
                $('#support_reason_' + bookingId).removeClass('d-none');
                $('#reason_text_' + bookingId).val('').prop('disabled', false);
            }
        }
    </script>
    <script>
        let arrayService = [];
        let arrayNameService = [];

        function removeArray(arr) {
            var what, a = arguments,
                L = a.length,
                ax;
            while (L > 1 && arr.length) {
                what = a[--L];
                while ((ax = arr.indexOf(what)) !== -1) {
                    arr.splice(ax, 1);
                }
            }
            return arr;
        }

        function getListName(array, items) {
            for (let i = 0; i < items.length; i++) {
                if (items[i].checked) {
                    if (array.length == 0) {
                        array.push(items[i].nextElementSibling.innerText);
                    } else {
                        let name = array.includes(items[i].nextElementSibling.innerText);
                        if (!name) {
                            array.push(items[i].nextElementSibling.innerText);
                        }
                    }
                } else {
                    removeArray(array, items[i].nextElementSibling.innerText)
                }
            }
            return array;
        }

        function checkArray(array, listItems) {
            for (let i = 0; i < listItems.length; i++) {
                if (listItems[i].checked) {
                    if (array.length == 0) {
                        array.push(listItems[i].value);
                    } else {
                        let check = array.includes(listItems[i].value);
                        if (!check) {
                            array.push(listItems[i].value);
                        }
                    }
                } else {
                    removeArray(array, listItems[i].value);
                }
            }
            return array;
        }

        function getInputService() {
            let items = document.getElementsByClassName('service_item');

            arrayService = checkArray(arrayService, items);
            arrayNameService = getListName(arrayNameService, items)

            let listName = arrayNameService.toString();
            if (listName) {
                $('#service_text').val(listName);
            }

            arrayService.sort();
            let value = arrayService.toString();
            $('#services').val(value);
        }

        getInputService();

        let arrayService2 = [];
        let arrayNameService2 = [];

        function getInputServiceName() {
            let items = document.getElementsByClassName('service_name_item');

            arrayService2 = checkArray(arrayService2, items);
            arrayNameService2 = getListName(arrayNameService2, items)

            let listName = arrayNameService2.toString();
            if (listName) {
                $('#service_name').val(listName);
            }

            arrayService2.sort();
            let value = arrayService2.toString();
            $('#service_result').val(value);
        }

        // getInputServiceName();
    </script>
    <script>

        $(document).ready(function () {
            $(window).on('popstate', function () {
                location.reload();
            });

            $('.btnCreate').on('click', function () {
                createBookingResult();
            })

            $('.btnUnCreate').on('click', function () {
                unCreateBooking();
            })

            $('.btnGetFile').on('click', function () {
                let alertMessage =
                    `Vui lòng nhập vào file theo định dạng mẫu đã được viết sẵn! Chúng tôi không khuyến khích bất kì hành động thay đổi định dạng file hoặc cấu trúc dữ liệu trong file vì điều này sẽ ảnh hướng đến việc đọc hiểu dữ liệu.`
                if (confirm(alertMessage)) {
                    window.location.href = `{{ route('user.download') }}`;
                }
            })

            async function createBookingResult() {
                const formData = new FormData();

                const arrField = [
                    "booking_id", "user_id", "created_by", "status",
                ];

                const itemList = [
                    "result", "result_en", "result_laos", "service_result",
                ];

                let isValid = true
                /* Tạo fn appendDataForm ở admin blade */
                isValid = appendDataForm(arrField, formData, isValid);

                formData.append('family_member', $('#family_member').val());

                let my_array = [];

                let result_list = document.getElementsByClassName('result');
                let result_en_list = document.getElementsByClassName('result_en');
                let result_laos_list = document.getElementsByClassName('result_laos');
                let service_result_list = document.getElementsByClassName('service_result');

                let total_service = null;
                for (let j = 0; j < result_list.length; j++) {
                    let result = result_list[j].value;
                    let result_en = result_en_list[j].value;
                    let result_laos = result_laos_list[j].value;
                    let service_result = service_result_list[j].value;

                    if (!result || !result_en || !result_laos) {
                        isValid = false;
                    }

                    if (total_service) {
                        total_service = total_service + ',' + service_result;
                    } else {
                        total_service = service_result;
                    }

                    let item = {
                        result: result,
                        result_en: result_en,
                        result_laos: result_laos,
                        service_result: total_service,
                    }
                    item = JSON.stringify(item);
                    my_array.push(item);
                }

                let array_total = total_service.split(',');
                total_service = removeDuplicates(array_total).toString();

                itemList.forEach(item => {
                    if (item === 'service_result') {
                        formData.append(item, total_service);
                    } else {
                        formData.append(item, my_array.toString());
                    }
                });

                const fieldTextareaTiny = [
                    'detail', 'detail_en', 'detail_laos'
                ];

                fieldTextareaTiny.forEach(fieldTextarea => {
                    const content = tinymce.get(fieldTextarea).getContent();
                    formData.append(fieldTextarea, content);
                });

                let files_data = document.getElementById('files');
                let i = 0,
                    len = files_data.files.length,
                    img, reader, file;
                for (i; i < len; i++) {
                    file = files_data.files[i];
                    formData.append('files[]', file);
                }

                let excel_file = $('#prescriptions')[0].files[0];
                if (!excel_file) {
                    isValid = false;
                }
                formData.append('prescriptions', excel_file);

                if (isValid) {
                    try {
                        await $.ajax({
                            url: `{{ route('api.medical.booking.result.create') }}`,
                            method: 'POST',
                            headers: headers,
                            contentType: false,
                            cache: false,
                            processData: false,
                            data: formData,
                            success: function (response) {
                                alert('Create success!')
                                // window.location.href = ``;
                                window.location.href =
                                    `{{ route('web.booking.result.list', $dataBooking->id) }}`;
                            },
                            error: function (error) {
                                console.log(error);
                                alert('Create error!')
                            }
                        });
                    } catch (e) {
                        console.log(e)
                        alert('Error, Please try again!');
                    }
                } else {
                    alert('Sorry, Please enter input require!');
                }
            }

            function unCreateBooking() {
                alert('Booking result already exist!');
            }
        })

        function removeDuplicates(arr) {
            return arr.filter((item, index) => arr.indexOf(item) === index);
        }
    </script>
    <script>
        let html = `<div class="service-result-item d-flex align-items-center justify-content-between border p-3">
    <div class="row">
     <div class="form-group">
            <label for="service_result">{{ __('home.Service Name') }}</label>
            <input type="text" class="form-control service_result" value="{{ $dataBooking->service }}" id="service_result" name="service_result">
        </div>
<div class="form-group">
        <label for="result">{{ __('home.Result') }}</label>
        <input type="text" class="form-control result" id="result" placeholder="{{ __('home.Result') }}">
    </div>
    <div class="form-group">
        <label for="result_en">{{ __('home.Result En') }}</label>
        <input type="text" class="form-control result_en" id="result_en" placeholder="{{ __('home.Result En') }}">
    </div>
    <div class="form-group">
        <label for="result_laos">{{ __('home.Result Laos') }}</label>
        <input type="text" class="form-control result_laos" id="result_laos" placeholder="{{ __('home.Result Laos') }}">
    </div>
</div>
<div class="action mt-3">
    <i class="fa-regular fa-trash-can btnTrash" style="cursor: pointer; font-size: 24px"></i>
</div>
</div>`;

        $(document).ready(function () {
            $('#list-service-result').append(html);
            $('.btnAddNewResult').on('click', function () {
                $('#list-service-result').append(html);
                loadTrash();
                loadData();
            })

            loadTrash();

            function loadTrash() {
                $('.btnTrash').on('click', function () {
                    let main = $(this).parent().parent();
                    main.remove();
                })
            }

            loadData();

            function loadData() {
                $('.service_name_item').on('click', function () {
                    let my_array = null;
                    let my_name = null;
                    $(this).parent().parent().find(':checkbox:checked').each(function (i) {
                        let value = $(this).val();
                        if (my_array) {
                            my_array = my_array + ',' + value;
                        } else {
                            my_array = value;
                        }

                        let name = $(this).data('name');
                        if (my_name) {
                            my_name = my_name + ', ' + name;
                        } else {
                            my_name = name;
                        }
                    });
                    $(this).parent().parent().prev().val(my_name);
                    $(this).parent().parent().next().find('input').val(my_array);
                })
            }
        })
    </script>

    <script>
        //REPEATER
        $(document).ready(function () {
            initialSelect2($('.doctor_selector'));

            $('[id^=repeater_]').each(function () {
                var repeaterId = $(this).attr('id');
                var count = $(this).find('[data-repeater-item]').length;

                $(this).repeater({
                    show: function () {
                        var $item = $(this);
                        $item.find('.selectType option[selected]').removeAttr('selected');
                        $item.find('.selectType option:first').prop('selected', true);
                        $item.find('.selectType').attr('name', `booking_result_list[${count}][select]`);
                        $item.find('input[type="file"]').attr('name', `booking_result_list[${count}][file]`);
                        $item.find('input[type="file"]').val('');
                        $item.find('.select2Div').remove();

                        // Thêm select2 cho bác sĩ
                        $item.find('.firstSelector').after(`
                    <div class="col-md-3 select2Div">
                        <div class="form-group">
                            <label for="in_charged">Bác sĩ phụ trách:</label>
                            <select class="form-select doctor_selector" name="booking_result_list[${count}][doctor_id]"></select>
                        </div>
                    </div>
                `);

                        initialSelect2($item.find('.doctor_selector'));

                        // Chèn item mới vào cuối
                        var $lastItem = $(this).find('[data-repeater-item]').last();
                        $item.insertAfter($lastItem);
                        $item.slideDown();
                        count++;
                    },
                    hide: function (deleteElement) {
                        $(this).slideUp(deleteElement);
                    },
                    isFirstItemUndeletable: true
                });
            });

            function initialSelect2(selectElement) {
                selectElement.select2({
                    theme: 'bootstrap-5',
                    ajax: {
                        url: "{{ route('role.user.list', ['member' => 'DOCTORS']) }}",
                        dataType: 'json',
                        delay: 250,
                        data: function (params) {
                            return {
                                name: params.term, // Pass the search term as the 'name' parameter
                            };
                        },
                        processResults: function (data) {
                            if (Array.isArray(data)) {
                                return {
                                    results: data.map(function (user) {
                                        return {
                                            id: user.id,
                                            text: user.name
                                        };
                                    })
                                };
                            } else {
                                return {
                                    results: []
                                };
                            }
                        },
                        cache: true
                    },
                    minimumInputLength: 1,
                });
            }
        });
    </script>

    <script>
        $(document).ready(function () {
            // Function to check the conditions and show/hide the trackFile div
            function checkConditions(bookingId) {
                var isChecked = $("#is_result_" + bookingId).is(":checked");
                var selectedValue = $("#booking_status_" + bookingId).val();

                if (isChecked && selectedValue === "COMPLETE") {
                    $("#trackFile_" + bookingId).show();
                } else {
                    $("#trackFile_" + bookingId).hide();
                }
            }

            $(".booking-item").each(function () {
                var bookingId = $(this).data("booking-id");

                // Check conditions on page load for each booking
                checkConditions(bookingId);

                // Check conditions when is_result checkbox or booking_status select changes
                $("#is_result_" + bookingId + ", #booking_status_" + bookingId).change(function () {
                    checkConditions(bookingId);
                });
            });
        });
    </script>

    <script>
        $(window).on('load', function () {
            $('.btn-add-medicine-loading').css('display', 'none');
            $('.btn-add-medicine-booking').fadeIn();
        });
        let elementInputMedicine_widgetChat_Booking;
        let next_elementInputMedicine_widgetChat_Booking;
        let next_elementQuantity_widgetChat_Booking;
        let next_elementMedicineIngredients_widgetChat_Booking;

        let html_widgetChat = `<div class="service-result-item-don-thuoc d-flex align-items-center justify-content-between border p-3">
                    <div class="prescription-group d-flex align-items-center">
                        <div class="row w-100">
                            <div class="form-group">
                                <label for="medicine_name">Medicine Name</label>
                                <input type="text" class="form-control medicine_name input_medicine_name_booking" value=""
                                    name="medicines[@index][medicine_name]"  data-toggle="modal" data-target="#modal-add-medicine-widget-chat-booking" readonly>
                                <input type="text" hidden class="form-control medicine_id_hidden" name="medicines[@index][medicine_id_hidden]" value="">

                            </div>
                            <div class="form-group">
                                <label for="medicine_ingredients">Medicine Ingredients</label>
                                <textarea class="form-control medicine_ingredients" readonly name="medicines[@index][medicine_ingredients]" rows="4"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="quantity">{{ __('home.Quantity') }}</label>
                                <input type="number" min="1" class="form-control quantity" name="medicines[@index][quantity]">
                            </div>
                            <div class="form-group">
                                <label for="detail_value">Thời gian uống</label>
                                <input type="text" class="form-control detail_value" name="medicines[@index][note]" value="" hidden>
                                <input type="number" min="1" class="form-control treatment_days" name="medicines[@index][treatment_days]" value="1" hidden>
                                <select class="form-control detail_value" name="medicines[@index][note_date][]" multiple style="height: 155px;">
                                    <option value="1" selected >Trước ăn sáng</option>
                                    <option value="2">Sau ăn sáng</option>
                                    <option value="3">Trước ăn trưa</option>
                                    <option value="4">Sau ăn trưa</option>
                                    <option value="5">Trước ăn tối</option>
                                    <option value="6">Sau ăn tối</option>
                                </select>
                            </div>
                            <div class="d-flex">
                                 <div class="form-group w-50 mr-2">
                                    <label for="treatment_days">Ngày bắt đầu điều trị</label>
                                    <input type="date" class="form-control treatment_days" name="medicines[@index][date_start]">
                                </div>
                                 <div class="form-group w-50">
                                    <label for="treatment_days">Ngày kết thúc điều trị</label>
                                    <input type="date" class="form-control treatment_days" name="medicines[@index][date_end]">
                                </div>
                            </div>
                        </div>
                        <div class="action mt-3 mx-3">
                            <i class="fa-regular fa-trash-can loadTrash_widgetChat" style="cursor: pointer; font-size: 24px"></i>
                        </div>
                    </div>
                </div>`;


        $('.btn-add-medicine-booking').click(function () {
            let prescriptionId = $(this).data('prescription-id');
            let listContainer = $(`#list-service-result-don-thuoc-${prescriptionId}`);
            let newIndex = listContainer.find('.service-result-item-don-thuoc').length;
            let newHtml = html_widgetChat.replace(/@index/g, newIndex);
            listContainer.append(newHtml);

            $('.input_medicine_name_booking').click(function () {
                elementInputMedicine_widgetChat_Booking = $(this);
                next_elementInputMedicine_widgetChat_Booking = $(this).next('.medicine_id_hidden');
                next_elementQuantity_widgetChat_Booking = $(this).parents().parents().find('input.quantity');
                next_elementMedicineIngredients_widgetChat_Booking = $(this).parents().parents().find(
                    'textarea.medicine_ingredients');
            });

            $('.loadTrash_widgetChat').click(function () {
                $(this).closest('.service-result-item-don-thuoc').remove();
            });
            loadData_widgetChat();
            loadListMedicine();
        });

        function loadDisplayMessage(id) {
            var friendDivs = document.querySelectorAll('.user_connect');

            friendDivs.forEach(function (div) {
                // Lấy giá trị data-id của từng div
                var dataId = div.getAttribute('data-id');

                // Kiểm tra xem data-id có bằng currentId hay không
                if (dataId === id) {
                    div.click();
                }
            });
        }


        function loadListMedicine() {
            let inputNameMedicine_Search = $('#inputSearchNameMedicine').val().toLowerCase();
            let inputDrugIngredient_Search = $('#inputSearchDrugIngredient').val().toLowerCase();
            let object_search = $('#object_search').val().toLowerCase();
            let clinic_Search = $('#inputSearchClinic').val().toLowerCase();

            let url = '{{ route('view.prescription.result.get-medicine') }}'
            url = url +
                `?name_search=${inputNameMedicine_Search}&drug_ingredient_search=${inputDrugIngredient_Search}&object_search=${object_search}&clinic_search=${clinic_Search}`;

            $.ajax({
                url: url,
                method: 'GET',
                success: function (response) {
                    renderMedicine(response);
                },
                error: function (error) {
                    console.log(error)
                }
            });
        }

        function renderMedicine(data) {
            let html = '';
            data.forEach((medicine) => {
                let url = '{{ route('medicine.detail', ':id') }}';
                url = url.replace(':id', medicine.id);

                html += `<div class="col-sm-6 col-xl-4 mb-3 col-6 find-my-medicine-2">
                                <div class="m-md-2 ">
                                    <div class="frame component-medicine w-100">
                                        <div class="img-pro justify-content-center d-flex img_product--homeNew w-100">
                                            <img loading="lazy" class="rectangle border-img w-100"
                                                 src="${medicine.thumbnail}"/>
                                        </div>
                                        <div class="div">
                                            <div class="div-2">
                                                <a target="_blank" class="w-100"
                                                   href="${url}">
                                                    <div
                                                        class="text-wrapper text-nowrap overflow-hidden text-ellipsis w-100">${medicine.name}</div>
                                                </a>
                                                <div
                                                    class="text-wrapper-3">${medicine.price} ${medicine.unit_price ?? 'VND'}</div>
                                                <div
                                                    class="text-wrapper-3">Còn lại: ${medicine.quantity}</div>
                                            </div>
                                            <div class="div-wrapper">
                                                <a style="cursor: pointer" class="handleSelectInputMedicine_widgetChat-booking" data-id="${medicine.id}" data-name="${medicine.name}" data-quantity="${medicine.quantity}"
                                                   data-dismiss="modal">
                                                    <div class="text-wrapper-4">{{ __('home.Choose...') }}</div>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>`
            });

            $('#modal-list-medicine-widget-chat-booking').html(html);

            $('.handleSelectInputMedicine_widgetChat-booking').click(function () {
                let id = $(this).data('id');
                let name = $(this).data('name');
                let quantity = $(this).data('quantity');
                elementInputMedicine_widgetChat_Booking.val(name);
                next_elementInputMedicine_widgetChat_Booking.val(id);
                next_elementQuantity_widgetChat_Booking.off('change');

                next_elementQuantity_widgetChat_Booking.attr('max', quantity);

                // Thêm sự kiện onchange
                next_elementQuantity_widgetChat_Booking.on('change', function () {
                    // Lấy giá trị hiện tại của next_elementQuantity_widgetChat
                    var currentValue = next_elementQuantity_widgetChat_Booking.val();

                    // Chuyển đổi giá trị thành số để so sánh
                    currentValue = parseInt(currentValue);

                    // Kiểm tra nếu giá trị lớn hơn quantity
                    if (currentValue > quantity) {
                        // Hiển thị cảnh báo
                        alert('Giá trị không thể lớn hơn ' + quantity);
                        // Cài đặt lại giá trị về quantity
                        next_elementQuantity_widgetChat_Booking.val(quantity);
                    }
                });

                getIngredientsByMedicineIdBooking(id)
                    .then(result => {
                        console.log(result.component_name); // Log kết quả
                        next_elementMedicineIngredients_widgetChat_Booking.val(result.component_name); // Sử dụng kết quả
                    })
                    .catch(error => {
                        console.error('Đã xảy ra lỗi:', error);
                    });
            });

        }

        loadData_widgetChat();

        async function getIngredientsByMedicineIdBooking(id) {
            let url = `{{ route('medicine.get-ingredients-by-medicine-id', ['id' => ':id']) }}`;
            url = url.replace(':id', id);

            let result = await fetch(url, {
                method: 'GET',
            });

            if (result.ok) {
                let data = await result.json();
                return data;
            }

            return {
                'component_name': ''
            };
        }

        function loadData_widgetChat() {
            $('.service_name_item').on('click', function () {
                let my_array = null;
                let my_name = null;
                $(this).parent().parent().find(':checkbox:checked').each(function (i) {
                    let value = $(this).val();
                    if (my_array) {
                        my_array = my_array + ',' + value;
                    } else {
                        my_array = value;
                    }

                    let name = $(this).data('name');
                    if (my_name) {
                        my_name = my_name + ', ' + name;
                    } else {
                        my_name = name;
                    }
                });
                $(this).parent().parent().prev().val(my_name);
                $(this).parent().parent().next().find('input').val(my_array);
            })
        }


        $(".handleSearchMedicine").on("input", function () {
            loadListMedicine();
        });
        $(".handleSearchMedicineChange").on("change", function () {
            loadListMedicine();
        });
    </script>
@endsection
