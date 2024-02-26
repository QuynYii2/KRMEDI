<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array<int, string>
     */
    protected $except = [
        //admin
        '/admin/service-clinics/**',
        '/admin/bookings/**',
        '/admin/new-event/**',
        '/admin/topic-videos/**',
        '/admin/users/**',
        '/api/reviews-doctor/**',
        //api
        '/api/products/**',
        '/api/wish-lists/**',
        '/api/clinics/**',
        '/api/questions/**',
        '/api/answers/**',
        '/api/reviews/**',
        '/api/categories/**',
        '/api/coupons/**',
        '/api/coupons-apply/**',
        '/api/doctors-info/**',
        '/api/users/**',
        '/api/pharmacies/**',
        '/api/short-videos/**',
        '/api/departments/**',
        '/api/symptoms/**',
        '/api/orders/**',
        '/api/booking-result/**',
        '/api/medical-results/**',
        '/api/family-management/**',
        '/api/checkout/**',
        '/api/surveys/**',
        '/api/surveys-2/**',
        '/api/address-order/**',
        '/api/account/**',
        '/api/bookings/**',
        // clients
        '/reviews/**',
        '/reviews/**',
        '/products/**',
        '/users/**',
        '/address/**',
        '/api/booking/**',
        '/api/carts/**',
        '/api/doctor-reviews/**',
        '/api/service-clinics/**',
        '/api/users-social/**',
        '/api/messages/**',
        '/api/business-favourites/**',
        '/api/medical-favourites/**',
        '/api/mentorings/**',
        '/api/prescription-result/**',
        '/api/mobile/fcm/**',
        '/orders/**',
        '/booking-result/**',
        'auth/*',
        'medicine/search',
        'forget-password/*',
        'examination/search',
        '/products-medicines/list-prescriptions',
        '/products-medicines/by-result/**',
        '/products-medicines/blade-list-prescriptions',
        '/check-valid-otp',
        '/change-password',
        '/medicine/list',
    ];
}
