@extends('layouts.admin')
@section('title')
    {{ __('home.Create Symptoms') }}
@endsection
@section('main-content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('home.Create Symptoms') }}</div>

                    <div class="card-body">
                        <form action="{{ route('symptom.store') }}" method="post" enctype="multipart/form-data">
                            @csrf

                           <div class="row">
                               <div class="form-group col-md-12">
                                   <label for="name">{{ __('home.Name') }}:</label>
                                   <input type="text" name="name" id="name" class="form-control" required>
                               </div>
                           </div>

                            <div class="form-group">
                                <label for="description">{{ __('home.Description') }}:</label>
                                <textarea class="form-control" name="description" id="description" rows="3"></textarea>
                            </div>

                            <div class="form-group">
                                <label for="department">{{ __('home.departments') }}:</label>
                                <select id="department" class="form-control form-select" name="department">
                                    @foreach($departments as $department)
                                        <option value="{{$department->id}}">{{$department->name}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="image">{{ __('home.Ảnh đại diện') }}:</label>
                                <input required type="file" name="image" id="image" class="form-control-file" accept="image/*">
                            </div>

                            <div class="row">
                                <label for="image">Thứ tự sắp xếp:</label>
                                <div class="col-md-6">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="symptom_order_type"
                                            id="symptom_order_type_after" value="after" checked>
                                        <label class="form-check-label" for="symptom_order_type_after">Sau triệu chứng</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="symptom_order_type"
                                            id="symptom_order_type_before" value="before">
                                        <label class="form-check-label" for="symptom_order_type_before">Trước triệu chứng</label>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <select class="form-select" name="symptom_order_id">
                                        @forelse ($symptoms as $sym)
                                            <option value="{{ $sym->id }}">{{ $sym->name }}</option>
                                        @empty
                                            <option value="" disabled>Không có triệu chứng hợp lệ</option>
                                        @endforelse
                                    </select>
                                </div>
                            </div>
                            <br>

                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="isFilter" id="isFilter" checked>
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
