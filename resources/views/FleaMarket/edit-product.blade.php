@extends('layouts.master')
@section('title', 'Flea Market')
@section('content')
    @include('layouts.partials.headerFleaMarket')
    <body>
    @include('component.banner')
    <div class="container content-add">
        <div class="add-cv_text">
            <div class="ac-text_content font-18-mobi"><a href=""><a href="{{route('flea.market.my.store')}}"><i
                            class="fa-solid fa-arrow-left mr-4"
                            style="color: black"></i></a>{{ __('home.Edit product information') }}</div>
        </div>
        <form action="#">
            <div class="d-flex row">
                <div class="col-md-12">
                    <div class="">
                        <div class="">
                            <div class="text-font-24 font-16-mobi mt-3 mt-md-4">{{ __('home.Product information') }}</div>
                        </div>
                        <div class="p-0 col-md-12 border-top">
                            <div class="text-font-16 mt-4 font-14-mobi">
                                <p><span>{{ __('home.Product name') }} </span><span class="red-color"> *</span></p>
                                <div class="w-100 mt-2">
                                    <input class="ac-email font-16-mobi checkValid" required name="name" id="name"
                                           value="{{$e_product->name}}"
                                           placeholder="example123">
                                </div>
                            </div>
                        </div>
                        <div class="d-block d-md-flex ">
                            <div class="col-md-6 pl-0 pr-0 pr-md-3">
                                <div class="text-font-16 mt-md-4 mt-3 font-14-mobi">
                                    <p><span>{{ __('home.Category') }} </span><span class="red-color"> *</span></p>
                                    <div class="w-100 mt-md-2">

                                        <select class="ac-choose font-16-mobi mt-2" name="category_id checkValid"
                                                required id="category_id">
                                            @php
                                                $e_productCat = \App\Models\online_medicine\CategoryProduct::find($e_product->category_id);
                                            @endphp
                                            <option
                                                value="{{$e_product->category_id}}">{{$e_productCat->name}}</option>
                                            @foreach($departments as $department)
                                                <option value="{{$department->id}}">{{$department->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="text-font-16 font-14-mobi mt-45 mt-3">
                                    <p><span>{{ __('home.Location') }} </span> <span class="red-color">*</span></p>
                                    <div class="w-100 mt-2">
                                        <select class="ac-choose font-16-mobi mt-2" id="province_idProduct"
                                                                                        name="province_idProduct checkValid"
                                                                                        required>
                                            @php
                                                $e_productName = \App\Models\Province::find($e_product->province_id);
                                            @endphp
                                            <option
                                                value="{{$e_product->province_id}}">{{$e_productName->name}}</option>
                                            @foreach($provinces as $province)
                                                <option value="{{$province->id}}">{{$province->name}}</option>
                                            @endforeach

                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 pr-0 pl-0 pl-md-3">
                                <div class="text-font-16 font-14-mobi mt-md-4 mt-3">
                                    <p><span>{{ __('home.Brand name') }} </span></p>
                                    <div class="w-100 mt-2 d-flex col-12 p-0">
                                        <div class="p-0 col-md-9 mt-2 col-8">
                                            <input class="web ac-nation font-16-mobi" style="max-width: 100%"
                                                   name="brand_name" id="brand_name" placeholder="0123456789"
                                                   value="{{$e_product->brand_name}}">
                                        </div>
                                        <div class="pr-0 col-md-3 mt-2 col-4">
                                            <a href="#" id="disabledInput" class="no-brand">{{ __('home.No Brand') }}</a>
                                        </div>
                                    </div>
                                    <small class="fs-12">{{ __("home.If you don't remember the brand name, you can leave it blank or click to select no brand") }}</small>
                                </div>
                                <div class="text-font-16 font-14-mobi mt-md-4 mt-3">
                                    <p><span>{{ __('home.Price') }} </span> <span class="red-color">*</span></p>
                                    <div class="w-100 mt-2">
                                        <input class="web ac-nation font-16-mobi mt-2" name="price checkValid" required
                                               id="price"
                                               placeholder="{{ __('home.Please choose....') }}" value="{{$e_product->price}}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="cv-about col-md-12">
                    <div class="">
                        <div class="text-font-24 font-14-mobi mt-md-4 mt-3">{{ __('home.Detailed description') }}</div>
                    </div>
                    <div class="mt-md-3 mt-2 font-16-mobi">
                        <textarea class="ac-textarea mt-md-3 checkValid" required name="description" id="description"
                                  placeholder="{{ __('home.Enter an introduction about yourself') }}">{{$e_product->description}}</textarea>
                    </div>
                    <div class="d-flex mt-2 font-10-mobi">
                        <i class="fa-solid fa-circle-exclamation text-center"
                           style="color: red;    padding: 4px 8px;"></i>
                        <p>{{ __('home.When promoting your website and exposing the website address, use of site will be suspended') }}</p>
                    </div>
                </div>
                <div class="">
                    <div class="text-font-24 font-14-mobi">{{ __('home.Photo') }}</div>
                    <div class="d-flex mt-2">
                        <div class="pl-0 d-flex">
                            <div class="p-0 d-flex">
                                <div class="p-0 d-flex">
                                    <div class="d-flex">
                                        @php
                                            $galleryArray = explode(',', $e_product->gallery);
                                        @endphp
                                        @foreach($galleryArray as $index => $productImg)
                                            <div class="image-container pr-2" data-index="{{ $index }}">
                                                <img class="image" width="200px" height="200px" src="{{ $productImg }}">
                                                {{--                                                <button class="delete-image" data-index="{{ $index }}">X</button>--}}
                                            </div>
                                        @endforeach
                                    </div>
                                    <div id="imagePreview"></div>
                                    <label for="gallery" class="p-0">
                                        <img class="p-0 img-sell-product"
                                             src="{{ asset('img/flea-market/add-photo.png') }}">
                                    </label>
                                    <input type="file" id="gallery" name="gallery[]" style="display: none;" multiple
                                           accept="image/*">
                                    <button id="chooseImageBtn" type="button" style="display: none">{{ __('home.Chọn ảnh') }}</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="text-font-24 mt-4 col-md-12 font-14-mobi">
                        <p><span>{{ __('home.Please choose you advertisement plan') }} </span><span class="red-color">*</span></p>
                        <div class="mt-2 d-flex font-12-mobi">
                            <div class="text-wrapper-input col-md-4 d-flex pl-0">
                                <input type="radio" class="web-tick-box" name="ads_plan" id="ads_plan1"
                                       value="1" {{ $e_product->ads_plan == 1 ? 'checked' : '' }}>
                                <label class="ml-2"><strong>{{ __('home.Platinum') }}</strong></label>
                            </div>
                            <div class="col-md-4 d-flex text-wrapper-input">
                                <input type="radio" class="web-tick-box" name="ads_plan" id="ads_plan2"
                                       value="2" {{ $e_product->ads_plan == 2 ? 'checked' : '' }}>
                                <label class=" ml-2"><strong>{{ __('home.Premium') }}</strong></label>
                            </div>
                            <div class="col-md-4 d-flex text-wrapper-input">
                                <input type="radio" class="web-tick-box" name="ads_plan" id="ads_plan3"
                                       value="3" {{ $e_product->ads_plan == 3 ? 'checked' : '' }}>
                                <label class=" ml-2"><strong>{{ __('home.Silver') }}</strong></label>
                            </div>
                        </div>
                    </div>

                    <div class="text-font-24 mt-4 col-md-12 mb-80 font-14-mobi">
                        <p><span>{{ __('home.Advertisement period') }}</span><span class="red-color">*</span></p>
                        <div class="mt-2 d-flex font-12-mobi">
                            <div class="text-wrapper-input col-md-3 d-flex pl-0">
                                <input type="radio" class="web-tick-box" name="ads_period"
                                       value="1" {{ $e_product->ads_period == 1 ? 'checked' : '' }}>
                                <label class="ml-2"><strong>{{ __('home.5 Day') }}</strong></label>
                            </div>
                            <div class="col-md-3 d-flex text-wrapper-input pl-0">
                                <input type="radio" class="web-tick-box" name="ads_period"
                                       value="2" {{ $e_product->ads_period == 2 ? 'checked' : '' }}>
                                <label class="ml-2"><strong>{{ __('home.10 Day') }}</strong></label>
                            </div>
                            <div class="col-md-3 d-flex text-wrapper-input pl-0">
                                <input type="radio" class="web-tick-box" name="ads_period"
                                       value="3" {{ $e_product->ads_period == 3 ? 'checked' : '' }}>
                                <label class="ml-2"><strong>{{ __('home.15 Day') }}</strong></label>
                            </div>
                            <div class="col-md-3 d-flex text-wrapper-input pl-0">
                                <input type="radio" class="web-tick-box" name="ads_period"
                                       value="4" {{ $e_product->ads_period == 4 ? 'checked' : '' }}>
                                <label class="ml-2"><strong>{{ __('home.20 Day') }}</strong></label>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="d-flex justify-content-center">
                    <div class="col-md-3 col-6">
                        <button type="submit" class="add-cv-bt w-100 apply-bt_delete">{{ __('home.CANCEL') }}</button>
                    </div>
                    <div class="col-md-3 col-6">
                        <button id="submitButton" type="button" class="add-cv-bt w-100 apply-bt_edit create-button">
                            {{ __('home.Save') }}
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
    </body>
    <script>
        document.getElementById('chooseImageBtn').addEventListener('click', function () {
            document.getElementById('gallery').click();
        });
        document.getElementById('gallery').addEventListener('change', function () {
            const selectedImages = this.files;
            for (let i = 0; i < selectedImages.length; i++) {
            }
        });
    </script>
    <script>
        {{--    xóa hình trong blade nhưng chưa được =))    --}}
        $(document).ready(function () {
            $('.delete-image').on('click', function () {
                const index = $(this).data('index');
                $galleryArray.splice(index, 1);
                $(`.image-container[data-index="${index}"]`).remove();
            });
        });
    </script>
    <script>
        document.getElementById('disabledInput').addEventListener('click', function (event) {
            event.preventDefault();

            const inputElement = document.getElementById('brand_name');

            if (inputElement.disabled) {
                inputElement.disabled = false;
                alert('You can enter the brand name')
            } else {
                inputElement.disabled = true;
                alert('You can not enter the brand name')
            }
        });
    </script>
    <script>
        document.getElementById('submitButton').addEventListener('click', function () {
            const inputElements = document.getElementsByClassName('checkValid');
            for (let i = 0; i < inputElements.length; i++) {
                const inputElement = inputElements[i];
                if (!inputElement.checkValidity()) {
                    alert('Please fill out the required field in element ' + (i + 1));
                    return;
                }
            }
            // alert('Form is valid. Submitting...');
        });
    </script>
    <script>
        let imgGallery = [];
        document.getElementById('gallery').addEventListener('change', function () {
            const imagePreviews = document.getElementById('imagePreview');
            imagePreviews.innerHTML = '';

            const selectedImages = this.files;
            for (let i = 0; i < selectedImages.length; i++) {
                const file = this.files[i];

                const image = document.createElement('img');
                image.src = URL.createObjectURL(file);
                image.alt = 'Preview Image';
                image.className = 'img-sell-product col-6 b-radius-8px';
                // image.className = 'col-6';
                // image.style.maxHeight = '200px';
                // image.style.maxWidth = '200px';
                image.style.paddingBottom = '16px';
                imagePreviews.appendChild(image);
            }
        });

        let selectedValue = document.querySelector('input[name="ads_period"]:checked').value;
        document.querySelectorAll('input[name="ads_period"]').forEach(function (radio) {
            radio.addEventListener('change', function () {
                if (this.checked) {
                    selectedValue = this.value;
                }
            });
        });
        let selectedValueAdd = document.querySelector('input[name="ads_plan"]:checked').value;
        document.querySelectorAll('input[name="ads_plan"]').forEach(function (radio) {
            radio.addEventListener('change', function () {
                if (this.checked) {
                    selectedValueAdd = this.value;
                }
            });
        });
        $(document).ready(function () {
            $('.create-button').on('click', function () {
                const headers = {
                    'Authorization': `Bearer ${token}`
                };

                const formData = new FormData();
                formData.append("name", $('#name').val());
                formData.append("name_en", $('#name').val());
                formData.append("name_laos", $('#name').val());
                formData.append("category_id", $('#category_id').val());
                formData.append("brand_name", $('#brand_name').val());
                formData.append("brand_name_en", $('#brand_name').val());
                formData.append("brand_name_laos", $('#brand_name').val());
                formData.append("province_id", $('#province_idProduct').val());
                formData.append("price", $('#price').val());
                formData.append("price_unit", 'VND');
                formData.append("ads_plan", (selectedValueAdd));
                const fieldTextareaTiny = ["description"];
                fieldTextareaTiny.forEach(fieldTextarea => {
                    const content = tinymce.get(fieldTextarea).getContent();
                    formData.append(fieldTextarea, content);
                });
                formData.append("ads_period", (selectedValue));
                formData.append("user_id", {{Auth::user()->id}});
                let photo = '';
                var filedata = document.getElementById("gallery");
                var i = 0, len = filedata.files.length, img, reader, file;
                for (i; i < len; i++) {
                    file = filedata.files[i];
                    if (i == 0) {
                        photo = file;
                    }
                    formData.append('gallery[]', file);
                }
                formData.append('thumbnail', photo);
                formData.append('status', 'ACTIVE');
                try {
                    $.ajax({
                        url: `{{route('api.backend.product.updatePost',$e_product->id)}}`,
                        method: 'POST',
                        headers: headers,
                        contentType: false,
                        cache: false,
                        processData: false,
                        data: formData,
                        success: function (response) {
                            alert('success');
                            window.location.reload();
                        },
                        error: function (exception) {
                        }
                    });
                } catch (error) {
                    throw error;
                }
            });
        })
    </script>
@endsection
