@extends('layouts.admin')
@section('title')
    {{ __('home.List Medical Result') }}
@endsection
@section('main-content')
    <div class="">
        <!-- Page Heading -->
        <h1 class="h3 mb-4 text-gray-800"> {{ __('home.List Medical Result') }} </h1>
        <a href="{{route('view.admin.medical.result.create')}}" class="btn btn-primary mb-3">{{ __('home.Add') }}</a>
        <table class="table" id="tableListMedical">
            <thead>
            <tr>
                <th scope="col">{{ __('home.STT') }}</th>
                <th scope="col">{{ __('home.Name') }}</th>
                <th scope="col">{{ __('home.PhoneNumber') }}</th>
                <th scope="col">{{ __('home.Addresses') }}</th>
                <th scope="col">{{ __('home.Email') }}</th>
                <th scope="col">{{ __('home.Code') }}</th>
                <th scope="col">{{ __('home.Service Name') }}</th>
                <th scope="col">{{ __('home.Status') }}</th>
                <th scope="col">{{ __('home.Action') }}</th>
            </tr>
            </thead>
            <tbody id="tbodyListMedical">
            </tbody>
        </table>
    </div>
    <script>
        let accessToken = `Bearer ` + token;
        let headers = {
            Authorization: accessToken,
        }

        $(document).ready(function () {
            callListMedical();
        })

        async function callListMedical() {
            let listUrl = `{{route('api.medical.medical.result.list')}}`;
            listUrl = listUrl + `?user_id={{Auth::user()->id}}`
            await $.ajax({
                url: listUrl,
                method: 'GET',
                headers: headers,
                success: function (response) {
                    renderMedical(response);
                },
                error: function (exception) {
                    console.log(exception)
                    alert('Không thể tải thông tin!')
                }
            });
        }

        function renderMedical(response) {
            let html = ``;
            for (let i = 0; i < response.length; i++) {
                let urlDetail = `{{ route('view.admin.medical.result.detail', ['id'=>':id']) }}`;
                let data = response[i];
                urlDetail = urlDetail.replace(':id', data.id)
                html = html + `<tr>
                                    <td>${i + 1}</td>
                                    <td>${data.full_name}</td>
                                    <td>${data.phone}</td>
                                    <td>${data.address}</td>
                                    <td>${data.email}</td>
                                    <td>${data.code}</td>
                                    <td>${data.service_name}</td>
                                    <td>${data.status}</td>
                                    <td>
                                         <div class="d-flex align-items-center">
                                            <a href="${urlDetail}" class="btn btn-primary">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                            </a>
                                         </div>
                                    </td>
                                </tr>`;
            }

            $('#tbodyListMedical').empty().append(html);
            loadPaginate('tableListMedical', 20);
        }
    </script>
@endsection

