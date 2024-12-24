@extends('layouts.admin')
@section('title')
    Quản lý Dịch vụ
@endsection
@section('main-content')
    <div class="container">
        <!-- Page Heading -->
        <h1 class="h3 mb-4 text-gray-800">  {{ __('home.Create Service Clinics') }}</h1>
        @if (session('success'))
            <div class="alert alert-success border-left-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
        <form action="{{route('api.serviceHospital.store')}}" method="POST">
            @csrf
            <div class="row">
                <div class="form-group col-md-4">
                    <label for="name">{{ __('home.Name') }}</label>
                    <input type="text" class="form-control" id="name" name="name" required>
                </div>
                <div class="form-group col-md-4">
                    <label for="service_price">{{ __('home.Giá dịch vụ') }}</label>
                    <input type="number" class="form-control" id="service_price" name="service_price">
                </div>
                <div class="form-group col-md-4">
                    <label for="status">{{ __('home.Status') }}</label>
                    <select id="status" class="form-control" name="status">
                        <option value="ACTIVE">{{ __('home.Active') }}</option>
                        <option value="INACTIVE">{{ __('home.Inactive') }}</option>
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-4">
                    <label for="name">Thời gian bắt đầu giảm giá</label>
                    <input type="date" class="form-control" id="date_start" name="date_start">
                </div>
                <div class="form-group col-md-4">
                    <label for="service_price">Thời gian kết thúc giảm giá</label>
                    <input type="date" class="form-control" id="date_end" name="date_end">
                </div>
                <div class="form-group col-md-4">
                    <label for="status">Giá dịch vụ giảm giá</label>
                    <input type="number" class="form-control" id="service_price_promotion" name="service_price_promotion">
                </div>
            </div>
            <button type="submit" class="btn btn-primary float-right">{{ __('home.Save') }}</button>
        </form>
    </div>
@endsection