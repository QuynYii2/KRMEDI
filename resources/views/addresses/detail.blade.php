@extends('layouts.admin')
@section('title')
    {{ __('home.Detail Address') }}
@endsection
@section('main-content')
    <h3 class="text-center"> {{ __('home.Detail Address') }}</h3>
    <div class="container">
        <form>
            <div class="row">
                <div class="form-group col-md-6">
                    <label for="username">{{ __('home.Full Name') }}</label>
                    <input type="text" class="form-control" id="username" maxlength="200"
                           value="{{ $address->username }}" required>
                </div>
                <div class="form-group col-md-6">
                    <label for="phone">{{ __('home.Phone Number') }}</label>
                    <input type="text" class="form-control" maxlength="200" id="phone" value="{{ $address->phone }}"
                           required>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-4">
                    <label for="province_id">{{ __('home.Tỉnh') }}</label>
                    <select name="province_id" id="province_id" class="form-control"
                            onchange="callGetAllDistricts($('#province_id').find(':selected').data('code'))">

                    </select>
                </div>
                <div class="col-sm-4">
                    <label for="district_id">{{ __('home.Quận') }}</label>
                    <select name="district_id" id="district_id" class="form-control"
                            onchange="callGetAllCommunes($('#district_id').find(':selected').data('code'))">
                        <option value="">{{ __('home.Chọn quận') }}</option>
                    </select>
                </div>
                <div class="col-sm-4">
                    <label for="commune_id">{{ __('home.Xã') }}</label>
                    <select name="commune_id" id="commune_id" class="form-control">
                        <option value="">{{ __('home.Chọn xã') }}</option>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label for="address_detail">{{ __('home.Detail Address') }}</label>
                <input type="text" class="form-control" value="{{ $address->address_detail }}" maxlength="200"
                       id="address_detail" required>
            </div>
            <div class="form-group form-check">
                <input type="checkbox" class="form-check-input" id="is_default"
                       {{ $address->is_default == 1 ? 'checked' : '' }} value="100">
                <label class="form-check-label" for="is_default"> {{ __('home.Set address default') }}</label>
            </div>
            <div class="text-center mt-3">
                <button type="button" class="btn btn-primary" id="btnUpdate">{{ __('home.Save') }}</button>
            </div>
        </form>
    </div>
    <script>
        let accessToken = `Bearer ` + token;
        let headers = {
            'content-type': 'application/json',
            "Authorization": accessToken
        };

        $(document).ready(function () {
            $('#btnUpdate').on('click', function () {
                updateNewAddress();
            })
        })


        async function updateNewAddress() {
            const formData = new FormData();

            const arrField = [
                "username", "phone", "address_detail",
                "province_id", "district_id", "commune_id",
            ];

            let is_default = null;

            if ($('#is_default').is(':checked')) {
                is_default = $('#is_default').val();
            }

            let isValid = false;
            isValid = appendDataForm(arrField, formData, isValid);

            const data = {
                username: $('#username').val(),
                phone: $('#phone').val(),
                address_detail: $('#address_detail').val(),
                user_id: `{{ Auth::user()->id }}`,
                province_id: $('#province_id').val(),
                district_id: $('#district_id').val(),
                commune_id: $('#commune_id').val(),
                status: `{{ \App\Enums\AddressStatus::ACTIVE }}`,
                is_default: is_default,
            }

            if (!isValid) {
                return;
            }

            try {
                await fetch(`{{ route('api.backend.address.order.update', $address->id) }}`, {
                    method: 'PUT',
                    headers: headers,
                    body: JSON.stringify(data),

                })
                    .then(response => {
                        if (response.status == 200) {
                            alert('Update success!')
                            window.location.href = `{{ route('view.user.address.list') }}`;
                        } else {
                            alert('Update error!')
                        }
                    })
                    .catch(error =>
                        console.log(error)
                    );
            } catch (e) {
                console.log(e)
                alert('Error, Please try again!');
            }
        }
    </script>
    <script>
        callGetAllProvince();

        async function callGetAllProvince() {
            $.ajax({
                url: `{{ route('restapi.get.provinces') }}`,
                method: 'GET',
                success: function (response) {
                    showAllProvince(response);
                },
                error: function (exception) {
                    console.log(exception);
                }
            });
        }

        async function callGetAllDistricts(code) {
            let url = `{{ route('restapi.get.districts', ['code' => ':code']) }}`;
            url = url.replace(':code', code);
            $.ajax({
                url: url,
                method: 'GET',
                success: function (response) {
                    showAllDistricts(response);
                },
                error: function (exception) {
                    console.log(exception);
                }
            });
        }

        async function callGetAllCommunes(code) {
            let url = `{{ route('restapi.get.communes', ['code' => ':code']) }}`;
            url = url.replace(':code', code);
            $.ajax({
                url: url,
                method: 'GET',
                success: function (response) {
                    showAllCommunes(response);
                },
                error: function (exception) {
                    console.log(exception);
                }
            });
        }

        function showAllProvince(res) {
            let html = ``;
            let pro = `{{ $address->province_id }}`;
            let select = ''
            for (let i = 0; i < res.length; i++) {
                let data = res[i];
                if (data.id == pro) {
                    select = 'selected';
                } else {
                    select = '';
                }
                let code = data.code;
                html = html + `<option ${select} class="province province-item" data-id="${data.id}" data-code="${code}" value="${data.id}">${data.name}</option>`;
            }
            $('#province_id').empty().append(html);
            callGetAllDistricts($('#province_id').find(':selected').data('code'));
        }

        function showAllDistricts(res) {
            let html = ``;
            let dis = `{{ $address->district_id }}`;
            let select = ''
            for (let i = 0; i < res.length; i++) {
                let data = res[i];
                if (data.id == dis) {
                    select = 'selected';
                } else {
                    select = '';
                }
                let code = data.code;
                html = html + `<option ${select} class="district district-item" data-id="${data.id}" data-code="${code}" value="${data.id}">${data.name}</option>`;
            }
            $('#district_id').empty().append(html);
            callGetAllCommunes($('#district_id').find(':selected').data('code'));
        }

        function showAllCommunes(res) {
            let html = ``;
            let com = `{{ $address->commune_id }}`;
            for (let i = 0; i < res.length; i++) {
                let data = res[i];
                if (data.id == com) {
                    select = 'selected';
                } else {
                    select = '';
                }
                html = html + `<option ${select} data-id="${data.id}" value="${data.id}">${data.name}</option>`;
            }
            $('#commune_id').empty().append(html);
        }
    </script>
@endsection
