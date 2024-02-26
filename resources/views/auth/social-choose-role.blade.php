@extends('layouts.master')
@section('title', 'Login Page')
@section('content')
    @include('layouts.partials.header_3')
    <div class="container" style="margin-top: 120px">
        <h3 class="text-center" style="font-weight: 600">Welcome {{$user->name}}</h3>
        <div class="text-center mt-3 mb-3">
            <img loading="lazy" src="{{ $user->avt }}" alt="" style="width:150px;" class="bg-info rounded-circle border">
        </div>
        @if($user->provider_name)
            <form action="{{ route('save.user.login.social') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label for="name">{{ __('home.Name') }}</label>
                        <input type="text" name="name" class="form-control" id="name" value="{{ $user->name }}">
                    </div>
                    <div class="form-group col-md-4">
                        <label for="last_name">{{ __('home.Last name') }}</label>
                        <input type="text" name="last_name" class="form-control" id="last_name"
                               value="{{ $user->last_name }}">
                    </div>
                    <div class="form-group col-md-4">
                        <label for="phone">{{ __('home.PhoneNumber') }}</label>
                        <input required type="text" name="phone" class="form-control" id="phone"
                               value="{{ $user->phone }}">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="username">{{ __('home.Username') }}</label>
                        <input required type="text" name="username" class="form-control" id="username"
                               value="{{ $user->username }}">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="email">{{ __('home.Email') }}</label>
                        <input required type="email" name="email" class="form-control" id="email"
                               value="{{ $user->email }}">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="password">{{ __('home.Password') }}</label>
                        <input required type="password" name="password" class="form-control" id="password">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="passwordConfirm">{{ __('home.Confirm Password') }}</label>
                        <input required type="password" name="passwordConfirm" class="form-control"
                               id="passwordConfirm">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label for="address_code">{{ __('home.AddressCode') }}</label>
                        <input type="text" name="address_code" class="form-control" id="address_code"
                               value="{{ $user->address_code }}">
                    </div>
                    <div class="form-group col-md-4">
                        <label for="type_user_login">{{ __('home.Type Account') }}</label>
                        <select id="type_user_login" name="type" class="form-select">
                            <option value="NORMAL">{{ __('home.Choose...') }}</option>
                            <option value="BUSINESS">{{ __('home.BUSINESS') }}</option>
                            <option value="MEDICAL">{{ __('home.MEDICAL') }}</option>
                            <option value="NORMAL">{{ __('home.NORMAL') }}</option>
                        </select>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="member_user_login">{{ __('home.Member') }}</label>
                        <select id="member_user_login" name="member" class="form-select">
                            <option value="PAITENTS">{{ __('home.PAITENTS') }}</option>
                            <option value="NORMAL_PEOPLE">{{ __('home.NORMAL PEOPLE') }}</option>
                        </select>
                    </div>
                </div>
                <div id="only-medical">

                </div>
                <div id="two-level">

                </div>
                <div id="only-business">

                </div>
                <div class="">
                    <a href="{{ route('home') }}" class="btn btn-secondary float-left">{{ __('home.Back') }}</a>
                    <button type="submit" class="btn btn-primary float-right">{{ __('home.Continue') }}</button>
                </div>
            </form>
        @endif
    </div>
    <script>
        $(document).ready(function () {
            $('#type_user_login').on('change', function () {
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
                        showOnlyBusiness();
                        showRoleOther();
                        break;
                    case 'MEDICAL':
                        html = `<option value="{{\App\Enums\Role::DOCTORS}}">DOCTOR</option>
                                                <option value="{{\App\Enums\Role::PHAMACISTS}}">PHAMACISTS</option>
                                                <option value="{{\App\Enums\Role::THERAPISTS}}">THERAPISTS</option>
                                                <option value="{{\App\Enums\Role::ESTHETICIANS}}">ESTHETICIANS</option>
                                                <option value="{{\App\Enums\Role::NURSES}}">NURSES</option>`;
                        clearAppend();
                        showOnlyMedical();
                        showRoleOther();
                        break;
                    default:
                        html = `<option value="{{\App\Enums\Role::PAITENTS}}">PAITENTS</option>
                                                <option value="{{\App\Enums\Role::NORMAL_PEOPLE}}">NORMAL PEOPLE</option>`;
                        clearAppend();
                        break;
                }
                $('#member_user_login').empty().append(html);
            })

            function showOnlyMedical() {
                let html = ` <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="doctor_name">{{ __('home.Doctor Name') }}</label>
                            <input required type="text" name="doctor_name" class="form-control" id="doctor_name">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="doctor_phone">{{ __('home.Doctor Phone') }}</label>
                            <input required type="text" name="doctor_phone" class="form-control" id="doctor_phone">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="doctor_experience">{{ __('home.Doctor Experience') }}</label>
                            <input required type="number" name="experience" class="form-control" id="doctor_experience">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="doctor_hospital">{{ __('home.Doctor Hospital') }}</label>
                            <input required type="text" name="doctor_hospital" class="form-control" id="doctor_hospital">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="specialized_services">{{ __('home.Specialized Services') }}</label>
                            <input required type="text" name="specialized_services" class="form-control" id="specialized_services">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="services_info">{{ __('home.Services Info') }}</label>
                            <input required type="text" name="services_info" class="form-control" id="services_info">
                        </div>
                    </div>`;
                $('#only-medical').empty().append(html);
            }

            function showOnlyBusiness() {
                let html = `<div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="open_date">{{ __('home.Open Time') }}</label>
                            <input required type="time" name="open_date" class="form-control" id="open_date">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="close_date">{{ __('home.Close Time') }}</label>
                            <input required type="time" name="close_date" class="form-control" id="close_date">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="time_work">{{ __('home.Thời gian làm việc') }}</label>
                            <select class="form-select" id="time_work" name="time_work">
                                <option value="ALL">{{ __('home.All') }}</option>
                                <option value="NONE">{{ __('home.NONE') }}</option>
                                <option value="OFFICE HOURS">{{ __('home.OFFICE HOURS') }}</option>
                                <option value="ONLY AFTERNOON">{{ __('home.ONLY MORNING') }}</option>
                                <option value="ONLY AFTERNOON">{{ __('home.ONLY AFTERNOON') }}</option>
                                <option value="OTHER">{{ __('home.Other') }}</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="address">{{ __('home.Addresses') }}</label>
                            <input required type="text" name="address" class="form-control" id="address">
                        </div>
                        <div class="form-group col-md-3">
                            <label for="representative">{{ __('home.Representative') }}</label>
                            <input required type="text" name="representative" class="form-control" id="representative">
                        </div>
                        <div class="form-group col-md-3">
                            <label for="experience">{{ __('home.Experience') }}</label>
                            <input required type="number" name="experience" class="form-control" id="experience">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <input id="prescription" name="prescription" type="checkbox" value="1">
                            <label for="prescription">{{ __('home.Kê đơn thuốc trực tuyến') }} ?</label>
                        </div>
                        <div class="form-group col-md-4">
                            <input id="free" name="free" type="checkbox" value="1">
                            <label for="free">{{ __('home.Tư vấn miễn phí ') }}?</label>
                        </div>
                    </div>`;
                $('#only-business').empty().append(html);
            }

            function showRoleOther() {
                let html = `<div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="file_upload">{{ __('home.Upload your license') }}</label>
                            <input required type="file" name="file_upload" class="form-control" id="file_upload">
                        </div>
                    </div>`;
                $('#two-level').empty().append(html);
            }

            function clearAppend() {
                $('#two-level').empty();
                $('#only-business').empty();
                $('#only-medical').empty()
            }
        })
    </script>
@endsection
