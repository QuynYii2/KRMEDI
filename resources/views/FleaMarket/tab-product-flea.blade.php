<link href="{{ asset('css/tabproductflea.css') }}" rel="stylesheet">
<div class="img-union"><img src="{{asset('img/flea-market/platinum.png')}}" alt=""></div>
<div class="page d-flex flex-wrap" id="productsAdsPlan1"></div>
<div class="img-union "><img src="{{asset('img/flea-market/premium.png')}}" alt=""></div>
<div class="page d-flex flex-wrap" id="productsAdsPlan2"></div>
<div class="img-union"><img src="{{asset('img/flea-market/silver.png')}}" alt=""></div>
<div class="page d-flex flex-wrap" id="productsAdsPlan3"></div>
<script>

    function isLogin() {
        if (token == 'undefined') {
            $('#staticBackdrop').modal('show');
        }
    }

    function addProductToWishList(id) {
        isLogin();
        let productId = id;
        let userId = `{{ Auth::check() ? Auth::user()->id : null }}`;
        if (userId) {
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
                    if (response.isFavorite == true) {
                        item.removeClass('bi-heart');
                        item.addClass('bi-heart-fill');
                        alert('Add product to wish list success');
                    } else {
                        item.addClass('bi-heart');
                        item.removeClass('bi-heart-fill');
                        alert('Remove product from wish list success');
                    }
                },
                error: function (exception) {
                }
            });
        } else {
            $('#staticBackdrop').modal('show');
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
            let accessToken = `Bearer ` + token;
            await $.ajax({
                url: `{{route('backend.products.list')}}`+'?user_id={{$id}}',
                method: 'GET',
                headers: {
                    "Authorization": accessToken
                },
                success: function (response) {
                    renderProduct(response);
                },
                error: function (exception) {
                    console.log(exception)
                }
            });
        }

        async function renderProduct(res) {
            var productsAdsPlan1 = [];
            var productsAdsPlan2 = [];
            var productsAdsPlan3 = [];

            for (let i = 0; i < res.length; i++) {
                let url = `{{ route('flea.market.product.detail', ['id' => ':id']) }}`;
                url = url.replace(':id', res[i].id);
                let item = res[i];
                let adsPlan = item.ads_plan;
                let userId = `{{ Auth::check() ? Auth::user()->id : null }}`;
                if (userId == item.created_by) {
                    continue;
                }
                if (adsPlan === 1) {
                    productsAdsPlan1.push(item);
                } else if (adsPlan === 2) {
                    productsAdsPlan2.push(item);
                } else if (adsPlan === 3) {
                    productsAdsPlan3.push(item);
                }

                let isFavorite = item.isFavorit ? 'bi-heart-fill' : 'bi-heart';

                var html = `
                    <div class="col-md-4 col-6">
                        <div class="product-item">
                             <div class="img-pro justify-content-center d-flex img_product--homeNew">
                                  <img src="${item.thumbnail}" alt="">
                                      <i id="icon-heart-${item.id}" class="${isFavorite} bi p-2" data-product-id="${item.id}" onclick="addProductToWishList(${item.id})"></i>
                                  </div>
                             <div class="content-pro p-md-3 p-2">
                             <div class="">
                                 <div class="name-product" style="min-height: 48px">
                                     <a class="name-product--fleaMarket"
                                     href="${url}">
                                     @if(locationHelper() == 'vi')
                                        ${item.name}
                                    @else
                                        ${item.name_en}
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
                                </svg> &nbsp; ${item.location_name ?? 'Toàn quốc'}
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
                    const formattedAmount = amount.toString().replace(/,/g, '.');
                    return parseFloat(formattedAmount).toLocaleString('de-DE');
                }
                if (adsPlan === 1) {
                    $('#productsAdsPlan1').append(html);
                } else if (adsPlan === 2) {
                    $('#productsAdsPlan2').append(html);
                } else if (adsPlan === 3) {
                    $('#productsAdsPlan3').append(html);
                }
            }
        }
    });
</script>
