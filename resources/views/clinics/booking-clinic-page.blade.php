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
        .zalo-chat{
            right: 60px!important;
            bottom: 135px!important;
            z-index: 1!important;
        }
        @media (max-width: 767px) {
            .zalo-chat {
                right: 22px !important;
                bottom: 122px !important;
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
            alert('Booking Success');
        </script>
    @elseif(request()->has('status') && request()->get('status') == 'unsuccessful')
        <script>
            alert('Booking Error!');
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
                                <a href="" class="mr-2">
                                    <div class="button-follow-specialList button-follow-specialList-zalo">
                                        <div style="margin-left: 8px; margin-top: 18px" class="zalo-follow-only-button"
                                            data-callback="userFollowZaloOA" data-oaid="4438562505337240484"></div>
                                    </div>
                                </a>
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
                            <div class="text-time">{{ __('home.Chọn Ngày') }}</div>
                            <div id="datepicker"></div>
                        </div>
                        <div class="small-12 col-lg-7 col-md-6">
                            <div class="time-kham text-time">{{ __('home.Chọn thời gian') }}</div>
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
                        name="member_family_id" checked id="myself" value="myself"><label
                        for="myself">{{ __('home.Cho mình') }}</label>
                    <input class="m-0 inputBookingFor" style="width: 20px;height: 20px;" type="radio"
                        name="member_family_id" id="family" value="family"><label
                        for="family">{{ __('home.Cho người thân') }}</label>
                </div>
            </div>
            <div class="d-flex mt-5 d-none" id="my-family">
                @if ($memberFamilys->count() == 0)
                    <div class="col-auto mr-3 border-8">
                        <div class="avtMember d-flex justify-content-center align-items-center">
                            <img src="https://i0.wp.com/sbcf.fr/wp-content/uploads/2018/03/sbcf-default-avatar.png"
                                alt="">
                        </div>
                        <div class="d-flex align-items-center justify-content-center">
                            <label for="yourself">{{ __('home.Bạn chưa có người thân') }}</label>
                            <input hidden="" type="radio" name="memberFamily" id="yourself" value="yourself"><label
                                for="yourself">{{ __('home.Cho mình') }}</label>
                        </div>
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
                            <input style="right: 0" class="position-absolute top-0 m-2" type="radio"
                                name="member_family_id" id="{{ $memberFamily->id }}" value="{{ $memberFamily->id }}">
                        </div>
                    @endforeach
                @endif
            </div>
            <div>
                <div class="select-service">{{ __('home.Select service') }}</div>
                <div>
                    @foreach ($services as $service)
                        <div class="d-flex justify-content-between mt-md-2 border-booking-sv align-items-center">
                            <div class="fs-14 font-weight-600">
                                <label class="d-flex" for="myCheckbox{{ $service->id }}">{{ $service->name }}</label>
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
        <div class="zalo-chat-widget zalo-chat" data-oaid="3111836148004341171" data-welcome-message="Rất vui khi được hỗ trợ bạn!" data-autopopup="0" data-width="300" data-height="300"></div>
    </div>
    <script>
        $(document).ready(function() {
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

            function renderWorkingHours(selectedDate) {
                if (isRendered) {
                    $(".timeContainer").empty(); // Clear existing working hours
                }
                var container = $(".timeContainer");
                for (var i = 0; i < workingHours.length; i++) {
                    (function() {
                        var workingHour = workingHours[i];
                        var button = $("<button>")
                            .addClass("btn btn-outline-primary")
                            .attr("type", "button")
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
                            console.log("checkIn:", checkIn);
                            console.log("checkOut:", checkOut);
                            $('#checkInTime').val(checkIn);
                            $('#checkOutTime').val(checkOut);
                            checkDataFullFill();
                        });

                        container.append(button);

                    })();
                }
                checkDataFullFill();
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
                if (isRendered) {
                    $(".timeContainer").empty(); // Clear existing working hours
                }
                spinner('start');
                setTimeout(() => {
                    renderWorkingHours(selectedDate);
                    spinner('stop');
                }, 500);
                isRendered = true;
            });

            // Trigger the change event when the datepicker is loaded
            $("#datepicker").trigger("change");
        }

        function checkDataFullFill() {
            const submitButton = $('.button-apply-booking');
            var checkIn = $('#checkInTime').val();
            var checkOut = $('#checkOutTime').val();
            // var memberFamily = $('#member_family_id').val();
            // var department = $('#department_id').val();
            if (checkIn && checkOut) {
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
                submitButton.text('Bạn phải điền đầy đủ thông tin');
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

            this.submit(); // Submit the form with the updated action
        });
    </script>
@endsection
