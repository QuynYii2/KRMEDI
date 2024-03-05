@extends('layouts.admin')
@section('title')
    {{ __('home.Update Symptoms') }}
@endsection
@section('main-content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('home.Update Symptoms') }}</div>

                    <div class="card-body">
                        <form action="{{ route('symptom.update', $symptom->id) }}" method="post"
                              enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label for="name">{{ __('home.Name') }}:</label>
                                    <input type="text" name="name" id="name" class="form-control"
                                           value="{{ $symptom->name }}" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="description">{{ __('home.Description') }}:</label>
                                <textarea class="form-control" name="description" id="description"
                                          rows="3">{{ $symptom->description }}</textarea>
                            </div>

                            <div class="form-group">
                                <label for="department">{{ __('home.Department') }}:</label>
                                <select id="department" class="form-control form-select" name="department">
                                    @foreach($departments as $department)
                                        <option {{ $symptom->department_id == $department->id ? 'selected' : '' }}
                                                value="{{$department->id}}">
                                            {{$department->name}}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="image">{{ __('home.Ảnh đại diện') }}:</label>
                                <input type="file" name="image" id="image" class="form-control" accept="image/*">
                                <img loading="lazy" src="{{ asset($symptom->thumbnail) }}" alt="l.l" width="80px">
                            </div>

                            <button type="submit" class="btn btn-primary">{{ __('home.Thêm mới') }}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
