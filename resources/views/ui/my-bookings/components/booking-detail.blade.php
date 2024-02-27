<div class="p-3 m-2 border">
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
        $service = $booking->service;
        $array_service = explode(',', $service);
        $services = \App\Models\ServiceClinic::whereIn('id', $array_service)
                        ->where('status', \App\Enums\ServiceClinicStatus::ACTIVE)
                        ->pluck('name')
                        ->toArray();
        $list_name = implode(',', $services);
    @endphp
    <div class="form-group">
        <label for="service">Service</label>
        <input disabled type="text" class="form-control" id="service" value="{{ $list_name }}">
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
</div>
