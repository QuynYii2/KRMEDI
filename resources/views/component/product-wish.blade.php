<link rel="stylesheet" href="{{asset('css/fleaMarketWishList.css')}}">

<div class="page row" id="listWishList">
</div>
<script>
    function addProductToWishList() {
        let productId = $(event.target).data('product-id');
        let userId = {{ Auth::check() ? Auth::user()->id : null }};
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
                    location.reload();
                    alert('remove product to wish list success')
                },
                error: function (exception) {
                }
            });
        }
    }

    $(document).ready(function () {
        callListProduct(token);

        async function callListProduct(token) {
            let accessToken = `Bearer ` + token;
            $.ajax({
                url: `{{ route('api.backend.wish.lists.list') }}`,
                method: 'GET',
                headers: {
                    "Authorization": accessToken
                },
                data: {
                    user_id: {{ Auth::check() ? Auth::user()->id : null }}
                },
                success: function (response) {
                    renderWishList(response);
                },
                error: function (exception) {
                    console.log(exception);
                }
            });
        }

        async function renderWishList(res) {
            let html = ``;
            for (let i = 0; i < res.length; i++) {
                let product = res[i];
                let url = `{{ route('flea.market.product.detail', ['id' => ':id']) }}`.replace(':id', product.id);
                html += `
                        <div class="col-md-3 col-6">
                            <div class="product-item">
                                <div class="img-pro img-pro-wishList2">
                                    <img loading="lazy" class="b-radius-8px" src="${product.thumbnail}" alt="">
                                    <a class="button-heart" data-favorite="0">
                                        <i id="bi-heart" class="bi bi-heart-fill" style="color: red;" data-product-id="${product.id}" onclick="addProductToWishList()"></i>
                                    </a>
                                </div>
                                <div class="content-pro content-pro-wishList2">
                                    <div class="name-pro">
                                        <a href="${url}">${product.name}</a>
                                    </div>
                                    <div class="location-pro d-flex">
                                        {{ __('home.Location') }}: <p>${product.province_id}</p>
                                    </div>
                                    <div class="price-pro">
                                        ${product.price} ${product.price_unit}
                                    </div>
                                </div>
                            </div>
                        </div>
                 `;
            }
            $('#listWishList').empty().append(html);
        }
    });
</script>
