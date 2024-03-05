@extends('layouts.admin')
@section('title')
    My Medical Favourite
@endsection
<style>
    .medical-item {
        border: 1px solid #ccc;
    }

    .medical-image {
        max-width: 100%;
        object-fit: cover;
        height: auto;
    }

    .medical-name {
        font-size: 24px;
        font-weight: 600;
        display: -webkit-box;
        line-height: 1.3;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .medical-type {
        font-size: 20px;
        font-weight: 600;
    }
</style>
@section('main-content')
    <h3 class="text-center">My Medical Favourite</h3>
    <br>
    <div class="container-fluid">
        <div class="row mt-3 list_medical">

        </div>
    </div>

    <script>
        let accessToken = `Bearer ` + token;
        let headers = {
            'Authorization': accessToken
        };

        $(document).ready(function () {
            loadMedical();
        })

        async function loadMedical() {
            loadingMasterPage();
            let medicalUrl = `{{ route('api.backend.business.favourites.clinics') }}` + `?user_id={{ Auth::check() ? Auth::user()->id : '' }}`;

            await $.ajax({
                url: medicalUrl,
                method: 'GET',
                headers: headers,
                success: function (response) {
                    loadingMasterPage()
                    renderMedical(response);
                },
                error: function (error) {
                    loadingMasterPage()
                    console.log(error);
                }
            });
        }

        async function renderMedical(response) {
            let html = ``;
            for (let i = 0; i < response.length; i++) {
                let data = response[i];
                let medical = data.doctor_info;
                html += `<div class="medical-item p-1 mt-3 col-md-3 bg-white">
                        <img src="${medical.avt}"
                            alt="" class="medical-image">
                        <div class="medical-info">
                            <div class="medical-name">
                                Member username: ${medical.username}
                            </div>
                            <div class="medical-type">
                                Member type: ${medical.member}
                            </div>
                        </div>
                    </div>`;
            }

            $('.list_medical').empty().append(html);
        }
    </script>
@endsection
