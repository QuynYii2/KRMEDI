@extends('layouts.admin')
@section('title')
    {{ __('home.Edit Business') }}
@endsection
@section('main-content')
    <link href="{{ asset('css/tabcreateclinics.css') }}" rel="stylesheet">
    <style>

        * {
            box-sizing: border-box;
        }

        .dropdown {
            position: relative;
            margin-bottom: 20px;
        }

        .dropdown .dropdown-list {
            padding: 25px 20px;
            background: #fff;
            position: absolute;
            top: 50px;
            left: 0;
            right: 0;
            border: 1px solid rgba(0, 0, 0, .2);
            max-height: 223px;
            overflow-y: auto;
            background: #fff;
            display: none;
            z-index: 10;
        }

        .dropdown .checkbox {
            opacity: 0;
            transition: opacity 0.2s;
        }

        .dropdown .dropdown-label {
            display: block;
            height: 44px;
            font-size: 16px;
            line-height: 42px;
            background: #fff;
            border: 1px solid rgba(0, 0, 0, .2);
            padding: 0 40px 0 20px;
            cursor: pointer;
            position: relative;
        }

        .dropdown .dropdown-label:before {
            content: '▼';
            position: absolute;
            right: 20px;
            top: 50%;
            transform: translateY(-50%);
            transition: transform 0.25s;
            transform-origin: center center;
        }

        .dropdown.open .dropdown-list {
            display: block;
        }

        .dropdown.open .checkbox {
            transition: 2s opacity 2s;
            opacity: 1;
        }

        .dropdown.open .dropdown-label:before {
            transform: translateY(-50%) rotate(-180deg);
        }

        .checkbox {
            margin-bottom: 20px;
        }

        .checkbox:last-child {
            margin-bottom: 0;
        }

        .checkbox .checkbox-custom {
            display: none;
        }

        .checkbox .checkbox-custom-label {
            display: inline-block;
            position: relative;
            vertical-align: middle;
            cursor: pointer;
        }

        .checkbox .checkbox-custom + .checkbox-custom-label:before {
            content: '';
            background: transparent;
            display: inline-block;
            vertical-align: middle;
            margin-right: 10px;
            text-align: center;
            width: 12px;
            height: 12px;
            border: 1px solid rgba(0, 0, 0, .3);
            border-radius: 2px;
            margin-top: -2px;
        }

        .checkbox .checkbox-custom:checked + .checkbox-custom-label:after {
            content: '';
            position: absolute;
            top: 2px;
            left: 4px;
            height: 4px;
            padding: 2px;
            transform: rotate(45deg);
            text-align: center;
            border: solid #000;
            border-width: 0 2px 2px 0;
        }

        .checkbox .checkbox-custom-label {
            line-height: 16px;
            font-size: 16px;
            margin-right: 0;
            margin-left: 0;
            color: black;
        }


        .list-department,
        .list-symptoms,
        .list-service {
            list-style-type: none;
            padding: 0;
            margin: 0;
        }

        .list-department li,
        .list-symptoms li,
        .list-service li {
            margin-right: 20px; /* Adjust as needed */
        }

        .list-department li:last-child,
        .list-symptoms li:last-child,
        .list-service li:last-child {
            margin-right: 0;
        }

        .new-select {
            display: flex;
            align-items: center;
        }

        .new-select input {
            margin-right: 5px; /* Adjust as needed */
        }

        .new-select label {
            margin-top: 10px;
        }

        /* Add more styles as needed */

    </style>
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">{{ __('home.Edit') }}</h1>
    <form>
        @csrf
        @method('POST')
        <div>
            <div class="row">
                <div class="col-md-12">
                    <label for="name">{{ __('home.Name') }}</label>
                    <input type="text" class="form-control" id="name" name="name" value="{{$clinic->name}}">
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <label for="phone">{{ __('home.PhoneNumber') }}</label>
                    <input type="number" class="form-control" id="phone" name="phone" required
                           value="{{$clinic->phone}}">
                </div>
                <div class="col-md-6">
                    <label for="email">{{ __('home.Email') }}</label>
                    <input type="email" class="form-control" id="email" name="email" required
                           value="{{$clinic->email}}">
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <label for="address_detail">{{ __('home.địa chỉ chi tiết việt') }}</label>
                    <input type="text" class="form-control" name="address_detail" id="address_detail"
                           value="{{$clinic->address_detail}}">
                </div>
            </div>
            <div class="row">
                @php
                    $combinedAddress = $clinic->address;
                    $addressParts = explode(',', $combinedAddress);
                    $detailAddress = $addressParts[0];
                    $codeProvince = $addressParts[1];
                    $codeDistrict = $addressParts[2];
                    $codeCommune = $addressParts[3];
                @endphp
                <div class="col-sm-4">
                    <label for="province_id">{{ __('home.Tỉnh') }}</label>
                    <select name="province_id" id="province_id" class="form-control">

                    </select>
                </div>
                <div class="col-sm-4">
                    <label for="district_id">{{ __('home.Quận') }}</label>
                    @php
                        $district = \App\Models\District::find($codeDistrict);
                    @endphp
                    <select name="district_id" id="district_id" class="form-control">
                        @if($district)
                            <option value="{{$district->id}}-{{$district->code}}"> {{$district->name}}</option>
                        @endif

                    </select>
                </div>
                <div class="col-sm-4">
                    <label for="commune_id">{{ __('home.Xã') }}</label>
                    @php
                        $commune = \App\Models\Commune::find($codeCommune);
                    @endphp
                    <select name="commune_id" id="commune_id" class="form-control">
                        @if($commune)
                            <option value="{{$commune->id}}-{{$commune->code}}">{{$commune->name}}</option>
                        @endif

                    </select>
                </div>
            </div>
            <div>
                <label for="introduce">{{ __('home.introduce') }}</label>
                <textarea type="text" class="form-control" id="introduce" name="introduce" required>
                    {{$clinic->introduce}}
                </textarea>
            </div>
            <div>
                <label>{{ __('home.gallery') }}</label>
                <input type="file" class="form-control" id="gallery" name="gallery" multiple>
                @php
                    $galleryArray = explode(',', $clinic->gallery);
                @endphp
                @foreach($galleryArray as $productImg)
                    <img loading="lazy" width="50px" src="{{$productImg}}" alt="">
                @endforeach
            </div>
            <div class="row">
                <div class="col-md-6">
                    <label for="status">{{ __('home.Status') }}</label>
                    <select class="form-select" id="status" name="status">
                        <option
                            value="{{ \App\Enums\ClinicStatus::ACTIVE }}" {{ $clinic->status === \App\Enums\ClinicStatus::ACTIVE ? 'selected' : '' }}>{{ \App\Enums\ClinicStatus::ACTIVE }}</option>
                        <option
                            value="{{ \App\Enums\ClinicStatus::INACTIVE }}" {{ $clinic->status === \App\Enums\ClinicStatus::INACTIVE ? 'selected' : '' }}>{{ \App\Enums\ClinicStatus::INACTIVE }}</option>
                        <option
                            value="{{ \App\Enums\ClinicStatus::DELETED }}" {{ $clinic->status === \App\Enums\ClinicStatus::DELETED ? 'selected' : '' }}>{{ \App\Enums\ClinicStatus::DELETED }}</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label for="time_work">{{ __('home.Time work') }}</label>
                    <select class="form-select" id="time_work" name="time_work">
                        @foreach($types as $type)
                            <option
                                {{ $type == $clinic->time_work ? 'selected' : ''}} value="{{ $type }}">{{ $type }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div hidden="">
                <label for="user_id">{{ __('home.Username') }}</label>
                <input type="text" class="form-control" id="user_id" name="user_id" value="{{Auth::user()->id}}">
            </div>
            <div class="form-group">
                <label for="service_clinic">{{ __('home.Service Clinics') }}</label>
                <input type="text" class="form-control" id="service_clinic" name="service_clinic" disabled>
                <ul class="list-service">
                    @php
                        $arrayService = explode(',', $clinic->service_id);
                    @endphp
                    @foreach($services as $service)
                        <li class="new-select">
                            <input onchange="getInputService();" class="service_clinic_item" value="{{$service->id}}"
                                   id="service_{{$service->id}}"
                                   name="service_clinic"
                                   {{ in_array($service->id, $arrayService) ? 'checked' : '' }}
                                   type="checkbox">
                            <label for="service_{{$service->id}}">{{$service->name}}</label>
                        </li>
                    @endforeach
                </ul>
            </div>

            <div class="form-group">
                <label for="department">{{ __('home.Department') }}</label>
                <input type="text" class="form-control" id="department" name="department_text" disabled>
                <ul class="list-department">
                    @php
                        $arrayDepartment = explode(',', $clinic->department);
                    @endphp
                    @foreach($departments as $department)
                        <li class="new-select">
                            <input onchange="getInputDepartment();" class="department_item" value="{{$department->id}}"
                                   id="department_{{$department->id}}"
                                   name="department"
                                   {{ in_array($department->id, $arrayDepartment) ? 'checked' : '' }}
                                   type="checkbox">
                            <label for="department_{{$department->id}}">{{$department->name}}</label>
                        </li>
                    @endforeach
                </ul>
            </div>

            <div class="form-group">
                <label for="symptom">{{ __('home.symptoms') }}</label>
                <input type="text" class="form-control" id="symptom" name="symptom" disabled>
                <ul class="list-symptoms">
                    @php
                        $arraySymptoms = explode(',', $clinic->symptom);
                    @endphp
                    @foreach($symptoms as $symptom)
                        <li class="new-select">
                            <input onchange="getInputSymptom();" class="symptom_item" value="{{$symptom->id}}"
                                   id="symptom_{{$symptom->id}}"
                                   name="symptom"
                                   {{ in_array($symptom->id, $arraySymptoms) ? 'checked' : '' }}
                                   type="checkbox">
                            <label for="symptom_{{$symptom->id}}">{{$symptom->name}}</label>
                        </li>
                    @endforeach
                </ul>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <label for="open_date">{{ __('home.open_date') }}</label>
                    <input type="datetime-local" class="form-control" id="open_date" name="open_date" required
                           value="{{$clinic->open_date}}">
                </div>
                <div class="col-md-4">
                    <label for="close_date">{{ __('home.close_date') }}</label>
                    <input type="datetime-local" class="form-control" id="close_date" name="close_date"
                           value="{{$clinic->close_date}}">
                </div>
                <div class="col-md-4">
                    <label for="type">{{ __('home.type') }}</label>
                    <select class="form-select" id="type" name="time_work">
                        <option
                            value="{{\App\Enums\TypeBusiness::CLINICS}}" {{ $clinic->type === \App\Enums\TypeBusiness::CLINICS ? 'selected' : '' }}>{{\App\Enums\TypeBusiness::CLINICS}}</option>
                        <option
                            value="{{\App\Enums\TypeBusiness::PHARMACIES}}" {{ $clinic->type === \App\Enums\TypeBusiness::PHARMACIES ? 'selected' : '' }}>{{\App\Enums\TypeBusiness::PHARMACIES}}</option>
                        <option
                            value="{{\App\Enums\TypeBusiness::HOSPITALS}}" {{ $clinic->type === \App\Enums\TypeBusiness::HOSPITALS ? 'selected' : '' }}>{{\App\Enums\TypeBusiness::HOSPITALS}}</option>
                    </select>
                </div>

                <div hidden="">
                    <label for="combined_address"></label>
                    <input type="text" name="combined_address" id="combined_address" value="{{ $clinic->address }}"
                           class="form-control">
                    <label for="longitude"></label>
                    <input type="text" name="longitude" id="longitude" class="form-control"
                           value="{{ $clinic->longitude }}">
                    <label for="latitude"></label>
                    <input type="text" name="latitude" id="latitude" class="form-control"
                           value="{{ $clinic->latitude }}">
                    <label for="clinics_service"></label>
                    <input type="text" name="clinics_service" id="clinics_service" class="form-control">
                    <label for="departments"></label>
                    <input type="text" name="departments" id="departments" class="form-control">
                    <label for="symptoms"></label>
                    <input type="text" name="symptoms" id="symptoms" class="form-control">
                    <label for="representative_doctor"></label>
                    <input type="text" name="representative_doctor" id="representative_doctor" value="{{ $clinic->representative_doctor }}"
                           class="form-control">
                </div>
            </div>
            <div class="row">
                <div class="col-md-3">
                    <div class="form-element">
                        <input name="emergency" id="emergency" type="checkbox" value="1"
                               @if($clinic->emergency == 1) checked @endif>
                        <label for="emergency">{{ __('home.Is there an emergency room') }}?</label>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-element">
                        <input name="insurance" id="insurance" type="checkbox" value="1"
                               @if($clinic->insurance == 1) checked @endif>
                        <label for="insurance">{{ __('home.Is health insurance applicable') }}?</label>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-element">
                        <input name="parking" id="parking" type="checkbox" value="1"
                               @if($clinic->parking == 1) checked @endif>
                        <label for="parking">{{ __('home.Is there parking') }}?</label>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-element">
                        <label for="costs">{{ __('home.Medical examination costs') }}?</label>
                        <input name="costs" class="form-control" id="costs" type="number" value="{{$clinic->costs}}">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <label for="hospital_information">{{ __('home.Hospital information') }}</label>
                    <div class="dropdown" data-target="hospital_information">
                        <label class="dropdown-label">{{ __('home.Select Options') }}</label>
                        <input class="d-none" name="hospital_information" id="hospital_information"
                               value="{{$clinic->information}}"/>
                        <div class="dropdown-list">
                            @php
                                $arrayInformation = explode(',',$clinic->information);
                                $options = [
                                    "Pediatric examination/treatment",
                                    " Emergency department",
                                    " Female doctor",
                                    " Specialized hospital",
                                    " Check health certificate",
                                    " Physical examination",
                                    " Rapid antigen test",
                                    " PCR test",
                                ];
                            @endphp
                            @foreach($options as $key => $option)
                                <div class="checkbox">
                                    <input type="checkbox" name="dropdown-group"
                                           class="check hospital_information_name checkbox-custom"
                                           id="checkbox-custom_{{ $key }}" value="{{ $option }}"
                                           @if(in_array($option, $arrayInformation, true) || in_array($option, explode(', ', old('hospital_information', '')))) checked @endif />
                                    <label for="checkbox-custom_{{ $key }}"
                                           class="checkbox-custom-label">{{ $option }}</label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <label for="hospital_facilities">{{ __('home.Hospital facilities') }}</label>
                    <div class="dropdown" data-target="hospital_facilities">
                        <label class="dropdown-label">{{ __('home.Select Options') }}</label>
                        <input class="d-none" name="hospital_facilities" id="hospital_facilities"
                               value="{{$clinic->facilities}}"/>
                        <div class="dropdown-list">
                            @php
                                $arrayFacilities = explode(',', $clinic->facilities);
                                $facilityOptions = [
                                    "Intensive care unit",
                                    " General hospital room",
                                    " High-class hospital room",
                                    " Surgery room",
                                    " Emergency room",
                                    " Physiotherapy room",
                                ];
                            @endphp
                            @foreach($facilityOptions as $key => $facilityOption)
                                <div class="checkbox">
                                    <input type="checkbox" name="dropdown-group"
                                           class="check hospital_facilities_name checkbox-custom"
                                           id="checkbox-custom_{{ $key + 21 }}" value="{{ $facilityOption }}"
                                           @if(in_array($facilityOption, $arrayFacilities, true) || in_array($facilityOption, explode(', ', old('hospital_facilities', '')))) checked @endif />
                                    <label for="checkbox-custom_{{ $key + 21 }}"
                                           class="checkbox-custom-label">{{ $facilityOption }}</label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <label for="hospital_equipment">{{ __('home.Hospital equipment') }}</label>
                    <div class="dropdown" data-target="hospital_equipment">
                        <label class="dropdown-label">{{ __('home.Select Options') }}</label>
                        <input class="d-none" name="hospital_equipment" id="hospital_equipment"
                               value="{{$clinic->equipment}}"/>
                        <div class="dropdown-list">
                            @php
                                $arrayEquipment = explode(',', $clinic->equipment);
                                $equipmentOptions = [
                                    "CT",
                                    " MRI",
                                    " Bone density meter",
                                    " Positron tomography (PET)",
                                    " Tumor treatment device (CYBER KNIFE)",
                                    " Ultrasound imaging equipment",
                                    " Tumor treatment devices (proton therapy devices)",
                                    " Artificial kidney equipment for hemodialysis",
                                ];
                            @endphp
                            @foreach($equipmentOptions as $key => $equipmentOption)
                                <div class="checkbox">
                                    <input type="checkbox" name="dropdown-group"
                                           class="check hospital_equipment_name checkbox-custom"
                                           id="checkbox-custom_{{ $key + 27 }}" value="{{ $equipmentOption }}"
                                           @if(in_array($equipmentOption, $arrayEquipment, true) || in_array($equipmentOption, explode(', ', old('hospital_equipment', '')))) checked @endif />
                                    <label for="checkbox-custom_{{ $key + 27 }}"
                                           class="checkbox-custom-label">{{ $equipmentOption }}</label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            @php
                $list_doctor = $clinic->representative_doctor;
                $array_doctor = explode(',', $list_doctor);
            @endphp
            <div class="row">
                <div class="col-md-12">
                    <label for="representative_doctor_text">{{ __('home.Chọn một tùy chọn') }}:</label>
                    <input type="text" class="form-control" id="representative_doctor_text"
                           name="representative_doctor_text" disabled>
                    <ul class="list-department bg-white p-3" style="max-height: 300px; overflow: auto">
                        @foreach($doctorLists as $doctor)
                            <li class="new-select">
                                <input onchange="getInputDoctor();" class="representative_doctor_item"
                                       value="{{$doctor->id}}"
                                       {{ in_array($doctor->id, $array_doctor) ? 'checked' : ''}}
                                       id="representative_doctor_{{$doctor->id}}"
                                       name="representative_doctor"
                                       type="checkbox">
                                <label for="representative_doctor_{{$doctor->id}}">{{$doctor->username}}
                                    ({{$doctor->email}})</label>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>

            <button type="button" class="btn btn-primary up-date-button mt-4">{{ __('home.Save') }}</button>
        </div>
    </form>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDe6qi9czJ2Z6SLnV9sSUzce0nuzhRm3hg"></script>
    <script>
        $(document).ready(function () {
            // Lắng nghe sự kiện onchange của các dropdown tỉnh, huyện, xã
            $('#province_id, #district_id, #commune_id').on('change', function () {
                // Gọi hàm để lưu địa chỉ khi có sự thay đổi
                saveAddressOnChange();
            });

            function saveAddressOnChange() {
                // Lấy giá trị từ các dropdown
                var provinceId = $('#province_id').val();
                var codeProvinceId = getCodeFromValue(provinceId);

                var districtId = $('#district_id').val();
                var codeDistrictId = getCodeFromValue(districtId);

                var communeId = $('#commune_id').val();
                var codeCommuneId = getCodeFromValue(communeId);

                // Lấy địa chỉ chi tiết từ input
                var detailAddress = $('#address_detail').val();

                // Gộp các giá trị vào một chuỗi cách nhau bởi dấu phẩy
                var combinedAddress = [detailAddress, codeCommuneId, codeDistrictId, codeProvinceId, 'Việt Nam'].join(',');
                // Gán giá trị vào input ẩn
                $('#combined_address').val(combinedAddress);
                addNewAddress();
                let latitude = $('#latitude');
                let longitude = $('#longitude');
                if (!latitude.val()) {
                    latitude.val(localStorage.getItem('latitude'))
                }

                if (!longitude.val()) {
                    longitude.val(localStorage.getItem('longitude'))
                }
            }

            function getCodeFromValue(value) {
                // Hàm này nhận một giá trị của dropdown và trả về mã code nếu có
                if (value) {
                    let myArray = value.split('-');
                    return myArray.length > 2 ? myArray[2] : '';
                }
                return '';
            }
        });

    </script>
    <script>
        $(document).ready(function () {
            // Lắng nghe sự kiện onchange của các dropdown tỉnh, huyện, xã
            $('#province_id, #district_id, #commune_id').on('change', function () {
                // Gọi hàm để lưu địa chỉ khi có sự thay đổi
                saveAddressOnChange();
            });

            function saveAddressOnChange() {
                // Lấy giá trị từ các dropdown
                var provinceId = $('#province_id').val();
                var codeProvinceId = getCodeFromValue(provinceId);

                var districtId = $('#district_id').val();
                var codeDistrictId = getCodeFromValue(districtId);

                var communeId = $('#commune_id').val();
                var codeCommuneId = getCodeFromValue(communeId);

                // Lấy địa chỉ chi tiết từ input
                var detailAddress = $('#address_detail').val();

                // Gộp các giá trị vào một chuỗi cách nhau bởi dấu phẩy
                var combinedAddress = [detailAddress, codeCommuneId, codeDistrictId, codeProvinceId, 'Việt Nam'].join(',');
                // Gán giá trị vào input ẩn
                $('#combined_address').val(combinedAddress);
                addNewAddress();
                let latitude = $('#latitude');
                let longitude = $('#longitude');
                if (!latitude.val()) {
                    latitude.val(localStorage.getItem('latitude'))
                }

                if (!longitude.val()) {
                    longitude.val(localStorage.getItem('longitude'))
                }
            }

            function getCodeFromValue(value) {
                // Hàm này nhận một giá trị của dropdown và trả về mã code nếu có
                if (value) {
                    let myArray = value.split('-');
                    return myArray.length > 2 ? myArray[2] : '';
                }
                return '';
            }
        });

    </script>
    <script>
        $(document).ready(function () {
            $('.up-date-button').on('click', function () {
                const headers = {
                    'Authorization': `Bearer ${token}`
                };
                let province = $('#province_id').val();
                let myProvince = [];
                if (province) {
                    myProvince = province.split('-');
                }

                let district = $('#district_id').val();
                let myDistrict = [];
                if (district) {
                    myDistrict = district.split('-');
                }

                let commune = $('#commune_id').val();
                let myCommune = [];
                if (commune) {
                    myCommune = commune.split('-');
                }


                const formData = new FormData();

                const arrFieldEmpty = [
                    "hospital_facilities", "hospital_equipment", "hospital_information", "combined_address",
                ];

                const arrFieldEmptyChecked = [
                    "emergency", "insurance", "parking",
                ];

                const arrField = [
                    "name", "phone", "costs", "longitude", "latitude", "address_detail",
                    "email", "province_id", "district_id", "commune_id",
                    "open_date", "close_date", "user_id", "time_work", "type", "status",
                    "clinics_service", "departments", "symptoms", "representative_doctor",
                ];

                arrFieldEmptyChecked.forEach(data => {
                    let checked = document.getElementById(data).checked;
                    if (checked) {
                        formData.append(data, $(`#${data}`).val());
                    }
                });

                arrFieldEmpty.forEach(data => {
                    formData.append(data, $(`#${data}`).val());
                });

                let isValid = true
                /* Tạo fn appendDataForm ở admin blade */
                isValid = appendDataForm(arrField, formData, isValid);

                const fieldTextareaTiny = [
                    'introduce'
                ];

                fieldTextareaTiny.forEach(fieldTextarea => {
                    const content = tinymce.get(fieldTextarea).getContent();
                    if (!content) {
                        isValid = false;
                    }
                    formData.append(fieldTextarea, content);
                });

                let filedata = document.getElementById("gallery");
                let i = 0, len = filedata.files.length, img, reader, file;
                for (i; i < len; i++) {
                    file = filedata.files[i];
                    formData.append('gallery[]', file);
                }

                if (!isValid) {
                    alert('Please enter input require!')
                    return;
                }

                try {
                    $.ajax({
                        url: `{{route('api.backend.clinics.edit',$clinic->id)}}`,
                        method: 'POST',
                        headers: headers,
                        contentType: false,
                        cache: false,
                        processData: false,
                        data: formData,
                        success: function (response) {
                            alert('Update success!');
                            window.location.href = `{{route('homeAdmin.list.clinics')}}`;
                        },
                        error: function (xhr) {
                            if (xhr.status === 400) {
                                alert(xhr.responseJSON.message);
                            } else {
                                alert('Update error! Please try again!');
                            }
                            console.log(xhr);
                        }
                    });
                } catch (error) {
                    console.log(error);
                    alert('Error! Please try again!');
                }
            })
        })
    </script>
    <script>
        let province_id;
        let list_address = `{{ $clinic->address }}`;
        console.log(list_address)
        let arrayAddress = list_address.split(',');
        var filtered = arrayAddress.filter(function (el) {
            return el != null;
        });
        if (filtered.length > 3) {
            province_id = filtered[1];
        } else {
            province_id = filtered[0];
        }

        $(document).ready(function () {
            callGetAllProvince();

            $('#province_id').on('change', function () {
                let id_code = $(this).val();
                let myArray = id_code.split('-');
                let code = myArray[1];
                callGetAllDistricts(code);
            })

            $('#district_id').on('change', function () {
                let id_code = $(this).val();
                let myArray = id_code.split('-');
                let code = myArray[1];
                callGetAllCommunes(code);
            })
        })

        async function callGetAllProvince() {
            await $.ajax({
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
            await $.ajax({
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
            await $.ajax({
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
                let isCheck = '';
                if (province_id == data.id) {
                    isCheck = 'selected';
                }
                let code = data.code;
                html = html + `<option class="province province-item"  ${isCheck}  data-code="${code}" value="${data.id}-${data.code}-${data.name}">${data.name}</option>`;
            }

            $('#province_id').empty().append(html);
        }

        function showAllDistricts(res) {
            let html = ``;
            for (let i = 0; i < res.length; i++) {
                let data = res[i];
                html = html + `<option class="district district-item" value="${data.id}-${data.code}-${data.name}">${data.name}</option>`;
            }
            $('#district_id').empty().append(html);
        }

        function showAllCommunes(res) {
            let html = ``;
            for (let i = 0; i < res.length; i++) {
                let data = res[i];
                html = html + `<option value="${data.id}-${data.code}-${data.name}">${data.name}</option>`;
            }
            $('#commune_id').empty().append(html);
        }

        function addNewAddress() {
            var newAddress = document.getElementById('combined_address').value;

            if (newAddress) {
                var geocoder = new google.maps.Geocoder();
                geocoder.geocode({'address': newAddress}, function (results, status) {
                    if (status == google.maps.GeocoderStatus.OK) {
                        var latitude = results[0].geometry.location.lat();
                        var longitude = results[0].geometry.location.lng();

                        if (!isNaN(latitude) && !isNaN(longitude)) {
                            $('#latitude').val(latitude);
                            $('#longitude').val(longitude);
                        }
                    }
                });
            }
        }
    </script>
    <script>
        let arrayItem = [];
        let arrayNameCategory = [];

        function removeArray(arr) {
            var what, a = arguments, L = a.length, ax;
            while (L > 1 && arr.length) {
                what = a[--L];
                while ((ax = arr.indexOf(what)) !== -1) {
                    arr.splice(ax, 1);
                }
            }
            return arr;
        }

        function getListName(array, items) {
            for (let i = 0; i < items.length; i++) {
                if (items[i].checked) {
                    if (array.length == 0) {
                        array.push(items[i].nextElementSibling.innerText);
                    } else {
                        let name = array.includes(items[i].nextElementSibling.innerText);
                        if (!name) {
                            array.push(items[i].nextElementSibling.innerText);
                        }
                    }
                } else {
                    removeArray(array, items[i].nextElementSibling.innerText)
                }
            }
            return array;
        }

        function checkArray(array, listItems) {
            for (let i = 0; i < listItems.length; i++) {
                if (listItems[i].checked) {
                    if (array.length == 0) {
                        array.push(listItems[i].value);
                    } else {
                        let check = array.includes(listItems[i].value);
                        if (!check) {
                            array.push(listItems[i].value);
                        }
                    }
                } else {
                    removeArray(array, listItems[i].value);
                }
            }
            return array;
        }

        function getInputService() {
            let items = document.getElementsByClassName('service_clinic_item');

            arrayItem = checkArray(arrayItem, items);
            arrayNameCategory = getListName(arrayNameCategory, items)

            let listName = arrayNameCategory.toString();

            if (listName) {
                $('#service_clinic').val(listName);
            }

            arrayItem.sort();
            let value = arrayItem.toString();
            $('#clinics_service').val(value);
        }

        let arrayDepartment = [];
        let arrayNameDepartment = [];

        function getInputDepartment() {
            let items = document.getElementsByClassName('department_item');

            arrayDepartment = checkArray(arrayDepartment, items);
            arrayNameDepartment = getListName(arrayNameDepartment, items)

            let listName = arrayNameDepartment.toString();
            if (listName) {
                $('#department').val(listName);
            }

            arrayDepartment.sort();
            let value = arrayDepartment.toString();
            $('#departments').val(value);
        }

        let arraySymptom = [];
        let arrayNameSymptom = [];

        function getInputSymptom() {
            let items = document.getElementsByClassName('symptom_item');

            arraySymptom = checkArray(arraySymptom, items);
            arrayNameSymptom = getListName(arrayNameSymptom, items)

            let listName = arrayNameSymptom.toString();

            if (listName) {
                $('#symptom').val(listName);
            }

            arraySymptom.sort();
            let value = arraySymptom.toString();
            console.log(value)
            $('#symptoms').val(value);
        }

        getInputService();
        getInputDepartment();
        getInputSymptom();
    </script>
    <script>
        // Thêm sự kiện change cho các checkbox cụ thể
        document.getElementById('emergency').addEventListener('change', function () {
            this.value = this.checked ? 1 : 0;
        });

        document.getElementById('insurance').addEventListener('change', function () {
            this.value = this.checked ? 1 : 0;
        });

        document.getElementById('parking').addEventListener('change', function () {
            this.value = this.checked ? 1 : 0;
        });
    </script>
    <script>
        function checkboxDropdown(el, targetInputId) {
            var $el = $(el);

            function updateHiddenInputValues($dropdown, targetInputId) {
                var result = [];
                var $label = $dropdown.find('.dropdown-label');
                $dropdown.find('.check:checked').each(function () {
                    var labelText = $(this).next('.checkbox-custom-label').text().trim();
                    result.push(labelText);
                });
                $('#' + targetInputId).val(result.join(', '));
            }

            function updateStatus($dropdown) {
                var $label = $dropdown.find('.dropdown-label');
                updateHiddenInputValues($dropdown, $dropdown.attr('data-target'));
                if (!$label.text().trim()) {
                    $label.html('Select Options');
                }
            }

            $el.each(function () {
                var $dropdown = $(this),
                    $label = $dropdown.find('.dropdown-label'),
                    $checkAll = $dropdown.find('.check-all'),
                    $inputs = $dropdown.find('.check');

                $label.on('click', () => {
                    $dropdown.toggleClass('open');
                });

                $checkAll.on('change', function () {
                    var checked = $(this).is(':checked');
                    $inputs.prop('checked', checked);
                    updateStatus($dropdown);
                });

                $inputs.on('change', function () {
                    updateStatus($dropdown);
                });

                $(document).on('click touchstart', e => {
                    if (!$(e.target).closest($dropdown).length) {
                        $dropdown.removeClass('open');
                    }
                });
            });
        }

        checkboxDropdown('.dropdown[data-target="hospital_information"]', 'hospital_information');
        checkboxDropdown('.dropdown[data-target="hospital_facilities"]', 'hospital_facilities');
        checkboxDropdown('.dropdown[data-target="hospital_equipment"]', 'hospital_equipment');
    </script>
    <script>
        $(document).ready(function () {
            loadDataHospitalEquipment();
            loadDataHospitalFacilities();
            loadDataHospitalInformation();

            $('.hospital_equipment_name').on('click', function () {
                loadDataHospitalEquipment();
            });

            $('.hospital_facilities_name').on('click', function () {
                loadDataHospitalFacilities();
            });

            $('.hospital_information_name').on('click', function () {
                loadDataHospitalInformation();
            });
        });


        function loadDataHospitalEquipment() {
            let arrayItem = $('.hospital_equipment_name:checked').map(function () {
                return $(this).val();
            }).get().join(', ');

            $('#hospital_equipment').val(arrayItem);
        }

        function loadDataHospitalFacilities() {
            let arrayItem = $('.hospital_facilities_name:checked').map(function () {
                return $(this).val();
            }).get().join(', ');

            $('#hospital_facilities').val(arrayItem);
        }

        function loadDataHospitalInformation() {
            let arrayItem = $('.hospital_information_name:checked').map(function () {
                return $(this).val();
            }).get().join(', ');
            $('#hospital_information').val(arrayItem);
        }
    </script>
    <script>
        let arrayDoctor = [];
        let arrayNameDoctor = [];

        getInputDoctor();

        function getInputDoctor() {
            let items = document.getElementsByClassName('representative_doctor_item');

            arrayDoctor = checkArray(arrayDoctor, items);
            arrayNameDoctor = getListName(arrayNameDoctor, items)

            let listName = arrayNameDoctor.toString();
            if (listName) {
                $('#representative_doctor_text').val(listName);
            }

            arrayDoctor.sort();
            let value = arrayDoctor.toString();
            $('#representative_doctor').val(value);
        }
    </script>
@endsection
