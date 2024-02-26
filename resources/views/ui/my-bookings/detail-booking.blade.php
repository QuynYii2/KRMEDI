@extends('layouts.admin')
@section('title')
    {{ __('home.Detail') }}
@endsection
@section('main-content')
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">{{ __('home.Booking Detail') }}</h1>
    <div class="container-fluid">
        <div class="row">
            @php
                $clinic = \App\Models\Clinic::find($booking->clinic_id);
            @endphp
            <div class="form-group col-md-6">
                <label for="clinic_id">Clinic Name</label>
                <input disabled type="text" class="form-control" id="clinic_id"
                       value="{{ $clinic ? $clinic->name : '' }}">
            </div>
            <div class="form-group col-md-3">
                <label for="check_in">Check In</label>
                <input disabled type="text" class="form-control" id="check_in"
                       value="{{ \Carbon\Carbon::parse($booking->check_in)->format('s:i:H d-m-Y') }}">
            </div>
            <div class="form-group col-md-3">
                <label for="check_out">Check Out</label>
                <input disabled type="text" class="form-control" id="check_out"
                       value="{{ \Carbon\Carbon::parse($booking->check_out)->format('s:i:H d-m-Y') }}">
            </div>
        </div>
        @php
            $department = \App\Models\Department::find($booking->department_id);
            $doctor = \App\Models\User::find($booking->doctor_id);
        @endphp
        <div class="row">
            <div class="form-group col-md-6">
                <label for="department_id">Department</label>
                <input disabled type="text" class="form-control" id="department_id" value="{{ $department->name }}">
            </div>
            <div class="form-group col-md-6">
                <label for="doctor_id">Doctor Name</label>
                <input disabled type="text" class="form-control" id="doctor_id" value="{{ $doctor->username }}">
            </div>
        </div>
        <div class="form-group">
            <label for="medical_history">Medical History</label>
            <input disabled type="text" class="form-control" id="medical_history"
                   value="{{ $booking->medical_history }}">
        </div>
        <div class="row">
            <div class="form-group col-md-4">
                <label for="status">Status</label>
                <input disabled type="text" class="form-control" id="status" value="{{ $booking->status }}">
            </div>
            @if($booking->member_family_id)
                @php
                    $family = \App\Models\FamilyManagement::find($booking->member_family_id);
                @endphp

                <div class="form-group col-md-4">
                    <label for="member_family_id">Member family</label>
                    <input disabled type="text" class="form-control" id="member_family_id" value="{{ $family->name }}">
                </div>
            @endif
        </div>
        <div class="form-group">
            <input disabled class="form-check-input" {{ $booking->is_result == 1 ? 'checked' : '' }} type="checkbox"
                   id="is_result">
            <label class="form-check-label" for="is_result">
                Result
            </label>
        </div>
        @if($booking->status == \App\Enums\BookingStatus::CANCEL)
            <div class="form-group">
                <label for="reason_cancel">Reason Cancel</label>
                <input disabled type="text" class="form-control" id="reason_cancel"
                       value="{{ $booking->reason_cancel }}">
            </div>
        @endif
        @if($booking->is_result == 1 && $booking->status == \App\Enums\BookingStatus::COMPLETE)
            <div class="d-flex align-items-center justify-content-start w-50">
                <a href="{{ route('web.users.my.bookings.result', $booking->id) }}" class="btn btn-primary">
                    View result
                </a>
            </div>
        @endif
    </div>
@endsection
