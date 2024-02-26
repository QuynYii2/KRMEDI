@php use App\Models\Role;use App\Models\RoleUser; @endphp
@php @endphp
    <!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title> @yield('title')</title>
    <meta content="krmedi description" name="description">
    <meta content="krmedi" name="keywords">
    <link rel="icon" type="image/png"
          href="{{ asset('img/logo.png') }}">
    <!-- Favicons -->
    <link href="{{ asset('admin/img/apple-touch-icon.png')}}" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
        rel="stylesheet">
    <script>
        const token = `{{ $_COOKIE['accessToken'] ?? '' }}`;
    </script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <!-- Vendor CSS Files -->
    <link href="{{ asset('admin/vendor/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>
    <link href="{{ asset('admin/vendor/bootstrap-icons/bootstrap-icons.css')}}" rel="stylesheet">
    <link href="{{ asset('admin/vendor/boxicons/css/boxicons.min.css')}}" rel="stylesheet">
    <link href="{{ asset('admin/vendor/quill/quill.snow.css')}}" rel="stylesheet">
    <link href="{{ asset('admin/vendor/quill/quill.bubble.css')}}" rel="stylesheet">
    <link href="{{ asset('admin/vendor/remixicon/remixicon.css')}}" rel="stylesheet">
    <link href="{{ asset('admin/vendor/simple-datatables/style.css')}}" rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">

    <script src="https://unpkg.com/sweetalert2@7.18.0/dist/sweetalert2.all.js"></script>
    <!-- Template Main CSS File -->
    <link href="{{ asset('admin/css/style.css') }}" rel="stylesheet">

</head>

<style>
    .loading-overlay-master {
        display: none;
        background: rgba(255, 255, 255, 0.7);
        position: fixed;
        bottom: 0;
        left: 0;
        right: 0;
        top: 0;
        z-index: 9998;
        align-items: center;
        justify-content: center;
    }

    .loading-overlay-master.is-active {
        display: flex;
    }

    .code {
        font-family: monospace;
        /*   font-size: .9em; */
        color: #dd4a68;
        background-color: rgb(238, 238, 238);
        padding: 0 3px;
    }

    ul#header-popup-message-unseen {
        width: 330px;
    }

    .pager {
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .pager span {
        border: 1px solid #dee2e6;
        padding: 4px 8px;
        cursor: pointer;
    }

    .pg-goto {
        padding: 4px 8px;
        border-color: #dee2e6;
        color: #007bff;
    }

    .pg-normal {
        color: #0056b3;
        text-decoration: none;
        background-color: #e9ecef;
        border-color: #dee2e6;
    }

    .pg-selected {
        z-index: 1;
        color: #fff;
        background-color: #007bff;
        border-color: #007bff;
    }
</style>
@php
    //lấy ra toàn bộ role của user hiện tại
    $roles = RoleUser::where('user_id', Auth::user()->id)->pluck('role_id')->toArray();
    $isStaff = false;
    $isNormal = false;
    foreach ($roles as $role){
        $roleNames = Role::where('id', $role)->pluck('name');
            if ($roleNames->contains('PAITENTS')
                    || $roleNames->contains('NORMAL PEOPLE')
            ){
                $isNormal = true;
                break;
            }
            if ($roleNames->contains('DOCTORS')
                    || $roleNames->contains('PHAMACISTS')
                    || $roleNames->contains('THERAPISTS')
                    || $roleNames->contains('ESTHETICIANS')
                    || $roleNames->contains('NURSES')
                    || $roleNames->contains('NURSES')
                    ){
                    $isStaff = true;
                    break;
            }

    }

    $isAdmin = (new \App\Http\Controllers\MainController())->checkAdmin();
@endphp
<body>
@include('sweetalert::alert')
<div class="loading-overlay-master">
    <span class="fas fa-spinner fa-3x fa-spin"></span>
</div>
<!-- ======= Header ======= -->
<header id="header" class="header fixed-top d-flex align-items-center">

    <div class="d-flex align-items-center justify-content-between">
        <a href="/" class="logo d-flex align-items-center">
            <img src="{{ asset('admin/img/logo.png')}}" alt="">
            <span class="d-none d-lg-block">KRMEDI</span>
        </a>
        <i class="bi bi-list toggle-sidebar-btn"></i>
    </div><!-- End Logo -->

    <div class="search-bar">
        <form class="search-form d-flex align-items-center">
            <input type="text" name="query" placeholder="{{ __('home.Search for anything…') }}"
                   title="Enter search keyword">
            <button type="button" title="Search"><i class="bi bi-search"></i></button>
        </form>
    </div><!-- End Search Bar -->

    <nav class="header-nav ms-auto">
        <ul class="d-flex align-items-center">

            <li class="nav-item d-block d-lg-none">
                <a class="nav-link nav-icon search-bar-toggle " href="#">
                    <i class="bi bi-search"></i>
                </a>
            </li><!-- End Search Icon-->

            <li class="nav-item dropdown">

                <a class="nav-link nav-icon" href="#" data-bs-toggle="dropdown">
                    <i class="bi bi-bell"></i>
                    <span class="badge bg-primary badge-number">4</span>
                </a><!-- End Notification Icon -->

                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow notifications">
                    <li class="dropdown-header">
                        {{ __('home.You have 4 new notifications') }}
                        <a href="#"><span
                                class="badge rounded-pill bg-primary p-2 ms-2">{{ __('home.View all') }}</span></a>
                    </li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>

                    <li class="notification-item">
                        <i class="bi bi-exclamation-circle text-warning"></i>
                        <div>
                            <h4>Lorem Ipsum</h4>
                            <p>Quae dolorem earum veritatis oditseno</p>
                            <p>30 min. ago</p>
                        </div>
                    </li>

                    <li>
                        <hr class="dropdown-divider">
                    </li>

                    <li class="notification-item">
                        <i class="bi bi-x-circle text-danger"></i>
                        <div>
                            <h4>Atque rerum nesciunt</h4>
                            <p>Quae dolorem earum veritatis oditseno</p>
                            <p>1 hr. ago</p>
                        </div>
                    </li>

                    <li>
                        <hr class="dropdown-divider">
                    </li>

                    <li class="notification-item">
                        <i class="bi bi-check-circle text-success"></i>
                        <div>
                            <h4>Sit rerum fuga</h4>
                            <p>Quae dolorem earum veritatis oditseno</p>
                            <p>2 hrs. ago</p>
                        </div>
                    </li>

                    <li>
                        <hr class="dropdown-divider">
                    </li>

                    <li class="notification-item">
                        <i class="bi bi-info-circle text-primary"></i>
                        <div>
                            <h4>Dicta reprehenderit</h4>
                            <p>Quae dolorem earum veritatis oditseno</p>
                            <p>4 hrs. ago</p>
                        </div>
                    </li>

                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li class="dropdown-footer">
                        <a href="#">{{ __('home.Show all notifications') }}</a>
                    </li>

                </ul><!-- End Notification Dropdown Items -->

            </li><!-- End Notification Nav -->

            <li class="nav-item dropdown">

                <a class="nav-link nav-icon" href="#" data-bs-toggle="dropdown">
                    <i class="bi bi-chat-left-text"></i>
                    <span class="badge bg-success badge-number" id="count-message-unseen"></span>
                </a><!-- End Messages Icon -->

                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow messages"
                    id="header-popup-message-unseen">


                </ul><!-- End Messages Dropdown Items -->

            </li><!-- End Messages Nav -->

            <li class="nav-item dropdown pe-3">

                <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
                    <img src="{{ asset('admin/img/profile-img.jpg')}}" alt="Profile" class="rounded-circle">
                    <span class="d-none d-md-block dropdown-toggle ps-2">{{ Auth::user()->username }}</span>
                </a><!-- End Profile Iamge Icon -->

                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                    <li class="dropdown-header">
                        <h6>{{ Auth::user()->username }}</h6>
                        <span> {{ Auth::user()->points }} points</span>
                    </li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>

                    <li>
                        <a class="dropdown-item d-flex align-items-center" href="{{ route('profile') }}">
                            <i class="bi bi-person"></i>
                            <span>{{ __('home.My Profile') }}</span>
                        </a>
                    </li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>

                    <li>
                        <a class="dropdown-item d-flex align-items-center" href="#">
                            <i class="bi bi-gear"></i>
                            <span>{{ __('home.Account Settings') }}</span>
                        </a>
                    </li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>

                    <li>
                        <a class="dropdown-item d-flex align-items-center" href="#">
                            <i class="bi bi-question-circle"></i>
                            <span>{{ __('home.Need Help') }}?</span>
                        </a>
                    </li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>

                    <li>
                        <a class="dropdown-item d-flex align-items-center" href="{{ route('logoutProcess') }}">
                            <i class="bi bi-box-arrow-right"></i>
                            <span>{{ __('home.Sign Out') }}</span>
                        </a>
                    </li>

                </ul><!-- End Profile Dropdown Items -->
            </li><!-- End Profile Nav -->

        </ul>
    </nav><!-- End Icons Navigation -->

</header>
<!-- End Header -->

<!-- ======= Sidebar ======= -->
<aside id="sidebar" class="sidebar">
    <ul class="sidebar-nav" id="sidebar-nav">
        @if(!$isNormal)
            <!-- Dashboard Nav -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="{{ route('admin.home') }}">
                    <i class="bi bi-grid"></i>
                    <span>{{ __('home.Dashboard') }}</span>
                </a>
            </li>
            <!-- End Dashboard Nav -->

            <!-- Product Medicine Nav -->
            @if($isAdmin)
                <li class="nav-item">
                    <a class="nav-link collapsed" data-bs-target="#components-nav" data-bs-toggle="collapse"
                       href="#">
                        <i class="bi bi-file-medical"></i><span>{{ __('home.Product Medicine') }}</span><i
                            class="bi bi-chevron-down ms-auto"></i>
                    </a>
                    <ul id="components-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                        <li>
                            <a href="{{ route('api.backend.category-product.index') }}">
                                <i class="bi bi-circle"></i><span>{{ __('home.Category Product') }}</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('view.admin.home.medicine.list') }}">
                                <i class="bi bi-circle"></i><span>{{__('home.Approval Product Medicine')}}</span>
                            </a>
                        </li>
                    </ul>
                </li>
            @endif
            <!-- End Product Medicine Nav -->

            <!-- Selling/Buying Nav -->
            <li class="nav-item">
                <a class="nav-link collapsed" data-bs-target="#selling-nav" data-bs-toggle="collapse" href="#">
                    <i class="bi bi-menu-button-wide"></i><span>{{ __('home.Selling/Buying') }}</span><i
                        class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="selling-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                    <li>
                        <a href="{{ route('homeAdmin.list.product') }}">
                            <i class="bi bi-circle"></i><span>{{ __('home.Selling/Buying') }}</span>
                        </a>
                    </li>
                    @if($isAdmin)
                        <li>
                            <a href="{{ route('view.admin.category.index') }}">
                                <i class="bi bi-circle"></i><span>{{ __('home.Category') }}</span>
                            </a>
                        </li>
                    @endif
                </ul>
            </li>
            <!-- End Selling/Buying Nav -->

            <!-- News/Events Nav -->
            <li class="nav-item">
                <a class="nav-link collapsed" data-bs-target="#forms-nav" data-bs-toggle="collapse" href="#">
                    <i class="bi bi-newspaper"></i><span>{{ __('home.News/Events') }}</span><i
                        class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="forms-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                    <li>
                        <a href="{{ route('api.new-event.index') }}">
                            <i class="bi bi-circle"></i><span>{{ __('home.News/Events') }}</span>
                        </a>
                    </li>
                </ul>
            </li>
            <!-- End News/Events Nav -->

            <!-- Order Nav -->
            <li class="nav-item">
                <a class="nav-link collapsed" data-bs-target="#orders-nav" data-bs-toggle="collapse" href="#">
                    <i class="bi bi-view-list"></i><span>{{ __('home.Order Management') }}</span><i
                        class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="orders-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                    <li>
                        <a href="{{ route('view.admin.orders.list') }}">
                            <i class="bi bi-circle"></i><span>{{ __('home.Order Selling/Buying') }}</span>
                        </a>
                    </li>
                    @if(!$isStaff)
                        <li>
                            <a href="{{ route('view.admin.orders.index') }}">
                                <i class="bi bi-circle"></i><span>{{ __('home.Order Online Shopping') }}</span>
                            </a>
                        </li>
                    @endif
                </ul>
            </li>
            <!-- End Order Nav -->

            <!-- Call video Nav -->
            <li class="nav-item">
                <a class="nav-link collapsed" data-bs-target="#call-video-nav" data-bs-toggle="collapse" href="#">
                    <i class="bi bi-camera-video"></i><span>{{ __('home.Call video') }}</span><i
                        class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="call-video-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                    <li>
                        <a href="{{ route('api.backend.connect.video.index3') }}">
                            <i class="bi bi-circle"></i><span>{{ __('home.Call video') }}</span>
                        </a>
                    </li>
                </ul>
            </li>
            <!-- End Call video Nav -->

            <!-- Start Doctor Prescription Page Nav -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="{{ route('view.prescription.result.doctor') }}">
                    <i class="bi bi-music-player"></i>
                    <span>{{ __('home.Doctor Prescription') }}</span>
                </a>
            </li>
            <!-- End Doctor Prescription Page Nav -->

            @if(!$isStaff)
                <!-- List Coupon Nav -->
                <li class="nav-item">
                    <a class="nav-link collapsed" data-bs-target="#coupon-nav" data-bs-toggle="collapse" href="#">
                        <i class="bi bi-medium"></i><span>{{ __('home.Free Coupon') }}</span><i
                            class="bi bi-chevron-down ms-auto"></i>
                    </a>
                    <ul id="coupon-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                        <li>
                            <a href="{{ route('homeAdmin.list.coupons') }}">
                                <i class="bi bi-circle"></i><span>{{ __('home.List Coupon') }}</span>
                            </a>
                        </li>
                    </ul>
                </li>
                <!-- End List Coupon Nav -->

                <!-- Booking Nav -->
                <li class="nav-item">
                    <a class="nav-link collapsed" data-bs-target="#charts-nav" data-bs-toggle="collapse" href="#">
                        <i class="bi bi-bar-chart"></i><span>{{ __('home.Booking Management') }}</span><i
                            class="bi bi-chevron-down ms-auto"></i>
                    </a>
                    <ul id="charts-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                        <li>
                            <a href="{{ route('homeAdmin.list.booking') }}">
                                <i class="bi bi-circle"></i><span>{{ __('home.Booking') }}</span>
                            </a>
                        </li>
                    </ul>
                </li>
                <!-- End Booking Nav -->

                <!-- Booking Nav -->
                <li class="nav-item">
                    <a class="nav-link collapsed" data-bs-target="#medicine-nav" data-bs-toggle="collapse" href="#">
                        <i class="bi bi-memory"></i><span>{{ __('home.Product Medicine') }}</span><i
                            class="bi bi-chevron-down ms-auto"></i>
                    </a>
                    <ul id="medicine-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                        <li>
                            <a href="{{ route('api.backend.product-medicine.index') }}">
                                <i class="bi bi-circle"></i><span>{{ __('home.List product medicine') }}</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('view.admin.surveys.index') }}">
                                <i class="bi bi-circle"></i><span>{{ __('home.List Survey') }}</span>
                            </a>
                        </li>
                    </ul>
                </li>
                <!-- End Booking Nav -->

                <!-- Start Medical Result Business Nav -->
                <li class="nav-item">
                    <a class="nav-link collapsed" data-bs-target="#medical-result-nav" data-bs-toggle="collapse"
                       href="#">
                        <i class="bi bi-segmented-nav"></i><span>{{ __('home.Medical examination results') }}</span><i
                            class="bi bi-chevron-down ms-auto"></i>
                    </a>
                    <ul id="medical-result-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                        <li>
                            <a href="{{ route('view.admin.medical.result.list') }}">
                                <i class="bi bi-circle"></i><span>{{ __('home.List examination results') }}</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('view.admin.medical.result.create') }}">
                                <i class="bi bi-circle"></i><span>{{ __('home.Create examination results') }}</span>
                            </a>
                        </li>
                    </ul>
                </li>
                <!-- End Medical Result Business Nav -->

                <!-- Examination Nav -->
                <li class="nav-item">
                    <a class="nav-link collapsed" data-bs-target="#tables-nav" data-bs-toggle="collapse" href="#">
                        <i class="bi bi-layout-text-window-reverse"></i><span>{{ __('home.Nhân viên') }}</span><i
                            class="bi bi-chevron-down ms-auto"></i>
                    </a>
                    <ul id="tables-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                        <li>
                            <a href="{{ route('homeAdmin.list.staff') }}">
                                <i class="bi bi-circle"></i><span>{{ __('home.Nhân viên') }}</span>
                            </a>
                        </li>
                    </ul>
                </li>
                <!-- End Examination Nav -->
            @endif
            @if($isAdmin)
                <!-- Clinics Nav -->
                <li class="nav-item">
                    <a class="nav-link collapsed" data-bs-target="#clinics-nav" data-bs-toggle="collapse" href="#">
                        <i class="bi bi-robot"></i><span>{{ __('home.Clinics/Pharmacies') }}</span><i
                            class="bi bi-chevron-down ms-auto"></i>
                    </a>
                    <ul id="clinics-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                        <li>
                            <a href="{{ route('homeAdmin.list.clinics') }}">
                                <i class="bi bi-circle"></i><span>{{ __('home.List Clinics') }}</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('user.service.clinics.list') }}">
                                <i class="bi bi-circle"></i><span>{{ __('home.Service Clinics') }}</span>
                            </a>
                        </li>
                    </ul>
                </li>
                <!-- End Clinics Nav -->

                <!-- Doctor Nav -->
                <li class="nav-item">
                    <a class="nav-link collapsed" data-bs-target="#doctor-nav" data-bs-toggle="collapse" href="#">
                        <i class="bi bi-robot"></i><span>{{ __('home.Doctors') }}</span><i
                            class="bi bi-chevron-down ms-auto"></i>
                    </a>
                    <ul id="doctor-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                        <li>
                            <a href="{{ route('homeAdmin.list.doctors') }}">
                                <i class="bi bi-circle"></i><span>{{ __('home.Examination') }}</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('api.backend.account-register.index') }}">
                                <i class="bi bi-circle"></i><span>{{ __('home.Duyệt đăng ký phòng khám') }}</span>
                            </a>
                        </li>
                    </ul>
                </li>
                <!-- End Doctor Nav -->

                <!-- Review Nav -->
                <li class="nav-item">
                    <a class="nav-link collapsed" data-bs-target="#reviews-nav" data-bs-toggle="collapse" href="#">
                        <i class="bi bi-image-alt"></i><span>{{ __('home.Reviews') }}</span><i
                            class="bi bi-chevron-down ms-auto"></i>
                    </a>
                    <ul id="reviews-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                        <li>
                            <a href="{{ route('view.admin.reviews.index') }}">
                                <i class="bi bi-circle"></i><span>{{ __('home.Reviews Clinic/Hospital/Pharmacy') }}</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('view.reviews.doctor.index') }}">
                                <i class="bi bi-circle"></i><span>{{ __('home.Reviews Doctor') }}</span>
                            </a>
                        </li>
                    </ul>
                </li>
                <!-- End Review Nav -->

                <!-- Videos Nav -->
                <li class="nav-item">
                    <a class="nav-link collapsed" data-bs-target="#videos-nav" data-bs-toggle="collapse" href="#">
                        <i class="bi bi-film"></i><span>{{ __('home.Videos') }}</span><i
                            class="bi bi-chevron-down ms-auto"></i>
                    </a>
                    <ul id="videos-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                        <li>
                            <a href="{{ route('view.admin.videos.list') }}">
                                <i class="bi bi-circle"></i><span>{{ __('home.Short Videos') }}</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('user.topic.videos.list') }}">
                                <i class="bi bi-circle"></i><span>{{ __('home.Topic Videos') }}</span>
                            </a>
                        </li>
                    </ul>
                </li>
                <!-- End Videos Nav -->

                <!-- Start Departments/Symptoms Nav -->
                <li class="nav-item">
                    <a class="nav-link collapsed" data-bs-target="#department-symptom-nav" data-bs-toggle="collapse"
                       href="#">
                        <i class="bi bi-bar-chart"></i><span>{{ __('home.departments') }}</span><i
                            class="bi bi-chevron-down ms-auto"></i>
                    </a>
                    <ul id="department-symptom-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                        <li>
                            <a href="{{ route('view.admin.department.index') }}">
                                <i class="bi bi-circle"></i><span>{{ __('home.departments') }}</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('symptom.index') }}">
                                <i class="bi bi-circle"></i><span>{{ __('home.symptoms') }}</span>
                            </a>
                        </li>
                    </ul>
                </li>
                <!-- End Departments/Symptoms Nav -->

                <!-- Config Nav -->
                <li class="nav-item">
                    <a class="nav-link collapsed" data-bs-target="#icons-nav" data-bs-toggle="collapse" href="#">
                        <i class="bi bi-gem"></i><span>{{ __('home.Cấu hình chung') }}</span><i
                            class="bi bi-chevron-down ms-auto"></i>
                    </a>
                    <ul id="icons-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                        <li>
                            <a href="{{ route('view.admin.list.config') }}">
                                <i class="bi bi-circle"></i><span>{{ __('home.Cấu hình chung') }}</span>
                            </a>
                        </li>
                    </ul>
                </li>
                <!-- End Config Nav -->

                <!-- Start Admin User Nav -->
                <li class="nav-item">
                    <a class="nav-link collapsed" data-bs-target="#user-manager-nav" data-bs-toggle="collapse"
                       href="#">
                        <i class="bi bi-list-task"></i><span>{{ __('home.User') }}</span><i
                            class="bi bi-chevron-down ms-auto"></i>
                    </a>
                    <ul id="user-manager-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                        <li>
                            <a href="{{ route('view.admin.user.list') }}">
                                <i class="bi bi-circle"></i><span>{{ __('home.List User') }}</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('view.admin.user.create') }}">
                                <i class="bi bi-circle"></i><span>{{ __('home.Create User') }}</span>
                            </a>
                        </li>
                    </ul>
                </li>
                <!-- End Admin User Nav -->
            @endif
        @else
            <!-- Start Family Nav -->
            <li class="nav-item">
                <a class="nav-link collapsed" data-bs-target="#family-nav" data-bs-toggle="collapse"
                   href="#">
                    <i class="bi bi-bar-chart"></i><span>{{ __('home.Gia dinh') }}</span><i
                        class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="family-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                    <li>
                        <a href="{{ route('api.backend.family-management.index') }}">
                            <i class="bi bi-circle"></i><span>{{ __('home.Gia dinh') }}</span>
                        </a>
                    </li>
                </ul>
            </li>
            <!-- End Family Nav -->

            <!-- Start For you Nav -->
            <li class="nav-item">
                <a class="nav-link collapsed" data-bs-target="#address-nav" data-bs-toggle="collapse"
                   href="#">
                    <i class="bi bi-card-heading"></i><span>Quản lý địa chỉ</span><i
                        class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="address-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                    <li>
                        <a href="{{ route('view.user.address.list') }}">
                            <i class="bi bi-circle"></i><span>{{ __('home.List Address') }}</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('view.user.address.create') }}">
                            <i class="bi bi-circle"></i><span>{{ __('home.Create Address') }}</span>
                        </a>
                    </li>
                </ul>
            </li>
            <!-- End For you Nav -->

            <li class="nav-item">
                <a class="nav-link collapsed" href="{{ route('view.web.orders.index') }}">
                    <i class="bi bi-ubuntu"></i><span>Đơn hàng của tôi</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link collapsed" href="{{ route('web.users.my.coupons.list') }}">
                    <i class="bi bi-memory"></i><span>Quản lý voucher</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link collapsed" href="{{ route('web.users.my.bookings.list') }}">
                    <i class="bi bi-bookmark"></i><span>Quản lý booking</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link collapsed" href="{{ route('view.prescription.result.my.list') }}">
                    <i class="bi bi-prescription"></i><span>Đơn thuốc của tôi</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link collapsed" href="{{ route('web.medical.result.list') }}">
                    <i class="bi bi-magic"></i><span>Kết quả khám bệnh</span>
                </a>
            </li>

            <!-- Start My Favourite Nav -->
            <li class="nav-item">
                <a class="nav-link collapsed" data-bs-target="#my-favourite-nav" data-bs-toggle="collapse"
                   href="#">
                    <i class="bi bi-heart"></i><span>Danh sách yêu thích</span><i
                        class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="my-favourite-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                    <li>
                        <a href="{{ route('web.users.my.favourite.businesses') }}">
                            <i class="bi bi-circle"></i><span>Bệnh viện yêu thích</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('web.users.my.favourite.medicals') }}">
                            <i class="bi bi-circle"></i><span>Bác sĩ yêu thích</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('web.users.my.favourite.products') }}">
                            <i class="bi bi-circle"></i><span>Sản phẩm yêu thích</span>
                        </a>
                    </li>
                </ul>
            </li>
            <!-- End My Favourite Nav -->
        @endif

        <li class="nav-heading">{{ __('home.Settings') }}</li>

        <!-- Start Profile Page Nav -->
        <li class="nav-item">
            <a class="nav-link collapsed" href="{{ route('profile') }}">
                <i class="bi bi-person"></i>
                <span>{{ __('home.Profile') }}</span>
            </a>
        </li>
        <!-- End Profile Page Nav -->

        <!-- Start About Page Nav -->
        <li class="nav-item">
            <a class="nav-link collapsed" href="{{ route('web.users.list.points') }}">
                <i class="bi bi-play"></i>
                <span>{{ __('home.Xếp hạng thành viên') }}</span>
            </a>
        </li>
        <!-- End About Page Nav -->
    </ul>
</aside>
<!-- End Sidebar -->

<!-- ======= Main ======= -->
<main id="main" class="main">
    @yield('main-content')
</main>
<!-- End Main -->

<!-- ======= Footer ======= -->
<footer id="footer" class="footer">
    <div class="copyright">
        &copy; Copyright <strong><span>KRMEDI</span></strong>. All Rights Reserved
    </div>
    <div class="credits">
        Designed by <a href="#">KRMEDI</a>
    </div>
</footer>
<!-- End Footer -->

@include('components.head.tinymce-config')
@includeWhen(Auth::check(),'components.head.chat-message' )

<a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
        class="bi bi-arrow-up-short"></i></a>

<!-- Vendor JS Files -->
<script src="{{ asset('admin/vendor/apexcharts/apexcharts.min.js')}}"></script>
<script src="{{ asset('admin/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<script src="{{ asset('admin/vendor/chart.js/chart.umd.js')}}"></script>
<script src="{{ asset('admin/vendor/echarts/echarts.min.js')}}"></script>
<script src="{{ asset('admin/vendor/quill/quill.min.js')}}"></script>
<script src="{{ asset('admin/vendor/simple-datatables/simple-datatables.js')}}"></script>
<script src="{{ asset('admin/vendor/php-email-form/validate.js')}}"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"></script>

<!-- Template Main JS File -->
<script src="{{ asset('admin/js/main.js')}}"></script>
<script>
    function loadingMasterPage() {
        let overlay = document.getElementsByClassName('loading-overlay-master')[0]
        overlay.classList.toggle('is-active')
    }
</script>
</body>

<script src="https://js.pusher.com/7.0/pusher.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/laravel-echo@1.11.2/dist/echo.iife.js"></script>

<script>
    let currentId = '{{ Auth::check() ? Auth::user()->id : '' }}';

    window.Pusher = Pusher;
    window.Echo = new Echo({
        broadcaster: 'pusher',
        key: 'e700f994f98dbb41ea9f',
        cluster: 'eu',
        encrypted: true,
    });

    window.Echo.private("messages." + currentId).listen('NewMessage', function (e) {
        if (!isApiBackendConnectChatIndex()) {
            loadMessageUnseen();
        }
    });

    loadMessageUnseen();

    function loadMessageUnseen() {
        $.ajax({
            url: '{{ route('admin.list.chat.unseen') }}',
            method: 'GET',
            success: function (data) {
                renderMessageUnseen(data.messages)
            }
        })
    }

    function isApiBackendConnectChatIndex() {
        // Kiểm tra xem route hiện tại có phải là 'api.backend.connect.chat.index' hay không
        return '{{ Route::currentRouteName() }}' === 'api.backend.connect.chat.index';
    }

    function renderMessageUnseen(data) {

        if (data.length === 0) {
            $('#header-popup-message-unseen').html(`<li class="dropdown-header">
                        {{ __('home.You have no new messages') }}
            </li>`)
            return;
        }

        let countUnseen = data[0].total;
        editBadgesMessageUnseen(countUnseen);

        let html = '';
        html += `<li class="dropdown-header">
                        {{ __('home.You have ') }} ${countUnseen} {{ __(' new messages') }}
        </li>`
        data.forEach(function (item) {
            html += `<li>
                        <hr class="dropdown-divider">
                    </li>
                    <li class="message-item">
                        <a href="{{ route('api.backend.connect.chat.index') }}">
                            <img src="${item.avt}" alt="" class="rounded-circle">
                            <div>
                                <h4>${item.name_from}</h4>
                                <p>${item.chat_message}</p>
                                <p>${item.timeAgo}</p>
                            </div>
                        </a>
                    </li>`;
        })
        $('#header-popup-message-unseen').html(html);
    }

    function editBadgesMessageUnseen(countUnseen) {
        $('#count-message-unseen').text(countUnseen);
    }

    function validInputByID(input) {
        let labelElement = $(`label[for='${input}']`);
        let text = labelElement.text();
        if (!text) {
            text = 'The input'
        }
        text = text + ' not empty!'
        return text;
    }

    function appendDataForm(arrField, formData) {
        let isValid = true;
        for (let i = 0; i < arrField.length; i++) {
            let field = arrField[i];
            let value = $(`#${field}`).val();

            if (value && value !== '') {
                formData.append(field, value);
            } else {
                isValid = false;
                let message = validInputByID(field);
                alert(message);
                break;
            }
        }
        return isValid;
    }
</script>
</html>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script>
    async function getLocation() {
        if (navigator.geolocation) {
            await navigator.geolocation.getCurrentPosition(showPosition);
            let locale = localStorage.getItem('countryCode');
            let country = localStorage.getItem('location');
            document.cookie = "countryCode=" + locale;
            document.cookie = "country=" + country;
        } else {
            alert("Geolocation is not supported by this browser.")
        }
    }

    async function showPosition(position) {
        const latitude = position.coords.latitude;
        const longitude = position.coords.longitude;
        await getCountryFromCoordinates(latitude, longitude);
    }

    function getCountryFromCoordinates(latitude, longitude) {
        const apiUrl = `https://nominatim.openstreetmap.org/reverse?lat=${latitude}&lon=${longitude}&format=json`;

        fetch(apiUrl)
            .then(response => response.json())
            .then(data => {
                if (data.address && data.address.country && data.address.country_code) {
                    const countryName = data.address.country;
                    const countryCode = data.address.country_code;

                    localStorage.setItem('location', countryName);
                    localStorage.setItem('countryCode', countryCode);
                    localStorage.setItem('latitude', latitude);
                    localStorage.setItem('longitude', longitude);
                } else {

                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
    }

    getLocation();

    function shortString(selector) {
        const elements = document.querySelectorAll(selector);
        const tail = '...';
        if (elements && elements.length) {
            for (const element of elements) {
                let text = element.innerText;
                if (element.hasAttribute('data-limit')) {
                    if (text.length > element.dataset.limit) {
                        element.innerText = `${text.substring(0, element.dataset.limit - tail.length).trim()}${tail}`;
                    }
                } else {
                    throw Error('Cannot find attribute \'data-limit\'');
                }
            }
        }
    }

    window.onload = function () {
        shortString('.text-shortcut');
    };
</script>
<script>
    /* Function search with inputSearch and Table */
    function searchMain(inputSearch, tableList) {
        $('#' + inputSearch).on('keyup', function () {
            let value = $(this).val().toLowerCase();
            $('#' + tableList + ' tbody tr').filter(function () {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });
    }

    /* Paginate for table with table is id of table and items is numbers element of table */
    function loadPaginate(table, items) {
        $('table#' + table).each(function () {
            var $table = $(this);
            var itemsPerPage = items;
            var currentPage = 0;
            var pages = Math.ceil($table.find("tr:not(:has(th))").length / itemsPerPage);
            $table.bind('repaginate', function () {
                $table.next().empty().show();
                if (pages > 1) {
                    var pager;
                    if ($table.next().hasClass("pager"))
                        pager = $table.next().empty(); else
                        pager = $('<div class="pager" style="padding-top: 20px; direction:ltr; " align="center"></div>');

                    $('<button class="pg-goto"></button>').text(' « First ').bind('click', function () {
                        currentPage = 0;
                        $table.trigger('repaginate');
                    }).appendTo(pager);

                    $('<button class="pg-goto"> « Prev </button>').bind('click', function () {
                        if (currentPage > 0)
                            currentPage--;
                        $table.trigger('repaginate');
                    }).appendTo(pager);

                    var startPager = currentPage > 2 ? currentPage - 2 : 0;
                    var endPager = startPager > 0 ? currentPage + 3 : 5;
                    if (endPager > pages) {
                        endPager = pages;
                        startPager = pages - 5;
                        if (startPager < 0)
                            startPager = 0;
                    }

                    for (var page = startPager; page < endPager; page++) {
                        $('<span id="pg' + page + '" class="' + (page == currentPage ? 'pg-selected' : 'pg-normal') + '"></span>').text(page + 1).bind('click', {
                            newPage: page
                        }, function (event) {
                            currentPage = event.data['newPage'];
                            $table.trigger('repaginate');
                        }).appendTo(pager);
                    }

                    $('<button class="pg-goto"> Next » </button>').bind('click', function () {
                        if (currentPage < pages - 1)
                            currentPage++;
                        $table.trigger('repaginate');
                    }).appendTo(pager);
                    $('<button class="pg-goto"> Last » </button>').bind('click', function () {
                        currentPage = pages - 1;
                        $table.trigger('repaginate');
                    }).appendTo(pager);

                    if (!$table.next().hasClass("pager"))
                        pager.insertAfter($table);
                } else {
                    if ($table.next().hasClass("pager"))
                        $table.next().empty().hide();
                }

                $table.find('tbody tr:not(:has(th))').hide().slice(currentPage * itemsPerPage, (currentPage + 1) * itemsPerPage).show();
            });

            $table.trigger('repaginate');
        });
    }
</script>
