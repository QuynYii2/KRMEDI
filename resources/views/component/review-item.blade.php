{{--@if($reviewStore->count() == 0)--}}
{{--    <p>You have no product to evaluate--}}
{{--    </p>--}}
{{--@else--}}
<style>
    .fa-stack {
        width: 1em;
    }
</style>
    @foreach($reviewStore as $review)
        <link href="{{ asset('css/reviewitem.css') }}" rel="stylesheet">
        <div class="rv_item-1">
            <div class="d-flex justify-content-between rv-header align-items-center">
                <div class="d-flex rv-header--left">
                    @php
                        $user = \App\Models\User::where('id', $review->user_id)
                        ->where('status', \App\Enums\UserStatus::ACTIVE)
                        ->first();
                    @endphp
                    <div class="avt">
                        <img src="{{$user->avt}}" alt="">
                    </div>
                    <p class="pl-2"> {{$user->name}}</p>
                </div>
                <div class="rv-header--right d-block">
                    <div>
                        <p>{{$review->created_at}}</p>
                    </div>
                    <div class="d-flex justify-content-end align-items-center">
                        @if($review->star_number == 1)
                            <span class="fa fa-stack">
                                                    <i class="fa fa-star cl-yellow"></i></span>
                            <span class="fa fa-stack">
                                                    <i class="fa-regular fa-star"></i></span>
                            <span class="fa fa-stack">
                                                    <i class="fa-regular fa-star"></i></span>
                            <span class="fa fa-stack">
                                                    <i class="fa-regular fa-star"></i></span>
                            <span class="fa fa-stack">
                                                    <i class="fa-regular fa-star"></i></span>
                        @endif
                        @if($review->star_number == 2)
                            <span class="fa fa-stack">
                                                    <i class="fa fa-star cl-yellow"></i></span>
                            <span class="fa fa-stack">
                                                    <i class="fa fa-star cl-yellow"></i></span>
                            <span class="fa fa-stack">
                                                    <i class="fa-regular fa-star"></i></span>
                            <span class="fa fa-stack">
                                                    <i class="fa-regular fa-star"></i></span>
                            <span class="fa fa-stack">
                                                    <i class="fa-regular fa-star"></i></span>
                        @endif
                        @if($review->star_number == 3)
                            <span class="fa fa-stack">
                                                    <i class="fa fa-star cl-yellow"></i></span>
                            <span class="fa fa-stack">
                                                    <i class="fa fa-star cl-yellow"></i></span>
                            <span class="fa fa-stack">
                                                    <i class="fa fa-star cl-yellow"></i></span>
                            <span class="fa fa-stack">
                                                    <i class="fa-regular fa-star"></i></span>
                            <span class="fa fa-stack">
                                                    <i class="fa-regular fa-star"></i></span>
                        @endif
                        @if($review->star_number == 4)
                            <span class="fa fa-stack">
                                                    <i class="fa fa-star cl-yellow"></i></span>
                            <span class="fa fa-stack">
                                                    <i class="fa fa-star cl-yellow"></i></span>
                            <span class="fa fa-stack">
                                                    <i class="fa fa-star cl-yellow"></i></span>
                            <span class="fa fa-stack">
                                                    <i class="fa fa-star cl-yellow"></i></span>
                            <span class="fa fa-stack">
                                                    <i class="fa-regular fa-star"></i></span>
                        @endif
                        @if($review->star_number == 5)
                            <span class="fa fa-stack">
                                                    <i class="fa fa-star cl-yellow"></i></span>
                            <span class="fa fa-stack">
                                                    <i class="fa fa-star cl-yellow"></i></span>
                            <span class="fa fa-stack">
                                                    <i class="fa fa-star cl-yellow"></i></span>
                            <span class="fa fa-stack">
                                                    <i class="fa fa-star cl-yellow"></i></span>
                            <span class="fa fa-stack">
                                                    <i class="fa fa-star cl-yellow"></i></span>
                        @endif
                    </div>

                </div>
            </div>
            <div class="">

                @if(locationHelper() == 'vi')
                    {!! $review->content !!}
                @else
                    {!! $review->content_en !!}
                @endif
            </div>
        </div>
    @endforeach
{{--@endif--}}


