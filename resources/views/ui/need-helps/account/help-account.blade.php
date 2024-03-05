@extends('layouts.master')
@section('title', 'Krmedi account')
@section('content')
    @include('layouts.partials.header')
    <div class="container pb-5" style="margin-top: 168px;">
        <div class="text-center">
            <img src="{{ asset('img/icons_logo/logo-new.png') }}" alt="" style="max-width: 100px">
            <p class="mt-2">How can we help you?</p>
        </div>
        <div class="d-flex align-items-center justify-content-center mt-3">
            <div class="w-75">
                <div id="accordion">
                    <div class="card">
                        <div class="card-header" id="headingOne">
                            <h5 class="mb-0">
                                <button class="btn btn-link" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                    Unlock Account
                                </button>
                            </h5>
                        </div>

                        <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
                            <div class="card-body">
                                Coming Soon
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header" id="headingTwo">
                            <h5 class="mb-0">
                                <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                    Bypass Password
                                </button>
                            </h5>
                        </div>
                        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
                            <div class="card-body">
                                Cannot log in with password
                            </div>
                            <ul class="list-group">
                                <li class="list-group-item">
                                    <a href="#">Reset password</a>
                                </li>
                                <li class="list-group-item">
                                    <a href="#">Change password</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header" id="headingThree">
                            <h5 class="mb-0">
                                <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                    Reset Device
                                </button>
                            </h5>
                        </div>
                        <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordion">
                            <div class="card-body">
                                Can't log in to your account? Try erasing the old device and try again
                            </div>
                            <ul class="list-group">
                                <li class="list-group-item">
                                    <a href="{{ route('need.helps.account.token') }}">Start now</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header" id="headingFour">
                            <h5 class="mb-0">
                                <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                                    Get help
                                </button>
                            </h5>
                        </div>
                        <div id="collapseFour" class="collapse" aria-labelledby="headingFour" data-parent="#accordion">
                            <div class="card-body">
                                Coming Soon
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function () {

        })
    </script>
@endsection
