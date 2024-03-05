@extends('layouts.admin')
@section('title')
    {{ __('home.List Category product') }}
@endsection
@section('main-content')
    <style>

    </style>
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">{{ __('home.List Category product') }}</h1>
    <a href="{{ route('api.backend.category-product.create') }}" class="btn btn-primary mb-3">{{ __('home.Add') }}</a>
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
            <th scope="col">{{ __('home.Tên category') }}</th>
            <th scope="col">{{ __('home.Trạng thái') }}</th>
            <th scope="col">{{ __('home.Thao tác') }}</th>
        </tr>
        </thead>
        <tbody>
        @foreach($categoryProducts as $index => $categoryProduct)
            <tr>
                <th scope="row">{{ ++$index }}</th>
                <td>
                    @if(locationHelper() == 'vi')
                        {{ $categoryProduct->name }}
                    @else
                        {{ $categoryProduct->name_en }}
                    @endif
                </td>
                <td>{{ $categoryProduct->status == 1 ? 'Active' : ($categoryProduct->status == 0 ? 'Inactive' : '') }}</td>
                <td>
                    <a href="{{ route('api.backend.category-product.edit', ['id' => $categoryProduct->id]) }}"
                       class="btn btn-primary">{{ __('home.Edit') }}</a>
                    <button type="button" onclick="deleteCategoryProduct({{ $categoryProduct->id }})"
                            class="btn btn-danger">{{ __('home.Delete') }}
                    </button>
                </td>
            </tr>
        @endforeach

        </tbody>
    </table>
    <div class="d-flex justify-content-center align-items-center">
        {{$categoryProducts->links()}}
    </div>
    <script>

        function deleteCategoryProduct(id) {
            if (confirm('{{ __('home.Bạn có chắc chắn muốn xóa không') }}?')) {

                loadingMasterPage();
                let url = '{{ route('api.backend.category-product.destroy', ['id' => ':id']) }}';
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
                            window.location.href = `{{route('api.backend.category-product.index')}}`;
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
