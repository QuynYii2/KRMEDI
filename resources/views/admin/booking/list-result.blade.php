@extends('layouts.admin')
@section('title')
    {{ __('home.List Result') }}
@endsection
@section('main-content')
    <div class="container-fluid">
        <h3 class="title">{{ __('home.List Result') }}</h3>
        <table class="table">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">{{ __('home.Department') }}</th>
                <th scope="col">{{ __('home.Code') }}</th>
                <th scope="col">{{ __('home.CreatedBy') }}</th>
                <th scope="col">{{ __('home.BusinessName') }}</th>
                <th scope="col">{{ __('home.Status') }}</th>
                <th scope="col">{{ __('home.Action') }}</th>
            </tr>
            </thead>
            <tbody>
            @foreach($results as $result)
                <tr>
                    <th scope="row"> {{ $loop->index + 1 }}</th>
                    @php
                        $booking = \App\Models\Booking::find($result->booking_id);
                        $business = \App\Models\Clinic::find($booking->clinic_id);

                        $department = \App\Models\Department::find($booking->department_id);
                    @endphp
                    <td>
                        {{ $department ? $department->name : '' }}
                    </td>
                    <td>
                        {{ $result->code }}
                    </td>
                    @php
                        $created_by = \App\Models\User::find($result->created_by);
                    @endphp
                    <td>
                        @if($created_by)
                            {{ $created_by->username }}
                        @endif
                    </td>
                    <td>
                        @if($business)
                            {{ $business->name }}
                        @endif
                    </td>
                    <td>
                        {{ $result->status }}
                    </td>
                    <td>
                        <div class="d-flex align-items-center">
                            <div class="list-action d-flex align-items-center">
                                <a href="{{ route('web.booking.result.list.prescriptions', $result->id) }}"
                                   class="btn btn-secondary">
                                    <i class="fa-solid fa-eye"></i>
                                </a>
                            </div>
                            <div class="list-action d-flex align-items-center">
                                <a href="{{ route('web.booking.result.detail', $result->id) }}" class="btn btn-primary">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </a>
                            </div>
                        </div>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
