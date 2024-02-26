<?php

namespace App\Http\Controllers\restapi\admin;

use App\Enums\SymptomStatus;
use App\Http\Controllers\Controller;
use App\Models\Symptom;
use Illuminate\Http\Request;

class AdminSymptomsApi extends Controller
{
    public function getList()
    {
        $symptoms = Symptom::where('status', SymptomStatus::ACTIVE)
            ->orderBy('id', 'desc')
            ->get();
        return response()->json($symptoms);
    }

    public function detail($id)
    {
        $symptom = Symptom::find($id);
        if (!$symptom || $symptom->status == SymptomStatus::DELETED) {
            return response('Not found!', 404);
        }
        return response()->json($symptom);
    }

    public function create(Request $request)
    {
        try {
            $symptom = new Symptom();

            $symptom = $this->saveSymptom($request, $symptom);

            $success = $symptom->save();
            if ($success) {
                return response()->json($symptom);
            }
            return response('Create error!', 400);
        } catch (\Exception $exception) {
            return response($exception, 400);
        }
    }

    public function saveSymptom($request, $symptom)
    {
        if ($request->hasFile('thumbnail')) {
            $item = $request->file('thumbnail');
            $itemPath = $item->store('symptoms', 'public');
            $thumbnail = asset('storage/' . $itemPath);
        } else {
            $thumbnail = $symptom->thumbnail;
        }
        $name = $request->input('name');
        $department = $request->input('department');
        $description = $request->input('description');

        $user_id = $request->input('user_id');
        $status = $request->input('status');

        $symptom->name = $name;
        $symptom->department_id = $department;
        $symptom->thumbnail = $thumbnail;
        $symptom->description = $description;
        $symptom->status = $status;
        $symptom->user_id = $user_id;
        return $symptom;
    }

    public function update(Request $request, $id)
    {
        try {
            $symptom = Symptom::find($id);
            if (!$symptom || $symptom->status == SymptomStatus::DELETED) {
                return response('Not found!', 404);
            }

            $symptom = $this->saveSymptom($request, $symptom);

            $success = $symptom->save();
            if ($success) {
                return response()->json($symptom);
            }
            return response('Update error!', 400);
        } catch (\Exception $exception) {
            return response($exception, 400);
        }
    }

    public function delete($id)
    {
        try {
            $symptom = Symptom::find($id);
            if (!$symptom || $symptom->status == SymptomStatus::DELETED) {
                return response('Not found!', 404);
            }

            $symptom->status = SymptomStatus::DELETED;

            $success = $symptom->save();
            if ($success) {
                return response('Delete success!', 200);
            }
            return response('Delete error!', 400);
        } catch (\Exception $exception) {
            return response($exception, 400);
        }
    }
}
