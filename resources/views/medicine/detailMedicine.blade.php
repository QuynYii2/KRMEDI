@php use App\Enums\TypeProductCart;use App\Http\Controllers\MainController;use App\Models\online_medicine\CategoryProduct;use App\Models\User;use Illuminate\Support\Facades\Auth; @endphp
@php @endphp
@php @endphp
@php @endphp
@php @endphp
@extends('layouts.master')
@section('title', 'Online Medicine')
@section('content')
    @php
        $isAdmin = (new MainController())->checkAdmin();
        $isBusiness = (new MainController())->checkBusiness();
        $isMedical = (new MainController())->checkMedical();
    @endphp
    <style>
        .selected {
            border: 0 solid black;
            opacity: 0.5;
        }
    </style>
    @include('layouts.partials.header')
    @include('component.banner')
    <div class="recruitment-details ">
        <div class="container">
            <div class="row medicine-search">
                <div class="col-md-10"></div>
                <div class="medicine-search--center col-md-2">
                    @if(Auth::check())
                        <button type="button" data-toggle="modal" data-target="#modalCart"
                                class="shopping-bag float-right">
                            <i class="fa-solid fa-bag-shopping"></i>
                            @if($carts && count($carts) > 0)
                                <div class="text-wrapper"> {{ count($carts) }}</div>
                            @endif
                        </button>
                        @include('component.modal-cart')
                    @endif

                </div>
            </div>

            <a href="{{route('medicine')}}" class="recruitment-details--title"><i class="fa-solid fa-arrow-left"></i>
                {{ __('home.Product details') }}</a>
            <div class="row recruitment-details--content">
                <div class="col-md-8 recruitment-details ">
                    @if(!empty($medicine->thumbnail))
                        <div
                            class="d-flex justify-content-center border-radius-1px color-Grey-Dark col-10 col-md-12 p-0">
                            <img src="{{asset($medicine->thumbnail)}}" alt="show"
                                 class="main col-10 col-md-12 p-0">
                        </div>
                    @else
                        <img style="width: 100%" src="{{asset('img/flea-market/photo.png')}}" alt="show"
                             class="main col-10 col-md-12">
                        <p>{{ __('home.No Thumbnail Available') }}</p>
                    @endif
                    @php
                        $gallery = $medicine->gallery;
                        $arrayGallery = explode(',', $gallery);
                    @endphp
                    <div class="list col-2 col-md-12 mt-md-3">
                        @foreach($arrayGallery as $pr_gallery)
                            <div
                                class="item-detail d-flex justify-content-center  border-radius-1px color-Grey-Dark mr-md-3">
                                <img src="{{asset($pr_gallery)}}"
                                     alt=""
                                     class="border mw-140px gallery-detail">
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="col-md-4 recruitment-details--content--right">
                    <div class="product-details">
                        <div class="body">
                            <p class="text-wrapper">
                                @if(locationHelper() == 'vi')
                                    {{ ($medicine->name ?? __('home.no name') ) }}
                                @else
                                    {{ ($medicine->name_en  ?? __('home.no name') ) }}
                                @endif
                            </p>
                            <div
                                class="price">{{number_format($medicine->price, 0, ',', '.') }} {{$medicine->price_unit ?? 'VND'}}</div>
                            @php
                                $user = User::find($medicine->user_id);
                                $clinic = \App\Models\Clinic::where('user_id', $user->id)->first();
                                $address = explode(',', $clinic->address);
                                $addressC = null;
                                $addressD = null;
                                $addressP = null;

                                if ($address[count($address) - 1] != ""){
                                $addressC = \App\Models\Commune::where('id', $address[count($address) - 1])->first()->name;
                                }
                                if ($address[count($address) - 2] != ""){
                                $addressD = \App\Models\District::where('id', $address[count($address) - 2])->first()->name;
                                }
                                if ($address[count($address) - 3] != ""){
                                $addressP = \App\Models\Province::where('id', $address[count($address) - 3])->first()->name;
                                }
                                if ($addressC != null && $addressD != null && $addressP != null){
                                $addressAll =$clinic->address_detail . ' , ' . $addressC . ', ' . $addressD . ', ' . $addressP;
                                }
                            @endphp
                            <div class="brand-name d-flex">
                                <div class="text-wrapper-2">{{ __('home.Name Pharmacy') }} :&nbsp;<b
                                        class="text-wrapper-3 text-black">{{ $clinic->name ?? ''}}</b></div>
                            </div>
                            <div class="brand-name d-flex">
                                <div class="text-wrapper-2">{{ __('home.Location') }}:&nbsp;<b
                                        class="text-wrapper-3 text-black">{{ $addressAll ?? 'Toàn quốc' }}</b></div>
                            </div>
                            <div class="brand-name d-flex">
                                <div class="text-wrapper-2">{{ __('home.Category') }}:</div>
                                @php
                                    $category = CategoryProduct::find($medicine->category_id)
                                @endphp
                                <div class="text-wrapper-3">{{ $category->name ?? ''}}</div>
                            </div>
                            <div class="brand-name d-flex">
                                <div class="text-wrapper-2">{{ __('home.Brand name') }}:</div>
                                <div class="text-wrapper-3">
                                    @if(locationHelper() == 'vi')
                                        {{ ($medicine->brand_name ?? __('home.no name') ) }}
                                    @else
                                        {{ ($medicine->brand_name_en  ?? __('home.no name') ) }}
                                    @endif
                                </div>
                            </div>
                            <div class="brand-name mt-2 mb-2">
                                <label class="text-wrapper-2" for="quantity">{{ __('home.Số lượng') }}: </label>
                                <input type="number" min="1" value="1" id="quantity" class="w-25 input-quantity p-2">
                            </div>
                        </div>
                        <input type="text" value="{{ $medicine->id }}" id="productID" class="d-none">
                        <input type="text" value="{{ TypeProductCart::MEDICINE }}" id="type_product"
                               class="d-none">
                        @php
                            $prMedicine = \Illuminate\Support\Facades\DB::table('product_medicines')->where('id', $medicine->id)->first();
                        @endphp
                        <div class="row">
                            <div class="col-6  d-flex align-center justify-center">
                                @if(Auth::user() == null || Auth::user()->id != $prMedicine->user_id)
                                    <a href="{{route('flea.market.product.shop.info',$prMedicine->user_id)}}"
                                       class="button-visitStore btn btn-secondary w-100 d-flex align-center justify-center">
                                        {{ __('home.Visit store') }}
                                    </a>
                                @else
                                    <a href="{{route('flea.market.my.store')}}"
                                       class="button-visitStore btn btn-secondary w-100 d-flex align-center justify-center">
                                        {{ __('home.My store') }}
                                    </a>
                                @endif
                            </div>
                            <div class="col-6">
                                @if(Auth::check())
                                    <button id="btnBuyNow" {{ $prMedicine->quantity == 0 ? 'disabled' : '' }}
                                    class=" button-buyNow btn btn-primary w-100">{{ __('home.Buy now') }}</button>
                                @else
                                    <button onclick="alertLogin();"
                                            class=" button-buyNow btn btn-primary w-100">{{ __('home.Buy now') }}</button>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="recruitment-details--text--line"></div>
            <div class="recruitment-details--text">
                @if(locationHelper() == 'vi')
                    {!! $medicine->description !!}
                @else
                    {!! $medicine->description_en !!}
                @endif
            </div>
        </div>
    </div>
    @if(Auth::check())
        <input type="text" id="accessToken" class="d-none" value="{{ $_COOKIE['accessToken'] }}">
        <input type="text" id="userID" class="d-none" value="{{ Auth::user()->id }}">
    @endif

    <script>
        $(document).ready(function () {
            $('.list img').click(function () {
                $(".main").attr("src", $(this).attr('src'));
            })

            $('#btnBuyNow').on('click', function () {
                const headers = {
                    'Authorization': `Bearer ${token}`
                };
                let userID = document.getElementById('userID').value;

                let productID = $('#productID').val();
                let typeProduct = '{{ TypeProductCart::MEDICINE }}';
                let quantity = $('#quantity').val();

                let data = {
                    user_id: userID,
                    product_id: productID,
                    type_product: typeProduct,
                    quantity: quantity,
                };

                try {
                    $.ajax({
                        url: `{{route('api.backend.cart.create')}}`,
                        method: 'POST',
                        headers: headers,
                        data: data,
                        success: function (response) {
                            alert('Success!');
                            window.location.reload();
                        },
                        error: function (exception) {
                        }
                    });
                } catch (error) {
                    throw error;
                }

            })
        })
    </script>
    <script>
        $('.list img').click(function () {
            $(".main").attr("src", $(this).attr('src'));
        })
    </script>
    <script>
        $('.list .item-detail img').click(function () {
            $('.list .item-detail img').removeClass('selected');
            $(this).removeClass('border');
            $(this).addClass('selected');
            $(".main").attr("src", $(this).attr('src'));
        })
    </script>
@endsection
