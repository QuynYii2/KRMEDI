@php use App\Enums\online_medicine\FilterOnlineMedicine;use App\Enums\online_medicine\ObjectOnlineMedicine;use App\Http\Controllers\MainController;use App\Models\User;use Illuminate\Support\Facades\Auth; @endphp

<link rel="stylesheet" href="{{asset('css/clinics-style.css')}}">

<style>
    .background-img-clinic-mobile {
        background: url(../img/homeNew-img/background/image_31.png) no-repeat;
        background-size: 100%;
        min-height: 200px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .shopping-bag {
        margin-right: 0;
        height: 100%;
        width: 100%;
        position: relative;
        background: rgba(247, 247, 247, 1);
        border-radius: 8px;
        display: flex;
        justify-content: center;
        align-items: center;
        border: none;

        &:focus {
            border: none;
        }
    }
</style>
<div class="d-block d-sm-none background-img-clinic-mobile">

</div>
<div class="container mt-3 d-block d-sm-none" id="header-what-free">
    <div class="row">
        <div class="col-10">
            <div class=" medicine-search ">
                <div class="medicine-search--center ">
                    <form class="search-box">
                        <input type="search" name="focus"
                               placeholder="{{ __('home.Search for anything…') }}" id="search-input" value="">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </form>
                </div>
            </div>
        </div>
        <a class="col-2">
            <button type="button"
                    class="btnModalCart shopping-bag"  data-bs-toggle="offcanvas"
                    data-bs-target="#filterNavbar">
                <i class="bi bi-filter"></i>
            </button>
        </a>
    </div>
</div>

<div class="background-image_Clinics mb-5 d-none d-sm-flex">
    <div class="container">
        <div class=" justify-content-center align-items-center mb-5 d-none d-sm-flex">
            <div class="title-list-clinic">{{__('home.Y tế gần bạn')}}</div>
        </div>
        <div class=" medicine-search d-block d-sm-none">
            <div class="medicine-search--center row">
                <form class="search-box col-12">
                    <input type="search" name="focus"
                           placeholder="{{ __('home.Search for anything…') }}" id="search-input" value="">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </form>
            </div>
        </div>
        <div class="border-search-clinics d-none d-sm-flex">
            <div class="col-md-12 p-0">
                <label for="search_input_clinics" class="label-input-clinic">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                              d="M14.8571 7.42857C14.8571 3.32588 11.5313 0 7.42857 0C3.32588 0 0 3.32588 0 7.42857C0 11.5313 3.32588 14.8571 7.42857 14.8571C9.26857 14.8571 10.96 14.1829 12.2629 13.0743L12.5714 13.3829V14.2857L18.2857 20L20 18.2857L14.2857 12.5714H13.3829L13.0743 12.2629C14.1829 10.96 14.8571 9.26857 14.8571 7.42857ZM2.28571 7.42857C2.28571 4.57143 4.57143 2.28571 7.42857 2.28571C10.2857 2.28571 12.5714 4.57143 12.5714 7.42857C12.5714 10.2857 10.2857 12.5714 7.42857 12.5714C4.57143 12.5714 2.28571 10.2857 2.28571 7.42857Z"
                              fill="black"/>
                    </svg>
                </label>
                <input class="m-0 form-select" type="search" name="focus" onkeypress="processSearchClinics();"
                       placeholder="{{ __('home.Search for anything…') }}"
                       id="search_input_clinics" value="">
            </div>
            <div class="col-md-12 p-0 d-flex">
                <div class="col-md-5 pl-0">
                    <select class="form-select_clinics" aria-label="Default select example" id="clinic_specialist">
                        <option selected>{{__('home.Select specialist')}}</option>
                    </select>
                </div>
                <div class="col-md-5">
                    <select class="form-select_clinics" aria-label="Default select example" id="clinic_location">
                        <option selected>{{__('home.Select location')}}</option>
                    </select>
                </div>
                <div class="col-md-2 d-flex justify-content-between pr-0">
                    <a href="">
                        <div class="reset-button">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                 fill="none">
                                <path
                                    d="M2 14C2 14 2.12132 14.8492 5.63604 18.364C9.15076 21.8787 14.8492 21.8787 18.364 18.364C19.6092 17.1187 20.4133 15.5993 20.7762 14M2 14V20M2 14H8M22 10C22 10 21.8787 9.15076 18.364 5.63604C14.8492 2.12132 9.15076 2.12132 5.63604 5.63604C4.39076 6.88131 3.58669 8.40072 3.22383 10M22 10V4M22 10H16"
                                    stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </div>
                    </a>
                    <div class="search-button--clinics col-md-8 p-0" id="btnSearchClinics" style="cursor: pointer">
                        {{__('home.Tìm kiếm')}}
                    </div>
                </div>
            </div>
        </div>

    </div>

</div>

<div class="offcanvas offcanvas-end" tabindex="-1" id="filterNavbar" aria-labelledby="offcanvasNavbarLabel">
    <div class="offcanvas-header">
        <a href="{{route('home')}}" class="offcanvas-title" id="offcanvasNavbarLabel"><img loading="lazy" class="w-100"
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
                        <div class="text-all">{{ __('home.All') }}</div>
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
                <a  class="add-cv-bt w-100 apply-bt_delete col-6">{{ __('home.Refresh') }}</a>
                <form  class="col-6 pr-0">
                    <button type="button" data-bs-dismiss="offcanvas" aria-label="Close"
                            class="add-cv-bt apply-bt_edit w-100">{{ __('home.Apply') }}</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    let accessToken = `Bearer ` + token;

    $(document).ready(function () {
        $('#btnSearchClinics').click(function () {
            searchClinics();
        })

        $('#clinic_specialist').change(function () {
            searchClinics();
        })

        $('#clinic_location').change(function () {
            searchClinics();
        })

        loadSpecialist();
        loadLocation();
    })

    async function processSearchClinics() {
        if (event.keyCode === 13 && !event.shiftKey) {
            await searchClinics();
        }
    }

    async function searchClinics() {
        loadingMasterPage();
        let urlSearch = `{{route('clinics.restapi.search')}}`;

        let search_input_clinics = document.getElementById('search_input_clinics').value;
        let clinic_specialist = document.getElementById('clinic_specialist').value;
        let clinic_location = document.getElementById('clinic_location').value;

        urlSearch = urlSearch + `?search_input_clinics=${search_input_clinics}&clinic_specialist=${clinic_specialist}&clinic_location=${clinic_location}`;

        await $.ajax({
            url: urlSearch,
            method: 'GET',
            headers: {
                "Authorization": accessToken
            },
            success: function (response) {
                renderClinics(response);
                setTimeout(() => {
                    loadingMasterPage();
                }, '500');
            },
            error: function (exception) {
                console.log(exception)
                setTimeout(() => {
                    loadingMasterPage();
                }, '500');
            }
        });
    }

    function renderClinics(response) {
        console.log(response);
        let html = ``;
        for (let i = 0; i < response.length; i++) {
            let data = response[i];

            let urlDetail = "{{ route('clinic.detail', ['id' => ':id']) }}".replace(':id', data.id);

            let img = '';
            let gallery = data.gallery;
            let arrayGallery = gallery.split(',');
            img += `<img loading="lazy" class="mr-2 img-item1" src="${arrayGallery[0]}" alt="">`;


            let openDate = new Date(data.open_date);
            let closeDate = new Date(data.close_date);
            let open = openDate.getHours() + ":" + openDate.getMinutes();
            let close = closeDate.getHours() + ":" + closeDate.getMinutes();

            html += `
                    <div class="specialList-clinics col-md-6 mt-5">
                        <a href="${urlDetail}">
                            <div class="border-specialList">
                                 <div class="content__item d-flex gap-3">
                                      <div class="specialList-clinics--img">
                                           ${img}
                                      </div>
                                      <div class="specialList-clinics--main w-100">
                                           <div class="title-specialList-clinics">
                                                ${data.name}
                                           </div>
                                      <div class="address-specialList-clinics">
                                 <div class="d-flex align-items-center address-clinics">
                                      <i class="fas fa-map-marker-alt mr-2"></i>
                                      <div>${data.address_detail} ${data.addressInfo}</div>
                                 </div>
                            </div>
                            <div class="time-working">
                                 <span class="color-timeWorking">
                                    <span class="fs-14 font-weight-600">${open} - ${close}</span>
                                    </span>
                            </div>
                            </div>
                            </div>
                            </div>
                        </a>
                    </div>
                    `;
        }
        let main = `<div class="row">${html}</div>`
        $('#listClinics').empty().append(main);
    }

    async function loadSpecialist() {
        let urlList = `{{ route('clinics.restapi.specialist') }}`;

        await $.ajax({
            url: urlList,
            method: 'GET',
            headers: {
                "Authorization": accessToken
            },
            success: function (response) {
                renderSpecialist(response);
            },
            error: function (exception) {
                console.log(exception)
            }
        });
    }

    function renderSpecialist(response) {
        console.log(response);
        let html = `<option value="">{{__('home.Select specialist')}}</option>`;
        for (let i = 0; i < response.length; i++) {
            let data = response[i];

            html += `<option value="${data.representative_doctor}">${data.name}</option>`;
        }
        $('#clinic_specialist').empty().append(html);
    }

    async function loadLocation() {
        let urlList = `{{ route('restapi.get.provinces') }}`;

        let accessToken = `Bearer ` + token;
        await $.ajax({
            url: urlList,
            method: 'GET',
            headers: {
                "Authorization": accessToken
            },
            success: function (response) {
                renderLocation(response);
            },
            error: function (exception) {
                console.log(exception)
            }
        });
    }

    function renderLocation(response) {
        let html = `<option value="">{{__('home.Select location')}}</option>`;
        for (let i = 0; i < response.length; i++) {
            let data = response[i];

            html += `<option value="${data.name}">${data.full_name}</option>`;
        }
        $('#clinic_location').empty().append(html);
    }
</script>
