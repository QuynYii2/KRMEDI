@php use App\Enums\NewEventStatus; @endphp
@php use App\Enums\NewEventType; @endphp
@extends('layouts.admin')
@section('title')
    {{ __('home.Create Category product') }}
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
    <form enctype="multipart/form-data">
        <div class="row">
            <div class="col-sm-4">
                <label for="name">{{ __('home.Title') }} </label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="col-sm-4">
                <label for="thumbnail">{{ __('home.Thumbnail') }}</label>
                <input type="file" class="form-control" id="thumbnail" name="thumbnail" required>
            </div>
            <div class="col-sm-4">
                <label for="status">{{ __('home.Status') }}</label>
                <select class="form-select" id="status" name="status">
                    <option
                        value="1" selected>{{ __('home.Active') }}
                    </option>
                    <option
                        value="0">{{ __('home.Inactive') }}
                    </option>
                </select>
            </div>
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

            const arrField = ['name', 'status'];

            let isValid = true
            /* Tạo fn appendDataForm ở admin blade*/
            isValid = appendDataForm(arrField, formData, isValid);

            let photo = $('#thumbnail')[0].files[0];
            if (!photo) {
                isValid = false;
            }
            formData.append('thumbnail', photo);

            formData.append('_token', '{{ csrf_token() }}');

            if (isValid) {
                try {
                    $.ajax({
                        url: `{{route('api.backend.category-product.store')}}`,
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
            } else {
                alert('Please check input require!')
                loadingMasterPage();
            }
        }
    </script>
@endsection
