@extends('layouts.master')
@section('title')
    Perscrition Result
@endsection
@section('content')
    @include('layouts.partials.header')
    @include('component.banner')
    <style>
        .frame.component-medicine.w-100 {
            box-shadow: 0px 4px 4px 0px rgba(0, 0, 0, 0.25);
        }

        @media (max-width: 575px) {
            .div .div-2 a .text-wrapper {
                font-size: 12px;
            }

            .text-wrapper-2, .text-wrapper-4 {
                font-size: 12px !important;
            }
        }

        .sold-out-overlay {
            opacity: .5;
            pointer-events: none;
        }

        .sold-out-overlay .sold-out-overlay-text {
            position: absolute;
            color: black;
            top: 30%;
            display: block;
        }

        .find-my-medicine-2 .frame {
            display: inline-flex;
            flex-direction: column;
            align-items: center;
            gap: 12px;
            position: relative;
            background-color: #088180;
            border-radius: 24px;
            border: 1px solid;
            border-color: var(--grey-medium);
        }

        .find-my-medicine-2 .frame .rectangle {
            position: relative;
            object-fit: cover;
        }

        .find-my-medicine-2 .frame .div {
            display: flex;
            flex-direction: column;
            align-items: flex-end;
            gap: 16px;
            position: relative;
            align-self: stretch;
            width: 100%;
            flex: 0 0 auto;
        }

        .find-my-medicine-2 .frame .div-2 {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            gap: 8px;
            padding: 0px 16px;
            position: relative;
            align-self: stretch;
            width: 100%;
            flex: 0 0 auto;
        }

        .find-my-medicine-2 .frame .text-wrapper {
            position: relative;
            width: fit-content;
            margin-top: -1px;
            font-weight: var(--body-1-extra-font-weight);
            color: var(--white);
            font-size: var(--body-1-extra-font-size);
            text-align: center;
            letter-spacing: var(--body-1-extra-letter-spacing);
            line-height: var(--body-1-extra-line-height);
            font-style: var(--body-1-extra-font-style);
        }

        .find-my-medicine-2 .frame .div-3 {
            display: inline-flex;
            align-items: flex-start;
            gap: 12px;
            position: relative;
            flex: 0 0 auto;
        }

        .find-my-medicine-2 .frame .marker-pin {
            position: relative;
            width: 20px;
            height: 20px;
        }

        .find-my-medicine-2 .frame .text-wrapper-2 {
            position: relative;
            width: fit-content;
            margin-top: -1px;
            font-weight: var(--body-4-extra-font-weight);
            color: var(--white);
            font-size: var(--body-4-extra-font-size);
            text-align: center;
            letter-spacing: var(--body-4-extra-letter-spacing);
            line-height: var(--body-4-extra-line-height);
            font-style: var(--body-4-extra-font-style);
        }

        .find-my-medicine-2 .frame .text-wrapper-3 {
            position: relative;
            width: fit-content;
            font-weight: var(--subtitle-1-extra-font-weight);
            color: var(--white);
            font-size: var(--subtitle-1-extra-font-size);
            text-align: center;
            letter-spacing: var(--subtitle-1-extra-letter-spacing);
            line-height: var(--subtitle-1-extra-line-height);
            font-style: var(--subtitle-1-extra-font-style);
        }

        .find-my-medicine-2 .frame .div-wrapper {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            padding: 16px 40px;
            position: relative;
            flex: 0 0 auto;
            margin-bottom: -1px;
            margin-right: -1px;
            background-color: var(--white);
            border-radius: 60px 0px 24px 0px;
            overflow: hidden;
        }

        .find-my-medicine-2 .frame .text-wrapper-4 {
            position: relative;
            width: fit-content;
            font-weight: var(--subtitle-1-extra-font-weight);
            color: var(--black);
            font-size: var(--subtitle-1-extra-font-size);
            letter-spacing: var(--subtitle-1-extra-letter-spacing);
            line-height: var(--subtitle-1-extra-line-height);
            font-style: var(--subtitle-1-extra-font-style);
        }

        .find-my-medicine-2 .frame .img {
            position: absolute;
            width: 24px;
            height: 24px;
            top: 20px;
            left: 225px;
        }

        .find-my-medicine-2 .frame .group {
            position: absolute;
            width: 116px;
            height: 114px;
            top: -19px;
            left: -19px;
        }

        .find-my-medicine-2 .frame .overlap-group {
            position: relative;
            width: 95px;
            height: 95px;
            top: 19px;
            left: 19px;
            background-image: url(https://c.animaapp.com/ItWXPcpR/img/rectangle-23800-2.svg);
            background-size: 100% 100%;
        }

        .find-my-medicine-2 .frame .text-wrapper-5 {
            position: absolute;
            height: 23px;
            top: 26px;
            left: 19px;
            transform: rotate(-45deg);
            font-weight: var(--body-1-extra-font-weight);
            color: #ffffff;
            font-size: var(--body-1-extra-font-size);
            letter-spacing: var(--body-1-extra-letter-spacing);
            line-height: var(--body-1-extra-line-height);
            font-style: var(--body-1-extra-font-style);
        }

        .find-my-medicine-2 .text-wrapper.text-ellipsis {
            text-overflow: ellipsis;
        }

        .find-my-medicine-2 .frame .frame-wrapper-heart {
            display: inline-flex;
            align-items: flex-start;
            gap: 10px;
            padding: 8px;
            position: absolute;
            top: 8px;
            right: 8px;
            background-color: var(--light);
            border-radius: 51px;
        }

        .find-my-medicine-2 .frame .frame-wrapper-heart i {
            font-size: 24px;
        }

        .find-my-medicine-2 .border-img {
            border-radius: 13px 13px 100px 0px;
            object-fit: cover;
        }

        .find-my-medicine .frame:hover, .find-my-medicine-2 .frame:hover {
            border-radius: 22px;
            background: #088180;
            box-shadow: 0px 8px 10px 0px rgba(0, 0, 0, 0.25);
        }
    </style>


    <div class="container">
        <div class="row">
            <div class="form-group col-md-6">
                <label for="full_name_value">{{ __('home.Full Name') }}</label>
                <input type="text" class="form-control full_name"
                       value="{{ $user ? $user->last_name . ' ' . $user->name : '' }}"
                       {{ $user ? $user->last_name || $user->name ? 'disabled' : '' : '' }} id="full_name_value"
                       name="full_name">
            </div>
            <div class="form-group col-md-6">
                <label for="email_value">{{ __('home.Email') }}</label>
                <input type="text" class="form-control" id="email_value" value="{{ $user ? $user->email : '' }}"
                       {{ $user ? $user->email ? 'disabled' : '' : '' }}
                       placeholder="{{ __('home.E-Mail Address') }}">
            </div>
        </div>
        <div class="list-service-result mt-2 mb-3">
            <div id="list-service-result-pre">

            </div>
            <button type="button"
                    class="btn btn-outline-primary mt-3 btnAddNewResult">{{ __('home.Add') }}
            </button>
        </div>
        <button type="button" class="btn btn-primary " id="btnCreate">Create</button>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="modal-add-medicine" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl">
            <div class="modal-content">
                <div class="modal-header row">
                    <form>
                        <div class="col-sm-4 col">
                            <div class="form-group position-relative">
                                <label for="inputSearchDoctor" class="fa fa-search form-control-feedback"></label>
                                <input type="search" id="inputSearchDoctor" class="form-control"
                                       name="nameSearch"
                                       placeholder="{{ __('home.Search for anything…') }}">
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-body find-my-medicine-2">
                    <div class="row" id="modal-list-medicine">

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        let accessToken = `Bearer ` + token;
        let headers = {
            "Authorization": accessToken
        };
        let elementInputMedicine;

        $(document).ready(function () {
            $('#btnCreate').click(function () {
                createPrescription();
            });
        });

        async function createPrescription() {
            const formData = new FormData();

            let full_name_value = $('#full_name_value').val();
            let email_value = $('#email_value').val();

            if (!full_name_value) {
                alert('Please enter full name!')
                return;
            }

            if (!email_value) {
                alert('Please enter email!')
                return;
            }

            formData.append('full_name', full_name_value);
            formData.append('email', email_value);
            formData.append('created_by', `{{ \Illuminate\Support\Facades\Auth::user()->id }}`);

            const itemList = [
                'prescriptions',
            ];

            let my_array = [];

            let medicine_name = document.getElementsByClassName('medicine_name');
            let medicine_ingredients = document.getElementsByClassName('medicine_ingredients');
            let quantity = document.getElementsByClassName('quantity');
            let detail = document.getElementsByClassName('detail_value');

            for (let j = 0; j < medicine_name.length; j++) {
                let name = medicine_name[j].value;
                let ingredients = medicine_ingredients[j].value;
                let quantity_value = quantity[j].value;
                let detail_value = detail[j].value;

                if (!name && !ingredients) {
                    alert('Please enter medicine name or medicine ingredients or quantity!')
                    return;
                }
                let item = {
                    medicine_name: name,
                    medicine_ingredients: ingredients,
                    quantity: quantity_value,
                    note: detail_value ?? '',
                }
                item = JSON.stringify(item);
                my_array.push(item);
            }

            itemList.forEach(item => {
                formData.append(item, my_array.toString());
            });

            try {
                await $.ajax({
                    url: `{{ route('api.backend.prescription.result.create') }}`,
                    method: 'POST',
                    headers: headers,
                    contentType: false,
                    cache: false,
                    processData: false,
                    data: formData,
                    success: function (response) {
                        console.log(response)
                        alert('Create success!')
                        window.location.href = `{{ route('view.prescription.result.doctor') }}`;
                    },
                    error: function (error) {
                        alert(error.responseJSON.message);
                    }
                });
            } catch (e) {
                console.log(e)
                alert('Error, Please try again!');
            }
        }

        let html = `<div class="service-result-item d-flex align-items-center justify-content-between border p-3">
                    <div class="row w-75">
                        <div class="form-group">
                            <label for="medicine_name">Medicine Name</label>
                            <input type="text" class="form-control medicine_name" value="" id="medicine_name"
                                   name="medicine_name" onclick="handleClickInputMedicine(this)" data-toggle="modal" data-target="#modal-add-medicine" readonly>
                        </div>
                        <div class="form-group">
                            <label for="medicine_ingredients">Medicine Ingredients</label>
                            <input type="text" class="form-control medicine_ingredients" id="medicine_ingredients">
                        </div>
                        <div class="form-group">
                            <label for="quantity">{{ __('home.Quantity') }}</label>
                            <input type="number" min="1" class="form-control quantity" id="quantity">
                        </div>
                        <div class="form-group">
                            <label for="detail_value">Note</label>
                            <input type="text" class="form-control detail_value" id="detail_value">
                        </div>
                    </div>
                    <div class="action mt-3">
                        <i class="fa-regular fa-trash-can btnTrash" style="cursor: pointer; font-size: 24px"></i>
                    </div>
                </div>`;

        $(document).ready(function () {
            $('#list-service-result-pre').append(html);
            $('.btnAddNewResult').on('click', function () {
                $('#list-service-result-pre').append(html);
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
                    $(this).parent().parent().next().find('input').val(my_array);
                })
            }
        })

        function handleSelectInputMedicine(id, name) {
            elementInputMedicine.value = name;
        }

        function handleClickInputMedicine(element) {
            elementInputMedicine = element;
        }

        loadListMedicine();

        function loadListMedicine() {
            $.ajax({
                url: `{{ route('view.prescription.result.get-medicine') }}`,
                method: 'GET',
                headers: headers,
                success: function (response) {
                    renderMedicine(response);
                },
                error: function (error) {
                    console.log(error)
                }
            });
        }

        function renderMedicine(data) {
            let html = '';
            data.forEach((medicine) => {
                let url = '{{ route('medicine.detail', ':id') }}';
                url = url.replace(':id', medicine.id);

                html += `<div class="col-sm-6 col-xl-4 mb-3 col-12 find-my-medicine-2">
                                <div class="m-md-2 ">
                                    <div class="frame component-medicine w-100">
                                        <div class="img-pro justify-content-center d-flex img_product--homeNew">
                                            <img loading="lazy" class="rectangle border-img"
                                                 src="${medicine.thumbnail}"/>
                                        </div>
                                        <div class="div">
                                            <div class="div-2">
                                                <a target="_blank" class="w-100"
                                                   href="${url}">
                                                    <div
                                                        class="text-wrapper text-nowrap overflow-hidden text-ellipsis w-100">${medicine.name}</div>
                                                </a>
                                                <div
                                                    class="text-wrapper-3">${medicine.price} ${medicine.unit_price ?? 'VND'}</div>
                                            </div>
                                            <div class="div-wrapper">
                                                <a onclick="handleSelectInputMedicine('${medicine.id}', '${medicine.name}')"
                                                   data-dismiss="modal">
                                                    <div class="text-wrapper-4">{{ __('home.Choose...') }}</div>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>`
            });

            $('#modal-list-medicine').html(html);
        }
    </script>
@endsection
