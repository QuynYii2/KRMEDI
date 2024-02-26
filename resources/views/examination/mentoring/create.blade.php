@extends('layouts.master')
@section('title', 'Home')
@section('content')
    @include('layouts.partials.header_3')
    @include('component.banner')

    <link href="{{ asset('css/create.css') }}" rel="stylesheet"><style>

    </style>
    <div class="container">
        <form enctype="multipart/form-data">
            <div class="form-group">
                <label for="content-question">{{ __('home.Title') }}</label>
                <input type="text" class="form-control" id="title"/>
            </div>
            <div class="form-group">
                <label for="content-question">{{ __('home.Content Question') }}</label>
                <textarea type="text" class="form-control" id="content-question"
                          placeholder="{{ __('home.Enter question here') }}"></textarea>
            </div>
            <div class="form-group">
                <label for="category">{{ __('home.Select Category') }}</label>
                <select class="form-select" id="category">
                    <option selected value="0">{{ __('home.Choose...') }}</option>
                    <option value="{{ \App\Enums\MentoringCategory::HEALTH }}">{{ __('home.Heath') }}</option>
                    <option value="{{ \App\Enums\MentoringCategory::BEAUTY }}">{{ __('home.Beauty') }}</option>
                    <option value="{{ \App\Enums\MentoringCategory::LOSING_WEIGHT }}">{{ __('home.Losing weight') }}</option>
                    <option value="{{ \App\Enums\MentoringCategory::KIDS }}">{{ __('home.Kids') }}</option>
                    <option value="{{ \App\Enums\MentoringCategory::PETS }}">{{ __('home.Pets') }}</option>
                    <option value="{{ \App\Enums\MentoringCategory::OTHER }}">{{ __('home.Other') }}</option>
                </select>
            </div>
            @include('component.upload_gallery')
            <div class="d-flex justify-content-center">
                <button type="button" class="btn btn-secondary mx-2 button_create_question" onclick="history.back()">
                    {{ __('home.CANCEL') }}
                </button>
                <button type="button" class="btn btn-primary mx-2 button_create_question" id="btn_submit" onclick="submitButton()">{{ __('home.Submit') }}</button>
            </div>
        </form>
    </div>

    <script>
        function submitButton() {
            if (!token) {
                alert('Please login to apply')
                return;
            }
            const message = document.getElementById('content-question').value;
            const title = document.getElementById('title').value;
            const headers = {
                'Authorization': `Bearer ${token}`
            };
            const formData = new FormData();
            formData.append("title", title);
            formData.append("title_en", title);
            formData.append("title_laos", title);
            formData.append("content", message);
            formData.append("content_en", message);
            formData.append("content_laos", message);
            formData.append("category_id", $('#category').val());
            formData.append("status", '{{ \App\Enums\QuestionStatus::APPROVED }}');
            formData.append("user_id", '{{ Auth::user()->id ?? '' }}');

            let len = galleryUploadInput.files.length;
            for (let i = 0; i < len; i++) {
                const file = galleryUploadInput.files[i];
                formData.append('gallery[]', file);
            }

            formData.append("list_public", $('#checkImageQty').val());
            try {
                $.ajax({
                    url: `{{route('api.backend.questions.create')}}`,
                    method: 'POST',
                    headers: headers,
                    contentType: false,
                    cache: false,
                    processData: false,
                    data: formData,
                    success: function (response) {
                        window.location.href = '{{ route('examination.mentoring') }}'
                    },
                    error: function (exception) {
                    }
                });
            } catch (error) {
                throw error;
            }
        }
    </script>
@endsection
