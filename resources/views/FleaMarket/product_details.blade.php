@php use App\Http\Controllers\backend\BackendProductInfoController; @endphp
@php use Illuminate\Support\Facades\DB; @endphp
@php use Illuminate\Support\Facades\Auth; @endphp
@extends('layouts.master')
@section('title', 'Flea Market')
@section('content')
    @include('layouts.partials.header')
    @include('component.banner')
    @php
        $pr = (new BackendProductInfoController())->show($id);
        $productDetail = json_decode($pr->getContent());
        $pr_json = $productDetail->product;
        $galleryArray = explode(',', $pr_json->gallery);
    @endphp
    <style>
        .selected {
            border: 0 solid black;
            opacity: 0.5;
        }
    </style>
    <div class="recruitment-details ">
        <div class="container">
            <div class="recruitment-details--title"><a href="{{route('flea-market.index')}}"><i
                        class="fa-solid fa-arrow-left"></i> {{ __('home.Product details') }}</a></div>
            <div class="row recruitment-details--content">
                <div class="col-md-8 recruitment-details ">
                    @if(!empty($pr_json->thumbnail))
                        <div class="d-flex justify-content-center border-radius-1px color-Grey-Dark col-10 col-md-12">
                            <img src="{{asset($pr_json->thumbnail)}}" alt="show"
                                 class="main col-10 col-md-12">
                        </div>
                    @else
                        <img style="width: 100%" src="{{asset('img/flea-market/photo.png')}}" alt="show"
                             class="main col-10 col-md-12">
                        <p>{{ __('home.No Thumbnail Available') }}</p>
                    @endif
                    <div class="list col-2 col-md-12 mt-md-3">
                        @foreach($galleryArray as $pr_gallery)
                            <div
                                class="item-detail d-flex justify-content-center  border-radius-1px color-Grey-Dark mr-md-3">
                                <img  src="{{asset($pr_gallery)}}"
                                     alt=""
                                     class="border mw-140px gallery-detail">
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="col-md-4 recruitment-details--content--right">
                    <div class="form-1" id="form-hospital">
                        <div>
                            <strong class="flea-prise">
                                @if(locationHelper() == 'vi')
                                    {{ ($pr_json->name ?? __('home.no name') ) }}
                                @else
                                    {{ ($pr_json->name_en  ?? __('home.no name') ) }}
                                @endif
                            </strong>
                            <div class="text-content-product">
                                <strong
                                    class="">{{number_format($pr_json->price, 0, ',', '.') }} {{$pr_json->price_unit ?? 'VND'}}</strong>
                            </div>

                            <p style="color: #929292">{{ __('home.Location') }}:<strong class="flea-prise">
                                    @php
//                                        $province = DB::table('provinces')->where('id', $pr_json->province_id)->first();
                                    if(locationHelper() == 'vi')
                                        $province = DB::table('provinces')->find($pr_json->province_id)->name;
                                    else
                                        $province = DB::table('provinces')->find($pr_json->province_id)->name_en;
                                    @endphp
                                    @if(!empty($province))
                                        {{$province}}
                                    @else
                                        Null
                                    @endif
                                </strong></p>
                            <p style="color: #929292">{{ __('home.Category') }}:<strong class="flea-prise">
                                    @php
                                    if (locationHelper() == 'vi')
                                        $cata_json = DB::table('categories')->find($pr_json->category_id)->name;
                                    else
                                        $cata_json = DB::table('categories')->find($pr_json->category_id)->name_en;
                                    @endphp
                                    @if(!empty($cata_json))
                                        {{$cata_json}}
                                    @else
                                        Null
                                    @endif
                                </strong></p>
                            <p style="color: #929292">{{ __('home.Brand name') }}:<strong class="flea-prise">

                                    @if(locationHelper() == 'vi')
                                        {{ ($pr_json->brand_name ?? __('home.no name') ) }}
                                    @else
                                        {{ ($pr_json->brand_name_en  ?? __('home.no name') ) }}
                                    @endif
                                    </strong></p>
                        </div>
                        <div class="div-7 d-flex justify-content-between">
                            @if(Auth::user() == null || Auth::user()->id != $pr_json->created_by)
                                <a href="{{route('flea.market.product.shop.info',$pr_json->created_by)}}"
                                   class="div-wrapper">
                                    {{ __('home.Visit store') }}
                                </a>
                            @else
                                <a href="{{route('flea.market.my.store')}}" class="div-wrapper">
                                    {{ __('home.My store') }}
                                </a>
                            @endif
                            @if(Auth::check())
                                <button id="button-apply" class="text-wrapper-5"
                                        onclick="handleStartChatWithDoctor('{{ $pr_json->created_by }}')">{{ __('home.Send message') }}</button>
                            @else
                                <button id="button-apply" class="text-wrapper-5"
                                        onclick="alert('Bạn cần đăng nhập')">{{ __('home.Send message') }}</button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="row recruitment-details--text mt-45">
                <div class="col-md-8">
                    <hr>

                    {{-- Start nội dung mô tả (backend)--}}
                    <div class="frame">
                        <p class="text-content-product">@if(locationHelper() == 'vi')
                                {{ ($pr_json->name ?? __('home.no name') ) }}
                            @else
                                {{ ($pr_json->name_en  ?? __('home.no name') ) }}
                            @endif</p>
                        <div class="div mo-ta">
                            <div class="div-2">
                                <p class="text-content-product-2">{{ __('home.Product Description') }}</p>
                                <ul class="list-mo-ta">
                                    @if(locationHelper() == 'vi')
                                        {!! ( $pr_json->description ?? __('home.no name') ) !!}
                                    @else
                                        {!! ( $pr_json->description_en  ?? __('home.no name') ) !!}
                                    @endif
                                </ul>
                            </div>
                            {{-- End nội dung mô tả--}}
                        </div>
                    </div>
                </div>
            </div>
            <script>
                $('.list img').click(function () {
                    $(".main").attr("src", $(this).attr('src'));
                })
            </script>
            <script>
                $('.list .item-detail img').click(function () {
                    $('.list .item-detail img').removeClass('selected');
                    $(this).removeClass('border');
                    $(this).addClass('selected');
                    $(".main").attr("src", $(this).attr('src'));
                })
            </script>
        </div>
    </div>
@endsection
