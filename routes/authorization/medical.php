<?php


use App\Http\Controllers\backend\BackendAccountRegisterController;
use App\Http\Controllers\backend\BackendAnswerController;
use App\Http\Controllers\backend\BackendCategoryProductController;
use App\Http\Controllers\backend\BackendClinicController;
use App\Http\Controllers\backend\BackendProductInfoController;
use App\Http\Controllers\backend\BackendProductMedicineController;
use App\Http\Controllers\backend\BackendReviewController;
use App\Http\Controllers\backend\BackendServiceClinicController;
use App\Http\Controllers\backend\BackendStaffController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\ClinicController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\DoctorInfoController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductInfoController;
use App\Http\Controllers\restapi\admin\AdminBookingApi;
use App\Http\Controllers\restapi\admin\AdminBookingResultApi;
use App\Http\Controllers\restapi\admin\AdminDepartmentApi;
use App\Http\Controllers\restapi\admin\AdminDoctorDepartmentApi;
use App\Http\Controllers\restapi\admin\AdminDoctorInfoApi;
use App\Http\Controllers\restapi\admin\AdminDoctorReviewApi;
use App\Http\Controllers\restapi\admin\AdminMedicalResultApi;
use App\Http\Controllers\restapi\admin\AdminNewsApi;
use App\Http\Controllers\restapi\admin\AdminOrderApi;
use App\Http\Controllers\restapi\admin\AdminPhamacitisApi;
use App\Http\Controllers\restapi\admin\AdminPharmacyApi;
use App\Http\Controllers\restapi\admin\AdminShortVideoApi;
use App\Http\Controllers\restapi\admin\AdminSymptomsApi;
use App\Http\Controllers\restapi\ui\MyMedicalApi;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\StaffController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Medical Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
