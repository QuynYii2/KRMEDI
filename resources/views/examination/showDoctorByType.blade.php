@extends('layouts.master')
@section('title', 'Home')
@section('content')
    @include('layouts.partials.header_3')
    @include('component.banner')
    <div class="container">
        <div class="d-flex justify-content-center">
            <div id="filter" class="d-md-flex d-flex w-100 justify-content-between">
                <div class="d-md-flex d-none flex-fill">
                    <div class="col filter_option">
                        <div class="form-group">
                            <label for="department_showDoctorByType">{{ __('home.Department') }}</label>
                            <select class="form-control" id="department_showDoctorByType" name="department_id"
                                    onchange="searchDoctor()">
                                <option value="">{{ __('home.All') }}</option>
                                @foreach($departments as $department)
                                    <option href="#" value="{{ $department->id }}"
                                            data-department="{{$department}}">{{$department->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col filter_option">
                        <div class="form-group">
                            <label for="province_showDoctorByType">{{ __('home.Location') }}</label>
                            <select class="form-control" id="province_showDoctorByType" name="province_id"
                                    onchange="searchDoctor()">
                                <option value="">{{ __('home.All') }}</option>
                                @foreach($provinces as $province)
                                    <option href="#" value="{{ $province->id }}">{{$province->full_name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col filter_option">
                        <div class="form-group">
                            <label for="hospital_showDoctorByType">{{ __('home.Hospital') }}</label>
                            <select class="form-control" id="hospital_showDoctorByType" name="hospital_id"
                                    onchange="searchDoctor()">
                                <option value="">{{ __('home.All') }}</option>
                                @foreach( $hospitals as $hospital )
                                    <option href="#" value="{{ $hospital->id }}">{{ $hospital->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col filter_option">
                        <div class="form-group">
                            <label for="year_of_experience_showDoctorByType">{{ __('home.Experience') }}</label>
                            <select class="form-control" id="year_of_experience_showDoctorByType"
                                    name="year_of_experience"
                                    onchange="searchDoctor()">
                                <option value="">{{ __('home.All') }}</option>
                                @foreach( $experiences as $experience )
                                    <option href="#" value="{{ $experience }}">{{ $experience }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="form-group has-search position-relative w-100 mt-3 mr-3 mr-md-0">
                    <span class="fa fa-search form-control-feedbackSearch p-md-3"></span>
                    <input type="text" id="inputSearch" onkeypress="processSearchDoctor();" class="form-control"
                           placeholder="{{ __('home.Search for anything…') }}">
                </div>
                <div class="flex mt-3 d-md-none">
                    <button class="navbar-toggler border-none css-button" type="button" data-bs-toggle="offcanvas"
                            data-bs-target="#filterNavbar" aria-controls="filterNavbar">
                        <i class="bi bi-filter"></i>
                    </button>
                </div>
            </div>
        </div>
        <div id="title" class="title d-flex justify-content-start" style="padding: 12px">
            <div id="list-title" class="list-title d-flex">
                <div class="list--doctor  p-0">
                    <a class="back " href="{{route('examination.index')}}"><p class="align-items-center d-flex"><i
                                class="bi bi-arrow-left"></i> {{ $title }}</p></a>
                </div>
            </div>
        </div>
        <div class="row list-doctor m-auto find-my-medicine" id="list_doctor">
            @if(count($doctors) > 0)
                @foreach($doctors as $doctor)
                    @include('examination.component_doctor_findmymedicine', ['pharmacist' => $doctor])
                @endforeach
            @else
                <h3 class="no-data text-center">{{ __('home.no data') }}</h3>
            @endif
        </div>

        <div class="d-flex justify-content-center align-items-center" id="doctor_paginate">
            {{$doctors->links()}}
        </div>

        <div class="offcanvas offcanvas-end" tabindex="-1" id="filterNavbar" aria-labelledby="offcanvasNavbarLabel">
            <div class="offcanvas-header">
                <a href="{{route('home')}}" class="offcanvas-title" id="offcanvasNavbarLabel">
                    <img class="w-100" alt="" src="{{asset('img/icons_logo/logo-new.png')}}">
                </a>
                <button type="button" class="btn-close btnCloseModal" data-bs-dismiss="offcanvas"
                        aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">
                <form>
                    <div class="flex-fill">
                        <div class="form-group">
                            <label for="department_showDoctorByTypeMobile">{{ __('home.Department') }}</label>
                            <select class="form-control" id="department_showDoctorByTypeMobile" name="department_id">
                                <option value="">{{ __('home.All') }}</option>
                                @foreach($departments as $department)
                                    <option href="#" value="{{ $department->id }}"
                                            data-department="{{$department}}">{{$department->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="province_showDoctorByTypeMobile">{{ __('home.Location') }}</label>
                            <select class="form-control" id="province_showDoctorByTypeMobile" name="province_id">
                                <option value="">{{ __('home.All') }}</option>
                                @foreach($provinces as $province)
                                    <option href="#" value="{{ $province->id }}">{{$province->full_name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="hospital_showDoctorByTypeMobile">{{ __('home.Hospital') }}</label>
                            <select class="form-control" id="hospital_showDoctorByTypeMobile" name="hospital_id">
                                <option value="">{{ __('home.All') }}</option>
                                @foreach( $hospitals as $hospital )
                                    <option href="#" value="{{ $hospital->id }}">{{ $hospital->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="year_of_experience_showDoctorByTypeMobile">{{ __('home.Experience') }}</label>
                            <select class="form-control" id="year_of_experience_showDoctorByTypeMobile"
                                    name="year_of_experience">
                                <option value="">{{ __('home.All') }}</option>
                                @foreach( $experiences as $experience )
                                    <option href="#" value="{{ $experience }}">{{ $experience }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="d-flex justify-content-center">
                        <button type="reset" class="add-cv-bt w-100 apply-bt_delete col-6 mr-1">
                            {{ __('home.Refresh') }}
                        </button>
                        <button type="button" data-bs-dismiss="offcanvas" aria-label="Close"
                                class="add-cv-bt apply-bt_edit w-100" onclick="searchDoctor();">{{ __('home.Apply') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        async function processSearchDoctor() {
            if (event.keyCode === 13 && !event.shiftKey) {
                await searchDoctor();
            }
        }

        async function searchDoctor() {
            loadingMasterPage()

            let keyword = $('#inputSearch').val();
            keyword = keyword.replace(' ', '+');

            let department_id, province_id, hospital_id, year_of_experience;

            let device = navigator.userAgent.toLowerCase();
            /* Check page was device mobile or desktop */
            if (device.search('iphone') > -1 || device.search('android') > -1) {
                department_id = $('#department_showDoctorByTypeMobile').val();
                province_id = $('#province_showDoctorByTypeMobile').val();
                hospital_id = $('#hospital_showDoctorByTypeMobile').val();
                year_of_experience = $('#year_of_experience_showDoctorByTypeMobile').val();
            } else {
                department_id = $('#department_showDoctorByType').val();
                province_id = $('#province_showDoctorByType').val();
                hospital_id = $('#hospital_showDoctorByType').val();
                year_of_experience = $('#year_of_experience_showDoctorByType').val();
            }

            let urlSearch = `{{ route('restapi.doctor.info.find') }}`
                + `?keyword=${keyword}`
                + `&department_id=${department_id}`
                + `&province_id=${province_id}`
                + `&hospital_id=${hospital_id}`
                + `&year_of_experience=${year_of_experience}`;

            console.log(urlSearch);

            await $.ajax({
                url: urlSearch,
                method: 'GET',
                success: function (response) {
                    loadingMasterPage()
                    renderResponse(response)
                },
                error: function (exception) {
                    console.log(exception);
                    loadingMasterPage()
                }
            });
        }

        function renderResponse(html) {
            $('#doctor_paginate').addClass('d-none');
            $('#list_doctor').html(html);
        }
    </script>
@endsection
