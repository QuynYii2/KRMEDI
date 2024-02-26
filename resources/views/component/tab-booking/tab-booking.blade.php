@extends('layouts.master')
<div class="col-md-2 container-fluid">
    <div>
        <img src="{{asset('img/doctor.png')}}" alt="img">
    </div>
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
    <div class="mt-md-3 mb-md-3">
        <a class="border-button-address font-weight-800 fs-14 justify-content-center" href="{{route('clinic.booking.service',$id)}}">{{ __('home.Booking') }}</a>
    </div>
    <div class="border-top">
        <div class="mt-md-2"><i class="text-gray mr-md-2 fa-solid fa-location-dot"></i>
            <span class="fs-14 font-weight-600">
               {{$bookings->address_detail}}
            </span>
        </div>
        <div class="mt-md-2">
            <i class="text-gray mr-md-2 fa-regular fa-clock"></i>
            <span class="fs-14 font-weight-600">{{ __('home.Open') }}: {{ \Carbon\Carbon::parse($bookings->open_date)->format('H:i') }} - {{ \Carbon\Carbon::parse($bookings->close_date)->format('H:i') }}
</span>
        </div>
        <div class="mt-md-2">
            <i class="text-gray mr-md-2 fa-solid fa-globe"></i>
            <span class="fs-14 font-weight-600"> {{$bookings->email}}</span>
        </div>
        <div class="mt-md-2">
            <i class="text-gray mr-md-2 fa-solid fa-phone-volume"></i> <span class="fs-14 font-weight-600">{{$bookings->phone}}</span>
        </div>
        <div class="mt-md-2 mb-md-2">
            <i class="text-gray mr-md-2 fa-solid fa-bookmark"></i> <span class="fs-14 font-weight-600"> {{$bookings->type}}</span>
        </div>
       @for($i=0; $i<3; $i++)
            <div class="border-top mb-md-2">
                <div class="d-flex justify-content-between rv-header align-items-center mt-md-2">
                    <div class="d-flex rv-header--left">
                        <div class="avt-24 mr-md-2">
                            <img src="{{asset('img/detail_doctor/ellipse _14.png')}}">
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
            <div class="d-flex justify-content-between rv-header align-items-center mt-md-2">
                <div class="d-flex rv-header--left">
                    <div class="avt-24 mr-md-2">
                        <img src="{{asset('img/detail_doctor/ellipse _14.png')}}">
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


