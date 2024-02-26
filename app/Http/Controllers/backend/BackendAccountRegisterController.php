<?php

namespace App\Http\Controllers\backend;

use App\Enums\Role;
use App\Enums\UserStatus;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class BackendAccountRegisterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $list = [Role::BUSINESS, Role::MEDICAL];
        $users = User::whereIn('type', $list)->where('status', '!=', UserStatus::DELETED)->paginate(10);
        return view('admin.account_register.index', compact('users'));
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
        $user = User::find($id);
        if (!$user) {
            return response('User not found', 404);
        }
        $user->status = $request->status;
        $success = $user->save();
        if (!$success) {
            return response('Error updating user', 500);
        }
        return response('User updated', 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
