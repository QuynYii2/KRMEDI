@php
    use App\Enums\online_medicine\FilterOnlineMedicine;
    use App\Enums\online_medicine\ObjectOnlineMedicine;
    use App\Http\Controllers\MainController;
    use App\Models\User;
    use Illuminate\Support\Facades\Auth;
@endphp

<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" />
<link rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
<link rel="stylesheet" href="{{ asset('css/clinics-style.css') }}">

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

    .address-clinics div {
        display: -webkit-box;
        line-height: 1.3;
        -webkit-line-clamp: 1;
        -webkit-box-orient: vertical;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .title-specialList-clinics {
        color: #000;
        font-size: 24px;
        font-style: normal;
        font-weight: 800;
        display: -webkit-box;
        line-height: 1.3;
        -webkit-line-clamp: 1;
        -webkit-box-orient: vertical;
        overflow: hidden;
        text-overflow: ellipsis;
    }
</style>
<div class="d-block d-sm-none background-img-clinic-mobile">

</div>
<div class="container mt-3 d-block d-sm-none" id="header-what-free">
    <div class="row">
        <div class="col-10">
            <div class=" medicine-search ">
                <div class="medicine-search--center ">
                    <div class="search-box">
                        <input type="search" placeholder="{{ __('home.Search for anything…') }}"
                            onkeyup="mobileProcessSearchClinics();" id="mobile_search_input_clinics" value="">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </div>
                </div>
            </div>
        </div>
        <a class="col-2">
            <button type="button" class="btnModalCart shopping-bag" data-bs-toggle="offcanvas"
                data-bs-target="#filterNavbar">
                <i class="bi bi-filter"></i>
            </button>
        </a>
    </div>
</div>

<div class="background-image_Clinics mb-5 d-none d-sm-flex">
    <div class="container">
        <div class=" justify-content-center align-items-center mb-5 d-none d-sm-flex">
            <div class="title-list-clinic">{{ __('home.Y tế gần bạn') }}</div>
        </div>
        <div class=" medicine-search d-block d-sm-none">
            <div class="medicine-search--center row">
                <div class="search-box col-12">
                    <input type="search" placeholder="{{ __('home.Search for anything…') }}">
                    <i class="fa-solid fa-magnifying-glass d-none"></i>
                </div>
            </div>
        </div>
        <div class="border-search-clinics d-none d-sm-flex">
            <div class="col-md-12 p-0">
                <label for="search_input_clinics" class="label-input-clinic">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20"
                        fill="none">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M14.8571 7.42857C14.8571 3.32588 11.5313 0 7.42857 0C3.32588 0 0 3.32588 0 7.42857C0 11.5313 3.32588 14.8571 7.42857 14.8571C9.26857 14.8571 10.96 14.1829 12.2629 13.0743L12.5714 13.3829V14.2857L18.2857 20L20 18.2857L14.2857 12.5714H13.3829L13.0743 12.2629C14.1829 10.96 14.8571 9.26857 14.8571 7.42857ZM2.28571 7.42857C2.28571 4.57143 4.57143 2.28571 7.42857 2.28571C10.2857 2.28571 12.5714 4.57143 12.5714 7.42857C12.5714 10.2857 10.2857 12.5714 7.42857 12.5714C4.57143 12.5714 2.28571 10.2857 2.28571 7.42857Z"
                            fill="black" />
                    </svg>
                </label>
                <input class="m-0 form-select" type="search" name="focus" onkeyup="processSearchClinics();"
                    placeholder="{{ __('home.Search for anything…') }}" id="search_input_clinics" value="">
            </div>
            <div class="col-md-12 p-0 d-flex">
                <div class="col-md-5 pl-0">
                    <select class="form-select_clinics specialist_selector" aria-label="Default select example"
                        id="clinic_specialist">
                        <option selected disabled>Chọn chuyên khoa</option>
                    </select>
                </div>
                <div class="col-md-5">
                    <select class="form-select_clinics symptom_selector" aria-label="Default select example"
                        id="clinic_symptom">
                        <option selected disabled>Chọn triệu chứng</option>
                    </select>
                </div>
                <div class="col-md-2 d-flex justify-content-between pr-0">
                    <a href="">
                        <div class="reset-button">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none">
                                <path
                                    d="M2 14C2 14 2.12132 14.8492 5.63604 18.364C9.15076 21.8787 14.8492 21.8787 18.364 18.364C19.6092 17.1187 20.4133 15.5993 20.7762 14M2 14V20M2 14H8M22 10C22 10 21.8787 9.15076 18.364 5.63604C14.8492 2.12132 9.15076 2.12132 5.63604 5.63604C4.39076 6.88131 3.58669 8.40072 3.22383 10M22 10V4M22 10H16"
                                    stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </div>
                    </a>
                    {{-- <div class="search-button--clinics col-md-8 p-0" id="btnSearchClinics" style="cursor: pointer">
                        {{ __('home.Tìm kiếm') }}
                    </div> --}}
                </div>
            </div>
        </div>

    </div>

</div>

<div class="offcanvas offcanvas-end" tabindex="-1" id="filterNavbar" aria-labelledby="offcanvasNavbarLabel">
    <div class="offcanvas-header">
        <a href="{{ route('home') }}" class="offcanvas-title" id="offcanvasNavbarLabel"><img loading="lazy"
                class="w-100" src="{{ asset('img/icons_logo/logo-new.png') }}"></a>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <div class="col-md-3 medicine-list--filter">
            <div class="filter">
                <div class="filter-header d-flex justify-content-between">
                    <div class="text-wrapper">Lọc theo chuyên khoa</div>
                    <i class="fa-solid fa-chevron-down" id="toggleSpecialist"></i>
                </div>
                <div class="filter-body" id="clinicMobileSpecialist"></div>
            </div>
            <div class="filter">
                <div class="filter-header d-flex justify-content-between">
                    <div class="text-wrapper">Lọc theo triệu chứng</div>
                    <i class="fa-solid fa-chevron-down" id="toggleSymptom"></i>
                </div>
                <div class="filter-body" id="clinicMobileSymptom"></div>
            </div>
            <div class="d-flex justify-content-center mt-4 gap-2">
                <button type="button"
                    class="btn btn-secondary w-100 btnResetMobileFilter">{{ __('home.Reset') }}</button>
                <button id="mobileApplyFilter" type="button" data-bs-dismiss="offcanvas" aria-label="Close"
                    class="btn btn-info w-100">{{ __('home.Apply') }}</button>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#btnSearchClinics').click(function() {
            searchClinics();
        })

        $('#clinic_specialist').change(function() {
            searchClinics();
        })

        $('#clinic_symptom').change(function() {
            searchClinics();
        })

        loadSpecialist();
        loadSymptom();
    })

    async function processSearchClinics() {
        //Enter press
        if (event.keyCode == 13) {
            await searchClinics();
        }
    }

    async function searchClinics() {
        // loadingMasterPage();
        let urlSearch = `{{ route('clinics.restapi.search') }}`;

        let search_input_clinics = document.getElementById('search_input_clinics').value;
        let clinic_specialist = document.getElementById('clinic_specialist').value;
        let clinic_symptom = document.getElementById('clinic_symptom').value;

        urlSearch = urlSearch +
            `?search_input_clinics=${search_input_clinics}&clinic_specialist=${clinic_specialist}&clinic_symptom=${clinic_symptom}`;

        await $.ajax({
            url: urlSearch,
            method: 'GET',
            headers: {
                "Authorization": accessToken
            },
            success: function(response) {
                mapClinic(response);
                // renderSearchClinics(response);
                // setTimeout(() => {
                //     loadingMasterPage();
                // }, '500');
            },
            error: function(exception) {
                console.log(exception)
                setTimeout(() => {
                    loadingMasterPage();
                }, '500');
            }
        });
    }

    function renderSearchClinics(response) {
        console.log(response)
        getCurrentLocation(function(currentLocation) {
            let html = `
                <div class="clinics-header row">
                    <div class=" d-flex justify-content-between">
                        <span class="fs-32px">Phòng khám gần bạn</span>
                        <span>
                        </span>
                    </div>
                </div>`;
            for (let i = 0; i < response.length; i++) {
                let data = response[i];

                var distance = calculateDistance(
                    currentLocation.lat, currentLocation.lng,
                    parseFloat(data.latitude), parseFloat(data.longitude)
                );
                // Chọn bán kính tìm kiếm (ví dụ: 10 km)
                var searchRadius = 10;
                if (distance >= searchRadius || isNaN(distance)) {
                    continue;
                }

                let urlDetail = "{{ route('clinic.detail', ['id' => ':id']) }}".replace(':id', data.id);

                let img = '';
                let gallery = data.gallery;
                let arrayGallery = gallery.split(',');
                img += `<img loading="lazy" class="mr-2 img-item1" src="${arrayGallery[0]}" alt="">`;

                let openDate = new Date(data.open_date);
                let closeDate = new Date(data.close_date);
                let open = openDate.toLocaleTimeString(undefined, {
                    hour: '2-digit',
                    minute: '2-digit'
                });
                let close = closeDate.toLocaleTimeString(undefined, {
                    hour: '2-digit',
                    minute: '2-digit'
                });

                html += `
                    <div class="specialList-clinics col-md-6 mt-3">
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
                                            <span class="distance">${distance.toFixed(2)} Km</span>
                                        </div>
                                    <div class="d-flex justify-content-between">
                                        <div class="time-working">
                                            <span class="color-timeWorking">
                                                <span class="fs-14 font-weight-600">${open} - ${close}</span>
                                            <span>/ {{ __('home.Dental Clinic') }}</span>
                                            </span>
                                        </div>
                                        @if (Auth::check())
                                            <div class="zalo-follow-only-button" data-callback="userFollowZaloOA" data-oaid="4438562505337240484"></div>
                                        @endif
                                    </div>
                                </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    `;
            }
            if (response.length < 1) {
                html += 'Không có phòng khám nào phù hợp';
            }
            let main = `<div class="row">${html}</div>`
            $('#productInformation').empty();
            $('#listClinics').empty().append(main);
        });
    }

    async function loadSpecialist() {
        let urlList = `{{ route('restapi.departments.list') }}`;

        await $.ajax({
            url: urlList,
            method: 'GET',
            headers: {
                "Authorization": accessToken
            },
            success: function(response) {
                renderSpecialist(response);
                initialSelect2($('.specialist_selector'));
            },
            error: function(exception) {
                console.log(exception)
            }
        });
    }

    function renderSpecialist(response) {
        //DESKTOP
        let html = `<option value="" selected disabled>Chọn chuyên khoa</option>`;
        for (let i = 0; i < response.length; i++) {
            let data = response[i];

            html += `<option value="${data.id}">${data.name}</option>`;
        }
        $('#clinic_specialist').empty().append(html);

        //MOBILE
        let htmlMb = `<div class="d-flex item">
                        <input type="checkbox" name="clinic_specialist" id="selectAllSpecialistMobile" value="all">
                        <div class="text-all">{{ __('home.All') }}</div>
                    </div>`;
        for (let i = 0; i < response.length; i++) {
            let data = response[i];

            let itemClass = (i <= 3) ? 'd-flex' : 'd-none';

            htmlMb += `<div class="${itemClass} item">
                        <input type="checkbox" name="clinic_specialist" value="${data.id}">
                        <div class="text-all">${data.name}</div>
                    </div>`;
        }
        $('#clinicMobileSpecialist').empty().append(htmlMb);

        $('#selectAllSpecialistMobile').change(function() {
            let isChecked = $(this).is(':checked');
            $('input[name="clinic_specialist"]').prop('checked', isChecked);
        });

    }

    async function loadSymptom() {
        let urlList = `{{ route('restapi.symptoms.list') }}`;

        let accessToken = `Bearer ` + token;
        await $.ajax({
            url: urlList,
            method: 'GET',
            headers: {
                "Authorization": accessToken
            },
            success: function(response) {
                renderSymptom(response);
                initialSelect2($('.symptom_selector'));
            },
            error: function(exception) {
                console.log(exception)
            }
        });
    }

    function renderSymptom(response) {
        let html = `<option value="" selected disabled>Chọn triệu chứng</option>`;
        for (let i = 0; i < response.length; i++) {
            let data = response[i];

            html += `<option value="${data.id}">${data.name}</option>`;
        }
        $('#clinic_symptom').empty().append(html);

        //MOBILE
        let htmlMb = `<div class="d-flex item">
                <input type="checkbox" name="clinic_symptom" id="selectAllSymptomMobile" value="all">
                <div class="text-all">{{ __('home.All') }}</div>
            </div>`;
        for (let i = 0; i < response.length; i++) {
            let data = response[i];

            let itemClass = (i <= 3) ? 'd-flex' : 'd-none';

            htmlMb += `<div class="${itemClass} item">
                <input type="checkbox" name="clinic_symptom" value="${data.id}">
                <div class="text-all">${data.name}</div>
            </div>`;
        }
        $('#clinicMobileSymptom').empty().append(htmlMb);

        $('#selectAllSymptomMobile').change(function() {
            let isChecked = $(this).is(':checked');
            $('input[name="clinic_symptom"]').prop('checked', isChecked);
        });
    }

    function initialSelect2(selectElement) {
        selectElement.select2({
            theme: 'bootstrap-5',
            // minimumInputLength: 1, Disabled search
        });
    }
</script>

{{-- MOBILE --}}
<script>
    $('#mobileApplyFilter').click(function() {
        mobileSearchClinics();
    })

    async function mobileProcessSearchClinics() {
        //Enter press
        if (event.keyCode == 13) {
            await mobileSearchClinics();
        }
    }

    async function mobileSearchClinics() {
        loadingMasterPage();
        let urlSearch = `{{ route('clinics.restapi.search') }}`;

        let mobile_search_input_clinics = $('#mobile_search_input_clinics').val();
        let clinic_specialist = $('input[name="clinic_specialist"]:checked').map(function() {
            return $(this).val();
        }).get();
        let clinic_symptom = $('input[name="clinic_symptom"]:checked').map(function() {
            return $(this).val();
        }).get();

        let params = new URLSearchParams();
        params.append('search_input_clinics', mobile_search_input_clinics);
        params.append('mobile_clinic_specialist', clinic_specialist.join(','));
        params.append('mobile_clinic_symptom', clinic_symptom.join(','));

        urlSearch = urlSearch + '?' + params.toString();

        try {
            const response = await $.ajax({
                url: urlSearch,
                method: 'GET',
                headers: {
                    "Authorization": accessToken
                }
            });

            renderSearchClinics(response);
            setTimeout(() => {
                loadingMasterPage();
            }, 500);
        } catch (error) {
            console.log(error);
            setTimeout(() => {
                loadingMasterPage();
            }, 500);
        }
    }
</script>

<script>
    $(document).ready(function() {
        // Toggle the items and change the icon when the button is clicked
        function toggleItems(buttonId) {
            $(buttonId).click(function() {
                $(this).toggleClass('fa-chevron-down fa-chevron-up');
                $(this).parent().next('.filter-body').find('.item:gt(4)').slideToggle(function() {
                    if ($(this).hasClass('d-none')) {
                        $(this).removeClass('d-none').addClass('d-flex').hide().slideDown(
                            'slow');
                    } else {
                        $(this).removeClass('d-flex').addClass('d-none').slideUp('slow');
                    }
                });
            });
        }

        toggleItems('#toggleSpecialist');
        toggleItems('#toggleSymptom');

        $('.btnResetMobileFilter').click(function() {
            $('.medicine-list--filter input[type="checkbox"]').prop('checked', false);
        });
    });
</script>
