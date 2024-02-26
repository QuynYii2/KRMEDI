@extends('layouts.master')
@section('title', 'Result Detail')
@section('content')
    @include('layouts.partials.header')
    @include('component.banner')
    <style>

    </style>
    <div class="container">
        <h1>{{ __('home.Result Detail') }}</h1>
        <div id="nameResult">

        </div>
        <h1>Suggest medicine</h1>
        <div class="row" id="resultBookingDetail">

        </div>
    </div>
    <script>
        let medicine_favourites = `{{ $medicine_favourites }}`;
        let accessToken = `Bearer ` + token;
        $(document).ready(function () {
            callListProduct();
        });
        async function callListProduct() {
            await $.ajax({
                url: `{{route('restapi.booking.result.list.medicine',$resultBooking->id)}}`,
                method: 'GET',
                headers: {
                    "Authorization": accessToken
                },
                success: function (response) {
                    renderMedicine(response);
                },
                error: function (exception) {
                    console.log(exception)
                }
            });
        }

        async function renderMedicine(response) {
            let html = ``;
            let nameResult = ``;
            for (let i = 0; i < response.length; i++) {
                let data = response[i];
                let isFavoriteClass = isUserWasWishlist(data.id);
                let reviewDetailUrl = `{{ route('medicine.detail', ['id'=>':id']) }}`;
                reviewDetailUrl = reviewDetailUrl.replace(':id', data.id);

                html = html + `
                    <div class="col-md-3 col-12">
                        <div class="p-3">
                             <div class="product-item">
                                  <div class="img-pro h-100 justify-content-center d-flex img_product--homeNew">
                                       <img src="${data.thumbnail}" alt="">
                                       <a class="button-heart" data-favorite="0">
                                            <i id="heart-icon-${data.id}" class="${isFavoriteClass} bi" data-product-id="${data.id}"
                                                       onclick="handleAddMedicineToWishList(${data.id})"></i>
                                       </a>
                                  </div>
                                  <div class="content-pro p-3">
                                       <div class="">
                                           <div class="name-product" style="height: auto">
                                               <a class="name-product--fleaMarket" href="${reviewDetailUrl}">${data.name}</a>
                                           </div>
                                            <div class="prices-pro">
                                            ${formatCurrency(data.price)} ${data.price_unit ?? 'VND'}
                                            </div>
                                     </div>
                                </div>
                                <div class="d-flex justify-content-end">
                                    <div class="SeeDetail">
                                        <a href="${reviewDetailUrl}" target="_blank">{{ __('home.See details') }}</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


            `;

                function formatCurrency(amount) {
                    const formattedAmount = amount.toString().replace(/,/g, '.');

                    return parseFloat(formattedAmount).toLocaleString('de-DE');
                }

                nameResult = nameResult + '-' + data.name + '<br> ' + `<div class="p-2"><h4>{{ __('home.ingredient') }}</h4> <div class="pl-3">${data.description}</div> </div>`;
            }
            await $('#resultBookingDetail').empty().append(html);
            await $('#nameResult').empty().append(nameResult);
        }

        function isUserWasWishlist(medicineId) {
            let isLogin = `{{ Auth::check() }}`;
            if (!isLogin) {
                return 'bi-heart';
            }

            if (medicine_favourites.includes(medicineId)) {
                return 'bi-heart-fill';
            }
            return 'bi-heart';
        }
    </script>
    <script>

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
    </script>
@endsection

