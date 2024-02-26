<?php

namespace App\Http\Controllers\restapi\admin;

use App\Enums\DepartmentStatus;
use App\Http\Controllers\Controller;
use App\Models\Department;
use Illuminate\Http\Request;

class AdminDepartmentApi extends Controller
{
    public function getList()
    {
        $departments = Department::where('status', DepartmentStatus::ACTIVE)
            ->orderBy('id', 'desc')
            ->get();
        return response()->json($departments);
    }

    public function detail($id)
    {
        $department = Department::find($id);
        if (!$department || $department->status == DepartmentStatus::DELETED) {
            return response('Not found!', 404);
        }
        return response()->json($department);
    }

    public function create(Request $request)
    {
        try {
            $department = new Department();

            $department = $this->saveDepartment($request, $department);

            $success = $department->save();
            if ($success) {
                return response()->json($department);
            }
            return response('Create error!', 400);
        } catch (\Exception $exception) {
            return response($exception, 400);
        }
    }

    public function saveDepartment($request, $department)
    {
        $name = $request->input('name');

        if ($request->hasFile('thumbnail')) {
            $item = $request->file('thumbnail');
            $itemPath = $item->store('departments', 'public');
            $thumbnail = asset('storage/' . $itemPath);
        } else {
            $thumbnail = $department->thumbnail;
        }

        $description = $request->input('description');
        $status = $request->input('status');
        $user_id = $request->input('user_id');

        $department->name = $name;
        $department->thumbnail = $thumbnail;
        $department->description = $description;
        $department->status = $status;
        $department->user_id = $user_id;
        return $department;
    }

    public function update(Request $request, $id)
    {
        try {
            $department = Department::find($id);
            if (!$department || $department->status == DepartmentStatus::DELETED) {
                return response('Not found!', 404);
            }

            $department = $this->saveDepartment($request, $department);

            $success = $department->save();
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
            $department = Department::find($id);
            if (!$department || $department->status == DepartmentStatus::DELETED) {
                return response('Not found!', 404);
            }

            $department->status = DepartmentStatus::DELETED;

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
