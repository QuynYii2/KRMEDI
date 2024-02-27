@extends('layouts.master')
@section('title')
    {{ __('home.Detail') }}
@endsection
@section('content')
    @include('layouts.partials.header')
    @include('component.banner')
    <h1 class="h3 mb-4 text-gray-800">{{ __('home.Booking Detail') }}</h1>
    <div class="container-fluid">

    </div>
@endsection
