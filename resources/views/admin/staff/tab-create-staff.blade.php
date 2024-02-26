@php use App\Enums\Role; @endphp
@extends('layouts.admin')
@section('title')
    {{ __('home.create') }}
@endsection
@section('main-content')

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">{{ __('home.create') }}</h1>
    @if (session('success'))
        <div class="alert alert-success border-left-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
    <div>
        <form>
            <div>
                <label for="username">{{ __('home.Username') }}</label>
                <input type="text" class="form-control" id="username" name="username">
            </div>
            <div>
                <label for="member">{{ __('home.Member') }}</label>
                <select id="member" name="member" class="form-select form-control">
                    <option value="{{ Role::DOCTORS }}">{{ Role::DOCTORS }}</option>
                    <option value="{{ Role::PHAMACISTS }}">{{ Role::PHAMACISTS }}</option>
                    <option value="{{ Role::THERAPISTS }}">{{ Role::THERAPISTS }}</option>
                    <option value="{{ Role::ESTHETICIANS }}">{{ Role::ESTHETICIANS }}</option>
                    <option value="{{ Role::NURSES }}">{{ Role::NURSES }}</option>
                </select>
            </div>
            <div>
                <label for="email">{{ __('home.Email') }}</label>
                <input type="email" class="form-control" id="email" name="email">
            </div>
            <div>
                <label for="phone">{{ __('home.PhoneNumber') }}</label>
                <input type="number" class="form-control" id="phone" name="phone">
            </div>
            <div>
                <label for="password">{{ __('home.Password') }}</label>
                <input type="password" class="form-control" id="password" name="password">
            </div>
            <div>
                <label for="password_confirm">{{ __('home.Enter the Password') }}</label>
                <input type="password" class="form-control" id="password_confirm" name="password_confirm">
            </div>
            <div>
                <label for="hospital">{{ __('home.Hospital') }}</label>
                <input type="text" class="form-control" id="hospital" name="hospital">
            </div>
            <div>
                <label for="specialty">{{ __('home.Specialty') }}</label>
                <input type="text" class="form-control" id="specialty" name="specialty">
            </div>
            <div>
                <label for="service">{{ __('home.Service Name') }}</label>
                <input type="text" class="form-control" id="service" name="service">
            </div>
            <div>
                <label for="year_of_experience">{{ __('home.Doctor Experience') }}</label>
                <input type="number" class="form-control" id="year_of_experience" name="year_of_experience">
            </div>
            <div>
                <label for="identifier">Mã định danh</label>
                <input type="text" class="form-control" id="identifier" name="identifier">
            </div>
            @php
                $departments = \App\Models\DoctorDepartment::where('status', \App\Enums\DoctorDepartmentStatus::ACTIVE)->get();
            @endphp
            <div>
                <label for="department_id">{{ __('home.Department') }}</label>
                <select class="form-select" id="department_id" name="department_id">
                    @foreach($departments as $department)
                        <option value="{{$department->id}}"> {{$department->name}}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="workplace">{{ __('home.Workplace') }}</label>
                <input type="text" class="form-control" id="workplace" name="workplace">
            </div>
        </form>
        <div hidden>
            <label for="manager_id"></label><input type="text" class="form-control" id="manager_id" name="manager_id"
                                                   value="{{Auth::user()->id}}">
        </div>
    </div>
    <button type="button" class="btn btn-primary up-date-button mt-md-4">{{ __('home.Save') }}</button>
    <script>
        $(document).ready(function () {
            $('.up-date-button').on('click', function () {
                createStaff();
            })
        })

        async function createStaff() {
            const headers = {
                'Authorization': `Bearer ${token}`
            };
            const formData = new FormData();

            const arrField = ['username', 'member', 'email', 'phone',
                'hospital', 'specialty', 'service', 'year_of_experience',
                'identifier', 'department_id', 'workplace',
                'password', 'password_confirm', 'manager_id'];

            let isValid = true
            /* Tạo fn appendDataForm ở admin blade*/
            isValid = appendDataForm(arrField, formData, isValid);


            formData.append('_token', '{{ csrf_token() }}');

            if (isValid) {
                try {
                    await $.ajax({
                        url: `{{route('api.backend.staffs.store')}}`,
                        method: 'POST',
                        headers: headers,
                        contentType: false,
                        cache: false,
                        processData: false,
                        data: formData,
                        success: function () {
                            alert('Create success!');
                            window.location.href = `{{route('homeAdmin.list.staff')}}`;
                        },
                        error: function (exception) {
                            alert(exception.responseText);
                        }
                    });
                } catch (error) {
                    alert('Create error!');
                }
            }
        }
    </script>
@endsection
