@php
    use App\Models\Province;
@endphp
@extends('layouts.master')
@section('title', 'Home')
@section('content')
    <style>
        /*d none when size = sm*/
        @media (max-width: 480px) {
            .d-sm-block {
                display: block !important;
            }
        }

        /*d block when size = md*/
        @media (min-width: 481px) {
            .d-md-block {
                display: block !important;
            }
        }

        *, *:before, *:after {
            box-sizing: border-box;
        }

        img {
            max-width: auto;
            height: auto;
        }

        .container {
            /*max-width: 1170px;*/
            width: 100%;
            /*margin: auto;*/
        }

        .carousel {
            margin-top: 50px;
            margin-bottom: 50px;
        }

        .carousel img {
            padding: 0px 2px;
        }

        @media screen and (max-width: 1200px) {
            .container {
                max-width: 100%;
            }
        }

        @media screen and (max-width: 1024px) {
            .carousel img {
                width: 100%;
            }
        }

        .slick-initialized .slick-prev {
            left: 40%;
            top: 725px;
        }

        .slick-initialized .slick-next {
            right: 40%;
            top: 725px;
        }

        .slick-next:before, .slick-prev:before {
            font-size: 32px !important;
            line-height: 1;
            opacity: .75;
            color: #000 !important;
        }

        .slick-dots {
            display: none !important;
        }

        .max-3-line-content {
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
            text-overflow: ellipsis;
            height: 70px;
        }
        .max-3-line-content-home {
            display: -webkit-box;
            -webkit-line-clamp: 1;
            -webkit-box-orient: vertical;
            overflow: hidden;
            text-overflow: ellipsis;
            height: 30px;
            min-height: 30px;
        }
        .webkit-line-clamp-newHome p{
            color: #FFFFFF;
            font-style: normal;
            font-weight: 800;
            line-height: normal;
            -webkit-line-clamp: 3;
            height: 70px;
            display: -webkit-box;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .sold-out-overlay {
            opacity: .5;
            pointer-events: none;
        }

        .sold-out-overlay .sold-out-overlay-text {
            position: absolute;
            color: black;
            top: 50%;
            display: block;
        }

        .prev {
            left: 15px;
            top: 45%;
        }

        .next {
            right: 15px;
            top: 45%;
        }
        .krm-tieuDe-findDoctor {
            width: 430px;
            background-color: #F2994A;
            color: white;
            border-radius: 0 0 120px 120px;
            font-size: 24px;
        }

    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.6.0/slick.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.6.0/slick-theme.min.css">
    <script src="{{ asset('https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.0/jquery.min.js') }}"></script>
    <script src="{{ asset('https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.js') }}"></script>

    <link href="{{ asset('css/style-home.css') }}" rel="stylesheet">
    @include('layouts.partials.header')

    <script src="{{ asset('build/assets/app.dba56e22.js') }}"></script>
    <div class="container d-flex pb-md-5 mt-200 mt-70">
        <div class="col-md-6 justify-content-center d-flex">
            <div class="slide-container position-relative">
                <div class="slide">
                    <img loading="lazy" src="{{asset('img/homeNew-img/Rectangle 23820.png')}}" alt="">
                </div>
                <div class="slide">
                    <img loading="lazy" src="{{asset('img/homeNew-img/Rectangle 23821.png')}}" alt="">
                </div>
                <div class="slide">
                    <img loading="lazy" src="{{asset('img/homeNew-img/Rectangle 23822.png')}}" alt="">
                </div>

                <a href="#" class="prev position-absolute" id="prev" title="Previous">
                    <svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <rect width="32" height="32" rx="16" fill="#424242" fill-opacity="0.5"/>
                        <path d="M19 10L13 16L19 22" stroke="white" stroke-width="2" stroke-linecap="round"
                              stroke-linejoin="round"/>
                    </svg>
                </a>
                <a href="#" class="next position-absolute" id="next" title="Next">
                    <svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <rect width="32" height="32" rx="16" fill="#424242" fill-opacity="0.5"/>
                        <path d="M13 22L19 16L13 10" stroke="white" stroke-width="2" stroke-linecap="round"
                              stroke-linejoin="round"/>
                    </svg>
                </a>
                <div class="dots-container position-absolute">
                    <span class="dot"></span>
                    <span class="dot"></span>
                    <span class="dot"></span>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="mainServiceHomeNew row">
                <div class="col-md-4">
                    <a href="#">
                        <div class="border-HomeNew align-items-center justify-content-center">
                            <div class="">
                                <div class="d-flex justify-content-center krm-select-bt">
                                    <svg width="101" height="94" viewBox="0 0 101 94" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <g filter="url(#filter0_f_7069_19741)">
                                            <circle cx="50.6875" cy="43.1875" r="15.9375" fill="#FFC700" fill-opacity="0.5"/>
                                        </g>
                                        <g clip-path="url(#clip0_7069_19741)">
                                            <mask id="mask0_7069_19741" style="mask-type:luminance" maskUnits="userSpaceOnUse" x="31" y="23" width="40" height="41">
                                                <path d="M31 23.5H71V63.5H31V23.5Z" fill="white"/>
                                            </mask>
                                            <g mask="url(#mask0_7069_19741)">
                                                <path d="M69.8281 63.5H58.8906C58.2434 63.5 57.7188 62.9753 57.7188 62.3281V61.5469C57.7188 57.8852 60.6977 54.9063 64.3594 54.9063C68.021 54.9063 71 57.8852 71 61.5469V62.3281C71 62.9753 70.4753 63.5 69.8281 63.5Z" fill="#FFF064"/>
                                                <path d="M69.8281 63.5C70.4753 63.5 71 62.9753 71 62.3281V61.5469C71 57.8852 68.021 54.9063 64.3594 54.9063V63.5H69.8281Z" fill="#FFDC1E"/>
                                                <path d="M64.3594 57.25C61.7747 57.25 59.6719 55.1472 59.6719 52.5625C59.6719 49.9778 61.7747 47.875 64.3594 47.875C66.9441 47.875 69.0469 49.9778 69.0469 52.5625C69.0469 55.1472 66.9441 57.25 64.3594 57.25Z" fill="#FFD0AF"/>
                                                <path d="M64.3594 47.875V57.25C66.944 57.25 69.0469 55.1472 69.0469 52.5625C69.0469 49.9779 66.944 47.875 64.3594 47.875Z" fill="#FABE8C"/>
                                                <path d="M43.1094 39.125H32.1719C31.5247 39.125 31 38.6003 31 37.9531V37.1719C31 33.5102 33.979 30.5313 37.6406 30.5313C41.3023 30.5313 44.2812 33.5102 44.2812 37.1719V37.9531C44.2812 38.6003 43.7566 39.125 43.1094 39.125Z" fill="#00AFFF"/>
                                                <path d="M43.1094 39.125C43.7566 39.125 44.2812 38.6003 44.2812 37.9531V37.1719C44.2812 33.5102 41.3023 30.5313 37.6406 30.5313V39.125H43.1094Z" fill="#008CFA"/>
                                                <path d="M37.6406 32.875C35.0559 32.875 32.9531 30.7722 32.9531 28.1875C32.9531 25.6028 35.0559 23.5 37.6406 23.5C40.2253 23.5 42.3281 25.6028 42.3281 28.1875C42.3281 30.7722 40.2253 32.875 37.6406 32.875Z" fill="#FFD0AF"/>
                                                <path d="M37.6406 23.5V32.875C40.2252 32.875 42.3281 30.7721 42.3281 28.1875C42.3281 25.6028 40.2252 23.5 37.6406 23.5Z" fill="#FABE8C"/>
                                                <path d="M69.8281 39.125H58.8906C58.2434 39.125 57.7188 38.6003 57.7188 37.9531V37.1719C57.7188 33.5102 60.6977 30.5313 64.3594 30.5313C68.021 30.5313 71 33.5102 71 37.1719V37.9531C71 38.6003 70.4753 39.125 69.8281 39.125Z" fill="#64E6E6"/>
                                                <path d="M69.8281 39.125C70.4753 39.125 71 38.6003 71 37.9531V37.1719C71 33.5102 68.021 30.5313 64.3594 30.5313V39.125H69.8281Z" fill="#00CDCD"/>
                                                <path d="M64.3594 32.875C61.7747 32.875 59.6719 30.7722 59.6719 28.1875C59.6719 25.6028 61.7747 23.5 64.3594 23.5C66.9441 23.5 69.0469 25.6028 69.0469 28.1875C69.0469 30.7722 66.9441 32.875 64.3594 32.875Z" fill="#FFD0AF"/>
                                                <path d="M64.3594 23.5V32.875C66.944 32.875 69.0469 30.7721 69.0469 28.1875C69.0469 25.6028 66.944 23.5 64.3594 23.5Z" fill="#FABE8C"/>
                                                <path d="M48.1882 50.1773C48.1847 50.1819 48.193 50.174 48.1889 50.178L35.6679 62.6991C34.6 63.767 32.8687 63.767 31.8009 62.6991L31.8009 62.6991C30.733 61.6312 30.733 59.9 31.8009 58.8321L44.322 46.3111L48.1882 50.1773Z" fill="#C8E1F5"/>
                                                <path d="M35.6678 62.6991L48.1889 50.178C48.193 50.174 48.1846 50.1819 48.1881 50.1773L46.2554 48.2445L31.8008 62.6991C32.8687 63.767 34.6 63.767 35.6678 62.6991Z" fill="#AACDE6"/>
                                                <path d="M41.625 43.5C41.625 48.6777 45.8223 52.875 51 52.875C56.1777 52.875 60.375 48.6777 60.375 43.5C60.375 38.3223 56.1777 34.125 51 34.125C45.8223 34.125 41.625 38.3223 41.625 43.5Z" fill="#E1F5FF"/>
                                                <path d="M44.3711 50.1291C46.0677 51.8257 48.4113 52.875 51.0002 52.875C56.1779 52.875 60.3752 48.6777 60.3752 43.5C60.3752 40.9112 59.3259 38.5674 57.6294 36.8709L44.3711 50.1291Z" fill="#C8E1F5"/>
                                                <path d="M51.0002 52.875C53.54 52.875 55.8436 51.8645 57.5319 50.2242C57.2901 48.8555 56.6265 47.5986 55.6123 46.6165C54.3693 45.4129 52.7315 44.75 51.0005 44.75H51.0002C49.2692 44.75 47.6314 45.4129 46.3884 46.6165C45.3741 47.5987 44.7105 48.8557 44.4688 50.2245C46.157 51.8646 48.4605 52.875 51.0002 52.875Z" fill="#FF823C"/>
                                                <path d="M44.4688 50.2245C46.157 51.8646 48.4604 52.875 51.0002 52.875C53.54 52.875 55.8435 51.8645 57.5319 50.2242C57.29 48.8555 56.6264 47.5986 55.6123 46.6165C54.3692 45.4129 52.7314 44.75 51.0005 44.75H51.0002C50.5244 44.75 50.0561 44.8018 49.6006 44.8995L44.517 49.9831C44.4997 50.0633 44.483 50.1435 44.4688 50.2245Z" fill="#F06923"/>
                                                <path d="M42.7969 43.5C42.7969 48.0232 46.4768 51.7031 51 51.7031C55.5232 51.7031 59.2031 48.0232 59.2031 43.5C59.2031 38.9768 55.5232 35.2969 51 35.2969C46.4768 35.2969 42.7969 38.9768 42.7969 43.5ZM40.4531 43.5C40.4531 37.6845 45.1845 32.9531 51 32.9531C56.8155 32.9531 61.5469 37.6845 61.5469 43.5C61.5469 49.3155 56.8155 54.0469 51 54.0469C45.1845 54.0469 40.4531 49.3155 40.4531 43.5Z" fill="#556E87"/>
                                                <path d="M56.7979 37.7023C58.2833 39.1877 59.2033 41.2384 59.2033 43.5C59.2033 48.0232 55.5234 51.7031 51.0002 51.7031C48.7386 51.7031 46.6878 50.7832 45.2024 49.2978L43.5459 50.9543C45.4557 52.8641 48.0924 54.0469 51.0002 54.0469C56.8157 54.0469 61.5471 49.3156 61.5471 43.5C61.5471 40.5923 60.3642 37.9555 58.4545 36.0457L56.7979 37.7023Z" fill="#435569"/>
                                                <path d="M47.6852 39.0919C49.5129 37.2643 52.4867 37.2643 54.3143 39.0919C56.142 40.9196 56.142 43.8934 54.3143 45.7211C52.4867 47.5487 49.5129 47.5487 47.6852 45.7211C45.8575 43.8934 45.8575 40.9196 47.6852 39.0919Z" fill="#FFD0AF"/>
                                                <path d="M48.2783 46.2226C50.1082 47.5293 52.6733 47.363 54.3146 45.7216C55.956 44.0804 56.1223 41.5151 54.8157 39.6853L48.2783 46.2226Z" fill="#FABE8C"/>
                                            </g>
                                        </g>
                                        <defs>
                                            <filter id="filter0_f_7069_19741" x="0.75" y="-6.75" width="99.875" height="99.875" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                                                <feFlood flood-opacity="0" result="BackgroundImageFix"/>
                                                <feBlend mode="normal" in="SourceGraphic" in2="BackgroundImageFix" result="shape"/>
                                                <feGaussianBlur stdDeviation="17" result="effect1_foregroundBlur_7069_19741"/>
                                            </filter>
                                            <clipPath id="clip0_7069_19741">
                                                <rect width="40" height="40" fill="white" transform="translate(31 23.5)"/>
                                            </clipPath>
                                        </defs>
                                    </svg>
                                </div>
                                <div>
                                    <span class="justify-content-center d-flex">{{ __('home.Recruitment') }}</span></div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-md-4">
                    <a href="{{route('home.specialist')}}">
                        <div class="border-HomeNew align-items-center justify-content-center">
                            <div class="">
                                <div class="d-flex justify-content-center krm-select-bt">
                                    <svg width="101" height="94" viewBox="0 0 101 94" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <g filter="url(#filter0_f_7456_1186)">
                                            <circle cx="50.3125" cy="43.8125" r="15.9375" fill="#FFC700" fill-opacity="0.5"/>
                                        </g>
                                        <g clip-path="url(#clip0_7456_1186)">
                                            <path d="M31.0459 46.9473H68.9544V60.685H31.0459V46.9473Z" fill="url(#paint0_linear_7456_1186)"/>
                                            <path d="M31.0459 46.9473H68.9544V54.0876H31.0459V46.9473Z" fill="url(#paint1_linear_7456_1186)"/>
                                            <path d="M58.7061 46.9473H68.9544V60.685H58.7061V46.9473Z" fill="url(#paint2_linear_7456_1186)"/>
                                            <path d="M34.9355 46.9473H45.1839V60.685H34.9355V46.9473Z" fill="url(#paint3_linear_7456_1186)"/>
                                            <path d="M69.0135 49.0324H30.9865C30.4416 49.0324 30 48.5907 30 48.0459V45.8498C30 45.3049 30.4416 44.8633 30.9865 44.8633H69.0135C69.5584 44.8633 70 45.3049 70 45.8498V48.0459C70 48.5907 69.5584 49.0324 69.0135 49.0324Z" fill="url(#paint4_linear_7456_1186)"/>
                                            <path d="M59.9402 63.5009H40.0601V29.9762C40.0601 28.929 40.909 28.0801 41.9562 28.0801H58.0441C59.0913 28.0801 59.9402 28.929 59.9402 29.9762V63.5009Z" fill="url(#paint5_linear_7456_1186)"/>
                                            <path d="M53.4293 63.4995H46.571C46.0407 63.4995 45.6108 63.0697 45.6108 62.5394V51.4777C45.6108 50.9475 46.0407 50.5176 46.571 50.5176H53.4293C53.9596 50.5176 54.3895 50.9475 54.3895 51.4777V62.5394C54.3895 63.0697 53.9596 63.4995 53.4293 63.4995Z" fill="url(#paint6_linear_7456_1186)"/>
                                            <path d="M52.7476 63.5004H47.2527C46.7919 63.5004 46.4185 63.1269 46.4185 62.6662V52.3244C46.4185 51.8637 46.7919 51.4902 47.2527 51.4902H52.7476C53.2083 51.4902 53.5818 51.8637 53.5818 52.3244V62.6662C53.5818 63.1269 53.2083 63.5004 52.7476 63.5004Z" fill="url(#paint7_linear_7456_1186)"/>
                                            <path d="M52.7475 51.4902H50V63.5004H52.7475C53.2082 63.5004 53.5816 63.1269 53.5816 62.6662V52.3244C53.5817 51.8637 53.2082 51.4902 52.7475 51.4902Z" fill="url(#paint8_linear_7456_1186)"/>
                                            <path d="M58.0441 28.0801H45.6108V29.9301L59.9403 44.2595V29.9762C59.9403 28.9289 59.0913 28.0801 58.0441 28.0801Z" fill="url(#paint9_linear_7456_1186)"/>
                                            <path d="M54.0345 26.0972H52.5269C52.2261 26.0972 51.9822 25.8533 51.9822 25.5524V24.0448C51.9822 23.7439 51.7382 23.5 51.4374 23.5H48.5629C48.262 23.5 48.0181 23.7439 48.0181 24.0448V25.5524C48.0181 25.8533 47.7742 26.0972 47.4733 26.0972H45.9657C45.6648 26.0972 45.4209 26.3411 45.4209 26.642V29.5165C45.4209 29.8173 45.6648 30.0613 45.9657 30.0613H47.4733C47.7742 30.0613 48.0181 30.3052 48.0181 30.606V32.1136C48.0181 32.4145 48.262 32.6584 48.5629 32.6584H51.4374C51.7382 32.6584 51.9822 32.4145 51.9822 32.1136V30.606C51.9822 30.3051 52.2261 30.0612 52.5269 30.0612H54.0345C54.3354 30.0612 54.5793 29.8173 54.5793 29.5164V26.6419C54.5793 26.341 54.3354 26.0972 54.0345 26.0972Z" fill="url(#paint10_linear_7456_1186)"/>
                                            <path d="M69.0135 63.4992H30.9865C30.4416 63.4992 30 63.0575 30 62.5127V60.3166C30 59.7717 30.4416 59.3301 30.9865 59.3301H69.0135C69.5584 59.3301 70 59.7717 70 60.3166V62.5127C70 63.0575 69.5584 63.4992 69.0135 63.4992Z" fill="url(#paint11_linear_7456_1186)"/>
                                            <path d="M47.7879 41.3447H43.4337C42.8705 41.3447 42.4141 40.8882 42.4141 40.3251V35.9708C42.4141 35.4076 42.8705 34.9512 43.4337 34.9512H47.7879C48.3511 34.9512 48.8076 35.4076 48.8076 35.9708V40.3251C48.8076 40.8882 48.3511 41.3447 47.7879 41.3447Z" fill="url(#paint12_linear_7456_1186)"/>
                                            <path d="M47.1191 40.3636H44.102C43.7118 40.3636 43.3955 40.0473 43.3955 39.6571V36.6401C43.3955 36.2499 43.7118 35.9336 44.102 35.9336H47.1191C47.5093 35.9336 47.8256 36.2499 47.8256 36.6401V39.6571C47.8256 40.0473 47.5093 40.3636 47.1191 40.3636Z" fill="url(#paint13_linear_7456_1186)"/>
                                            <path d="M56.5668 41.3447H52.2125C51.6493 41.3447 51.1929 40.8882 51.1929 40.3251V35.9708C51.1929 35.4076 51.6493 34.9512 52.2125 34.9512H56.5668C57.1299 34.9512 57.5864 35.4076 57.5864 35.9708V40.3251C57.5864 40.8882 57.1299 41.3447 56.5668 41.3447Z" fill="url(#paint14_linear_7456_1186)"/>
                                            <path d="M55.8984 40.3636H52.8813C52.4911 40.3636 52.1748 40.0473 52.1748 39.6571V36.6401C52.1748 36.2499 52.4911 35.9336 52.8813 35.9336H55.8983C56.2885 35.9336 56.6048 36.2499 56.6048 36.6401V39.6571C56.6048 40.0473 56.2885 40.3636 55.8984 40.3636Z" fill="url(#paint15_linear_7456_1186)"/>
                                            <path d="M47.7879 49.0322H43.4337C42.8705 49.0322 42.4141 48.5757 42.4141 48.0126V43.6583C42.4141 43.0951 42.8705 42.6387 43.4337 42.6387H47.7879C48.3511 42.6387 48.8076 43.0951 48.8076 43.6583V48.0126C48.8076 48.5757 48.3511 49.0322 47.7879 49.0322Z" fill="url(#paint16_linear_7456_1186)"/>
                                            <path d="M47.1191 48.0511H44.102C43.7118 48.0511 43.3955 47.7348 43.3955 47.3446V44.3276C43.3955 43.9374 43.7118 43.6211 44.102 43.6211H47.1191C47.5093 43.6211 47.8256 43.9374 47.8256 44.3276V47.3446C47.8256 47.7348 47.5093 48.0511 47.1191 48.0511Z" fill="url(#paint17_linear_7456_1186)"/>
                                            <path d="M56.5668 49.0322H52.2125C51.6493 49.0322 51.1929 48.5757 51.1929 48.0126V43.6583C51.1929 43.0951 51.6493 42.6387 52.2125 42.6387H56.5668C57.1299 42.6387 57.5864 43.0951 57.5864 43.6583V48.0126C57.5864 48.5757 57.1299 49.0322 56.5668 49.0322Z" fill="url(#paint18_linear_7456_1186)"/>
                                            <path d="M55.8984 48.0511H52.8813C52.4911 48.0511 52.1748 47.7348 52.1748 47.3446V44.3276C52.1748 43.9374 52.4911 43.6211 52.8813 43.6211H55.8983C56.2885 43.6211 56.6048 43.9374 56.6048 44.3276V47.3446C56.6048 47.7348 56.2885 48.0511 55.8984 48.0511Z" fill="url(#paint19_linear_7456_1186)"/>
                                            <path d="M37.4764 57.4853H33.1221C32.559 57.4853 32.1025 57.0288 32.1025 56.4657V52.1114C32.1025 51.5483 32.559 51.0918 33.1221 51.0918H37.4764C38.0396 51.0918 38.496 51.5483 38.496 52.1114V56.4657C38.496 57.0288 38.0396 57.4853 37.4764 57.4853Z" fill="url(#paint20_linear_7456_1186)"/>
                                            <path d="M36.8081 56.5043H33.791C33.4008 56.5043 33.0845 56.1879 33.0845 55.7977V52.7807C33.0845 52.3905 33.4008 52.0742 33.791 52.0742H36.8081C37.1983 52.0742 37.5146 52.3905 37.5146 52.7807V55.7977C37.5145 56.1879 37.1982 56.5043 36.8081 56.5043Z" fill="url(#paint21_linear_7456_1186)"/>
                                            <path d="M66.8783 57.4853H62.524C61.9609 57.4853 61.5044 57.0288 61.5044 56.4657V52.1114C61.5044 51.5483 61.9609 51.0918 62.524 51.0918H66.8783C67.4414 51.0918 67.8979 51.5483 67.8979 52.1114V56.4657C67.8979 57.0288 67.4414 57.4853 66.8783 57.4853Z" fill="url(#paint22_linear_7456_1186)"/>
                                            <path d="M66.2099 56.5043H63.1928C62.8026 56.5043 62.4863 56.1879 62.4863 55.7977V52.7807C62.4863 52.3905 62.8026 52.0742 63.1928 52.0742H66.2099C66.6001 52.0742 66.9164 52.3905 66.9164 52.7807V55.7977C66.9164 56.1879 66.6001 56.5043 66.2099 56.5043Z" fill="url(#paint23_linear_7456_1186)"/>
                                        </g>
                                        <defs>
                                            <filter id="filter0_f_7456_1186" x="0.375" y="-6.125" width="99.875" height="99.875" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                                                <feFlood flood-opacity="0" result="BackgroundImageFix"/>
                                                <feBlend mode="normal" in="SourceGraphic" in2="BackgroundImageFix" result="shape"/>
                                                <feGaussianBlur stdDeviation="17" result="effect1_foregroundBlur_7456_1186"/>
                                            </filter>
                                            <linearGradient id="paint0_linear_7456_1186" x1="31.0459" y1="53.8161" x2="68.9544" y2="53.8161" gradientUnits="userSpaceOnUse">
                                                <stop stop-color="#D8ECFE"/>
                                                <stop offset="1" stop-color="#A8D3D8"/>
                                            </linearGradient>
                                            <linearGradient id="paint1_linear_7456_1186" x1="50.0002" y1="52.2575" x2="50.0002" y2="49.0641" gradientUnits="userSpaceOnUse">
                                                <stop stop-color="#A8D3D8" stop-opacity="0"/>
                                                <stop offset="1" stop-color="#6CABCA"/>
                                            </linearGradient>
                                            <linearGradient id="paint2_linear_7456_1186" x1="63.1505" y1="53.8161" x2="59.7939" y2="53.8161" gradientUnits="userSpaceOnUse">
                                                <stop stop-color="#A8D3D8" stop-opacity="0"/>
                                                <stop offset="1" stop-color="#6CABCA"/>
                                            </linearGradient>
                                            <linearGradient id="paint3_linear_7456_1186" x1="37.5292" y1="53.8161" x2="44.9763" y2="53.8161" gradientUnits="userSpaceOnUse">
                                                <stop stop-color="#A8D3D8" stop-opacity="0"/>
                                                <stop offset="1" stop-color="#6CABCA"/>
                                            </linearGradient>
                                            <linearGradient id="paint4_linear_7456_1186" x1="49.8367" y1="44.1305" x2="50.255" y2="51.3462" gradientUnits="userSpaceOnUse">
                                                <stop stop-color="#98D5B9"/>
                                                <stop offset="1" stop-color="#1E9C6F"/>
                                            </linearGradient>
                                            <linearGradient id="paint5_linear_7456_1186" x1="39.0428" y1="38.5318" x2="65.1274" y2="56.897" gradientUnits="userSpaceOnUse">
                                                <stop stop-color="#D8ECFE"/>
                                                <stop offset="1" stop-color="#A8D3D8"/>
                                            </linearGradient>
                                            <linearGradient id="paint6_linear_7456_1186" x1="53.5986" y1="60.607" x2="44.4429" y2="51.4513" gradientUnits="userSpaceOnUse">
                                                <stop stop-color="#D8ECFE"/>
                                                <stop offset="1" stop-color="#A8D3D8"/>
                                            </linearGradient>
                                            <linearGradient id="paint7_linear_7456_1186" x1="46.9243" y1="54.4194" x2="51.0632" y2="58.5585" gradientUnits="userSpaceOnUse">
                                                <stop stop-color="#5A5A5A"/>
                                                <stop offset="1" stop-color="#444444"/>
                                            </linearGradient>
                                            <linearGradient id="paint8_linear_7456_1186" x1="48.9935" y1="54.9423" x2="52.4289" y2="58.3777" gradientUnits="userSpaceOnUse">
                                                <stop stop-color="#433F43" stop-opacity="0"/>
                                                <stop offset="1" stop-color="#1A1A1A"/>
                                            </linearGradient>
                                            <linearGradient id="paint9_linear_7456_1186" x1="55.4901" y1="35.9689" x2="51.3333" y2="26.4525" gradientUnits="userSpaceOnUse">
                                                <stop stop-color="#A8D3D8" stop-opacity="0"/>
                                                <stop offset="1" stop-color="#6CABCA"/>
                                            </linearGradient>
                                            <linearGradient id="paint10_linear_7456_1186" x1="47.5435" y1="25.6225" x2="53.1952" y2="31.2742" gradientUnits="userSpaceOnUse">
                                                <stop stop-color="#FD4755"/>
                                                <stop offset="1" stop-color="#A72B2B"/>
                                            </linearGradient>
                                            <linearGradient id="paint11_linear_7456_1186" x1="49.8367" y1="58.5973" x2="50.255" y2="65.813" gradientUnits="userSpaceOnUse">
                                                <stop stop-color="#5A5A5A"/>
                                                <stop offset="1" stop-color="#444444"/>
                                            </linearGradient>
                                            <linearGradient id="paint12_linear_7456_1186" x1="48.6494" y1="41.1865" x2="40.9797" y2="33.5168" gradientUnits="userSpaceOnUse">
                                                <stop stop-color="#D8ECFE"/>
                                                <stop offset="1" stop-color="#A8D3D8"/>
                                            </linearGradient>
                                            <linearGradient id="paint13_linear_7456_1186" x1="42.1786" y1="34.7166" x2="47.4545" y2="39.9925" gradientUnits="userSpaceOnUse">
                                                <stop stop-color="#FFDFCF"/>
                                                <stop offset="1" stop-color="#0593FC"/>
                                            </linearGradient>
                                            <linearGradient id="paint14_linear_7456_1186" x1="57.4282" y1="41.1865" x2="49.7585" y2="33.5168" gradientUnits="userSpaceOnUse">
                                                <stop stop-color="#D8ECFE"/>
                                                <stop offset="1" stop-color="#A8D3D8"/>
                                            </linearGradient>
                                            <linearGradient id="paint15_linear_7456_1186" x1="50.9578" y1="34.7166" x2="56.2337" y2="39.9925" gradientUnits="userSpaceOnUse">
                                                <stop stop-color="#FFDFCF"/>
                                                <stop offset="1" stop-color="#0593FC"/>
                                            </linearGradient>
                                            <linearGradient id="paint16_linear_7456_1186" x1="48.6494" y1="48.874" x2="40.9797" y2="41.2043" gradientUnits="userSpaceOnUse">
                                                <stop stop-color="#D8ECFE"/>
                                                <stop offset="1" stop-color="#A8D3D8"/>
                                            </linearGradient>
                                            <linearGradient id="paint17_linear_7456_1186" x1="42.1786" y1="42.4041" x2="47.4545" y2="47.68" gradientUnits="userSpaceOnUse">
                                                <stop stop-color="#FFDFCF"/>
                                                <stop offset="1" stop-color="#0593FC"/>
                                            </linearGradient>
                                            <linearGradient id="paint18_linear_7456_1186" x1="57.4282" y1="48.874" x2="49.7585" y2="41.2043" gradientUnits="userSpaceOnUse">
                                                <stop stop-color="#D8ECFE"/>
                                                <stop offset="1" stop-color="#A8D3D8"/>
                                            </linearGradient>
                                            <linearGradient id="paint19_linear_7456_1186" x1="50.9578" y1="42.4041" x2="56.2337" y2="47.68" gradientUnits="userSpaceOnUse">
                                                <stop stop-color="#FFDFCF"/>
                                                <stop offset="1" stop-color="#0593FC"/>
                                            </linearGradient>
                                            <linearGradient id="paint20_linear_7456_1186" x1="38.3378" y1="57.3271" x2="30.6682" y2="49.6574" gradientUnits="userSpaceOnUse">
                                                <stop stop-color="#D8ECFE"/>
                                                <stop offset="1" stop-color="#A8D3D8"/>
                                            </linearGradient>
                                            <linearGradient id="paint21_linear_7456_1186" x1="31.8675" y1="50.8572" x2="37.1434" y2="56.1331" gradientUnits="userSpaceOnUse">
                                                <stop stop-color="#FFDFCF"/>
                                                <stop offset="1" stop-color="#0593FC"/>
                                            </linearGradient>
                                            <linearGradient id="paint22_linear_7456_1186" x1="67.7397" y1="57.3271" x2="60.07" y2="49.6574" gradientUnits="userSpaceOnUse">
                                                <stop stop-color="#D8ECFE"/>
                                                <stop offset="1" stop-color="#A8D3D8"/>
                                            </linearGradient>
                                            <linearGradient id="paint23_linear_7456_1186" x1="61.2693" y1="50.8572" x2="66.5452" y2="56.1331" gradientUnits="userSpaceOnUse">
                                                <stop stop-color="#FFDFCF"/>
                                                <stop offset="1" stop-color="#0593FC"/>
                                            </linearGradient>
                                            <clipPath id="clip0_7456_1186">
                                                <rect width="40" height="40" fill="white" transform="translate(30 23.5)"/>
                                            </clipPath>
                                        </defs>
                                    </svg>
                                </div>
                                <div>
                                    <span class="justify-content-center d-flex">{{ __('home.Đặt lịch khám bệnh') }}</span></div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-md-4">
                    <a href="{{route('medicine')}}">
                        <div class="border-HomeNew align-items-center justify-content-center">
                            <div class="">
                                <div class="d-flex justify-content-center krm-select-bt">
                                    <svg width="98" height="93" viewBox="0 0 98 93" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <g clip-path="url(#clip0_7456_1543)">
                                            <path d="M66.7391 37.4188C68.2462 38.9258 68.9997 40.9012 68.9997 42.8758C68.9997 44.8505 68.2462 46.8258 66.7391 48.3329L60.8452 54.2268L53.7781 50.3798L49.9312 43.3127L55.8251 37.4188C58.8391 34.4047 63.725 34.4047 66.7391 37.4188Z" fill="url(#paint0_linear_7456_1543)"/>
                                            <path d="M66.7395 37.4183C68.2465 38.9253 69 40.9006 69 42.8753C69 44.85 68.2465 46.8253 66.7395 48.3323L60.8456 54.2262L53.7785 50.3793L52.6064 48.2259L64.8186 36.0137C65.5106 36.3705 66.1593 36.8382 66.7395 37.4183Z" fill="url(#paint1_linear_7456_1543)"/>
                                            <path d="M65.1185 49.954L60.8453 54.2254L53.7787 50.3789L49.9321 43.3123L54.2036 39.0391L65.1185 49.954Z" fill="url(#paint2_linear_7456_1543)"/>
                                            <path d="M49.9314 43.3125L60.8454 54.2266L54.9515 60.1205C51.9374 63.1346 47.0516 63.1346 44.0375 60.1205C42.5304 58.6134 41.7769 56.6381 41.7769 54.6634C41.7769 52.6887 42.5304 50.7134 44.0375 49.2064L49.9314 43.3125Z" fill="url(#paint3_linear_7456_1543)"/>
                                            <path d="M49.9314 43.3125L60.8454 54.2266L54.9515 60.1205C51.9374 63.1346 47.0516 63.1346 44.0375 60.1205C42.5304 58.6134 41.7769 56.6381 41.7769 54.6634C41.7769 52.6887 42.5304 50.7134 44.0375 49.2064L49.9314 43.3125Z" fill="url(#paint4_linear_7456_1543)"/>
                                            <path d="M43.7314 49.5313L54.6269 60.4267C54.7373 60.3282 54.8458 60.2264 54.9518 60.1205L60.8457 54.2266L49.9316 43.3125L44.0377 49.2064C43.9318 49.3123 43.8299 49.4209 43.7314 49.5313Z" fill="url(#paint5_linear_7456_1543)"/>
                                            <path d="M53.7257 47.1074L60.8455 54.2272L54.9516 60.1211C51.9374 63.1352 47.0516 63.1352 44.0375 60.1211C43.4574 59.541 42.9892 58.8916 42.6328 58.2002L53.7257 47.1074Z" fill="url(#paint6_linear_7456_1543)"/>
                                            <path d="M55.8252 37.4188L51.5996 41.6444L62.5137 52.5585L66.7393 48.3329C68.2463 46.8258 68.9999 44.8505 68.9998 42.8758C68.9998 40.9012 68.2463 38.9258 66.7393 37.4188C63.7252 34.4047 58.8393 34.4047 55.8252 37.4188Z" fill="url(#paint7_linear_7456_1543)"/>
                                            <path d="M53.9623 49.6986C52.4552 51.2056 50.4799 51.9591 48.5052 51.9591C46.5305 51.9591 44.5552 51.2056 43.0482 49.6986L37.1543 43.8047L41.0013 36.7376L48.0684 32.8906L53.9623 38.7845C56.9764 41.7987 56.9764 46.6845 53.9623 49.6986Z" fill="url(#paint8_linear_7456_1543)"/>
                                            <path d="M53.9623 49.6995C52.4552 51.2065 50.4799 51.96 48.5052 51.96C46.5305 51.96 44.5552 51.2065 43.0482 49.6995L37.1543 43.8055L41.0013 36.7384L43.1547 35.5664L55.3669 47.7786C55.01 48.4705 54.5424 49.1193 53.9623 49.6995Z" fill="url(#paint9_linear_7456_1543)"/>
                                            <path d="M48.0686 32.8908L37.1545 43.8048L31.2606 37.9109C28.2465 34.8968 28.2465 30.011 31.2606 26.9969C32.7676 25.4898 34.7429 24.7363 36.7176 24.7363C38.6923 24.7363 40.6676 25.4898 42.1747 26.997L48.0686 32.8908Z" fill="url(#paint10_linear_7456_1543)"/>
                                            <path d="M44.2743 36.6847L37.1545 43.8045L31.2606 37.9105C28.2465 34.8964 28.2465 30.0106 31.2606 26.9965C31.8407 26.4164 32.4901 25.9482 33.1815 25.5918L44.2743 36.6847Z" fill="url(#paint11_linear_7456_1543)"/>
                                            <path d="M53.9624 38.7842L49.7368 34.5586L38.8228 45.4727L43.0484 49.6983C44.5554 51.2053 46.5307 51.9589 48.5054 51.9588C50.4801 51.9588 52.4554 51.2053 53.9624 49.6983C56.9766 46.6841 56.9766 41.7984 53.9624 38.7842Z" fill="url(#paint12_linear_7456_1543)"/>
                                            <path d="M53.9624 38.7842L49.7368 34.5586L38.8228 45.4727L43.0484 49.6983C44.5554 51.2053 46.5307 51.9589 48.5054 51.9588C50.4801 51.9588 52.4554 51.2053 53.9624 49.6983C56.9766 46.6841 56.9766 41.7984 53.9624 38.7842Z" fill="url(#paint13_linear_7456_1543)"/>
                                            <path d="M53.9628 49.6992C52.4557 51.2063 50.4804 51.9598 48.5057 51.9598C46.531 51.9598 44.5557 51.2063 43.0487 49.6992L37.1548 43.8053L44.2746 36.6855L55.3674 47.7784C55.0105 48.4704 54.5429 49.1191 53.9628 49.6992Z" fill="url(#paint14_linear_7456_1543)"/>
                                            <path d="M56.602 39.4842C60.7074 39.4842 64.0355 36.1561 64.0355 32.0507C64.0355 27.9453 60.7074 24.6172 56.602 24.6172C52.4966 24.6172 49.1685 27.9453 49.1685 32.0507C49.1685 36.1561 52.4966 39.4842 56.602 39.4842Z" fill="url(#paint15_linear_7456_1543)"/>
                                            <path d="M62.8843 28.0764L52.6264 38.3342C51.6975 37.7441 50.9076 36.9545 50.3213 36.0254L60.5772 25.7676C61.5063 26.3576 62.2961 27.1474 62.8843 28.0764Z" fill="url(#paint16_linear_7456_1543)"/>
                                            <path d="M49.1685 32.0498C49.1685 36.1552 52.4965 39.4833 56.602 39.4833C60.7074 39.4833 64.0355 36.1552 64.0355 32.0498C64.0355 31.8442 64.0267 31.6408 64.0104 31.4395H49.1935C49.1772 31.6408 49.1685 31.8443 49.1685 32.0498Z" fill="url(#paint17_linear_7456_1543)"/>
                                            <path d="M56.6018 24.6172C56.1229 24.6172 55.6548 24.663 55.2012 24.7495V39.3518C55.6548 39.4383 56.123 39.4841 56.6018 39.4841C60.7072 39.4841 64.0353 36.156 64.0353 32.0506C64.0353 27.9452 60.7073 24.6172 56.6018 24.6172Z" fill="url(#paint18_linear_7456_1543)"/>
                                            <path d="M61.8267 26.7637L51.3149 37.2755C52.6625 38.6389 54.5334 39.484 56.6018 39.484C60.7072 39.484 64.0353 36.1559 64.0353 32.0505C64.0353 29.982 63.1902 28.1112 61.8267 26.7637Z" fill="url(#paint19_linear_7456_1543)"/>
                                        </g>
                                        <g filter="url(#filter0_f_7456_1543)">
                                            <circle cx="49" cy="43.5" r="15" fill="#FFC700" fill-opacity="0.5"/>
                                        </g>
                                        <defs>
                                            <filter id="filter0_f_7456_1543" x="0" y="-5.5" width="98" height="98" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                                                <feFlood flood-opacity="0" result="BackgroundImageFix"/>
                                                <feBlend mode="normal" in="SourceGraphic" in2="BackgroundImageFix" result="shape"/>
                                                <feGaussianBlur stdDeviation="17" result="effect1_foregroundBlur_7456_1543"/>
                                            </filter>
                                            <linearGradient id="paint0_linear_7456_1543" x1="58.4415" y1="42.0466" x2="63.2778" y2="46.8829" gradientUnits="userSpaceOnUse">
                                                <stop stop-color="#F3FAFF"/>
                                                <stop offset="1" stop-color="#D5DAF3"/>
                                            </linearGradient>
                                            <linearGradient id="paint1_linear_7456_1543" x1="59.1457" y1="42.7499" x2="65.9912" y2="49.5953" gradientUnits="userSpaceOnUse">
                                                <stop stop-color="#DBD5EF" stop-opacity="0"/>
                                                <stop offset="0.2667" stop-color="#D8D2EC" stop-opacity="0.023"/>
                                                <stop offset="0.4431" stop-color="#D1C9E2" stop-opacity="0.098"/>
                                                <stop offset="0.5933" stop-color="#C4B9D1" stop-opacity="0.225"/>
                                                <stop offset="0.7288" stop-color="#B2A4BA" stop-opacity="0.405"/>
                                                <stop offset="0.8545" stop-color="#9A889C" stop-opacity="0.638"/>
                                                <stop offset="0.9713" stop-color="#7E6678" stop-opacity="0.92"/>
                                                <stop offset="1" stop-color="#765D6E"/>
                                            </linearGradient>
                                            <linearGradient id="paint2_linear_7456_1543" x1="60.3109" y1="46.7402" x2="54.6962" y2="46.5226" gradientUnits="userSpaceOnUse">
                                                <stop stop-color="#DBD5EF" stop-opacity="0"/>
                                                <stop offset="0.2667" stop-color="#D8D2EC" stop-opacity="0.023"/>
                                                <stop offset="0.4431" stop-color="#D1C9E2" stop-opacity="0.098"/>
                                                <stop offset="0.5933" stop-color="#C4B9D1" stop-opacity="0.225"/>
                                                <stop offset="0.7288" stop-color="#B2A4BA" stop-opacity="0.405"/>
                                                <stop offset="0.8545" stop-color="#9A889C" stop-opacity="0.638"/>
                                                <stop offset="0.9713" stop-color="#7E6678" stop-opacity="0.92"/>
                                                <stop offset="1" stop-color="#765D6E"/>
                                            </linearGradient>
                                            <linearGradient id="paint3_linear_7456_1543" x1="47.8975" y1="52.5907" x2="52.7338" y2="57.4271" gradientUnits="userSpaceOnUse">
                                                <stop stop-color="#FE646F"/>
                                                <stop offset="0.235" stop-color="#FA5964"/>
                                                <stop offset="0.6415" stop-color="#EF3D49"/>
                                                <stop offset="1" stop-color="#E41F2D"/>
                                            </linearGradient>
                                            <linearGradient id="paint4_linear_7456_1543" x1="51.32" y1="54.7165" x2="51.0154" y2="48.7536" gradientUnits="userSpaceOnUse">
                                                <stop stop-color="#A72B2B" stop-opacity="0"/>
                                                <stop offset="0.1561" stop-color="#A32B2A" stop-opacity="0.066"/>
                                                <stop offset="0.386" stop-color="#982C29" stop-opacity="0.248"/>
                                                <stop offset="0.6615" stop-color="#872F28" stop-opacity="0.545"/>
                                                <stop offset="0.97" stop-color="#6F3226" stop-opacity="0.956"/>
                                                <stop offset="1" stop-color="#6D3326"/>
                                            </linearGradient>
                                            <linearGradient id="paint5_linear_7456_1543" x1="52.7205" y1="51.5804" x2="57.0872" y2="48.4795" gradientUnits="userSpaceOnUse">
                                                <stop stop-color="#A72B2B" stop-opacity="0"/>
                                                <stop offset="0.1561" stop-color="#A32B2A" stop-opacity="0.066"/>
                                                <stop offset="0.386" stop-color="#982C29" stop-opacity="0.248"/>
                                                <stop offset="0.6615" stop-color="#872F28" stop-opacity="0.545"/>
                                                <stop offset="0.97" stop-color="#6F3226" stop-opacity="0.956"/>
                                                <stop offset="1" stop-color="#6D3326"/>
                                            </linearGradient>
                                            <linearGradient id="paint6_linear_7456_1543" x1="49.8594" y1="54.5532" x2="54.7027" y2="59.3966" gradientUnits="userSpaceOnUse">
                                                <stop stop-color="#A72B2B" stop-opacity="0"/>
                                                <stop offset="0.1561" stop-color="#A32B2A" stop-opacity="0.066"/>
                                                <stop offset="0.386" stop-color="#982C29" stop-opacity="0.248"/>
                                                <stop offset="0.6615" stop-color="#872F28" stop-opacity="0.545"/>
                                                <stop offset="0.97" stop-color="#6F3226" stop-opacity="0.956"/>
                                                <stop offset="1" stop-color="#6D3326"/>
                                            </linearGradient>
                                            <linearGradient id="paint7_linear_7456_1543" x1="62.5372" y1="43.9051" x2="68.8236" y2="44.9599" gradientUnits="userSpaceOnUse">
                                                <stop stop-color="#DBD5EF" stop-opacity="0"/>
                                                <stop offset="0.2667" stop-color="#D8D2EC" stop-opacity="0.023"/>
                                                <stop offset="0.4431" stop-color="#D1C9E2" stop-opacity="0.098"/>
                                                <stop offset="0.5933" stop-color="#C4B9D1" stop-opacity="0.225"/>
                                                <stop offset="0.7288" stop-color="#B2A4BA" stop-opacity="0.405"/>
                                                <stop offset="0.8545" stop-color="#9A889C" stop-opacity="0.638"/>
                                                <stop offset="0.9713" stop-color="#7E6678" stop-opacity="0.92"/>
                                                <stop offset="1" stop-color="#765D6E"/>
                                            </linearGradient>
                                            <linearGradient id="paint8_linear_7456_1543" x1="49.2939" y1="41.3548" x2="44.4576" y2="46.1911" gradientUnits="userSpaceOnUse">
                                                <stop stop-color="#FEF0AE"/>
                                                <stop offset="1" stop-color="#FAC600"/>
                                            </linearGradient>
                                            <linearGradient id="paint9_linear_7456_1543" x1="48.5901" y1="42.0594" x2="41.7447" y2="48.9049" gradientUnits="userSpaceOnUse">
                                                <stop stop-color="#FE9738" stop-opacity="0"/>
                                                <stop offset="0.1648" stop-color="#FE9637" stop-opacity="0.012"/>
                                                <stop offset="0.2957" stop-color="#FE9535" stop-opacity="0.052"/>
                                                <stop offset="0.415" stop-color="#FE9331" stop-opacity="0.118"/>
                                                <stop offset="0.5274" stop-color="#FE902C" stop-opacity="0.211"/>
                                                <stop offset="0.635" stop-color="#FE8C25" stop-opacity="0.331"/>
                                                <stop offset="0.739" stop-color="#FE871D" stop-opacity="0.479"/>
                                                <stop offset="0.8401" stop-color="#FE8213" stop-opacity="0.655"/>
                                                <stop offset="0.9364" stop-color="#FE7B09" stop-opacity="0.852"/>
                                                <stop offset="1" stop-color="#FE7701"/>
                                            </linearGradient>
                                            <linearGradient id="paint10_linear_7456_1543" x1="40.4669" y1="29.1416" x2="32.4701" y2="37.1384" gradientUnits="userSpaceOnUse">
                                                <stop stop-color="#C1E9AF"/>
                                                <stop offset="0.1072" stop-color="#B6E4AA"/>
                                                <stop offset="0.2935" stop-color="#99D69E"/>
                                                <stop offset="0.5365" stop-color="#6BC18A"/>
                                                <stop offset="0.8238" stop-color="#2CA36F"/>
                                                <stop offset="1" stop-color="#02905D"/>
                                            </linearGradient>
                                            <linearGradient id="paint11_linear_7456_1543" x1="35.7446" y1="35.6698" x2="33.1404" y2="41.3469" gradientUnits="userSpaceOnUse">
                                                <stop stop-color="#026841" stop-opacity="0"/>
                                                <stop offset="0.2182" stop-color="#026841" stop-opacity="0.033"/>
                                                <stop offset="0.4099" stop-color="#026841" stop-opacity="0.137"/>
                                                <stop offset="0.5916" stop-color="#026841" stop-opacity="0.31"/>
                                                <stop offset="0.7671" stop-color="#026841" stop-opacity="0.553"/>
                                                <stop offset="0.9367" stop-color="#026841" stop-opacity="0.864"/>
                                                <stop offset="1" stop-color="#026841"/>
                                            </linearGradient>
                                            <linearGradient id="paint12_linear_7456_1543" x1="47.4356" y1="45.4499" x2="46.3809" y2="51.7364" gradientUnits="userSpaceOnUse">
                                                <stop stop-color="#FE9738" stop-opacity="0"/>
                                                <stop offset="0.1648" stop-color="#FE9637" stop-opacity="0.012"/>
                                                <stop offset="0.2957" stop-color="#FE9535" stop-opacity="0.052"/>
                                                <stop offset="0.415" stop-color="#FE9331" stop-opacity="0.118"/>
                                                <stop offset="0.5274" stop-color="#FE902C" stop-opacity="0.211"/>
                                                <stop offset="0.635" stop-color="#FE8C25" stop-opacity="0.331"/>
                                                <stop offset="0.739" stop-color="#FE871D" stop-opacity="0.479"/>
                                                <stop offset="0.8401" stop-color="#FE8213" stop-opacity="0.655"/>
                                                <stop offset="0.9364" stop-color="#FE7B09" stop-opacity="0.852"/>
                                                <stop offset="1" stop-color="#FE7701"/>
                                            </linearGradient>
                                            <linearGradient id="paint13_linear_7456_1543" x1="47.0956" y1="43.1579" x2="51.5889" y2="52.0812" gradientUnits="userSpaceOnUse">
                                                <stop stop-color="#FE9738" stop-opacity="0"/>
                                                <stop offset="0.1648" stop-color="#FE9637" stop-opacity="0.012"/>
                                                <stop offset="0.2957" stop-color="#FE9535" stop-opacity="0.052"/>
                                                <stop offset="0.415" stop-color="#FE9331" stop-opacity="0.118"/>
                                                <stop offset="0.5274" stop-color="#FE902C" stop-opacity="0.211"/>
                                                <stop offset="0.635" stop-color="#FE8C25" stop-opacity="0.331"/>
                                                <stop offset="0.739" stop-color="#FE871D" stop-opacity="0.479"/>
                                                <stop offset="0.8401" stop-color="#FE8213" stop-opacity="0.655"/>
                                                <stop offset="0.9364" stop-color="#FE7B09" stop-opacity="0.852"/>
                                                <stop offset="1" stop-color="#FE7701"/>
                                            </linearGradient>
                                            <linearGradient id="paint14_linear_7456_1543" x1="45.5821" y1="47.8752" x2="44.1593" y2="52.5389" gradientUnits="userSpaceOnUse">
                                                <stop stop-color="#FAC600" stop-opacity="0"/>
                                                <stop offset="0.1175" stop-color="#FAC602" stop-opacity="0.017"/>
                                                <stop offset="0.2423" stop-color="#FAC80B" stop-opacity="0.067"/>
                                                <stop offset="0.3705" stop-color="#FACC1A" stop-opacity="0.151"/>
                                                <stop offset="0.5011" stop-color="#FBD12E" stop-opacity="0.268"/>
                                                <stop offset="0.6336" stop-color="#FBD748" stop-opacity="0.419"/>
                                                <stop offset="0.7676" stop-color="#FCDF69" stop-opacity="0.604"/>
                                                <stop offset="0.9003" stop-color="#FDE88E" stop-opacity="0.819"/>
                                                <stop offset="1" stop-color="#FEF0AE"/>
                                            </linearGradient>
                                            <linearGradient id="paint15_linear_7456_1543" x1="52.5801" y1="28.0288" x2="60.9213" y2="36.3701" gradientUnits="userSpaceOnUse">
                                                <stop stop-color="#99E6FC"/>
                                                <stop offset="0.1325" stop-color="#8EE1FB"/>
                                                <stop offset="0.3627" stop-color="#71D5F9"/>
                                                <stop offset="0.6631" stop-color="#43C2F5"/>
                                                <stop offset="1" stop-color="#08A9F1"/>
                                            </linearGradient>
                                            <linearGradient id="paint16_linear_7456_1543" x1="57.6536" y1="33.1025" x2="55.0518" y2="30.5007" gradientUnits="userSpaceOnUse">
                                                <stop stop-color="#99E6FC"/>
                                                <stop offset="0.1325" stop-color="#8EE1FB"/>
                                                <stop offset="0.3627" stop-color="#71D5F9"/>
                                                <stop offset="0.6631" stop-color="#43C2F5"/>
                                                <stop offset="1" stop-color="#08A9F1"/>
                                            </linearGradient>
                                            <linearGradient id="paint17_linear_7456_1543" x1="56.602" y1="33.5471" x2="56.602" y2="41.1695" gradientUnits="userSpaceOnUse">
                                                <stop stop-color="#2740B0" stop-opacity="0"/>
                                                <stop offset="0.2505" stop-color="#263FAE" stop-opacity="0.023"/>
                                                <stop offset="0.4239" stop-color="#253DAB" stop-opacity="0.095"/>
                                                <stop offset="0.5741" stop-color="#233BA4" stop-opacity="0.218"/>
                                                <stop offset="0.711" stop-color="#21379B" stop-opacity="0.393"/>
                                                <stop offset="0.8389" stop-color="#1E3290" stop-opacity="0.618"/>
                                                <stop offset="0.9585" stop-color="#1A2C82" stop-opacity="0.89"/>
                                                <stop offset="1" stop-color="#192A7D"/>
                                            </linearGradient>
                                            <linearGradient id="paint18_linear_7456_1543" x1="58.1326" y1="32.0506" x2="65.5321" y2="32.0506" gradientUnits="userSpaceOnUse">
                                                <stop stop-color="#2740B0" stop-opacity="0"/>
                                                <stop offset="0.2505" stop-color="#263FAE" stop-opacity="0.023"/>
                                                <stop offset="0.4239" stop-color="#253DAB" stop-opacity="0.095"/>
                                                <stop offset="0.5741" stop-color="#233BA4" stop-opacity="0.218"/>
                                                <stop offset="0.711" stop-color="#21379B" stop-opacity="0.393"/>
                                                <stop offset="0.8389" stop-color="#1E3290" stop-opacity="0.618"/>
                                                <stop offset="0.9585" stop-color="#1A2C82" stop-opacity="0.89"/>
                                                <stop offset="1" stop-color="#192A7D"/>
                                            </linearGradient>
                                            <linearGradient id="paint19_linear_7456_1543" x1="59.1706" y1="34.6192" x2="62.8407" y2="38.2895" gradientUnits="userSpaceOnUse">
                                                <stop stop-color="#08A9F1" stop-opacity="0"/>
                                                <stop offset="0.0927" stop-color="#0BAAF1" stop-opacity="0.025"/>
                                                <stop offset="0.2192" stop-color="#15AEF2" stop-opacity="0.094"/>
                                                <stop offset="0.3651" stop-color="#26B5F3" stop-opacity="0.208"/>
                                                <stop offset="0.5256" stop-color="#3DBFF5" stop-opacity="0.367"/>
                                                <stop offset="0.698" stop-color="#5ACBF7" stop-opacity="0.571"/>
                                                <stop offset="0.8776" stop-color="#7EDAF9" stop-opacity="0.816"/>
                                                <stop offset="1" stop-color="#99E6FC"/>
                                            </linearGradient>
                                            <clipPath id="clip0_7456_1543">
                                                <rect width="40" height="40" fill="white" transform="translate(29 23.5)"/>
                                            </clipPath>
                                        </defs>
                                    </svg>
                                </div>
                                <div>
                                    <span class="justify-content-center d-flex">{{ __('home.Thuốc online') }}</span></div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-md-4">
                    <a href="{{route('examination.mentoring')}}">
                        <div class="border-HomeNew align-items-center justify-content-center">
                            <div class="">
                                <div class="d-flex justify-content-center krm-select-bt">
                                    <svg width="101" height="94" viewBox="0 0 101 94" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <g filter="url(#filter0_f_7069_19525)">
                                            <circle cx="50.3125" cy="43.8125" r="15.9375" fill="#FFC700" fill-opacity="0.5"/>
                                        </g>
                                        <path d="M56.875 44.75H58.125V46H56.875C56.7092 46 56.5503 46.0658 56.4331 46.1831C56.3158 46.3003 56.25 46.4592 56.25 46.625V47.875H55V46.625C55 46.4592 54.9342 46.3003 54.8169 46.1831C54.6997 46.0658 54.5408 46 54.375 46H53.125V44.75H54.375C54.5408 44.75 54.6997 44.6842 54.8169 44.5669C54.9342 44.4497 55 44.2908 55 44.125V42.875H56.25V44.125C56.25 44.2908 56.3158 44.4497 56.4331 44.5669C56.5503 44.6842 56.7092 44.75 56.875 44.75ZM45 39.125C45.0008 38.4622 45.2644 37.8267 45.7331 37.3581C46.2017 36.8894 46.8372 36.6258 47.5 36.625H53.75V32.875C53.7497 32.5436 53.6179 32.2258 53.3835 31.9915C53.1492 31.7571 52.8314 31.6253 52.5 31.625H36.25C35.9186 31.6253 35.6008 31.7571 35.3665 31.9915C35.1321 32.2258 35.0003 32.5436 35 32.875V45.375C35.0003 45.7064 35.1321 46.0242 35.3665 46.2585C35.6008 46.4929 35.9186 46.6247 36.25 46.625H37.8662L40.1831 48.9419C40.2411 48.9999 40.31 49.046 40.3858 49.0774C40.4616 49.1088 40.5429 49.125 40.625 49.125C40.7071 49.125 40.7883 49.1088 40.8641 49.0774C40.94 49.046 41.0089 48.9999 41.0669 48.9419L43.3838 46.625H45V39.125ZM65 39.125V51.625C64.9997 51.9564 64.8679 52.2742 64.6335 52.5085C64.3992 52.7429 64.0814 52.8747 63.75 52.875H58.3838L56.0672 55.1919C56.0092 55.2499 55.9403 55.296 55.8645 55.3274C55.7886 55.3588 55.7074 55.375 55.6253 55.375C55.5432 55.375 55.462 55.3588 55.3861 55.3274C55.3103 55.296 55.2414 55.2499 55.1834 55.1919L52.8662 52.875H47.5C47.1686 52.8747 46.8508 52.7429 46.6165 52.5085C46.3821 52.2742 46.2503 51.9564 46.25 51.625V39.125C46.2503 38.7936 46.3821 38.4758 46.6165 38.2415C46.8508 38.0071 47.1686 37.8753 47.5 37.875H63.75C64.0814 37.8753 64.3992 38.0071 64.6335 38.2415C64.8679 38.4758 64.9997 38.7936 65 39.125ZM59.375 44.125C59.375 43.9592 59.3092 43.8003 59.1919 43.6831C59.0747 43.5658 58.9158 43.5 58.75 43.5H57.5V42.25C57.5 42.0842 57.4342 41.9253 57.3169 41.8081C57.1997 41.6908 57.0408 41.625 56.875 41.625H54.375C54.2092 41.625 54.0503 41.6908 53.9331 41.8081C53.8158 41.9253 53.75 42.0842 53.75 42.25V43.5H52.5C52.3342 43.5 52.1753 43.5658 52.0581 43.6831C51.9408 43.8003 51.875 43.9592 51.875 44.125V46.625C51.875 46.7908 51.9408 46.9497 52.0581 47.0669C52.1753 47.1842 52.3342 47.25 52.5 47.25H53.75V48.5C53.75 48.6658 53.8158 48.8247 53.9331 48.9419C54.0503 49.0592 54.2092 49.125 54.375 49.125H56.875C57.0408 49.125 57.1997 49.0592 57.3169 48.9419C57.4342 48.8247 57.5 48.6658 57.5 48.5V47.25H58.75C58.9158 47.25 59.0747 47.1842 59.1919 47.0669C59.3092 46.9497 59.375 46.7908 59.375 46.625V44.125Z" fill="url(#paint0_linear_7069_19525)"/>
                                        <defs>
                                            <filter id="filter0_f_7069_19525" x="0.375" y="-6.125" width="99.875" height="99.875" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                                                <feFlood flood-opacity="0" result="BackgroundImageFix"/>
                                                <feBlend mode="normal" in="SourceGraphic" in2="BackgroundImageFix" result="shape"/>
                                                <feGaussianBlur stdDeviation="17" result="effect1_foregroundBlur_7069_19525"/>
                                            </filter>
                                            <linearGradient id="paint0_linear_7069_19525" x1="35" y1="43.5" x2="65" y2="43.5" gradientUnits="userSpaceOnUse">
                                                <stop stop-color="#11998E"/>
                                                <stop offset="1" stop-color="#38EF7D"/>
                                            </linearGradient>
                                        </defs>
                                    </svg>
                                </div>
                                <div>
                                    <span class="justify-content-center d-flex">{{__('home.Tư vẫn sức khoẻ')}}</span></div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-md-4">
                    <a href="{{route('clinic')}}">
                        <div class="border-HomeNew align-items-center justify-content-center">
                            <div class="">
                                <div class="d-flex justify-content-center krm-select-bt">
                                    <svg width="101" height="94" viewBox="0 0 101 94" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <g filter="url(#filter0_f_7456_2030)">
                                            <circle cx="50.3125" cy="43.8125" r="15.9375" fill="#FFC700" fill-opacity="0.5"/>
                                        </g>
                                        <g clip-path="url(#clip0_7456_2030)">
                                            <path d="M44.8922 56.8579L39.5516 62.1985C39.0711 62.679 39.4114 63.5007 40.091 63.5007H59.9091C60.5887 63.5007 60.929 62.679 60.4485 62.1985L55.1079 56.8579C52.2869 54.0369 47.7131 54.0369 44.8922 56.8579Z" fill="url(#paint0_linear_7456_2030)"/>
                                            <path d="M59.9091 63.5016H40.0908C39.4117 63.5016 39.0708 62.6797 39.5518 62.1994L43.3385 58.4121H56.6614L60.4487 62.1994C60.9291 62.6797 60.5889 63.5016 59.9091 63.5016Z" fill="url(#paint1_linear_7456_2030)"/>
                                            <path d="M55.108 56.8576C53.4233 55.1729 51.1136 54.4947 48.9253 54.8221V63.5003H59.9092C60.5888 63.5003 60.9291 62.6787 60.4486 62.1982L55.108 56.8576Z" fill="url(#paint2_linear_7456_2030)"/>
                                            <path d="M60.4481 62.1973L55.1075 56.8567C53.0562 54.8054 50.0785 54.2473 47.5215 55.1793L47.4907 55.2076L55.7827 63.4995H59.9088C60.5883 63.4995 60.9287 62.6779 60.4481 62.1973Z" fill="url(#paint3_linear_7456_2030)"/>
                                            <path d="M63.3475 36.8476C63.3475 29.4759 57.3716 23.5 49.9999 23.5C42.6283 23.5 36.6523 29.4759 36.6523 36.8476C36.6523 44.2192 45.6443 56.1297 49.9999 56.1297C54.3555 56.1297 63.3475 44.2192 63.3475 36.8476Z" fill="url(#paint4_linear_7456_2030)"/>
                                            <path d="M49.9997 48.0326C56.0736 48.0326 60.9974 43.1087 60.9974 37.0348C60.9974 30.961 56.0736 26.0371 49.9997 26.0371C43.9258 26.0371 39.002 30.961 39.002 37.0348C39.002 43.1087 43.9258 48.0326 49.9997 48.0326Z" fill="url(#paint5_linear_7456_2030)"/>
                                            <path d="M49.9997 56.1297C49.0741 56.1297 47.9382 55.5878 46.7246 54.6699V23.9062C47.7727 23.6418 48.8695 23.5 49.9997 23.5C57.3713 23.5 63.3473 29.4759 63.3473 36.8476C63.3473 44.2192 54.3552 56.1297 49.9997 56.1297Z" fill="url(#paint6_linear_7456_2030)"/>
                                            <path d="M36.8589 38.9199C38.2228 46.252 46.0332 56.129 49.9997 56.129C53.9663 56.129 61.7766 46.252 63.1406 38.9199H36.8589Z" fill="url(#paint7_linear_7456_2030)"/>
                                            <path d="M49.9999 46.5077C55.2315 46.5077 59.4725 42.2666 59.4725 37.0351C59.4725 31.8035 55.2315 27.5625 49.9999 27.5625C44.7684 27.5625 40.5273 31.8035 40.5273 37.0351C40.5273 42.2666 44.7684 46.5077 49.9999 46.5077Z" fill="url(#paint8_linear_7456_2030)"/>
                                            <path d="M54.9019 35.3609H51.6734V32.1324C51.6734 31.6602 51.2906 31.2773 50.8183 31.2773H49.1818C48.7096 31.2773 48.3268 31.6602 48.3268 32.1324V35.3609H45.0982C44.626 35.3609 44.2432 35.7438 44.2432 36.216V37.8525C44.2432 38.3248 44.626 38.7076 45.0982 38.7076H48.3268V41.9361C48.3268 42.4084 48.7096 42.7912 49.1818 42.7912H50.8183C51.2906 42.7912 51.6734 42.4084 51.6734 41.9361V38.7076H54.9019C55.3742 38.7076 55.757 38.3248 55.757 37.8525V36.216C55.757 35.7438 55.3742 35.3609 54.9019 35.3609Z" fill="url(#paint9_linear_7456_2030)"/>
                                            <path d="M40.5273 37.0355C40.5273 42.267 44.7684 46.508 49.9999 46.508C55.2315 46.508 59.4725 42.267 59.4725 37.0355C59.4725 36.7736 59.4614 36.5143 59.4405 36.2578H40.5593C40.5384 36.5143 40.5273 36.7736 40.5273 37.0355Z" fill="url(#paint10_linear_7456_2030)"/>
                                            <path d="M49.9997 27.5625C49.3895 27.5625 48.793 27.6209 48.2148 27.7312V46.339C48.793 46.4492 49.3895 46.5077 49.9997 46.5077C55.2312 46.5077 59.4723 42.2666 59.4723 37.0351C59.4723 31.8035 55.2312 27.5625 49.9997 27.5625Z" fill="url(#paint11_linear_7456_2030)"/>
                                            <path d="M56.658 30.2988L43.2627 43.6941C44.9799 45.4316 47.3639 46.5085 49.9998 46.5085C55.2314 46.5085 59.4724 42.2675 59.4724 37.0359C59.4724 34.4001 58.3954 32.016 56.658 30.2988Z" fill="url(#paint12_linear_7456_2030)"/>
                                        </g>
                                        <defs>
                                            <filter id="filter0_f_7456_2030" x="0.375" y="-6.125" width="99.875" height="99.875" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                                                <feFlood flood-opacity="0" result="BackgroundImageFix"/>
                                                <feBlend mode="normal" in="SourceGraphic" in2="BackgroundImageFix" result="shape"/>
                                                <feGaussianBlur stdDeviation="17" result="effect1_foregroundBlur_7456_2030"/>
                                            </filter>
                                            <linearGradient id="paint0_linear_7456_2030" x1="46.5545" y1="59.1214" x2="55.5902" y2="59.1214" gradientUnits="userSpaceOnUse">
                                                <stop stop-color="#C1E9AF"/>
                                                <stop offset="0.1072" stop-color="#B6E4AA"/>
                                                <stop offset="0.2935" stop-color="#99D69E"/>
                                                <stop offset="0.5365" stop-color="#6BC18A"/>
                                                <stop offset="0.8238" stop-color="#2CA36F"/>
                                                <stop offset="1" stop-color="#02905D"/>
                                            </linearGradient>
                                            <linearGradient id="paint1_linear_7456_2030" x1="50.0001" y1="61.1251" x2="50.0001" y2="64.2643" gradientUnits="userSpaceOnUse">
                                                <stop stop-color="#026841" stop-opacity="0"/>
                                                <stop offset="0.2182" stop-color="#026841" stop-opacity="0.033"/>
                                                <stop offset="0.4099" stop-color="#026841" stop-opacity="0.137"/>
                                                <stop offset="0.5916" stop-color="#026841" stop-opacity="0.31"/>
                                                <stop offset="0.7671" stop-color="#026841" stop-opacity="0.553"/>
                                                <stop offset="0.9367" stop-color="#026841" stop-opacity="0.864"/>
                                                <stop offset="1" stop-color="#026841"/>
                                            </linearGradient>
                                            <linearGradient id="paint2_linear_7456_2030" x1="53.8941" y1="59.6882" x2="55.9826" y2="58.0174" gradientUnits="userSpaceOnUse">
                                                <stop stop-color="#026841" stop-opacity="0"/>
                                                <stop offset="0.2182" stop-color="#026841" stop-opacity="0.033"/>
                                                <stop offset="0.4099" stop-color="#026841" stop-opacity="0.137"/>
                                                <stop offset="0.5916" stop-color="#026841" stop-opacity="0.31"/>
                                                <stop offset="0.7671" stop-color="#026841" stop-opacity="0.553"/>
                                                <stop offset="0.9367" stop-color="#026841" stop-opacity="0.864"/>
                                                <stop offset="1" stop-color="#026841"/>
                                            </linearGradient>
                                            <linearGradient id="paint3_linear_7456_2030" x1="53.6766" y1="57.2929" x2="52.8783" y2="54.0812" gradientUnits="userSpaceOnUse">
                                                <stop stop-color="#026841" stop-opacity="0"/>
                                                <stop offset="0.2182" stop-color="#026841" stop-opacity="0.033"/>
                                                <stop offset="0.4099" stop-color="#026841" stop-opacity="0.137"/>
                                                <stop offset="0.5916" stop-color="#026841" stop-opacity="0.31"/>
                                                <stop offset="0.7671" stop-color="#026841" stop-opacity="0.553"/>
                                                <stop offset="0.9367" stop-color="#026841" stop-opacity="0.864"/>
                                                <stop offset="1" stop-color="#026841"/>
                                            </linearGradient>
                                            <linearGradient id="paint4_linear_7456_2030" x1="42.9245" y1="34.7533" x2="58.3541" y2="44.0111" gradientUnits="userSpaceOnUse">
                                                <stop stop-color="#FE646F"/>
                                                <stop offset="0.235" stop-color="#FA5964"/>
                                                <stop offset="0.6415" stop-color="#EF3D49"/>
                                                <stop offset="1" stop-color="#E41F2D"/>
                                            </linearGradient>
                                            <linearGradient id="paint5_linear_7456_2030" x1="56.3831" y1="43.4183" x2="43.0625" y2="30.0977" gradientUnits="userSpaceOnUse">
                                                <stop stop-color="#FE646F"/>
                                                <stop offset="0.235" stop-color="#FA5964"/>
                                                <stop offset="0.6415" stop-color="#EF3D49"/>
                                                <stop offset="1" stop-color="#E41F2D"/>
                                            </linearGradient>
                                            <linearGradient id="paint6_linear_7456_2030" x1="47.5505" y1="39.0537" x2="61.0811" y2="42.377" gradientUnits="userSpaceOnUse">
                                                <stop stop-color="#A72B2B" stop-opacity="0"/>
                                                <stop offset="0.1561" stop-color="#A32B2A" stop-opacity="0.066"/>
                                                <stop offset="0.386" stop-color="#982C29" stop-opacity="0.248"/>
                                                <stop offset="0.6615" stop-color="#872F28" stop-opacity="0.545"/>
                                                <stop offset="0.97" stop-color="#6F3226" stop-opacity="0.956"/>
                                                <stop offset="1" stop-color="#6D3326"/>
                                            </linearGradient>
                                            <linearGradient id="paint7_linear_7456_2030" x1="49.9997" y1="41.7133" x2="49.9997" y2="56.5243" gradientUnits="userSpaceOnUse">
                                                <stop stop-color="#A72B2B" stop-opacity="0"/>
                                                <stop offset="0.1561" stop-color="#A32B2A" stop-opacity="0.066"/>
                                                <stop offset="0.386" stop-color="#982C29" stop-opacity="0.248"/>
                                                <stop offset="0.6615" stop-color="#872F28" stop-opacity="0.545"/>
                                                <stop offset="0.97" stop-color="#6F3226" stop-opacity="0.956"/>
                                                <stop offset="1" stop-color="#6D3326"/>
                                            </linearGradient>
                                            <linearGradient id="paint8_linear_7456_2030" x1="44.8748" y1="31.9099" x2="55.5041" y2="42.5392" gradientUnits="userSpaceOnUse">
                                                <stop stop-color="#F3FAFF"/>
                                                <stop offset="1" stop-color="#D5DAF3"/>
                                            </linearGradient>
                                            <linearGradient id="paint9_linear_7456_2030" x1="47.8244" y1="34.9406" x2="52.2559" y2="39.2049" gradientUnits="userSpaceOnUse">
                                                <stop stop-color="#FE646F"/>
                                                <stop offset="0.235" stop-color="#FA5964"/>
                                                <stop offset="0.6415" stop-color="#EF3D49"/>
                                                <stop offset="1" stop-color="#E41F2D"/>
                                            </linearGradient>
                                            <linearGradient id="paint10_linear_7456_2030" x1="50.1639" y1="38.2923" x2="51.2927" y2="46.57" gradientUnits="userSpaceOnUse">
                                                <stop stop-color="#DBD5EF" stop-opacity="0"/>
                                                <stop offset="0.2667" stop-color="#D8D2EC" stop-opacity="0.023"/>
                                                <stop offset="0.4431" stop-color="#D1C9E2" stop-opacity="0.098"/>
                                                <stop offset="0.5933" stop-color="#C4B9D1" stop-opacity="0.225"/>
                                                <stop offset="0.7288" stop-color="#B2A4BA" stop-opacity="0.405"/>
                                                <stop offset="0.8545" stop-color="#9A889C" stop-opacity="0.638"/>
                                                <stop offset="0.9713" stop-color="#7E6678" stop-opacity="0.92"/>
                                                <stop offset="1" stop-color="#765D6E"/>
                                            </linearGradient>
                                            <linearGradient id="paint11_linear_7456_2030" x1="50.204" y1="37.0663" x2="59.3283" y2="38.4773" gradientUnits="userSpaceOnUse">
                                                <stop stop-color="#DBD5EF" stop-opacity="0"/>
                                                <stop offset="0.2667" stop-color="#D8D2EC" stop-opacity="0.023"/>
                                                <stop offset="0.4431" stop-color="#D1C9E2" stop-opacity="0.098"/>
                                                <stop offset="0.5933" stop-color="#C4B9D1" stop-opacity="0.225"/>
                                                <stop offset="0.7288" stop-color="#B2A4BA" stop-opacity="0.405"/>
                                                <stop offset="0.8545" stop-color="#9A889C" stop-opacity="0.638"/>
                                                <stop offset="0.9713" stop-color="#7E6678" stop-opacity="0.92"/>
                                                <stop offset="1" stop-color="#765D6E"/>
                                            </linearGradient>
                                            <linearGradient id="paint12_linear_7456_2030" x1="52.3547" y1="39.3909" x2="57.0304" y2="44.0664" gradientUnits="userSpaceOnUse">
                                                <stop stop-color="#DBD5EF" stop-opacity="0"/>
                                                <stop offset="0.2667" stop-color="#D8D2EC" stop-opacity="0.023"/>
                                                <stop offset="0.4431" stop-color="#D1C9E2" stop-opacity="0.098"/>
                                                <stop offset="0.5933" stop-color="#C4B9D1" stop-opacity="0.225"/>
                                                <stop offset="0.7288" stop-color="#B2A4BA" stop-opacity="0.405"/>
                                                <stop offset="0.8545" stop-color="#9A889C" stop-opacity="0.638"/>
                                                <stop offset="0.9713" stop-color="#7E6678" stop-opacity="0.92"/>
                                                <stop offset="1" stop-color="#765D6E"/>
                                            </linearGradient>
                                            <clipPath id="clip0_7456_2030">
                                                <rect width="40" height="40" fill="white" transform="translate(30 23.5)"/>
                                            </clipPath>
                                        </defs>
                                    </svg>
                                </div>
                                <div>
                                    <span class="justify-content-center d-flex">{{__('home.Y tế gần bạn')}}</span></div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-md-4">
                    <a href="{{ route('examination.index') }}">
                        <div class="border-HomeNew align-items-center justify-content-center">
                            <div class="">
                                <div class="d-flex justify-content-center krm-select-bt">
                                    <svg width="98" height="93" viewBox="0 0 98 93" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <g filter="url(#filter0_f_7456_16385)">
                                            <circle cx="49" cy="43.5" r="15" fill="#FFC700" fill-opacity="0.5"/>
                                        </g>
                                        <path d="M45.25 47.25H52.75V53.8125H45.25V47.25Z" fill="url(#paint0_linear_7456_16385)"/>
                                        <path d="M45.25 51C46.1053 51.9106 47.4666 52.5625 49 52.5625C50.5684 52.5625 51.8991 51.9463 52.75 51V62.8753H49H45.25V51Z" fill="url(#paint1_linear_7456_16385)"/>
                                        <path d="M45.25 51C46.1053 51.9106 47.4666 52.5625 49 52.5625C50.5684 52.5625 51.8991 51.9463 52.75 51C53.0963 51.0766 53.5247 51.18 54.0078 51.3047C53.2809 52.7644 51.3163 53.8125 49 53.8125C46.6838 53.8125 44.7191 52.7644 43.9922 51.3047C44.4753 51.18 44.9038 51.0769 45.25 51Z" fill="url(#paint2_linear_7456_16385)"/>
                                        <path d="M39.9375 54.4372L34.3125 53.8125C34.3125 53.8125 31.1875 56.9375 29.625 62.875H39.9375V54.4372Z" fill="url(#paint3_linear_7456_16385)"/>
                                        <path d="M44 50.6875C41.7722 51.1809 36.1597 52.4578 34.3125 53.8125L37.4375 62.875H47.75L44 50.6875Z" fill="url(#paint4_linear_7456_16385)"/>
                                        <path d="M58.0625 54.4372L63.6875 53.8125C63.6875 53.8125 66.8125 56.9375 68.375 62.875H58.0625V54.4372Z" fill="url(#paint5_linear_7456_16385)"/>
                                        <path d="M54 50.6875C56.2278 51.1809 61.8403 52.4578 63.6875 53.8125L60.5625 62.875H50.25L54 50.6875Z" fill="url(#paint6_linear_7456_16385)"/>
                                        <path d="M60.25 40.0178C60.25 41.3984 59.2706 42.875 58.0625 42.875C56.8544 42.875 55.875 41.3984 55.875 40.0178C55.875 38.6372 56.8544 37.875 58.0625 37.875C59.2706 37.875 60.25 38.6372 60.25 40.0178Z" fill="url(#paint7_linear_7456_16385)"/>
                                        <path d="M41.8125 40.0178C41.8125 41.3984 40.8331 42.875 39.625 42.875C38.4169 42.875 37.4375 41.3984 37.4375 40.0178C37.4375 38.6372 38.4169 37.875 39.625 37.875C40.8331 37.875 41.8125 38.6372 41.8125 40.0178Z" fill="url(#paint8_linear_7456_16385)"/>
                                        <path d="M56.8125 32.25H41.1875C40.4881 32.4197 39.9375 33.0928 39.9375 33.8125V40.0647C39.9375 45.375 44 49.4375 49 49.4375C54 49.4375 58.0625 45.375 58.0625 40.0647V33.8125C58.0625 33.0906 57.5147 32.4178 56.8125 32.25Z" fill="url(#paint9_linear_7456_16385)"/>
                                        <path d="M49 24.125C53.9016 24.125 59.3125 27.9337 59.3125 33.8125C59.2962 37.535 58.0625 40.0625 58.0625 40.0625C58.0625 38.1875 57.125 33.8125 57.125 33.8125C51.8125 35.0625 41.1875 32.5625 41.1875 32.5625C41.1875 32.5625 39.9375 34.4375 39.9375 40.0625C39.9375 40.0625 38.0625 37.875 38.0625 34.125C38.0625 29.4488 40.25 28.5 40.25 28.5C40.25 28.5 40.875 24.125 49 24.125Z" fill="url(#paint10_linear_7456_16385)"/>
                                        <path d="M48.9942 47.2493C48.2879 47.2493 47.5835 47.0218 46.9435 46.5675C46.8029 46.4675 46.7698 46.2725 46.8698 46.1315C46.9698 45.9906 47.1648 45.9581 47.3057 46.0578C48.3754 46.8181 49.6107 46.8178 50.6954 46.0568C50.8364 45.9575 51.0317 45.9918 51.1307 46.1331C51.2298 46.2743 51.1957 46.4693 51.0545 46.5684C50.4073 47.0221 49.6998 47.2493 48.9942 47.2493Z" fill="url(#paint11_linear_7456_16385)"/>
                                        <path d="M44.9375 41.3125C45.4553 41.3125 45.875 40.8928 45.875 40.375C45.875 39.8572 45.4553 39.4375 44.9375 39.4375C44.4197 39.4375 44 39.8572 44 40.375C44 40.8928 44.4197 41.3125 44.9375 41.3125Z" fill="url(#paint12_linear_7456_16385)"/>
                                        <path d="M53.0625 41.3125C53.5803 41.3125 54 40.8928 54 40.375C54 39.8572 53.5803 39.4375 53.0625 39.4375C52.5447 39.4375 52.125 39.8572 52.125 40.375C52.125 40.8928 52.5447 41.3125 53.0625 41.3125Z" fill="url(#paint13_linear_7456_16385)"/>
                                        <path d="M46.8121 37.8728C46.7556 37.8728 46.6987 37.8575 46.6471 37.8256C44.9099 36.744 43.7784 37.4715 43.2953 37.7825L43.2296 37.8247C43.0834 37.9169 42.8906 37.8731 42.7984 37.7275C42.7062 37.5815 42.7496 37.3887 42.8956 37.2962L42.9574 37.2569C43.4899 36.914 44.9056 36.0047 46.9778 37.2953C47.1243 37.3865 47.169 37.5794 47.0778 37.7256C47.0184 37.8206 46.9165 37.8728 46.8121 37.8728Z" fill="url(#paint14_linear_7456_16385)"/>
                                        <path d="M51.1879 37.873C51.0836 37.873 50.9817 37.8208 50.9223 37.7258C50.8311 37.5792 50.8758 37.3864 51.0223 37.2955C53.0948 36.0042 54.5101 36.9145 55.0429 37.257L55.1045 37.2964C55.2504 37.3886 55.2936 37.5817 55.2017 37.7277C55.1095 37.8736 54.9164 37.917 54.7704 37.8249L54.7048 37.783C54.222 37.4724 53.0898 36.7445 51.3526 37.8261C51.3014 37.8577 51.2445 37.873 51.1879 37.873Z" fill="url(#paint15_linear_7456_16385)"/>
                                        <path d="M48.9988 44.4377C48.9981 44.4377 48.9978 44.4377 48.9972 44.4377C48.6925 44.4371 48.3984 44.2949 48.1469 44.0265C48.0291 43.9006 48.0353 43.7027 48.1613 43.5846C48.2872 43.4671 48.485 43.4731 48.6031 43.599C48.6944 43.6962 48.8369 43.8124 48.9981 43.8127H48.9988C49.1613 43.8127 49.3053 43.6962 49.3978 43.5981C49.5163 43.4724 49.7141 43.4668 49.8397 43.5852C49.965 43.7037 49.9709 43.9015 49.8525 44.0271C49.5988 44.2959 49.3038 44.4377 48.9988 44.4377Z" fill="url(#paint16_linear_7456_16385)"/>
                                        <path d="M45.25 49.75L47.75 62.875L42.75 58.1875L43.375 55.6875L41.1875 55.3747L43.6875 50.6872C43.9413 50.2281 44.6641 49.7503 45.25 49.75Z" fill="url(#paint17_linear_7456_16385)"/>
                                        <path d="M52.75 49.75L50.25 62.875L55.25 58.1875L54.625 55.6875L56.8125 55.3747L54.3125 50.6872C54.0587 50.2281 53.3359 49.7503 52.75 49.75Z" fill="url(#paint18_linear_7456_16385)"/>
                                        <path d="M43.6875 60.6875H42.125C41.9525 60.6875 41.8125 60.5478 41.8125 60.375C41.8125 60.2022 41.9525 60.0625 42.125 60.0625H43.6875C44.0322 60.0625 44.3125 59.7822 44.3125 59.4375V56.3125C44.3125 54.7616 43.0506 53.5 41.5 53.5C39.9494 53.5 38.6875 54.7616 38.6875 56.3125V59.4375C38.6875 59.7822 38.9678 60.0625 39.3125 60.0625H40.5625C40.735 60.0625 40.875 60.2022 40.875 60.375C40.875 60.5478 40.735 60.6875 40.5625 60.6875H39.3125C38.6231 60.6875 38.0625 60.1269 38.0625 59.4375V56.3125C38.0625 54.4172 39.6047 52.875 41.5 52.875C43.3953 52.875 44.9375 54.4172 44.9375 56.3125V59.4375C44.9375 60.1269 44.3769 60.6875 43.6875 60.6875Z" fill="url(#paint19_linear_7456_16385)"/>
                                        <path d="M41.5 52.875C39.6047 52.875 38.0625 54.4172 38.0625 56.3125H38.6875C38.6875 54.7616 39.9494 53.5 41.5 53.5C43.0506 53.5 44.3125 54.7616 44.3125 56.3125H44.9375C44.9375 54.4172 43.3953 52.875 41.5 52.875Z" fill="url(#paint20_linear_7456_16385)"/>
                                        <path d="M40.5625 60.0625H39.9375V60.6875H40.5625C40.735 60.6875 40.875 60.5478 40.875 60.375C40.875 60.2022 40.735 60.0625 40.5625 60.0625Z" fill="url(#paint21_linear_7456_16385)"/>
                                        <path d="M42.125 60.0625H42.75V60.6875H42.125C41.9525 60.6875 41.8125 60.5478 41.8125 60.375C41.8125 60.2022 41.9525 60.0625 42.125 60.0625Z" fill="url(#paint22_linear_7456_16385)"/>
                                        <path d="M53.9948 47.918C53.6755 48.133 53.342 48.3277 52.9961 48.5005H53.3752C55.7877 48.5005 57.7502 50.463 57.7502 52.8755V56.6255C57.7502 56.7983 57.8902 56.938 58.0627 56.938C58.2352 56.938 58.3752 56.7983 58.3752 56.6255V52.8755C58.3752 50.3289 56.4598 48.2248 53.9948 47.918Z" fill="url(#paint23_linear_7456_16385)"/>
                                        <path d="M44.0253 47.9316C42.4153 48.2163 41.1875 49.6226 41.1875 51.3132V53.1882C41.1875 53.361 41.3275 53.5007 41.5 53.5007C41.6725 53.5007 41.8125 53.361 41.8125 53.1882V51.3132C41.8125 49.7623 43.0744 48.5007 44.625 48.5007C44.7078 48.5007 44.7822 48.4673 44.8381 48.4145C44.5584 48.2676 44.2872 48.1066 44.0253 47.9316Z" fill="url(#paint24_linear_7456_16385)"/>
                                        <path d="M58.0625 59.4375C58.9254 59.4375 59.625 58.7379 59.625 57.875C59.625 57.0121 58.9254 56.3125 58.0625 56.3125C57.1996 56.3125 56.5 57.0121 56.5 57.875C56.5 58.7379 57.1996 59.4375 58.0625 59.4375Z" fill="url(#paint25_linear_7456_16385)"/>
                                        <path d="M58.0625 59.4375C58.9254 59.4375 59.625 58.7379 59.625 57.875C59.625 57.0121 58.9254 56.3125 58.0625 56.3125C57.1996 56.3125 56.5 57.0121 56.5 57.875C56.5 58.7379 57.1996 59.4375 58.0625 59.4375Z" fill="url(#paint26_linear_7456_16385)"/>
                                        <mask id="mask0_7456_16385" style="mask-type:luminance" maskUnits="userSpaceOnUse" x="56" y="56" width="4" height="4">
                                            <path d="M58.0625 59.4375C58.9254 59.4375 59.625 58.7379 59.625 57.875C59.625 57.0121 58.9254 56.3125 58.0625 56.3125C57.1996 56.3125 56.5 57.0121 56.5 57.875C56.5 58.7379 57.1996 59.4375 58.0625 59.4375Z" fill="white"/>
                                        </mask>
                                        <g mask="url(#mask0_7456_16385)">
                                            <path d="M56.5 56.3125H59.625V59.4375H56.5V56.3125Z" fill="url(#paint27_linear_7456_16385)"/>
                                        </g>
                                        <path d="M58.0625 59.75C57.0284 59.75 56.1875 58.9091 56.1875 57.875C56.1875 56.8409 57.0284 56 58.0625 56C59.0966 56 59.9375 56.8409 59.9375 57.875C59.9375 58.9091 59.0966 59.75 58.0625 59.75ZM58.0625 56.625C57.3731 56.625 56.8125 57.1856 56.8125 57.875C56.8125 58.5644 57.3731 59.125 58.0625 59.125C58.7519 59.125 59.3125 58.5644 59.3125 57.875C59.3125 57.1856 58.7519 56.625 58.0625 56.625Z" fill="url(#paint28_linear_7456_16385)"/>
                                        <defs>
                                            <filter id="filter0_f_7456_16385" x="0" y="-5.5" width="98" height="98" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                                                <feFlood flood-opacity="0" result="BackgroundImageFix"/>
                                                <feBlend mode="normal" in="SourceGraphic" in2="BackgroundImageFix" result="shape"/>
                                                <feGaussianBlur stdDeviation="17" result="effect1_foregroundBlur_7456_16385"/>
                                            </filter>
                                            <linearGradient id="paint0_linear_7456_16385" x1="49" y1="52.8228" x2="49" y2="49.5416" gradientUnits="userSpaceOnUse">
                                                <stop stop-color="#F6CFBE"/>
                                                <stop offset="1" stop-color="#EDAD99"/>
                                            </linearGradient>
                                            <linearGradient id="paint1_linear_7456_16385" x1="48.7356" y1="47.0247" x2="48.6541" y2="43.9634" gradientUnits="userSpaceOnUse">
                                                <stop stop-color="#FFCF97"/>
                                                <stop offset="1" stop-color="#FFAC6A"/>
                                            </linearGradient>
                                            <linearGradient id="paint2_linear_7456_16385" x1="49.6638" y1="40.1322" x2="49.3513" y2="45.3925" gradientUnits="userSpaceOnUse">
                                                <stop stop-color="#FFCF97"/>
                                                <stop offset="1" stop-color="#FFAC6A"/>
                                            </linearGradient>
                                            <linearGradient id="paint3_linear_7456_16385" x1="33.9191" y1="71.1634" x2="34.9875" y2="60.8953" gradientUnits="userSpaceOnUse">
                                                <stop stop-color="#EFF0F0"/>
                                                <stop offset="1" stop-color="#E4E5E6"/>
                                            </linearGradient>
                                            <linearGradient id="paint4_linear_7456_16385" x1="39.8112" y1="68.8359" x2="38.8291" y2="77.2834" gradientUnits="userSpaceOnUse">
                                                <stop stop-color="#EFF0F0"/>
                                                <stop offset="1" stop-color="#E4E5E6"/>
                                            </linearGradient>
                                            <linearGradient id="paint5_linear_7456_16385" x1="64.0813" y1="71.1634" x2="63.0128" y2="60.8953" gradientUnits="userSpaceOnUse">
                                                <stop stop-color="#EFF0F0"/>
                                                <stop offset="1" stop-color="#E4E5E6"/>
                                            </linearGradient>
                                            <linearGradient id="paint6_linear_7456_16385" x1="58.1888" y1="68.8359" x2="59.1709" y2="77.2834" gradientUnits="userSpaceOnUse">
                                                <stop stop-color="#EFF0F0"/>
                                                <stop offset="1" stop-color="#E4E5E6"/>
                                            </linearGradient>
                                            <linearGradient id="paint7_linear_7456_16385" x1="58.0625" y1="30.8959" x2="58.0625" y2="46.1066" gradientUnits="userSpaceOnUse">
                                                <stop stop-color="#F6CFBE"/>
                                                <stop offset="1" stop-color="#EDAD99"/>
                                            </linearGradient>
                                            <linearGradient id="paint8_linear_7456_16385" x1="39.625" y1="30.8959" x2="39.625" y2="46.1066" gradientUnits="userSpaceOnUse">
                                                <stop stop-color="#F6CFBE"/>
                                                <stop offset="1" stop-color="#EDAD99"/>
                                            </linearGradient>
                                            <linearGradient id="paint9_linear_7456_16385" x1="50.5178" y1="29.4906" x2="51.3772" y2="25.0375" gradientUnits="userSpaceOnUse">
                                                <stop stop-color="#F6CFBE"/>
                                                <stop offset="1" stop-color="#EDAD99"/>
                                            </linearGradient>
                                            <linearGradient id="paint10_linear_7456_16385" x1="48.6875" y1="18.1094" x2="48.6875" y2="44.1091" gradientUnits="userSpaceOnUse">
                                                <stop stop-color="#957E7F"/>
                                                <stop offset="1" stop-color="#373638"/>
                                            </linearGradient>
                                            <linearGradient id="paint11_linear_7456_16385" x1="49.3782" y1="40.6365" x2="49.222" y2="42.9803" gradientUnits="userSpaceOnUse">
                                                <stop stop-color="#F6CFBE"/>
                                                <stop offset="1" stop-color="#EDAD99"/>
                                            </linearGradient>
                                            <linearGradient id="paint12_linear_7456_16385" x1="44.8612" y1="50.5316" x2="44.9003" y2="45.3366" gradientUnits="userSpaceOnUse">
                                                <stop stop-color="#58595B"/>
                                                <stop offset="1" stop-color="#414042"/>
                                            </linearGradient>
                                            <linearGradient id="paint13_linear_7456_16385" x1="52.9859" y1="50.5775" x2="53.025" y2="45.3822" gradientUnits="userSpaceOnUse">
                                                <stop stop-color="#58595B"/>
                                                <stop offset="1" stop-color="#414042"/>
                                            </linearGradient>
                                            <linearGradient id="paint14_linear_7456_16385" x1="44.8121" y1="54.2294" x2="44.8643" y2="47.3025" gradientUnits="userSpaceOnUse">
                                                <stop stop-color="#58595B"/>
                                                <stop offset="1" stop-color="#414042"/>
                                            </linearGradient>
                                            <linearGradient id="paint15_linear_7456_16385" x1="52.9367" y1="54.2908" x2="52.9889" y2="47.3636" gradientUnits="userSpaceOnUse">
                                                <stop stop-color="#58595B"/>
                                                <stop offset="1" stop-color="#414042"/>
                                            </linearGradient>
                                            <linearGradient id="paint16_linear_7456_16385" x1="41.8022" y1="45.3856" x2="44.2828" y2="44.8777" gradientUnits="userSpaceOnUse">
                                                <stop stop-color="#F6CFBE"/>
                                                <stop offset="1" stop-color="#EDAD99"/>
                                            </linearGradient>
                                            <linearGradient id="paint17_linear_7456_16385" x1="47.7166" y1="73.0516" x2="47.0981" y2="70.2341" gradientUnits="userSpaceOnUse">
                                                <stop stop-color="#EFF0F0"/>
                                                <stop offset="1" stop-color="#E4E5E6"/>
                                            </linearGradient>
                                            <linearGradient id="paint18_linear_7456_16385" x1="50.2838" y1="73.0516" x2="50.9022" y2="70.2341" gradientUnits="userSpaceOnUse">
                                                <stop stop-color="#EFF0F0"/>
                                                <stop offset="1" stop-color="#E4E5E6"/>
                                            </linearGradient>
                                            <linearGradient id="paint19_linear_7456_16385" x1="41.9603" y1="63.1662" x2="41.8897" y2="62.3472" gradientUnits="userSpaceOnUse">
                                                <stop stop-color="#D0D3D3"/>
                                                <stop offset="1" stop-color="#AAAEB1"/>
                                            </linearGradient>
                                            <linearGradient id="paint20_linear_7456_16385" x1="40.4469" y1="47.7788" x2="40.525" y2="48.4038" gradientUnits="userSpaceOnUse">
                                                <stop stop-color="#58595B"/>
                                                <stop offset="1" stop-color="#414042"/>
                                            </linearGradient>
                                            <linearGradient id="paint21_linear_7456_16385" x1="40.4384" y1="60.8966" x2="40.4325" y2="60.8272" gradientUnits="userSpaceOnUse">
                                                <stop stop-color="#58595B"/>
                                                <stop offset="1" stop-color="#414042"/>
                                            </linearGradient>
                                            <linearGradient id="paint22_linear_7456_16385" x1="42.2491" y1="60.8966" x2="42.255" y2="60.8272" gradientUnits="userSpaceOnUse">
                                                <stop stop-color="#58595B"/>
                                                <stop offset="1" stop-color="#414042"/>
                                            </linearGradient>
                                            <linearGradient id="paint23_linear_7456_16385" x1="55.1127" y1="45.9461" x2="55.1908" y2="46.5711" gradientUnits="userSpaceOnUse">
                                                <stop stop-color="#58595B"/>
                                                <stop offset="1" stop-color="#414042"/>
                                            </linearGradient>
                                            <linearGradient id="paint24_linear_7456_16385" x1="42.6" y1="47.5104" x2="42.6781" y2="48.1354" gradientUnits="userSpaceOnUse">
                                                <stop stop-color="#58595B"/>
                                                <stop offset="1" stop-color="#414042"/>
                                            </linearGradient>
                                            <linearGradient id="paint25_linear_7456_16385" x1="61.2409" y1="59.0028" x2="61.9978" y2="59.2713" gradientUnits="userSpaceOnUse">
                                                <stop stop-color="#6C6F73"/>
                                                <stop offset="1" stop-color="#56585B"/>
                                            </linearGradient>
                                            <linearGradient id="paint26_linear_7456_16385" x1="51.9528" y1="57.0625" x2="54.4009" y2="57.3881" gradientUnits="userSpaceOnUse">
                                                <stop stop-color="#58595B"/>
                                                <stop offset="1" stop-color="#414042"/>
                                            </linearGradient>
                                            <linearGradient id="paint27_linear_7456_16385" x1="51.9528" y1="57.0625" x2="54.4009" y2="57.3881" gradientUnits="userSpaceOnUse">
                                                <stop stop-color="#6C6F73"/>
                                                <stop offset="1" stop-color="#56585B"/>
                                            </linearGradient>
                                            <linearGradient id="paint28_linear_7456_16385" x1="51.9528" y1="57.0625" x2="54.4009" y2="57.3881" gradientUnits="userSpaceOnUse">
                                                <stop stop-color="#D0D3D3"/>
                                                <stop offset="1" stop-color="#AAAEB1"/>
                                            </linearGradient>
                                        </defs>
                                    </svg>
                                </div>
                                <div>
                                    <span class="justify-content-center d-flex">{{__('home.Find a doctor')}}</span></div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="bg-homeNew">
        <div class="container pt-3">
            <div id="find-doctor--homeNew">
                <div class="title-findDoctor--homeNew d-md-flex justify-content-center">
                    <div class="py-3 text-center krm-tieuDe-findDoctor">{{ __('home.Find a doctor') }}</div>
                </div>
                <div class="tab-content py-4" id="myTabContent">
                    <div class="tab-pane fade show active" id="available" role="tabpanel"
                         aria-labelledby="available-tab">
                        @php
                            $doctors = \App\Models\User::where('member', \App\Enums\TypeUser::DOCTORS)->paginate(12);
                        @endphp
                        <div class="row">

                            @foreach($doctors as $doctor)
                                {{--                                @dd($doctor)--}}
                                @if($doctor == '')
                                    <h1 class="d-flex align-items-center justify-content-center mt-4">{{ __('home.null') }}</h1>
                                @else
                                    @php
                                        $isFavourite = null;
                                        if (Auth::check()){
                                            $isFavourite = \App\Models\MedicalFavourite::where('user_id', Auth::user()->id)
                                                                ->where('medical_id', $doctor->id)
                                                                ->first();
                                        }
                                        $class = !$isFavourite ? 'bi-heart' : 'bi-heart-fill text-danger';
                                    @endphp
                                    <div class="col-md-3 col-6">
                                        <div class="">
                                            <div class="product-item">
                                                <div class="img-pro justify-content-center d-flex">
                                                    <img loading="lazy" src="{{$doctor->avt}}" alt="">
                                                    <a class="button-heart button-doctor-heart"
                                                       data-doctor="{{$doctor->id}}"
                                                       data-isFavourite="{{ $isFavourite ? 1 : 0 }}">
                                                        <i class="bi {{ $class }}"></i>
                                                    </a>
                                                    <s class="icon-chuyen-khoa">
                                                        @php
                                                            $department = \App\Models\Department::where('id',$doctor->department_id)->value('thumbnail');
                                                        @endphp
                                                        <img loading="lazy" src="{{$department}}">
                                                    </s>
                                                </div>
                                                <div class="content-pro p-md-3 p-2">
                                                    <div class="">
                                                        <div class="name-product" style="height: auto">
                                                            <a class="max-3-line-content-home"
                                                               href="{{ route('examination.doctor_info', $doctor->id) }}">{{$doctor->name}}</a>
                                                        </div>
                                                        <div class="location-pro webkit-line-clamp-newHome d-flex">
                                                            <p>
                                                                @if(locationHelper() == 'vi')
                                                                    {!! ($doctor->service ?? __('home.no Service Name') ) !!}
                                                                @else
                                                                    {!! ($doctor->service_en  ?? __('home.no Service Name') ) !!}
                                                                @endif
                                                            </p>
                                                        </div>
                                                        <div class="price-pro">
                                                            @php
                                                                if ($doctor->province_id == null) {
                                                                    $addressP = 'Ha Noi';
                                                                    }
                                                                else {
                                                                    if (locationHelper() == 'vi') {
                                                                        $addressP = Province::find($doctor->province_id)->name;
                                                                    }
                                                                    else {
                                                                        $addressP = Province::find($doctor->province_id)->name_en;
                                                                    }
                                                                }
                                                            @endphp
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="21"
                                                                 height="21" viewBox="0 0 21 21" fill="none">
                                                                <g clip-path="url(#clip0_5506_14919)">
                                                                    <path
                                                                        d="M4.66602 12.8382C3.12321 13.5188 2.16602 14.4673 2.16602 15.5163C2.16602 17.5873 5.89698 19.2663 10.4993 19.2663C15.1017 19.2663 18.8327 17.5873 18.8327 15.5163C18.8327 14.4673 17.8755 13.5188 16.3327 12.8382M15.4993 7.59961C15.4993 10.986 11.7493 12.5996 10.4993 15.0996C9.24935 12.5996 5.49935 10.986 5.49935 7.59961C5.49935 4.83819 7.73793 2.59961 10.4993 2.59961C13.2608 2.59961 15.4993 4.83819 15.4993 7.59961ZM11.3327 7.59961C11.3327 8.05985 10.9596 8.43294 10.4993 8.43294C10.0391 8.43294 9.66602 8.05985 9.66602 7.59961C9.66602 7.13937 10.0391 6.76628 10.4993 6.76628C10.9596 6.76628 11.3327 7.13937 11.3327 7.59961Z"
                                                                        stroke="white" stroke-width="2"
                                                                        stroke-linecap="round"
                                                                        stroke-linejoin="round"/>
                                                                </g>
                                                                <defs>
                                                                    <clipPath id="clip0_5506_14919">
                                                                        <rect width="20" height="20" fill="white"
                                                                              transform="translate(0.5 0.933594)"/>
                                                                    </clipPath>
                                                                </defs>
                                                            </svg> &nbsp;
                                                            {{$addressP}}
                                                        </div>
                                                        <div class="price-pro">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="21"
                                                                 height="21" viewBox="0 0 21 21" fill="none">
                                                                <g clip-path="url(#clip0_5506_14923)">
                                                                    <path
                                                                        d="M10.4993 5.93294V10.9329L13.8327 12.5996M18.8327 10.9329C18.8327 15.5353 15.1017 19.2663 10.4993 19.2663C5.89698 19.2663 2.16602 15.5353 2.16602 10.9329C2.16602 6.33057 5.89698 2.59961 10.4993 2.59961C15.1017 2.59961 18.8327 6.33057 18.8327 10.9329Z"
                                                                        stroke="white" stroke-width="2"
                                                                        stroke-linecap="round"
                                                                        stroke-linejoin="round"/>
                                                                </g>
                                                                <defs>
                                                                    <clipPath id="clip0_5506_14923">
                                                                        <rect width="20" height="20" fill="white"
                                                                              transform="translate(0.5 0.933594)"/>
                                                                    </clipPath>
                                                                </defs>
                                                            </svg> &nbsp; {{$doctor->time_working_1}}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                        <div class="pagination mt-4 d-flex align-items-center justify-content-center">
                            {{ $doctors->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="background-image_HomeNew--departments">
        <div class="container">
            <div id="map-location" class="pb-5 d-flex justify-content-center">
                <div class="content-item  justify-content-center w-100">
                    <div class="title-clinics">
                        <h2>{{ __('home.Clinics/Pharmacies') }}</h2>
                        <p>{{ __('home.Find your suitable clinics/pharmacies and book now') }}!</p>
                    </div>
                    <div class="d-flex clip-path-container">
                        <div id="allAddressesMap" class="p-2 w-100">

                        </div>
                    </div>
                    <div id="" class="w-100 d-md-flex">
                        <div class="col-md-4 mt-4 d-flex text-map--homeNew">
                            <div class="mr-3">
                                <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" viewBox="0 0 64 64"
                                     fill="none">
                                    <g clip-path="url(#clip0_4225_13428)">
                                        <mask id="mask0_4225_13428" style="mask-type:luminance"
                                              maskUnits="userSpaceOnUse"
                                              x="0" y="0" width="64" height="64">
                                            <path d="M0 7.62939e-06H64V64H0V7.62939e-06Z" fill="white"/>
                                        </mask>
                                        <g mask="url(#mask0_4225_13428)">
                                            <path
                                                d="M36.1292 51.8662L38.8236 50.6817C39.6451 50.3207 40.6073 50.5924 41.1188 51.3297L43.2787 54.4437C43.2787 54.4437 45.7977 53.4954 49.6464 49.6466C53.4952 45.7979 54.4436 43.2789 54.4436 43.2789L51.3296 41.119C50.5922 40.6075 50.3206 39.6452 50.6816 38.8237L55.4029 28.0835C55.7508 27.2922 56.5936 26.8427 57.4451 26.9912C58.4846 27.1724 59.8754 27.6294 61.0063 28.7601C65.3608 33.1147 62.7218 44.9129 53.8172 53.8174C44.9127 62.722 33.1146 65.361 28.7599 61.0065C27.6292 59.8756 27.1722 58.4847 26.9911 57.4452C26.8426 56.5937 27.2921 55.751 28.0833 55.4031L32.7446 53.3541"
                                                stroke="#088180" stroke-width="3" stroke-miterlimit="10"
                                                stroke-linecap="round" stroke-linejoin="round"/>
                                            <path
                                                d="M11.7607 50.3398C7.36537 45.4922 4.6875 39.0587 4.6875 31.9998C4.6875 16.9155 16.9157 4.68735 32 4.68735C33.8856 4.68735 35.7265 4.87835 37.5044 5.24222"
                                                stroke="#088180" stroke-width="3" stroke-miterlimit="10"
                                                stroke-linecap="round" stroke-linejoin="round"/>
                                            <path d="M27.4086 58.9277C24.1228 58.3715 21.0367 57.2284 18.2617 55.6101"
                                                  stroke="#088180" stroke-width="3" stroke-miterlimit="10"
                                                  stroke-linecap="round" stroke-linejoin="round"/>
                                            <path d="M39.2871 30.3453H47.3737L40.912 45.0449" stroke="#088180"
                                                  stroke-width="3" stroke-miterlimit="10" stroke-linecap="round"
                                                  stroke-linejoin="round"/>
                                            <path d="M39.6513 19.9842L28.6348 45.0449" stroke="#088180" stroke-width="3"
                                                  stroke-miterlimit="10" stroke-linecap="round"
                                                  stroke-linejoin="round"/>
                                            <path
                                                d="M30.5375 30.3451H21.3066C21.3066 30.3451 26.194 21.4862 27.0005 20.4967C27.8161 19.4961 28.5884 20.1202 28.6619 21.0028C28.7354 21.8855 28.6251 34.6836 28.6251 34.6836"
                                                stroke="#088180" stroke-width="3" stroke-miterlimit="10"
                                                stroke-linecap="round" stroke-linejoin="round"/>
                                            <path
                                                d="M20.2431 34.793L12.7525 34.77C12.7525 34.77 13.2956 34.0606 17.9846 27.3607C18.8602 26.1096 19.3423 25.054 19.5475 24.1696L19.6201 23.601C19.6201 21.5236 17.936 19.8397 15.8587 19.8397C14.0308 19.8397 12.5075 21.1435 12.168 22.872"
                                                stroke="#088180" stroke-width="3" stroke-miterlimit="10"
                                                stroke-linecap="round" stroke-linejoin="round"/>
                                            <path
                                                d="M58.2024 12.6879C58.2024 16.4933 55.1175 19.5781 51.3121 19.5781C47.5069 19.5781 44.4219 16.4933 44.4219 12.6879C44.4219 8.8825 47.5069 5.79763 51.3121 5.79763C55.1175 5.79763 58.2024 8.8825 58.2024 12.6879Z"
                                                stroke="#088180" stroke-width="3" stroke-miterlimit="10"
                                                stroke-linecap="round" stroke-linejoin="round"/>
                                            <path
                                                d="M12.9087 44.4283C14.6395 45.2989 15.8276 47.0898 15.8276 49.1593C15.8276 52.0829 13.4575 54.4531 10.5337 54.4531C8.46423 54.4531 6.67336 53.2649 5.80273 51.5343C5.91986 55.2369 8.95623 58.2031 12.6874 58.2031C16.4927 58.2031 19.5776 55.1183 19.5776 51.3129C19.5776 47.5818 16.6115 44.5454 12.9087 44.4283Z"
                                                stroke="#088180" stroke-width="3" stroke-miterlimit="10"
                                                stroke-linecap="round" stroke-linejoin="round"/>
                                            <path d="M51.3125 5.79688V0.937501" stroke="#088180" stroke-width="3"
                                                  stroke-miterlimit="10" stroke-linecap="round"
                                                  stroke-linejoin="round"/>
                                            <path d="M47.8671 6.7207L45.4375 2.51233" stroke="#088180" stroke-width="3"
                                                  stroke-miterlimit="10" stroke-linecap="round"
                                                  stroke-linejoin="round"/>
                                            <path d="M57.2793 16.1329L61.4877 18.5625" stroke="#088180" stroke-width="3"
                                                  stroke-miterlimit="10" stroke-linecap="round"
                                                  stroke-linejoin="round"/>
                                            <path d="M58.2031 12.6875H63.0625" stroke="#088180" stroke-width="3"
                                                  stroke-miterlimit="10" stroke-linecap="round"
                                                  stroke-linejoin="round"/>
                                            <path d="M44.4219 12.6875H39.5625" stroke="#088180" stroke-width="3"
                                                  stroke-miterlimit="10" stroke-linecap="round"
                                                  stroke-linejoin="round"/>
                                            <path d="M45.3451 9.24219L41.1367 6.81256" stroke="#088180" stroke-width="3"
                                                  stroke-miterlimit="10" stroke-linecap="round"
                                                  stroke-linejoin="round"/>
                                            <path d="M54.7578 18.6549L57.1874 22.8633" stroke="#088180" stroke-width="3"
                                                  stroke-miterlimit="10" stroke-linecap="round"
                                                  stroke-linejoin="round"/>
                                            <path d="M51.3125 19.5781V24.4375" stroke="#088180" stroke-width="3"
                                                  stroke-miterlimit="10" stroke-linecap="round"
                                                  stroke-linejoin="round"/>
                                            <path d="M57.2793 9.24219L61.4877 6.81256" stroke="#088180" stroke-width="3"
                                                  stroke-miterlimit="10" stroke-linecap="round"
                                                  stroke-linejoin="round"/>
                                            <path d="M54.7578 6.7207L57.1874 2.51233" stroke="#088180" stroke-width="3"
                                                  stroke-miterlimit="10" stroke-linecap="round"
                                                  stroke-linejoin="round"/>
                                            <path d="M2.81836 43.4434V48.4434" stroke="#088180" stroke-width="3"
                                                  stroke-miterlimit="10" stroke-linecap="round"
                                                  stroke-linejoin="round"/>
                                            <path d="M0.943359 45.9434H4.69336" stroke="#088180" stroke-width="3"
                                                  stroke-miterlimit="10" stroke-linecap="round"
                                                  stroke-linejoin="round"/>
                                            <path d="M18.9922 59.7738V63.0625" stroke="#088180" stroke-width="3"
                                                  stroke-miterlimit="10" stroke-linecap="round"
                                                  stroke-linejoin="round"/>
                                            <path d="M17.7598 61.418H20.2263" stroke="#088180" stroke-width="3"
                                                  stroke-miterlimit="10" stroke-linecap="round"
                                                  stroke-linejoin="round"/>
                                        </g>
                                    </g>
                                    <defs>
                                        <clipPath id="clip0_4225_13428">
                                            <rect width="64" height="64" fill="white"/>
                                        </clipPath>
                                    </defs>
                                </svg>
                            </div>
                            <div class="title--newAddress">
                                <h3>{{ __('home.24/7 AVAILABLE') }}</h3>
                                <p>{{ __('home.You can find available clinics/pharmacies') }}</p>
                            </div>
                        </div>
                        <div class="col-md-4 mt-4 d-flex text-map--homeNew">
                            <div class="mr-3">
                                <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" viewBox="0 0 64 64"
                                     fill="none">
                                    <g clip-path="url(#clip0_4225_13482)">
                                        <path
                                            d="M36.8484 31.4238C34.9455 31.4238 33.2247 32.2187 32.0005 33.4935C30.7763 32.2187 29.0554 31.4238 27.1526 31.4238C23.4456 31.4238 20.4297 34.4397 20.4297 38.1467C20.4297 41.2818 21.804 44.2393 24.2002 46.261L32.0005 52.8424L39.8008 46.261C42.197 44.2393 43.5713 41.2818 43.5713 38.1467C43.5714 34.4397 40.5555 31.4238 36.8484 31.4238ZM37.3828 43.395L32.0005 47.9361L26.6182 43.3949C25.0684 42.0873 24.1794 40.1744 24.1794 38.1467C24.1794 36.5074 25.5131 35.1737 27.1524 35.1737C28.7917 35.1737 30.1254 36.5074 30.1254 38.1467H33.8753C33.8753 36.5074 35.209 35.1737 36.8483 35.1737C38.4876 35.1737 39.8213 36.5074 39.8213 38.1467C39.8216 40.1745 38.9326 42.0873 37.3828 43.395Z"
                                            fill="#088180"/>
                                        <path
                                            d="M63.9025 28.1582C63.6036 26.4282 62.649 24.9181 61.2143 23.9061L32.0001 3.29883L2.78575 23.9063C1.35105 24.9182 0.396467 26.4283 0.0976033 28.1584C-0.20126 29.8883 0.191475 31.6312 1.20356 33.0658C2.21552 34.5004 3.72559 35.4551 5.45564 35.7539C5.83375 35.8193 6.21236 35.8516 6.58847 35.8516C7.11583 35.8516 7.63756 35.7871 8.14491 35.6621V56.9519H3.9712V60.7017H60.0289V56.9519H55.8552V35.6576C58.4046 36.2818 61.1943 35.3369 62.7965 33.0658C63.8086 31.6311 64.2012 29.8883 63.9025 28.1582ZM11.8948 56.9519V33.5675L32 19.3854L52.1053 33.5675V56.9519H11.8948ZM59.7324 30.9042C58.8349 32.1762 57.0703 32.4809 55.7985 31.5838L32 14.7965L8.20141 31.5838C7.58519 32.0186 6.83709 32.1868 6.09387 32.0588C5.3509 31.9305 4.7023 31.5205 4.26769 30.9042C3.83308 30.2881 3.66446 29.5397 3.79271 28.7967C3.92108 28.0537 4.33119 27.4051 4.94729 26.9705L32.0001 7.88765L59.0528 26.9704C59.669 27.405 60.079 28.0536 60.2074 28.7966C60.3357 29.5396 60.167 30.288 59.7324 30.9042Z"
                                            fill="#088180"/>
                                    </g>
                                    <defs>
                                        <clipPath id="clip0_4225_13482">
                                            <rect width="64" height="64" fill="white"/>
                                        </clipPath>
                                    </defs>
                                </svg>
                            </div>
                            <div class="title--newAddress"><h3>{{ __('home.HOME CARE SERVICE') }}</h3>
                                <p>{{ __("home.Don't come to us! We will come to you") }}!</p>
                            </div>
                        </div>
                        <div class="col-md-4 mt-4 d-flex text-map--homeNew">
                            <div class="mr-3">
                                <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" viewBox="0 0 64 64"
                                     fill="none">
                                    <path
                                        d="M32.0006 0C20.4563 0 11.0645 9.39188 11.0645 20.9361C11.0645 25.6241 14.3508 33.9281 20.8325 45.6174C25.5777 54.175 32.0006 64 32.0006 64C32.0006 64 38.4235 54.1749 43.1686 45.6174C49.6502 33.928 52.9366 25.624 52.9366 20.936C52.9366 9.39188 43.5447 0 32.0006 0ZM20.7572 37.4868C19.9593 35.9074 19.205 34.3466 18.5177 32.8361C19.3955 31.5266 20.8801 30.7126 22.4882 30.7126H25.3595C27.927 30.7126 30.0268 32.7487 30.1316 35.2909C30.1301 35.3573 30.1265 35.4233 30.1265 35.4899V37.4869L20.7572 37.4868ZM21.4655 24.5265C21.4655 23.1766 22.5637 22.0784 23.9135 22.0784C25.2633 22.0784 26.3616 23.1766 26.3616 24.5265C26.3616 25.8764 25.2633 26.9745 23.9135 26.9745C22.5637 26.9745 21.4655 25.8764 21.4655 24.5265ZM30.5692 18.6795H33.4406C34.457 18.6795 35.4547 19.0336 36.2775 19.6426C34.8211 20.7755 33.8813 22.5427 33.8813 24.5266C33.8813 25.7546 34.2425 26.8993 34.8621 27.8625C33.7483 28.4167 32.7727 29.2075 32.0008 30.1691C31.2253 29.2031 30.2445 28.4093 29.1242 27.8547C29.7407 26.893 30.0998 25.7514 30.0998 24.5268C30.0998 22.5413 29.1586 20.7726 27.7001 19.6399C28.5138 19.028 29.515 18.6795 30.5692 18.6795ZM29.5467 12.4934C29.5467 11.1435 30.645 10.0454 31.9947 10.0454C33.3446 10.0454 34.4428 11.1435 34.4428 12.4934C34.4428 13.8433 33.3446 14.9415 31.9947 14.9415C30.645 14.9415 29.5467 13.8433 29.5467 12.4934ZM32.0006 57.1306C29.4448 53.0885 25.9071 47.208 22.7042 41.2249H41.2972C38.0941 47.2079 34.5562 53.0885 32.0006 57.1306ZM43.2436 37.4868H33.8643V35.4897H33.8645H33.8746C33.8746 35.423 33.8711 35.3571 33.8695 35.2907C33.9742 32.7485 36.0742 30.7125 38.6416 30.7125H41.5128C43.121 30.7125 44.6056 31.5264 45.4833 32.836C44.796 34.3466 44.0415 35.9074 43.2436 37.4868ZM37.6192 24.5266C37.6192 23.1768 38.7175 22.0785 40.0672 22.0785C41.417 22.0785 42.5152 23.1768 42.5152 24.5266C42.5152 25.8765 41.417 26.9746 40.0672 26.9746C38.7175 26.9746 37.6192 25.8765 37.6192 24.5266ZM45.2771 27.8554C45.8938 26.8935 46.2532 25.7515 46.2532 24.5265C46.2532 21.1743 43.5726 18.4384 40.2427 18.3447C39.4255 17.2715 38.38 16.4142 37.2005 15.8285C37.8197 14.8652 38.1807 13.7209 38.1807 12.4932C38.1807 9.08225 35.4056 6.30725 31.9946 6.30725C28.5837 6.30725 25.8086 9.08225 25.8086 12.4932C25.8086 13.7204 26.1692 14.8642 26.788 15.8271C25.6063 16.4126 24.5658 17.2703 23.7593 18.3442C20.4195 18.4265 17.7273 21.1671 17.7273 24.5265C17.7273 25.7546 18.0886 26.8994 18.7083 27.8629C18.0596 28.1847 17.4532 28.5874 16.9056 29.0621C15.6098 25.7809 14.8023 22.9321 14.8023 20.9359C14.8023 11.4529 22.5173 3.73787 32.0005 3.73787C41.4835 3.73787 49.1985 11.4529 49.1985 20.936C49.1985 22.9323 48.3909 25.7809 47.0952 29.0621C46.5433 28.5837 45.9316 28.1785 45.2771 27.8554Z"
                                        fill="#088180"/>
                                </svg>
                            </div>
                            <div class="title--newAddress"><h3>{{ __('home.MANY LOCATION') }}</h3>
                                <p>{{ __('home.More than 1500 Doctors, 1000 Pharmacists, 1000 Hospitals always wait for you') }}</p>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="">
                <div
                    class="titleServiceHomeNew d-flex justify-content-between align-items-center">{{__('home.Chuyên khoa khám')}}
                    <a
                        class="pc-hidden" href="{{route('home.specialist')}}">{{__('home.see more')}}</a></div>
                <div class="mainServiceHomeNew row">
                    @php
                        $departments = \App\Models\Department::where('status', \App\Enums\DepartmentStatus::ACTIVE)->get();
                        $departmentsMobile = \App\Models\Department::where('status', \App\Enums\DepartmentStatus::ACTIVE)->get();
                    @endphp
                    @foreach($departments as $index => $departmentItem)
                        @php
                            $showDesktop = $index > 5;
                        @endphp
                        <div class="col-md-4 d-none {{ $showDesktop == true ? 'd-md-block' : 'd-sm-block' }}">
                            <a href="{{route('home.specialist.department',$departmentItem->id)}}">
                                <div class="border-HomeNew">
                                    <div class="w-75 d-flex align-items-center ">
                                        <img loading="lazy" src="{{$departmentItem->thumbnail}}" alt="thumbnail">
                                        <span>
                                            @if(locationHelper() == 'vi')
                                                {{ ($departmentItem->name ?? __('home.no name') ) }}
                                            @else
                                                {{ ($departmentItem->name_en  ?? __('home.no name') ) }}
                                            @endif
                                        </span>
                                    </div>
                                    <div class="svg-containerNho">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                             viewBox="0 0 24 24"
                                             fill="none">
                                            <path opacity="0.5" fill-rule="evenodd" clip-rule="evenodd"
                                                  d="M16.6666 0H7.3333V7.33268L0 7.33268V16.666H7.3333V24H16.6666V16.666H24V7.33268L16.6666 7.33268V0Z"
                                                  fill="#D8F6FF"/>
                                        </svg>
                                    </div>
                                    <div class="svg-container">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="60" height="60"
                                             viewBox="0 0 60 60"
                                             fill="none">
                                            <path opacity="0.5" fill-rule="evenodd" clip-rule="evenodd"
                                                  d="M41.6667 0H18.3333V18.3327H0V41.666H18.3333V60H41.6667V41.666H60V18.3327H41.6667V0Z"
                                                  fill="#D8F6FF"/>
                                        </svg>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>



    <div class="banner1 m-0">
        <img loading="lazy" src="{{asset('img/icons_logo/Rectangle 23814.png')}}" alt="">
    </div>
    <div class="container pb-5 mt-4">
        <div id="recruitment-homeNew" class="">
            <div class="title-recruitment--homeNew">
                <span>{{ __('home.Recruitment') }}</span>
                <p>{{ __('home.Hire staffs cheaper, find your staffs faster') }}</p>
            </div>
            <div class="d-md-flex main-recruitment--homeNew justify-content-between">
                <div class="col-md-6 col-12 pl-0 main-card--homeNew">
                    <div class="d-flex content-recruitment--homeNew">
                        <div class="col-md-3 col-4 p-0">
                            <img loading="lazy" src="{{asset('img/icons_logo/image 1.jpeg')}}" alt=""/>
                        </div>
                        <div class="col-md-9 col-8 text-title--card">
                            <span>
                                {{ __('home.Nhận liền tay voucher khám online trị giá 250k từ Phòng khám Med247') }}
                            </span>
                            <div class="content__item__describe">
                                {{ __('home.Chiều qua, nhận được cuộc gọi của một đồng nghiệp, hỏi ý kiến về một cô gái bị mù mắt sau khi được tiêm chất làm đầy. Dù đã có ...') }}
                            </div>
                        </div>
                    </div>
                    <div class="d-flex content-recruitment--homeNew">
                        <div class="col-md-3 col-4 p-0">
                            <img loading="lazy" src="{{asset('img/icons_logo/image 1.jpeg')}}" alt=""/>
                        </div>
                        <div class="col-md-9 col-8 text-title--card">
                            <span>
                                {{ __('home.Nhận liền tay voucher khám online trị giá 250k từ Phòng khám Med247') }}
                            </span>
                            <div class="content__item__describe">
                                {{ __('home.Chiều qua, nhận được cuộc gọi của một đồng nghiệp, hỏi ý kiến về một cô gái bị mù mắt sau khi được tiêm chất làm đầy. Dù đã có ...') }}
                            </div>
                        </div>
                    </div>
                    <div class="d-flex content-recruitment--homeNew">
                        <div class="col-md-3 col-4 p-0">
                            <img loading="lazy" src="{{asset('img/icons_logo/image 1.jpeg')}}" alt=""/>
                        </div>
                        <div class="col-md-9 col-8 text-title--card">
                            <span>
                                {{ __('home.Nhận liền tay voucher khám online trị giá 250k từ Phòng khám Med247') }}
                            </span>
                            <div class="content__item__describe">
                                {{ __('home.Chiều qua, nhận được cuộc gọi của một đồng nghiệp, hỏi ý kiến về một cô gái bị mù mắt sau khi được tiêm chất làm đầy. Dù đã có ...') }}
                            </div>
                        </div>
                    </div>
                    <div class="d-flex content-recruitment--homeNew">
                        <div class="col-md-3 col-4 p-0">
                            <img loading="lazy" src="{{asset('img/icons_logo/image 1.jpeg')}}" alt=""/>
                        </div>
                        <div class="col-md-9 col-8 text-title--card">
                            <span>
                                {{ __('home.Nhận liền tay voucher khám online trị giá 250k từ Phòng khám Med247') }}
                            </span>
                            <div class="content__item__describe">
                                {{ __('home.Chiều qua, nhận được cuộc gọi của một đồng nghiệp, hỏi ý kiến về một cô gái bị mù mắt sau khi được tiêm chất làm đầy. Dù đã có ...') }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-5 main-title-card--homeNew col-12">
                    <div class="w-100">
                        <div class="describe-item d-md-flex">
                            <svg xmlns="http://www.w3.org/2000/svg" class="mr-4" width="64" height="64"
                                 viewBox="0 0 64 64"
                                 fill="none">
                                <g clip-path="url(#clip0_5901_81337)">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                          d="M50.1316 51.9878L39.6232 41.4926C39.4078 41.2775 39.3844 40.9542 39.5123 40.6781C39.6402 40.4018 39.9007 40.2353 40.2051 40.2353H45.0993L45.0992 17.2473C45.0992 16.4066 45.7851 15.7207 46.6258 15.7207H54.8008C55.6414 15.7207 56.3273 16.4068 56.3273 17.2473L56.3276 40.2353H61.2218C61.5262 40.2353 61.7867 40.4017 61.9144 40.6781C62.0423 40.9543 62.0006 41.2606 61.8036 41.4927L51.2949 51.988C51.1309 52.1517 50.9452 52.2572 50.7132 52.2572C50.4815 52.2571 50.2957 52.1518 50.1316 51.9878Z"
                                          fill="#B9EA6A"/>
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                          d="M50.1315 51.9878L48.8374 50.6955L59.3035 40.2426L59.3095 40.2353H61.2217C61.526 40.2353 61.7865 40.4017 61.9143 40.6781C62.0422 40.9543 62.0004 41.2606 61.8034 41.4927L51.2948 51.988C51.1308 52.1517 50.945 52.2572 50.713 52.2572C50.4814 52.2571 50.2957 52.1518 50.1315 51.9878ZM53.802 15.7207C53.8185 15.8105 53.8273 15.9028 53.8273 15.9973L53.8275 40.2355H56.3277L56.3274 17.2475C56.3274 16.407 55.6415 15.7208 54.8009 15.7208L53.802 15.7207Z"
                                          fill="#A1E42C"/>
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                          d="M20.2045 61.1951L6.75042 47.758C6.47467 47.4825 6.44479 47.0687 6.60842 46.7151C6.77204 46.3615 7.10554 46.1482 7.49529 46.1482H13.7615L13.7614 16.7162C13.7614 15.6398 14.6397 14.7617 15.7159 14.7617H26.1825C27.2588 14.7617 28.137 15.6401 28.137 16.7162L28.1373 46.1482H34.4037C34.7933 46.1482 35.1269 46.3613 35.2905 46.7151C35.4543 47.0688 35.4008 47.4608 35.1487 47.7581L21.6943 61.1952C21.4843 61.405 21.2464 61.54 20.9495 61.54C20.6524 61.5398 20.4147 61.4051 20.2045 61.1951Z"
                                          fill="#B9EA6A"/>
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                          d="M20.2046 61.1952L19.0674 60.0595C19.1109 60.0246 19.1531 59.9863 19.1943 59.9452L32.6486 46.508C32.7414 46.3987 32.8073 46.2766 32.8453 46.1482H34.4038C34.7934 46.1482 35.127 46.3613 35.2906 46.7151C35.4544 47.0688 35.4009 47.4608 35.1488 47.7581L21.6944 61.1953C21.4844 61.4051 21.2465 61.5401 20.9496 61.5401C20.6525 61.54 20.4148 61.4052 20.2046 61.1952ZM25.5054 14.7617C25.5904 14.9805 25.6373 15.2181 25.6373 15.4662L25.6375 46.1483H28.1375L28.1373 16.7163C28.1373 15.6402 27.2591 14.7618 26.1828 14.7618L25.5054 14.7617Z"
                                          fill="#A1E42C"/>
                                    <path
                                        d="M34.3339 34.7853C41.7284 27.3909 41.7284 15.4021 34.3339 8.00767C26.9395 0.613234 14.9507 0.613234 7.55629 8.00767C0.161856 15.4021 0.161856 27.3909 7.55629 34.7853C14.9507 42.1797 26.9395 42.1797 34.3339 34.7853Z"
                                        fill="#FCDD2E"/>
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                          d="M20.9496 2.45898C31.4085 2.45898 39.8871 10.9376 39.8871 21.3965C39.8871 31.8554 31.4085 40.334 20.9496 40.334C20.5433 40.334 20.1406 40.3196 19.7407 40.2945C29.6361 39.671 37.4693 31.4491 37.4693 21.3965C37.4693 11.3439 29.6361 3.12211 19.7407 2.49848C20.1406 2.47323 20.5435 2.45898 20.9496 2.45898Z"
                                          fill="#FBD307"/>
                                    <path
                                        d="M20.9497 36.2968C29.1784 36.2968 35.849 29.6261 35.849 21.3974C35.849 13.1687 29.1784 6.49805 20.9497 6.49805C12.721 6.49805 6.05029 13.1687 6.05029 21.3974C6.05029 29.6261 12.721 36.2968 20.9497 36.2968Z"
                                        fill="#FBD307"/>
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                          d="M20.9497 6.49805C21.3567 6.49805 21.7597 6.51505 22.1584 6.54705C14.4952 7.16242 8.46792 13.5757 8.46792 21.3974C8.46792 29.219 14.4952 35.6324 22.1584 36.2478C21.7597 36.2798 21.3567 36.2968 20.9497 36.2968C12.7209 36.2968 6.05029 29.6262 6.05029 21.3974C6.05029 13.1688 12.721 6.49805 20.9497 6.49805Z"
                                          fill="#F9C301"/>
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                          d="M26.1723 16.9921C26.4214 17.7817 25.9834 18.6237 25.1938 18.8729C24.4042 19.1221 23.562 18.6841 23.3129 17.8944C23.2028 17.5452 22.9292 17.2286 22.5504 16.9908C22.122 16.7218 21.5675 16.5617 20.9495 16.5617C20.2223 16.5617 19.5783 16.7886 19.125 17.1554C18.7607 17.4503 18.5352 17.8316 18.5352 18.2291C18.5352 18.6266 18.7605 19.0079 19.125 19.3028C19.5783 19.6696 20.2224 19.8966 20.9495 19.8966C22.3842 19.8966 23.6974 20.3788 24.6608 21.1583C25.713 22.0098 26.3639 23.2124 26.3639 24.5641C26.3639 25.9158 25.713 27.1183 24.6608 27.9698C24.0463 28.4671 23.2894 28.8432 22.4495 29.0506V29.6291C22.4495 30.4574 21.7779 31.1291 20.9495 31.1291C20.1212 31.1291 19.4495 30.4574 19.4495 29.6291V29.0502C18.9239 28.9202 18.4309 28.7239 17.9854 28.4733C17.0632 27.9546 16.3352 27.1938 15.9194 26.2878C15.5764 25.5371 15.9069 24.6503 16.6577 24.3073C17.4084 23.9643 18.2952 24.2948 18.6382 25.0456C18.7834 25.3622 19.07 25.6461 19.4502 25.8599C19.8664 26.0941 20.3827 26.2314 20.9495 26.2314C21.6767 26.2314 22.3208 26.0046 22.774 25.6377C23.1384 25.3428 23.3639 24.9616 23.3639 24.5641C23.3639 24.1664 23.1384 23.7852 22.774 23.4903C22.3207 23.1236 21.6767 22.8966 20.9495 22.8966C19.5149 22.8966 18.2017 22.4143 17.2383 21.6348C16.186 20.7833 15.5352 19.5808 15.5352 18.2291C15.5352 16.8773 16.186 15.6748 17.2383 14.8233C17.8528 14.3261 18.6097 13.9498 19.4495 13.7426V13.1641C19.4495 12.3357 20.1212 11.6641 20.9495 11.6641C21.7779 11.6641 22.4495 12.3357 22.4495 13.1641V13.7442C23.066 13.8976 23.6389 14.1423 24.1442 14.4596C25.1194 15.0718 25.8459 15.9572 26.1723 16.9921Z"
                                          fill="#F4F8F8"/>
                                </g>
                                <defs>
                                    <clipPath id="clip0_5901_81337">
                                        <rect width="64" height="64" fill="white"/>
                                    </clipPath>
                                </defs>
                            </svg>
                            <div class="title-re">
                                <span>{{ __('home.HIRE CHEAPER') }}</span>
                                <p>{{ __('home.Only 500000vnđ, you can hire your staffs.') }}</p>
                            </div>
                        </div>
                        <div class="describe-item d-md-flex">
                            <svg xmlns="http://www.w3.org/2000/svg" class="mr-4" width="64" height="64"
                                 viewBox="0 0 64 64"
                                 fill="none">
                                <g clip-path="url(#clip0_5901_81351)">
                                    <path
                                        d="M59.7812 38.6884H58.5312C60.8613 38.6884 62.75 36.7996 62.75 34.4696C62.75 32.1396 60.8613 30.2509 58.5312 30.2509H49.7261L52.5353 19.7667C53.1383 17.5162 51.8026 15.2029 49.5521 14.5999C47.3016 13.9969 44.9884 15.3325 44.3853 17.583L43.3493 21.4492C41.9584 26.6409 37.2537 30.2509 31.879 30.2509H22.75V59.0009H29.9375L30.875 60.2509C32.6455 62.6115 35.4241 64.0009 38.375 64.0009H54.7812C57.1113 64.0009 59 62.1121 59 59.7821C59 57.4521 57.1113 55.5634 54.7812 55.5634H57.2812C59.6113 55.5634 61.5 53.6746 61.5 51.3446C61.5 49.0146 59.6113 47.1259 57.2812 47.1259H59.7812C62.1113 47.1259 64 45.2371 64 42.9071C64 40.5771 62.1113 38.6884 59.7812 38.6884Z"
                                        fill="#FFDECF"/>
                                    <path
                                        d="M61.5 51.3438C61.5 49.0138 59.6113 47.125 57.2812 47.125H22.75V59H29.9375L30.875 60.25C32.6455 62.6106 35.4241 64 38.375 64H54.7812C57.1113 64 59 62.1112 59 59.7812C59 57.4513 57.1113 55.5625 54.7812 55.5625H57.2812C59.6113 55.5625 61.5 53.6737 61.5 51.3438Z"
                                        fill="#FFCDBE"/>
                                    <path
                                        d="M16.9496 1.15125C16.9442 1.137 16.9386 1.12275 16.9328 1.10863C16.6558 0.435 16.0065 0 15.2782 0C15.2776 0 15.277 0 15.2763 0C14.5473 0.00075 13.8981 0.43725 13.6222 1.112C13.6173 1.12363 13.6127 1.1355 13.6082 1.14725L9.85322 11.0064C9.5461 11.8129 9.95085 12.7155 10.7572 13.0228C11.5637 13.3298 12.4665 12.9251 12.7736 12.1188L13.3255 10.6696H17.2015L17.7466 12.1143C17.9827 12.74 18.5773 13.1255 19.2087 13.1255C19.392 13.1255 19.5785 13.093 19.7602 13.0244C20.5676 12.7196 20.9751 11.8183 20.6703 11.0109L16.9496 1.15125ZM14.5157 7.5445L15.2725 5.55763L16.0222 7.5445H14.5157Z"
                                        fill="#613393"/>
                                    <path
                                        d="M5.77612 3.125C6.639 3.125 7.33862 2.42537 7.33862 1.5625C7.33862 0.699625 6.639 0 5.77612 0H1.5625C0.699625 0 0 0.6995 0 1.5625V11.5625C0 12.4254 0.699625 13.125 1.5625 13.125H5.77612C6.639 13.125 7.33862 12.4254 7.33862 11.5625C7.33862 10.6996 6.639 10 5.77612 10H3.125V8.125H5.46537C6.32837 8.125 7.02787 7.4255 7.02787 6.5625C7.02787 5.6995 6.32837 5 5.46537 5H3.125V3.125H5.77612Z"
                                        fill="#613393"/>
                                    <path
                                        d="M43.9774 0.27847C43.2541 -0.192155 42.2863 0.0122198 41.8155 0.735595L39.955 3.5936L38.0711 0.70847C37.5994 -0.0140302 36.6311 -0.21753 35.9086 0.25447C35.186 0.72622 34.9828 1.69447 35.4546 2.41697L38.3935 6.91785L38.3821 11.559C38.38 12.422 39.0779 13.1232 39.9408 13.1253H39.9446C40.8058 13.1253 41.5049 12.4283 41.5071 11.5667L41.5185 6.92035L44.4346 2.44072C44.9053 1.71722 44.7006 0.749345 43.9774 0.27847Z"
                                        fill="#613393"/>
                                    <path
                                        d="M29.6304 5.18651C28.4605 4.75501 27.3675 4.28614 26.9759 4.11539C26.8678 4.01051 26.8584 3.87876 26.8725 3.78014C26.9078 3.53451 27.1164 3.33689 27.445 3.23789C28.6153 2.88514 29.5028 3.46389 29.6809 3.59351C30.1428 4.16564 30.9599 4.34776 31.6323 3.98877C32.3934 3.58214 32.6807 2.63539 32.274 1.87426C31.7352 0.865765 29.2918 -0.582235 26.5438 0.24564C25.0475 0.696265 23.9883 1.88051 23.7794 3.33601C23.5823 4.70926 24.1779 6.03064 25.3339 6.78427C25.4029 6.82927 25.4754 6.86876 25.5507 6.90227C25.6088 6.92827 26.992 7.54389 28.5492 8.11827C29.1327 8.33352 29.73 8.71114 29.656 9.12539C29.593 9.47801 29.0943 9.99989 28.2235 9.99989C27.3194 9.99989 26.4524 9.63889 25.9044 9.03414C25.3249 8.39464 24.3367 8.34601 23.6974 8.92552C23.0579 9.50502 23.0093 10.4931 23.5888 11.1325C24.7362 12.3986 26.4254 13.1248 28.2235 13.1248C30.4792 13.1248 32.3754 11.6738 32.7324 9.67452C33.0029 8.15789 32.3303 6.18239 29.6304 5.18651Z"
                                        fill="#613393"/>
                                    <path
                                        d="M24.625 62.75H15.875C14.8395 62.75 14 61.9105 14 60.875V28.375C14 27.3395 14.8395 26.5 15.875 26.5H24.625C25.6605 26.5 26.5 27.3395 26.5 28.375V60.875C26.5 61.9105 25.6605 62.75 24.625 62.75Z"
                                        fill="#FF7D47"/>
                                    <path
                                        d="M14 47.125V60.875C14 61.9105 14.8395 62.75 15.875 62.75H24.625C25.6605 62.75 26.5 61.9105 26.5 60.875V47.125H14Z"
                                        fill="#FF405C"/>
                                </g>
                                <defs>
                                    <clipPath id="clip0_5901_81351">
                                        <rect width="64" height="64" fill="white"/>
                                    </clipPath>
                                </defs>
                            </svg>
                            <div class="title-re">
                                <span>{{ __('home.EASY TO FIND STAFFS') }}</span>
                                <p>{{ __("home.Through us, find your staffs more easier") }}!</p>
                            </div>
                        </div>
                        <div class="describe-item d-md-flex">
                            <svg xmlns="http://www.w3.org/2000/svg" class="mr-4" width="64" height="64"
                                 viewBox="0 0 64 64"
                                 fill="none">
                                <g clip-path="url(#clip0_5901_81312)">
                                    <path
                                        d="M52.5858 30.9291L58.7968 26.2173L52.5858 21.4929L56.1512 14.5512L48.5039 13.0142L48.7055 5.20315L41.159 7.13071L37.959 0L32 5.03937L26.0409 0L22.8409 7.13071L15.2945 5.19055L15.496 13.0142L7.84879 14.5512L11.4141 21.4929L5.20312 26.2173L11.4141 30.9291L7.84879 37.8835L15.496 39.4205L15.2945 47.2315L22.8409 45.3039L26.0409 52.4347L32 47.3953L37.959 52.4347L41.159 45.3039L48.7055 47.2315L48.5039 39.4205L56.1512 37.8835L52.5858 30.9291Z"
                                        fill="#FFD15C"/>
                                    <path
                                        d="M22.8409 45.3042L15.2944 47.2318L15.4708 40.1641L13.9842 42.8097L5.83301 57.2349L15.1432 54.6523L17.7259 64.0003L24.3905 52.2208L25.2472 50.6837L22.8409 45.3042Z"
                                        fill="#FF7058"/>
                                    <path
                                        d="M50.0031 42.3429L48.5165 39.6973L48.7055 47.2311L41.159 45.3036L38.8535 50.4311L39.7228 51.9681L46.526 63.9996L49.1086 54.6516L58.4189 57.2343L50.0031 42.3429Z"
                                        fill="#FF7058"/>
                                    <path
                                        d="M25.2471 50.6837L24.3904 52.2208L22.0345 46.9798L13.8203 49.0837L13.9841 42.8097L15.4707 40.1641L15.2943 47.2318L22.8408 45.3042L25.2471 50.6837Z"
                                        fill="#F1543F"/>
                                    <path
                                        d="M50.1795 49.0831L41.9653 46.9792L39.7228 51.9681L38.8535 50.4311L41.159 45.3036L48.7055 47.2311L48.5165 39.6973L50.0031 42.3429L50.1795 49.0831Z"
                                        fill="#F1543F"/>
                                    <path
                                        d="M31.9999 42.9093C41.1914 42.9093 48.6425 35.4356 48.6425 26.2164C48.6425 16.9971 41.1914 9.52344 31.9999 9.52344C22.8085 9.52344 15.3574 16.9971 15.3574 26.2164C15.3574 35.4356 22.8085 42.9093 31.9999 42.9093Z"
                                        fill="#F8B64C"/>
                                    <path
                                        d="M28.0317 34.8101L21.7451 28.5109L24.6554 25.5881L28.0317 28.9771L39.3451 17.6133L42.2554 20.5361L28.0317 34.8101Z"
                                        fill="#F2F2F2"/>
                                </g>
                                <defs>
                                    <clipPath id="clip0_5901_81312">
                                        <rect width="64" height="64" fill="white"/>
                                    </clipPath>
                                </defs>
                            </svg>
                            <div class="title-re">
                                <span>{{ __('home.BETTER MATCHING RATE') }}</span>
                                <p>{{ __('home.Through us, you can hire right person') }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="mt-auto p-2 button-bottom-right">
                        <button class="btn-see-all ">{{ __('home.Visit') }}</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="banner1 m-0">
        <img loading="lazy" src="{{asset('img/icons_logo/Rectangle 23818.png')}}" alt="" style="">
    </div>

    <div class="">
        <div class="background-image_HomeNew" id="find-doctor--homeNew">
            <div class="container pb-5 mt-4">
                <div class="pc-hidden tt-flea">
                    Flea market
                </div>
                <div class="carousel pc-hidden">
                    @foreach($productsFlea as $product)
                        <div class="product-itemFlea">
                            <div class="img-proFlea justify-content-center d-flex">
                                <img loading="lazy" src="{{$product->thumbnail}}" alt="">
                                <a class="button-heart" data-favorite="0">
                                    <i class="bi-heart bi"
                                       data-product-id="${product.id}"
                                       onclick="addProductToWishList(${product.id})"></i>
                                </a>
                            </div>
                            <div class="content-proFlea p-md-3 p-2">
                                <div class="">
                                    <div class="name-productFlea" style="min-height: 55px">
                                        <a class="name-product--fleaMarket max-3-line-content"
                                           href="{{ route('flea.market.product.detail', $product->id) }}"
                                           target="_blank">
                                            @if(locationHelper() == 'vi')
                                                {{ ($product->name ?? __('home.no name') ) }}
                                            @else
                                                {{ ($product->name_en  ?? __('home.no name') ) }}
                                            @endif</a>
                                    </div>
                                    <div class="location-proFlea">
                                        @php
                                            if (locationHelper() == 'vi'){
                                                $addressP = Province::find($product->province_id)->name ?? 'Ha Noi';
                                            } else{
                                                $addressP = Province::find($product->province_id)->name_en ?? 'Ha Noi';
                                            }
                                        @endphp
                                        <svg xmlns="http://www.w3.org/2000/svg" width="21"
                                             height="21" viewBox="0 0 21 21" fill="none">
                                            <g clip-path="url(#clip0_5506_14919)">
                                                <path
                                                    d="M4.66602 12.8382C3.12321 13.5188 2.16602 14.4673 2.16602 15.5163C2.16602 17.5873 5.89698 19.2663 10.4993 19.2663C15.1017 19.2663 18.8327 17.5873 18.8327 15.5163C18.8327 14.4673 17.8755 13.5188 16.3327 12.8382M15.4993 7.59961C15.4993 10.986 11.7493 12.5996 10.4993 15.0996C9.24935 12.5996 5.49935 10.986 5.49935 7.59961C5.49935 4.83819 7.73793 2.59961 10.4993 2.59961C13.2608 2.59961 15.4993 4.83819 15.4993 7.59961ZM11.3327 7.59961C11.3327 8.05985 10.9596 8.43294 10.4993 8.43294C10.0391 8.43294 9.66602 8.05985 9.66602 7.59961C9.66602 7.13937 10.0391 6.76628 10.4993 6.76628C10.9596 6.76628 11.3327 7.13937 11.3327 7.59961Z"
                                                    stroke="white" stroke-width="2"
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"/>
                                            </g>
                                            <defs>
                                                <clipPath id="clip0_5506_14919">
                                                    <rect width="20" height="20" fill="white"
                                                          transform="translate(0.5 0.933594)"/>
                                                </clipPath>
                                            </defs>
                                        </svg> &nbsp; {{$addressP}}
                                    </div>
                                    <div class="prices-proFlea">
                                        {{number_format($product->price, 0, ',', '.') }} {{$product->price_unit ?? 'VND'}}
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex justify-content-end">
                                <div class="SeeDetailFlea">
                                    <a href="{{ route('flea.market.product.detail', $product->id) }}"
                                       target="_blank">{{ __('home.See details') }}</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="tab-content mt-4 header-pc" id="myTabContent">
                    <div class="tab-pane fade show active" id="popularProduct" role="tabpanel"
                         aria-labelledby="popularProduct-tab">
                        <div id="cCarousel">
                            <div style="z-index: 0;" class="arrow" id="prevFlea"><i
                                    class="fa-solid fa-chevron-left"></i></div>
                            <div style="z-index: 0;" class="arrow" id="nextFlea"><i
                                    class="fa-solid fa-chevron-right"></i></div>
                            <div id="carousel-vp">
                                <div id="cCarousel-inner">
                                    @if($productsFlea == '')
                                        <h1 class="d-flex align-items-center justify-content-center mt-4">{{ __('home.null') }}</h1>
                                    @else
                                        @foreach($productsFlea as $product)
                                            @php
                                                $isFavourite = null;
                                                if (Auth::check()){
                                                    $isFavourite = \App\Models\WishList::where('user_id', Auth::user()->id)
                                                                        ->where('product_id', $product->id)
                                                                        ->where('type_product', \App\Enums\TypeProductCart::FLEA_MARKET)
                                                                        ->first();
                                                }

                                                $class = !$isFavourite ? 'bi-heart' : 'bi-heart-fill text-danger';
                                                $isSoldOut = $product->quantity == 0
                                            @endphp
                                            <div class="cCarousel-item {{ $isSoldOut ? 'sold-out-overlay' : '' }}">
                                                <div class="product-item">
                                                    <div
                                                        class="img-pro justify-content-center h-auto d-flex img_product--homeNew">
                                                        <img loading="lazy" src="{{$product->thumbnail}}" alt="">
                                                        <a class="button-heart button-flea-market-heart"
                                                           data-product="{{$product->id}}"
                                                           data-isFavourite="{{ $isFavourite ? 1 : 0 }}">
                                                            <i class="bi {{ $class }}"></i>
                                                        </a>
                                                        <div
                                                            class="{{ $isSoldOut ? 'sold-out-overlay-text' : 'd-none' }} ">
                                                            <h1 class="sold-out">{{__('home.Sold Out')}}</h1>
                                                        </div>
                                                    </div>
                                                    <div class="content-pro p-md-3 p-2">
                                                        <div class="">
                                                            <div class="name-product" style="min-height: 48px">
                                                                <a class="name-product--fleaMarket max-3-line-content"
                                                                   href="{{ route('flea.market.product.detail', $product->id) }}">{{$product->name}}</a>
                                                            </div>
                                                            <div class="location-pro">
                                                                @php
                                                                    if (locationHelper() == 'vi'){
                                                                    $addressP = Province::find($product->province_id)->name ?? 'Ha Noi';
                                                                } else{
                                                                    $addressP = Province::find($product->province_id)->name_en ?? 'Ha Noi';
                                                                }
                                                                @endphp
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="21"
                                                                     height="21" viewBox="0 0 21 21" fill="none">
                                                                    <g clip-path="url(#clip0_5506_14919)">
                                                                        <path
                                                                            d="M4.66602 12.8382C3.12321 13.5188 2.16602 14.4673 2.16602 15.5163C2.16602 17.5873 5.89698 19.2663 10.4993 19.2663C15.1017 19.2663 18.8327 17.5873 18.8327 15.5163C18.8327 14.4673 17.8755 13.5188 16.3327 12.8382M15.4993 7.59961C15.4993 10.986 11.7493 12.5996 10.4993 15.0996C9.24935 12.5996 5.49935 10.986 5.49935 7.59961C5.49935 4.83819 7.73793 2.59961 10.4993 2.59961C13.2608 2.59961 15.4993 4.83819 15.4993 7.59961ZM11.3327 7.59961C11.3327 8.05985 10.9596 8.43294 10.4993 8.43294C10.0391 8.43294 9.66602 8.05985 9.66602 7.59961C9.66602 7.13937 10.0391 6.76628 10.4993 6.76628C10.9596 6.76628 11.3327 7.13937 11.3327 7.59961Z"
                                                                            stroke="white" stroke-width="2"
                                                                            stroke-linecap="round"
                                                                            stroke-linejoin="round"/>
                                                                    </g>
                                                                    <defs>
                                                                        <clipPath id="clip0_5506_14919">
                                                                            <rect width="20" height="20" fill="white"
                                                                                  transform="translate(0.5 0.933594)"/>
                                                                        </clipPath>
                                                                    </defs>
                                                                </svg> &nbsp; {{$addressP}}
                                                            </div>
                                                            <div class="prices-pro">
                                                                {{number_format($product->price, 0, ',', '.') }} {{$product->price_unit ?? 'VND'}}
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="d-flex justify-content-end">
                                                        <div class="SeeDetail">
                                                            <a href="{{ route('flea.market.product.detail', $product->id) }}"
                                                               target="_blank">{{ __('home.See details') }}</a>
                                                        </div>
                                                    </div>


                                                </div>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="banner1 m-0">
        <img loading="lazy" src="{{asset('img/Rectangle 23815.png')}}" alt="">
    </div>
    <div class="bg-homeNew">
        <div class="container pb-5 pt-3">
            <div id="find-doctor--homeNew" class="item-information">
                <div class="title-findProduct--homeNew">
                    <span class="py-3 text-center">{{ __('home.Buy online') }}</span>
                    <p>{{ __("home.Don't struggle finding, we are always ready for you") }}</p>
                </div>
                <div class="d-flex nav-header--homeNew justify-content-center mt-3">
                    <ul class="nav nav-pills nav-fill d-flex justify-content-between">
                        <li class="nav-item">
                            <a class="nav-link active font-14-mobi" id="popularProduct-tab" data-toggle="tab"
                               href="#popularProduct"
                               role="tab" aria-controls="popularProduct"
                               aria-selected="true">{{ __('home.Popular') }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link font-14-mobi" id="recommended-tab" data-toggle="tab" href="#recommended"
                               role="tab" aria-controls="recommended"
                               aria-selected="false">{{ __('home.Recommended') }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link font-14-mobi" id="newProducts-tab" data-toggle="tab" href="#newProducts"
                               role="tab" aria-controls="newProducts"
                               aria-selected="true">{{ __('home.New product') }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link font-14-mobi" id="hotDeal-tab" data-toggle="tab" href="#hotDeal"
                               role="tab" aria-controls="hotDeal"
                               aria-selected="true">{{ __('home.Hot deal') }}
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                     fill="none">
                                    <g clip-path="url(#clip0_5435_17445)">
                                        <path
                                            d="M22.8428 12.5865C22.6738 12.2145 22.6738 11.7865 22.8428 11.4145L23.7378 9.44552C24.0708 8.71252 24.0858 7.86552 23.7778 7.12252C23.4688 6.37852 22.8608 5.78952 22.1068 5.50752L20.0828 4.74752C19.6988 4.60352 19.3968 4.30252 19.2538 3.91852L18.4938 1.89452C18.2118 1.14052 17.6228 0.532519 16.8788 0.223519C16.1378 -0.0844809 15.2888 -0.0694809 14.5558 0.263519L12.5868 1.15852C12.2138 1.32852 11.7858 1.32852 11.4148 1.15852L9.44477 0.263519C8.71277 -0.0704809 7.86377 -0.0854809 7.12177 0.223519C6.37777 0.531519 5.78877 1.14052 5.50677 1.89452L4.74677 3.91852C4.60377 4.30252 4.30177 4.60352 3.91777 4.74752L1.89377 5.50752C1.13977 5.78952 0.53077 6.37852 0.22277 7.12252C-0.0852295 7.86552 -0.0702295 8.71252 0.262771 9.44552L1.15777 11.4145C1.32677 11.7865 1.32677 12.2145 1.15777 12.5865L0.262771 14.5555C-0.0702295 15.2885 -0.0852295 16.1355 0.22277 16.8785C0.53177 17.6225 1.13977 18.2115 1.89377 18.4935L3.91777 19.2535C4.30177 19.3975 4.60377 19.6985 4.74677 20.0825L5.50677 22.1065C5.78877 22.8605 6.37777 23.4685 7.12177 23.7775C7.47677 23.9245 7.85677 23.9985 8.23677 23.9985C8.64977 23.9985 9.06277 23.9115 9.44477 23.7375L11.4138 22.8425C11.7868 22.6725 12.2148 22.6725 12.5858 22.8425L14.5548 23.7375C15.2868 24.0715 16.1358 24.0855 16.8778 23.7775C17.6218 23.4685 18.2108 22.8605 18.4928 22.1065L19.2528 20.0825C19.3968 19.6985 19.6978 19.3965 20.0818 19.2535L22.1058 18.4935C22.8598 18.2115 23.4678 17.6225 23.7768 16.8785C24.0848 16.1355 24.0698 15.2885 23.7368 14.5555L22.8428 12.5865Z"
                                            fill="#F44336"/>
                                        <path
                                            d="M13.414 9.70072C12.537 8.82372 11.109 8.82372 10.232 9.70072C9.35497 10.5777 9.35497 12.0057 10.232 12.8827L11.646 14.2967C12.084 14.7347 12.661 14.9547 13.237 14.9547C13.813 14.9547 14.389 14.7347 14.828 14.2967C15.705 13.4197 15.705 11.9917 14.828 11.1147L13.414 9.70072ZM13.768 13.2357C13.475 13.5287 13 13.5287 12.707 13.2357L11.293 11.8217C11.001 11.5297 11.001 11.0527 11.293 10.7607C11.439 10.6137 11.631 10.5417 11.823 10.5417C12.015 10.5417 12.207 10.6137 12.353 10.7607L13.767 12.1747C14.06 12.4677 14.06 12.9437 13.768 13.2357Z"
                                            fill="#FAFAFA"/>
                                        <path
                                            d="M8.81781 12.1768C8.52481 11.8838 8.04981 11.8838 7.75681 12.1768C7.46381 12.4698 7.46381 12.9448 7.75681 13.2378L8.99381 14.4748L7.93281 15.5368L6.69481 14.2988C6.40181 14.0058 5.92681 14.0058 5.63381 14.2988C5.34081 14.5918 5.34081 15.0668 5.63381 15.3598L9.16981 18.8958C9.31581 19.0418 9.50781 19.1158 9.69981 19.1158C9.89181 19.1158 10.0838 19.0428 10.2298 18.8958C10.5228 18.6028 10.5228 18.1278 10.2298 17.8348L8.99281 16.5978L10.0538 15.5358L11.2908 16.7728C11.4368 16.9188 11.6288 16.9928 11.8208 16.9928C12.0128 16.9928 12.2048 16.9198 12.3508 16.7728C12.6438 16.4798 12.6438 16.0048 12.3508 15.7118L8.81781 12.1768Z"
                                            fill="#FAFAFA"/>
                                        <path
                                            d="M18.3631 9.70152L15.3571 6.69552L15.8871 6.16552C16.1801 5.87252 16.1801 5.39752 15.8871 5.10452C15.5941 4.81152 15.1191 4.81152 14.8261 5.10452L13.7671 6.16452L13.7651 6.16552L13.7641 6.16652L12.7041 7.22752C12.4111 7.52052 12.4111 7.99552 12.7041 8.28852C12.8501 8.43451 13.0431 8.50852 13.2341 8.50852C13.4261 8.50852 13.6181 8.43552 13.7641 8.28852L14.2941 7.75752L17.3001 10.7635C17.4461 10.9095 17.6381 10.9835 17.8301 10.9835C18.0221 10.9835 18.2141 10.9105 18.3601 10.7635C18.6561 10.4695 18.6561 9.99452 18.3631 9.70152Z"
                                            fill="#FAFAFA"/>
                                        <path
                                            d="M13.025 11.436L11.964 12.497L12.706 13.239C12.852 13.385 13.044 13.459 13.236 13.459C13.428 13.459 13.62 13.386 13.766 13.239C14.058 12.947 14.058 12.47 13.766 12.178L13.025 11.436ZM19.834 4.62695L16.561 7.89995L18.364 9.70295C18.657 9.99595 18.657 10.471 18.364 10.764C18.218 10.91 18.026 10.984 17.834 10.984C17.642 10.984 17.45 10.911 17.304 10.764L15.5 8.95995L14.085 10.375L14.827 11.117C15.704 11.994 15.704 13.422 14.827 14.299C14.389 14.737 13.812 14.957 13.236 14.957C12.66 14.957 12.084 14.737 11.645 14.299L10.903 13.557L10.549 13.911L12.352 15.714C12.645 16.007 12.645 16.482 12.352 16.775C12.206 16.921 12.014 16.995 11.822 16.995C11.63 16.995 11.438 16.922 11.292 16.775L10.055 15.538L8.994 16.6L10.231 17.837C10.524 18.13 10.524 18.605 10.231 18.898C10.085 19.044 9.893 19.118 9.701 19.118C9.509 19.118 9.317 19.045 9.171 18.898L7.368 17.095L4.625 19.838C4.673 19.916 4.714 19.999 4.746 20.086L5.506 22.11C5.788 22.864 6.377 23.472 7.121 23.781C7.476 23.928 7.856 24.002 8.236 24.002C8.649 24.002 9.062 23.915 9.444 23.741L11.413 22.846C11.6 22.761 11.8 22.719 12 22.719C12.2 22.719 12.4 22.761 12.585 22.846L14.554 23.741C14.935 23.915 15.349 24.002 15.762 24.002C16.142 24.002 16.522 23.928 16.878 23.781C17.622 23.472 18.211 22.864 18.493 22.11L19.253 20.086C19.397 19.702 19.698 19.4 20.082 19.257L22.106 18.497C22.86 18.215 23.468 17.626 23.777 16.882C24.085 16.139 24.07 15.292 23.737 14.559L22.842 12.59C22.673 12.218 22.673 11.79 22.842 11.418L23.737 9.44895C24.07 8.71595 24.085 7.86895 23.777 7.12595C23.468 6.38195 22.86 5.79295 22.106 5.51095L20.082 4.75095C19.995 4.71495 19.912 4.67495 19.834 4.62695Z"
                                            fill="#D43A2F"/>
                                        <path
                                            d="M14.0863 10.373L13.0253 11.434L13.7673 12.176C14.0593 12.468 14.0593 12.944 13.7673 13.237C13.6203 13.383 13.4293 13.457 13.2373 13.457C13.0453 13.457 12.8533 13.384 12.7073 13.237L11.9653 12.495L10.9043 13.556L11.6463 14.298C12.0843 14.736 12.6613 14.956 13.2373 14.956C13.8133 14.956 14.3893 14.736 14.8283 14.298C15.7053 13.421 15.7053 11.993 14.8283 11.116L14.0863 10.373Z"
                                            fill="#DADADA"/>
                                        <path
                                            d="M10.5511 13.9082L7.36914 17.0902L9.17214 18.8932C9.31814 19.0392 9.51014 19.1132 9.70214 19.1132C9.89414 19.1132 10.0861 19.0402 10.2321 18.8932C10.5251 18.6002 10.5251 18.1252 10.2321 17.8322L8.99514 16.5952L10.0561 15.5332L11.2931 16.7702C11.4391 16.9162 11.6311 16.9902 11.8231 16.9902C12.0151 16.9902 12.2071 16.9172 12.3531 16.7702C12.6461 16.4772 12.6461 16.0022 12.3531 15.7092L10.5511 13.9082Z"
                                            fill="#DADADA"/>
                                        <path
                                            d="M16.561 7.89844L15.5 8.95844L17.303 10.7614C17.449 10.9074 17.641 10.9814 17.833 10.9814C18.025 10.9814 18.217 10.9084 18.363 10.7614C18.656 10.4684 18.656 9.99344 18.363 9.70044L16.561 7.89844Z"
                                            fill="#DADADA"/>
                                    </g>
                                    <defs>
                                        <clipPath id="clip0_5435_17445">
                                            <rect width="24" height="24" fill="white"/>
                                        </clipPath>
                                    </defs>
                                </svg>
                            </a>
                        </li>

                    </ul>
                </div>
                <div class="tab-content mt-4" id="myTabContent">
                    <div class="tab-pane fade show active" id="popularProduct" role="tabpanel"
                         aria-labelledby="popularProduct-tab">
                        <div class="row">
                            @if($products == '')
                                <h1 class="d-flex align-items-center justify-content-center mt-4">{{ __('home.null') }}</h1>
                            @else
                                @foreach($products as $product)
                                    @php
                                        $isFavourite = null;
                                        if (Auth::check()){
                                            $isFavourite = \App\Models\WishList::where('user_id', Auth::user()->id)
                                                                ->where('product_id', $product->id)
                                                                ->where('type_product', \App\Enums\TypeProductCart::MEDICINE)
                                                                ->first();
                                        }

                                        $class = !$isFavourite ? 'bi-heart' : 'bi-heart-fill text-danger';
                                                $isSoldOut = $product->quantity == 0;
                                    @endphp
                                    <div class="col-md-3 col-6">
                                        <div class="">
                                            <div class="product-item {{ $isSoldOut ? 'sold-out-overlay' : '' }}">
                                                <div
                                                    class="img-pro justify-content-center d-flex img_product--homeNew">
                                                    <img loading="lazy" src="{{$product->thumbnail}}" alt="">
                                                    <a class="button-heart button-product-heart"
                                                       data-product="{{$product->id}}"
                                                       data-isFavourite="{{ $isFavourite ? 1 : 0 }}">
                                                        <i class="bi {{ $class }}"></i>
                                                    </a>
                                                    <div class="{{ $isSoldOut ? 'sold-out-overlay-text' : 'd-none' }} ">
                                                        <h1 class="sold-out">{{__('home.Sold Out')}}</h1>
                                                    </div>
                                                </div>
                                                <div class="content-pro p-md-3 p-2">
                                                    <div class="">
                                                        <div class="name-product" style="height: auto">
                                                            <a class="name-product--fleaMarket max-3-line-content"
                                                               href="{{ route('medicine.detail', $product->id) }}">{{$product->name}}</a>
                                                        </div>
                                                        <div class="location-pro">
                                                            @php
                                                                if (locationHelper() == 'vi'){
                                                                    $addressP = Province::find($product->province_id)->name ?? 'Ha Noi';
                                                                } else{
                                                                    $addressP = Province::find($product->province_id)->name_en ?? 'Ha Noi';
                                                                }
                                                            @endphp
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="21"
                                                                 height="21" viewBox="0 0 21 21" fill="none">
                                                                <g clip-path="url(#clip0_5506_14919)">
                                                                    <path
                                                                        d="M4.66602 12.8382C3.12321 13.5188 2.16602 14.4673 2.16602 15.5163C2.16602 17.5873 5.89698 19.2663 10.4993 19.2663C15.1017 19.2663 18.8327 17.5873 18.8327 15.5163C18.8327 14.4673 17.8755 13.5188 16.3327 12.8382M15.4993 7.59961C15.4993 10.986 11.7493 12.5996 10.4993 15.0996C9.24935 12.5996 5.49935 10.986 5.49935 7.59961C5.49935 4.83819 7.73793 2.59961 10.4993 2.59961C13.2608 2.59961 15.4993 4.83819 15.4993 7.59961ZM11.3327 7.59961C11.3327 8.05985 10.9596 8.43294 10.4993 8.43294C10.0391 8.43294 9.66602 8.05985 9.66602 7.59961C9.66602 7.13937 10.0391 6.76628 10.4993 6.76628C10.9596 6.76628 11.3327 7.13937 11.3327 7.59961Z"
                                                                        stroke="white" stroke-width="2"
                                                                        stroke-linecap="round"
                                                                        stroke-linejoin="round"/>
                                                                </g>
                                                                <defs>
                                                                    <clipPath id="clip0_5506_14919">
                                                                        <rect width="20" height="20" fill="white"
                                                                              transform="translate(0.5 0.933594)"/>
                                                                    </clipPath>
                                                                </defs>
                                                            </svg> &nbsp; {{$addressP}}
                                                        </div>
                                                        <div class="prices-pro">
                                                            {{number_format($product->price, 0, ',', '.') }} {{$product->price_unit ?? 'VND'}}
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="d-flex justify-content-end">
                                                    <div class="SeeDetail">
                                                        <a href="{{ route('flea.market.product.detail', $product->id) }}"
                                                           target="_blank">{{ __('home.See details') }}</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                        <div class="pagination mt-4 d-flex align-items-center justify-content-center">
                            {{ $products->links() }}
                        </div>
                    </div>
                    <div class="tab-pane fade" id="recommended" role="tabpanel" aria-labelledby="recommended-tab">
                        <div class="row">
                            @if($products == '')
                                <h1 class="d-flex align-items-center justify-content-center mt-4">{{ __('home.null') }}</h1>
                            @else
                                @foreach($products as $product)
                                    @php
                                        $isFavourite = null;
                                        if (Auth::check()){
                                            $isFavourite = \App\Models\WishList::where('user_id', Auth::user()->id)
                                                                ->where('product_id', $product->id)
                                                                ->where('type_product', \App\Enums\TypeProductCart::MEDICINE)
                                                                ->first();
                                        }

                                        $class = !$isFavourite ? 'bi-heart' : 'bi-heart-fill text-danger';
                                    @endphp
                                    <div class="col-md-3 col-6">
                                        <div class="">
                                            <div class="product-item">
                                                <div
                                                    class="img-pro justify-content-center d-flex img_product--homeNew">
                                                    <img loading="lazy" src="{{$product->thumbnail}}" alt="">
                                                    <a class="button-heart button-product-heart"
                                                       data-product="{{$product->id}}"
                                                       data-isFavourite="{{ $isFavourite ? 1 : 0 }}">
                                                        <i class="bi {{ $class }}"></i>
                                                    </a>
                                                </div>
                                                <div class="content-pro p-md-3 p-2">
                                                    <div class="">
                                                        <div class="name-product" style="height: auto">
                                                            <a class="name-product--fleaMarket max-3-line-content"
                                                               href="{{ route('examination.doctor_info', $product->id) }}">{{$product->name}}</a>
                                                        </div>
                                                        <div class="location-pro">
                                                            @php
                                                                if (locationHelper() == 'vi'){
                                                                    $addressP = Province::find($product->province_id)->name ?? 'Ha Noi';
                                                                } else{
                                                                    $addressP = Province::find($product->province_id)->name_en ?? 'Ha Noi';
                                                                }
                                                            @endphp
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="21"
                                                                 height="21" viewBox="0 0 21 21" fill="none">
                                                                <g clip-path="url(#clip0_5506_14919)">
                                                                    <path
                                                                        d="M4.66602 12.8382C3.12321 13.5188 2.16602 14.4673 2.16602 15.5163C2.16602 17.5873 5.89698 19.2663 10.4993 19.2663C15.1017 19.2663 18.8327 17.5873 18.8327 15.5163C18.8327 14.4673 17.8755 13.5188 16.3327 12.8382M15.4993 7.59961C15.4993 10.986 11.7493 12.5996 10.4993 15.0996C9.24935 12.5996 5.49935 10.986 5.49935 7.59961C5.49935 4.83819 7.73793 2.59961 10.4993 2.59961C13.2608 2.59961 15.4993 4.83819 15.4993 7.59961ZM11.3327 7.59961C11.3327 8.05985 10.9596 8.43294 10.4993 8.43294C10.0391 8.43294 9.66602 8.05985 9.66602 7.59961C9.66602 7.13937 10.0391 6.76628 10.4993 6.76628C10.9596 6.76628 11.3327 7.13937 11.3327 7.59961Z"
                                                                        stroke="white" stroke-width="2"
                                                                        stroke-linecap="round"
                                                                        stroke-linejoin="round"/>
                                                                </g>
                                                                <defs>
                                                                    <clipPath id="clip0_5506_14919">
                                                                        <rect width="20" height="20" fill="white"
                                                                              transform="translate(0.5 0.933594)"/>
                                                                    </clipPath>
                                                                </defs>
                                                            </svg> &nbsp; {{$addressP}}
                                                        </div>
                                                        <div class="prices-pro">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="21"
                                                                 height="21" viewBox="0 0 21 21" fill="none">
                                                                <g clip-path="url(#clip0_5506_14923)">
                                                                    <path
                                                                        d="M10.4993 5.93294V10.9329L13.8327 12.5996M18.8327 10.9329C18.8327 15.5353 15.1017 19.2663 10.4993 19.2663C5.89698 19.2663 2.16602 15.5353 2.16602 10.9329C2.16602 6.33057 5.89698 2.59961 10.4993 2.59961C15.1017 2.59961 18.8327 6.33057 18.8327 10.9329Z"
                                                                        stroke="white" stroke-width="2"
                                                                        stroke-linecap="round"
                                                                        stroke-linejoin="round"/>
                                                                </g>
                                                                <defs>
                                                                    <clipPath id="clip0_5506_14923">
                                                                        <rect width="20" height="20" fill="white"
                                                                              transform="translate(0.5 0.933594)"/>
                                                                    </clipPath>
                                                                </defs>
                                                            </svg>
                                                            &nbsp;{{number_format($product->price, 0, ',', '.') }} {{$product->price_unit ?? 'VND'}}
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="d-flex justify-content-end">
                                                    <div class="SeeDetail">
                                                        <a href="{{ route('flea.market.product.detail', $product->id) }}"
                                                           target="_blank">{{ __('home.See details') }}</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                        <div class="pagination mt-4 d-flex align-items-center justify-content-center">
                            {{ $products->links() }}
                        </div>
                    </div>
                    <div class="tab-pane fade" id="newProducts" role="tabpanel" aria-labelledby="newProducts-tab">
                        <div class="row">
                            @if($products == '')
                                <h1 class="d-flex align-items-center justify-content-center mt-4">{{ __('home.null') }}</h1>
                            @else
                                @foreach($products as $product)
                                    @php
                                        $isFavourite = null;
                                        if (Auth::check()){
                                            $isFavourite = \App\Models\WishList::where('user_id', Auth::user()->id)
                                                                ->where('product_id', $product->id)
                                                                ->where('type_product', \App\Enums\TypeProductCart::MEDICINE)
                                                                ->first();
                                        }

                                        $class = !$isFavourite ? 'bi-heart' : 'bi-heart-fill text-danger';
                                    @endphp
                                    <div class="col-md-3 col-6">
                                        <div class="">
                                            <div class="product-item">
                                                <div
                                                    class="img-pro justify-content-center d-flex img_product--homeNew">
                                                    <img loading="lazy" src="{{$product->thumbnail}}" alt="">
                                                    <a class="button-heart button-product-heart"
                                                       data-product="{{$product->id}}"
                                                       data-isFavourite="{{ $isFavourite ? 1 : 0 }}">
                                                        <i class="bi {{ $class }}"></i>
                                                    </a>
                                                </div>
                                                <div class="content-pro p-md-3 p-2">
                                                    <div class="">
                                                        <div class="name-product" style="height: auto">
                                                            <a class="name-product--fleaMarket max-3-line-content"
                                                               href="{{ route('examination.doctor_info', $product->id) }}">{{$product->name}}</a>
                                                        </div>
                                                        <div class="location-pro">
                                                            @php
                                                                if (locationHelper() == 'vi'){
                                                                    $addressP = Province::find($product->province_id)->name ?? 'Ha Noi';
                                                                } else{
                                                                    $addressP = Province::find($product->province_id)->name_en ?? 'Ha Noi';
                                                                }
                                                            @endphp
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="21"
                                                                 height="21" viewBox="0 0 21 21" fill="none">
                                                                <g clip-path="url(#clip0_5506_14919)">
                                                                    <path
                                                                        d="M4.66602 12.8382C3.12321 13.5188 2.16602 14.4673 2.16602 15.5163C2.16602 17.5873 5.89698 19.2663 10.4993 19.2663C15.1017 19.2663 18.8327 17.5873 18.8327 15.5163C18.8327 14.4673 17.8755 13.5188 16.3327 12.8382M15.4993 7.59961C15.4993 10.986 11.7493 12.5996 10.4993 15.0996C9.24935 12.5996 5.49935 10.986 5.49935 7.59961C5.49935 4.83819 7.73793 2.59961 10.4993 2.59961C13.2608 2.59961 15.4993 4.83819 15.4993 7.59961ZM11.3327 7.59961C11.3327 8.05985 10.9596 8.43294 10.4993 8.43294C10.0391 8.43294 9.66602 8.05985 9.66602 7.59961C9.66602 7.13937 10.0391 6.76628 10.4993 6.76628C10.9596 6.76628 11.3327 7.13937 11.3327 7.59961Z"
                                                                        stroke="white" stroke-width="2"
                                                                        stroke-linecap="round"
                                                                        stroke-linejoin="round"/>
                                                                </g>
                                                                <defs>
                                                                    <clipPath id="clip0_5506_14919">
                                                                        <rect width="20" height="20" fill="white"
                                                                              transform="translate(0.5 0.933594)"/>
                                                                    </clipPath>
                                                                </defs>
                                                            </svg> &nbsp; {{$addressP}}
                                                        </div>
                                                        <div class="prices-pro">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="21"
                                                                 height="21" viewBox="0 0 21 21" fill="none">
                                                                <g clip-path="url(#clip0_5506_14923)">
                                                                    <path
                                                                        d="M10.4993 5.93294V10.9329L13.8327 12.5996M18.8327 10.9329C18.8327 15.5353 15.1017 19.2663 10.4993 19.2663C5.89698 19.2663 2.16602 15.5353 2.16602 10.9329C2.16602 6.33057 5.89698 2.59961 10.4993 2.59961C15.1017 2.59961 18.8327 6.33057 18.8327 10.9329Z"
                                                                        stroke="white" stroke-width="2"
                                                                        stroke-linecap="round"
                                                                        stroke-linejoin="round"/>
                                                                </g>
                                                                <defs>
                                                                    <clipPath id="clip0_5506_14923">
                                                                        <rect width="20" height="20" fill="white"
                                                                              transform="translate(0.5 0.933594)"/>
                                                                    </clipPath>
                                                                </defs>
                                                            </svg>
                                                            &nbsp;{{number_format($product->price, 0, ',', '.') }} {{$product->price_unit ?? 'VND'}}
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="d-flex justify-content-end">
                                                    <div class="SeeDetail">
                                                        <a href="{{ route('flea.market.product.detail', $product->id) }}"
                                                           target="_blank">{{ __('home.See details') }}</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                        <div class="pagination mt-4 d-flex align-items-center justify-content-center">
                            {{ $products->links() }}
                        </div>
                    </div>
                    <div class="tab-pane fade" id="hotDeal" role="tabpanel" aria-labelledby="hotDeal-tab">
                        <div class="row">
                            @if($products == '')
                                <h1 class="d-flex align-items-center justify-content-center mt-4">{{ __('home.null') }}</h1>
                            @else
                                @foreach($products as $product)
                                    @php
                                        $isFavourite = null;
                                        if (Auth::check()){
                                            $isFavourite = \App\Models\WishList::where('user_id', Auth::user()->id)
                                                                ->where('product_id', $product->id)
                                                                ->where('type_product', \App\Enums\TypeProductCart::MEDICINE)
                                                                ->first();
                                        }

                                        $class = !$isFavourite ? 'bi-heart' : 'bi-heart-fill text-danger';
                                    @endphp
                                    <div class="col-md-3 col-6">
                                        <div class="">
                                            <div class="product-item">
                                                <div
                                                    class="img-pro justify-content-center d-flex img_product--homeNew">
                                                    <img loading="lazy" src="{{$product->thumbnail}}" alt="">
                                                    <a class="button-heart button-product-heart"
                                                       data-product="{{$product->id}}"
                                                       data-isFavourite="{{ $isFavourite ? 1 : 0 }}">
                                                        <i class="bi {{ $class }}"></i>
                                                    </a>
                                                </div>
                                                <div class="content-pro p-md-3 p-2">
                                                    <div class="">
                                                        <div class="name-product" style="height: auto">
                                                            <a class="name-product--fleaMarket max-3-line-content"
                                                               href="{{ route('examination.doctor_info', $product->id) }}">{{$product->name}}</a>
                                                        </div>
                                                        <div class="location-pro">
                                                            @php
                                                                if (locationHelper() == 'vi'){
                                                                    $addressP = Province::find($product->province_id)->name ?? 'Ha Noi';
                                                                } else{
                                                                    $addressP = Province::find($product->province_id)->name_en ?? 'Ha Noi';
                                                                }
                                                            @endphp
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="21"
                                                                 height="21" viewBox="0 0 21 21" fill="none">
                                                                <g clip-path="url(#clip0_5506_14919)">
                                                                    <path
                                                                        d="M4.66602 12.8382C3.12321 13.5188 2.16602 14.4673 2.16602 15.5163C2.16602 17.5873 5.89698 19.2663 10.4993 19.2663C15.1017 19.2663 18.8327 17.5873 18.8327 15.5163C18.8327 14.4673 17.8755 13.5188 16.3327 12.8382M15.4993 7.59961C15.4993 10.986 11.7493 12.5996 10.4993 15.0996C9.24935 12.5996 5.49935 10.986 5.49935 7.59961C5.49935 4.83819 7.73793 2.59961 10.4993 2.59961C13.2608 2.59961 15.4993 4.83819 15.4993 7.59961ZM11.3327 7.59961C11.3327 8.05985 10.9596 8.43294 10.4993 8.43294C10.0391 8.43294 9.66602 8.05985 9.66602 7.59961C9.66602 7.13937 10.0391 6.76628 10.4993 6.76628C10.9596 6.76628 11.3327 7.13937 11.3327 7.59961Z"
                                                                        stroke="white" stroke-width="2"
                                                                        stroke-linecap="round"
                                                                        stroke-linejoin="round"/>
                                                                </g>
                                                                <defs>
                                                                    <clipPath id="clip0_5506_14919">
                                                                        <rect width="20" height="20" fill="white"
                                                                              transform="translate(0.5 0.933594)"/>
                                                                    </clipPath>
                                                                </defs>
                                                            </svg> &nbsp; {{$addressP}}
                                                        </div>
                                                        <div class="prices-pro">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="21"
                                                                 height="21" viewBox="0 0 21 21" fill="none">
                                                                <g clip-path="url(#clip0_5506_14923)">
                                                                    <path
                                                                        d="M10.4993 5.93294V10.9329L13.8327 12.5996M18.8327 10.9329C18.8327 15.5353 15.1017 19.2663 10.4993 19.2663C5.89698 19.2663 2.16602 15.5353 2.16602 10.9329C2.16602 6.33057 5.89698 2.59961 10.4993 2.59961C15.1017 2.59961 18.8327 6.33057 18.8327 10.9329Z"
                                                                        stroke="white" stroke-width="2"
                                                                        stroke-linecap="round"
                                                                        stroke-linejoin="round"/>
                                                                </g>
                                                                <defs>
                                                                    <clipPath id="clip0_5506_14923">
                                                                        <rect width="20" height="20" fill="white"
                                                                              transform="translate(0.5 0.933594)"/>
                                                                    </clipPath>
                                                                </defs>
                                                            </svg>
                                                            &nbsp; {{number_format($product->price, 0, ',', '.') }} {{$product->price_unit ?? 'VND'}}
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="d-flex justify-content-end">
                                                    <div class="SeeDetail">
                                                        <a href="{{ route('flea.market.product.detail', $product->id) }}"
                                                           target="_blank">{{ __('home.See details') }}</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                        <div class="pagination mt-4 d-flex align-items-center justify-content-center">
                            {{ $products->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @php
        $addresses = \App\Models\Clinic::all();
        $coordinatesArray = $addresses->toArray();
    @endphp

    <script>

        $('.carousel').slick({
            dots: true,
            slidesPerRow: 2,
            rows: 2,
            responsive: [
                {
                    breakpoint: 480,
                    settings: {
                        slidesPerRow: 2,
                        rows: 2,
                    }
                }
            ]
        });

        let currentSlide = 0;
        const slides = document.querySelectorAll(".slide")
        const dots = document.querySelectorAll('.dot')

        const init = (n) => {
            slides.forEach((slide, index) => {
                slide.style.display = "none"
                dots.forEach((dot, index) => {
                    dot.classList.remove("active")
                })
            })
            slides[n].style.display = "block"
            dots[n].classList.add("active")
        }
        document.addEventListener("DOMContentLoaded", init(currentSlide))
        const next = () => {
            currentSlide >= slides.length - 1 ? currentSlide = 0 : currentSlide++
            init(currentSlide)
        }

        const prev = () => {
            currentSlide <= 0 ? currentSlide = slides.length - 1 : currentSlide--
            init(currentSlide)
        }

        document.querySelector("#next").addEventListener('click', next)

        document.querySelector("#prev").addEventListener('click', prev)


        setInterval(() => {
            next()
        }, 5000);

        dots.forEach((dot, i) => {
            dot.addEventListener("click", () => {
                console.log(currentSlide)
                init(i)
                currentSlide = i
            })
        })

    </script>
    <script>
        let accessToken = `Bearer ` + token;
        let headers = {
            "Authorization": accessToken
        };

        $(document).ready(function () {
            $('.button-doctor-heart').click(function () {
                let element = $(this);
                let doctorID = element.data('doctor')
                doctorWishList(doctorID, element);
            })

            $('.button-product-heart').click(function () {
                let element = $(this);
                let productID = element.data('product')
                productWishList(productID, `{{ \App\Enums\TypeProductCart::MEDICINE }}`, element)
            })

            $('.button-flea-market-heart').click(function () {
                let element = $(this);
                let productID = element.data('product')
                productWishList(productID, `{{ \App\Enums\TypeProductCart::FLEA_MARKET }}`, element)
            })
        })

        async function productWishList(productID, type, element) {
            loadingMasterPage();

            if (!type) {
                type = `{{ \App\Enums\TypeProductCart::MEDICINE }}`;
            }

            let productWishListUrl = `{{ route('api.backend.wish.lists.medical.update')  }}`;

            let data = {
                'user_id': `{{ Auth::check() ? Auth::user()->id : '' }}`,
                'product_id': productID,
                'product_type': type,
                '_token': `{{ csrf_token() }}`
            };

            let heart = `bi-heart-fill text-danger`;
            let unHeart = `bi-heart`;

            await $.ajax({
                url: productWishListUrl,
                method: 'POST',
                headers: headers,
                data: data,
                success: function (response) {
                    loadingMasterPage();
                    isFavourite = response.isFavourite
                    if (isFavourite === true) {
                        element.find('i').removeClass(unHeart)
                        element.find('i').addClass(heart)
                    } else {
                        element.find('i').removeClass(heart)
                        element.find('i').addClass(unHeart)
                    }
                    alert(response.message);
                },
                error: function (error) {
                    loadingMasterPage();
                    alert('Create error!');
                }
            });
        }

        async function doctorWishList(doctorID, element) {
            loadingMasterPage();

            let doctorWishListUrl = `{{ route('api.backend.medical.favourites.update.wishlist')  }}`;

            let data = {
                'user_id': `{{ Auth::check() ? Auth::user()->id : '' }}`,
                'medical_id': doctorID
            };

            let heart = `bi-heart-fill text-danger`;
            let unHeart = `bi-heart`;

            await $.ajax({
                url: doctorWishListUrl,
                method: 'POST',
                headers: headers,
                data: data,
                success: function (response) {
                    isFavourite = response.isFavourite
                    if (isFavourite === true) {
                        element.find('i').removeClass(unHeart)
                        element.find('i').addClass(heart)
                    } else {
                        element.find('i').removeClass(heart)
                        element.find('i').addClass(unHeart)
                    }
                    loadingMasterPage();
                    alert(response.message);
                },
                error: function (error) {
                    loadingMasterPage();
                    alert('Create error!');
                }
            });
        }
    </script>
    <script>
        function viewCoupon(id) {
            window.location.href = "/coupon/" + id;
        }
    </script>
    <script>
        var locations = {!! json_encode($coordinatesArray) !!};
        var infoWindows = [];

        function getCurrentLocation(callback) {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function (position) {
                    var currentLocation = {
                        lat: position.coords.latitude,
                        lng: position.coords.longitude
                    };
                    callback(currentLocation);
                });
            } else {
                alert('Geolocation is not supported by this browser.');
            }
        }

        function calculateDistance(lat1, lng1, lat2, lng2) {
            var R = 6371; // Độ dài trung bình của trái đất trong km
            var dLat = toRadians(lat2 - lat1);
            var dLng = toRadians(lng2 - lng1);

            var a = Math.sin(dLat / 2) * Math.sin(dLat / 2) +
                Math.cos(toRadians(lat1)) * Math.cos(toRadians(lat2)) *
                Math.sin(dLng / 2) * Math.sin(dLng / 2);

            var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));

            var distance = R * c;
            return distance;
        }

        function toRadians(degrees) {
            return degrees * (Math.PI / 180);
        }

        function formatTime(dateTimeString) {
            const date = new Date(dateTimeString);
            const hours = date.getHours().toString().padStart(2, '0');
            const minutes = date.getMinutes().toString().padStart(2, '0');
            return `${hours}:${minutes}`;
        }

        function initMap(currentLocation, locations) {
            var map = new google.maps.Map(document.getElementById('allAddressesMap'), {
                center: currentLocation,
                zoom: 10
            });

            var currentLocationMarker = new google.maps.Marker({
                position: currentLocation,
                map: map,
                title: 'Your Location'
            });

            locations.forEach(function (location) {
                var distance = calculateDistance(
                    currentLocation.lat, currentLocation.lng,
                    parseFloat(location.latitude), parseFloat(location.longitude)
                );

                // Chọn bán kính tìm kiếm (ví dụ: 5 km)
                var searchRadius = 10;

                if (distance <= searchRadius) {
                    var marker = new google.maps.Marker({
                        position: {lat: parseFloat(location.latitude), lng: parseFloat(location.longitude)},
                        map: map,
                        title: 'Location'
                    });
                    var urlDetail = "{{ route('clinic.detail', ['id' => ':id']) }}".replace(':id', location.id);
                    let img = '';
                    let gallery = location.gallery;
                    let arrayGallery = gallery.split(',');


                    var infoWindowContent = `<div class="p-0 m-0 tab-pane fade show active background-modal b-radius" id="modalBooking">
                <div>

                    <img loading="lazy" class="b-radius" src="${arrayGallery[0]}" alt="img">
                </div>
                <div class="p-md-3 p-2">
                    <div class="form-group">
                        <div class="d-flex justify-content-between mt-md-2">
                            <div class="fs-18px">${location.name}</div>
                            <div class="button-follow fs-12p ">
                                <a class="text-follow-12" href="">{{ __('home.FOLLOW') }}</a>
                            </div>
                        </div>
                        <div class="d-flex mt-md-2">
                            <div class="d-flex col-md-6 justify-content-center align-items-center">
                                <a class="row p-2" href="">
                                    <div class="justify-content-center d-flex">
                                        <i class="border-button-address fa-solid fa-bullseye"></i>
                                    </div>
                                    <div class="d-flex justify-content-center">{{ __('home.Start') }}</div>
                                </a>
                            </div>
                            <div class="d-flex col-md-6 justify-content-center align-items-center">
                                <a class="row p-2" href="">
                                    <div class="justify-content-center d-flex">
                                        <i class="border-button-address fa-regular fa-circle-right"></i>
                                    </div>
                                    <div class="d-flex justify-content-center">{{ __('home.Direction') }}</div>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="mt-md-3 mb-md-3">
                    <a class="w-100 btn btn-secondary border-button-address font-weight-800 fs-14 justify-content-center" href="${urlDetail}" >
                    {{ __('home.Booking') }}
                    </a>
                    </div>
                    <div class="border-top">
                        <div class="mt-md-2 mt-1"><i class="text-gray mr-md-2 fa-solid fa-location-dot"></i>
                            <span class="fs-14 font-weight-600">${location.address_detail}</span>
                        </div>
                        <div class="mt-md-2 mt-1">
                            <i class="text-gray mr-md-2 fa-regular fa-clock"></i>
                            <span class="fs-14 font-weight-600">
                                Open: ${formatTime(location.open_date)} - ${formatTime(location.close_date)}
                            </span>
                        </div>
                        <div class="mt-md-2 mt-1">
                            <i class="text-gray mr-md-2 fa-solid fa-globe"></i>
                            <span class="fs-14 font-weight-600"> ${location.email}</span>
                        </div>
                        <div class="mt-md-2 mt-1">
                            <i class="text-gray mr-md-2 fa-solid fa-phone-volume"></i> <span
                                class="fs-14 font-weight-600"> ${location.phone}</span>
                        </div>
                        <div class="mt-md-2 mt-1 mb-md-2">
                            <i class="text-gray mr-md-2 fa-solid fa-bookmark"></i> <span
                                class="fs-14 font-weight-600"> ${location.type}</span>
                        </div>
                        @for($i=0; $i<3; $i++)
                    <div class="border-top mb-md-2">
                        <div
                            class="d-flex justify-content-between rv-header align-items-center mt-md-2 mt-1">
                            <div class="d-flex rv-header--left">
                                <div class="avt-24 mr-md-2">
                                    <img loading="lazy" src="{{asset('img/detail_doctor/ellipse _14.png')}}">
                                        </div>
                                        <p class="fs-16px">Trần Đình Phi</p>
                                    </div>
                                    <div class="rv-header--right">
                                        <p class="fs-14 font-weight-400">10:20 07/04/2023</p>
                                    </div>
                                </div>
                                <div class="content">
                                    <p>
                                        {{ __('home.Lần đầu tiên sử dụng dịch vụ qua app nhưng chất lượng và dịch vụ tại salon quá tốt. Book giờ nào thì cứ đúng giờ đến k sợ phải chờ đợi như mọi chỗ khác. Hy vọng thi thoảng app có nhiều ưu đãi để giới thiệu cho bạn bè cùng sử dụng') }}
                    </p>
                </div>
            </div>
@endfor
                    <div class="border-top">
                        <div
                            class="d-flex justify-content-between rv-header align-items-center mt-md-2 mt-1">
                            <div class="d-flex rv-header--left">
                                <div class="avt-24 mr-md-2">
                                    <img loading="lazy" src="{{asset('img/detail_doctor/ellipse _14.png')}}">
                                    </div>
                                    <p class="fs-16px">Trần Đình Phi</p>
                                </div>
                                <div class="rv-header--right">
                                    <p class="fs-14 font-weight-400">10:20 07/04/2023</p>
                                </div>
                            </div>
                            <div class="content">
                                <p>
                                    {{ __('home.Lần đầu tiên sử dụng dịch vụ qua app nhưng chất lượng và dịch vụ tại salon quá tốt. Book giờ nào thì cứ đúng giờ đến k sợ phải chờ đợi như mọi chỗ khác. Hy vọng thi thoảng app có nhiều ưu đãi để giới thiệu cho bạn bè cùng sử dụng') }}
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>`;

                    var infoWindow = new google.maps.InfoWindow({
                        content: infoWindowContent
                    });

                    marker.addListener('click', function () {
                        closeAllInfoWindows();
                        infoWindow.open(map, marker);
                    });

                    infoWindows.push(infoWindow);
                }
            });
        }

        function closeAllInfoWindows() {
            infoWindows.forEach(function (infoWindow) {
                infoWindow.close();
            });
        }

        getCurrentLocation(function (currentLocation) {
            initMap(currentLocation, locations);
        });
    </script>
    <script>
        const prevFlea = document.getElementById("prevFlea");
        const nextFlea = document.getElementById("nextFlea");

        let carouselVp = document.getElementById("carousel-vp");

        let cCarouselInner = document.getElementById("cCarousel-inner");
        let carouselInnerWidth = cCarouselInner.getBoundingClientRect().width;

        let leftValue = 0;

        // Variable used to set the carousel movement value (card's width + gap)
        const totalMovementSize =
            parseFloat(
                document.querySelector(".cCarousel-item").getBoundingClientRect().width,
                10
            ) +
            parseFloat(
                window.getComputedStyle(cCarouselInner).getPropertyValue("gap"),
                10
            );

        prevFlea.addEventListener("click", () => {
            if (leftValue !== 0) {
                leftValue -= -totalMovementSize;
                cCarouselInner.style.left = leftValue + "px";
            }
        });

        nextFlea.addEventListener("click", () => {
            const carouselVpWidth = carouselVp.getBoundingClientRect().width;
            if (carouselInnerWidth - Math.abs(leftValue) > carouselVpWidth) {
                leftValue -= totalMovementSize;
                cCarouselInner.style.left = leftValue + "px";
            }
        });

        const mediaQuery510 = window.matchMedia("(max-width: 510px)");
        const mediaQuery770 = window.matchMedia("(max-width: 770px)");

        mediaQuery510.addEventListener("change", mediaManagement);
        mediaQuery770.addEventListener("change", mediaManagement);

        let oldViewportWidth = window.innerWidth;

        function mediaManagement() {
            const newViewportWidth = window.innerWidth;

            if (leftValue <= -totalMovementSize && oldViewportWidth < newViewportWidth) {
                leftValue += totalMovementSize;
                cCarouselInner.style.left = leftValue + "px";
                oldViewportWidth = newViewportWidth;
            } else if (
                leftValue <= -totalMovementSize &&
                oldViewportWidth > newViewportWidth
            ) {
                leftValue -= totalMovementSize;
                cCarouselInner.style.left = leftValue + "px";
                oldViewportWidth = newViewportWidth;
            }
        }

    </script>
@endsection
