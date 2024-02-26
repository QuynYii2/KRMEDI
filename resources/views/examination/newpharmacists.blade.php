@extends('layouts.master')
@section('title', 'Home')
@section('content')
    @include('layouts.partials.header_3')
    @include('component.banner')
    <div class="container">
    <div class="d-flex justify-content-center">
        <div id="filter" class="box--1 d-flex w-100">
            <div class="d-flex flex-fill">
                <div class="filter_option"><p>{{ __('home.Category') }} <i class="bi bi-chevron-expand"></i></p></div>
                <div class="filter_option"><p>{{ __('home.Location') }}<i class="bi bi-chevron-expand"></i></p></div>
            </div>
            <div class="filter_search flex-fill">
                <label for="filter_search"><i class="bi bi-search"></i></label>
                <input type="text" name="filter_search" id="filter_search" placeholder="{{ __('home.Search for anything…') }}">
            </div>
        </div>
    </div>
    <div id="title" class="d-flex justify-content-center">
        <div class="list-title d-flex">
            <div class="list--doctor p-0">
                <a class="back" href="{{route('examination.findmymedicine')}}"><p><i class="bi bi-arrow-left"></i>{{ __('home.New Pharmacists') }}</p></a>
            </div>
        </div>
    </div>
    <div class="list-doctor row  m-auto">
        @foreach($newPhamrmacists as $newPhamrmacist)
            <div class=" col-md-3">
                <div class="card">
                <i class="bi bi-heart"></i>
                @php
                    $arrayGallery=[];
                    $gallery = $newPhamrmacist->gallery;
                    if ($gallery){
                        $arrayGallery = explode(',', $gallery);
                    }
                    $text = '';
                    switch ($newPhamrmacist->time_work){
                        case \App\Enums\TypeTimeWork::ALL:
                            $text = '24/7';
                            break;
                        case \App\Enums\TypeTimeWork::OTHER:
                            $text = 'Other';
                            break;
                        case \App\Enums\TypeTimeWork::ONLY_MORNING:
                            $text = 'All morning';
                            break;
                        case \App\Enums\TypeTimeWork::ONLY_AFTERNOON:
                            $text = 'All afternoon';
                            break;
                        default:
                            $text = 'Private';
                            break;

                    }

                @endphp
                @if(count($arrayGallery) > 0)
                    <img src="{{asset($arrayGallery[0])}}" class="card-img-top" alt="...">
                @endif
                <div class="card-body">
                    <a href="#"><h5
                            class="card-title"> {{ $newPhamrmacist->name }}</h5></a>
                    <p class="card-text_1">{{ __('home.Location') }}: <b>{{ $newPhamrmacist->address_detail }}</b></p>
                    <p class="card-text_1">{{ __('home.Working time') }}: <b> {{ $text }}</b></p>
                </div>
            </div>
            </div>
        @endforeach
    </div>
    </div>
@endsection
