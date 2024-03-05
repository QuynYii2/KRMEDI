@extends('layouts.admin')
@section('title')
    {{ __('home.List Review Doctors') }}
@endsection
@section('main-content')
    <h3 class="text-center">{{ __('home.Review Doctor Management') }}</h3>
    <table class="table" id="tableReviewsDoctorManagement">
        <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">{{ __('home.Title') }}</th>
            <th scope="col">{{ __('home.Star') }}</th>
            <th scope="col">{{ __('home.Parent') }}</th>
            <th scope="col">{{ __('home.Status') }}</th>
            <th scope="col">{{ __('home.Action') }}</th>
        </tr>
        </thead>
        <tbody id="tbodyTableReviewsDoctorManagement">
        </tbody>
    </table>

    <script>
        let accessToken = `Bearer ` + token;
        let headers = {
            "Authorization": accessToken
        };

        $(document).ready(function () {
            loadReviewsDoctor();
        })

        async function loadReviewsDoctor() {
            let reviewUrl = `{{ route('api.medical.reviews.doctors.list')  }}`;

            await $.ajax({
                url: reviewUrl,
                method: "GET",
                headers: headers,
                success: function (response) {
                    renderReviewsDoctor(response);
                },
                error: function (error) {
                    console.log(error);
                }
            });
        }

        function renderReviewsDoctor(response) {
            let html = ``;
            for (let i = 0; i < response.length; i++) {
                let data = response[i];

                let reviewDetailUrl = `{{ route('view.reviews.doctor.detail', ['id'=>':id']) }}`;
                reviewDetailUrl = reviewDetailUrl.replace(':id', data.id);

                html = html + `<tr>
                                        <th scope="row">${i + 1}</th>
                                        <td>${data.title}</td>
                                        <td>${data.number_star}</td>
                                        <td>${data.parent_id}</td>
                                        <td>${data.status}</td>
                                        <td>
                                            <a href="${reviewDetailUrl}" class="btn btn-success" >{{ __('home.Detail') }}</a>
                                            <button type="button" class="btn btn-danger" id="btnDelete" onclick="confirmDeleteReviewsDoctor('${data.id}')">{{ __('home.Delete') }}</button>
                                        </td>
                                    </tr>`;
            }
            $('#tbodyTableReviewsDoctorManagement').empty().append(html);
            loadPaginate('tableReviewsDoctorManagement', 20);
        }

        function confirmDeleteReviewsDoctor(id) {
            if (confirm('Are you sure you want to delete!')) {
                deleteReviewsDoctor(id);
            }
        }

        async function deleteReviewsDoctor(id) {
            let reviewDeleteUrl = `{{ route('api.medical.reviews.doctors.delete', ['id'=>':id']) }}`;
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
