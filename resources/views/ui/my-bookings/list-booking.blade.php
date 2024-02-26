@extends('layouts.admin')
@section('title')
    {{ __('home.List Booking') }}
@endsection
@section('main-content')
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">{{ __('home.List Booking') }}</h1>
    <link href="{{ asset('css/listbooking.css') }}" rel="stylesheet">
    <div class="">
        <table class="table table-striped" id="tableBooking">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">{{ __('home.clinics') }}</th>
                <th scope="col">{{ __('home.giờ vào') }}</th>
                <th scope="col">{{ __('home.dịch vụ') }}</th>
                <th scope="col">{{ __('home.Trạng thái') }}</th>
                <th scope="col">{{ __('home.Thao tác') }}</th>
            </tr>
            </thead>
            <tbody>
            @foreach($bookings as $item)
                <tr>
                    <th scope="row">{{ $loop->index + 1 }}</th>
                    <td>@php
                            $clinic = \App\Models\Clinic::where('id',$item->clinic_id)->pluck('name')->first();
                        @endphp
                        {{$clinic}}
                    </td>
                    <td>{{$item->check_in}} </td>
                    @php
                        $service_name = explode(',', $item->service);
                        $services = \App\Models\ServiceClinic::whereIn('id', $service_name)->get();
                        $service_names = $services->pluck('name')->implode(', ');
                    @endphp
                    <td>{{$service_names}}</td>
                    <td>{{$item->status}}</td>
                    <td class="d-flex">
                        <form action="{{ route('web.users.my.bookings.detail', $item->id) }}" method="get">
                            <button type="submit" class="btn btn-primary">
                                <i class="fa-solid fa-eye"></i>
                            </button>
                        </form>
                        <form action="{{ route('web.users.my.bookings.generate', $item->id) }}" method="get">
                            <button type="submit" class="btn btn-success">
                                <i class="fa-solid fa-qrcode"></i>
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <div class="d-flex justify-content-center align-items-center">
            {{ $bookings->links() }}
        </div>
    </div>
@endsection
