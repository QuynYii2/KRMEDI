@php use App\Enums\online_medicine\ObjectOnlineMedicine; @endphp
@php use App\Enums\online_medicine\FilterOnlineMedicine;use App\Enums\online_medicine\OnlineMedicineStatus; @endphp
@extends('layouts.admin')
@section('title')
    {{ __('home.Edit product medicine') }}
@endsection
@section('main-content')

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">{{ __('home.Update') }}</h1>
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
                    <input type="text" class="form-control" id="name" name="name"
                           value="{{ $productMedicine->name ?? '' }}">
                </div>
            </div>
            <div class="form-group">
                <label for="short_description">{{__('home.Short Description')}}</label>
                <textarea class="form-control" name="short_description" id="short_description">
                    {{ $productMedicine->short_description ?? '' }}
                </textarea>
            </div>
            <div class="form-group">
                <label for="description">{{ __('home.Mô tả dài việt') }}</label>
                <textarea class="form-control" name="description" id="description">
                    {{ $productMedicine->description ?? '' }}
                </textarea>
            </div>
            <div class="row">
                <div class="col-md-4 form-group">
                    <label for="brand_name">{{ __('home.Brand Name') }}</label>
                    <input type="text" class="form-control" id="brand_name" name="brand_name"
                           value="{{ $productMedicine->brand_name ?? '' }}">
                </div>
                <div class="form-group col-md-4">
                    <label for="number_register">{{ __('home.Number Register') }}</label>
                    <input type="number" class="form-control" id="number_register"
                           name="number_register" value="{{ $productMedicine->number_register ?? '' }}">
                </div>
                <div class="form-group col-md-4">
                    <label for="specifications">Specifications</label>
                    <input type="text" class="form-control" id="specifications"
                           name="specifications" value="{{ $productMedicine->specifications ?? '' }}">
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <label for="category_id">{{ __('home.Category') }}</label>
                    <select class="form-select" id="category_id" name="category_id">
                        <option value="0">{{ __('home.Khác') }}</option>
                        @if($categoryProductMedicine)
                            @foreach($categoryProductMedicine as $index => $cateProductMedicine)
                                <option
                                        {{ $productMedicine->category_id == $cateProductMedicine->id ? 'selected' : '' }}
                                        value="{{ $cateProductMedicine->id }}">
                                    {{ $cateProductMedicine->name }}
                                </option>
                            @endforeach
                        @endif
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="object_">{{ __('home.Object') }}</label>
                    <select class="form-select" id="object_" name="object_">
                        <option
                                {{ $productMedicine->object_ ==ObjectOnlineMedicine::KIDS ? 'selected' : '' }}
                                value="{{ ObjectOnlineMedicine::KIDS }}">{{ __('home.For kids') }}</option>
                        <option
                                {{ $productMedicine->object_ == ObjectOnlineMedicine::FOR_WOMEN ? 'selected' : '' }}
                                value="{{ ObjectOnlineMedicine::FOR_WOMEN }}">{{ __('home.For women') }}
                        </option>
                        <option {{ $productMedicine->object_ == ObjectOnlineMedicine::FOR_MEN ? 'selected' : '' }}
                                value="{{ ObjectOnlineMedicine::FOR_MEN }}">{{ __('home.For men') }}
                        </option>
                        <option {{ $productMedicine->object_ == ObjectOnlineMedicine::FOR_ADULT ? 'selected' : '' }}
                                value="{{ ObjectOnlineMedicine::FOR_ADULT }}">{{ __('home.For adults') }}
                        </option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="filter_">{{ __('home.Filter') }}</label>
                    <select class="form-select" id="filter_" name="filter_">
                        <option
                                {{ $productMedicine->filter_ == FilterOnlineMedicine::HEALTH ? 'selected' : '' }}
                                value="{{ FilterOnlineMedicine::HEALTH }}">{{ __('home.Heath') }}
                        </option>
                        <option
                                {{ $productMedicine->filter_ == FilterOnlineMedicine::BEAUTY ? 'selected' : '' }}
                                value="{{ FilterOnlineMedicine::BEAUTY }}">{{ __('home.Beauty') }}
                        </option>
                        <option
                                {{ $productMedicine->filter_ == FilterOnlineMedicine::PET  ? 'selected' : '' }}
                                value="{{ FilterOnlineMedicine::PET }}">{{ __('home.Pets') }}
                        </option>
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <label for="thumbnail">{{ __('home.Thumbnail') }}</label>
                    <input type="file" class="form-control" id="thumbnail" name="thumbnail" accept="image/*">
                    <img loading="lazy" class="mt-3" src="{{ asset($productMedicine->thumbnail) }}" alt="" width="80px" height="80xp">
                </div>
                <div class="col-md-6">
                    <label for="gallery">{{ __('home.gallery') }}</label>
                    <input type="file" class="form-control" id="gallery" name="gallery[]" multiple accept="image/*">
                    @php
                        $gallery = $productMedicine->gallery;
                        $arrayGallery = explode(',',$gallery);
                    @endphp
                    @foreach($arrayGallery as $itemGallery)
                        <img loading="lazy" src="{{ asset($itemGallery) }}" alt="" width="80px" height="80xp" class="mr-3 mt-3">
                    @endforeach
                </div>
            </div>
            <div class="row">
                <div class="col-sm-9">
                    <div class="list_product_ingredient">
                        @if(is_array($list_drugIngredients))
                            @foreach($list_drugIngredients as $list_drugIngredient)
                                @php
                                    $array_value = explode('(', $list_drugIngredient);
                                    if (count($array_value) > 1){
                                        $percent_one = $array_value[1];
                                        $percent_array = explode('%', $percent_one);
                                    }
                                @endphp
                                <div class="p-3 border mt-3 mb-3 d-flex align-items-center justify-content-between">
                                    <div class="w-75 form-ingredient">
                                        <div class="form-group">
                                            <label>{{ __('home.ingredient') }}</label>
                                            <input type="text" class="form-control ingredient_name"
                                                   value="{{ $array_value[0] }}"
                                                   name="ingredient_name">
                                        </div>
                                        <div class="form-group">
                                            <label>{{ __('home.Quantity') }} (Accountable by %)</label>
                                            <input type="number" class="form-control ingredient_quantity"
                                                   value="{{ isset($percent_array) ? $percent_array[0] : '' }}"
                                                   name="ingredient_quantity">
                                        </div>
                                    </div>
                                    <div class="btn-remove w-25 d-flex align-items-center justify-content-center">
                                        <i class="fa-regular fa-trash-can btnRemove p-3"
                                           style="font-size: 24px; cursor: pointer"></i>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                    <div class="action">
                        <button class="btn btn-outline-primary btnAddNew" type="button">
                            <i class="fa-solid fa-plus"></i> Create
                        </button>
                    </div>
                </div>
                <div class="col-sm-3">
                    <label for="is_prescription">{{ __('home.Choose prescription medications(Yes/No)') }}</label>
                    <input type="checkbox" id="is_prescription" name="is_prescription"
                            {{ $productMedicine->is_prescription ? 'checked' : '' }}>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <label for="price">{{ __('home.Price') }}</label>
                    <input type="number" class="form-control" id="price" name="price"
                           value="{{ $productMedicine->price ?? '' }}">
                </div>
                <div class="col-md-4">
                    <label for="unit_price">{{ __('home.Price Unit') }}</label>
                    <input type="text" class="form-control" id="unit_price" name="unit_price"
                           value="{{ $productMedicine->unit_price ?? '' }}">
                </div>
                <div class="col-md-4">
                    <label for="status">{{ __('home.Status') }}</label>
                    <select class="form-select" id="status" name="status" disabled>
                        <option
                                value="{{ OnlineMedicineStatus::PENDING }}" {{ $productMedicine->price == OnlineMedicineStatus::PENDING ? 'selected' : '' }}>{{ OnlineMedicineStatus::PENDING }}</option>
                        <option
                                value="{{ OnlineMedicineStatus::APPROVED }}" {{ $productMedicine->price == OnlineMedicineStatus::APPROVED ? 'selected' : '' }}>{{ OnlineMedicineStatus::APPROVED }}</option>
                        <option
                                value="{{ OnlineMedicineStatus::DELETED }}" {{ $productMedicine->price == OnlineMedicineStatus::DELETED ? 'selected' : '' }}>{{ OnlineMedicineStatus::DELETED }}</option>
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <label for="quantity">{{ __('home.Quantity') }}</label>
                    <input type="number" class="form-control" id="quantity" name="quantity" min="0"
                           value="{{ $productMedicine->quantity ?? '' }}">
                </div>
                <div class="col-md-4">
                    <label for="unit_quantity">{{ __('home.Unit Quantity') }}</label>
                    <select class="form-select" id="unit_quantity" name="unit_quantity">
                        @foreach($unit_quantity as $unit_quantity_item)
                            <option value="{{ $unit_quantity_item }}"
                                    {{ $unit_quantity_item == $productMedicine->unit_quantity ? 'selected' : '' }}>
                                {{ $unit_quantity_item }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="shape">{{ __('home.Shape') }}</label>
                    <select class="form-select" id="shape" name="shape">
                        @foreach($shapes as $shape)
                            <option value="{{ $shape }}"
                                    {{ $shape == $productMedicine->shape ? 'selected' : '' }}>
                                {{ $shape }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <label for="manufacturing_country">{{ __('home.Manufacturing Country') }}</label>
                    <input type="text" class="form-control" id="manufacturing_country"
                           value="{{ $productMedicine->manufacturing_country }}"
                           name="manufacturing_country">
                </div>
                <div class="col-md-6">
                    <label for="manufacturing_company">{{ __('home.Manufacturing Company') }}</label>
                    <input type="text" class="form-control" id="manufacturing_company"
                           value="{{ $productMedicine->manufacturing_company }}"
                           name="manufacturing_company">
                </div>
            </div>
            <div class="form-group">
                <label for="side_effects">{{__('home.Side Effects')}}</label>
                <textarea class="form-control" name="side_effects" id="side_effects">
                    {{ $productMedicine->side_effects }}
                </textarea>
            </div>
            <div class="form-group">
                <label for="uses">{{ __('home.Uses') }}</label>
                <textarea class="form-control" name="uses" id="uses">
                     {{ $productMedicine->uses }}
                </textarea>
            </div>
            <div class="form-group">
                <label for="user_manual">{{ __('home.User Manual') }}</label>
                <textarea class="form-control" name="user_manual" id="user_manual">
                    {{ $productMedicine->uses }}
                </textarea>
            </div>
            <div class="form-group">
                <label for="notes">{{ __('home.Notes') }}</label>
                <textarea class="form-control" name="notes" id="notes">
                     {{ $productMedicine->notes }}
                </textarea>
            </div>
            <div class="form-group">
                <label for="preserve">{{ __('home.Preserve') }}</label>
                <textarea class="form-control" name="preserve" id="preserve">
                    {{ $productMedicine->preserve }}
                </textarea>
            </div>
            <input type="hidden" id="id" name="id" value="{{ $productMedicine->id ?? '' }}">
        </div>
    </form>

    <button type="button" onclick="submitForm()"
            class="btn btn-primary up-date-button mt-md-4">{{ __('home.Save') }}</button>
    <script>
        function submitForm() {
            loadingMasterPage();
            const headers = {
                'Authorization': `Bearer ${token}`
            };
            const formData = new FormData();

            const arrField = [
                'name', 'brand_name', 'category_id', 'object_', 'filter_',
                'price', 'status', 'unit_price', 'quantity', 'id',
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
                    alert('Ingredient name or Ingredient quantity not null')
                    loadingMasterPage();
                    return;
                }

                let ingredient_value = ingredient_name + '(' + ingredient_quantity + '%)';
                if (!ingredient) {
                    ingredient = ingredient_value;
                } else {
                    ingredient = ingredient + ', ' + ingredient_value;
                }
            }

            var filedata = document.getElementById("gallery");
            var i = 0, len = filedata.files.length, img, reader, file;
            for (i; i < len; i++) {
                file = filedata.files[i];
                formData.append('gallery[]', file);
            }

            formData.append('ingredient', ingredient);

            let isValid = true
            /* Tạo fn appendDataForm ở admin blade*/
            isValid = appendDataForm(arrField, formData, isValid);

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
                    let labelElement = $(`label[for='${fieldTextarea}']`);
                    let text = labelElement.text();
                    if (!text) {
                        text = 'The input'
                    }
                    text = text + ' not empty!'
                    alert(text);
                    loadingMasterPage();
                    isValid = false;
                }
                formData.append(fieldTextarea, content);
            });

            if (!isValid) {
                return;
            }

            const photo = $('#thumbnail')[0].files[0];
            formData.append('thumbnail', photo);
            formData.append('user_id', '{{ Auth::user()->id }}');
            formData.append('_token', '{{ csrf_token() }}');
            formData.append('proved_by', '{{ Auth::user()->id }}');

            try {
                $.ajax({
                    url: `{{route('api.backend.product-medicine.update')}}`,
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
