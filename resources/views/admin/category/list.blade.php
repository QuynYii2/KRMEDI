@extends('layouts.admin')
@section('title')
    {{ __('home.List Category') }}
@endsection
@section('main-content')
    <h3 class="text-center">{{ __('home.Category Management') }}</h3>
    <a href="{{ route('view.admin.category.create') }}" class="btn btn-primary mb-3">{{ __('home.create') }}</a>
    <table class="table table-striped" id="tableCategoryManagement">
        <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">{{ __('home.Title') }}</th>
            <th scope="col">{{ __('home.Description') }}</th>
            <th scope="col">{{ __('home.Parent') }}</th>
            <th scope="col">{{ __('home.Status') }}</th>
            <th scope="col">{{ __('home.Action') }}</th>
        </tr>
        </thead>
        <tbody id="tbodyTableCategoryManagement">

        </tbody>
    </table>

    <script>
        let accessToken = `Bearer ` + token;
        let headers = {
            "Authorization": accessToken
        };

        $(document).ready(function () {
            async function loadCategory() {
                let categoryUrl = `{{ route('api.business.categories.list')  }}`;

                await $.ajax({
                    url: categoryUrl,
                    method: "GET",
                    headers: headers,
                    success: function (response) {
                        console.log(response);
                        renderCategory(response);
                    },
                    error: function (error) {
                        console.log(error);
                    }
                });
            }

            loadCategory();

            function renderCategory(response) {
                let html = ``;
                for (let i = 0; i < response.length; i++) {
                    let data = response[i];

                    let categoryDetailUrl = `{{ route('view.admin.category.detail', ['id'=>':id']) }}`;
                    categoryDetailUrl = categoryDetailUrl.replace(':id', data.id);

                    html = html + `<tr>
                                        <th scope="row">${i + 1}</th>
                                        <td>
                                            <span class="text-shortcut">${data.name}</span>
                                        </td>
                                        <td>
                                            <span class="text-shortcut">${data.description}</span>
                                        </td>
                                        <td>${data.parent_id}</td>
                                        <td>${data.status}</td>
                                        <td>
                                            <a href="${categoryDetailUrl}" class="btn btn-success" >{{ __('home.Detail') }}</a>
                                            <button type="button" class="btn btn-danger" id="btnDelete" onclick="confirmDeleteCategory('${data.id}')">{{ __('home.Delete') }}</button>
                                        </td>
                                    </tr>`;
                }
                $('#tbodyTableCategoryManagement').empty().append(html);
            }

        })

        function confirmDeleteCategory(id) {
            if (confirm('Are you sure you want to delete!')) {
                deleteCategory(id);
            }
        }

        async function deleteCategory(id) {
            let categoryDeleteUrl = `{{ route('api.business.categories.delete', ['id'=>':id']) }}`;
            categoryDeleteUrl = categoryDeleteUrl.replace(':id', id);

            await $.ajax({
                url: categoryDeleteUrl,
                method: "DELETE",
                headers: headers,
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
