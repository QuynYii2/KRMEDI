<div class=" row d-flex align-content-center mb-42">
    <div class="col-md-2 d-flex justify-content-center col-2">
        <img class="img-info" src="{{asset('img/flea-market/avatar-phi.png')}}">
    </div>
    <div class="col-md-8 col-10">
        <div class="d-mb-flex">
            <div class="info col-8 pl-0">
                @php
                        if (Auth::user() != null) {
                            $info = $user;
                        } else {
                            $info = \App\Models\User::where('id', $id)->first();
                        }
                        $address = \App\Models\Province::where('id', $info->province_id)->value('name');
                @endphp
                <div class="name font-18-mobi">{{$info->name}} {{$info->last_name}}</div>
                <p class="location-info font-14-mobi">{{ __('home.Location') }}: <strong class="hanoi font-14-mobi">
                        @if(!empty($address))
                            {{$address}}
                        @else
                            {{ __('home.null') }}
                        @endif
                    </strong></p>
            </div>
            <div class="col-4 pc-hidden">
                @if(\Illuminate\Support\Facades\Auth::check())
                    @if( $id != Auth::user()->id)
                        <a href="" class="flea-button mobi-text">
                            {{ __('home.FOLLOW') }}
                        </a>
                    @else
                        <a href="{{route('flea.market.sell.product')}}" class="flea-button mobi-text">
                            {{ __('home.Sell my product') }}
                        </a>
                    @endif
                @else
                    <a onclick="alertLogin();" class="flea-button mobi-text">
                        {{ __('home.FOLLOW') }}
                    </a>
                @endif
            </div>
        </div>
        <div class=" margin-info row mt-2">
            @php
                $count = \App\Models\ProductInfo::where('created_by', $id )->where('status', \App\Enums\ProductStatus::ACTIVE)->count();
            @endphp
            <div class="col-4 col-md-3 p-1 d-flex font-12-mobi">{{ __('home.Product') }}: <span class="font-weight-800">{{$count}}</span></div>
            <div class="col-4 col-md-3 p-1 d-flex font-12-mobi">{{ __('home.Sold') }}: <span class="font-weight-800">1000</span></div>
            <div class="col-4 col-md-3 p-1 d-flex font-12-mobi">{{ __('home.Sold Out') }}: <span class="font-weight-800">10</span></div>
            <div class="col-4 col-md-3 p-1 d-flex font-12-mobi">{{ __('home.Following') }}: <span class="font-weight-800">50</span></div>
        </div>
    </div>
    <div class="col-md-2 mobile-hidden">

        <div class="d-flex">
            @if(\Illuminate\Support\Facades\Auth::check())
                @if( $id != Auth::user()->id)
                    <a href="" class="flea-button">
                        {{ __('home.FOLLOW') }}
                    </a>
                @else
                    <a href="{{route('flea.market.sell.product')}}" class="flea-button">
                        {{ __('home.Sell my product') }}
                    </a>
                @endif
            @else
                <a onclick="alertLogin();" class="flea-button">
                    {{ __('home.FOLLOW') }}
                </a>
            @endif
        </div>
    </div>
</div>

