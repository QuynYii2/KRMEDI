@extends('layouts.admin')
@section('title', 'News Events')
@section('main-content')

    <script src="{{ asset('js/chat-message.js') }}" defer></script>
    <link href="{{ asset('css/chat-message.css') }}" rel="stylesheet">

    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-4">
                <div class="card">

                    <div class="card-body" >
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="home-tab" data-toggle="tab" data-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true">{{ __('home.Home') }}</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="profile-tab" data-toggle="tab" data-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false">{{ __('home.Profile') }}</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="contact-tab" data-toggle="tab" data-target="#contact" type="button" role="tab" aria-controls="contact" aria-selected="false">{{ __('home.Contact') }}</button>
                            </li>
                        </ul>
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">...</div>
                            <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">...</div>
                            <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">...</div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="card">

                    <div class="card-body" style="height: 200px">

                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>

        $(document).ready(function () {
            // loadChatUser();
        });

        function loadChatUser() {
            let id = '{{ $id }}';
            if (!id) {
                return;
            }
            let currentUserId = '{{ auth()->user()->id }}';

            $.ajax({
                url: '/api/conversation/' + id + '/' + currentUserId,
                method: 'GET',
                dataType: 'json',
                success: (response) => {
                    this.messages = response.data;
                    this.selectedContact = id;
                },
                error: (error) => {
                    console.log(error);
                }
            });
        }
    </script>

@endsection
