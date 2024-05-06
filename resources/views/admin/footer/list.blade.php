@extends('layouts.admin')
@section('title')
    List footer
@endsection
@section('main-content')
    <div class="">
        <!-- Page Heading -->
        <h1 class="h3 mb-4 text-gray-800"> List footer </h1>
        <div class="d-flex align-items-center justify-content-end">
            <a href="{{route('view.admin.footer.create')}}" class="btn btn-primary mb-3">Thêm mới</a>
        </div>
        <br>
        <table class="table" id="tableListUser">
            <thead>
            <tr>
                <th scope="col">STT</th>
                <th scope="col">Tiêu đề</th>
                <th scope="col">Hoạt động</th>
            </tr>
            </thead>
            <tbody id="tbodyListUser">
                @foreach($listData as $index => $val)
                    <tr>
                        <td>{{$index+1}}</td>
                        <td>{{$val->title}}</td>
                        <td>
                            <div class="d-flex align-items-center">
                                <a href="{{route('view.admin.footer.edit',$val->id)}}" class="btn btn-primary">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </a>
                                <button onclick="confirmDeleteUser({{$val->id}})" type="button" class="btn btn-danger">
                                    <i class="fa-regular fa-trash-can"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
            </tbody>
        </table>
    </div>
    <script>
        let accessToken = `Bearer ` + token;
        let headers = {
            Authorization: accessToken,
        }


        function confirmDeleteUser(id) {
            let text = `Are you sure you want to delete?`;
            if (confirm(text) === true) {
                deleteUser(id);
            }
        }

        async function deleteUser(id) {
            let deleteUrl = `{{ route('view.admin.footer.delete', ['id'=>':id']) }}`;
            deleteUrl = deleteUrl.replace(':id', id);

            try {
                await $.ajax({
                    url: deleteUrl,
                    method: 'GET',
                    headers: headers,
                    success: function (response) {
                        alert('Delete success!');
                        window.location.reload();
                    },
                    error: function (error) {
                        alert(error.responseJSON.message);
                    }
                });
            } catch (e) {
                alert('Delete error!');
            }
        }
    </script>
@endsection

