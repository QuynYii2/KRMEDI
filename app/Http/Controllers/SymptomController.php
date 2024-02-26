<?php

namespace App\Http\Controllers;

use App\Enums\DepartmentStatus;
use App\Enums\SymptomStatus;
use App\Models\Department;
use App\Models\Symptom;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SymptomController extends Controller
{
    public function index()
    {
        $symptoms = Symptom::where('status', SymptomStatus::ACTIVE)
            ->orderBy('id', 'desc')
            ->paginate(10);
        return view('admin.department_symptom.lists-symptom', ['symptoms' => $symptoms]);
    }

    public function create()
    {
        $departments = Department::where('status', DepartmentStatus::ACTIVE)
            ->orderBy('id', 'desc')
            ->get();
        return view('admin.department_symptom.create-symptom', compact('departments'));
    }

    public function show($id)
    {
    }

    public function edit($id)
    {
        $symptom = Symptom::find($id);
        $departments = Department::where('status', DepartmentStatus::ACTIVE)
            ->orderBy('id', 'desc')
            ->get();
        return view('admin.department_symptom.edit-symptom', compact('symptom', 'departments'));
    }

    public function update(Request $request, $id)
    {
        $symptom = Symptom::find($id);

        $translate = new TranslateController();

        $department = $request->input('department');
        if ($request->hasFile('image')) {
            $item = $request->file('image');
            $itemPath = $item->store('symptoms', 'public');
            $thumbnail = asset('storage/' . $itemPath);
            $symptom->thumbnail = $thumbnail;
        }

        $name = $request->input('name');

        $name_en = $translate->translateText($name, 'en');
        $name_laos = $translate->translateText($name, 'lo');

        if (!$name || !$name_en || !$name_laos) {
            alert()->error('Error', 'Please enter the name input!');
            return back();
        }

        $symptom->name = $name;
        $symptom->name_en = $name_en;
        $symptom->name_laos = $name_laos;

        $symptom->department_id = $department;

        $description = $request->input('description');

        $description_en = $translate->translateText($description, 'en');
        $description_laos = $translate->translateText($description, 'lo');

        if (!$description || !$description_en || !$description_laos) {
            alert()->error('Error', 'Please enter the description input!');
            return back();
        }

        $symptom->description = $description;
        $symptom->description_en = $description_en;
        $symptom->description_laos = $description_laos;

        $status = SymptomStatus::ACTIVE;
        $symptom->status = $status;

        $symptom->save();

        return redirect()->route('symptom.index')->with('success', 'Symptoms updated successfully.');
    }

    public function store(Request $request)
    {
        $name = $request->input('name');

        $symptom = new Symptom();

        $translate = new TranslateController();

        $name_en = $translate->translateText($name, 'en');
        $name_laos = $translate->translateText($name, 'lo');

        if (!$name || !$name_en || !$name_laos) {
            alert()->error('Error', 'Please enter the name input!');
            return back();
        }

        if ($request->hasFile('image')) {
            $item = $request->file('image');
            $itemPath = $item->store('symptoms', 'public');
            $thumbnail = asset('storage/' . $itemPath);
            $symptom->thumbnail = $thumbnail;
        } else {
            alert()->error('Error', 'Please upload image!');
            return back();
        }

        $department = $request->input('department');

        $description = $request->input('description');
        $description_en = $translate->translateText($description, 'en');
        $description_laos = $translate->translateText($description, 'lo');

        if (!$description || !$description_en || !$description_laos) {
            alert()->error('Error', 'Please enter the description input!');
            return back();
        }

        $user_id = Auth::user()->id;
        $status = SymptomStatus::ACTIVE;

        $symptom->name = $name;
        $symptom->name_en = $name_en;
        $symptom->name_laos = $name_laos;

        $symptom->department_id = $department;

        $symptom->description = $description;
        $symptom->description_en = $description_en;
        $symptom->description_laos = $description_laos;

        $symptom->status = $status;
        $symptom->user_id = $user_id;

        $symptom->save();

        return redirect()->route('symptom.index')->with('success', 'Symptoms created successfully.');
    }

    public function destroy($id)
    {
    }
}
