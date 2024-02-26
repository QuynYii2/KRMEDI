@extends('layouts.master')
@section('title', 'Reset device?')
@section('content')
    @include('layouts.partials.header')
    <div class="container pb-5" style="margin-top: 168px;">
        <div class="text-center">
            <img src="{{ asset('img/icons_logo/logo-new.png') }}" alt="" style="max-width: 100px">
            <h1 class="mt-2">What is reset device?</h1>
        </div>
        <div class="d-flex align-items-center justify-content-center mt-5">
            <div class="w-75">
                <form class="form-inline">
                    <div class="form-group mx-sm-3 mb-2">
                        <label for="your_email" class="sr-only">Email</label>
                        <input type="email" class="form-control" id="your_email"
                               placeholder="Please enter your email...">
                    </div>
                    <button type="button" class="btn btn-primary mb-2" id="btnNextStep">Next step</button>
                </form>
            </div>
        </div>
        <div class="d-flex align-items-center justify-content-center mt-2">
            <div class="w-75">
                <p class="small">
                    You enter your email here, we will send your email a confirmation code. You will need it in the next
                    step...
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
            $('#btnNextStep').click(function () {
                sendCodeVerify();
            })
        })

        async function sendCodeVerify() {
            loadingMasterPage();
            let email = $('#your_email').val()
            if (!email) {
                loadingMasterPage();
                alert('Please enter your email');
                return;
            }

            let data = {
                'email': email
            }

            try {
                $.ajax({
                    url: `{{route('restapi.account.send.verify.code.reset.token')}}`,
                    method: 'POST',
                    headers: headers,
                    data: data,
                    success: function (response) {
                        loadingMasterPage();
                        alert(response.message);
                        let user_id = response.user_id;
                        let urlRedirect = `{{route('need.helps.account.verify.code', ['id' => ':id'])}}`;
                        urlRedirect = urlRedirect.replace(':id', user_id);
                        window.location.href = urlRedirect;
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
