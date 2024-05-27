@extends('layouts.admin')
@section('title')
    List Prescription
@endsection
@section('main-content')
    <div class="container-fluid">
        <!-- Page Heading -->
        <h1 class="h3 mb-4 text-gray-800">{{ __('home.My Prescription') }}</h1>
        <div>
            <form class="d-flex form-prescription" method="GET" action="{{ route('view.prescription.result.my.list') }}" style="padding-left: 0; column-gap: 10px">
                <input class="form-control" name="search" id="inputSearch" type="text" placeholder="Search.." value="{{ request('search') }}" />
                <button type="submit" class="btn btn-primary">Search</button>
            </form>
        </div>
        <br>
        <div class="table-responsive">
            <table class="table table-vcenter text-nowrap table-bordered border-bottom">
                <thead>
                <tr>
                    <th class="text-center" scope="col">{{ __('home.STT') }}</th>
                    <th class="text-center" scope="col">Mã đơn thuốc</th>
                    <th class="text-center" scope="col">Bác sĩ kê đơn</th>
                    <th class="text-center" scope="col">Ngày kê đơn</th>
                    <th class="text-center" scope="col">{{ __('home.Status') }}</th>
                </tr>
                </thead>
                <tbody id="tbodyListPrescription">
                @foreach ($listPrescriptions as $key => $pre)
                    <tr>
                        <td class="text-center">{{ $key + 1 }}</td>
                        <td style="cursor: pointer" class="text-center text-decoration-underline" data-bs-toggle="modal"
                            data-bs-target="#prescriptionDetails{{ $pre->prescription_id }}">{{ $pre->prescription_id }}
                        </td>
                        <td class="text-center">{{ $pre->doctors->name ?? '' }}</td>
                        <td class="text-center">{{ date('H:i d/m/Y', strtotime($pre->created_at)) }}</td>
                        <td class="text-center">{{ $pre->status }}</td>
                    </tr>
                @endforeach
                </tbody>

            </table>
            <div class="d-flex justify-content-center">
                {!! $listPrescriptions->appends(Request::except('page'))->links() !!}
            </div>
        </div>
    </div>

    <!-- Prescription details -->
    @foreach ($prescriptions as $key => $pre)
        @php
            $data = $pre['data'];
        @endphp
        <div class="modal fade" id="prescriptionDetails{{ $pre['prescription_id'] }}" data-bs-backdrop="static"
            data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title text-dark" id="exampleModalLongTitle">Đơn thuốc
                            #<strong>{{ $pre['prescription_id'] }}</strong></h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <table class="table text-center">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Sản phẩm</th>
                                    <th scope="col">Số lượng</th>
                                    <th scope="col">Ngày điều trị</th>
                                    <th scope="col">Lưu ý</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($data as $keyData => $item)
                                    <tr>
                                        <th scope="row" class="align-middle">{{ $keyData + 1 }}</th>
                                        <td class="align-middle">
                                            <p>{{ $item->productMedicine->name }}</p>
                                            <img width="130px" height="90px"
                                                src="{{ $item->productMedicine->thumbnail }}">
                                        </td>
                                        <td class="align-middle">{{ $item->quantity }}</td>
                                        <td class="align-middle">{{ $item->treatment_days }}</td>
                                        <td class="align-middle">{{ $item->note }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5">
                                            Chưa có đơn thuốc nào được kê
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        @if ($listPrescriptions[$key]->status == \App\Enums\CartStatus::COMPLETE)
                            <a href="{{ route('user.checkout.reorder', ['prescription_id' => $listPrescriptions[$key]->prescription_id]) }}"
                                type="button" class="btn btn-primary text-white">Mua lại</a>
                        @else
                            <a href="{{ route('user.checkout.index', ['prescription_id' => $listPrescriptions[$key]->prescription_id]) }}"
                                type="button" class="btn btn-primary text-white">Đến trang thanh toán</a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endforeach
    <!-- Prescription details -->
@endsection
