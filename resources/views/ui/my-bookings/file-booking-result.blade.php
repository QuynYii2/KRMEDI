@section('title')
    Kết quả khám bệnh
@endsection
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

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
                if ($extension === 'xlsx') {
                    $fileType = 'xlsx';
                } elseif ($extension === 'pdf') {
                    $fileType = 'pdf';
                } elseif ($extension === 'docx') {
                    $fileType = 'docx';
                } else {
                    $fileType = 'Unknown';
                }
            @endphp
            <br>
            @if ($fileType == 'xlsx')
                <iframe id="iframe{{ $index }}"
                    src="https://view.officeapps.live.com/op/embed.aspx?src={{ url(asset($file['url'])) }}"
                    width="80%" height="500"
                    style="border: none; {{ $index === 0 ? 'display: block;' : 'display: none;' }}"></iframe>
            @elseif ($fileType == 'pdf')
                {{-- <embed id="iframe{{ $index }}" src="{{ url(asset($file['url'])) }}" type="application/pdf"
                    width="80%" height="800"
                    style="border: none; {{ $index === 0 ? 'display: block;' : 'display: none;' }}"> --}}
                <div class="row justify-content-center">
                    <iframe id="iframe{{ $index }}" src="{{ url(asset($file['url'])) }}#toolbar=0" width="100%"
                        height="400"
                        style="width: 95%; transform: scale(2); border: none; {{ $index === 0 ? 'display: block;' : 'display: none;' }}">
                    </iframe>
                </div>
            @elseif ($fileType == 'docx')
                <iframe id="iframe{{ $index }}"
                    src="https://view.officeapps.live.com/op/view.aspx?src={{ url(asset($file['url'])) }}"
                    width="80%" height="800"
                    style="border: none; {{ $index === 0 ? 'display: block;' : 'display: none;' }}"></iframe>
            @else
                <iframe id="iframe{{ $index }}" src="{{ url(asset($file['url'])) }}" width="80%"
                    height="800"
                    style="border: none; {{ $index === 0 ? 'display: block;' : 'display: none;' }}"></iframe>
            @endif
        @empty
        @endforelse
    </div>
</div>

<script>
    function showIframe(index) {
        var iframes = document.getElementsByTagName('iframe');
        for (var i = 0; i < iframes.length; i++) {
            iframes[i].style.display = 'none';
        }

        var embeds = document.getElementsByTagName('embed');
        for (var j = 0; j < embeds.length; j++) {
            embeds[j].style.display = 'none';
        }

        var selectedIframe = document.getElementById('iframe' + index);
        var selectedEmbed = document.getElementById('embed' + index);
        if (selectedIframe) {
            selectedIframe.style.display = 'block';
        }
        if (selectedEmbed) {
            selectedEmbed.style.display = 'block';
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
