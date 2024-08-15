@extends('layouts.admin')
@section('title')
    List footer
@endsection
@section('main-content')
    <div class="">
        <!-- Page Heading -->
        <h1 class="h3 mb-4 text-gray-800"> Danh sách Version </h1>
        <div class="d-flex align-items-center justify-content-end">
            <a href="{{route('view.admin.version.create')}}" class="btn btn-primary mb-3">Thêm mới</a>
        </div>
        <br>
        <div class="table-responsive">
            <table class="table text-nowrap" id="tableListUser">
                <thead>
                <tr>
                    <th scope="col">STT</th>
                    <th scope="col">Version old</th>
                    <th scope="col">Version new</th>
                    <th scope="col">Note</th>
                    <th scope="col">Thể loại</th>
                    <th scope="col">Thao tác</th>
                </tr>
                </thead>
                <tbody id="tbodyListUser">
                @foreach($listData as $index => $val)
                    <tr>
                        <td>{{$index+1}}</td>
                        <td>{{@$val->version_current}}</td>
                        <td>{{$val->version_update}}</td>
                        <td>{!! $val->note_update !!}</td>
                        <td>@if($val->type == 0)
                                Android
                            @else
                                IOS
                            @endif
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                <a href="{{route('view.admin.version.edit',$val->id)}}" class="btn btn-primary">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </a>
                                <a href="{{route('view.admin.version.delete',$val->id)}}" class="btn btn-danger">
                                    <i class="fa-regular fa-trash-can"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

    </div>
@endsection
