@extends('layouts.master')
@section('title', 'Home')
@section('content')
    @include('layouts.partials.header_3')
    @include('component.banner')

    <style>
        .list-doctor .card img {
            height: 300px;
        }
    </style>
    <div class="container">
        <div class="d-flex">
            <div class="col-md-3 mr-2 d-md-block d-none">
                <div class="">
                    <div class="flea-adv row align-items-center justify-content-center">
                        <div class="">
                            <img src="{{asset('img/image 16.png')}}" alt="" style="width: 270px;height: 682px">
                        </div>
                    </div>
                </div>
                <div class="">
                    <div class="flea-adv row align-items-center justify-content-center">
                        <div class="">
                            <img src="{{asset('img/image 16.png')}}" alt="" style="width: 270px;height: 682px">
                        </div>
                    </div>
                </div>
            </div>
            @if(Auth::check())
                <div class="col-md-9 medicine-list--item">
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="productList" role="tabpanel"
                             aria-labelledby="productList-tab">
                            <div>
                                <h3><b>{{ __('home.My personal doctor') }}</b></h3>
                                <hr>
                            </div>
                            <div class="list-doctor row" id="listMyDoctor">
                            </div>
                        </div>
                        <div class="tab-pane fade" id="review" role="tabpanel" aria-labelledby="review-tab">
                        </div>
                        <div class="tab-pane fade" id="wishList" role="tabpanel" aria-labelledby="wishList-tab">
                            <div class="row">

                            </div>
                        </div>

                    </div>
                </div>
            @else
                <p class="text-center">{{ __('home.Please login to continue') }}!</p>
            @endif
        </div>
    </div>
    <div class="">
        @if(Auth::check())
            <input type="text" class="d-none" id="inputReadMyDoctor" value="{{ Auth::user()->id }}">
        @endif
    </div>
    <script>
        $(document).ready(function () {
            processReadMyDoctor();

            async function processReadMyDoctor() {
                let userID = $('#inputReadMyDoctor').val();
                if (userID) {
                    await readMyDoctor(userID);
                }
            }

            async function readMyDoctor(id) {
                let url = `{{ route('doctors.info.restapi.my.doctor', ['id'=>':id']) }}`;
                url = url.replace(':id', id);
                await $.ajax({
                    url: url,
                    method: 'GET',
                    success: function (response) {
                        renderMyDoctor(response);
                    },
                    error: function (exception) {
                        console.log(exception)
                    }
                });
            }

            function renderMyDoctor(res) {
                let html = ``;
                for (let i = 0; i < res.length; i++) {
                    let data = res[i];
                    let route = `{{route('examination.doctor_info', ['id'=>':id'])}}`;
                    route = route.replace(':id', data['id']);

                    html = html + `<div class="col-md-3 col-6">
                                    <div class="card" >
                                    <i class="bi bi-heart"></i>
                                    <img src="${data.avt}" class="card-img-top" alt="...">
                                    <div class="card-body">
                                        <a href="${route}" target="_blank"><h5 class="card-title">${data['name']}</h5></a>
                                        <p class="card-text_1">{{ __('home.Location') }}: <b>Hanoi</b></p>
                                        <p class="card-text_1">{{ __('home.Working time') }}: <b>${data['time_working_1']} - ${data['time_working_2']}</b></p>
                                    </div>
                                    </div>
                                </div>`;
                }

                $('#listMyDoctor').empty().append(html)
            }
        })
    </script>
@endsection


