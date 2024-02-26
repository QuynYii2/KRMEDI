@extends('layouts.admin')
@section('title')
    {{ __('home.Detail Medical Result') }}
@endsection
@section('main-content')
    <div class="">
        <!-- Page Heading -->
        <h1 class="h3 mb-4 text-gray-800"> {{ __('home.Detail Medical Result') }}</h1>
        <form>
            <div class="row">
                <div class="form-group col-md-6">
                    <label for="full_name"> {{ __('home.Full Name') }}</label>
                    <input type="text" class="form-control" id="full_name" value="{{ $result->full_name }}">
                </div>
                <div class="form-group col-md-6">
                    <label for="phone">{{ __('home.PhoneNumber') }}</label>
                    <input type="text" class="form-control" id="phone" value="{{ $result->phone }}">
                </div>
            </div>
            <div class="form-group mb-3">
                <label for="address"> {{ __('home.Addresses') }}</label>
                <input type="text" class="form-control" id="address" value="{{ $result->address }}">
            </div>
            <div class="list-service-result mt-2 mb-3">
                <div id="list-service-result">
                    @foreach($array_result as $item)
                        <div class="service-result-item d-flex align-items-center justify-content-between border p-3">
                            <div class="service-result w-75">
                                <div class="form-group">
                                    <label for="service_name">{{ __('home.Service Name') }}</label>
                                    <input type="text" class="form-control service_result" id="service_name"
                                           value="{{ $item['service_result'] }}"
                                           placeholder="{{ __('home.Apartment, studio, or floor') }}">
                                </div>
                                <div class="form-group">
                                    <label for="result">{{ __('home.Result') }}</label>
                                    <input type="text" class="form-control result" value="{{ $item['result'] }}"
                                           id="result" placeholder="{{ __('home.Result') }}">
                                </div>
                                <div class="form-group">
                                    <label for="result_en">{{ __('home.Result En') }}</label>
                                    <input type="text" class="form-control result_en" value="{{ $item['result_en'] }}"
                                           id="result_en" placeholder="{{ __('home.Result En') }}">
                                </div>
                                <div class="form-group">
                                    <label for="result_laos">{{ __('home.Result Laos') }}</label>
                                    <input type="text" class="form-control result_laos"
                                           value="{{ $item['result_laos'] }}" id="result_laos"
                                           placeholder="{{ __('home.Result Laos') }}">
                                </div>
                            </div>
                            <div class="action">
                                <i class="fa-regular fa-trash-can btnTrash"
                                   style="cursor: pointer; font-size: 24px"></i>
                            </div>
                        </div>
                    @endforeach
                </div>
                <button type="button"
                        class="btn btn-outline-primary mt-3 btnAddNewResult">{{ __('home.Add new result') }}
                </button>
            </div>
            <div class="row">
                <div class="form-group col-md-8">
                    <label for="place">{{ __('home.Place') }}</label>
                    <input type="text" class="form-control" id="place" value="{{ $result->place }}">
                </div>
                <div class="form-group col-md-4">
                    <label for="datetime">{{ __('home.Datetime') }}</label>
                    <input type="datetime-local" class="form-control" id="datetime" value="{{ $result->datetime }}">
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-4">
                    <label for="files">{{ __('home.File Attachments') }}</label>
                    <input type="file" accept="image/*" multiple class="form-control" id="files" name="files[]">
                </div>
                <div class="form-group col-md-3">
                    <label for="status">{{ __('home.Status') }}</label>
                    <select class="form-select" name="status" id="status">
                        <option
                            {{ $result->status == \App\Enums\MedicalResultStatus::APPROVED ? 'selected' : '' }}
                            value="{{ \App\Enums\MedicalResultStatus::APPROVED }}">
                            {{ \App\Enums\MedicalResultStatus::APPROVED }}
                        </option>
                        <option
                            {{ $result->status == \App\Enums\MedicalResultStatus::PENDING ? 'selected' : '' }}
                            value="{{ \App\Enums\MedicalResultStatus::PENDING }}">
                            {{ \App\Enums\MedicalResultStatus::PENDING }}
                        </option>
                    </select>
                </div>
                <div class="form-group col-md-3">
                    <label for="prescriptions">{{ __('home.File Prescriptions') }}</label>
                    <input type="file"
                           accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel"
                           class="form-control" id="prescriptions" name="prescriptions">
                </div>
                <div class="form-group col-md-2">
                    <button type="button" class="btnDownloadFile btn btn-outline-warning mt-4">
                        {{ __('home.Xem đơn đã upload') }}
                    </button>
                </div>
            </div>
            @php
                $array_file = null;
                $files = $result->files;
                if ($files){
                    $array_file = explode(',',$files);
                }
            @endphp
            <div class="form-group d-flex">
                @if($array_file)
                    @foreach($array_file as $file)
                        <img src="{{ asset($file) }}" alt="" style="max-width: 100px; object-fit: cover"
                             class="m-3">
                    @endforeach
                @endif
            </div>

            <div class="form-group">
                <label for="detail">{{ __('home.Detail') }}</label>
                <textarea class="form-control" id="detail" rows="5">{{ $result->detail }}</textarea>
            </div>
            <div class="form-group">
                <label for="detail_en">{{ __('home.Detail En') }}</label>
                <textarea class="form-control" id="detail_en" rows="5">{{ $result->detail_en }}</textarea>
            </div>
            <div class="form-group">
                <label for="detail_laos">{{ __('home.Detail Lao') }}</label>
                <textarea class="form-control" id="detail_laos" rows="5">{{ $result->detail_laos }}</textarea>
            </div>
            <div class="d-none">
                <label for="created_by">{{ __('home.CreatedBy') }}</label>
                <input type="text" class="form-control" id="created_by" name="created_by "
                       value="{{ $result->created_by }}">
                <label for="code">{{ __('home.Code') }}</label>
                <input type="text" class="form-control" id="code" name="code "
                       value="{{ $result->code }}">
            </div>
            <div class="text-center mt-5">
                <button type="button" class="btn btn-primary btnSave">{{ __('home.Save') }}</button>
            </div>
        </form>
    </div>
    <script>
        let accessToken = `Bearer ` + token;
        let headers = {
            "Authorization": accessToken
        };

        $(document).ready(function () {
            $('.btnSave').on('click', function () {
                const formData = new FormData();

                const arrField = [
                    "full_name", "phone", "address",
                    "created_by", "code", "place", "datetime",
                ];

                const itemList = [
                    "result", "result_en", "result_laos", "service_result",
                ];

                let isValid = true
                /* Tạo fn appendDataForm ở admin blade */
                isValid = appendDataForm(arrField, formData, isValid);

                let my_array = [];

                let result_list = document.getElementsByClassName('result');
                let result_en_list = document.getElementsByClassName('result_en');
                let result_laos_list = document.getElementsByClassName('result_laos');
                let service_result_list = document.getElementsByClassName('service_result');

                let total_service = null;
                for (let j = 0; j < result_list.length; j++) {
                    let result = result_list[j].value;
                    let result_en = result_en_list[j].value;
                    let result_laos = result_laos_list[j].value;
                    let service_result = service_result_list[j].value;

                    if (!result || !result_en || !result_laos || !service_result) {
                        isValid = false;
                        alert('Result not empty!')
                    }

                    if (total_service) {
                        total_service = total_service + ',' + service_result;
                    } else {
                        total_service = service_result;
                    }

                    let item = {
                        result: result,
                        result_en: result_en,
                        result_laos: result_laos,
                        service_result: service_result,
                    }
                    item = JSON.stringify(item);
                    my_array.push(item);
                }

                let array_total = total_service.split(',');
                total_service = removeDuplicates(array_total).toString();

                itemList.forEach(item => {
                    if (item === 'service_result') {
                        formData.append(item, total_service);
                    } else {
                        formData.append(item, my_array.toString());
                    }
                });

                const fieldTextareaTiny = [
                    'detail', 'detail_en', 'detail_laos'
                ];

                fieldTextareaTiny.forEach(fieldTextarea => {
                    const content = tinymce.get(fieldTextarea).getContent();
                    formData.append(fieldTextarea, content);
                });

                let excel_file = $('#prescriptions')[0].files[0];
                formData.append('prescriptions', excel_file);

                let files_data = document.getElementById('files');
                let i = 0, len = files_data.files.length, img, reader, file;
                for (i; i < len; i++) {
                    file = files_data.files[i];
                    formData.append('files[]', file);
                }

                if (!isValid) {
                    return;
                }

                try {
                    $.ajax({
                        url: `{{ route('api.medical.medical.result.update', $result->id) }}`,
                        method: 'POST',
                        headers: headers,
                        contentType: false,
                        cache: false,
                        processData: false,
                        data: formData,
                        success: function (response) {
                            alert('Update success!')
                            window.location.href = `{{ route('view.admin.medical.result.list') }}`
                        },
                        error: function (error) {
                            console.log(error);
                            alert(error.responseJSON.message);
                        }
                    });
                } catch (e) {
                    console.log(e)
                    alert('Error, Please try again!');
                }
            })

            $('.btnDownloadFile').on('click', function () {
                let url = `{{ route('user.download.file', $result->id) }}`;
                let alertMessage = `Vui lòng nhập vào file theo định dạng mẫu đã được viết sẵn! Chúng tôi không khuyến khích bất kì hành động thay đổi định dạng file hoặc cấu trúc dữ liệu trong file vì điều này sẽ ảnh hướng đến việc đọc hiểu dữ liệu.`
                if (confirm(alertMessage)) {
                    window.location.href = url;
                }
            })
        })

        function removeDuplicates(arr) {
            return arr.filter((item, index) => arr.indexOf(item) === index);
        }
    </script>
    <script>
        let html = `<div class="service-result-item d-flex align-items-center justify-content-between border p-3">
                                <div class="service-result w-75">
                                    <div class="form-group">
                                        <label for="service_name">{{ __('home.Service Name') }}</label>
                                        <input type="text" class="form-control service_result" id="service_name" value=""
                                               placeholder="{{ __('home.Apartment, studio, or floor') }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="result">{{ __('home.Result') }}</label>
                                        <input type="text" class="form-control result" id="result" placeholder="{{ __('home.Result') }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="result_en">{{ __('home.Result En') }}</label>
                                        <input type="text" class="form-control result_en" id="result_en" placeholder="{{ __('home.Result En') }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="result_laos">{{ __('home.Result Laos') }}</label>
                                        <input type="text" class="form-control result_laos" id="result_laos" placeholder="{{ __('home.Result Laos') }}">
                                    </div>
                                </div>
                                <div class="action">
                                    <i class="fa-regular fa-trash-can btnTrash" style="cursor: pointer; font-size: 24px"></i>
                                </div>
                        </div>`;

        $(document).ready(function () {
            $('.btnAddNewResult').on('click', function () {
                $('#list-service-result').append(html);
                loadTrash();
            })

            loadTrash();

            function loadTrash() {
                $('.btnTrash').on('click', function () {
                    let main = $(this).parent().parent();
                    main.remove();
                })
            }
        })
    </script>
@endsection
