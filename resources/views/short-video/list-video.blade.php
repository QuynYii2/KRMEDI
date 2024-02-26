@extends('layouts.master')
@section('title', 'Short Videos')
@section('content')
    <link href="{{ asset('css/listvideo.css') }}" rel="stylesheet">
    @include('layouts.partials.header')
    @include('component.banner')
    <div class="container">
        <div class="text-center">
            @foreach($videos as $video)
                <div class="user-posted">
                    <div class="header-post">
                        <div class="user">
                            <img class="user-avt" src="{{ asset($video->avt) }}" alt="">
                            <span class="username">{{ $video->username }}</span>
                            <span class="name">{{ $video->name }}</span>
                        </div>
                        <div class="content">
                            <a href="{{ route('short.videos.item', $video->id) }}">{{ $video->title }}</a>
                        </div>
                    </div>
                    <div class="main-post">
                        <div class="row">
                            <div class="col-md-10 see-video">
                                <video controls>
                                    <source src="{{ asset($video->file) }}" type="video/mp4">
                                    <source src="{{ asset($video->file) }}" type="video/ogg">
                                    {{ __('home.Your browser does not support the video tag') }}.
                                </video>
                            </div>
                            <div class="col-md-2 action-video">

                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#uploadVideo">
        {{ __('home.Start Upload Video') }}
    </button>
    <!-- Modal -->
    <div class="modal fade" id=uploadVideo tabindex="-1" aria-labelledby="uploadVideoLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="uploadVideoLabel">{{ __('home.Create Short Video Public') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="title">{{ __('home.Title') }}</label>
                        <input type="text" class="form-control" id="title">
                    </div>
                    <div class="form-group">
                        <label for="topic">{{ __('home.topic') }}</label>
                        <select id="topic" class="form-select">
                            @foreach($topics as $topic)
                                <option value="{{$topic->id}}">{{$topic->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="video">{{ __('home.Video') }}</label>
                        <input type="file" class="form-control" id="video" accept="video/mp4,video/x-m4v,video/*">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('home.CANCEL') }}</button>
                    <button type="button" id="btnUploadVideo" class="btn btn-primary">{{ __('home.Upload') }}</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        let headers = {
            'Authorization': `Bearer ${token}`
        };

        $(document).ready(function () {
            $('#btnUploadVideo').on('click', function () {
                uploadVideo();
            })

            async function uploadVideo() {
                const formData = new FormData();
                formData.append("title", $('#title').val());
                formData.append("topic_id", $('#topic').val());
                formData.append("user_id", '{{ Auth::user()->id }}');

                const video = $('#video')[0].files[0];
                formData.append('file_videos', video);

                try {
                    $.ajax({
                        url: `{{route('api.medical.short.videos.create')}}`,
                        method: 'POST',
                        headers: headers,
                        contentType: false,
                        cache: false,
                        processData: false,
                        data: formData,
                        success: function (response) {
                            alert('success');
                            window.location.reload();
                        },
                        error: function (exception) {
                            console.log(exception)
                        }
                    });
                } catch (error) {
                    throw error;
                }
            }
        })
    </script>
@endsection
