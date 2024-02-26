<header class="header">
    <div class="container">
        <div class="row header-detail">
            <div class="col-md-4 header-detail--left d-flex justify-content-around">
                <a class="logo" href="{{ route('home') }}">
                    <img src="{{asset('img/icons_logo/logo-new.png')}}" alt="Logo" width="177px" height="42px"
                         class="d-inline-block align-text-top">
                </a>
                <a class="back" href="#"><h5><i class="fa-solid fa-angles-left"></i>{{ __('home.Recruitment') }} </h5></a>
            </div>
            <div class="col-md-5 header-detail--center d-flex justify-content-sm-around">
                <a class="active" href="#">{{ __('home.My job') }}</a>
                <a href="{{route('recruitment.apply')}}">{{ __('home.My CV') }}</a>
                <a href="#">{{ __('home.Match Up') }}</a>
            </div>
            <div class="col-md-4 header-detail--right d-flex">
                <div class="option">
                    <a href="#">{{ __('home.Business service') }}</a>
                </div>
                <div class="option">
                    <a href="#">{{ __('home.Register recruitment') }}</a>
                </div>
                <div class="user">
                    <img src="{{asset('img/user-circle.png')}}">
                </div>
            </div>
        </div>
    </div>
</header>
