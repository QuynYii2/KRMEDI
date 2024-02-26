<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RecruitmentController extends Controller
{
    //
    public function index(){
        return view('recruitment');
    }

    public function apply()
    {
        return view('RecruitmentDetails.apply');
    }
    public function addCv()
    {
        return view('RecruitmentDetails.add-cv');
    }
    public function editCv()
    {
        return view('RecruitmentDetails.edit-cv');
    }

    public function detail(){
        return view('recruitment_details');
    }
}
