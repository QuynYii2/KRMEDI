@php
    use Illuminate\Support\Facades\Auth;
    use App\Http\Controllers\MainController;
@endphp
@extends('layouts.admin')
@section('title')
    {{ __('home.Profile') }}
@endsection
@section('main-content')
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
    <link href="{{ asset('css/profile.css') }}" rel="stylesheet">
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">{{ __('home.Profile') }}</h1>

    @if (session('success'))
        <div class="alert alert-success border-left-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
    @if ($errors->any())
        <div class="alert alert-danger border-left-danger" role="alert">
            <ul class="pl-4 my-2">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="row">

        <div class="col-lg-4 order-lg-2">

            <div class="card shadow mb-4">
                <div class="card-profile-image mt-4 d-flex justify-content-center">
                    <img loading="lazy" class="avatar-user" src="{{ Auth::user()->avt }}" alt=""
                        style="width: 100px; height: 100px; object-fit: cover;">
                </div>
                <div class="card-body">

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="text-center">
                                <h5 class="font-weight-bold">{{ Auth::user()->username }}</h5>
                                <p>{{ Auth::user()->points }} points</p>
                            </div>
                            <div class="d-flex justify-content-center align-items-center">
                                <div class="mr-3 ml-3">
                                    <a href="#" class="p-2 m-1" style="font-size: 24px">
                                        <i class="fa-solid fa-book-medical"></i>
                                    </a>
                                    <p class="small">{{ __('home.Booking') }}</p>
                                </div>
                                <div class="mr-3 ml-3">
                                    <a href="#" class="p-2 m-1" style="font-size: 24px">
                                        <i class="fa-solid fa-comment-medical"></i>
                                    </a>
                                    <p class="small">{{ __('home.Mentoring') }}</p>
                                </div>
                                <div class="mr-3 ml-3">
                                    <a href="#" class="p-2 m-1" style="font-size: 24px">
                                        <i class="fa-solid fa-ticket"></i>
                                    </a>
                                    <p class="small">{{ __('home.Voucher') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            @if (Auth::user()->member == 'DOCTORS')
                <div class="card shadow mb-4">
                    <div class="card-body">
                        <h6 class="card-title">Chữ ký của bạn</h6>
                        <img id="signatureImg" src="{{ Auth::user()->signature }}" alt="Signature"></br>
                        <div class="d-flex justify-content-around">
                            <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal"
                                data-bs-target="#signatureModal">Sửa chữ ký</button>
                        </div>
                    </div>
                </div>
            @endif

            <div class="card shadow mb-4">
                <div class="card-body">
                    <form>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1"><i
                                        class="fa-brands fa-facebook w-icon-px"></i></span>
                            </div>
                            <label for="facebook"></label><input type="text" class="form-control" id="facebook"
                                name="facebook" value="{{ $socialUser->facebook ?? '' }}">
                        </div>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1"><i
                                        class="fa-brands fa-tiktok w-icon-px"></i></span>
                            </div>
                            <label for="tiktok"></label><input type="text" class="form-control" id="tiktok"
                                name="tiktok" value="{{ $socialUser->tiktok ?? '' }}">
                        </div>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1"><i
                                        class="fa-brands fa-instagram"></i></span>
                            </div>
                            <label for="instagram"></label><input type="text" class="form-control" id="instagram"
                                name="instagram" value="{{ $socialUser->instagram ?? '' }}">
                        </div>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1"><i class="fa-brands fa-google"></i></span>
                            </div>
                            <label for="google_review"></label><input type="text" class="form-control"
                                id="google_review" name="google_review" value="{{ $socialUser->google_review ?? '' }}">
                        </div>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1"><i
                                        class="fa-brands fa-youtube w-icon-px"></i></span>
                            </div>
                            <label for="youtube"></label><input type="text" class="form-control" id="youtube"
                                name="youtube" value="{{ $socialUser->youtube ?? '' }}">
                        </div>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1"><i
                                        class="fa-solid fa-hashtag"></i></span>
                            </div>
                            <label for="other"></label><input type="text" class="form-control" id="other"
                                name="other" value="{{ $socialUser->other ?? '' }}">
                        </div>

                        <input type="hidden" id="user_id" name="user_id" value="{{ Auth::user()->id }}">
                        <button type="button" class="btn btn-primary"
                            onclick="submitForm()">{{ __('home.Submit') }}</button>
                    </form>
                </div>
            </div>

            @if(Auth::user()->member == "HOSPITALS" || Auth::user()->member == "CLINICS")
            <div class="card shadow mb-4">
                <div class="card-body">
                    <h3 class="text-center bold">My QrCode</h3>
                    <div class="text-center">
                        {!! $qrCodes !!}
                    </div>
                </div>
            </div>
                @endif
        </div>

        <div class="col-lg-8 order-lg-1">

            <div class="card shadow mb-4">
                @php
                    $memberMappings = [
                        \App\Enums\TypeUser::PAITENTS => 'Người dùng',
                        \App\Enums\TypeUser::NORMAL_PEOPLE => 'Người dùng',
                        \App\Enums\TypeUser::PHARMACEUTICAL_COMPANIES => 'Công ty dược phẩm',
                        \App\Enums\TypeUser::SPAS => 'SPAS',
                        \App\Enums\TypeUser::OTHERS => 'OTHERS',
                        \App\Enums\TypeUser::DOCTORS => 'Bác sĩ',
                        \App\Enums\TypeUser::THERAPISTS => 'Nhà trị liệu',
                        \App\Enums\TypeUser::ESTHETICIANS => 'Chuyên viên thẩm mỹ',
                        \App\Enums\TypeUser::NURSES => 'Y tá',
                        \App\Enums\TypeUser::PHAMACISTS => 'Dược sỹ',
                        \App\Enums\TypeUser::HOSPITALS => 'Chủ Bệnh viện',
                        \App\Enums\TypeUser::CLINICS => 'chủ phòng khám',
                        \App\Enums\TypeUser::PHARMACIES => 'Nhà thuốc',
                    ];
                    $member = $memberMappings[Auth::user()->member] ?? 'Người dùng';
                @endphp

                <div class="card-header py-3">
                    @php
                        $roleUser = \App\Models\RoleUser::where('user_id', Auth::user()->id)->first();
                        $roleName = \App\Models\Role::where('id', $roleUser->role_id)->first();

                    @endphp
                    <h6 class="m-0 font-weight-bold text-primary">{{ __('home.My Account') }}
                        : @if ($roleName->name != 'ADMIN')
                            {{ $member ?? 'Người dùng' }}
                        @else
                            ADMIN
                        @endif
                    </h6>
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('profile.update') }}" autocomplete="off"
                        enctype="multipart/form-data">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="previous_route" value="{{app('router')->getRoutes()->match(app('request')->create(URL::previous()))->getName()}}"/>
                        <input type="hidden" name="booking_clinic_id" value="{{ request()->query('clinic_id') }}">

                        <input type="hidden" name="_method" value="PUT">

                        <h6 class="heading-small text-muted mb-4">{{ __('home.User information') }}</h6>

                        <div class="pl-lg-4">
                            <div class="row">
{{--                                <div class="col-lg-4">--}}
{{--                                    <div class="form-group focused">--}}
{{--                                        <label class="form-control-label" for="username">{{ __('home.Username') }}<span--}}
{{--                                                class="small text-danger">*</span></label>--}}
{{--                                        <input type="text" id="username" class="form-control" name="username"--}}
{{--                                            placeholder="Username" required--}}
{{--                                            value="{{ old('username', Auth::user()->username) }}">--}}
{{--                                    </div>--}}
{{--                                </div>--}}
                                <div class="col-lg-12">
                                    <div class="form-group focused">
                                        <label class="form-control-label" for="name">Họ và tên<span
                                                class="small text-danger">*</span></label>
                                        <input type="text" id="name" class="form-control" name="name"
                                            placeholder="Name" required value="{{ old('name', Auth::user()->name) }}">
                                    </div>
                                </div>
{{--                                <div class="col-lg-4">--}}
{{--                                    <div class="form-group focused">--}}
{{--                                        <label class="form-control-label" for="last_name">{{ __('home.Last name') }}--}}
{{--                                            <span class="small text-danger">*</span>--}}
{{--                                        </label>--}}
{{--                                        <input type="text" id="last_name" class="form-control" name="last_name"--}}
{{--                                            placeholder="Last name" required--}}
{{--                                            value="{{ old('last_name', Auth::user()->last_name) }}">--}}
{{--                                    </div>--}}
{{--                                </div>--}}
                            </div>

                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label class="form-control-label" for="email">{{ __('home.Email address') }}
                                        </label>
                                        <input type="email" id="email" class="form-control" name="email"
                                            placeholder="example@example.com"
                                            value="{{ old('email', Auth::user()->email) }}">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label class="form-control-label"
                                            for="phone">{{ __('home.PhoneNumber') }}<span
                                                class="small text-danger">*</span></label>
                                        <input type="number" id="phone" class="form-control" name="phone"
                                            placeholder="Phone" value="{{ old('phone', Auth::user()->phone) }}" required>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <label for="avt">{{ __('home.Ảnh đại diện') }} </label>
                                    <input type="file" class="form-control" id="avt" name="avt"
                                        accept="image/*">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="form-group focused">
                                        <label class="form-control-label"
                                            for="current_password">{{ __('home.Current password') }}</label>
                                        <input type="password" id="current_password" class="form-control"
                                            name="current_password" placeholder="{{ __('home.Current password') }}">
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group focused">
                                        <label class="form-control-label"
                                            for="new_password">{{ __('home.New password') }}</label>
                                        <input type="password" id="new_password" class="form-control"
                                            name="new_password" placeholder="{{ __('home.New password') }}">
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group focused">
                                        <label class="form-control-label"
                                            for="confirm_password">{{ __('home.Confirm Password') }}</label>
                                        <input type="password" id="confirm_password" class="form-control"
                                            name="password_confirmation" placeholder="{{ __('home.Confirm Password') }}">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group focused">
                                        <label for="province_id">Tỉnh/Thành phố</label>
                                        <select name="province_id" id="province_id" class="form-control"
                                            onchange="callGetAllDistricts(this.value)">
                                            <option value="">Chọn thành phố</option>
                                            @foreach($province as $provinces)
                                                <option value="{{$provinces->code}}" @if($provinces->code == $doctor->province_id) selected @endif>{{ $provinces->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group focused">
                                        <label for="district_id">Quận/Huyện</label>
                                        <select name="district_id" id="district_id" class="form-control"
                                            onchange="callGetAllCommunes(this.value)">
                                            <option value="">{{ __('home.Chọn quận') }}</option>
                                            @foreach($district as $districts)
                                                <option value="{{$districts->code}}" @if($districts->code == $doctor->district_id) selected @endif>{{ $districts->name }}</option>
                                                @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group focused">
                                        <label for="commune_id">Phường/Xã</label>
                                        <select name="commune_id" id="commune_id" class="form-control">
                                            <option value="">{{ __('home.Chọn xã') }}</option>
                                            @foreach($commune as $communes)
                                                <option value="{{$communes->code}}" @if($communes->code == $doctor->commune_id) selected @endif>{{ $communes->name }}</option>
                                                @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
{{--                                <div class="col-sm-4">--}}
{{--                                    <div class="form-group focused">--}}
{{--                                        <label class="form-control-label" for="address_code">{{ __('home.AddressCode') }}--}}
{{--                                            <span class="small text-danger">*</span>--}}
{{--                                        </label>--}}
{{--                                        <input type="text" id="address_code" class="form-control" name="address_code"--}}
{{--                                            placeholder="ha_noi"--}}
{{--                                            value="{{ old('address_code', Auth::user()->address_code) }}" required>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
                                <div class="col-sm-12">
                                    <label for="detail_address">Địa chỉ chi tiết
                                        <span class="small text-danger">*</span>
                                    </label>
                                    <input class="form-control" name="detail_address" id="detail_address"
                                           value="{{ $doctor->detail_address }}" required>
                                </div>
{{--                                <div class="col-sm-4">--}}
{{--                                    <div class="form-group focused">--}}
{{--                                        <label class="form-control-label" for="member">{{ __('home.Member') }}<span--}}
{{--                                                class="small text-danger">*</span></label>--}}
{{--                                        <select id="member" name="member" class="form-control" disabled>--}}
{{--                                            @foreach ($roles as $role)--}}
{{--                                                @php--}}
{{--                                                    $isSelected = false;--}}
{{--                                                    if ($role->id == $roleItem->id) {--}}
{{--                                                        $isSelected = true;--}}
{{--                                                    }--}}
{{--                                                @endphp--}}
{{--                                                <option {{ $isSelected ? 'selected' : '' }} value="{{ $role->id }}">--}}
{{--                                                    {{ $role->name }}</option>--}}
{{--                                            @endforeach--}}
{{--                                        </select>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
                                @if ($roleItem->name == "NORMAL PEOPLE" || $roleItem->name == "PAITENTS")
                                    <div class="col-sm-4">
                                        <label for="insurance_id">Mã bảo hiểm</label>
                                        <input class="form-control" name="insurance_id" id="insurance_id"
                                               value="{{ $doctor->insurance_id ?? '' }}">
                                    </div>
                                @endif
                            </div>

                            @if ($roleItem->name == "NORMAL PEOPLE" || $roleItem->name == "PAITENTS")
                                <div class="row">
                                    <div class="col-sm-4">
                                        <label for="health_insurance_front">Mặt trước BHYT</label>
                                        <input class="form-control" type="file" name="health_insurance_front" id="health_insurance_front" onchange="previewImage(event, 'frontPreview')">
                                        <img id="frontPreview" src="{{ Auth::user()->health_insurance_front ?? '' }}" alt="Mặt trước BHYT" style="margin-top: 10px; max-width: 200px; height: auto; display: {{ Auth::user()->health_insurance_front ? 'block' : 'none' }};">
                                    </div>
                                    <div class="col-sm-4">
                                        <label for="health_insurance_back">Mặt sau BHYT</label>
                                        <input class="form-control" type="file" name="health_insurance_back" id="health_insurance_back" onchange="previewImage(event, 'backPreview')">
                                        <img id="backPreview" src="{{ Auth::user()->health_insurance_back ?? '' }}" alt="Mặt sau BHYT" style="margin-top: 10px; max-width: 200px; height: auto; display: {{ Auth::user()->health_insurance_back ? 'block' : 'none' }};">
                                    </div>
                                    <div class="col-sm-4">
                                        <label for="date_health_insurance">Hạn BHYT</label>
                                        <input class="form-control" type="date" value="{{ $doctor->date_health_insurance ? \Carbon\Carbon::parse($doctor->date_health_insurance)->format('Y-m-d') : '' }}" name="date_health_insurance" id="date_health_insurance">
                                    </div>
                                </div>
                            @endif
                            <input type="text" id="role" name="type" class="form-control"
                                   value="{{ Auth::user()->roles->first()->name ?? '' }}" hidden>
                            <div class="row mt-3">
{{--                                <div class="col-sm-4">--}}
{{--                                    <div class="form-group focused">--}}
{{--                                        <label class="form-control-label" for="status">{{ __('home.Status') }}</label>--}}
{{--                                        <input type="text" id="status" class="form-control" name="status"--}}
{{--                                               disabled value="{{ old('status', Auth::user()->status) }}">--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                                <div class="col-sm-4">--}}
{{--                                    <div class="form-group focused">--}}
{{--                                        <label class="form-control-label" for="role">{{ __('home.role') }}</label>--}}
{{--                                        <input type="text" id="role" name="type" class="form-control"--}}
{{--                                            value="{{ Auth::user()->roles->first()->name ?? '' }}" readonly>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
                                <div class="col-sm-4">
                                    <div class="form-group focused">
                                        <label class="form-control-label"
                                            for="identify_number">{{ __('home.identify_number') }}</label>
                                        <div class="input-group">
                                            <input type="text" id="identify_number" class="form-control"
                                                value="{{ Auth::user()->identify_number ?? '' }}" readonly>
                                            <div class="input-group-append">
                                                <button onclick="copyToClipboard()" type="button"
                                                    class="btn btn-outline-primary" data-bs-toggle="tooltip"
                                                    data-bs-placement="top"
                                                    title="Gửi mã này cho bạn bè để nhận điểm tích luỹ"><i
                                                        class="fa-regular fa-copy"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="experienceHospital">Số năm kinh nghiệm</label>
                                    <input class="form-control" type="number" id="experienceHospital"
                                           name="experienceHospital" placeholder="{{ __('home.EXPERIENCE') }}">
                                </div>
                            </div>

                            @if (Auth::user()->type == 'NORMAL')
                                <div class="row">
                                    <div class="col-12">
                                        <label for="is_check_medical_history">Lịch sử khám</label>
                                        <input name="is_check_medical_history" id="is_check_medical_history" type="checkbox" value="1" {{ Auth::user()->is_check_medical_history ? 'checked' : '' }}>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12"><label
                                            for="medical_history">{{ __('home.Tiền sử bệnh án') }}</label>
                                        <textarea id="medical_history" name="medical_history">{{ old('medical_history', Auth::user()->medical_history) }}</textarea>
                                    </div>
                                </div>
                            @endif

                            <!-- Doctor -->
                            @if (Auth::user()->type == 'MEDICAL')
                                <h1>Info doctor</h1>
                                <div class="row">
                                    <div class="col-sm-4">
                                        <label for="identifier">{{ __('home.Mã định danh trên giấy hành nghề') }}</label>
                                        <input type="text" class="form-control" id="identifier" name="identifier"
                                            value="{{ $doctor->identifier }}">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="workplace">{{ __('home.Workplace') }}</label>
                                        <input class="form-control" id="workplace" type="text" name="workplace"
                                            required value="{{ $doctor->workplace }}">
                                    </div>
                                    <div class="col-sm-4"><label for="specialty">Chuyên khoa</label>
                                        <select class="form-select" id="department_id" name="department_id">
                                            @php
                                                $departments = \App\Models\DoctorDepartment::where(
                                                    'status',
                                                    \App\Enums\DoctorDepartmentStatus::ACTIVE,
                                                )->get();
                                            @endphp
                                            @foreach ($departments as $department)
                                                <option value="{{ $department->id }}" {{ $doctor->department_id == $department->id ? 'selected' : '' }}> {{ $department->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="row">

                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <label for="service">{{ __('home.Dịch vụ cung cấp việt') }}</label>
                                        <textarea class="form-control" name="service" id="service">
                                            @if (locationHelper() == 'vi')
{{ $doctor->service ?? '' }}
@else
{{ $doctor->service_en ?? '' }}
@endif
                                        </textarea>
                                    </div>
                                </div>
                                <div class="row">
                                    @php
                                        $working1 = $doctor->time_working_1;
                                        $arrayWorking1 = explode('-', $working1);

                                        $working2 = $doctor->time_working_2;
                                        $arrayWorking2 = explode('-', $working2);
                                    @endphp
                                    @if (!$working1 == null && !$working2 == null)
                                        <div class="col-sm-3">
                                            <label
                                                for="time_working_1_start">{{ __('home.Thời gian làm việc bắt đầu') }}</label>
                                            <input type="time" class="form-control" id="time_working_1_start"
                                                name="time_working_1_start" value="{{ $arrayWorking1[0] }}">
                                        </div>
                                        <div class="col-sm-3">
                                            <label
                                                for="time_working_1_end">{{ __('home.Thời gian làm việc kết thúc') }}</label>
                                            <input type="time" class="form-control" id="time_working_1_end"
                                                name="time_working_1_end" value="{{ $arrayWorking1[1] }}">
                                        </div>
                                        <div class="col-sm-3">
                                            <label
                                                for="time_working_2_start">{{ __('home.Những này làm việc bắt đầu') }}</label>
                                            <select name="time_working_2_start" id="time_working_2_start"
                                                class="form-control">
                                                <option {{ $arrayWorking2[0] == 'T2' ? 'selected' : '' }} value="T2">
                                                    {{ __('home.Thứ 2') }}</option>
                                                <option {{ $arrayWorking2[0] == 'T3' ? 'selected' : '' }} value="T3">
                                                    {{ __('home.Thứ 3') }}</option>
                                                <option {{ $arrayWorking2[0] == 'T4' ? 'selected' : '' }} value="T4">
                                                    {{ __('home.Thứ 4') }}</option>
                                                <option {{ $arrayWorking2[0] == 'T5' ? 'selected' : '' }} value="T5">
                                                    {{ __('home.Thứ 5') }}</option>
                                                <option {{ $arrayWorking2[0] == 'T6' ? 'selected' : '' }} value="T6">
                                                    {{ __('home.Thứ 6') }}</option>
                                                <option {{ $arrayWorking2[0] == 'T7' ? 'selected' : '' }} value="T7">
                                                    {{ __('home.Thứ 7') }}</option>
                                                <option {{ $arrayWorking2[0] == 'CN' ? 'selected' : '' }} value="CN">
                                                    {{ __('home.Chủ nhật') }}</option>
                                            </select>
                                        </div>
                                        <div class="col-sm-3">
                                            <label
                                                for="time_working_2_end">{{ __('home.Những này làm việc kết thúc') }}</label>
                                            <select name="time_working_2_end" id="time_working_2_end"
                                                class="form-control">
                                                <option {{ $arrayWorking2[1] == 'T2' ? 'selected' : '' }} value="T2">
                                                    {{ __('home.Thứ 2') }}</option>
                                                <option {{ $arrayWorking2[1] == 'T3' ? 'selected' : '' }} value="T3">
                                                    {{ __('home.Thứ 3') }}</option>
                                                <option {{ $arrayWorking2[1] == 'T4' ? 'selected' : '' }} value="T4">
                                                    {{ __('home.Thứ 4') }}</option>
                                                <option {{ $arrayWorking2[1] == 'T5' ? 'selected' : '' }} value="T5">
                                                    {{ __('home.Thứ 5') }}</option>
                                                <option {{ $arrayWorking2[1] == 'T6' ? 'selected' : '' }} value="T6">
                                                    {{ __('home.Thứ 6') }}</option>
                                                <option {{ $arrayWorking2[1] == 'T7' ? 'selected' : '' }} value="T7">
                                                    {{ __('home.Thứ 7') }}</option>
                                                <option {{ $arrayWorking2[1] == 'CN' ? 'selected' : '' }} value="CN">
                                                    {{ __('home.Chủ nhật') }}</option>
                                            </select>
                                        </div>

                                        <input type="text" class="form-control d-none" id="time_working_1"
                                            name="time_working_1">
                                        <input type="text" class="form-control d-none" id="time_working_2"
                                            name="time_working_2">
                                        <input type="text" class="form-control d-none" id="apply_for"
                                            name="apply_for">
                                    @else
                                        <div class="col-sm-3">
                                            <label
                                                for="time_working_1_start">{{ __('home.Thời gian làm việc bắt đầu') }}</label>
                                            <input type="time" class="form-control" id="time_working_1_start"
                                                name="time_working_1_start" value="00:00">
                                        </div>
                                        <div class="col-sm-3">
                                            <label
                                                for="time_working_1_end">{{ __('home.Thời gian làm việc kết thúc') }}</label>
                                            <input type="time" class="form-control" id="time_working_1_end"
                                                name="time_working_1_end" value="23:59">
                                        </div>
                                        <div class="col-sm-3">
                                            <label
                                                for="time_working_2_start">{{ __('home.Addresses') }}{{ __('home.Những này làm việc bắt đầu') }}</label>
                                            <select name="time_working_2_start" id="time_working_2_start"
                                                class="form-control">
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
                                            <label
                                                for="time_working_2_end">{{ __('home.Những này làm việc kết thúc') }}</label>
                                            <select name="time_working_2_end" id="time_working_2_end"
                                                class="form-control">
                                                <option value="T2">{{ __('home.Thứ 2') }}</option>
                                                <option value="T3">{{ __('home.Thứ 3') }}</option>
                                                <option value="T4"{{ __('home.Thứ 4') }}></option>
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
                                        <input type="text" class="form-control d-none" id="apply_for"
                                            name="apply_for">
                                    @endif
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <label for="year_of_experience">{{ __('home.Năm kinh nghiệm') }}</label>
                                        <input type="number" class="form-control" id="year_of_experience"
                                            name="year_of_experience" value="{{ $doctor->year_of_experience }}">
                                    </div>
                                    <div class="col-sm-6">
                                        <label for="service_price">{{ __('home.Giá dịch vụ việt') }}</label>
                                        <input class="form-control" type="number" name="service_price"
                                            id="service_price" value="{{ $doctor->service_price }}">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group">
                                        <input name="prescription" type="checkbox" id="prescription"
                                            value="{{ $doctor->prescription == null ? '0' : '1' }}"
                                            {{ $doctor->prescription == null ? '' : 'checked' }}>
                                        <label for="prescription">{{ __('home.prescription') }}</label>
                                    </div>
                                    <div class="form-group">
                                        <input name="free" type="checkbox" id="free"
                                            value="{{ $doctor->free == null ? '1' : '0' }}"
                                            {{ $doctor->free == null ? '' : 'checked' }}>
                                        <label for="free">{{ __('home.free') }}</label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="apply_show">{{ __('home.Apply Show') }}</label>
                                    <input type="text" class="form-control" id="apply_show" name="apply_show"
                                        disabled>
                                    @php
                                        $arrayApply = [
                                            'name' => 'Name',
                                            'response_rate' => 'Response Rate',
                                            'specialty' => 'Specialty',
                                            'year_of_experience' => 'Years of experience',
                                            'service' => 'Service',
                                            'service_price' => 'Service Price',
                                            'time_working_1' => 'Time Working',
                                            'time_working_2' => 'Date Working',
                                        ];

                                        $arrayApplyOld = explode(',', $doctor->apply_for);
                                    @endphp
                                    <ul class="list-apply">
                                        @foreach ($arrayApply as $key => $value)
                                            <li class="new-select">
                                                <input onchange="getInput();" class="apply_item"
                                                    value="{{ $key }}" id="apply_item_{{ $key }}"
                                                    name="apply_item"
                                                    {{ in_array($key, $arrayApplyOld) ? 'checked' : '' }}
                                                    type="checkbox">
                                                <label for="apply_item_{{ $key }}">{{ $value }}</label>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            {{-- Business only --}}
                            @if (Auth::user()->type == 'BUSINESS' )

                                <div>
                                    <label for="introduce">Giới thiệu</label>
                                    <textarea type="text" class="form-control" id="introduce" name="introduce" >
                                        {!! $clinic->introduce !!}
                                    </textarea>
                                </div>
                                <div class="mt-3">
                                    <label>{{ __('home.gallery') }}</label>
                                    <input type="file" class="form-control" id="gallery" name="gallery[]" multiple>
                                    @php
                                        $galleryArray = explode(',', $clinic->gallery);
                                    @endphp
                                    @foreach($galleryArray as $productImg)
                                        <img loading="lazy" width="50px" src="{{$productImg}}" alt="">
                                    @endforeach
                                </div>
{{--                                <div class="row">--}}
{{--                                    <div class="col-lg-6">--}}
{{--                                        <div class="form-group focused">--}}
{{--                                            <label class="form-control-label" for="zalo_app_id"><a--}}
{{--                                                    href="https://oa.zalo.me/home">{{ __('home.zalo_app_id') }}</a></label>--}}
{{--                                            <input type="text" id="zalo_app_id" class="form-control"--}}
{{--                                                   name="zalo_app_id" placeholder="<Enter your zalo app id>"--}}
{{--                                                   value="{{ old('zalo_app_id', Auth::user()->extend['zalo_app_id'] ?? '') }}">--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                    <div class="col-lg-6">--}}
{{--                                        <div class="form-group focused">--}}
{{--                                            <label class="form-control-label" for="zalo_secret_id"><a--}}
{{--                                                    href="https://oa.zalo.me/home">{{ __('home.zalo_secret_id') }}</a></label>--}}
{{--                                            <input type="text" id="zalo_secret_id" class="form-control"--}}
{{--                                                   name="zalo_secret_id" placeholder="<Enter your zalo secret id>"--}}
{{--                                                   value="{{ old('zalo_secret_id', Auth::user()->extend['zalo_secret_id'] ?? '') }}">--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                                @if (!isset(Auth::user()->extend['isActivated']) || !Auth::user()->extend['isActivated'])--}}
{{--                                    <a href="{{ route('zalo.service.auth.verify') }}" type="button"--}}
{{--                                       class="btn btn-outline-primary">{{ __('home.activate_zalo_oa') }}</a>--}}
{{--                                @endif--}}
                                <div class="row">
                                    <div class="form-group col-md-4">
                                        <label for="time_work">{{ __('home.Time work') }}</label>
                                        <select class="form-select" id="time_work" name="time_work">
                                            <option value="{{ \App\Enums\TypeTimeWork::ALL }}">
                                                {{ \App\Enums\TypeTimeWork::ALL }}</option>
                                            <option value="{{ \App\Enums\TypeTimeWork::NONE }}">
                                                {{ \App\Enums\TypeTimeWork::NONE }}</option>
                                            <option value="{{ \App\Enums\TypeTimeWork::OFFICE_HOURS }}">
                                                {{ \App\Enums\TypeTimeWork::OFFICE_HOURS }}</option>
                                            <option value="{{ \App\Enums\TypeTimeWork::ONLY_AFTERNOON }}">
                                                {{ \App\Enums\TypeTimeWork::ONLY_MORNING }}</option>
                                            <option value="{{ \App\Enums\TypeTimeWork::ONLY_AFTERNOON }}">
                                                {{ \App\Enums\TypeTimeWork::ONLY_AFTERNOON }}</option>
                                            <option value="{{ \App\Enums\TypeTimeWork::OTHER }}">
                                                {{ \App\Enums\TypeTimeWork::OTHER }}</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="open_date">{{ __('home.Thời gian bắt đầu') }}</label>
                                        <input class="form-control" id="open_date" name="open_date" type="datetime-local"
                                               placeholder="">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="close_date">{{ __('home.Thời gian kết thúc') }}</label>
                                        <input class="form-control" id="close_date" name="close_date" type="datetime-local"
                                               placeholder="">
                                    </div>
                                </div>
                            @if($roleItem->name != "NORMAL PEOPLE" || $roleItem->name != "PAITENTS")
                                <div class="row">
                                    <div class="form-group col-md-4">
                                        <label for="time_work">ClientId KiotViet</label>
                                        <input class="form-control" id="client_id_kiot_viet" name="client_id_kiot_viet" type="text" value="{{@$doctor->client_id_kiot_viet}}"
                                               placeholder="">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="open_date">Mã bảo mật KiotViet</label>
                                        <input class="form-control" id="client_secret_kiot_viet" name="client_secret_kiot_viet" type="text" value="{{@$doctor->client_secret_kiot_viet}}"
                                               placeholder="">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="close_date">Tên cửa hàng KiotViet</label>
                                        <input class="form-control" id="retailer_kiot_viet" name="retailer_kiot_viet" type="text" value="{{@$doctor->retailer_kiot_viet}}"
                                               placeholder="">
                                    </div>
                                </div>
                                @endif
{{--                                <div class="form-group">--}}
{{--                                    <label for="service_clinic">{{ __('home.Service Clinics') }}</label>--}}
{{--                                    <input type="text" class="form-control" id="service_clinic" name="service_clinic" disabled>--}}
{{--                                    <ul class="list-service">--}}
{{--                                        @php--}}
{{--                                            $arrayService = explode(',', $clinic->service_id);--}}
{{--                                        @endphp--}}
{{--                                        @foreach($services as $service)--}}
{{--                                            <li class="new-select">--}}
{{--                                                <input onchange="getInputService();" class="service_clinic_item" value="{{$service->id}}"--}}
{{--                                                       id="service_{{$service->id}}"--}}
{{--                                                       name="service_clinic"--}}
{{--                                                       {{ in_array($service->id, $arrayService) ? 'checked' : '' }}--}}
{{--                                                       type="checkbox">--}}
{{--                                                <label for="service_{{$service->id}}">{{$service->name}}</label>--}}
{{--                                            </li>--}}
{{--                                        @endforeach--}}
{{--                                    </ul>--}}
{{--                                </div>--}}

{{--                                <div class="form-group">--}}
{{--                                    <label for="department">{{ __('home.Department') }}</label>--}}
{{--                                    <input type="text" class="form-control" id="department_list" name="department_text" disabled>--}}
{{--                                    <ul class="list-department">--}}
{{--                                        @php--}}
{{--                                            $arrayDepartment = explode(',', $clinic->department);--}}
{{--                                        @endphp--}}
{{--                                        @foreach($listDepartments as $department)--}}
{{--                                            <li class="new-select">--}}
{{--                                                <input onchange="getInputDepartment();" class="department_item" value="{{$department->id}}"--}}
{{--                                                       id="department_{{$department->id}}"--}}
{{--                                                       name="department"--}}
{{--                                                       {{ in_array($department->id, $arrayDepartment) ? 'checked' : '' }}--}}
{{--                                                       type="checkbox">--}}
{{--                                                <label for="department_{{$department->id}}">{{$department->name}}</label>--}}
{{--                                            </li>--}}
{{--                                        @endforeach--}}
{{--                                    </ul>--}}
{{--                                </div>--}}

{{--                                <div class="form-group">--}}
{{--                                    <label for="symptom">{{ __('home.symptoms') }}</label>--}}
{{--                                    <input type="text" class="form-control" id="symptom" name="symptom" disabled>--}}
{{--                                    <ul class="list-symptoms">--}}
{{--                                        @php--}}
{{--                                            $arraySymptoms = explode(',', $clinic->symptom);--}}
{{--                                        @endphp--}}
{{--                                        @foreach($symptoms as $symptom)--}}
{{--                                            <li class="new-select">--}}
{{--                                                <input onchange="getInputSymptom();" class="symptom_item" value="{{$symptom->id}}"--}}
{{--                                                       id="symptom_{{$symptom->id}}"--}}
{{--                                                       name="symptom"--}}
{{--                                                       {{ in_array($symptom->id, $arraySymptoms) ? 'checked' : '' }}--}}
{{--                                                       type="checkbox">--}}
{{--                                                <label for="symptom_{{$symptom->id}}">{{$symptom->name}}</label>--}}
{{--                                            </li>--}}
{{--                                        @endforeach--}}
{{--                                    </ul>--}}
{{--                                </div>--}}

{{--                                <div class="row mb-3">--}}
{{--                                    <div class="col-md-4">--}}
{{--                                        <label for="open_date">{{ __('home.open_date') }}</label>--}}
{{--                                        <input type="datetime-local" class="form-control" id="open_date" name="open_date" required--}}
{{--                                               value="{{$clinic->open_date}}">--}}
{{--                                    </div>--}}
{{--                                    <div class="col-md-4">--}}
{{--                                        <label for="close_date">{{ __('home.close_date') }}</label>--}}
{{--                                        <input type="datetime-local" class="form-control" id="close_date" name="close_date"--}}
{{--                                               value="{{$clinic->close_date}}">--}}
{{--                                    </div>--}}
{{--                                    <div class="col-md-4">--}}
{{--                                        <label for="type">{{ __('home.type') }}</label>--}}
{{--                                        <select class="form-select" id="type" name="time_work">--}}
{{--                                            <option--}}
{{--                                                value="{{\App\Enums\TypeBusiness::CLINICS}}" {{ $clinic->type === \App\Enums\TypeBusiness::CLINICS ? 'selected' : '' }}>{{\App\Enums\TypeBusiness::CLINICS}}</option>--}}
{{--                                            <option--}}
{{--                                                value="{{\App\Enums\TypeBusiness::PHARMACIES}}" {{ $clinic->type === \App\Enums\TypeBusiness::PHARMACIES ? 'selected' : '' }}>{{\App\Enums\TypeBusiness::PHARMACIES}}</option>--}}
{{--                                            <option--}}
{{--                                                value="{{\App\Enums\TypeBusiness::HOSPITALS}}" {{ $clinic->type === \App\Enums\TypeBusiness::HOSPITALS ? 'selected' : '' }}>{{\App\Enums\TypeBusiness::HOSPITALS}}</option>--}}
{{--                                        </select>--}}
{{--                                    </div>--}}

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
{{--                                <div class="row">--}}
{{--                                    <div class="col-md-6">--}}
{{--                                        <div class="form-element">--}}
{{--                                            <input name="emergency" id="emergency" type="checkbox" value="1"--}}
{{--                                                   @if($clinic->emergency == 1) checked @endif>--}}
{{--                                            <label for="emergency">{{ __('home.Is there an emergency room') }}?</label>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                    <div class="col-md-6">--}}
{{--                                        <div class="form-element">--}}
{{--                                            <input name="insurance" id="insurance" type="checkbox" value="1"--}}
{{--                                                   @if($clinic->insurance == 1) checked @endif>--}}
{{--                                            <label for="insurance">{{ __('home.Is health insurance applicable') }}?</label>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                                <div class="row">--}}
{{--                                    <div class="col-md-6">--}}
{{--                                        <div class="form-element">--}}
{{--                                            <input name="parking" id="parking" type="checkbox" value="1"--}}
{{--                                                   @if($clinic->parking == 1) checked @endif>--}}
{{--                                            <label for="parking">{{ __('home.Is there parking') }}?</label>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                    <div class="col-md-6">--}}
{{--                                        <div class="form-element d-flex">--}}
{{--                                            <label class="col-6" for="costs">{{ __('home.Medical examination costs') }}?</label>--}}
{{--                                            <input name="costs" class="form-control col-6" id="costs" type="number" value="{{$clinic->costs}}">--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}

{{--                                <div class="row">--}}
{{--                                    <div class="col-md-12">--}}
{{--                                        <label for="hospital_information">{{ __('home.Hospital information') }}</label>--}}
{{--                                        <div class="dropdown" data-target="hospital_information">--}}
{{--                                            <label class="dropdown-label">{{ __('home.Select Options') }}</label>--}}
{{--                                            <input class="d-none" name="hospital_information" id="hospital_information"--}}
{{--                                                   value="{{$clinic->information}}"/>--}}
{{--                                            <div class="dropdown-list">--}}
{{--                                                @php--}}
{{--                                                    $arrayInformation = explode(',',$clinic->information);--}}
{{--                                                    $options = [--}}
{{--                                                        "Pediatric examination/treatment",--}}
{{--                                                        " Emergency department",--}}
{{--                                                        " Female doctor",--}}
{{--                                                        " Specialized hospital",--}}
{{--                                                        " Check health certificate",--}}
{{--                                                        " Physical examination",--}}
{{--                                                        " Rapid antigen test",--}}
{{--                                                        " PCR test",--}}
{{--                                                    ];--}}
{{--                                                @endphp--}}
{{--                                                @foreach($options as $key => $option)--}}
{{--                                                    <div class="checkbox">--}}
{{--                                                        <input type="checkbox" name="dropdown-group"--}}
{{--                                                               class="check hospital_information_name checkbox-custom"--}}
{{--                                                               id="checkbox-custom_{{ $key }}" value="{{ $option }}"--}}
{{--                                                               @if(in_array($option, $arrayInformation, true) || in_array($option, explode(', ', old('hospital_information', '')))) checked @endif />--}}
{{--                                                        <label for="checkbox-custom_{{ $key }}"--}}
{{--                                                               class="checkbox-custom-label">{{ $option }}</label>--}}
{{--                                                    </div>--}}
{{--                                                @endforeach--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                                <div class="row">--}}
{{--                                    <div class="col-md-12">--}}
{{--                                        <label for="hospital_facilities">{{ __('home.Hospital facilities') }}</label>--}}
{{--                                        <div class="dropdown" data-target="hospital_facilities">--}}
{{--                                            <label class="dropdown-label">{{ __('home.Select Options') }}</label>--}}
{{--                                            <input class="d-none" name="hospital_facilities" id="hospital_facilities"--}}
{{--                                                   value="{{$clinic->facilities}}"/>--}}
{{--                                            <div class="dropdown-list">--}}
{{--                                                @php--}}
{{--                                                    $arrayFacilities = explode(',', $clinic->facilities);--}}
{{--                                                    $facilityOptions = [--}}
{{--                                                        "Intensive care unit",--}}
{{--                                                        " General hospital room",--}}
{{--                                                        " High-class hospital room",--}}
{{--                                                        " Surgery room",--}}
{{--                                                        " Emergency room",--}}
{{--                                                        " Physiotherapy room",--}}
{{--                                                    ];--}}
{{--                                                @endphp--}}
{{--                                                @foreach($facilityOptions as $key => $facilityOption)--}}
{{--                                                    <div class="checkbox">--}}
{{--                                                        <input type="checkbox" name="dropdown-group"--}}
{{--                                                               class="check hospital_facilities_name checkbox-custom"--}}
{{--                                                               id="checkbox-custom_{{ $key + 21 }}" value="{{ $facilityOption }}"--}}
{{--                                                               @if(in_array($facilityOption, $arrayFacilities, true) || in_array($facilityOption, explode(', ', old('hospital_facilities', '')))) checked @endif />--}}
{{--                                                        <label for="checkbox-custom_{{ $key + 21 }}"--}}
{{--                                                               class="checkbox-custom-label">{{ $facilityOption }}</label>--}}
{{--                                                    </div>--}}
{{--                                                @endforeach--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                                <div class="row">--}}
{{--                                    <div class="col-md-12">--}}
{{--                                        <label for="hospital_equipment">{{ __('home.Hospital equipment') }}</label>--}}
{{--                                        <div class="dropdown" data-target="hospital_equipment">--}}
{{--                                            <label class="dropdown-label">{{ __('home.Select Options') }}</label>--}}
{{--                                            <input class="d-none" name="hospital_equipment" id="hospital_equipment"--}}
{{--                                                   value="{{$clinic->equipment}}"/>--}}
{{--                                            <div class="dropdown-list">--}}
{{--                                                @php--}}
{{--                                                    $arrayEquipment = explode(',', $clinic->equipment);--}}
{{--                                                    $equipmentOptions = [--}}
{{--                                                        "CT",--}}
{{--                                                        " MRI",--}}
{{--                                                        " Bone density meter",--}}
{{--                                                        " Positron tomography (PET)",--}}
{{--                                                        " Tumor treatment device (CYBER KNIFE)",--}}
{{--                                                        " Ultrasound imaging equipment",--}}
{{--                                                        " Tumor treatment devices (proton therapy devices)",--}}
{{--                                                        " Artificial kidney equipment for hemodialysis",--}}
{{--                                                    ];--}}
{{--                                                @endphp--}}
{{--                                                @foreach($equipmentOptions as $key => $equipmentOption)--}}
{{--                                                    <div class="checkbox">--}}
{{--                                                        <input type="checkbox" name="dropdown-group"--}}
{{--                                                               class="check hospital_equipment_name checkbox-custom"--}}
{{--                                                               id="checkbox-custom_{{ $key + 27 }}" value="{{ $equipmentOption }}"--}}
{{--                                                               @if(in_array($equipmentOption, $arrayEquipment, true) || in_array($equipmentOption, explode(', ', old('hospital_equipment', '')))) checked @endif />--}}
{{--                                                        <label for="checkbox-custom_{{ $key + 27 }}"--}}
{{--                                                               class="checkbox-custom-label">{{ $equipmentOption }}</label>--}}
{{--                                                    </div>--}}
{{--                                                @endforeach--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
                                @php
                                    $representativeDoctors = [];
                                    $list_doctor = $clinic->representative_doctor;
                                    $array_doctor = explode(',', $list_doctor);

                                    foreach ($array_doctor as $doctorId) {
                                        $doctor = $doctorLists->find($doctorId);
                                        if ($doctor) {
                                            $representativeDoctors[] = $doctor;
                                        }
                                    }
                                @endphp
                                <div class="row">
                                    <div class="col-md-12">
                                        <label for="representative_doctor_text">{{ __('home.REPRESENTATIVE DOCTOR') }}:</label>
                                        <input type="text" class="form-control" id="representative_doctor_text" name="representative_doctor_text" disabled>
                                        <ul class="list-department bg-white p-3" style="max-height: 300px; overflow: auto">
                                            @foreach($representativeDoctors as $doctor)
                                                <li class="new-select">
                                                    <input onchange="getInputDoctor();" class="representative_doctor_item"
                                                           value="{{$doctor->id}}" checked
                                                           id="representative_doctor_{{$doctor->id}}"
                                                           name="representative_doctor"
                                                           type="checkbox">
                                                    <label for="representative_doctor_{{$doctor->id}}">{{$doctor->username}} ({{$doctor->email}})</label>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            @endif
                        </div>

                        <!-- Button -->
                        <div class="pl-lg-4 mt-2 mb-4">
                            <div class="row">
                                <div class="col text-center">
                                    <button type="submit"
                                        class="btn btn-primary">{{ __('home.Save Changes') }}</button>
                                </div>
                            </div>
                        </div>
                    </form>

                </div>

            </div>

        </div>

    </div>

    <!-- Modal Signature -->
    <div class="modal fade" id="signatureModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Tạo chữ ký của bạn</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <canvas id="signature-pad" class="signature-pad border" width="460" height="200"></canvas>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                    <button type="button" class="btn btn-primary" id="save-signature">Lưu</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('page-script')
    <script src="{{ asset('signature_pad@4.2.0/dist/signature_pad.umd.min.js') }}"></script>

    <script>
        // callGetAllProvince();

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
            let pro = `{{ $doctor->province_id ?? 1}}`;
            for (let i = 0; i < res.length; i++) {
                let data = res[i];
                if (data.code == pro) {
                    select = `selected`;
                } else {
                    select = ``;
                }
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
            let dis = `{{ $doctor->district_id ?? 1}}`;
            for (let i = 0; i < res.length; i++) {
                let data = res[i];
                if (data.code == dis) {
                    select = `selected`;
                } else {
                    select = ``;
                }
                html = html + `<option ${select} class="district district-item" value="${data.code}">${data.name}</option>`;
            }
            $('#district_id').empty().append(html);
            callGetAllCommunes($('#district_id').find(':selected').val());
        }

        function showAllCommunes(res) {
            let html = ``;
            let select = ``;
            let cm = `{{ $doctor->commune_id ?? 1 }}`;
            for (let i = 0; i < res.length; i++) {
                let data = res[i];
                if (data.code == cm) {
                    select = `selected`;
                } else {
                    select = ``;
                }
                html = html + `<option ${select} value="${data.code}">${data.name}</option>`;
            }
            $('#commune_id').empty().append(html);
        }
    </script>
    <script>
        let arrayItem = [];
        let arrayNameCategory = [];

        function removeArray(arr) {
            var what, a = arguments,
                L = a.length,
                ax;
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
    </script>
    <script>
        setDataForTime('time_working_1_start', 'time_working_1_end', 'time_working_1');
        setDataForTime('time_working_2_start', 'time_working_2_end', 'time_working_2');

        $('#time_working_1_start').on('change', function() {
            setDataForTime('time_working_1_start', 'time_working_1_end', 'time_working_1')
        })

        $('#time_working_1_end').on('change', function() {
            setDataForTime('time_working_1_start', 'time_working_1_end', 'time_working_1')
        })

        $('#time_working_2_start').on('change', function() {
            setDataForTime('time_working_2_start', 'time_working_2_end', 'time_working_2')
        })

        $('#time_working_2_end').on('change', function() {
            setDataForTime('time_working_2_start', 'time_working_2_end', 'time_working_2')
        })

        function setDataForTime(time_working_start, time_working_end, merge) {
            let value_start = $('#' + time_working_start).val();
            let value_end = $('#' + time_working_end).val();
            let mergeValue = value_start + '-' + value_end;
            $('#' + merge).val(mergeValue);
        }
    </script>
    <script>
        function submitForm() {
            loadingMasterPage();
            let headers = {
                'Authorization': `Bearer ${token}`
            };
            const formData = new FormData();

            const arrField = ['facebook', 'tiktok', 'instagram', 'google_review', 'youtube', 'other', 'user_id'];

            arrField.forEach((field) => {
                formData.append(field, $(`#${field}`).val().trim());
            });
            formData.append('_token', '{{ csrf_token() }}');

            try {
                $.ajax({
                    url: `{{ route('user.social.update') }}`,
                    method: 'POST',
                    headers: headers,
                    contentType: false,
                    cache: false,
                    processData: false,
                    data: formData,
                    success: function() {
                        loadingMasterPage();
                        toastr.success('Update success');
                        window.location.reload();
                    },
                    error: function(exception) {
                        toastr.error('Update fail');
                        loadingMasterPage();
                    }
                });
            } catch (error) {
                loadingMasterPage();
                throw error;
            }

        }
    </script>
    <script>
        $(document).ready(function() {
            document.getElementById('prescription').addEventListener('change', function() {
                if (this.checked) {
                    this.value = 1;
                } else {
                    this.value = 2;
                }

                var freeCheckbox = document.getElementById('free');
                var freeValue = freeCheckbox.checked ? 1 : 0;

            });

            document.getElementById('free').addEventListener('change', function() {
                if (this.checked) {
                    this.value = 1;
                } else {
                    this.value = 0;
                }

                var prescriptionCheckbox = document.getElementById('prescription');
                var prescriptionValue = prescriptionCheckbox.checked ? 1 : 2;

            });

        });
    </script>
    <script>
        function copyToClipboard() {
            // Get the value from the input element
            var inputValue = $('#identify_number').val();

            // Create a temporary input element
            var tempInput = $('<input>');
            $('body').append(tempInput);

            // Set the value of the temporary input to the desired value
            tempInput.val(inputValue);

            // Select the value in the temporary input
            tempInput.select();

            // Copy the selected value to the clipboard
            document.execCommand('copy');

            // Remove the temporary input element
            tempInput.remove();

            toastr.success('Copied!!');
        }
    </script>

    <script>
        var canvas = document.getElementById('signature-pad');

        var signaturePad = new SignaturePad(canvas);

        $('#save-signature').click(function() {
            if (signaturePad.isEmpty()) {
                toastr.error("Bạn phải tạo chữ ký trước");
                return;
            }
            var signatureData = signaturePad.toDataURL();
            var formData = new FormData();

            // Add the user_id field to the form data
            formData.append('user_id', '{{ Auth::user()->id ?? 0 }}');
            formData.append('signature', signatureData);

            var csrfToken = `{{ csrf_token() }}`;
            var header = {
                'X-CSRF-TOKEN': csrfToken
            };

            $.ajax({
                url: "{{ route('user.update.user.signature') }}",
                method: 'POST',
                headers: header,
                contentType: false,
                cache: false,
                processData: false,
                data: formData,
                success: function(response) {
                    if (response.error == 0) {
                        toastr.success('Sửa chữ ký thành công');
                        $('#signatureModal').modal('hide');
                        $('#signatureImg').attr('src', signatureData);
                        signaturePad.clear();
                    }
                },
                error: function(xhr, status, error) {
                    // Handle the error here
                    toastr.error(error);
                }
            });
        });
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
                $('#department_list').val(listName);
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
            $('#symptoms').val(value);
        }

        getInputService();
        getInputDepartment();
        getInputSymptom();

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

        function previewImage(event, previewId) {
            let reader = new FileReader();
            reader.onload = function() {
                let output = document.getElementById(previewId);
                output.src = reader.result;
                output.style.display = 'block'; // Display the image
            }
            // Check if a file is selected
            if (event.target.files[0]) {
                reader.readAsDataURL(event.target.files[0]);
            } else {
                let output = document.getElementById(previewId);
                output.style.display = 'none'; // Hide the image if no file is selected
                output.src = ''; // Clear the src attribute
            }
        }
    </script>
@endsection

