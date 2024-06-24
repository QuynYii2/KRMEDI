@php use App\Models\Province; @endphp

@extends('layouts.master')
@section('title', 'Specialist')
@section('content')
    <link rel="stylesheet" href="{{ asset('css/homeSpecialist.css') }}">
    <style>
        #showMapBtn{
            background: white;
        }
        .gm-style .gm-style-iw-d{
            max-width: 465px !important;
        }
        .btn-filter-bs{
            border: none;
            outline: unset;
            border-radius: 10px;
            padding: 10px;
        }
        .btn-filter-bs img{
            width: 24px;
            height: 24px;
        }
        .filter-section {
            margin-bottom: 20px;
        }
        .filter-section h5 {
            font-size: 18px;
            margin-bottom: 10px;
            font-weight: bold;
        }
        .filter-option {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 0;
        }
        .filter-option:last-child {
            border-bottom: 1px solid #e0e0e0;
        }
        .filter-option label {
            flex-grow: 1;
        }
        .filter-option input[type="radio"] {
            margin-left: 20px;
            width: 18px;
            height: 18px;
        }
        .filter-buttons {
            display: flex;
            justify-content: space-around;
            padding-top: 10px;
        }
        .filter-buttons button {
            padding: 10px 30px;
            font-size: 16px;
            cursor: pointer;
        }
        .reset-button {
            background-color: #f8f9fa;
            border: 1px solid #e0e0e0;
        }
        .apply-button {
            background-color: #17a2b8;
            color: white;
            border: none;
        }
        .filter-option img{
            width: 110px;
        }
    </style>
    @include('layouts.partials.header')
    <div class="container mt-200 mt-70 box-ck-new-home">
        <div class="danh-sach-theo-chuyen-khoa">
            <a href="{{ route('home.specialist') }}">
                <div class="title-Danh-sach"><i class="fa-solid fa-arrow-left"></i> {{ __('home.Danh sách') }}</div>
            </a>

            <div class="d-flex nav-header--homeNew justify-content-center mt-3">
                <ul class="nav nav-pills nav-fill d-flex justify-content-between">
                    <li class="nav-item">
                        <a class="nav-link font-14-mobi list-tab-menu-doctor @if($is_active == 1) active show @endif" id="clinicList-tab" data-toggle="tab" href="#clinicList"
                           role="tab" aria-controls="clinicList" aria-selected="true">{{ __('home.HOSPITALS') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link font-14-mobi list-tab-menu-doctor @if($is_active == 2) active show @endif" id="pharmacies-tab" data-toggle="tab" href="#pharmacies"
                           role="tab" aria-controls="pharmacies" aria-selected="false">{{ __('home.CLINICS') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link font-14-mobi list-tab-menu-doctor is-doctor-tab @if($is_active == 3) active show @endif" id="doctorList-tab" data-toggle="tab" href="#doctorList"
                           role="tab" aria-controls="doctorList" aria-selected="true">{{ __('home.DOCTOR') }}</a>
                    </li>
                </ul>
            </div>
            <div class="tab-content mt-4" id="myTabContent">
                <div class="tab-pane list-tab-content-doctor fade @if($is_active == 1) active show @endif" id="clinicList" role="tabpanel" aria-labelledby="clinicList-tab">
                    <form class="mb-5">
                        <div class="search-specialist col-lg-8 col-md-10">
                            <label for="search-specialist" class="search-specialist__label w-75">
                                <i class="fas fa-search"></i>
                                <input id="search-specialist" name="search_hospital" placeholder="{{ __('home.Tìm kiếm cơ sở y tế') }}"
                                       value="{{ request()->query('search_hospital') }}" style="border-top-right-radius:10px!important;border-bottom-right-radius:10px!important;">
                            </label>
                        </div>
                    </form>
                    <div class="box-list-clinic-address">
                        @if(count($clinics)>0)
                        <div class="body row" id="productInformation">
                            @foreach ($clinics as $key => $clinic)
                                <div class="specialList-clinics specialList-clinics-address col-lg-12 col-md-6 mb-3" data-marker-index=""
                                     data-clinic-id="{{ $clinic->id }}">
                                    <div class="border-specialList">
                                        <div class="content__item d-flex box-item__content">
                                            <div class="specialList-clinics--img img-special-line">
                                                @php
                                                    $galleryArray = explode(',', $clinic->gallery);
                                                @endphp
                                                <img class="content__item__image" src="{{ $galleryArray[0] }}" alt=""/>
                                                <button id="showMapBtn" class="search-way" style="border: none"><i class="fa-solid fa-location-arrow"></i>Chỉ đường</button>
                                                <div class="group-button d-flex flex-column box-desktop-line-address mt-2">
                                                    <a href="{{ route('home.specialist.booking.detail', $clinic->id) }}"
                                                       class="item-btn-specialist">
                                                        <div class="button-booking-specialList line-dk-btn">
                                                            {{ __('home.Đặt khám') }}
                                                        </div>
                                                    </a>
                                                    <a href="{{ route('home.specialist.detail', $clinic->id) }}"
                                                       class="item-btn-specialist">
                                                        <div class="button-detail-specialList">
                                                            {{ __('home.Xem chi tiết') }}
                                                        </div>
                                                    </a>
                                                </div>
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
                                                        <div class="text-address m-0">{{ $clinic->address_detail }}
                                                            , {{ $addressC->name ?? '' }} , {{ $addressD->name ?? '' }}
                                                            , {{ $addressP->name ?? '' }}</div>
                                                    </div>
                                                </div>
                                                <div class="time-working d-flex justify-content-between mt-2">
                                                <span class="color-timeWorking">
                                                    <span
                                                        class="fs-14 font-weight-600"><i
                                                            class="fa-regular fa-clock"></i> {{ \Carbon\Carbon::parse($clinic->open_date)->format('H:i') }}
                                                        -
                                                        {{ \Carbon\Carbon::parse($clinic->close_date)->format('H:i') }}</span>
                                                </span>
                                                        <div style="width: fit-content">
                                                            <i class="fas fa-map-marker-alt"
                                                               style="color: #088180"></i>
                                                            <span class="clinicDistanceSpan">
                                                    <p class="lat">{{ $clinic->latitude }}</p>
                                                    <p class="long">{{ $clinic->longitude }}</p>
                                                </span>
                                                        </div>
                                                </div>
                                                <div class="group-button d-flex box-mobile-line-address mt-2">
                                                    <a href="{{ route('home.specialist.booking.detail', $clinic->id) }}"
                                                       class="item-btn-specialist">
                                                        <div class="button-booking-specialList line-dk-btn">
                                                            {{ __('home.Đặt khám') }}
                                                        </div>
                                                    </a>
                                                    <a href="{{ route('home.specialist.detail', $clinic->id) }}"
                                                       class="item-btn-specialist">
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
                        <div class="box-content-map">
                            <div id="allAddressesMap" class="show active fade w-100" style="height: 800px;">

                            </div>
                            <div class="swiper mySwiperMap">
                                <div class="swiper-wrapper data-map">

                                </div>
                            </div>
                        </div>

                        @else
                            <p style="color: red;text-align: center;font-size: 20px;width: 100%;">Không có dữ liệu bạn muốn tìm</p>
                        @endif
                    </div>
                </div>

                <div class="tab-pane fade list-tab-content-doctor @if($is_active == 2) active show @endif" id="pharmacies" role="tabpanel" aria-labelledby="pharmacies-tab">
                    <form class="mb-5">
                        <div class="search-specialist col-lg-8 col-md-10">
                            <label for="search-specialist" class="search-specialist__label w-75">
                                <i class="fas fa-search"></i>
                                <input id="search-specialist" name="search_clinic" placeholder="Tìm kiếm phòng khám"
                                       value="{{ request()->query('search_clinic') }}" style="border-top-right-radius:10px!important;border-bottom-right-radius:10px!important;">
                            </label>
                        </div>
                    </form>
                    <div class="box-list-clinic-address">
                        @if(count($pharmacies)>0)
                        <div class="body row" id="productInformation">
                            @foreach ($pharmacies as $index => $pharmacy)
                                <div class="specialList-clinics specialList-pharmacy-address col-lg-12 col-md-6 mb-3" data-marker-index="{{$index}}"
                                     data-pharmacy-id="{{ $pharmacy->id }}">
                                    <div class="border-specialList">
                                        <div class="content__item d-flex box-item__content">
                                            <div class="specialList-clinics--img img-special-line">
                                                @php
                                                    $galleryArray = explode(',', $pharmacy->gallery);
                                                @endphp
                                                <img class="content__item__image" src="{{ $galleryArray[0] }}"
                                                     alt=""/>
                                                <button id="showMapBtnPharmacy" class="search-way" style="border: none"><i class="fa-solid fa-location-arrow"></i>Chỉ đường</button>
                                                <div class="group-button d-flex flex-column box-desktop-line-address mt-2">
                                                    <a href="{{ route('home.specialist.booking.detail', $pharmacy->id) }}" class="item-btn-specialist">
                                                        <div class="button-booking-specialList line-dk-btn">
                                                            {{ __('home.Đặt khám') }}
                                                        </div>
                                                    </a>
                                                    <a href="{{route('home.specialist.detail', $pharmacy->id)}}"
                                                       class="item-btn-specialist">
                                                        <div class="button-detail-specialList">
                                                            {{ __('home.Xem chi tiết') }}
                                                        </div>
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="specialList-clinics--main w-100">
                                                <div class="title-specialList-clinics">
                                                    {{ $pharmacy->name }}
                                                </div>
                                                <div class="address-specialList-clinics d-flex align-items-center">
                                                    <div class="d-flex align-items-center">
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
                                                </div>
                                                <div class="time-working d-flex justify-content-between mt-2">
                                                <span class="color-timeWorking">
                                                    <span
                                                        class="fs-14 font-weight-600">{{ \Carbon\Carbon::parse($pharmacy->open_date)->format('H:i') }}
                                                        -
                                                        {{ \Carbon\Carbon::parse($pharmacy->close_date)->format('H:i') }}</span>
                                                </span>
                                                    <div style="width: fit-content">
                                                        <i class="fas fa-map-marker-alt"
                                                           style="color: #088180"></i>
                                                    <span class="pharmacyDistanceSpan">
                                                    <p class="lat">{{ $pharmacy->latitude }}</p>
                                                    <p class="long">{{ $pharmacy->longitude }}</p>
                                                </span>
                                                    </div>
                                                </div>

                                                <div class="group-button d-flex box-mobile-line-address mt-2">
                                                    <a href="{{ route('home.specialist.booking.detail', $pharmacy->id) }}" class="item-btn-specialist">
                                                        <div class="button-booking-specialList line-dk-btn">
                                                            {{ __('home.Đặt khám') }}
                                                        </div>
                                                    </a>
                                                    <a href="{{route('home.specialist.detail', $pharmacy->id)}}"
                                                       class="item-btn-specialist">
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
                            <div class="box-content-map">
                        <div id="allAddressesMapPharmacies" class="show active fade w-100" style="height: 800px;">

                        </div>
                            <div class="swiper mySwiperMapPharmacies">
                                <div class="swiper-wrapper data-map-pharmacies">

                                </div>
                            </div>
                            </div>
                            @else
                            <p style="color: red;text-align: center;font-size: 20px;width: 100%;">Không có dữ liệu bạn muốn tìm</p>
                            @endif
                    </div>
                </div>

                <div class="tab-pane fade list-tab-content-doctor is-doctor-tab @if($is_active == 3) active show @endif" id="doctorList" role="tabpanel" aria-labelledby="doctorList-tab">
                    <div class="d-flex align-items-center mb-5 w-100 justify-content-center">
                        <form style="width: 50%;margin-right: 15px">
                            <div class="search-specialist">
                                <label for="search-specialist" class="search-specialist__label w-100">
                                    <i class="fas fa-search"></i>
                                    <input id="search-specialist" name="search_doctor" placeholder="Tìm kiếm bác sĩ"
                                           value="{{ request()->query('search_doctor') }}" style="border-top-right-radius:10px!important;border-bottom-right-radius:10px!important;">
                                </label>
                            </div>
                        </form>
                        <button class="btn-filter-bs" data-bs-toggle="offcanvas" data-bs-target="#offcanvasDoctorRight" aria-controls="offcanvasDoctorRight">
                            <img src="{{asset('img/icon-filter.png')}}" alt="">
                        </button>
                    </div>

                    <div class="row">
                        @if(count($doctorsSpecial)>0)
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
                                                    <div
                                                        class="location-pro box-about-doctor box-about-doctor-specialist">
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
                                                                    stroke-linecap="round" stroke-linejoin="round"/>
                                                            </g>
                                                            <defs>
                                                                <clipPath id="clip0_5506_14919">
                                                                    <rect width="20" height="20" fill="white"
                                                                          transform="translate(0.5 0.933594)"/>
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
                                                                    stroke-linecap="round" stroke-linejoin="round"/>
                                                            </g>
                                                            <defs>
                                                                <clipPath id="clip0_5506_14923">
                                                                    <rect width="20" height="20" fill="white"
                                                                          transform="translate(0.5 0.933594)"/>
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
                        @else
                            <p style="color: red;text-align: center;font-size: 20px">Không có dữ liệu bạn muốn tìm</p>
                        @endif
                    </div>
                    <div class="pagination mt-4 d-flex align-items-center justify-content-center">
                        {{ $doctorsSpecial->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasDoctorRight" aria-labelledby="offcanvasRightLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="offcanvasRightLabel" style="font-weight: bold">Bộ lọc</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body pt-0">
            <form method="get" action="{{route('home.specialist.department',$id)}}">
                <div class="filter-section">
                    <h5>Chuyên khoa</h5>
                    <div class="filter-option">
                        <select name="departments_id" class="form-control">
                            <option value="">-- Chuyên khoa --</option>
                            @foreach($departments as $val)
                                <option value="{{$val->id}}">{{$val->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            <div class="filter-section">
                <h5>Kinh nghiệm</h5>
                <div class="filter-option">
                    <label for="experience">1 - 3 Năm kinh nghiệm</label>
                    <input type="radio" name="experience" id="experience" @if(request()->query('experience') == 1) checked @endif value="1">
                </div>
                <div class="filter-option">
                    <label for="experience2">3 - 5 Năm kinh nghiệm</label>
                    <input type="radio" name="experience" id="experience2" @if(request()->query('experience') == 2) checked @endif value="2">
                </div>
                <div class="filter-option">
                    <label for="experience3">5 - 8 Năm kinh nghiệm</label>
                    <input type="radio" name="experience" id="experience3" @if(request()->query('experience') == 3) checked @endif value="3">
                </div>
                <div class="filter-option">
                    <label for="experience4">8 - 10 Năm kinh nghiệm</label>
                    <input type="radio" name="experience" id="experience4" @if(request()->query('experience') == 4) checked @endif value="4">
                </div>
                <div class="filter-option">
                    <label for="experience5">+10 Năm kinh nghiệm</label>
                    <input type="radio" name="experience" id="experience5" @if(request()->query('experience') == 5) checked @endif value="5">
                </div>
            </div>
            <div class="filter-section">
                <h5>Tôi có thể kê đơn thuốc được không?</h5>
                <div class="filter-option">
                    <label>Đơn thuốc?</label>
                    <input type="radio" name="prescribe" @if(request()->query('prescribe') == 1) checked @endif value="1">
                </div>
            </div>
            <div class="filter-section">
                <h5>Miễn phí hoặc không miễn phí</h5>
                <div class="filter-option">
                    <label for="free">Miễn phí</label>
                    <input type="radio" name="free" id="free" @if(request()->query('free') == 1) checked @endif value="1">
                </div>
                <div class="filter-option">
                    <label for="free2">Mất phí</label>
                    <input type="radio" name="free" id="free2" @if(request()->query('free') === '0') checked @endif value="0">
                </div>
            </div>
            <div class="filter-section">
                <h5>Đánh giá</h5>
                <div class="filter-option">
                    <label for="reviews">
                        <span><img src="{{asset('img/icon-star.png')}}" alt=""></span>
                        4.5-5
                    </label>
                    <input type="radio" name="reviews" id="reviews" @if(request()->query('reviews') == 4.5) checked @endif value="4.5">
                </div>
                <div class="filter-option">
                    <label for="reviews2">
                        <span><img src="{{asset('img/icon-star.png')}}" alt=""></span>
                        4-4.5
                    </label>
                    <input type="radio" name="reviews" id="reviews2" @if(request()->query('reviews') == 4) checked @endif value="4">
                </div>
                <div class="filter-option">
                    <label for="reviews3">
                        <span><img src="{{asset('img/icon-star.png')}}" alt=""></span>
                        3.5-4
                    </label>
                    <input type="radio" name="reviews" id="reviews3" @if(request()->query('reviews') == 3.5) checked @endif value="3.5">
                </div>
                <div class="filter-option">
                    <label for="reviews4">
                        <span><img src="{{asset('img/icon-star.png')}}" alt=""></span>
                        3-3.5
                    </label>
                    <input type="radio" name="reviews" id="reviews4" @if(request()->query('reviews') == 3) checked @endif value="3">
                </div>
                <div class="filter-option">
                    <label for="reviews5">
                        <span><img src="{{asset('img/icon-star.png')}}" alt=""></span>
                        2.5-3
                    </label>
                    <input type="radio" name="reviews" id="reviews5" @if(request()->query('reviews') == 2.5) checked @endif value="2.5">
                </div>
                <div class="filter-option">
                    <label for="reviews">
                        <span><img src="{{asset('img/icon-star.png')}}" alt=""></span>
                        0-2.5
                    </label>
                    <input type="radio" name="reviews" id="reviews" @if(request()->query('reviews') === '0') checked @endif value="0">
                </div>
            </div>
            <div class="filter-buttons">
                <button type="button" class="reset-button"><a href="{{url('home/specialist/'.$id)}}">Làm mới</a></button>
                <button type="submit" class="apply-button">Áp dụng</button>
            </div>
            </form>
        </div>
    </div>
    <script>
        $(document).ready(function () {
            localStorage.setItem('check-kham','active')
            var clinics = {!! json_encode($clinics) !!};
            var pharmacies = {!! json_encode($pharmacies) !!};

            function waitForAllLocations(clinics) {
                var promises = clinics.map(function(clinic) {
                    return new Promise(function(resolve) {
                        var clinicElement = $('.specialList-clinics[data-clinic-id="' + clinic.id + '"]');
                        var distanceSpan = clinicElement.find('.clinicDistanceSpan');
                        var latitude = distanceSpan.find('.lat').text();
                        var longitude = distanceSpan.find('.long').text();

                        getCurrentLocation(function(currentLocation) {
                            var newDistance = calculateDistance(currentLocation.lat, currentLocation.lng, parseFloat(latitude), parseFloat(longitude));
                            var formattedDistance = newDistance.toFixed(2).replace('.', ',');
                            distanceSpan.text(formattedDistance + 'Km');
                            resolve(newDistance);
                        });

                    });
                });
                return Promise.all(promises);
            }
            waitForAllLocations(clinics).then(function(distances) {
                var clinicIndex = 0;
                clinics.forEach(function(clinic, index) {
                    var distance = distances[index];
                    var clinicElement = $('.specialList-clinics[data-clinic-id="' + clinic.id + '"]');
                    if (distance <= 10) {
                        clinicElement.attr('data-marker-index', clinicIndex++);
                    } else {
                        clinicElement.hide();
                    }
                });
            });

            function waitForAllPharmacyLocations(pharmacies) {
                var promises = pharmacies.map(function(pharmacy) {
                    return new Promise(function(resolve) {
                        var pharmacyElement = $('.specialList-clinics[data-pharmacy-id="' + pharmacy.id + '"]');
                        var distanceSpan = $('.specialList-clinics[data-pharmacy-id="' + pharmacy.id + '"]').find('.pharmacyDistanceSpan');
                        var latitude = distanceSpan.find('.lat').text();
                        var longitude = distanceSpan.find('.long').text();

                        getCurrentLocation(function(currentLocation) {
                            var newDistance = calculateDistance(currentLocation.lat, currentLocation.lng, parseFloat(latitude), parseFloat(longitude));
                            var formattedDistances = newDistance.toFixed(2).replace('.', ',');
                            distanceSpan.text(formattedDistances + 'Km');
                            resolve({distance: newDistance, pharmacyElement: pharmacyElement});
                        });

                    });
                });
                return Promise.all(promises);
            }
            waitForAllPharmacyLocations(pharmacies).then(function(results) {
                var pharmacyIndex = 0;
                results.forEach(function(result) {
                    var distance = result.distance;
                    var pharmacyElement = result.pharmacyElement;
                    if (distance <= 10) {
                        pharmacyElement.attr('data-marker-index', pharmacyIndex++);
                    } else {
                        pharmacyElement.hide();
                    }
                });
            });
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
            var swiperPharmacies = new Swiper(".mySwiperMapPharmacies", {
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
            var locations = {!! json_encode($clinics) !!};
            var locationsPharmacies = {!! json_encode($pharmacies) !!};
            var markers = [];
            var markersPharmacy = [];
            var infoWindows = [];
            var infoWindowsPharmacy = [];
            var directionsService;
            var directionsRenderer;
            var directionsService2;
            var directionsRenderer2;

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

            function getCurrentLocationPharmacies(callback) {
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

            function formatTime(dateTimeString) {
                const date = new Date(dateTimeString);
                const hours = date.getHours().toString().padStart(2, '0');
                const minutes = date.getMinutes().toString().padStart(2, '0');
                return `${hours}:${minutes}`;
            }

            function initMap(currentLocation, clinicLocation, locations) {
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
                    var searchRadius = 10;

                    if (distance <= searchRadius) {
                        var marker = new google.maps.Marker({
                            position: {lat: parseFloat(location.latitude), lng: parseFloat(location.longitude)},
                            map: map,
                            title: 'Location'
                        });
                        var urlDetail = "{{ route('home.specialist.booking.detail', ['id' => ':id']) }}".replace(':id', location.id);
                        let img = '';
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
                            <i class="text-gray mr-md-2 fa-solid fa-phone-volume"></i> <span
                                class="fs-14 font-weight-600"> ${location.phone}</span>
                        </div>

            </div>
        </div>
    </div> </div></div>`;

                        // var infoWindow = new google.maps.InfoWindow({
                        //     content: infoWindowContent
                        // });
                        //
                        // marker.addListener('click', function () {
                        //     closeAllInfoWindows();
                        //     infoWindow.open(map, marker);
                        //     $(document).on('click', '#showMapBtnTab', function() {
                        //         getDirections(currentLocation, {lat: parseFloat(location.latitude), lng: parseFloat(location.longitude)});
                        //         closeAllInfoWindows();
                        //     });
                        // });

                        markers.push(marker);
                        // infoWindows.push(infoWindow);
                        location.markerIndex = markers.length - 1;

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

                        $('body').on('click', '.specialList-clinics[data-clinic-id="' + location.id + '"] #showMapBtn', function() {
                            getDirections(currentLocation, { lat: parseFloat(location.latitude), lng: parseFloat(location.longitude) });
                        });
                    }
                });
                $('.data-map').html(list_map);
                document.querySelectorAll('.specialList-clinics-address').forEach(function (item, index) {
                    item.addEventListener('click', function () {
                        var markerIndex = parseInt(item.getAttribute('data-marker-index'));
                        closeAllInfoWindows();
                        infoWindows[markerIndex].open(map, markers[markerIndex]);

                        var location = locations[markerIndex];
                        if (location && !isNaN(location.latitude) && !isNaN(location.longitude)) {
                            $(document).on('click', '#showMapBtnTab', function() {
                                console.log('click');
                                getDirections(currentLocation, { lat: parseFloat(location.latitude), lng: parseFloat(location.longitude) });
                            })
                            closeAllInfoWindows();
                        } else {
                            console.error('Invalid location data:', location);
                        }
                    });
                });

            }

            function initMapPharmacies(currentLocation, clinicLocationPharmacy,  locationsPharmacies) {
                var map2 = new google.maps.Map(document.getElementById('allAddressesMapPharmacies'), {
                    center: currentLocation,
                    zoom: 12.3,
                    gestureHandling: 'greedy',
                    streetViewControl: false,
                    zoomControl: false
                });
                 directionsService2 = new google.maps.DirectionsService();
                 directionsRenderer2 = new google.maps.DirectionsRenderer();
                directionsRenderer2.setMap(map2);

                var currentLocationMarker = new google.maps.Marker({
                    position: currentLocation,
                    map: map2,
                    title: 'Your Location'
                });
                let list_map_pharmacies = '';
                let count_address_pharmacies =0;
                locationsPharmacies.forEach(function (locationsPharmacies) {
                    var distance = calculateDistance(
                        currentLocation.lat, currentLocation.lng,
                        parseFloat(locationsPharmacies.latitude), parseFloat(locationsPharmacies.longitude)
                    );

                    // Chọn bán kính tìm kiếm (ví dụ: 5 km)
                    var searchRadius = 10;

                    if (distance <= searchRadius) {
                        var markerPharmacies = new google.maps.Marker({
                            position: {
                                lat: parseFloat(locationsPharmacies.latitude),
                                lng: parseFloat(locationsPharmacies.longitude)
                            },
                            map: map2,
                            title: 'Location'
                        });
                        var urlDetail = "{{ route('home.specialist.booking.detail', ['id' => ':id']) }}".replace(':id', locationsPharmacies.id);
                        let img = '';
                        let gallery = locationsPharmacies.gallery;
                        let arrayGallery = gallery.split(',');

                        list_map_pharmacies += `<div class="swiper-slide swiper-slide-height slide_pharmacies_${count_address_pharmacies} bg-white" data-index="${count_address_pharmacies}" ><div class="p-0 m-0 tab-pane fade show active background-modal b-radius" id="modalBooking">
                <div class="box-img-item-map">
                    <img loading="lazy" class="b-radius" src="${arrayGallery[0]}" alt="img" style="height: 100%;object-fit: cover;">
                </div>
                <div class="p-2 box-info-item-map">
                    <div class="form-group mb-1">
                        <div class="d-flex justify-content-between mt-md-2">
                            <div class="fs-18px name-address-map">${locationsPharmacies.name}</div>

                        </div>
                        <div class="d-flex mt-md-2">
                            <div class="d-flex col-md-6 justify-content-center align-items-center">
                                <button class="row " id="showMapBtnPharmacyTab_${count_address_pharmacies}" style="background-color: transparent; border:none">
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
                                <span class="fs-14 font-weight-600">${locationsPharmacies.address_detail}</span>
                        </div>
                        <div class="mt-md-2 mt-1">
                            <i class="text-gray mr-md-2 fa-regular fa-clock"></i>
                            <span class="fs-14 font-weight-600">
                                Open: ${formatTime(locationsPharmacies.open_date)} - ${formatTime(locationsPharmacies.close_date)}
                            </span>
                        </div>

                        <div class="mt-md-2 mt-1">
                            <i class="text-gray mr-md-2 fa-solid fa-phone-volume"></i> <span
                                class="fs-14 font-weight-600"> ${locationsPharmacies.phone}</span>
                        </div>

        </div>
    </div></div></div>`;

                        // var infoWindow2 = new google.maps.InfoWindow({
                        //     content: infoWindowContent
                        // });
                        //
                        // markerPharmacies.addListener('click', function () {
                        //     closeAllInfoWindowsPharmacy();
                        //     infoWindow2.open(map2, markerPharmacies);
                        //     $(document).on('click', '#showMapBtnPharmacyTab', function() {
                        //         getDirectionsPharmacies(currentLocation, { lat: parseFloat(locationsPharmacies.latitude), lng: parseFloat(locationsPharmacies.longitude) });
                        //         closeAllInfoWindowsPharmacy();
                        //     });
                        // });
                        markersPharmacy.push(markerPharmacies);
                        // infoWindowsPharmacy.push(infoWindow2);
                        locationsPharmacies.markerIndex = markersPharmacy.length - 1;

                        let classBox2 = '.slide_pharmacies_'+count_address_pharmacies;
                        markerPharmacies.addListener('click', function () {
                            var index4= $(classBox2).attr('data-index');
                            swiperPharmacies.slideTo(index4);
                        });
                        $(document).on('click', '#showMapBtnPharmacyTab_'+count_address_pharmacies, function() {
                            if (locationsPharmacies && !isNaN(locationsPharmacies.latitude) && !isNaN(locationsPharmacies.longitude)) {
                                getDirectionsPharmacies(currentLocation, { lat: parseFloat(locationsPharmacies.latitude), lng: parseFloat(locationsPharmacies.longitude) });
                                var index3= $(classBox2).attr('data-index');
                                swiperPharmacies.slideTo(index3);
                            } else {
                                console.error('Invalid location data:', locationsPharmacies);
                            }
                        });
                        count_address_pharmacies ++;

                        $('body').on('click', '.specialList-pharmacy-address[data-pharmacy-id="' + locationsPharmacies.id + '"] #showMapBtnPharmacy', function() {
                            getDirectionsPharmacies(currentLocation, { lat: parseFloat(locationsPharmacies.latitude), lng: parseFloat(locationsPharmacies.longitude) });
                            closeAllInfoWindowsPharmacy();
                        });
                    }
                });
                $('.data-map-pharmacies').html(list_map_pharmacies);

                document.querySelectorAll('.specialList-pharmacy-address').forEach(function (item, index) {
                    item.addEventListener('click', function () {
                        var markerIndex = parseInt(item.getAttribute('data-marker-index'));
                        closeAllInfoWindowsPharmacy();
                        infoWindowsPharmacy[markerIndex].open(map2, markersPharmacy[markerIndex]);

                        var location = locationsPharmacies[markerIndex];
                        if (location && !isNaN(location.latitude) && !isNaN(location.longitude)) {
                            $(document).on('click', '#showMapBtnPharmacyTab', function() {
                                console.log('click');
                                getDirections(currentLocation, { lat: parseFloat(location.latitude), lng: parseFloat(location.longitude) });
                                closeAllInfoWindowsPharmacy();
                            })
                        } else {
                            console.error('Invalid location data:', location);
                        }
                    });
                });

            }
            function getDirectionsPharmacies(currentLocation, clinicLocation) {
                var request = {
                    origin: currentLocation,
                    destination: clinicLocation,
                    travelMode: 'DRIVING'
                };

                directionsService2.route(request, function(result, status) {
                    if (status === 'OK') {
                        directionsRenderer2.setDirections(result);
                        document.getElementById('allAddressesMapPharmacies').style.display = 'block';
                    } else {
                        console.error('Directions request failed due to ' + status);
                    }
                });
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
            function closeAllInfoWindows() {
                infoWindows.forEach(function (infoWindow) {
                    infoWindow.close();
                });
            }

            function closeAllInfoWindowsPharmacy() {
                infoWindowsPharmacy.forEach(function (infoWindow) {
                    infoWindow.close();
                });
            }

            getCurrentLocation(function (currentLocation) {
                initMap(currentLocation, null, locations);
            });

            getCurrentLocationPharmacies(function (currentLocation) {
                initMapPharmacies(currentLocation, null, locationsPharmacies);
            });

            document.addEventListener('DOMContentLoaded', function () {
                const departmentLinks = document.querySelectorAll('.department-link');

                departmentLinks.forEach(link => {
                    link.addEventListener('click', function (event) {
                        event.preventDefault();
                        const departmentId = this.getAttribute('data-id');
                        localStorage.setItem('departmentId', departmentId);
                        window.location.href = this.href;
                    });
                });
            });

        });

        document.addEventListener("DOMContentLoaded", function() {
            let params = new URLSearchParams(window.location.search);
            let isActive = `{{ $is_active }}`;

            if (params.has('search_hospital')) {
                isActive = 1;
            } else if (params.has('search_clinic')) {
                isActive = 2;
            } else if (params.has('search_doctor') || params.has('experience') || params.has('prescribe') || params.has('free') || params.has('reviews') || params.has('departments_id') ) {
                isActive = 3;
            } else {
                isActive = 1;
            }

            let tabs = document.querySelectorAll('.list-tab-content-doctor');
            tabs.forEach((tab, index) => {
                if (index + 1 === isActive) {
                    tab.classList.add('active','show');
                } else {
                    tab.classList.remove('active', 'show');
                }
            });

            let tabsMenu = document.querySelectorAll('.list-tab-menu-doctor');
            tabsMenu.forEach((menu, index) => {
                if (index + 1 === isActive) {
                    menu.classList.add('active','show');
                } else {
                    menu.classList.remove('active', 'show');
                }
            });

            let is_doctor_tab = localStorage.getItem('doctor');
            if(is_doctor_tab == 'true'){
                tabs.forEach((tab, index) => {
                    tab.classList.remove('active', 'show');
                });
                tabsMenu.forEach((menu, index) => {
                    menu.classList.remove('active', 'show');
                });
                $(".is-doctor-tab").addClass('active');
                $(".is-doctor-tab").addClass('show');
            }
            $(".list-tab-menu-doctor").click(function () {
                localStorage.setItem('doctor',false);
            });

        });

    </script>
@endsection
