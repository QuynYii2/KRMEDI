@extends('layouts.master')
@section('title')
    Booking Detail
@endsection
@section('content')
    @include('layouts.partials.header')
    @include('component.banner')
    <div class="container-fluid">
        @if(Auth::check())
            @if($bookings)
                @foreach($bookings as $booking)
                    @include('ui.my-bookings.components.booking-detail')
                @endforeach
            @endif
        @else
            @include('ui.my-bookings.components.auth-check')
        @endif
    </div>
@endsection
