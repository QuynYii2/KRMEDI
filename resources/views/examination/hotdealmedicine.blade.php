@extends('layouts.master')
@section('title', 'Home')
@section('content')
    @include('layouts.partials.header_3')
    @include('component.banner')
    <div class="container">
        <div class="d-flex justify-content-center">
            <div id="filter" class="box--1 d-flex w-100 ">
                <div class="d-flex flex-fill">
                    <div class="filter_option"><p>{{ __('home.Category') }} <i class="bi bi-chevron-expand"></i></p>
                    </div>
                    <div class="filter_option"><p>{{ __('home.Location') }}<i class="bi bi-chevron-expand"></i></p>
                    </div>
                </div>
                <div class="filter_search flex-fill">
                    <label for="filter_search"><i class="bi bi-search"></i></label>
                    <input type="text" name="filter_search" id="filter_search"
                           placeholder="{{ __('home.Search for anything…') }}">
                </div>
            </div>
        </div>
        <div id="title" class="d-flex justify-content-center">
            <div class="list-title">
                <div class="list--doctor p-0">
                    <a class="back" href="{{route('examination.findmymedicine')}}"><p><i
                                class="bi bi-arrow-left"></i><b>{{ __('home.Hot deal medicine') }}</b></p></a>
                </div>
            </div>
        </div>
        <div class="row list-doctor  m-auto">
            @if(count($hotMedicines) > 0)
                @foreach($hotMedicines as $hotMedicine)
                    @php
                        $user = \App\Models\User::find($hotMedicine->user_id);
                    @endphp
                    <div class="col-md-3">
                        <div class="card">
                            <i class="bi bi-heart"></i>
                            <img src="{{asset($hotMedicine->thumbnail)}}" class="card-img-top" alt="...">
                            <div class="card-body">
                                <a href="{{ route('medicine.detail', $hotMedicine->id) }}"><h5
                                        class="card-title">{{ $hotMedicine->name }}</h5></a>
                                <p class="card-text_1">{{ __('home.Location') }}: <b>{{ $user->address_code }}</b></p>
                                <p class="card-text_1">{{ __('home.Price') }}:
                                    <b>{{ $hotMedicine->price }} {{ $hotMedicine->unit_price }}</b></p>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
@endsection
