@extends('layouts.admin')
@section('title')
    {{ __('home.List Booking') }}
@endsection
@section('main-content')
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">{{ __('home.List Booking') }}</h1>
    <div class="d-flex align-items-center justify-content-start">
        <div class="mb-3 col-md-3">
            <input class="form-control" id="inputSearchBooking" type="text" placeholder="Search.."/>
        </div>
    </div>
    <br>
    <link href="{{ asset('css/listbooking.css') }}" rel="stylesheet">
    <div class="">
        <table class="table table-striped" id="tableBooking">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">{{ __('home.Người đăng ký') }}</th>
                <th scope="col">{{ __('home.clinics') }}</th>
                <th scope="col">{{ __('home.giờ vào') }}</th>
                <th scope="col">{{ __('home.Department') }}</th>
                <th scope="col">{{ __('home.Doctor Name') }}</th>
                <th scope="col">{{ __('home.Trạng thái') }}</th>
                <th scope="col">{{ __('home.Thao tác') }}</th>
            </tr>
            </thead>
            <tbody>
            @foreach($bookings as $item)
                <tr>
                    <th scope="row">{{ $loop->index + 1 }}</th>
                    <td>
                        @php
                            $user_name = \App\Models\User::find($item->user_id);
                        @endphp
                        {{$user_name->name}}
                    </td>
                    <td>
                        @php
                            $clinic = \App\Models\Clinic::where('id',$item->clinic_id)->pluck('name')->first();
                        @endphp
                        {{$clinic}}
                    </td>
                    <td>{{$item->check_in}} </td>
                    @php
                        $doctor = \App\Models\User::find($item->doctor_id);
                        $department = \App\Models\Department::find($item->department_id);
                    @endphp
                    <td>{{$department ? $department->name : ''}}</td>
                    <td>{{$doctor ? $doctor->username : ''}} - {{$doctor ? $doctor->email : ''}}</td>
                    <td>{{$item->status}}</td>
                    <td class="d-flex">
                        {{--                        <form action="{{ route('web.booking.result.list', $item->id) }}" method="get">--}}
                        {{--                            <button type="submit" class="btn btn-secondary">--}}
                        {{--                                <i class="fa-solid fa-eye"></i>--}}
                        {{--                            </button>--}}
                        {{--                        </form>--}}
                        <form action="{{route('api.backend.booking.edit',$item->id)}}" method="get">
                            <button type="submit" class="btn btn-primary">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </button>
                        </form>

                        <form action="{{route('api.backend.booking.delete',$item->id)}}" method="post">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="ml-3 btn btn-primary btn-danger">
                                <i class="fa-regular fa-trash-can"></i>
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        @if(session('error'))
        Swal.fire({
            icon: 'error',
            title: 'Permission Denied',
            text: '{{ session('error') }}',
        });
        @endif
        $(document).ready(function () {
            searchMain('inputSearchBooking', 'tableBooking');
        })
    </script>
@endsection
