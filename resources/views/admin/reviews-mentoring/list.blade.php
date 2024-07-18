@extends('layouts.admin')
@section('title')
    Danh sách câu hỏi tư vấn sức khỏe
@endsection
@section('main-content')
    <h3 class="text-center">Danh sách câu hỏi tư vấn sức khỏe</h3>
    <br>
    <form action="{{route('view.reviews.mentoring.index')}}" method="get">
        <div class="card-body d-flex align-items-end flex-wrap p-0 pb-3">
            <div class="col-lg-4 col-md-4 col-6 px-1">
                <lable>Danh mục</lable>
                <select class="form-select w-100" name="category_id" >
                    <option class="bg-white" value="">--Danh mục--</option>
                   @foreach($departments as $item)
                    <option class="bg-white" @if(request()->get('category_id') == $item->id) selected @endif value="{{$item->id}}">{{$item->name}}</option>
                       @endforeach
                </select>
            </div>
            <div class="col-lg-4 col-md-4 col-6 px-1">
                <lable>Trạng thái</lable>
                <select class="form-select w-100" name="status" >
                    <option class="bg-white" value="">--Trạng thái--</option>
                    <option class="bg-white" @if(request()->get('status') == 'APPROVED') selected @endif value="APPROVED">APPROVED</option>
                    <option class="bg-white" @if(request()->get('status') == 'PENDING') selected @endif value="PENDING">PENDING</option>
                    <option class="bg-white" @if(request()->get('status') == 'REFUSE') selected @endif value="REFUND">REFUSE</option>
                </select>
            </div>
            <div class="col-md-4 col-12 px-0 mt-2">
                <button type="submit" class="btn btn-warning mx-2">Tìm kiếm</button>
                <a href="{{route('view.reviews.mentoring.index')}}" class="btn btn-dark">Làm mới</a>
            </div>
        </div>
    </form>
    <br>
    <div class="table-responsive">
        <table class="table text-nowrap" id="tableReviewsDoctorManagement">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Tiêu đề</th>
                <th scope="col">Danh mục</th>
                <th scope="col">Trạng thái</th>
                <th scope="col">Thao tác</th>
                <th scope="col">DS Report</th>
            </tr>
            </thead>
            <tbody >
            @foreach($questions as $key => $val)
            <tr>
                <th scope="row">{{$key+1}}</th>
                <td>{{$val->title}}</td>
                <td>{{$val->name_category}}</td>
                <td>{{$val->status}}</td>
                <td>
                    <a href="{{route('view.reviews.mentoring.detail',$val->id)}}" class="btn btn-success" >{{ __('home.Detail') }}</a>
                    <button type="button" class="btn btn-danger" id="btnDelete" onclick="confirmDeleteReviewsDoctor({{$val->id}})">{{ __('home.Delete') }}</button>
                </td>
                <td><a href="{{route('view.reviews.mentoring.report',$val->id)}}" class="btn btn-warning" >report</a></td>
            </tr>
                @endforeach
            </tbody>
        </table>
        <div class="d-flex justify-content-center align-items-center">
            {{$questions->links()}}
        </div>
    </div>

    <script>
        function confirmDeleteReviewsDoctor(id) {
            if (confirm('Are you sure you want to delete!')) {
                deleteReviewsDoctor(id);
            }
        }

         function deleteReviewsDoctor(id) {
            let reviewDeleteUrl = `{{ route('view.reviews.mentoring.delete', ['id'=>':id']) }}`;
            reviewDeleteUrl = reviewDeleteUrl.replace(':id', id);

             $.ajax({
                url: reviewDeleteUrl,
                method: "DELETE",
                 headers: {
                     'Authorization': `Bearer ${token}`,
                     'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                 },
                success: function (response) {
                    alert('Delete success!');
                    window.location.reload();
                },
                error: function (error) {
                    console.log(error);
                }
            });
        }
    </script>
@endsection
