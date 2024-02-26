@php use App\Enums\SurveyStatus; @endphp
@extends('layouts.admin')
@section('title')
    {{ __('home.Create Survey') }}
@endsection
@section('main-content')
    <style>
        #answer {
            margin: 20px 0px;
        }

        .item {
            margin: 5px 0px;
        }

        input:focus {
            outline: 0;
        }

        #result {
            margin-top: 10px;
            background: pink;
            display: inline-block;
            padding: 0 10px;
            min-width: 200px;
        }

        .blink_me {
            -webkit-animation-name: blinker;
            -webkit-animation-duration: 1s;
            -webkit-animation-timing-function: linear;

            -moz-animation-name: blinker;
            -moz-animation-duration: 1s;
            -moz-animation-timing-function: linear;

            animation-name: blinker;
            animation-duration: 1s;
            animation-timing-function: linear;
        }

        @-moz-keyframes blinker {
            0% {
                opacity: 1.0;
            }
            50% {
                opacity: 0.0;
            }
            100% {
                opacity: 1.0;
            }
        }

        @-webkit-keyframes blinker {
            0% {
                opacity: 1.0;
            }
            50% {
                opacity: 0.0;
            }
            100% {
                opacity: 1.0;
            }
        }

        @keyframes blinker {
            0% {
                opacity: 1.0;
            }
            50% {
                opacity: 0.0;
            }
            100% {
                opacity: 1.0;
            }
        }
    </style>


    <h3 class="text-center"> {{ __('home.Create Survey') }}</h3>
    <div class="container">
        <form>
            <div class="row">
                <div class="form-group">
                    <label for="question">{{ __('home.Question') }}</label>
                    <input type="text" class="form-control" id="question" maxlength="200" required>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-3">
                    <label for="department_id">{{ __('home.Department') }}</label>
                    <select id="department_id" name="department_id" class="form-select">
                        @foreach($departments as $category)
                            <option value="{{$category->id}}" data-limit="30"
                                    class="text-shortcut">{{$category->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-md-3">
                    <label for="type">{{ __('home.type') }}</label>
                    <select id="type" name="type" class="form-select" onchange="handleChangeType()">
                        @foreach($types as $item)
                            <option value="{{ $item }}">{{ $item }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-md-3">
                    <label for="status">{{ __('home.type') }}</label>
                    <select id="status" name="status" class="form-select">
                        <option
                            value="{{ SurveyStatus::ACTIVE }}">{{ SurveyStatus::ACTIVE }}</option>
                        <option
                            value="{{ SurveyStatus::INACTIVE }}">{{ SurveyStatus::INACTIVE }}</option>
                    </select>
                </div>
            </div>
            <div class="row" id="row-answer">
                <div class="form-group col-md-4">
                    <label for="answer">{{ __('home.Answer') }}</label>
                    <a href="javascript:void(0)" onclick="appendAnswer('answer_vi')">{{ __('home.Add answer') }}</a>

                    <div id="answer_vi">
                        <div class="item">
                            <label>
                                <span>{{ __('home.Answer') }} 1</span>
                                <input type="text">
                            </label>
                            <a href="javascript:void(0)" class="del">{{ __('home.Delete') }}</a>
                        </div>
                    </div>

                </div>
                <div class="form-group col-md-4">
                    <label for="answer_en">{{ __('home.Answer En') }} 1</label>
                    <a href="javascript:void(0)" onclick="appendAnswer('answer_en')">{{ __('home.Add answer') }}</a>

                    <div id="answer_en">
                        <div class="item">
                            <label>
                                <span>{{ __('home.Answer') }} 1</span>
                                <input type="text">
                            </label>
                            <a href="javascript:void(0)" class="del">{{ __('home.Delete') }}</a>
                        </div>
                    </div>
                </div>
                <div class="form-group col-md-4">
                    <label for="answer_laos">{{ __('home.Answer Laos') }} </label>
                    <a href="javascript:void(0)" onclick="appendAnswer('answer_laos')">{{ __('home.Add answer') }}</a>

                    <div id="answer_laos">
                        <div class="item">
                            <label>
                                <span>{{ __('home.Answer') }} 1</span>
                                <input type="text">
                            </label>
                            <a href="javascript:void(0)" class="del">{{ __('home.Delete') }}</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="text-center mt-3">
                <button type="button" class="btn btn-primary" id="btnCreate"
                        onclick="createCategory()">{{ __('home.create') }}</button>
            </div>
        </form>
    </div>
    <script>
        let accessToken = `Bearer ` + token;
        let headers = {
            "Authorization": accessToken
        };

        const maxAnswer = 10;

        async function createCategory() {

            const symbol = '@#!';

            let answer_vi = $('#answer_vi input[type="text"]').map(function () {
                return $(this).val();
            }).get().join(symbol);

            let answer_en = $('#answer_en input[type="text"]').map(function () {
                return $(this).val();
            }).get().join(symbol);

            let answer_laos = $('#answer_laos input[type="text"]').map(function () {
                return $(this).val();
            }).get().join(symbol);

            let categoryUrl = `{{ route('api.medical.surveys.create')  }}`;

            const formData = new FormData();

            const fieldNames = [
                "question",
                "department_id", "type"
            ];

            let isValid = true;
            isValid = appendDataForm(fieldNames, formData, isValid);

            formData.append("answer_vi", answer_vi);
            formData.append("answer_en", answer_en);
            formData.append("answer_laos", answer_laos);

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
                    window.location.href = `{{ route('view.admin.surveys.index') }}`;
                },
                error: function (error) {
                    console.log(error);
                    alert('Create error!');
                }
            });
        }

        $(document).ready(function () {
            // đưa con trỏ chuột vào text field đầu tiên
            $("#answer .item:first input[type='text']").focus();

            // kích hoạt nút checkbox tương ứng khi nhập liệu cho text field
            // nếu xoá hết ký tự trong text field thì lại vô hiệu hoá checkbox
            $(document).on("keyup", "input[type='text']", function () {
                $(this).next("input[type='checkbox']").removeAttr("disabled");
                if ($(this).val() == "") {
                    $(this).next("input[type='checkbox']").attr("disabled", "disabled").removeAttr("checked");
                }
            });

            // xoá text filed khi click vào nút del ở dòng tương ứng
            // với text file đang có dữ liệu thì không cho xoá
            $(document).on("click", "a.del", function () {
                var n = countItem();
                if (n == 1) {
                    alert("Number of answers isn't less than 1");
                } else {
                    // cách viết khác
                    // var check = $(this).parent().find("label input").val();
                    var currentIndex = $(this).parent().index();

                    $("#answer_vi .item:eq(" + currentIndex + ")").remove();
                    $("#answer_en .item:eq(" + currentIndex + ")").remove();
                    $("#answer_laos .item:eq(" + currentIndex + ")").remove();

                    for (i = 0; i < n - 1; i++) {
                        $("#answer_vi .item:eq(" + i + ") label span").html("Ans " + (parseInt(i) + 1));
                        $("#answer_en .item:eq(" + i + ") label span").html("Ans " + (parseInt(i) + 1));
                        $("#answer_laos .item:eq(" + i + ") label span").html("Ans " + (parseInt(i) + 1));
                    }
                }
            });

            // nếu lựa chọn checkbox thì đánh dấu đây là câu trả lời đúng
            // nếu bỏ chọn thì không đánh dấu nữa
            $(document).on("change", "input[type='checkbox']", function () {
                var v = $(this).prop("checked");
                if (v == true) {
                    $(this).attr("checked", "checked");
                } else {
                    $(this).removeAttr("checked");
                }
            });

        });

        function appendAnswer() {
            var n = countItem();
            if (n == maxAnswer) {
                alert("Number of answers isn't greater than 10");
            } else {
                n++;
                $('#answer_vi').append("<div class='item'><label><span>Ans " + n + "</span> <input type='text'></label> <a href='javascript:void(0)' class='del'>{{ __('home.Delete') }}</a></div>");
                $('#answer_en').append("<div class='item'><label><span>Ans " + n + "</span> <input type='text'></label> <a href='javascript:void(0)' class='del'>{{ __('home.Delete') }}</a></div>");
                $('#answer_laos').append("<div class='item'><label><span>Ans " + n + "</span> <input type='text'></label> <a href='javascript:void(0)' class='del'>{{ __('home.Delete') }}</a></div>");
            }
        }

        function countItem(idDiv = 'answer_vi') {
            return $('#' + idDiv).children().length;
        }

        handleChangeType();

        function handleChangeType() {
            let type = $('#type').val();
            if (type === '{{ \App\Enums\SurveyType::TEXT }}') {
                $('#row-answer').hide();
            } else {
                $('#row-answer').show();
            }
        }
    </script>
@endsection
