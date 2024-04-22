<link rel="stylesheet" href="{{ asset('css/clinics-style.css') }}">
<style>
    .border-specialList {
        border-radius: 16px;
        border: 1px solid #EAEAEA;
        background: #FFF;
        display: flex;
        padding: 16px;
        align-items: flex-start;
        gap: 16px;
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

    .address-clinics {
        color: #929292;
        font-size: 18px;
        font-style: normal;
        font-weight: 600;
        line-height: normal;
    }

    .address-clinics div {
        display: -webkit-box;
        line-height: 1.3;
        -webkit-line-clamp: 1;
        -webkit-box-orient: vertical;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .distance {
        color: #088180;
        font-size: 18px;
        font-style: normal;
        font-weight: 600;
        line-height: normal;
    }

    .time-working {
        font-size: 12px;
        font-style: normal;
        font-weight: 600;
        line-height: normal;
    }

    .color-timeWorking {
        color: #088180;

    }

    .spinner-loading span {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background-color: white;
        animation: flashing 1.4s infinite linear;
        margin: 0 4px;
        display: inline-block;
    }

    .spinner-loading span:nth-child(2) {
        animation-delay: 0.2s;
    }

    .spinner-loading span:nth-child(3) {
        animation-delay: 0.4s;
    }

    @keyframes flashing {
        0% {
            opacity: 0.2;
        }

        20% {
            opacity: 1;
        }

        100% {
            opacity: 0.2;
        }
    }
</style>
<div class="body m-0 d-flex flex-wrap w-100" id="listClinic"></div>
<script>
    $(document).ready(function() {
        callListProduct();

        async function callListProduct() {
            await $.ajax({
                url: `{{ route('clinics.restapi.list') }}`,
                method: 'GET',
                success: function(response) {
                    showSpinner();
                    renderClinics(response);
                    hideSpinner();
                },
                error: function(exception) {
                    console.log(exception)
                }
            });
        }

        async function getCurrentLocation(callback) {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function(position) {
                    var currentLocation = {
                        lat: position.coords.latitude,
                        lng: position.coords.longitude
                    };
                    callback(currentLocation);
                });
            } else {
                alert('Geolocation is not supported by this browser.');
            }
        }

        function calculateDistance(lat1, lng1, lat2, lng2) {
            var R = 6371; // Độ dài trung bình của trái đất trong km
            var dLat = toRadians(lat2 - lat1);
            var dLng = toRadians(lng2 - lng1);

            var a = Math.sin(dLat / 2) * Math.sin(dLat / 2) +
                Math.cos(toRadians(lat1)) * Math.cos(toRadians(lat2)) *
                Math.sin(dLng / 2) * Math.sin(dLng / 2);

            var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));

            var distance = R * c;
            return distance;
        }

        async function renderClinics(res) {
            getCurrentLocation(function(currentLocation) {
                let html = ``;
                const baseUrl = '{{ route('clinic.detail', ['id' => ':id']) }}';
                for (let i = 0; i < res.length; i++) {
                    var distance = calculateDistance(
                        currentLocation.lat, currentLocation.lng,
                        parseFloat(res[i].latitude), parseFloat(res[i].longitude)
                    );
                    console.log(distance, res[i].name)
                    // Chọn bán kính tìm kiếm (ví dụ: 10 km)
                    var searchRadius = 10;
                    if (distance <= searchRadius) {
                        continue;
                    }

                    let item = res[i];
                    let urlDetail = baseUrl.replace(':id', item.id);
                    let gallery = item.gallery;
                    let arrayGallery = gallery.split(',')
                    let img = ``;
                    img += `<img class="mr-2 img-item1" src="${arrayGallery[0]}" alt="">`;
                    // for (let j = 0; j < arrayGallery.length; j++) {
                    //     img = img + `<img class="mr-2 w-auto h-100 img-item1 " src="${arrayGallery[j]}" alt="">`;
                    // }
                    let serviceHtml = ``;
                    let service = item.services;
                    for (let j = 0; j < service.length; j++) {
                        let serviceItem = service[j];
                        serviceHtml = serviceHtml + `<span>${serviceItem.name},</span>`;
                    }
                    let openDate = new Date(item.open_date);
                    let closeDate = new Date(item.close_date);

                    let formattedOpenDate = openDate.toLocaleTimeString(undefined, {
                        hour: '2-digit',
                        minute: '2-digit'
                    });
                    let formattedCloseDate = closeDate.toLocaleTimeString(undefined, {
                        hour: '2-digit',
                        minute: '2-digit'
                    });

                    html = html + `
                        <div class="specialList-clinics col-md-6 mt-3">
                                <a href="${urlDetail}">
                                    <div class="border-specialList">
                                        <div class="content__item d-flex gap-3">
                                            <div class="specialList-clinics--img">
                                                ${img}
                                            </div>
                                            <div class="specialList-clinics--main w-100">
                                                <div class="title-specialList-clinics">
                                                @if (locationHelper() == 'vi')
                                                                ${item.name}
                                                                    @else
                                                                ${item.name_en}
                                                                    @endif
                                                </div>
                                            <div class="address-specialList-clinics">
                                        <div class="d-flex align-items-center address-clinics">
                                            <i class="fas fa-map-marker-alt mr-2"></i>
                                            <div>${item.address_detail} ${item.addressInfo}</div>
                                        </div>
                                            <span class="distance"> >=10Km</span>
                                    </div>
                                    <div class="time-working">
                                        <span class="color-timeWorking">
                                            <span class="fs-14 font-weight-600">${formattedOpenDate} - ${formattedCloseDate}</span>
                                            <span>/ {{ __('home.Dental Clinic') }}</span>
                                            </span>

                                    </div>
                                    </div>
                                    </div>
                                    </div>
                                </a>
                            </div>
                        `;
                }
                $('#listClinic').empty().append(html);
            });
        }

        function showSpinner() {
            const $spinner = $('<div>').addClass('spinner-loading text-center').attr('role', 'status')
                .append($('<span>').text('Loading...'));

            $('#listClinic').append($spinner);
        }

        function hideSpinner() {
            $('.spinner-loading').remove();
        }
    });
</script>
