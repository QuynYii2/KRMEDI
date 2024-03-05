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
        <hr>

        <div class="d-flex justify-content-center">
            <button id="syncButton" type="button" class="btn btn-primary" onclick="syncData()"><i
                    class="fa-solid fa-rotate"></i> Sync
                data</button>
            {{-- <button style="display: none" class="btn btn-primary" type="button" disabled>
                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                Synchronizing...
            </button> --}}
        </div>

        @if (session('syncStatus') == 'success')
            <div class="alert alert-success">Sync successfully</div>
        @elseif(session('syncStatus') == 'error')
            <div class="alert alert-danger">Fail to sync</div>
        @endif

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
                            {{ $info['name'] ?? '' }}
                        </td>
                        <td class="text-center">
                            {{ $info['user_id'] ?? '' }}
                        </td>
                        <td class="text-center">
                            {{ $info['user_id_by_app'] ?? '' }}
                        </td>
                        <td class="text-center">
                            <a type="button" data-bs-toggle="modal" data-bs-target="#sendMessageModal"
                                data-toggle="tooltip" data-placement="top"
                                title="{{ __('admin.send-message-to') }}: {{ $info['phone'] ?? '' }}"
                                onclick="setModalUserId('{{ $info['user_id'] ?? 0 }}', '{{ $info['phone'] ?? '' }}')">{{ $info['phone'] ?? '' }}</a>
                        </td>
                        <td class="text-center">
                            {!! $info['address'] ?? '' !!}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center">Empty data</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <!-- Modal -->
    <form id="sendMsgZalo" method="POST" action="{{ route('zalo.service.send.message.text') }}"
        enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="user_zalo" id="hidden-user-id">

        <div class="modal fade" id="sendMessageModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
            aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">{{ __('admin.send-message-to') }} <span
                                id="phone-title">...</span> {{ __('admin.through-zalo-oa') }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="d-flex justify-content-between">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="message_type" id="textType"
                                    value="text" checked>
                                <label class="form-check-label" for="textType">
                                    Textual form
                                </label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="message_type" id="fileType"
                                    value="file">
                                <label class="form-check-label" for="fileType">
                                    File attached
                                </label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="message_type" id="photoType"
                                    value="photo">
                                <label class="form-check-label" for="photoType">
                                    Photo attached
                                </label>
                            </div>
                        </div>

                        <hr>
                        <label class="form-label">{{ __('admin.message') }}</label>

                        <div id="textContent" class="mt-3">
                            <input type="text" class="form-control" id="message" name="message">
                        </div>
                        <div id="fileContent" class="mt-3" style="display: none;">
                            <input type="file" class="form-control" accept=".pdf,.doc,.docx" id="file_attached"
                                name="file_attached" />
                        </div>
                        <div id="photoContent" class="mt-3" style="display: none;">
                            <div class="d-flex justify-content-center">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="photo_type" id="imageType"
                                        value="image" checked>
                                    <label class="form-check-label" for="imageType">
                                        Image attached
                                    </label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="photo_type" id="gifType"
                                        value="gif">
                                    <label class="form-check-label" for="gifType">
                                        Gif attached
                                    </label>
                                </div>
                            </div>
                            <input type="text" class="form-control" id="photoMessage" name="photoMessage"
                                placeholder="Enter attached message">
                            <br>
                            <div id="imageContent">
                                <input type="file" class="form-control" accept=".jpg,.png" id="photo_attached"
                                    name="photo_attached" />
                            </div>
                            <div id="gifContent" style="display: none;">
                                <input type="file" class="form-control" accept=".gif" id="gif_attached"
                                    name="gif_attached" />
                            </div>
                        </div>
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

    <script>
        function syncData() {
            var syncButton = $('#syncButton');
            var originalHtml = syncButton.html();

            syncButton.prop('disabled', true).html(
                '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Synchronizing...'
            );

            $.ajax({
                type: 'POST',
                url: '{{ route('admin.sync.user.zalo') }}',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    var table = $('#tableListZaloFollower').DataTable();
                    table.destroy();
                    $('#tableListZaloFollower').load(location.href + ' #tableListZaloFollower');
                    $('#tableListZaloFollower').DataTable();
                    toastr.success('Sync follower successfully', 'Success');
                },
                error: function(xhr, status, error) {
                    toastr.error('Failed to sync: ' + error, 'Error');
                },
                complete: function() {
                    syncButton.prop('disabled', false).html(originalHtml);
                }
            });
        }
    </script>

    <script>
        $(document).ready(function() {
            $('input[name="message_type"]').change(function() {
                var selectedOption = $('input[name="message_type"]:checked').val();

                // Hide all content sections
                $('#textContent, #fileContent, #photoContent').hide();

                // Show the selected content section
                if (selectedOption === 'text') {
                    $('#textContent').show();
                } else if (selectedOption === 'file') {
                    $('#fileContent').show();
                } else if (selectedOption === 'photo') {
                    $('#photoContent').show();
                }
            });
        });

        $('input[name="photo_type"]').change(function() {
            var selectedValue = $('input[name="photo_type"]:checked').val();

            // Hide all content sections
            $('#imageContent, #gifContent').hide();

            if (selectedValue === 'image') {
                $('#imageContent').show();
            } else if (selectedValue === 'gif') {
                $('#gifContent').show();
            }
        });
    </script>
@endsection
