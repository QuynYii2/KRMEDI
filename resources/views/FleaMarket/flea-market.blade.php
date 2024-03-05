@php use App\Enums\Role; @endphp
@extends('layouts.master')
@section('title', 'Flea Market')
@section('content')
    <style>
        .bi-heart-fill {
            color: red;
        }

        .product-item .img-pro i {
            padding: 8px;
            border-radius: 36px;
            background: #EAEAEA;
            align-items: center;
            justify-content: center;
            display: flex;
        }

        .ellipse-1-line {
            line-height: 1.3;
            -webkit-line-clamp: 1;
            -webkit-box-orient: vertical;
            overflow: hidden;
            text-overflow: ellipsis;
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
    </style>
    @include('layouts.partials.headerFleaMarket')
    <body>
    @include('component.banner')

    <div class="container mt-70">
        <div class="container pc-hidden">
            <div class="row clinic-search">
                <div
                    class="clinic-search--left col-md-12 d-flex justify-content-between clinic-search--center align-items-center">
                    <div class="clinic-search--left col-md-6 justify-content-around mobile-hidden">
                        <div class="title mobile-hidden">{{ __('home.All') }} <i class="bi bi-arrow-down-up"></i></div>
                        <div class="title mobile-hidden">{{ __('home.Category') }} <i class="bi bi-arrow-down-up"></i>
                        </div>
                        <div class="title mobile-hidden">{{ __('home.Location') }}<i class="bi bi-arrow-down-up"></i>
                        </div>
                    </div>

                    <div class="search-box col-md-5">
                        <input class="m-0" type="Search" onkeyup="performSearch()" name="focus"
                               placeholder="{{ __('home.Search for anything…') }}" id="inputSearchMobile" value="">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </div>
                    <div class="flex-fill">
                        <button class="navbar-toggler border-none css-button" type="button" data-bs-toggle="offcanvas"
                                data-bs-target="#filterNavbar" aria-controls="filterNavbar">
                            <i class="bi bi-filter"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="d-flex mt-70 mobile-hidden">
            <div class="col-md-3 flea-content ">{{ __('home.Flea market') }}</div>
            <div class="col-md-5 flea-search d-flex align-items-center">
                <i class="fa fa-search form-control-search"></i>
                <label for="inputSearch"></label><input onkeyup="performSearch()" id="inputSearch" type="Search"
                                                        placeholder="{{ __('home.Search for anything…') }}" value="">
            </div>

            @if(Auth::check())
                @if(auth()->user()->type!= Role::NORMAL)
                    <div class="d-flex col-md-4 justify-content-between align-items-center">
                        <a href="#" onclick="checkLogin()" class="col-md-4 flea-button">
                            {{ __('home.Sell my product') }}
                        </a>
                        <a href="#" onclick="checkLoginWishStore()" class="col-md-4 flea-button flea-btn">
                            {{ __('home.Go to my store') }}
                        </a>
                        <a href="#" onclick="checkLoginWish()" class="col-md-4 flea-button flea-btn">
                            {{ __('home.Wish list') }}
                        </a>
                    </div>
                @else
                    <div class="d-flex col-md-4 justify-content-start align-items-center">
                        <a href="#" onclick="checkLoginWishStore()" class="col-md-4 flea-button flea-btn mr-3">
                            {{ __('home.Go to my store') }}
                        </a>
                        <a href="#" onclick="checkLoginWish()" class="col-md-4 flea-button flea-btn">
                            {{ __('home.Wish list') }}
                        </a>
                    </div>
                @endif
            @endif

        </div>
        <div class="d-flex mt-88">
            <div class="col-md-3  mobile-hidden">
                <div class="border-radius ">
                    <div class="flea-text">{{ __('home.Filter') }}</div>
                    @foreach($departments as $department)
                        <div class="ellipse-1-line d-flex mb-2">
                            <input type="checkbox" onchange="performSearch()" name="category_{{$department->id}}"
                                   id="category_{{$department->id}}">
                            <label for="category_{{$department->id}}" style="margin-bottom: 0"
                                   class="flea-text-gray text-nowrap ml-2">{{$department->name}}</label>
                        </div>
                    @endforeach
                    <div class="flea-text-sp">{{ __('home.See all categories') }}</div>
                </div>
                <div class="border-radius mt-3 ">
                    <div class="d-flex">
                        <div class="wrapper">
                            <header>
                                <h2>{{ __('home.Price') }}</h2>
                            </header>
                            <div class="price-input">
                                <div class="field">
                                    <input type="number" onchange="performSearch()" id="inputProductMin"
                                           class="rangePrice input-min" value="0">
                                </div>
                                <div class="separator">-</div>
                                <div class="field">
                                    <input type="number" onchange="performSearch()" id="inputProductMax"
                                           class="rangePrice input-max" value="0">
                                </div>
                            </div>
                            <div class="slider">
                                <div class="progress"></div>
                            </div>
                            <div class="range-input">
                                <input type="range" onchange="performSearch()" class="rangePrice range-min" min="0"
                                       max="100000" value="25000" step="1000">
                                <input type="range" onchange="performSearch()" class="rangePrice range-max" min="0"
                                       max="100000" value="75000" step="1000">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mt-100">
                    <div class=" row align-items-center justify-content-center">
                        <div class="">
                            <img loading="lazy" src="{{asset('img/image 16.png')}}" alt="">
                        </div>
                    </div>
                    <div class=" row align-items-center justify-content-center">
                        <div class="">
                            <img loading="lazy" src="{{asset('img/image 16.png')}}" alt="">
                        </div>
                    </div>
                    <div class=" row align-items-center justify-content-center">
                        <div class="">
                            <img loading="lazy" src="{{asset('img/image 16.png')}}" alt="">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-9">
                <div class="img-union"><img loading="lazy" src="{{asset('img/flea-market/platinum.png')}}"></div>
                <div class="page d-flex flex-wrap" id="productsAdsPlan1"></div>
                <div class="img-union "><img loading="lazy" src="{{asset('img/flea-market/premium.png')}}"></div>
                <div class="page d-flex flex-wrap" id="productsAdsPlan2"></div>
                <div class="img-union"><img loading="lazy" src="{{asset('img/flea-market/silver.png')}}"></div>
                <div class="page d-flex flex-wrap" id="productsAdsPlan3"></div>
            </div>
        </div>
        {{-- modal filter --}}
        <div class="offcanvas offcanvas-end" tabindex="-1" id="filterNavbar" aria-labelledby="offcanvasNavbarLabel">
            <div class="offcanvas-header">
                <a href="{{route('home')}}" class="offcanvas-title" id="offcanvasNavbarLabel"><img loading="lazy" class="w-100"
                                                                                                   src="{{asset('img/icons_logo/logo-new.png')}}"></a>
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">
                <div class="border-radius ">
                    <div class="flea-text">{{ __('home.Filter') }}</div>
                    @foreach($departments as $department)
                        <div>
                            <input type="checkbox" onchange="performSearch()" name="category_{{$department->id}}"
                                   id="category_{{$department->id}}">
                            <label for="category_{{$department->id}}"
                                   class="flea-text-gray">{{$department->name}}</label>
                        </div>
                    @endforeach
                    <div class="flea-text-sp">{{ __('home.See all categories') }}</div>
                </div>
                <div class="border-radius mt-3 ">
                    <div class="d-flex">
                        <div class="wrapper">
                            <header>
                                <h2>{{ __('home.Price') }}</h2>
                            </header>
                            <div class="price-input">
                                <div class="field">
                                    <input type="number" onchange="performSearch()" id="inputProductMin"
                                           class="rangePrice input-min" value="0">
                                </div>
                                <div class="separator">-</div>
                                <div class="field">
                                    <input type="number" onchange="performSearch()" id="inputProductMax"
                                           class="rangePrice input-max" value="0">
                                </div>
                            </div>
                            <div class="slider">
                                <div class="progress"></div>
                            </div>
                            <div class="range-input">
                                <input type="range" onchange="performSearch()" class="rangePrice range-min" min="0"
                                       max="100000" value="25000" step="1000">
                                <input type="range" onchange="performSearch()" class="rangePrice range-max" min="0"
                                       max="100000" value="75000" step="1000">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="d-flex justify-content-center">
                    <a href="" class="add-cv-bt w-100 apply-bt_delete col-6">{{ __('home.Refresh') }}</a>
                    <form action="#" class="col-6 pr-0">
                        <button type="button" data-bs-dismiss="offcanvas" aria-label="Close"
                                class="add-cv-bt apply-bt_edit w-100">{{ __('home.Apply') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </body>
    <script>
        let listWishList = `{{ $listWishList }}`;

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
                window.location.href = '{{ route('flea.market.wish.list') }}';
            }
        }

        function checkLogin() {
            if (token === undefined) {
                $('#staticBackdrop').modal('show');
            } else {
                window.location.href = '{{route('flea.market.sell.product')}}';
            }
        }


        const rangeInput = document.querySelectorAll(".range-input input"),
            priceInput = document.querySelectorAll(".price-input input"),
            range = document.querySelector(".slider .progress");
        let priceGap = 1000;
        priceInput.forEach((input) => {
            input.addEventListener("input", (e) => {
                let minPrice = parseInt(priceInput[0].value),
                    maxPrice = parseInt(priceInput[1].value);

                if (maxPrice - minPrice >= priceGap && maxPrice <= rangeInput[1].max) {
                    if (e.target.className === "input-min") {
                        rangeInput[0].value = minPrice;
                        range.style.left = (minPrice / rangeInput[0].max) * 100 + "%";
                    } else {
                        rangeInput[1].value = maxPrice;
                        range.style.right = 100 - (maxPrice / rangeInput[1].max) * 100 + "%";
                    }
                }
            });
        });
        rangeInput.forEach((input) => {
            input.addEventListener("input", (e) => {
                let minVal = parseInt(rangeInput[0].value),
                    maxVal = parseInt(rangeInput[1].value);

                if (maxVal - minVal < priceGap) {
                    if (e.target.className === "range-min") {
                        rangeInput[0].value = maxVal - priceGap;
                    } else {
                        rangeInput[1].value = minVal + priceGap;
                    }
                } else {
                    priceInput[0].value = minVal;
                    priceInput[1].value = maxVal;
                    range.style.left = (minVal / rangeInput[0].max) * 100 + "%";
                    range.style.right = 100 - (maxVal / rangeInput[1].max) * 100 + "%";
                }
            });
        });


        function performSearch() {
            loadingMasterPage();
            var searchInput = document.getElementById('inputSearch');
            var searchValue = searchInput.value;
            var inputSearchMobile = document.getElementById('inputSearchMobile');
            var searchValueMobile = inputSearchMobile.value;
            if (searchValueMobile) {
                searchValue = searchValueMobile;
            }

            var departmentIds = [];
            var departmentInputs = document.querySelectorAll('input[name^="category_"]');
            for (var i = 0; i < departmentInputs.length; i++) {
                var departmentInput = departmentInputs[i];
                if (departmentInput.checked) {
                    departmentIds.push(departmentInput.name.replace('category_', ''));
                }
            }
            var categoryIdsString = departmentIds.join(',');
            var formData = {
                category_id: categoryIdsString,
                name: searchValue,
                status: 'ACTIVE',
                min_price: $('#inputProductMin').val(),
                max_price: $('#inputProductMax').val(),
            };

            $.ajax({
                url: "{{ route('products.api.search') }}",
                method: "GET",
                data: formData,
                success: function (response) {
                    renderProduct(response);
                    loadingMasterPage();
                },
                error: function (error) {
                    console.log(error);
                    loadingMasterPage();
                }
            });
        }

        function renderProduct(products) {
            $('#productsAdsPlan1').html('');
            $('#productsAdsPlan2').html('');
            $('#productsAdsPlan3').html('');

            let adsPlan1Counter = 0;
            let adsPlan2Counter = 0;
            let adsPlan3Counter = 0;

            for (var i = 0; i < products.length; i++) {

                if (adsPlan1Counter === 6 && adsPlan2Counter === 6 && adsPlan3Counter === 6) {
                    break;
                }

                let url = `{{ route('flea.market.product.detail', ['id' => ':id']) }}`;
                url = url.replace(':id', products[i].id);
                var product = products[i];
                let toanQuoc = `{{__('home.Toàn quốc')}}`
                var isSoldOut = product.quantity == 0;
                var adsPlan = product.ads_plan;
                let isFavoriteClass = isUserWasWishlist(product.id);

                var productHtml = `
    <div class="col-md-4 col-6">
        <div class="product-item ${isSoldOut ? 'sold-out-overlay' : ''}">
             <div class="img-pro justify-content-center d-flex img_product--homeNew">
                  <img loading="lazy" src="${product.thumbnail}" alt="">
                  <div class="${ isSoldOut ? 'sold-out-overlay-text' : 'd-none' } ">
                <h1 class="sold-out">{{__('home.Sold Out')}}</h1>
            </div>
                       <a class="button-heart" data-favorite="0">
                            <i id="icon-heart-${product.id}" class="${isFavoriteClass} bi" data-product-id="${product.id}" onclick="addProductToWishList(${product.id})"></i>
                       </a>
                  </div>
             <div class="content-pro p-md-3 p-2">
             <div class="">
                 <div class="name-product" style="min-height: 48px">
                     <a class="name-product--fleaMarket"
                     href="${url}">
                     @if(locationHelper() == 'vi')
                ${product.name}
                @else
                ${product.name_en}
                @endif
                </a>
                 </div>
            <div class="location-pro">
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
                </svg> &nbsp; ${product.location_name ?? toanQuoc }
                </div>
                <div class="prices-pro">
                    ${formatCurrency(product.price)} ${product.price_unit}
                </div>
            </div>
        </div>
        <div class="d-flex justify-content-end">
            <div class="SeeDetail">
                <a href="${url}" target="_blank">{{ __('home.See details') }}</a>
            </div>
        </div>
    </div>

`;

                function formatCurrency(amount) {
                    // Sử dụng hàm toLocaleString để định dạng số tiền
                    return amount.toLocaleString('de-DE');
                }

                if (adsPlan === 1 && adsPlan1Counter < 6) {
                    $('#productsAdsPlan1').append(productHtml);
                    adsPlan1Counter++;
                } else if (adsPlan === 2 && adsPlan2Counter < 6) {
                    $('#productsAdsPlan2').append(productHtml);
                    adsPlan2Counter++;
                } else if (adsPlan === 3 && adsPlan3Counter < 6) {
                    $('#productsAdsPlan3').append(productHtml);
                    adsPlan3Counter++;
                }
            }
        }


    </script>
    <script>
        function addProductToWishList(id) {
            let productId = id;
            let userId = `{{ Auth::check() ? Auth::user()->id : null }}`;
            if (userId) {
                loadingMasterPage();
                let url = '{{ route('api.backend.wish.lists.update', ':productId') }}';
                url = url.replace(':productId', productId);
                $.ajax({
                    url: url,
                    method: 'POST',
                    data: {
                        user_id: userId,
                        product_id: productId
                    },
                    headers: {
                        "Authorization": `Bearer ${token}`,
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (response) {
                        let item = $('#icon-heart-' + id);
                        reGetWishList();
                        if (response.isFavorite == true) {
                            item.removeClass('bi-heart');
                            item.addClass('bi-heart-fill');
                        } else {
                            item.addClass('bi-heart');
                            item.removeClass('bi-heart-fill');
                        }
                        loadingMasterPage();
                    },
                    error: function (exception) {
                        loadingMasterPage();
                    }
                });
            } else {
                $('#staticBackdrop').modal('show');
            }
        }

        function reGetWishList() {
            let userId = `{{ Auth::check() ? Auth::user()->id : null }}`;
            if (userId) {
                let url = '{{ route('api.backend.wish.lists.reGet') }}';
                $.ajax({
                    url: url,
                    method: 'GET',
                    headers: {
                        "Authorization": `Bearer ${token}`,
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (response) {
                        listWishList = response;
                    },
                    error: function (exception) {
                    }
                });
            }
        }

        function getCookie(name) {
            var value = "; " + document.cookie;
            var parts = value.split("; " + name + "=");
            if (parts.length === 2) return parts.pop().split(";").shift();
        }

        $(document).ready(function () {
            callListProduct(token);

            async function callListProduct(token) {
                loadingMasterPage();
                let accessToken = `Bearer ` + token;
                await $.ajax({
                    url: `{{route('products.api.list')}}`,
                    method: 'GET',
                    headers: {
                        "Authorization": accessToken
                    },
                    success: function (response) {
                        renderProduct(response);
                        loadingMasterPage();
                    },
                    error: function (exception) {
                        console.log(exception)
                        loadingMasterPage();
                    }
                });
            }

            async function renderProduct(res) {

                let adsPlan1Counter = 0;
                let adsPlan2Counter = 0;
                let adsPlan3Counter = 0;

                for (let i = 0; i < res.length; i++) {

                    if (adsPlan1Counter === 6 && adsPlan2Counter === 6 && adsPlan3Counter === 6) {
                        break;
                    }

                    let url = `{{ route('flea.market.product.detail', ['id' => ':id']) }}`;
                    url = url.replace(':id', res[i].id);
                    let item = res[i];
                    let toanQuoc = `{{__('home.Toàn quốc')}}`
                    var isSoldOut = item.quantity == 0;
                    let adsPlan = item.ads_plan;
                    let userId = `{{ Auth::check() ? Auth::user()->id : null }}`;

                    let isFavorite = isUserWasWishlist(item.id);
                    let created_by = item.created_by;
                    let tab = ``;
                    if (userId != created_by) {
                        tab = `
                             <a class="button-heart" data-favorite="0">
                                <i id="icon-heart-${item.id}" class="${isFavorite} bi" data-product-id="${item.id}" onclick="addProductToWishList(${item.id})"></i>
                            </a>`;
                    }
                    var html = `

                    <div class="col-md-4 col-6">
                        <div class="product-item ${isSoldOut ? 'sold-out-overlay' : ''}">
                             <div class="img-pro justify-content-center d-flex img_product--homeNew">
                                  <img loading="lazy" src="${item.thumbnail}" alt="" >
                                  <div class="${ isSoldOut ? 'sold-out-overlay-text' : 'd-none' } ">
                <h1 class="sold-out">{{__('home.Sold Out')}}</h1>
            </div>
                                       ${tab}
                                  </div>
                             <div class="content-pro p-md-3 p-2">
                             <div class="">
                                 <div class="name-product" style="min-height: 48px">
                                     <a class="name-product--fleaMarket"
                                     href="${url}">@if(locationHelper() == 'vi')
                                            ${item.name}
                                        @else
                                            ${item.name_en}
                                        @endif</a>
                                 </div>
                            <div class="location-pro">
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
                                </svg> &nbsp; ${item.location_name ?? toanQuoc}
                                </div>
                                <div class="prices-pro">
                                    ${formatCurrency(item.price)} ${item.price_unit}
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-end">
                            <div class="SeeDetail">
                                <a href="${url}" target="_blank">{{ __('home.See details') }}</a>
                            </div>
                        </div>
                    </div>


                    `;

                    function formatCurrency(amount) {
                        // Chuyển đổi dấu phẩy thành dấu chấm
                        const formattedAmount = amount.toString().replace(/,/g, '.');

                        // Truyền ngôn ngữ là 'en-US' cho hàm toLocaleString
                        return parseFloat(formattedAmount).toLocaleString('de-DE');
                    }

                    if (adsPlan === 1 && adsPlan1Counter < 6) {
                        $('#productsAdsPlan1').append(html);
                        adsPlan1Counter++;
                    } else if (adsPlan === 2 && adsPlan2Counter < 6) {
                        $('#productsAdsPlan2').append(html);
                        adsPlan2Counter++;
                    } else if (adsPlan === 3 && adsPlan3Counter < 6) {
                        $('#productsAdsPlan3').append(html);
                        adsPlan3Counter++;
                    }
                }
            }
        });

        function isUserWasWishlist(productId) {
            let isLogin = `{{ Auth::check() }}`;
            if (!isLogin) {
                return 'bi-heart';
            }

            if (listWishList.includes(productId)) {
                return 'bi-heart-fill';
            }
            return 'bi-heart';
        }
    </script>
@endsection
