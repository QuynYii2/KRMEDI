@extends('layouts.admin')
@section('title')
    {{ __('home.Create Category') }}
@endsection
@section('main-content')
    <h3 class="text-center"> {{ __('home.Create Category') }}</h3>
    <div class="container">
        <form>
            <div class="row">
                <div class="form-group col-md-12">
                    <label for="name">{{ __('home.Name') }}</label>
                    <input type="text" class="form-control" id="name" maxlength="200" required>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-12">
                    <label for="description">{{ __('home.Description') }}</label>
                    <textarea class="form-control" id="description" placeholder="{{ __('home.Description') }}"
                              rows="3"></textarea>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-4">
                    <label for="thumbnail">{{ __('home.Thumbnail') }}</label>
                    <input type="file" class="form-control" id="thumbnail" accept="image/*" required>
                </div>
                <div class="form-group col-md-4">
                    <label for="parent_id">{{ __('home.Parent') }}</label>
                    <select id="parent_id" class="form-select">
                        <option value="0">{{ __('home.Choose...') }}</option>
                        @foreach($categories as $category)
                            <option value="{{$category->id}}" data-limit="30"
                                    class="text-shortcut">{{$category->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-md-4">
                    <label for="status">{{ __('home.Status') }}</label>
                    <select id="status" class="form-select">
                        @foreach($status as $item)
                            @if($item != 'DELETED')
                                <option value="{{ $item }}">{{ $item }}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="text-center mt-3">
                <button type="button" class="btn btn-primary" id="btnCreate">{{ __('home.create') }}</button>
            </div>
        </form>
    </div>
    <script>
        let accessToken = `Bearer ` + token;
        let headers = {
            "Authorization": accessToken
        };

        $(document).ready(function () {
            $('#btnCreate').on('click', function () {
                createCategory();
            })

            async function createCategory() {
                let categoryUrl = `{{ route('api.business.categories.create')  }}`;

                const formData = new FormData();

                const fieldNames = [
                    "name", "parent_id", "status",
                ];

                let isValid = true;
                isValid = appendDataForm(fieldNames, formData, isValid);

                const fieldTextareaTiny = [
                    'description',
                ];
                fieldTextareaTiny.forEach(fieldTextarea => {
                    const content = tinymce.get(fieldTextarea).getContent();
                    if (!content) {
                        isValid = false;
                        let labelElement = $(`label[for='${fieldTextarea}']`);
                        let text = labelElement.text();
                        if (!text) {
                            text = 'The input'
                        }
                        text = text + ' not empty!'
                        alert(text);
                        return;
                    }
                    formData.append(fieldTextarea, content);
                });

                let file = $('#thumbnail')[0].files[0];
                formData.append("user_id", '{{ Auth::user()->id }}');
                if (!file) {
                    isValid = false;
                    let labelElement = $(`label[for='thumbnail`);
                    let text = labelElement.text();
                    text = text + ' not empty!'
                    alert(text);
                    return;
                }
                formData.append("thumbnail", file);

                if (!isValid) {
                    alert('Please check input require!')
                    return;
                }

                await $.ajax({
                    url: categoryUrl,
                    method: 'POST',
                    headers: headers,
                    contentType: false,
                    cache: false,
                    processData: false,
                    data: formData,
                    success: function (response) {
                        alert('Create success!');
                        window.location.href = `{{ route('view.admin.category.index') }}`;
                    },
                    error: function (error) {
                        console.log(error);
                        alert('Create error!');
                    }
                });
            }
        })
    </script>
@endsection
