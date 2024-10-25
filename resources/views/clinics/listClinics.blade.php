@extends('layouts.master')
@section('title', 'Online Medicine')
@section('content')
    <link rel="stylesheet" href="{{ asset('css/clinics-style.css') }}">
    <style>
        .border-specialList {
            border-radius: 16px;
            border: 1px solid #EAEAEA;
            background: #FFF;
            display: flex;
            padding: 16px;
            align-items: flex-start;
            gap: 16px;
        }

        .title-specialList-clinics {
            color: #000;
            font-size: 24px;
            font-style: normal;
            font-weight: 800;
            line-height: normal;
        }

        .address-clinics {
            color: #929292;
            font-size: 18px;
            font-style: normal;
            font-weight: 600;
            line-height: normal;
        }

        .distance {
            color: #088180;
            font-size: 18px;
            font-style: normal;
            font-weight: 600;
            line-height: normal;
        }

        .time-working {
            font-size: 12px;
            font-style: normal;
            font-weight: 600;
            line-height: normal;
        }

        .color-timeWorking {
            color: #088180;

        }

        .spinner-loading span {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background-color: white;
            animation: flashing 1.4s infinite linear;
            margin: 0 4px;
            display: inline-block;
        }

        .spinner-loading span:nth-child(2) {
            animation-delay: 0.2s;
        }

        .spinner-loading span:nth-child(3) {
            animation-delay: 0.4s;
        }

        @keyframes flashing {
            0% {
                opacity: 0.2;
            }

            20% {
                opacity: 1;
            }

            100% {
                opacity: 0.2;
            }
        }
        #productInformation::-webkit-scrollbar {
            width: 8px;
        }
        #productInformation::-webkit-scrollbar-track {
            background: #ebebeb;
            border-radius: 10px;
        }

        #productInformation::-webkit-scrollbar-thumb {
            background: #a5a5a5;
            border-radius: 10px;
        }
        .search-way{
            width: fit-content;
            font-size: 12px;
            border-radius: 8px;
            margin-top: 10px;
            display: inline-block;
            color: #0070E0;
        }
        .search-way:hover{
            color: #0070E0;
        }
        .header-mobile-clinics{
            display: none;
        }
        .gm-style .gm-style-iw-c {
            max-width: 465px !important;
        }
        .zalo-follow-only-button{
            margin-top: 5px;
        }
    </style>
    <div class="header_clinic_desktop">
        @include('layouts.partials.header')
    </div>
    @include('What-free.header-wFree')
    <div class="container" id="listClinics">
        <div class="clinics-list">
            <div class="clinics-header row">
                <div class=" d-flex justify-content-between">
                    <span class="fs-32px text-phong-mall">Phòng khám gần bạn</span>
                    <span>
                    </span>
                </div>
            </div>
            <p style="color: red;text-align: center;margin:30px 0;display: none" class="text-not-address w-100">Không có phòng khám nào như bạn cần tìm quanh bạn</p>
            <div class="box-list-clinic-address">
                <div class="body row box-productInformation-clinic" id="productInformation"></div>
                <div class="box-content-map">
                    <div id="allAddressesMap" class="show active fade map_clinic_desktop w-100" style="height: 800px;">

                    </div>
                    <div class="swiper mySwiperMap">
                        <div class="swiper-wrapper data-map">

                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>

    <script>
        localStorage.setItem('check-kham','active');
        localStorage.removeItem('bookingFormData');
        localStorage.removeItem('selectedDate');
        var swiper = new Swiper(".mySwiperMap", {
            slidesPerView: 1.5,
            spaceBetween: 5,
            breakpoints: {
                768: {
                    slidesPerView: 1.7,
                },
                300: {
                    slidesPerView: 1,
                },
            },
        });
        var markers = [];
        var infoWindows = [];
        var directionsService;
        var directionsRenderer;

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
                        zoom: 12.3,
                        gestureHandling: 'greedy',
                        streetViewControl: false,
                        zoomControl: false
                    });

                    directionsService = new google.maps.DirectionsService();
                    directionsRenderer = new google.maps.DirectionsRenderer();
                    directionsRenderer.setMap(map);

                    var currentLocationMarker = new google.maps.Marker({
                        position: currentLocation,
                        map: map,
                        title: 'Your Location'
                    });
                    let list_map = '';
                    let count_address =0;
                    locations.forEach(function (location) {
                        var distance = calculateDistance(
                            currentLocation.lat, currentLocation.lng,
                            parseFloat(location.latitude), parseFloat(location.longitude)
                        );

                        // Chọn bán kính tìm kiếm (ví dụ: 5 km)
                        var searchRadius = 100;

                        if (distance <= searchRadius && !isNaN(distance)) {
                            var marker = new google.maps.Marker({
                                position: {lat: parseFloat(location.latitude), lng: parseFloat(location.longitude)},
                                map: map,
                                title: 'Location'
                            });
                            var urlDetail = "{{ route('home.specialist.booking.detail', ['id' => ':id']) }}".replace(':id', location.id);
                            let gallery = location.gallery;
                            let arrayGallery = gallery.split(',');

                            list_map += `<div class="swiper-slide swiper-slide-height slide_${count_address} bg-white" data-index="${count_address}" ><div class="p-0 m-0 tab-pane fade show active background-modal b-radius" id="modalBooking">
                                <div class="box-img-item-map">
                                    <img loading="lazy" class="b-radius" src="${arrayGallery[0]}" alt="img" style="height: 100%;object-fit: cover;">
                                </div>
                                <div class="p-2 box-info-item-map">
                                    <div class="form-group mb-1">
                                        <div class="d-flex justify-content-between mt-md-2">
                                            <div class="fs-18px name-address-map">${location.name}</div>
                                        </div>
                                        <div class="d-flex mt-md-2">
                                            <div class="d-flex col-md-6 justify-content-center align-items-center">
                                                <button class="row" id="showMapBtnTab_${count_address}" style="background-color: transparent; border:none">
                                                    <div class="justify-content-center d-flex">
                                                        <i class="border-button-address fa-regular fa-circle-right"></i>
                                                    </div>
                                                    <div class="d-flex justify-content-center">{{ __('home.Direction') }}</div>
                                                </button>
                                            </div>
                                             <div class="d-flex col-md-6 justify-content-center align-items-center">
                                                <a class="row" href="${urlDetail}">
                                                    <div class="justify-content-center d-flex">
                                                        <i class="border-button-address fa-solid fa-bullseye"></i>
                                                    </div>
                                                    <div class="d-flex justify-content-center">{{ __('home.Booking') }}</div>
                                                </a>
                                            </div>
                                        </div>
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
                                            <i class="text-gray mr-md-2 fa-solid fa-phone-volume"></i>
                                            <span class="fs-14 font-weight-600">${location.phone}</span>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            </div></div>`;

                            // var infoWindow = new google.maps.InfoWindow({
                            //     content: infoWindowContent
                            // });
                            //
                            // marker.addListener('click', function () {
                            //     closeAllInfoWindows();
                            //     infoWindow.open(map, marker);
                            //     $(document).on('click', '#showMapBtnTab', function() {
                            //         if (location && !isNaN(location.latitude) && !isNaN(location.longitude)) {
                            //             getDirections(currentLocation, { lat: parseFloat(location.latitude), lng: parseFloat(location.longitude) });
                            //             location = [];
                            //             closeAllInfoWindows();
                            //         } else {
                            //             console.error('Invalid location data:', location);
                            //         }
                            //     });
                            // });
                            markers.push(marker);
                            // infoWindows.push(infoWindow);
                            location.markerIndex = markers.length - 1;

                            // Define clinicElement after DOM is ready
                            // $(document).ready(function() {
                            //     var clinicElement = $('.border-specialList[data-marker-index="' + location.markerIndex + '"]');
                            //     // Add click event for directions
                            //     clinicElement.find('#showMapBtn').on('click', function() {
                            //         getDirections(currentLocation, { lat: parseFloat(location.latitude), lng: parseFloat(location.longitude) });
                            //     });
                            //     closeAllInfoWindows();
                            // });
                            let classBox = '.slide_'+count_address;
                            marker.addListener('click', function () {
                                var index2= $(classBox).attr('data-index');
                                swiper.slideTo(index2);
                            });
                            $(document).on('click', '#showMapBtnTab_'+count_address, function() {
                                if (location && !isNaN(location.latitude) && !isNaN(location.longitude)) {
                                    getDirections(currentLocation, { lat: parseFloat(location.latitude), lng: parseFloat(location.longitude) });
                                    var index= $(classBox).attr('data-index');
                                    swiper.slideTo(index);
                                } else {
                                    console.error('Invalid location data:', location);
                                }
                            });
                            count_address ++;
                        }
                    });
                    $('.data-map').html(list_map);

                    document.querySelectorAll('.border-specialList').forEach(function (item) {
                        console.log(12)
                        item.addEventListener('click', function () {
                            console.log(1)
                            var markerIndex = parseInt(item.getAttribute('data-marker-index'));
                            closeAllInfoWindows();
                            infoWindows[markerIndex].open(map, markers[markerIndex]);

                            var location = locations[markerIndex];
                            if (location && !isNaN(location.latitude) && !isNaN(location.longitude)) {
                                $(document).on('click', '#showMapBtnTab', function() {
                                    console.log('click');
                                    getDirections(currentLocation, { lat: parseFloat(location.latitude), lng: parseFloat(location.longitude) });
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

                    var searchRadius = 100; // Example search radius: 10 km
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
                                        <button id="showMapBtnTab_${index_map}" class="search-way" style="border:none; background-color: transparent"><i class="fa-solid fa-location-arrow"></i>Chỉ đường</button>
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
                                                <span class="distance"><i class="fas fa-map-marker-alt mr-2"></i>${distance.toFixed(2).replace('.', ',')} Km</span>
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
