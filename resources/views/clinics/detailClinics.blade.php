@extends('layouts.master')
@section('title', 'Booking Clinic')
@section('content')
    @include('layouts.partials.header')
    @include('component.banner')

    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/foundation/6.1.0/foundation.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css">

    <link href="{{ asset('css/detailclinics.css') }}" rel="stylesheet">

    {{--    @include('What-free.header-wFree')--}}
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
    </div>

    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAl8bmtXj3F5lPG_mbD5Pj9mGSu2LCzrrE"></script>
    <script>
        let accessToken = `Bearer ` + token;
        var locations = {!! json_encode($coordinatesArray) !!};
        var jsonServices = {!! json_encode($services) !!};
        var infoWindows = [];

        function getCurrentLocation(callback) {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function (position) {
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

            locations.forEach(function (location) {
                var distance = calculateDistance(
                    currentLocation.lat, currentLocation.lng,
                    parseFloat(location.latitude), parseFloat(location.longitude)
                );

                // Chọn bán kính tìm kiếm (ví dụ: 5 km)
                var searchRadius = 10;

                if (distance <= searchRadius) {
                    var marker = new google.maps.Marker({
                        position: {lat: parseFloat(location.latitude), lng: parseFloat(location.longitude)},
                        map: map,
                        title: 'Location'
                    });

                    var infoWindowContent = `<div class="p-0 m-0 tab-pane fade show active background-modal b-radius" id="modalBooking">
                <div>
                    @php
                        $str = $bookings->gallery;
                        $parts = explode(',', $str);
                    @endphp
                    <img loading="lazy" class="b-radius" src="{{$parts[0]}}" alt="img">
                </div>
                <div class="p-3">
                    <div class="form-group">
                        <div class="d-flex justify-content-between mt-md-2">
                            <div class="fs-18px">{{$bookings->name}}</div>
                            <div class="button-follow fs-12p ">
                                <a class="text-follow-12" href="">{{ __('home.FOLLOW') }}</a>
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
                        <span class="fs-14 font-weight-600">{{$bookings->address_detail}}</span>
                        </div>
                        <div class="mt-md-2">
                            <i class="text-gray mr-md-2 fa-regular fa-clock"></i>
                            <span class="fs-14 font-weight-600">Open: {{ \Carbon\Carbon::parse($bookings->open_date)->format('H:i') }} - {{ \Carbon\Carbon::parse($bookings->close_date)->format('H:i') }}</span>
                        </div>
                        <div class="mt-md-2">
                            <i class="text-gray mr-md-2 fa-solid fa-globe"></i>
                            <span class="fs-14 font-weight-600"> {{$bookings->email}}</span>
                        </div>
                        <div class="mt-md-2">
                            <i class="text-gray mr-md-2 fa-solid fa-phone-volume"></i> <span
                                class="fs-14 font-weight-600">{{$bookings->phone}}</span>
                        </div>
                        <div class="mt-md-2 mb-md-2">
                            <i class="text-gray mr-md-2 fa-solid fa-bookmark"></i> <span
                                class="fs-14 font-weight-600"> {{$bookings->type}}</span>
                        </div>
                        {{--Review clinics--}}
                    <div id="list-review">
                        @foreach($reviews as $review)
                    <div class="border-top">
@php
                        $user_review = \App\Models\User::find($review->user_id);
                    @endphp
                    <div class="d-flex justify-content-between rv-header align-items-center mt-md-2">
@if($user_review)
                    <div class="d-flex rv-header--left">
                        <div class="avt-24 mr-md-2">
                            <img loading="lazy" src="{{asset($user_review->avt)}}">
                                                            </div>
                                                            <p class="fs-16px">{{ $user_review->username }}</p>
                                                    </div>
                                                @else
                    <div class="d-flex rv-header--left">
                        <div class="avt-24 mr-md-2">
                            <img loading="lazy" src="{{asset('img/detail_doctor/ellipse _14.png')}}">
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

                    marker.addListener('click', function () {
                        closeAllInfoWindows();
                        infoWindow.open(map, marker);
                    });

                    infoWindows.push(infoWindow);
                }
            });
        }

        function closeAllInfoWindows() {
            infoWindows.forEach(function (infoWindow) {
                infoWindow.open();
            });
        }

        getCurrentLocation(function (currentLocation) {
            initMap(currentLocation, locations);
        });

        function addNewAddress() {
            var newAddress = document.getElementById('newAddress').value;

            if (newAddress) {
                var geocoder = new google.maps.Geocoder();
                geocoder.geocode({'address': newAddress}, function (results, status) {
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
                            center: {lat: parseFloat(latitude), lng: parseFloat(longitude)},
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
                success: function (response) {
                    renderService(response);
                },
                error: function (exception) {
                }
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
        $(document).ready(function () {
            $(document).on('click', '#modalToggle', async function () {

                if ('{{ !Auth::check() }}') {
                    alert('{{ __('home.Please login to continue') }}');
                    return;
                }

                let response = await fetch('{{ route('api.survey.get-by-department', $bookings->department) }}', {
                    method: 'GET',
                    headers: {
                        "Authorization": accessToken
                    },
                });

                if (response.ok) {
                    response = await response.json();
                }

                if (response.length === 0) {
                    modalToggleQuestion();
                    return;
                }

                var html = `<form method="post" action="{{route('clinic.booking.store')}}" class="p-3">
                @csrf`

                response.forEach((item) => {
                    const idQuestion = item.id;

                    let typeQuestion = item.type;
                    if (typeQuestion === '{{ \App\Enums\SurveyType::TEXT }}') {
                        html += `<div class="form-group">`
                        html += `<label for="exampleInputEmail1">${item.question}</label>`;
                        html += `<input type="text" class="form-control" data-id-question="${idQuestion}" data-type="text-answer" name="survey[${idQuestion}]" placeholder="{{ __('home.Nhập vào câu trả lời') }}">`;
                        html += `</div>`;
                    } else {
                        if (typeQuestion === '{{ \App\Enums\SurveyType::MULTIPLE }}') {
                            typeQuestion = 'checkbox';
                        }
                        if (typeQuestion === '{{ \App\Enums\SurveyType::RADIO }}') {
                            typeQuestion = 'radio';
                        }
                        html += `<div class="form-group">`
                        html += `<label class="form-check-label" for="exampleInputEmail1">${item.question}</label>`;

                        item.survey_answers.forEach((answer) => {

                            html += `<div class="form-check">`;

                            html += `<input type="${typeQuestion}" data-type="${typeQuestion}-answer" class=form-check-input data-id-question="${idQuestion}" data-id-answer="${answer.id}"
                                     name="survey-answer-${idQuestion}">`;
                            html += `<label class="form-check-label" for="exampleInputEmail1">${answer.answer}</label>`;

                            html += `</div>`;
                        });
                        html += `</div>`;
                    }

                });

                html += `<button onclick="modalToggleQuestion()" data-toggle="modal" data-target="#exampleModal"
                                class="w-100 btn btn-secondary border-button-address font-weight-800 fs-14 justify-content-center"
                                >{{ __('home.Next') }}
                </button>
                </form>`;
                $('#modalBooking').empty().append(html);

            });
        });

        function getValueSurvey() {
            let arrayResultText = [];
            let arrayResultCheckbox = [];
            let arrayResultRadio = [];

            $('input[data-type="text-answer"]').each(function () {
                if ($(this).val()) {
                    let result_text = $(this).data('id-question') + '-' + $(this).val();
                    arrayResultText.push(result_text);
                }
            });

            const checkboxInputs = $('input[data-type="checkbox-answer"]:checked');

            let checkboxAnswer = $(checkboxInputs[0]).data('id-question') + '-';


            for (let i = 0; i < checkboxInputs.length; i++) {
                let item = $(checkboxInputs[i]);

                let currentQuestion = item.data('id-question');
                let currentAnswer = item.data('id-answer');
                let nextQuestion = $(checkboxInputs[i + 1]).data('id-question');

                if (currentQuestion === nextQuestion) {
                    checkboxAnswer += currentAnswer + ',';
                } else {
                    checkboxAnswer += currentAnswer + ',';

                    checkboxAnswer = checkboxAnswer.substring(0, checkboxAnswer.length - 1);

                    arrayResultCheckbox.push(checkboxAnswer);

                    if (i === checkboxInputs.length - 1) {
                        break;
                    }

                    checkboxAnswer = nextQuestion + '-';
                }
            }

            $('input[data-type="radio-answer"]:checked').each(function () {
                let result_radio = $(this).data('id-question') + '-' + $(this).data('id-answer');
                arrayResultRadio.push(result_radio);
            });

            // delete localStorage
            window.localStorage.removeItem('result_text');
            window.localStorage.removeItem('result_checkbox');
            window.localStorage.removeItem('result_radio');

            window.localStorage.setItem('result_text', JSON.stringify(arrayResultText));
            window.localStorage.setItem('result_checkbox', JSON.stringify(arrayResultCheckbox));
            window.localStorage.setItem('result_radio', JSON.stringify(arrayResultRadio));

        }

        async function modalToggleQuestion() {
            await getValueSurvey();

            let service = localStorage.getItem('services');
            var html = `<form method="post" action="{{route('clinic.booking.store')}}" class="p-3">
            @csrf

            <input type="hidden" name="survey_text" value='${window.localStorage.getItem('result_text')}'>
                    <input type="hidden" name="survey_checkbox" value='${window.localStorage.getItem('result_checkbox')}'>
                    <input type="hidden" name="survey_radio" value='${window.localStorage.getItem('result_radio')}'>


                <div class="fs-18px justify-content-start d-flex mb-md-4 mt-2">
                    <div class="align-items-center">
                    <a href="{{route('clinic.detail',$bookings->id)}}"><i class="fa-solid fa-chevron-left"></i></a>
                </div>
                <div class="ml-2">
                    <span>{{$bookings->name}}</span>
                             </div>
                                </div>
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
                                                    <div class="master-container-slots">
                                                        <div class="morning-container fs-16px">
                                                            <p>AM</p>
                                                            <div class="flex-container-morning"></div>
                                                        </div>
                                                        <div class="afternoon-container fs-16px">
                                                            <p>PM</p>
                                                            <div class="flex-container-afternoon"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <input hidden="" type="text" id="selectedTime" name="selectedTime"
                                                       readonly>
                                            </div>
                                        </section>
                                    </div>
                                </div>
                                <div class="border-bottom fs-16px mb-md-3">
                                     @if(Auth::check())
            <span>{{ __('home.select member family') }}</span>
                                        </div>
                                        <div class="mt-1">
                                        Bản thân
                                        <select class="form-control" name="member_family_id" id="member_family_id">
                                        <option value="">{{ __('home.Bản thân') }}</option>
                                        @foreach($memberFamily as $member)
            <option value="{{$member->id}}">{{$member->name}}</option>
                                        @endforeach
            </select>
                </div>
@endif
            <div class="border-bottom fs-16px mb-md-3">
            <span>{{ __('home.Main service') }}</span>
            <div class="mt-1">
                                        Select Department
                                          <div id="list-department">
                                          </div>
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
        @if(Auth::check())
            <input id="user_id" name="user_id" value="{{ Auth::user()->id }}">
        @endif

            </div>

            <button class="btn mt-4 btn-primary btn-block up-date-button button-apply-booking" id="activate">Apply
            </button>
        </form>
`;
            $('#modalBooking').empty().append(html);
            loadData();
            let clinicID = `{{ $bookings->id }}`;
            await getDepartment(clinicID);
            await getDoctor(clinicID, $('#department_id').find(':selected').val());
        }

        function loadData() {
            let cachedData = {};

            function serviceCallSlots(date) {
                const dt = new Date(date);
                let ms = dt.getTime();
                let startMs = ms - (60 * 60 * 24 * 1000 * 2);
                const dtArr = [1, 2, 3, 4, 5].map((e) => {
                    const innerDt = new Date(startMs);
                    startMs += 60 * 60 * 24 * 1000;
                    return innerDt;
                });
                const timeArrs = [
                    ['9', '10', '11', '12', '1', '2', '3', '4', '5'],
                    ['9', '10', '11', '1', '2', '3', '4', '5'],
                    ['9', '10', '11', '12', '3', '4', '5'],
                    ['10', '11', '2', '4'],
                    ['11', '12', '1', '4', '5']
                ];
                return new Promise((resolve, reject) => {
                    setTimeout(() => {
                        const obj = dtArr.reduce((accum, e) => {
                            const randomNum = Math.floor(Math.random() * 5);
                            const dtString = e.toLocaleDateString();
                            let parts = dtString.split('/');
                            parts[0] = parts[0].length === 1 ? '0' + parts[0] : parts[0];
                            parts[1] = parts[1].length === 1 ? '0' + parts[1] : parts[1];
                            accum[parts.join('/')] = timeArrs[randomNum];
                            return accum;
                        }, {});
                        resolve(obj);
                    }, 2000);
                })
            }

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

            function createSlotsDom(formSubmit, morning, afternoon, arr) {
                [9, 10, 11, 12, 1, 2, 3, 4, 5].map((e) => {
                    const div = document.createElement('div');
                    div.setAttribute('class', 'item');

                    const anchor = document.createElement('a');
                    anchor.setAttribute('class', 'hollow button');
                    anchor.setAttribute('href', 'javascript:void(0)');

                    const time = (e < 10 ? '0' : '') + e + ':00';
                    const txt = document.createTextNode(time);
                    anchor.appendChild(txt);

                    anchor.onclick = function (event) {
                        const selectedTime = event.target.innerText;
                        let date = document.getElementById('check_in').value;
                        const selectedDateTime = date + ' ' + selectedTime;

                        document.getElementById('selectedTime').value = selectedDateTime;

                        formSubmit.classList.remove('disabled');
                    }

                    if (!arr.filter(r => r == e).length) {
                        anchor.setAttribute('disabled', 'true');
                    }

                    div.appendChild(anchor);

                    if (e >= 9 && e < 12) {
                        morning.appendChild(div);
                    } else {
                        afternoon.appendChild(div);
                    }
                });
            }

            $("#datepicker").datepicker({
                onSelect: function (date) {
                    const container = document.querySelector('.master-container-slots');
                    const morning = document.querySelector('.flex-container-morning');
                    const afternoon = document.querySelector('.flex-container-afternoon');
                    const formSubmit = document.querySelector('.button-apply-booking');
                    const checkInInput = document.getElementById('check_in');

                    formSubmit.classList.add('disabled');
                    container.classList.add('hide');

                    if (cachedData[date]) {
                        spinner('start');
                        setTimeout(() => {
                            morning.innerHTML = '';
                            afternoon.innerHTML = '';
                            createSlotsDom(formSubmit, morning, afternoon, cachedData[date]);
                            spinner('stop');
                            container.classList.remove('hide');
                            container.classList.add('fade-in');
                            checkInInput.value = date;
                        }, 500);
                    } else {
                        spinner('start');
                        const prom = serviceCallSlots(date);
                        setTimeout(() => {
                            morning.innerHTML = '';
                            afternoon.innerHTML = '';
                            prom.then((payload) => {
                                Object.keys(payload).map((e) => {
                                    const cachedKeys = Object.keys(cachedData);
                                    if (!cachedKeys.includes(e)) {
                                        cachedData[e] = payload[e];
                                    }
                                });
                                createSlotsDom(formSubmit, morning, afternoon, cachedData[date]);
                                spinner('stop');
                                container.classList.remove('hide');
                                container.classList.add('fade-in');
                                checkInInput.value = date;
                            });
                        }, 500);
                    }
                    document.getElementById('check_in').value = date;
                }
            });
        }

    </script>
    <script>
        async function getDoctor(clinic, department) {
            await $.ajax({
                url: `{{ route('restapi.list.doctor.clinics.department') }}?clinic_id=${clinic}&department_id=${department}`,
                method: 'GET',
                success: function (response) {
                    console.log(response)
                    renderDoctor(response);
                },
                error: function (exception) {
                    console.log(exception);
                }
            });
        }

        function renderDoctor(response) {
            let html = ``;

            for (let i = 0; i < response.length; i++) {
                let data = response[i];
                html += `<option value="${data.id}">${data.username}-${data.email}</option>`
            }

            let main_html = `<select class="form-control"
                                        name="doctor_id" id="doctor_id">
                                            ${html}
                                       </select>`;
            $('#list-doctor').empty().append(main_html);
        }

        async function getDepartment(clinic) {
            await $.ajax({
                url: `{{ route('restapi.list.departments.clinics') }}?clinic_id=${clinic}`,
                method: 'GET',
                success: function (response) {
                    console.log(response)
                    renderDepartment(response, clinic);
                },
                error: function (exception) {
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

            let main_html = `<select onchange="getDoctor(${clinic}, $('#department_id').find(':selected').val())" class="form-control"
                                        name="department_id" id="department_id">
                                            ${html}
                                       </select>`;
            $('#list-department').empty().append(main_html);
        }
    </script>
@endsection
