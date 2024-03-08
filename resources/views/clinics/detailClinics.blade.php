@extends('layouts.master')
@section('title', 'Booking Clinic')
@section('content')
    @include('layouts.partials.header')
    @include('component.banner')

    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/foundation/6.1.0/foundation.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css">

    <link href="{{ asset('css/detailclinics.css') }}" rel="stylesheet">

    {{--    @include('What-free.header-wFree') --}}
    <div class="container mt-150">
        @php
            $addresses = \App\Models\Clinic::where('id', $bookings->id)->get();
            $coordinatesArray = $addresses->toArray();
        @endphp
        <div id="allAddressesMap" class="show active fade" style="height: 800px;">

        </div>

        <div class="other-clinics">
            <div class="title">
                {{ __('home.Other Clinics/Pharmacies') }}
            </div>

            @include('component.clinic')

        </div>
        <div class="d-none">
            <input id="room_id" name="room_id" value="{{ $bookings->id }}">
            <input id="check_in" name="check_in" value="">
            <input id="check_out" name="check_out" value="">
        </div>

        <!-- Modal -->
        <div class="modal fade" id="modalBookingProcess" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
            aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="staticBackdropLabel">{{ $bookings->name ?? '' }}</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form method="post" action="{{ route('clinic.booking.store') }}" class="p-3">
                            @csrf
                            <div class="mb-md-4">
                                <div class="border-bottom fs-16px">
                                    <span>{{ __('home.Booking') }}</span>
                                </div>
                                <div class="mt-md-3">
                                    <section>
                                        <div class=" d-block">
                                            <div class="small-12 ">
                                                <div id="datepicker"></div>
                                            </div>
                                            <div class="small-12 ">
                                                <div class="spin-me"></div>
                                                <div class="container">
                                                    <div class="row">
                                                        <div class="col-12 timeContainer">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <input type="hidden" id="checkInTime" name="checkInTime">
                                            <input type="hidden" id="checkOutTime" name="checkOutTime">
                                        </div>
                                    </section>
                                </div>
                            </div>
                            @if (Auth::check())
                                <div class="border-bottom fs-16px mb-md-3">
                                    <span>{{ __('home.select member family') }}</span>
                                </div>
                                <div class="mt-1">
                                    Bản thân
                                    <select class="form-control" name="member_family_id" id="member_family_id">
                                        <option value="">{{ __('home.Bản thân') }}</option>
                                        @foreach ($memberFamily as $member)
                                            <option value="{{ $member->id }}">{{ $member->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            @endif
                            <div class="border-bottom fs-16px mb-md-3">
                                <span>{{ __('home.Main service') }}</span>
                                <div class="mt-1">
                                    Select Department
                                    <select onchange="getDoctor({{ $bookings->id }}, this.value)" class="form-select"
                                        name="department_id" id="department_id">
                                    </select>
                                </div>
                            </div>
                            <div class="border-bottom fs-16px mb-md-3">
                                <span>{{ __('home.Doctor Name') }}</span>
                                <div class="mt-1">
                                    Select Doctor
                                    <div id="list-doctor">
                                        <select class="form-control">
                                            <option value="#">Please choose doctor</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="border-bottom mt-md-4 fs-16px mb-md-3">
                                <span>{{ __('home.Information') }}</span>
                            </div>
                            <div class="fs-14 font-weight-600">
                                <span>
                                    {!! $bookings->introduce !!}
                                </span>
                            </div>
                            <div hidden="">
                                <input id="clinic_id" name="clinic_id" value="{{ $bookings->id }}">
                                @if (Auth::check())
                                    <input id="user_id" name="user_id" value="{{ Auth::user()->id }}">
                                @endif

                            </div>

                            <button class="btn mt-4 btn-primary btn-block up-date-button button-apply-booking"
                                id="activate">Đặt lịch ngay
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAl8bmtXj3F5lPG_mbD5Pj9mGSu2LCzrrE"></script>
    <script>
        let accessToken = `Bearer ` + token;
        var locations = {!! json_encode($coordinatesArray) !!};
        var jsonServices = {!! json_encode($services) !!};
        var infoWindows = [];

        function getCurrentLocation(callback) {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function(position) {
                    var currentLocation = {
                        lat: position.coords.latitude,
                        lng: position.coords.longitude
                    };
                    callback(currentLocation);
                });
            } else {
                alert('Geolocation is not supported by this browser.');
            }
        }

        function calculateDistance(lat1, lng1, lat2, lng2) {
            var R = 6371; // Độ dài trung bình của trái đất trong km
            var dLat = toRadians(lat2 - lat1);
            var dLng = toRadians(lng2 - lng1);

            var a = Math.sin(dLat / 2) * Math.sin(dLat / 2) +
                Math.cos(toRadians(lat1)) * Math.cos(toRadians(lat2)) *
                Math.sin(dLng / 2) * Math.sin(dLng / 2);

            var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));

            var distance = R * c;
            return distance;
        }

        function toRadians(degrees) {
            return degrees * (Math.PI / 180);
        }

        function initMap(currentLocation, locations) {
            var map = new google.maps.Map(document.getElementById('allAddressesMap'), {
                center: currentLocation,
                zoom: 10
            });

            var currentLocationMarker = new google.maps.Marker({
                position: currentLocation,
                map: map,
                title: 'Your Location'
            });

            locations.forEach(function(location) {
                var distance = calculateDistance(
                    currentLocation.lat, currentLocation.lng,
                    parseFloat(location.latitude), parseFloat(location.longitude)
                );

                // Chọn bán kính tìm kiếm (ví dụ: 5 km)
                var searchRadius = 10;

                if (distance <= searchRadius) {
                    var marker = new google.maps.Marker({
                        position: {
                            lat: parseFloat(location.latitude),
                            lng: parseFloat(location.longitude)
                        },
                        map: map,
                        title: 'Location'
                    });

                    var infoWindowContent = `<div class="p-0 m-0 tab-pane fade show active background-modal b-radius" id="modalBooking">
                <div>
                    @php
                        $str = $bookings->gallery;
                        $parts = explode(',', $str);
                    @endphp
                    <img loading="lazy" class="b-radius" src="{{ $parts[0] }}" alt="img">
                </div>
                <div class="p-3">
                    <div class="form-group">
                        <div class="d-flex justify-content-between mt-md-2">
                            <div class="fs-18px">{{ $bookings->name }}</div>
                            <div class="button-follow fs-12p ">
                                <div style="margin-left: 10px;margin-top: 20px;">
                                    @if (Auth::check())
                                        <div class="zalo-follow-only-button" data-callback="userFollowZaloOA" data-oaid="4438562505337240484"></div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="d-flex mt-md-2">
                            <div class="d-flex col-md-6 justify-content-center align-items-center">
                                <a class="row p-2" href="">
                                    <div class="justify-content-center d-flex">
                                        <i class="border-button-address fa-solid fa-bullseye"></i>
                                    </div>
                                    <div class="d-flex justify-content-center">{{ __('home.Start') }}</div>
                                </a>
                            </div>
                            <div class="d-flex col-md-6 justify-content-center align-items-center">
                                <a class="row p-2" href="">
                                    <div class="justify-content-center d-flex">
                                        <i class="border-button-address fa-regular fa-circle-right"></i>
                                    </div>
                                    <div class="d-flex justify-content-center">{{ __('home.Direction') }}</div>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="mt-md-3 mb-md-3">
                        <button id="modalToggle" data-toggle="modal" data-target="#exampleModal"
                                class="w-100 btn btn-secondary border-button-address font-weight-800 fs-14 justify-content-center"
                                >{{ __('home.Booking') }}
                    </button>
                </div>
                <div class="border-top">
                    <div class="mt-md-2"><i class="text-gray mr-md-2 fa-solid fa-location-dot"></i>
                        <span class="fs-14 font-weight-600">{{ $bookings->address_detail }}</span>
                        </div>
                        <div class="mt-md-2">
                            <i class="text-gray mr-md-2 fa-regular fa-clock"></i>
                            <span class="fs-14 font-weight-600">Open: {{ \Carbon\Carbon::parse($bookings->open_date)->format('H:i') }} - {{ \Carbon\Carbon::parse($bookings->close_date)->format('H:i') }}</span>
                        </div>
                        <div class="mt-md-2">
                            <i class="text-gray mr-md-2 fa-solid fa-globe"></i>
                            <span class="fs-14 font-weight-600"> {{ $bookings->email }}</span>
                        </div>
                        <div class="mt-md-2">
                            <i class="text-gray mr-md-2 fa-solid fa-phone-volume"></i> <span
                                class="fs-14 font-weight-600">{{ $bookings->phone }}</span>
                        </div>
                        <div class="mt-md-2 mb-md-2">
                            <i class="text-gray mr-md-2 fa-solid fa-bookmark"></i> <span
                                class="fs-14 font-weight-600"> {{ $bookings->type }}</span>
                        </div>
                        {{-- Review clinics --}}
                    <div id="list-review">
                        @foreach ($reviews as $review)
                    <div class="border-top">
@php
    $user_review = \App\Models\User::find($review->user_id);
@endphp
                    <div class="d-flex justify-content-between rv-header align-items-center mt-md-2">
@if ($user_review)
                    <div class="d-flex rv-header--left">
                        <div class="avt-24 mr-md-2">
                            <img loading="lazy" src="{{ asset($user_review->avt) }}">
                                                            </div>
                                                            <p class="fs-16px">{{ $user_review->username }}</p>
                                                    </div>
                                                @else
                    <div class="d-flex rv-header--left">
                        <div class="avt-24 mr-md-2">
                            <img loading="lazy" src="{{ asset('img/detail_doctor/ellipse _14.png') }}">
                                                            </div>
                                                            <p class="fs-16px">Guest</p>
                                                    </div>
                                                @endif
                    <div class="rv-header--right">
                        <p class="fs-14 font-weight-400">{{ $review->created_at }}</p>
                                                    </div>
                                                </div>
                                                <div class="content">
                                                    <p>
                                                        {!! $review->content !!}
                    </p>
                </div>
            </div>
@endforeach
                    </div>
                                    </div>
                                </div>
                            </div>`;

                    var infoWindow = new google.maps.InfoWindow({
                        content: infoWindowContent
                    });

                    marker.addListener('click', function() {
                        closeAllInfoWindows();
                        infoWindow.open(map, marker);
                    });

                    infoWindows.push(infoWindow);
                }
            });
        }

        function closeAllInfoWindows() {
            infoWindows.forEach(function(infoWindow) {
                infoWindow.open();
            });
        }

        getCurrentLocation(function(currentLocation) {
            initMap(currentLocation, locations);
        });

        function addNewAddress() {
            var newAddress = document.getElementById('newAddress').value;

            if (newAddress) {
                var geocoder = new google.maps.Geocoder();
                geocoder.geocode({
                    'address': newAddress
                }, function(results, status) {
                    if (status == google.maps.GeocoderStatus.OK) {
                        var latitude = results[0].geometry.location.lat();
                        var longitude = results[0].geometry.location.lng();

                        if (!isNaN(latitude) && !isNaN(longitude)) {
                            saveAddress(newAddress, latitude, longitude, 'map-new-' + new Date().getTime());
                        } else {
                            console.error('Invalid coordinates:', latitude, longitude);
                            alert('Invalid coordinates. Please try again.');
                        }
                    } else {
                        alert('Geocode was not successful for the following reason: ' + status);
                    }
                });
            }
        }

        function saveAddress(address, latitude, longitude, mapId) {
            var formData = new FormData();
            formData.append('address', address);
            formData.append('latitude', latitude);
            formData.append('longitude', longitude);

            fetch('/save-address', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    },
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        var map = new google.maps.Map(document.getElementById(mapId), {
                            center: {
                                lat: parseFloat(latitude),
                                lng: parseFloat(longitude)
                            },
                            zoom: 15
                        });
                    } else {
                        alert('Failed to save address. Please try again.');
                    }
                })
                .catch(error => console.error('Error:', error));
        }

        readService();

        async function readService() {
            let url = '{{ route('api.backend.service.clinic.list.clinics', $id) }}';
            await $.ajax({
                url: url,
                method: 'GET',
                headers: {
                    "Authorization": accessToken
                },
                success: function(response) {
                    renderService(response);
                },
                error: function(exception) {}
            });
        }

        function renderService(response) {
            let services = ``;
            for (let i = 0; i < response.length; i++) {
                let data = response[i];
                services = services + `<div class="d-flex justify-content-between mt-md-2 mt-1 border-booking-sv align-items-center">
                                    <div class="fs-14 font-weight-600">
                                        <span>${data.name}</span>
                                    </div>
                                    <div class="checkbox-button">
                                        <input type="checkbox" id="myCheckbox${data.id}" value="${data.id}" name="service[]">
                                        <label for="myCheckbox${data.id}">{{ __('home.Booking') }}</label>
                                    </div>
                                </div>`;
            }
            localStorage.setItem('services', services);
        }
    </script>
    <script>
        $(document).ready(function() {

            $(document).on('click', '#modalToggle', async function() {

                if ('{{ !Auth::check() }}') {
                    alert('{{ __('home.Please login to continue') }}');
                    return;
                }

                //Check user followed
                let followed = await fetch(
                    '{{ route('zalo-follower.show', Auth::user()->id ?? 0) }}', {
                        method: 'GET',
                        // headers: {
                        //     "Authorization": accessToken
                        // },
                    });

                if (followed.ok) {
                    followed = await followed.json();
                    console.log(followed.error)
                    if (followed.error != 0) {
                        alert('Bạn chưa follow phòng khám này');
                        return;
                    }
                }
                //Check user followed

                let response = await fetch(
                    '{{ route('api.survey.get-by-department', $bookings->department) }}', {
                        method: 'GET',
                        headers: {
                            "Authorization": accessToken
                        },
                    });

                if (response.ok) {
                    response = await response.json();
                }

                modalToggleQuestion();

            });
        });

        function checkDataFullFill() {
            const submitButton = $('.button-apply-booking');
            var checkIn = $('#checkInTime').val();
            var checkOut = $('#checkOutTime').val();
            // var memberFamily = $('#member_family_id').val();
            var department = $('#department_id').val();
            var doctor = $('#doctor_id').val();
            if (checkIn && checkOut && department && doctor) {
                // All values are not null or undefined
                submitButton.text('Đặt lịch ngay');
                submitButton.attr("disabled", false);
            } else {
                // At least one value is null or undefined
                submitButton.text('Bạn phải điền đầy đủ thông tin');
                submitButton.attr("disabled", true);
            }
        }

        async function modalToggleQuestion() {
            let service = localStorage.getItem('services');
            $('#modalBookingProcess').modal("show");
            checkDataFullFill();
            loadData();
            let clinicID = `{{ $bookings->id }}`;
            await getDepartment(clinicID);
            await getDoctor(clinicID, $('#department_id').find(':selected').val());
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
                var container = $(".timeContainer");
                for (var i = 0; i < workingHours.length; i++) {
                    var workingHour = workingHours[i];
                    var button = $("<button>")
                        .addClass("btn btn-outline-primary")
                        .attr("type", "button")
                        .css({
                            'margin-right': '7px',
                            'margin-bottom': '5px'
                        })
                        .text(workingHour)
                        .on("click", function() {
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
    </script>
    <script>
        async function getDoctor(clinic, department) {
            await $.ajax({
                url: `{{ route('restapi.list.doctor.clinics.department') }}?clinic_id=${clinic}&department_id=${department}`,
                method: 'GET',
                success: function(response) {
                    renderDoctor(response);
                    checkDataFullFill();
                },
                error: function(exception) {
                    console.log(exception);
                }
            });
        }

        function renderDoctor(response) {
            let html = ``;

            if (response.length == 0) {
                //NULL DOCTOR
                let main_html = `<select class="form-control" disable><option>Không có bác sĩ hoạt động</option></select>`;
                $('#list-doctor').empty().append(main_html);
            } else {
                for (let i = 0; i < response.length; i++) {
                    let data = response[i];
                    html += `<option value="${data.id}">${data.username}-${data.email}</option>`
                }

                let main_html = `<select class="form-control"
                                        name="doctor_id" id="doctor_id">
                                            ${html}
                                       </select>`;
                $('#list-doctor').empty().append(main_html);
                checkDataFullFill();
            }
        }

        async function getDepartment(clinic) {
            await $.ajax({
                url: `{{ route('restapi.list.departments.clinics') }}?clinic_id=${clinic}`,
                method: 'GET',
                success: function(response) {
                    console.log(response)
                    renderDepartment(response, clinic);
                },
                error: function(exception) {
                    console.log(exception);
                }
            });
        }

        function renderDepartment(response, clinic) {
            let html = ``;

            for (let i = 0; i < response.length; i++) {
                let data = response[i];
                html += `<option value="${data.id}">${data.name}</option>`
            }

            if (response.length < 1) {
                html = `<option value="">No doctor</option>`;
            }

            $('#department_id').empty().append(html);
            checkDataFullFill();
        }
    </script>
@endsection
