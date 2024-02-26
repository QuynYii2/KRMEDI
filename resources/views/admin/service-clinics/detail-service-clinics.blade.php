@extends('layouts.admin')
@section('title')
    {{ __('home.Detail Service Clinics') }}
@endsection
@section('main-content')
    <div class="container">
        <!-- Page Heading -->
        <h1 class="h3 mb-4 text-gray-800">{{ __('home.Detail Service Clinics') }}</h1>
        @if (session('success'))
            <div class="alert alert-success border-left-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
        <form>
            <div class="row">
                <div class="form-group col-md-4">
                    <label for="name">{{ __('home.Name') }}</label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ $service->name }}" required>
                </div>
                <div class="form-group col-md-4">
                    <label for="service_price">{{ __('home.Giá dịch vụ') }}</label>
                    <input type="number" class="form-control" id="service_price" name="service_price" value="{{ $service->service_price }}">
                </div>
                <div class="form-group col-md-4">
                    <label for="status">{{ __('home.Status') }}</label>
                    <select id="status" class="form-control">
                        <option {{ $service->status == 'ACTIVE' ? 'selected' : '' }} value="ACTIVE">{{ __('home.Active') }}</option>
                        <option {{ $service->status == 'INACTIVE' ? 'selected' : '' }} value="INACTIVE">{{ __('home.Inactive') }}
                        </option>
                    </select>
                </div>
            </div>
            <button type="button" onclick="updateService('{{ $service->id }}');" class="btn btn-primary float-right">
                {{ __('home.Save') }}
            </button>
        </form>
    </div>
    <script>
        let accessToken = `Bearer ` + token;

        async function updateService(id) {
            let url = `{{ route('api.admin.service.clinic.update', ['id'=>':id']) }}`;
            url = url.replace(':id', id);

            let data = {
                name: document.getElementById('name').value,
                service_price: document.getElementById('service_price').value,
                user_id: `{{ Auth::check() ? Auth::user()->id : '' }}`,
                status: document.getElementById('status').value,
            };

            if (document.getElementById('name').value) {
                fetch(url, {
                    method: 'PUT',
                    headers: {
                        'content-type': 'application/json',
                        'Authorization': `Bearer ${token}`
                    },
                    body: JSON.stringify(data),

                })
                    .then(response => {
                        if (response.status == 200) {
                            console.log(response);
                            alert('Update success!');
                            window.location.href = `{{ route('user.service.clinics.list') }}`;
                        } else {
                            alert("Error! Please fill in the data completely...");
                        }
                    })
                    .catch(error => console.log(error));
            } else {
                alert('Please enter input!')
            }
        }
    </script>
@endsection

