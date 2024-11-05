<?php

use App\Http\Controllers\Api\ContactController;
use App\Http\Controllers\connect\AgoraChatController;
use App\Http\Controllers\connect\CallVideoController;
use App\Http\Controllers\ui\MyBookingController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\backend\BackendClinicController;

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

Route::post('my-bookings/history/{userId}', [MyBookingController::class, 'updateMedicalHistoryApi'])->name('api.backend.my-bookings.update-history');

Route::post('/end-call', [CallVideoController::class, 'endCall']);

Route::post('/download-record', [AgoraChatController::class, 'downloadRecord']);

/* api list outstanding hospital clinic */
Route::get('/outstanding-hospital-clinic', [BackendClinicController::class, 'getOutstandingHospitalClinic']);
Route::get('/outstanding-doctor', [BackendClinicController::class, 'getOutstandingDoctor']);
