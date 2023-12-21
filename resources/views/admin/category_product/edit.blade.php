@php use App\Enums\NewEventStatus; @endphp
@php use App\Enums\NewEventType; @endphp
@extends('layouts.admin')
@section('title')
    {{ __('home.Update Category product') }}
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
    <form enctype="multipart/form-data">
        <div class="row">
            <div class="col-sm-4">
                <label for="name">{{ __('home.Title') }} </label>
                <input required type="text" class="form-control" id="name" name="name"
                       value="{{ $categoryProduct->name ?? '' }}">
            </div>
            <div class="col-sm-4">
                <label for="name_en">{{ __('home.Title Anh') }}</label>
                <input required type="text" class="form-control" id="name_en" name="name_en"
                       value="{{ $categoryProduct->name_en ?? '' }}">
            </div>
            <div class="col-sm-4">
                <label for="name_laos">{{ __('home.Title Lào') }}</label>
                <input required type="text" class="form-control" id="name_laos" name="name_laos"
                       value="{{ $categoryProduct->name_laos ?? '' }}">
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6">
                <label for="thumbnail">{{ __('home.Thumbnail') }}</label>
                <input type="file" class="form-control" id="thumbnail" name="thumbnail">
                <img src="{{ asset($categoryProduct->thumbnail) }}" alt="" width="80px">
            </div>
            <div class="col-sm-6">
                <label for="status">{{ __('home.Status') }}</label>
                <select class="form-select" id="status" name="status">
                    <option
                        value="1" {{ $categoryProduct->status == 1 ? 'selected' : '' }}>{{ __('home.Active') }}
                    </option>
                    <option
                        value="0" {{ $categoryProduct->status == 0 ? 'selected' : '' }}>{{ __('home.Inactive') }}
                    </option>
                </select>
            </div>
        </div>
        <input type="hidden" id="id" name="id" value="{{ $categoryProduct->id }}">
    </form>
    <button type="button" onclick="submitForm()" class="btn btn-primary up-date-button mt-md-4">{{ __('home.Save') }}</button>
    <script>

        function submitForm() {
            loadingMasterPage();
            const headers = {
                'Authorization': `Bearer ${token}`
            };
            const formData = new FormData();

            const arrField = ['name', 'name_en', 'name_laos', 'status', 'id'];

            arrField.forEach((field) => {
                formData.append(field, $(`#${field}`).val().trim());
            });
            formData.append('thumbnail', $('#thumbnail')[0].files[0]);

            formData.append('_token', '{{ csrf_token() }}');

            try {
                $.ajax({
                    url: `{{route('api.backend.category-product.update')}}`,
                    method: 'POST',
                    headers: headers,
                    contentType: false,
                    cache: false,
                    processData: false,
                    data: formData,
                    success: function (data) {
                        alert(data);
                        loadingMasterPage();
                        window.location.href = `{{route('api.backend.category-product.index')}}`;
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
@endsection
