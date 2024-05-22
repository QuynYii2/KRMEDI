@php use App\Models\Province; @endphp

@extends('layouts.master')
@section('title', 'Specialist')
@section('content')
    <link rel="stylesheet" href="{{ asset('css/homeSpecialist.css') }}">
    @include('layouts.partials.header')
    <div class="container mt-200 mt-70 box-ck-new-home">
        <div class="danh-sach-theo-chuyen-khoa">
            <a href="{{ route('home.specialist') }}">
                <div class="title-Danh-sach"><i class="fa-solid fa-arrow-left"></i> {{ __('home.Danh sách') }}</div>
            </a>
            <form>
                <div class="search-specialist col-lg-8 col-md-10">
                    <label for="search-specialist" class="search-specialist__label w-50">
                        <i class="fas fa-search"></i>
                        <input id="search-specialist" name="q" placeholder="{{ __('home.Tìm kiếm cơ sở y tế') }}" value="{{ request()->query('q') }}">
                    </label>
                    <div class="position-absolute">|</div>
                    <label class="select-specialist__label w-50">
                        <i class="fas fa-map-marker-alt"></i>
                        <select name="location">
                            <option value="">{{ __('home.Tất cả địa điểm') }}</option>
                            <option value="Hà Nội" {{ request()->query('location') == 'Hà Nội' ? 'selected' : '' }}>Hà Nội</option>
                        </select>
                    </label>
                </div>
            </form>


            <div class="d-flex nav-header--homeNew justify-content-center mt-3">
                <ul class="nav nav-pills nav-fill d-flex justify-content-between">
                    <li class="nav-item">
                        <a class="nav-link active font-14-mobi" id="clinicList-tab" data-toggle="tab" href="#clinicList"
                            role="tab" aria-controls="clinicList" aria-selected="true">{{ __('home.HOSPITALS') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link font-14-mobi" id="pharmacies-tab" data-toggle="tab" href="#pharmacies"
                            role="tab" aria-controls="pharmacies" aria-selected="false">{{ __('home.CLINICS') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link font-14-mobi" id="doctorList-tab" data-toggle="tab" href="#doctorList"
                            role="tab" aria-controls="doctorList" aria-selected="true">{{ __('home.DOCTOR') }}</a>
                    </li>
                </ul>
            </div>
            <div class="tab-content mt-4" id="myTabContent">
                <div class="tab-pane fade show active" id="clinicList" role="tabpanel" aria-labelledby="clinicList-tab">
                    <div class="box-list-clinic-address">
                        <div class="body row" id="productInformation">
                            @foreach ($clinics as $clinic)
                                <div class="specialList-clinics col-lg-12 col-md-6 mb-3" data-clinic-id="{{ $clinic->id }}">
                                    <div class="border-specialList">
                                        <div class="content__item d-flex gap-3 box-item__content">
                                            <div class="specialList-clinics--img img-special-line">
                                                @php
                                                    $galleryArray = explode(',', $clinic->gallery);
                                                @endphp
                                                <img class="content__item__image" src="{{ $galleryArray[0] }}" alt="" />
                                            </div>
                                            <div class="specialList-clinics--main w-100">
                                                <div class="title-specialList-clinics">
                                                    {{ $clinic->name }}
                                                </div>
                                                <div class="address-specialList-clinics d-flex align-items-center">
                                                    @php
                                                        $array = explode(',', $clinic->address);
                                                        $addressP = \App\Models\Province::where(
                                                            'id',
                                                            $array[1] ?? null,
                                                        )->first();
                                                        $addressD = \App\Models\District::where(
                                                            'id',
                                                            $array[2] ?? null,
                                                        )->first();
                                                        $addressC = \App\Models\Commune::where(
                                                            'id',
                                                            $array[3] ?? null,
                                                        )->first();
                                                    @endphp
                                                    <div class="d-flex align-items-center">
                                                        <i class="fas fa-map-marker-alt mr-2"></i>
                                                        <div class="text-address">{{ $clinic->address_detail }}
                                                            , {{ $addressC->name ?? '' }} , {{ $addressD->name ?? '' }}
                                                            , {{ $addressP->name ?? '' }}</div>
                                                    </div>
                                                    <span class="clinicDistanceSpan">
                                                    <p class="lat">{{ $clinic->latitude }}</p>
                                                    <p class="long">{{ $clinic->longitude }}</p>
                                                </span>
                                                </div>
                                                <div class="time-working justify-content-between mt-0">
                                                    <div style="display: inline-block">
                                                <span class="color-timeWorking">
                                                    <span
                                                        class="fs-14 font-weight-600">{{ \Carbon\Carbon::parse($clinic->open_date)->format('H:i') }}
                                                        -
                                                        {{ \Carbon\Carbon::parse($clinic->close_date)->format('H:i') }}</span>
                                                </span>
                                                    <span>
                                                    / {{ __('home.Dental Clinic') }}
                                                </span>
                                                    </div>
                                                    <button id="showMapBtn" class="search-way">Chỉ đường</button>
                                                </div>
                                                <div class="group-button d-flex mt-3">
                                                    <a href="{{ route('home.specialist.booking.detail', $clinic->id) }}"
                                                       class="col-md-6 item-btn-specialist">
                                                        <div class="button-booking-specialList line-dk-btn">
                                                            {{ __('home.Đặt khám') }}
                                                        </div>
                                                    </a>
                                                    <a href="{{ route('home.specialist.detail', $clinic->id) }}"
                                                       class="col-md-6 item-btn-specialist">
                                                        <div class="button-detail-specialList">
                                                            {{ __('home.Xem chi tiết') }}
                                                        </div>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div id="allAddressesMap" class="show active fade" style="height: 800px;">

                        </div>
                    </div>
                </div>

                <div class="tab-pane fade" id="pharmacies" role="tabpanel" aria-labelledby="pharmacies-tab">
                    <div class="box-list-clinic-address">
                        <div class="body row" id="productInformation">
                            @foreach ($pharmacies as $pharmacy)
                                <div class="specialList-clinics col-lg-12 col-md-6 mb-3" data-pharmacy-id="{{ $pharmacy->id }}">
                                    <div class="border-specialList">
                                        <div class="content__item d-flex gap-3 box-item__content">
                                            <div class="specialList-clinics--img img-special-line">
                                                @php
                                                    $galleryArray = explode(',', $pharmacy->gallery);
                                                @endphp
                                                <img class="content__item__image" src="{{ $galleryArray[0] }}"
                                                     alt="" />
                                            </div>
                                            <div class="specialList-clinics--main w-100">
                                                <div class="title-specialList-clinics">
                                                    {{ $pharmacy->name }}
                                                </div>
                                                <div class="address-specialList-clinics d-flex align-items-center">
                                                    <div class="d-flex">
                                                        <i class="fas fa-map-marker-alt mr-2"></i>
                                                        @php
                                                            $array = explode(',', $pharmacy->address);
                                                            $addressP = \App\Models\Province::where(
                                                                'id',
                                                                $array[1] ?? null,
                                                            )->first();
                                                            $addressD = \App\Models\District::where(
                                                                'id',
                                                                $array[2] ?? null,
                                                            )->first();
                                                            $addressC = \App\Models\Commune::where(
                                                                'id',
                                                                $array[3] ?? null,
                                                            )->first();
                                                        @endphp
                                                        <div>{{ $pharmacy->address_detail }}
                                                            , {{ $addressC->name ?? '' }} , {{ $addressD->name ?? '' }}
                                                            , {{ $addressP->name ?? '' }}</div>
                                                    </div>
                                                    <span class="pharmacyDistanceSpan">
                                                    <p class="lat">{{ $pharmacy->latitude }}</p>
                                                    <p class="long">{{ $pharmacy->longitude }}</p>
                                                </span>
                                                </div>
                                                <div class="time-working">
                                                <span class="color-timeWorking">
                                                    <span
                                                        class="fs-14 font-weight-600">{{ \Carbon\Carbon::parse($pharmacy->open_date)->format('H:i') }}
                                                        -
                                                        {{ \Carbon\Carbon::parse($pharmacy->close_date)->format('H:i') }}</span>
                                                                                                    09:00 - 19:00
                                                </span>
                                                    <span>
                                                    / {{ __('home.Dental Clinic') }}
                                                </span>
                                                </div>
                                                <a href="https://www.google.com/maps?q={{$pharmacy->latitude}},{{$pharmacy->longitude}}" class="search-way" target="_blank">Chỉ đường</a>
                                                <div class="group-button d-flex mt-3">
                                                    <a href="" class="col-md-6 item-btn-specialist">
                                                        <div class="button-booking-specialList line-dk-btn">
                                                            {{ __('home.Đặt khám') }}
                                                        </div>
                                                    </a>
                                                    <a href="{{route('home.specialist.detail', $pharmacy->id)}}" class="col-md-6 item-btn-specialist">
                                                        <div class="button-detail-specialList">
                                                            {{ __('home.Xem chi tiết') }}
                                                        </div>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div id="allAddressesMapPharmacies" class="show active fade" style="height: 800px;">

                        </div>
                    </div>
                </div>

                <div class="tab-pane fade" id="doctorList" role="tabpanel" aria-labelledby="doctorList-tab">
                    <div class="row">

                        @foreach ($doctorsSpecial as $doctor)
                            @if ($doctor == '')
                                <h1 class="d-flex align-items-center justify-content-center mt-4">{{ __('home.null') }}
                                </h1>
                            @else
                                <div class="col-lg-3 col-md-4 col-6">
                                    <div class="p-lg-0">
                                        <div class="product-item">
                                            <div class="img-pro h-100 justify-content-center d-flex">
                                                <img src="{{ $doctor->avt }}" alt="">
                                                <a class="button-heart" data-favorite="0">
                                                    <i id="icon-heart" class="bi-heart bi"
                                                        data-product-id="${product.id}"
                                                        onclick="addProductToWishList(${product.id})"></i>
                                                </a>
                                                <s class="icon-chuyen-khoa">
                                                    @php
                                                        $department = \App\Models\Department::where(
                                                            'id',
                                                            $doctor->department_id,
                                                        )->value('thumbnail');
                                                    @endphp
                                                    <img src="{{$department}}" class="icon-ck">
                                                </s>
                                            </div>
                                            <div class="content-pro p-3">
                                                <div class="">
                                                    <div class="name-product" style="height: auto">
                                                        <a class="name-product--fleaMarket name-doctors"
                                                           href="{{ route('examination.doctor_info', $doctor->id) }}">{{$doctor->name}}</a>
                                                    </div>
                                                    <div class="location-pro box-about-doctor box-about-doctor-specialist">
                                                        {!! $doctor->abouts !!}
                                                    </div>
                                                    <div class="price-pro">
                                                        @php
                                                            if ($doctor->province_id == null) {
                                                                $addressP = 'Ha Noi';
                                                            } else {
                                                                $addressP = \App\Models\Province::find(
                                                                    $doctor->province_id,
                                                                )->name;
                                                            }
                                                        @endphp
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="21"
                                                            height="21" viewBox="0 0 21 21" fill="none">
                                                            <g clip-path="url(#clip0_5506_14919)">
                                                                <path
                                                                    d="M4.66602 12.8382C3.12321 13.5188 2.16602 14.4673 2.16602 15.5163C2.16602 17.5873 5.89698 19.2663 10.4993 19.2663C15.1017 19.2663 18.8327 17.5873 18.8327 15.5163C18.8327 14.4673 17.8755 13.5188 16.3327 12.8382M15.4993 7.59961C15.4993 10.986 11.7493 12.5996 10.4993 15.0996C9.24935 12.5996 5.49935 10.986 5.49935 7.59961C5.49935 4.83819 7.73793 2.59961 10.4993 2.59961C13.2608 2.59961 15.4993 4.83819 15.4993 7.59961ZM11.3327 7.59961C11.3327 8.05985 10.9596 8.43294 10.4993 8.43294C10.0391 8.43294 9.66602 8.05985 9.66602 7.59961C9.66602 7.13937 10.0391 6.76628 10.4993 6.76628C10.9596 6.76628 11.3327 7.13937 11.3327 7.59961Z"
                                                                    stroke="white" stroke-width="2"
                                                                    stroke-linecap="round" stroke-linejoin="round" />
                                                            </g>
                                                            <defs>
                                                                <clipPath id="clip0_5506_14919">
                                                                    <rect width="20" height="20" fill="white"
                                                                        transform="translate(0.5 0.933594)" />
                                                                </clipPath>
                                                            </defs>
                                                        </svg> &nbsp;
                                                        {{ $addressP }}
                                                    </div>
                                                    <div class="price-pro">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="21"
                                                            height="21" viewBox="0 0 21 21" fill="none">
                                                            <g clip-path="url(#clip0_5506_14923)">
                                                                <path
                                                                    d="M10.4993 5.93294V10.9329L13.8327 12.5996M18.8327 10.9329C18.8327 15.5353 15.1017 19.2663 10.4993 19.2663C5.89698 19.2663 2.16602 15.5353 2.16602 10.9329C2.16602 6.33057 5.89698 2.59961 10.4993 2.59961C15.1017 2.59961 18.8327 6.33057 18.8327 10.9329Z"
                                                                    stroke="white" stroke-width="2"
                                                                    stroke-linecap="round" stroke-linejoin="round" />
                                                            </g>
                                                            <defs>
                                                                <clipPath id="clip0_5506_14923">
                                                                    <rect width="20" height="20" fill="white"
                                                                        transform="translate(0.5 0.933594)" />
                                                                </clipPath>
                                                            </defs>
                                                        </svg> &nbsp; {{ $doctor->time_working_1 }}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                    <div class="pagination mt-4 d-flex align-items-center justify-content-center">
                        {{ $doctorsSpecial->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            var clinics = {!! json_encode($clinics) !!};

            var pharmacies = {!! json_encode($pharmacies) !!};

            for (var i = 0; i < clinics.length; i++) {
                (function(i) {
                    var clinic = clinics[i];
                    var clinicElement = $('.specialList-clinics[data-clinic-id="' + clinic.id + '"]');
                    var distanceSpan = clinicElement.find('.clinicDistanceSpan');
                    var latitude = distanceSpan.find('.lat').text();
                    var longitude = distanceSpan.find('.long').text();

                    if (latitude && longitude) {
                        getCurrentLocation(function(currentLocation) {
                            var newDistance = calculateDistance(currentLocation.lat, currentLocation.lng,
                                parseFloat(latitude), parseFloat(longitude));

                            distanceSpan.text(newDistance.toFixed(2) + 'Km');
                        });

                        var showMapBtn = clinicElement.find('#showMapBtn');

                        showMapBtn.on('click', function() {
                            var clinicLocation = { lat: parseFloat(latitude), lng: parseFloat(longitude) };
                            document.getElementById('allAddressesMap').style.display = 'block';
                            initMap(clinicLocation, clinics);
                        });
                    } else {
                        console.error("Latitude or Longitude is missing for clinic ID:", clinic.id);
                    }
                })(i);
            }

            for (var i = 0; i < pharmacies.length; i++) {
                (function() {
                    var clinic = pharmacies[i];
                    var distanceSpan = $('.specialList-clinics[data-pharmacy-id="' + clinic.id + '"]').find(
                        '.pharmacyDistanceSpan');
                    var latitude = distanceSpan.find('.lat').text();
                    var longitude = distanceSpan.find('.long').text();

                    getCurrentLocation(function(currentLocation) {
                        var newDistance = calculateDistance(currentLocation.lat, currentLocation.lng,
                            parseFloat(latitude), parseFloat(longitude));

                        distanceSpan.text(newDistance.toFixed(2) + 'Km');
                    });
                })();
            }

            var locations = {!! json_encode($clinics) !!};
            var locationsPharmacies = {!! json_encode($pharmacies) !!};
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

            function getCurrentLocationPharmacies(callback) {
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

            function formatTime(dateTimeString) {
                const date = new Date(dateTimeString);
                const hours = date.getHours().toString().padStart(2, '0');
                const minutes = date.getMinutes().toString().padStart(2, '0');
                return `${hours}:${minutes}`;
            }

            function initMap(currentLocation, locations) {
                var map = new google.maps.Map(document.getElementById('allAddressesMap'), {
                    center: currentLocation,
                    zoom: 12.3
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
                        var urlDetail = "{{ route('clinic.detail', ['id' => ':id']) }}".replace(':id', location.id);
                        let img = '';
                        let gallery = location.gallery;
                        let arrayGallery = gallery.split(',');


                        var infoWindowContent = `<div class="p-0 m-0 tab-pane fade show active background-modal b-radius" id="modalBooking">
                <div>

                    <img loading="lazy" class="b-radius" src="${arrayGallery[0]}" alt="img">
                </div>
                <div class="p-md-3 p-2">
                    <div class="form-group">
                        <div class="d-flex justify-content-between mt-md-2">
                            <div class="fs-18px">${location.name}</div>
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
                    <a class="w-100 btn btn-secondary border-button-address font-weight-800 fs-14 justify-content-center" href="${urlDetail}" >
                    {{ __('home.Booking') }}
                        </a>
                        </div>
                        <div class="border-top">
                            <div class="mt-md-2 mt-1"><i class="text-gray mr-md-2 fa-solid fa-location-dot"></i>
                                <span class="fs-14 font-weight-600">${location.address_detail}</span>
                        </div>
                        <div class="mt-md-2 mt-1">
                            <i class="text-gray mr-md-2 fa-regular fa-clock"></i>
                            <span class="fs-14 font-weight-600">
                                Open: ${formatTime(location.open_date)} - ${formatTime(location.close_date)}
                            </span>
                        </div>
                        <div class="mt-md-2 mt-1">
                            <i class="text-gray mr-md-2 fa-solid fa-globe"></i>
                            <span class="fs-14 font-weight-600"> ${location.email}</span>
                        </div>
                        <div class="mt-md-2 mt-1">
                            <i class="text-gray mr-md-2 fa-solid fa-phone-volume"></i> <span
                                class="fs-14 font-weight-600"> ${location.phone}</span>
                        </div>
                        <div class="mt-md-2 mt-1 mb-md-2">
                            <i class="text-gray mr-md-2 fa-solid fa-bookmark"></i> <span
                                class="fs-14 font-weight-600"> ${location.type}</span>
                        </div>
                        @for($i=0; $i<3; $i++)
                        <div class="border-top mb-md-2">
                            <div
                                class="d-flex justify-content-between rv-header align-items-center mt-md-2 mt-1">
                                <div class="d-flex rv-header--left">
                                    <div class="avt-24 mr-md-2">
                                        <img loading="lazy" src="{{asset('img/detail_doctor/ellipse _14.png')}}">
                                        </div>
                                        <p class="fs-16px">Trần Đình Phi</p>
                                    </div>
                                    <div class="rv-header--right">
                                        <p class="fs-14 font-weight-400">10:20 07/04/2023</p>
                                    </div>
                                </div>
                                <div class="content">
                                    <p>
                                        {{ __('home.Lần đầu tiên sử dụng dịch vụ qua app nhưng chất lượng và dịch vụ tại salon quá tốt. Book giờ nào thì cứ đúng giờ đến k sợ phải chờ đợi như mọi chỗ khác. Hy vọng thi thoảng app có nhiều ưu đãi để giới thiệu cho bạn bè cùng sử dụng') }}
                        </p>
                    </div>
                </div>
@endfor
                        <div class="border-top">
                            <div
                                class="d-flex justify-content-between rv-header align-items-center mt-md-2 mt-1">
                                <div class="d-flex rv-header--left">
                                    <div class="avt-24 mr-md-2">
                                        <img loading="lazy" src="{{asset('img/detail_doctor/ellipse _14.png')}}">
                                    </div>
                                    <p class="fs-16px">Trần Đình Phi</p>
                                </div>
                                <div class="rv-header--right">
                                    <p class="fs-14 font-weight-400">10:20 07/04/2023</p>
                                </div>
                            </div>
                            <div class="content">
                                <p>
                                    {{ __('home.Lần đầu tiên sử dụng dịch vụ qua app nhưng chất lượng và dịch vụ tại salon quá tốt. Book giờ nào thì cứ đúng giờ đến k sợ phải chờ đợi như mọi chỗ khác. Hy vọng thi thoảng app có nhiều ưu đãi để giới thiệu cho bạn bè cùng sử dụng') }}
                        </p>
                    </div>
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

            function initMapPharmacies(currentLocation, locationsPharmacies) {
                var map2 = new google.maps.Map(document.getElementById('allAddressesMapPharmacies'), {
                    center: currentLocation,
                    zoom: 12.3
                });

                var currentLocationMarker = new google.maps.Marker({
                    position: currentLocation,
                    map: map2,
                    title: 'Your Location'
                });

                locationsPharmacies.forEach(function (locationsPharmacies) {
                    var distance = calculateDistance(
                        currentLocation.lat, currentLocation.lng,
                        parseFloat(locationsPharmacies.latitude), parseFloat(locationsPharmacies.longitude)
                    );

                    // Chọn bán kính tìm kiếm (ví dụ: 5 km)
                    var searchRadius = 10;

                    if (distance <= searchRadius) {
                        var markerPharmacies = new google.maps.Marker({
                            position: {lat: parseFloat(locationsPharmacies.latitude), lng: parseFloat(locationsPharmacies.longitude)},
                            map: map2,
                            title: 'Location'
                        });
                        var urlDetail = "{{ route('clinic.detail', ['id' => ':id']) }}".replace(':id', locationsPharmacies.id);
                        let img = '';
                        let gallery = locationsPharmacies.gallery;
                        let arrayGallery = gallery.split(',');


                        var infoWindowContent = `<div class="p-0 m-0 tab-pane fade show active background-modal b-radius" id="modalBooking">
                <div>

                    <img loading="lazy" class="b-radius" src="${arrayGallery[0]}" alt="img">
                </div>
                <div class="p-md-3 p-2">
                    <div class="form-group">
                        <div class="d-flex justify-content-between mt-md-2">
                            <div class="fs-18px">${locationsPharmacies.name}</div>
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
                    <a class="w-100 btn btn-secondary border-button-address font-weight-800 fs-14 justify-content-center" href="${urlDetail}" >
                    {{ __('home.Booking') }}
                        </a>
                        </div>
                        <div class="border-top">
                            <div class="mt-md-2 mt-1"><i class="text-gray mr-md-2 fa-solid fa-location-dot"></i>
                                <span class="fs-14 font-weight-600">${locationsPharmacies.address_detail}</span>
                        </div>
                        <div class="mt-md-2 mt-1">
                            <i class="text-gray mr-md-2 fa-regular fa-clock"></i>
                            <span class="fs-14 font-weight-600">
                                Open: ${formatTime(locationsPharmacies.open_date)} - ${formatTime(locationsPharmacies.close_date)}
                            </span>
                        </div>
                        <div class="mt-md-2 mt-1">
                            <i class="text-gray mr-md-2 fa-solid fa-globe"></i>
                            <span class="fs-14 font-weight-600"> ${locationsPharmacies.email}</span>
                        </div>
                        <div class="mt-md-2 mt-1">
                            <i class="text-gray mr-md-2 fa-solid fa-phone-volume"></i> <span
                                class="fs-14 font-weight-600"> ${locationsPharmacies.phone}</span>
                        </div>
                        <div class="mt-md-2 mt-1 mb-md-2">
                            <i class="text-gray mr-md-2 fa-solid fa-bookmark"></i> <span
                                class="fs-14 font-weight-600"> ${locationsPharmacies.type}</span>
                        </div>
                        @for($i=0; $i<3; $i++)
                        <div class="border-top mb-md-2">
                            <div
                                class="d-flex justify-content-between rv-header align-items-center mt-md-2 mt-1">
                                <div class="d-flex rv-header--left">
                                    <div class="avt-24 mr-md-2">
                                        <img loading="lazy" src="{{asset('img/detail_doctor/ellipse _14.png')}}">
                                        </div>
                                        <p class="fs-16px">Trần Đình Phi</p>
                                    </div>
                                    <div class="rv-header--right">
                                        <p class="fs-14 font-weight-400">10:20 07/04/2023</p>
                                    </div>
                                </div>
                                <div class="content">
                                    <p>
                                        {{ __('home.Lần đầu tiên sử dụng dịch vụ qua app nhưng chất lượng và dịch vụ tại salon quá tốt. Book giờ nào thì cứ đúng giờ đến k sợ phải chờ đợi như mọi chỗ khác. Hy vọng thi thoảng app có nhiều ưu đãi để giới thiệu cho bạn bè cùng sử dụng') }}
                        </p>
                    </div>
                </div>
@endfor
                        <div class="border-top">
                            <div
                                class="d-flex justify-content-between rv-header align-items-center mt-md-2 mt-1">
                                <div class="d-flex rv-header--left">
                                    <div class="avt-24 mr-md-2">
                                        <img loading="lazy" src="{{asset('img/detail_doctor/ellipse _14.png')}}">
                                    </div>
                                    <p class="fs-16px">Trần Đình Phi</p>
                                </div>
                                <div class="rv-header--right">
                                    <p class="fs-14 font-weight-400">10:20 07/04/2023</p>
                                </div>
                            </div>
                            <div class="content">
                                <p>
                                    {{ __('home.Lần đầu tiên sử dụng dịch vụ qua app nhưng chất lượng và dịch vụ tại salon quá tốt. Book giờ nào thì cứ đúng giờ đến k sợ phải chờ đợi như mọi chỗ khác. Hy vọng thi thoảng app có nhiều ưu đãi để giới thiệu cho bạn bè cùng sử dụng') }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>`;

                        var infoWindow2 = new google.maps.InfoWindow({
                            content: infoWindowContent
                        });

                        markerPharmacies.addListener('click', function () {
                            closeAllInfoWindows();
                            infoWindow2.open(map2, markerPharmacies);
                        });

                        infoWindows.push(infoWindow2);
                    }
                });
            }

            function closeAllInfoWindows() {
                infoWindows.forEach(function(infoWindow) {
                    infoWindow.close();
                });
            }

            getCurrentLocation(function(currentLocation) {
                initMap(currentLocation, locations);
            });

            getCurrentLocationPharmacies(function(currentLocation) {
                initMapPharmacies(currentLocation, locationsPharmacies);
            });

            document.addEventListener('DOMContentLoaded', function() {
                const departmentLinks = document.querySelectorAll('.department-link');

                departmentLinks.forEach(link => {
                    link.addEventListener('click', function(event) {
                        event.preventDefault();
                        const departmentId = this.getAttribute('data-id');
                        localStorage.setItem('departmentId', departmentId);
                        window.location.href = this.href;
                    });
                });
            });

        });
    </script>
@endsection
