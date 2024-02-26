@extends('layouts.admin')
@section('title')
    {{ __('home.Create Selling/Buying') }}
@endsection
@section('main-content')

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">{{ __('home.create') }}</h1>
    @if (session('success'))
        <div class="alert alert-success border-left-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
    <form id="form-create-product" action="#" method="post">
        <div>
            <div class="row">
                <div class="col-md-12">
                    <label for="name">{{ __('home.Name') }}</label>
                    <input type="text" class="form-control" id="name" name="name" required>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-12"><label for="description">{{ __('home.Mô tả dài việt') }}</label>
                    <textarea class="form-control" name="description" id="description"></textarea>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <label for="brand_name">{{ __('home.Brand Name') }}</label>
                    <input type="text" class="form-control" id="brand_name" name="brand_name"
                           value="" required>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <label for="category_id">{{ __('home.Category') }}</label>
                    <select class="form-select" id="category_id" name="category_id">
                        @foreach($categories as $category)
                            <option data-limit="50" class="text-shortcut"
                                    value="{{$category->id}}">{{$category->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    @php
                        $provinces = \App\Models\Province::all();
                    @endphp
                    <label for="province_id">Province</label>
                    <select class="form-select" id="province_id" name="province_id">
                        @foreach($provinces as $province)
                            <option value="{{$province->id}}">{{$province->name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div>
                <label>{{ __('home.Thumbnail') }}</label>
                <input type="file" class="form-control" id="thumbnail" name="thumbnail" accept="image/*"
                       required>
            </div>
            <div>
                <label>{{ __('home.gallery') }}</label>
                <input type="file" class="form-control" id="gallery" name="gallery[]" multiple accept="image/*">
            </div>
            <div class="row">
                <div class="col-md-4">
                    <label for="price">{{ __('home.Price') }}</label>
                    <input type="number" required class="form-control" id="price" name="price" value="">
                </div>
                <div class="col-md-4">
                    <label for="price_unit">{{ __('home.Price Unit') }}</label>
                    <input type="text" class="form-control" id="price_unit" name="price_unit"
                           value="VND" required>
                </div>
                <div class="col-md-4">
                    <label for="quantity">{{ __('home.Quantity') }}</label>
                    <input type="number" value="1" class="form-control" id="quantity" name="quantity" min="0" required>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <label for="ads_plan">{{ __('home.Ads Plan') }}</label>
                    <select id="ads_plan" name="ads_plan" class="form-select">
                        <option value="1">{{ __('home.Platinum') }}</option>
                        <option value="2">{{ __('home.Premium') }}</option>
                        <option value="3">{{ __('home.Silver') }}</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="ads_period">{{ __('home.Ads Period') }}</label>
                    <select id="ads_period" name="ads_period" class="form-select">
                        <option value="1">{{ __('home.5 Day') }}</option>
                        <option value="2">{{ __('home.10 Day') }}</option>
                        <option value="3">{{ __('home.15 Day') }}</option>
                        <option value="4">{{ __('home.20 Day') }}</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="status">{{ __('home.Status') }}</label>
                    <select id="status" name="status" class="form-select">
                        <option
                            value="{{ \App\Enums\ProductStatus::ACTIVE }}">{{ \App\Enums\ProductStatus::ACTIVE }}</option>
                        <option
                            value="{{ \App\Enums\ProductStatus::ACTIVE }}">{{ \App\Enums\ProductStatus::ACTIVE }}</option>
                    </select>
                </div>
            </div>
            <div hidden="">
                <label for="user_id">{{ __('home.Username') }}</label>
                <input type="text" class="form-control" id="user_id" name="user_id" value="{{Auth::user()->id}}">
            </div>
        </div>
        <button type="button" class="btn btn-primary up-create-button mt-md-4">{{ __('home.Save') }}</button>
    </form>
    <script>
        $(document).ready(function () {
            $('#form-create-product').submit(function (e) {
                e.preventDefault();
                // createProduct();
            });

            $('.up-create-button').on('click', function () {
                createProduct();
            })
        })

        async function createProduct() {
            const headers = {
                'Authorization': `Bearer ${token}`
            };
            const formData = new FormData();

            const arrField = ['name',
                'category_id', 'brand_name', 'province_id', 'price',
                'price_unit', 'ads_plan', 'ads_period',
                'user_id', 'quantity'];

            let isValid = true
            /* Tạo fn appendDataForm ở admin blade*/
            isValid = appendDataForm(arrField, formData, isValid);

            const fieldTextareaTiny = ["description"];
            fieldTextareaTiny.forEach(fieldTextarea => {
                const content = tinymce.get(fieldTextarea).getContent();
                if (!content) {
                    isValid = false;
                }
                formData.append(fieldTextarea, content);
            });

            var filedata = document.getElementById("gallery");
            var i = 0, len = filedata.files.length, img, reader, file;

            if (len > 0) {
                for (i; i < len; i++) {
                    file = filedata.files[i];
                    formData.append('gallery[]', file);
                }
            } else {
                isValid = false;
            }

            const photo = $('#thumbnail')[0].files[0];
            if (!photo) {
                isValid = false;
            }
            formData.append('thumbnail', photo);
            formData.append('status', 'ACTIVE');
            if (isValid) {
                try {
                    await $.ajax({
                        url: `{{route('api.backend.products.create')}}`,
                        method: 'POST',
                        headers: headers,
                        contentType: false,
                        cache: false,
                        processData: false,
                        data: formData,
                        success: function (response) {
                            alert('success');
                            window.location.href = `{{route('homeAdmin.list.product')}}`;
                        },
                        error: function (exception) {
                            console.log(exception)
                        }
                    });
                } catch (error) {
                    throw error;
                }
            } else {
                alert('Please check input not empty!')
            }
        }
    </script>
@endsection
