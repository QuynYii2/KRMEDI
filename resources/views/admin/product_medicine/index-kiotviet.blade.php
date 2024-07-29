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
    <h1 class="h3 mb-4 text-gray-800">Danh sách sản phẩm bên kiotviet</h1>
    @if (session('success'))
        <div class="alert alert-success border-left-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
    <form action="{{ route('api.backend.list-product-kiotviet') }}" method="GET" enctype="multipart/form-data">
        @csrf
        <div class="row" style="margin-bottom: 20px">
            <div class="col-md-4 col-sm-6 col-xs-12">
                <select name="id_category" id="selectedCategory" class="form-control" required>
                    <option value="">---- Chọn nhóm hàng ----</option>
                    @foreach ($categories as $item)
                        <option value="{{ $item['categoryId'] }}" @if($item['categoryId'] == $Category_id) selected @endif>{{ $item['categoryName'] }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2 col-sm-6 col-xs-12">
                <button type="submit" class="btn btn-outline-primary" style="background:#00B7FF;color:white">Lọc
                </button>
            </div>
        </div>
    </form>
    <div class="table-responsive">
        <table class="table table-striped text-nowrap">
            <thead>
            <tr>
                <th scope="col">STT</th>
                <th scope="col">{{ __('home.Category') }}</th>
                <th scope="col">{{ __('home.Tên sản phẩm') }}</th>
                <th scope="col">Giá</th>
                <th scope="col">{{ __('home.Thao tác') }}</th>
            </tr>
            </thead>
            <tbody>
            @foreach($paginator as $index => $value)
                <tr>
                    <th scope="row">{{ $index + 1 }}</th>
                    <td>
                        {{$value['categoryName']}}
                    </td>
                    <td>
                        {{$value['name']}}
                    </td>
                    <td>
                        {{number_format($value['basePrice'])}} VNĐ
                    </td>
                    <td>
                        <a href="{{ route('api.backend.create-product-kiot-viet', ['id' => $value['id']]) }}"
                           class="btn btn-primary">Thêm sản phẩm</a>
                    </td>
                </tr>
            @endforeach

            </tbody>
        </table>
        <div class="d-flex justify-content-center align-items-center">
            {{$paginator->links()}}
        </div>
    </div>

@endsection
