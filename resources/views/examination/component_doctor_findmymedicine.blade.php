@php use App\Models\Department;use App\Models\MedicalFavourite;use App\Models\Province;use Illuminate\Support\Facades\Auth; @endphp
@php @endphp
@php
    $isFavourite = \App\Models\MedicalFavourite::where([
                ['user_id', '=', \Illuminate\Support\Facades\Auth::user()->id ?? ''],
                ['medical_id', '=', $pharmacist->id],
                ['is_favorite', '=', '1']
            ])->first();

            $heart = 'bi-heart';
            if ($isFavourite){
                $heart = 'bi-heart-fill';
            }
    $is_online = false;
    if (Cache::has('user-is-online|' . $pharmacist->id)){
        $is_online = true;
    }
@endphp

<link href="{{ asset('css/component-doctor.css') }}" rel="stylesheet">
<div class="col-6 col-sm-6 col-md-3 mb-3">
    <div class="frame component-doctor">
        <img loading="lazy" class="rectangle border-img"
             src="{{asset($pharmacist->avt)}}"/>
        <div class="div mt-3">
            <a target="_blank" class="title-best__doctor"
               href="{{ route('examination.doctor_info', ['id' => $pharmacist->id]) }}">
                <div class="text-wrapper">
                    {{ $pharmacist->name ?? __('home.no name') }}
                </div>
            </a>
            <span class="small {{ $is_online ? 'text-white' : '' }}">{{ $is_online ? __('home.Online') : __('home.Offline') }}</span>
            <div class="div-2 serviceDoctor">
                @if(locationHelper() == 'vi')
                    {!! ($pharmacist->service ?? __('home.no name') ) !!}
                @else
                    {!! ($pharmacist->service_en  ?? __('home.no name') ) !!}
                @endif
            </div>
            <div class="div-2">
                @php
                if (locationHelper() == 'vi'){
                    $province = Province::find($pharmacist->province_id)->name ?? 'Ha Noi';
                }else{
                    $province = Province::find($pharmacist->province_id)->name_en ?? 'Ha Noi';
                }
                @endphp
                <img loading="lazy" class="img" src="{{ asset('img/location.png') }}"/>
                <div class="text-wrapper-2">{{ $province ?? __('home.Toàn quốc') }}</div>
            </div>
            <div class="div-2">
                <img loading="lazy" class="img" src="{{ asset('img/clock.png') }}"/>
                <div class="text-wrapper-2">
                    {{ $pharmacist->time_working_1 ?? '' }} {{ $pharmacist->time_working_2 ?? '' }}
                </div>
            </div>
        </div>
        @php
            $department = Department::find($pharmacist->department_id);
            $isFavourite = MedicalFavourite::where([
                ['user_id', '=', Auth::user()->id ?? ''],
                ['medical_id', '=', $pharmacist->id],
                ['type', '=', $pharmacist->type],
            ])->first();

            $heart = 'bi-heart d-flex';
            if ($isFavourite){
                $heart = 'bi-heart-fill d-flex';
            }

        @endphp
        @if(Auth::check())
            <div class="frame-wrapper-heart"
                 onclick="handleAddToWishList('{{ $pharmacist->id }}', '{{ $pharmacist->type }}')">
                <i class="{{ $heart }} bi"></i></div>
        @endif
        <div class="component department-div">
            <img loading="lazy" class="fills" src="{{ $department->thumbnail ?? ''}}"/>
        </div>
    </div>
</div>
