@extends('layouts.admin')
@section('title')
    {{ __('home.List Short Videos') }}
@endsection
@section('main-content')
    <div class="">
        <!-- Page Heading -->
        <h1 class="h3 mb-4 text-gray-800">{{ __('home.List Short Videos') }}</h1>
        @if (session('success'))
            <div class="alert alert-success border-left-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
        <table class="table" id="tableListVideo">
            <thead>
            <tr>
                <th scope="col">{{ __('home.Title') }}</th>
                <th scope="col">{{ __('home.views') }}</th>
                <th scope="col">{{ __('home.shares') }}</th>
                <th scope="col">{{ __('home.reactions') }}</th>
                <th scope="col">{{ __('home.Status') }}</th>
                <th scope="col">{{ __('home.Active') }}</th>
            </tr>
            </thead>
            <tbody id="tbodyListVideo">

            </tbody>
        </table>
    </div>
    <script>
        let accessToken = `Bearer ` + token;

        callListVideo();

        async function callListVideo() {
            let url = `{{ route('api.medical.short.videos.list') }}`;
            await $.ajax({
                url: url,
                method: "GET",
                headers: {
                    "Authorization": accessToken
                },
                success: function (response) {
                    renderVideo(response);
                },
                error: function (error) {
                    console.log(error);
                }
            });

        }

        function renderVideo(response) {
            let html = ``;
            for (let i = 0; i < response.length; i++) {
                let detail = `{{ route('view.admin.videos.detail', ['id'=>':id']) }}`;
                let data = response[i];
                detail = detail.replace(':id', data.id);
                html = html + ` <tr>
                        <td>${data.title}
                        @if(locationHelper() == 'vi')
                ${data.title}
                @else
                ${data.title_en}
                @endif
                        </td>
                        <td>${data.views}</td>
                        <td>${data.shares}</td>
                        <td>${data.reactions}</td>
                        <td>${data.status}</td>
                        <td>
                            <a href="${detail}" class="btn btn-secondary">{{ __('home.Detail') }}</a>
                            <button onclick="deleteVideo('${data.id}')"  class="btn btn-danger">{{ __('home.Delete') }}</button>
                        </td>
                    </tr>`;
            }

            document.getElementById('tbodyListVideo').innerHTML = html;
        }

        function deleteVideo(id) {
            let text = `Are you sure you want to delete?`;
            if (confirm(text) == true) {
                confirmDeleteVideo(id);
            }
        }

        async function confirmDeleteVideo(id) {
            let url = `{{ route('api.medical.short.videos.delete', ['id'=>':id']) }}`;
            url = url.replace(':id', id);
            await $.ajax({
                url: url,
                method: "DELETE",
                headers: {
                    "Authorization": accessToken
                },
                success: function (response) {
                    console.log(response);
                    callListVideo();
                    alert('Delete success!')
                },
                error: function (error) {
                    console.log(error);
                    alert('Delete error!')
                }
            });
        }
    </script>
@endsection

