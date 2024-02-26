@extends('layouts.master')
@section('title', 'Online Medicine')
@section('content')
    <link rel="stylesheet" href="{{asset('css/clinics-style.css')}}">
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

    </style>
    @include('layouts.partials.header')
    @include('What-free.header-wFree')
    <div class="container" id="listClinics">
        @php
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

                            $clinic = (array)$item;
                            $clinic['total_services'] = $services->count();
                            $clinic['services'] = $services->toArray();
                            if ($addressC != null && $addressD != null && $addressP != null){
                                $clinic['addressInfo'] = ', ' . $addressC->name . ', ' . $addressD->name . ', ' . $addressP->name;
                            } else {
                                $clinic['addressInfo'] = '';
                            }
                            return $clinic;
                        });
            $adr = $address->toArray();
        @endphp
        <div class="clinics-list">
            <div class="clinics-header row">
                <div class=" d-flex justify-content-between">
                    <span class="fs-32px"></span>
                    <span>
                </span>
                </div>
            </div>
            <div class="body row" id="productInformation"></div>

        </div>
        <div class="other-clinics">
            <div class="title">
                {{ __('home.Other Clinics/Pharmacies') }}
            </div>
            @include('component.clinic')
        </div>
    </div>

    <script>
        var addressNew = {!! json_encode($adr) !!};
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

        function initShowProducts(currentLocation, locations) {
            var productInformationDiv = document.getElementById('productInformation');
            locations.forEach(function (item) {
                var distance = calculateDistance(
                    currentLocation.lat, currentLocation.lng,
                    parseFloat(item.latitude), parseFloat(item.longitude)
                );

                // Chọn bán kính tìm kiếm (ví dụ: 10 km)
                var searchRadius = 10;
                if (distance <= searchRadius) {
                    var urlDetail = "{{ route('clinic.detail', ['id' => ':id']) }}".replace(':id', item.id);

                    let img = '';
                    let gallery = item.gallery;
                    let arrayGallery = gallery.split(',');
                    img += `<img class="mr-2 img-item1" src="${arrayGallery[0]}" alt="">`;
                    // for (let j = 0; j < arrayGallery.length; j++) {
                    // }
                    let serviceHtml = ``;
                    let service = item.services;
                    for (let j = 0; j < service.length; j++) {
                        let serviceItem = service[j];
                        serviceHtml = serviceHtml + `<span>${serviceItem.name},</span>`;
                    }
                    let openDate = new Date(item.open_date);
                    let closeDate = new Date(item.close_date);

                    let formattedOpenDate = `${openDate.getHours()}:${openDate.getMinutes()}`;
                    let formattedCloseDate = `${closeDate.getHours()}:${closeDate.getMinutes()}`;

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

                                                @if(locationHelper() == 'vi')
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
                                    <span class="distance"> - ${distance.toFixed(2)} Km</span>
                            </div>
                            <div class="time-working">
                                 <span class="color-timeWorking">
                                    <span class="fs-14 font-weight-600">${formattedOpenDate} - ${formattedCloseDate}</span>
                                    </span>
                                    <span>/ {{ __('home.Dental Clinic') }}</span>
                            </div>
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

        function loadProductInformation() {
            getCurrentLocation(function (currentLocation) {
                initShowProducts(currentLocation, addressNew);
            });
        }

        loadProductInformation();
    </script>

@endsection
