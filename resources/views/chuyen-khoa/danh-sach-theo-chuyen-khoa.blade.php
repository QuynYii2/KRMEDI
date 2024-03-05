@php use App\Models\Province;

@endphp
@extends('layouts.master')
@section('title', 'Specialist')
@section('content')
    <link rel="stylesheet" href="{{asset('css/homeSpecialist.css')}}">
    @include('layouts.partials.header')
    <div class="container mt-200 mt-70">
        <div class="danh-sach-theo-chuyen-khoa">
            <a href="{{route('home.specialist')}}">
                <div class="title-Danh-sach"><i class="fa-solid fa-arrow-left"></i> {{ __('home.Danh sách') }}</div>
            </a>
            <div class="search-specialist col-md-8">
                <label for="search-specialist" class="search-specialist__label w-50">
                    <i class="fas fa-search"></i>
                    <input id="search-specialist" placeholder="{{ __('home.Tìm kiếm cơ sở y tế') }}">
                </label>
                <div class="position-absolute">|</div>
                <label class="select-specialist__label w-50">
                    <i class="fas fa-map-marker-alt"></i>
                    <select>
                        <option value="0">{{ __('home.Tất cả địa điểm') }}</option>
                        <option value="1">Hà Nội</option>
                        <option value="2">Hồ Chí Minh</option>
                        <option value="3">Đà Nẵng</option>
                        <option value="4">Hải Phòng</option>
                    </select>
                </label>
            </div>

            <div class="d-flex nav-header--homeNew justify-content-center mt-3">
                <ul class="nav nav-pills nav-fill d-flex justify-content-between">
                    <li class="nav-item">
                        <a class="nav-link active font-14-mobi" id="clinicList-tab" data-toggle="tab"
                           href="#clinicList"
                           role="tab" aria-controls="clinicList"
                           aria-selected="true">{{ __('home.HOSPITALS') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link font-14-mobi" id="pharmacies-tab" data-toggle="tab"
                           href="#pharmacies"
                           role="tab" aria-controls="pharmacies"
                           aria-selected="false">{{ __('home.CLINICS') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link font-14-mobi" id="doctorList-tab" data-toggle="tab" href="#doctorList"
                           role="tab" aria-controls="doctorList"
                           aria-selected="true">{{ __('home.DOCTOR') }}</a>
                    </li>
                </ul>
            </div>
            <div class="tab-content mt-4" id="myTabContent">
                <div class="tab-pane fade show active" id="clinicList" role="tabpanel"
                     aria-labelledby="clinicList-tab">
                    <div class="row">
                        @foreach($clinics as $clinic)
                            <div class="specialList-clinics col-md-6 mt-5">
                                <div class="border-specialList">
                                    <div class="content__item d-flex gap-3">
                                        <div class="specialList-clinics--img">
                                            @php
                                                $galleryArray = explode(',', $clinic->gallery);
                                            @endphp
                                            <img class="content__item__image" src="{{$galleryArray[0]}}"
                                                 alt=""/>
                                        </div>
                                        <div class="specialList-clinics--main w-100">
                                            <div class="title-specialList-clinics">
                                                {{$clinic->name}}
                                            </div>
                                            <div class="address-specialList-clinics d-flex align-items-center">
                                                @php
                                                    $array = explode(',', $clinic->address);
                                                    $addressP = Province::where('id', $array[1] ?? null)->first();
                                                    $addressD = \App\Models\District::where('id', $array[2] ?? null)->first();
                                                    $addressC = \App\Models\Commune::where('id', $array[3] ?? null)->first();
                                                @endphp
                                                <div class="d-flex">
                                                    <i class="fas fa-map-marker-alt mr-2"></i>
                                                    <div>{{$clinic->address_detail}}
                                                        , {{$addressC->name ?? ''}} , {{$addressD->name ?? ''}}
                                                        , {{$addressP->name ?? ''}}</div>
                                                </div>
                                                - <span>3 Km</span>
                                            </div>
                                            <div class="time-working">
                                            <span class="color-timeWorking">
                                                 <span class="fs-14 font-weight-600">{{ \Carbon\Carbon::parse($clinic->open_date)->format('H:i') }} - {{ \Carbon\Carbon::parse($clinic->close_date)->format('H:i') }}</span>
                                            </span>
                                                <span>
                                                 / {{ __('home.Dental Clinic') }}
                                            </span>
                                            </div>
                                            <div class="group-button d-flex mt-3">
                                                <a href="{{route('home.specialist.booking.detail', $clinic->id)}}" class="col-md-6">
                                                    <div class="button-booking-specialList">
                                                        {{ __('home.Đặt khám') }}
                                                    </div>
                                                </a>
                                                <a href="{{route('home.specialist.detail', $clinic->id)}}" class="col-md-6">
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
                </div>
                <div class="tab-pane fade" id="pharmacies" role="tabpanel" aria-labelledby="pharmacies-tab">
                    <div class="row">
                        @foreach($pharmacies as $pharmacy)
                            <div class="specialList-clinics col-md-6 mt-5">
                                <div class="border-specialList">
                                    <div class="content__item d-flex gap-3">
                                        <div class="specialList-clinics--img">
                                            @php
                                                $galleryArray = explode(',', $pharmacy->gallery);
                                            @endphp
                                            <img class="content__item__image" src="{{$galleryArray[0]}}"
                                                 alt=""/>
                                        </div>
                                        <div class="specialList-clinics--main w-100">
                                            <div class="title-specialList-clinics">
                                                {{$pharmacy->name}}
                                            </div>
                                            <div class="address-specialList-clinics">
                                                <i class="fas fa-map-marker-alt"></i>
                                                @php
                                                    $array = explode(',', $pharmacy->address);
                                                    $addressP = Province::where('id', $array[1] ?? null)->first();
                                                    $addressD = \App\Models\District::where('id', $array[2] ?? null)->first();
                                                    $addressC = \App\Models\Commune::where('id', $array[3] ?? null)->first();
                                                @endphp
                                                <div>{{$pharmacy->address_detail}}
                                                    , {{$addressC->name ?? ''}} , {{$addressD->name ?? ''}}
                                                    , {{$addressP->name ?? ''}}</div>
                                                - <span>3 Km</span>
                                            </div>
                                            <div class="time-working">
                                            <span class="color-timeWorking">
                                                 <span class="fs-14 font-weight-600">{{ \Carbon\Carbon::parse($pharmacy->open_date)->format('H:i') }} - {{ \Carbon\Carbon::parse($pharmacy->close_date)->format('H:i') }}</span>
{{--                                                09:00 - 19:00--}}
                                            </span>
                                                <span>
                                                 / {{ __('home.Dental Clinic') }}
                                            </span>
                                            </div>
                                            <div class="group-button d-flex mt-3">
                                                <a href="" class="col-md-6">
                                                    <div class="button-booking-specialList">
                                                        {{ __('home.Đặt khám') }}
                                                    </div>
                                                </a>
                                                <a href="{{route('home.specialist.detail', $pharmacy->id)}}" class="col-md-6">
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
                </div>
                <div class="tab-pane fade" id="doctorList" role="tabpanel" aria-labelledby="doctorList-tab">
                    <div class="row">

                        @foreach($doctorsSpecial as $doctor)
                            @if($doctor == '')
                                <h1 class="d-flex align-items-center justify-content-center mt-4">{{ __('home.null') }}</h1>
                            @else
                                <div class="col-md-3 col-12">
                                    <div class="p-3">
                                        <div class="product-item">
                                            <div class="img-pro h-100 justify-content-center d-flex">
                                                <img src="{{$doctor->avt}}" alt="">
                                                <a class="button-heart" data-favorite="0">
                                                    <i id="icon-heart" class="bi-heart bi"
                                                       data-product-id="${product.id}"
                                                       onclick="addProductToWishList(${product.id})"></i>
                                                </a>
                                                <s class="icon-chuyen-khoa">
                                                    @php
                                                        $department = \App\Models\Department::where('id',$doctor->department_id)->value('thumbnail');
                                                    @endphp
                                                    <img src="{{$department}}">
                                                </s>
                                            </div>
                                            <div class="content-pro p-3">
                                                <div class="">
                                                    <div class="name-product" style="height: auto">
                                                        <a class="name-product--fleaMarket"
                                                           href="{{ route('examination.doctor_info', $doctor->id) }}">{{$doctor->name}}</a>
                                                    </div>
                                                    <div class="location-pro d-flex">
                                                        <p>{!! $doctor->service !!}</p>
                                                    </div>
                                                    <div class="price-pro">
                                                        @php
                                                            if ($doctor->province_id == null) {
                                                                $addressP = 'Ha Noi';
                                                                }
                                                            else {
                                                                $addressP = Province::find($doctor->province_id)->name;
                                                                }
                                                        @endphp
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="21"
                                                             height="21" viewBox="0 0 21 21" fill="none">
                                                            <g clip-path="url(#clip0_5506_14919)">
                                                                <path
                                                                    d="M4.66602 12.8382C3.12321 13.5188 2.16602 14.4673 2.16602 15.5163C2.16602 17.5873 5.89698 19.2663 10.4993 19.2663C15.1017 19.2663 18.8327 17.5873 18.8327 15.5163C18.8327 14.4673 17.8755 13.5188 16.3327 12.8382M15.4993 7.59961C15.4993 10.986 11.7493 12.5996 10.4993 15.0996C9.24935 12.5996 5.49935 10.986 5.49935 7.59961C5.49935 4.83819 7.73793 2.59961 10.4993 2.59961C13.2608 2.59961 15.4993 4.83819 15.4993 7.59961ZM11.3327 7.59961C11.3327 8.05985 10.9596 8.43294 10.4993 8.43294C10.0391 8.43294 9.66602 8.05985 9.66602 7.59961C9.66602 7.13937 10.0391 6.76628 10.4993 6.76628C10.9596 6.76628 11.3327 7.13937 11.3327 7.59961Z"
                                                                    stroke="white" stroke-width="2"
                                                                    stroke-linecap="round"
                                                                    stroke-linejoin="round"/>
                                                            </g>
                                                            <defs>
                                                                <clipPath id="clip0_5506_14919">
                                                                    <rect width="20" height="20" fill="white"
                                                                          transform="translate(0.5 0.933594)"/>
                                                                </clipPath>
                                                            </defs>
                                                        </svg> &nbsp;
                                                        {{$addressP}}
                                                    </div>
                                                    <div class="price-pro">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="21"
                                                             height="21" viewBox="0 0 21 21" fill="none">
                                                            <g clip-path="url(#clip0_5506_14923)">
                                                                <path
                                                                    d="M10.4993 5.93294V10.9329L13.8327 12.5996M18.8327 10.9329C18.8327 15.5353 15.1017 19.2663 10.4993 19.2663C5.89698 19.2663 2.16602 15.5353 2.16602 10.9329C2.16602 6.33057 5.89698 2.59961 10.4993 2.59961C15.1017 2.59961 18.8327 6.33057 18.8327 10.9329Z"
                                                                    stroke="white" stroke-width="2"
                                                                    stroke-linecap="round"
                                                                    stroke-linejoin="round"/>
                                                            </g>
                                                            <defs>
                                                                <clipPath id="clip0_5506_14923">
                                                                    <rect width="20" height="20" fill="white"
                                                                          transform="translate(0.5 0.933594)"/>
                                                                </clipPath>
                                                            </defs>
                                                        </svg> &nbsp; {{$doctor->time_working_1}}
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
@endsection
