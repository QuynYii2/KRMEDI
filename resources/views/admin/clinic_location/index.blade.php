@extends('layouts.admin')
@section('title')
    Quản lý địa chỉ
@endsection
@section('main-content')
    <div class="">
        <h1 class="h3 mb-4 text-gray-800">Danh sách cơ sở</h1>
        <a href="{{route('api.clinic-location.create', ['user_id' => $userID])}}" class="btn btn-primary mb-3">{{ __('home.Add') }}</a>
        @if (session('success'))
            <div class="alert alert-success border-left-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
        <div class="table-responsive">
            <table class="table text-nowrap" id="tableListAddress">
                <thead>
                <tr>
                    <th scope="col">Địa chỉ chi tiết</th>
                    <th scope="col">{{ __('home.Status') }}</th>
                    <th scope="col">{{ __('home.Active') }}</th>
                </tr>
                </thead>
                <tbody id="tbodyListAddress">
                @forelse($addresses as $address)
                    <tr>
                        <td>{{$address->address_detail . ', ' . $address->commune_name . ', ' . $address->district_name . ', ' . $address->province_name}}</td>
                        <td>{{$address->status}}</td>
                        <td>
                            <a href="{{route('api.clinic-location.edit', ['user_id' => $userID, 'id' => $address->id])}}"
                               class="btn btn-primary">{{ __('home.Edit') }}</a>
                            <a href="{{route('api.clinic-location.destroy', ['id' => $address->id])}}"
                               class="btn btn-danger"
                               onclick="return confirm('Bạn có chắc chắn muốn xóa không?')">{{ __('home.Delete') }}</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="text-center">Chưa có địa chỉ</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

    </div>
@endsection
