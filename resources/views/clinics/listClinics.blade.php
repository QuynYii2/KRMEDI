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
    </style>
    @include('layouts.partials.header')
    @include('What-free.header-wFree')
    <div class="container" id="listClinics">
        {{-- @php
            $address = DB::table('clinics')
                ->join('users', 'users.id', '=', 'clinics.user_id')
                ->where('clinics.status', \App\Enums\ClinicStatus::ACTIVE)
                ->where('clinics.type', \App\Enums\TypeBusiness::CLINICS)
                ->select('clinics.*', 'users.email')
                ->cursor()
                ->map(function ($item) {
                    $array = explode(',', $item->service_id);
                    $services = \App\Models\ServiceClinic::whereIn('id', $array)->get();
                    $array = explode(',', $item->address);
                    $addressP = \App\Models\Province::where('id', $array[1] ?? null)->first();
                    $addressD = \App\Models\District::where('id', $array[2] ?? null)->first();
                    $addressC = \App\Models\Commune::where('id', $array[3] ?? null)->first();

                    $clinic = (array) $item;
                    $clinic['total_services'] = $services->count();
                    $clinic['services'] = $services->toArray();
                    if ($addressC != null && $addressD != null && $addressP != null) {
                        $clinic['addressInfo'] =
                            ', ' . $addressC->name . ', ' . $addressD->name . ', ' . $addressP->name;
                    } else {
                        $clinic['addressInfo'] = '';
                    }
                    return $clinic;
                });
            $adr = $address->toArray();
        @endphp --}}
        <div class="clinics-list">
            <div class="clinics-header row">
                <div class=" d-flex justify-content-between">
                    <span class="fs-32px">Phòng khám gần bạn</span>
                    <span>
                    </span>
                </div>
            </div>
            <div class="body row" id="productInformation"></div>

        </div>
        {{-- <div class="other-clinics">
            <div class="title">
                {{ __('home.Other Clinics/Pharmacies') }}
            </div>
            @include('component.clinic')
        </div> --}}
    </div>

    <script>
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

        function initShowProducts() {
            $.ajax({
                url: `{{ route('clinics.restapi.search') }}`,
                method: 'GET',
                headers: {
                    "Authorization": accessToken
                },
                success: function(response) {
                    renderClinics(response)
                },
                error: function(exception) {
                    console.log(exception)
                }
            });
        }

        function showSpinner() {
            const $spinner = $('<div>').addClass('spinner-loading text-center').attr('role', 'status')
                .append($('<span>').text('Loading...'));

            $('#productInformation').append($spinner);
        }

        function hideSpinner() {
            $('.spinner-loading').remove();
        }

        function loadProductInformation() {
            showSpinner();
            initShowProducts();
            hideSpinner();
        }

        loadProductInformation();

        function renderClinics(response) {
            getCurrentLocation(function(currentLocation) {
                var productInformationDiv = document.getElementById('productInformation');
                for (let i = 0; i < response.length; i++) {
                    let item = response[i];
                    var distance = calculateDistance(
                        currentLocation.lat, currentLocation.lng,
                        parseFloat(item.latitude), parseFloat(item.longitude)
                    );

                    // Chọn bán kính tìm kiếm (ví dụ: 10 km)
                    var searchRadius = 10;
                    if (distance >= searchRadius || isNaN(distance)) {
                        continue;
                    }
                    var urlDetail = "{{ route('clinic.detail', ['id' => ':id']) }}".replace(':id', item.id);

                    let img = '';
                    let gallery = item.gallery;
                    let arrayGallery = gallery.split(',');
                    img += `<img class="mr-2 img-item1" src="${arrayGallery[0]}" alt="">`;

                    // let serviceHtml = ``;
                    // let service = item.services;
                    // for (let j = 0; j < service.length; j++) {
                    //     let serviceItem = service[j];
                    //     serviceHtml = serviceHtml + `<span>${serviceItem.name},</span>`;
                    // }
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
                            <div class="specialList-clinics col-md-6 mt-3">
                                <a href="${urlDetail}">
                                    <div class="border-specialList">
                                        <div class="content__item d-flex gap-3">
                                            <div class="specialList-clinics--img">
                                                ${img}
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
                                            <div>${item.address_detail} ${item.addressInfo}</div>
                                        </div>
                                            <span class="distance"> ${distance.toFixed(2)} Km</span>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center flex-wrap">
                                        <div class="time-working">
                                            <span class="color-timeWorking">
                                                <span class="fs-14 font-weight-600">${formattedOpenDate} - ${formattedCloseDate}</span>
                                                </span>
                                                <span>/ {{ __('home.Dental Clinic') }}</span>
                                        </div>
                                       <a href="https://www.google.com/maps?q=${item.latitude},${item.longitude}" class="search-way mb-1" target="_blank">Chỉ đường</a>
                                    </div>
                                    @if (Auth::check())
                                    <div class="zalo-follow-only-button" data-callback="userFollowZaloOA" data-oaid="4438562505337240484"></div>
                                    @endif
                                    </div>
                                    </div>
                                    </div>
                                </a>
                            </div>
                            `;

                    productInformationDiv.innerHTML += html;
                }
            });
        }
    </script>

@endsection
