@extends('layouts.admin')
@section('title')
    {{ __('home.List Prescription') }}
@endsection
@section('main-content')
    <div class="">
        <!-- Page Heading -->
        <h1 class="h3 mb-4 text-gray-800"> List Prescription </h1>
        <div class="d-flex align-items-center justify-content-between">
            <div class="mb-3 col-md-3">
                <input class="form-control" id="inputSearch" type="text" placeholder="Search.."/>
            </div>
        </div>
        <br>
        <table class="table" id="tableListPrescription">
            <thead>
            <tr>
                <th scope="col">{{ __('home.STT') }}</th>
                <th scope="col">{{ __('home.Full Name') }}</th>
                <th scope="col">{{ __('home.Email') }}</th>
                <th scope="col">{{ __('home.Username') }}</th>
                <th scope="col">{{ __('home.Status') }}</th>
                <th scope="col">{{ __('home.Action') }}</th>
            </tr>
            </thead>
            <tbody id="tbodyListPrescription">
            </tbody>
        </table>
    </div>
    <script>
        let accessToken = `Bearer ` + token;
        let headers = {
            Authorization: accessToken,
        }

        $(document).ready(function () {
            callListPrescription();
        });

        async function callListPrescription() {
            await $.ajax({
                url: `{{route('api.backend.prescription.result.doctor')}}?doctor_id={{\Illuminate\Support\Facades\Auth::user()->id}}`,
                method: 'GET',
                headers: headers,
                success: function (response) {
                    renderPrescription(response);
                },
                error: function (exception) {
                    console.log(exception)
                }
            });
        }

        function renderPrescription(response) {
            let html = ``;
            for (let i = 0; i < response.length; i++) {
                let urlDetail = `{{ route('view.prescription.result.detail', ['id'=>':id']) }}`;
                let data = response[i];
                urlDetail = urlDetail.replace(':id', data.id)
                html = html + `<tr>
                                    <td>${i + 1}</td>
                                    <td>${data.full_name}</td>
                                    <td>${data.email}</td>
                                    <td>${data.user.username}</td>
                                    <td>${data.status}</td>
                                    <td>
                                         <div class="d-flex align-items-center">
                                            <a href="${urlDetail}" class="btn btn-primary">
                                                <i class="fa-solid fa-eye"></i>
                                            </a>
                                    </td>
                                </tr>`;
            }

            $('#tbodyListPrescription').empty().append(html);
            loadPaginate('tableListPrescription', 20);
            searchMain('inputSearchUser', 'tableListPrescription');
        }
    </script>
@endsection
