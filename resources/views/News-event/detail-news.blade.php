@extends('layouts.master')
@section('title', 'News')
@section('content')
    @include('layouts.partials.header')
    @include('component.banner')
    <div class="recruitment-details ">
        <div class="container">
            <a href="{{route('index.new')}}">
                <div class="recruitment-details--title p-md-2 p-0 mb-md-4"><i class="fa-solid fa-arrow-left"></i> {{ __('home.News details') }}</div>
            </a>
            <div class="d-flex">
                <div class="col-md-9">
                    <div>
                        <div class="news-content">
                            @if(locationHelper() == 'vi')
                                {{$newEvent->title}}
                            @else
                                {{$newEvent->title_en}}
                            @endif
                        </div>
                        <div class="fs-16px color-Grey-Dark mb-4 mt-2">{{ \Carbon\Carbon::parse($newEvent->created_at)->format('l, \n\g\à\y j-m-Y') }}</div>
                        <div class="justify-content-center row w-100">
                            <img class="b-radius-8px p-0" src="{{$newEvent->thumbnail}}">
                        </div>
{{--                        <div class="justify-content-center row mb-4">{!! $newEvent->short_description !!}</div>--}}
                        <div class="mt-md-3">
                            <div class="text-content-news">
                                @if(locationHelper() == 'vi')
                                    {!! $newEvent->short_description !!}
                                @else
                                    {!! $newEvent->short_description_en !!}!!}
                                @endif
                            </div>
                            <div class="text-gray body-news mt-3">
                                @if(locationHelper() == 'vi')
                                    {!! $newEvent->description !!}
                                @else
                                    {!! $newEvent->description_en !!}
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="border-top mt-30">
                        <div class="mb-30">
                            <div class="justify-content-between align-items-center d-flex mt-4">
                                <div class="ac-text_content ">{{ __('home.Related news') }}</div>
                                <div class="flea-content-product"><a href="{{route('index.new')}}">{{ __('home.See all') }}</a></div>
                            </div>
                        </div>
                        <div class="d-flex row">
                            @foreach($related as $item)
                                <div class="col-md-6 padding-news">
                                    <a href="{{route('detail.new',$item->id)}}">
                                        <div class="d-flex border-8px w-100">
                                            <div class="col-md-4 p-0 content__item__image">
                                                <img class="content__item__image" src="{{$item->thumbnail}}">
                                            </div>
                                            <div class="col-md-8 pr-0">

                                                <strong class="fs-16px max-2-line-title">
                                                    @if(locationHelper() == 'vi')
                                                        {{$item->title}}
                                                    @else
                                                        {{ $item->title_en }}
                                                    @endif
                                                </strong>
                                                <div class="max-5-line-title">
                                                    <div class="fs-12px">
                                                        @if(locationHelper() == 'vi')
                                                            {!! $item->short_description !!}
                                                        @else
                                                            {!! $item->short_description_en !!}
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="col-md-3 d-none d-md-block">
                    <img class="w-100 mb-4" src="{{asset('img/icons_logo/banner-doc.png')}}">
                    <img class="w-100 mb-4" src="{{asset('img/icons_logo/banner-doc.png')}}">
                    <img class="w-100 mb-4" src="{{asset('img/icons_logo/banner-doc.png')}}">
                </div>
            </div>

        </div>
    </div>

@endsection
