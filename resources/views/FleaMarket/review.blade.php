@extends('layouts.master')
@section('title', 'Flea Market')
@section('content')
    @include('layouts.partials.headerFleaMarket')
    <body>
    @include('component.banner')
    <div class="container mt-70">
        <div class="d-flex mt-88">
            <div class="col-md-3 mr-2">
                <div class="">
                    <div class="flea-adv row align-items-center justify-content-center">
                        <img src="{{asset('img/image 16.png')}}" alt="" style="width: 270px;height: 682px">
                    </div>
                </div>
                <div class="">
                    <div class="flea-adv row align-items-center justify-content-center">
                        <img src="{{asset('img/image 16.png')}}" alt="" style="width: 270px;height: 682px">
                    </div>
                </div>
            </div>
            <div class="col-md-9 medicine-list--item">
                @include('component.avt-info')
                <div class="border-bottom-review">
                    <div class="d-flex justify-content-between">
                        <div class="avt-review">
                            <img src="{{asset('img/flea-market/ny-phi.png')}}">
                            <strong>Trần Đình Phi</strong>
                        </div>
                        <div class="d-flex align-items-end"><p>10:20 07/04/2023</p></div>
                    </div>
                    <div class="text-description">
                        <strong>"{{ __('home.Dịch vụ cực tốt') }}"</strong>
                        <p>{{ __('home.Lần đầu tiên sử dụng dịch vụ qua app nhưng chất lượng và dịch vụ tại salon quá tốt. Book giờ nào thì cứ đúng giờ đến k sợ phải chờ đợi như mọi chỗ khác. Hy vọng thi thoảng app có nhiều ưu đãi để giới thiệu cho bạn bè cùng sử dụng') }}</p>
                    </div>
                    <a href="#">
                        <div class="row icon-reply d-flex justify-content-end">
                            <i class="fa-solid fa-reply"></i>
                            <p>{{ __('home.Reply') }}</p>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
    </body>
@endsection
