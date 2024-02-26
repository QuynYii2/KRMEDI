@extends('layouts.admin')
@section('title')
    My Business Favourite
@endsection
<style>
    .business-item {
        border: 1px solid #ccc;
    }

    .business-image {
        max-width: 100%;
        max-height: 300px;
        object-fit: cover;
    }

    .business-name {
        font-size: 24px;
        font-weight: 600;
        display: -webkit-box;
        line-height: 1.3;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .business-type {
        font-size: 20px;
        font-weight: 600;
    }
</style>
@section('main-content')
    <h3 class="text-center">My Business Favourite</h3>
    <br>
    <div class="container-fluid">
        <div class="row mt-3 list_business">

        </div>
    </div>

    <script>
        let accessToken = `Bearer ` + token;
        let headers = {
            'Authorization': accessToken
        };

        $(document).ready(function () {
            loadBusiness();
        })

        async function loadBusiness() {
            loadingMasterPage();
            let businessUrl = `{{ route('api.backend.business.favourites.list') }}` + `?user_id={{ Auth::check() ? Auth::user()->id : '' }}`;

            await $.ajax({
                url: businessUrl,
                method: 'GET',
                headers: headers,
                success: function (response) {
                    loadingMasterPage()
                    renderBusiness(response);
                },
                error: function (error) {
                    loadingMasterPage()
                    console.log(error);
                }
            });
        }

        async function renderBusiness(response) {
            let html = ``;
            for (let i = 0; i < response.length; i++) {
                let data = response[i];
                let gallery = data.gallery;
                let list_images = gallery.split(',');
                html += `<div class="business-item p-1 mt-3 col-md-3 bg-white">
                        <img src="${list_images[0]}"
                            alt="" class="business-image">
                        <div class="business-info">
                            <div class="business-name">
                                Member name: ${data.name}
                            </div>
                            <div class="business-type">
                                Member type: ${data.type}
                            </div>
                        </div>
                    </div>`;
            }

            $('.list_business').empty().append(html);
        }
    </script>
@endsection
