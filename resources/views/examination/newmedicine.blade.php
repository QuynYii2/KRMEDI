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
            <div class="form-group has-search">
                <span class="fa fa-search form-control-feedback"></span>
                <input type="text" class="form-control" placeholder="{{ __('home.Search for anything…') }}">
            </div>
        </div>
    </div>
    <div id="title" class="d-flex justify-content-center">
        <div class="list-title">
            <div class="list--doctor p-0">
                <a class="back" href="{{route('examination.findmymedicine')}}"><p><i class="bi bi-arrow-left"></i><b>{{ __('home.New medicine') }}</b></p></a>
            </div>
        </div>
    </div>
    <div class="row list-doctor container m-auto">
        @if(count($newMedicines) > 0)
            @foreach($newMedicines as $newMedicine)
                @php
                    $user = \App\Models\User::find($newMedicine->user_id);
                @endphp
                <div class="card col-md-3">
                    <div class="card">
                    <i class="bi bi-heart"></i>
                    <img src="{{asset($newMedicine->thumbnail)}}" class="card-img-top" alt="...">
                    <div class="card-body">
                        <a href="{{ route('medicine.detail', $newMedicine->id) }}"><h5 class="card-title">{{ $newMedicine->name }}</h5></a>
                        <p class="card-text_1">{{ __('home.Location') }}: <b>{{ $user->address_code }}</b></p>
                        <p class="card-text_1">{{ __('home.Price') }}: <b>{{ $newMedicine->price }} {{ $newMedicine->unit_price }}</b></p>
                    </div>
                </div>
                </div>
            @endforeach
        @endif
    </div>
    </div>
@endsection
