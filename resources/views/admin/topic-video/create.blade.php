@extends('layouts.admin')
@section('title')
    {{ __('home.Create Service Clinics') }}
@endsection
@section('main-content')
    <div class="container">
        <!-- Page Heading -->
        <h1 class="h3 mb-4 text-gray-800">{{ __('home.Create Service Clinics') }}</h1>
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
                    <input type="text" class="form-control" id="name" name="name" required>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-4">
                    <label for="thumbnail">{{ __('home.Thumbnail') }}</label>
                    <input type="file" class="form-control" id="thumbnail" name="thumbnail" multiple accept="image/*">
                </div>
                <div class="form-group col-md-4">
                    <label for="status">{{ __('home.Status') }}</label>
                    <select id="status" class="form-control">
                        <option value="ACTIVE">{{ __('home.Active') }}</option>
                        <option value="INACTIVE">{{ __('home.Inactive') }}</option>
                    </select>
                </div>
            </div>
            <button type="button" id="btnCreateTopic" class="btn btn-primary float-right">{{ __('home.Save') }}</button>
        </form>
    </div>
    <script>
        let accessToken = `Bearer ` + token;

        $(document).ready(function () {
            let formDataCreate = new FormData();

            $('#btnCreateTopic').on('click', function () {
                let url = `{{ route('api.admin.topic.videos.create') }}`;
                let headers = {
                    'Authorization': `Bearer ${token}`
                };

                formDataCreate.append('name', document.getElementById('name').value);
                formDataCreate.append('user_id', `{{ Auth::check() ? Auth::user()->id : '' }}`);
                formDataCreate.append('status', document.getElementById('status').value);
                let photo = $('#thumbnail')[0].files[0];
                formDataCreate.append('thumbnail', photo);

                if (document.getElementById('name').value && photo) {
                    try {
                        $.ajax({
                            url: url,
                            method: 'POST',
                            headers: headers,
                            contentType: false,
                            cache: false,
                            processData: false,
                            data: formDataCreate,
                            success: function () {
                                alert('success');
                                window.location.href = `{{route('user.topic.videos.list')}}`;
                            },
                            error: function (exception) {
                                alert('Create error!')
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
