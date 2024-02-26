@extends('layouts.admin')
@section('title')
    List User
@endsection
@section('main-content')
    <div class="">
        <!-- Page Heading -->
        <h1 class="h3 mb-4 text-gray-800"> List User </h1>
        <div class="d-flex align-items-center justify-content-between">
            <div class="mb-3 col-md-3">
                <input class="form-control" id="inputSearchUser" type="text" placeholder="Search.."/>
            </div>
            <a href="{{route('view.admin.user.create')}}" class="btn btn-primary mb-3">{{ __('home.Add') }}</a>
        </div>
        <br>
        <table class="table" id="tableListUser">
            <thead>
            <tr>
                <th scope="col">{{ __('home.STT') }}</th>
                <th scope="col">{{ __('home.Name') }}</th>
                <th scope="col">{{ __('home.Last Name') }}</th>
                <th scope="col">{{ __('home.Username') }}</th>
                <th scope="col">{{ __('home.Email') }}</th>
                <th scope="col">{{ __('home.PhoneNumber') }}</th>
                <th scope="col">{{ __('home.Member') }}</th>
                <th scope="col">{{ __('home.Type Account') }}</th>
                <th scope="col">{{ __('home.Status') }}</th>
                <th scope="col">{{ __('home.Action') }}</th>
            </tr>
            </thead>
            <tbody id="tbodyListUser">
            </tbody>
        </table>
    </div>
    <script>
        let accessToken = `Bearer ` + token;
        let headers = {
            Authorization: accessToken,
        }

        $(document).ready(function () {
            callListUser();
        });

        async function callListUser() {
            await $.ajax({
                url: `{{route('api.admin.users.list')}}`,
                method: 'GET',
                headers: headers,
                success: function (response) {
                    renderUser(response);
                },
                error: function (exception) {
                    console.log(exception)
                }
            });
        }

        function renderUser(response) {
            let html = ``;
            for (let i = 0; i < response.length; i++) {
                let urlDetail = `{{ route('view.admin.user.detail', ['id'=>':id']) }}`;
                let data = response[i];
                urlDetail = urlDetail.replace(':id', data.id)
                html = html + `<tr>
                                    <td>${i + 1}</td>
                                    <td>${data.name}</td>
                                    <td>${data.last_name}</td>
                                    <td>${data.username}</td>
                                    <td>${data.email}</td>
                                    <td>${data.phone}</td>
                                    <td>${data.member}</td>
                                    <td>${data.type}</td>
                                    <td>${data.status}</td>
                                    <td>
                                         <div class="d-flex align-items-center">
                                            <a href="${urlDetail}" class="btn btn-primary">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                            </a>
                                            <button onclick="confirmDeleteUser('${data.id}')" type="button" class="btn btn-danger">
                                                <i class="fa-regular fa-trash-can"></i>
                                            </button>
                                         </div>
                                    </td>
                                </tr>`;
            }

            $('#tbodyListUser').empty().append(html);
            loadPaginate('tableListUser', 20);
            searchMain('inputSearchUser', 'tableListUser');
        }

        function confirmDeleteUser(id) {
            let text = `Are you sure you want to delete?`;
            if (confirm(text) === true) {
                deleteUser(id);
            }
        }

        async function deleteUser(id) {
            let deleteUrl = `{{ route('api.admin.users.delete', ['id'=>':id']) }}`;
            deleteUrl = deleteUrl.replace(':id', id);

            try {
                await $.ajax({
                    url: deleteUrl,
                    method: 'DELETE',
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

