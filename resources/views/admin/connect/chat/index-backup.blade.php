@extends('layouts.admin')
@section('title', 'News Events')
@section('main-content')

    <script src="{{ asset('js/chat-message.js') }}" defer></script>
    <link href="{{ asset('css/chat-message.css') }}" rel="stylesheet">

    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">{{ __('home.Dashboard') }}</div>

                    <div class="card-body" id="app">
                        <chat-app :user="{{auth()->user()}}" />
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
