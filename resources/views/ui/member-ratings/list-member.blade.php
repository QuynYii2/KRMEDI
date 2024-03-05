@php use App\Models\Province;

@endphp
@extends('layouts.master')
@section('title', 'Membership points')
<style>
    tr {
        transition: all 0.2s ease-in-out;
        border-radius: 0.2rem;
    }

    /*table tr:not(:nth-child(1)):not(:nth-child(2)):not(:nth-child(3)):hover {*/
    /*    background-color: #fff;*/
    /*    transform: scale(1.1);*/
    /*    -webkit-box-shadow: 0px 5px 15px 8px #e4e7fb;*/
    /*    box-shadow: 0px 5px 15px 8px #e4e7fb;*/
    /*}*/

    table tr:hover {
        cursor: pointer;
        background-color: #fff;
        transform: scale(1.1);
        -webkit-box-shadow: 0px 5px 15px 8px #e4e7fb;
        box-shadow: 0px 5px 15px 8px #e4e7fb;
    }


    tr:nth-child(1) {
        color: #fff;
    }

    tr:nth-child(2) {
        color: #fff;
    }

    tr:nth-child(3) {
        color: #fff;
    }

    td {
        vertical-align: middle !important;
        height: 5rem;
        font-size: 1.4rem;
        padding: 1rem 2rem;
        position: relative;
    }

    .number {
        width: 1rem;
        font-size: 2.2rem;
        font-weight: bold;
        text-align: left;
    }

    .username {
        text-align: left;
        font-size: 1.2rem;
    }

    .points {
        font-weight: bold;
        font-size: 1.3rem;
        display: flex;
        justify-content: flex-end;
        align-items: center;
    }

    .gold-medal {
        height: 3rem;
        margin-left: 1.5rem;
        max-width: 50px;
        object-fit: cover;
    }

    .me {
        background-color: #36CAA9 !important;
        color: #fff !important;
    }
</style>
@section('content')
    @include('layouts.partials.header')
    <div class="container pb-5" style="margin-top: 168px;">
        <div class="list-user d-flex justify-content-center align-items-center">
            <h3 class="">{{ __('home.Membership points') }}</h3>
        </div>
        <table class="table table-striped" id="table-list-user">
            <tbody id="list-user">

            </tbody>

        </table>
    </div>
    <script>
        let no1 = `<img class="gold-medal" src="{{ asset('img/icon/no1.png') }}" alt="" style="">`;
        let no2 = `<img class="gold-medal" src="{{ asset('img/icon/no2.png') }}" alt="" style="">`;
        let no3 = `<img class="gold-medal" src="{{ asset('img/icon/no3.png') }}" alt="" style="">`;
        let accessToken = `Bearer ` + token;

        let html = ``;

        $(document).ready(function () {
            callListUser();
        })

        async function callListUser() {
            loadingMasterPage()
            await $.ajax({
                url: `{{ route('api.backend.user.list.points') }}`,
                method: 'GET',
                headers: {
                    "Authorization": accessToken
                },
                success: function (response) {
                    renderUser(response);
                    loadingMasterPage()
                },
                error: function (exception) {
                    console.log(exception);
                    loadingMasterPage()
                }
            });
        }

        function renderUser(response) {
            let is_me = false;

            for (let i = 0; i < response.length; i++) {
                let user = response[i];
                let image = ``;
                if (i === 0) {
                    image = no1;
                } else if (i === 1) {
                    image = no2;
                } else if (i === 2) {
                    image = no3;
                }

                if (user.id == `{{ Auth::user()->id }}`) {
                    is_me = true;
                    html += `<tr class="">
                <td class="me number">${i + 1}</td>
                <td class="me username">
                    <p class="me">${user.username}</p>
                    <p class="me small">${user.email}</p>
                </td>
                <td class="me points">
                    <span class="">${user.points}</span>
                    ${image}
                </td>
            </tr>`;
                } else {
                    html += `<tr class="">
                <td class="number">${i + 1}</td>
                <td class="username">
                    <p>${user.username}</p>
                    <p class="small">${user.email}</p>
                </td>
                <td class="points">
                    <span class="">${user.points}</span>
                    ${image}
                </td>
            </tr>`;
                }
            }

            if (!is_me){
                html = html + ` <tr class="">
                <td class="me number"><p class="text-nowrap">--</p></td>
                <td class="me username">
                    <p class="me">{{ Auth::user()->username }}</p>
                    <p class="me small">{{ Auth::user()->email }}</p>
                </td>
                <td class="me points">
                    <span class="">{{ Auth::user()->points }}</span>
                </td>
            </tr>`
            }

            $('#list-user').empty().append(html);
            loadPaginate('table-list-user', 50);
        }
    </script>
@endsection
