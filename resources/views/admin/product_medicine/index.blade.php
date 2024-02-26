@php use App\Enums\online_medicine\ObjectOnlineMedicine; @endphp
@php use App\Enums\online_medicine\FilterOnlineMedicine; @endphp
@extends('layouts.admin')
@section('title')
    {{ __('home.List product medicine') }}
@endsection
@section('main-content')
    <style>

    </style>
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">{{ __('home.List product medicine') }}</h1>
    <a href="{{ route('api.backend.product-medicine.create') }}" class="btn btn-primary mb-3">{{ __('home.Add') }}</a>
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
            <th scope="col">{{ __('home.Tên sản phẩm') }}</th>
            <th scope="col">{{ __('home.Ảnh thumb') }}</th>
            <th scope="col">{{ __('home.Object') }}</th>
            <th scope="col">{{ __('home.Filter') }}</th>
            <th scope="col">{{ __('home.Category') }}</th>
            <th scope="col">{{ __('home.Trạng thái') }}</th>
            <th scope="col">{{ __('home.Thao tác') }}</th>
        </tr>
        </thead>
        <tbody>
        @foreach($productMedicines as $index => $productMedicine)
            <tr>
                <th scope="row">{{ $index + 1 }}</th>
                <td>
                    @if(locationHelper() == 'vi')
                        {{ $productMedicine->name }}
                    @else
                        {{ $productMedicine->name_en }}
                    @endif
                </td>
                <td><img loading="lazy" src="{{ $productMedicine->thumb }}" alt="" width="100px"></td>
                <td>
                    @if($productMedicine->object_)
                        {{ ObjectOnlineMedicine::NAME_EN[$productMedicine->object_] }}
                    @endif
                </td>
                <td>
                    @if($productMedicine->object_)
                        {{ FilterOnlineMedicine::NAME_EN[$productMedicine->filter_] }}
                    @endif
                </td>
                <td>{{ $productMedicine->category_id }}</td>
                <td>{{ $productMedicine->status }}</td>
                <td>
                    <a href="{{ route('api.backend.product-medicine.edit', ['id' => $productMedicine->id]) }}"
                       class="btn btn-primary">{{ __('home.Edit') }}</a>
                    <button onclick="deleteCategoryProduct({{ $productMedicine->id }})"
                            class="btn btn-danger">{{ __('home.Delete') }}
                    </button>
                </td>
            </tr>
        @endforeach

        </tbody>
    </table>
    <div class="d-flex justify-content-center align-items-center">
        {{$productMedicines->links()}}
    </div>
    <script>

        function deleteCategoryProduct(id) {
            if (confirm('{{ __('home.Bạn có chắc chắn muốn xóa không') }}?')) {

                loadingMasterPage();
                let url = '{{ route('api.backend.product-medicine.destroy', ['id' => ':id']) }}';
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
                            window.location.href = `{{route('api.backend.product-medicine.index')}}`;
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
