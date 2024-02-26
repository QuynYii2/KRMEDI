@extends('layouts.master')
@section('title', 'Recruitment Details')
@section('content')
    @include('layouts.partials.header_2')
    @include('component.banner')
    <div class="recruitment-details ">
        <div class="container">
            <a href="{{route('recruitment.index')}}" class="recruitment-details--title"><i class="fa-solid fa-arrow-left"></i> {{ __('home.Recruitment details') }}</a>
            <div class="row recruitment-details--content">
                <div class="col-md-8 recruitment-details--content--left">
                    <div class="img-main">
                        <img loading="lazy" src="{{asset('/img/recruitment/Rectangle 23798.png')}}" alt="show" class="main">
                    </div>
                    <div class="list d-flex">
                        <div class="item">
                            <img loading="lazy" src="{{asset('/img/recruitment/Rectangle 23798.png')}}" alt="">
                        </div>
                        <div class="item">
                            <img loading="lazy" src="{{asset('/img/favicon.png')}}" alt="">
                        </div>
                        <div class="item">
                            <img loading="lazy" src="{{asset('/img/recruitment/Rectangle 23798.png')}}" alt="">
                        </div>
                        <div class="item">
                            <img loading="lazy" src="{{asset('/img/favicon.png')}}" alt="">
                        </div>
                        <div class="item">
                            <img loading="lazy" src="{{asset('/img/recruitment/Rectangle 23798.png')}}" alt="">
                        </div>
                        <div class="item">
                            <img loading="lazy" src="{{asset('/img/favicon.png')}}" alt="">
                        </div>
                        <div class="item">
                            <img loading="lazy" src="{{asset('/img/recruitment/Rectangle 23798.png')}}" alt="">
                        </div>
                        <div class="item">
                            <img loading="lazy" src="{{asset('/img/favicon.png')}}" alt="">
                        </div>
                    </div>
                </div>
                <div class="col-md-4 recruitment-details--content--right">
                    <div class="form-1" id="form-hospital">
                        <div class="div d-flex justify-content-between align-items-center">
                            <div class="title">{{ __('home.Platinum') }}</div>
                            <button class="text-wrapper">{{ __('home.FOLLOW') }}</button>
                        </div>
                        <div class="div-2">
                            <img loading="lazy" class="image" src="{{asset('img/recruitment/logo.png')}}"/>
                            <div class="text-wrapper-2">{{ __('home.Bệnh viện bạch mai') }}</div>
                        </div>
                        <div class="div-3">
                            <div class="div-4">
                                <div class="img-wrapper"><img loading="lazy" class="img"
                                                              src="{{asset('img/recruitment/Vector.png')}}"/></div>
                                <div class="div-5">
                                    <div class="text-wrapper-3">{{ __('home.Position') }}</div>
                                    <div class="text-wrapper-4">{{ __('home.Nhân viên') }}</div>
                                </div>
                            </div>
                            <div class="div-4">
                                <div class="img-wrapper"><img loading="lazy" class="img"
                                                              src="{{asset('img/recruitment/hourglass-03.png')}}"/>
                                </div>
                                <div class="div-5">
                                    <div class="text-wrapper-3">{{ __('home.From of employment') }}</div>
                                    <div class="text-wrapper-4">1 {{ __('home.year') }}</div>
                                </div>
                            </div>
                            <div class="div-4">
                                <div class="img-wrapper"><img loading="lazy" class="img"
                                                              src="{{asset('img/recruitment/briefcase.png')}}"/></div>
                                <div class="div-5">
                                    <div class="text-wrapper-3">{{ __('home.Experience') }}</div>
                                    <div class="text-wrapper-4">{{ __('home.Full time') }}</div>
                                </div>
                            </div>
                            <div class="div-4">
                                <div class="img-wrapper"><img loading="lazy" class="img" src="{{asset('img/recruitment/Icon.png')}}"/>
                                </div>
                                <div class="div-5">
                                    <div class="text-wrapper-3">{{ __('home.Salary') }}</div>
                                    <div class="text-wrapper-4">{{ __('home.7 - 12 million') }}</div>
                                </div>
                            </div>
                            <div class="div-4">
                                <div class="img-wrapper"><img loading="lazy" class="img" src="{{asset('img/recruitment/clock.png')}}"/>
                                </div>
                                <div class="div-5">
                                    <div class="text-wrapper-3">{{ __('home.Deadline') }}</div>
                                    <div class="text-wrapper-4">30/10/2023</div>
                                </div>
                            </div>
                        </div>
                        <div class="div-7 d-flex justify-content-between">
                            <button class="div-wrapper">{{ __('home.Company page') }}</button>
                            <button id="button-apply" class="text-wrapper-5">{{ __('home.Apply') }}</button>
                        </div>
                    </div>
                    <div class="form-2 d-none" id="form-apply">
                        <div class="div">
                            <div class="text-wrapper">{{ __('home.Select CV') }}</div>
                            <div class="div-2 d-flex">
                                <div class="div-wrapper">
                                    <div class="text-wrapper-2">CV 1</div>
                                </div>
                                <div class="div-wrapper">
                                    <div class="text-wrapper-2">CV 2</div>
                                </div>
                                <div class="div-wrapper">
                                    <i class="fa-solid fa-plus"></i>
                                </div>
                            </div>
                        </div>
                        <div class="div-3">
                            <div class="text-wrapper">{{ __('home.Applicant information') }}</div>
                            <div class="div-4">
                                <div class="div-5">
                                    <div class="text-wrapper-3">{{ __('home.Name') }}</div>
                                    <input class="frame-wrapper" type="text" placeholder="example123">
                                </div>
                                <div class="div-5">
                                    <div class="text-wrapper-3">{{ __('home.Email') }}</div>
                                    <input class="frame-wrapper" type="text" placeholder="example123">
                                </div>
                                <div class="div-5">
                                    <div class="text-wrapper-3">{{ __('home.Conact number') }}</div>
                                    <input class="frame-wrapper" type="text" placeholder="example123">
                                </div>
                            </div>
                        </div>
                        <div class="div-7 d-flex justify-content-between">
                            <button class="div-wrapper" id="button-back">{{ __('home.CANCEL') }}</button>
                            <button  class="text-wrapper-5" data-toggle="modal" data-target=".bd-example-modal-lg">{{ __('home.Apply') }}</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row recruitment-details--text">
                <div class="col-md-8">
                    <hr>

                    {{-- Start nội dung mô tả (backend)--}}
                    <div class="frame">
                        <b style="font-size: 20px" class="text-wrapper">{{ __('home.Bên mình đang cần tuyển dụng 2 BS chuyên khoa VLTL hoặc YHCT') }}</b>
                        <div class="div">
                            <div class="div-2">
                                <b style="font-size: 16px" class="text-wrapper-2">{{ __('home.Job Description') }}</b>
                                <p class="th-c-hi-n-c-c-k-thu">
                                    {{ __('home.Bên mình đang cần tuyển dụng 2 BS chuyên khoa VLTL hoặc YHCTĐịa điểm làm việc: 77 Hoàng Hoa Thám, Phường 13, Quận Tân Bình, TPHCM') }}
                                </p>
                            </div>
                            <div class="div-3">
                                <b style="font-size: 16px" class="text-wrapper-2">{{ __('home.Job Description') }}</b>
                                <p class="c-nh-n-x-t-nghi-m-c">
                                    {{ __('home.Bên mình đang cần tuyển dụng 2 BS chuyên khoa VLTL hoặc YHCTĐịa điểm làm việc: 77 Hoàng Hoa Thám, Phường 13, Quận Tân Bình, TPHCM') }}
                                </p>
                            </div>
                            <div class="div-3">
                                <b style="font-size: 16px" class="text-wrapper-2">{{ __('home.Job Description') }}</b>
                                <p class="c-nh-n-x-t-nghi-m-c">
                                    {{ __('home.Bên mình đang cần tuyển dụng 2 BS chuyên khoa VLTL hoặc YHCTĐịa điểm làm việc: 77 Hoàng Hoa Thám, Phường 13, Quận Tân Bình, TPHCM') }}
                                </p>
                            </div>
                        </div>
                    </div>
                    {{-- End nội dung mô tả--}}

                </div>
            </div>
        </div>
    </div>
    <script>
        $('.list img').click(function () {
            $(".main").attr("src", $(this).attr('src'));
        })
    </script>

    <script>
        $(document).ready(function () {
            $('#button-apply').on('click', function () {
                $('#form-hospital').addClass('d-none')
                $('#form-apply').removeClass('d-none')
            })

            $('#button-back').on('click', function () {
                $('#form-hospital').removeClass('d-none')
                $('#form-apply').addClass('d-none')
            })
        })
    </script>
@endsection
