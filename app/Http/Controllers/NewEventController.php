<?php

namespace App\Http\Controllers;

use App\Enums\NewEventStatus;
use App\Models\NewEvent;
use Illuminate\Http\Request;

class NewEventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $perPage = 6; // Set the number of items per page

        $listEvent = NewEvent::where('status', NewEventStatus::ACTIVE)
            ->where('type', 'EVENT')
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);
        $listNews = NewEvent::where('status', NewEventStatus::ACTIVE)
            ->where('type', 'NEWS')
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);
        return view('News-event.News', compact('listEvent', 'listNews'));
    }

    public function detail($id)
    {
        $newEvent = NewEvent::find($id);
        $related = NewEvent::where('status', NewEventStatus::ACTIVE)
            ->where('type', $newEvent->type)
            ->where('id', '!=', $id)
            ->orderBy('created_at', 'desc')
            ->get();
        return view('News-event.detail-news', compact('newEvent', 'id', 'related'));
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
    public function show(NewEvent $newEvent)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(NewEvent $newEvent)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, NewEvent $newEvent)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(NewEvent $newEvent)
    {
        //
    }
}
