@extends('layouts.master')
@section('title')
    QrCode
@endsection
@section('content')
    @include('layouts.partials.header')
    @include('component.banner')
    <div class="container">
        <div class="d-flex align-items-center justify-content-center w- mb-5 mt-2">
            {{--            <a href="{{ route('web.users.my.bookings.download', $id) }}" class="btn btn-outline-success">--}}
            {{--                <i class="fa-solid fa-download"></i>--}}
            {{--                Download now--}}
            {{--            </a>--}}
{{--            <button class="btn btn-outline-success" id="btnDownload2" onclick="download();">--}}
{{--                <i class="fa-solid fa-download"></i>--}}
{{--                Download now--}}
{{--            </button>--}}
        </div>
        <div class="d-flex align-items-center justify-content-center" id="htmlContent">
            {!! $qrCodes !!}
        </div>
        <div id="imageContent">

        </div>
    </div>
    <script>
        $('#btnDownload').click(function () {
            console.log($('#htmlContent').html())
        });


        function download() {
            let svg = document.getElementById('htmlContent').querySelector('svg');
            console.log(svg);
            img = new Image(),
                serializer = new XMLSerializer(),
                svgStr = serializer.serializeToString(svg);

            img.src = 'data:image/svg+xml;base64,' + window.btoa(svgStr);

            var canvas = document.createElement("canvas");

            var w = 800;
            var h = 400;

            canvas.width = w;
            canvas.height = h;
            canvas.getContext("2d").drawImage(img, 0, 0, w, h);

            var imgURL = canvas.toDataURL("image/png");

            var dlLink = document.createElement('a');
            dlLink.download = "image";
            dlLink.href = imgURL;
            dlLink.dataset.downloadurl = ["image/png", dlLink.download, dlLink.href].join(':');

            document.getElementById('imageContent').appendChild(dlLink);
            dlLink.click();
            document.getElementById('imageContent').removeChild(dlLink);
        }
    </script>

@endsection
