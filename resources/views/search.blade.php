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
            font-weight: 700 !important;
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

        .search-way {
            width: fit-content;
            font-size: 12px;
            border-radius: 8px;
            margin-top: 10px;
            display: inline-block;
            color: #0070E0;
        }

        .search-way:hover {
            color: #0070E0;
        }

        .header-mobile-clinics {
            display: none;
        }

        .gm-style .gm-style-iw-c {
            max-width: 465px !important;
        }

        .zalo-follow-only-button {
            margin-top: 5px;
        }
    </style>
    <div class="header_clinic_desktop">
        @include('layouts.partials.header')
    </div>
    <div class="container pb-md-5 mt-200 mt-70">
        <p style="font-size: 18px;font-weight: bold">Kết quả tìm kiếm của " {{$search_input}} "</p>

        <div class="mt-5 d-flex flex-wrap">
            @if(count($listData)>0 && $listData)
            @foreach($listData as $item)
                <div class="specialList-clinics col-lg-4 col-6 mb-3">
                    <div class="border-specialList" style="gap:unset;padding:5px">
                        <div class="content__item d-flex">
                            <div class="specialList-clinics--img d-flex flex-column mr-2">
                                <a href="{{ route('home.specialist.detail', $item['id']) }}">
                                    <img src="{{$item['image']}}" class="img-item1"></a>
                            </div>
                            <div class="specialList-clinics--main w-100">
                                <a href="{{ route('home.specialist.detail', $item['id']) }}">
                                    <div class="title-specialList-clinics">
                                        @if (locationHelper() == 'vi')
                                {{$item['name']}}
                                        @else
                                            {{$item['name_en']}}
                                        @endif
                                    </div>
                                </a>

                                <div class="address-specialList-clinics">
                                    <div class="d-flex align-items-center address-clinics">
                                        <i class="fas fa-map-marker-alt mr-2"></i>
                                        <div style="-webkit-line-clamp: 3!important; font-size: 12px; margin-top: 5px">
                                            {{$item['address_detail']}}, {{$item['addressInfo']}}
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-between align-items-center flex-wrap">
                                    <div class="time-working w-100 d-flex justify-content-between"
                                         style="font-size: 12px !important">
                                                <span class="color-timeWorking">
                                                    <span class="fs-12 font-weight-600"><i
                                                            class="fa-regular fa-clock"></i> {{\Carbon\Carbon::parse($item['open_date'])->format('H:i')}} - {{\Carbon\Carbon::parse($item['close_date'])->format('H:i')}}</span>
                                                </span>
                                        <span class="distance"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
                @else
                <p style="text-align: center;color: red;font-weight: bold;font-size: 18px;width: 100%">Không có dữ liệu</p>
                @endif
        </div>
    </div>



@endsection
