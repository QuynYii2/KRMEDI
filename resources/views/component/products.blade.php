@php
    $isFavourite = \App\Models\WishList::where([
                ['user_id', '=', Auth::user()->id ?? ''],
                ['product_id', '=', $medicine->id],
                ['type_product', '=', \App\Enums\TypeProductCart::MEDICINE],
            ])->first();

            $heart = 'bi-heart d-flex';
            if ($isFavourite == true){
                $heart = 'bi-heart-fill d-flex';
            }
            $isSoldOut = $medicine->quantity == 0;

@endphp
<style>
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
    .contact_doctor{
        background: #ff5d4b;
        padding: 4px 10px;
        border-radius: 8px;
        color: #f0f0f0;
        width: fit-content;
        cursor: pointer;
    }
</style>
<div class="product-item {{ $isSoldOut ? 'sold-out-overlay' : '' }}">
    <div class="img-pro">
        <img src="{{asset($medicine->thumbnail)}}" alt="">
        <div class="{{ $isSoldOut ? 'sold-out-overlay-text d-flex justify-content-center align-items-center w-100' : 'd-none' }} ">
            <h1 class="sold-out fs-32px">{{__('home.Sold Out')}}</h1>
        </div>
        <a class="button-heart" data-favorite="0">
            <i id="heart-icon-{{$medicine->id}}" class="{{$heart}} bi" data-product-id="{{$medicine->id}}"
               onclick="handleAddMedicineToWishList({{$medicine->id}})"></i>
        </a>
    </div>

    <div class="content-pro">
        <div class="name-pro">
            <a href="{{route('medicine.detail', $medicine->id)}}">
                @if(locationHelper() == 'vi')
                    {{ $medicine->name }}
                @else
                    {{ $medicine->name_en }}
                @endif

            </a>
        </div>
        <div class="location-pro d-flex align-items-center justify-content-between">
            <div class="d-flex">
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
                </svg> <p>{{ $medicine->location_name ??  __('home.Toàn quốc') }}</p>
            </div>
            <div class="distance-pro" data-lat="{{ $medicine->latitude }}" data-lng="{{ $medicine->longitude }}"></div>
        </div>
        @if($medicine->type_product == 0)
        <div class="price-pro">
            {{ number_format($medicine->price, 0, ',', '.') }} {{ $medicine->unit_price ?? 'VND' }}
        </div>
            @else
            <div class="contact_doctor" data-mail="{{$medicine->email}}" data-id="{{$medicine->user_id}}">
                Tư vấn
            </div>
        @endif
    </div>
    <div class="d-flex justify-content-end">
        <div class="SeeDetail">
            <a href="{{route('medicine.detail', $medicine->id)}}" target="_blank">{{ __('home.See details') }}</a>
        </div>
    </div>
</div>


<script>
    $(document).ready(function () {
        $('#button-heart').on('click', function () {
            $('#bi-heart').addClass('d-none')
            $('#bi-heart-fill').removeClass('d-none')
        })

        $('#button-heart-fill').on('click', function () {
            $('#bi-heart').removeClass('d-none')
            $('#bi-heart-fill').addClass('d-none')
        })
    })

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
        data.append('_token', '{{ csrf_token() }}');
        data.append('product_type', `{{ \App\Enums\TypeProductCart::MEDICINE }}`);
        if (user_id == '') {
            alert('Bạn cần đăng nhập để thực hiện chức năng này')
            return;
        }

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

    function getCurrentLocation(callback) {
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
    function toRadians(degrees) {
        return degrees * (Math.PI / 180);
    }
    function calculateDistance(lat1, lng1, lat2, lng2) {
        var R = 6371; // Radius of the earth in km
        var dLat = toRadians(lat2 - lat1);
        var dLng = toRadians(lng2 - lng1);

        var a = Math.sin(dLat / 2) * Math.sin(dLat / 2) +
            Math.cos(toRadians(lat1)) * Math.cos(toRadians(lat2)) *
            Math.sin(dLng / 2) * Math.sin(dLng / 2);

        var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));

        return R * c;
    }

    getCurrentLocation(function (currentLocation) {
        var distanceProElements = document.querySelectorAll('.distance-pro');
        var itemsWithDistances = [];

        distanceProElements.forEach(function (distancePro) {
            var lat = parseFloat(distancePro.getAttribute('data-lat'));
            var lng = parseFloat(distancePro.getAttribute('data-lng'));
            var distance = calculateDistance(currentLocation.lat, currentLocation.lng, lat, lng).toFixed(2);

            distancePro.innerHTML = `${distance} km`;

            // Store the product-item element along with its distance
            itemsWithDistances.push({
                element: distancePro.closest('.box-sp-medicine'),
                distance: parseFloat(distance)
            });
        });

        itemsWithDistances = itemsWithDistances.filter(item => item.element !== null);
        // Sort the array by distance
        itemsWithDistances.sort(function (a, b) {
            return a.distance - b.distance;
        });

        var container = document.querySelector('#content-medicine');

        itemsWithDistances.forEach(function (item) {
            container.appendChild(item.element);
        });
    });
</script>
<script src="{{asset('js/send-mess.js')}}" type="module"></script>
