@extends('layouts.master')
@section('title', 'Home')
@section('content')
    @include('layouts.partials.header_3')
    @include('component.banner')
    <div id="examination-scene" class="container ">
        <div class="d-md-flex d-none
         w-100">
            <div id="filter" class="box--3 w-100 ">
                <form action="{{ route('examination.index') }}" method="get" class="row" id="searchForm">
                    <div class="col-sm-2 col">
                        <div class="form-group">
                            <label for="exampleFormControlSelect2">{{ __('home.Department') }}</label>
                            <select class="form-control" name="department_id" onchange="submitForm()">
                                <option value="">{{ __('home.All') }}</option>
                                @foreach($departments as $department)
                                    <option href="#"
                                            {{ $departmentId == $department->id ? 'selected' : '' }} value="{{ $department->id }}"
                                            data-department="{{$department}}">{{$department->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-sm-2 col">
                        <div class="form-group">
                            <label for="exampleFormControlSelect2">{{ __('home.Location') }}</label>
                            <select class="form-control" name="province_id" onchange="submitForm()">
                                <option value="">{{ __('home.All') }}</option>
                                @foreach($provinces as $province)
                                    <option href="#" {{ $provinceId == $province->id ? 'selected' : '' }}
                                    value="{{ $province->id }}"
                                    >{{$province->full_name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-2 col">
                        <div class="form-group">
                            <label for="exampleFormControlSelect2">{{ __('home.Hospital') }}</label>
                            <select class="form-control" name="hospital_id" onchange="submitForm()">
                                <option value="">{{ __('home.All') }}</option>
                                @foreach( $hospitals as $hospital )
                                    <option href="#" {{ $hospitalId == $hospital->id ? 'selected' : '' }}
                                    value="{{ $hospital->id }}"
                                    >{{ $hospital->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-2 col">
                        <div class="form-group">
                            <label for="exampleFormControlSelect2">{{ __('home.Experience') }}</label>
                            <select class="form-control" name="year_of_experience" onchange="submitForm()">
                                <option value="">{{ __('home.All') }}</option>
                                @foreach( $experiences as $experience )
                                    <option href="#" {{ $experienceValue == $experience ? 'selected' : '' }}
                                    value="{{ $experience }}"
                                    >{{ $experience }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-4 col">
                        <div class="form-group position-relative">
                            <label for="inputSearchDoctor" class="fa fa-search form-control-feedback"></label>
                            <input type="search" id="inputSearchDoctor" class="form-control"
                                   name="nameSearch"
                                   value="{{ $nameSearch }}"
                                   placeholder="{{ __('home.Search for anything…') }}">
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div id="show-doctor">
            <div class="d-flex justify-content-center" style="padding: 12px">
                <div id="list-title-best" class="list-title justify-content-between align-items-center d-flex">
                    <div class="list--doctor p-0">
                        <p>{{ __('home.Best doctor') }}</p>
                    </div>
                    <div class="p-md-2 seeAll"><a href="{{route('examination.best_doctor')}}">{{ __('home.See all') }}</a>
                    </div>
                </div>
            </div>
            <div class="row list-doctor m-auto find-my-medicine">
                @if(count($bestDoctorInfos) > 0)
                    @foreach($bestDoctorInfos as $pharmacist)
                        @include('examination.component_doctor_findmymedicine', ['pharmacist' => $pharmacist])
                    @endforeach
                @else
                    <h3 class="no-data text-center">{{ __('home.no data') }}</h3>
                @endif
            </div>


            <div class="d-flex justify-content-center" style="padding: 12px">
                <div id="list-title-new" class="list-title justify-content-between align-items-center d-flex">
                    <div class="list--doctor p-0">
                        <p>{{ __('home.New doctor') }}</p>
                    </div>
                    <div class="seeAll p-2"><a href="{{route('examination.new_doctor')}}">{{ __('home.See all') }}</a>
                    </div>
                </div>
            </div>
            <div class="row list-doctor m-auto find-my-medicine">
                @if(count($newDoctorInfos) > 0)
                    @foreach($newDoctorInfos as $pharmacist)
                        @include('examination.component_doctor_findmymedicine', ['pharmacist' => $pharmacist])
                    @endforeach
                @else
                    <h3 class="no-data text-center">{{ __('home.no data') }}</h3>
                @endif
            </div>
            <div class="d-flex justify-content-center" style="padding: 12px;">
                <div id="list-title-available" class="list-title justify-content-between align-items-center d-flex">
                    <div class="list--doctor p-0">
                        <p>{{ __('home.24/7 Available doctor') }}</p>
                    </div>
                    <div class="seeAll p-2"><a
                            href="{{route('examination.available_doctor')}}">{{ __('home.See all') }}</a></div>
                </div>
            </div>
            <div class="row list-doctor m-auto find-my-medicine">
                @if(count($availableDoctorInfos) > 0)
                    @foreach($availableDoctorInfos as $pharmacist)
                        @include('examination.component_doctor_findmymedicine', ['pharmacist' => $pharmacist])
                    @endforeach
                @else
                    <h3 class="no-data text-center">{{ __('home.no data') }}</h3>
                @endif
            </div>
        </div>
    </div>

    <script>
        function submitForm() {
            document.getElementById('searchForm').submit();
        }
    </script>
@endsection
