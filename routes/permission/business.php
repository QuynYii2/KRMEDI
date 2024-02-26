<?php

use App\Http\Controllers\backend\BackendCategoryController;
use App\Http\Controllers\backend\BackendCategoryProductController;
use App\Http\Controllers\backend\BackendNewEventController;
use App\Http\Controllers\backend\BackendProductMedicineController;
use App\Http\Controllers\backend\BackendServiceClinicController;
use App\Http\Controllers\restapi\admin\AdminDepartmentApi;
use App\Http\Controllers\restapi\admin\AdminSymptomsApi;
use App\Http\Controllers\restapi\ui\MyBusinessApi;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
|Business Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::group(['prefix' => 'categories'], function () {
    Route::get('/list', [BackendCategoryController::class, 'getAll'])->name('api.business.categories.list');
    Route::get('/detail/{id}', [BackendCategoryController::class, 'detail'])->name('api.business.categories.detail');
    Route::get('/user/{id}', [BackendCategoryController::class, 'getAllByUser'])->name('api.business.categories.user');
    Route::post('/create', [BackendCategoryController::class, 'create'])->name('api.business.categories.create');
    Route::post('/update/{id}', [BackendCategoryController::class, 'update'])->name('api.business.categories.update');
    Route::delete('/delete/{id}', [BackendCategoryController::class, 'delete'])->name('api.business.categories.delete');
});

/* My Business api */
Route::group(['prefix' => 'my-business'], function () {
    Route::post('update', [MyBusinessApi::class, 'updateBusiness'])->name('api.backend.my.business.update');
    Route::get('show', [MyBusinessApi::class, 'showBusiness'])->name('api.backend.my.business.show');
});

Route::group(['prefix' => 'product-medicine'], function () {
    Route::get('index', [BackendProductMedicineController::class, 'index'])->name('api.backend.product-medicine.index');
    Route::get('edit/{id}', [BackendProductMedicineController::class, 'edit'])->name('api.backend.product-medicine.edit');
    Route::post('update', [BackendProductMedicineController::class, 'update'])->name('api.backend.product-medicine.update');
    Route::get('create', [BackendProductMedicineController::class, 'create'])->name('api.backend.product-medicine.create');
    Route::post('store', [BackendProductMedicineController::class, 'store'])->name('api.backend.product-medicine.store');
    Route::post('destroy/{id}', [BackendProductMedicineController::class, 'destroy'])->name('api.backend.product-medicine.destroy');
});

Route::group(['prefix' => 'category-product'], function () {
    Route::get('index', [BackendCategoryProductController::class, 'index'])->name('api.backend.category-product.index');
    Route::get('edit/{id}', [BackendCategoryProductController::class, 'edit'])->name('api.backend.category-product.edit');
    Route::post('update', [BackendCategoryProductController::class, 'update'])->name('api.backend.category-product.update');
    Route::get('create', [BackendCategoryProductController::class, 'create'])->name('api.backend.category-product.create');
    Route::post('store', [BackendCategoryProductController::class, 'store'])->name('api.backend.category-product.store');
    Route::post('destroy/{id}', [BackendCategoryProductController::class, 'destroy'])->name('api.backend.category-product.destroy');
});

Route::group(['prefix' => 'service-clinic-pharmacy'], function () {
    Route::get('index', [BackendServiceClinicController::class, 'index'])->name('api.backend.service-clinic-pharmacy.index');
    Route::get('edit/{id}', [BackendServiceClinicController::class, 'edit'])->name('api.backend.service-clinic-pharmacy.edit');
    Route::post('update', [BackendServiceClinicController::class, 'update'])->name('api.backend.service-clinic-pharmacy.update');
    Route::get('create', [BackendServiceClinicController::class, 'create'])->name('api.backend.service-clinic-pharmacy.create');
    Route::post('store', [BackendServiceClinicController::class, 'store'])->name('api.backend.service-clinic-pharmacy.store');
    Route::post('destroy/{id}', [BackendServiceClinicController::class, 'destroy'])->name('api.backend.service-clinic-pharmacy.destroy');
});

/* Departments api */
Route::group(['prefix' => 'departments'], function () {
    Route::get('/list', [AdminDepartmentApi::class, 'getList'])->name('api.medical.departments.list');
    Route::get('/detail/{id}', [AdminDepartmentApi::class, 'detail'])->name('api.medical.departments.detail');
    Route::post('/create', [AdminDepartmentApi::class, 'create'])->name('api.medical.departments.create');
    Route::post('/update/{id}', [AdminDepartmentApi::class, 'update'])->name('api.medical.view.admin.department.update');
    Route::delete('/delete/{id}', [AdminDepartmentApi::class, 'delete'])->name('api.medical.departments.delete');
});

/* Symptoms api */
Route::group(['prefix' => 'symptoms'], function () {
    Route::get('/list', [AdminSymptomsApi::class, 'getList'])->name('api.medical.symptoms.list');
    Route::get('/detail/{id}', [AdminSymptomsApi::class, 'detail'])->name('api.medical.symptoms.detail');
    Route::post('/create', [AdminSymptomsApi::class, 'create'])->name('api.medical.symptoms.create');
    Route::post('/update/{id}', [AdminSymptomsApi::class, 'update'])->name('api.medical.symptoms.update');
    Route::delete('/delete/{id}', [AdminSymptomsApi::class, 'delete'])->name('api.medical.symptoms.delete');
});

