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

                            <button type="submit" class="btn btn-primary">{{ __('home.Thêm mới') }}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
