@extends('layouts.admin')
@section('title')
    {{ __('home.Detail Short Video') }}
@endsection
@section('main-content')
    <div class="container">
        <!-- Page Heading -->
        <h1 class="h3 mb-4 text-gray-800">{{ __('home.Detail Short Video') }}</h1>
        @if (session('success'))
            <div class="alert alert-success border-left-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
        <form>
            <div class="row">
                <div class="form-group col-md-12">
                    <label for="title">{{ __('home.Title') }}</label>
                    <input type="text" class="form-control" id="title" name="title" value="{{ $video->title }}"
                           required>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-4">
                    <label for="views">{{ __('home.views') }}</label>
                    <input type="number" min="0" class="form-control" id="views" name="views"
                           value="{{ $video->views }}">
                </div>
                <div class="form-group col-md-4">
                    <label for="shares">{{ __('home.shares') }}</label>
                    <input type="number" min="0" class="form-control" id="shares" value="{{ $video->shares }}"
                           name="shares">
                </div>
                <div class="form-group col-md-4">
                    <label for="reactions">{{ __('home.reactions') }}</label>
                    <input type="number" min="0" class="form-control" id="reactions" value="{{ $video->reactions }}"
                           name="reactions">
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-3">
                    <label for="file">{{ __('home.Video') }}</label>
                    <input type="file" class="form-control" id="file" name="file" accept="video/*">
                    <video width="320" height="240" controls autoplay>
                        <source src="{{ asset($video->file) }}" type="video/mp4">
                        {{ __('home.Your browser does not support the video tag.') }}
                    </video>
                </div>
                <div class="form-group col-md-3">
                    <label for="topic_id">{{ __('home.topic') }}</label>
                    <select id="topic_id" name="topic_id" class="form-control form-select">
                        @foreach($topics as $topic)
                            <option {{ $topic->id == $video->topic_id ? 'selected' : '' }} value="{{ $topic->id }}">
                                {{ $topic->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-md-3">
                    <label for="user_id">{{ __('home.Username') }}</label>
                    <input type="text" class="form-control" id="user_id" disabled value="{{ $user->username }}"
                           name="user_id">
                </div>
                <div class="form-group col-md-3">
                    <label for="status">{{ __('home.Status') }}</label>
                    <select id="status" name="status" class="form-control form-select">
                        <option
                            {{ $video->status == 'ACTIVE' ? 'selected' : '' }} value="ACTIVE">{{ __('home.Active') }}</option>
                        <option
                            {{ $video->status == 'INACTIVE' ? 'selected' : '' }} value="INACTIVE">{{ __('home.Inactive') }}
                        </option>
                    </select>
                </div>
            </div>
            <button type="button" class="btn btn-primary float-right" id="btnUpdateVideo">
                {{ __('home.Save') }}
            </button>
        </form>
    </div>
    <script>
        let accessToken = `Bearer ` + token;

        $(document).ready(function () {
            let formDataEdit = new FormData();

            $('#btnUpdateVideo').on('click', function () {
                let url = `{{ route('api.medical.short.videos.update', $video->id) }}`;
                let headers = {
                    'Authorization': `Bearer ${token}`
                };

                const arrField = ['title', 'status',
                    'views', 'shares', 'reactions', 'topic_id'];

                let isValid = true
                /* Tạo fn appendDataForm ở admin blade*/
                isValid = appendDataForm(arrField, formDataEdit, isValid);

                const video = $('#file')[0].files[0];
                formDataEdit.append('file_videos', video);

                if (isValid) {
                    try {
                        $.ajax({
                            url: url,
                            method: 'POST',
                            headers: headers,
                            contentType: false,
                            cache: false,
                            processData: false,
                            data: formDataEdit,
                            success: function () {
                                alert('success');
                                window.location.href = `{{route('view.admin.videos.list')}}`;
                            },
                            error: function (exception) {
                                alert('Update error!')
                                console.log(exception)
                            }
                        });
                    } catch (error) {
                        alert('Error, Please try again!')
                        throw error;
                    }
                } else {
                    alert('Please enter input!')
                }
            });

        })
    </script>
@endsection
