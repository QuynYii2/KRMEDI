@extends('layouts.admin')
@section('title')
    {{ __('home.List Reviews') }}
@endsection
@section('main-content')
    <h3 class="text-center">{{ __('home.Review Management') }}</h3>
    <table class="table table-striped" id="tableReviewsManagement">
        <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">{{ __('home.Full Name') }}</th>
            <th scope="col">{{ __('home.Email') }}</th>
            <th scope="col">{{ __('home.PhoneNumber') }}</th>
            <th scope="col">{{ __('home.Addresses') }}</th>
            <th scope="col">{{ __('home.Star') }}</th>
            <th scope="col">{{ __('home.Content') }}</th>
            <th scope="col">{{ __('home.Status') }}</th>
            <th scope="col">{{ __('home.Action') }}</th>
        </tr>
        </thead>
        <tbody id="tbodyTableReviewsManagement">

        </tbody>
    </table>
    <script>
        let accessToken = `Bearer ` + token;
        let headers = {
            "Authorization": accessToken
        };

        $(document).ready(function () {
            loadReviews();

        })

        async function loadReviews() {
            let reviewUrl = `{{ route('api.backend.reviews.list') }}`;

            await $.ajax({
                url: reviewUrl,
                method: "GET",
                headers: headers,
                success: function (response) {
                    renderReviews(response);
                },
                error: function (error) {
                    console.log(error);
                }
            });
        }

        function renderReviews(response) {
            let html = ``;
            for (let i = 0; i < response.length; i++) {
                let data = response[i];

                let reviewDetailUrl = `{{ route('view.admin.reviews.detail', ['id'=> ':id']) }}`;
                reviewDetailUrl = reviewDetailUrl.replace(':id', '');

                html = html + `<tr>
                                        <th scope="row">${i + 1}</th>
                                        <td>${data.name}</td>
                                        <td>${data.email}</td>
                                        <td>${data.phone}</td>
                                        <td>${data.address}</td>
                                        <td>${data.star}</td>
                                        <td>
                                        @if(locationHelper() == 'vi')
                                            ${data.content}
                                            @else
                                            ${data.content_en}
                                            @endif
                                        </td>
                                        <td>${data.status}</td>
                                        <td>
                                            <a href="${reviewDetailUrl + data.id}" class="btn btn-success" >{{ __('home.Detail') }}</a>
                                            <button type="button" class="btn btn-danger" id="btnDelete" onclick="confirmDeleteReviews('${data.id}')">{{ __('home.Delete') }}</button>
                                        </td>
                                    </tr>`;
            }
            $('#tbodyTableReviewsManagement').empty().append(html);
            loadPaginate('tableReviewsManagement', 20);
        }

        function confirmDeleteReviews(id) {
            if (confirm('Are you sure you want to delete!')) {
                deleteReviews(id);
            }
        }

        async function deleteReviews(id) {
            let reviewDeleteUrl = `{{ route('api.backend.reviews.delete', ['id'=>':id']) }}`;
            reviewDeleteUrl = reviewDeleteUrl.replace(':id', id);

            await $.ajax({
                url: reviewDeleteUrl,
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
