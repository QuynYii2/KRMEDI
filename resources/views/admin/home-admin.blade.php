@extends('layouts.admin')
@section('title')
    {{ __('home.Dashboard') }}
@endsection
@section('main-content')
    <style>
        .datatable-bottom{
            justify-content: center;
            display: flex;
        }
        .datatable-info{
            display: none;
        }
    </style>
    <div class="pagetitle">
        <h1>{{ __('home.Dashboard') }}</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">{{ __('home.Home') }}</a></li>
                <li class="breadcrumb-item active">{{ __('home.Dashboard') }}</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">
        <div class="row">
            <div class="col-lg-12">
                <div class="row">

                    @if($isAdmin || Auth::user()->type === "BUSINESS")
                        <!-- Products Card -->
                        <div class="col-xxl-3 col-xl-12">
                            <div class="card info-card product-medicine-card">
                                <div class="filter">
                                    <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                        <li class="dropdown-header text-start">
                                            <h6>{{ __('home.Filter') }}</h6>
                                        </li>
                                        <li><a class="dropdown-item" href="{{ route('admin.home', ['order-filter' => 'today']) }}">{{ __('home.Today') }}</a></li>
                                        <li><a class="dropdown-item" href="{{ route('admin.home', ['order-filter' => 'this_month']) }}">{{ __('home.This Month') }}</a></li>
                                        <li><a class="dropdown-item" href="{{ route('admin.home', ['order-filter' => 'this_year']) }}">{{ __('home.This Year') }}</a></li>
                                    </ul>
                                </div>

                                <div class="card-body">
                                    <h5 class="card-title">Đơn thuốc<span> | {{ $orderFilterName }}</span></h5>

                                    <a href="{{ route('view.admin.home.medicine.list') }}" class="d-flex align-items-center">
                                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                            <i class="bi bi-journal-medical"></i>
                                        </div>
                                        <div class="ps-3">
                                            <h6>{{$orders->count()}}</h6>
                                            @php
                                                $currentCount = $orders->count();
                                                $lastCount = $orderLastPeriod->count();
                                                $percentageChange = $lastCount > 0 ? (($currentCount - $lastCount) / $lastCount) * 100 : 0;
                                            @endphp
                                            @if($percentageChange > 0)
                                                <span class="text-success small pt-1 fw-bold">{{ number_format($percentageChange, 2) }}%</span>
                                                <span class="text-muted small pt-2 ps-1">{{ __('home.increase') }}</span>
                                            @elseif($percentageChange < 0)
                                                <span class="text-danger small pt-1 fw-bold">{{ number_format($percentageChange, 2) }}%</span>
                                                <span class="text-muted small pt-2 ps-1">{{ __('home.decrease') }}</span>
                                            @else
                                                <span class="text-muted small pt-1">{{ number_format($percentageChange, 2) }}%</span>
                                                <span class="text-muted small pt-2 ps-1">Không đổi</span>
                                            @endif
                                        </div>
                                    </a>
                                </div>

                            </div>
                        </div>
                        <!-- End Products Card -->
                    @endif

                    <!-- Sales Card -->
                    <div class="col-xxl-3 col-md-6">
                        <div class="card info-card sales-card">

                            <div class="filter">
                                <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                    <li class="dropdown-header text-start">
                                        <h6>{{ __('home.Filter') }}</h6>
                                    </li>
                                    <li><a class="dropdown-item" href="{{ route('admin.home', ['booking-filter' => 'today']) }}">{{ __('home.Today') }}</a></li>
                                    <li><a class="dropdown-item" href="{{ route('admin.home', ['booking-filter' => 'this_month']) }}">{{ __('home.This Month') }}</a></li>
                                    <li><a class="dropdown-item" href="{{ route('admin.home', ['booking-filter' => 'this_year']) }}">{{ __('home.This Year') }}</a></li>
                                </ul>
                            </div>

                            <div class="card-body">
                                <h5 class="card-title">Đặt khám <span>| {{ $bookingFilterName }}</span></h5>
                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-cart"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h6>{{$bookings->count()}}</h6>
                                        @php
                                            $currentCount = $bookings->count();
                                            $lastCount = $bookingLastPeriod->count();
                                            $percentageChange = $lastCount > 0 ? (($currentCount - $lastCount) / $lastCount) * 100 : 0;
                                        @endphp
                                        @if($percentageChange > 0)
                                            <span class="text-success small pt-1 fw-bold">{{ number_format($percentageChange, 2) }}%</span>
                                            <span class="text-muted small pt-2 ps-1">{{ __('home.increase') }}</span>
                                        @elseif($percentageChange < 0)
                                            <span class="text-danger small pt-1 fw-bold">{{ number_format($percentageChange, 2) }}%</span>
                                            <span class="text-muted small pt-2 ps-1">{{ __('home.decrease') }}</span>
                                        @else
                                            <span class="text-muted small pt-1">{{ number_format($percentageChange, 2) }}%</span>
                                            <span class="text-muted small pt-2 ps-1">Không đổi</span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <!-- End Sales Card -->

                    <!-- Revenue Card -->
                    <div class="col-xxl-3 col-md-6">
                        <div class="card info-card revenue-card">
                            <div class="filter">
                                <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                    <li class="dropdown-header text-start">
                                        <h6>{{ __('home.Filter') }}</h6>
                                    </li>
                                    <li><a class="dropdown-item" href="{{ route('admin.home', ['user-filter' => 'today']) }}">{{ __('home.Today') }}</a></li>
                                    <li><a class="dropdown-item" href="{{ route('admin.home', ['user-filter' => 'this_month']) }}">{{ __('home.This Month') }}</a></li>
                                    <li><a class="dropdown-item" href="{{ route('admin.home', ['user-filter' => 'this_year']) }}">{{ __('home.This Year') }}</a></li>
                                </ul>
                            </div>

                            <div class="card-body">
                                <h5 class="card-title">Người truy cập mới <span> | {{ $userFilterName }}</span></h5>
                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-currency-dollar"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h6>{{$users->count()}}</h6>
                                        @php
                                            $currentCount = $users->count();
                                            $lastCount = $userLastPeriod->count();
                                            $percentageChange = $lastCount > 0 ? (($currentCount - $lastCount) / $lastCount) * 100 : 0;
                                        @endphp
                                        @if($percentageChange > 0)
                                            <span class="text-success small pt-1 fw-bold">{{ number_format($percentageChange, 2) }}%</span>
                                            <span class="text-muted small pt-2 ps-1">{{ __('home.increase') }}</span>
                                        @elseif($percentageChange < 0)
                                            <span class="text-danger small pt-1 fw-bold">{{ number_format($percentageChange, 2) }}%</span>
                                            <span class="text-muted small pt-2 ps-1">{{ __('home.decrease') }}</span>
                                        @else
                                            <span class="text-muted small pt-1">{{ number_format($percentageChange, 2) }}%</span>
                                            <span class="text-muted small pt-2 ps-1">Không đổi</span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <!-- End Revenue Card -->

                    <!-- Customers Card -->
{{--                    <div class="col-xxl-3 col-xl-12">--}}

{{--                        <div class="card info-card customers-card">--}}

{{--                            <div class="filter">--}}
{{--                                <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>--}}
{{--                                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">--}}
{{--                                    <li class="dropdown-header text-start">--}}
{{--                                        <h6>{{ __('home.Filter') }}</h6>--}}
{{--                                    </li>--}}

{{--                                    <li><a class="dropdown-item" href="#">{{ __('home.Today') }}</a></li>--}}
{{--                                    <li><a class="dropdown-item" href="#">{{ __('home.This Month') }}</a></li>--}}
{{--                                    <li><a class="dropdown-item" href="#">{{ __('home.This Year') }}</a></li>--}}
{{--                                </ul>--}}
{{--                            </div>--}}

{{--                            <div class="card-body">--}}
{{--                                <h5 class="card-title">{{ __('home.Customers') }} <span>| {{ __('home.This Year') }}</span></h5>--}}

{{--                                <div class="d-flex align-items-center">--}}
{{--                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">--}}
{{--                                        <i class="bi bi-people"></i>--}}
{{--                                    </div>--}}
{{--                                    <div class="ps-3">--}}
{{--                                        <h6>1244</h6>--}}
{{--                                        <span class="text-danger small pt-1 fw-bold">12%</span> <span class="text-muted small pt-2 ps-1">{{ __('home.decrease') }}</span>--}}

{{--                                    </div>--}}
{{--                                </div>--}}

{{--                            </div>--}}
{{--                        </div>--}}

{{--                    </div>--}}
                    <!-- End Customers Card -->

                    <!-- Reports -->
                    <div class="col-12">
                            <div class="card">
                                <div class="filter">
                                    <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                        <li class="dropdown-header text-start">
                                            <h6>{{ __('home.Filter') }}</h6>
                                        </li>
                                        <li><a class="dropdown-item report-filter" href="#" data-reportfilter="today">{{ __('home.Today') }}</a></li>
                                        <li><a class="dropdown-item report-filter" href="#" data-reportfilter="this_month">{{ __('home.This Month') }}</a></li>
                                        <li><a class="dropdown-item report-filter" href="#" data-reportfilter="this_year">{{ __('home.This Year') }}</a></li>
                                    </ul>
                                </div>
                                <div class="card-body">
                                    <h5 class="card-title">{{ __('home.Reports') }} <span id="report-filter-title">/{{ __('home.Today') }}</span></h5>

                                    <!-- Line Chart -->
                                    <div id="reportsChart"></div>

                                    <script>
                                        document.addEventListener("DOMContentLoaded", () => {
                                            let chart = new ApexCharts(document.querySelector("#reportsChart"), {
                                                series: [{
                                                    name: 'Đơn thuốc',
                                                    data: []
                                                }, {
                                                    name: 'Đặt khám',
                                                    data: []
                                                }, {
                                                    name: 'Người truy cập',
                                                    data: []
                                                }],
                                                chart: {
                                                    height: 350,
                                                    type: 'area',
                                                    toolbar: {
                                                        show: false
                                                    },
                                                },
                                                markers: {
                                                    size: 4
                                                },
                                                colors: ['#4154f1', '#2eca6a', '#ff771d'],
                                                fill: {
                                                    type: "gradient",
                                                    gradient: {
                                                        shadeIntensity: 1,
                                                        opacityFrom: 0.3,
                                                        opacityTo: 0.4,
                                                        stops: [0, 90, 100]
                                                    }
                                                },
                                                dataLabels: {
                                                    enabled: false
                                                },
                                                stroke: {
                                                    curve: 'smooth',
                                                    width: 2
                                                },
                                                xaxis: {
                                                    type: 'datetime',
                                                    categories: []
                                                },
                                                tooltip: {
                                                    x: {
                                                        format: 'dd/MM/yy'
                                                    },
                                                }
                                            });

                                            chart.render();

                                            document.querySelectorAll('.report-filter').forEach(item => {
                                                item.addEventListener('click', function(event) {
                                                    event.preventDefault();
                                                    const filter = this.getAttribute('data-reportfilter');
                                                    fetchChartData(filter);
                                                    document.getElementById('report-filter-title').textContent = `/${this.textContent}`;
                                                });
                                            });
                                            function getTooltipFormat(filter) {
                                                if (filter === 'this_month') {
                                                    return 'MM/yyyy';
                                                } else if (filter === 'this_year') {
                                                    return 'yyyy';
                                                }
                                                return 'dd/MM/yy';
                                            }
                                            function fetchChartData(filter) {
                                                fetch(`/web/home/getDataForChart?filter=${filter}`)
                                                    .then(response => response.json())
                                                    .then(data => {
                                                        const bookingDates = data.bookings.map(item => item.date);
                                                        const bookingCounts = data.bookings.map(item => item.count);
                                                        const orderCounts = data.orders.map(item => item.count);
                                                        const userCounts = data.users.map(item => item.count);
                                                        chart.updateOptions({
                                                            xaxis: {
                                                                categories: bookingDates
                                                            },
                                                            series: [{
                                                                name: 'Đặt khám',
                                                                data: bookingCounts
                                                            }, {
                                                                name: 'Đơn thuốc',
                                                                data: orderCounts
                                                            }, {
                                                                name: 'Người truy cập',
                                                                data: userCounts
                                                            }],
                                                            tooltip: {
                                                                x: {
                                                                    format: getTooltipFormat(filter)

                                                                }
                                                            }
                                                        });
                                                    })
                                                    .catch(error => console.error('Error fetching data:', error));
                                            }

                                            // Initial load
                                            fetchChartData('today');
                                        });
                                    </script>
                                    <!-- End Line Chart -->
                                </div>
                            </div>
                        </div>
                    <!-- End Reports -->

                    <!-- Booking -->
                    <div class="col-12">
                        <div class="card recent-sales overflow-auto">
                            <div class="filter">
                                <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                    <li class="dropdown-header text-start">
                                        <h6>{{ __('home.Filter') }}</h6>
                                    </li>
                                    <li><a class="dropdown-item" href="{{ route('admin.home', ['booking-filter' => 'today']) }}">{{ __('home.Today') }}</a></li>
                                    <li><a class="dropdown-item" href="{{ route('admin.home', ['booking-filter' => 'this_month']) }}">{{ __('home.This Month') }}</a></li>
                                    <li><a class="dropdown-item" href="{{ route('admin.home', ['booking-filter' => 'this_year']) }}">{{ __('home.This Year') }}</a></li>
                                </ul>
                            </div>
                            <div class="card-body">
                                <h5 class="card-title">Đặt khám<span> | {{ $bookingFilterName }}</span></h5>

                                <table class="table table-borderless datatable">
                                    <thead>
                                    <tr>
                                        <th scope="col">Khách hàng</th>
                                        <th scope="col">Phòng khám/ Bệnh viện</th>
                                        <th scope="col">Chuyên Khoa</th>
                                        <th scope="col">Ngày đặt lịch</th>
                                        <th scope="col">Ngày đặt khám</th>
                                        <th scope="col">Trạng thái</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($bookings as $booking)
                                            <tr>
                                                <td>{{$booking->user->name ?? 'Không có người đặt'}}</td>
                                                <td>{{$booking->clinic->name ?? 'Không có tên BV/PK'}}</td>
                                                <td>{{$booking->department->name ?? 'Không có chuyên khoa'}}</td>
                                                <td>{{$booking->created_at}}</td>
                                                <td>{{$booking->check_in}}</td>
                                                <td>{{$booking->status}}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                                <h6 class="mt-4"><strong>* <u>Tỉ lệ huỷ lịch khám</u>: </strong> {{ number_format(($bookings->where('status', "CANCEL")->count() / max($bookings->count(), 1)) * 100, 2) }}%</h6>
                                <h6 class="mt-2"><strong>* <u>Tỉ lệ bệnh nhân đặt lại</u>: </strong> {{ number_format(($userReBooking->count() / $userCount) * 100, 2)}}%</h6>
                                <h6 class="mt-2"><strong>* <u>Top chuyên khoa có số lượng đặt khám nhiều nhất</u>: </strong></h6>
                                <table class="table table-borderless">
                                    <thead>
                                    <tr>
                                        <th scope="col">Chuyên khoa</th>
                                        <th scope="col">Số lượng</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @forelse($departmentCounts as $departmentId => $count)
                                        @php
                                            $department = \App\Models\Department::find($departmentId);
                                        @endphp
                                        @if($department)
                                            <tr>
                                                <td>{{ $department->name }}</td>
                                                <td>{{ $count }}</td>
                                            </tr>
                                        @endif
                                    @empty
                                        <tr>
                                            <td colspan="2">Không có lịch khám trong {{ $bookingFilterName }}</td>
                                        </tr>
                                    @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Recent Sales -->
                    <div class="col-12">
                        <div class="card recent-sales overflow-auto">
                            <div class="filter">
                                <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                    <li class="dropdown-header text-start">
                                        <h6>{{ __('home.Filter') }}</h6>
                                    </li>
                                    <li><a class="dropdown-item" href="{{ route('admin.home', ['order-filter' => 'today']) }}">{{ __('home.Today') }}</a></li>
                                    <li><a class="dropdown-item" href="{{ route('admin.home', ['order-filter' => 'this_month']) }}">{{ __('home.This Month') }}</a></li>
                                    <li><a class="dropdown-item" href="{{ route('admin.home', ['order-filter' => 'this_year']) }}">{{ __('home.This Year') }}</a></li>
                                </ul>
                            </div>
                            <div class="card-body">
                                <h5 class="card-title">Đơn hàng<span> | {{ $orderFilterName }}</span></h5>
                                <table class="table table-borderless datatable">
                                    <thead>
                                    <tr>
                                        <th scope="col">Khách hàng</th>
                                        <th scope="col">SĐT</th>
                                        <th scope="col">Địa chỉ</th>
                                        <th scope="col">Tổng hoá đơn (VNĐ)</th>
                                        <th scope="col">Ngày mua hàng</th>
                                        <th scope="col">Trạng thái</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($orders as $order)
                                            <tr>
                                                <td>{{$order->full_name}}</td>
                                                <td>{{$order->phone}}</td>
                                                <td>{{$order->address}}</td>
                                                <td>{{ number_format($order->total, 0, '.', '.') }} </td>
                                                <td>{{$order->created_at}}</td>
                                                <td>{{$order->status}}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <h6 class="mt-4"><strong>* <u>Tỉ lệ huỷ đơn</u>: </strong> {{ number_format(($orders->where('status', "CANCELLED")->count() / max($orders->count(), 1)) * 100, 2) }}%</h6>
                                <h6 class="mt-2"><strong>* <u>Tỉ lệ hoàn đơn</u>: </strong> {{ number_format(($orders->where('status', "REFUND")->where('type_order', 1)->count() / max($orders->count(), 1)) * 100, 2) }}%</h6>
                                <h6 class="mt-2"><strong>* <u>Top loại thuốc được mua nhiều nhất</u>: </strong></h6>
                                <table class="table table-borderless">
                                    <thead>
                                    <tr>
                                        <th scope="col">Loại thuốc</th>
                                        <th scope="col">Số lượng</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @forelse($topOrderCount as $item)
                                        @php
                                            $product = \App\Models\online_medicine\ProductMedicine::find($item->product_id);
                                        @endphp
                                        @if($product)
                                            <tr>
                                                <td>{{ $product->name }}</td>
                                                <td>{{ $item->total }}</td>
                                            </tr>
                                        @endif
                                    @empty
                                        <tr>
                                            <td colspan="2">Không có đơn hàng trong {{ $orderFilterName }}</td>
                                        </tr>
                                    @endforelse
                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>
                    <!-- End Recent Sales -->

                </div>
            </div>
        </div>
    </section>
@endsection
