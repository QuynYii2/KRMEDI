<?php

use App\Http\Controllers\restapi\admin\AdminProductMedicineApi;
use App\Http\Controllers\restapi\admin\AdminTopicVideoApi;
use App\Http\Controllers\restapi\admin\AdminUserApi;
use App\Http\Controllers\restapi\admin\AminServiceClinicApi;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
|admin Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::group(['prefix' => 'users'], function () {
    Route::get('index', [AdminUserApi::class, 'getAllUser'])->name('api.admin.users.list');
    Route::get('search', [AdminUserApi::class, 'search'])->name('api.admin.users.search');
    Route::get('detail/{id}', [AdminUserApi::class, 'detail'])->name('api.admin.users.detail');
    Route::post('create', [AdminUserApi::class, 'create'])->name('api.admin.users.create');
    Route::post('update/{id}', [AdminUserApi::class, 'update'])->name('api.admin.users.update');
    Route::delete('delete/{id}', [AdminUserApi::class, 'delete'])->name('api.admin.users.delete');
});

Route::group(['prefix' => 'service-clinics'], function () {
    Route::get('list', [AminServiceClinicApi::class, 'getAll'])->name('api.admin.service.clinic.list');
    Route::get('list-by-clinics/{id}', [AminServiceClinicApi::class, 'getAllByClinics'])->name('api.admin.service.clinic.list.clinics');
    Route::get('list-by-user/{id}', [AminServiceClinicApi::class, 'getAllByUserId'])->name('api.admin.service.clinic.list.user');
    Route::get('detail/{id}', [AminServiceClinicApi::class, 'detail'])->name('api.admin.service.clinic.detail');
    Route::post('create', [AminServiceClinicApi::class, 'create'])->name('api.admin.service.clinic.create');
    Route::put('update/{id}', [AminServiceClinicApi::class, 'update'])->name('api.admin.service.clinic.update');
    Route::put('change-status/{id}', [AminServiceClinicApi::class, 'changeStatus'])->name('api.admin.service.clinic.changeStatus');
    Route::delete('delete/{id}', [AminServiceClinicApi::class, 'delete'])->name('api.admin.service.clinic.delete');
});

Route::group(['prefix' => 'topic-videos'], function () {
    Route::get('/list', [AdminTopicVideoApi::class, 'getAll'])->name('api.admin.topic.videos.list');
    Route::get('/users/{id}', [AdminTopicVideoApi::class, 'getAllByUserID'])->name('api.admin.topic.videos.users');
    Route::get('/detail/{id}', [AdminTopicVideoApi::class, 'detail'])->name('api.admin.topic.videos.detail');

    Route::post('/create', [AdminTopicVideoApi::class, 'create'])->name('api.admin.topic.videos.create');
    Route::post('/update/{id}', [AdminTopicVideoApi::class, 'update'])->name('api.admin.topic.videos.update');
    Route::delete('/delete/{id}', [AdminTopicVideoApi::class, 'delete'])->name('api.admin.topic.videos.delete');
});

Route::group(['prefix' => 'products-medicine'], function () {
    Route::get('/filter', [AdminProductMedicineApi::class, 'filterProduct'])->name('api.admin.products.medicine.filter');
    Route::get('/search', [AdminProductMedicineApi::class, 'searchProduct'])->name('api.admin.products.medicine.search');
    Route::post('/change', [AdminProductMedicineApi::class, 'changeStatus'])->name('api.admin.products.medicine.change');
});


