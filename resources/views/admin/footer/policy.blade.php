@extends('layouts.admin')
@section('title', 'Chính sách')
@section('main-content')
    <h1 class="h3 mb-4 text-gray-800">Chính sách </h1>
    @if (session('error'))
        <div
            class="alert alert-danger bg-danger text-light border-0 alert-dismissible fade show"
            role="alert">
            {{session('error')}}
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"
                    aria-label="Close"></button>
        </div>
    @endif
    @if (session('success'))
        <div
            class="alert alert-success bg-success text-light border-0 alert-dismissible fade show"
            role="alert">
            {{session('success')}}
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"
                    aria-label="Close"></button>
        </div>
    @endif
        <form id="form" action="{{route('view.admin.policy.store')}}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="content">Nội dung</label>
                <textarea class="form-control" name="content"
                          id="content">{!! @$data->content !!}</textarea>
            </div>

            <button type="submit" class="btn btn-primary up-date-button mt-md-4">{{ __('home.Save') }}</button>
        </form>

@endsection
