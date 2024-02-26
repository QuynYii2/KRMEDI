@extends('layouts.master')
@section('title', 'Flea Market')
@section('content')
    @include('layouts.partials.header')
    @include('component.banner')
    <div class="container">
        <div class="d-flex">
            <div class="col-md-3 mr-2 mobile-hidden">
                <div class="">
                    <div class=" row align-items-center justify-content-center">
                        <img src="{{asset('img/image 16.png')}}" alt="" >
                    </div>
                </div>
                <div class="">
                    <div class=" row align-items-center justify-content-center">
                        <div class="">
                            <img src="{{asset('img/image 16.png')}}" alt="" >
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-9 medicine-list--item col-12">
                @include('component.avt-info')
                <ul class="nav nav-tabs row tabMystore" role="tablist">
                    <li class="nav-item col-4">
                        <a class="nav-link d-flex align-items-center justify-content-center p-0 active font-14-mobi" id="productList-tab" data-toggle="tab" href="#productList" role="tab" aria-controls="home" aria-selected="true">{{ __('home.Home') }}</a>
                    </li>
                    <li class="nav-item col-4">
                        <a class="nav-link d-flex align-items-center justify-content-center p-0 font-14-mobi" id="review-tab" data-toggle="tab" href="#review" role="tab" aria-controls="profile" aria-selected="false">{{ __('home.Review') }}</a>
                    </li>
                    <li class="nav-item col-4">
                        <a class="nav-link d-flex align-items-center justify-content-center p-0 font-14-mobi" id="wishList-tab" data-toggle="tab" href="#wishList" role="tab" aria-controls="contact" aria-selected="false">{{ __('home.Wish list') }}</a>
                    </li>
                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="productList" role="tabpanel" aria-labelledby="productList-tab">
                                    @include('component.edit-product')
                    </div>
                    <div class="tab-pane fade" id="review" role="tabpanel" aria-labelledby="review-tab">
                        @include('component.review-item')
                    </div>
                    <div class="tab-pane fade" id="wishList" role="tabpanel" aria-labelledby="wishList-tab">
                                    @include('component.product-wish')
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
