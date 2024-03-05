@extends('layouts.master')
@section('title', 'Home')
@section('content')

    @include('layouts.partials.header_2')
    @include('component.banner')
    <div class="container">
        <div class="d-flex">
            <div id="filter" class="d-flex justify-content-around ">
                <div class="d-flex flex-fill">
                    <div class="filter_option"><p>{{ __('home.Category') }}</p></div>
                    <div class="filter_option"><p>{{ __('home.Position') }}</p></div>
                </div>
                <div class="filter_search flex-fill">
                    <label for="filter_search"><i class="bi bi-search"></i></label>
                    <input type="text" name="filter_search" id="filter_search" placeholder="{{ __('home.Search for anything...') }}">
                </div>
                <div class="d-flex flex-fill">
                    <div class="filter_option"><p>{{ __('home.Location') }}</p></div>
                    <div class="filter_option"><p>{{ __('home.Experience') }}</p></div>
                </div>
                <div class="flex-fill"><button><i class="bi bi-filter"></i></button></div>
            </div>
        </div>
        <div class="recruitment_rank d-flex flex-column container">
            <div id="recruitment_ctn" class="flex-column">
                <div id="rank" class="d-flex">
                    <div class="col-10 rank_title p-0">
                        <img loading="lazy" src="{{asset('img/platinum_rank.png')}}" width="398px" height="60px">
                        <h2>PLATINUM</h2>
                    </div>
                    <div class="col-1 ms-auto p-2"><a href="">{{ __('home.See all') }}</a></div>

                </div>
                <div id="ctn" class="d-flex">
                    <div class="card">
                        <div id="crd_ctn">
                            <div id="card-image">
                                <i class="bi bi-heart"></i>
                                <img loading="lazy" src="{{asset('img/recruitment/Rectangle 23798.png')}}" class="card-img-top" alt="...">
                            </div>
                            <div class="card-body">
                                <div id="time">
                                <i class="bi bi-clock"></i>
                                    <div class="time-txt">9/18/2023</div>
                                </div>
                                <a href="{{route('recruitment_detail')}}"><h6>{{ __('home.Bên mình đang cần tuyển dụng 2 BS chuyên khoa VLTL hoặc YHCT') }}</h6></a>
                                <p>{{ __('home.Bên mình đang cần tuyển dụng 2 BS chuyên khoa VLTL hoặc YHCTĐịa điểm làm việc: 77 Hoàng Hoa Thám, Phường 13, Quận Tân Bình, TPHCM') }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div id="crd_ctn">
                            <div id="card-image">
                                <i class="bi bi-heart"></i>
                                <img loading="lazy" src="{{asset('img/recruitment/Rectangle 23798.png')}}" class="card-img-top" alt="...">
                            </div>
                            <div class="card-body">
                                <div id="time">
                                <i class="bi bi-clock"></i>
                                    <div class="time-txt">9/18/2023</div>
                                </div>
                                <a href="{{route('recruitment_detail')}}"><h6>{{ __('home.Bên mình đang cần tuyển dụng 2 BS chuyên khoa VLTL hoặc YHCT') }}</h6></a>
                                <p>{{ __('home.Bên mình đang cần tuyển dụng 2 BS chuyên khoa VLTL hoặc YHCTĐịa điểm làm việc: 77 Hoàng Hoa Thám, Phường 13, Quận Tân Bình, TPHCM') }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div id="crd_ctn">
                            <div id="card-image">
                                <i class="bi bi-heart"></i>
                                <img loading="lazy" src="{{asset('img/recruitment/Rectangle 23798.png')}}" class="card-img-top" alt="...">
                            </div>
                            <div class="card-body">
                                <div id="time">
                                <i class="bi bi-clock"></i>
                                    <div class="time-txt">9/18/2023</div>
                                </div>
                                <a href="{{route('recruitment_detail')}}"><h6>{{ __('home.Bên mình đang cần tuyển dụng 2 BS chuyên khoa VLTL hoặc YHCT') }}</h6></a>
                                <p>{{ __('home.Bên mình đang cần tuyển dụng 2 BS chuyên khoa VLTL hoặc YHCTĐịa điểm làm việc: 77 Hoàng Hoa Thám, Phường 13, Quận Tân Bình, TPHCM') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="recruitment_ctn" class="flex-column">
                <div id="rank" class="d-flex">
                    <div class="col-10 rank_title p-0">
                        <img loading="lazy" src="{{asset('img/premium_rank.png')}}" width="398px" height="60px">
                        <h2>PREMIUM</h2>
                    </div>
                    <div class="col-1 ms-auto p-2"><a href="{{route('recruitment_detail')}}">{{ __('home.See all') }}</a></div>
                </div>
                <div id="ctn" class="d-flex">
                    <div class="card">
                        <div id="crd_ctn">
                            <div id="card-image">
                                <i class="bi bi-heart"></i>
                                <img loading="lazy" src="{{asset('img/recruitment/Rectangle 23798.png')}}" class="card-img-top" alt="...">
                            </div>
                            <div class="card-body">
                                <div id="time">
                                <i class="bi bi-clock"></i>
                                    <div class="time-txt">9/18/2023</div>
                                </div>
                                <a href="{{route('recruitment_detail')}}"><h6>{{ __('home.Bên mình đang cần tuyển dụng 2 BS chuyên khoa VLTL hoặc YHCT') }}</h6></a>
                                <p>{{ __('home.Bên mình đang cần tuyển dụng 2 BS chuyên khoa VLTL hoặc YHCTĐịa điểm làm việc: 77 Hoàng Hoa Thám, Phường 13, Quận Tân Bình, TPHCM') }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div id="crd_ctn">
                            <div id="card-image">
                                <i class="bi bi-heart"></i>
                                <img loading="lazy" src="{{asset('img/recruitment/Rectangle 23798.png')}}" class="card-img-top" alt="...">
                            </div>
                            <div class="card-body">
                                <div id="time">
                                <i class="bi bi-clock"></i>
                                    <div class="time-txt">9/18/2023</div>
                                </div>
                                <a href="{{route('recruitment_detail')}}"><h6>{{ __('home.Bên mình đang cần tuyển dụng 2 BS chuyên khoa VLTL hoặc YHCT') }}</h6></a>
                                <p>{{ __('home.Bên mình đang cần tuyển dụng 2 BS chuyên khoa VLTL hoặc YHCTĐịa điểm làm việc: 77 Hoàng Hoa Thám, Phường 13, Quận Tân Bình, TPHCM') }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div id="crd_ctn">
                            <div id="card-image">
                                <i class="bi bi-heart"></i>
                                <img loading="lazy" src="{{asset('img/recruitment/Rectangle 23798.png')}}" class="card-img-top" alt="...">
                            </div>
                            <div class="card-body">
                                <div id="time">
                                <i class="bi bi-clock"></i>
                                    <div class="time-txt">9/18/2023</div>
                                </div>
                                <a href="{{route('recruitment_detail')}}"><h6>{{ __('home.Bên mình đang cần tuyển dụng 2 BS chuyên khoa VLTL hoặc YHCT') }}</h6></a>
                                <p>{{ __('home.Bên mình đang cần tuyển dụng 2 BS chuyên khoa VLTL hoặc YHCTĐịa điểm làm việc: 77 Hoàng Hoa Thám, Phường 13, Quận Tân Bình, TPHCM') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="recruitment_ctn" class="flex-column">
                <div id="rank" class="d-flex">
                    <div class="col-10 rank_title p-0">
                        <img loading="lazy" src="{{asset('img/silver_rank.png')}}" width="398px" height="60px">
                        <h2>{{ __('home.Silver') }}</h2>
                    </div>
                    <div class="col-1 ms-auto p-2"><a href="{{route('recruitment_detail')}}">{{ __('home.See all') }}</a></div>

                </div>
                <div id="ctn" class="d-flex">
                    <div class="card">
                        <div id="crd_ctn">
                            <div id="card-image">
                                <i class="bi bi-heart"></i>
                                <img loading="lazy" src="{{asset('img/recruitment/Rectangle 23798.png')}}" class="card-img-top" alt="...">
                            </div>
                            <div class="card-body">
                                <div id="time">
                                <i class="bi bi-clock"></i>
                                    <div class="time-txt">9/18/2023</div>
                                </div>
                                <a href="{{route('recruitment_detail')}}"><h6>{{ __('home.Bên mình đang cần tuyển dụng 2 BS chuyên khoa VLTL hoặc YHCT') }}</h6></a>
                                <p>{{ __('home.Bên mình đang cần tuyển dụng 2 BS chuyên khoa VLTL hoặc YHCTĐịa điểm làm việc: 77 Hoàng Hoa Thám, Phường 13, Quận Tân Bình, TPHCM') }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div id="crd_ctn">
                            <div id="card-image">
                                <i class="bi bi-heart"></i>
                                <img loading="lazy" src="{{asset('img/recruitment/Rectangle 23798.png')}}" class="card-img-top" alt="...">
                            </div>
                            <div class="card-body">
                                <div id="time">
                                <i class="bi bi-clock"></i>
                                    <div class="time-txt">9/18/2023</div>
                                </div>
                                <a href="{{route('recruitment_detail')}}"><h6>{{ __('home.Bên mình đang cần tuyển dụng 2 BS chuyên khoa VLTL hoặc YHCT') }}</h6></a>
                                <p>{{ __('home.Bên mình đang cần tuyển dụng 2 BS chuyên khoa VLTL hoặc YHCTĐịa điểm làm việc: 77 Hoàng Hoa Thám, Phường 13, Quận Tân Bình, TPHCM') }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div id="crd_ctn">
                            <div id="card-image">
                                <i class="bi bi-heart"></i>
                                <img loading="lazy" src="{{asset('img/recruitment/Rectangle 23798.png')}}" class="card-img-top" alt="...">
                            </div>
                            <div class="card-body">
                                <div id="time">
                                <i class="bi bi-clock"></i>
                                    <div class="time-txt">9/18/2023</div>
                                </div>
                                <a href="{{route('recruitment_detail')}}"><h6>{{ __('home.Bên mình đang cần tuyển dụng 2 BS chuyên khoa VLTL hoặc YHCT') }}</h6></a>
                                <p>{{ __('home.Bên mình đang cần tuyển dụng 2 BS chuyên khoa VLTL hoặc YHCTĐịa điểm làm việc: 77 Hoàng Hoa Thám, Phường 13, Quận Tân Bình, TPHCM') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
