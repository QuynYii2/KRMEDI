@php use App\Enums\online_medicine\FilterOnlineMedicine;use App\Enums\online_medicine\ObjectOnlineMedicine;use App\Http\Controllers\MainController;use App\Models\User;use Illuminate\Support\Facades\Auth; @endphp
@php use App\Enums\TypeCoupon; @endphp
@php
    \App\Http\Controllers\CouponController::checkAndUpdateExpiredStatus();
@endphp
@extends('layouts.master')
@section('title', 'What free')
@section('content')
    @include('layouts.partials.header')
    @include('component.banner')
    <style>
        @media (max-width: 576px) {
            #what-free-index .btnModalCart.shopping-bag {
                margin-right: 0;
                height: 100%;
                width: 100%;
            }
        }
    </style>
    <link href="{{ asset('css/whatfree.css') }}" rel="stylesheet">
    <div class="container" id="what-free-index">
        <div class=" medicine-search d-block d-sm-none">
            <div class="medicine-search--center row">
                <form class="search-box col-12">
                    <input type="search" name="search-input"
                           placeholder="{{ __('home.Search for anything…') }}" id="search-input" value="{{$nameSearch}}">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </form>
            </div>
        </div>

        <div class="clinics-list">
            <div class="clinics-header margin-bottom-32 border-bottom">
                <div class="justify-content-between align-items-center d-flex mt-4 mb-2">
                    <div class="ac-text_content ">{{ __('home.Free today') }}</div>
                    <div class="flea-content-product"><a
                            href="{{route('what.free.see.all', ['type' => TypeCoupon::FREE_TODAY])}}">{{ __('home.See all') }}</a>
                    </div>
                </div>
            </div>
            <div class="body row">
                @if(count($coupons_freeToDay) > 0)
                    @foreach($coupons_freeToDay as $coupon)
                        @include('What-free.component-what-free', ['coupon' => $coupon])
                    @endforeach
                @else
                    <h3 class="no-data text-center">{{ __('home.no data') }}</h3>
                @endif
            </div>
        </div>
        <div class="clinics-list">
            <div class="clinics-header margin-bottom-32 border-bottom">
                <div class="justify-content-between align-items-center d-flex mt-4 mb-2">
                    <div class="ac-text_content ">{{ __('home.Free with mission') }}</div>
                    <div class="flea-content-product"><a
                            href="{{route('what.free.see.all', ['type' => TypeCoupon::FREE_MISSION])}}">{{ __('home.See all') }}</a>
                    </div>
                </div>
            </div>
            <div class="body row">
                @if(count($coupons_withMission) > 0)
                    @foreach($coupons_withMission as $coupon)
                        @include('What-free.component-what-free', ['coupon' => $coupon])
                    @endforeach
                @else
                    <h3 class="no-data text-center">{{ __('home.no data') }}</h3>
                @endif
            </div>
        </div>
        <div class="clinics-list">
            <div class="clinics-header margin-bottom-32 border-bottom">
                <div class="justify-content-between align-items-center d-flex mt-4 mb-2">
                    <div class="ac-text_content ">{{ __('home.Discounted sevice') }}</div>
                    <div class="flea-content-product"><a
                            href="{{route('what.free.see.all', ['type' => TypeCoupon::DISCOUNT_SERVICE])}}">{{ __('home.See all') }}</a>
                    </div>
                </div>
            </div>
            <div class="body row">
                @if(count($coupons_discount) > 0)
                    @foreach($coupons_discount as $coupon)
                        @include('What-free.component-what-free', ['coupon' => $coupon])
                    @endforeach
                @else
                    <h3 class="no-data text-center">{{ __('home.no data') }}</h3>
                @endif
            </div>
        </div>
    </div>

@endsection
