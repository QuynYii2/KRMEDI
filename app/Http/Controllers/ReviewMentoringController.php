<?php

namespace App\Http\Controllers;

use App\Enums\QuestionStatus;
use App\Models\Department;
use App\Models\Question;
use App\Models\ReportmentoringModel;
use App\Models\User;
use Illuminate\Http\Request;

class ReviewMentoringController extends Controller
{
    public function index()
    {
        $questions = Question::withCount('answers')->orderBy('created_at', 'desc')->paginate(20);
        foreach ($questions as $item){
            $item->name_category = Department::find($item->category_id)->name??'Chưa có tên';
        }
        $departments = Department::where('status', \App\Enums\DepartmentStatus::ACTIVE)->get();
        return view('admin.reviews-mentoring.list',compact('questions','departments'));
    }

    public function detail($id)
    {
        $review = Question::find($id);
        $review->name_category = Department::find($review->category_id)->name;
        $reflector = new \ReflectionClass('App\Enums\DoctorReviewStatus');
        $status = $reflector->getConstants();

        return view('admin.reviews-mentoring.detail', compact('review', 'status'));
    }

    public function updateStatus(Request $request, $id)
    {
        try {
            $review = Question::find($id);
            if (!$review ) {
                return response('Not found', 404);
            }

            $status = $request->input('status');
            if (!$status) {
                $status = QuestionStatus::PENDING;
            }

            $review->status = $status;
            $success = $review->save();
            if ($success) {
                return response()->json($review);
            }
            return response('Update error!', 400);
        } catch (\Exception $exception) {
            return response($exception, 400);
        }
    }

    public function delete($id)
    {
        try {
            $review = Question::find($id);
            if (!$review) {
                return response('Not found', 404);
            }
            $review->delete();

            return response('Delete success!', 200);
        } catch (\Exception $exception) {
            return response($exception, 400);
        }
    }

    public function listReport($id)
    {
        $listData = ReportmentoringModel::where('question_id',$id)->orderBy('created_at','desc')->paginate(20);
        foreach ($listData as $item){
            $item->name_people = User::find($item->user_id)->name;
        }

        return view('admin.reviews-mentoring.list-report', compact('listData'));
    }
}
