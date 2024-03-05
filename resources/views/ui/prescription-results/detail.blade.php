@extends('layouts.master')
@section('title')
    Perscrition Result
@endsection
@section('content')
    @include('layouts.partials.header')
    @include('component.banner')
    <div class="container">
        <div class="row">
            <div class="form-group col-md-6">
                <label for="full_name_value">{{ __('home.Full Name') }}</label>
                <input disabled type="text" class="form-control full_name" value="{{ $prescription->full_name }}"
                       id="full_name_value" name="full_name">
            </div>
            <div class="form-group col-md-6">
                <label for="email_value">{{ __('home.Email') }}</label>
                <input disabled type="text" class="form-control" id="email_value" value="{{ $prescription->email }}"
                       placeholder="{{ __('home.Please enter your email') }}">
            </div>
        </div>
        <div class="list-service-result mt-2 mb-3">
            <div id="list-service-result">
                @if(is_array($array_result))
                    @foreach($array_result as $item)
                        <div class="service-result-item d-flex align-items-center justify-content-between border p-3">
                            <div class="row w-75">
                                <div class="form-group">
                                    <label for="medicine_name">Medicine Name</label>
                                    <input disabled type="text" class="form-control medicine_name"
                                           value="{{ $item['medicine_name'] }}" id="medicine_name"
                                           name="medicine_name">
                                </div>
                                <div class="form-group">
                                    <label for="medicine_ingredients">Medicine Ingredients</label>
                                    <input disabled type="text" class="form-control medicine_ingredients"
                                           value="{{ $item['medicine_ingredients'] }}" id="medicine_ingredients">
                                </div>
                                <div class="form-group">
                                    <label for="quantity">{{ __('home.Quantity') }}</label>
                                    <input disabled type="number" min="1" class="form-control quantity"
                                           value="{{ $item['quantity'] }}" id="quantity">
                                </div>
                                <div class="form-group">
                                    <label for="detail_value">Detail</label>
                                    <input disabled type="text" class="form-control detail_value" id="detail_value"
                                           value="{{ isset($item['note']) ? $item['note'] : '' }}">
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
        <div class="d-flex align-items-center justify-content-end">
            @if(Auth::user()->id == $prescription->user_id)
                <button type="button" class="btn btn-outline-success mt-3 mr-3" id="btnAddToCart">
                    {{ $prescription->isFirstBuy ? 'Mua lại' : 'Thêm vào giỏ hàng' }}
                </button>
            @endif
            <button type="button" class="btn btn-outline-primary mt-3 " id="btnConvert">
                Export
            </button>
        </div>
    </div>
    <script>
        let accessToken = `Bearer ` + token;
        let headers = {
            "Authorization": accessToken
        };

        $('#btnAddToCart').click(function () {
            addToCart();
        });

        $('#btnConvert').click(function () {
            exportAndDownload();
        });

        async function addToCart() {
            loadingMasterPage();
            let data = {
                prescription_id: `{{ $prescription->id }}`,
                user_id: `{{ Auth::user()->id }}`,
            };

            try {
                await $.ajax({
                    url: `{{ route('api.backend.prescription.result.add.cart.v2') }}`,
                    method: 'POST',
                    headers: headers,
                    data: data,

                    success: function (response, textStatus, xhr) {
                        loadingMasterPage();
                        console.log(response);
                        alert(response.message);
                        var statusCode = xhr.status;
                        if (statusCode === 200) {
                            window.location.href = `{{ route('user.checkout.index') }}`;
                        }
                    },
                    error: function (xhr, status, error) {
                        loadingMasterPage();
                        alert(xhr.responseJSON.message);
                    }
                });
            } catch (e) {
            }
        }

        async function exportAndDownload() {
            loadingMasterPage();
            let data = {
                prescription_id: `{{ $prescription->id }}`,
            };

            try {
                await $.ajax({
                    url: `{{ route('api.backend.prescription.result.export') }}`,
                    method: 'POST',
                    headers: headers,
                    data: data,
                    xhrFields: {
                        responseType: 'blob'
                    },
                    success: function (data) {
                        loadingMasterPage();
                        var blob = new Blob([data], {type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'});
                        var url = window.URL.createObjectURL(blob);
                        var a = document.createElement('a');
                        a.href = url;
                        a.download = 'prescription.xlsx';
                        document.body.appendChild(a);
                        a.click();
                        window.URL.revokeObjectURL(url);
                        document.body.removeChild(a);
                    },
                    error: function (xhr, status, error) {
                        loadingMasterPage();
                        alert(xhr.responseJSON.message);
                    }
                });
            } catch (e) {
                console.log(e)
                alert('Error, Please try again!');
            }
        }
    </script>
    {{-- Handle input disabled --}}
    <script>
        let html = `<div class="service-result-item d-flex align-items-center justify-content-between border p-3">
                    <div class="row w-75">
                        <div class="form-group">
                            <label for="medicine_name">Medicine Name</label>
                            <input disabled type="text" class="form-control medicine_name" value="" id="medicine_name"
                                   name="medicine_name">
                        </div>
                        <div class="form-group">
                            <label for="medicine_ingredients">Medicine Ingredients</label>
                            <input disabled type="text" class="form-control medicine_ingredients" id="medicine_ingredients">
                        </div>
                        <div class="form-group">
                            <label for="quantity">{{ __('home.Quantity') }}</label>
                            <input disabled type="number" min="1" class="form-control quantity" id="quantity">
                        </div>
                    </div>
                    <div class="action mt-3">
                        <i class="fa-regular fa-trash-can btnTrash" style="cursor: pointer; font-size: 24px"></i>
                    </div>
                </div>`;

        $(document).ready(function () {
            $('.btnAddNewResult').on('click', function () {
                $('#list-service-result').append(html);
                loadTrash();
                loadData();
            })

            loadTrash();

            function loadTrash() {
                $('.btnTrash').on('click', function () {
                    let main = $(this).parent().parent();
                    main.remove();
                })
            }

            loadData();

            function loadData() {
                $('.service_name_item').on('click', function () {
                    let my_array = null;
                    let my_name = null;
                    $(this).parent().parent().find(':checkbox:checked').each(function (i) {
                        let value = $(this).val();
                        if (my_array) {
                            my_array = my_array + ',' + value;
                        } else {
                            my_array = value;
                        }

                        let name = $(this).data('name');
                        if (my_name) {
                            my_name = my_name + ', ' + name;
                        } else {
                            my_name = name;
                        }
                    });
                    $(this).parent().parent().prev().val(my_name);
                    $(this).parent().parent().next().find('input disabled').val(my_array);
                })
            }
        })
    </script>
@endsection
