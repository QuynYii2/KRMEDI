@extends('layouts.admin')
@section('title', 'General configuration')
@section('main-content')
    <h1 class="h3 mb-4 text-gray-800">Sửa version </h1>
    @if (session('error'))
        <div
            class="alert alert-danger bg-danger text-light border-0 alert-dismissible fade show"
            role="alert">
            {{session('error')}}
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"
                    aria-label="Close"></button>
        </div>
    @endif
        <form id="form" action="{{route('view.admin.version.update',$data->id)}}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-2">
                    <label for="address">Version: </label>
                </div>
                <div class="col-10">
                    <input type="text" class="form-control" id="title" value="{{$data->version_update}}" name="version_update" required>
                </div>
            </div>
            <div class="form-group">
                <label for="content">Nội dung</label>
                <textarea class="form-control" name="note_update"
                          id="note_update">{!! $data->note_update !!}</textarea>
            </div>
            <div class="row mb-3">
                <div class="col-2">
                    <label>Trạng thái </label>
                </div>
                <div class="col-10">
                    <select name="need_update" class="form-control">
                        <option value="1" @if($data->need_update == 1) selected @endif>Bắt buộc</option>
                        <option value="0" @if($data->need_update == 0) selected @endif>Không bắt buộc</option>
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="col-2">
                    <label>Loại máy </label>
                </div>
                <div class="col-10">
                    <select name="type" class="form-control">
                        <option value="0" @if($data->type == 0) selected @endif>Android</option>
                        <option value="1" @if($data->type == 1) selected @endif>IOS</option>
                    </select>
                </div>
            </div>

            <button type="submit" class="btn btn-primary up-date-button mt-md-4">{{ __('home.Save') }}</button>
        </form>

@endsection
