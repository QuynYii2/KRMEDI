@extends('layouts.master')
@section('title', 'News')
@section('content')
    @include('layouts.partials.header')
    @include('component.banner')

    <div class="recruitment-details ">
        <div class="container">
            @if($listNews && count($listNews) > 0)
                @php
                    $news = $listNews->first();
                @endphp
                @if($news)
                    <a href="{{route('detail.new',$news->id)}}">
                        <div class="d-md-flex">
                            <div class="pl-0">
                                <img class="thumbnail-title b-radius-8px" src="{{$news->thumbnail}}">
                            </div>
                            <div class="main-title-news">
                                <strong class="text-content-product">
                                    @if(locationHelper() == 'vi')
                                        {{ ($news->title) }}
                                    @else
                                        {{ ($news->title_en) }}
                                    @endif
                                </strong>
                                <div class="text-gray max-6-line-title mt-md-3">
                                    @if(locationHelper() == 'vi')
                                        {!! $news->short_description !!}
                                    @else
                                        {!! $news->short_description_en !!}
                                    @endif
                                </div>
                            </div>
                        </div>
                    </a>
                @endif

                <div class="mt-4">
                    <p class="text-content-product">{{ __('home.All news') }}</p>
                </div>
                <div class="d-flex row">
                    @foreach($listNews as $news)
                        <div class="col-md-6 padding-news">
                            <a href="{{route('detail.new',$news->id)}}">
                                <div class="d-flex border-8px w-100">
                                    <div class="p-0 col-md-4 content__item__image">
                                        <img class="content__item__image" src="{{$news->thumbnail}}">
                                    </div>
                                    <div class="col-md-8 pr-0">

                                        <strong class="fs-16px max-2-line-title">
                                            @if(locationHelper() == 'vi')
                                                {{$news->title}}
                                            @else
                                                {{ $news->title_en }}
                                            @endif
                                        </strong>
                                        <div class="max-5-line-title">
                                            <div class="fs-12px">
                                                @if(locationHelper() == 'vi')
                                                    {!! $news->short_description !!}
                                                @else
                                                    {!! $news->short_description_en !!}
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
                <nav aria-label="Page navigation example" class="d-flex justify-content-center">
                    {{ $listNews->links() }}
                </nav>
            @else
                <div class="mt-4">
                    <p class="text-content-product">{{ __('home.All news') }}</p>
                </div>
                <div class="d-flex justify-content-center">
                    <h3>{{ __('home.Không có tin tức nào') }}</h3>
                </div>
            @endif
        </div>
    </div>
    <div class="banner2">
        @include('component.banner')
    </div>
    <div class="recruitment-details ">
        <div class="container">
            @if($listEvent && count($listEvent) > 0)
                @php
                    $Event = $listEvent->first();
                @endphp
                @if($Event)
                    <a href="{{route('detail.new',$Event->id)}}">
                        <div class="d-md-flex">
                            <div class="col-md-5 pl-0">
                                <img class="thumbnail-title b-radius-8px" src="{{$Event->thumbnail}}">
                            </div>
                            <div class="main-title-news">
                                <strong class="text-content-product">
                                    @if(locationHelper() == 'vi')
                                        {{$Event->title}}
                                    @else
                                        {{ $Event->title_en }}
                                    @endif</strong>
                                <div class="text-gray max-6-line-title mt-md-3">
                                    @if(locationHelper() == 'vi')
                                        {!! $Event->short_description !!}
                                    @else
                                        {!! $Event->short_description_en !!}
                                    @endif
                                </div>
                            </div>
                        </div>
                    </a>
                @endif
                <div class="mt-4">
                    <p class="text-content-product">{{ __('home.All Event') }}</p>
                </div>
                <div class="d-flex row">
                    @foreach($listEvent as $event)
                        <div class="col-md-6 padding-news">
                            <a href="{{route('detail.new',$event->id)}}">
                                <div class="d-flex border-8px w-100">
                                    <div class="col-md-4 p-0 content__item__image">
                                        <img class="content__item__image" src="{{$event->thumbnail}}">
                                    </div>
                                    <div class="col-md-8 pr-0">

                                        <strong class="fs-16px max-2-line-title">
                                            @if(locationHelper() == 'vi')
                                                {{$event->title}}
                                            @else
                                                {{ $event->title_en }}
                                            @endif
                                        </strong>
                                        <div class="max-5-line-title">
                                            <div class="fs-12px">
                                                @if(locationHelper() == 'vi')
                                                    {!! $event->short_description !!}
                                                @else
                                                    {!! $event->short_description_en !!}
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
                <nav aria-label="Page navigation example" class="d-flex justify-content-center">
                    {{ $listEvent->links() }}
                </nav>
            @else
                <div class="mt-4">
                    <p class="text-content-product">{{ __('home.All Event') }}</p>
                </div>
                <div class="d-flex justify-content-center">
                    <h3>{{ __('home.Không có sự kiện nào') }}</h3>
                </div>
            @endif
        </div>
    </div>

@endsection
