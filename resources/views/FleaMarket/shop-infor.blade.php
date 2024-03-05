@extends('layouts.master')
@section('title', 'Flea Market')
@section('content')
    @include('layouts.partials.header')
    @include('component.banner')
    <div class="container">
        <div class="d-flex">
            <div class="col-md-3 mr-2 mobile-hidden">
                <div class=" row align-items-center justify-content-center">
                    <div class="">
                        <img src="{{asset('img/image 16.png')}}" alt="" >
                    </div>
                </div>
                <div class=" row align-items-center justify-content-center">
                    <div class="">
                        <img src="{{asset('img/image 16.png')}}" alt="" >
                    </div>
                </div>
            </div>
            <div class="col-md-9 medicine-list--item col-12">
                @include('component.avt-info')
                <ul class="nav nav-tabs row tabMystore" role="tablist">
                    <li class="nav-item col-4">
                        <a class="nav-link p-0 active font-14-mobi" id="productList-tab" data-toggle="tab" href="#productList" role="tab" aria-controls="home" aria-selected="true">{{ __('home.Home') }}</a>
                    </li>
                    <li class="nav-item col-4">
                        <a class="nav-link p-0 font-14-mobi" id="review-tab" data-toggle="tab" href="#review" role="tab" aria-controls="profile" aria-selected="false">{{ __('home.Review') }}</a>
                    </li>
                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="productList" role="tabpanel" aria-labelledby="productList-tab">
                        @include('FleaMarket.tab-product-flea')
                    </div>
                    <div class="tab-pane fade" id="review" role="tabpanel" aria-labelledby="review-tab">
                        <div class="d-flex justify-content-end align-items-center mb-md-3">
                            <a id="writeReviewBtn" class="b-radius p-2" style="border-radius: 30px; background: none" ><i class="fa-regular fa-file-lines"></i>{{ __('home.Write a review') }}</a>
                        </div>
                        <div id="reviewItem">
                            @include('component.review-item')
                        </div>
                        <div id="createReviewStore" style="display: none;">
                            @include('FleaMarket.tab-create-review-store')
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            var writeReviewBtn = document.getElementById('writeReviewBtn');
            var reviewItem = document.getElementById('reviewItem');
            var createReviewStore = document.getElementById('createReviewStore');

            writeReviewBtn.addEventListener('click', function () {
                // Ẩn nút "Write a review"
                writeReviewBtn.style.display = 'none';

                // Ẩn review-item và hiển thị tab-create-review-store
                reviewItem.style.display = 'none';
                createReviewStore.style.display = 'block';
            });
        });
    </script>


@endsection
