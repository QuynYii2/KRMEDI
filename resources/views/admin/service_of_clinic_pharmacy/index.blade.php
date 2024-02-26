@extends('layouts.admin')

@section('main-content')
    <style>

    </style>
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">{{ __('home.List service of clinic pharmacy') }}</h1>
    <a href="{{ route('api.backend.service-clinic-pharmacy.create') }}" class="btn btn-primary mb-3">{{ __('home.Add') }}</a>
    @if (session('success'))
        <div class="alert alert-success border-left-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <table class="table table-striped">
        <thead>
        <tr>
            <th scope="col">STT</th>
            <th scope="col">{{ __('home.Name') }} </th>
            <th scope="col">{{ __('home.name_en') }}</th>
            <th scope="col">{{ __('home.name_laos') }}</th>
            <th scope="col">{{ __('home.Thao tác') }} </th>
        </tr>
        </thead>
        <tbody>
        @foreach($serviceClinics as $index => $serviceClinic)
            <tr>
                <th scope="row">{{ $index + 1 }}</th>
                <td>{{ $serviceClinic->name }}</td>
                <td>{{ $serviceClinic->name_en }}</td>
                <td>{{ $serviceClinic->name_laos }}</td>
                <td>
                    <a href="{{ route('api.backend.service-clinic-pharmacy.edit', ['id' => $serviceClinic->id]) }}" class="btn btn-primary">{{ __('home.Sửa') }} </a>
                    <button onclick="deleteRecord({{ $serviceClinic->id }})" class="btn btn-danger">{{ __('home.Delete') }} </button>
                </td>
            </tr>
        @endforeach

        </tbody>
    </table>
    <div class="align-items-center justify-content-center d-flex">
        {{$serviceClinics->links()}}
    </div>
    <script>

        function deleteRecord(id) {
            if (confirm('{{ __('home.Bạn có chắc chắn muốn xóa không') }} ?')) {

                loadingMasterPage();
                let url = '{{ route('api.backend.service-clinic-pharmacy.destroy', ['id' => ':id']) }}';
                url = url.replace(':id', id);

                const headers = {
                    'Authorization': `Bearer ${token}`
                };
                const formData = new FormData();
                formData.append('_token', '{{ csrf_token() }}');

                try {
                    $.ajax({
                        url: url,
                        method: 'POST',
                        headers: headers,
                        contentType: false,
                        cache: false,
                        data: formData,
                        processData: false,
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
                }
            }
        }
    </script>

@endsection
