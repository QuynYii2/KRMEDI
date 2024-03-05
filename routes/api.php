<?php

use App\Http\Controllers\Api\ContactController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/contact-list/{id}', [ContactController::class, 'getContactList'])->name('chat.contact-list');


Route::get('/conversation/{id}/{auth_id}', [ContactController::class, 'getMessages'])->name('chat.conversation');


Route::post('/conversation/send', [ContactController::class, 'sendNewMessage'])->name('chat.send-message');


Route::post('renew-uuid', [ContactController::class, 'renewUuidMessage'])->name('chat.send-message.renew-uuid');
