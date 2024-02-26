@extends('layouts.master')
@section('title', 'My Campaign')
@section('content')
    @include('layouts.partials.header')
    @include('component.banner')
    <div class="container">
        <div class="d-flex">
            <div class="col-md-12 medicine-list--item">
                <ul class="nav nav-tabs row tabMystore col-md-6" role="tablist">
                    <li class="nav-item col-4">
                        <a class="nav-link active" id="productList-tab" data-toggle="tab" href="#productList" role="tab"
                           aria-controls="home" aria-selected="true">{{ __('home.My campaign') }}</a>
                    </li>
                    <li class="nav-item col-4">
                        <a class="nav-link" id="review-tab" data-toggle="tab" href="#review" role="tab"
                           aria-controls="profile" aria-selected="false">{{ __('home.Interested campaign') }}</a>
                    </li>
                    <li class="nav-item col-4">
                        <a class="nav-link" id="wishList-tab" data-toggle="tab" href="#wishList" role="tab"
                           aria-controls="contact" aria-selected="false">{{ __('home.My SNS') }}</a>
                    </li>
                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="productList" role="tabpanel"
                         aria-labelledby="productList-tab">
                        <div class="page row">
                            @for($i = 0; $i < 12; $i++)
                                <div class="col-md-4 col-6 item">
                                    @include('component.edit-product')
                                </div>
                            @endfor
                        </div>
                    </div>
                    <div class="tab-pane fade" id="review" role="tabpanel" aria-labelledby="review-tab">
                        @include('component.review-item')
                    </div>
                    <div class="tab-pane fade" id="wishList" role="tabpanel" aria-labelledby="wishList-tab">
                        <div class="row">
                            @for($i = 0; $i < 12; $i++)
                                <div class="col-md-3">
                                    @include('component.product-wish')
                                </div>
                            @endfor
                        </div>
                    </div>
                </div>
                <nav aria-label="Page navigation example" class="d-flex justify-content-center">
                    <ul class="pagination">
                        <li class="page-item">
                            <a class="page-link" href="#" aria-label="Previous">
                                <span aria-hidden="true">&laquo;</span>
                                <span class="sr-only">{{ __('home.Previous') }}</span>
                            </a>
                        </li>
                        <li class="page-item"><a class="page-link" href="#">1</a></li>
                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                        <li class="page-item">
                            <a class="page-link" href="#" aria-label="Next">
                                <span aria-hidden="true">&raquo;</span>
                                <span class="sr-only">{{ __('home.Next') }}</span>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
@endsection
