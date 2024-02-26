@php use App\Enums\SearchMentoring; @endphp
@extends('layouts.master')
@section('title', 'Home')
@section('content')
    <link href="{{ asset('css/mentoring.css') }}" rel="stylesheet">

    <head>
        <meta charset=utf-8>
        <meta name=description content="">
        <meta name=viewport content="width=device-width, initial-scale=1">
        <title>Jquery Comments Plugin</title>

        <!-- Styles -->
        <link rel="stylesheet" type="text/css"
              href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">

        <!-- Libraries -->
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
        <script type="text/javascript"
                src="https://cdnjs.cloudflare.com/ajax/libs/jquery.textcomplete/1.8.0/jquery.textcomplete.js"></script>

        {{--        @include('examination.mentoring.jquery-comment')--}}

        <!-- Init jquery-comments -->
        <script type="text/javascript">
            let data;
            let headers = {
                'Authorization': `Bearer ${token}`
            };
            $.ajax({
                url: `{{route('questions.custome.list')}}`,
                method: 'GET',
                headers: headers,
                success: function (response) {
                    data = response;
                },
                error: function (exception) {
                    console.log(exception)
                }
            });
        </script>

    </head>
    @include('layouts.partials.header_3')
    @include('component.banner')
    <div id="mentoring" class="container">


        <div id="comments-container"></div>

        <div class="border-bottom">
            <div class="div d-flex justify-content-between mb-md-3 m-1">
                <div class="text-wrapper d-inline-flex header_comment">{{ __('home.Best question') }}</div>
            </div>
        </div>

        <div class="row mb-md-5 mb-2">
            @foreach($questions as $index => $question)
                <div class="col-sm-6 list-group list-group-flush">
                    <span class="list-group-item d-flex justify-content-between align-items-center">
                        <a href="{{ route('examination.mentoring.show', $question->id) }}"><b class="style-b">{{ $index + 1 }}
                                @if(locationHelper() == 'vi')
                                    {{ ($question->title ?? '') }}
                                @else
                                    {{ ($question->title_en  ?? $question->title ) }}
                                @endif
                            </b></a>
                        <span class="text-red">({{ $question->answers_count }})</span>
                    </span>
                </div>
            @endforeach
        </div>

        <div class="border-bottom">
            <div class="div d-md-flex d-block justify-content-between mb-md-3 mb-1">
                <div class="text-wrapper d-inline-flex header_comment">{{ __('home.All comments') }}</div>
                <div class="d-inline-flex cl-select">
                    {{ __('home.Sorted by') }}
                    <div class="form-check mx-1">
                        <input class="form-check-input" type="radio" name="type" id="exampleRadios1"
                               value="{{ SearchMentoring::LATEST }}" checked>
                        <label class="form-check-label" for="exampleRadios1">
                            {{ __('home.Latest') }}
                        </label>
                    </div>
                    <div class="form-check mx-1">
                        <input class="form-check-input" type="radio" name="type" id="exampleRadios2"
                               value="{{ SearchMentoring::MOST_COMMENTED }}">
                        <label class="form-check-label" for="exampleRadios2">
                            {{ __('home.Most commented') }}
                        </label>
                    </div>
                    <div class="form-check mx-1">
                        <input class="form-check-input" type="radio" name="type" id="exampleRadios3"
                               value="{{ SearchMentoring::MOST_VIEWS }}">
                        <label class="form-check-label" for="exampleRadios3">
                            {{ __('home.Most views') }}
                        </label>
                    </div>
                </div>
            </div>
        </div>
        <div class="nav d-flex flex-nowrap mt-md-3 mt-1">
            <a class="tab" onclick="choiceType(this, 0)">{{ __('home.All') }}</a>
            <a class="tab" onclick="choiceType(this, 1)">{{ __('home.Heath') }}</a>
            <a class="tab" onclick="choiceType(this, 2)">{{ __('home.Beauty') }}</a>
            <a class="tab" onclick="choiceType(this, 3)">{{ __('home.Losing weight') }}</a>
            <a class="tab" onclick="choiceType(this, 4)">{{ __('home.Kids') }}</a>
            <a class="tab" onclick="choiceType(this, 5)">{{ __('home.Pets') }}</a>
            <a class="tab" onclick="choiceType(this, 6)">{{ __('home.Other') }}</a>
        </div>
        <div id="all_comment"></div>
    </div>

    <script>

        let category_id = 0;

        function choiceType(elememt, value) {
            // Lấy tất cả các thẻ có lớp 'tab'
            var tabs = document.querySelectorAll('.tab');

            // Hủy (remove) lớp 'active' của tất cả các thẻ
            tabs.forEach(function (tab) {
                tab.classList.remove('active');
            });

            // Thêm lớp 'active' cho thẻ được chọn
            elememt.classList.toggle('active');
            category_id = value;

            searchMentoring();
        }


        const radioButtons = document.getElementsByName("type");
        let selectedValue = '{{ SearchMentoring::LATEST }}'
        // Add an event listener to each radio button
        radioButtons.forEach(function (radioButton) {
            radioButton.addEventListener("click", function () {
                // Check if the radio button is checked
                if (radioButton.checked) {
                    // Get the value of the checked radio button
                    selectedValue = radioButton.value;
                    searchMentoring();
                }
            });
        });

        searchMentoring();

        function searchMentoring() {

            const formData = new FormData();
            formData.append("type", selectedValue);
            formData.append("_token", '{{ csrf_token() }}');
            formData.append("category_id", category_id);

            try {
                $.ajax({
                    url: `{{route('examination.mentoring.search')}}`,
                    method: 'POST',
                    headers: headers,
                    contentType: false,
                    cache: false,
                    processData: false,
                    data: formData,
                    success: function (response) {
                        console.log(response)
                        renderJsonToHTML(response);
                    },
                    error: function (exception) {
                        console.log(exception)
                    }
                });
            } catch (error) {
                throw error;
            }
        }

        function renderJsonToHTML(data) {
            let str = '';
            data.forEach((comment) => {

                let textCate = '';
                switch (comment.category_id) {
                    case 1:
                        textCate = 'Health';
                        break;
                    case 2:
                        textCate = 'Beauty';
                        break;
                    case 3:
                        textCate = 'Losing weight';
                        break;
                    case 4:
                        textCate = 'Kids';
                        break;
                    case 5:
                        textCate = 'Pets';
                        break;
                    case 6:
                        textCate = 'Other';
                        break;
                    default:
                        textCate = 'All';
                }
                let url = '{{ route('examination.mentoring.show', ['id' => ':id']) }}';
                url = url.replace(':id', comment.id);

                str += `<div class="frame border-bottom comment_list mb-md-3">
                <div class="frame-wrapper">
                    <div class="div">
                        <div class="div-wrapper">
                            <div class="text-wrapper textCate">${textCate}</div>
                        </div>
                        <div class="div-2">
                            <a href="${url}"><div class="lin-tip-tht-bi-cc"><p class="p">
                            @if(locationHelper() == 'vi')
                ${comment.title}
                @else
                ${comment.title_en ?? comment.title}
                @endif
                </p>
                            </div></a>
                            <div class="row w-100">
                                <div class="col-sm-2 col text-cmt"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                        <path d="M7.5 12H7.51M12 12H12.01M16.5 12H16.51M12 21C16.9706 21 21 16.9706 21 12C21 7.02944 16.9706 3 12 3C7.02944 3 3 7.02944 3 12C3 13.1971 3.23374 14.3397 3.65806 15.3845C3.73927 15.5845 3.77988 15.6845 3.798 15.7653C3.81572 15.8443 3.8222 15.9028 3.82221 15.9839C3.82222 16.0667 3.80718 16.1569 3.77711 16.3374L3.18413 19.8952C3.12203 20.2678 3.09098 20.4541 3.14876 20.5888C3.19933 20.7067 3.29328 20.8007 3.41118 20.8512C3.54589 20.909 3.73218 20.878 4.10476 20.8159L7.66265 20.2229C7.84309 20.1928 7.9333 20.1778 8.01613 20.1778C8.09715 20.1778 8.15566 20.1843 8.23472 20.202C8.31554 20.2201 8.41552 20.2607 8.61549 20.3419C9.6603 20.7663 10.8029 21 12 21ZM8 12C8 12.2761 7.77614 12.5 7.5 12.5C7.22386 12.5 7 12.2761 7 12C7 11.7239 7.22386 11.5 7.5 11.5C7.77614 11.5 8 11.7239 8 12ZM12.5 12C12.5 12.2761 12.2761 12.5 12 12.5C11.7239 12.5 11.5 12.2761 11.5 12C11.5 11.7239 11.7239 11.5 12 11.5C12.2761 11.5 12.5 11.7239 12.5 12ZM17 12C17 12.2761 16.7761 12.5 16.5 12.5C16.2239 12.5 16 12.2761 16 12C16 11.7239 16.2239 11.5 16.5 11.5C16.7761 11.5 17 11.7239 17 12Z" stroke="#424242" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                    <div class="text-wrapper-2 d-none d-md-inline-block">{{__('home.Comment: ')}}</div>${comment.comment_count ?? 0}</div>
                                <div class="col-sm-2 col text-cmt"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                        <path d="M2.42012 12.7132C2.28394 12.4975 2.21584 12.3897 2.17772 12.2234C2.14909 12.0985 2.14909 11.9015 2.17772 11.7766C2.21584 11.6103 2.28394 11.5025 2.42012 11.2868C3.54553 9.50484 6.8954 5 12.0004 5C17.1054 5 20.4553 9.50484 21.5807 11.2868C21.7169 11.5025 21.785 11.6103 21.8231 11.7766C21.8517 11.9015 21.8517 12.0985 21.8231 12.2234C21.785 12.3897 21.7169 12.4975 21.5807 12.7132C20.4553 14.4952 17.1054 19 12.0004 19C6.8954 19 3.54553 14.4952 2.42012 12.7132Z" stroke="#424242" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M12.0004 15C13.6573 15 15.0004 13.6569 15.0004 12C15.0004 10.3431 13.6573 9 12.0004 9C10.3435 9 9.0004 10.3431 9.0004 12C9.0004 13.6569 10.3435 15 12.0004 15Z" stroke="#424242" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                    <div class="text-wrapper-2 d-none d-md-inline-block">{{__('home.Views: ')}}</div>${comment.view_count ?? 0}</div>
                                <div class="col-auto col text-cmt"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                        <path d="M12 6V12L16 14M22 12C22 17.5228 17.5228 22 12 22C6.47715 22 2 17.5228 2 12C2 6.47715 6.47715 2 12 2C17.5228 2 22 6.47715 22 12Z" stroke="#424242" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                    <div class="text-wrapper-2 d-none d-md-inline-block">{{__('home.Date: ')}}</div>${comment.created_at}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>`
            });

            $('#all_comment').html('');
            $('#all_comment').html(str);
        }
    </script>

@endsection
