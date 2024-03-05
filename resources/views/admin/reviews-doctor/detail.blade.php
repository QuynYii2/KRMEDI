@extends('layouts.admin')
@section('title')
    {{ __('home.Detail Review') }}
@endsection
@section('main-content')
    <h3 class="text-center">{{ __('home.Detail Review') }}</h3>
    <div class="container">
        <div class="row">
            <div class="form-group col-md-12">
                <label for="title">{{ __('home.Title') }}</label>
                <input disabled type="text" class="form-control" id="title" value="{{ $review->title }}">
            </div>
        </div>
        <div class="form-group">
            <label for="description">{{ __('home.Description') }}</label>
            <input disabled value="{{ $review->description }}" type="text" class="form-control" id="description">
        </div>
        <div class="row">
            @if($medical)
                <div class="form-group col-md-6">
                    <label for="medical">{{ __('home.MedicalName') }}</label>
                    <input disabled value="{{ $medical->name }}" type="text" class="form-control" id="medical">
                </div>
            @endif
            <div class="form-group col-md-2">
                <label for="star">{{ __('home.Star') }}</label>
                <input disabled value="{{ $review->number_star }}" type="text" class="form-control" id="star">
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
                let reviewUrl = `{{ route('view.reviews.doctor.index') }}`;
                let reviewUpdateUrl = `{{ route('api.medical.reviews.doctors.change.status', $review->id) }}`;

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
