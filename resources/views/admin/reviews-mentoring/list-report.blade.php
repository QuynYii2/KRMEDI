@extends('layouts.admin')
@section('title')
    Danh sách report câu hỏi tư vấn sức khỏe
@endsection
@section('main-content')
    <h3 class="text-center">Danh sách report câu hỏi tư vấn sức khỏe</h3>
    <div class="table-responsive">
        <table class="table text-nowrap" id="tableReviewsDoctorManagement">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Người report</th>
                <th scope="col">Nội dung</th>
            </tr>
            </thead>
            <tbody >
            @if(count($listData)>0)
            @foreach($listData as $key => $val)
            <tr>
                <th scope="row">{{$key+1}}</th>
                <td>{{$val->name_people}}</td>
                <td>{!! $val->content !!}</td>
            </tr>
                @endforeach
                @else
                <tr><th colspan="3" style="text-align: center;color: red">Không có report nào</th></tr>
                @endif
            </tbody>
        </table>
        <div class="d-flex justify-content-center align-items-center">
            {{$listData->links()}}
        </div>
    </div>
@endsection
