@php use App\Enums\FamilyManagementEnum;use App\Enums\RelationshipFamily; @endphp
@extends('layouts.admin')

@section('main-content')

    <div class="container">
        <div class="row">
            <div class="col-sm-6">
                <label for="name">{{ __('home.Name') }}</label>
                <input type="text" class="form-control" id="name" name="name">
            </div>
            <div class="col-sm-6">
                <label for="date_of_birth">{{ __('home.Date of birth') }}</label>
                <input type="date" class="form-control" id="date_of_birth" name="date_of_birth">
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6">
                <label for="number_phone">{{ __('home.PhoneNumber') }}</label>
                <input type="number" class="form-control" id="number_phone" name="number_phone">
            </div>
            <div class="col-sm-6">
                <label for="email">{{ __('home.Email') }}</label>
                <input type="email" class="form-control" id="email" name="email">
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6">
                <label for="sex">{{ __('home.Sexs') }}</label>
                <select class="custom-select form-control" id="sex" name="sex">
                    <option value="{{ FamilyManagementEnum::NAM }}">{{ __('home.Nam') }}</option>
                    <option value="{{ FamilyManagementEnum::NU }}">{{ __('home.Nu') }}</option>
                </select>
            </div>
            <div class="col-sm-6">
                <label for="relationship">{{ __('home.quan he voi chu ho') }}</label>
                <select class="custom-select form-control" id="relationship" name="relationship">
                    @foreach(RelationshipFamily::asArray() as $key => $value)
                        <option value="{{ $value }}">{{ $key }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6">
                <label for="province_id">{{ __('home.Province') }}</label>
                <select class="custom-select form-control" id="province_id" name="province_id"
                        onchange="callGetAllDistricts(this.value)">
                </select>
            </div>
            <div class="col-sm-6">
                <label for="district_id">{{ __('home.District') }}</label>
                <select class="custom-select form-control" id="district_id" name="district_id"
                        onchange="callGetAllCommunes(this.value)">
                </select>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6">
                <label for="ward_id">{{ __('home.Ward') }}</label>
                <select class="custom-select form-control" id="ward_id" name="ward_id">
                </select>
            </div>
            <div class="col-sm-6">
                <label for="detail_address">{{ __('home.Addresses') }}</label>
                <input type="text" class="form-control" id="detail_address" name="detail_address">
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6">
                <label for="avatar">{{ __('home.avatar') }}</label>
                <input type="file" class="form-control" id="avatar" name="avatar" accept="image/*">
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-sm-4">
                <button class="btn btn-primary" type="button" onclick="submitForm()">{{ __('home.create') }}</button>
            </div>
        </div>
    </div>

    <script>

        disableAfterThisDay();

        function disableAfterThisDay() {
            // Get the current date in the format YYYY-MM-DD
            const currentDate = new Date().toISOString().split('T')[0];

            // Set the max attribute of the date input field
            document.getElementById('date_of_birth').max = currentDate;

            document.getElementById('date_of_birth').value = currentDate;
        }

        function submitForm() {
            let formData = new FormData();
            let isValid = true;
            let arrInput = ['name', 'date_of_birth',
                'number_phone', 'email', 'sex',
                'relationship', 'province_id', 'district_id',
                'ward_id', 'detail_address'];
            isValid = appendDataForm(arrInput, formData, isValid);

            if (!isValid) {
                return;
            }

            // check file avatar not empty
            let file = $('#avatar')[0].files[0];
            if (!file) {
                alert('Vui lòng chọn ảnh đại diện');
                return;
            }

            let url = `{{route('api.backend.family-management.store', ['type' => ':type'])}}`;
            url = url.replace(':type', '{{ FamilyManagementEnum::CREATE_FAMILY }}');

            formData.append('_token', '{{ csrf_token() }}');
            // push file avatar to form data
            if (file) {
                formData.append('avatar', file);
            }

            $.ajax({
                url: url,
                method: 'POST',
                headers: {
                    'Authorization': `Bearer ${token}`
                },
                data: formData,
                contentType: false,
                processData: false,
                success: function (data) {
                    window.location.href = `{{route('api.backend.family-management.index')}}`;
                },
                error: function (error) {
                    console.log(error)
                    alert(error.responseJSON.message);
                }
            });
        }

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
            for (let i = 0; i < res.length; i++) {
                let data = res[i];
                let code = data.code;

                html = html + `<option class="province province-item" data-code="${code}" value="${data.code}">${data.name}</option>`;
            }
            $('#province_id').empty().append(html);
            callGetAllDistricts($('#province_id').find(':selected').val());
        }

        function showAllDistricts(res) {
            let html = ``;
            for (let i = 0; i < res.length; i++) {
                let data = res[i];
                html = html + `<option class="district district-item" value="${data.code}">${data.name}</option>`;
            }
            $('#district_id').empty().append(html);
            callGetAllCommunes($('#district_id').find(':selected').val());
        }

        function showAllCommunes(res) {
            let html = ``;
            for (let i = 0; i < res.length; i++) {
                let data = res[i];
                html = html + `<option value="${data.code}">${data.name}</option>`;
            }
            $('#ward_id').empty().append(html);
        }
    </script>
@endsection
