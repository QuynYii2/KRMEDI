@extends('layouts.master')
@section('title', 'What free')
@section('content')
    @include('layouts.partials.header')
    @include('component.banner')
    <div class="container">
        <div class="clinics-list">
            <div class="clinics-header margin-bottom-32 border-bottom">
                <div class="justify-content-between align-items-center d-flex mt-4 mb-2">
                    <div class="ac-text_content ">{{ __('home.Free today') }}</div>
                </div>
            </div>
            <div class="body row">
                @if(count($coupons) > 0)
                    @foreach($coupons as $coupon)
                        @include('What-free.component-what-free', ['coupon' => $coupon])
                    @endforeach
                @else
                    <h3 class="no-data text-center">{{ __('home.no data') }}</h3>
                @endif
            </div>
            <nav aria-label="Page navigation example" class="d-flex justify-content-center">
                {{ $coupons->links() }}
            </nav>
        </div>
    </div>
@endsection
