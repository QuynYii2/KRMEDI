@extends('layouts.master')
@section('title', 'Booking Detail')
@section('content')
    @include('layouts.partials.header')
    @include('component.banner')
    <div class="container">
        <h1>{{ __('home.Booking Detail') }}</h1>
        <div class="row d-flex">
            <div class="col-md-4">
                <div>{{ __('home.Status') }}: {{$booking->status}}</div>
                <div>{{ __('home.Start') }}: {{$booking->check_in}}</div>
            </div>
            <div class="col-md-4">
                @php
                    $array = explode(',', $clinic->address);
                    $addressP = \App\Models\Province::where('id', $array[1] ?? null)->first();
                    $addressD = \App\Models\District::where('id', $array[2] ?? null)->first();
                    $addressC = \App\Models\Commune::where('id', $array[3] ?? null)->first();
                @endphp
                <div>{{ __('home.clinics') }}: {{$clinic->name}}</div>
                <div>{{ __('home.Addresses') }}: {{$clinic->address_detail}} - {{$addressC->name}} - {{$addressD->name}}
                    - {{$addressP->name}}</div>
                <div>

                    @foreach($service as $item)
                        <div>- {{$item->name}}</div>

                    @endforeach</div>

            </div>
            <div class="col-md-4">
                @if($memberFamily == null && $user != null)
                    <div>{{ __('home.Name') }}: {{$user->name}}</div>
                    <div>{{ __('home.PhoneNumber') }}: {{$user->phone}}</div>
                    <div>{{ __('home.Email') }}: {{$user->email}}</div>
                @else
                    @if($memberFamily != null)
                        <div>{{ __('home.Name') }}: {{$memberFamily->first()->name}}</div>
                        <div>{{ __('home.relationship') }}
                            : {{ \App\Enums\RelationshipFamily::getLabels()[$memberFamily->first()->relationship] ?? $memberFamily->first()->relationship }}</div>
                        <div>{{ __('home.Sexs') }}: {{$memberFamily->first()->sex}}</div>
                        <div>{{ __('home.Date of birth') }}: {{$memberFamily->first()->date_of_birth}}</div>
                    @endif
                @endif
            </div>

        </div>

        <div class="row">
            <h3>{{ __('home.cau hoi khao sat') }}</h3>
        </div>
        <div class="row">

            @foreach($arraySurvey as $survey)
                <div class="col-sm-6">
                    {{ $survey['question'] }}
                </div>
                @if($survey['type'] === \App\Enums\SurveyType::TEXT)
                    <div class="col-sm-6">
                        {{ $survey['answers'] }}
                    </div>
                @else
                    <div class="col-sm-6">
                        @foreach($survey['answers'] as $answer)
                            {{ $answer['answer'] . ' - ' }}
                        @endforeach
                    </div>
                @endif
            @endforeach
        </div>

        <div class="justify-content-center align-items-center d-flex mt-4">
            <a href="{{ route("clinic.detail", $booking->clinic_id) }}" class="btn button-apply-booking col-md-4 mr-2">{{ __('home.Clinic Detail') }}</a>
            @if($booking->status == 'COMPLETE')
                <a href="{{ route("clinic.detail.results", $booking->id) }}" class="btn button-cancel col-md-4">{{ __('home.Results Detail') }}</a>
            @endif
        </div>
    </div>
@endsection
