@extends('layouts.admin')
@section('title', 'News Events')
@section('main-content')
    <style>

    </style>
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">{{ __('home.News Events') }}</h1>
    <a href="{{ route('api.new-event.create') }}" class="btn btn-primary mb-3">{{ __('home.Add') }}</a>
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
            <th scope="col">{{ __('home.Tiêu đề') }}</th>
            <th scope="col">{{ __('home.người tạo') }}</th>
            <th scope="col">{{ __('home.Trạng thái') }}</th>
            <th scope="col">{{ __('home.Thao tác') }}</th>
        </tr>
        </thead>
        <tbody>
        @foreach($listNewEvent as $index => $newEvent)
            <tr>
                <th scope="row">{{ ++$index }}</th>
                <td>
                    @if(locationHelper() == 'vi')
                        {{ $newEvent->title }}
                    @else
                        {{ $newEvent->title_en }}
                    @endif
                </td>
                <td>{{ $newEvent->user_id }}</td>
                <td>{{ $newEvent->status }}</td>
                <td class="d-flex">
                    <a href="{{ route('api.new-event.edit', ['id' => $newEvent->id]) }}"
                       class="btn btn-primary mr-2">{{ __('home.Edit') }}</a>
                    <button type="button" class="btn btn-danger" onclick="deleteNewEvent({{ $newEvent->id }})">{{ __('home.Delete') }}
                    </button>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <div class="d-flex justify-content-center align-items-center">
        {{$listNewEvent->links()}}
    </div>
    <script>

        function deleteNewEvent(id) {
            if (confirm('{{ __('home.Bạn có chắc chắn muốn xóa không') }}?')) {

                loadingMasterPage();
                let url = '{{ route('api.new-event.destroy', ['id' => ':id']) }}';
                url = url.replace(':id', id);

                const headers = {
                    'Authorization': `Bearer ${token}`
                };
                const formData = new FormData();
                formData.append('_token', '{{ csrf_token() }}');

                try {
                    $.ajax({
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
                            window.location.href = `{{route('api.new-event.index')}}`;
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
    </script>

@endsection
