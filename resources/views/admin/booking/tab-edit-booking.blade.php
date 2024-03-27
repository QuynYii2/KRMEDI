@extends('layouts.admin')
@section('title')
    {{ __('home.Edit') }}
@endsection
@section('page-style')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" />
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
@endsection
@section('main-content')
    <div class="container-fluid">
        <h1 class="h3 mb-4 text-gray-800">{{ __('home.List Booking') }}</h1>
        <form id="form" action="{{ route('api.backend.booking.update', $bookings_edit->id) }}" method="post"
            enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-md-3 form-group">
                    <label for="user">{{ __('home.Tên người đăng ký') }}</label>
                    @php
                        $user_name = \App\Models\User::where('id', $bookings_edit->user_id)->value('name');
                    @endphp
                    <input type="text" class="form-control" id="user" name="user" value="{{ $user_name }}"
                        disabled>
                </div>
                <div class="col-md-3 form-group">
                    <label for="clinic_id">{{ __('home.BusinessName') }}</label>
                    @php
                        $clinic_name = \App\Models\Clinic::where('id', $bookings_edit->clinic_id)->value('name');
                    @endphp
                    <input type="text" class="form-control" id="user" name="clinic_id" value="{{ $clinic_name }}"
                        disabled>
                </div>
                <div class="col-md-3 form-group">
                    <label for="department_id">{{ __('home.Department') }}</label>
                    @php
                        $department = \App\Models\Department::find($bookings_edit->department_id);
                    @endphp
                    <input type="text" class="form-control" id="department_id" name="department_id"
                        value="{{ $department ? $department->name : '' }}" disabled>
                </div>
                <div class="col-md-3 form-group">
                    <label for="doctor_id">{{ __('home.Doctor Name') }}</label>
                    @php
                        $doctor = \App\Models\User::where('id', $bookings_edit->doctor_id)->first();
                        $doctor_info = '';
                        if ($doctor) {
                            $doctor_info = $doctor->username . '-' . $doctor->email;
                        }
                    @endphp
                    <input type="text" class="form-control" id="doctor_id" name="doctor_id" value="{{ $doctor_info }}"
                        disabled>
                    {{-- <select class="form-select" id="doctor_id" name="doctor_id">
                        @if ($doctor_id && $doctor_name)
                            <option value="{{ $doctor_id }}">{{ $doctor_name }}</option>
                        @endif
                    </select> --}}
                </div>
            </div>
            <div class="row">
                <div class="col-md-3 form-group">
                    <label for="check_in">{{ __('home.Thời gian bắt đầu') }}</label>
                    <input disabled type="datetime-local" class="form-control" id="check_in" name="check_in"
                        value="{{ $bookings_edit->check_in }}">
                </div>
                <div class="col-md-3 form-group">
                    <label for="check_out">{{ __('home.Thời gian kết thúc') }}</label>
                    <input disabled type="datetime-local" class="form-control" id="check_out" name="check_out"
                        value="{{ $bookings_edit->check_out }}">
                </div>
                <div class="col-md-3 form-group">
                    <label for="booking_status">{{ __('home.Trạng thái') }}</label>
                    <select class="form-select" id="booking_status" name="status">
                        <option value="{{ \App\Enums\BookingStatus::PENDING }}"
                            {{ $bookings_edit->status === \App\Enums\BookingStatus::PENDING ? 'selected' : '' }}>
                            {{ \App\Enums\BookingStatus::PENDING }}
                        </option>
                        <option value="{{ \App\Enums\BookingStatus::COMPLETE }}"
                            {{ $bookings_edit->status === \App\Enums\BookingStatus::COMPLETE ? 'selected' : '' }}>
                            {{ \App\Enums\BookingStatus::COMPLETE }}
                        </option>
                        <option value="{{ \App\Enums\BookingStatus::APPROVED }}"
                            {{ $bookings_edit->status === \App\Enums\BookingStatus::APPROVED ? 'selected' : '' }}>
                            {{ \App\Enums\BookingStatus::APPROVED }}
                        </option>
                        <option value="{{ \App\Enums\BookingStatus::CANCEL }}"
                            {{ $bookings_edit->status === \App\Enums\BookingStatus::CANCEL ? 'selected' : '' }}>
                            {{ \App\Enums\BookingStatus::CANCEL }}
                        </option>
                    </select>
                </div>
                <div class=" col-md-3 form-group mt-4">
                    <label for="services"></label>
                    <input type="checkbox" name="is_result" {{ $bookings_edit->is_result == 1 ? 'checked' : '' }}
                        class="is_result" id="is_result" value="1">
                    <label for="is_result">{{ __('home.Result') }}</label>
                    @if (isset(Auth::user()->extend['isActivated']) && Auth::user()->extend['isActivated'])
                        @if (
                            $bookings_edit->is_result == 1 &&
                                $bookings_edit->status === \App\Enums\BookingStatus::COMPLETE &&
                                $user_zalo_id != 0)
                            <a href="{{ route('admin.send.booking.result', ['id' => $bookings_edit->id, 'userId' => $user_zalo_id]) }}"
                                class="btn btn-outline-dark ms-5">Gửi thông báo qua zalo</a>
                        @endif
                    @endif
                </div>
            </div>
            <div class="row" id="showReasonCancel">

            </div>

            {{-- @if ($bookings_edit->is_result == 1 && $bookings_edit->status === \App\Enums\BookingStatus::COMPLETE) --}}
            <div id="trackFile" style="display: none;">
                <div id="repeater">
                    @forelse ($repeaterItems as $index => $item)
                        <div class="d-flex align-items-center row repeater-item">
                            <div class="col-md-1 delete-repeater-div">
                                @if ($index != 0)
                                    <button class="btn btn-danger delete-btn" data-index="{{ $index }}"><i
                                            class="fa-solid fa-x"></i></button>
                                @endif
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="selectType{{ $index }}">Loại khám bệnh:</label>
                                    <select id="selectType{{ $index }}" class="form-control" name="select[]">
                                        <option value="Khám bệnh"
                                            {{ $item['selectValue'] === 'Khám bệnh' ? 'selected' : '' }}>
                                            Khám bệnh</option>
                                        <option value="Siêu âm" {{ $item['selectValue'] === 'Siêu âm' ? 'selected' : '' }}>
                                            Siêu
                                            âm</option>
                                        <option value="XQuang" {{ $item['selectValue'] === 'XQuang' ? 'selected' : '' }}>
                                            XQuang
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="in_charged_{{ $index }}">Bác sĩ phụ trách:</label>
                                    <select id="in_charged_{{ $index }}" class="form-select doctor_selector"
                                        name="doctor_id[]">
                                        @if ($item['doctorId'] && $item['doctorName'])
                                            <option value="{{ $item['doctorId'] }}">{{ $item['doctorName'] }}</option>
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="repeater-item col-md-3">
                                <div class="form-group">
                                    <label for="file">Tài liệu khám bệnh:</label>
                                    <input type="file" name="file[{{ $index }}]" class="form-control-file"
                                        accept=".pdf">
                                    <input type="hidden" name="file_urls[{{ $index }}]"
                                        value="{{ $item['fileUrl'] }}">
                                </div>
                            </div>
                            @if (Storage::exists(str_replace('/storage', 'public', $item['fileUrl'])))
                                <div class="col-md-2 viewFile">
                                    <a target="_blank" href="{{ asset($item['fileUrl']) }}">Xem tài liệu khám</a>
                                </div>
                            @endif
                        </div>
                    @empty
                        <div class="d-flex align-items-center row repeater-item">
                            <div class="col-md-1 delete-repeater-div">
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="select1">Select:</label>
                                    <select class="form-control" name="select[]">
                                        <option value="Khám bệnh">Khám bệnh</option>
                                        <option value="Siêu âm">Siêu âm</option>
                                        <option value="XQuang">XQuang</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="in_charged">Bác sĩ phụ trách:</label>
                                    <select id="in_charged" class="form-select doctor_selector"
                                        name="doctor_id[]">
                                    </select>
                                </div>
                            </div>
                            <div class="repeater-item col-md-3">
                                <div class="form-group">
                                    <label for="file">Tài liệu khám bệnh:</label>
                                    <input type="file" name="file[]" class="form-control-file"
                                        accept=".pdf, .xlsx, .docx">
                                </div>
                            </div>
                        </div>
                    @endforelse
                </div>
                <button type="button" class="btn btn-primary" id="addBtn"><i class="fa-solid fa-plus"></i></button>
                </br>
            </div>
            {{-- @endif --}}


            <input type="text" name="services" id="services" class="form-control d-none">
            @if ($bookings_edit->is_result == 1 && $bookings_edit->status === \App\Enums\BookingStatus::COMPLETE)
                @if (isset($bookings_edit->extend['booking_results']))
                    <button type="button" class="btn btn-success mt-4 me-2"><i class="fa-regular fa-eye"
                            onclick="window.location.href = '{{ route('web.users.booking.result', ['id' => $bookings_edit->id]) }}';"></i></button>
                @endif
            @endif
            <button type="submit" class="btn btn-primary up-date-button mt-4">{{ __('home.Save') }}</button>
        </form>
    </div>

    {{-- Handle JS --}}
    <script>
        $(document).ready(function() {
            let html = `<div class="form-group">
                    <label for="reason_text">Lí do hủy: </label>
                    <input type="text" class="form-control" id="reason_text" name="reason_text" value="{{ $bookings_edit->reason_cancel }}">
                    <p class="small text-danger mt-1" id="support_reason">Vui lòng chọn/nhập lý do hủy</p>
                    <ul class="list-reason " style="list-style: none; padding-left: 0">
                        @foreach ($reasons as $reason)
            <li class="new-select">
                <input onchange="changeReason();" class="reason_item"
                       value="{{ $reason }}"
                                       id="{{ $reason }}"
                                       {{ $reason == 'Other' ? 'checked' : '' }}
            name="reason_item"
            type="radio">
     <label for="{{ $reason }}">{{ $reason }}</label>
                            </li>
                        @endforeach
            </ul>
        </div>`;
            showOrHidden(html);
            $('#booking_status').change(function() {
                showOrHidden(html);
            });
        })

        function showOrHidden(html) {
            let value = $('#booking_status').val();
            if (value === `{{ \App\Enums\BookingStatus::CANCEL }}`) {
                $('#showReasonCancel').empty().append(html);
            } else {
                $('#showReasonCancel').empty();
            }
        }

        function changeReason() {
            let value = $('input[name="reason_item"]:checked').val();
            if (value !== 'Other') {
                $('#support_reason').addClass('d-none');
                $('#reason_text').val(value).prop('disabled', false /* or 'true' to  disabled input */ );
            } else {
                $('#support_reason').removeClass('d-none');
                $('#reason_text').val('').prop('disabled', false);
            }
        }
    </script>
    <script>
        let arrayService = [];
        let arrayNameService = [];

        function removeArray(arr) {
            var what, a = arguments,
                L = a.length,
                ax;
            while (L > 1 && arr.length) {
                what = a[--L];
                while ((ax = arr.indexOf(what)) !== -1) {
                    arr.splice(ax, 1);
                }
            }
            return arr;
        }

        function getListName(array, items) {
            for (let i = 0; i < items.length; i++) {
                if (items[i].checked) {
                    if (array.length == 0) {
                        array.push(items[i].nextElementSibling.innerText);
                    } else {
                        let name = array.includes(items[i].nextElementSibling.innerText);
                        if (!name) {
                            array.push(items[i].nextElementSibling.innerText);
                        }
                    }
                } else {
                    removeArray(array, items[i].nextElementSibling.innerText)
                }
            }
            return array;
        }

        function checkArray(array, listItems) {
            for (let i = 0; i < listItems.length; i++) {
                if (listItems[i].checked) {
                    if (array.length == 0) {
                        array.push(listItems[i].value);
                    } else {
                        let check = array.includes(listItems[i].value);
                        if (!check) {
                            array.push(listItems[i].value);
                        }
                    }
                } else {
                    removeArray(array, listItems[i].value);
                }
            }
            return array;
        }

        function getInputService() {
            let items = document.getElementsByClassName('service_item');

            arrayService = checkArray(arrayService, items);
            arrayNameService = getListName(arrayNameService, items)

            let listName = arrayNameService.toString();
            if (listName) {
                $('#service_text').val(listName);
            }

            arrayService.sort();
            let value = arrayService.toString();
            $('#services').val(value);
        }

        getInputService();

        let arrayService2 = [];
        let arrayNameService2 = [];

        function getInputServiceName() {
            let items = document.getElementsByClassName('service_name_item');

            arrayService2 = checkArray(arrayService2, items);
            arrayNameService2 = getListName(arrayNameService2, items)

            let listName = arrayNameService2.toString();
            if (listName) {
                $('#service_name').val(listName);
            }

            arrayService2.sort();
            let value = arrayService2.toString();
            $('#service_result').val(value);
        }

        // getInputServiceName();
    </script>
    <script>
        // let accessToken = `Bearer ` + token;
        // let headers = {
        //     "Authorization": accessToken
        // };

        $(document).ready(function() {
            $(window).on('popstate', function() {
                location.reload();
            });

            $('.btnCreate').on('click', function() {
                createBookingResult();
            })

            $('.btnUnCreate').on('click', function() {
                unCreateBooking();
            })

            $('.btnGetFile').on('click', function() {
                let alertMessage =
                    `Vui lòng nhập vào file theo định dạng mẫu đã được viết sẵn! Chúng tôi không khuyến khích bất kì hành động thay đổi định dạng file hoặc cấu trúc dữ liệu trong file vì điều này sẽ ảnh hướng đến việc đọc hiểu dữ liệu.`
                if (confirm(alertMessage)) {
                    window.location.href = `{{ route('user.download') }}`;
                }
            })

            async function createBookingResult() {
                const formData = new FormData();

                const arrField = [
                    "booking_id", "user_id", "created_by", "status",
                ];

                const itemList = [
                    "result", "result_en", "result_laos", "service_result",
                ];

                let isValid = true
                /* Tạo fn appendDataForm ở admin blade */
                isValid = appendDataForm(arrField, formData, isValid);

                formData.append('family_member', $('#family_member').val());

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

                    if (!result || !result_en || !result_laos) {
                        isValid = false;
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
                        service_result: total_service,
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

                let files_data = document.getElementById('files');
                let i = 0,
                    len = files_data.files.length,
                    img, reader, file;
                for (i; i < len; i++) {
                    file = files_data.files[i];
                    formData.append('files[]', file);
                }

                let excel_file = $('#prescriptions')[0].files[0];
                if (!excel_file) {
                    isValid = false;
                }
                formData.append('prescriptions', excel_file);

                if (isValid) {
                    try {
                        await $.ajax({
                            url: `{{ route('api.medical.booking.result.create') }}`,
                            method: 'POST',
                            headers: headers,
                            contentType: false,
                            cache: false,
                            processData: false,
                            data: formData,
                            success: function(response) {
                                alert('Create success!')
                                // window.location.href = ``;
                                window.location.href =
                                    `{{ route('web.booking.result.list', $bookings_edit->id) }}`;
                            },
                            error: function(error) {
                                console.log(error);
                                alert('Create error!')
                            }
                        });
                    } catch (e) {
                        console.log(e)
                        alert('Error, Please try again!');
                    }
                } else {
                    alert('Sorry, Please enter input require!');
                }
            }

            function unCreateBooking() {
                alert('Booking result already exist!');
            }
        })

        function removeDuplicates(arr) {
            return arr.filter((item, index) => arr.indexOf(item) === index);
        }
    </script>
    <script>
        let html = `<div class="service-result-item d-flex align-items-center justify-content-between border p-3">
    <div class="row">
     <div class="form-group">
            <label for="service_result">{{ __('home.Service Name') }}</label>
            <input type="text" class="form-control service_result" value="{{ $bookings_edit->service }}" id="service_result" name="service_result">
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
<div class="action mt-3">
    <i class="fa-regular fa-trash-can btnTrash" style="cursor: pointer; font-size: 24px"></i>
</div>
</div>`;

        $(document).ready(function() {
            $('#list-service-result').append(html);
            $('.btnAddNewResult').on('click', function() {
                $('#list-service-result').append(html);
                loadTrash();
                loadData();
            })

            loadTrash();

            function loadTrash() {
                $('.btnTrash').on('click', function() {
                    let main = $(this).parent().parent();
                    main.remove();
                })
            }

            loadData();

            function loadData() {
                $('.service_name_item').on('click', function() {
                    let my_array = null;
                    let my_name = null;
                    $(this).parent().parent().find(':checkbox:checked').each(function(i) {
                        let value = $(this).val();
                        if (my_array) {
                            my_array = my_array + ',' + value;
                        } else {
                            my_array = value;
                        }

                        let name = $(this).data('name');
                        if (my_name) {
                            my_name = my_name + ', ' + name;
                        } else {
                            my_name = name;
                        }
                    });
                    $(this).parent().parent().prev().val(my_name);
                    $(this).parent().parent().next().find('input').val(my_array);
                })
            }
        })
    </script>

    <script>
        //REPEATER
        $(document).ready(function() {
            var counter = 2;

            $('#addBtn').click(function() {
                var clone = $('.repeater-item:first').clone();
                clone.find('select').attr('name', 'select[]');
                clone.find('input[type="file"]').attr('name',
                    'file[]');
                clone.find('input[type="file"]').val('');
                clone.find('.delete-repeater-div').html(
                    `<button class="btn btn-danger delete-btn" data-index="` + counter + `"><i
                                            class="fa-solid fa-x"></i></button>`);
                clone.find('input[type="hidden"]').remove();
                clone.find('.viewFile').remove();
                clone.appendTo('#repeater');
                counter++;
            });

            $(document).on('click', '.delete-btn', function() {
                var index = $(this).data('index');
                $(this).closest('.repeater-item').remove();
                // Update the counter and reindex the remaining items
                counter--;
                $('.delete-btn').each(function(idx) {
                    $(this).data('index', idx);
                });
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            // Function to check the conditions and show/hide the trackFile div
            function checkConditions() {
                var isChecked = $("#is_result").is(":checked");
                var selectedValue = $("#booking_status").val();

                if (isChecked && selectedValue === "COMPLETE") {
                    $("#trackFile").show();
                } else {
                    $("#trackFile").hide();
                }
            }

            // Check conditions on page load
            checkConditions();

            // Check conditions when is_result checkbox or booking_status select changes
            $("#is_result, #booking_status").change(function() {
                checkConditions();
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            $('.doctor_selector').select2({
                theme: 'bootstrap-5',
                ajax: {
                    url: "{{ route('role.user.list', ['role_id' => 39]) }}",
                    dataType: 'json',
                    delay: 250,
                    data: function(params) {
                        return {
                            name: params.term, // Pass the search term as the 'name' parameter
                        };
                    },
                    processResults: function(data) {
                        if (Array.isArray(data)) {
                            return {
                                results: data.map(function(user) {
                                    return {
                                        id: user.id,
                                        text: user.name
                                    };
                                })
                            };
                        } else {
                            return {
                                results: []
                            };
                        }
                    },
                    cache: true
                },
                minimumInputLength: 1,
            });
        });
    </script>
@endsection
