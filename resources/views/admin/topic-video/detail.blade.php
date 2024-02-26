@extends('layouts.admin')
@section('title')
    {{ __('home.Detail Topic Video') }}
@endsection
@section('main-content')
    <div class="container">
        <!-- Page Heading -->
        <h1 class="h3 mb-4 text-gray-800">{{ __('home.Detail Topic Video') }}</h1>
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
                    <label for="name">{{ __('home.Name') }}</label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ $topicVideo->name }}"
                           required>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-4">
                    <label for="thumbnail">{{ __('home.Thumbnail') }}</label>
                    <input type="file" class="form-control" id="thumbnail" name="thumbnail" multiple accept="image/*">
                    <img loading="lazy" width="100px" src="{{$topicVideo->thumbnail}}" alt="thumbnail">
                </div>
                <div class="form-group col-md-4">
                    <label for="status">{{ __('home.Status') }}</label>
                    <select id="status" class="form-control">
                        <option {{ $topicVideo->status == 'ACTIVE' ? 'selected' : '' }} value="ACTIVE">{{ __('home.Active') }}</option>
                        <option {{ $topicVideo->status == 'INACTIVE' ? 'selected' : '' }} value="INACTIVE">{{ __('home.Inactive') }}
                        </option>
                    </select>
                </div>
            </div>
            <button type="button" class="btn btn-primary float-right" id="btnUpdateTopic">
                {{ __('home.Save') }}
            </button>
        </form>
    </div>
    <script>
        let accessToken = `Bearer ` + token;

        $(document).ready(function () {
            let formDataEdit = new FormData();

            $('#btnUpdateTopic').on('click', function () {
                let url = `{{ route('api.admin.topic.videos.update', $topicVideo->id) }}`;
                let headers = {
                    'Authorization': `Bearer ${token}`
                };

                formDataEdit.append('name', document.getElementById('name').value);
                formDataEdit.append('user_id', `{{ Auth::check() ? Auth::user()->id : '' }}`);
                formDataEdit.append('status', document.getElementById('status').value);
                const photo = $('#thumbnail')[0].files[0];
                formDataEdit.append('thumbnail', photo);

                if (document.getElementById('name').value) {
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
                                window.location.href = `{{route('user.topic.videos.list')}}`;
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
