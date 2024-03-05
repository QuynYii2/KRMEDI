@extends('layouts.admin')
@section('title')
    {{ __('home.List Survey') }}
@endsection
@section('main-content')
    <h3 class="text-center"> {{ __('home.List Survey') }}</h3>
    <a href="{{ route('view.admin.surveys.create') }}" class="btn btn-primary mb-3">{{ __('home.create') }}</a>
    <table class="table table-striped" id="tableSurveyManagement">
        <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">{{ __('home.Question') }}</th>
            <th scope="col">{{ __('home.Department') }}</th>
            <th scope="col">{{ __('home.type') }}</th>
            <th scope="col">{{ __('home.Action') }}</th>
        </tr>
        </thead>
        <tbody id="tbodyTableSurveyManagement">
        @foreach($surveys as $index => $survey)
            <tr>
                <th scope="row">{{ ++$index }}</th>
                <td>{{ $survey->question }}</td>
                <td>
                    @php
                        $department = \App\Models\Department::find($survey->department_id);
                    @endphp
                    {{ $department->name }}
                </td>
                <td>{{ $survey->type }}</td>

                <td>
                    <div class="d-flex align-items-center">
                        <a href="{{ route('view.admin.surveys.detail', $survey->id) }}" class="btn btn-primary">
                            <i class="fa-solid fa-pen-to-square"></i>
                        </a>
                        <button onclick="confirmDeleteSurvey('{{ $survey->id }}')" class="btn btn-danger">
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

        function confirmDeleteSurvey(id) {
            if (confirm('Are you sure you want to delete!')) {
                deleteSurvey(id);
            }
        }

        async function deleteSurvey(id) {
            let categoryDeleteUrl = `{{ route('api.medical.surveys.delete', ['id'=>':id']) }}`;
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
