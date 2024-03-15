@section('title')
    Kết quả khám bệnh
@endsection

<div style="display: flex; justify-content: center; align-items: center; height: 100vh;">
    <iframe src="https://view.officeapps.live.com/op/embed.aspx?src={{ url(asset($booking->extend['booking_results'][0]['url'])) }}/edit?usp=sharing&embedded=true" width="100%" height="100%" style="border: none;"></iframe>
</div>