@php use App\Enums\online_medicine\FilterOnlineMedicine;use App\Enums\online_medicine\ObjectOnlineMedicine;use App\Http\Controllers\MainController;use App\Models\User;use Illuminate\Support\Facades\Auth; @endphp
@extends('layouts.master')
@section('title', 'Online Medicine')
@section('content')
    @include('layouts.partials.header')
    @include('component.banner')
    @php
        $isAdmin = (new MainController())->checkAdmin();
        $isBusiness = (new MainController())->checkBusiness();
        $isMedical = (new MainController())->checkMedical();
    @endphp
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

        @media (max-width: 575px) {
            #online-medicine .btnModalCart.shopping-bag {
                margin-right: 0;
                height: 100%;
                width: 100%;
            }

            .content-pro {
                color: #FFFFFF;
                padding: 12px;
            }

            .content-pro .name-pro a {
                font-size: 12px;
                line-height: 24px;
                font-weight: 500;
                margin-bottom: 8px;
                color: #FFFFFF !important;
            }

            .product-item .content-pro .location-pro p {
                color: #FFFFFF;
            }

        }

        @media (min-width: 576px) {
            .content-pro {
                color: #FFFFFF;
                padding: 12px;
            }

            .content-pro .name-pro a {
                font-size: 16px;
                line-height: 24px;
                font-weight: 500;
                margin-bottom: 8px;
                color: #FFFFFF !important;
            }

            .product-item .content-pro .location-pro p {
                color: #FFFFFF;
            }

            .SeeDetail {
                border-radius: 60px 0 16px 0;
                background: #FFF;
                display: flex;
                padding: 16px 18px !important;
                justify-content: center;
                align-items: center;
                gap: 10px;
                color: #000;
                font-size: 18px;
                font-style: normal;
                font-weight: 800;
                line-height: normal;
            }
        }

        .add-cv-bt {
            display: flex;
            justify-content: center;
            align-items: center;
            border-radius: 8px;
            height: 48px;
            width: 270px;
            color: #f7f7f7;
            border: none;
            margin-top: 24px;
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
    <div class="medicine container" id="online-medicine">
        <div class="row medicine-search d-none d-sm-flex">
            <div class="medicine-search--left col-md-3 d-flex justify-content-around">
                <div class="title pl-0 col-md-5">
                    <select class="form-select" id="category_id" name="category_id"
                            onchange="categoryFilterMedicine(this.value)">
                        <option value="">{{ __('home.Category') }}</option>
                        @if($categoryMedicines)
                            @foreach($categoryMedicines as $index => $cateProductMedicine)
                                <option value="{{ $cateProductMedicine->id }}">{{ $cateProductMedicine->name }}</option>
                            @endforeach
                        @endif
                    </select>
                </div>
                <div class="title pr-0 col-md-7">
                    <select class="form-select" id="category_id" name="category_id"
                            onchange="locationFilterMedicine(this.value)">
                        <option value="">{{ __('home.Location') }}</option>
                        @if($provinces)
                            @foreach($provinces as $index => $province)
                                <option value="{{ $province->id }}">{{ $province->full_name }}</option>
                            @endforeach
                        @endif
                    </select>
                </div>
            </div>
            <div class="medicine-search--center col-md-6 row d-flex justify-content-between">
                <div class="search-box col-md-10">
                    <input type="search" onkeypress="performSearch()" name="focus"
                           placeholder="{{__('home.Enter name, prescription or ingredients of products')}}" id="search-input" value="">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </div>
                @if(Auth::check())
                    <button type="button" data-toggle="modal" data-target="#modalCart"
                            class="btnModalCart shopping-bag">
                        <i class="fa-solid fa-bag-shopping"></i>
                        @if($carts && count($carts) > 0)
                            <div class="text-wrapper"> {{ count($carts) }}</div>
                        @endif
                    </button>
                    @include('component.modal-cart')
                @endif
                @include('component.modal-cart')
            </div>
            <div class="medicine-search--right col-md-3 d-flex row justify-content-between">
                <div class="col-md-6 ">
                    <div class="div-wrapper">
                        <a type="button"
                           data-toggle="modal"
                           data-target="#modalCreatPrescription"
                        >{{ __('home.Create prescription') }}
                        </a>
                    </div>
                </div>
                @include('component.modalCreatPrescription')
                <div class="col-md-6">
                    <div class="div-wrapper">
                        <a href="{{route('medicine.wishList')}}">{{ __('home.Wish list') }}</a>
                    </div>
                </div>
            </div>
        </div>

        {{-- filter trong màn hình mobile --}}
        <div class=" medicine-search d-block d-sm-none">
            <div class="medicine-search--center row">
                @if(Auth::check())
                    <div class="search-box col-md-8 col-8">
                        <input type="search" onkeypress="performSearch()" name="focus"
                               placeholder="{{ __('home.Search for anything…') }}" id="search-input" value="">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </div>
                    <a class="col-2">
                        <button type="button" data-toggle="modal" data-target="#modalCart"
                                class="btnModalCart shopping-bag">
                            <i class="fa-solid fa-bag-shopping"></i>
                            @if($carts && count($carts) > 0)
                                <div class="text-wrapper"> {{ count($carts) }}</div>
                            @endif
                        </button>
                    </a>
                    <a class="col-2">
                        <button type="button"
                                class="btnModalCart shopping-bag" data-bs-toggle="offcanvas"
                                data-bs-target="#filterNavbar">
                            <i class="bi bi-filter"></i>
                        </button>
                    </a>

                    @include('component.modal-cart')
                @else
                    <div class="search-box col-12">
                        <input type="search" onkeypress="performSearch()" name="focus"
                               placeholder="{{ __('home.Search for anything…') }}" id="search-input" value="">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </div>
                @endif
                @include('component.modal-cart')
            </div>
            <div class="medicine-search--right row mt-3">
                <div class="col-md-6 col-6">
                    <div class="div-wrapper">
                        <a type="button"
                            {{--                           data-toggle="modal"--}}
                            {{--                           data-target="#modalCreatPrescription"--}}
                        >{{ __('home.Create prescription') }}
                        </a>
                    </div>
                </div>
                @include('component.modalCreatPrescription')
                <div class="col-md-6 col-6">
                    <div class="div-wrapper">
                        <a href="{{route('medicine.wishList')}}">{{ __('home.Wish list') }}</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="medicine-list row">
            <div class="col-md-3 medicine-list--filter d-none d-sm-block">
                <div class="filter">
                    <div class="filter-header d-flex justify-content-between">
                        <div class="text-wrapper">{{ __('home.Filter') }}</div>
                        <i class="fa-solid fa-chevron-down"></i>
                    </div>
                    <div class="filter-body">
                        <div class="d-flex item">
                            <input type="checkbox" name="filter_" value="0" onchange="searchFilterMedicine(this.value)">
                            <div class="text-all">{{ __('home.All') }} ({{ $countAllMedicine }})</div>
                        </div>
                        <div class="d-flex item">
                            <input type="checkbox" name="filter_"
                                   value="{{ FilterOnlineMedicine::HEALTH }}"
                                   onchange="searchFilterMedicine(this.value)">
                            <div class="text">{{ __('home.Heath') }}</div>
                        </div>
                        <div class="d-flex item">
                            <input type="checkbox" name="filter_"
                                   value="{{ FilterOnlineMedicine::BEAUTY }}"
                                   onchange="searchFilterMedicine(this.value)">
                            <div class="text">{{ __('home.Beauty') }}</div>
                        </div>
                        <div class="d-flex item">
                            <input type="checkbox" name="filter_"
                                   value="{{ FilterOnlineMedicine::PET }}"
                                   onchange="searchFilterMedicine(this.value)">
                            <div class="text">{{ __('home.Pets') }}</div>
                        </div>
                    </div>
                </div>
                <div class="filter">
                    <div class="filter-header d-flex justify-content-between">
                        <div class="text-wrapper">{{ __('home.Object') }}</div>
                        <i class="fa-solid fa-chevron-down"></i>
                    </div>
                    <div class="filter-body">
                        <div class="d-flex item">
                            <input type="checkbox" value="{{ ObjectOnlineMedicine::KIDS }}"
                                   onchange="objectFilterMedicine(this.value)">
                            <div class="text">{{ __('home.For kids') }}</div>
                        </div>
                        <div class="d-flex item">
                            <input type="checkbox"
                                   value="{{ ObjectOnlineMedicine::FOR_WOMEN }}"
                                   onchange="objectFilterMedicine(this.value)">
                            <div class="text">{{ __('home.For women') }}</div>
                        </div>
                        <div class="d-flex item">
                            <input type="checkbox"
                                   value="{{ ObjectOnlineMedicine::FOR_MEN }}"
                                   onchange="objectFilterMedicine(this.value)">
                            <div class="text">{{ __('home.For men') }}</div>
                        </div>
                        <div class="d-flex item">
                            <input type="checkbox"
                                   value="{{ ObjectOnlineMedicine::FOR_ADULT }}"
                                   onchange="objectFilterMedicine(this.value)">
                            <div class="text">{{ __('home.For adults') }}</div>
                        </div>
                    </div>
                </div>
                <div class="filter">
                    <div class="filter-header d-flex justify-content-between">
                        <div class="text-wrapper">{{__('home.Manufacturing Company')}}</div>
                        <i class="fa-solid fa-chevron-down"></i>
                    </div>
                    <div class="filter-body">
                        @if(is_array($array_company))
                            @foreach($array_company as $company)
                                <div class="d-flex item">
                                    <input type="checkbox" value="{{ $company }}"
                                           onchange="companyMedicine(this.value);">
                                    <div class="text">{{ $company }}</div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
                <div class="filter">
                    <div class="filter-header d-flex justify-content-between">
                        <div class="text-wrapper">{{__('home.Manufacturing Country')}}</div>
                        <i class="fa-solid fa-chevron-down"></i>
                    </div>
                    <div class="filter-body">
                        @if(is_array($array_country))
                            @foreach($array_country as $country)
                                <div class="d-flex item">
                                    <input type="checkbox" value="{{ $country }}"
                                           onchange="countryMedicine(this.value);">
                                    <div class="text">{{ $country }}</div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-md-9 medicine-list--item">
                <div class="page row" id="content-medicine">
                    @foreach($medicines as $medicine)
                        <div class="col-md-4 col-6 col-sm-4 col-xl-4 d-none d-sm-block">
                            @include('component.products')
                        </div>
                    @endforeach
                    @foreach($medicine10 as $medicine)
                        <div class="col-md-4 col-6 col-sm-4 col-xl-4 d-block d-sm-none">
                            @include('component.products')
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

    </div>
    <div class="offcanvas offcanvas-end" tabindex="-1" id="filterNavbar" aria-labelledby="offcanvasNavbarLabel">
        <div class="offcanvas-header">
            <a href="{{route('home')}}" class="offcanvas-title" id="offcanvasNavbarLabel">
                <img class="w-100" src="{{asset('img/icons_logo/logo-new.png')}}">
            </a>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <div class="col-md-3 medicine-list--filter">
                <div class="filter">
                    <div class="filter-header d-flex justify-content-between">
                        <div class="text-wrapper">{{ __('home.Filter') }}</div>
                        <i class="fa-solid fa-chevron-down"></i>
                    </div>
                    <div class="filter-body">
                        <div class="d-flex item">
                            <input type="checkbox" name="filter_" value="0" onchange="searchFilterMedicine(this.value)">
                            <div class="text-all">{{ __('home.All') }} ({{ $countAllMedicine }})</div>
                        </div>
                        <div class="d-flex item">
                            <input type="checkbox" name="filter_"
                                   value="{{ FilterOnlineMedicine::HEALTH }}"
                                   onchange="searchFilterMedicine(this.value)">
                            <div class="text">{{ __('home.Heath') }}</div>
                        </div>
                        <div class="d-flex item">
                            <input type="checkbox" name="filter_"
                                   value="{{ FilterOnlineMedicine::BEAUTY }}"
                                   onchange="searchFilterMedicine(this.value)">
                            <div class="text">{{ __('home.Beauty') }}</div>
                        </div>
                        <div class="d-flex item">
                            <input type="checkbox" name="filter_"
                                   value="{{ FilterOnlineMedicine::PET }}"
                                   onchange="searchFilterMedicine(this.value)">
                            <div class="text">{{ __('home.Pets') }}</div>
                        </div>
                    </div>
                </div>
                <div class="filter">
                    <div class="filter-header d-flex justify-content-between">
                        <div class="text-wrapper">{{ __('home.Object') }}</div>
                        <i class="fa-solid fa-chevron-down"></i>
                    </div>
                    <div class="filter-body">
                        <div class="d-flex item">
                            <input type="checkbox" value="{{ ObjectOnlineMedicine::KIDS }}"
                                   onchange="objectFilterMedicine(this.value)">
                            <div class="text">{{ __('home.For kids') }}</div>
                        </div>
                        <div class="d-flex item">
                            <input type="checkbox"
                                   value="{{ ObjectOnlineMedicine::FOR_WOMEN }}"
                                   onchange="objectFilterMedicine(this.value)">
                            <div class="text">{{ __('home.For women') }}</div>
                        </div>
                        <div class="d-flex item">
                            <input type="checkbox"
                                   value="{{ ObjectOnlineMedicine::FOR_MEN }}"
                                   onchange="objectFilterMedicine(this.value)">
                            <div class="text">{{ __('home.For men') }}</div>
                        </div>
                        <div class="d-flex item">
                            <input type="checkbox"
                                   value="{{ ObjectOnlineMedicine::FOR_ADULT }}"
                                   onchange="objectFilterMedicine(this.value)">
                            <div class="text">{{ __('home.For adults') }}</div>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-center align-items-center mt-4">
                    <a class="add-cv-bt w-100 apply-bt_delete col-6">{{ __('home.Refresh') }}</a>
                    <form class="col-6 pr-0">
                        <button type="button" data-bs-dismiss="offcanvas" aria-label="Close"
                                class="add-cv-bt apply-bt_edit w-100">{{ __('home.Apply') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        let medical_favourites = `{{ $medical_favourites }}`;

        function isUserWasWishlist(medicineId) {
            let isLogin = `{{ Auth::check() }}`;
            if (!isLogin) {
                return 'bi-heart';
            }

            if (medical_favourites.includes(medicineId)) {
                return 'bi-heart-fill';
            }
            return 'bi-heart';
        }
    </script>
    <script>
        async function performSearch() {
            if (event.keyCode === 13 && !event.shiftKey) {
                await masterFilterMedicine();
            }
        }
    </script>
    <script>
        let filterMedicine = [];
        let objectMedicine = [];
        let categoryMedicine = '';
        let locationMedicine = [];
        let companyMedicineValue = [];
        let countryMedicineValue = [];

        async function masterFilterMedicine() {
            let searchInput = document.getElementById('search-input');
            let searchValue = searchInput.value;

            loadingMasterPage();

            var data = {
                name: searchValue,
                object: objectMedicine.toString(),
                filter: filterMedicine.toString(),
                company: companyMedicineValue.toString(),
                country: countryMedicineValue.toString(),
                category: categoryMedicine,
                location: locationMedicine,
                status: 'ACTIVE',
                min_price: $('#inputProductMin').val(),
                max_price: $('#inputProductMax').val(),
            };

            try {
                await $.ajax({
                    url: `{{route('medicine.search')}}`,
                    method: "GET",
                    data: data,
                    success: function (data) {
                        renderJson2Html(data);
                    },
                    error: function (exception) {
                    }
                });
            } catch (error) {
                loadingMasterPage();
                throw error;
            }
            setTimeout(function () {
                loadingMasterPage();
            }, 1000);
        }

        function renderJson2Html(data) {
            console.log(data)
            let html = '';
            // data = data.data;
            document.getElementById('content-medicine').innerHTML = html;
            if (data.length === 0) {
                html = `<div class="col-md-12">
                            <div class="alert alert-danger" role="alert">
                                No data
                            </div>
                        </div>`;
            } else {
                data.forEach(async function (item) {
                    let url = `{{ route('medicine.detail', ['id' => ':id']) }}`;
                    url = url.replace(':id', item.id);
                    let isSoldOut = item.quantity == 0;
                    let isFavoriteClass = isUserWasWishlist(item.id);
                    html += `<div class="col-md-3 col-6">
        <div class="product-item ${isSoldOut ? 'sold-out-overlay' : ''}">
    <div class="img-pro">
        <img src="${item.thumbnail}" alt="">
        <div class="${isSoldOut ? 'sold-out-overlay-text d-flex justify-content-center align-items-center w-100' : 'd-none'} ">
                <h1 class="sold-out">{{__('home.Sold Out')}}</h1>
            </div>
        <a class="button-heart" data-favorite="0">
            <i id="heart-icon-${item.id}" class="${isFavoriteClass} bi" data-product-id="${item.id}"
               onclick="handleAddMedicineToWishList(${item.id})"></i>
        </a>
    </div>
    <div class="content-pro">
        <div class="name-pro">
            <a href="${url}">${item.name}</a>
        </div>
        <div class="location-pro d-flex align-items-center">
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
            </svg> <p>${item.location_name ?? '{{ __('home.Toàn quốc') }}'}</p>
        </div>
        <div class="price-pro">
            ${formatCurrency(item.price ?? 0)} ${item.unit_price ?? 'VND'}
                    </div>
                </div>
                <div class="d-flex justify-content-end">
                    <div class="SeeDetail">
                        <a href="{{route('medicine.detail', $medicine->id)}}" target="_blank">{{ __('home.See details') }}</a>
        </div>
    </div>
</div>
    </div>`;

                    function formatCurrency(amount) {
                        const formattedAmount = amount.toString().replace(/,/g, '.');

                        return parseFloat(formattedAmount).toLocaleString('de-DE');
                    }
                });
            }
            document.getElementById('content-medicine').innerHTML = html;
        }

        function searchFilterMedicine(value) {
            // Kiểm tra xem giá trị có trong mảng hay không
            var index = filterMedicine.indexOf(value);

            if (index === -1) {
                // Nếu giá trị không có trong mảng, thêm vào mảng
                filterMedicine.push(value);
            } else {
                // Nếu giá trị đã có trong mảng, xóa khỏi mảng
                filterMedicine.splice(index, 1);
            }

            masterFilterMedicine();
        }

        function objectFilterMedicine(value) {
            // Kiểm tra xem giá trị có trong mảng hay không
            var index = objectMedicine.indexOf(value);

            if (index === -1) {
                // Nếu giá trị không có trong mảng, thêm vào mảng
                objectMedicine.push(value);
            } else {
                // Nếu giá trị đã có trong mảng, xóa khỏi mảng
                objectMedicine.splice(index, 1);
            }

            masterFilterMedicine();
        }

        function priceFilterMedicine() {
            console.log('priceFilterMedicine')
        }

        function categoryFilterMedicine(value) {
            categoryMedicine = value;

            masterFilterMedicine();
        }

        function locationFilterMedicine(value) {
            locationMedicine = value;

            masterFilterMedicine();
        }

        function countryMedicine(value) {
            // Kiểm tra xem giá trị có trong mảng hay không
            var index = countryMedicineValue.indexOf(value);

            if (index === -1) {
                // Nếu giá trị không có trong mảng, thêm vào mảng
                countryMedicineValue.push(value);
            } else {
                // Nếu giá trị đã có trong mảng, xóa khỏi mảng
                countryMedicineValue.splice(index, 1);
            }

            masterFilterMedicine();
        }

        function companyMedicine(value) {
            // Kiểm tra xem giá trị có trong mảng hay không
            var index = companyMedicineValue.indexOf(value);

            if (index === -1) {
                // Nếu giá trị không có trong mảng, thêm vào mảng
                companyMedicineValue.push(value);
            } else {
                // Nếu giá trị đã có trong mảng, xóa khỏi mảng
                companyMedicineValue.splice(index, 1);
            }

            masterFilterMedicine();
        }
    </script>
    <script>
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

    </script>
@endsection
