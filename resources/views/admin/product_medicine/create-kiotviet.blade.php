@php use App\Enums\online_medicine\ObjectOnlineMedicine; @endphp
@php use App\Enums\online_medicine\FilterOnlineMedicine;use App\Enums\online_medicine\OnlineMedicineStatus; @endphp
@extends('layouts.admin')
@section('title')
    {{ __('home.Create product medicine') }}
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
    <form id="form" method="post" action="{{ route('api.backend.products.create') }}" enctype="multipart/form-data">
        @csrf
        @method('POST')
        <div>
            <div class="row">
                <div class="col-md-12 form-group">
                    <label for="name">{{ __('home.Name') }}</label>
                    <input type="text" class="form-control" id="name" name="name" value="{{@$data['fullName']}}">
                </div>
                <input type="text" class="form-control" id="id_kiotviet" name="id_kiotviet" value="{{@$data['id']}}" hidden>
            </div>
            <div class="form-group">
                <label for="short_description">Mô tả ngắn</label>
                <textarea class="form-control" name="short_description" id="short_description"></textarea>
            </div>
            <div class="form-group">
                <label for="description">Nội dung</label>
                <textarea class="form-control" name="description" id="description" >{{@$data['description']}}</textarea>
            </div>
            <div class="row">
                <div class="col-md-4 form-group">
                    <label for="brand_name">{{ __('home.Brand Name') }}</label>
                    <input type="text" class="form-control" id="brand_name" name="brand_name"
                           value="">
                </div>
                <div class="form-group col-md-4">
                    <label for="number_register">Số đăng ký</label>
                    <input type="number" class="form-control" id="number_register"
                           name="number_register">
                </div>
                <div class="form-group col-md-4">
                    <label for="specifications">Quy cách đóng gói</label>
                    <input type="text" class="form-control" id="specifications"
                           name="specifications">
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <label for="category_id">{{ __('home.Category') }}</label>
                    <select class="form-select" id="category_id" name="category_id">
                        <option value="0">{{ __('home.Khác') }}</option>
                        @if($categoryProductMedicine)
                            @foreach($categoryProductMedicine as $index => $cateProductMedicine)
                                <option value="{{ $cateProductMedicine->id }}" @if($cateProductMedicine->name == $data['categoryName']) selected @endif>{{ $cateProductMedicine->name }}</option>
                            @endforeach
                        @endif
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="object_">{{ __('home.Object') }}</label>
                    <select class="form-select" id="object_" name="object_">
                        <option value="{{ ObjectOnlineMedicine::KIDS }}">{{ __('home.For kids') }}</option>
                        <option value="{{ ObjectOnlineMedicine::FOR_WOMEN }}">{{ __('home.For women') }}
                        </option>
                        <option value="{{ ObjectOnlineMedicine::FOR_MEN }}">{{ __('home.For men') }}</option>
                        <option value="{{ ObjectOnlineMedicine::FOR_ADULT }}">{{ __('home.For adults') }}
                        </option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="filter_">{{ __('home.Filter') }}</label>
                    <select class="form-select" id="filter_" name="filter_">
                        <option value="{{ FilterOnlineMedicine::HEALTH }}">{{ __('home.Heath') }}</option>
                        <option value="{{ FilterOnlineMedicine::BEAUTY }}">{{ __('home.Beauty') }}</option>
                        <option value="{{ FilterOnlineMedicine::PET }}">{{ __('home.Pets') }}</option>
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <label for="thumbnail">{{ __('home.Thumbnail') }}</label>
                    <input type="file" class="form-control" id="thumbnail" placeholder="ádassd" name="thumbnail" accept="image/*">
                    <span id="thumbnail-count" style="color: red;"></span>
                    <input type="hidden" id="existing_thumbnail" name="existing_thumbnail" value="{{@$data['images'][0]}}">
                </div>
                <div class="col-md-6">
                    <label for="gallery">{{ __('home.gallery') }}</label>
                    <input type="file" class="form-control" id="gallery" name="gallery[]" value="" multiple accept="image/*">
                    <span id="gallery-count" style="color: red;"></span>
                </div>
                @if(!empty($data['images']))
                    @foreach($data['images'] as $image)
                        <input type="hidden" name="existing_images[]" value="{{ $image }}">
                    @endforeach
                @endif
            </div>
            <div class="row">
                <div class="col-sm-9">
                    <div class="list_product_ingredient">

                    </div>
                    <div class="action">
                        <button class="btn btn-outline-primary btnAddNew" type="button">
                            <i class="fa-solid fa-plus"></i> Create
                        </button>
                    </div>
                </div>
                <div class="col-sm-3">
                    <label for="is_prescription">Chọn thuốc theo đơn (Có/ Không)</label>
                    <input type="checkbox" id="is_prescription" name="is_prescription">
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <label for="price">{{ __('home.Price') }}</label>
                    <input type="number" class="form-control" id="price" name="price" value="{{@$data['basePrice']}}">
                </div>
                <div class="col-md-4">
                    <label for="unit_price">{{ __('home.Price Unit') }}</label>
                    <input type="text" class="form-control" id="unit_price" name="unit_price" value="">
                </div>
                <div class="col-md-4">
                    <label for="status">{{ __('home.Status') }}</label>
                    <select class="form-select" id="status" name="status" disabled>
                        <option
                            value="{{ OnlineMedicineStatus::PENDING }}">{{ OnlineMedicineStatus::PENDING }}</option>
                        <option
                            value="{{ OnlineMedicineStatus::APPROVED }}">{{ OnlineMedicineStatus::APPROVED }}</option>
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <label for="quantity">{{ __('home.Quantity') }}</label>
                    <input type="number" class="form-control" id="quantity" name="quantity" min="0" value="{{@$data['inventories'][0]['onHand']}}">
                </div>
                <div class="col-md-4">
                    <label for="unit_quantity">Đơn vị số lượng</label>
                    <select class="form-select" id="unit_quantity" name="unit_quantity">
                        @foreach($unit_quantity as $unit_quantity_item)
                            <option value="{{ $unit_quantity_item }}">{{ $unit_quantity_item }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="shape">Hình dạng</label>
                    <select class="form-select" id="shape" name="shape">
                        @foreach($shapes as $shape)
                            <option value="{{ $shape }}">{{ $shape }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <label for="manufacturing_country">Quốc gia sản xuất</label>
                    <input type="text" class="form-control" id="manufacturing_country"
                           name="manufacturing_country">
                </div>
                <div class="col-md-6">
                    <label for="manufacturing_company">Công ty sản xuất</label>
                    <input type="text" class="form-control" id="manufacturing_company"
                           name="manufacturing_company">
                </div>
                <div class="col-md-6">
                    <div class="form-check mt-3 mb-3">
                        <input class="form-check-input" type="checkbox" value="1" id="type_product" name="type_product">
                        <label class="form-check-label" for="type_product">
                            Sản phẩm theo chỉ định của bác sĩ
                        </label>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="side_effects">Tác dụng phụ</label>
                <textarea class="form-control" name="side_effects" id="side_effects"></textarea>
            </div>
            <div class="form-group">
                <label for="uses">Công dụng</label>
                <textarea class="form-control" name="uses" id="uses"></textarea>
            </div>
            <div class="form-group">
                <label for="user_manual">Hướng dẫn sử dụng</label>
                <textarea class="form-control" name="user_manual" id="user_manual"></textarea>
            </div>
            <div class="form-group">
                <label for="notes">Ghi chú</label>
                <textarea class="form-control" name="notes" id="notes"></textarea>
            </div>
            <div class="form-group">
                <label for="preserve">Bảo quản</label>
                <textarea class="form-control" name="preserve" id="preserve"></textarea>
            </div>
        </div>
    </form>

    <button type="button" onclick="submitForm()"
            class="btn btn-primary up-date-button mt-md-4">{{ __('home.Save') }}</button>
    <script>
        document.addEventListener('DOMContentLoaded', (event) => {
            const thumbnailInput = document.getElementById('thumbnail');
            const galleryInput = document.getElementById('gallery');
            const thumbnailCount = document.getElementById('thumbnail-count');
            const galleryCount = document.getElementById('gallery-count');

            thumbnailInput.addEventListener('change', function() {
                const files = thumbnailInput.files;
                thumbnailCount.textContent = files.length > 0 ? `${files.length} tệp đã chọn` : '';
            });

            galleryInput.addEventListener('change', function() {
                const files = galleryInput.files;
                galleryCount.textContent = files.length > 0 ? `${files.length} tệp đã chọn` : '';
            });

            const existingImages = document.getElementsByName('existing_images[]');
            if (existingImages.length > 0) {
                galleryCount.textContent = `Đã có ${existingImages.length} hình ảnh được chọn`;
            }

            const existingThumbnail = document.getElementById('existing_thumbnail');
            if (existingThumbnail.value != '' && existingThumbnail.value != null) {
                thumbnailCount.textContent = `Đã chọn hình ảnh`;
            }

        });

        function submitForm() {
            // loadingMasterPage();
            const headers = {
                'Authorization': `Bearer ${token}`
            };
            const formData = new FormData();

            const arrField = [
                'name', 'brand_name', 'category_id', 'object_', 'filter_',
                'price', 'status', 'unit_price', 'quantity',
                'unit_quantity', 'number_register', 'manufacturing_company',
                'manufacturing_country', 'shape', 'specifications'
            ];

            let checked = document.getElementById('is_prescription').checked;
            if (checked) {
                formData.append('is_prescription', 'true');
            }

            //'ingredient'
            let ingredient_names = document.getElementsByName('ingredient_name');
            let ingredient_quantities = document.getElementsByName('ingredient_quantity');

            let ingredient = null;
            for (let j = 0; j < ingredient_names.length; j++) {
                let ingredient_name = ingredient_names[j].value;
                let ingredient_quantity = ingredient_quantities[j].value;

                if (!ingredient_name || !ingredient_quantity) {
                    alert('Vui lòng điền thành phần thuốc và hàm lượng')
                    return;
                }

                let ingredient_value = ingredient_name + '(' + ingredient_quantity + '%)';
                if (!ingredient) {
                    ingredient = ingredient_value;
                } else {
                    ingredient = ingredient + ', ' + ingredient_value;
                }
            }

            formData.append('ingredient', ingredient);

            let isValid = true
            /* Tạo fn appendDataForm ở admin blade*/
            isValid = appendDataForm(arrField, formData, isValid);
            let allImages = [];

            const filedata = document.getElementById('gallery');
            const len = filedata.files.length;
            if (len > 0) {
                for (let i = 0; i < len; i++) {
                    const file = filedata.files[i];
                    formData.append('gallery[]', file);
                }
            }

            // Thêm các hình ảnh hiện có vào formData
            const existingImages = document.getElementsByName('existing_images[]');
            for (let i = 0; i < existingImages.length; i++) {
                formData.append('existing_images[]', existingImages[i].value);
            }

            const fieldTextareaTiny = [
                'description',
                'short_description',
                'side_effects',
                'uses',
                'user_manual',
                'notes',
                'preserve',
            ];
            fieldTextareaTiny.forEach(fieldTextarea => {
                const content = tinymce.get(fieldTextarea).getContent();
                if (!content) {
                    isValid = false;
                }
                formData.append(fieldTextarea, content);
            });

            const photo = $('#thumbnail')[0].files[0];
            const existingThumbnail = document.getElementById('existing_thumbnail').value;
            if (photo) {
                formData.append('thumbnail', photo);
            }else{
                formData.append('thumbnail', existingThumbnail);
            }
            if (!photo && !existingThumbnail) {
                isValid = false;
            }

            const remember = document.getElementById("type_product");
            let active_type = 0;
            if (remember.checked) {
                active_type = 1;
            }
            formData.append('user_id', '{{ Auth::user()->id }}');
            formData.append('_token', '{{ csrf_token() }}');
            formData.append('proved_by', '{{ Auth::user()->id }}');
            formData.append('type_product', active_type);
            let idKiotvietElement = document.getElementById('id_kiotviet');
            let idKiotvietValue = idKiotvietElement ? idKiotvietElement.value : null;
            formData.append('id_kiotviet', idKiotvietValue);

            if (!isValid) {
                alert('Please check input empty!');
                return;
            }

            if (isValid){
                try {
                    $.ajax({
                        url: `{{route('api.backend.product-medicine.store')}}`,
                        method: 'POST',
                        headers: headers,
                        contentType: false,
                        cache: false,
                        processData: false,
                        data: formData,
                        success: function (data) {
                            alert(data.message);
                            loadingMasterPage();
                            window.location.href = `{{route('api.backend.product-medicine.index')}}`;
                        },
                        error: function (exception) {
                            alert(exception.responseText);
                            loadingMasterPage();
                        }
                    });
                } catch (error) {
                    loadingMasterPage();
                    throw error;
                }
            }
        }
    </script>
    <script>
        let html = `<div class="p-3 border mt-3 mb-3 d-flex align-items-center justify-content-between">
                            <div class="w-75 form-ingredient">
                                <div class="form-group">
                                    <label>{{ __('home.ingredient') }}</label>
                                    <input type="text" class="form-control ingredient_name" name="ingredient_name">
                                </div>
                                <div class="form-group">
                                    <label>{{ __('home.Quantity') }} (Accountable by %)</label>
                                    <input type="number" class="form-control ingredient_quantity" name="ingredient_quantity">
                                </div>
                            </div>
                            <div class="btn-remove w-25 d-flex align-items-center justify-content-center">
                                <i class="fa-regular fa-trash-can btnRemove p-3" style="font-size: 24px; cursor: pointer"></i>
                            </div>
                        </div>`;
        $(document).ready(function () {
            let list_product_ingredient = $('.list_product_ingredient');
            list_product_ingredient.append(html);

            $('.btnAddNew').on('click', function () {
                list_product_ingredient.append(html);
                loadRemove();
            })

            loadRemove();
        })

        function loadRemove() {
            $('.btnRemove').on('click', function () {
                let parent = $(this).parent().parent();
                parent.remove();
            })
        }
    </script>
@endsection
