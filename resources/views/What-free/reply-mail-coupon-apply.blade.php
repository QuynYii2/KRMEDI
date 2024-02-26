@extends('layouts.master')
@section('title', 'What free')
@section('content')

    <link href="{{ asset('css/reply-link.css') }}" rel="stylesheet">
    @include('layouts.partials.header')
    @include('component.banner')
    @php
        $couponApply = \App\Models\CouponApply::where('id', $id)->first();
    @endphp
    <div class="container">
        @if($couponApply->content == null)
            <form action="{{route('what.free.reply.link.social',$couponApply->id)}}" method="post">
                @csrf
                @method('POST')
                <div class="container">
                    <h1>{{ __('home.Form nhập thông tin review') }}</h1>
                    <p>{{ __('home.Xin hãy nhập biểu mẫu bên dưới.') }}</p>
                    <hr>
                    @php
                        $sns_option =$couponApply->sns_option;
                        $sns_option = explode(', ',$sns_option);
                    @endphp

                    @foreach($sns_option as $sns_social)
                        @foreach(['tiktok', 'facebook', 'instagram', 'youtube', 'google_review'] as $platform)
                            @if($sns_social == $platform)
                                <div>
                                    <label for="{{$sns_social}}"><b>{{ __('home.Thông tin review ') }} {{$sns_social}}</b></label>
                                    <input class="link-social" type="text" placeholder="Nhập Link" name="{{$sns_social}}"
                                           id="{{$sns_social}}" required>
                                </div>
                            @endif
                        @endforeach
                    @endforeach
                    <div class="clearfix">
                        <button type="submit" class="signupbtn">{{ __('home.Submit') }}</button>
                    </div>
                </div>
            </form>
        @else
            <div class="container d-flex justify-content-center">
                <h4>Bạn đã gửi liên kết đăng bài</h4>
            </div>
        @endif

        </div>



        @endsection
