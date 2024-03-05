@php use App\Models\Province;

@endphp
@extends('layouts.master')
@section('title', 'Detail')
@section('content')
    <link rel="stylesheet" href="{{asset('css/homeSpecialist.css')}}">
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
                            <img class="content__item__image" src="{{asset('img/icons_logo/image 1.jpeg')}}"
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
                            <div class="group-button d-flex mt-3">
                                <a href="" class="mr-2">
                                    <div class="button-follow-specialList">
                                        {{ __('home.Theo dõi') }}

                                    </div>
                                </a>
                                <a href="{{route('clinic.detail',$clinicDetail->id)}}" class="">
                                    <div class="button-direct-specialList">
                                        {{ __('home.Chỉ đường') }}
                                    </div>
                                </a>
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
                    <div class="">
                        {!! $clinicDetail->introduce !!}
                    </div>
                </div>
                <div class="tab-pane fade" id="image" role="tabpanel" aria-labelledby="image-tab">
                    <div class="row">
                        @php
                            $galleryArray = explode(',', $clinicDetail->gallery);
                        @endphp
                        @foreach($galleryArray as $gallery)
                            <img class="p-0"
                                 style="width: 370px;
                                 height: 365px;
                                 object-fit: cover;
                                 border-radius: 16px;
                                 margin: 15px;
                                 "
                                 src="{{$gallery}}" alt="">
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

    <script>
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
@endsection
