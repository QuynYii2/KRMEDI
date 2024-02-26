@extends('layouts.admin')
@section('title')
    {{ __('home.list-symptom') }}
@endsection
@section('main-content')
    <style>

    </style>
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800" id="listTextMedical">{{ __('home.list-symptom') }}</h1>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand btn btn-primary mb-3" href="{{route('symptom.create')}}"> <span
                class="text-white">{{ __('home.add-new-symptom') }}</span></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

    </nav>
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
            <th scope="col">{{ __('home.Tên chuyên khoa') }}</th>
            <th scope="col">{{ __('home.Ảnh đại diện') }}</th>
            <th scope="col">{{ __('home.Action') }}</th>
        </tr>
        </thead>
        <tbody id="ProductsAdmin">
        @foreach($symptoms as $symptom)
            <tr>
                <td>
                    <a href="{{ route('symptom.edit', $symptom->id) }}">
                        {{$symptom->name}}
                    </a>
                </td>
                <td><img loading="lazy" src="{{ asset($symptom->thumbnail) }}" alt="Image" width="50px"></td>
                <td>
                    <div class="d-flex align-items-center">
                        <a href="{{ route('symptom.edit', $symptom->id) }}"
                           class="btn btn-success">
                            <i class="fa-solid fa-pen-to-square"></i>
                        </a>
                        <button type="button" class="btn btn-danger" onclick="confirmDelete('{{ $symptom->id }}')">
                            <i class="fa-regular fa-trash-can"></i>
                        </button>
                    </div>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <div class="d-flex justify-content-center align-items-center">
        {{$symptoms->links()}}
    </div>
    <script>
        function confirmDelete(id) {
            if (confirm('Are you sure you want to delete!')) {
                deleteSymptom(id);
            }
        }

        async function deleteSymptom(id) {
            let url = `{{ route('api.medical.symptoms.delete', ['id'=>':id']) }}`;
            url = url.replace(':id', id);

            await fetch(url, {
                method: 'DELETE',
                headers: {
                    'Authorization': `Bearer ${token}`
                },

            })
                .then(response => {
                    alert('Delete success!');
                    window.location.reload();
                })
                .catch(error => console.log(error));
        }
    </script>
@endsection
