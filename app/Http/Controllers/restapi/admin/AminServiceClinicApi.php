<?php

namespace App\Http\Controllers\restapi\admin;

use App\Enums\ServiceClinicStatus;
use App\Http\Controllers\Controller;
use App\Http\Controllers\restapi\ServiceClinicApi;
use App\Models\Clinic;
use App\Models\ServiceClinic;
use Illuminate\Http\Request;

class AminServiceClinicApi extends Controller
{
    public function getAll(Request $request)
    {
        $status = $request->input('status');
        if ($status) {
            $services = ServiceClinic::where('status', $status)
                ->orderBy('id', 'desc')
                ->get();
        } else {
            $services = ServiceClinic::where('status', '!=', ServiceClinicStatus::DELETED)
                ->orderBy('id', 'desc')
                ->get();
        }

        return response()->json($services);
    }

    public function getAllByClinics($id, Request $request)
    {
        $services = null;
        $clinic = Clinic::find($id);
        $status = $request->input('status');
        if ($clinic) {
            $list_service = $clinic->service_id;
            $array_service = explode(',', $list_service);
            if ($status) {
                $services = ServiceClinic::whereIn('id', $array_service)
                    ->where('status', $status)
                    ->orderBy('id', 'desc')
                    ->get();
            } else {
                $services = ServiceClinic::whereIn('id', $array_service)
                    ->where('status', '!=', ServiceClinicStatus::DELETED)
                    ->orderBy('id', 'desc')
                    ->get();
            }
        }
        return response()->json($services);
    }

    public function getAllByUserId($id, Request $request)
    {
        $status = $request->input('status');
        if ($status) {
            $services = ServiceClinic::where('status', $status)
                ->where('user_id', $id)
                ->orderBy('id', 'desc')
                ->get();
        } else {
            $services = ServiceClinic::where('status', '!=', ServiceClinicStatus::DELETED)
                ->where('user_id', $id)
                ->orderBy('id', 'desc')
                ->get();
        }
        return response()->json($services);
    }

    public function detail($id)
    {
        $service = ServiceClinic::find($id);
        if (!$service || $service->status == ServiceClinicStatus::DELETED) {
            return response('Not found!', 404);
        }
        return response()->json($service);
    }

    public function create(Request $request)
    {
        try {
            $service = new ServiceClinic();
            $service = (new ServiceClinicApi())->saveService($request, $service);
            $success = $service->save();
            if ($success) {
                return response()->json($service);
            }
            return response('Create error!', 400);
        } catch (\Exception $exception) {
            return response($exception, 400);
        }
    }

    public function update($id, Request $request)
    {
        try {
            $service = ServiceClinic::find($id);
            if (!$service || $service->status == ServiceClinicStatus::DELETED) {
                return response('Not found!', 404);
            }
            $service = (new ServiceClinicApi())->saveService($request, $service);
            $success = $service->save();
            if ($success) {
                return response()->json($service);
            }
            return response('Update error!', 400);
        } catch (\Exception $exception) {
            return response($exception, 400);
        }
    }

    public function changeStatus($id)
    {
        try {
            $service = ServiceClinic::find($id);
            if (!$service || $service->status != ServiceClinicStatus::ACTIVE) {
                return response('Not found!', 404);
            }
            if ($service->status == ServiceClinicStatus::ACTIVE) {
                $service->status == ServiceClinicStatus::INACTIVE;
            } else {
                $service->status == ServiceClinicStatus::ACTIVE;
            }
            $success = $service->save();
            if ($success) {
                return response()->json($service);
            }
            return response('Change status error!', 400);
        } catch (\Exception $exception) {
            return response($exception, 400);
        }
    }

    public function delete($id, Request $request)
    {
        try {
            $service = ServiceClinic::find($id);
            if (!$service || $service->status == ServiceClinicStatus::DELETED) {
                return response('Not found!', 404);
            }
            $service->status = ServiceClinicStatus::DELETED;
            $success = $service->save();
            if ($success) {
                return response('Delete success!', 200);
            }
            return response('Delete error!', 400);
        } catch (\Exception $exception) {
            return response($exception, 400);
        }
    }

    public function getServiceById($serviceId)
    {
        try {

            $services = ServiceClinic::whereIn('id', explode(',', $serviceId))
                ->select('name', 'name_en', 'name_laos')
                ->get();

            if ($services->isEmpty()) {
                return response('Not found!', 404);
            }

            return response()->json($services);
        } catch (\Exception $exception) {
            return response('An error occurred.', 500);
        }
    }
}
