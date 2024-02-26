<?php

namespace App\Http\Controllers;

use App\Models\CalcViewQuestion;
use Illuminate\Http\Request;

class CalcViewQuestionController extends Controller
{

    public function calcView($id)
    {
        $calcViewQuestion = CalcViewQuestion::where('question_id', $id)->first();
        if ($calcViewQuestion) {
            $calcViewQuestion->views += 1;
            $calcViewQuestion->save();
        } else {
            $calcViewQuestion = new CalcViewQuestion();
            $calcViewQuestion->question_id = $id;
            $calcViewQuestion->views = 1;
            $calcViewQuestion->save();
        }

        return response()->json([
            'message' => 'success',
            'data' => $calcViewQuestion
        ]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(CalcViewQuestion $calcViewQuestion)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CalcViewQuestion $calcViewQuestion)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CalcViewQuestion $calcViewQuestion)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CalcViewQuestion $calcViewQuestion)
    {
        //
    }
}
