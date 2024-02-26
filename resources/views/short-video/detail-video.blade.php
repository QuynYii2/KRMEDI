@extends('layouts.master')
@section('title', 'Detail Videos')
@section('content')
    @include('layouts.partials.header')
    @include('component.banner')
    <div class="container">
        <div class="video-post">
            <div class="row">
                <div class="col-md-8 see-video">
                    <video controls>
                        <source src="{{ asset($video->file) }}" type="video/mp4">
                        <source src="{{ asset($video->file) }}" type="video/ogg">
                        {{ __('home.Your browser does not support the video tag') }}.
                    </video>
                </div>
                <div class="col-md-4 action-video">
                    <div class="user">
                        <img class="user-avt" src="{{ asset($video->avt) }}" alt="">
                        <span class="username">{{ $video->username }}</span>
                        <span class="name">{{ $video->name }}</span>
                    </div>
                    <div class="content">
                        <p>{{ $video->title }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
