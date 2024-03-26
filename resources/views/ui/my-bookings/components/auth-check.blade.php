<form method="post" action="{{ route('loginProcess') }}">
    @csrf
    <div class="popup d-lg-flex justify-content-center">
        <div class="form">
            <div class="form-element">
                <label for="email">{{ __('home.Email') }}</label>
                <input id="email" name="email" type="text" placeholder="exmaple@gmail.com">
            </div>
            <div class="form-element">
                <label for="password">{{ __('home.Password') }}</label>
                <input id="password" name="password" type="password" placeholder="********">
            </div>
            <div class="d-none">
                <label for="call_back_url">{{ __('home.Password') }}</label>
                <input id="call_back_url" name="call_back_url" type="text" value="{{ route('web.users.my.bookings.detail', $id) }}">
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
