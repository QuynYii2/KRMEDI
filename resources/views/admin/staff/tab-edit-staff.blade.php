@php use App\Enums\Role; @endphp
@php use App\Enums\UserStatus;
 $role = $user->type;
@endphp
@extends('layouts.admin')
@section('title')
    {{ __('home.Edit') }}
@endsection
@section('main-content')
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">{{ __('home.Edit') }}</h1>
    @if (session('success'))
        <div class="alert alert-success border-left-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
    <form>
        <div>
            <label for="username">{{ __('home.Username') }}</label>
            <input type="text" class="form-control" id="username" name="username" value="{{ $user->username ?? '' }}">
        </div>
        <div>

            <label for="member">{{ __('home.Member') }}</label>
            <select id="member" name="member" class="form-select form-control">
                <option
                        value="{{ Role::DOCTORS }}" {{ $role == Role::DOCTORS ? 'selected' : '' }}>{{ __('home.Doctors') }}</option>
                <option
                        value="{{ Role::PHAMACISTS }}" {{ $role == Role::PHAMACISTS ? 'selected' : '' }}>{{ __('home.Pharmacists') }}</option>
                <option
                        value="{{ Role::THERAPISTS }}" {{ $role == Role::THERAPISTS ? 'selected' : '' }}>{{ __('home.THERAPISTS') }}</option>
                <option
                        value="{{ Role::ESTHETICIANS }}" {{ $role == Role::ESTHETICIANS ? 'selected' : '' }}>{{ __('home.ESTHETICIANS') }}</option>
                <option
                        value="{{ Role::NURSES }}" {{ $role == Role::NURSES ? 'selected' : '' }}>{{ __('home.NURSES') }}</option>
                <option
                        value="{{ Role::PAITENTS }}" {{ $role == Role::PAITENTS ? 'selected' : '' }}>{{ __('home.Patients') }}</option>
                <option
                        value="{{ Role::NORMAL_PEOPLE }}" {{ $role == Role::NORMAL_PEOPLE ? 'selected' : '' }}>{{ __('home.NORMAL PEOPLE') }}</option>
            </select>

        </div>
        <div>
            <label for="email">{{ __('home.Email') }}</label>
            <input type="email" class="form-control" id="email" name="email" value="{{ $user->email ?? '' }}">
        </div>
        <div>
            <label for="phone">{{ __('home.PhoneNumber') }}</label>
            <input type="number" class="form-control" id="phone" name="phone" value="{{ $user->phone ?? '' }}">
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
            <input type="text" class="form-control" id="hospital" name="hospital" value="{{ $user->hospital ?? '' }}">
        </div>
        <div>
            <label for="specialty">{{ __('home.Specialty') }}</label>
            <input type="text" class="form-control" id="specialty" value="{{ $user->specialty ?? '' }}"
                   name="specialty">
        </div>
        <div>
            <label for="service">{{ __('home.Service Name') }}</label>
            <input type="text" class="form-control" id="service" value="{{ $user->service ?? '' }}" name="service">
        </div>
        <div>
            <label for="year_of_experience">{{ __('home.Doctor Experience') }}</label>
            <input type="number" class="form-control" id="year_of_experience"
                   value="{{ $user->year_of_experience ?? '' }}" name="year_of_experience">
        </div>
        <div>
            <label for="identifier">Mã định danh</label>
            <input type="text" class="form-control" id="identifier" value="{{ $user->identifier ?? '' }}"
                   name="identifier">
        </div>
        @php
            $departments = \App\Models\DoctorDepartment::where('status', \App\Enums\DoctorDepartmentStatus::ACTIVE)->get();
        @endphp
        <div>
            <label for="department_id">{{ __('home.Department') }}</label>
            <select class="form-select" id="department_id" name="department_id">
                @foreach($departments as $department)
                    <option value="{{$department->id}}"
                            {{ $user->department_id == $department->id ? 'selected' : '' }}> {{$department->name}}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label for="workplace">{{ __('home.Workplace') }}</label>
            <input type="text" class="form-control" id="workplace" value="{{ $user->workplace ?? '' }}"
                   name="workplace">
        </div>
        <div>
            <label for="status">{{ __('home.Status') }}</label>
            <select id="status" name="status" class="form-select form-control">
                <option
                        value="{{ UserStatus::ACTIVE }}" {{ $user->status == UserStatus::ACTIVE ? 'selected' : '' }}>{{ UserStatus::ACTIVE }}</option>
                <option
                        value="{{ UserStatus::INACTIVE }}" {{ $user->status == UserStatus::INACTIVE ? 'selected' : '' }}>{{ UserStatus::INACTIVE }}</option>
                <option
                        value="{{ UserStatus::BLOCKED }}" {{ $user->status == UserStatus::BLOCKED ? 'selected' : '' }}>{{ UserStatus::BLOCKED }}</option>
                <option
                        value="{{ UserStatus::PENDING }}" {{ $user->status == UserStatus::PENDING ? 'selected' : '' }}>{{ UserStatus::PENDING }}</option>
            </select>
        </div>
    </form>

    <button type="button" class="btn btn-primary up-date-button mt-md-4"
            onclick="updateUser()">{{ __('home.Save') }}</button>

    <script>

        function updateUser() {
            const headers = {
                'Authorization': `Bearer ${token}`
            };
            const formDataEdit = new FormData();

            const arrFieldEmpty = ['password', 'password_confirm'];

            arrFieldEmpty.forEach(fieldName => {
                formDataEdit.append(fieldName, $(`#${fieldName}`).val());
            });

            const arrField = ['username', 'member', 'email',
                'hospital', 'specialty', 'service', 'year_of_experience',
                'identifier', 'department_id', 'workplace',
                'phone', 'status'];

            let isValid = true
            /* Tạo fn appendDataForm ở admin blade*/
            isValid = appendDataForm(arrField, formDataEdit, isValid);
            formDataEdit.append('_token', '{{ csrf_token() }}');

            if (isValid) {
                try {
                    $.ajax({
                        url: `{{route('api.backend.staffs.update', $user->id)}}`,
                        method: 'POST',
                        headers: headers,
                        contentType: false,
                        cache: false,
                        processData: false,
                        data: formDataEdit,
                        success: function (response) {
                            alert('Update success');
                            window.location.href = `{{route('homeAdmin.list.staff')}}`;
                        },
                        error: function (exception) {
                            alert(exception.responseText);
                        }
                    });
                } catch (error) {
                    alert('Update error!');
                }
            }
        }
    </script>
@endsection
