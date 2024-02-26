@php use App\Enums\online_medicine\ObjectOnlineMedicine; @endphp
@php use App\Enums\online_medicine\FilterOnlineMedicine;use App\Enums\UserStatus;use App\Models\User; @endphp
@extends('layouts.admin')
@section('title')
    {{ __('home.List Member') }}
@endsection
@section('main-content')
    <style>

    </style>
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">{{ __('home.List account register') }}</h1>
    @if (session('success'))
        <div class="alert alert-success border-left-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
    <table class="table table-striped">
        <thead>
        <tr>
            <th scope="col">STT</th>
            <th scope="col">{{ __('home.Username') }}</th>
            <th scope="col">{{ __('home.Email') }}</th>
            <th scope="col">{{ __('home.type') }}</th>
            <th scope="col">{{ __('home.Member') }}</th>
            <th scope="col">{{ __('home.Status') }}</th>
            <th scope="col">{{ __('home.Thao tác') }}</th>
        </tr>
        </thead>
        <tbody>
        @foreach($users as $user)
            <tr>
                <th scope="row">{{ $loop->index + 1 }}</th>
                <td>{{ $user->username }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->type }}</td>
                <td>{{ User::getMemberNameByID($user->id) }}</td>
                <td>{{ $user->status }}</td>
                <td>
                    @if($user->business_license_img || $user->medical_license_img)
                        <a href="{{ asset($user->business_license_img ?? $user->medical_license_img) }}"
                           class="btn btn-info" target="_blank">{{ __('home.View License') }}
                        </a>
                    @else
                        <button type="button" onclick="alertMessage()"
                                class="btn btn-info">{{ __('home.View License') }}</button>
                    @endif
                    <button onclick="updateUser('{{ $user->id }}', '{{ UserStatus::BLOCKED }}')"
                            class="btn btn-danger">{{ __('home.Reject') }}
                    </button>
                    <button onclick="updateUser('{{ $user->id }}', '{{ UserStatus::ACTIVE }}')"
                            class="btn btn-primary">{{ __('home.Approve') }}
                    </button>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <div class="d-flex justify-content-center align-items-center">
        {{$users->links()}}
    </div>
    <script>
        async function updateUser(id, value) {
            if (confirm('{{ __('home.Bạn có chắc chắn muốn thay đổi không') }}?')) {

                loadingMasterPage();
                let url = '{{ route('api.backend.account-register.update', ['id' => ':id']) }}';
                url = url.replace(':id', id);

                const headers = {
                    'Authorization': `Bearer ${token}`
                };
                const formData = new FormData();
                formData.append('_token', '{{ csrf_token() }}');
                formData.append('status', value);

                try {
                    await $.ajax({
                        url: url,
                        method: 'POST',
                        headers: headers,
                        contentType: false,
                        cache: false,
                        data: formData,
                        processData: false,
                        success: function (data) {
                            alert(data);
                            loadingMasterPage();
                            window.location.href = `{{route('api.backend.account-register.index')}}`;
                        },
                        error: function (exception) {
                            alert(exception.responseText);
                            loadingMasterPage();
                        }
                    });
                } catch (error) {
                    loadingMasterPage();
                }
            }
        }


        function alertMessage() {
            alert('The license not found!')
        }
    </script>

@endsection
