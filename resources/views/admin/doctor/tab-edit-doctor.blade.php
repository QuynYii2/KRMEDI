@php
    use App\Enums\Role;
@endphp
@extends('layouts.admin')
@section('title')
    {{ __('home.Edit Doctor') }}
@endsection
@section('main-content')
    <link href="{{ asset('css/tabeditdoctor.css') }}" rel="stylesheet">
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">{{ __('home.Edit') }}</h1>
    @if (session('success'))
        <div class="alert alert-success border-left-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
    <form id="form">

        @csrf
        <div class="row">
            <div class="col-lg-4">
                <div class="form-group focused">
                    <label class="form-control-label" for="username">{{ __('home.Username') }}<span
                            class="small text-danger">*</span></label>
                    <input type="text" id="username" class="form-control" name="username"
                           placeholder="{{ __('home.Username') }}"
                           value="{{ $doctor->username }}">
                </div>
            </div>
            <div class="col-lg-4">
                <div class="form-group focused">
                    <label class="form-control-label" for="name">{{ __('home.Name') }}<span
                            class="small text-danger">*</span></label>
                    <input type="text" id="name" class="form-control" name="name" placeholder="{{ __('home.Name') }}"
                           required
                           value="{{ $doctor->name }}">
                </div>
            </div>
            <div class="col-lg-4">
                <div class="form-group focused">
                    <label class="form-control-label"
                           for="last_name">{{ __('home.Last name') }}</label>
                    <input type="text" id="last_name" class="form-control" name="last_name"
                           placeholder="{{ __('home.Last name') }}"
                           value="{{ $doctor->last_name }}">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-4">
                <label for="identifier">{{ __('home.Mã định danh trên giấy hành nghề') }}</label>
                <input type="text" class="form-control" id="identifier" name="identifier"
                       value="{{ $doctor->identifier }}">
            </div>
        </div>

        <div class="row">
            <div class="col-sm-4">
                <div class="form-group">
                    <label class="form-control-label" for="email">{{ __('home.Email address') }}
                        <span
                            class="small text-danger">*</span></label>
                    <input type="email" id="email" class="form-control" name="email"
                           placeholder="example@example.com"
                           value="{{ $doctor->email }}">
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                    <label class="form-control-label" for="phone">{{ __('home.PhoneNumber') }}<span
                            class="small text-danger">*</span></label>
                    <input type="number" id="phone" class="form-control" name="phone"
                           placeholder="{{ __('home.PhoneNumber') }}"
                           value="{{ $doctor->phone }}" required>
                </div>
            </div>
            <div class="col-sm-4">
                <label for="avt">{{ __('home.Ảnh đại diện') }}</label>
                <input type="file" class="form-control" id="avt" name="avt" accept="image/*, .pdf, .doc, .docx">
                <img loading="lazy" src="{{ asset($doctor->avt) }}" alt="" width="80px">
            </div>
        </div>

        <div class="row">
            <div class="form-element col-md-4">
                <label for="password">{{ __('home.Password') }}</label>
                <input class="form-control" id="password" type="password" name="password" minlength="8"
                       placeholder="********" value="" required>
            </div>
            <div class="form-element col-md-4">
                <label for="passwordConfirm">{{ __('home.Enter the Password') }}</label>
                <input class="form-control" id="passwordConfirm" name="passwordConfirm" minlength="8"
                       type="password" placeholder="********" required>
            </div>
            <div class="form-element col-md-4">
                <label for="workspace">{{ __('home.Workplace') }}</label>
                <input class="form-control" id="workspace" type="text" name="workspace" value="{{$doctor->workplace}}">
            </div>
        </div>
        <div class="row">
            <div class="form-element col-md-6">
                <label for="type">{{ __('home.Type Account') }}</label>
                <select id="type" name="type" class="form-select form-control">
                    <option value="{{Role::MEDICAL }}" selected>{{ __('home.MEDICAL') }}</option>
                </select>
            </div>
            <div class="form-element col-md-6">
                <label for="member">{{ __('home.Member') }}</label>
                <select id="member" name="member" class="form-select form-control">
                    <option {{ $doctor->member == Role::DOCTORS ? 'selected' : '' }} value="{{Role::DOCTORS}}"
                            selected>{{ __('home.DOCTOR') }}</option>
                    <option
                        {{ $doctor->member == Role::PHAMACISTS ? 'selected' : '' }} value="{{Role::PHAMACISTS}}">{{ __('home.PHAMACISTS') }}</option>
                    <option
                        {{ $doctor->member == Role::THERAPISTS ? 'selected' : '' }} value="{{Role::THERAPISTS}}">{{ __('home.THERAPISTS') }}</option>
                    <option
                        {{ $doctor->member == Role::ESTHETICIANS ? 'selected' : '' }} value="{{Role::ESTHETICIANS}}">{{ __('home.ESTHETICIANS') }}</option>
                    <option
                        {{ $doctor->member == Role::NURSES ? 'selected' : '' }} value="{{Role::NURSES}}">{{ __('home.NURSES') }}</option>
                </select>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <label for="specialty">{{ __('home.chuyên môn việt') }}</label>
                <input type="text" class="form-control" id="specialty" name="specialty" value="{{$doctor->specialty}}">
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <label for="service">{{ __('home.Dịch vụ cung cấp việt') }}</label>
                <textarea class="form-control" name="service" id="service">{{$doctor->service}}</textarea>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6">
                <label for="service_price">{{ __('home.Giá dịch vụ việt') }}</label>
                <input class="form-control" type="number" name="service_price" id="service_price"
                       value="{{$doctor->service_price}}">
            </div>
            <div class="col-sm-6">
                <label for="detail_address">{{ __('home.địa chỉ chi tiết việt') }}</label>
                <input class="form-control" name="detail_address" id="detail_address"
                       value="{{$doctor->detail_address}}">
            </div>
        </div>
        <div class="row">
            <div class="col-sm-4">
                <label for="province_id">{{ __('home.Tỉnh') }}</label>
                <select name="province_id" id="province_id" class="form-control">

                </select>
            </div>
            <div class="col-sm-4">
                <label for="district_id">{{ __('home.Quận') }}</label>
                @php
                    $district = \App\Models\District::find($doctor->district_id);
                @endphp
                <select name="district_id" id="district_id" class="form-control">
                    <option
                        value="{{$district->id ?? null}}-{{$district->code ?? null}}"> {{$district->name ?? null}}</option>
                </select>
            </div>
            <div class="col-sm-4">
                <label for="commune_id">{{ __('home.Xã') }}</label>
                @php
                    $commune = \App\Models\Commune::find($doctor->commune_id);
                @endphp
                <select name="commune_id" id="commune_id" class="form-control">
                    <option
                        value="{{$commune->id ?? null}}-{{$commune->code ?? null}}">{{$commune->name ?? null}}</option>
                </select>
            </div>
        </div>
        <div class="row">
            @php
                $working1 = $doctor->time_working_1;
                $arrayWorking1 = explode('-', $working1);

                $working2 = $doctor->time_working_2;
                $arrayWorking2 = explode('-', $working2);
            @endphp
            @if(!$working1 == null && !$working2 == null)
                <div class="col-sm-3">
                    <label for="time_working_1_start">{{ __('home.Thời gian làm việc bắt đầu') }}</label>
                    <input type="time" class="form-control" id="time_working_1_start" name="time_working_1_start"
                           value="{{ $arrayWorking1[0] }}">
                </div>
                <div class="col-sm-3">
                    <label for="time_working_1_end">{{ __('home.Thời gian làm việc kết thúc') }}</label>
                    <input type="time" class="form-control" id="time_working_1_end" name="time_working_1_end"
                           value="{{ $arrayWorking1[1] }}">
                </div>
                <div class="col-sm-3">
                    <label for="time_working_2_start">{{ __('home.Những này làm việc bắt đầu') }}</label>
                    <select name="time_working_2_start" id="time_working_2_start" class="form-control">
                        <option
                            {{ $arrayWorking2[0] == 'T2' ? 'selected' : '' }} value="T2">{{ __('home.Thứ 2') }}</option>
                        <option
                            {{ $arrayWorking2[0] == 'T3' ? 'selected' : '' }}  value="T3">{{ __('home.Thứ 3') }}</option>
                        <option
                            {{ $arrayWorking2[0] == 'T4' ? 'selected' : '' }}  value="T4">{{ __('home.Thứ 4') }}</option>
                        <option
                            {{ $arrayWorking2[0] == 'T5' ? 'selected' : '' }}  value="T5">{{ __('home.Thứ 5') }}</option>
                        <option
                            {{ $arrayWorking2[0] == 'T6' ? 'selected' : '' }}  value="T6">{{ __('home.Thứ 6') }}</option>
                        <option
                            {{ $arrayWorking2[0] == 'T7' ? 'selected' : '' }}  value="T7">{{ __('home.Thứ 7') }}</option>
                        <option
                            {{ $arrayWorking2[0] == 'CN' ? 'selected' : '' }}  value="CN">{{ __('home.Chủ nhật') }}</option>
                    </select>
                </div>
                <div class="col-sm-3">
                    <label for="time_working_2_end">{{ __('home.Những này làm việc kết thúc') }}</label>
                    <select name="time_working_2_end" id="time_working_2_end" class="form-control">
                        <option
                            {{ $arrayWorking2[1] == 'T2' ? 'selected' : '' }}  value="T2">{{ __('home.Thứ 2') }}</option>
                        <option
                            {{ $arrayWorking2[1] == 'T3' ? 'selected' : '' }}  value="T3">{{ __('home.Thứ 3') }}</option>
                        <option
                            {{ $arrayWorking2[1] == 'T4' ? 'selected' : '' }}  value="T4">{{ __('home.Thứ 4') }}</option>
                        <option
                            {{ $arrayWorking2[1] == 'T5' ? 'selected' : '' }}  value="T5">{{ __('home.Thứ 5') }}</option>
                        <option
                            {{ $arrayWorking2[1] == 'T6' ? 'selected' : '' }}  value="T6">{{ __('home.Thứ 6') }}</option>
                        <option
                            {{ $arrayWorking2[1] == 'T7' ? 'selected' : '' }}  value="T7">{{ __('home.Thứ 7') }}</option>
                        <option
                            {{ $arrayWorking2[1] == 'CN' ? 'selected' : '' }}  value="CN">{{ __('home.Chủ nhật') }}</option>
                    </select>
                </div>

                <input type="text" class="form-control d-none" id="time_working_1" name="time_working_1">
                <input type="text" class="form-control d-none" id="time_working_2" name="time_working_2">
                <input type="text" class="form-control d-none" id="apply_for" name="apply_for">
            @else
                <div class="col-sm-3">
                    <label for="time_working_1_start">{{ __('home.Thời gian làm việc bắt đầu') }}</label>
                    <input type="time" class="form-control" id="time_working_1_start"
                           name="time_working_1_start"
                           value="00:00">
                </div>
                <div class="col-sm-3">
                    <label for="time_working_1_end">{{ __('home.Thời gian làm việc kết thúc') }}</label>
                    <input type="time" class="form-control" id="time_working_1_end"
                           name="time_working_1_end" value="23:59">
                </div>
                <div class="col-sm-3">
                    <label for="time_working_2_start">{{ __('home.Những này làm việc bắt đầu') }}</label>
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
                <div class="col-sm-3">
                    <label for="time_working_2_end">{{ __('home.Những này làm việc kết thúc') }}</label>
                    <select name="time_working_2_end" id="time_working_2_end" class="form-control">
                        <option value="T2">{{ __('home.Thứ 2') }}</option>
                        <option value="T3">{{ __('home.Thứ 3') }}</option>
                        <option value="T4">{{ __('home.Thứ 4') }}</option>
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
            @endif
        </div>
        <div class="row">

            <div class="col-sm-4"><label for="department_id">{{ __('home.departments') }}</label>
                <select class="form-select" id="department_id" name="department_id">
                    @foreach($departments as $department)
                        <option
                            {{ $department->id == $doctor->department_id ? 'selected' : ''}} value=" {{$department->id}}"> {{$department->name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-sm-4"><label for="status">{{ __('home.Trạng thái') }}</label>
                <select class="form-select" id="status" name="status">
                    <option
                        {{ $doctor->status == \App\Enums\UserStatus::PENDING ? 'selected' : ''}}
                        value="{{ \App\Enums\UserStatus::PENDING }}">
                        {{ \App\Enums\UserStatus::PENDING }}
                    </option>
                    <option
                        {{ $doctor->status == \App\Enums\UserStatus::INACTIVE ? 'selected' : ''}}
                        value="{{ \App\Enums\UserStatus::INACTIVE }}">
                        {{ \App\Enums\UserStatus::INACTIVE }}
                    </option>
                    <option
                        {{ $doctor->status == \App\Enums\UserStatus::ACTIVE ? 'selected' : ''}}
                        value="{{ \App\Enums\UserStatus::ACTIVE }}">
                        {{ \App\Enums\UserStatus::ACTIVE }}
                    </option>
                    <option
                        {{ $doctor->status == \App\Enums\UserStatus::BLOCKED ? 'selected' : ''}}
                        value="{{ \App\Enums\UserStatus::BLOCKED }}">
                        {{ \App\Enums\UserStatus::BLOCKED }}
                    </option>
                    <option
                        {{ $doctor->status == \App\Enums\UserStatus::DELETED ? 'selected' : ''}}
                        value="{{ \App\Enums\UserStatus::DELETED }}">
                        {{ \App\Enums\UserStatus::DELETED }}
                    </option>
                </select>
            </div>
            <div class="col-sm-4">
                <label for="year_of_experience">{{ __('home.Năm kinh nghiệm') }}</label>
                <input type="number" class="form-control" id="year_of_experience" name="year_of_experience"
                       value="{{$doctor->year_of_experience}}">
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

                    $arrayApplyOld = explode(',', $doctor->apply_for);
                @endphp
                <ul class="list-apply">
                    @foreach($arrayApply as $key => $value)
                        <li class="new-select">
                            <input onchange="getInput();" class="apply_item" value="{{$key}}"
                                   id="apply_item_{{$key}}"
                                   name="apply_item"
                                   {{ in_array($key, $arrayApplyOld) ? 'checked' : '' }}
                                   type="checkbox">
                            <label for="apply_item_{{$key}}">{{$value}}</label>
                        </li>
                    @endforeach
                </ul>
            </div>
            <input hidden="" id="address_code" name="address_code" value="{{$doctor->address_code ?? 'code_default'}}">
            <input hidden="" id="update_by" name="update_by" value="{{Auth::user()->id}}">
        </div>
        <div class="row">
            <div class="col-sm-12">
                <label for="about_vn">{{ __('home.About') }}</label>
                <textarea class="form-control" id="about_vn" rows="3">{{ $doctor->abouts }}</textarea>
            </div>
        </div>
        <button type="button" class="btn btn-primary up-date-button mt-md-4">Lưu</button>
    </form>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script>
        $(document).ready(function () {
            $('.up-date-button').on('click', function () {
                const headers = {
                    'Authorization': `Bearer ${token}`,
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                };
                const formData = new FormData();
                const fieldNames = [
                    "specialty", "workspace", "identifier", "service_price", "detail_address",
                    "province_id", "district_id", "commune_id", "time_working_1", "time_working_2",
                    "apply_for", "address_code", "update_by", "name", "year_of_experience", "status",
                    "department_id", "username", "email", "phone", "last_name", "member", "type"
                ];

                const passwords = [
                    "password", "passwordConfirm",
                ];

                const fieldTextareaTiny = [
                    "service", "about_vn",
                ];

                passwords.forEach(fieldName => {
                    formData.append(fieldName, $(`#${fieldName}`).val());
                });

                fieldNames.forEach(fieldName => {
                    console.log(fieldName, $(`#${fieldName}`).val());
                });

                let isValid = true
                /* Tạo fn appendDataForm ở admin blade */
                isValid = appendDataForm(fieldNames, formData, isValid);

                /* Temporary don't use tinymce because this was error
                *  and move the necessary ids(service, service_en, service_laos) to fieldNames array*/
                fieldTextareaTiny.forEach(fieldTextarea => {
                    const content = tinymce.get(fieldTextarea).getContent();
                    if (!content) {
                        isValid = false;
                        let labelElement = $(`label[for='${fieldTextarea}']`);
                        let text = labelElement.text();
                        if (!text) {
                            text = 'The input'
                        }
                        text = text + ' not empty!'
                        alert(text);
                        return;
                    }
                    formData.append(fieldTextarea, content);
                });

                formData.append("apply_for", $('#apply_for').val());
                const photo = $('#avt')[0].files[0];
                formData.append('avt', photo);
                formData.append('_token', '{{ csrf_token() }}');
                formData.append("user_id", '{{ \Illuminate\Support\Facades\Auth::user()->id }}');

                if (!isValid) {
                    alert('Please check input not empty!')
                    return;
                }

                try {
                    $.ajax({
                        url: `{{route('api.backend.doctors.info.update.doctor', ['id' => $doctor->id])}}`,
                        method: 'post',
                        headers: headers,
                        contentType: false,
                        cache: false,
                        processData: false,
                        data: formData,
                        success: function () {
                            alert('Update success!');
                            window.location.href = '{{route('homeAdmin.list.doctors')}}';
                        },
                        error: function (exception) {
                            console.log(exception);
                            alert('Update error!');
                        }
                    });
                } catch (error) {
                    console.log(error);
                    alert('Error, Please try again!');
                }
            })

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

            function setDataForTime(time_working_start, time_working_end, merge) {
                let value_start = $('#' + time_working_start).val();
                let value_end = $('#' + time_working_end).val();
                let mergeValue = value_start + '-' + value_end;
                $('#' + merge).val(mergeValue);
            }
        })
    </script>
    <script>
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
                let province_id = `{{ $doctor->province_id }}`;
                let supHtml = '';
                if (province_id == data.id) {
                    supHtml = 'selected';
                }
                html = html + `<option ${supHtml} class="province province-item" data-code="${code}" value="${data.id}-${data.code}">${data.name}</option>`;
            }

            $('#province_id').empty().append(html);
        }

        function showAllDistricts(res) {
            let html = ``;
            for (let i = 0; i < res.length; i++) {
                let data = res[i];
                html = html + `<option class="district district-item" value="${data.id}-${data.code}">${data.name}</option>`;
            }
            $('#district_id').empty().append(html);
        }

        function showAllCommunes(res) {
            let html = ``;
            for (let i = 0; i < res.length; i++) {
                let data = res[i];
                html = html + `<option value="${data.id}-${data.code}">${data.name}</option>`;
            }
            $('#commune_id').empty().append(html);
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

        getInput();
    </script>
@endsection
