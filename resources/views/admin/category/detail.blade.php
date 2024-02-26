@extends('layouts.admin')
@section('title')
    {{ __('home.Detail Category') }}
@endsection
@section('main-content')
    <h3 class="text-center">{{ __('home.Detail Category') }}</h3>
    <div class="container">
        <form>
            <div class="row">
                <div class="form-group col-md-12">
                    <label for="name">{{ __('home.Name') }}</label>
                    <input type="text" class="form-control" id="name" required value="{{ $category->name }}">
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-12">
                    <label for="description">{{ __('home.Description') }}</label>
                    <textarea class="form-control" id="description" placeholder="{{ __('home.Description') }}"
                              rows="3">{{ $category->description }}</textarea>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-4">
                    <label for="thumbnail">{{ __('home.Thumbnail') }}</label>
                    <input type="file" class="form-control" id="thumbnail" required>
                    @if($category->thumbnail)
                        <img loading="lazy" src="{{ asset($category->thumbnail) }}" alt="" width="80px">
                    @endif
                </div>
                <div class="form-group col-md-4">
                    <label for="parent_id">{{ __('home.Parent') }}</label>
                    <select id="parent_id" class="form-select">
                        <option value="0">{{ __('home.Choose...') }}</option>
                        @foreach($categories as $value)
                            <option
                                {{$category->parent_id == $value->id ? 'selected' : ''}} value="{{$value->id}}">{{$value->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-md-4">
                    <label for="status">{{ __('home.Status') }}</label>
                    <select id="status" class="form-select">
                        @foreach($status as $item)
                            @if($item != 'DELETED')
                                <option
                                    {{$category->status == $item ? 'selected' : ''}} value="{{ $item }}">{{ $item }}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="text-center mt-3">
                <button type="button" class="btn btn-primary" id="btnSaveCategory">{{ __('home.Save') }}</button>
            </div>
        </form>
    </div>

    <script>
        let accessToken = `Bearer ` + token;
        let headers = {
            "Authorization": accessToken
        };

        $(document).ready(function () {
            $('#btnSaveCategory').on('click', function () {
                updateCategory();
            })

            async function updateCategory() {
                let reviewUrl = `{{ route('view.admin.category.index') }}`;
                let reviewUpdateUrl = `{{ route('api.business.categories.update', $category->id) }}`;

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

                formData.append("thumbnail", $('#thumbnail')[0].files[0]);

                if (!isValid) {
                    alert('Please check input require!')
                    return;
                }

                try {
                    await $.ajax({
                        url: reviewUpdateUrl,
                        method: 'POST',
                        headers: headers,
                        contentType: false,
                        cache: false,
                        processData: false,
                        data: formData,
                        success: function (response) {
                            alert('Update success!')

                            window.location.href = reviewUrl;
                        },
                        error: function (error) {
                            console.log(error);
                            alert('Update error!')
                        }
                    });
                } catch (e) {
                    console.log(e)
                    alert('Error, Please try again!');
                }
            }
        })
    </script>
@endsection
