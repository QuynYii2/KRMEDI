@extends('layouts.admin')
@section('title')
    {{ __('home.Detail Review') }}
@endsection
@section('main-content')
    <h3 class="text-center">{{ __('home.Detail Review') }}</h3>
    <div class="container">
        <div class="row">
            <div class="form-group col-md-4">
                <label for="name">{{ __('home.Full Name') }}</label>
                <input disabled type="text" class="form-control" id="name" value="{{ $review->name }}">
            </div>
            <div class="form-group col-md-4">
                <label for="email">{{ __('home.Email') }}</label>
                <input disabled value="{{ $review->email }}" type="email" class="form-control" id="email">
            </div>
            <div class="form-group col-md-4">
                <label for="phone">{{ __('home.PhoneNumber') }}</label>
                <input disabled value="{{ $review->phone }}" type="text" class="form-control" id="phone">
            </div>
        </div>
        <div class="form-group">
            <label for="address">{{ __('home.Addresses') }}</label>
            <input disabled value="{{ $review->address }}" type="text" class="form-control" id="address">
        </div>
        <div class="form-group">
            <label for="content">{{ __('home.Content') }}</label>
            <input disabled value="{{ $review->content }}" type="text" class="form-control" id="content">
        </div>
        <div class="row">
            <div class="form-group col-md-6">
                <label for="business">{{ __('home.BusinessName') }}</label>
                <input disabled value="{{ $business->name }}" type="text" class="form-control" id="business">
            </div>
            <div class="form-group col-md-2">
                <label for="star">{{ __('home.Star') }}</label>
                <input disabled value="{{ $review->star }}" type="text" class="form-control" id="star">
            </div>
            <div class="form-group col-md-4">
                <label for="status">{{ __('home.Status') }}</label>
                <select id="status" class="form-select">
                    @foreach($status as $item)
                        @if($item != 'DELETED')
                            <option
                                {{ $item == $review->status ? 'selected' : '' }} value="{{ $item }}">{{ $item }}</option>
                        @endif
                    @endforeach
                </select>
            </div>
        </div>
        <div class="text-center mt-3 ">
            <button type="button" class="btn btn-primary" id="btnSaveReview">{{ __('home.Save') }}</button>
        </div>
    </div>

    <script>
        let accessToken = `Bearer ` + token;
        let headers = {
            "Authorization": accessToken
        };

        $(document).ready(function () {
            $('#btnSaveReview').on('click', function () {
                updateReview();
            })

            async function updateReview() {
                let reviewUrl = `{{ route('view.admin.reviews.index') }}`;
                let reviewUpdateUrl = `{{ route('api.backend.reviews.change.status', $review->id) }}`;

                let data = {
                    'status': $('#status').val()
                };

                await $.ajax({
                    url: reviewUpdateUrl,
                    method: "PUT",
                    headers: headers,
                    data: data,
                    success: function (response) {
                        window.location.href = reviewUrl;
                    },
                    error: function (error) {
                        console.log(error);
                    }
                });
            }
        })
    </script>
@endsection
