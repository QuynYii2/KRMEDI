@php use App\Enums\AnswerStatus;use App\Models\QuestionLikes;use App\Models\User;use Carbon\Carbon;use Illuminate\Support\Facades\Auth; @endphp
@extends('layouts.master')
@section('title', 'Home')
@section('content')
    <style>
        .tox.tox-tinymce {
            width: 100%;
        }
    </style>
    <link href="{{ asset('css/detail.css') }}" rel="stylesheet">
    @include('layouts.partials.header_3')
    @include('component.banner')
    @php
        $isDoctor = false;
        if (Auth::check()){
            $doctor = \App\Models\DoctorInfo::where('created_by', Auth::user()->id)->where('status', \App\Enums\DoctorInfoStatus::ACTIVE)->first();
            if ($doctor){
                $isDoctor = true;
            }
        }
        $isMedical = (new \App\Http\Controllers\MainController())->checkMedical();
    @endphp
    <div id="mentoring" class="container">
        <a href="{{ route('examination.mentoring') }}">
            <div class="page-header">
                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32" fill="none"
                     style="vertical-align: inherit">
                    <path d="M26.6654 16H5.33203M5.33203 16L13.332 24M5.33203 16L13.332 8" stroke="black"
                          stroke-width="4"
                          stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                <h1 class="d-inline ml-3">{{ __('home.Comment') }}</h1>
            </div>
        </a>
        <div class="card-body">
            <h5 class="card-title">{{ $question->title }}
                @if(locationHelper() == 'vi')
                    {{ ($question->title)}}
                @else
                    {{ ($question->title_en) }}
                @endif
            </h5>
            <p class="card-text">
                @if(locationHelper() == 'vi')
                    {{ $question->content }}
                @else
                    {{$question->content_en}}
                @endif</p>
        </div>

        <div class="frame row justify-content-md-around mentoring-img" id="mentoring-img">

            @foreach(explode(',', $question->gallery_public) as $picture)

                <div class="div col-sm-4">
                    <div class="catalog">
                        <div class="div">
                            <img alt="" class="rectangle" src="{{ asset($picture) }}"/>
                        </div>
                    </div>
                </div>
            @endforeach

            @if(Auth::check())
                @php
                    $doctor = \App\Models\DoctorInfo::where('created_by', Auth::user()->id)->first();
                @endphp
                @if(Auth::user()->id == $question->user_id || $isMedical)
                    @foreach(explode(',', $question->gallery) as $picture)
                        <div class="div col-sm-4">
                            <div class="catalog">
                                <div class="div">
                                    <img alt="" class="rectangle" src="{{ asset($picture) }}"/>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
            @endif
        </div>
        <style>
            .d-ch-v-c-c-t-t-l-n-u-wrapper a{
                text-decoration: underline;
            }
        </style>
        <div class="mt-5">
            <div class="frame comment-item mb-3 d-none" id="comment-main">
                <div class="div-5 ">
                    <div class="frame-wrapper">
                        <div class="div-6 w-100">
                            <img class="img"
                                 src="https://media.licdn.com/dms/image/D560BAQE96KctT7x-iw/company-logo_200_200/0/1666170056007?e=2147483647&v=beta&t=U-5DmL_mYQaduEYyl0aVlabEvxP6-F5nZE9daao6Wuk" alt=""/>
                            <textarea type="text" class="form-control text-wrapper-4 w-100 h-100 border-0"
                                      placeholder="{{ __('home.Enter question here') }}" id="input-comment-main"></textarea>
                        </div>
                    </div>
                    <div class="text-wrapper-5">
                        <button type="button" class="btn mx-2 w-100 h-100"
                                onclick="submitCommentMain()">{{ __('home.comment') }}
                        </button>
                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-center">
                @php
                    $isLike = QuestionLikes::where('question_id', $question->id)->where('user_id', Auth::user()->id ?? '')->first();
                    if (!$isLike) {
                        $isLike = false;
                    }
                @endphp

                @if(!Auth::check())
                    <button type="button" class="btn btn-primary mx-2 button-main"
                            onclick="alertLogin()">{{ __('home.Like') }}</button>
                @else
                    <button type="button" class="btn btn-primary mx-2 button-main"
                            onclick="changeEmotion()">{{ $isLike ? ( $isLike->is_like ? 'Dislike' : 'Like' ) : 'Like'}}</button>
                @endif
                @if($isMedical)
                    <button type="button" class="btn btn-primary mx-2 button-main"
                            onclick="replyCommentMain()">{{ __('home.Reply') }}
                    </button>
                @endif
            </div>
        </div>

        <div class="border-bottom mb-4">
            <div class="div d-flex justify-content-between mb-3">
                <div class="text-wrapper d-inline-flex header_comment">{{ __('home.Answer') }}</div>
            </div>
        </div>

        @foreach($answers as $index => $answer)
            <div class="frame comment-item border-bottom pb-3" id="{{ $index }}">
                <div class="div">
                    <div class="div-2">
                        <div class="div-3">
                            <div class="div-4">
                                <img class="ellipse"
                                     src="https://media.licdn.com/dms/image/D560BAQE96KctT7x-iw/company-logo_200_200/0/1666170056007?e=2147483647&v=beta&t=U-5DmL_mYQaduEYyl0aVlabEvxP6-F5nZE9daao6Wuk"/>
                                <div
                                    class="text-wrapper text-title">{{ $answer->user_id ? User::getNameByID($answer->user_id) : $answer->name }}</div>
                            </div>
                            <div class="div-wrapper">
                                <div
                                    class="text-wrapper-2">{{ Carbon::parse($answer->created_at)->format('H:i:s d/m/Y') }}</div>
                            </div>
                        </div>
                        <div class="d-ch-v-c-c-t-t-l-n-u-wrapper">
                            <p class="d-ch-v-c-c-t-t-l-n-u">
                                <span class="text-wrapper-3">  @if(locationHelper() == 'vi')
                                        {!! $answer->content !!}
                                    @else
                                       {!! $answer->content_en !!}
                                    @endif</span>
                            </p>
                        </div>
                    </div>

                    <div class="div-5" id="reply-comment-{{ $index }}" style="display: none">
                        <div class="frame-wrapper">
                            <div class="div-6 w-100">

                                <label for="input-comment-{{ $index }}">
                                    <img class="img" src="https://media.licdn.com/dms/image/D560BAQE96KctT7x-iw/company-logo_200_200/0/1666170056007?e=2147483647&v=beta&t=U-5DmL_mYQaduEYyl0aVlabEvxP6-F5nZE9daao6Wuk" alt=""/>
                                </label>
                                <textarea type="text" class="form-control text-wrapper-4 w-100 h-100 border-0"
                                                                                          id="input-comment-{{ $index }}"
                                                                                          placeholder="{{ __('home.Enter question here') }}"></textarea>
                            </div>
                        </div>
                        <div class="text-wrapper-5">
                            <button type="button" class="btn mx-2 w-100 h-100"
                                    onclick="submitComment('{{ $index }}')">{{ __('home.comment') }}
                            </button>
                        </div>
                    </div>
                    <style>
                        .blue {
                            color: #007bff;
                        }
                        .grey {
                            color: #929292;
                        }
                    </style>
                    <div class="div-5 justify-content-end" id="button-reply-comment-{{ $index }}">
                        @php
                            $infoDoctorAnswer = User::where('id', $answer->user_id)->first();

                            $checkCallDoctor = \App\Models\Question::where('id', $question->id)->first();
                            $userCheck = \App\Models\User::where('id', $checkCallDoctor->user_id)->first();
                                $checkLike = \App\Models\Answer::where('id', $answer->id)->get();
                                if ($checkLike) {
                                    $checkLikes = $answer->likes;
                                }
                                else {
                                    $checkLikes = 0;
                                }
                            $isLikes = \App\Models\AnswerLike::where('answer_id', $answer->id)
                            ->where('user_id', Auth::user()->id ?? '')
                            ->where('is_like', 1)
                            ->first();
                            if ($isLikes) {
                                $isLike = 'blue';
                            }
                            else {
                                $isLike = 'grey';
                            }
                        @endphp
                        @if(Auth::check())
                            <div class="like-cmt d-flex">
                                <a onclick="updateLikeCmt('{{ Auth::user()->id }}', '{{ $answer->id }}' , '{{ $index }}')">
                                    <i id="fa-solid-{{$answer->id}}" class="fa-solid fa-thumbs-up {{$isLike}}"></i>
                                </a>
                                <div class="like-count-{{ $index }}">
                                    {{$checkLikes}}
                                </div>
                            </div>
                            @if(Auth::user()->id == $userCheck->id && $infoDoctorAnswer != null)
                                <div id="opt_btn" class="d-flex justify-content-between justify-content-md-center">
                                    <a onclick="handleStartChatWithDoctor('{{ $infoDoctorAnswer->id }}')" class="mr-2">
                                        <button class="p-1">{{ __('home.Chat') }}</button>
                                    </a>
                                    <form method="post" action="{{ route('createMeeting') }}" target="_blank">
                                        {{ csrf_field() }}
                                        <input type="hidden" name="user_id_1"
                                               value="@if(Auth::check()) {{ Auth::user()->id }} @endif">
                                        <input type="hidden" name="user_id_2" value="{{ $infoDoctorAnswer->id }}">
                                        <button class="p-1" type="submit">{{ __('home.Videocall') }}</button>
                                    </form>
                                </div>
                            @endif

                        @else
                            <div class="like-cmt"><a onclick="alertLogin()"><i
                                        class="fa-solid fa-thumbs-up"></i></a>{{$checkLikes}}</div>
                        @endif
                    @if($isMedical)
                            <div class="text-wrapper-3 reply-comment">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16"
                                     fill="none">
                                    <g clip-path="url(#clip0_1944_12433)">
                                        <path
                                            d="M6.66667 4.66808V1.83342C6.66667 1.63275 6.546 1.45142 6.36133 1.37275C6.17733 1.29475 5.962 1.33408 5.81867 1.47475L0.152 6.97475C0.0546667 7.06875 0 7.19808 0 7.33342C0 7.46875 0.0546667 7.59808 0.152 7.69208L5.81867 13.1921C5.96333 13.3321 6.178 13.3714 6.36133 13.2941C6.546 13.2154 6.66667 13.0341 6.66667 12.8334V10.0001H7.612C10.7027 10.0001 13.552 11.6801 15.0473 14.3814L15.0613 14.4067C15.1507 14.5694 15.32 14.6667 15.5 14.6667C15.5413 14.6667 15.5827 14.6621 15.624 14.6514C15.8453 14.5947 16 14.3954 16 14.1667C16 8.98408 11.8287 4.75742 6.66667 4.66808Z"
                                            fill="#929292"/>
                                    </g>
                                    <defs>
                                        <clipPath id="clip0_1944_12433">
                                            <rect width="16" height="16" fill="white"/>
                                        </clipPath>
                                    </defs>
                                </svg>{{ __('home.Reply') }}</div>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div id="image-viewer">
        <span class="close">&times;</span>
        <img class="modal-content" id="full-image">
    </div>

    <script>
        $(document).ready(function () {
            var mentoringDivs = $('#mentoring-img').find('img.rectangle');

            mentoringDivs.on('click', function () {
                var imageUrl = $(this).attr('src');

                $('#full-image').attr('src', imageUrl);

                $('#image-viewer').css('display', 'flex');
            });

            $("#image-viewer").click(function () {
                $('#image-viewer').hide();
            });
        });

        var replyCommentElements = document.querySelectorAll(".reply-comment");
        let headers = {
            'Authorization': `Bearer ${token}`
        };
        // Gắn sự kiện "click" cho mỗi phần tử
        replyCommentElements.forEach(function (element) {
            element.addEventListener("click", function () {
                var parentFrame = element.closest('.frame.comment-item');
                if (parentFrame) {
                    toggleReplyComment(parentFrame.id);
                }
            });
        });

        function hiddenReplyComment() {
            var replyCommentDivs = document.querySelectorAll("div[id^='reply-comment-']");

            replyCommentDivs.forEach(function (div) {
                div.style.display = "none";
            });
            var replyButtonDivs = document.querySelectorAll("div[id^='button-reply-comment-']");

            replyButtonDivs.forEach(function (div) {
                div.style.display = "flex";
            });

            document.getElementById('comment-main').classList.add('d-none');
        }

        function toggleReplyComment(id) {
            const idComment = `reply-comment-${id}`;
            const idButtonReplyComment = `button-reply-comment-${id}`;
            const commentElement = document.getElementById(idComment);
            const buttonReplyCommentElement = document.getElementById(idButtonReplyComment);

            hiddenReplyComment();

            if (commentElement && buttonReplyCommentElement) {
                if (commentElement.style.display === 'none') {
                    commentElement.style.display = 'flex';
                    buttonReplyCommentElement.style.display = 'none';
                } else {
                    commentElement.style.display = 'none';
                    buttonReplyCommentElement.style.display = 'block';
                }
            }
        }

        function submitComment(id) {
            if (!token) {
                alert('Please login to apply')
                return;
            }

            const idComment = `input-comment-${id}`;
            console.log(idComment)

            const commentValue = tinymce.get(idComment).getContent();
            console.log(commentValue)

            const formData = new FormData();
            formData.append("_token", '{{ csrf_token() }}');
            formData.append("content", commentValue);
            formData.append("content_en", commentValue);
            formData.append("content_laos", commentValue);
            formData.append("question_id", '{{ $question->id }}');
            formData.append("answer_parent", '');
            formData.append("status", '{{ AnswerStatus::APPROVED }}');
            formData.append("user_id", '{{ Auth::user()->id ?? '' }}');
            formData.append("pings", '');
            formData.append("name", '{{ User::getNameByID(Auth::user()->id ?? '' )  }}');

            try {
                $.ajax({
                    url: `{{route('answers.api.create')}}`,
                    method: 'POST',
                    headers: headers,
                    contentType: false,
                    cache: false,
                    processData: false,
                    data: formData,
                    success: function (response) {
                        location.reload();
                    },
                    error: function (exception) {
                    }
                });
            } catch (error) {
                throw error;
            }
        }

        function submitCommentMain() {
            if (!token) {
                alert('Please login to apply')
                return;
            }

            const idComment = `input-comment-main`;

            const commentValue = tinymce.get(idComment).getContent();

            const formData = new FormData();
            formData.append("_token", '{{ csrf_token() }}');
            formData.append("content", commentValue);
            formData.append("content_en", commentValue);
            formData.append("content_laos", commentValue);
            formData.append("question_id", '{{ $question->id }}');
            formData.append("answer_parent", '');
            formData.append("status", '{{ AnswerStatus::APPROVED }}');
            formData.append("user_id", '{{ Auth::user()->id ?? '' }}');
            formData.append("pings", '');
            formData.append("name", '{{ User::getNameByID(Auth::user()->id ?? '' )  }}');

            try {
                $.ajax({
                    url: `{{route('answers.api.create')}}`,
                    method: 'POST',
                    headers: headers,
                    contentType: false,
                    cache: false,
                    processData: false,
                    data: formData,
                    success: function (response) {
                        location.reload();
                    },
                    error: function (exception) {
                    }
                });
            } catch (error) {
                throw error;
            }
        }

        function changeEmotion() {
            if (!token) {
                alert('Please login to apply')
                return;
            }

            const formData = new FormData();
            formData.append("_token", '{{ csrf_token() }}');

            let url = '{{route('api.backend.question-like.change', ['questionId' => $question->id ?? 0, 'userId' => Auth::user()->id ?? 0])}}';
            try {
                $.ajax({
                    url: url,
                    method: 'POST',
                    headers: headers,
                    contentType: false,
                    cache: false,
                    processData: false,
                    data: formData,
                    success: function () {
                        location.reload();
                    },
                    error: function (exception) {
                    }
                });
            } catch (error) {
                throw error;
            }
        }

        function replyCommentMain() {
            hiddenReplyComment();
            var commentMain = document.getElementById('comment-main');
            commentMain.classList.toggle('d-none');
        }

        function alertLogin() {
            alert('Please login to apply')

        }

    </script>
    <script>
        async function updateLikeCmt(user, answer, idComment) {
            loadingMasterPage();
            let url = '{{ route('api.backend.like.answer') }}';
            const headers = {
                'Authorization': `Bearer ${token}`,
            };
            const formData = new FormData();
            formData.append('_token', '{{ csrf_token() }}');
            formData.append("user_id", user);
            formData.append("answer_id", answer);

            try {
                const response = await $.ajax({
                    url: url,
                    method: 'POST',
                    headers: headers,
                    contentType: false,
                    cache: false,
                    data: formData,
                    processData: false,
                });

                if (response.message === 'Success!') {
                    $('.like-cmt').find(`.like-count-${idComment}`).text(response.data);
                    $('#fa-solid-'+answer).toggleClass('grey');
                    $('#fa-solid-'+answer).toggleClass('blue');
                }
            } catch (error) {
                console.error('Error:', error);
            } finally {
                loadingMasterPage();
            }
        }

    </script>
@endsection
