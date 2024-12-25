@extends('layouts.admin')
@section('title')
    Quản lý địa chỉ
@endsection
@section('main-content')
    <div class="">
        <h1 class="h3 mb-4 text-gray-800">Thêm địa chỉ mới</h1>
        @if (session('success'))
            <div class="alert alert-success border-left-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger border-left-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
        <form action="{{route('api.clinic-location.store')}}" method="POST">
            @csrf
            <div class="row">
                <div class="col-sm-4">
                    <div class="form-group focused">
                        <label for="province_id">Tỉnh/Thành phố <span class="small text-danger">*</span></label>
                        <select name="province_id" id="province_id" class="form-control"
                                onchange="callGetAllDistricts(this.value)">
                        </select>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group focused">
                        <label for="district_id">Quận/Huyện <span class="small text-danger">*</span></label>
                        <select name="district_id" id="district_id" class="form-control"
                                onchange="callGetAllCommunes(this.value)">
                            <option value="">{{ __('home.Chọn quận') }}</option>
                        </select>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group focused">
                        <label for="commune_id">Phường/Xã <span class="small text-danger">*</span></label>
                        <select name="commune_id" id="commune_id" class="form-control">
                            <option value="">{{ __('home.Chọn xã') }}</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <label for="detail_address">Địa chỉ chi tiết<span class="small text-danger">*</span></label>
                    <input class="form-control" name="detail_address" id="detail_address" required>
                </div>
            </div>
            <div class="row mt-3">
                <div class="form-group col-md-4">
                    <label for="status">{{ __('home.Status') }}</label>
                    <select id="status" class="form-control" name="status">
                        <option value="Active" >{{ __('home.Active') }}</option>
                        <option value="Inactive" >{{ __('home.Inactive') }}</option>
                    </select>
                </div>
            </div>
            <input type="hidden" name="new_latitude" id="new_latitude">
            <input type="hidden" name="new_longitude" id="new_longitude">
            <input type="hidden" name="user_id" value="{{$userID}}">
            <button type="submit" class="btn btn-primary d-flex m-auto">{{ __('home.Save') }}</button>
        </form>
    </div>

@endsection

@section('page-script')
    <script>
        callGetAllProvince();

        async function callGetAllProvince() {
            $.ajax({
                url: `{{ route('restapi.get.provinces') }}`,
                method: 'GET',
                success: function(response) {
                    showAllProvince(response);
                },
                error: function(exception) {
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
                success: function(response) {
                    showAllDistricts(response);
                },
                error: function(exception) {
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
                success: function(response) {
                    showAllCommunes(response);
                },
                error: function(exception) {
                    console.log(exception);
                }
            });
        }

        function showAllProvince(res) {
            let html = ``;
            let select = ``;
            for (let i = 0; i < res.length; i++) {
                let data = res[i];
                let code = data.code;
                html = html +
                    `<option ${select} class="province province-item" data-code="${code}" value="${data.code}">${data.name}</option>`;
            }
            $('#province_id').empty().append(html);
            callGetAllDistricts($('#province_id').find(':selected').val());
        }

        function showAllDistricts(res) {
            let html = ``;
            let select = ``;
            for (let i = 0; i < res.length; i++) {
                let data = res[i];
                html = html + `<option ${select} class="district district-item" value="${data.code}">${data.name}</option>`;
            }
            $('#district_id').empty().append(html);
            callGetAllCommunes($('#district_id').find(':selected').val());
        }

        function showAllCommunes(res) {
            let html = ``;
            let select = ``;
            for (let i = 0; i < res.length; i++) {
                let data = res[i];
                html = html + `<option ${select} value="${data.code}">${data.name}</option>`;
            }
            $('#commune_id').empty().append(html);
        }

        let debounceTimeout; // Variable to store the debounce timeout

        function updateLatLongInputs() {
            const detailAddress = document.getElementById('detail_address').value;
            const province = document.getElementById('province_id').options[document.getElementById('province_id').selectedIndex].text;
            const district = document.getElementById('district_id').options[document.getElementById('district_id').selectedIndex].text;
            const commune = document.getElementById('commune_id').options[document.getElementById('commune_id').selectedIndex].text;

            const fullAddress = `${detailAddress}, ${commune}, ${district}, ${province}`;

            const geocodeUrl = `https://maps.googleapis.com/maps/api/geocode/json?address=${encodeURIComponent(fullAddress)}&key=AIzaSyBw3G5DUAOaV9CFr3Pft_X-949-64zXaBg`;

            fetch(geocodeUrl)
                .then(response => response.json())
                .then(data => {
                    if (data.status === "OK") {
                        const location = data.results[0].geometry.location;

                        console.log(`Latitude: ${location.lat}, Longitude: ${location.lng}`);

                        // Update hidden input values
                        document.getElementById('new_latitude').value = location.lat;
                        document.getElementById('new_longitude').value = location.lng;
                    } else {
                        console.error("Geocoding failed: " + data.status);
                    }
                })
                .catch(error => console.error("Error: ", error));
        }

        function debounceUpdateLatLongInputs() {
            clearTimeout(debounceTimeout); // Clear the existing timeout
            debounceTimeout = setTimeout(updateLatLongInputs, 700); // Set a new timeout for 0.7 seconds
        }

        // Event listeners for inputs
        document.getElementById('detail_address').addEventListener('input', debounceUpdateLatLongInputs);
        document.getElementById('province_id').addEventListener('change', updateLatLongInputs);
        document.getElementById('district_id').addEventListener('change', updateLatLongInputs);
        document.getElementById('commune_id').addEventListener('change', updateLatLongInputs);
    </script>
@endsection
