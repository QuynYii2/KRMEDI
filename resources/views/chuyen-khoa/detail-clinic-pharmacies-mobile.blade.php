@php use App\Models\Province;

@endphp
@extends('layouts.master')
@section('title', 'Detail')
<style>
    .swiper{
        height: fit-content;
    }
    .swiper-slide {
        display: flex !important;
        border: 1px solid #d5d4d4;
        border-radius: 10px;
        align-items: center;
    }

    .doctor-image img {
        max-width: 100%;
        width: 190px;
        height: 240px;
        padding: 40px 20px;
        object-fit: contain;
        border-radius: 50%;
    }

    .doctor-info {
        padding: 10px;
    }

    .doctor-info {
        padding: 10px;
    }

    @media (max-width: 575px) {
        .content__item{
            flex-wrap: wrap;
        }
        .specialList-clinics--img,.specialList-clinics--main{
            width: 100%;
        }
    }
</style>
@section('content')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightgallery/1.6.12/css/lightgallery.min.css">
    <link rel="stylesheet" href="{{asset('css/homeSpecialist.css')}}">
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css"/>

    @include('layouts.partials.header')
    <div class="container mt-200 mt-70">
        <div class="detail-clinic-theo-chuyen-khoa-title">
            <a href="{{route('home.specialist')}}">
                <div class="title-detail-clinic"><i class="fa-solid fa-arrow-left"></i> {{ __('home.Detail') }}</div>
            </a>
            <div class="specialList-clinics col-md-12 mt-5">
                <div class="border-specialList">
                    <div class="content__item d-flex gap-3">
                        <div class="specialList-clinics--img">
                            @php
                                $galleryArray = explode(',', $clinicDetail->gallery);
                            @endphp
                            <img class="content__item__image content__item__image_detail" src="{{ $galleryArray[0] }}"
                                 alt=""/>
                        </div>
                        <div class="specialList-clinics--main">
                            <div class="title-specialList-clinics">
                                {{$clinicDetail->name}}
                            </div>
                            <div class="address-specialList-clinics d-flex">
                                <i class="fas fa-map-marker-alt"></i>
                                @php
                                    $array = explode(',', $clinicDetail->address);
                                    $addressP = Province::where('id', $array[1] ?? null)->first();
                                    $addressD = \App\Models\District::where('id', $array[2] ?? null)->first();
                                    $addressC = \App\Models\Commune::where('id', $array[3] ?? null)->first();
                                @endphp
                                <div class="ml-1">{{$clinicDetail->address_detail}}
                                    , {{$addressC->name ?? ''}} , {{$addressD->name ?? ''}}
                                    , {{$addressP->name ?? ''}}</div>
                            </div>
                            <div class="time-working">
                                <i class="fa-solid fa-clock"></i>
                                {{$clinicDetail->time_work}} | {{ \Carbon\Carbon::parse($clinicDetail->open_date)->format('H:i') }} - {{ \Carbon\Carbon::parse($clinicDetail->close_date)->format('H:i') }}
                            </div>
                            <div class="group-button d-flex mt-3 align-items-center">
                                <a href="" class="mr-2">
                                    <div class="button-follow-specialList button-follow-specialList-zalo" style="padding-top: 7px!important;padding-left: 12px!important;">
                                        <div style="margin-left: 8px; margin-top: 18px" class="zalo-follow-only-button"
                                             data-callback="userFollowZaloOA" data-oaid="4438562505337240484"></div>
                                    </div>
                                </a>
                                <a href="{{ route('home.specialist.booking.detail', $clinicDetail->id) }}" style="margin: 0 5px 0 0px">
                                    <div class="button-booking-specialList line-dk-btn button-direct-specialList btn-detail-clinic" style="margin: 0;background-color: #00bc59">
                                        {{ __('home.Đặt khám') }}
                                    </div>
                                </a>
{{--                                <a href="https://www.google.com/maps?q={{$clinicDetail->latitude}},{{$clinicDetail->longitude}}" target="_blank">--}}
{{--                                    <div class="button-direct-specialList">--}}
{{--                                        {{ __('home.Chỉ đường') }}--}}
{{--                                    </div>--}}
{{--                                </a>--}}
                                <button class="row p-2" id="showMapBtn" style="background-color: transparent; border:none">
                                    <div class="button-direct-specialList">
                                        {{ __('home.Chỉ đường') }}
                                    </div>
                                </button>
                                <input type="hidden" name="latitude" id="latitude" value="{{$clinicDetail->latitude}}" />
                                <input type="hidden" name="longitude" id="longitude" value="{{$clinicDetail->longitude}}" />
                                {{--                                <a href="{{route('clinic.detail',$clinicDetail->id)}}" class="">--}}
{{--                                    <div class="button-direct-specialList">--}}
{{--                                        {{ __('home.Chỉ đường') }}--}}
{{--                                    </div>--}}
{{--                                </a>--}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="detail-clinic-theo-chuyen-khoa-main">
            <div class="d-flex nav-header--homeNew mt-3">
                <ul class="nav nav-pills nav-fill d-flex justify-content-between">
                    <li class="nav-item">
                        <a class="nav-link active font-14-mobi" id="introduce-tab" data-toggle="tab"
                           href="#introduce"
                           role="tab" aria-controls="introduce"
                           aria-selected="true">{{ __('home.Giới thiệu') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link font-14-mobi" id="image-tab" data-toggle="tab"
                           href="#image"
                           role="tab" aria-controls="image"
                           aria-selected="false">{{ __('home.Hình ảnh') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link font-14-mobi" id="review-tab" data-toggle="tab" href="#review"
                           role="tab" aria-controls="review"
                           aria-selected="true">{{ __('home.Đánh giá') }}</a>
                    </li>
                </ul>
            </div>
            <div class="tab-content mt-4" id="myTabContent">
                <div class="tab-pane fade show active" id="introduce" role="tabpanel"
                     aria-labelledby="introduce-tab">
                    <div class="box-content-clinic">
                        {!! $clinicDetail->introduce !!}
                    </div>
                    <div class="mt-3">
                        <p class="h6"><strong>Bác sĩ đại diện</strong></p>
                        <!-- Swiper -->
                        <div class="swiper mySwiper">
                            <div class="swiper-wrapper">
                                @foreach($doctors as $doctor)
                                    <div class="swiper-slide">
                                        <div class="doctor-image">
                                            <img src="{{$doctor->avt}}" alt="Bác sĩ" />
                                        </div>
                                        <div class="doctor-info">
                                            <p><strong>{{ ($doctor->last_name ?? '') . ' ' . ($doctor->name ?? '') }}</strong></p>
                                            <div class="d-flex" style="column-gap: 10px">
                                                <span><i class="fa-solid fa-clipboard mr-1"></i>{{ $doctor->year_of_experience ?? '' }} Năm</span>
                                                <span><i class="fa-solid fa-star mr-1"></i>{{ $doctor->average_star ?? '' }}</span>
                                            </div>
                                            <p><i class="fa-solid fa-location-dot mr-1"></i>{{ $doctor->detail_address ?? '' }}</p>
                                            <p><i class="fa-solid fa-clock mr-1"></i>{{ ($doctor->time_working_1 ?? '') . ' - ' . ($doctor->time_working_2 ?? '') }}</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <div class="swiper-pagination"></div>
                            <div class="swiper-button-prev"></div>
                            <div class="swiper-button-next"></div>
                        </div>

                    </div>
                    <div class="offcanvas-body p-0 mt-5">
                        <div id="allAddressesMap" class="show active fade map_clinic_mobile" style="height: 500px; width: 100%">
                        </div>
                    </div>
                    <div class="table-responsive mt-5">
                        <table class="table table-vcenter text-nowrap table-bordered border-bottom">
                            <thead>
                            <tr>
                                <th>Ngày trong tuần</th>
                                <th>Thời gian</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>Thứ Hai</td>
                                <td>8am - 20pm</td>
                            </tr>
                            <tr>
                                <td>Thứ Ba</td>
                                <td>8am - 20pm</td>
                            </tr>
                            <tr>
                                <td>Thứ Tư</td>
                                <td>8am - 20pm</td>
                            </tr>
                            <tr>
                                <td>Thứ Năm</td>
                                <td>8am - 20pm</td>
                            </tr>
                            <tr>
                                <td>Thứ Sáu</td>
                                <td>8am - 20pm</td>
                            </tr>
                            <tr>
                                <td>Thứ Bảy</td>
                                <td>8am - 20pm</td>
                            </tr>
                            <tr>
                                <td>Chủ Nhật</td>
                                <td class="text-danger">Ngày nghỉ</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-3">
                        <p class="h6"><strong>Khoa điều trị</strong></p>
                        @foreach($departments as $department)
                            <button class="btn text-muted" style="border: 1px solid #a2a2a2bf; border-radius: 20px; margin: 0 10px 10px 0">
                                {{$department->name ?? ''}}
                            </button>
                        @endforeach
                    </div>
                    <div class="mt-3">
                        <p class="h6"><strong>Triệu chứng điều trị</strong></p>
                        <p class="h6"><strong>Giá dịch vụ</strong></p>
                        <div class="table-responsive mt-3">
                            <table class="table table-vcenter text-nowrap table-bordered border-bottom">
                                <tbody>
                                @foreach($services as $service)
                                    <tr>
                                        <td><strong>{{$service->name ?? ''}}</strong></td>
                                        <td>Đang cập nhật</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="image" role="tabpanel" aria-labelledby="image-tab">
                    <div class="row" id="lightgallery">
                        @php
                            $galleryArray = explode(',', $clinicDetail->gallery);
                        @endphp
                        @foreach($galleryArray as $gallery)
                            <div class="col-lg-4 col-md-6 col-12 mb-md-4 mb-3" data-src="{{$gallery}}" data-lg-size="1600-1067">
                                <img class="p-0 w-100 h-100"
                                     style="
                                 object-fit: cover;
                                 border-radius: 16px;
                                 "
                                     src="{{$gallery}}" alt="">
                            </div>

                        @endforeach
                    </div>
                </div>
                <div class="tab-pane fade" id="review" role="tabpanel" aria-labelledby="review-tab">
                    <div class="d-flex justify-content-center align-items-center">
                        <a id="writeReviewBtn" class="b-radius col-md-5 p-2 justify-content-center d-flex align-items-center" style="border-radius: 30px; background: none" >
                            <svg xmlns="http://www.w3.org/2000/svg" width="25" height="24" viewBox="0 0 25 24" fill="none" class="mr-2">
                                <path d="M20.5 10.5V6.8C20.5 5.11984 20.5 4.27976 20.173 3.63803C19.8854 3.07354 19.4265 2.6146 18.862 2.32698C18.2202 2 17.3802 2 15.7 2H9.3C7.61984 2 6.77976 2 6.13803 2.32698C5.57354 2.6146 5.1146 3.07354 4.82698 3.63803C4.5 4.27976 4.5 5.11984 4.5 6.8V17.2C4.5 18.8802 4.5 19.7202 4.82698 20.362C5.1146 20.9265 5.57354 21.3854 6.13803 21.673C6.77976 22 7.61984 22 9.3 22H12.5M14.5 11H8.5M10.5 15H8.5M16.5 7H8.5M18.5 21V15M15.5 18H21.5" stroke="black" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                            {{ __('home.Write a review') }}</a>
                    </div>
                    <div id="reviewItemClinic">
                        @php
                            $reviewStore = \App\Models\Review::where('status', '!=', \App\Enums\ReviewStatus::DELETED)->where('clinic_id', $clinicDetail->id)->get();
                        @endphp
                        @include('chuyen-khoa.tab-show-review')
                    </div>
                    <div id="createReviewClinic" style="display: none;">
                        @include('chuyen-khoa.tab-review-clinics')
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/2.0.11/clipboard.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/lightgallery@1.6.12/dist/js/lightgallery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-mousewheel/3.1.13/jquery.mousewheel.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lg-thumbnail/1.1.0/lg-thumbnail.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lg-fullscreen/1.1.0/lg-fullscreen.min.js"></script>
    <script>
        $(document).ready(function () {
            $("#lightgallery").lightGallery();
        });
        document.addEventListener("DOMContentLoaded", function () {
            var writeReviewBtn = document.getElementById('writeReviewBtn');
            var reviewItemClinic = document.getElementById('reviewItemClinic');
            var createReviewClinic = document.getElementById('createReviewClinic');

            writeReviewBtn.addEventListener('click', function () {
                // Ẩn nút "Write a review"
                writeReviewBtn.style.display = 'none';

                // Ẩn review-item và hiển thị tab-create-review-store
                reviewItemClinic.style.display = 'none';
                createReviewClinic.style.display = 'block';
            });
        });
    </script>

    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
    <script>
        var swiper = new Swiper('.mySwiper', {
            slidesPerView: 1,
            spaceBetween: 10,
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
            breakpoints: {
                576: {
                    slidesPerView: 1,
                    spaceBetween: 20,
                },
                768: {
                    slidesPerView: 2,
                    spaceBetween: 30,
                },
                // 1024: {
                //     slidesPerView: 3,
                //     spaceBetween: 40,
                // },
                1280: {
                    slidesPerView: 3,
                    spaceBetween: 40,
                },
            }
        });
    </script>

    <script>
        var markers = [];
        var infoWindows = [];
        var directionsService;
        var directionsRenderer;
        var latitude = {{ $clinicDetail->latitude }};
        var longitude = {{ $clinicDetail->longitude }};

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
            var R = 6371; // Radius of the earth in km
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

        function mapClinic(coordinatesArray) {
            var locations = coordinatesArray;
            if (locations.length > 0){
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

                    directionsService = new google.maps.DirectionsService();
                    directionsRenderer = new google.maps.DirectionsRenderer();
                    directionsRenderer.setMap(map);

                    var currentLocationMarker = new google.maps.Marker({
                        position: currentLocation,
                        map: map,
                        title: 'Your Location'
                    });

                    locations.forEach(function (location) {
                        var distance = calculateDistance(
                            currentLocation.lat, currentLocation.lng,
                            parseFloat(latitude), parseFloat(longitude)
                        );

                        // Chọn bán kính tìm kiếm (ví dụ: 5 km)
                        var searchRadius = 10;

                        if (distance <= searchRadius && !isNaN(distance)) {
                            var marker = new google.maps.Marker({
                                position: {lat: parseFloat(latitude), lng: parseFloat(longitude)},
                                map: map,
                                title: 'Location'
                            });
                            var urlDetail = "{{ route('home.specialist.booking.detail', ['id' => ':id']) }}".replace(':id', location.id);
                            let gallery = location.gallery;
                            let arrayGallery = gallery.split(',');

                            var infoWindowContent = `<div class="p-0 m-0 tab-pane fade show active background-modal b-radius" id="modalBooking">
                                <div>
                                    <img loading="lazy" class="b-radius" src="${arrayGallery[0]}" alt="img">
                                </div>
                                <div class="p-md-3 p-2">
                                    <div class="form-group">
                                        <div class="d-flex justify-content-between mt-md-2">
                                            <div class="fs-18px name-address-map">${location.name}</div>
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
                                                <button class="row p-2" id="showMapBtnTab" style="background-color: transparent; border:none">
                                                    <div class="justify-content-center d-flex">
                                                        <i class="border-button-address fa-regular fa-circle-right"></i>
                                                    </div>
                                                    <div class="d-flex justify-content-center">{{ __('home.Direction') }}</div>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mt-md-3 mb-md-3">
                                        <a class="w-100 btn btn-secondary border-button-address font-weight-800 fs-14 justify-content-center" href="${urlDetail}">
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
                                            <span class="fs-14 font-weight-600">${location.email}</span>
                                        </div>
                                        <div class="mt-md-2 mt-1">
                                            <i class="text-gray mr-md-2 fa-solid fa-phone-volume"></i>
                                            <span class="fs-14 font-weight-600">${location.phone}</span>
                                        </div>
                                        <div class="mt-md-2 mt-1 mb-md-2">
                                            <i class="text-gray mr-md-2 fa-solid fa-bookmark"></i>
                                            <span class="fs-14 font-weight-600">${location.type}</span>
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
                                $(document).on('click', '#showMapBtnTab', function() {
                                    getDirections(currentLocation, { lat: parseFloat(latitude), lng: parseFloat(longitude) });
                                    location = [];
                                    closeAllInfoWindows();
                                });
                            });
                            markers.push(marker);
                            infoWindows.push(infoWindow);
                            location.markerIndex = markers.length - 1;

                            // Define clinicElement after DOM is ready
                            $(document).ready(function() {
                                $('#showMapBtn').on('click', function() {
                                    getDirections(currentLocation, { lat: parseFloat(latitude), lng: parseFloat(longitude) });
                                    var mapElement = $('#allAddressesMap').get(0);
                                    if (mapElement) {
                                        mapElement.scrollIntoView({ behavior: 'smooth', block: 'start' });
                                    }
                                });
                                closeAllInfoWindows();
                            });

                        }
                    });

                    document.querySelectorAll('.border-specialList').forEach(function (item) {
                        item.addEventListener('click', function () {
                            var markerIndex = parseInt(item.getAttribute('data-marker-index'));
                            closeAllInfoWindows();
                            infoWindows[markerIndex].open(map, markers[markerIndex]);

                            var location = locations[markerIndex];
                            if (location && !isNaN(latitude) && !isNaN(longitude)) {
                                $(document).on('click', '#showMapBtnTab', function() {
                                    console.log('click');
                                    getDirections(currentLocation, { lat: parseFloat(latitude), lng: parseFloat(longitude) });
                                    closeAllInfoWindows();
                                })
                            } else {
                                console.error('Invalid location data:', location);
                            }
                        });
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
            } else {
                $('.text-not-address').css('display', 'inline-block');
                $('#productInformation').html('');
                $('#allAddressesMap').html('');
            }
        }

        function getDirections(currentLocation, clinicLocation) {
            var request = {
                origin: currentLocation,
                destination: clinicLocation,
                travelMode: 'DRIVING'
            };

            directionsService.route(request, function(result, status) {
                if (status === 'OK') {
                    directionsRenderer.setDirections(result);
                    document.getElementById('allAddressesMap').style.display = 'block';
                } else {
                    console.error('Directions request failed due to ' + status);
                }
            });
        }

        function initShowProducts() {
            $.ajax({
                url: `{{ route('clinics.restapi.search') }}`,
                method: 'GET',
                headers: {
                    "Authorization": accessToken
                },
                success: function(response) {
                    mapClinic(response);
                    renderClinics(response);
                },
                error: function(exception) {
                    console.log(exception);
                }
            });
        }

        function loadProductInformation() {
            initShowProducts();
        }

        loadProductInformation();

        function renderClinics(response) {
            var productInformationDiv = document.getElementById('productInformation');
            productInformationDiv.innerHTML = '';
            getCurrentLocation(function(currentLocation) {
                let index_map = 0;
                for (let i = 0; i < response.length; i++) {
                    let item = response[i];
                    var distance = calculateDistance(
                        currentLocation.lat, currentLocation.lng,
                        parseFloat(item.latitude), parseFloat(item.longitude)
                    );

                    var searchRadius = 10; // Example search radius: 10 km
                    if (distance >= searchRadius || isNaN(distance)) {
                        continue;
                    }
                    var urlDetail = "{{ route('clinic.detail', ['id' => ':id']) }}".replace(':id', item.id);

                    let img = '';
                    let gallery = item.gallery;
                    let arrayGallery = gallery.split(',');
                    img += `<img class="mr-2 img-item1" src="${arrayGallery[0]}" alt="">`;

                    let openDate = new Date(item.open_date);
                    let closeDate = new Date(item.close_date);

                    let formattedOpenDate = openDate.toLocaleTimeString(undefined, {
                        hour: '2-digit',
                        minute: '2-digit'
                    });
                    let formattedCloseDate = closeDate.toLocaleTimeString(undefined, {
                        hour: '2-digit',
                        minute: '2-digit'
                    });

                    let html = `
                        <div class="specialList-clinics col-lg-12 col-md-6 mb-3">
                            <div class="border-specialList" data-marker-index="${index_map}" style="gap:unset;padding:5px">
                                <div class="content__item d-flex">
                                    <div class="specialList-clinics--img d-flex flex-column">
                                        ${img}
                                        <button id="showMapBtn" class="search-way" style="border:none; background-color: transparent"><i class="fa-solid fa-location-arrow"></i>Chỉ đường</button>
                                        @if (Auth::check())
                    <div class="zalo-follow-only-button" style="height:20px" data-callback="userFollowZaloOA" data-oaid="4438562505337240484"></div>
@endif
                    </div>
                    <div class="specialList-clinics--main w-100">
                        <div class="title-specialList-clinics">
@if (locationHelper() == 'vi')
                    ${item.name}
                                            @else
                    ${item.name_en}
                                            @endif
                    </div>
                    <div class="address-specialList-clinics">
                        <div class="d-flex align-items-center address-clinics">
                            <i class="fas fa-map-marker-alt mr-2"></i>
                            <div style="-webkit-line-clamp: 3!important;">${item.address_detail} ${item.addressInfo}</div>
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-between align-items-center flex-wrap">
                                            <div class="time-working w-100 d-flex justify-content-between">
                                                <span class="color-timeWorking">
                                                    <span class="fs-14 font-weight-600"><i class="fa-regular fa-clock"></i> ${formattedOpenDate} - ${formattedCloseDate}</span>
                                                </span>
                                                <span class="distance"><i class="fas fa-map-marker-alt mr-2"></i>${distance.toFixed(2)} Km</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `;

                    productInformationDiv.innerHTML += html;
                    index_map += 1;
                }
            });
        }
    </script>
@endsection
