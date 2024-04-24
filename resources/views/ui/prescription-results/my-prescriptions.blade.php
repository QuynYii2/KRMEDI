@extends('layouts.admin')
@section('title')
    List Prescription
@endsection
@section('page-style')
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.1/css/dataTables.dataTables.css" />
@endsection
@section('main-content')
    <div class="">
        <!-- Page Heading -->
        <h1 class="h3 mb-4 text-gray-800">{{ __('home.My Prescription') }}</h1>
        <div class="d-flex align-items-center justify-content-between">
            <div class="mb-3 col-md-3">
                <input class="form-control" id="inputSearch" type="text" placeholder="Search.." />
            </div>
        </div>
        <br>
        <table class="table" id="tableListPrescription">
            <thead>
                <tr>
                    <th class="text-center" scope="col">{{ __('home.STT') }}</th>
                    <th class="text-center" scope="col">Mã đơn thuốc</th>
                    <th class="text-center" scope="col">Lưu ý của bác sĩ</th>
                    <th class="text-center" scope="col">Bác sĩ kê đơn</th>
                    <th class="text-center" scope="col">Số ngày điều trị</th>
                    <th class="text-center" scope="col">Ngày kê đơn</th>
                    <th class="text-center" scope="col">{{ __('home.Status') }}</th>
                </tr>
            </thead>
            <tbody id="tbodyListPrescription">
                @foreach ($prescription as $key => $pre)
                    <tr>
                        <td class="text-center">{{ $key + 1 }}</td>
                        <td class="text-center">{{ $pre->prescription_id }}</td>
                        <td class="text-center">{{ $pre->note }}</td>
                        <td class="text-center">{{ $pre->doctors->name ?? '' }}</td>
                        <td class="text-center">{{ $pre->treatment_days }}</td>
                        <td class="text-center">{{ date('H:i d/m/Y', strtotime($pre->created_at)) }}</td>
                        <td class="text-center">{{ $pre->status }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
@section('page-script')
    <script src="https://cdn.datatables.net/2.0.1/js/dataTables.js"></script>
    <script>
        $(document).ready(function() {
            $('#tableListPrescription').DataTable();
        });
    </script>
@endsection
