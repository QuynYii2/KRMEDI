@extends('layouts.admin')
@section('title')
    Quản lý Dịch vụ
@endsection
@section('main-content')
    <div class="">
        <!-- Page Heading -->
        <h1 class="h3 mb-4 text-gray-800">{{ __('home.List Service Clinics') }}</h1>
        <div class="d-flex align-items-center justify-content-between mb-4">
            <a href="{{route('api.serviceHospital.create')}}" class="btn btn-primary mb-3">{{ __('home.Add') }}</a>
            <form action="{{ route('service-clinics.import') }}" method="POST" enctype="multipart/form-data" class="d-flex align-items-center">
                @csrf
                <div>
                    <label for="file">Chọn file Excel:</label>
                    <input type="file" name="file" id="file" accept=".xlsx, .xls,.csv" required>
                </div>
                <button type="submit" class="form-control btn btn-success">Import</button>
            </form>
        </div>

        @if (session('success'))
            <div class="alert alert-success border-left-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
        <div class="table-responsive">
            <table class="table text-nowrap" id="tableListService">
                <thead>
                <tr>
                    <th scope="col">{{ __('home.Name') }}</th>
                    <th scope="col">Giá</th>
                    <th scope="col">{{ __('home.Status') }}</th>
                    <th scope="col">{{ __('home.Active') }}</th>
                </tr>
                </thead>
                <tbody id="tbodyListService">
                    @foreach($services as $serviceHospital)
                        <tr>
                            <td>{{$serviceHospital->name}}</td>
                            <td>{{$serviceHospital->service_price}}</td>
                            <td>{{$serviceHospital->status}}</td>
                            <td>
                                <a href="{{route('api.serviceHospital.edit', ['id' => $serviceHospital->id])}}"
                                   class="btn btn-primary">{{ __('home.Edit') }}</a>
                                <a href="{{route('api.serviceHospital.destroy', ['id' => $serviceHospital->id])}}"
                                   class="btn btn-danger"
                                   onclick="return confirm('Bạn có chắc chắn muốn xóa không?')">{{ __('home.Delete') }}</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>
@endsection
