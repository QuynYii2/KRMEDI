<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\AddressController;
use App\Http\Controllers\AddressMapController;
use App\Http\Controllers\admin\AdminMedicalResultController;
use App\Http\Controllers\admin\OrderController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AuthSocialController;
use App\Http\Controllers\backend\BackendProductInfoController;
use App\Http\Controllers\backend\BackendQuestionController;
use App\Http\Controllers\backend\BackendWishListController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\BookingResultController;
use App\Http\Controllers\CalcViewQuestionController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ClinicController;
use App\Http\Controllers\connect\AgoraChatController;
use App\Http\Controllers\connect\CallVideoController;
use App\Http\Controllers\connect\ChatMessageController;
use App\Http\Controllers\connect\WidgetChatController;
use App\Http\Controllers\DoctorInfoController;
use App\Http\Controllers\DoctorReviewController;
use App\Http\Controllers\DownloadController;
use App\Http\Controllers\ExaminationController;
use App\Http\Controllers\FleaMarketController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ImportController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\MapController;
use App\Http\Controllers\MedicalResultController;
use App\Http\Controllers\MedicineController;
use App\Http\Controllers\NewEventController;
use App\Http\Controllers\PharmaciesController;
use App\Http\Controllers\ProductInfoController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RecruitmentController;
use App\Http\Controllers\restapi\BookingApi;
use App\Http\Controllers\restapi\MainApi;
use App\Http\Controllers\restapi\UserApi;
use App\Http\Controllers\ReviewStoreController;
use App\Http\Controllers\ServiceClinicController;
use App\Http\Controllers\ShortVideoController;
use App\Http\Controllers\SurveyController;
use App\Http\Controllers\SymptomController;
use App\Http\Controllers\TopicVideoController;
use App\Http\Controllers\ui\MyBookingController;
use App\Http\Controllers\ui\MyCouponController;
use App\Http\Controllers\ui\MyFavouriteController;
use App\Http\Controllers\ui\PrescriptionResultController;
use App\Http\Controllers\ui\UserController;
use App\Http\Controllers\WhatFreeToDay;
use App\Http\Controllers\ZaloController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::middleware(['user.active'])->group(function () {
    Route::get('/lang/{locale}', [MainController::class, 'setLanguage'])->name('language');
    Route::get('test-noti', [\App\Http\Controllers\AlertNotificationController::class, 'pushNoti'])->name('noti.push');

    Route::get('/', 'HomeController@index')->name('home');
    Route::group(['prefix' => 'home'], function () {
        Route::get('/specialist', [HomeController::class, 'specialist'])->name('home.specialist');
        Route::get('/specialist/{id}', [HomeController::class, 'specialistDepartment'])->name('home.specialist.department');
        Route::get('/specialist-detail/{id}', [HomeController::class, 'specialistDetail'])->name('home.specialist.detail');
        Route::get('/booking-detail/{id}', [HomeController::class, 'bookingDetailSpecialist'])->name('home.specialist.booking.detail');
        Route::post('/specialist-review/{id}', [HomeController::class, 'specialistReview'])->name('home.specialist.review');

    });

    Route::post('/login', [AuthController::class, 'login'])->name('loginProcess');
    Route::post('/register', [AuthController::class, 'register'])->name('registerProcess');
    Route::get('/logout', [AuthController::class, 'logout'])->name('logoutProcess');

    /* Start login social */
    /* Google */
    Route::get('/login-google', [AuthSocialController::class, 'getGoogleSignInUrl'])->name('login.google');
    Route::get('/login-google-callback', [AuthSocialController::class, 'loginCallback'])->name('login.google.callback');
    /* Facebook */
    Route::get('/login-facebook', [AuthSocialController::class, 'getFacebookSignInUrl'])->name('login.facebook');
    Route::get('/login-facebook-callback', [AuthSocialController::class, 'loginFacebookCallback'])->name('login.facebook.callback');
    /* KakaoTalk */
    Route::get('/login-kakao', [AuthSocialController::class, 'getKakaoSignInUrl'])->name('login.kakao');
    Route::get('/login-kakao-callback', [AuthSocialController::class, 'loginKakaoCallback'])->name('login.facebook.kakao');

    Route::get('/login-role', [AuthSocialController::class, 'chooseRole'])->name('login.social.choose.role');
    /* End login social */

    Route::post('forget-password/send',
        [ProfileController::class, 'handleForgetPassword'])->name('user.forget.password.send');
    Route::post('forget-password/check', [ProfileController::class, 'checkOTP'])->name('user.forget.password.check');
    Route::post('check-valid-otp', [ProfileController::class, 'checkValidOTP'])->name('user.forget.password.check.valid.otp');
    Route::post('change-password', [ProfileController::class, 'changePassword'])->name('user.forget.password.change.password');

    /* Need help? */
    Route::group(['prefix' => 'need-helps'], function () {
        Route::get('/home', [AccountController::class, 'needHelp'])->name('need.helps.home');
        Route::get('/account', [AccountController::class, 'accountHelp'])->name('need.helps.account');
        Route::get('/reset-device', [AccountController::class, 'resetToken'])->name('need.helps.account.token');
        Route::get('/verify-code/{id}', [AccountController::class, 'verifyCodeToken'])->name('need.helps.account.verify.code');
    });

    /* */
    Route::group(['prefix' => 'news-events'], function () {
        Route::get('', [NewEventController::class, 'index'])->name('index.new');
        Route::get('detail/{id}', [NewEventController::class, 'detail'])->name('detail.new');
    });
    Route::group(['prefix' => 'recruitment'], function () {
        Route::get('/index', [RecruitmentController::class, 'index'])->name('recruitment.index');
        Route::get('/apply', [RecruitmentController::class, 'apply'])->name('recruitment.apply');
        Route::get('/add-cv', [RecruitmentController::class, 'addCv'])->name('recruitment.add.cv');
        Route::get('/detail', [RecruitmentController::class, 'detail'])->name('recruitment_detail');
        Route::get('/edit-cv', [RecruitmentController::class, 'editCv'])->name('recruitment.edit.cv');
    });

    Route::group(['prefix' => 'wish-lists'], function () {
        Route::get('/list', [BackendWishListController::class, 'getAll'])->name('api.backend.wish.lists.list');
        Route::get('/users', [BackendWishListController::class, 'getAllByUserID'])->name('api.backend.wish.lists.users');
        Route::get('/detail/{id}', [BackendWishListController::class, 'detail'])->name('api.backend.wish.lists.detail');
        Route::post('/create', [BackendWishListController::class, 'create'])->name('api.backend.wish.lists.create');
        Route::POST('/update/{id}',
            [BackendWishListController::class, 'update'])->name('api.backend.wish.lists.update');
        Route::POST('/update-medical',
            [BackendWishListController::class, 'updateMedical'])->name('api.backend.wish.lists.medical.update');
        Route::get('/reget',
            [BackendWishListController::class, 'reGet'])->name('api.backend.wish.lists.reGet');
        Route::delete('/delete/{id}',
            [BackendWishListController::class, 'delete'])->name('api.backend.wish.lists.delete');
        Route::delete('/delete-list',
            [BackendWishListController::class, 'deleteMultil'])->name('api.backend.wish.lists.delete.listId');
    });

    Route::group(['prefix' => 'examination'], function () {
        Route::get('/index', [ExaminationController::class, 'index'])->name('examination.index');
        Route::get('/doctor-info/{id}', [ExaminationController::class, 'infoDoctor'])->name('examination.doctor_info');
        Route::get('/chat-with-doctor/{id}',
            [ExaminationController::class, 'chatWithDoctor'])->name('examination.doctor_info.chat');
        Route::get('/best-doctor', [ExaminationController::class, 'bestDoctor'])->name('examination.best_doctor');
        Route::get('/new-doctor', [ExaminationController::class, 'newDoctor'])->name('examination.new_doctor');
        Route::get('/available-doctor',
            [ExaminationController::class, 'availableDoctor'])->name('examination.available_doctor');
        Route::get('/find-my-medicine',
            [ExaminationController::class, 'findMyMedicine'])->name('examination.findmymedicine');
        Route::get('/best-pharmacists',
            [ExaminationController::class, 'bestPharmacists'])->name('examination.bestpharmacists');
        Route::get('/new-pharmacists',
            [ExaminationController::class, 'newPharmacists'])->name('examination.newpharmacists');
        Route::get('/available-pharmacists',
            [ExaminationController::class, 'availablePharmacists'])->name('examination.availablepharmacists');
        Route::get('/hot-deal-medicine',
            [ExaminationController::class, 'hotDealMedicine'])->name('examination.hotdealmedicine');
        Route::get('/new-medicine', [ExaminationController::class, 'newMedicine'])->name('examination.newmedicine');
        Route::get('/recommended', [ExaminationController::class, 'recommended'])->name('examination.recommended');
        Route::get('/category/{id}',
            [ExaminationController::class, 'findByCategory'])->name('examination.findByCategory');
        Route::get('/my-personal-doctor',
            [ExaminationController::class, 'myPersonalDoctor'])->name('examination.mypersonaldoctor');
    });

    Route::group(['prefix' => 'questions'], function () {
        Route::get('/get-list', [BackendQuestionController::class, 'custom_getlist'])->name('questions.custome.list');
        Route::get('/list/{id}', [BackendQuestionController::class, 'getListQuestion'])->name('questions.list.filter');
        Route::get('/user-id/{id}', [BackendQuestionController::class, 'getQuestionByUserId'])->name('questions.list.userid');
        Route::get('/detail/{id}', [BackendQuestionController::class, 'detail'])->name('api.backend.questions.detail');
        Route::get('/{userId}/{categoryId}', [BackendQuestionController::class, 'getQuestionByUserIdAndCategoryId'])->name('questions.list.userid.categoryId');
    });

    Route::group(['prefix' => 'pharmacies'], function () {
        Route::get('/list-pharmacies', [PharmaciesController::class, 'index'])->name('api.pharmacies.list');
        Route::get('/detail-pharmacies/{id}',
            [PharmaciesController::class, 'detailPharmacies'])->name('api.pharmacies.detail');
    });

    Route::group(['prefix' => 'mentoring'], function () {
        Route::get('', [ExaminationController::class, 'mentoring'])->name('examination.mentoring');
        Route::get('detail/{id}', [ExaminationController::class, 'showMentoring'])->name('examination.mentoring.show');
        Route::post('search', [ExaminationController::class, 'searchMentoring'])->name('examination.mentoring.search');
        Route::get('/ask-a-question',
            [ExaminationController::class, 'createMentoring'])->name('examination.mentoring.create');
        Route::get('/calc-view-comment/{id}',
            [CalcViewQuestionController::class, 'calcView'])->name('examination.mentoring.calc.view');
    });

    Route::group(['prefix' => 'medicine'], function () {
        Route::get('/', [MedicineController::class, 'index'])->name('medicine');
        Route::get('/detail/{id}', [MedicineController::class, 'detail'])->name('medicine.detail');
        Route::get('/wish-list', [MedicineController::class, 'wishList'])->name('medicine.wishList');
        Route::get('search', [MedicineController::class, 'searchOnlineMedicine'])->name('medicine.search');
        Route::post('list', [MedicineController::class, 'searchOnlineMedicineNoPaginate'])->name('medicine.list');
        Route::get('list/{id}', [MedicineController::class, 'getIngredientsByMedicineId'])->name('medicine.get-ingredients-by-medicine-id');
        Route::post('get-name-location',
            [MedicineController::class, 'getLocationByUserId'])->name('medicine.get.name.location.by.user');

    });

    Route::group(['prefix' => 'clinic'], function () {
        Route::get('/', [ClinicController::class, 'index'])->name('clinic');
        Route::get('/detail/{id}', [ClinicController::class, 'detail'])->name('clinic.detail');
        Route::post('/create', [ClinicController::class, 'store'])->name('clinic.booking.store');
        Route::get('/showNear/{id}', [ClinicController::class, 'showNear'])->name('clinic.booking.showNear');

    });
    Route::group(['prefix' => 'product'], function () {
        Route::get('/lists', [BackendProductInfoController::class, 'index'])->name('backend.products.list');
        Route::get('/search', [BackendProductInfoController::class, 'search'])->name('backend.products.search');
    });

    Route::group(['prefix' => 'booking'], function () {
        Route::get('/lists', [BookingController::class, 'index'])->name('booking.list.by.user');
        Route::get('/booking-detail/{id}', [BookingController::class, 'detailBooking'])->name('booking.detail.by.user');
        Route::get('/results-detail/{id}', [BookingController::class, 'resultsDetail'])->name('clinic.detail.results');
        Route::get('/list-by-users/{id}/{status}', [BookingApi::class, 'getAllBookingByUserId'])->name('booking.list.users');
        Route::get('/detail/{id}', [BookingApi::class, 'detail'])->name('restapi.booking.detail');;
        Route::get('/search', [BackendProductInfoController::class, 'search'])->name('backend.booking.search');
        Route::get('get-all-booking/{id?}', [BookingApi::class, 'getAllBooking'])->name('api.user.booking.get-all');
        Route::post('create-bookingNew', [BookingController::class, 'creatBookingNew'])->name('booking.create.new');
    });

    Route::get('/policy', [AddressMapController::class, 'policy'])->name('policy.index');

    Route::post('/save-address', [AddressMapController::class, 'store']);

    Route::group(['prefix' => 'flea-market'], function () {
        Route::get('/', [FleaMarketController::class, 'index'])->name('flea-market.index');
        Route::get('wish-list-flea-market', [FleaMarketController::class, 'wishList'])->name('flea.market.wish.list');
        Route::get('my-store', [FleaMarketController::class, 'myStore'])->name('flea.market.my.store');
        Route::get('review', [FleaMarketController::class, 'review'])->name('flea.market.review');
        Route::get('sell-product', [FleaMarketController::class, 'sellProduct'])->name('flea.market.sell.product');
        Route::get('edit-product/{id}', [FleaMarketController::class, 'editProduct'])->name('flea.market.edit.product');
        Route::get('product-detail/{id}',
            [FleaMarketController::class, 'productDetail'])->name('flea.market.product.detail');
        Route::get('shop-info/{id}', [FleaMarketController::class, 'ShopInfo'])->name('flea.market.product.shop.info');
        Route::get('review-store',
            [ReviewStoreController::class, 'ReviewStore'])->name('flea.market.product.review.store');
        Route::get('create-review-store',
            [ReviewStoreController::class, 'createReviewStore'])->name('flea.market.product.create.review.store');
        Route::post('create-review/{id}',
            [ReviewStoreController::class, 'createReview'])->name('flea.market.product.create.review');

    });
    Route::group(['prefix' => 'what-free'], function () {
        Route::get('/', [WhatFreeToDay::class, 'index'])->name('what.free');
        Route::get('/to-day', [WhatFreeToDay::class, 'toDay'])->name('what.free.to.day');
        Route::get('/wit-mission', [WhatFreeToDay::class, 'withMission'])->name('what.free.with.mission');
        Route::get('/discounted-sevice',
            [WhatFreeToDay::class, 'discountedSevice'])->name('what.free.discounted.service');
        Route::get('/detail/{id}', [WhatFreeToDay::class, 'detail'])->name('what.free.detail');
        Route::get('/campaign', [WhatFreeToDay::class, 'campaign'])->name('what.free.campaign');

        Route::get('/see-all/{type}', [WhatFreeToDay::class, 'seeAll'])->name('what.free.see.all');
        Route::get('/reply/{id}', [WhatFreeToDay::class, 'replyLink'])->name('what.free.reply.link')->middleware('signed');
        Route::post('/reply-link/{id}', [WhatFreeToDay::class, 'replyLinkSocial'])->name('what.free.reply.link.social');
    });

    Route::middleware(['auth'])->group(function () {
        Route::get('web/home', [HomeController::class, 'admin'])->name('admin.home');

        Route::get('web/chat-unseen', [HomeController::class, 'listMessageUnseen'])->name('admin.list.chat.unseen');

        Route::post('/save-user-login-social',
            [AuthSocialController::class, 'saveUser'])->name('save.user.login.social');

        Route::get('profile', [ProfileController::class, 'index'])->name('profile');
        Route::put('profile-update', [ProfileController::class, 'update'])->name('profile.update');

        Route::group(['prefix' => 'categories'], function () {
            Route::get('admin/list', [CategoryController::class, 'index'])->name('view.admin.category.index');
            Route::get('admin/create', [CategoryController::class, 'create'])->name('view.admin.category.create');
            Route::get('admin/detail/{id}', [CategoryController::class, 'detail'])->name('view.admin.category.detail');
        });

        Route::group(['prefix' => 'checkout'], function () {
            Route::get('/', [CheckoutController::class, 'index'])->name('user.checkout.index');
            Route::get('/return-checkout',
                [CheckoutController::class, 'returnCheckout'])->name('return.checkout.payment');
            Route::post('/imm', [CheckoutController::class, 'checkoutByImm'])->name('user.checkout.imm');
            Route::post('/vnpay', [CheckoutController::class, 'checkoutByVNPay'])->name('user.checkout.vnpay');
        });

        Route::group(['prefix' => 'web/orders'], function () {
            Route::get('/list', [\App\Http\Controllers\OrderController::class, 'index'])->name('view.web.orders.index');
        });

        Route::group(['prefix' => 'orders'], function () {
            Route::get('admin/list_medicine', [OrderController::class, 'index'])->name('view.admin.orders.index');
            Route::get('admin/list_market', [OrderController::class, 'list'])->name('view.admin.orders.list');
            Route::get('admin/detail/{id}', [OrderController::class, 'detail'])->name('view.admin.orders.detail');
        });

        Route::group(['prefix' => 'short-video'], function () {
            Route::get('show', [ShortVideoController::class, 'showVideo'])->name('short.videos.show');
            Route::get('show/{id}', [ShortVideoController::class, 'detail'])->name('short.videos.item');
        });

        Route::group(['prefix' => 'reviews-doctor'], function () {
            Route::get('admin/list', [DoctorReviewController::class, 'index'])->name('view.reviews.doctor.index');
            Route::get('admin/detail/{id}',
                [DoctorReviewController::class, 'detail'])->name('view.reviews.doctor.detail');
        });

        Route::group(['prefix' => 'service-clinics'], function () {
            Route::get('list', [ServiceClinicController::class, 'getListService'])->name('user.service.clinics.list');
            Route::get('detail/{id}',
                [ServiceClinicController::class, 'detailService'])->name('user.service.clinics.detail');
            Route::get('create',
                [ServiceClinicController::class, 'createService'])->name('user.service.clinics.create');
        });

        Route::group(['prefix' => 'topics-videos'], function () {
            Route::get('list', [TopicVideoController::class, 'getList'])->name('user.topic.videos.list');
            Route::get('detail/{id}', [TopicVideoController::class, 'detail'])->name('user.topic.videos.detail');
            Route::get('create', [TopicVideoController::class, 'create'])->name('user.topic.videos.create');
        });

        Route::group(['prefix' => 'symptom'], function () {
            Route::get('list', [SymptomController::class, 'index'])->name('symptom.index');
            Route::get('create', [SymptomController::class, 'create'])->name('symptom.create');
            Route::post('store', [SymptomController::class, 'store'])->name('symptom.store');
            Route::get('edit/{id}', [SymptomController::class, 'edit'])->name('symptom.edit');
            Route::post('update/{id}', [SymptomController::class, 'update'])->name('symptom.update');
        });

        Route::group(['prefix' => 'connect'], function () {
            Route::group(['prefix' => 'video'], function () {
                Route::get('index3', [CallVideoController::class, 'index3'])->name('api.backend.connect.video.index3');

                Route::post("/createMeeting", [CallVideoController::class, 'createMeeting'])->name("createMeeting");

                Route::post("/validateMeeting",
                    [CallVideoController::class, 'validateMeeting'])->name("validateMeeting");

                Route::get("/handle-change-status-download-record/{roomName}",
                    [CallVideoController::class, 'changeStatusQueueDownloadRecord'])->name("download.change.status");

                Route::get("/meeting/{meetingId}", function ($meetingId) {

                    $METERED_DOMAIN = env('METERED_DOMAIN');
                    return view('admin.connect.video.meeting', [
                        'METERED_DOMAIN' => $METERED_DOMAIN,
                        'MEETING_ID' => $meetingId
                    ]);
                })->name('joinMeeting');


                Route::get("/agora/test", [AgoraChatController::class, 'index'])->name('agora.index');
                Route::post("agora/createMeeting", [AgoraChatController::class, 'createMeeting'])->name("agora.createMeeting");
                Route::post("/agora/call", [AgoraChatController::class, 'handleCallVideo'])->name('agora.call');
                Route::get("agora/joinMeeting", [AgoraChatController::class, 'joinMeeting'])->name("agora.joinMeeting");
                Route::get("agora/update-token", [AgoraChatController::class, 'saveTokenByUserId'])->name("agora.update-token");

            });

            Route::group(['prefix' => 'chat'], function () {
                Route::get('index', [ChatMessageController::class, 'index'])->name('api.backend.connect.chat.index');

                Route::get('getListUserWasConnect', [
                    WidgetChatController::class,
                    'getListUserWasConnect'
                ])->name('api.backend.connect.chat.getListUserWasConnect');
                Route::get('getMessageByUserId/{id}', [
                    WidgetChatController::class,
                    'getMessageByUserId'
                ])->name('api.backend.connect.chat.getMessageByUserId');
                Route::get('seen-message/{id}',
                    [WidgetChatController::class, 'handleSeenMessage'])->name('api.backend.connect.chat.seen-message');
            });
        });
        /* User view points */
        Route::group(['prefix' => 'users-points'], function () {
            Route::get('list', [UserController::class, 'listRatingUser'])->name('web.users.list.points');
        });

        /*  User blade */
        /* My booking */
        Route::group(['prefix' => 'my-bookings'], function () {
            Route::get('list', [MyBookingController::class, 'listBooking'])->name('web.users.my.bookings.list');
            Route::get('detail/{id}', [MyBookingController::class, 'detailBooking'])->name('web.users.my.bookings.detail');
            Route::get('result/{id}', [MyBookingController::class, 'bookingResult'])->name('web.users.my.bookings.result');
            Route::get('list-products/{id}', [MyBookingController::class, 'listProductResult'])->name('web.users.my.bookings.products');
        });

        /* My coupons */
        Route::group(['prefix' => 'my-coupons'], function () {
            Route::get('list', [MyCouponController::class, 'listMyCoupons'])->name('web.users.my.coupons.list');
        });

        /* My favourite */
        Route::group(['prefix' => 'my-favourite'], function () {
            Route::get('businesses', [MyFavouriteController::class, 'businessFavourite'])->name('web.users.my.favourite.businesses');
            Route::get('medicals', [MyFavouriteController::class, 'medicalFavourite'])->name('web.users.my.favourite.medicals');
            Route::get('products', [MyFavouriteController::class, 'productFavourite'])->name('web.users.my.favourite.products');
        });

        /*  Admin blade */
        /* Booking result */
        Route::group(['prefix' => 'web/booking-result'], function () {
            Route::get('/list/{id}', [BookingResultController::class, 'getList'])->name('web.booking.result.list');
            Route::get('/detail/{id}', [BookingResultController::class, 'detail'])->name('web.booking.result.detail');
            Route::get('/list-prescriptions/{id}', [BookingResultController::class, 'getListProduct'])->name('web.booking.result.list.prescriptions');
        });

        /* Medical result */
        Route::group(['prefix' => 'web/medical-result'], function () {
            Route::get('/list', [MedicalResultController::class, 'list'])->name('web.medical.result.list');
            Route::get('/detail/{id}', [MedicalResultController::class, 'detail'])->name('web.medical.result.detail');
        });

        /* Surveys */
        Route::group(['prefix' => 'surveys'], function () {
            Route::get('medical/list', [SurveyController::class, 'getList'])->name('view.admin.surveys.index');
            Route::get('medical/detail/{id}', [SurveyController::class, 'detail'])->name('view.admin.surveys.detail');
            Route::get('medical/create', [SurveyController::class, 'create'])->name('view.admin.surveys.create');
        });

        /* Address order */
        Route::group(['prefix' => 'address'], function () {
            Route::get('list', [AddressController::class, 'getList'])->name('view.user.address.list');
            Route::get('detail/{id}', [AddressController::class, 'detail'])->name('view.user.address.detail');
            Route::get('create', [AddressController::class, 'create'])->name('view.user.address.create');
        });

        /* Admin medical result */
        Route::group(['prefix' => 'medical-result'], function () {
            Route::get('list', [AdminMedicalResultController::class, 'list'])->name('view.admin.medical.result.list');
            Route::get('detail/{id}', [AdminMedicalResultController::class, 'detail'])->name('view.admin.medical.result.detail');
            Route::get('create', [AdminMedicalResultController::class, 'create'])->name('view.admin.medical.result.create');
        });

        Route::group(['prefix' => 'ui/prescription-result'], function () {
            Route::get('my-list', [PrescriptionResultController::class, 'myPrescription'])->name('view.prescription.result.my.list');
            Route::get('detail/{id}', [PrescriptionResultController::class, 'detail'])->name('view.prescription.result.detail');
            Route::get('list', [PrescriptionResultController::class, 'doctorPrescription'])->name('view.prescription.result.doctor');
            Route::get('create', [PrescriptionResultController::class, 'create'])->name('view.prescription.result.create');
            Route::get('get-medicine', [PrescriptionResultController::class, 'getListMedicine'])->name('view.prescription.result.get-medicine');
        });
    });

    Route::get('/send', 'SendMessageController@index')->name('send');
    Route::post('/postMessage', 'SendMessageController@sendMessage')->name('postMessage');

    /* QrCode */
    Route::group(['prefix' => 'qr-code'], function () {
        Route::get('/doctor-info/{id}',
            [DoctorInfoController::class, 'showFromQrCode'])->name('qr.code.show.doctor.info');
    });

    Route::group(['prefix' => 'my-bookings'], function () {
        Route::get('show/{id}', [MyBookingController::class, 'showBookingQr'])->name('web.users.my.bookings.show');
        Route::get('generate/{id}', [MyBookingController::class, 'generateQrCode'])->name('web.users.my.bookings.generate');
        Route::get('download/{id}', [MyBookingController::class, 'downloadQrCode'])->name('web.users.my.bookings.download');
    });
    /* List route for web*/
    /* Admin */
    Route::group(['prefix' => 'admin-ui', 'middleware' => ['admin']], function () {
        require_once __DIR__ . '/authorization/admin.php';
    });

    /* Business */
    Route::group(['prefix' => 'route-ui', 'middleware' => ['business']], function () {
        require_once __DIR__ . '/authorization/business.php';
    });

    /* Medical */
    Route::group(['prefix' => 'route-ui', 'middleware' => ['medical']], function () {
        require_once __DIR__ . '/authorization/medical.php';
    });

    /* Normal */
    Route::group(['prefix' => 'route-ui', 'middleware' => 'normal'], function () {
        require_once __DIR__ . '/authorization/normal.php';
    });

    /* Authenticate */
    Route::group(['prefix' => 'route-ui', 'middleware' => 'jwt'], function () {
        require_once __DIR__ . '/authorization/auth.php';
    });

    /* List Api*/
    /* Auth */
    Route::group(['prefix' => 'auth'], function () {
        Route::post('/login', [LoginController::class, 'login'])->name('api.user.login');
        Route::post('/logout', [LoginController::class, 'logout'])->name('api.user.logout');
        Route::post('/save-token', [LoginController::class, 'saveTokenFireBase'])->name('api.user.save.token');
        Route::post('/register', [RegisterController::class, 'register'])->name('api.user.register');
        Route::get('/logout-all', [UserApi::class, 'logout']);
        Route::post('/open-key', [UserApi::class, 'calcPoint'])->name('api.user.open');
    });
    /* Product */
    Route::group(['prefix' => 'products'], function () {
        Route::get('', [ProductInfoController::class, 'index'])->name('product.list');

    });

    /* Admin */
    Route::group(['prefix' => 'admin', 'middleware' => ['admin']], function () {
        require_once __DIR__ . '/admin.php';
    });

    /* Business */
    Route::group(['prefix' => 'api', 'middleware' => ['business']], function () {
        require_once __DIR__ . '/permission/business.php';
    });

    /* Medical */
    Route::group(['prefix' => 'api', 'middleware' => ['medical']], function () {
        require_once __DIR__ . '/permission/medical.php';
    });

    /* Normal */
    Route::group(['prefix' => 'api', 'middleware' => 'normal'], function () {
        require_once __DIR__ . '/permission/normal.php';
    });

    /* Authenticate */
    Route::group(['prefix' => 'api', 'middleware' => 'jwt'], function () {
        require_once __DIR__ . '/backend.php';
    });

    /* Free api */
    Route::group(['prefix' => ''], function () {
        require_once __DIR__ . '/restapi.php';
    });

    /* Route maps */
    Route::get('explore', [MapController::class, 'explore'])->name('explore.list');
    Route::get('/info-user/{id}', [ProfileController::class, 'infoUser'])->name('info.user');
    Route::get('/department', [DoctorInfoController::class, 'listDepartment'])->name('list.department');

    Route::get('/upload-form', [ImportController::class, 'showForm'])->name('upload.form');
    Route::post('/import-excel', [ImportController::class, 'importExcel'])->name('import.excel');
    /*Download*/
    Route::group(['prefix' => 'download'], function () {
        Route::get('', [DownloadController::class, 'getDownload'])->name('user.download');
        Route::get('file/{id}', [DownloadController::class, 'downloadFile'])->name('user.download.file');
    });
});
Route::get('test/translate', [MainApi::class, 'translateLanguage']);
Route::group(['prefix' => 'zalo-service'], function () {
    Route::get('auth-verify', [ZaloController::class, 'getAuthCode'])->name('zalo.service.auth.verify');
    Route::get('callback', [ZaloController::class, 'getParameter'])->name('zalo.service.callback');
    Route::get('token', [ZaloController::class, 'getToken'])->name('zalo.service.token');
    Route::get('follower', [ZaloController::class, 'getFollower'])->name('zalo.service.follower');
    Route::get('profile', [ZaloController::class, 'getProfile'])->name('zalo.service.profile');
    Route::get('send-message-text', [ZaloController::class, 'sendMessage'])->name('zalo.service.send.message.text');
});
