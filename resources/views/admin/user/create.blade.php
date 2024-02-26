@extends('layouts.admin')
@section('title')
    Create User
@endsection
@section('main-content')
    <div class="">
        <!-- Page Heading -->
        <h1 class="h3 mb-4 text-gray-800"> Create User </h1>
        <div class="container-fluid">
            <form method="POST" autocomplete="off" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-md-4 form-group">
                        <label class="form-control-label" for="username">{{ __('home.Username') }}
                            <span class="small text-danger">*</span>
                        </label>
                        <input type="text" id="username" class="form-control" name="username" placeholder="Username"
                               required value="">
                    </div>
                    <div class="col-md-4 form-group">
                        <label class="form-control-label" for="name">{{ __('home.Name') }}
                            <span class="small text-danger">*</span>
                        </label>
                        <input type="text" id="name" class="form-control" name="name" placeholder="Name" required
                               value="">
                    </div>
                    <div class="col-md-4 form-group">
                        <label class="form-control-label" for="last_name">{{ __('home.Last name') }}</label>
                        <input type="text" id="last_name" class="form-control" name="last_name"
                               placeholder="Last name" required value="">
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-md-4">
                        <label class="form-control-label" for="email">{{ __('home.Email address') }}
                            <span class="small text-danger">*</span>
                        </label>
                        <input type="email" id="email" class="form-control" name="email"
                               placeholder="example@example.com" required value="">
                    </div>
                    <div class="form-group col-md-4">
                        <label class="form-control-label" for="phone">{{ __('home.PhoneNumber') }}
                            <span class="small text-danger">*</span>
                        </label>
                        <input type="number" id="phone" class="form-control" name="phone" placeholder="Phone"
                               value="" required>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="avt">{{ __('home.Ảnh đại diện') }} </label>
                        <input type="file" class="form-control" id="avt" name="avt" accept="image/*">
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-md-6">
                        <label class="form-control-label" for="password">{{ __('home.New password') }}
                            <span class="small text-danger">*</span>
                        </label>
                        <input type="password" id="password" class="form-control" name="password"
                               placeholder="{{ __('home.New password') }}">
                    </div>
                    <div class="form-group col-md-6">
                        <label class="form-control-label"
                               for="passwordConfirm">{{ __('home.Confirm Password') }}
                            <span class="small text-danger">*</span>
                        </label>
                        <input type="password" id="passwordConfirm" class="form-control"
                               name="passwordConfirm" placeholder="{{ __('home.Confirm Password') }}">
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-4">
                        <label for="detail_address">{{ __('home.địa chỉ chi tiết việt') }}</label>
                        <input class="form-control" name="detail_address" id="detail_address" value="">
                    </div>
                    <div class="form-group col-md-4">
                        <label for="detail_address_en">{{ __('home.địa chỉ chi tiết anh') }}</label>
                        <input class="form-control" name="detail_address_en" id="detail_address_en" value="">
                    </div>
                    <div class="form-group col-md-4">
                        <label for="detail_address_laos">{{ __('home.địa chỉ chi tiết lào') }}</label>
                        <input class="form-control" name="detail_address_laos" id="detail_address_laos" value="">
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-4">
                        <label for="province_id">{{ __('home.Tỉnh') }}</label>
                        <select name="province_id" id="province_id" class="form-control form-select"
                                onchange="callGetAllDistricts($('#province_id').find(':selected').data('code'))">
                        </select>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="district_id">{{ __('home.Quận') }}</label>
                        <select name="district_id" id="district_id" class="form-control form-select"
                                onchange="callGetAllCommunes($('#district_id').find(':selected').data('code'))">
                            <option value="">{{ __('home.Chọn quận') }}</option>
                        </select>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="commune_id">{{ __('home.Xã') }}</label>
                        <select name="commune_id" id="commune_id" class="form-control form-select">
                            <option value="">{{ __('home.Chọn xã') }}</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-3">
                        <label class="form-control-label" for="address_code">{{ __('home.AddressCode') }}</label>
                        <input type="text" id="address_code" class="form-control" name="address_code"
                               placeholder="ha_noi" value="" required>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="type">{{ __('home.Type Account') }}</label>
                        <select id="type" name="type" class="form-select form-control">
                            <option value="NORMAL">Choose...</option>
                            <option value="BUSINESS">{{ __('home.BUSINESS') }}</option>
                            <option value="MEDICAL">{{ __('home.MEDICAL') }}</option>
                            <option value="NORMAL">{{ __('home.NORMAL') }}</option>
                        </select>
                    </div>
                    <div class="form-group col-md-3">
                        <label class="form-control-label" for="member">{{ __('home.Member') }}<span
                                class="small text-danger">*</span></label>
                        <select id="member" name="member" class="form-control form-select">
                            <option value="PAITENTS">{{ __('home.PAITENTS') }}</option>
                            <option value="NORMAL_PEOPLE">{{ __('home.NORMAL PEOPLE') }}</option>
                        </select>
                    </div>
                    <div class="form-group col-md-3">
                        <label class="form-control-label" for="status">{{ __('home.Status') }}</label>
                        <select id="status" name="status" class="form-control form-select">
                            <option value="ACTIVE">ACTIVE</option>
                            <option value="INACTIVE">INACTIVE</option>
                        </select>
                    </div>
                </div>

                <!-- Normal -->
                <div class="only-normal" id="only_normal">
                    <div class="form-group">
                        <label for="medical_history">{{ __('home.Tiền sử bệnh án') }}</label>
                        <textarea id="medical_history" class="form-control" name="medical_history"></textarea>
                    </div>
                </div>

                <div id="two_level">

                </div>

                <!-- Medical -->
                <div class="only-medical" id="only_medical">

                </div>

                <!-- Business -->
                <div class="only-business" id="only_business">

                </div>

                <!-- Button -->
                <div class="pl-md-4 mt-4">
                    <div class="row">
                        <div class="col text-center">
                            <button type="button" id="btnCreateUser"
                                    class="btn btn-primary">{{ __('home.create') }}</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <script>
        let accessToken = `Bearer ` + token;
        let headers = {
            "Authorization": accessToken
        };

        $(document).ready(function () {
            $('#type').on('change', function () {
                let value = $(this).val();
                let html = ``;
                switch (value) {
                    case 'BUSINESS':
                        html = `<option value="{{\App\Enums\Role::PHARMACEUTICAL_COMPANIES}}">PHARMACEUTICAL COMPANIES</option>
                                                <option value="{{\App\Enums\Role::HOSPITALS}}">HOSPITALS</option>
                                                <option value="{{\App\Enums\Role::CLINICS}}">CLINICS</option>
                                                <option value="{{\App\Enums\Role::PHARMACIES}}">PHARMACIES</option>
                                                <option value="{{\App\Enums\Role::SPAS}}">SPAS</option>
                                                <option value="{{\App\Enums\Role::OTHERS}}">OTHERS</option>`;
                        clearAppend();
                        showRoleOther();
                        showOnlyBusiness();
                        break;
                    case 'MEDICAL':
                        html = `<option value="{{\App\Enums\Role::DOCTORS}}">DOCTOR</option>
                                                <option value="{{\App\Enums\Role::PHAMACISTS}}">PHAMACISTS</option>
                                                <option value="{{\App\Enums\Role::THERAPISTS}}">THERAPISTS</option>
                                                <option value="{{\App\Enums\Role::ESTHETICIANS}}">ESTHETICIANS</option>
                                                <option value="{{\App\Enums\Role::NURSES}}">NURSES</option>`;
                        clearAppend();
                        showRoleOther();
                        showOnlyMedical();
                        break;
                    default:
                        html = `<option value="{{\App\Enums\Role::PAITENTS}}">PAITENTS</option>
                                                <option value="{{\App\Enums\Role::NORMAL_PEOPLE}}">NORMAL PEOPLE</option>`;
                        clearAppend();
                        showOnlyNormal();
                        break;
                }
                $('#member').empty().append(html);
            })

            $('#btnCreateUser').on('click', function () {
                createUser();
            })
        })
    </script>
    {{-- Create new user --}}
    <script>
        async function createUser() {
            const formData = new FormData();

            let checking = true;

            const array_default = ['username', 'name', 'last_name',
                'email', 'phone', 'password', 'passwordConfirm',
                'detail_address', 'detail_address_en', 'detail_address_laos',
                'province_id', 'district_id', 'commune_id', 'address_code',
                'type', 'member', 'status',]

            const array_empty_normal = ['medical_history',]

            const array_medical = ['specialty', 'specialty_en', 'specialty_laos','identifier',
                'service', 'service_en', 'service_laos', "workspace",
                'service_price', 'service_price_en', 'service_price_laos',
                'time_working_1', 'time_working_2', 'apply_for',
                'department_id', 'year_of_experience',]

            const array_empty_medical = ['prescription', 'free',]

            let avt = $('#avt')[0].files[0];
            formData.append('avt', avt);

            let isValid = true
            /* Tạo fn appendDataForm ở admin blade*/
            isValid = appendDataForm(array_default, formData, isValid);

            if ($('#type').val() === 'MEDICAL') {
                isValid = appendDataForm(array_medical, formData, isValid);

                let file_upload = $('#file_upload')[0].files[0];
                if (!file_upload) {
                    isValid = false;
                    checking = false;
                }
                formData.append('file_upload', file_upload);

                array_empty_medical.forEach(field => {
                    let checked = document.getElementById(field).checked;
                    if (checked) {
                        formData.append(field, $(`#${field}`).val());
                    }
                });
            }

            array_empty_normal.forEach(field => {
                formData.append(field, $(`#${field}`).val());
            });

            let createUserUrl = `{{ route('api.admin.users.create') }}`;
            if (!isValid) {
                if (!checking) {
                    alert('Please upload your license!')
                }
                return;
            }

            try {
                await $.ajax({
                    url: createUserUrl,
                    method: 'POST',
                    headers: headers,
                    contentType: false,
                    cache: false,
                    processData: false,
                    data: formData,
                    success: function (response) {
                        alert('Create success!');
                        window.location.href = `{{ route('view.admin.user.list') }}`;
                    },
                    error: function (error) {
                        alert(error.responseJSON.message);
                    }
                });
            } catch (e) {
                alert('Create error!');
            }
        }
    </script>
    {{-- Append form element follow type account --}}
    <script>
        function showOnlyBusiness() {
            let html = ``;
            $('#only_business').empty().append(html);
        }

        function showOnlyMedical() {
            let html = `<h1>Info doctor</h1>
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label for="specialty">{{ __('home.chuyên môn việt') }}</label>
                                <input type="text" class="form-control" id="specialty" name="specialty" value="">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="specialty_en">{{ __('home.chuyên môn anh') }}</label>
                                <input type="text" class="form-control" id="specialty_en" name="specialty_en" value="">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="specialty_laos">{{ __('home.chuyên môn lào') }}</label>
                                <input type="text" class="form-control" id="specialty_laos" name="specialty_laos"
                                       value="">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-4">
                                <label for="identifier">{{ __('home.Mã định danh trên giấy hành nghề') }}</label>
                                <input type="text" class="form-control" id="identifier" name="identifier" value="">
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label for="service">{{ __('home.Dịch vụ cung cấp việt') }}</label>
                                <textarea class="form-control" name="service" id="service"></textarea>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="service_en">{{ __('home.Dịch vụ cung cấp anh') }}</label>
                                <textarea class="form-control" name="service_en" id="service_en"></textarea>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="service_laos">{{ __('home.Dịch vụ cung cấp lào') }}</label>
                                <textarea class="form-control" name="service_laos" id="service_laos"></textarea>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label for="service_price">{{ __('home.Giá dịch vụ việt') }}</label>
                                <input class="form-control" type="number" name="service_price" id="service_price"
                                       value="">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="service_price_en">{{ __('home.Giá dịch vụ anh') }}</label>
                                <input class="form-control" type="number" name="service_price_en" id="service_price_en"
                                       value="">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="service_price_laos">{{ __('home.Giá dịch vụ lào') }}</label>
                                <input class="form-control" type="number" name="service_price_laos"
                                       id="service_price_laos" value="">
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-3">
                                <label for="time_working_1_start">{{ __('home.Thời gian làm việc bắt đầu') }}</label>
                                <input type="time" class="form-control" id="time_working_1_start"
                                       name="time_working_1_start" value="00:00">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="time_working_1_end">{{ __('home.Thời gian làm việc kết thúc') }}</label>
                                <input type="time" class="form-control" id="time_working_1_end"
                                       name="time_working_1_end" value="23:59">
                            </div>
                            <div class="form-group col-md-3">
                                <label
                                    for="time_working_2_start">{{ __('home.Addresses') }}{{ __('home.Những này làm việc bắt đầu') }}</label>
                                <select name="time_working_2_start" id="time_working_2_start" class="form-control">
                                    <option value="T2">{{ __('home.Thứ 2') }}</option>
                                    <option value="T3">{{ __('home.Thứ 3') }}</option>
                                    <option value="T4">{{ __('home.Thứ 4') }}</option>
                                    <option value="T5">{{ __('home.Thứ 5') }}</option>
                                    <option value="T6">{{ __('home.Thứ 6') }}</option>
                                    <option value="T7">{{ __('home.Thứ 7') }}</option>
                                    <option value="CN">{{ __('home.Chủ nhật') }}</option>
                                </select>
                            </div>
                            <div class="form-group col-md-3">
                                <label
                                    for="time_working_2_end">{{ __('home.Những này làm việc kết thúc') }}</label>
                                <select name="time_working_2_end" id="time_working_2_end"
                                        class="form-control">
                                    <option value="T2">{{ __('home.Thứ 2') }}</option>
                                    <option value="T3">{{ __('home.Thứ 3') }}</option>
                                    <option value="T4">{{ __('home.Thứ 4') }}></option>
                                    <option value="T5">{{ __('home.Thứ 5') }}</option>
                                    <option value="T6">{{ __('home.Thứ 6') }}</option>
                                    <option value="T7">{{ __('home.Thứ 7') }}</option>
                                    <option value="CN">{{ __('home.Chủ nhật') }}</option>
                                </select>
                            </div>

                            <input type="text" class="form-control d-none" id="time_working_1"
                                   name="time_working_1">
                            <input type="text" class="form-control d-none" id="time_working_2"
                                   name="time_working_2">
                            <input type="text" class="form-control d-none" id="apply_for" name="apply_for">
                        </div>
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label for="department_id">{{ __('home.Department') }}</label>
                                <select class="form-select" id="department_id" name="department_id">
                                    @foreach($departments as $department)
            <option value="{{$department->id}}" data-limit="300"
                                                      class="text-shortcut">
                                                            {{$department->name}}
            </option>
@endforeach
            </select>
        </div>
        <div class="form-group col-md-4">
            <label for="year_of_experience">{{ __('home.Năm kinh nghiệm') }}</label>
                                <input type="number" class="form-control" max="80" id="year_of_experience"
                                       name="year_of_experience" value="">
                            </div>
                            <div class="form-element col-md-4">
                <label for="workspace">{{ __('home.Workplace') }}</label>
                <input class="form-control" id="workspace" type="text" name="workspace">
            </div>
                        </div>
                        <div class="row">
                            <div class="form-group">
                                <input name="prescription" type="checkbox" id="prescription" value="1">
                                <label for="prescription">{{ __('home.prescription') }}</label>
                            </div>
                            <div class="form-group">
                                <input name="free" type="checkbox" id="free" value="1">
                                <label for="free">{{ __('home.free') }}</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="apply_show">{{ __('home.Apply Show') }}</label>
                            <input type="text" class="form-control" id="apply_show" name="apply_show" disabled>
                            @php
                $arrayApply = [
                    'name'=> 'Name',
                    'response_rate'=> 'Response Rate',
                    'specialty'=> 'Specialty',
                    'year_of_experience'=> 'Years of experience',
                    'service'=> 'Service',
                    'service_price'=> 'Service Price',
                    'time_working_1'=> 'Time Working',
                    'time_working_2'=> 'Date Working',
                ];
            @endphp
            <ul class="list-apply">
@foreach($arrayApply as $key => $value)
            <li class="new-select">
                <input onchange="getInput();" class="apply_item" value="{{$key}}"
                                                                   id="apply_item_{{$key}}"
                                                                   name="apply_item"
                                                                   type="checkbox">
                                                        <label for="apply_item_{{$key}}">{{$value}}</label>
                                                    </li>
                            @endforeach
            </ul>
        </div>`;
            $('#only_medical').empty().append(html);

            handleTimeOne();
        }

        function showRoleOther() {
            let html = `<div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="file_upload">{{ __('home.Upload your license') }}</label>
                            <input required type="file" name="file_upload" class="form-control" accept="image/*" id="file_upload">
                        </div>
                    </div>`;
            $('#two_level').empty().append(html);
        }

        function showOnlyNormal() {
            let html = `<div class="form-group">
                        <label for="medical_history">{{ __('home.Tiền sử bệnh án') }}</label>
                        <textarea id="medical_history" class="form-control" name="medical_history"></textarea>
                    </div>`;
            $('#only_normal').empty().append(html);
        }

        function clearAppend() {
            $('#only_normal').empty();
            $('#two_level').empty();
            $('#only_medical').empty();
            $('#only_business').empty();
        }
    </script>
    {{-- Handle input --}}
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

        function getInput() {
            let items = document.getElementsByClassName('apply_item');

            arrayItem = checkArray(arrayItem, items);
            arrayNameCategory = getListName(arrayNameCategory, items)

            let listName = arrayNameCategory.toString();

            if (listName) {
                $('#apply_show').val(listName);
            }

            arrayItem.sort();
            let value = arrayItem.toString();
            $('#apply_for').val(value);
        }

        function handleTimeOne() {
            setDataForTime('time_working_1_start', 'time_working_1_end', 'time_working_1');
            setDataForTime('time_working_2_start', 'time_working_2_end', 'time_working_2');

            $('#time_working_1_start').on('change', function () {
                setDataForTime('time_working_1_start', 'time_working_1_end', 'time_working_1')
            })

            $('#time_working_1_end').on('change', function () {
                setDataForTime('time_working_1_start', 'time_working_1_end', 'time_working_1')
            })

            $('#time_working_2_start').on('change', function () {
                setDataForTime('time_working_2_start', 'time_working_2_end', 'time_working_2')
            })

            $('#time_working_2_end').on('change', function () {
                setDataForTime('time_working_2_start', 'time_working_2_end', 'time_working_2')
            })
        }

        function setDataForTime(time_working_start, time_working_end, merge) {
            let value_start = $('#' + time_working_start).val();
            let value_end = $('#' + time_working_end).val();
            let mergeValue = value_start + '-' + value_end;
            $('#' + merge).val(mergeValue);
        }

    </script>
    {{-- Load list address --}}
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
