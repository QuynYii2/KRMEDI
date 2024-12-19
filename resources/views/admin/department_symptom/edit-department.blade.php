@extends('layouts.admin')
@section('title')
    {{ __('home.Edit') }}
@endsection
@section('main-content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('home.Edit') }}</div>

                    <div class="card-body">
                        <form action="{{ route('view.admin.department.update', $department->id) }}" method="post"
                            enctype="multipart/form-data">
                            @csrf

                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label for="name">{{ __('home.Name') }}:</label>
                                    <input type="text" name="name" id="name" class="form-control"
                                        value="{{ $department->name }}" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="description">{{ __('home.Description') }}:</label>
                                <textarea class="form-control" name="description" id="description" rows="3">{{ $department->description }}</textarea>
                            </div>

                            <div class="form-group">
                                <label for="image">{{ __('home.Ảnh đại diện') }}:</label>
                                <input type="file" name="image" id="image" class="form-control" accept="image/*">
                                <img loading="lazy" src="{{ asset($department->thumbnail) }}" alt="" width="80px">
                            </div>

                            <div class="row">
                                <label for="image">Thứ tự sắp xếp:</label>
                                <div class="col-md-6">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="department_order_type"
                                            id="department_order_type_before" value="before" checked>
                                        <label class="form-check-label" for="department_order_type_before">Trước chuyên
                                            khoa</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="department_order_type"
                                            id="department_order_type_after" value="after">
                                        <label class="form-check-label" for="department_order_type_after">Sau chuyên
                                            khoa</label>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <select class="form-select" name="department_order_id">
                                        @forelse ($departments as $dep)
                                            @if ($dep->id != $department->id)
                                                <option value="{{ $dep->id }}">{{ $dep->name }}</option>
                                            @endif
                                        @empty
                                            <option value="" disabled>Không có chuyên khoa hợp lệ</option>
                                        @endforelse
                                    </select>
                                </div>
                            </div>
                            <br>

                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="isFilter" id="isFilter"
                                    {{ $department->isFilter ? 'checked' : '' }}>
                                <label class="form-check-label" for="isFilter">
                                    Khả dụng để lọc?
                                </label>
                            </div>
                            <br>

                            <button type="submit" class="btn btn-primary">{{ __('home.Thêm mới') }}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
