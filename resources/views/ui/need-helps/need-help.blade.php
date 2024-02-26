@php use App\Models\Province;

@endphp
@extends('layouts.master')
@section('title', 'Need Help?')
@section('content')
    @include('layouts.partials.header')
    <div class="container pb-5" style="margin-top: 168px;">
        <div class="text-center">
            <img src="{{ asset('img/icons_logo/logo-new.png') }}" alt="" style="max-width: 100px">
            <p class="mt-2">We can help you with anything. How can we assist you?</p>
        </div>
        <div class="d-flex align-items-center justify-content-center mt-3">
            <div class="d-flex flex-wrap list-action w-75">
                <a href="{{ route('need.helps.account') }}" class="col-md-3 p-3 border">
                    <div class="d-flex justify-content-center align-items-center">
                        <img class="w-25" src="https://lh3.googleusercontent.com/o9U8AvPuX9gkIYtYfNmH-_wBdTfOJ7jb0VwbLWWbERzml7oTPngODhKv2Br7A64=w64" alt="" >
                    </div>
                    <div class="title d-flex justify-content-center align-items-center">
                        Krmedi account
                    </div>
                </a>
                <a href="#" class="col-md-3 p-3 border">
                    <div class="d-flex justify-content-center align-items-center">
                        <img class="w-25" src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTIkO5Rg9sop-Haqi9HWOpQgTkAXQac0NnFPPSjP7Jupeb16Qo2GotbfVrMENC56m0xFNg&usqp=CAU" alt="" >
                    </div>
                    <div class="title d-flex justify-content-center align-items-center">
                        Krmedi service
                    </div>
                </a>
                <a href="#" class="col-md-3 p-3 border">
                    <div class="d-flex justify-content-center align-items-center">
                        <img class="w-25" src="https://cdn-icons-png.flaticon.com/512/3080/3080058.png" alt="" >
                    </div>
                    <div class="title d-flex justify-content-center align-items-center">
                        Krmedi feedback
                    </div>
                </a>
                <a href="#" class="col-md-3 p-3 border">
                    <div class="d-flex justify-content-center align-items-center">
                        <img class="w-25" src="https://cdn-icons-png.flaticon.com/512/4807/4807695.png" alt="" >
                    </div>
                    <div class="title d-flex justify-content-center align-items-center">
                        Krmedi member
                    </div>
                </a>
                <a href="#" class="col-md-3 p-3 border">
                    <div class="d-flex justify-content-center align-items-center">
                        <img class="w-25" src="https://icons.iconarchive.com/icons/fa-team/fontawesome/512/FontAwesome-Hand-Holding-Medical-icon.png" alt="" >
                    </div>
                    <div class="title d-flex justify-content-center align-items-center">
                        Other
                    </div>
                </a>
            </div>
        </div>
    </div>
@endsection
