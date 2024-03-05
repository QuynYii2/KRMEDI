@extends('layouts.master')
@section('title', 'Verify Code?')
@section('content')
    @include('layouts.partials.header')
    <div class="container pb-5" style="margin-top: 168px;">
        <div class="text-center">
            <img src="{{ asset('img/icons_logo/logo-new.png') }}" alt="" style="max-width: 100px">
            <h1 class="mt-2">Verify Code</h1>
        </div>
        <div class="d-flex align-items-center justify-content-center mt-5">
            <div class="w-75">
                <form class="form-inline">
                    <div class="form-group mx-sm-3 mb-2">
                        <label for="verify_code" class="sr-only">Verify Code</label>
                        <input type="text" class="form-control" id="verify_code"
                               placeholder="Please enter your code...">
                    </div>
                    <button type="button" class="btn btn-primary mb-2" id="btnSave">Continue</button>
                </form>
            </div>
        </div>
        <div class="d-flex align-items-center justify-content-center mt-2">
            <div class="w-75">
                <p class="small">
                    Please open the email and enter the verification code we sent you and press the continue button...
                </p>
            </div>
        </div>
        <h3 class="text-center mt-3">Suggest for you</h3>
        <div class="d-flex align-items-center justify-content-center mt-3">
            <div class="w-75">
                <div id="accordion">
                    <div class="card">
                        <div class="card-header" id="headingOne">
                            <h5 class="mb-0">
                                <button class="btn btn-link" data-toggle="collapse" data-target="#collapseOne"
                                        aria-expanded="true" aria-controls="collapseOne">
                                    Unlock Account
                                </button>
                            </h5>
                        </div>

                        <div id="collapseOne" class="collapse collapsed" aria-labelledby="headingOne"
                             data-parent="#accordion">
                            <div class="card-body">
                                Coming Soon
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header" id="headingTwo">
                            <h5 class="mb-0">
                                <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseTwo"
                                        aria-expanded="false" aria-controls="collapseTwo">
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
                                <button class="btn btn-link collapsed" data-toggle="collapse"
                                        data-target="#collapseThree" aria-expanded="false"
                                        aria-controls="collapseThree">
                                    Reset Device
                                </button>
                            </h5>
                        </div>
                        <div id="collapseThree" class="collapse" aria-labelledby="headingThree"
                             data-parent="#accordion">
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
                                <button class="btn btn-link collapsed" data-toggle="collapse"
                                        data-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
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
        let headers = {
            'Authorization': `Bearer ${token}`
        };

        $(document).ready(function () {
            $('#btnSave').click(function () {
                sendCodeVerify();
            })
        })

        async function sendCodeVerify() {
            loadingMasterPage();
            let code = $('#verify_code').val()
            if (!code) {
                loadingMasterPage();
                alert('Please enter your code');
                return;
            }

            let data = {
                'code': code
            }

            try {
                $.ajax({
                    url: `{{route('restapi.account.handle.reset.token', $id)}}`,
                    method: 'POST',
                    headers: headers,
                    data: data,
                    success: function (response) {
                        loadingMasterPage();
                        alert(response.message);
                        window.location.href = `{{ route('home') }}`;
                    },
                    error: function (exception) {
                        loadingMasterPage();
                        alert(exception.responseJSON.message);
                    }
                });
            } catch (error) {
                loadingMasterPage();
                console.log(error)
                alert('Error, Please try again!');
            }
        }
    </script>
@endsection
