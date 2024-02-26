@extends('layouts.admin')
@section('title')
    {{ __('home.Edit') }}
@endsection
@section('main-content')
    <div class="container-fluid">
        <h1 class="h3 mb-4 text-gray-800">{{ __('home.Detail Result') }}</h1>
        @php
            $arrayServiceName = explode(',', $result->service_name);
            $list_service_name = \App\Models\ServiceClinic::whereIn('id', $arrayServiceName)
                ->where('status', \App\Enums\ServiceClinicStatus::ACTIVE)
                ->get();
            $names = null;
            foreach ($list_service_name as $item){
                if ($names){
                    $names = $names .','. $item->name;
                } else {
                    $names = $item->name;
                }
            }
        @endphp
        <div class="list-service-result mt-2 mb-3">
            <div id="list-service-result">
                @foreach($array_result as $item)
                    <div class="service-result-item d-flex align-items-center justify-content-between border p-3">
                        <div class="service-result w-75">
                            <div class="form-group">
                                @php
                                    $arrayService = explode(',', $item['service_result']);
                                    $service_names = \App\Models\ServiceClinic::whereIn('id', $arrayService)
                                                        ->where('status', \App\Enums\ServiceClinicStatus::ACTIVE)
                                                        ->pluck('name')
                                                        ->toArray();
                                    $list_name = implode(',', $service_names);
                                @endphp
                                <label for="service_name">{{ __('home.Service Name') }}</label>
                                <input type="text" class="form-control" id="service_name" disabled
                                       placeholder="Apartment, studio, or floor" value="{{ $list_name }}">
                                <ul class="list-service" style="list-style: none; padding-left: 0">
                                    @foreach($services as $service)
                                        <li class="new-select">
                                            <input class="service_name_item" data-name="{{$service->name}}"
                                                   value="{{$service->id}}"
                                                   {{ in_array($service->id, $arrayService) ? 'checked' : '' }}
                                                   name="service_name_item"
                                                   type="checkbox">
                                            <label>{{$service->name}}</label>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                            <div class="form-group">
                                <label for="result">{{ __('home.Result') }}</label>
                                <input type="text" class="form-control result" value="{{ $item['result'] }}"
                                       id="result" disabled placeholder="{{ __('home.Result') }}">
                            </div>
                            <div class="form-group">
                                <label for="result_en">{{ __('home.Result En') }}</label>
                                <input type="text" class="form-control result_en" value="{{ $item['result_en'] }}"
                                       id="result_en" disabled placeholder="{{ __('home.Result En') }}">
                            </div>
                            <div class="form-group">
                                <label for="result_laos">{{ __('home.Result Laos') }}</label>
                                <input type="text" class="form-control result_laos" disabled
                                       value="{{ $item['result_laos'] }}" id="result_laos"
                                       placeholder="{{ __('home.Result Laos') }}">
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="row">
            <div class="form-group col-md-3">
                <label for="status">{{ __('home.Status') }}</label>
                <select class="form-select" name="status" id="status" disabled>
                    <option
                            {{ $result->status == \App\Enums\BookingResultStatus::ACTIVE ? 'selected' : '' }}
                            value="{{ \App\Enums\BookingResultStatus::ACTIVE }}">
                        {{ \App\Enums\BookingResultStatus::ACTIVE }}
                    </option>
                    <option
                            {{ $result->status == \App\Enums\BookingResultStatus::INACTIVE ? 'selected' : '' }}
                            value="{{ \App\Enums\BookingResultStatus::INACTIVE }}">
                        {{ \App\Enums\BookingResultStatus::INACTIVE }}
                    </option>
                </select>
            </div>
            <div class="form-group col-md-2">
                <a href="{{ route('user.download.file', $result->id) }}" type="button"
                   class="btnDownloadFile btn btn-outline-warning mt-4">
                    {{ __('home.Xem đơn đã upload') }}
                </a>
            </div>
        </div>
        @php
            $array_file = null;
            $files = $result->files;
            if ($files){
                $array_file = explode(',',$files);
            }
        @endphp
        <div class="form-group d-flex">
            @if($array_file)
                @foreach($array_file as $file)
                    <img src="{{ asset($file) }}" alt="" style="max-width: 100px; object-fit: cover"
                         class="m-3">
                @endforeach
            @endif
        </div>

        <div class="form-group">
            <label for="detail">{{ __('home.Detail') }}</label>
            <input disabled class="form-control" id="detail" value="{{ $result->detail }}">
        </div>
        <div class="form-group">
            <label for="detail_en">{{ __('home.Detail En') }}</label>
            <input disabled class="form-control" id="detail_en" value="{{ $result->detail_en }}">
        </div>
        <div class="form-group">
            <label for="detail_laos">{{ __('home.Detail Lao') }}</label>
            <input disabled class="form-control" id="detail_laos" value="{{ $result->detail_laos }}">
        </div>


        <div class="d-flex justify-content-start align-items-center">
            <a href="{{ route('web.users.my.bookings.products', $result->booking_id) }}" type="button"
               class="btnViewProduct btn btn-outline-success mt-4">
                View product
            </a>
        </div>
    </div>
@endsection
