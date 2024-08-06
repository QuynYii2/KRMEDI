@extends('layouts.master')
@section('title', 'Specialist')
@section('content')
    <link rel="stylesheet" href="{{asset('css/homeSpecialist.css')}}">
    @include('layouts.partials.header')
    <div class="container mt-200 mt-70 box-ck-new-home">
        <div class="tab-chuyen-khoa">
            <a href="{{route('home')}}">
                <div class="titleServiceHomeNew"><i class="fa-solid fa-arrow-left"></i> {{ __('home.Tên chuyên khoa') }}</div>
            </a>
            <div class="mainServiceHomeNew row">
                @if($departments->isEmpty())
                    <div class="col-md-12">
                        <div class="alert alert-danger" role="alert">
                            {{ __('home.no data') }}
                        </div>
                    </div>
                @else
{{--                    <style>--}}
{{--                        .krm-border-chuyen-khoa-list {--}}
{{--                            border: 1px solid #D6D6D6;--}}
{{--                            border-radius: 16px;--}}
{{--                            padding: 24px;--}}
{{--                            background: #FFFFFF;--}}
{{--                        }--}}
{{--                        .krm-img-chuyen-khoa-list {--}}
{{--                            background-image: radial-gradient(circle at center, rgba(255, 193, 7, 0.3098039216) 5%, #FFFFFF 55%, #FFFFFF 0%);--}}
{{--                        }--}}
{{--                        .krm-img-chuyen-khoa-list img {--}}
{{--                            width: 60px;--}}
{{--                            height: 60px;--}}
{{--                            border-radius: 50px;--}}
{{--                            margin: 12px;--}}
{{--                        }--}}
{{--                    </style>--}}
                    @foreach($departments as $departmentItem)
                        <div class="col-md-4">
                            <a href="{{route('home.specialist.department',$departmentItem->id)}}" class="department-link" data-id="{{$departmentItem->id}}">
                                <div class="border-HomeNew position-relative">
                                    <div class="w-100 d-flex align-items-center ">
                                        <img src="{{$departmentItem->thumbnail}}" alt="thumbnail">
                                        <span>
                                            @if(locationHelper() == 'vi')
                                                {{$departmentItem->name ?? ''}}
                                            @else
                                                {{ $departmentItem->name_en  ?? ''}}
                                            @endif
                                        </span>
                                    </div>
                                    <div class="svg-containerNho">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                             fill="none">
                                            <path opacity="0.5" fill-rule="evenodd" clip-rule="evenodd"
                                                  d="M16.6666 0H7.3333V7.33268L0 7.33268V16.666H7.3333V24H16.6666V16.666H24V7.33268L16.6666 7.33268V0Z"
                                                  fill="#D8F6FF"/>
                                        </svg>
                                    </div>
                                    <div class="svg-container">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="60" height="60" viewBox="0 0 60 60"
                                             fill="none">
                                            <path opacity="0.5" fill-rule="evenodd" clip-rule="evenodd"
                                                  d="M41.6667 0H18.3333V18.3327H0V41.666H18.3333V60H41.6667V41.666H60V18.3327H41.6667V0Z"
                                                  fill="#D8F6FF"/>
                                        </svg>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </div>
@endsection
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const departmentLinks = document.querySelectorAll('.department-link');
        localStorage.removeItem('bookingFormData');
        departmentLinks.forEach(link => {
            link.addEventListener('click', function(event) {
                event.preventDefault();
                const departmentId = this.getAttribute('data-id');
                localStorage.setItem('departmentId', departmentId);
                window.location.href = this.href;
            });
        });
    });
</script>
