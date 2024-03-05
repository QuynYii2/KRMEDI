@extends('layouts.admin')
@section('title')
    My Product Favourite
@endsection
<style>
    .product-item {
        border: 1px solid #ccc;
    }

    .product-image {
        max-width: 100%;
        object-fit: cover;
        height: auto;
    }

    .product-name {
        font-size: 24px;
        font-weight: 600;
        display: -webkit-box;
        line-height: 1.3;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .product-price {
        font-size: 20px;
        font-weight: 600;
    }
</style>
@section('main-content')
    <h3 class="text-center">My Product Favourite</h3>
    <br>
    <div class="container-fluid">
        <ul class="nav nav-tabs" id="myTabOrder" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="flea_market_tab" data-bs-toggle="tab"
                        data-bs-target="#product_flea_market"
                        type="button" role="tab" aria-controls="product_flea_market" aria-selected="true">
                    Product Flea Market
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="medicine_tab" data-bs-toggle="tab" data-bs-target="#product_medicine"
                        type="button" role="tab" aria-controls="product_medicine" aria-selected="false">
                    Product Medicine
                </button>
            </li>
        </ul>
        <div class="tab-content" id="myTabOrderContent">
            <div class="tab-pane fade show active" id="product_flea_market" role="tabpanel"
                 aria-labelledby="flea_market_tab">
                <div class="list-products row mt-3 product_flea_market">

                </div>
            </div>
            <div class="tab-pane fade" id="product_medicine" role="tabpanel" aria-labelledby="medicine_tab">
                <div class="list-products row mt-3 product_medicine">

                </div>
            </div>
        </div>
    </div>

    <script>
        let accessToken = `Bearer ` + token;
        let headers = {
            'Authorization': accessToken
        };

        $(document).ready(function () {
            loadProduct('FLEA MARKET');

            $('#flea_market_tab').click(function () {
                loadProduct('FLEA MARKET')
            })

            $('#medicine_tab').click(function () {
                loadProduct('MEDICINE')
            })
        })

        async function loadProduct(status) {
            loadingMasterPage();
            let productUrl = `{{ route('api.backend.wish.lists.users') }}`;
            productUrl = productUrl + `?user_id={{ Auth::check() ? Auth::user()->id : '' }}`;
            if (status === 'MEDICINE') {
                productUrl = productUrl + `&type_product=${status}`;
            }

            await $.ajax({
                url: productUrl,
                method: 'GET',
                headers: headers,
                success: function (response) {
                    loadingMasterPage()
                    renderProduct(response, status);
                },
                error: function (error) {
                    loadingMasterPage()
                    console.log(error);
                }
            });
        }

        async function renderProduct(response, status) {
            let html = ``;
            for (let i = 0; i < response.length; i++) {
                let data = response[i];
                html += `<div class="product-item p-1 mt-3 col-md-3 bg-white">
                        <img src="${data.thumbnail}"
                            alt="" class="product-image">
                        <div class="product-info">
                            <div class="product-name">
                                ${data.name}
                            </div>
                            <div class="product-price">
                                ${data.price}
                            </div>
                        </div>
                    </div>`;
            }

            if (status === 'MEDICINE') {
                $('.product_medicine').empty().append(html);
            } else {
                $('.product_flea_market').empty().append(html);
            }
        }
    </script>
@endsection
