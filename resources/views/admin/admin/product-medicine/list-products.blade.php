@extends('layouts.admin')
@section('title')
    List Products
@endsection
<style>
    .switch {
        position: relative;
        display: inline-block;
        width: 60px;
        height: 34px;
    }

    .switch input {
        opacity: 0;
        width: 0;
        height: 0;
    }

    .slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #ccc;
        -webkit-transition: .4s;
        transition: .4s;
    }

    .slider:before {
        position: absolute;
        content: "";
        height: 26px;
        width: 26px;
        left: 4px;
        bottom: 4px;
        background-color: white;
        -webkit-transition: .4s;
        transition: .4s;
    }

    input:checked + .slider {
        background-color: #2196F3;
    }

    input:focus + .slider {
        box-shadow: 0 0 1px #2196F3;
    }

    input:checked + .slider:before {
        -webkit-transform: translateX(26px);
        -ms-transform: translateX(26px);
        transform: translateX(26px);
    }

    /* Rounded sliders */
    .slider.round {
        border-radius: 34px;
    }

    .slider.round:before {
        border-radius: 50%;
    }
</style>
@section('main-content')
    <div class="">
        <!-- Page Heading -->
        <h1 class="h3 mb-4 text-gray-800"> Danh sách sản phẩm </h1>
        <div class="mb-3">
            <div class="row w-100">
                <div class="col-md-3 col-6 mb-2">
                    <input class="form-control" id="keyword" type="text" onkeypress="processSearchProduct();"
                           placeholder="{{__('home.Enter name, prescription or ingredients of products')}}"/>
                </div>
                <div class="col-md-3 col-6 mb-2">
                    <select id="inputCountry" class="form-select input_filter">
                        <option value="" selected>Quốc gia sản xuất</option>
                        @if(is_array($array_country))
                            @foreach($array_country as $country)
                                <option value="{{ $country }}">{{ $country }}</option>
                            @endforeach
                        @endif
                    </select>
                </div>
                <div class="col-md-3 col-6 mb-2">
                    <select id="inputCompany" class="form-select input_filter">
                        <option value="" selected>Công ty sản xuất</option>
                        @if(is_array($array_company))
                            @foreach($array_company as $company)
                                <option value="{{ $company }}">{{ $company }}</option>
                            @endforeach
                        @endif
                    </select>
                </div>
                <div class="col-md-3 col-6 mb-2">
                    <select id="inputObject" class="form-select input_filter">
                        <option value="" selected>Đối tượng</option>
                        <option value="1">Cho trẻ em</option>
                        <option value="2">Cho phụ nữ</option>
                        <option value="3">Cho nam giới</option>
                        <option value="4">Cho người lớn</option>
                    </select>
                </div>
                <div class="col-md-3 col-6 mb-2">
                    <select id="inputFilter" class="form-select input_filter">
                        <option value="" selected>Lọc</option>
                        <option value="1">Tất cả</option>
                        <option value="2">Sức khoẻ</option>
                        <option value="3">Sắc đẹp</option>
                        <option value="4">Vật nuôi</option>
                    </select>
                </div>
                <div class="col-md-3 col-6 mb-2">
                    <select id="inputCategory" class="form-select input_filter">
                        <option value="" selected>Danh mục</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3 col-6 mb-2">
                    <select id="inputCondition" class="form-select input_filter">
                        <option value="" selected>Tình trạng sản phẩm</option>
                        <option value="in">Còn hàng</option>
                        <option value="out">Hết hàng</option>
                    </select>
                </div>
                <div class="col-md-3 col-6 mb-2">
                    <select id="inputStatus" class="form-select input_filter">
                        <option value="" selected>Trạng thái</option>
                        <option value="APPROVED">APPROVED</option>
                        <option value="PENDING">PENDING</option>
                    </select>
                </div>
            </div>
        </div>
        <br>
        <div class="row d-flex align-items-center justify-content-end">
            <div class="mb-3 col-md-3">
                <label for="inputSearchProduct">Tìm kiếm</label>
                <input class="form-control" id="inputSearchProduct" type="text" placeholder="Tìm kiếm.."/>
            </div>
            <div class="mb-3 col-md-2">
                <label for="inputPaginate">Trang: <span class="item_quantity">20</span>/mục </label>
                <select class="form-select" id="inputPaginate">
                    <option value="10">10 mục</option>
                    <option selected value="20">20 mục</option>
                    <option value="50">50 mục</option>
                    <option value="100">100 mục</option>
                </select>
            </div>
        </div>
        <br>
        <div class="table-responsive">
            <table class="table text-nowrap " id="tableListProduct">
                <thead>
                <tr>
                    <th scope="col">{{ __('home.STT') }}</th>
                    <th scope="col">{{ __('home.Product name') }}</th>
                    <th scope="col">{{ __('home.Price') }}</th>
                    <th scope="col">{{ __('home.Quantity') }}</th>
                    <th scope="col">{{ __('home.Status') }}</th>
                    <th scope="col">{{ __('home.Action') }}</th>
                </tr>
                </thead>
                <tbody id="tbodyListProduct">
                @foreach($products as $product)
                    <tr>
                        <td> {{ $loop->index + 1 }} </td>
                        <td>
                            @if(locationHelper() == 'vi')
                                {{ $product->name }}
                            @else
                                {{ $product->name_en }}
                            @endif
                        </td>
                        <td> {{ $product->price }} </td>
                        <td> {{ $product->quantity }} </td>
                        <td>
                        <span id="product_status_{{ $product->id }}">
                            {{ $product->status }}
                        </span>
                        </td>
                        <td>
                            <div class="d-flex justify-content-start align-items-center">
                                <div class="w-25 d-flex justify-content-center align-items-center">
                                    <a href="{{ route('api.backend.product-medicine.edit', $product->id) }}"
                                       class="btn btn-success mr-3 ml-3">
                                        <i class="fa-solid fa-eye"></i>
                                    </a>
                                </div>
                                <div class="w-50 d-flex justify-content-center align-items-center">
                                    <label class="switch">
                                        <input type="checkbox" class="product_action"
                                               {{ $product->status == \App\Enums\online_medicine\OnlineMedicineStatus::PENDING ? '' : 'checked'}}
                                               data-product="{{$product->id}}">
                                        <span class="slider round"></span>
                                    </label>
                                </div>
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <script>
        // let accessToken = `Bearer ` + token;
        // let headers = {
        //     'Authorization': accessToken
        // };

        $(document).ready(function () {
            loadPaginate('tableListProduct', 20);
            searchMain('inputSearchProduct', 'tableListProduct');

            $('.product_action').click(function () {
                let product = $(this).data('product');
                changeStatus(product);
            });

            $('.input_filter').change(function () {
                searchProduct();
            });

            changePaginate();
        })

        async function processSearchProduct() {
            if (event.keyCode === 13 && !event.shiftKey) {
                await searchProduct();
            }
        }

        async function searchProduct() {
            let search_url = await renderUrlSearch();
            await callSearchProduct(search_url);
            await changePaginate();
        }

        async function renderUrlSearch() {
            let keyword = $('#keyword').val();
            let filter = $('#inputFilter').val();
            let object = $('#inputObject').val();
            let country = $('#inputCountry').val();
            let company = $('#inputCompany').val();
            let category = $('#inputCategory').val();
            let stock = $('#inputCondition').val();
            let status = $('#inputStatus').val();

            let search_url = `{{ route('api.admin.products.medicine.search') }}`;

            let keyword_url = `keyword=${keyword}`;
            let filter_url = `filter=${filter}`;
            let object_url = `object=${object}`;
            let country_url = `country=${country}`;
            let company_url = `company=${company}`;
            let category_url = `category=${category}`;
            let stock_url = `stock=${stock}`;
            let status_url = `status=${status}`;

            search_url = search_url + `?${keyword_url}&${filter_url}&${object_url}&${country_url}&${company_url}&${category_url}&${stock_url}&${status_url}`;

            return search_url;
        }

        async function changePaginate() {
            $('#inputPaginate').change(function () {
                let number = $(this).val();
                loadPaginate('tableListProduct', number);
                $('.item_quantity').text(number)
            });
        }

        async function callSearchProduct(search_url) {
            $('.pager').remove();
            loadingMasterPage();

            await $.ajax({
                url: search_url,
                method: 'GET',
                headers: headers,
                success: function (response) {
                    loadingMasterPage();
                    renderProductFilter(response);
                },
                error: function (xhr, status, exception) {
                    loadingMasterPage();
                    alert(xhr.responseJSON.message);
                }
            });
        }

        async function filterProduct(stock, status) {
            $('.pager').remove();
            loadingMasterPage();
            let filter_url = `{{ route('api.admin.products.medicine.filter') }}` + `?stock=${stock}&status=${status}`;

            await $.ajax({
                url: filter_url,
                method: 'GET',
                headers: headers,
                success: function (response) {
                    loadingMasterPage();
                    renderProductFilter(response);
                },
                error: function (xhr, status, exception) {
                    loadingMasterPage();
                    alert(xhr.responseJSON.message);
                }
            });
        }

        function renderProductFilter(response) {
            let checked = null;
            let html = ``;
            let total = response.length;
            for (let i = 0; i < total; i++) {
                let product = response[i];

                checked = '';
                if (product.status === 'APPROVED') {
                    checked = 'checked';
                } else {
                    checked = '';
                }

                let url_detail = `{{ route('api.backend.product-medicine.edit', ['id'=>':id']) }}`;
                url_detail = url_detail.replace(':id', product.id);

                html += ` <tr>
                    <td> ${i + 1} </td>
                    <td> ${product.name} </td>
                    <td> ${product.price} </td>
                    <td> ${product.quantity} </td>
                    <td>
                        <span id="product_status_${product.id}">
                            ${product.status}
                </span>
            </td>
            <td>
                <div class="d-flex justify-content-start align-items-center">
                    <div class="w-25 d-flex justify-content-center align-items-center">
                        <a href="${url_detail}"
                                   class="btn btn-success mr-3 ml-3">
                                    <i class="fa-solid fa-eye"></i>
                                </a>
                            </div>
                            <div class="w-50 d-flex justify-content-center align-items-center">
                                <label class="switch">
                                    <input type="checkbox" class="product_action"
                                          ${checked} data-product="${product.id}">
                                    <span class="slider round"></span>
                                </label>
                            </div>
                        </div>
                    </td>
                </tr>`;
            }
            $('#tbodyListProduct').empty().append(html);
            if (total > 20) {
                loadPaginate('tableListProduct', 20);
            }
            searchMain('inputSearchProduct', 'tableListProduct');
        }

        async function changeStatus(productID) {
            loadingMasterPage();
            let update_url = `{{ route('api.admin.products.medicine.change') }}`;

            let data = {
                product_id: productID,
                user_id: `{{ Auth::user()->id }}`,
                _token: '{{ csrf_token() }}'
            }

            try {
                await $.ajax({
                    url: update_url,
                    method: 'POST',
                    headers: headers,
                    data: data,
                    success: function (response) {
                        loadingMasterPage();
                        processChangeStatus(response, productID);
                    },
                    error: function (xhr, status, exception) {
                        loadingMasterPage();
                        alert(xhr.responseJSON.message);
                    }
                });
            } catch (e) {
                console.log(e)
                alert('Error, Please try again!');
            }
        }

        function processChangeStatus(product, productID) {
            let status_text = $('#product_status_' + productID);
            status_text.text(product.status);
        }
    </script>
@endsection

