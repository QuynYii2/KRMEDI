<?php

use App\Http\Controllers\admin\AdminHomeController;
use App\Http\Controllers\admin\AdminUserController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\restapi\admin\AdminTopicVideoApi;
use App\Http\Controllers\restapi\admin\AdminUserApi;
use App\Http\Controllers\restapi\admin\AminServiceClinicApi;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\ShortVideoController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web admin Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

/* Admin user */
Route::group(['prefix' => 'user'], function () {
    Route::get('list', [AdminUserController::class, 'list'])->name('view.admin.user.list');
    Route::get('detail/{id}', [AdminUserController::class, 'detail'])->name('view.admin.user.detail');
    Route::get('create', [AdminUserController::class, 'create'])->name('view.admin.user.create');
});

/* Admin review */
Route::group(['prefix' => 'reviews'], function () {
    Route::get('list', [ReviewController::class, 'index'])->name('view.admin.reviews.index');
    Route::get('detail/{id}', [ReviewController::class, 'detail'])->name('view.admin.reviews.detail');
});

/* Admin short video */
Route::group(['prefix' => 'short-video'], function () {
    Route::get('list', [ShortVideoController::class, 'getList'])->name('view.admin.videos.list');
    Route::get('detail/{id}', [ShortVideoController::class, 'getById'])->name('view.admin.videos.detail');
});

/* Admin department */
Route::group(['prefix' => 'department'], function () {
    Route::get('list', [DepartmentController::class, 'index'])->name('view.admin.department.index');
    Route::get('create', [DepartmentController::class, 'create'])->name('view.admin.department.create');
    Route::post('store', [DepartmentController::class, 'store'])->name('view.admin.department.store');
    Route::get('edit/{id}', [DepartmentController::class, 'edit'])->name('view.admin.department.edit');
    Route::post('update/{id}', [DepartmentController::class, 'update'])->name('view.admin.department.update');
});

/* Admin manager products medicine with home admin page */
Route::group(['prefix' => 'home-medicine'], function () {
    Route::get('list', [AdminHomeController::class, 'showAllProductMedicine'])->name('view.admin.home.medicine.list');
    Route::get('detail/{id}', [AdminHomeController::class, 'detailProductMedicine'])->name('view.admin.home.medicine.detail');
});

/* Main admin */
Route::group(['prefix' => 'home'], function () {
    Route::get('list-config', [HomeController::class, 'listConfig'])->name('view.admin.list.config');
});
