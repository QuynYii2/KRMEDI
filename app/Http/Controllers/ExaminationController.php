<?php

namespace App\Http\Controllers;

use App\Enums\DoctorDepartmentStatus;
use App\Enums\DoctorInfoStatus;
use App\Enums\online_medicine\OnlineMedicineStatus;
use App\Enums\QuestionStatus;
use App\Enums\SearchMentoring;
use App\Enums\TypeBusiness;
use App\Enums\TypeMedical;
use App\Enums\TypeTimeWork;
use App\Enums\UserStatus;
use App\Models\Answer;
use App\Models\CalcViewQuestion;
use App\Models\Clinic;
use App\Models\DoctorDepartment;
use App\Models\DoctorInfo;
use App\Models\online_medicine\CategoryProduct;
use App\Models\online_medicine\ProductMedicine;
use App\Models\Question;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use SimpleSoftwareIO\QrCode\Facades\QrCode;


class ExaminationController extends Controller
{
    public function index()
    {
        $departments = DoctorDepartment::where('status', DoctorDepartmentStatus::ACTIVE)->get();
        return view('examination.index', compact('departments'));
    }

    public function infoDoctor($id)
    {
        $url = route('qr.code.show.doctor.info', $id);
        $qrCodes = QrCode::size(300)->generate($url);
        $doctor = User::find($id);
        return view('examination.infodoctor', compact('qrCodes', 'doctor'));
    }

    public function bestDoctor()
    {
        return view('examination.bestdoctor');
    }

    public function newDoctor()
    {
        return view('examination.newdoctor');
    }

    public function availableDoctor()
    {
        return view('examination.availabledoctor');
    }

    public function findMyMedicine()
    {
        $bestPhamrmacists = User::where('member', TypeMedical::PHAMACISTS)
            ->where('status', UserStatus::ACTIVE)
            ->orderBy('id', 'DESC')
            ->limit(16)
            ->get();
        $newPhamrmacists = User::where('member', TypeMedical::PHAMACISTS)
            ->where('status', UserStatus::ACTIVE)
            ->orderBy('id', 'DESC')
            ->limit(16)
            ->get();
        $allPhamrmacists = User::where('member', TypeMedical::PHAMACISTS)
            ->where('status', UserStatus::ACTIVE)
            ->where('time_working_1', '00:00-23:59')
            ->where('time_working_2', 'T2-CN')
            ->limit(16)
            ->get();

        $hotMedicines = ProductMedicine::where('status', OnlineMedicineStatus::APPROVED)->limit(16)->get();
        $newMedicines = ProductMedicine::where('status', OnlineMedicineStatus::APPROVED)->orderBy('id',
            'DESC')->limit(16)->get();
        $recommendedMedicines = ProductMedicine::where('status', OnlineMedicineStatus::APPROVED)->limit(16)->get();

        $category_function = CategoryProduct::where('name', 'Functional Foods')->first();
        $function_foods = null;
        if ($category_function) {
            $function_foods = ProductMedicine::where('status', OnlineMedicineStatus::APPROVED)->where('category_id',
                $category_function->id)->limit(16)->get();
        }

        $categoryMedicines = CategoryProduct::where('status', true)->get();
        return view('examination.findmymedicine',
            compact('bestPhamrmacists', 'newPhamrmacists', 'allPhamrmacists', 'hotMedicines', 'newMedicines',
                'recommendedMedicines', 'categoryMedicines', 'function_foods'));
    }

    public function bestPharmacists()
    {
        $bestPhamrmacists = Clinic::where('type', TypeBusiness::PHARMACIES)->orderBy('count',
            'DESC')->limit(16)->get();
        return view('examination.bestpharmacists', compact('bestPhamrmacists'));
    }

    public function newPharmacists()
    {
        $newPhamrmacists = Clinic::where('type', TypeBusiness::PHARMACIES)->orderBy('id', 'DESC')->limit(16)->get();
        return view('examination.newpharmacists', compact('newPhamrmacists'));
    }

    public function availablePharmacists()
    {
        $availablePhamrmacists = Clinic::where('type', TypeBusiness::PHARMACIES)->where('time_work',
            TypeTimeWork::ALL)->limit(16)->get();
        return view('examination.availablepharmacists', compact('availablePhamrmacists'));
    }

    public function hotDealMedicine()
    {
        $hotMedicines = ProductMedicine::where('status', OnlineMedicineStatus::APPROVED)->limit(16)->get();
        return view('examination.hotdealmedicine', compact('hotMedicines'));
    }

    public function newMedicine()
    {
        $newMedicines = ProductMedicine::where('status', OnlineMedicineStatus::APPROVED)->orderBy('id',
            'DESC')->limit(16)->get();
        return view('examination.newmedicine', compact('newMedicines'));
    }

    public function recommended()
    {
        $recommendedMedicines = ProductMedicine::where('status', OnlineMedicineStatus::APPROVED)->limit(16)->get();
        return view('examination.recommended', compact('recommendedMedicines'));
    }

    public function myPersonalDoctor()
    {
        return view('examination.mypersonaldoctor');
    }

    public function mentoring()
    {
        $questions = Question::withCount('answers')->where('status', QuestionStatus::APPROVED)->orderBy('answers_count',
            'desc') // Order by answer_count in descending order
        ->take(10)->get();
        return view('examination.mentoring.mentoring', compact('questions'));
    }

    public function searchMentoring(Request $request)
    {

        $list = [];

        $listQuestion = Question::where('status', QuestionStatus::APPROVED)->get();
        $category_id = $request->input('category_id');

        if ($category_id && $category_id != 0) {
            $listQuestion = Question::where('status', QuestionStatus::APPROVED)->where('category_id',
                $category_id)->get();
        }

        foreach ($listQuestion as $question) {

            $countAnswer = Answer::where('question_id', $question->id)->count();
            $question_id = $question->id;
            $item = [
                'id' => $question_id,
                'title' => $question->title,
                'title_en' => $question->title_en,
                'title_laos' => $question->title_laos,
                'created_at' => Carbon::parse($question->created_at)->format('H:i:s d/m/Y'),
                'modified' => $question->updated_at,
                'comment_count' => $countAnswer,
                'category_id' => $question->category_id,
                'view_count' => CalcViewQuestion::getViewQuestion($question_id)->views ?? 0,
            ];
            array_push($list, $item);
        }

        switch ($request->input('type')) {
            case SearchMentoring::LATEST:
                usort($list, function ($a, $b) {
                    return strtotime($b['created_at']) - strtotime($a['created_at']);
                });
                break;
            case SearchMentoring::MOST_VIEWS:
                usort($list, function ($a, $b) {
                    return $b['view_count'] - $a['view_count'];
                });
                break;
            case SearchMentoring::MOST_COMMENTED:
                usort($list, function ($a, $b) {
                    return $b['comment_count'] - $a['comment_count'];
                });
                break;
        }

        return response()->json($list);
    }

    public function findByCategory($id)
    {
        $categoryProduct = CategoryProduct::find($id);
        $productCategories = ProductMedicine::where('category_id', $id)->where('status',
            OnlineMedicineStatus::APPROVED)->orderBy('id', 'desc')->get();
        return view('examination.find-by-category', compact('categoryProduct', 'productCategories'));
    }

    public function createMentoring()
    {
        return view('examination.mentoring.create');
    }

    public function showMentoring($id)
    {
        $question = Question::where('id', $id)->first();
        $answers = Answer::where('question_id', $id)->get();

        $calcViewQuestion = CalcViewQuestion::where('question_id', $id)->first();
        if ($calcViewQuestion) {
            $calcViewQuestion->views += 1;
        } else {
            $calcViewQuestion = new CalcViewQuestion();
            $calcViewQuestion->question_id = $id;
            $calcViewQuestion->views = 1;
        }
        $calcViewQuestion->save();

        return view('examination.mentoring.detail', compact('question', 'answers'));
    }

}
