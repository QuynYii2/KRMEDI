@extends('layouts.admin')
@section('title')
    {{ __('home.List Address') }}
@endsection
@section('main-content')
    <h3 class="text-center">   {{ __('home.List Address') }}</h3>
    <a href="{{ route('view.user.address.create') }}" class="btn btn-primary mb-3">{{ __('home.create') }}</a>
    <table class="table table-striped" id="tableAddressManagement">
        <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">{{ __('home.Username') }}</th>
            <th scope="col">{{ __('home.PhoneNumber') }}</th>
            <th scope="col">{{ __('home.Province') }}</th>
            <th scope="col">{{ __('home.District') }}</th>
            <th scope="col">{{ __('home.Commune') }}</th>
            <th scope="col">{{ __('home.Addresses') }}</th>
            <th scope="col">{{ __('home.Default') }}</th>
            <th scope="col">{{ __('home.Action') }}</th>
        </tr>
        </thead>
        <tbody id="tbodyTableAddressManagement">
        @foreach($addresses as $address)
            <tr>
                <th scope="row">{{ $loop->index + 1 }}</th>
                <td>{{ $address->username }}</td>
                <td>{{ $address->phone }}</td>
                <td>{{ $address->provinces_name }}</td>
                <td>{{ $address->districts_name }}</td>
                <td>{{ $address->communes_name }}</td>
                <td>{{ $address->address_detail }}</td>
                <td>{{ $address->is_default }}</td>

                <td>
                    <div class="d-flex align-items-center">
                        <a href="{{ route('view.user.address.detail', $address->id) }}" class="btn btn-primary">
                            <i class="fa-solid fa-pen-to-square"></i>
                        </a>
                        <button onclick="confirmDeleteAddress('{{ $address->id }}')" class="btn btn-danger">
                            <i class="fa-regular fa-trash-can"></i>
                        </button>
                    </div>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <script>
        let accessToken = `Bearer ` + token;
        let headers = {
            "Authorization": accessToken
        };

        function confirmDeleteAddress(id) {
            if (confirm('Are you sure you want to delete!')) {
                deleteAddress(id);
            }
        }

        async function deleteAddress(id) {
            let categoryDeleteUrl = `{{ route('api.backend.address.order.delete', ['id'=>':id']) }}`;
            categoryDeleteUrl = categoryDeleteUrl.replace(':id', id);

            await $.ajax({
                url: categoryDeleteUrl,
                method: "DELETE",
                headers: headers,
                success: function (response) {
                    alert('Delete success!');
                    window.location.reload();
                },
                error: function (error) {
                    console.log(error);
                }
            });
        }
    </script>
@endsection
