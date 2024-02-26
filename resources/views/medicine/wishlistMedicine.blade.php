@php use App\Enums\online_medicine\FilterOnlineMedicine;use App\Enums\online_medicine\ObjectOnlineMedicine;use App\Http\Controllers\MainController;use App\Models\User;use Illuminate\Support\Facades\Auth; @endphp
@extends('layouts.master')
@section('title', 'Online Medicine')
@section('content')
    @include('layouts.partials.header')
    @include('component.banner')

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

        @media (max-width: 576px) {
            #online-medicine .btnModalCart.shopping-bag {
                margin-right: 0;
                height: 100%;
                width: 100%;
            }

            .content-pro .name-product a {
                color: #FFFFFF;
                font-size: 18px;
                font-style: normal;
                font-weight: 800;
                line-height: normal;
                min-height: 50px;
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
                <form class="search-box col-md-10">
                    <input type="search" onkeyup="performSearch()" name="focus"
                           placeholder="{{ __('home.Search for anything…') }}" id="search-input" value="">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </form>
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
        </div>

        {{-- filter trong màn hình mobile --}}
        <div class=" medicine-search d-block d-sm-none">
            <div class="medicine-search--center row">

                @if(Auth::check())
                    <form class="search-box col-md-8 col-8">
                        <input type="search" onkeyup="performSearch()" name="focus"
                               placeholder="{{ __('home.Search for anything…') }}" id="search-input" value="">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </form>
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
                    <form class="search-box col-12">
                        <input type="search" onkeyup="performSearch()" name="focus"
                               placeholder="{{ __('home.Search for anything…') }}" id="search-input" value="">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </form>
                @endif
                @include('component.modal-cart')
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
                                       max="10000000" value="2500000" step="1000">
                                <input type="range" onchange="performSearch()" class="rangePrice range-max" min="0"
                                       max="10000000" value="7500000" step="1000">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-9 medicine-list--item">
                <div class="page row" id="content-medicine">
                    @foreach($medicines as $medicine)
                        <div class="col-md-4 col-6 col-sm-4 col-xl-3 d-none d-sm-block">
                            @include('component.products')
                        </div>
                    @endforeach
                    @foreach($medicine10 as $medicine)
                        <div class="col-md-4 col-6 col-sm-4 col-xl-3 d-block d-sm-none">
                            @include('component.products')
                        </div>
                    @endforeach
                </div>
                <div class="d-flex justify-content-center d-none d-sm-block">
                    {{ $medicines->links() }}
                </div>
                <div class="d-flex justify-content-center d-block d-sm-none">
                    {{ $medicine10->links() }}
                </div>
            </div>
        </div>

    </div>
    <div class="offcanvas offcanvas-end" tabindex="-1" id="filterNavbar" aria-labelledby="offcanvasNavbarLabel">
        <div class="offcanvas-header">
            <a href="{{route('home')}}" class="offcanvas-title" id="offcanvasNavbarLabel"><img class="w-100"
                                                                                               src="{{asset('img/icons_logo/logo-new.png')}}"></a>
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
                                       max="10000000" value="2500000" step="1000">
                                <input type="range" onchange="performSearch()" class="rangePrice range-max" min="0"
                                       max="10000000" value="7500000" step="1000">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="d-flex justify-content-center mt-4">
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
