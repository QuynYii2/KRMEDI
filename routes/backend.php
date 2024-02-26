<?php

use App\Http\Controllers\backend\BackendCouponApplyController;
use App\Http\Controllers\backend\BackendCouponController;
use App\Http\Controllers\backend\BackendQuestionController;
use App\Http\Controllers\connect\AgoraChatController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\restapi\AddressApi;
use App\Http\Controllers\restapi\AnswerLikeApi;
use App\Http\Controllers\restapi\BookingApi;
use App\Http\Controllers\restapi\BusinessFavouriteApi;
use App\Http\Controllers\restapi\CartApi;
use App\Http\Controllers\restapi\CheckoutApi;
use App\Http\Controllers\restapi\MainApi;
use App\Http\Controllers\restapi\MedicalFavouriteApi;
use App\Http\Controllers\restapi\MessageApi;
use App\Http\Controllers\restapi\PrescriptionResultApi;
use App\Http\Controllers\restapi\ServiceClinicApi;
use App\Http\Controllers\restapi\SocialUserApi;
use App\Http\Controllers\restapi\ui\MyBusinessApi;
use App\Http\Controllers\restapi\UserApi;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'users'], function () {
    Route::get('/list-points', [UserApi::class, 'getUserByPoint'])->name('api.backend.user.list.points');
    Route::post('/update-profile', [UserApi::class, 'updateProfile'])->name('api.backend.user.update.profile');
    Route::post('/change-info', [UserApi::class, 'changeInformation'])->name('api.backend.user.change.information');
    Route::post('/change-email', [UserApi::class, 'changeEmail'])->name('api.backend.user.change.email');
    Route::post('/change-phone', [UserApi::class, 'changePhoneNumber'])->name('api.backend.user.change.phone');
    Route::post('/change-password', [UserApi::class, 'changePassword'])->name('api.backend.user.change.password');
    Route::post('/change-avatar', [UserApi::class, 'changeAvt'])->name('api.backend.user.change.avatar');
});

Route::group(['prefix' => 'users-social'], function () {
    Route::post('modify', [SocialUserApi::class, 'createOrEdit'])->name('user.social.update');
    Route::get('list-social/{id}', [SocialUserApi::class, 'getSocialByUserId'])->name('list-social');
});

Route::group(['prefix' => 'questions'], function () {
    Route::get('/list', [BackendQuestionController::class, 'getAll'])->name('api.backend.questions.list');
    Route::get('/user/{id}', [BackendQuestionController::class, 'getAllByUserId'])->name('api.backend.questions.user');
    Route::post('/create', [BackendQuestionController::class, 'create'])->name('api.backend.questions.create');
    Route::put('/change/{id}',
        [BackendQuestionController::class, 'upgradeStatus'])->name('api.backend.questions.change.status');
    Route::put('/update/{id}', [BackendQuestionController::class, 'update'])->name('api.backend.questions.update');
    Route::delete('/delete/{id}', [BackendQuestionController::class, 'delete'])->name('api.backend.questions.delete');
});

Route::group(['prefix' => 'coupons-apply'], function () {
    Route::get('/list', [BackendCouponApplyController::class, 'getAll'])->name('api.backend.coupons-apply.list');
    Route::get('/detail/{id}',
        [BackendCouponApplyController::class, 'detail'])->name('api.backend.coupons-apply.detail');
    Route::get('/user/{id}',
        [BackendCouponApplyController::class, 'getAllByUser'])->name('api.backend.coupons-apply.user');
    Route::post('/create', [BackendCouponApplyController::class, 'create'])->name('api.backend.coupons-apply.create');
    Route::put('/update/{id}',
        [BackendCouponApplyController::class, 'update'])->name('api.backend.coupons-apply.update');
    Route::delete('/delete/{id}',
        [BackendCouponApplyController::class, 'delete'])->name('api.backend.coupons-apply.delete');
    Route::get('/my-coupons',
        [BackendCouponApplyController::class, 'listMyCoupons'])->name('api.backend.coupons-apply.my.coupon');
    Route::post('change-status',
        [BackendCouponApplyController::class, 'updateStatus'])->name('api.backend.coupons-apply.update-status');
    Route::post('checking', [MainApi::class, 'checkCoupon']);
});

Route::group(['prefix' => 'coupons'], function () {
    Route::get('/list/{type?}', [BackendCouponController::class, 'getAll'])->name('api.backend.coupons.list');
    Route::post('/create', [BackendCouponController::class, 'create'])->name('api.backend.coupons.create');
    Route::post('/update/{id}', [BackendCouponController::class, 'update'])->name('api.backend.coupons.update');
    Route::delete('/delete/{id}', [BackendCouponController::class, 'delete'])->name('api.backend.coupons.delete');
    Route::get('get-applied/{user_id?}/{status?}', [CouponController::class, 'getListCouponApplied'])->name('coupon.get.applied');
});

Route::group(['prefix' => 'service-clinics'], function () {
    Route::get('list', [ServiceClinicApi::class, 'getAll'])->name('api.backend.service.clinic.list');
    Route::get('list-by-clinics/{id}',
        [ServiceClinicApi::class, 'getAllByClinics'])->name('api.backend.service.clinic.list.clinics');
    Route::get('list-by-user/{id}',
        [ServiceClinicApi::class, 'getAllByUserId'])->name('api.backend.service.clinic.list.user');
    Route::get('detail/{id}', [ServiceClinicApi::class, 'detail'])->name('api.backend.service.clinic.detail');
    Route::post('create', [ServiceClinicApi::class, 'create'])->name('api.backend.service.clinic.create');
});

Route::group(['prefix' => 'business-favourites'], function () {
    Route::get('list-by-users', [BusinessFavouriteApi::class, 'getAll'])->name('api.backend.business.favourites.list');
    Route::get('list-clinics-by-users', [BusinessFavouriteApi::class, 'getAllClinicsByUser'])->name('api.backend.business.favourites.clinics');
    Route::get('list-by-business',
        [BusinessFavouriteApi::class, 'findByUserIdAndBusinessID'])->name('api.backend.business.favourites.business');
    Route::post('create', [BusinessFavouriteApi::class, 'create'])->name('api.backend.business.favourites.create');
    Route::delete('delete/{id}',
        [BusinessFavouriteApi::class, 'delete'])->name('api.backend.business.favourites.delete');
});

Route::group(['prefix' => 'medical-favourites'], function () {
    Route::get('list-by-users', [MedicalFavouriteApi::class, 'getAll'])->name('api.backend.medical.favourites.list');
    Route::get('list-by-medical', [MedicalFavouriteApi::class, 'findByUserIdAndMedicalID'])->name('api.backend.medical.favourites.medical');
    Route::post('create', [MedicalFavouriteApi::class, 'create'])->name('api.backend.medical.favourites.create');
    Route::delete('delete/{id}', [MedicalFavouriteApi::class, 'delete'])->name('api.backend.medical.favourites.delete');
    Route::post('update-wishlist', [MedicalFavouriteApi::class, 'updateWishListMedical'])->name('api.backend.medical.favourites.update.wishlist');
});

Route::group(['prefix' => 'booking'], function () {
    Route::get('list-users/{id}/{status}', [BookingApi::class, 'getAllBookingByUserId'])->name('api.booking.list.users');
    Route::get('list-clinics/{id}', [BookingApi::class, 'getAllBookingByClinicID'])->name('api.booking.list.clinics');
    Route::post('create', [BookingApi::class, 'createBooking'])->name('api.user.createBooking');
    Route::post('cancel/{id}', [BookingApi::class, 'cancelBooking'])->name('api.backend.booking.cancel');
    Route::get('list-reason', [BookingApi::class, 'getListReason'])->name('api.backend.booking.list.reason');
});

Route::group(['prefix' => 'messages'], function () {
    Route::post('/create', [MessageApi::class, 'create'])->name('api.backend.messages.create');
});

/* Cart api */
Route::group(['prefix' => 'carts'], function () {
    Route::get('user/{id}', [CartApi::class, 'showCartByUserID'])->name('api.backend.cart.user');
    Route::post('create', [CartApi::class, 'addToCart'])->name('api.backend.cart.create');
    Route::post('change-quantity/{id}', [CartApi::class, 'changeQuantityCart'])->name('api.backend.cart.change.quantity');
    Route::delete('delete/{id}', [CartApi::class, 'deleteCart'])->name('api.backend.cart.delete');
    Route::delete('clear/{id}', [CartApi::class, 'clearCart'])->name('api.backend.cart.clear');
});

/* Checkout api */
Route::group(['prefix' => 'checkout'], function () {
    Route::post('imm', [CheckoutApi::class, 'checkoutByImm']);
    Route::post('calc-discount', [CheckoutApi::class, 'calcDiscount']);
    Route::get('return-vnpay', [CheckoutApi::class, 'returnCheckoutVNPay']);
    Route::get('calc-points', [CheckoutApi::class, 'showPoint'])->name('api.backend.checkout.calc.points');
});

/* Address api */
Route::group(['prefix' => 'address-order'], function () {
    Route::get('user/{id}', [AddressApi::class, 'getListByUserID'])->name('api.backend.address.order.user');
    Route::get('detail/{id}', [AddressApi::class, 'detail'])->name('api.backend.address.order.detail');
    Route::get('default', [AddressApi::class, 'getAddressDefault'])->name('api.backend.address.order.default');
    Route::post('create', [AddressApi::class, 'create'])->name('api.backend.address.order.create');
    Route::put('update/{id}', [AddressApi::class, 'update'])->name('api.backend.address.order.update');
    Route::delete('delete/{id}', [AddressApi::class, 'delete'])->name('api.backend.address.order.delete');
});

/* Mentoring api */
Route::group(['prefix' => 'mentorings'], function () {
    Route::post('like-answer', [AnswerLikeApi::class, 'handleLikeOrDislike'])->name('api.backend.like.answer');
});

/* Prescription result api */
Route::group(['prefix' => 'prescription-result'], function () {
    Route::get('list', [PrescriptionResultApi::class, 'listPrescription'])->name('api.backend.prescription.result.list');
    Route::get('user', [PrescriptionResultApi::class, 'listPrescriptionByUser'])->name('api.backend.prescription.result.user');
    Route::get('doctor', [PrescriptionResultApi::class, 'listPrescriptionByDoctor'])->name('api.backend.prescription.result.doctor');
    Route::post('create', [PrescriptionResultApi::class, 'createPrescription'])->name('api.backend.prescription.result.create');
    Route::post('upload', [PrescriptionResultApi::class, 'uploadExcelFile'])->name('api.backend.prescription.result.upload');
    Route::post('export', [PrescriptionResultApi::class, 'exportAndDownload'])->name('api.backend.prescription.result.export');
    Route::post('add-to-cart', [PrescriptionResultApi::class, 'addProductToCart'])->name('api.backend.prescription.result.add.cart');
    Route::post('add-to-cart-v2', [PrescriptionResultApi::class, 'addProductToCartV2'])->name('api.backend.prescription.result.add.cart.v2');
});

Route::get("connect/video/agora/get-token-app", [AgoraChatController::class, 'getInfoAgoraForApp'])->name("agora.get-token-app");
Route::get("connect/video/agora/get-push-token-user", [AgoraChatController::class, 'getPushTokenByUser'])->name("agora.get-token-app-user");
