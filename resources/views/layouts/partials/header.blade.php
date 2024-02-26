@php use App\Enums\CommonType;use App\Enums\Role;use App\Enums\TypeTimeWork;use App\Http\Middleware\MedicalPermission;use Illuminate\Support\Facades\Auth; @endphp

<link href="{{ asset('css/header.css') }}" rel="stylesheet">
<link href="{{ asset('css/loginNew.css') }}" rel="stylesheet">

<style>
    .dropdown-toggle::after {
        color: black;
    }
    .btn:not(:disabled):not(.disabled).active, .btn:not(:disabled):not(.disabled):active {
        background-color: white !important;
        color: black !important;
    }
    .btn-outline-dark.focus, .btn-outline-dark:focus {
        box-shadow: none !important;
    }
    .show>.btn-outline-dark.dropdown-toggle {
        color: #000000;
        background-color: #ffffff;
        border-color: #ffffff;
    }
</style>
<header class="container">
    <div class="main-header">
        <div class="header-30px d-flex justify-content-between align-items-center header-pc container krm-form-header-top">
            <div class="header-left">
                <a href="{{route('home')}}"><img class="w-100" src="{{asset('img/icons_logo/logo-new-header.png')}}" alt="logo"></a>
            </div>
            <div class="header-center d-flex position-relative">
                <label for="search-home" class="krm-label-search"><svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M14.8571 7.42857C14.8571 3.32588 11.5313 0 7.42857 0C3.32588 0 0 3.32588 0 7.42857C0 11.5313 3.32588 14.8571 7.42857 14.8571C9.26857 14.8571 10.96 14.1829 12.2629 13.0743L12.5714 13.3829V14.2857L18.2857 20L20 18.2857L14.2857 12.5714H13.3829L13.0743 12.2629C14.1829 10.96 14.8571 9.26857 14.8571 7.42857ZM2.28571 7.42857C2.28571 4.57143 4.57143 2.28571 7.42857 2.28571C10.2857 2.28571 12.5714 4.57143 12.5714 7.42857C12.5714 10.2857 10.2857 12.5714 7.42857 12.5714C4.57143 12.5714 2.28571 10.2857 2.28571 7.42857Z" fill="black"/>
                    </svg>
                </label><input class="krm-search-home" name="search-home" id="search-home" placeholder="{{__('home.Tìm kiếm cơ sở y tế, nhà thuốc, bác sĩ, thuốc')}}">
            </div>
            <div class="header-right d-flex align-items-center">
                @if(Auth::check())
                    <div class="dropdown">
                        <div class="d-flex dropdown-toggle justify-content-between" type="button" data-toggle="dropdown"
                             aria-expanded="false">
                            <img src="{{Auth::user()->avt ?? asset('img/user-circle.png')}}" style="width: 40px; height: 40px; border-radius: 25px;"> &nbsp;
                            <div class="d-flex align-items-center krm-name-user mr-2">
                                {{Auth::user()->name}}
                            </div>
                        </div>
                        <div class="dropdown-menu">
                            <a class="dropdown-item"
                               href="{{ route('profile') }}">{{ __('home.Trang cá nhân') }}</a>
                            @if(Auth::user()->type != Role::NORMAL)
                                <a class="dropdown-item"
                                   href="{{ route('view.prescription.result.create') }}">Create Prescription</a>
                            @else
                                <a class="dropdown-item"
                                   href="{{ route('view.prescription.result.my.list') }}">{{__('home.My Prescription')}}</a>
                            @endif
                            <a class="dropdown-item"
                               href="{{route('booking.list.by.user')}}">{{ __('home.My booking') }}</a>
                            <a class="dropdown-item" href="{{route('logoutProcess')}}">{{ __('home.Logout') }}</a>
                        </div>
                    </div>
                @else
                    <button class="account_control krm-new_bt__login" id="show_login" data-toggle="modal"
                            data-target="#staticBackdrop">{{ __('home.Log In') }}
                    </button>
                    <div style="color: #FFFFFF">/</div>
                    <button type="button" class="account_control krm-new_bt__login" data-toggle="modal"
                            data-target="#modalRegister">{{ __('home.Sign Up') }}
                    </button>
                @endif
            </div>
            <div class="pr-3 ">
                <div class="dropdown float-right ">
                    <button class="btn krm-select-national dropdown-toggle  btn-outline-dark" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        @if(locationHelper() == 'en')
                            <svg width="24" height="17" viewBox="0 0 24 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <g clip-path="url(#clip0_7408_67)">
                                    <g clip-path="url(#clip1_7408_67)">
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M0 0.5H34.2V1.73333H0V0.5ZM0 2.96333H34.2V4.19667H0V2.96333ZM0 5.42333H34.2V6.65667H0V5.42333ZM0 7.88333H34.2V9.11667H0V7.88333ZM0 10.35H34.2V11.5767H0V10.35ZM0 12.8067H34.2V14.04H0V12.8067ZM0 15.2667H34.2V16.5H0V15.2667Z" fill="#BD3D44"/>
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M0 1.73242H34.2V2.96242H0V1.73242ZM0 4.19242H34.2V5.42242H0V4.19242ZM0 6.65242H34.2V7.88576H0V6.65242ZM0 9.11576H34.2V10.3491H0V9.11576ZM0 11.5758H34.2V12.8091H0V11.5758ZM0 14.0358H34.2V15.2691H0V14.0358Z" fill="white"/>
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M0 0.5H13.68V9.11667H0V0.5Z" fill="#192F5D"/>
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M1.14008 0.867188L1.26758 1.21052H1.66508L1.34258 1.42052L1.46633 1.76385L1.14008 1.55052L0.817578 1.76052L0.937578 1.42052L0.611328 1.21052H1.02008L1.14008 0.867188ZM3.42008 0.867188L3.54383 1.21052H3.94883L3.62258 1.42052L3.74258 1.76385L3.42008 1.55052L3.09383 1.76052L3.21758 1.42052L2.89508 1.21052H3.29258L3.42008 0.867188ZM5.70008 0.867188L5.82383 1.21052H6.22508L5.90258 1.42052L6.02633 1.76385L5.70008 1.55052L5.37383 1.76052L5.49758 1.42052L5.17133 1.21052H5.57633L5.70008 0.867188ZM7.98008 0.867188L8.10383 1.21052H8.50883L8.18258 1.42052L8.30633 1.76385L7.98008 1.55052L7.65383 1.76052L7.78133 1.42052L7.45133 1.21052H7.85258L7.98008 0.867188ZM10.2601 0.867188L10.3838 1.21052H10.7851L10.4626 1.42052L10.5863 1.76385L10.2601 1.55052L9.93383 1.76052L10.0576 1.42052L9.73508 1.21052H10.1363L10.2601 0.867188ZM12.5401 0.867188L12.6638 1.21052H13.0688L12.7388 1.42052L12.8663 1.76385L12.5401 1.55052L12.2138 1.76052L12.3413 1.42052L12.0113 1.21052H12.4163L12.5401 0.867188ZM2.28008 1.73385L2.40383 2.07385H2.81258L2.48633 2.28052L2.60633 2.62385L2.28758 2.41385L1.96133 2.62385L2.07758 2.28052L1.76258 2.07385H2.16383L2.28008 1.73385ZM4.56008 1.73385L4.68758 2.07385H5.08883L4.75883 2.28052L4.88633 2.62385L4.56008 2.41385L4.23383 2.62385L4.35758 2.28052L4.03133 2.07385H4.43633L4.56008 1.73385ZM6.84008 1.73385L6.96383 2.07385H7.36883L7.04258 2.28052L7.16633 2.62385L6.84008 2.41385L6.51383 2.62385L6.63758 2.28052L6.31508 2.07385H6.71258L6.84008 1.73385ZM9.12008 1.73385L9.24758 2.07385H9.64883L9.31883 2.28052L9.44633 2.62385L9.12008 2.41385L8.79758 2.62385L8.91758 2.28052L8.59133 2.07385H9.00008L9.12008 1.73385ZM11.4001 1.73385L11.5238 2.07385H11.9288L11.6026 2.28052L11.7263 2.62385L11.4001 2.41385L11.0738 2.62385L11.1976 2.28052L10.8751 2.07385H11.2763L11.4001 1.73385ZM1.14008 2.58719L1.26758 2.93385H1.66508L1.34258 3.14385L1.46633 3.48385L1.14008 3.27385L0.817578 3.48385L0.937578 3.14385L0.611328 2.93385H1.02008L1.14008 2.58719ZM3.42008 2.58719L3.54383 2.93385H3.94883L3.62258 3.14385L3.74258 3.48385L3.42008 3.27385L3.09383 3.48385L3.21758 3.14052L2.89508 2.93052H3.29258L3.42008 2.58719ZM5.70008 2.58719L5.82383 2.93052H6.22508L5.90258 3.14052L6.02633 3.48052L5.70008 3.27052L5.37383 3.48052L5.49758 3.13719L5.17133 2.92719H5.57633L5.70008 2.58719ZM7.98008 2.58719L8.10383 2.93052H8.50883L8.18258 3.14052L8.30633 3.48052L7.98008 3.27052L7.65383 3.48052L7.78133 3.13719L7.45133 2.92719H7.85258L7.98008 2.58719ZM10.2601 2.58719L10.3838 2.93052H10.7851L10.4626 3.14052L10.5863 3.48052L10.2601 3.27052L9.93383 3.48052L10.0576 3.13719L9.73508 2.92719H10.1363L10.2601 2.58719ZM12.5401 2.58719L12.6638 2.93052H13.0688L12.7388 3.14052L12.8663 3.48052L12.5401 3.27052L12.2138 3.48052L12.3413 3.13719L12.0113 2.92719H12.4163L12.5401 2.58719ZM2.28008 3.45385L2.40383 3.79385H2.81258L2.48633 4.00385L2.61008 4.34719L2.28383 4.13385L1.95758 4.34385L2.08133 4.00385L1.75883 3.79385H2.16008L2.28008 3.45385ZM4.56008 3.45385L4.68758 3.79385H5.08883L4.75883 4.00385L4.88633 4.34719L4.56008 4.13385L4.23383 4.34385L4.35758 4.00385L4.03133 3.79385H4.43633L4.56008 3.45385ZM6.84008 3.45385L6.96383 3.79385H7.36883L7.04258 4.00385L7.16633 4.34719L6.84008 4.13385L6.51383 4.34385L6.63758 4.00385L6.31508 3.79385H6.71258L6.84008 3.45385ZM9.12008 3.45385L9.24758 3.79385H9.64883L9.32258 4.00385L9.44633 4.34719L9.12008 4.13385L8.79758 4.34385L8.91758 4.00385L8.59133 3.79385H9.00008L9.12008 3.45385ZM11.4001 3.45385L11.5238 3.79385H11.9288L11.6026 4.00385L11.7263 4.34719L11.4001 4.13385L11.0738 4.34385L11.1976 4.00385L10.8751 3.79385H11.2763L11.4001 3.45385ZM1.14008 4.31719L1.26758 4.65719H1.66508L1.34258 4.86719L1.46633 5.21052L1.14008 4.99719L0.817578 5.20719L0.937578 4.86719L0.611328 4.65719H1.02008L1.14008 4.31719ZM3.42008 4.31719L3.54383 4.65719H3.94883L3.62258 4.86719L3.74258 5.20719L3.42008 4.99719L3.09383 5.20719L3.21758 4.86719L2.89508 4.65719H3.29258L3.42008 4.31719ZM5.70008 4.31719L5.82383 4.65719H6.22508L5.90258 4.86719L6.02633 5.21052L5.70008 4.99719L5.37383 5.20719L5.49758 4.86719L5.17133 4.65719H5.57633L5.70008 4.31719ZM7.98008 4.31719L8.10383 4.65719H8.50883L8.18258 4.86719L8.30633 5.21052L7.98008 4.99719L7.65383 5.20719L7.78133 4.86719L7.45133 4.65719H7.85258L7.98008 4.31719ZM10.2601 4.31719L10.3838 4.65719H10.7851L10.4626 4.86719L10.5863 5.21052L10.2601 4.99719L9.93383 5.20719L10.0576 4.86719L9.73508 4.65719H10.1363L10.2601 4.31719ZM12.5401 4.31719L12.6638 4.65719H13.0688L12.7388 4.86719L12.8663 5.21052L12.5401 4.99719L12.2138 5.20719L12.3376 4.86719L12.0076 4.65719H12.4126L12.5401 4.31719ZM2.28008 5.17719L2.40383 5.52052H2.81258L2.48633 5.72719L2.61008 6.07052L2.28383 5.85719L1.95758 6.07052L2.08133 5.72719L1.75883 5.51719H2.16008L2.28008 5.17719ZM4.56008 5.17719L4.68758 5.52052H5.08883L4.75883 5.72719L4.88633 6.07052L4.56008 5.85719L4.23383 6.07052L4.35758 5.72719L4.03133 5.51719H4.43633L4.56008 5.17719ZM6.84008 5.17719L6.96383 5.52052H7.36883L7.04258 5.72719L7.16633 6.07052L6.84008 5.85719L6.51383 6.07052L6.63758 5.72719L6.31508 5.51719H6.71258L6.84008 5.17719ZM9.12008 5.17719L9.24758 5.52052H9.64883L9.32258 5.72719L9.44633 6.07052L9.12008 5.85719L8.79758 6.07052L8.91758 5.72719L8.59133 5.51719H9.00008L9.12008 5.17719ZM11.4001 5.17719L11.5238 5.52052H11.9288L11.6026 5.72719L11.7263 6.07052L11.4001 5.85719L11.0738 6.07052L11.1976 5.72719L10.8751 5.51719H11.2763L11.4001 5.17719ZM1.14008 6.03719L1.26758 6.38052H1.66508L1.34258 6.59052L1.46633 6.92719L1.14008 6.72052L0.817578 6.92719L0.937578 6.58719L0.611328 6.37719H1.02008L1.14008 6.03719ZM3.42008 6.03719L3.54383 6.38052H3.94883L3.62258 6.59052L3.74633 6.92719L3.42008 6.72052L3.09383 6.92719L3.22133 6.58719L2.89508 6.37719H3.29258L3.42008 6.03719ZM5.70008 6.03719L5.82383 6.38052H6.22508L5.90258 6.59052L6.02633 6.92719L5.70008 6.72052L5.37383 6.92719L5.49758 6.58719L5.17133 6.37719H5.57633L5.70008 6.03719ZM7.98008 6.03719L8.10383 6.38052H8.50883L8.18258 6.59052L8.30633 6.92719L7.98008 6.72052L7.65383 6.92719L7.78133 6.58719L7.45133 6.37719H7.85258L7.98008 6.03719ZM10.2601 6.03719L10.3838 6.38052H10.7851L10.4626 6.59052L10.5863 6.92719L10.2601 6.72052L9.93383 6.92719L10.0576 6.58719L9.73508 6.37719H10.1363L10.2601 6.03719ZM12.5401 6.03719L12.6638 6.38052H13.0688L12.7388 6.59052L12.8663 6.92719L12.5401 6.72052L12.2138 6.92719L12.3413 6.58719L12.0113 6.37719H12.4163L12.5401 6.03719ZM2.28008 6.90052L2.40383 7.24052H2.81258L2.48633 7.45052L2.61008 7.79385L2.28383 7.58052L1.95758 7.79052L2.08133 7.45052L1.75883 7.24052H2.16008L2.28008 6.90052ZM4.56008 6.90052L4.68758 7.24052H5.08883L4.75883 7.45052L4.88633 7.79385L4.56008 7.58052L4.23383 7.79052L4.35758 7.45052L4.03133 7.24052H4.43633L4.56008 6.90052ZM6.84008 6.90052L6.96383 7.24052H7.36883L7.04258 7.45052L7.16633 7.79385L6.84008 7.58052L6.51383 7.79052L6.63758 7.45052L6.31508 7.24052H6.71258L6.84008 6.90052ZM9.12008 6.90052L9.24758 7.24052H9.64883L9.32258 7.45052L9.44633 7.79385L9.12008 7.58052L8.79758 7.79052L8.91758 7.45052L8.59133 7.24052H9.00008L9.12008 6.90052ZM11.4001 6.90052L11.5238 7.24052H11.9288L11.6026 7.45052L11.7263 7.79385L11.4001 7.58052L11.0738 7.79052L11.1976 7.45052L10.8751 7.24052H11.2763L11.4001 6.90052ZM1.14008 7.76385L1.26758 8.10385H1.66508L1.34258 8.31385L1.46633 8.65385L1.14008 8.44385L0.817578 8.65385L0.937578 8.31052L0.611328 8.10052H1.02008L1.14008 7.76385ZM3.42008 7.76385L3.54383 8.10385H3.94883L3.62258 8.31385L3.74633 8.65385L3.42008 8.44385L3.09383 8.65385L3.22133 8.31052L2.89508 8.10052H3.29258L3.42008 7.76385ZM5.70008 7.76385L5.82383 8.10385H6.22508L5.91008 8.31385L6.03383 8.65385L5.70758 8.44385L5.38133 8.65385L5.50508 8.31052L5.17883 8.10052H5.58383L5.70008 7.76385ZM7.98008 7.76385L8.10383 8.10385H8.50883L8.18258 8.31385L8.30633 8.65385L7.98008 8.44385L7.65383 8.65385L7.78133 8.31052L7.45133 8.10052H7.85258L7.98008 7.76385ZM10.2601 7.76385L10.3838 8.10385H10.7851L10.4626 8.31385L10.5863 8.65385L10.2601 8.44385L9.93383 8.65385L10.0576 8.31052L9.73508 8.10052H10.1363L10.2601 7.76385ZM12.5401 7.76385L12.6638 8.10385H13.0688L12.7388 8.31385L12.8663 8.65385L12.5401 8.44385L12.2138 8.65385L12.3413 8.31052L12.0113 8.10052H12.4163L12.5401 7.76385Z" fill="white"/>
                                    </g>
                                </g>
                                <defs>
                                    <clipPath id="clip0_7408_67">
                                        <rect y="0.5" width="24" height="16" rx="2" fill="white"/>
                                    </clipPath>
                                    <clipPath id="clip1_7408_67">
                                        <rect y="0.5" width="24" height="16" rx="2" fill="white"/>
                                    </clipPath>
                                </defs>
                            </svg> EN
                        @else
                            <svg width="24" height="17" viewBox="0 0 24 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <g clip-path="url(#clip0_7408_3209)">
                                    <g clip-path="url(#clip1_7408_3209)">
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M-1.5 0.5H25.5V16.5H-1.5V0.5Z" fill="#DA251D"/>
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M15.2906 12.4055L12.1406 10.3211L9.01172 12.4242L10.1719 8.99922L7.04297 6.88359L10.9137 6.85234L12.116 3.43359L13.3359 6.84297L17.2066 6.84609L14.0953 8.98359L15.2871 12.4086L15.2906 12.4055Z" fill="#FFFF00"/>
                                    </g>
                                </g>
                                <defs>
                                    <clipPath id="clip0_7408_3209">
                                        <rect y="0.5" width="24" height="16" rx="2" fill="white"/>
                                    </clipPath>
                                    <clipPath id="clip1_7408_3209">
                                        <rect width="24" height="16" fill="white" transform="translate(0 0.5)"/>
                                    </clipPath>
                                </defs>
                            </svg> VN
                        @endif
                    </button>
                    <div class="dropdown-menu dropdown-menu-right " style="min-width: 90px" aria-labelledby="dropdownMenuButton">
                        <a href="{{ route('language', ['locale'=>'vi']) }}" class="dropdown-item">
                            <svg width="24" height="17" viewBox="0 0 24 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <g clip-path="url(#clip0_7408_3209)">
                                    <g clip-path="url(#clip1_7408_3209)">
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M-1.5 0.5H25.5V16.5H-1.5V0.5Z" fill="#DA251D"/>
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M15.2906 12.4055L12.1406 10.3211L9.01172 12.4242L10.1719 8.99922L7.04297 6.88359L10.9137 6.85234L12.116 3.43359L13.3359 6.84297L17.2066 6.84609L14.0953 8.98359L15.2871 12.4086L15.2906 12.4055Z" fill="#FFFF00"/>
                                    </g>
                                </g>
                                <defs>
                                    <clipPath id="clip0_7408_3209">
                                        <rect y="0.5" width="24" height="16" rx="2" fill="white"/>
                                    </clipPath>
                                    <clipPath id="clip1_7408_3209">
                                        <rect width="24" height="16" fill="white" transform="translate(0 0.5)"/>
                                    </clipPath>
                                </defs>
                            </svg> VN
                        </a>
                        <a href="{{ route('language', ['locale'=>'en']) }}" class="dropdown-item">
                            <svg width="24" height="17" viewBox="0 0 24 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <g clip-path="url(#clip0_7408_67)">
                                    <g clip-path="url(#clip1_7408_67)">
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M0 0.5H34.2V1.73333H0V0.5ZM0 2.96333H34.2V4.19667H0V2.96333ZM0 5.42333H34.2V6.65667H0V5.42333ZM0 7.88333H34.2V9.11667H0V7.88333ZM0 10.35H34.2V11.5767H0V10.35ZM0 12.8067H34.2V14.04H0V12.8067ZM0 15.2667H34.2V16.5H0V15.2667Z" fill="#BD3D44"/>
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M0 1.73242H34.2V2.96242H0V1.73242ZM0 4.19242H34.2V5.42242H0V4.19242ZM0 6.65242H34.2V7.88576H0V6.65242ZM0 9.11576H34.2V10.3491H0V9.11576ZM0 11.5758H34.2V12.8091H0V11.5758ZM0 14.0358H34.2V15.2691H0V14.0358Z" fill="white"/>
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M0 0.5H13.68V9.11667H0V0.5Z" fill="#192F5D"/>
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M1.14008 0.867188L1.26758 1.21052H1.66508L1.34258 1.42052L1.46633 1.76385L1.14008 1.55052L0.817578 1.76052L0.937578 1.42052L0.611328 1.21052H1.02008L1.14008 0.867188ZM3.42008 0.867188L3.54383 1.21052H3.94883L3.62258 1.42052L3.74258 1.76385L3.42008 1.55052L3.09383 1.76052L3.21758 1.42052L2.89508 1.21052H3.29258L3.42008 0.867188ZM5.70008 0.867188L5.82383 1.21052H6.22508L5.90258 1.42052L6.02633 1.76385L5.70008 1.55052L5.37383 1.76052L5.49758 1.42052L5.17133 1.21052H5.57633L5.70008 0.867188ZM7.98008 0.867188L8.10383 1.21052H8.50883L8.18258 1.42052L8.30633 1.76385L7.98008 1.55052L7.65383 1.76052L7.78133 1.42052L7.45133 1.21052H7.85258L7.98008 0.867188ZM10.2601 0.867188L10.3838 1.21052H10.7851L10.4626 1.42052L10.5863 1.76385L10.2601 1.55052L9.93383 1.76052L10.0576 1.42052L9.73508 1.21052H10.1363L10.2601 0.867188ZM12.5401 0.867188L12.6638 1.21052H13.0688L12.7388 1.42052L12.8663 1.76385L12.5401 1.55052L12.2138 1.76052L12.3413 1.42052L12.0113 1.21052H12.4163L12.5401 0.867188ZM2.28008 1.73385L2.40383 2.07385H2.81258L2.48633 2.28052L2.60633 2.62385L2.28758 2.41385L1.96133 2.62385L2.07758 2.28052L1.76258 2.07385H2.16383L2.28008 1.73385ZM4.56008 1.73385L4.68758 2.07385H5.08883L4.75883 2.28052L4.88633 2.62385L4.56008 2.41385L4.23383 2.62385L4.35758 2.28052L4.03133 2.07385H4.43633L4.56008 1.73385ZM6.84008 1.73385L6.96383 2.07385H7.36883L7.04258 2.28052L7.16633 2.62385L6.84008 2.41385L6.51383 2.62385L6.63758 2.28052L6.31508 2.07385H6.71258L6.84008 1.73385ZM9.12008 1.73385L9.24758 2.07385H9.64883L9.31883 2.28052L9.44633 2.62385L9.12008 2.41385L8.79758 2.62385L8.91758 2.28052L8.59133 2.07385H9.00008L9.12008 1.73385ZM11.4001 1.73385L11.5238 2.07385H11.9288L11.6026 2.28052L11.7263 2.62385L11.4001 2.41385L11.0738 2.62385L11.1976 2.28052L10.8751 2.07385H11.2763L11.4001 1.73385ZM1.14008 2.58719L1.26758 2.93385H1.66508L1.34258 3.14385L1.46633 3.48385L1.14008 3.27385L0.817578 3.48385L0.937578 3.14385L0.611328 2.93385H1.02008L1.14008 2.58719ZM3.42008 2.58719L3.54383 2.93385H3.94883L3.62258 3.14385L3.74258 3.48385L3.42008 3.27385L3.09383 3.48385L3.21758 3.14052L2.89508 2.93052H3.29258L3.42008 2.58719ZM5.70008 2.58719L5.82383 2.93052H6.22508L5.90258 3.14052L6.02633 3.48052L5.70008 3.27052L5.37383 3.48052L5.49758 3.13719L5.17133 2.92719H5.57633L5.70008 2.58719ZM7.98008 2.58719L8.10383 2.93052H8.50883L8.18258 3.14052L8.30633 3.48052L7.98008 3.27052L7.65383 3.48052L7.78133 3.13719L7.45133 2.92719H7.85258L7.98008 2.58719ZM10.2601 2.58719L10.3838 2.93052H10.7851L10.4626 3.14052L10.5863 3.48052L10.2601 3.27052L9.93383 3.48052L10.0576 3.13719L9.73508 2.92719H10.1363L10.2601 2.58719ZM12.5401 2.58719L12.6638 2.93052H13.0688L12.7388 3.14052L12.8663 3.48052L12.5401 3.27052L12.2138 3.48052L12.3413 3.13719L12.0113 2.92719H12.4163L12.5401 2.58719ZM2.28008 3.45385L2.40383 3.79385H2.81258L2.48633 4.00385L2.61008 4.34719L2.28383 4.13385L1.95758 4.34385L2.08133 4.00385L1.75883 3.79385H2.16008L2.28008 3.45385ZM4.56008 3.45385L4.68758 3.79385H5.08883L4.75883 4.00385L4.88633 4.34719L4.56008 4.13385L4.23383 4.34385L4.35758 4.00385L4.03133 3.79385H4.43633L4.56008 3.45385ZM6.84008 3.45385L6.96383 3.79385H7.36883L7.04258 4.00385L7.16633 4.34719L6.84008 4.13385L6.51383 4.34385L6.63758 4.00385L6.31508 3.79385H6.71258L6.84008 3.45385ZM9.12008 3.45385L9.24758 3.79385H9.64883L9.32258 4.00385L9.44633 4.34719L9.12008 4.13385L8.79758 4.34385L8.91758 4.00385L8.59133 3.79385H9.00008L9.12008 3.45385ZM11.4001 3.45385L11.5238 3.79385H11.9288L11.6026 4.00385L11.7263 4.34719L11.4001 4.13385L11.0738 4.34385L11.1976 4.00385L10.8751 3.79385H11.2763L11.4001 3.45385ZM1.14008 4.31719L1.26758 4.65719H1.66508L1.34258 4.86719L1.46633 5.21052L1.14008 4.99719L0.817578 5.20719L0.937578 4.86719L0.611328 4.65719H1.02008L1.14008 4.31719ZM3.42008 4.31719L3.54383 4.65719H3.94883L3.62258 4.86719L3.74258 5.20719L3.42008 4.99719L3.09383 5.20719L3.21758 4.86719L2.89508 4.65719H3.29258L3.42008 4.31719ZM5.70008 4.31719L5.82383 4.65719H6.22508L5.90258 4.86719L6.02633 5.21052L5.70008 4.99719L5.37383 5.20719L5.49758 4.86719L5.17133 4.65719H5.57633L5.70008 4.31719ZM7.98008 4.31719L8.10383 4.65719H8.50883L8.18258 4.86719L8.30633 5.21052L7.98008 4.99719L7.65383 5.20719L7.78133 4.86719L7.45133 4.65719H7.85258L7.98008 4.31719ZM10.2601 4.31719L10.3838 4.65719H10.7851L10.4626 4.86719L10.5863 5.21052L10.2601 4.99719L9.93383 5.20719L10.0576 4.86719L9.73508 4.65719H10.1363L10.2601 4.31719ZM12.5401 4.31719L12.6638 4.65719H13.0688L12.7388 4.86719L12.8663 5.21052L12.5401 4.99719L12.2138 5.20719L12.3376 4.86719L12.0076 4.65719H12.4126L12.5401 4.31719ZM2.28008 5.17719L2.40383 5.52052H2.81258L2.48633 5.72719L2.61008 6.07052L2.28383 5.85719L1.95758 6.07052L2.08133 5.72719L1.75883 5.51719H2.16008L2.28008 5.17719ZM4.56008 5.17719L4.68758 5.52052H5.08883L4.75883 5.72719L4.88633 6.07052L4.56008 5.85719L4.23383 6.07052L4.35758 5.72719L4.03133 5.51719H4.43633L4.56008 5.17719ZM6.84008 5.17719L6.96383 5.52052H7.36883L7.04258 5.72719L7.16633 6.07052L6.84008 5.85719L6.51383 6.07052L6.63758 5.72719L6.31508 5.51719H6.71258L6.84008 5.17719ZM9.12008 5.17719L9.24758 5.52052H9.64883L9.32258 5.72719L9.44633 6.07052L9.12008 5.85719L8.79758 6.07052L8.91758 5.72719L8.59133 5.51719H9.00008L9.12008 5.17719ZM11.4001 5.17719L11.5238 5.52052H11.9288L11.6026 5.72719L11.7263 6.07052L11.4001 5.85719L11.0738 6.07052L11.1976 5.72719L10.8751 5.51719H11.2763L11.4001 5.17719ZM1.14008 6.03719L1.26758 6.38052H1.66508L1.34258 6.59052L1.46633 6.92719L1.14008 6.72052L0.817578 6.92719L0.937578 6.58719L0.611328 6.37719H1.02008L1.14008 6.03719ZM3.42008 6.03719L3.54383 6.38052H3.94883L3.62258 6.59052L3.74633 6.92719L3.42008 6.72052L3.09383 6.92719L3.22133 6.58719L2.89508 6.37719H3.29258L3.42008 6.03719ZM5.70008 6.03719L5.82383 6.38052H6.22508L5.90258 6.59052L6.02633 6.92719L5.70008 6.72052L5.37383 6.92719L5.49758 6.58719L5.17133 6.37719H5.57633L5.70008 6.03719ZM7.98008 6.03719L8.10383 6.38052H8.50883L8.18258 6.59052L8.30633 6.92719L7.98008 6.72052L7.65383 6.92719L7.78133 6.58719L7.45133 6.37719H7.85258L7.98008 6.03719ZM10.2601 6.03719L10.3838 6.38052H10.7851L10.4626 6.59052L10.5863 6.92719L10.2601 6.72052L9.93383 6.92719L10.0576 6.58719L9.73508 6.37719H10.1363L10.2601 6.03719ZM12.5401 6.03719L12.6638 6.38052H13.0688L12.7388 6.59052L12.8663 6.92719L12.5401 6.72052L12.2138 6.92719L12.3413 6.58719L12.0113 6.37719H12.4163L12.5401 6.03719ZM2.28008 6.90052L2.40383 7.24052H2.81258L2.48633 7.45052L2.61008 7.79385L2.28383 7.58052L1.95758 7.79052L2.08133 7.45052L1.75883 7.24052H2.16008L2.28008 6.90052ZM4.56008 6.90052L4.68758 7.24052H5.08883L4.75883 7.45052L4.88633 7.79385L4.56008 7.58052L4.23383 7.79052L4.35758 7.45052L4.03133 7.24052H4.43633L4.56008 6.90052ZM6.84008 6.90052L6.96383 7.24052H7.36883L7.04258 7.45052L7.16633 7.79385L6.84008 7.58052L6.51383 7.79052L6.63758 7.45052L6.31508 7.24052H6.71258L6.84008 6.90052ZM9.12008 6.90052L9.24758 7.24052H9.64883L9.32258 7.45052L9.44633 7.79385L9.12008 7.58052L8.79758 7.79052L8.91758 7.45052L8.59133 7.24052H9.00008L9.12008 6.90052ZM11.4001 6.90052L11.5238 7.24052H11.9288L11.6026 7.45052L11.7263 7.79385L11.4001 7.58052L11.0738 7.79052L11.1976 7.45052L10.8751 7.24052H11.2763L11.4001 6.90052ZM1.14008 7.76385L1.26758 8.10385H1.66508L1.34258 8.31385L1.46633 8.65385L1.14008 8.44385L0.817578 8.65385L0.937578 8.31052L0.611328 8.10052H1.02008L1.14008 7.76385ZM3.42008 7.76385L3.54383 8.10385H3.94883L3.62258 8.31385L3.74633 8.65385L3.42008 8.44385L3.09383 8.65385L3.22133 8.31052L2.89508 8.10052H3.29258L3.42008 7.76385ZM5.70008 7.76385L5.82383 8.10385H6.22508L5.91008 8.31385L6.03383 8.65385L5.70758 8.44385L5.38133 8.65385L5.50508 8.31052L5.17883 8.10052H5.58383L5.70008 7.76385ZM7.98008 7.76385L8.10383 8.10385H8.50883L8.18258 8.31385L8.30633 8.65385L7.98008 8.44385L7.65383 8.65385L7.78133 8.31052L7.45133 8.10052H7.85258L7.98008 7.76385ZM10.2601 7.76385L10.3838 8.10385H10.7851L10.4626 8.31385L10.5863 8.65385L10.2601 8.44385L9.93383 8.65385L10.0576 8.31052L9.73508 8.10052H10.1363L10.2601 7.76385ZM12.5401 7.76385L12.6638 8.10385H13.0688L12.7388 8.31385L12.8663 8.65385L12.5401 8.44385L12.2138 8.65385L12.3413 8.31052L12.0113 8.10052H12.4163L12.5401 7.76385Z" fill="white"/>
                                    </g>
                                </g>
                                <defs>
                                    <clipPath id="clip0_7408_67">
                                        <rect y="0.5" width="24" height="16" rx="2" fill="white"/>
                                    </clipPath>
                                    <clipPath id="clip1_7408_67">
                                        <rect y="0.5" width="24" height="16" rx="2" fill="white"/>
                                    </clipPath>
                                </defs>
                            </svg> EN
                        </a>
                        <a href="{{ route('language', ['locale'=>'laos']) }}" class="dropdown-item" hidden="">
                            <svg width="24" height="17" viewBox="0 0 24 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <g clip-path="url(#clip0_7408_4516)">
                                    <g clip-path="url(#clip1_7408_4516)">
                                        <rect y="0.5" width="60" height="45" fill="white"/>
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M18.2534 14.4397L19.4363 12.8809L20.1378 13.3014L18.9549 14.8603L18.2534 14.4397Z" fill="black"/>
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M19.626 12.6311L20.8089 11.0723L21.5104 11.4929L20.3275 13.0517L19.626 12.6311Z" fill="black"/>
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M17.2715 13.8499L18.4544 12.291L19.1559 12.7116L17.973 14.2705L17.2715 13.8499Z" fill="black"/>
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M18.644 12.0413L19.827 10.4824L20.5284 10.903L19.3455 12.4619L18.644 12.0413Z" fill="black"/>
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M16.2896 13.262L17.4725 11.7031L18.174 12.1237L16.991 13.6826L16.2896 13.262Z" fill="black"/>
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M17.6616 11.4534L18.8445 9.89453L19.546 10.3151L18.3631 11.874L17.6616 11.4534Z" fill="black"/>
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M3.1014 11.0723L5.65648 14.4394L4.95498 14.86L2.3999 11.4929L3.1014 11.0723Z" fill="black"/>
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M5.45589 12.291L6.6388 13.8499L5.9373 14.2705L4.75439 12.7116L5.45589 12.291Z" fill="black"/>
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M4.08333 10.4824L5.26624 12.0413L4.56474 12.4619L3.38184 10.903L4.08333 10.4824Z" fill="black"/>
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M5.06526 9.89453L7.62034 13.2617L6.91885 13.6823L4.36377 10.3151L5.06526 9.89453Z" fill="black"/>
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M12.0362 12.2749C9.46781 12.2749 7.38574 10.4227 7.38574 8.13789C7.38574 7.40001 7.60289 6.70725 7.98344 6.10742C7.82138 6.39572 7.73022 6.72105 7.73022 7.06532C7.73022 8.25005 8.80981 9.05723 10.1416 9.05723C10.7168 9.05723 11.1911 8.95464 11.6056 8.50233C11.6347 8.46782 11.6637 8.43388 11.6927 8.40054L11.7794 8.30228C11.8083 8.27012 11.8371 8.23857 11.866 8.20765L11.9525 8.11674C12.5013 7.55295 13.0621 7.21855 13.8447 7.21855C15.1289 7.21855 16.3388 7.83821 16.1699 9.44029C16.1102 10.0064 15.9129 10.5222 15.4967 10.8959L15.5025 10.8959C14.651 11.7423 13.4135 12.2749 12.0362 12.2749Z" fill="#0047A0"/>
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M11.8742 4.15234C14.4425 4.15234 16.5246 6.00456 16.5246 8.28939C16.5246 9.02727 16.3075 9.72003 15.9269 10.3199C16.089 10.0316 16.1801 9.70623 16.1801 9.36196C16.1801 8.17723 15.1005 7.37005 13.7688 7.37005C13.1935 7.37005 12.7192 7.47264 12.3048 7.92495C11.6353 8.71871 11.013 9.20873 10.0657 9.20873C8.78148 9.20873 7.57152 8.58907 7.74044 6.98699C7.80013 6.42089 7.99747 5.9051 8.41364 5.53134L8.40783 5.5314C9.25936 4.68501 10.4968 4.15234 11.8742 4.15234Z" fill="#CD2E3A"/>
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M18.3631 4.55273L19.546 6.11161L18.8445 6.5322L17.6616 4.97332L18.3631 4.55273Z" fill="black"/>
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M16.991 2.74414L18.174 4.30301L17.4725 4.7236L16.2896 3.16473L16.991 2.74414Z" fill="black"/>
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M17.973 2.1543L20.5281 5.52146L19.8266 5.94205L17.2715 2.57489L17.973 2.1543Z" fill="black"/>
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M20.3275 3.375L21.5104 4.93387L20.8089 5.35446L19.626 3.79559L20.3275 3.375Z" fill="black"/>
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M18.9549 1.56641L20.1378 3.12528L19.4363 3.54587L18.2534 1.987L18.9549 1.56641Z" fill="black"/>
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M4.36377 6.1113L6.91885 2.74414L7.62034 3.16473L5.06526 6.53189L4.36377 6.1113Z" fill="black"/>
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M3.38184 5.52146L5.93692 2.1543L6.63841 2.57489L4.08333 5.94205L3.38184 5.52146Z" fill="black"/>
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M2.3999 4.93357L4.95498 1.56641L5.65648 1.987L3.1014 5.35416L2.3999 4.93357Z" fill="black"/>
                                    </g>
                                </g>
                                <defs>
                                    <clipPath id="clip0_7408_4516">
                                        <rect y="0.5" width="24" height="16" rx="2" fill="white"/>
                                    </clipPath>
                                    <clipPath id="clip1_7408_4516">
                                        <rect width="24" height="16" fill="white" transform="translate(0 0.5)"/>
                                    </clipPath>
                                </defs>
                            </svg> LO
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="before-header d-flex justify-content-between align-items-center">
            <div class="header-center d-flex justify-content-between align-content-center w-100 container mobile-hidden">
                <a href="{{route('recruitment.index')}}" hidden="">{{ __('home.Recruitment') }}</a>
                <a href="{{route('flea-market.index')}}">{{ __('home.Flea market') }}</a>
                <a href="{{route('examination.index')}}">{{ __('home.Examination') }}</a>
                <a href="{{route('index.new')}}">{{ __('home.New/Events') }}</a>
                <a href="{{route('medicine')}}">{{ __('home.Online Medicine') }}</a>
                <a href="{{route('clinic')}}">{{ __('home.Clinic/Pharmacies') }}</a>
                <a href="{{route('what.free')}}">{{ __("home.What's free") }}?</a>
            </div>
        </div>
    </div>
    <div class="header-mobile row d-flex d-none">
        <nav class="navbar bg-lights fixed-top d-flex">
            <div class="w-100 d-flex justify-content-between">
                <div>
                    <button class="navbar-toggler border-none" type="button" data-bs-toggle="offcanvas"
                            data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                </div>
                <div class="align-items-center row">
                    <a href="{{route('home')}}">
                        <img class="w-100px" src="{{asset('img/icons_logo/logo-new.png')}}">
                    </a>
                </div>
                <div class="header-right d-flex align-items-center">
                    @if(Auth::check())
                        <div class="dropdown">
                            <div class="d-flex dropdown-toggle justify-content-between" type="button"
                                 data-toggle="dropdown"
                                 aria-expanded="false">
                                <div class="d-flex align-items-center mr-2">
                                    {{Auth::user()->username}}
                                </div>
                                <img src="{{asset('img/user-circle.png')}}">
                            </div>
                            <div class="dropdown-menu">
                                <a class="dropdown-item"
                                   href="{{ route('profile') }}">{{ __('home.Trang cá nhân') }}</a>
                                <a class="dropdown-item"
                                   href="{{route('booking.list.by.user')}}">{{ __('home.My booking') }}</a>
                                <a class="dropdown-item" href="{{route('logoutProcess')}}">{{ __('home.Logout') }}</a>
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
</header>

<div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
    <div class="offcanvas-header">
        <a href="{{route('home')}}" class="offcanvas-title" id="offcanvasNavbarLabel"><img class="w-100"
                                                                                           src="{{asset('img/icons_logo/logo-new.png')}}"></a>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
            <li class="nav-item button-nav-header mb-3" hidden="">
                <a class="nav-link" href="{{route('recruitment.index')}}">{{ __('home.Recruitment') }}</a>
            </li>
            <li class="nav-item button-nav-header mb-3">
                <a class="nav-link" href="{{route('flea-market.index')}}">{{ __('home.Flea market') }}</a>
            </li>
            <li class="nav-item button-nav-header mb-3">
                <a class="nav-link" href="{{route('examination.index')}}">{{ __('home.Examination') }}</a>
            </li>
            <li class="nav-item button-nav-header mb-3">
                <a class="nav-link" href="{{route('index.new')}}">{{ __('home.New/Events') }}</a>
            </li>
            <li class="nav-item button-nav-header mb-3">
                <a class="nav-link" href="{{route('medicine')}}">{{ __('home.Online Medicine') }}</a>
            </li>
            <li class="nav-item button-nav-header mb-3">
                <a class="nav-link" href="{{route('clinic')}}">{{ __('home.Clinic/Pharmacies') }}</a>
            </li>
            <li class="nav-item button-nav-header mb-3">
                <a class="nav-link" href="{{route('what.free')}}">{{ __("home.What's free") }}?</a>
            </li>
        </ul>
    </div>
</div>
<div class="modal fade" id="staticBackdrop" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel"
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
                            <div class="form-element d-flex justify-content-between align-items-center mt-md-0 mt-2">
                                <div class="remember-me">
                                    <input id="remember-me" type="checkbox">
                                    <label for="remember-me">{{ __('home.Remember password') }}</label>
                                </div>
                                <a href="#" data-toggle="modal" data-target="#modalForgetPassword">
                                    {{ __('home.Forgot Password') }}</a>
                            </div>
                            <div class="form-element text-center d-flex justify-content-center">
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
                                    <img src="{{asset('img/icons_logo/facebook_logo.png')}}" alt=""/>
                                </a>
                                <a href="{{ route('login.google') }}" class="login-with-btn">
                                    <img src="{{asset('img/icons_logo/google_logo.png')}}" alt=""/>
                                </a>
                                <a type="button" class="login-with-btn">
                                    <img src="{{asset('img/icons_logo/apple_logo.png')}}" alt=""/>
                                </a>
                                <a href="{{ route('login.kakao') }}" class="login-with-btn">
                                    <img src="{{asset('img/icons_logo/kakao-talk_logo.png')}}" alt=""/>
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
<div class="modal fade" id="modalRegister" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
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
                                            <input id="username" name="username" type="text" placeholder="exmaple"
                                                   required>
                                        </div>
                                        <div class="form-element">
                                            <label for="type">{{ __('home.Type Account') }}</label>
                                            <select id="type" name="type" class="form-select"
                                                    onchange="showInputFileUpload(this.value)">
                                                <option>Choose...</option>
                                                <option value="{{Role::BUSINESS }}">{{ __('home.BUSINESS') }}</option>
                                                <option value="{{Role::MEDICAL }}">{{ __('home.MEDICAL') }}</option>
                                                <option value="{{Role::NORMAL }}"
                                                        >{{ __('home.NORMAL') }}</option>
                                            </select>
                                        </div>
                                        <div class="form-element">
                                            <label for="member">{{ __('home.Member') }}</label>
                                            <select id="member" name="member" class="form-select">
{{--                                                <option value="{{Role::PAITENTS }}">{{ __('home.PAITENTS') }}</option>--}}
{{--                                                <option value="{{Role::NORMAL_PEOPLE }}">{{ __('home.NORMAL PEOPLE') }}--}}
{{--                                                </option>--}}
                                            </select>
                                        </div>
                                        <div class="form-elementt m-16" id="element-normal" style="display: none;">
                                            <div>
                                                <label for="medical_history">{{ __('home.Tiền sử bệnh án') }}</label>
                                                <textarea id="medical_history" name="medical_history"
                                                          placeholder="{{ __('home.Tiền sử bệnh án') }}"></textarea>
                                            </div>
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
                                                <label for="identifier">{{ __('home.Mã định danh trên giấy hành nghề') }}</label>
                                                <input type="text" id="identifier" name="identifier"
                                                       placeholder="{{ __('home.Mã định danh trên giấy hành nghề') }}">
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
                                                <input type="text" id="specialized_services" name="specialized_services"
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
                                                    <label for="open_date">{{ __('home.Thời gian bắt đầu') }}</label>
                                                    <input class="input-time" id="open_date" name="open_date"
                                                           type="time" placeholder="">
                                                </div>
                                                <div class="col-md-6 pr-0">
                                                    <label for="close_date">{{ __('home.Thời gian kết thúc') }}</label>
                                                    <input class="input-time" id="close_date" name="close_date"
                                                           type="time" placeholder="">
                                                </div>
                                            </div>
                                            <div class="mt-3 form-element">
                                                <label for="experienceHospital">{{ __('home.EXPERIENCE') }}</label>
                                                <input type="number" id="experienceHospital" name="experienceHospital"
                                                       placeholder="{{ __('home.EXPERIENCE') }}">
                                            </div>
                                            <div class="form-element">
                                                <label for="address">{{ __('home.Addresses') }}</label>
                                                <input id="address" name="address" type="text"
                                                       placeholder="{{ __('home.Addresses') }}">
                                            </div>
                                            <div class="form-element">
                                                <label for="province_id">{{ __('home.Tỉnh') }}</label>
                                                <select name="province_id" id="province_id" class="form-control">
                                                </select>
                                            </div>
                                            <div class="form-element">
                                                <label for="district_id">{{ __('home.Quận') }}</label>
                                                <select name="district_id" id="district_id" class="form-control">
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
                                                        value="{{TypeTimeWork::ALL}}">{{TypeTimeWork::ALL}}</option>
                                                    <option
                                                        value="{{TypeTimeWork::NONE}}">{{TypeTimeWork::NONE}}</option>
                                                    <option
                                                        value="{{TypeTimeWork::OFFICE_HOURS}}">{{TypeTimeWork::OFFICE_HOURS}}</option>
                                                    <option
                                                        value="{{TypeTimeWork::ONLY_AFTERNOON}}">{{TypeTimeWork::ONLY_MORNING}}</option>
                                                    <option
                                                        value="{{TypeTimeWork::ONLY_AFTERNOON}}">{{TypeTimeWork::ONLY_AFTERNOON}}</option>
                                                    <option
                                                        value="{{TypeTimeWork::OTHER}}">{{TypeTimeWork::OTHER}}</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-element">
                                            <label for="email">{{ __('home.Email') }}</label>
                                            <input id="email" name="email" type="email" placeholder="exmaple@gmail.com"
                                                   required>
                                        </div>
                                        <div id="action-doctor" style="display: none">
                                            <div class="form-element">
                                                <input name="prescription" type="checkbox" value="1">
                                                <label
                                                    for="prescription">{{ __('home.prescription') }}</label>
                                            </div>
                                            <div class="form-element">
                                                <input name="free" type="checkbox" value="1">
                                                <label
                                                    for="free">{{ __('home.free') }}</label>
                                            </div>
                                        </div>

                                        <div class="form-element">
                                            <label for="password">{{ __('home.Password') }}</label>
                                            <input id="password" type="password" name="password" minlength="8"
                                                   placeholder="********" required>
                                        </div>
                                        <div class="form-element">
                                            <label for="passwordConfirm">{{ __('home.Enter the Password') }}</label>
                                            <input id="passwordConfirm" name="passwordConfirm" minlength="8"
                                                   type="password" placeholder="********" required>
                                        </div>
                                        <div class="form-element remember-me">
                                            <input id="remember-me" type="checkbox" required>
                                            <label
                                                for="remember-me">{{ __('home.Agree to Terms of Service and Privacy Policy') }}</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="other-option">
                            <div class="form-element text-center d-flex justify-content-center">
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
                                    <img src="{{asset('img/icons_logo/facebook_logo.png')}}" alt=""/>
                                </a>
                                <a href="{{ route('login.google') }}" class="login-with-btn">
                                    <img src="{{asset('img/icons_logo/google_logo.png')}}" alt=""/>
                                </a>
                                <a type="button" class="login-with-btn">
                                    <img src="{{asset('img/icons_logo/apple_logo.png')}}" alt=""/>
                                </a>
                                <a href="{{ route('login.kakao') }}" class="login-with-btn">
                                    <img src="{{asset('img/icons_logo/kakao-talk_logo.png')}}" alt=""/>
                                </a>
                            </div>
                            <div class="sign--up d-flex justify-content-center">
                                <p>{{ __('home.Do you already have an account') }}?</p>
                                <a href="#" data-toggle="modal" data-target="#staticBackdrop" data-dismiss="modal">
                                    {{ __('home.Log In') }}</a>
                            </div>
                        </div>
                        <div hidden="">
                            <input type="text" name="combined_address" id="combined_address" class="form-control">
                            <input type="text" name="longitude" id="longitude" class="form-control">
                            <input type="text" name="latitude" id="latitude" class="form-control">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal modal-xl modal fade" id="modalForgetPassword" data-backdrop="static" data-keyboard="false"
     tabindex="-1" aria-labelledby="modalForgetPasswordLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered">
        <div class="modal-content container h-80">

            <div class="modal-body">
                <div class="container-fluid">
                    <div class="row justify-content-center">
                        <div class="col-sm-12 text-center p-0 mt-3 mb-2">
                            <div class="card px-0 pt-4 pb-0 mt-3 mb-3">
                                <h2 id="heading">{{ __('home.Lấy lại mật khẩu') }}</h2>
                                <form id="msform">
                                    <!-- progressbar -->
                                    <ul id="progressbar">
                                        <li class="active" id="account"><strong>{{ __('home.Thông tin tài khoản') }}</strong></li>
                                        <li id="personal"><strong>{{ __('home.Nhập OTP') }}</strong></li>
                                        <li id="confirm"><strong>{{ __('home.Hoàn thành') }}</strong></li>
                                    </ul>
                                    <div class="progress">
                                        <div class="progress-bar progress-bar-striped progress-bar-animated"
                                             role="progressbar" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <br> <!-- fieldsets -->
                                    <fieldset>
                                        <div class="form-card">
                                            <div class="row">
                                                <div class="col-7">
                                                    <h2 class="fs-title">{{ __('home.Account Information') }}:</h2>
                                                </div>
                                                <div class="col-5">
                                                    <h2 class="steps">{{ __('home.Step') }} 1 - 3</h2>
                                                </div>
                                            </div>
                                            <label class="fieldlabels">{{ __('home.Tìm tài khoản của bạn') }}</label>
                                            <select class="custom-select" name="type_account" id="type_account"
                                                    onchange="reloadLabel()">
                                                <option value="{{ CommonType::EMAIL }}">{{ __('home.Email') }}</option>
                                                <option value="{{ CommonType::PHONE }}">{{ __('home.Phone Number') }}</option>
                                            </select>
                                            <label class="fieldlabels" id="label-account-info">{{ __('home.Email') }}: *</label>
                                            <input type="text" required class="form-control" id="valueFindUser"
                                            />
                                        </div>
                                        <input type="button" onclick="sendOTP(this)" name="next"
                                               class="next btn btn-primary mt-2" value="Next"/>
                                    </fieldset>
                                    <fieldset>
                                        <div class="form-card">
                                            <div class="row">
                                                <div class="col-7">
                                                    <h2 class="fs-title">{{ __('home.Đổi mật khẩu') }} </h2>
                                                </div>
                                                <div class="col-5">
                                                    <h2 class="steps">{{ __('home.Step') }} 2 - 3</h2>
                                                </div>
                                            </div>
                                            <label class="fieldlabels">OTP</label>
                                            <input type="number" maxlength="6" class="form-control"
                                                   id="forget-password-otp"
                                            />

                                            <label class="fieldlabels" id="label-account-info">{{ __('home.Mật khẩu mới') }}</label>
                                            <input type="password" class="form-control" id="forget-new-password"/>

                                            <label class="fieldlabels" id="label-account-info">{{ __('home.Nhập lại mật khẩu') }}</label>
                                            <input type="password" class="form-control" id="forget-re-new-password"/>
                                        </div>
                                        <input type="button" name="previous" class="previous btn btn-secondary mt-2"
                                               value="Previous"/>
                                        <input type="button" name="next" class="next btn btn-primary mt-2"
                                               onclick="checkOTP(this)"
                                               value="Next"/>

                                    </fieldset>
                                    <fieldset>
                                        <div class="form-card">
                                            <div class="row">
                                                <div class="col-7">
                                                    <h2 class="fs-title">{{ __('home.Finish') }}:</h2>
                                                </div>
                                                <div class="col-5">
                                                    <h2 class="steps">{{ __('home.Step') }} 3 - 3</h2>
                                                </div>
                                            </div>
                                            <br><br>
                                            <h2 class="purple-text text-center"><strong>{{ __('home.SUCCESS') }} !</strong></h2> <br>
                                            <br><br>
                                            <div class="row justify-content-center">
                                                <div class="col-7 text-center">
                                                    <h5 class="purple-text text-center">{{ __('home.You Have Successfully Signed Up') }}</h5>
                                                </div>
                                            </div>
                                        </div>
                                    </fieldset>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('home.Close') }}</button>
            </div>
        </div>
    </div>
</div>

{{--script modal forget password--}}
<script>
    var steps = $("fieldset").length;

    var current_fs, next_fs, previous_fs; //fieldsets
    var opacity;
    var current = 1;
    setProgressBar(current);

    let isNextStep = false;

    function reloadLabel() {
        // document.getElementById('label-account-info').innerHTML = document.getElementById('type_account').value + ': *';
        let type = document.getElementById('type_account').value;
        switch (type) {
            case '{{ CommonType::EMAIL }}':
                document.getElementById('label-account-info').innerHTML = 'Email: *';
                // change type input
                document.getElementById('valueFindUser').type = 'email';
                break;
            case '{{ CommonType::PHONE }}':
                document.getElementById('label-account-info').innerHTML = 'Phone: *';
                // change type input
                document.getElementById('valueFindUser').type = 'number';
                break;
        }

    }

    function sendOTP(element) {
        loadingMasterPage();

        let value = document.getElementById('valueFindUser').value;
        let type_account = document.getElementById('type_account').value;

        let url = '{{ route('user.forget.password.send') }}';
        let data = {
            'type': type_account,
            'value': value
        };

        $.ajax({
            url: url,
            type: 'POST',
            dataType: 'json',
            data: data,
            success: function (data) {
                loadingMasterPage();
                goToNextStep(element);
            },
            error: function (data) {
                loadingMasterPage();
                alert(data.responseJSON);
            }
        });
    }

    function checkOTP(element) {
        let otp = document.getElementById('forget-password-otp').value;
        let value = document.getElementById('valueFindUser').value;
        let type_account = document.getElementById('type_account').value;

        let password = document.getElementById('forget-new-password').value;
        let rePassword = document.getElementById('forget-re-new-password').value;

        // check password min length 8
        if (password.length < 8) {
            alert('Mật khẩu phải có ít nhất 8 ký tự');
            return;
        }

        if (password !== rePassword) {
            alert('Mật khẩu không trùng khớp');
            return;
        }

        loadingMasterPage();

        let url = '{{ route('user.forget.password.check') }}';

        let data = {
            'type': type_account,
            'value': value,
            'otp': otp,
            'password': password,
            'rePassword': rePassword
        };

        $.ajax({
            url: url,
            type: 'POST',
            dataType: 'json',
            data: data,
            success: function (data) {
                goToNextStep(element)
                loadingMasterPage();
                alert(data);
            },
            error: function (data) {
                loadingMasterPage();
                alert(data.responseJSON);
            }
        });
    }

    function goToNextStep(element) {
        current_fs = $(element).parent();
        next_fs = $(element).parent().next();

//Add Class Active
        $("#progressbar li").eq($("fieldset").index(next_fs)).addClass("active");

//show the next fieldset
        next_fs.show();
//hide the current fieldset with style
        current_fs.animate({opacity: 0}, {
            step: function (now) {
// for making fielset appear animation
                opacity = 1 - now;

                current_fs.css({
                    'display': 'none',
                    'position': 'relative'
                });
                next_fs.css({'opacity': opacity});
            },
            duration: 500
        });
        setProgressBar(++current);
    }

    $(document).ready(function () {

        $(".previous").click(function () {

            current_fs = $(this).parent();
            previous_fs = $(this).parent().prev();

//Remove class active
            $("#progressbar li").eq($("fieldset").index(current_fs)).removeClass("active");

//show the previous fieldset
            previous_fs.show();

//hide the current fieldset with style
            current_fs.animate({opacity: 0}, {
                step: function (now) {
// for making fielset appear animation
                    opacity = 1 - now;

                    current_fs.css({
                        'display': 'none',
                        'position': 'relative'
                    });
                    previous_fs.css({'opacity': opacity});
                },
                duration: 500
            });
            setProgressBar(--current);
        });


        $(".submit").click(function () {
            return false;
        })

    });

    function setProgressBar(curStep) {
        var percent = parseFloat(100 / steps) * curStep;
        percent = percent.toFixed();
        $(".progress-bar")
            .css("width", percent + "%")
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
                case 'NORMAL':
                    html = `<option value="{{Role::PAITENTS}}">PAITENTS</option>
                                                <option value="{{Role::NORMAL_PEOPLE}}">NORMAL PEOPLE</option>`;
                    break;
                default:
                    html = ``;
                    break;
            }
            $('#member').empty().append(html);

            let type = $(this).val();
            loadData(type);
        });

        function loadData(value) {
            loadDoctor(value);
            loadHospital(value);
            loadNormal(value);
        }

        function loadDoctor(value) {
            if (value == '{{Role::MEDICAL}}') {
                $('#element-doctor').show();
                $('#name_doctor').attr('required', true);
                $('#identifier').attr('required', true);
                $('#contact_phone').attr('required', true);
                $('#experience').attr('required', true);
                $('#hospital').attr('required', true);
                $('#rate').attr('required', true);
                $('#specialized_services').attr('required', true);
                $('#services_info').attr('required', true);
                $('#action-doctor').show();
            } else {
                $('#element-doctor').hide();
                $('#name_doctor').attr('required', false);
                $('#identifier').attr('required', false);
                $('#contact_phone').attr('required', false);
                $('#experience').attr('required', false);
                $('#hospital').attr('required', false);
                $('#rate').attr('required', false);
                $('#specialized_services').attr('required', false);
                $('#services_info').attr('required', false);
                $('#action-doctor').hide();
            }
        }

        function loadHospital(value) {
            if (value == '{{Role::BUSINESS}}') {
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
                $('#action-doctor').show();
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
                $('#action-doctor').hide();
            }
        }
        function loadNormal(value) {
            if (value == '{{Role::NORMAL}}') {
                $('#element-normal').show();
            } else {
                $('#element-normal').hide();
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

