<?php

use App\Http\Controllers\FamilyManagementController;
use App\Http\Controllers\QuestionLikesController;
use App\Http\Controllers\restapi\admin\AdminSurveyApi;
use App\Http\Controllers\SurveyController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
|Normal Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::group(['prefix' => 'question-like'], function () {
    Route::get('is-like/{questionId}/{userId}',
        [QuestionLikesController::class, 'checkEmotion'])->name('api.backend.question-like.check');
    Route::post('change/{questionId}/{userId}',
        [QuestionLikesController::class, 'changeEmotion'])->name('api.backend.question-like.change');
});

Route::group(['prefix' => 'family-managementt'], function () {
    Route::get('index', [FamilyManagementController::class, 'index'])->name('api.backend.family-management.index');
    Route::get('create', [FamilyManagementController::class, 'create'])->name('api.backend.family-management.create');
    Route::get('addMember',
        [FamilyManagementController::class, 'addMember'])->name('api.backend.family-management.addMember');
    Route::post('store/{type}',
        [FamilyManagementController::class, 'store'])->name('api.backend.family-management.store');
    Route::get('edit/{id}', [FamilyManagementController::class, 'edit'])->name('api.backend.family-management.edit');
    Route::post('update/{id}',
        [FamilyManagementController::class, 'update'])->name('api.backend.family-management.update');
    Route::post('destroy/{id}',
        [FamilyManagementController::class, 'destroy'])->name('api.backend.family-management.destroy');
});

Route::group(['prefix' => 'family-management'], function () {
    Route::get('index/{current_user_id}', [FamilyManagementController::class, 'indexApi']);
    Route::post('create/{current_user_id}', [FamilyManagementController::class, 'createApi']);
    Route::post('store/{current_user_id}', [FamilyManagementController::class, 'storeApi']);
    Route::post('update/{id}', [FamilyManagementController::class, 'updateApi']);
    Route::delete('destroy/{id}', [FamilyManagementController::class, 'destroyApi']);
    Route::get('list/{id}', [FamilyManagementController::class, 'listMemberAPI']);
});

/* Survey api*/
Route::group(['prefix' => 'surveys'], function () {
    Route::get('/list', [AdminSurveyApi::class, 'getAll'])->name('api.medical.surveys.list');
    Route::get('/list-department/{id}',
        [AdminSurveyApi::class, 'getAllByDepartment'])->name('api.medical.surveys.department');
    Route::get('/detail/{id}', [AdminSurveyApi::class, 'detail'])->name('api.medical.surveys.detail');
    Route::post('/create', [AdminSurveyApi::class, 'create'])->name('api.medical.surveys.create');
    Route::post('/update/{id}', [AdminSurveyApi::class, 'update'])->name('api.medical.surveys.update');
    Route::delete('/delete/{id}', [AdminSurveyApi::class, 'delete'])->name('api.medical.surveys.delete');

    Route::get('get-by-department/{departmentId}', [SurveyController::class, 'getQuestionByDepartment'])->name('api.survey.get-by-department');
    Route::get('get-answer-by-user/{question_id}/{user_id}', [SurveyController::class, 'getAnswerByUser']);
    Route::post('form-survey', [AdminSurveyApi::class, 'handleFormSurvey'])->name('api.medical.surveys.form.submit');

});
