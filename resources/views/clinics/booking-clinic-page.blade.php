@extends('layouts.master')
@section('title', 'Booking Clinic')
@section('content')
    <link rel="stylesheet" href="{{ asset('css/homeSpecialist.css') }}">
    <link href="{{ asset('css/detailclinics.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/foundation/6.1.0/foundation.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css">
    <link href="{{ asset('css/selectdate.css') }}" rel="stylesheet">
    <style>
        input[type=radio] {
            accent-color: #088180;
        }

        .border-booking-sv .font-weight-600 label {
            color: #000;
            font-size: 18px;
            font-style: normal;
            font-weight: 800;
            line-height: normal;
        }

        .date-active {
            background-color: blue;

        }

        a.hollow.button {
            border-radius: 8px;
            background: #F3F3F3;
            color: #929292;
            font-size: 24px;
            font-style: normal;
            font-weight: 800;
            line-height: normal;
            border: 1px solid #FFFFFF;
            margin: 0 16px 0 0;
        }

        a.hollow.button:hover {
            border-radius: 8px;
            border: 1px solid #088180;
            background: #F3F3F3;
        }

        a.hollow.button:active {
            border-radius: 8px;
            background: #088180;
            color: #FFF;
            font-size: 24px;
            font-style: normal;
            font-weight: 800;
            line-height: normal;
        }

        .ui-state-active {
            border-radius: 85px;
            background-color: #088180 !important;
        }

        .ui-datepicker-inline.ui-datepicker.ui-widget.ui-widget-content.ui-helper-clearfix.ui-corner-all {
            border-radius: 8px;
            background: #FFF;
            box-shadow: 0 8px 12px 0 rgba(0, 0, 0, 0.20);
            border: none;
            padding: 16px;

        }

        tbody,
        tfoot,
        thead {
            border: none;
            background-color: #FFFFFF;
        }

        tbody tr:nth-child(even) {
            background-color: white;
        }

        .ui-datepicker-calendar tbody tr td .ui-state-default {
            border: none;
            background-color: #ffffff;
        }

        .ui-datepicker-header.ui-widget-header.ui-helper-clearfix.ui-corner-all {
            background: white;
            border: none;
        }

        .ui-datepicker td {
            padding: 12px;
        }

        .select-memberFamily label {
            color: #000;
            font-size: 24px;
            font-style: normal;
            font-weight: 800;
            line-height: normal;
        }

        .select-service {
            margin-top: 40px;
            color: #000;
            font-size: 18px;
            font-style: normal;
            font-weight: 600;
            line-height: normal;
        }

        .checkbox-button label {
            width: 24px;
            height: 24px;
            border-radius: 30px;
        }

        .border-booking-sv {
            padding: 16px;
        }

        .button-apply-booking {
            display: flex;
            width: 470px;
            padding: 14px 50px;
            justify-content: center;
            align-items: center;
            gap: 10px;
            border-radius: 8px;
            background: #088180;
            border: none;
        }

        .avtMember img {
            width: 71px;
            height: 71px;
            border-radius: 71px;
            object-fit: cover;
        }

        .border-8 {
            border-radius: 8px;
            border: 1px solid #EAEAEA;
            background: #FFF;
            box-shadow: 0 4px 4px 0 rgba(0, 0, 0, 0.25);
            padding: 16px;
        }
        #select-insurance{
            display: flex;
            align-items: center;
        }
        .insurance_your_self input[type=text], .insurance_family input[type=text]
        {
            border-radius: 0.375rem;
        }

        @media (max-width: 767px) {
            .zalo-chat {
                right: 26px !important;
                bottom: 150px !important;
            }
        }
        .border-booking-payment .font-weight-600 label {
            color: #000;
            font-size: 18px;
            font-style: normal;
            font-weight: 800;
            line-height: normal;
        }
        .fundiin-payment{
            padding: 16px;
            background-color: #f3f3f3;
        }
        .fundiin-payment-checkbox{
            width: 24px;
            height: 24px;
            border-radius: 30px;
            margin-right: 1rem;
            margin-bottom: 0;
        }
    </style>
    @include('layouts.partials.header')
    @if(request()->has('status') && request()->get('status') == 'successful')
        <script>
            alert('Đặt lịch thành công');
        </script>
    @elseif(request()->has('status') && request()->get('status') == 'unsuccessful')
        <script>
            alert('Đặt lịch thất bại!');
        </script>
    @endif
    <div class="container box-dat-kham">
        <div class="detail-clinic-theo-chuyen-khoa-title border-bottom">
            <a href="{{ route('home.specialist') }}">
                <div class="title-detail-clinic"><i class="fa-solid fa-arrow-left"></i> {{ __('home.Detail') }}</div>
            </a>
            <div class="specialList-clinics specialList-clinics-mobile col-md-12 mt-5 mb-5">
                <div class="border-specialList">
                    <div class="content__item d-md-flex gap-3">
                        @php
                            $arrayGallery = explode(',', $clinicDetail->gallery);

                        @endphp
                        <div class="specialList-clinics--img">
                            <img class="content__item__image" src="{{ $arrayGallery[0] ?? '' }}" alt="" />
                        </div>
                        <div class="specialList-clinics--main">
                            <div class="title-specialList-clinics">
                                {{ $clinicDetail->name }}
                            </div>
                            <div class="address-specialList-clinics d-flex">
                                <i class="fas fa-map-marker-alt"></i>
                                @php
                                    $array = explode(',', $clinicDetail->address);
                                    $addressP = \App\Models\Province::where('id', $array[1] ?? null)->first();
                                    $addressD = \App\Models\District::where('id', $array[2] ?? null)->first();
                                    $addressC = \App\Models\Commune::where('id', $array[3] ?? null)->first();
                                @endphp
                                <div class="ml-1">{{ $clinicDetail->address_detail }}
                                    , {{ $addressC->name ?? '' }} , {{ $addressD->name ?? '' }}
                                    , {{ $addressP->name ?? '' }}</div>
                            </div>
                            <div class="time-working">
                                <i class="fa-solid fa-clock"></i>
                                {{ $clinicDetail->time_work }}
                                | {{ \Carbon\Carbon::parse($clinicDetail->open_date)->format('H:i') }}
                                - {{ \Carbon\Carbon::parse($clinicDetail->close_date)->format('H:i') }}
                            </div>
                            <div class="group-button d-flex mt-3">
{{--                                <a href="" class="mr-2">--}}
{{--                                    <div class="button-follow-specialList button-follow-specialList-zalo">--}}
{{--                                        <div style="margin-left: 8px; margin-top: 18px" class="zalo-follow-only-button"--}}
{{--                                            data-callback="userFollowZaloOA" data-oaid="4438562505337240484"></div>--}}
{{--                                    </div>--}}
{{--                                </a>--}}
                                <a href="{{ route('clinic.detail', $clinicDetail->id) }}" class="">
                                    <div class="button-direct-specialList">
                                        {{ __('home.Chỉ đường') }}
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <form action="{{ route('clinic.booking.store') }}" method="post" id="bookingHospitalForm">
            @csrf
            <input type="hidden" name="checkInTime" id="checkInTime">
            <input type="hidden" name="checkOutTime" id="checkOutTime">
            <input type="hidden" name="clinic_id" id="clinic_id" value='{{ $clinicDetail->id }}'>
            <input type="hidden" name="user_id" id="user_id" value="{{ Auth::user()->id }}">
            <input type="hidden" name="department_id" id="department_id" value="">
            <input type="hidden" name="clinic_detail_name" value="{{$clinicDetail->name}}"/>
            <input type="hidden" name="clinic_detail_description" value="{{$clinicDetail->introduce}}"/>
            <input type="hidden" name="clinic_detail_image" value="{{$clinicDetail->gallery}}"/>
            <div>
                <div></div>
                <section>
                    <div class="d-md-flex">
                        <div class="small-12 col-lg-5 col-md-6 pl-0 pr-0">
                            <div class="text-time">{{ __('home.Chọn Ngày') }}
                                <span class="small text-danger">*</span>
                            </div>
                            <div id="datepicker"></div>
                        </div>
                        <div class="small-12 col-lg-7 col-md-6">
                            <div class="time-kham text-time">{{ __('home.Chọn thời gian') }}
                                <span class="small text-danger">*</span>
                            </div>
                            <div class="spin-me"></div>
                            <div class="container p-0">
                                <div class="row">
                                    <div class="col-12 timeContainer p-0">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
            <div class="mt-5">
                <div class="d-flex align-items-center select-memberFamily">
                    <input class="m-0 inputBookingFor" style="width: 20px;height: 20px;" type="radio"
                        name="member_family_id" checked id="myself" value="myself" onclick="checkDataFullFill()"><label
                        for="myself">{{ __('home.Cho mình') }}</label>
                    <input class="m-0 inputBookingFor" style="width: 20px;height: 20px;" type="radio"
                        name="member_family_id" id="family" value="family" onclick="checkDataFullFill()"><label
                        for="family">{{ __('home.Cho người thân') }}</label>
                </div>
            </div>
            <div class="d-flex mt-5 d-none" id="my-family">
                @if ($memberFamilys->count() == 0)
                    <div class="col-auto mr-3 border-8">
                        <a href="{{ route('api.backend.family-management.create') }}">
                            <div class="avtMember d-flex justify-content-center align-items-center">
                                <img src="{{ asset('img/add-new.png') }}" alt="add-new"/>
                            </div>
                            <div class="d-flex align-items-center justify-content-center">
                                {{--                            <label for="yourself">{{ __('home.Bạn chưa có người thân') }}</label>--}}
                                {{--                            <input hidden="" type="radio" name="memberFamily" id="yourself" value="yourself"><label--}}
                                {{--                                for="yourself">{{ __('home.Cho mình') }}</label>--}}
                                <label>Thêm Người thân</label>
                            </div>
                        </a>
                    </div>
                @else
                    @foreach ($memberFamilys as $memberFamily)
                        <div class="col-auto mr-3 border-8">
                            <div class="avtMember">
                                <img src="{{ $memberFamily->avatar ?? 'https://i0.wp.com/sbcf.fr/wp-content/uploads/2018/03/sbcf-default-avatar.png' }}"
                                    alt="">
                            </div>
                            <div class="d-flex align-items-center justify-content-center">
                                <label for="{{ $memberFamily->id }}">{{ $memberFamily->name }}</label>
                            </div>
                            <div class="d-flex align-items-center justify-content-center">
                                #
                                {{ \App\Enums\RelationshipFamily::getLabels()[$memberFamily->relationship] ?? $memberFamily->relationship }}
                            </div>
                            <input style="right: 0" class="position-absolute top-0 m-2 family-member-check" type="radio"
                                name="member_family_child_id" id="{{ $memberFamily->id }}" value="{{ $memberFamily->id }}"
                                   data-insurance-id="{{ $memberFamily->insurance_id }}" data-insurance-date="{{$memberFamily->insurance_date}}"
                                   onchange="updateCheckedMember()" onclick="checkDataFullFill()">

                        </div>
                    @endforeach
                        <div class="col-auto mr-3 border-8">
                            <a href="{{ route('api.backend.family-management.addMember') }}">
                                <div class="avtMember d-flex justify-content-center align-items-center">
                                    <img src="{{ asset('img/add-new.png') }}" alt="add-new"/>
                                </div>
                                <div class="d-flex align-items-center justify-content-center">
                                    <label>Thêm Người thân</label>
                                </div>
                            </a>
                        </div>
                @endif
            </div>
            <div>
                <div class="select-service">{{ __('home.Select service') }}</div>
                <div>
                    @foreach ($services as $service)
                        <div class="d-flex justify-content-between mt-md-2 border-booking-sv align-items-center">
                            <div class="fs-14 font-weight-600">
                                <label class="d-flex" for="myCheckbox{{ $service->id }}">{{ $service->name }}   (<span style="color: red">{{number_format($service->service_price)}} VND</span>)</label>
                            </div>
                            <div class="checkbox-button">
                                <input type="checkbox" id="myCheckbox{{ $service->id }}" value="{{ $service->id }}"
                                    name="service[]">
                                <label class="d-flex" for="myCheckbox{{ $service->id }}"></label>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="select-service d-flex align-items-center">
                <div class="mr-4">Sử dụng bảo hiểm y tế: </div>
                <div id="select-insurance">
                    <input class="m-0 inputBookingFor" id="insurance_yes" style="width: 20px;height: 20px;" type="radio" name="insurance_use" value="yes" onclick="checkDataFullFill()" checked>
                    <label for="yes" style="font-size: 18px">Có</label>
                    <input class="m-0 inputBookingFor" id="insurance_no" style="width: 20px;height: 20px;" type="radio" name="insurance_use" value="no" onclick="checkDataFullFill()">
                    <label for="no" style="font-size: 18px">Không</label>
                </div>
            </div>
            <div class="form-group insurance_your_self mt-1">
                <div>Mã bảo hiểm y tế: (cập nhật mã bảo hiểm <a href="{{ route('profile', ['clinic_id' => $clinicDetail->id]) }}">tại đây</a>)</div>
                <input type="text" class="form-control" id="insurance_your_selfs" name="insurance_your_self" value="{{ Auth::user()->insurance_id }}" disabled/>
                <input type="text" class="form-control" id="insurance_dates" name="insurance_date" value="{{ Auth::user()->date_health_insurance }}" hidden/>
                <input type="text" class="form-control" name="insurance_your_self_hidden" value="{{ Auth::user()->insurance_id }}" hidden/>
            </div>
            <div class="form-group insurance_family mt-1">
                <div>Mã bảo hiểm y tế: (cập nhật mã bảo hiểm <a id="updateCheckedMember" href="#" onclick="validateSelectMember(event)">tại đây</a>)</div>
                <input type="text" class="form-control" name="insurance_family" id="insuranceFamilyIDInput" value="" disabled/>
                <input type="text" class="form-control" name="insurance_date" id="insuranceFamilyDateInput"  value="" hidden/>
                <input type="text" class="form-control" name="insurance_family_hidden" id="insurance_family_hidden"  value="" hidden/>
            </div>

            <div>
                <div class="select-service">Chọn hình thức thanh toán (không bắt buộc)</div>
                <div class="fundiin-payment">
                    <div class="d-flex justify-content-between mt-md-2 align-items-center border-booking-payment">
                        <div class="fs-14 font-weight-600">
                            <label for="fundiin">
                                <img src="{{ asset('/img/icon/fundiin.png') }}" alt=""
                                     style="width: 24px; height: 24px; margin-right: 10px">
                                <span>Fundiin - Mua trả sau 0% lãi</span>
                            </label>
                        </div>
                        <div>
                            <input type="radio" id="fundiin" name="method" value="fundiin" class="fundiin-payment-checkbox">
                        </div>
                    </div>
                    <div id='script-checkout-container' class="mt-2" style="display: none;"></div>
                </div>
            </div>
            <div class="d-flex justify-content-center">
                <button type="submit" class="btn col-md-6 mt-4 btn-success btn-block up-date-button button-apply-booking"
                    id="activate">{{ __('home.Xác nhận đặt khám') }}
                </button>
            </div>

        </form>
    </div>
    <div class="modal fade" id="model-check-kham" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5 text-center" id="staticBackdropLabel">Bạn có muốn bác sĩ xem lịch sử khám bệnh của bạn không</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-footer d-flex justify-content-center">
                    <button type="button" class="btn btn-secondary btn-yes-history" data-value="0" style="background-color: red;border: none">Không</button>
                    <button type="button" class="btn btn-success btn-yes-history" data-value="1" style="border: none">Có</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            let showsModel = localStorage.getItem('check-kham');
            if (showsModel == 'active'){
                $('#model-check-kham').modal('show');
            }

            $('.btn-yes-history').click(function () {
                let medical_history = $(this).attr('data-value');
                const csrfTokens = $('meta[name="csrf-token"]').attr('content');
                $.ajax({
                    url: `{{route('examination-history-user')}}`,
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfTokens
                    },
                    dataType: 'json',
                    data: {'medical_history':medical_history},
                    success: function (data) {
                        $('#model-check-kham').modal('hide');
                        localStorage.setItem('check-kham','none')
                    },
                    error: function (data) {
                        console.log(data)
                    }
                });
            });

            loadData();

            $('.inputBookingFor').on('change', function() {
                checkMyFamily();
            });

        });

        function checkMyFamily() {
            let inputChecked = document.querySelector('input[name="member_family_id"]:checked');
            let value = inputChecked.value;
            if (value === 'myself') {
                document.getElementById('my-family').classList.add('d-none');
            } else {
                document.getElementById('my-family').classList.remove('d-none');
            }
        }
        var bookingsCount = @json($bookingsCheck);

        function loadData() {

            function spinner(startOrStop) {
                const spin = document.querySelector('.spin-me');
                if (startOrStop === 'start') {
                    const spinner = document.createElement('i');
                    spinner.setAttribute('class', 'fas fa-spinner fa-4x fa-spin');
                    spin.appendChild(spinner);
                } else {
                    spin.innerHTML = '';
                }
            }

            // Define the working hours
            var workingHours = [
                "08:00-09:00",
                "09:00-10:00",
                "10:00-11:00",
                "12:00-13:00",
                "13:00-14:00",
                "14:00-15:00",
                "15:00-16:00",
                "16:00-17:00"
            ];

            var isRendered = false; // Flag to track if working hours are rendered

            function renderWorkingHours(selectedDate, clinicId) {
                if (isRendered) {
                    $(".timeContainer").empty(); // Clear existing working hours
                }
                var container = $(".timeContainer");

                var selectedDateFormatted = new Date(selectedDate).toISOString().split('T')[0];
                var bookingCountsForDate = bookingsCount.reduce((acc, booking) => {
                    var checkInDate = new Date(booking.check_in_date).toISOString().split('T')[0];
                    var time = booking.check_in_date.split(' ')[1].substring(0, 5);
                    if (!acc[booking.clinic_id]) {
                        acc[booking.clinic_id] = {};
                    }
                    if (!acc[booking.clinic_id][checkInDate]) {
                        acc[booking.clinic_id][checkInDate] = {};
                    }
                    acc[booking.clinic_id][checkInDate][time] = booking.num_bookings;
                    return acc;
                }, {});

                for (var i = 0; i < workingHours.length; i++) {
                    (function() {
                        var workingHour = workingHours[i];
                        var button = $("<button>")
                            .addClass("btn btn-outline-primary")
                            .attr("type", "button")
                            .attr("data-date", workingHour)
                            .css({
                                'margin-right': '7px',
                                'margin-bottom': '5px'
                            })
                            .text(workingHour);

                        //VALIDATE TODAY TIME
                        var timeParts = workingHour.split("-");
                        var startTime = timeParts[0];
                        var endTime = timeParts[1];

                        var currentTime = new Date();
                        var currentHour = currentTime.getHours();
                        var currentMinute = currentTime.getMinutes();

                        if (currentMinute > 0) {
                            currentHour += 1; //Làm tròn giờ khi đã vào ca
                        }

                        var selectedDateTime = new Date(selectedDate);
                        selectedDateTime.setHours(parseInt(startTime.split(":")[0]));
                        selectedDateTime.setMinutes(parseInt(startTime.split(":")[1]));

                        if (bookingCountsForDate[clinicId] &&
                            bookingCountsForDate[clinicId][selectedDateFormatted] &&
                            bookingCountsForDate[clinicId][selectedDateFormatted][startTime] >= 5) {
                            button.prop("disabled", true);
                        }
                        // Kiểm tra nếu ngày được chọn là hôm nay và giờ hiện tại nằm trong khoảng từ 08:00 đến currentHour
                        if (
                            selectedDateTime.toDateString() === currentTime.toDateString() &&
                            currentHour > 8 && currentHour > parseInt(startTime.split(":")[0])
                        ) {
                            // Vô hiệu hóa các nút từ 08:00 đến currentHour
                            button.prop("disabled", true);
                        }
                        //VALIDATE TODAY TIME

                        checkWorkingTime(selectedDate + " " + timeParts[0] + ":00", selectedDate + " " +
                            timeParts[1] + ":00",
                            function(result) {
                                if (!result) {
                                    button.prop("disabled", true);
                                }
                            });

                        button.on("click", function() {
                            $(".timeContainer button").removeClass("btn btn-primary").addClass(
                                "btn btn-outline-primary");
                            $(this).removeClass("btn btn-outline-primary").addClass("btn btn-primary");
                            var timeText = $(this).text();
                            var timeParts = timeText.split("-");
                            var checkIn = selectedDate + " " + timeParts[0] + ":00";
                            var checkOut = selectedDate + " " + timeParts[1] + ":00";
                            $('#checkInTime').val(checkIn);
                            $('#checkOutTime').val(checkOut);
                            checkDataFullFill();
                        });

                        container.append(button);

                    })();
                }
                checkDataFullFill();
                document.getElementById('bookingHospitalForm').addEventListener('change', function() {
                    const formData = new FormData(this);
                    const data = {};
                    const services = [];
                    formData.forEach((value, key) => {
                        if (key === 'service[]') {
                            services.push(value);
                        } else {
                            data[key] = value;
                        }
                    });
                    if (services.length > 0) {
                        data['service'] = services;
                    }
                    localStorage.setItem('bookingFormData', JSON.stringify(data));
                });

                const savedData = localStorage.getItem('bookingFormData');
                if (savedData) {
                    const formData = JSON.parse(savedData);
                    if (formData.checkInTime && formData.checkOutTime) {
                        var checkInDate = new Date(formData.checkInTime);
                        var checkOutDate = new Date(formData.checkOutTime);
                        $(".timeContainer button").each(function() {
                            var button = $(this);
                            var buttonTime = button.attr("data-date");
                            var timeParts = buttonTime.split("-");
                            var buttonStartTime = new Date(selectedDate + ' ' + timeParts[0] + ":00");
                            var buttonEndTime = new Date(selectedDate + ' ' + timeParts[1] + ":00");

                            if ((checkInDate >= buttonStartTime && checkInDate < buttonEndTime) ||
                                (checkOutDate > buttonStartTime && checkOutDate <= buttonEndTime) ||
                                (checkInDate <= buttonStartTime && checkOutDate >= buttonEndTime)) {
                                button.removeClass("btn-outline-primary").addClass("btn-primary");
                            } else {
                                button.removeClass("btn-primary").addClass("btn-outline-primary");
                            }
                        });
                    }

                    document.getElementById('checkInTime').value = formData.checkInTime || '';
                    document.getElementById('checkOutTime').value = formData.checkOutTime || '';
                    document.getElementById('clinic_id').value = formData.clinic_id || '';
                    document.getElementById('user_id').value = formData.user_id || '';
                    document.getElementById('department_id').value = formData.department_id || '';
                    document.querySelector('[name="clinic_detail_name"]').value = formData.clinic_detail_name || '';
                    document.querySelector('[name="clinic_detail_description"]').value = formData.clinic_detail_description || '';
                    document.querySelector('[name="clinic_detail_image"]').value = formData.clinic_detail_image || '';

                    if (formData.service) {
                        formData.service.forEach(serviceId => {
                            document.querySelector(`input[name="service[]"][value="${serviceId}"]`).checked = true;
                        });
                    }

                    document.querySelector(`input[name="insurance_use"][value="${formData.insurance_use}"]`).checked = true;
                    document.getElementById('insurance_dates').value = formData.insurance_date || '';

                    document.getElementById('insurance_your_selfs').value = formData.insurance_your_self_hidden || '';
                    document.getElementById('insuranceFamilyIDInput').value = formData.insurance_family_hidden || '';
                    document.getElementById('insurance_family_hidden').value = formData.insurance_family_hidden || '';

                    var insuranceUseLoad = $('input[name="insurance_use"]:checked').val();
                    if (formData.member_family_id == "myself"){
                        document.querySelector(`input[name="member_family_id"]`).checked = false;
                        document.querySelector(`input[name="member_family_id"][value="${formData.member_family_id}"]`).checked = true;
                        document.querySelector('.insurance_your_self').style.display = 'block';
                        document.querySelector('.insurance_family').style.display = 'none';
                        if (insuranceUseLoad == 'no'){
                            document.querySelector('.insurance_your_self').style.display = 'none';
                        }
                    }else{
                        document.querySelector(`input[name="member_family_id"]`).checked = false;
                        document.querySelector(`input[name="member_family_id"][value="${formData.member_family_id}"]`).checked = true;
                        document.querySelector('.insurance_family').style.display = 'block';
                        document.querySelector('.insurance_your_self').style.display = 'none';
                        if (formData.member_family_child_id) {
                            document.querySelector('#my-family').style.setProperty('display', 'flex', 'important');
                            document.querySelector(`input[name="member_family_child_id"][value="${formData.member_family_child_id}"]`).checked = true;
                        }
                        if (insuranceUseLoad == 'no'){
                            document.querySelector('.insurance_family').style.display = 'none';
                        }
                    }
                    checkDataFullFill();
                    updateCheckedMember();
                }
            }

            $("#datepicker").datepicker({
                dateFormat: "yy-mm-dd",
                minDate: 0, // Ngày hôm nay
                maxDate: "+1Y" // 1 năm sau ngày hôm nay
            });

            $("#datepicker").on("change", function() {
                $('#checkInTime').val('');
                $('#checkOutTime').val('');
                var selectedDate = $(this).val();
                localStorage.setItem('selectedDate', selectedDate);
                var clinicId = {{$clinicDetail->id}};
                if (isRendered) {
                    $(".timeContainer").empty(); // Clear existing working hours
                }
                spinner('start');
                setTimeout(() => {
                    renderWorkingHours(selectedDate, clinicId);
                    spinner('stop');
                }, 500);
                isRendered = true;
            });

            // Trigger the change event when the datepicker is loaded
            const selectedDateSelect = localStorage.getItem('selectedDate');

            if (selectedDateSelect) {
                $("#datepicker").datepicker("setDate", selectedDateSelect);
                renderWorkingHours(selectedDateSelect, {{$clinicDetail->id}});
            }else{
                $("#datepicker").trigger("change");
            }
        }

        function checkDataFullFill() {
            const submitButton = $('.button-apply-booking');
            var myself = $('#myself:checked');
            var family = $('#family:checked');
            var familyMem = $('.family-member-check:checked');
            var checkIn = $('#checkInTime').val();
            var checkOut = $('#checkOutTime').val();
            var insuranceUse = $('input[name="insurance_use"]:checked').val();
            var insuranceId = $('#insurance_your_selfs').val();
            var insuranceDate = $('#insurance_dates').val();
            var currentDate = new Date().toISOString().split('T')[0];
            var insuranceDateObj = insuranceDate ? new Date(insuranceDate) : null;
            var currentDateObj = new Date(currentDate);
            var insuranceFamilyID = $('.family-member-check:checked').data('insurance-id');
            var insuranceFamilyDate = $('.family-member-check:checked').data('insurance-date');
            var insuranceFamilyDateObj = insuranceFamilyDate ? new Date(insuranceFamilyDate) : null;
            if ($('input[name="member_family_id"]:checked').val() == 'myself'){
                document.querySelector('#my-family').style.setProperty('display', 'none', 'important');
            }else{
                document.querySelector('#my-family').style.setProperty('display', 'flex', 'important');
            }
            if (checkIn && checkOut) {
                if (insuranceUse === 'yes') {
                    if (!insuranceId && myself.length > 0) {
                        submitButton.text('Vui lòng nhập bảo hiểm y tế');
                        submitButton.attr("disabled", true);
                        return;
                    } else if(familyMem && !insuranceFamilyID && myself.length === 0){
                        submitButton.text('Vui lòng nhập bảo hiểm y tế');
                        submitButton.attr("disabled", true);
                        return;
                    }
                    if (insuranceDateObj && insuranceDateObj < currentDateObj && myself.length > 0) {
                        submitButton.text('Bảo hiểm y tế đã hết hạn');
                        submitButton.attr("disabled", true);
                        return;
                    } else if(insuranceFamilyDateObj && insuranceFamilyDateObj < currentDateObj  && myself.length === 0) {
                        submitButton.text('Bảo hiểm y tế đã hết hạn');
                        submitButton.attr("disabled", true);
                        return;
                    }
                }
                // All values are not null or undefined
                submitButton.text('Đặt lịch ngay');
                submitButton.attr("disabled", false);

                //Check user followed
                let followed = fetch(
                    '{{ route('zalo-follower.show', Auth::user()->id ?? 0) }}', {
                        method: 'GET',
                        // headers: {
                        //     "Authorization": accessToken
                        // },
                    });

                if (followed.ok) {
                    followed = followed.json();
                    if (followed.error != 0) {
                        submitButton.text('Bạn phải follow phòng khám này trước');
                        submitButton.attr("disabled", true);
                    }
                }
                //Check user followed
            } else {
                // At least one value is null or undefined
                submitButton.text('Vui lòng chọn Ngày và Giờ khám');
                submitButton.attr("disabled", true);
            }
        }

        function checkWorkingTime(check_in, check_out, callback) {
            let checkWorkingTimeUrl = `{{ route('api.backend.booking.check.time.available') }}`;

            let data = {
                'clinic_id': `{{ $bookings->id ?? '' }}`,
                'checkInTime': check_in,
                'checkOutTime': check_out,
            };
            $.ajax({
                url: checkWorkingTimeUrl,
                method: "GET",
                headers: headers,
                data: data,
                success: function(response) {
                    let result = true;
                    if (response.data >= 10) {
                        result = false;
                    }
                    callback(result);
                },
                error: function(error) {
                    console.log(error);
                    callback(false);
                }
            });
        }
        document.addEventListener('DOMContentLoaded', function() {
            const departmentId = localStorage.getItem('departmentId');
            if (departmentId) {
                document.getElementById('department_id').value = departmentId;
            }
        });
    </script>

    <script type="application/javascript"
            crossorigin="anonymous"
            src="https://gateway-sandbox.fundiin.vn/merchants/checkoutjs/FD200000165745.js">

    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const fundiinRadio = document.getElementById('fundiin');
            const checkoutContainer = document.getElementById('script-checkout-container');

            fundiinRadio.addEventListener('change', function() {
                if (this.checked) {
                    checkoutContainer.style.display = 'block';
                }
            });

            // Optionally, handle other radio buttons to hide the container when they are checked
            const otherRadios = document.querySelectorAll('input[name="method"]:not(#fundiin)');
            otherRadios.forEach(function(radio) {
                radio.addEventListener('change', function() {
                    if (this.checked) {
                        checkoutContainer.style.display = 'none';
                    }
                });
            });
        });

        document.getElementById('bookingHospitalForm').addEventListener('submit', function(event) {
            event.preventDefault(); // Prevent the default form submission

            var fundiinChecked = document.getElementById('fundiin').checked;
            if (fundiinChecked) {
                this.action = "{{ route('home.fundiin') }}"; // Change form action if Fundiin is selected
            } else {
                this.action = "{{ route('clinic.booking.store') }}"; // Default action
            }
            localStorage.removeItem('bookingFormData');
            localStorage.removeItem('selectedDate');
            this.submit(); // Submit the form with the updated action
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            function toggleInsuranceFields() {
                let insuranceYes = document.getElementById('insurance_yes').checked;
                let myself = document.getElementById('myself').checked;
                let family = document.getElementById('family').checked;

                document.querySelector('.insurance_your_self').style.display = 'none';
                document.querySelector('.insurance_family').style.display = 'none';

                if (insuranceYes) {
                    if (myself) {
                        document.querySelector('.insurance_your_self').style.display = 'block';
                        document.querySelector('input[name="insurance_family"]').removeAttribute('required');
                    } else if (family) {
                        document.querySelector('.insurance_family').style.display = 'block';
                        document.querySelector('input[name="insurance_family"]').setAttribute('required', 'required');
                    }
                } else {
                    document.querySelector('input[name="insurance_family"]').removeAttribute('required');
                }
            }

            document.getElementById('insurance_yes').addEventListener('change', toggleInsuranceFields);
            document.getElementById('insurance_no').addEventListener('change', toggleInsuranceFields);
            document.getElementById('myself').addEventListener('change', toggleInsuranceFields);
            document.getElementById('family').addEventListener('change', toggleInsuranceFields);

            // Initialize the display based on the default checked values
            toggleInsuranceFields();
        });

        function updateCheckedMember() {
            const selectedRadio = document.querySelector('input[name="member_family_child_id"]:checked');
            if (selectedRadio) {
                const memberFamilyId = selectedRadio.value;
                const insuranceId = selectedRadio.getAttribute('data-insurance-id');
                const insuranceDate = selectedRadio.getAttribute('data-insurance-date');
                const updateLink = document.getElementById('updateCheckedMember');
                const insuranceIDInput = document.getElementById('insuranceFamilyIDInput');
                const insuranceDateInput = document.getElementById('insuranceFamilyDateInput');

                const baseUrl = `{{ route('api.backend.family-management.edit', ':id') }}`;
                updateLink.href = baseUrl.replace(':id', memberFamilyId);

                // Update the insurance input with the insurance_id of the selected family member
                insuranceIDInput.value = insuranceId;
                insuranceDateInput.value = insuranceDate;
                document.getElementById('insurance_family_hidden').value = insuranceId;
            }
        }

        // Initial call to set the link if a radio button is already checked
        document.addEventListener('DOMContentLoaded', function() {
            updateCheckedMember();
        });

        function validateSelectMember(event){
            const selectedRadio = document.querySelector('.family-member-check:checked');
            if (!selectedRadio) {
                event.preventDefault();
                alert('Vui lòng chọn người thân');
            }
        }

    </script>
@endsection
