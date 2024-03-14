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
            ->orderBy('order', 'asc')
            ->orderBy('isFilter', 'desc')
            ->orderBy('id', 'desc')
            ->get();

        $symptoms = Symptom::where('status', SymptomStatus::ACTIVE)
            ->orderBy('order', 'asc')
            ->orderBy('isFilter', 'desc')
            ->orderBy('id', 'desc')
            ->get();

        return view('admin.department_symptom.create-symptom', compact('departments', 'symptoms'));
    }

    public function show($id)
    {
    }

    public function edit($id)
    {
        $symptom = Symptom::find($id);

        $departments = Department::where('status', DepartmentStatus::ACTIVE)
            ->orderBy('order', 'asc')
            ->orderBy('isFilter', 'desc')
            ->orderBy('id', 'desc')
            ->get();

        $symptoms = Symptom::where('status', SymptomStatus::ACTIVE)
            ->orderBy('order', 'asc')
            ->orderBy('isFilter', 'desc')
            ->orderBy('id', 'desc')
            ->get();

        return view('admin.department_symptom.edit-symptom', compact('symptom', 'departments', 'symptoms'));
    }

    public function update(Request $request, $id)
    {
        $symptom = Symptom::find($id);

        $isFilter = $request->input('isFilter');

        $orderType = $request->input('symptom_order_type');

        $symOrderId = $request->input('symptom_order_id');

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

        $getSymptomOrder = Symptom::find($symOrderId)->order ?? 0;

        $symptom->description = $description;
        $symptom->description_en = $description_en;
        $symptom->description_laos = $description_laos;

        $status = SymptomStatus::ACTIVE;
        $symptom->status = $status;

        if ($orderType == "before") {
            if ($getSymptomOrder == 0) {
                $symptom->order = 0;
            } else {
                $symptom->order = $getSymptomOrder - 1;
            }
        } elseif ($orderType == "after") {
            $symptom->order = $getSymptomOrder + 1;
        } else {
            $symptom->order = 0;
        }

        if ($isFilter && $isFilter == "on") {
            $symptom->isFilter = 1;
        } else {
            $symptom->isFilter = 0;
        }

        $symptom->save();

        return redirect()->route('symptom.index')->with('success', 'Symptoms updated successfully.');
    }

    public function store(Request $request)
    {
        $name = $request->input('name');

        $symptom = new Symptom();

        $translate = new TranslateController();

        $isFilter = $request->input('isFilter');

        $orderType = $request->input('symptom_order_type');

        $symOrderId = $request->input('symptom_order_id');

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

        $getSymptomOrder = Symptom::find($symOrderId)->order ?? 0;

        $symptom->name = $name;
        $symptom->name_en = $name_en;
        $symptom->name_laos = $name_laos;

        $symptom->department_id = $department;

        $symptom->description = $description;
        $symptom->description_en = $description_en;
        $symptom->description_laos = $description_laos;

        $symptom->status = $status;
        $symptom->user_id = $user_id;

        if ($orderType == "before") {
            if ($getSymptomOrder == 0) {
                $symptom->order = 0;
            } else {
                $symptom->order = $getSymptomOrder - 1;
            }
        } elseif ($orderType == "after") {
            $symptom->order = $getSymptomOrder + 1;
        } else {
            $symptom->order = 0;
        }

        if ($isFilter && $isFilter == "on") {
            $symptom->isFilter = 1;
        }

        $symptom->save();

        return redirect()->route('symptom.index')->with('success', 'Symptoms created successfully.');
    }

    public function destroy($id)
    {
    }
}
