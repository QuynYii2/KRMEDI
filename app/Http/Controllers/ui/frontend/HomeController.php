<?php

namespace App\Http\Controllers\ui\frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
//    public function index()
//    {
//        $listNewEvent = NewEvent::where('status', NewEventStatus::ACTIVE)
//            ->orderBy('created_at', 'desc')
//            ->get();
//        return view('News-event.News', compact('listNewEvent'));
//    }
//
//    public function detail ()
//    {
//        return view('News-event.detail-news');
//    }

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
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
