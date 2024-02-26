@php use App\Models\Department;use App\Models\MedicalFavourite;use App\Models\Province; @endphp
@php use App\Models\User;use Illuminate\Support\Facades\Auth;
 $currentUserId = Auth::user()->id ?? '';
@endphp
@extends('layouts.master')
@section('title', 'Find By Medicine')
<link href="{{ asset('css/findmymedicine.css') }}" rel="stylesheet">
@section('content')
    <style>
        @media (max-width: 575px) {
            h3.no-data.text-center {
                font-size: 16px;
            }
        }

        .bi-heart-fill {
            color: red;
        }


        .bi-heart-fill {
            color: red;
        }

        .find-my-medicine-2 .frame {
            display: inline-flex;
            flex-direction: column;
            align-items: center;
            gap: 12px;
            position: relative;
            background-color: #088180;
            border-radius: 24px;
            border: 1px solid;
            border-color: var(--grey-medium);
        }

        .find-my-medicine-2 .frame .rectangle {
            position: relative;
            object-fit: cover;
        }

        .find-my-medicine-2 .frame .div {
            display: flex;
            flex-direction: column;
            align-items: flex-end;
            gap: 16px;
            position: relative;
            align-self: stretch;
            width: 100%;
            flex: 0 0 auto;
        }

        .find-my-medicine-2 .frame .div-2 {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            gap: 8px;
            padding: 0px 16px;
            position: relative;
            align-self: stretch;
            width: 100%;
            flex: 0 0 auto;
        }

        .find-my-medicine-2 .frame .text-wrapper {
            position: relative;
            width: fit-content;
            margin-top: -1px;
            font-weight: var(--body-1-extra-font-weight);
            color: var(--white);
            font-size: var(--body-1-extra-font-size);
            text-align: center;
            letter-spacing: var(--body-1-extra-letter-spacing);
            line-height: var(--body-1-extra-line-height);
            font-style: var(--body-1-extra-font-style);
        }

        .find-my-medicine-2 .frame .div-3 {
            display: inline-flex;
            align-items: flex-start;
            gap: 12px;
            position: relative;
            flex: 0 0 auto;
        }

        .find-my-medicine-2 .frame .marker-pin {
            position: relative;
            width: 20px;
            height: 20px;
        }

        .find-my-medicine-2 .frame .text-wrapper-2 {
            position: relative;
            width: fit-content;
            margin-top: -1px;
            font-weight: var(--body-4-extra-font-weight);
            color: var(--white);
            font-size: var(--body-4-extra-font-size);
            text-align: center;
            letter-spacing: var(--body-4-extra-letter-spacing);
            line-height: var(--body-4-extra-line-height);
            font-style: var(--body-4-extra-font-style);
        }

        .find-my-medicine-2 .frame .text-wrapper-3 {
            position: relative;
            width: fit-content;
            font-weight: var(--subtitle-1-extra-font-weight);
            color: var(--white);
            font-size: var(--subtitle-1-extra-font-size);
            text-align: center;
            letter-spacing: var(--subtitle-1-extra-letter-spacing);
            line-height: var(--subtitle-1-extra-line-height);
            font-style: var(--subtitle-1-extra-font-style);
        }

        .find-my-medicine-2 .frame .div-wrapper {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            padding: 16px 40px;
            position: relative;
            flex: 0 0 auto;
            margin-bottom: -1px;
            margin-right: -1px;
            background-color: var(--white);
            border-radius: 60px 0px 24px 0px;
            overflow: hidden;
        }

        .find-my-medicine-2 .frame .text-wrapper-4 {
            position: relative;
            width: fit-content;
            font-weight: var(--subtitle-1-extra-font-weight);
            color: var(--black);
            font-size: var(--subtitle-1-extra-font-size);
            letter-spacing: var(--subtitle-1-extra-letter-spacing);
            line-height: var(--subtitle-1-extra-line-height);
            font-style: var(--subtitle-1-extra-font-style);
        }

        .find-my-medicine-2 .frame .img {
            position: absolute;
            width: 24px;
            height: 24px;
            top: 20px;
            left: 225px;
        }

        .find-my-medicine-2 .frame .group {
            position: absolute;
            width: 116px;
            height: 114px;
            top: -19px;
            left: -19px;
        }

        .find-my-medicine-2 .frame .overlap-group {
            position: relative;
            width: 95px;
            height: 95px;
            top: 19px;
            left: 19px;
            background-image: url(https://c.animaapp.com/ItWXPcpR/img/rectangle-23800-2.svg);
            background-size: 100% 100%;
        }

        .find-my-medicine-2 .frame .text-wrapper-5 {
            position: absolute;
            height: 23px;
            top: 26px;
            left: 19px;
            transform: rotate(-45deg);
            font-weight: var(--body-1-extra-font-weight);
            color: #ffffff;
            font-size: var(--body-1-extra-font-size);
            letter-spacing: var(--body-1-extra-letter-spacing);
            line-height: var(--body-1-extra-line-height);
            font-style: var(--body-1-extra-font-style);
        }

        .find-my-medicine-2 .text-wrapper.text-ellipsis {
            text-overflow: ellipsis;
        }

        .find-my-medicine-2 .frame .frame-wrapper-heart {
            display: inline-flex;
            align-items: flex-start;
            gap: 10px;
            padding: 8px;
            position: absolute;
            top: 8px;
            right: 8px;
            background-color: var(--light);
            border-radius: 51px;
        }

        .find-my-medicine-2 .frame .frame-wrapper-heart i {
            font-size: 24px;
        }

        .find-my-medicine-2 .border-img {
            border-radius: 13px 13px 100px 0px;
            object-fit: cover;
        }

        .find-my-medicine .frame:hover, .find-my-medicine-2 .frame:hover {
            border-radius: 22px;
            background: #088180;
            box-shadow: 0px 8px 10px 0px rgba(0, 0, 0, 0.25);
        }

        .rectangle {
            /*height: 273px;*/
        }

    </style>

    @include('layouts.partials.header_3')
    @include('component.banner')

    <div class="container">
        <div id="examination-scene">

            <div class="row medicine-search">
                <form action="{{ route('examination.findmymedicine') }}" method="get" class="row" id="searchForm">
                    <div class="col-sm-2">
                        <div class="form-group">
                            <label for="exampleFormControlSelect2">{{ __('home.Department') }}</label>
                            <select class="form-control" name="department_id" onchange="submitForm()">
                                <option value="">{{ __('home.All') }}</option>
                                @foreach($departments as $department)
                                    <option href="#"
                                            {{ $departmentId == $department->id ? 'selected' : '' }} value="{{ $department->id }}"
                                            data-department="{{$department}}">{{$department->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <div class="form-group">
                            <label for="exampleFormControlSelect2">{{ __('home.Danh mục thuoc') }}</label>
                            <select class="form-control" name="category_product" onchange="submitForm()">
                                <option value="">{{ __('home.All') }}</option>
                                @foreach($categoryMedicines as $categoryProduct)
                                    <option {{ $categoryProductId == $categoryProduct->id ? 'selected' : '' }} href="#"
                                            value="{{ $categoryProduct->id }}">{{$categoryProduct->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-sm-2">
                        <div class="form-group">
                            <label for="exampleFormControlSelect2">{{ __('home.Location') }}</label>
                            <select class="form-control" name="province_id" onchange="submitForm()">
                                <option value="">{{ __('home.All') }}</option>
                                @foreach($provinces as $province)
                                    <option href="#" {{ $provinceId == $province->id ? 'selected' : '' }}
                                    value="{{ $province->id }}"
                                    >{{$province->full_name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-4 col">
                        <div class="form-group position-relative">
                            <label for="inputSearchDoctor" class="fa fa-search form-control-feedback"></label>
                            <input type="search" id="inputSearchDoctor" class="form-control"
                                   name="nameSearch"
                                   value="{{ $nameSearch }}"
                                   placeholder="{{ __('home.Search for anything…') }}">
                        </div>
                    </div>
                </form>

            </div>

            <div id="list-find-my-medicine">
                <div class="d-flex justify-content-center" style="padding: 12px">
                    <div class="list-title w-100 align-items-center justify-content-between d-flex">
                        <div class="list--doctor p-0">
                            <p>{{ __('home.Best Pharmacists') }}</p>
                        </div>
                        <div class="ms-auto p-2"><a
                                href="{{route('examination.bestpharmacists')}}">{{ __('home.See all') }}</a></div>
                    </div>
                </div>
                <div class="row list-doctor m-auto find-my-medicine">
                    @if(count($bestPhamrmacists) > 0)
                        @foreach($bestPhamrmacists as $pharmacist)
                            @include('examination.component_doctor_findmymedicine', ['pharmacist' => $pharmacist])
                        @endforeach
                    @else
                        <h3 class="no-data text-center">{{ __('home.no data') }}</h3>
                    @endif
                </div>
                <div class="d-flex justify-content-center" style="padding: 12px">
                    <div class=" list-title w-100 align-items-center justify-content-between  d-flex">
                        <div class="list--doctor p-0">
                            <p>{{ __('home.New Pharmacists') }}</p>
                        </div>
                        <div class="ms-auto p-2"><a
                                href="{{route('examination.newpharmacists')}}">{{ __('home.See all') }}</a></div>
                    </div>
                </div>
                <div class="row list-doctor m-auto find-my-medicine">
                    @if(count($newPhamrmacists) > 0)
                        @foreach($newPhamrmacists as $pharmacist)
                            @include('examination.component_doctor_findmymedicine', ['pharmacist' => $pharmacist])
                        @endforeach
                    @else
                        <h3 class="no-data text-center">{{ __('home.no data') }}</h3>
                    @endif
                </div>
                <div class="d-flex justify-content-center" style="padding: 12px">
                    <div class=" list-title w-100 align-items-center justify-content-between d-flex">
                        <div class="list--doctor p-0">
                            <p>{{ __('home.24/7 Available Pharmacists') }}</p>
                        </div>
                        <div class="ms-auto p-2"><a
                                href="{{route('examination.availablepharmacists')}}">{{ __('home.See all') }}</a>
                        </div>
                    </div>
                </div>
                <div class="row list-doctor m-auto find-my-medicine">
                    @if(count($allPhamrmacists) > 0)
                        @foreach($allPhamrmacists as $pharmacist)
                            @include('examination.component_doctor_findmymedicine', ['pharmacist' => $pharmacist])
                        @endforeach
                    @else
                        <h3 class="no-data text-center">{{ __('home.no data') }}</h3>
                    @endif
                </div>
                <div class="d-flex justify-content-center" style="padding: 12px">
                    <div class=" list-title w-100 align-items-center justify-content-between d-flex">
                        <div class="list--doctor p-0">
                            <p>{{ __('home.Hot deal medicine') }}</p>
                        </div>
                        <div class="ms-auto p-2"><a
                                href="{{route('examination.hotdealmedicine')}}">{{ __('home.See all') }}</a></div>
                    </div>
                </div>
                <div class="row list-doctor m-auto find-my-medicine-2">
                    @if(count($hotMedicines) > 0)
                        @foreach($hotMedicines as $medicine)
                            @include('examination.component_medicine_findmymedicine', ['medicine' => $medicine])
                        @endforeach
                    @else
                        <h3 class="no-data text-center">{{ __('home.no data') }}</h3>
                    @endif
                </div>
                <div class="d-flex justify-content-center" style="padding: 12px">
                    <div class=" list-title w-100 align-items-center justify-content-between d-flex">
                        <div class="list--doctor p-0">
                            <p>{{ __('home.New medicine') }}</p>
                        </div>
                        <div class="ms-auto p-2"><a
                                href="{{route('examination.newmedicine')}}">{{ __('home.See all') }}</a></div>
                    </div>
                </div>
                <div class="row list-doctor m-auto find-my-medicine-2">
                    @if(count($newMedicines) > 0)
                        @foreach($newMedicines as $medicine)
                            @include('examination.component_medicine_findmymedicine', ['medicine' => $medicine])
                        @endforeach
                    @else
                        <h3 class="no-data text-center">{{ __('home.no data') }}</h3>
                    @endif
                </div>
                <div class="d-flex justify-content-center" style="padding: 12px">
                    <div class=" list-title w-100 align-items-center justify-content-between d-flex">
                        <div class="list--doctor p-0">
                            <p>{{ __('home.Recommended') }}</p>
                        </div>
                        <div class="ms-auto p-2"><a
                                href="{{route('examination.recommended')}}">{{ __('home.See all') }}</a></div>
                    </div>
                </div>
                <div class="row list-doctor m-auto find-my-medicine-2">
                    @if(count($recommendedMedicines) > 0)
                        @foreach($recommendedMedicines as $medicine)
                            @include('examination.component_medicine_findmymedicine', ['medicine' => $medicine])
                        @endforeach
                    @else
                        <h3 class="no-data text-center">{{ __('home.no data') }}</h3>
                    @endif
                </div>
                <div class="d-flex justify-content-center" style="padding: 12px">
                    <div class=" list-title w-100 align-items-center justify-content-between d-flex">
                        <div class="list--doctor p-0">
                            <p>{{ __('home.Functional Foods') }}</p>
                        </div>
                        <div class="ms-auto p-2"><a href="#">{{ __('home.See all') }}</a></div>
                    </div>
                </div>
                <div class="row list-doctor m-auto find-my-medicine-2">
                    @if(count($function_foods) > 0)
                        @foreach($function_foods as $medicine)
                            @include('examination.component_medicine_findmymedicine', ['medicine' => $medicine])
                        @endforeach
                    @else
                        <h3 class="no-data text-center">{{ __('home.no data') }}</h3>
                    @endif
                </div>
            </div>
        </div>
        <script>
            let name = '';
            $(document).ready(function () {
                $('.medicine-product').on('click', function () {
                    $('.medicine-product').removeClass('active');
                    $(this).addClass('active');
                    let medicine = $(this).data('medicine');
                    callListDoctorByDepartment(medicine);
                })

                function showListMedicineByCategory(res, medicine) {
                    let html = ``;
                    let url = `{{ asset('storage') }}`;
                    let detail = `{{ route('medicine.detail', ['id' => ':id']) }}`;
                    for (let i = 0; i < res.length; i++) {
                        let item = res[i];
                        let mainUrl = detail.replace(':id', item['id']);
                        let imageDoctor = item['thumbnail'];
                        let myArray = imageDoctor.split("/storage");
                        html = html + `<div class=" col-sm-3">
                                <div class="card">
                            <i class="bi bi-heart"></i>
                            <img loading="lazy" src="${url}${myArray[1]}" class="card-img-top" alt="...">
                            <div class="card-body">
                                <a href="${mainUrl}"><h5 class="card-title">
                                    @if(locationHelper() == 'vi')
                                        ${item['name']}
                                    @else
                                        ${item['name_en']}
                                    @endif
                                </h5></a>
                                <p class="card-text_1">{{ __('home.Location') }}: <b>${item['address_code']}</b></p>
                                <p class="card-text_1">Price: <b>${item['price']} ${item['unit_price']}</b></p>
                            </div>
                            </div>
                        </div>`;
                    }
                    let listDoctor = `<div class="list-doctor row m-auto"> ${html} </div>`;
                    let showMedicine = ` <div class="d-flex justify-content-center">
                <div class=" list-title w-100 align-items-center justify-content-between d-flex">
                    <div class="list--doctor p-0">
                        <p>${medicine.name}</p>
                    </div>
                    <div class="ms-auto p-2"><a href="{{route('examination.findmymedicine')}}">See all</a></div>
                </div>
                </div>`;
                    let allHtml = showMedicine + listDoctor;
                    $('#list-find-my-medicine').empty().append(allHtml);
                }

                async function callListDoctorByDepartment(department) {
                    let url = `{{route('restapi.get.products.medicines.category', ['id' => ':id'])}}/?size=4`;
                    url = url.replace(':id', department['id']);
                    await $.ajax({
                        url: url,
                        method: 'GET',
                        success: function (response) {
                            showListMedicineByCategory(response, department);
                        },
                        error: function (exception) {
                            console.log(exception)
                        }
                    });
                }

                var mySwiper = new Swiper('.swiper-container', {
                    loop: true,
                    nextButton: '.swiper-button-next',
                    prevButton: '.swiper-button-prev',
                    slidesPerView: 3,
                    paginationClickable: true,
                    spaceBetween: 20,
                    breakpoints: {
                        1920: {
                            slidesPerView: 4,
                            spaceBetween: 20
                        },
                        1028: {
                            slidesPerView: 3,
                            spaceBetween: 20
                        },
                        480: {
                            slidesPerView: 2,
                            spaceBetween: 10
                        }
                    }
                });
            })

            function submitForm() {
                document.getElementById('searchForm').submit();
            }

            $(document).ready(function () {
                $('.frame.component-medicine .frame-wrapper-heart').on('click', function () {
                    $(this).find('i').toggleClass('bi-heart');
                    $(this).find('i').toggleClass('bi-heart-fill');
                })
            });

            async function handleAddMedicineToWishList(id) {
                loadingMasterPage();
                let headers = {
                    'Authorization': `Bearer ${token}`
                };

                let user_id = `{{ Auth::user()->id ?? ''}}`;
                let url = `{{ route('api.backend.wish.lists.medical.update') }}`;

                let data = new FormData();
                data.append('user_id', user_id);
                data.append('product_id', id);
                data.append('product_type', `{{ \App\Enums\TypeProductCart::MEDICINE }}`);
                data.append('_token', '{{ csrf_token() }}');

                try {
                   await $.ajax({
                        url: url,
                        method: 'POST',
                        headers: headers,
                        contentType: false,
                        cache: false,
                        processData: false,
                        data: data,
                        success: function (response) {
                            let heartIcon = $('#heart-icon-' + id);
                            if (response.isFavourite == true) {
                                heartIcon.removeClass('bi-heart')
                                heartIcon.addClass('bi-heart-fill');
                            } else {
                                heartIcon.removeClass('bi-heart-fill');
                                heartIcon.addClass('bi-heart');
                            }
                            loadingMasterPage();
                        },
                        error: function (exception) {
                            loadingMasterPage();
                            alert('Create error!')
                        }
                    });
                } catch (error) {
                    loadingMasterPage();
                    alert('Error, Please try again!')
                }
            }

            $(document).ready(function () {
                $('.frame.component-doctor .frame-wrapper-heart').on('click', function () {
                    $(this).find('i').toggleClass('bi-heart');
                    $(this).find('i').toggleClass('bi-heart-fill');
                })
            });

            function handleAddToWishList(id, type) {

                let headers = {
                    'Authorization': `Bearer ${token}`
                };

                let user_id = `{{ Auth::user()->id ?? ''}}`;

                let url = `{{ route('api.backend.medical.favourites.update.wishlist') }}`;

                let data = new FormData();
                data.append('user_id', user_id);
                data.append('medical_id', id);
                data.append('medical_type', type);

                try {
                    $.ajax({
                        url: url,
                        method: 'POST',
                        headers: headers,
                        contentType: false,
                        cache: false,
                        processData: false,
                        data: data,
                        success: function (response) {
                            console.log(response)
                        },
                        error: function (exception) {
                        }
                    });
                } catch (error) {
                    throw error;
                }

            }
        </script>
    </div>
@endsection

