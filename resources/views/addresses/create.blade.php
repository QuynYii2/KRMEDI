@extends('layouts.admin')
@section('title')
    {{ __('home.Create Address') }}
@endsection
@section('main-content')
    <h3 class="text-center">{{ __('home.Create Address') }}</h3>
    <div class="container">
        <form>
            <div class="row">
                <div class="form-group col-md-6">
                    <label for="username">{{ __('home.Full Name') }}</label>
                    <input type="text" class="form-control" id="username" maxlength="200" required>
                </div>
                <div class="form-group col-md-6">
                    <label for="phone">{{ __('home.PhoneNumber') }}</label>
                    <input type="text" class="form-control" maxlength="200" id="phone" required>
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
                <input type="text" class="form-control" maxlength="200" id="address_detail" required>
            </div>
            <div class="form-group form-check">
                <input type="checkbox" class="form-check-input" id="is_default" value="100">
                <label class="form-check-label" for="is_default">{{ __('home.Set address default') }}</label>
            </div>
            <div class="text-center mt-3">
                <button type="button" class="btn btn-primary" id="btnCreate">{{ __('home.create') }}</button>
            </div>
        </form>
    </div>
    <script>
        let accessToken = `Bearer ` + token;
        let headers = {
            "Authorization": accessToken
        };

        $(document).ready(function () {
            $('#btnCreate').on('click', function () {
                createNewAddress();
            })
        })


        async function createNewAddress() {
            const formData = new FormData();

            const arrField = [
                "username", "phone", "address_detail",
                "province_id", "district_id", "commune_id",
            ];

            formData.append('user_id', `{{ Auth::user()->id }}`);
            formData.append('status', `{{ \App\Enums\AddressStatus::ACTIVE }}`);

            if ($('#is_default').is(':checked')) {
                formData.append('is_default', $('#is_default').val());
            }

            let isValid = true
            /* Tạo fn appendDataForm ở admin blade */
            isValid = appendDataForm(arrField, formData, isValid);

            if (isValid) {
                try {
                    await $.ajax({
                        url: `{{ route('api.backend.address.order.create') }}`,
                        method: 'POST',
                        headers: headers,
                        contentType: false,
                        cache: false,
                        processData: false,
                        data: formData,
                        success: function (response) {
                            alert('Create success!')
                            // window.location.href = ``;
                            window.location.href = `{{ route('view.user.address.list') }}`;
                        },
                        error: function (error) {
                            console.log(error);
                            alert('Create error!')
                        }
                    });
                } catch (e) {
                    console.log(e)
                    alert('Error, Please try again!');
                }
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
            console.log(code);
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
            for (let i = 0; i < res.length; i++) {
                let data = res[i];
                let code = data.code;
                html = html + `<option class="province province-item" data-id="${data.id}" data-code="${code}" value="${data.id}">${data.name}</option>`;
            }
            $('#province_id').empty().append(html);
            callGetAllDistricts($('#province_id').find(':selected').data('code'));
        }

        function showAllDistricts(res) {
            let html = ``;
            for (let i = 0; i < res.length; i++) {
                let data = res[i];
                let code = data.code;
                html = html + `<option class="district district-item" data-id="${data.id}" data-code="${code}" value="${data.id}">${data.name}</option>`;
            }
            $('#district_id').empty().append(html);
            callGetAllCommunes($('#district_id').find(':selected').data('code'));
        }

        function showAllCommunes(res) {
            let html = ``;
            for (let i = 0; i < res.length; i++) {
                let data = res[i];
                html = html + `<option data-id="${data.id}" value="${data.id}">${data.name}</option>`;
            }
            $('#commune_id').empty().append(html);
        }
    </script>
@endsection
