@extends('layouts.admin')
@section('title', 'General configuration')
@section('main-content')
    <h1 class="h3 mb-4 text-gray-800">Sửa footer </h1>
    @if (session('error'))
        <div
            class="alert alert-danger bg-danger text-light border-0 alert-dismissible fade show"
            role="alert">
            {{session('error')}}
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"
                    aria-label="Close"></button>
        </div>
    @endif
        <form id="form" action="{{route('view.admin.footer.update',$footer->id)}}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-sm-4">
                    <label for="address">Tiêu đề </label>
                    <input type="text" class="form-control" id="title" name="title" value="{{$footer->title}}" required>
                </div>
            </div>
            <div class="form-group">
                <label for="content">Nội dung</label>
                <textarea class="form-control" name="content"
                          id="content">{!! $footer->content !!}</textarea>
            </div>

            <button type="submit" class="btn btn-primary up-date-button mt-md-4">{{ __('home.Save') }}</button>
        </form>

@endsection
