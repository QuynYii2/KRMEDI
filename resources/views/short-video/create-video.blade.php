@extends('layouts.master')
@section('title', 'Create Videos')
@section('content')
    @include('layouts.partials.header')
    @include('component.banner')
    <div class="container">
        <h3 class="text-center">{{ __('home.Create Short Video Public') }} </h3>
        <form>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="inputEmail4">{{ __('home.Email') }} </label>
                    <input type="email" class="form-control" id="inputEmail4">
                </div>
                <div class="form-group col-md-6">
                    <label for="inputPassword4">{{ __('home.Password') }} </label>
                    <input type="password" class="form-control" id="inputPassword4">
                </div>
            </div>
            <div class="form-group">
                <label for="inputAddress">{{ __('home.Addresses') }} </label>
                <input type="text" class="form-control" id="inputAddress" placeholder="1234 Main St">
            </div>
            <div class="form-group">
                <label for="inputAddress2">{{ __('home.Addresses') }} 2</label>
                <input type="text" class="form-control" id="inputAddress2" placeholder="{{ __('home.Apartment, studio, or floor') }}">
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="inputCity">{{ __('home.City') }}</label>
                    <input type="text" class="form-control" id="inputCity">
                </div>
                <div class="form-group col-md-4">
                    <label for="inputState">{{ __('home.State') }}</label>
                    <select id="inputState" class="form-control">
                        <option selected>{{ __('home.Choose...') }}</option>
                        <option>...</option>
                    </select>
                </div>
                <div class="form-group col-md-2">
                    <label for="inputZip">{{ __('home.Zip') }}</label>
                    <input type="text" class="form-control" id="inputZip">
                </div>
            </div>
            <div class="form-group">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="gridCheck">
                    <label class="form-check-label" for="gridCheck">
                        {{ __('home.Check me out') }}
                    </label>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">{{ __('home.Sign in') }}</button>
        </form>
    </div>
@endsection
