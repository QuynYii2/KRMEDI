@section('title')
    Kết quả khám bệnh
@endsection
<meta name="viewport" content="initial-scale=1.0, width=device-width" />
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

<style>
    .download-button {
        position: absolute;
        top: 0;
        right: 0;
        z-index: 1;
        background-color: #fff;
        color: #000;
        padding: 5px;
        border-radius: 10px;
        text-decoration: none;
        background-color: red;
        color: white
    }

    /* Styles for viewport widths up to 768px */
    @media (max-width: 768px) {
        .iframe-container {
            width: 500px !important;
            height: 570px !important;
        }
    }

    /* Styles for viewport widths between 769px and 1024px */
    @media (min-width: 769px) and (max-width: 1024px) {
        .iframe-container {
            width: 560px !important;
            height: 650px !important;
        }
    }
</style>
<div class="container-fluid mt-3">
    <div class="d-flex justify-content-center">
        @forelse ($bookingFiles as $index => $file)
            <button id="btn{{ $index }}" class="btn btn-outline-success me-3"
                onclick="showIframe({{ $index }})">
                {{ $file['type'] }}
            </button>
        @empty
        @endforelse
    </div>

    <div class="d-flex justify-content-center mt-3">
        @forelse ($bookingFiles as $index => $file)
            @php
                $fileType = '';
                $extension = pathinfo($file['url'], PATHINFO_EXTENSION);
                if ($extension === 'pdf') {
                    $fileType = 'pdf';
                } else {
                    $fileType = 'Unknown';
                }
            @endphp
            <br>
            @if ($fileType == 'pdf')
                <div class="position-relative iframe-container"
                    style="aspect-ratio: 5/7; width: 800px;{{ $index === 0 ? 'display: block;' : 'display: none;' }}">
                    <iframe id="iframe{{ $index }}" src="{{ url(asset($file['url'])) }}#toolbar=0"
                        style="border: none; width: 100%; height: 100%;" frameborder="0" scrolling="no"
                        allowfullscreen="">
                    </iframe>
                    <a class="download-button text-decoration-none mt-2 me-2" href="{{ url(asset($file['url'])) }}"
                        download>
                        <svg class="me-1" width="20" height="20" viewBox="0 0 24 24" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M17 17H17.01M17.4 14H18C18.9319 14 19.3978 14 19.7654 14.1522C20.2554 14.3552 20.6448 14.7446 20.8478 15.2346C21 15.6022 21 16.0681 21 17C21 17.9319 21 18.3978 20.8478 18.7654C20.6448 19.2554 20.2554 19.6448 19.7654 19.8478C19.3978 20 18.9319 20 18 20H6C5.06812 20 4.60218 20 4.23463 19.8478C3.74458 19.6448 3.35523 19.2554 3.15224 18.7654C3 18.3978 3 17.9319 3 17C3 16.0681 3 15.6022 3.15224 15.2346C3.35523 14.7446 3.74458 14.3552 4.23463 14.1522C4.60218 14 5.06812 14 6 14H6.6M12 15V4M12 15L9 12M12 15L15 12"
                                stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>Tải PDF</a>
                </div>
            @else
                <iframe id="iframe{{ $index }}" src="{{ url(asset($file['url'])) }}" width="80%"
                    height="800" style="border: none"></iframe>
            @endif
        @empty
        @endforelse
    </div>
</div>

<script>
    function showIframe(index) {
        var iframes = document.getElementsByTagName('iframe-container');
        for (var i = 0; i < iframes.length; i++) {
            iframes[i].style.display = 'none';
        }

        var selectedIframe = document.getElementById('iframe-container' + index);
        if (selectedIframe) {
            selectedIframe.style.display = 'block';
        }

        var buttons = document.getElementsByTagName('button');
        for (var k = 0; k < buttons.length; k++) {
            buttons[k].classList.remove('active');
        }

        var selectedButton = document.getElementById('btn' + index);
        if (selectedButton) {
            selectedButton.classList.add('active');
        }
    }

    // Show the first iframe and set the class of the first button initially
    showIframe(0);
</script>
