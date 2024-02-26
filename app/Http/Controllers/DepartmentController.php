<?php

namespace App\Http\Controllers;

use App\Enums\DepartmentStatus;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DepartmentController extends Controller
{
    public function index()
    {
        $departments = Department::where('status', DepartmentStatus::ACTIVE)
            ->orderBy('id', 'desc')
            ->paginate(10);

        return view('admin.department_symptom.lists-department', ['departments' => $departments]);
    }

    public function create()
    {
        return view('admin.department_symptom.create-department');
    }

    public function show($id)
    {
    }

    public function edit($id)
    {
        $department = Department::find($id);
        return view('admin.department_symptom.edit-department', compact('department'));
    }

    public function update(Request $request, $id)
    {
        $department = Department::find($id);

        $name = $request->input('name');

        $translate = new TranslateController();

        $name_en = $translate->translateText($name, 'en');
        $name_laos = $translate->translateText($name, 'lo');

        if (!$name || !$name_en || !$name_laos) {
            alert()->error('Error', 'Please enter the name input!');
            return back();
        }

        if ($request->hasFile('image')) {
            $item = $request->file('image');
            $itemPath = $item->store('departments', 'public');
            $thumbnail = asset('storage/' . $itemPath);
            $department->thumbnail = $thumbnail;
        }

        $status = DepartmentStatus::ACTIVE;

        $description = $request->input('description');

        $description_en = $translate->translateText($description, 'en');
        $description_laos = $translate->translateText($description, 'lo');

        if (!$description || !$description_en || !$description_laos) {
            alert()->error('Error', 'Please enter the description input!');
            return back();
        }

        $department->name = $name;
        $department->name_en = $name_en;
        $department->name_laos = $name_laos;

        $department->description = $description;
        $department->description_en = $description_en;
        $department->description_laos = $description_laos;

        $department->status = $status;
        $department->save();

        return redirect()->route('view.admin.department.index')->with('success', 'Department update successfully.');
    }

    public function store(Request $request)
    {
        $department = new Department();

        $translate = new TranslateController();

        $name = $request->input('name');

        $name_en = $translate->translateText($name, 'en');
        $name_laos = $translate->translateText($name, 'lo');

        if (!$name || !$name_en || !$name_laos) {
            alert()->error('Error', 'Please enter the name input!');
            return back();
        }

        if ($request->hasFile('image')) {
            $item = $request->file('image');
            $itemPath = $item->store('departments', 'public');
            $thumbnail = asset('storage/' . $itemPath);
        } else {
            alert()->error('Error', 'Please upload image!');
            return back();
        }

        $description = $request->input('description');
        $description_en = $translate->translateText($description, 'en');
        $description_laos = $translate->translateText($description, 'lo');

        if (!$description || !$description_en || !$description_laos) {
            alert()->error('Error', 'Please enter the description input!');
            return back();
        }

        $status = DepartmentStatus::ACTIVE;
        $user_id = Auth::user()->id;

        $department->name = $name;
        $department->name_en = $name_en;
        $department->name_laos = $name_laos;

        $department->thumbnail = $thumbnail;

        $department->description = $description;
        $department->description_en = $description_en;
        $department->description_laos = $description_laos;

        $department->status = $status;
        $department->user_id = $user_id;
        $department->save();

        return redirect()->route('view.admin.department.index')->with('success', 'Department created successfully.');
    }

    public function destroy($id)
    {
    }
}
