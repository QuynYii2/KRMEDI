<?php

namespace App\Http\Controllers\restapi;

use App\Enums\ServiceClinicStatus;
use App\Http\Controllers\Controller;
use App\Http\Controllers\TranslateController;
use App\Models\Clinic;
use App\Models\ServiceClinic;
use Illuminate\Http\Request;

class ServiceClinicApi extends Controller
{
    public function getAll()
    {
        $services = ServiceClinic::where('status', ServiceClinicStatus::ACTIVE)
            ->orderBy('id', 'desc')
            ->get();
        return response()->json($services);
    }

    public function getAllByClinics($id)
    {
        $services = null;
        $clinic = Clinic::find($id);
        if ($clinic) {
            $list_service = $clinic->service_id;
            $array_service = explode(',', $list_service);
            $services = ServiceClinic::whereIn('id', $array_service)
                ->where('status', ServiceClinicStatus::ACTIVE)
                ->orderBy('id', 'desc')
                ->get();
        }
        return response()->json($services);
    }

    public function getAllByUserId($id)
    {
        $services = ServiceClinic::where('status', ServiceClinicStatus::ACTIVE)
            ->where('user_id', $id)
            ->orderBy('id', 'desc')
            ->get();
        return response()->json($services);
    }

    public function detail($id)
    {
        $service = ServiceClinic::find($id);
        if (!$service || $service->status != ServiceClinicStatus::ACTIVE) {
            return response('Not found!', 404);
        }
        return response()->json($service);
    }

    public function create(Request $request)
    {
        try {
            $service = new ServiceClinic();
            $service = $this->saveService($request, $service);
            $success = $service->save();
            if ($success) {
                return response()->json($service);
            }
            return response('Create error!', 400);
        } catch (\Exception $exception) {
            return response($exception, 400);
        }
    }

    public function saveService($request, $service)
    {
        $name = $request->input('name');

        $translate = new TranslateController();
        $name_en = $translate->translateText($request->input('name'), 'en');
        $name_laos = $translate->translateText($request->input('name'), 'lo');

        $user_id = $request->input('user_id');
        $status = $request->input('status');
        $servicePrice = $request->input('service_price');

        $service->name = $name;
        $service->name_en = $name_en;
        $service->name_laos = $name_laos;
        $service->user_id = $user_id;
        $service->status = $status;
        $service->service_price = $servicePrice;

        return $service;
    }
}
