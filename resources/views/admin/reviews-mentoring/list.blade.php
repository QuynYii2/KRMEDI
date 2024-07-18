@extends('layouts.admin')
@section('title')
    Danh sách câu hỏi tư vấn sức khỏe
@endsection
@section('main-content')
    <h3 class="text-center">Danh sách câu hỏi tư vấn sức khỏe</h3>
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
