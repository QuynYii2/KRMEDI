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
        .list-tab-medicine{
            display: flex;
            flex-direction: column;
            li{
                color: black;
                padding: 15px 10px;
                font-size: 16px;
                border-bottom: 1px solid #e4e8ed;
                border-radius: 5px;
            }
            li:hover{
                background: #cccccc;
                font-weight: 700;
            }
            li.active{
                background: #cccccc;
                font-weight: 700;
            }
        }
        .medicine-tab-title{
            font-size: 18px !important;
            font-weight: 800 !important;
            text-decoration: underline;
        }
        .medicineTab{
            max-height: 800px;
            overflow: hidden;
            transition: max-height 0.5s ease;
        }
        .duration-500 {
            animation-duration: .5s;
        }
        .transition-all {
            transition-property: all;
            transition-timing-function: cubic-bezier(.4,0,.2,1);
            transition-duration: .15s;
        }
        .medicine-current-tab{
            padding: 15px;
            border: 1px solid #e4e8ed;
            border-radius: 5px;
            box-shadow: 0 4px 4px 0 rgba(0, 0, 0, 0.25);
        }
    </style>
    @include('layouts.partials.header')
    @include('component.banner')
    <div class="recruitment-details ">
        <div class="container box-detail-sp">
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
                <div class="col-lg-5 col-md-6 recruitment-details ">
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
                <div class="col-lg-7 col-md-6 recruitment-details--content--right">
                    <div class="product-details">
                        <div class="body">
                            <p class="text-wrapper">
                                @if(locationHelper() == 'vi')
                                    {{ ($medicine->name ?? __('home.no name') ) }}
                                @else
                                    {{ ($medicine->name_en  ?? __('home.no name') ) }}
                                @endif
                            </p>
                            @if($medicine->type_product == 0)
                            <div
                                class="price">{{number_format($medicine->price, 0, ',', '.') }} {{$medicine->price_unit ?? 'VND'}}</div>
                            @else
                                <div class="price">Liên hệ</div>
                                @endif
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
                        <div class="row mt-3">
                            <div class="col-lg-6 col-12  d-flex align-center justify-center mb-2">
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
                            <div class="col-lg-6 col-12 mb-2">
                                @if(Auth::check())
                                    @if($medicine->type_product == 0 || $name_role == 'HOSPITALS' || $name_role == 'DOCTORS')
                                    <button id="btnBuyNow" {{ $prMedicine->quantity == 0 ? 'disabled' : '' }}
                                    class=" button-buyNow btn btn-primary w-100">{{ __('home.Add cart') }}</button>
                                        @else
                                        <button {{ $prMedicine->quantity == 0 ? 'disabled' : '' }}
                                        class=" button-buyNow btn btn-primary w-100 contact_doctor" style="padding: 11px 50px" data-mail="{{$user_email}}" data-id="{{$medicine->user_id}}">Liên hệ</button>
                                        @endif
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
                <div class="row">
                    <div class="col-md-3 col-xl-2 mb-2">
                        <ul class="list-tab-medicine">
                            <li><a href="javascript:void(0);" data-target="descriptionTab">Mô tả sản phẩm</a></li>
                            <li><a href="javascript:void(0);" data-target="ingredientTab">Thành phần</a></li>
                            <li><a href="javascript:void(0);" data-target="congdungTab">Công dụng</a></li>
                            <li><a href="javascript:void(0);" data-target="hdsdTab">Hướng dẫn sử dụng</a></li>
                            <li><a href="javascript:void(0);" data-target="sideEffectsTab">Tác dụng phụ</a></li>
                            <li><a href="javascript:void(0);" data-target="noteTab">Lưu ý</a></li>
                            <li><a href="javascript:void(0);" data-target="preserveTab">Bảo quản</a></li>
                        </ul>
                    </div>
                    <div class="col-md-9 col-xl-10">
                        <div class="medicine-current-tab" id="descriptionTab">
                            <h5 class="medicine-tab-title">Mô tả sản phẩm</h5>
                            <div class="medicineTab">
                                @if(locationHelper() == 'vi')
                                    {!! $medicine->description !!}
                                @else
                                    {!! $medicine->description_en !!}
                                @endif
                            </div>
                            <div class="justify-content-center align-items-center mt-3 toggle-expand" style="cursor: pointer">
                                <p class="see-more-medicine transition-all duration-500 text-decoration-underline">Xem thêm</p>
                                <p class="see-less-medicine transition-all duration-500 text-decoration-underline d-none">Thu gọn</p>
                            </div>
                        </div>
                        <div class="medicine-current-tab" id="ingredientTab">
                            <h5 class="medicine-tab-title">Thành phần</h5>
                            <div class="medicineTab">
                                {!! $medicineIngredient !!}
                            </div>
                            <div class="justify-content-center align-items-center mt-3 toggle-expand" style="cursor: pointer">
                                <p class="see-more-medicine transition-all duration-500 text-decoration-underline">Xem thêm</p>
                                <p class="see-less-medicine transition-all duration-500 text-decoration-underline d-none">Thu gọn</p>
                            </div>
                        </div>
                        <div class="medicine-current-tab" id="congdungTab">
                            <h5 class="medicine-tab-title">Công dụng</h5>
                            <div class="medicineTab">
                                {!! $medicine->uses!!}
                            </div>
                            <div class="justify-content-center align-items-center mt-3 toggle-expand" style="cursor: pointer">
                                <p class="see-more-medicine transition-all duration-500 text-decoration-underline">Xem thêm</p>
                                <p class="see-less-medicine transition-all duration-500 text-decoration-underline d-none">Thu gọn</p>
                            </div>
                        </div>
                        <div class="medicine-current-tab" id="hdsdTab">
                            <h5 class="medicine-tab-title">Hướng dẫn sử dụng</h5>
                            <div class="medicineTab">
                                {!! $medicine->user_manual !!}
                            </div>
                            <div class="justify-content-center align-items-center mt-3 toggle-expand" style="cursor: pointer">
                                <p class="see-more-medicine transition-all duration-500 text-decoration-underline">Xem thêm</p>
                                <p class="see-less-medicine transition-all duration-500 text-decoration-underline d-none">Thu gọn</p>
                            </div>
                        </div>
                        <div class="medicine-current-tab" id="sideEffectsTab">
                            <h5 class="medicine-tab-title">Tác dụng phụ</h5>
                            <div class="medicineTab">
                                {!! $medicine->side_effects !!}
                            </div>
                            <div class="justify-content-center align-items-center mt-3 toggle-expand" style="cursor: pointer">
                                <p class="see-more-medicine transition-all duration-500 text-decoration-underline">Xem thêm</p>
                                <p class="see-less-medicine transition-all duration-500 text-decoration-underline d-none">Thu gọn</p>
                            </div>
                        </div>
                        <div class="medicine-current-tab" id="noteTab">
                            <h5 class="medicine-tab-title">Lưu ý</h5>
                            <div class="medicineTab">
                                {!! $medicine->notes!!}
                            </div>
                            <div class="justify-content-center align-items-center mt-3 toggle-expand" style="cursor: pointer">
                                <p class="see-more-medicine transition-all duration-500 text-decoration-underline">Xem thêm</p>
                                <p class="see-less-medicine transition-all duration-500 text-decoration-underline d-none">Thu gọn</p>
                            </div>
                        </div>
                        <div class="medicine-current-tab" id="preserveTab">
                            <h5 class="medicine-tab-title">Bảo quản</h5>
                            <div class="medicineTab">
                                {!! $medicine->preserve!!}
                            </div>
                            <div class="justify-content-center align-items-center mt-3 toggle-expand" style="cursor: pointer">
                                <p class="see-more-medicine transition-all duration-500 text-decoration-underline">Xem thêm</p>
                                <p class="see-less-medicine transition-all duration-500 text-decoration-underline d-none">Thu gọn</p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    @if(Auth::check())
        <input type="text" id="accessToken" class="d-none" value="{{ $_COOKIE['accessToken'] ?? null }}">
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
                            alert('Thêm vào giỏ hàng thành công');
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
        // function checkDoctorOnline(doctor_id) {
        //     let accessToken = `Bearer ` + token;
        //     $.ajax({
        //         url: window.location.origin +'/connect/chat/check-doctor-online/'+doctor_id,
        //         type: 'GET',
        //         headers: {
        //             'Authorization': accessToken
        //         },
        //         contentType: false,
        //         cache: false,
        //         processData: false,
        //         success: function(response) {
        //             if (response.isOnline) {
        //                 handleStartChatWithDoctor(`${doctor_id}`)
        //             } else {
        //                 alert('Bác sĩ hiện không online. Vui lòng liên hệ lại sau.');
        //             }
        //         },
        //         error: function(xhr, status, error) {
        //             alert('Vui lòng đăng nhập để tiếp tục.');
        //         }
        //     });
        // }
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const tabs = document.querySelectorAll(".list-tab-medicine li a");
            const tabContents = document.querySelectorAll(".medicine-current-tab");

            tabs.forEach(tab => {
                tab.addEventListener("click", function () {
                    tabs.forEach(t => t.parentElement.classList.remove("active"));
                    tabContents.forEach(content => content.style.display = "none");

                    tab.parentElement.classList.add("active");
                    const targetTab = document.getElementById(this.getAttribute("data-target"));
                    if (targetTab) {
                        targetTab.style.display = "block";
                    }
                });
            });

            tabs[0].click();

            const medicineTabContainers = document.querySelectorAll(".medicine-current-tab");
            medicineTabContainers.forEach(container => {
                const medicineTab = container.querySelector(".medicineTab");
                const toggleButton = container.querySelector(".toggle-expand");
                const seeMore = toggleButton.querySelector(".see-more-medicine");
                const seeLess = toggleButton.querySelector(".see-less-medicine");

                if (medicineTab.scrollHeight > 800) {
                    toggleButton.style.display = "flex";
                }else{
                    toggleButton.style.display = "none";
                }

                toggleButton.addEventListener("click", function () {
                    if (medicineTab.style.maxHeight === "none") {
                        medicineTab.style.maxHeight = "800px";
                        seeMore.classList.remove("d-none");
                        seeLess.classList.add("d-none");
                    } else {
                        medicineTab.style.maxHeight = "none";
                        seeMore.classList.add("d-none");
                        seeLess.classList.remove("d-none");
                    }
                });
            });
        });

    </script>
    <script src="{{asset('js/send-mess.js')}}" type="module"></script>
@endsection
