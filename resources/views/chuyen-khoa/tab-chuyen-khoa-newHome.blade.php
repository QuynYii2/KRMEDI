@extends('layouts.master')
@section('title', 'Specialist')
@section('content')
    <link rel="stylesheet" href="{{asset('css/homeSpecialist.css')}}">
    @include('layouts.partials.header')
    <div class="container mt-200 mt-70">
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
                    <style>
                        .krm-border-chuyen-khoa-list {
                            border: 1px solid #D6D6D6;
                            border-radius: 16px;
                            padding: 24px;
                            background: #FFFFFF;
                        }
                        .krm-img-chuyen-khoa-list {
                            background-image: radial-gradient(circle at center, rgba(255, 193, 7, 0.3098039216) 5%, #FFFFFF 55%, #FFFFFF 0%);
                        }
                        .krm-img-chuyen-khoa-list img {
                            width: 60px;
                            height: 60px;
                            border-radius: 50px;
                            margin: 12px;
                        }
                    </style>
                    @foreach($departments as $departmentItem)
                        <div class="col-md-2 col-6 mb-3">
                            <a href="{{route('home.specialist.department',$departmentItem->id)}}">
                                <div class="align-items-center krm-border-chuyen-khoa-list">
                                    <div class="d-flex justify-content-center align-content-center krm-img-chuyen-khoa-list">
                                        <img loading="lazy" src="{{$departmentItem->thumbnail}}" alt="thumbnail"
                                             class="krm-icon-chuyen-khoa">
                                    </div>
                                    <div class="d-flex align-content-center justify-content-center">
                                            <span style="height: 40px;">
                                                @if(locationHelper() == 'vi')
                                                    {{ ($departmentItem->name ?? __('home.no name') ) }}
                                                @else
                                                    {{ ($departmentItem->name_en  ?? __('home.no name') ) }}
                                                @endif
                                            </span>
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
