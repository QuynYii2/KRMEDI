@extends('layouts.admin')
@section('title')
    {{ __('home.Detail Review') }}
@endsection
@section('main-content')
    <h3 class="text-center">{{ __('home.Detail Review') }}</h3>
    <div class="container">
        <div class="form-group">
            <label for="name">{{ __('home.Full Name') }}</label>
            <input disabled type="text" class="form-control" id="name" value="{{ $review->name }}">
        </div>
        <div class="row">
            <div class="form-group col-md-12">
                <label for="title">{{ __('home.Title') }}</label>
                <input disabled type="text" class="form-control" id="title" value="{{ $review->title }}">
            </div>
        </div>
        <div class="form-group">
            <label for="content">{{ __('home.Content') }}</label>
            <input disabled value="{{ $review->content }}" type="text" class="form-control" id="content">
        </div>
        <div class="row">
            <div class="form-group col-md-6">
                <label for="star">Danh mục</label>
                <input disabled value="{{ $review->name_category }}" type="text" class="form-control">
            </div>
            <div class="form-group col-md-6">
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
        <label for="title">Hình ảnh</label>
        <div class="form-group col-md-12">
            @php
                $galleries = explode(',', $review->gallery);
            @endphp
            @foreach($galleries as $gallery)
                <img src="{{ asset($gallery) }}" alt="Image" class="w-25">
            @endforeach
        </div>

        <div class="text-center mt-3 ">
            <button type="button" class="btn btn-primary" id="btnSaveReview">{{ __('home.Save') }}</button>
        </div>
    </div>

    <script>

        $(document).ready(function () {
            $('#btnSaveReview').on('click', function () {
                updateReview();
            });

             function updateReview() {
                let reviewUrl = `{{ route('view.reviews.mentoring.index') }}`;
                let reviewUpdateUrl = `{{ route('view.reviews.mentoring.change.status', $review->id) }}`;

                let data = {
                    'status': $('#status').val()
                };

                 $.ajax({
                    url: reviewUpdateUrl,
                    method: "POST",
                    headers: {
                        'Authorization': `Bearer ${token}`,
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
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
