<?php

namespace App\Http\Controllers\restapi\admin;

use App\Enums\DoctorDepartmentStatus;
use App\Http\Controllers\Controller;
use App\Models\DoctorDepartment;
use Illuminate\Http\Request;

class AdminDoctorDepartmentApi extends Controller
{
    public function getAll(Request $request)
    {
        $status = $request->input('status');
        if ($status) {
            $departments = DoctorDepartment::where('status', $status)->get();
        } else {
            $departments = DoctorDepartment::where('status', '!=', DoctorDepartmentStatus::DELETED)->get();
        }

        return response()->json($departments);
    }

    public function getAllByUserID($id, Request $request)
    {
        $status = $request->input('status');
        if ($status) {
            $departments = DoctorDepartment::where('status', $status)
                ->where('user_id', $id)
                ->get();
        } else {
            $departments = DoctorDepartment::where('status', '!=', DoctorDepartmentStatus::DELETED)
                ->where('user_id', $id)
                ->get();
        }

        return response()->json($departments);
    }

    public function getById($id)
    {
        $department = DoctorDepartment::where('id', $id)->first();
        if (!$department || $department->status == DoctorDepartmentStatus::DELETED) {
            return response('Not found!', 404);
        }
        return response()->json($department);
    }

    public function create(Request $request)
    {
        try {
            $department = new DoctorDepartment();
            $success = $this->createOrUpdate($request, $department);
            if ($success) {
                return response()->json($department);
            }
            return response('Create error!', 400);
        } catch (\Exception $exception) {
            return response($exception, 400);
        }
    }

    private function createOrUpdate(Request $request, $department)
    {
        $department->user_id = $request->input('user_id');

        if ($request->hasFile('thumbnail')) {
            $item = $request->file('thumbnail');
            $itemPath = $item->store('departments', 'public');
            $thumbnail = asset('storage/' . $itemPath);
        } else {
            $thumbnail = $department->thumbnail;
        }

        $department->thumbnail = $thumbnail;

        $department->name = $request->input('name');
        $department->name_en = $request->input('name_en');
        $department->name_laos = $request->input('name_laos');

        $department->status = $request->input('status');

        $success = $department->save();

        return $success;
    }

    public function update(Request $request, $id)
    {
        try {
            $department = DoctorDepartment::find($id);

            if (!$department || $department->status == DoctorDepartmentStatus::DELETED) {
                return response('Not found!', 404);
            }
            $success = $this->createOrUpdate($request, $department);
            if ($success) {
                return response()->json($department);
            }
            return response('Update error!', 400);
        } catch (\Exception $exception) {
            return response($exception, 400);
        }
    }

    public function delete($id)
    {
        try {
            $department = DoctorDepartment::find($id);

            if (!$department || $department->status == DoctorDepartmentStatus::DELETED) {
                return response('Not found!', 404);
            }
            $department->status = DoctorDepartmentStatus::DELETED;

            $success = $department->save();
            if ($success) {
                return response('Delete success!', 200);
            }
            return response('Delete error!', 400);
        } catch (\Exception $exception) {
            return response($exception, 400);
        }
    }
}
