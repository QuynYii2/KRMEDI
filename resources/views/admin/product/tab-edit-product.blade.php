@extends('layouts.admin')
@section('title')
    {{ __('home.Edit Selling/Buying') }}
@endsection
@section('main-content')
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">{{ __('home.Edit') }}</h1>
    @if (session('success'))
        <div class="alert alert-success border-left-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
    <form id="form">
        <div>
            <div class="row">
                <div class="col-md-12">
                    <label for="name">{{ __('home.Name') }}</label>
                    <input type="text" class="form-control" id="name" name="name" maxlength="200"
                           value="{{$product->name}}">
                </div>
            </div>

            <div class="row">
                <div class="col-sm-12">
                    <label for="description">{{ __('home.Mô tả dài việt') }}</label>
                    <textarea class="form-control" name="description"
                              id="description">{{$product->description}}</textarea>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <label for="brand_name">{{ __('home.Brand Name') }}</label>
                    <input type="text" class="form-control" id="brand_name" name="brand_name"
                           maxlength="200"
                           value="{{$product->brand_name}}">
                </div>
                <div class="col-md-4">
                    <label for="category_id">{{ __('home.Category') }}</label>
                    <select class="form-select" id="category_id" name="category_id">
                        @foreach($categories as $category)
                            <option {{ $category->id == $product->category_id ? 'selected' : '' }}
                                    data-limit="50" class="text-shortcut"
                                    value="{{$category->id}}">
                                {{$category->name}}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    @php
                        $provinces = \App\Models\Province::find($product->province_id)->get();
                    @endphp
                    <label for="province_id">{{ __('home.Province') }}</label>

                    <select class="form-select" id="province_id" name="province_id">
                        @foreach($provinces as $province)
                            <option
                                value="{{$province->id}}" {{$province->id == $product->province_id ? 'selected' : ''}}>{{$province->name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 form-group">
                    <label>{{ __('home.Thumbnail') }}</label>
                    <input type="file" class="form-control" id="thumbnail" name="thumbnail" accept="image/*">
                    <img loading="lazy" width="50px" src="{{$product->thumbnail}}" alt="thumbnail">
                </div>
                <div class="col-md-6 form-group">
                    <label for="gallery">{{ __('home.gallery') }}</label>
                    <input type="file" class="form-control" id="gallery" name="gallery[]" multiple accept="image/*">
                    @php
                        $galleryArray = explode(',', $product->gallery);
                    @endphp
                    @foreach($galleryArray as $productImg)
                        <img loading="lazy" width="50px" src="{{$productImg}}" alt="gallery">
                    @endforeach
                </div>
            </div>
            <div class="row">
                <div class="col-md-4 form-group">
                    <label for="price">{{ __('home.Price') }}</label>
                    <input type="number" class="form-control" id="price" name="price" value="{{$product->price}}">
                </div>
                <div class="col-md-4 form-group">
                    <label for="price_unit">{{ __('home.Price Unit') }}</label>
                    <input type="text" class="form-control" id="price_unit" name="price_unit"
                           value="{{$product->price_unit}}">
                </div>
                <div class="col-md-4 form-group">
                    <label for="quantity">{{ __('home.Quantity') }}</label>
                    <input type="text" class="form-control" id="quantity" name="quantity" min="0"
                           value="{{ $product->quantity ?? 0 }}">
                </div>
            </div>

            <div class="row">
                <div class="col-sm-4">
                    <label for="ads_plan">{{ __('home.Ads Plan') }}</label>
                    <select id="ads_plan" name="ads_plan" class="form-select">
                        <option
                            {{$product->ads_plan == 1 ? 'selected' : ''}} value="1">{{ __('home.Platinum') }}</option>
                        <option
                            {{$product->ads_plan == 2 ? 'selected' : ''}} value="2">{{ __('home.Premium') }}</option>
                        <option {{$product->ads_plan == 3 ? 'selected' : ''}} value="3">{{ __('home.Silver') }}</option>
                    </select>
                </div>
                <div class="col-sm-4">
                    <label for="ads_period">{{ __('home.Ads Period') }}</label>
                    <select id="ads_period" name="ads_period" class="form-select">
                        <option
                            {{$product->ads_period == 1 ? 'selected' : ''}} value="1">{{ __('home.5 Day') }}</option>
                        <option
                            {{$product->ads_period == 2 ? 'selected' : ''}} value="2">{{ __('home.10 Day') }}</option>
                        <option
                            {{$product->ads_period == 3 ? 'selected' : ''}} value="3">{{ __('home.15 Day') }}</option>
                        <option
                            {{$product->ads_period == 4 ? 'selected' : ''}} value="4">{{ __('home.20 Day') }}</option>
                    </select>
                </div>
                <div class="col-sm-4"><label for="status">{{ __('home.Trạng thái') }}</label>
                    <select class="form-select" id="status" name="status" {{ !$isAdmin ? 'disabled' : '' }}>
                        <option value="{{ \App\Enums\ProductStatus::ACTIVE }}"
                            {{ $product->status == \App\Enums\ProductStatus::ACTIVE ? 'selected' : '' }}>
                            {{ \App\Enums\ProductStatus::ACTIVE }}
                        </option>
                        <option value="{{ \App\Enums\ProductStatus::INACTIVE }}"
                            {{ $product->status == \App\Enums\ProductStatus::INACTIVE ? 'selected' : '' }}>
                            {{ \App\Enums\ProductStatus::INACTIVE }}
                        </option>
                    </select>

                </div>
            </div>

            <div hidden="">
                <label for="user_id">{{ __('home.Username') }}</label>
                <input type="text" class="form-control" id="user_id" name="user_id" value="{{Auth::user()->id}}">
            </div>
        </div>
        <button type="button" class="btn btn-primary mt-md-4" id="editProducts">{{ __('home.Save') }}</button>
    </form>
    <script>
        $(document).ready(function () {
            $('#editProducts').on('click', function () {
                const headers = {
                    'Authorization': `Bearer ${token}`
                };
                const formDataEdit = new FormData();

                const fieldNames = [
                    "name", "category_id", "brand_name", "province_id", "price",
                    "price_unit", "ads_plan", "ads_period", "user_id", 'quantity'
                ];

                let isValid = true
                /* Tạo fn appendDataForm ở admin blade*/
                isValid = appendDataForm(fieldNames, formDataEdit, isValid);

                const fieldTextareaTiny = [
                    "description",
                ];
                fieldTextareaTiny.forEach(fieldTextarea => {
                    const content = tinymce.get(fieldTextarea).getContent();
                    if (!content) {
                        isValid = false;
                        let labelElement = $(`label[for='${fieldTextarea}']`);
                        let text = labelElement.text();
                        if (!text) {
                            text = 'The input'
                        }
                        text = text + ' not empty!'
                        alert(text);
                        return;
                    }
                    formDataEdit.append(fieldTextarea, content);
                });


                var filedata = document.getElementById("gallery");
                var i = 0, len = filedata.files.length, file;
                for (i; i < len; i++) {
                    file = filedata.files[i];
                    formDataEdit.append('gallery[]', file);
                }
                const photoGallery = $('#gallery')[0].files;
                const photo = $('#thumbnail')[0].files[0];
                formDataEdit.append('thumbnail', photo);
                formDataEdit.append('status', $('#status').val());

                if (isValid) {
                    alert('Please check input not empty!')
                    return;
                }

                try {
                    $.ajax({
                        url: `{{route('api.backend.product.updatePost',$product->id)}}`,
                        method: 'POST',
                        headers: headers,
                        contentType: false,
                        cache: false,
                        processData: false,
                        data: formDataEdit,
                        success: function (response) {
                            alert('success');
                            window.location.href = `{{route('homeAdmin.list.product')}}`
                        },
                        error: function (exception) {
                            console.log(exception)
                        }
                    });
                } catch (error) {
                    throw error;
                }
            })
        })
    </script>
@endsection
