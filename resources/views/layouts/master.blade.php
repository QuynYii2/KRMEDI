@php use Illuminate\Support\Facades\Auth; @endphp
    <!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDe6qi9czJ2Z6SLnV9sSUzce0nuzhRm3hg"></script>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Fashi Template">
    <meta name="keywords" content="Fashi, unica, creative, html">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title')</title>

    <link rel="icon" type="image/png"
          href="{{ asset('img/logo.png') }}">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css"/>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    {{--    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet"/>--}}
    <link href="https://use.fontawesome.com/releases/v5.0.6/css/all.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.cdnfonts.com/css/mulish" rel="stylesheet">
    {{--    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;0,1000;1,400;1,700&family=Inter:wght@400;500;600;700&family=Mulish:wght@300;400;500;600;700;800&family=Noto+Sans+KR:wght@300;400;500;700&family=Nunito+Sans:wght@400;500&family=Poppins:wght@300&family=Roboto+Slab:wght@400;500&family=Roboto:wght@500&family=Rubik:wght@300;400;500&display=swap" rel="stylesheet">--}}
    <link rel="stylesheet" href="{{asset('css/file.css')}}">
    <link rel="stylesheet" href="{{asset('css/style.css')}}">
    <link rel="stylesheet" href="{{asset('css/login.css')}}">
    <link rel="stylesheet" href="{{asset('css/recruitment.css')}}">
    <link rel="stylesheet" href="{{asset('css/flea-market.css')}}">
    <link rel="stylesheet" href="{{asset('css/responsive.css')}}">
    <link rel="stylesheet" href="{{asset('css/responsive-mobi.css')}}">
    <link rel="stylesheet" href="{{asset('css/news.css')}}">
    <script>
        const token = `{{ $_COOKIE['accessToken'] ?? '' }}`;
    </script>
    <script src="https://unpkg.com/sweetalert2@7.18.0/dist/sweetalert2.all.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.21.1/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.textcomplete/1.8.0/jquery.textcomplete.js"></script>
    @includeWhen(Auth::check(),'components.head.chat-message' )

</head>

<style>
    .loading-overlay-master {
        display: none;
        background: rgba(255, 255, 255, 0.7);
        position: fixed;
        bottom: 0;
        left: 0;
        right: 0;
        top: 0;
        z-index: 9998;
        align-items: center;
        justify-content: center;
    }

    .loading-overlay-master.is-active {
        display: flex;
    }

    .code {
        font-family: monospace;
        /*   font-size: .9em; */
        color: #dd4a68;
        background-color: rgb(238, 238, 238);
        padding: 0 3px;
    }

    .pager {
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .pager span {
        border: 1px solid #dee2e6;
        padding: 4px 8px;
        cursor: pointer;
    }

    .pg-goto {
        padding: 4px 8px;
        border-color: #dee2e6;
        color: #007bff;
    }

    .pg-normal {
        color: #0056b3;
        text-decoration: none;
        background-color: #e9ecef;
        border-color: #dee2e6;
    }

    .pg-selected {
        z-index: 1;
        color: #fff;
        background-color: #007bff;
        border-color: #007bff;
    }
</style>

<div class="d-none">
    @if(Auth::check())
        <div class="">
            <input id="input-check" type="number" value="2">
        </div>
    @else
        <input id="input-check" type="number" value="1">
    @endif
</div>
<body>
<div class="loading-overlay-master">
    <span class="fas fa-spinner fa-3x fa-spin"></span>
</div>
@include('sweetalert::alert')
<div id="content">
    @yield('content')
</div>
@include('layouts.partials.footer')

<!-- Back to top -->
<div class="btn-back-to-top" id="myBtn">
    <span class="symbol-btn-back-to-top">
        <i class="zmdi zmdi-chevron-up"></i>
    </span>
</div>


<div class="modal fade" id="modal-call-alert" data-backdrop="static" data-keyboard="false" tabindex="-1"
     aria-labelledby="modal-call-alert-label" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-call-alert-label">Modal title</h5>
                <button type="button" class="close btn_close_m" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                ...
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn_close_m" data-dismiss="modal">Từ chối</button>
                <button type="button" class="btn btn-primary" data-dismiss="modal" id="ReceiveCall">Tiếp nhận</button>
            </div>
        </div>
    </div>
</div>

</body>
@include('components.head.tinymce-config')

<script type="module">
    import {initializeApp} from "https://www.gstatic.com/firebasejs/10.8.0/firebase-app.js";
    import {getMessaging, getToken, onMessage} from "https://www.gstatic.com/firebasejs/10.8.0/firebase-messaging.js";

    const firebaseConfig = {
        apiKey: "AIzaSyAW-1uaHUA8tAaA3IQD9ypNkbVzFji88bE",
        authDomain: "chat-firebase-de134.firebaseapp.com",
        projectId: "chat-firebase-de134",
        storageBucket: "chat-firebase-de134.appspot.com",
        messagingSenderId: "867778569957",
        appId: "1:867778569957:web:7f3a6b87d83cefd8e8d60c"
    };

    const app = initializeApp(firebaseConfig);
    const messaging = getMessaging();

    const key_pair_fire_base = 'BIKdl-B84phF636aS0ucw5k-KoGPnivJW4L_a9GNf7gyrWBZt--O9KcEzvsLl3h-3_Ld0rT8YFTsuupknvguW9s';
    getToken(messaging, {vapidKey: key_pair_fire_base}).then((currentToken) => {
        if (currentToken) {
            console.log('token: ', currentToken);
            saveToken(currentToken);
        } else {
            console.log('No registration token available. Request permission to generate one.');
        }
    }).catch((err) => {
        console.log('An error occurred while retrieving token. ', err);
    });

    let accessToken = `Bearer ` + token;
    let headers = {
        'Authorization': accessToken
    };

    async function saveToken(token) {
        @if(Auth::check() && (!Auth::user()->token_firebase || Auth::user()->token_firebase == '' || Auth::user()->token_firebase == null))
            await callSaveToken(token);
        @endif
    }

    async function callSaveToken(token) {
        let saveTokenUrl = `{{ route('api.user.save.token') }}`;

        let data = {
            'token_firebase': token,
            'user_id': '{{ Auth::check() ? Auth::user()->id : '' }}'
        };
        await $.ajax({
            url: saveTokenUrl,
            method: "POST",
            headers: headers,
            data: data,
            success: function (response) {
                console.log(response)
            },
            error: function (error) {
                console.log(error);
            }
        });
    }

    onMessage(messaging, (payload) => {
        console.log('Message received. ', payload);
        const isFromFirebase = true;
        callAlert(payload, isFromFirebase);
    });

</script>
<script>
    $(document).ready(function () {
        $('.btn_close_m').click(function () {
            $('#modal-call-alert').modal('toggle')
        })
    })
</script>
<script>
    function loadingMasterPage() {
        let overlay = document.getElementsByClassName('loading-overlay-master')[0]
        overlay.classList.toggle('is-active')
    }

    var pusher = new Pusher('3ac4f810445d089829e8', {
        cluster: 'ap1', // specify your cluster here
        encrypted: true
    });
    // Subscribe to the channel we specified in our Laravel Event
    var channel = pusher.subscribe('send-message');
    // Bind a function to a Event (the full Laravel class)
    channel.bind('send-message', function (data) {
        callAlert(data);
    });

    function callAlert(data, firebase = false) {
        let thisUser = '{{Auth::user()->id ?? ''}}'

        if (firebase) {
            data.from = data.notification.body;
            data.content = data.data.link;
            if (!data.data.link) {
                return;
            }
        } else if (data.user_id_1 != thisUser && data.user_id_2 != thisUser) {
            return;
        }

        $('#modal-call-alert').modal('show')
        document.getElementById('modal-call-alert-label').innerHTML = 'Cuộc gọi từ ' + data.from

        document.getElementById('ReceiveCall').addEventListener('click', function () {
            window.open(data.content, '_blank');
            $('#modal-call-alert').modal('hide')
        });
    }

    function appendDataForm(arrField, formData) {
        let isValid = true;
        for (let i = 0; i < arrField.length; i++) {
            let field = arrField[i];
            let value = $(`#${field}`).val();

            if (value && value !== '') {
                formData.append(field, value);
            } else {
                isValid = false;
                let message = validInputByID(field);
                alert(message);
                break;
            }
        }
        return isValid;
    }

    function validInputByID(input) {
        let labelElement = $(`label[for='${input}']`);
        let text = labelElement.text();
        if (!text) {
            text = 'The input'
        }
        text = text + ' not empty!'
        return text;
    }

    function alertLogin() {
        alert('Please login to continue!');
    }
</script>
<script>
    /* Paginate for table with table is id of table and items is numbers element of table */
    function loadPaginate(table, items) {
        $('table#' + table).each(function () {
            var $table = $(this);
            var itemsPerPage = items;
            var currentPage = 0;
            var pages = Math.ceil($table.find("tr:not(:has(th))").length / itemsPerPage);
            $table.bind('repaginate', function () {
                if (pages > 1) {
                    var pager;
                    if ($table.next().hasClass("pager"))
                        pager = $table.next().empty(); else
                        pager = $('<div class="pager" style="padding-top: 20px; direction:ltr; " align="center"></div>');

                    $('<button class="pg-goto"></button>').text(' « First ').bind('click', function () {
                        currentPage = 0;
                        $table.trigger('repaginate');
                    }).appendTo(pager);

                    $('<button class="pg-goto"> « Prev </button>').bind('click', function () {
                        if (currentPage > 0)
                            currentPage--;
                        $table.trigger('repaginate');
                    }).appendTo(pager);

                    var startPager = currentPage > 2 ? currentPage - 2 : 0;
                    var endPager = startPager > 0 ? currentPage + 3 : 5;
                    if (endPager > pages) {
                        endPager = pages;
                        startPager = pages - 5;
                        if (startPager < 0)
                            startPager = 0;
                    }

                    for (var page = startPager; page < endPager; page++) {
                        $('<span id="pg' + page + '" class="' + (page == currentPage ? 'pg-selected' : 'pg-normal') + '"></span>').text(page + 1).bind('click', {
                            newPage: page
                        }, function (event) {
                            currentPage = event.data['newPage'];
                            $table.trigger('repaginate');
                        }).appendTo(pager);
                    }

                    $('<button class="pg-goto"> Next » </button>').bind('click', function () {
                        if (currentPage < pages - 1)
                            currentPage++;
                        $table.trigger('repaginate');
                    }).appendTo(pager);
                    $('<button class="pg-goto"> Last » </button>').bind('click', function () {
                        currentPage = pages - 1;
                        $table.trigger('repaginate');
                    }).appendTo(pager);

                    if (!$table.next().hasClass("pager"))
                        pager.insertAfter($table);
                }

                $table.find(
                    'tbody tr:not(:has(th))').hide().slice(currentPage * itemsPerPage, (currentPage + 1) * itemsPerPage).show();
            });

            $table.trigger('repaginate');
        });
    }
</script>
</html>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
