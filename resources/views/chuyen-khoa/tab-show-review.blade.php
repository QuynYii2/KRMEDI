@if($reviewStore->count() == 0)

@else
    @foreach($reviewStore as $review)
        <link href="{{ asset('css/reviewitem.css') }}" rel="stylesheet">
        <div class="rv_item-1">
            <div class="d-flex justify-content-between rv-header align-items-center">
                <div class="d-flex rv-header--left">
                    @php
                        $user = \App\Models\User::where('id', $review->user_id)
                        ->where('status', \App\Enums\UserStatus::ACTIVE)
                        ->first();

                        $avtValue = $user->avt ?? 'https://i0.wp.com/sbcf.fr/wp-content/uploads/2018/03/sbcf-default-avatar.png';
                    @endphp
                    <div class="avt">
                        <img src="{{$avtValue}}" alt="">
                    </div>
                    <p class="pl-2"> {{$user->name ?? 'incognito'}}</p>
                </div>
                <div class="rv-header--right d-block">
                    <div>
                        <p>{{$review->created_at}}</p>
                    </div>
                    <div>
                        @if($review->star == 1)
                            <span class="fa fa-stack">
                                                    <i class="fa fa-star fa-xl  cl-yellow"></i></span>
                            <span class="fa fa-stack">
                                                    <i class="fa-regular fa-xl  fa-star"></i></span>
                            <span class="fa fa-stack">
                                                    <i class="fa-regular fa-xl  fa-star"></i></span>
                            <span class="fa fa-stack">
                                                    <i class="fa-regular fa-xl  fa-star"></i></span>
                            <span class="fa fa-stack">
                                                    <i class="fa-regular fa-xl  fa-star"></i></span>
                        @endif
                        @if($review->star == 2)
                            <span class="fa fa-stack">
                                                    <i class="fa fa-star fa-xl  cl-yellow"></i></span>
                            <span class="fa fa-stack">
                                                    <i class="fa fa-star fa-xl  cl-yellow"></i></span>
                            <span class="fa fa-stack">
                                                    <i class="fa-regular fa-xl  fa-star"></i></span>
                            <span class="fa fa-stack">
                                                    <i class="fa-regular fa-xl  fa-star"></i></span>
                            <span class="fa fa-stack">
                                                    <i class="fa-regular fa-xl  fa-star"></i></span>
                        @endif
                        @if($review->star == 3)
                            <span class="fa fa-stack">
                                                    <i class="fa fa-star fa-xl  cl-yellow"></i></span>
                            <span class="fa fa-stack">
                                                    <i class="fa fa-star fa-xl  cl-yellow"></i></span>
                            <span class="fa fa-stack">
                                                    <i class="fa fa-star fa-xl  cl-yellow"></i></span>
                            <span class="fa fa-stack">
                                                    <i class="fa-regular fa-xl  fa-star"></i></span>
                            <span class="fa fa-stack">
                                                    <i class="fa-regular fa-xl  fa-star"></i></span>
                        @endif
                        @if($review->star == 4)
                            <span class="fa fa-stack">
                                                    <i class="fa fa-star fa-xl  cl-yellow"></i></span>
                            <span class="fa fa-stack">
                                                    <i class="fa fa-star fa-xl  cl-yellow"></i></span>
                            <span class="fa fa-stack">
                                                    <i class="fa fa-star fa-xl  cl-yellow"></i></span>
                            <span class="fa fa-stack">
                                                    <i class="fa fa-star fa-xl  cl-yellow"></i></span>
                            <span class="fa fa-stack">
                                                    <i class="fa-regular fa-xl  fa-star"></i></span>
                        @endif
                        @if($review->star == 5)
                            <span class="fa fa-stack">
                                                    <i class="fa fa-star fa-xl  cl-yellow"></i></span>
                            <span class="fa fa-stack">
                                                    <i class="fa fa-star fa-xl cl-yellow"></i></span>
                            <span class="fa fa-stack">
                                                    <i class="fa fa-star fa-xl  cl-yellow"></i></span>
                            <span class="fa fa-stack">
                                                    <i class="fa fa-star fa-xl  cl-yellow"></i></span>
                            <span class="fa fa-stack">
                                                    <i class="fa fa-star fa-xl  cl-yellow"></i></span>
                        @endif
                    </div>

                </div>
            </div>
            <div class="">
                {!! $review->content !!}
            </div>
        </div>
    @endforeach
@endif


