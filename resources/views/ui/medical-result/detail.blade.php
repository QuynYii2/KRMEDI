@extends('layouts.admin')
@section('title')
    Detail Medical Result
@endsection
@section('main-content')
    <div class="">
        <!-- Page Heading -->
        <h1 class="h3 mb-4 text-gray-800"> Detail Medical Result </h1>
        <form>
            <div class="row">
                <div class="form-group col-md-6">
                    <label for="full_name">Full Name</label>
                    <input disabled type="text" class="form-control" id="full_name" value="{{ $result->full_name }}">
                </div>
                <div class="form-group col-md-6">
                    <label for="phone">Phone</label>
                    <input disabled type="text" class="form-control" id="phone" value="{{ $result->phone }}">
                </div>
            </div>
            <div class="form-group mb-3">
                <label for="address">Address</label>
                <input disabled type="text" class="form-control" id="address" value="{{ $result->address }}">
            </div>
            <div class="list-service-result mt-2 mb-3">
                <div id="list-service-result">
                    @foreach($array_result as $item)
                        <div class="service-result-item d-flex align-items-center justify-content-between border p-3">
                            <div class="service-result w-75">
                                <div class="form-group">
                                    <label for="service_name">{{ __('home.Service Name') }}</label>
                                    <input disabled type="text" class="form-control service_result" id="service_name"
                                           value="{{ $item['service_result'] }}"
                                           placeholder="Apartment, studio, or floor">
                                </div>
                                <div class="form-group">
                                    <label for="result">{{ __('home.Result') }}</label>
                                    <input disabled type="text" class="form-control result"
                                           value="{{ $item['result'] }}"
                                           id="result" placeholder="{{ __('home.Result') }}">
                                </div>
                                <div class="form-group">
                                    <label for="result_en">{{ __('home.Result En') }}</label>
                                    <input disabled type="text" class="form-control result_en"
                                           value="{{ $item['result_en'] }}"
                                           id="result_en" placeholder="{{ __('home.Result En') }}">
                                </div>
                                <div class="form-group">
                                    <label for="result_laos">{{ __('home.Result Laos') }}</label>
                                    <input disabled type="text" class="form-control result_laos"
                                           value="{{ $item['result_laos'] }}" id="result_laos"
                                           placeholder="{{ __('home.Result Laos') }}">
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-8">
                    <label for="place">Place</label>
                    <input disabled type="text" class="form-control" id="place" value="{{ $result->place }}">
                </div>
                <div class="form-group col-md-4">
                    <label for="datetime">Datetime</label>
                    <input disabled type="datetime-local" class="form-control" id="datetime"
                           value="{{ $result->datetime }}">
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-2">
                    <button type="button" class="btnDownloadFile btn btn-outline-warning mt-4">
                        {{ __('home.Xem đơn đã upload') }}
                    </button>
                </div>
                <div class="form-group col-md-2">
                    <button type="button" class=" btn btn-outline-success mt-4" data-toggle="modal"
                            data-target="#modalShowProductMedicines">
                        {{ __('home.Product Medicine') }}
                    </button>
                </div>
            </div>
            @php
                $array_file = null;
                $files = $result->files;
                if ($files){
                    $array_file = explode(',',$files);
                }
            @endphp
            <div class="title mt-3">List attachments files:</div>
            <div class="form-group d-flex">
                @if($array_file)
                    @foreach($array_file as $file)
                        <img src="{{ asset($file) }}" alt="" style="max-width: 100px; object-fit: cover"
                             class="m-3">
                    @endforeach
                @endif
            </div>

            <div class="form-group">
                <label for="detail">{{ __('home.Detail') }}</label>
                <textarea class="form-control" id="detail" rows="5">{{ $result->detail }}</textarea>
            </div>
            <div class="form-group">
                <label for="detail_en">{{ __('home.Detail En') }}</label>
                <textarea class="form-control" id="detail_en" rows="5">{{ $result->detail_en }}</textarea>
            </div>
            <div class="form-group">
                <label for="detail_laos">{{ __('home.Detail Lao') }}</label>
                <textarea class="form-control" id="detail_laos" rows="5">{{ $result->detail_laos }}</textarea>
            </div>
        </form>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="modalShowProductMedicines" tabindex="-1"
         aria-labelledby="modalShowProductMedicinesLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalShowProductMedicinesLabel">List Product</h5>
                    <button type="button" class="close btn" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    @if($products)
                        @foreach($products as $product)
                            <div class="product-modal d-flex align-items-center mb-3">
                                <div class="img">
                                    <img src="{{asset($product->thumbnail)}}" alt="">
                                </div>
                                <div class="title">
                                    <div class="title-name">
                                        {{ $product->name }}
                                    </div>
                                    <div class="price">
                                        {{ number_format($product->price, 0, ',', '.') }}  {{ $product->unit_price }}
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        No product!
                    @endif
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button"
                            {{ count($products) > 0 ? '' : 'disabled' }} class="btn btnCheckOutNow btn-primary">
                        Buy now
                    </button>
                </div>
            </div>
        </div>
    </div>
    <style>
        .product-modal img {
            max-width: 100px;
            height: auto;
            object-fit: cover;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .title {
            margin-left: 8px;
        }

        .title-name {
            font-size: 18px;
            font-weight: 600;
        }

        .price {
            font-size: 20px;
            font-weight: 600;
        }
    </style>

    <script>
        $(document).ready(function () {
            $('.btnCheckOutNow').click(function () {
                addProductToCart();
            });
        })

        let accessToken = `Bearer ${token}`;

        async function addProductToCart() {
            let urlResult = `{{ route('restapi.get.products.medicines.result', $result->id) }}`;

            await $.ajax({
                url: urlResult,
                method: 'POST',
                headers: {
                    "Authorization": accessToken
                },
                success: function (response) {
                    alert(response.message);
                    window.location.href = `{{ route('user.checkout.index') }}`;
                },
                error: function (exception) {
                    console.log(exception);
                }
            });
        }

        $('.btnDownloadFile').on('click', function () {
            let url = `{{ route('user.download.file', $result->id) }}`;
            let alertMessage = `Vui lòng nhập vào file theo định dạng mẫu đã được viết sẵn! Chúng tôi không khuyến khích bất kì hành động thay đổi định dạng file hoặc cấu trúc dữ liệu trong file vì điều này sẽ ảnh hướng đến việc đọc hiểu dữ liệu.`
            if (confirm(alertMessage)) {
                window.location.href = url;
            }
        })
    </script>
@endsection
