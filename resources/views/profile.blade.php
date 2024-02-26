@php use Illuminate\Support\Facades\Auth; @endphp
@extends('layouts.admin')
@section('title')
    {{ __('home.Profile') }}
@endsection
@section('main-content')
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
                         style="max-width: 100px; max-height: 100px">
                </div>
                <div class="card-body">

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="text-center">
                                <h5 class="font-weight-bold">{{  Auth::user()->username }}</h5>
                                <p>{{  Auth::user()->points }} points</p>
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

            <div class="card shadow mb-4">
                <div class="card-body">
                    <form>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1"><i
                                        class="fa-brands fa-facebook w-icon-px"></i></span>
                            </div>
                            <label for="facebook"></label><input type="text" class="form-control" id="facebook"
                                                                 name="facebook"
                                                                 value="{{ $socialUser->facebook ?? '' }}">
                        </div>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1"><i
                                        class="fa-brands fa-tiktok w-icon-px"></i></span>
                            </div>
                            <label for="tiktok"></label><input type="text" class="form-control" id="tiktok"
                                                               name="tiktok"
                                                               value="{{ $socialUser->tiktok ?? '' }}">
                        </div>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1"><i class="fa-brands fa-instagram"></i></span>
                            </div>
                            <label for="instagram"></label><input type="text" class="form-control" id="instagram"
                                                                  name="instagram"
                                                                  value="{{ $socialUser->instagram ?? '' }}">
                        </div>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1"><i
                                        class="fa-brands fa-google"></i></span>
                            </div>
                            <label for="google_review"></label><input type="text" class="form-control"
                                                                      id="google_review" name="google_review"
                                                                      value="{{ $socialUser->google_review ?? '' }}">
                        </div>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1"><i
                                        class="fa-brands fa-youtube w-icon-px"></i></span>
                            </div>
                            <label for="youtube"></label><input type="text" class="form-control" id="youtube"
                                                                name="youtube"
                                                                value="{{ $socialUser->youtube ?? '' }}">
                        </div>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1"><i
                                        class="fa-solid fa-hashtag"></i></span>
                            </div>
                            <label for="other"></label><input type="text" class="form-control" id="other" name="other"
                                                              value="{{ $socialUser->other ?? '' }}">
                        </div>

                        <input type="hidden" id="user_id" name="user_id"
                               value="{{ Auth::user()->id }}">
                        <button type="button" class="btn btn-primary"
                                onclick="submitForm()">{{ __('home.Submit') }}</button>
                    </form>
                </div>
            </div>

        </div>

        <div class="col-lg-8 order-lg-1">

            <div class="card shadow mb-4">
                @php
                    if (Auth::user()->member == 'NORMAL') {
                       $member = 'Người dùng';
                    } elseif (Auth::user()->member == 'DOCTORS') {
                        $member = 'Bác sĩ';
                    } elseif (Auth::user()->member == 'HOSPITALS') {
                        $member = 'Chủ Bệnh viện';
                    } else {
                        $member = 'chủ phòng khám';
                    }
                @endphp
                <div class="card-header py-3">
                    @php
                        $roleUser = \App\Models\RoleUser::where('user_id',Auth::user()->id)->first();
                        $roleName = \App\Models\Role::where('id',$roleUser->role_id)->first();

                    @endphp
                    <h6 class="m-0 font-weight-bold text-primary">{{ __('home.My Account') }}
                        : @if($roleName->name != 'ADMIN')
                            {{$member}}
                        @else
                            ADMIN
                        @endif</h6>
                </div>

                <div class="card-body">

                    <form method="POST" action="{{ route('profile.update') }}" autocomplete="off"
                          enctype="multipart/form-data">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">

                        <input type="hidden" name="_method" value="PUT">

                        <h6 class="heading-small text-muted mb-4">{{ __('home.User information') }}</h6>

                        <div class="pl-lg-4">
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="form-group focused">
                                        <label class="form-control-label" for="username">{{ __('home.Username') }}<span
                                                class="small text-danger">*</span></label>
                                        <input type="text" id="username" class="form-control" name="username"
                                               placeholder="Username" required
                                               value="{{ old('username', Auth::user()->username) }}">
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group focused">
                                        <label class="form-control-label" for="name">{{ __('home.Name') }}<span
                                                class="small text-danger">*</span></label>
                                        <input type="text" id="name" class="form-control" name="name" placeholder="Name"
                                               required
                                               value="{{ old('name', Auth::user()->name) }}">
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group focused">
                                        <label class="form-control-label"
                                               for="last_name">{{ __('home.Last name') }}</label>
                                        <input type="text" id="last_name" class="form-control" name="last_name"
                                               placeholder="Last name" required
                                               value="{{ old('last_name', Auth::user()->last_name) }}">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label class="form-control-label" for="email">{{ __('home.Email address') }}
                                            <span
                                                class="small text-danger">*</span></label>
                                        <input type="email" id="email" class="form-control" name="email"
                                               placeholder="example@example.com" required
                                               value="{{ old('email', Auth::user()->email) }}">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label class="form-control-label" for="phone">{{ __('home.PhoneNumber') }}<span
                                                class="small text-danger">*</span></label>
                                        <input type="number" id="phone" class="form-control" name="phone"
                                               placeholder="Phone"
                                               value="{{ old('phone', Auth::user()->phone) }}" required>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <label for="avt">{{ __('home.Ảnh đại diện') }} </label>
                                    <input type="file" class="form-control" id="avt" name="avt" accept="image/*">
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
                                               name="password_confirmation"
                                               placeholder="{{ __('home.Confirm Password') }}">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-4">
                                    <label for="detail_address">{{ __('home.địa chỉ chi tiết việt') }}</label>
                                    <input class="form-control" name="detail_address" id="detail_address"
                                           value="{{$doctor->detail_address}}">
                                </div>
                                <div class="col-sm-4">
                                    <label for="detail_address_en">{{ __('home.địa chỉ chi tiết anh') }}</label>
                                    <input class="form-control" name="detail_address_en" id="detail_address_en"
                                           value="{{$doctor->detail_address_en}}">
                                </div>
                                <div class="col-sm-4">
                                    <label for="detail_address_laos">{{ __('home.địa chỉ chi tiết lào') }}</label>
                                    <input class="form-control" name="detail_address_laos" id="detail_address_laos"
                                           value="{{$doctor->detail_address_laos}}">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-4">
                                    <label for="province_id">{{ __('home.Tỉnh') }}</label>
                                    <select name="province_id" id="province_id" class="form-control"
                                            onchange="callGetAllDistricts(this.value)">

                                    </select>
                                </div>
                                <div class="col-sm-4">
                                    <label for="district_id">{{ __('home.Quận') }}</label>
                                    <select name="district_id" id="district_id" class="form-control"
                                            onchange="callGetAllCommunes(this.value)">
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
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="form-group focused">
                                        <label class="form-control-label"
                                               for="address_code">{{ __('home.AddressCode') }}</label>
                                        <input type="text" id="address_code" class="form-control" name="address_code"
                                               placeholder="ha_noi"
                                               value="{{ old('address_code', Auth::user()->address_code) }}" required>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group focused">
                                        <label class="form-control-label" for="member">{{ __('home.Member') }}<span
                                                class="small text-danger">*</span></label>
                                        <select id="member" name="member" class="form-control" disabled>
                                            @foreach($roles as $role)
                                                @php
                                                    $isSelected = false;
                                                    if ($role->id == $roleItem->id){
                                                        $isSelected = true;
                                                    }
                                                @endphp
                                                <option
                                                    {{ $isSelected ? 'selected' : '' }} value="{{$role->id}}">{{$role->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group focused">
                                        <label class="form-control-label" for="status">{{ __('home.Status') }}</label>
                                        <input type="text" id="status" class="form-control" name="status"
                                               disabled
                                               value="{{ old('status', Auth::user()->status) }}">
                                    </div>
                                </div>
                            </div>
                            @if(Auth::user()->type == 'NORMAL')
                                <div class="row">
                                    <div class="col-12"><label
                                            for="medical_history">{{ __('home.Tiền sử bệnh án') }}</label>
                                        <textarea id="medical_history"
                                                  name="medical_history">{{ old('medical_history', Auth::user()->medical_history) }}</textarea>
                                    </div>
                                </div>
                            @endif

                            <!-- Doctor -->
                            @if(Auth::user()->type == 'MEDICAL')
                                <h1>Info doctor</h1>
                                <div class="row">
                                    <div class="col-sm-4">
                                        <label
                                            for="identifier">{{ __('home.Mã định danh trên giấy hành nghề') }}</label>
                                        <input type="text" class="form-control" id="identifier" name="identifier"
                                               value="{{$doctor->identifier}}">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="workplace">{{ __('home.Workplace') }}</label>
                                        <input class="form-control" id="workplace" type="text" name="workplace" required
                                               value="{{$doctor->workplace}}">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-4"><label
                                            for="specialty">{{ __('home.chuyên môn việt') }}</label>
                                        <input type="text" class="form-control" id="specialty" name="specialty"
                                               value="{{$doctor->specialty}}">
                                    </div>
                                    <div class="col-sm-4"><label
                                            for="specialty_en">{{ __('home.chuyên môn anh') }}</label>
                                        <input type="text" class="form-control" id="specialty_en" name="specialty_en"
                                               value="{{$doctor->specialty_en}}"></div>
                                    <div class="col-sm-4"><label
                                            for="specialty_laos">{{ __('home.chuyên môn lào') }}</label>
                                        <input type="text" class="form-control" id="specialty_laos"
                                               name="specialty_laos"
                                               value="{{$doctor->specialty_laos}}"></div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-4">
                                        <label for="service">{{ __('home.Dịch vụ cung cấp việt') }}</label>
                                        <textarea class="form-control" name="service"
                                                  id="service">{{$doctor->service}}</textarea>
                                    </div>
                                    <div class="col-sm-4">
                                        <label for="service_en">{{ __('home.Dịch vụ cung cấp anh') }}</label>
                                        <textarea class="form-control" name="service_en"
                                                  id="service_en">{{$doctor->service_en}}</textarea>
                                    </div>
                                    <div class="col-sm-4">
                                        <label for="service_laos">{{ __('home.Dịch vụ cung cấp lào') }}</label>
                                        <textarea class="form-control" name="service_laos"
                                                  id="service_laos">{{$doctor->service_laos}}</textarea>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-4">
                                        <label for="service_price">{{ __('home.Giá dịch vụ việt') }}</label>
                                        <input class="form-control" type="number" name="service_price"
                                               id="service_price"
                                               value="{{$doctor->service_price}}">
                                    </div>
                                    <div class="col-sm-4">
                                        <label for="service_price_en">{{ __('home.Giá dịch vụ anh') }}</label>
                                        <input class="form-control" type="number" name="service_price_en"
                                               id="service_price_en"
                                               value="{{$doctor->service_price_en}}">
                                    </div>
                                    <div class="col-sm-4">
                                        <label for="service_price_laos">{{ __('home.Giá dịch vụ lào') }}</label>
                                        <input class="form-control" type="number" name="service_price_laos"
                                               id="service_price_laos"
                                               value="{{$doctor->service_price_laos}}">
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
                                            <label
                                                for="time_working_1_start">{{ __('home.Thời gian làm việc bắt đầu') }}</label>
                                            <input type="time" class="form-control" id="time_working_1_start"
                                                   name="time_working_1_start"
                                                   value="{{ $arrayWorking1[0] }}">
                                        </div>
                                        <div class="col-sm-3">
                                            <label
                                                for="time_working_1_end">{{ __('home.Thời gian làm việc kết thúc') }}</label>
                                            <input type="time" class="form-control" id="time_working_1_end"
                                                   name="time_working_1_end"
                                                   value="{{ $arrayWorking1[1] }}">
                                        </div>
                                        <div class="col-sm-3">
                                            <label
                                                for="time_working_2_start">{{ __('home.Những này làm việc bắt đầu') }}</label>
                                            <select name="time_working_2_start" id="time_working_2_start"
                                                    class="form-control">
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
                                            <label
                                                for="time_working_2_end">{{ __('home.Những này làm việc kết thúc') }}</label>
                                            <select name="time_working_2_end" id="time_working_2_end"
                                                    class="form-control">
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

                                        <input type="text" class="form-control d-none" id="time_working_1"
                                               name="time_working_1">
                                        <input type="text" class="form-control d-none" id="time_working_2"
                                               name="time_working_2">
                                        <input type="text" class="form-control d-none" id="apply_for" name="apply_for">
                                    @else
                                        <div class="col-sm-3">
                                            <label
                                                for="time_working_1_start">{{ __('home.Thời gian làm việc bắt đầu') }}</label>
                                            <input type="time" class="form-control" id="time_working_1_start"
                                                   name="time_working_1_start"
                                                   value="00:00">
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
                                        <input type="text" class="form-control d-none" id="apply_for" name="apply_for">
                                    @endif
                                </div>
                                <div class="row">
                                    <div class="col-sm-4"><label for="department_id">{{ __('home.Department') }}</label>
                                        <select class="form-select" id="department_id" name="department_id">
                                            @php
                                                $departments = \App\Models\DoctorDepartment::where('status', \App\Enums\DoctorDepartmentStatus::ACTIVE)->get();
                                            @endphp
                                            @foreach($departments as $department)
                                                <option value="{{$department->id}}"> {{$department->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-sm-4">
                                        <label for="year_of_experience">{{ __('home.Năm kinh nghiệm') }}</label>
                                        <input type="number" class="form-control" id="year_of_experience"
                                               name="year_of_experience"
                                               value="{{$doctor->year_of_experience}}">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group">
                                        <input name="prescription" type="checkbox" id="prescription"
                                               value="{{ $doctor->prescription == null ? '0' : '1' }}" {{ $doctor->prescription == null ? '' : 'checked' }} >
                                        <label
                                            for="prescription">{{ __('home.prescription') }}</label>
                                    </div>
                                    <div class="form-group">
                                        <input name="free" type="checkbox" id="free"
                                               value="{{ $doctor->free == null ? '1' : '0' }}" {{ $doctor->free == null ? '' : 'checked' }}>
                                        <label
                                            for="free">{{ __('home.free') }}</label>
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
                            @endif

                            {{-- Business only --}}
                            @if(Auth::user()->type == 'BUSINESS')
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label for="open_date">{{ __('home.Thời gian bắt đầu') }}</label>
                                        <input class="form-control" id="open_date" name="open_date"
                                               type="time" placeholder="">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="close_date">{{ __('home.Thời gian kết thúc') }}</label>
                                        <input class="form-control" id="close_date" name="close_date"
                                               type="time" placeholder="">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label for="experienceHospital">{{ __('home.EXPERIENCE') }}</label>
                                        <input class="form-control" type="number" id="experienceHospital" name="experienceHospital"
                                               placeholder="{{ __('home.EXPERIENCE') }}">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="time_work">{{ __('home.Time work') }}</label>
                                        <select class="form-select" id="time_work" name="time_work">
                                            <option
                                                value="{{\App\Enums\TypeTimeWork::ALL}}">{{\App\Enums\TypeTimeWork::ALL}}</option>
                                            <option
                                                value="{{\App\Enums\TypeTimeWork::NONE}}">{{\App\Enums\TypeTimeWork::NONE}}</option>
                                            <option
                                                value="{{\App\Enums\TypeTimeWork::OFFICE_HOURS}}">{{\App\Enums\TypeTimeWork::OFFICE_HOURS}}</option>
                                            <option
                                                value="{{\App\Enums\TypeTimeWork::ONLY_AFTERNOON}}">{{\App\Enums\TypeTimeWork::ONLY_MORNING}}</option>
                                            <option
                                                value="{{\App\Enums\TypeTimeWork::ONLY_AFTERNOON}}">{{\App\Enums\TypeTimeWork::ONLY_AFTERNOON}}</option>
                                            <option
                                                value="{{\App\Enums\TypeTimeWork::OTHER}}">{{\App\Enums\TypeTimeWork::OTHER}}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="representative">{{ __('home.REPRESENTATIVE DOCTOR') }}</label>
                                </div>
                            @endif
                        </div>

                        <!-- Button -->
                        <div class="pl-lg-4 mt-4">
                            <div class="row">
                                <div class="col text-center">
                                    <button type="submit" class="btn btn-primary">{{ __('home.Save Changes') }}</button>
                                </div>
                            </div>
                        </div>
                    </form>

                </div>

            </div>

        </div>

    </div>

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
            let select = ``;
            let pro = `{{ $doctor->province_id }}`;
            for (let i = 0; i < res.length; i++) {
                let data = res[i];
                if (data.code == pro) {
                    select = `selected`;
                } else {
                    select = ``;
                }
                let code = data.code;
                html = html + `<option ${select} class="province province-item" data-code="${code}" value="${data.code}">${data.name}</option>`;
            }
            $('#province_id').empty().append(html);
            callGetAllDistricts($('#province_id').find(':selected').val());
        }

        function showAllDistricts(res) {
            let html = ``;
            let select = ``;
            let dis = `{{ $doctor->district_id }}`;
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
            let cm = `{{ $doctor->commune_id }}`;
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
    </script>
    <script>
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
                    url: `{{route('user.social.update')}}`,
                    method: 'POST',
                    headers: headers,
                    contentType: false,
                    cache: false,
                    processData: false,
                    data: formData,
                    success: function () {
                        loadingMasterPage();
                        toastr.success('Update success');
                        window.location.reload();
                    },
                    error: function (exception) {
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
        $(document).ready(function () {
            document.getElementById('prescription').addEventListener('change', function () {
                if (this.checked) {
                    this.value = 1;
                } else {
                    this.value = 2;
                }

                var freeCheckbox = document.getElementById('free');
                var freeValue = freeCheckbox.checked ? 1 : 0;

            });

            document.getElementById('free').addEventListener('change', function () {
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
@endsection
