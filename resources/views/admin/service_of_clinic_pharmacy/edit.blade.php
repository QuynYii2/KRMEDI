@php use App\Enums\NewEventStatus; @endphp
@php use App\Enums\NewEventType; @endphp
@extends('layouts.admin')

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
                <input type="text" class="form-control" id="name" name="name"
                       value="{{ $serviceClinic->name ?? '' }}">
            </div>
            <div class="col-sm-4">
                <label for="name_en">{{ __('home.Title Anh') }}</label>
                <input type="text" class="form-control" id="name_en" name="name_en"
                       value="{{ $serviceClinic->name_en ?? '' }}">
            </div>
            <div class="col-sm-4">
                <label for="name_laos">{{ __('home.Title Lào') }}</label>
                <input type="text" class="form-control" id="name_laos" name="name_laos"
                       value="{{ $serviceClinic->name_laos ?? '' }}">
            </div>
        </div>
        <input type="hidden" id="id" name="id" value="{{ $serviceClinic->id }}">
    </form>
    <button type="button" onclick="submitForm()" class="btn btn-primary up-date-button mt-md-4">{{ __('home.Save') }}</button>
    <script>

        function submitForm() {
            loadingMasterPage();
            const headers = {
                'Authorization': `Bearer ${token}`
            };
            const formData = new FormData();

            const arrField = ['name', 'name_en', 'name_laos', 'id'];

            arrField.forEach((field) => {
                formData.append(field, $(`#${field}`).val().trim());
            });

            formData.append('_token', '{{ csrf_token() }}');

            try {
                $.ajax({
                    url: `{{route('api.backend.service-clinic-pharmacy.update')}}`,
                    method: 'POST',
                    headers: headers,
                    contentType: false,
                    cache: false,
                    processData: false,
                    data: formData,
                    success: function (data) {
                        alert(data);
                        loadingMasterPage();
                        window.location.href = `{{route('api.backend.service-clinic-pharmacy.index')}}`;
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
