@extends('layouts.admin')
@section('title')
    {{ __('home.List Service Clinics') }}
@endsection
@section('main-content')
    <div class="">
        <!-- Page Heading -->
        <h1 class="h3 mb-4 text-gray-800">{{ __('home.List Service Clinics') }}</h1>
        <a href="{{route('user.service.clinics.create')}}" class="btn btn-primary mb-3">{{ __('home.Add') }}</a>
        @if (session('success'))
            <div class="alert alert-success border-left-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
        <table class="table" id="tableListService">
            <thead>
            <tr>
                <th scope="col">{{ __('home.Name') }}</th>
                <th scope="col">{{ __('home.Status') }}</th>
                <th scope="col">{{ __('home.Active') }}</th>
            </tr>
            </thead>
            <tbody id="tbodyListService">

            </tbody>
        </table>
    </div>
    <script>
        let accessToken = `Bearer ` + token;

        callListService();

        async function callListService() {
            let url = `{{ route('api.admin.service.clinic.list') }}`;
            await $.ajax({
                url: url,
                method: "GET",
                headers: {
                    "Authorization": accessToken
                },
                success: function (response) {
                    renderService(response);
                },
                error: function (error) {
                    console.log(error);
                }
            });

        }

        function renderService(response) {
            let html = ``;
            for (let i = 0; i < response.length; i++) {
                let detail = `{{ route('user.service.clinics.detail', ['id'=>':id']) }}`;
                let data = response[i];
                detail = detail.replace(':id', data.id);
                html = html + ` <tr>
                        <td>${data.name}</td>
                        <td>${data.status}</td>
                        <td>
                            <a href="${detail}" class="btn btn-secondary">Detail</a>
                            <button onclick="deleteService('${data.id}')"  class="btn btn-danger">{{ __('home.Delete') }}</button>
                        </td>
                    </tr>`;
            }

            document.getElementById('tbodyListService').innerHTML = html;
        }

        function deleteService(id) {
            let text = `Are you sure you want to delete?`;
            if (confirm(text) == true) {
                confirmDeleteService(id);
            }
        }

        async function confirmDeleteService(id) {
            let url = `{{ route('api.admin.service.clinic.delete', ['id'=>':id']) }}`;
            url = url.replace(':id', id);
            await $.ajax({
                url: url,
                method: "DELETE",
                headers: {
                    "Authorization": accessToken
                },
                success: function (response) {
                    console.log(response);
                    callListService();
                },
                error: function (error) {
                    console.log(error);
                }
            });
        }
    </script>
@endsection

