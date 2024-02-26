@extends('layouts.admin')
@section('title')
    List Prescription
@endsection
@section('main-content')
    <div class="">
        <!-- Page Heading -->
        <h1 class="h3 mb-4 text-gray-800">{{__('home.My Prescription')}}</h1>
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
                <th scope="col">{{ __('home.CreatedBy') }}</th>
                <th scope="col">{{ __('home.Doctors') }}</th>
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
                url: `{{route('api.backend.prescription.result.user')}}?user_id={{\Illuminate\Support\Facades\Auth::user()->id}}`,
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
            let urlBase = `{{ route('view.prescription.result.detail', ['id'=>':id']) }}`;
            for (let i = 0; i < response.length; i++) {
                let data = response[i];
                let urlDetail = urlBase.replace(':id', data.id)

                html = html + `<tr>
                                    <td>${i + 1}</td>
                                    <td>${data.full_name}</td>
                                    <td>${data.email}</td>
                                    <td>${data.created.username}</td>
                                    <td>${data.created.identifier}</td>
                                    <td>${data.isFirstBuy ? 'Đã mua' : 'Đơn thuốc mới'}</td>
                                    <td>
                                            <a href="${urlDetail}" target="_blank" class="color-blue">
                                                Xem chi tiết
                                            </a> |
                                            <a onclick="addToCart(${data.id})" class="color-blue">
                                                ${data.isFirstBuy ? 'Mua lại' : 'Mua ngay'}
                                            </a>
                                    </td>
                                </tr>`;
            }

            $('#tbodyListPrescription').empty().append(html);
            loadPaginate('tableListPrescription', 20);
            searchMain('inputSearchUser', 'tableListPrescription');
        }

        async function addToCart(id) {
            loadingMasterPage();
            let data = {
                prescription_id: id,
                user_id: `{{ Auth::user()->id }}`,
            };

            try {
                await $.ajax({
                    url: `{{ route('api.backend.prescription.result.add.cart.v2') }}`,
                    method: 'POST',
                    headers: headers,
                    data: data,

                    success: function (response, textStatus, xhr) {
                        loadingMasterPage();
                        alert(response.message);
                        var statusCode = xhr.status;
                        if (statusCode === 200) {
                            window.location.href = `{{ route('user.checkout.index') }}`;
                        }
                    },
                    error: function (xhr, status, error) {
                        loadingMasterPage();
                        alert(xhr.responseJSON.message);
                    }
                });
            } catch (e) {
            }
        }
    </script>
@endsection

