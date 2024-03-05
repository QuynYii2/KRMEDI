@php
    $routeName = Route::currentRouteName();
@endphp
@php use App\Http\Middleware\MedicalPermission; @endphp
@php use Illuminate\Support\Facades\Auth; @endphp
@php use App\Enums\Role; @endphp
<header class="header header-flea mt-0">
    <div class="container">
        <div class="row header-detail mobile-hidden justify-content-between">
            <div class="col-md-3 header-detail--left d-flex justify-content-around">
                <a class="logo" href="{{ route('home') }}">
                    <img loading="lazy" src="{{asset('img/icons_logo/logo-new.png')}}" alt="Logo" width="177px" height="42px"
                         class="d-inline-block align-text-top">
                </a>
                <a class="back" href="{{ route('home') }}"><h5><i
                            class="fa-solid fa-angles-left"></i> {{ __('home.Examination') }}</h5>
                </a>
            </div>
            <div class="col-md-6 header-detail--center d-flex justify-content-sm-around">
                <a class=" {{ $routeName == 'examination.index' ? 'active' : '' }}"
                   href="{{ route('examination.index') }}">{{ __('home.Find a doctor') }}</a>
                <a class="{{ $routeName == 'examination.findmymedicine' ? 'active' : '' }}"
                   href="{{ route('examination.findmymedicine') }}">{{ __('home.Find my medicine') }}</a>
                <a class="{{ $routeName == 'examination.mentoring' ? 'active' : '' }}"
                   href="{{route('examination.mentoring')}}">{{ __('home.Mentoring') }}</a>
                <a class="{{ $routeName == 'examination.mypersonaldoctor' ? 'active' : '' }}"
                   href="{{ route('examination.mypersonaldoctor') }}">{{ __('home.My personal doctor') }}</a>
            </div>
            <div class="col-md-2 header-detail--right d-flex">
                <div class="header-right d-flex align-items-center w-100">
                    @if(Auth::check())
                        <div class="dropdown col-md-6 p-0">
                            <div class="d-flex dropdown-toggle justify-content-between overflow-hidden" type="button"
                                 data-toggle="dropdown"
                                 aria-expanded="false">
                                <div class="d-flex align-items-center mr-2">
                                    {{Auth::user()->username}}
                                </div>
                            </div>
                            <div class="dropdown-menu">
                                <a class="dropdown-item"
                                   href="{{ route('profile') }}">{{ __('home.Trang cá nhân') }}</a>
                                <a class="dropdown-item" href="{{route('logoutProcess')}}">{{ __('home.Logout') }}</a>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="option p-2">
                                <a href="{{ route('examination.mentoring.create') }}">{{ __('home.Ask a question') }}</a>
                            </div>
                        </div>
                    @else
                        <button class="account_control" id="show_login" data-toggle="modal"
                                data-target="#staticBackdrop">{{ __('home.Log In') }}
                        </button>
                        <div>|</div>
                        <button type="button" class="account_control" data-toggle="modal"
                                data-target="#modalRegister">{{ __('home.Sign Up') }}
                        </button>
                    @endif
                </div>
            </div>
        </div>
        <div class="header-mobile row d-flex d-none">
            <nav class="navbar bg-lights fixed-top d-flex">
                <div class="w-100 d-flex justify-content-between">
                    <div>
                        <button class="navbar-toggler border-none" type="button" data-bs-toggle="offcanvas"
                                data-bs-target="#fleaMarketNavbar" aria-controls="fleaMarketNavbar">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                    </div>
                    <div class="align-items-center row">
                        <a href="{{route('home')}}">
                            <img loading="lazy" class="w-100px" src="{{asset('img/icons_logo/logo-new.png')}}" alt="">
                        </a>
                    </div>
                    <div class="header-right d-flex align-items-center">
                        @if(Auth::check())
                            <div class="dropdown">
                                <div class="d-flex dropdown-toggle justify-content-between" type="button"
                                     data-toggle="dropdown"
                                     aria-expanded="false">
                                    <div class="d-flex align-items-center mr-2">
                                        {{Auth::user()->name}}
                                    </div>
                                    <img loading="lazy" src="{{asset('img/user-circle.png')}}">
                                </div>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item"
                                       href="{{ route('profile') }}">{{ __('home.Trang cá nhân') }}</a>
                                    <a class="dropdown-item"
                                       href="{{route('booking.list.by.user')}}">{{ __('home.My booking') }}</a>
                                    <a class="dropdown-item"
                                       href="{{route('logoutProcess')}}">{{ __('home.Logout') }}</a>
                                </div>
                            </div>
                        @else
                            <button class="account_control" id="show_login" data-toggle="modal"
                                    data-target="#staticBackdrop">{{ __('home.Log In') }}
                            </button>
                            <div>|</div>
                            <button type="button" class="account_control" data-toggle="modal"
                                    data-target="#modalRegister">{{ __('home.Sign Up') }}
                            </button>
                        @endif
                    </div>
                </div>
            </nav>
        </div>
    </div>
</header>
{{-- modal menu --}}
<div class="offcanvas offcanvas-start" tabindex="-1" id="fleaMarketNavbar"
     aria-labelledby="offcanvasNavbarLabel">
    <div class="offcanvas-header">
        <a href="{{route('home')}}" class="offcanvas-title" id="offcanvasNavbarLabel"><img loading="lazy" class="w-100"
                                                                                           src="{{asset('img/icons_logo/logo-new.png')}}"
                                                                                           alt=""></a>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <div class="text-center-info align-items-start d-flex mb-3">
            <a href="{{route('home')}}" class="text-center-info"><i
                    class="fa-solid fa-angles-left"></i><span>{{ __('home.Examination') }}</span></a>
        </div>
        <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
            <li class="nav-item button-nav-header mb-3">
                <a class=" {{ $routeName == 'examination.index' ? 'active' : 'nav-link' }}"
                   href="{{ route('examination.index') }}">{{ __('home.Find a doctor') }}</a>
            </li>
            <li class="nav-item button-nav-header mb-3">
                <a class="{{ $routeName == 'examination.findmymedicine' ? 'active' : 'nav-link' }}"
                   href="{{ route('examination.findmymedicine') }}">{{ __('home.Find my medicine') }}</a>
            </li>
            <li class="nav-item button-nav-header mb-3">
                <a class="{{ $routeName == 'examination.mentoring' ? 'active' : 'nav-link' }}"
                   href="{{route('examination.mentoring')}}">{{ __('home.Mentoring') }}</a>
            </li>
            <li class="nav-item button-nav-header mb-3">
                <a class="{{ $routeName == 'examination.mypersonaldoctor' ? 'active' : 'nav-link' }}"
                   href="{{ route('examination.mypersonaldoctor') }}">{{ __('home.My personal doctor') }}</a>
            </li>
            @if(Auth::check())
                <li class="nav-item button-nav-header mb-3">
                    <a class="nav-link" href="#">{{ __('home.Log out') }}</a>
                </li>
            @else
                <li class="nav-item button-nav-header mb-3">
                    <a class="nav-link" href="#" data-toggle="modal"
                       data-target="#staticBackdrop">{{ __('home.Log In') }}</a>
                </li>
                <li class="nav-item button-nav-header mb-3">
                    <a class="nav-link" href="#" data-toggle="modal"
                       data-target="#modalRegister">{{ __('home.Sign Up') }}</a>
                </li>
            @endif
        </ul>
    </div>
</div>
<div class="modal fade" id="staticBackdrop" data-keyboard="false" tabindex="-1"
     aria-labelledby="staticBackdropLabel"
     aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" id="modal_login">
            <div class="modal-body">
                <div class="close-btn">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">&times;</button>
                </div>
                <form method="post" action="{{ route('loginProcess') }}">
                    @csrf
                    <div class="popup d-lg-flex justify-content-center">
                        <div class="form">
                            <div class="form-element">
                                <label for="email">{{ __('home.Email') }}</label>
                                <input id="email" name="email" type="email" placeholder="exmaple@gmail.com">
                            </div>
                            <div class="form-element">
                                <label for="password">{{ __('home.Password') }}</label>
                                <input id="password" name="password" type="password" placeholder="********">
                            </div>
                            <div class="form-element">
                                <input id="remember-me" type="checkbox">
                                <label for="remember-me">{{ __('home.Remember password') }}</label>
                                <a href="#">{{ __('home.Forgot Password') }}?</a>
                            </div>
                            <div class="form-element text-center">
                                <button>{{ __('home.Login') }}</button>
                            </div>
                            <div class="other_sign">
                                <div class="line"></div>
                                <div class="text-center">
                                    {{ __('home.Or') }}
                                </div>
                                <div class="line"></div>
                            </div>
                            <div class="form-signin d-flex justify-content-around">
                                <a href="{{ route('login.facebook') }}" class="login-with-btn">
                                    <img loading="lazy" src="{{asset('img/icons_logo/facebook_logo.png')}}" alt=""/>
                                </a>
                                <a href="{{ route('login.google') }}" class="login-with-btn">
                                    <img loading="lazy" src="{{asset('img/icons_logo/google_logo.png')}}" alt=""/>
                                </a>
                                <button type="button" class="login-with-btn">
                                    <img loading="lazy" src="{{asset('img/icons_logo/apple_logo.png')}}" alt=""/>
                                </button>
                                <a href="{{ route('login.kakao') }}" class="login-with-btn">
                                    <img loading="lazy" src="{{asset('img/icons_logo/kakao-talk_logo.png')}}" alt=""/>
                                </a>
                            </div>
                            <div class="sign--up d-flex justify-content-center">
                                <p>{{ __('home.Do not have an account') }}?</p>
                                <a href="" data-toggle="modal" data-target="#modalRegister"
                                   data-dismiss="modal">{{ __('home.Sign Up') }}</a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modalRegister" data-keyboard="false" tabindex="-1"
     aria-labelledby="staticBackdropLabel"
     aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" id="modal_register">
            <div class="modal-body">
                <div class="close-btn">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">&times;</button>
                </div>
                <div class="popup">
                    <form method="post" action="{{route('registerProcess')}}" id="formSignUp"
                          enctype="multipart/form-data">
                        @csrf
                        <div class="form">
                            <div class="tab-content" id="myTabContent">
                                <div class="tab-pane fade show active" id="Pharmacist" role="tabpanel"
                                     aria-labelledby="Pharmacist-tab">
                                    <div>
                                        <div class="form-element">
                                            <label for="username">{{ __('home.Username') }}</label>
                                            <input id="username" name="username" type="text"
                                                   placeholder="exmaple"
                                                   required>
                                        </div>
                                        <div class="form-element">
                                            <label for="type">{{ __('home.Type Account') }}</label>
                                            <select id="type" name="type" class="form-select"
                                                    onchange="showInputFileUpload(this.value)">
                                                <option>Choose...</option>
                                                <option
                                                    value="{{Role::BUSINESS }}">{{ __('home.BUSINESS') }}</option>
                                                <option
                                                    value="{{Role::MEDICAL }}">{{ __('home.MEDICAL') }}</option>
                                                <option value="{{Role::NORMAL }}"
                                                        selected>{{ __('home.NORMAL') }}</option>
                                            </select>
                                        </div>
                                        <div class="form-element">
                                            <label for="member">{{ __('home.Member') }}</label>
                                            <select id="member" name="member" class="form-select">
                                                <option
                                                    value="{{Role::PAITENTS }}">{{ __('home.PAITENTS') }}</option>
                                                <option
                                                    value="{{Role::NORMAL_PEOPLE }}">{{ __('home.NORMAL PEOPLE') }}
                                                </option>
                                            </select>
                                        </div>
                                        <div class="form-element" id="elemet-upload-file-sign-up">
                                            <label for="member" id="labelFileUploadSignup"></label>
                                            <input type="file" id="fileupload" name="fileupload"
                                                   accept="image/*, .pdf, .doc, .docx">
                                        </div>
                                        <div class="form-element" id="element-doctor" style="display: none;">
                                            <div>
                                                <label for="name_doctor">{{ __('home.Name') }}</label>
                                                <input type="text" id="name_doctor" name="name_doctor"
                                                       placeholder="{{ __('home.Name') }}">
                                            </div>
                                            <div class="mt-3">
                                                <label for="contact_phone">{{ __('home.CONTACT INFO') }}</label>
                                                <input type="number" id="contact_phone" name="contact_phone"
                                                       placeholder="0123456789">
                                            </div>
                                            <div class="mt-3">
                                                <label for="experience">{{ __('home.EXPERIENCE') }}</label>
                                                <input type="text" id="experience" name="experience"
                                                       placeholder="{{ __('home.EXPERIENCE') }}">
                                            </div>
                                            <div class="mt-3">
                                                <label for="hospital">{{ __('home.HOSPITAL NAME') }}</label>
                                                <input type="text" id="hospital" name="hospital"
                                                       placeholder="{{ __('home.HOSPITAL NAME') }}">
                                            </div>
                                            <div class="mt-3">
                                                <label
                                                    for="specialized_services">{{ __('home.SPECIALIZED SERVICES') }}</label>
                                                <input type="text" id="specialized_services"
                                                       name="specialized_services"
                                                       placeholder="{{ __('home.SPECIALIZED SERVICES') }}">
                                            </div>
                                            <div class="mt-3">
                                                <label for="services_info">{{ __('home.SERVICE INFO') }}</label>
                                                <input type="text" id="services_info" name="services_info"
                                                       placeholder="{{ __('home.SERVICE INFO') }}">
                                            </div>
                                        </div>
                                        <div id="element-hospital" style="display: none;">
                                            <div class="d-flex form-element">
                                                <div class="col-md-6 pl-0">
                                                    <label
                                                        for="open_date">{{ __('home.Thời gian bắt đầu') }}</label>
                                                    <input class="input-time" id="open_date" name="open_date"
                                                           type="time" placeholder="">
                                                </div>
                                                <div class="col-md-6 pr-0">
                                                    <label
                                                        for="close_date">{{ __('home.Thời gian kết thúc') }}</label>
                                                    <input class="input-time" id="close_date" name="close_date"
                                                           type="time" placeholder="">
                                                </div>
                                            </div>
                                            <div class="mt-3 form-element">
                                                <label
                                                    for="experienceHospital">{{ __('home.EXPERIENCE') }}</label>
                                                <input type="number" id="experienceHospital"
                                                       name="experienceHospital"
                                                       placeholder="{{ __('home.EXPERIENCE') }}">
                                            </div>
                                            <div class="form-element">
                                                <label for="address">{{ __('home.Addresses') }}</label>
                                                <input id="address" name="address" type="text"
                                                       placeholder="{{ __('home.Addresses') }}">
                                            </div>
                                            <div class="form-element">
                                                <label for="province_id">{{ __('home.Tỉnh') }}</label>
                                                <select name="province_id" id="province_id"
                                                        class="form-control">
                                                </select>
                                            </div>
                                            <div class="form-element">
                                                <label for="district_id">{{ __('home.Quận') }}</label>
                                                <select name="district_id" id="district_id"
                                                        class="form-control">
                                                </select>
                                            </div>
                                            <div class="form-element">
                                                <label for="commune_id">{{ __('home.Xã') }}</label>
                                                <select name="commune_id" id="commune_id" class="form-control">
                                                </select>
                                            </div>
                                            <div class="form-element">
                                                <label
                                                    for="representative">{{ __('home.REPRESENTATIVE DOCTOR') }}</label>
                                                <input id="representative" name="representative" type="text"
                                                       placeholder="{{ __('home.REPRESENTATIVE DOCTOR') }}">
                                            </div>
                                            <div class="form-element">
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
                                        <div class="form-element">
                                            <label for="email">{{ __('home.Email') }}</label>
                                            <input id="email" name="email" type="email"
                                                   placeholder="exmaple@gmail.com"
                                                   required>
                                        </div>

                                        <div class="form-element">
                                            <label for="password">{{ __('home.Password') }}</label>
                                            <input id="password" type="password" name="password" minlength="8"
                                                   placeholder="********" required>
                                        </div>
                                        <div class="form-element">
                                            <label
                                                for="passwordConfirm">{{ __('home.Enter the Password') }}</label>
                                            <input id="passwordConfirm" name="passwordConfirm" minlength="8"
                                                   type="password" placeholder="********" required>
                                        </div>
                                        <div class="form-element">
                                            <input id="remember-me" type="checkbox" required>
                                            <label
                                                for="remember-me">{{ __('home.Agree to Terms of Service and Privacy Policy') }}</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="other-option">
                            <div class="form-element text-center">
                                <button type="submit">{{ __('home.Sign Up') }}</button>
                            </div>
                            <div class="other_sign">
                                <div class="line"></div>
                                <div class="text-center">
                                    {{ __('home.Or') }}
                                </div>
                                <div class="line"></div>
                            </div>
                            <div class="form-signin" style="display: flex; justify-content: space-around">
                                <a href="{{ route('login.facebook') }}" class="login-with-btn">
                                    <img loading="lazy" src="{{asset('img/icons_logo/facebook_logo.png')}}" alt=""/>
                                </a>
                                <a href="{{ route('login.google') }}" class="login-with-btn">
                                    <img loading="lazy" src="{{asset('img/icons_logo/google_logo.png')}}" alt=""/>
                                </a>
                                <button type="button" class="login-with-btn">
                                    <img loading="lazy" src="{{asset('img/icons_logo/apple_logo.png')}}" alt=""/>
                                </button>
                                <a href="{{ route('login.kakao') }}" class="login-with-btn">
                                    <img loading="lazy" src="{{asset('img/icons_logo/kakao-talk_logo.png')}}" alt=""/>
                                </a>
                            </div>
                            <div class="sign--up d-flex justify-content-center">
                                <p>{{ __('home.Do you already have an account') }}?</p>
                                <a href="#" data-toggle="modal" data-target="#staticBackdrop"
                                   data-dismiss="modal">
                                    {{ __('home.Log In') }}</a>
                            </div>
                        </div>
                        <div hidden="">
                            <label for="combined_address"></label><input type="text" name="combined_address"
                                                                         id="combined_address"
                                                                         class="form-control">
                            <label for="longitude"></label><input type="text" name="longitude" id="longitude"
                                                                  class="form-control">
                            <label for="latitude"></label><input type="text" name="latitude" id="latitude"
                                                                 class="form-control">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    function getCookie(name) {
        var value = "; " + document.cookie;
        var parts = value.split("; " + name + "=");
        if (parts.length === 2) return parts.pop().split(";").shift();
    }

    function checkLoginWishStore() {
        let userId = `{{ Auth::check() ? Auth::user()->id : null }}`;
        if (!userId) {
            $('#staticBackdrop').modal('show');
        } else {
            window.location.href = '{{route('flea.market.my.store' )}}';
        }
    }

    function checkLoginWish() {
        if (token === undefined) {
            $('#staticBackdrop').modal('show');
        } else {
            window.location.href = '{{ route('examination.mypersonaldoctor') }}';
        }
    }

    function checkLogin() {
        if (token === undefined) {
            $('#staticBackdrop').modal('show');
        } else {
            window.location.href = '{{route('examination.mentoring')}}';
        }
    }
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
            var detailAddress = $('#address').val();

            // Gộp các giá trị vào một chuỗi cách nhau bởi dấu phẩy
            var combinedAddress = [detailAddress, codeCommuneId, codeDistrictId, codeProvinceId, 'Việt Nam'].join(',');
            // Gán giá trị vào input ẩn
            $('#combined_address').val(combinedAddress);
            addNewAddress();
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
    $('#elemet-upload-file-sign-up').hide();

    function showInputFileUpload(value) {
        if (value === '{{Role::BUSINESS}}') {
            $('#labelFileUploadSignup').text('Upload your business license');
            //show elemet-upload-file-sign-up
            $('#fileupload').attr('required', true);
            $('#elemet-upload-file-sign-up').show();
        } else if (value === '{{Role::MEDICAL}}') {
            $('#labelFileUploadSignup').text('Upload your medical license');
            $('#fileupload').attr('required', true);
            $('#elemet-upload-file-sign-up').show();
        } else {
            $('#elemet-upload-file-sign-up').hide();
            $('#fileupload').attr('required', false);
        }
    }

    $(document).ready(function () {
        $('#type').on('change', function () {
            let value = $(this).val();
            let html = ``;
            switch (value) {
                case 'BUSINESS':
                    html = `<option value="{{Role::PHARMACEUTICAL_COMPANIES}}">PHARMACEUTICAL COMPANIES</option>
                                                <option value="{{Role::HOSPITALS}}">HOSPITALS</option>
                                                <option value="{{Role::CLINICS}}">CLINICS</option>
                                                <option value="{{Role::PHARMACIES}}">PHARMACIES</option>
                                                <option value="{{Role::SPAS}}">SPAS</option>
                                                <option value="{{Role::OTHERS}}">OTHERS</option>`;
                    break;
                case 'MEDICAL':
                    html = `<option value="{{Role::DOCTORS}}">DOCTOR</option>
                                                <option value="{{Role::PHAMACISTS}}">PHAMACISTS</option>
                                                <option value="{{Role::THERAPISTS}}">THERAPISTS</option>
                                                <option value="{{Role::ESTHETICIANS}}">ESTHETICIANS</option>
                                                <option value="{{Role::NURSES}}">NURSES</option>`;
                    break;
                default:
                    html = `<option value="{{Role::PAITENTS}}">PAITENTS</option>
                                                <option value="{{Role::NORMAL_PEOPLE}}">NORMAL PEOPLE</option>`;
                    break;
            }
            $('#member').empty().append(html);

            let member = $('#member').val();
            loadHospital(member);
            loadDoctor(member);
        });

        $('#member').on('change', function () {
            let value = $(this).val();
            loadDoctor(value);
            loadHospital(value);
        });

        function loadDoctor(value) {
            if (value == '{{Role::DOCTORS}}') {
                $('#element-doctor').show();
                $('#name_doctor').attr('required', true);
                $('#contact_phone').attr('required', true);
                $('#experience').attr('required', true);
                $('#hospital').attr('required', true);
                $('#rate').attr('required', true);
                $('#specialized_services').attr('required', true);
                $('#services_info').attr('required', true);
            } else {
                $('#element-doctor').hide();
                $('#name_doctor').attr('required', false);
                $('#contact_phone').attr('required', false);
                $('#experience').attr('required', false);
                $('#hospital').attr('required', false);
                $('#rate').attr('required', false);
                $('#specialized_services').attr('required', false);
                $('#services_info').attr('required', false);
            }
        }

        function loadHospital(value) {
            if (value == '{{Role::HOSPITALS}}') {
                $('#element-hospital').show();
                $('#open_date').attr('required', true);
                $('#close_date').attr('required', true);
                $('#experienceHospital').attr('required', true);
                $('#address').attr('required', true);
                $('#province_id').attr('required', true);
                $('#district_id').attr('required', true);
                $('#commune_id').attr('required', true);
                $('#representative').attr('required', true);
                $('#time_work').attr('required', true);
            } else {
                $('#element-hospital').hide();
                $('#open_date').attr('required', false);
                $('#close_date').attr('required', false);
                $('#experienceHospital').attr('required', false);
                $('#address').attr('required', false);
                $('#province_id').attr('required', false);
                $('#district_id').attr('required', false);
                $('#commune_id').attr('required', false);
                $('#representative').attr('required', false);
                $('#time_work').attr('required', false);
            }
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
            let code = data.code;
            html = html + `<option class="province province-item" data-code="${code}" value="${data.id}-${data.code}-${data.code_name}-${data.name}">${data.name}</option>`;
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

