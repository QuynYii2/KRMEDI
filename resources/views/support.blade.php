@extends('layouts.master')
@section('title', 'Support')
<style>
    .content-support img{
        max-width: 100%;
        object-fit: cover;
        height: auto;
    }
</style>
@section('content')
    @include('layouts.partials.header')
    @include('component.banner')
    <div class="recruitment-details ">
        <div class="container box-detail-news">
            <h1 class="h3 mb-4 text-gray-800">{{@$footer->title}}</h1>
            <div class="content-support">{!! @$footer->content !!}</div>

        </div>
    </div>


@endsection
