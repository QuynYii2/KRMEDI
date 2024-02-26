<?php

use App\Http\Controllers\backend\BackendAnswerController;
use App\Http\Controllers\backend\BackendCouponController;
use App\Http\Controllers\restapi\AccountApi;
use App\Http\Controllers\restapi\BookingResultApi;
use App\Http\Controllers\restapi\BusinessApi;
use App\Http\Controllers\restapi\CategoryApi;
use App\Http\Controllers\restapi\ClinicApi;
use App\Http\Controllers\restapi\DepartmentApi;
use App\Http\Controllers\restapi\DoctorDepartmentApi;
use App\Http\Controllers\restapi\DoctorInfoApi;
use App\Http\Controllers\restapi\DoctorReviewApi;
use App\Http\Controllers\restapi\MainApi;
use App\Http\Controllers\restapi\MedicalApi;
use App\Http\Controllers\restapi\MedicalResultApi;
use App\Http\Controllers\restapi\NewsApi;
use App\Http\Controllers\restapi\OrderApi;
use App\Http\Controllers\restapi\PharmacyApi;
use App\Http\Controllers\restapi\ProductInfoApi;
use App\Http\Controllers\restapi\ProductMedicineApi;
use App\Http\Controllers\restapi\QrCodeApi;
use App\Http\Controllers\restapi\ReadAddressApi;
use App\Http\Controllers\restapi\ReviewApi;
use App\Http\Controllers\restapi\ShortVideoApi;
use App\Http\Controllers\restapi\SurveyApi;
use App\Http\Controllers\restapi\SymptomsApi;
use App\Http\Controllers\restapi\TopicVideoApi;
use App\Http\Controllers\ui\QuestionApi;
use App\Http\Controllers\ui\TrendingApi;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
|restapi Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::group(['prefix' => 'products'], function () {
    Route::get('/list', [ProductInfoApi::class, 'index'])->name('products.api.list');
    Route::get('/category/{id}', [ProductInfoApi::class, 'getAllByCategory'])->name('products.api.category');
    Route::get('/user/{id}', [ProductInfoApi::class, 'getByUser'])->name('products.api.user');
    Route::get('/detail/{id}', [ProductInfoApi::class, 'getById'])->name('products.api.detail');
    Route::get('/clinics/{id}', [ProductInfoApi::class, 'getByClinic'])->name('products.api.clinics');
    Route::get('/search', [ProductInfoApi::class, 'search'])->name('products.api.search');
    Route::get('/department/{id}', [ProductInfoApi::class, 'findByDepartment'])->name('products.restapi.department');
});

Route::group(['prefix' => 'orders'], function () {
    Route::get('/get-by-user/{id}', [OrderApi::class, 'getAllByUser'])->name('restapi.api.orders.list.user');
    Route::get('/detail/{id}', [OrderApi::class, 'detail'])->name('restapi.api.orders.detail');
    Route::put('/cancel/{id}', [OrderApi::class, 'cancelOrder'])->name('restapi.api.orders.cancel');
});

Route::group(['prefix' => 'business'], function () {
    Route::get('/list', [BusinessApi::class, 'getList'])->name('business.restapi.list');
    Route::get('/search', [BusinessApi::class, 'search'])->name('business.restapi.search');
    Route::get('/filter', [BusinessApi::class, 'searchByDepartmentAndSymptoms'])->name('business.restapi.filter');
});

Route::group(['prefix' => 'medicals'], function () {
    Route::get('/filter', [MedicalApi::class, 'searchByDepartmentAndSymptoms'])->name('medicals.restapi.filter');
    Route::get('/all-filter', [MedicalApi::class, 'searchMedical'])->name('medicals.restapi.all.filter');
});

Route::group(['prefix' => 'clinics'], function () {
    Route::get('/list', [ClinicApi::class, 'getAll'])->name('clinics.restapi.list');
    Route::get('/user/{id}', [ClinicApi::class, 'getAllByUserId'])->name('clinics.restapi.user');
    Route::get('/detail/{id}', [ClinicApi::class, 'detail'])->name('clinics.restapi.detail');
    Route::get('/filter', [ClinicApi::class, 'searchByDepartmentAndSymptoms'])->name('clinics.restapi.department.symptom');
    Route::get('/search', [ClinicApi::class, 'searchClinics'])->name('clinics.restapi.search');
    Route::get('/get-specialist', [ClinicApi::class, 'getAllSpecialist'])->name('clinics.restapi.specialist');
    Route::get('/get-location', [ClinicApi::class, 'getAllLocation'])->name('clinics.restapi.location');
});

Route::group(['prefix' => 'pharmacies'], function () {
    Route::get('/list', [PharmacyApi::class, 'getAll'])->name('pharmacies.restapi.list');
    Route::get('/user/{id}', [PharmacyApi::class, 'getAllByUserId'])->name('pharmacies.restapi.user');
    Route::get('/detail/{id}', [PharmacyApi::class, 'detail'])->name('pharmacies.restapi.detail');
    Route::get('/filter', [PharmacyApi::class, 'searchByDepartmentAndSymptoms'])->name('pharmacies.restapi.department.symptom');
});

Route::group(['prefix' => 'doctors-info'], function () {
    Route::get('/list', [DoctorInfoApi::class, 'getAll'])->name('doctors.info.restapi.list');
    Route::get('/list/doctor24h', [DoctorInfoApi::class, 'getDoctor24h'])->name('doctors.info.restapi.list.getDoctor24h');
    Route::get('/user/{id}', [DoctorInfoApi::class, 'findByUser'])->name('doctors.info.restapi.user');
    Route::get('/department/{id}', [DoctorInfoApi::class, 'findByDepartment'])->name('doctors.info.restapi.department');
    Route::get('/detail/{id}', [DoctorInfoApi::class, 'detail'])->name('doctors.info.restapi.detail');
    Route::get('/my-doctors/{id}', [DoctorInfoApi::class, 'getMyDoctor'])->name('doctors.info.restapi.my.doctor');
    Route::get('/search-doctor', [DoctorInfoApi::class, 'searchDoctor'])->name('api.backend.user.doctor.search');
    Route::get('/find-doctor', [DoctorInfoApi::class, 'findDoctorByKeyword'])->name('restapi.doctor.info.find');
    Route::get('/list-doctor-clinics', [DoctorInfoApi::class, 'getAllDoctorByClinic'])->name('restapi.list.doctor.clinics');
    Route::get('/list-doctor-clinics-department', [DoctorInfoApi::class, 'getDoctorByDepartmentIDAndClinicID'])->name('restapi.list.doctor.clinics.department');
});

Route::group(['prefix' => 'api/doctor-reviews'], function () {
    Route::get('/list', [DoctorReviewApi::class, 'getAll'])->name('api.backend.doctor.reviews.list');
    Route::get('/doctor/{id}', [DoctorReviewApi::class, 'getAllByDoctorID'])->name('api.backend.doctor.reviews.doctor');
    Route::get('/user/{id}', [DoctorReviewApi::class, 'getAllByUserID'])->name('api.backend.doctor.reviews.user');
    Route::get('/detail/{id}', [DoctorReviewApi::class, 'findById'])->name('api.backend.doctor.reviews.detail');
    Route::post('/create', [DoctorReviewApi::class, 'create'])->name('api.backend.doctor.reviews.create');
});

Route::group(['prefix' => 'doctors-departments'], function () {
    Route::get('/list', [DoctorDepartmentApi::class, 'getAll'])->name('doctors.departments.list');
    Route::get('/detail/{id}', [DoctorDepartmentApi::class, 'getById'])->name('doctors.departments.detail');
    Route::get('/user/{id}', [DoctorDepartmentApi::class, 'getAllByUserID'])->name('doctors.departments.user');
});

Route::group(['prefix' => 'api/answers'], function () {
    Route::post('/create', [BackendAnswerController::class, 'create'])->name('answers.api.create');
});

Route::group(['prefix' => 'reviews'], function () {
    Route::get('/list', [ReviewApi::class, 'getAll'])->name('reviews.api.list');
    Route::get('/clinics/{id}', [ReviewApi::class, 'getAllByClinicId'])->name('reviews.api.clinics');
    Route::get('/detail/{id}', [ReviewApi::class, 'detail'])->name('reviews.api.detail');
    Route::post('/create', [ReviewApi::class, 'create'])->name('reviews.api.create');
});

Route::group(['prefix' => 'news'], function () {
    Route::get('/list', [NewsApi::class, 'getAll'])->name('news.api.list');
    Route::get('/users/{id}', [NewsApi::class, 'getAllByUserID'])->name('news.api.users');
    Route::get('/detail/{id}', [NewsApi::class, 'detail'])->name('news.api.detail');
});

Route::group(['prefix' => 'topic-videos'], function () {
    Route::get('/list', [TopicVideoApi::class, 'getAll'])->name('restapi.topic.videos.list');
    Route::get('/users/{id}', [TopicVideoApi::class, 'getAllByUserID'])->name('restapi.topic.videos.users');
    Route::get('/detail/{id}', [TopicVideoApi::class, 'detail'])->name('restapi.topic.videos.detail');
});

Route::group(['prefix' => 'short-videos'], function () {
    Route::get('/list', [ShortVideoApi::class, 'getAll'])->name('restapi.short.videos.list');
    Route::get('/users/{id}', [ShortVideoApi::class, 'getAllByUserID'])->name('restapi.short.videos.users');
    Route::get('/topics/{id}', [ShortVideoApi::class, 'getAllByTopic'])->name('restapi.short.videos.topics');
    Route::get('/detail/{id}', [ShortVideoApi::class, 'detail'])->name('restapi.short.videos.detail');
});

Route::group(['prefix' => 'coupons'], function () {
    Route::get('/list', [BackendCouponController::class, 'getListCouponForUser'])->name('coupons.list');
    Route::get('/detail/{id}', [BackendCouponController::class, 'detail'])->name('coupons.detail');
    Route::get('/code/{id}', [BackendCouponController::class, 'getByCode'])->name('coupons.code');
    Route::get('/user/{id}', [BackendCouponController::class, 'getAllByUserID'])->name('coupons.user');
    Route::get('/search', [BackendCouponController::class, 'search'])->name('coupons.clinic');
});

Route::group(['prefix' => 'api/qr-code'], function () {
    Route::get('/doctor-info/{id}', [QrCodeApi::class, 'doctorInfo'])->name('qr.code.api.show.doctor.info');
});

Route::group(['prefix' => 'categories'], function () {
    Route::get('/list', [CategoryApi::class, 'getAll'])->name('categories.list');
    Route::get('/detail/{id}', [CategoryApi::class, 'detail'])->name('categories.detail');
    Route::get('/user/{id}', [CategoryApi::class, 'getAllByUser'])->name('categories.user');
});

Route::group(['prefix' => 'address'], function () {
    Route::get('/provinces', [ReadAddressApi::class, 'getAllProvince'])->name('restapi.get.provinces');
    Route::get('/districts/{code}', [ReadAddressApi::class, 'getAllDistrictByProvinceCode'])->name('restapi.get.districts');
    Route::get('/communes/{code}', [ReadAddressApi::class, 'getAllCommuneByDistrictCode'])->name('restapi.get.communes');
});

Route::group(['prefix' => 'products-medicines'], function () {
    Route::get('/list', [ProductMedicineApi::class, 'getAllProduct'])->name('restapi.get.products.medicines.list');
    Route::get('/category/{id}', [ProductMedicineApi::class, 'findMedicineByCategory'])->name('restapi.get.products.medicines.category');
    Route::get('/detail/{id}', [ProductMedicineApi::class, 'detail'])->name('restapi.get.products.medicines.detail');
    Route::post('/list-prescriptions', [ProductMedicineApi::class, 'getAllProductByExcelFile'])->name('restapi.products.medicines.prescriptions');
    Route::post('/blade-list-prescriptions', [ProductMedicineApi::class, 'getAllProductByExcelFileBlade'])->name('restapi.products.medicines.prescriptions.blade');
    Route::post('/by-result/{id}', [ProductMedicineApi::class, 'addProductFromExcelFile'])->name('restapi.get.products.medicines.result');
});

Route::group(['prefix' => 'departments'], function () {
    Route::get('/list', [DepartmentApi::class, 'getList'])->name('restapi.departments.list');
    Route::get('/detail/{id}', [DepartmentApi::class, 'detail'])->name('restapi.departments.detail');
    Route::get('/symptoms/{id}', [DepartmentApi::class, 'getBySymptomID'])->name('restapi.departments.symptoms');
    Route::get('/clinics', [DepartmentApi::class, 'getAllByClinic'])->name('restapi.list.departments.clinics');
});

Route::group(['prefix' => 'symptoms'], function () {
    Route::get('/list', [SymptomsApi::class, 'getList'])->name('restapi.symptoms.list');
    Route::get('/detail/{id}', [SymptomsApi::class, 'detail'])->name('restapi.symptoms.detail');
    Route::get('/department/{id}', [SymptomsApi::class, 'getListByDepartment'])->name('restapi.symptoms.department');
});

Route::get('/users/by-role/{role_id}', [\App\Http\Controllers\ProfileController::class, 'getUsersByRoleId'])->name('role.user');
Route::get('/service/{serviceId}', [\App\Http\Controllers\restapi\admin\AminServiceClinicApi::class, 'getServiceById'])->name('service.by.id');

/* Booking result*/
Route::group(['prefix' => 'booking-result'], function () {
    Route::get('/list', [BookingResultApi::class, 'getListByUser'])->name('restapi.booking.result.list');
    Route::get('/list-medicine/{id}', [BookingResultApi::class, 'getProductByPrescriptionsInBookingID'])->name('restapi.booking.result.list.medicine');
    Route::get('/list-business', [BookingResultApi::class, 'getListByBusinessID'])->name('restapi.booking.result.business');
    Route::get('/detail/{id}', [BookingResultApi::class, 'detail'])->name('restapi.booking.result.detail');
});

/* Medical result*/
Route::group(['prefix' => 'medical-results'], function () {
    Route::get('/list', [MedicalResultApi::class, 'getListByUser'])->name('restapi.medical.result.list');
    Route::get('/list-medicine/{id}', [MedicalResultApi::class, 'getProductByPrescriptionsID'])->name('restapi.medical.result.list.medicine');
    Route::get('/detail/{id}', [MedicalResultApi::class, 'detail'])->name('restapi.medical.result.detail');
});

/* Survey api*/
Route::group(['prefix' => 'surveys'], function () {
    Route::get('/list-department/{id}', [SurveyApi::class, 'getAllByDepartment'])->name('restapi.surveys.department');
    Route::get('/detail/{id}', [SurveyApi::class, 'detail'])->name('restapi.surveys.detail');
});

/* Handle auth account*/
Route::group(['prefix' => 'api/account'], function () {
    Route::post('/send-verify-code-reset-token', [AccountApi::class, 'sendCode'])->name('restapi.account.send.verify.code.reset.token');
    Route::post('/reset-token/{id}', [AccountApi::class, 'resetTokenLogin'])->name('restapi.account.handle.reset.token');
});

/* Trending */
Route::group(['prefix' => 'trending'], function () {
    Route::get('/list-department', [TrendingApi::class, 'listDepartment'])->name('restapi.trending.list.department');
    Route::get('/list-topics', [TrendingApi::class, 'listTopicQuestion'])->name('restapi.trending.list.topics');
});

/* Questions */
Route::group(['prefix' => 'questions'], function () {
    Route::get('/list-by-topic', [QuestionApi::class, 'getAllByTopics'])->name('restapi.questions.list.by.topic');
});

/* Only use for app */
Route::group(['prefix' => 'api/mobile/fcm'], function () {
    Route::post('/send', [MainApi::class, 'sendNotificationFcm']);
    Route::post('/send_v2', [MainApi::class, 'sendNotificationWeb']);
});
