@extends('layouts.admin')
@section('title')
    List User
@endsection
@section('page-style')
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.1/css/dataTables.dataTables.css" />
@endsection
@section('main-content')
    <div class="">
        <!-- Page Heading -->
        <h1 class="h3 mb-4 text-gray-800">List Zalo OA follower User</h1>
        <br>
        <table class="table" id="tableListZaloFollower">
            <thead>
                <tr>
                    <th scope="col" class="text-center">{{ __('admin.No') }}</th>
                    <th scope="col" class="text-center">{{ __('admin.avatar') }}</th>
                    <th scope="col" class="text-center">{{ __('admin.name') }}</th>
                    <th scope="col" class="text-center">{{ __('admin.user-id') }}</th>
                    <th scope="col" class="text-center">{{ __('admin.user-id-by-app') }}</th>
                    <th scope="col" class="text-center">{{ __('admin.phone') }}</th>
                    <th scope="col" class="text-center">{{ __('admin.address') }}</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($follower_info as $key => $info)
                    <tr>
                        <td class="text-center">
                            {{ $key + 1 }}
                        </td>
                        <td class="text-center">
                            @if (isset($info['avatar']) && $info['avatar'])
                                <img src="{{ $info['avatar'] }}" alt="avt">
                            @else
                                <i class="fa-solid fa-ban fa-2xl" style="color: red;"></i>
                            @endif
                        </td>
                        <td class="text-center">
                            {{ $info['shared_info']['name'] ?? $info['display_name'] }}
                        </td>
                        <td class="text-center">
                            {{ $info['user_id'] ?? '' }}
                        </td>
                        <td class="text-center">
                            {{ $info['user_id_by_app'] ?? '' }}
                        </td>
                        <td class="text-center">
                            @php
                                $phone = $info['shared_info']['phone'] ?? '';

                                // Check if the string is a regular expression
                                if (preg_match('/^\d{11}$/', $phone)) {
                                    // Convert the regular expression to the desired format
                                    $convert = '0' . substr($phone, 2);

                                    $convertedPhone = $convert;
                                } else {
                                    $convertedPhone = $phone;
                                }
                            @endphp
                            <a type="button" data-bs-toggle="modal" data-bs-target="#sendMessageModal"
                                data-toggle="tooltip" data-placement="top"
                                title="{{ __('admin.send-message-to') }}: {{ $convertedPhone ?? '' }}"
                                onclick="setModalUserId('{{ $info['user_id'] ?? 0 }}', '{{ $convertedPhone ?? '' }}')">{{ $convertedPhone ?? '' }}</a>
                        </td>
                        <td class="text-center">
                            @if (isset($info['shared_info']))
                                {!! $info['shared_info']['address'] .
                                    '</br>' .
                                    $info['shared_info']['district'] .
                                    '</br>' .
                                    $info['shared_info']['city'] !!}
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7">Empty data</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <!-- Modal -->
    <form id="sendMsgZalo" method="POST" action="{{ route('zalo.service.send.message.text') }}">
        <div class="modal fade" id="sendMessageModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
            aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                @csrf
                <input type="hidden" name="user_zalo" id="hidden-user-id">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">{{ __('admin.send-message-to') }} <span id="phone-title">...</span>
                            {{ __('admin.through-zalo-oa') }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <label for="message" class="form-label">{{ __('admin.message') }}</label>
                        <input type="text" class="form-control" id="message" name="message" required/>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary"
                            data-bs-dismiss="modal">{{ __('admin.close') }}</button>
                        <button type="submit" class="btn btn-primary">{{ __('admin.send') }}</button>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <script>
        $(document).ready(function() {
            $('#tableListZaloFollower').DataTable();
        });
    </script>
@endsection

@section('page-script')
    <script src="https://cdn.datatables.net/2.0.1/js/dataTables.js"></script>

    <script>
        function setModalUserId(userId, phone) {
            $('#hidden-user-id').val(userId);
            $('#phone-title').text(phone);
        }
    </script>
@endsection
