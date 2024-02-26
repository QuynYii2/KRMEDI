@php use App\Enums\CouponStatus; @endphp
@php use App\Enums\TypeCoupon;use Illuminate\Support\Facades\Auth; @endphp
@extends('layouts.admin')
@section('title', 'List Coupon')
@section('main-content')
    <link href="{{ asset('css/tabcreatecoupon.css') }}" rel="stylesheet">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">{{ __('home.Create Coupon') }}</h1>
    @if (session('success'))
        <div class="alert alert-success border-left-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
    <form id="form" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-sm-4">
                <label for="title">{{ __('home.tiêu đề việt') }}</label>
                <input type="text" class="form-control" id="title" name="title">
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6">
                <label for="short_description">{{ __('home.Phần thưởng') }}</label>
                <textarea class="form-control" name="short_description" id="short_description"></textarea>
            </div>
            <div class="col-sm-6">
                <label for="condition">{{ __('home.Điều khoản và điều kiện') }}</label>
                <textarea class="form-control" name="condition" id="condition"></textarea>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6">
                <label for="conduct">{{ __('home.Hướng dẫn chiến dịch') }}</label>
                <textarea class="form-control" name="conduct" id="conduct"></textarea>
            </div>
            <div class="col-sm-6">
                <label for="description">{{ __('home.Yêu cầu nội dung') }}</label>
                <textarea class="form-control" name="description" id="description"></textarea>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6">
                <label for="instruction">{{ __('home.Hướng dẫn chi tiết') }}</label>
                <textarea class="form-control" name="instruction" id="instruction"></textarea>
            </div>
            <div class="col-sm-6">
                <label for="website">{{ __('home.Website') }}</label>
                <textarea class="form-control" name="website" id="website"></textarea>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-4">
                <label for="startDate">{{ __('home.Thời gian bắt đầu ứng tuyển') }}</label>
                <input type="datetime-local" class="form-control" id="startDate" name="startDate"></div>
            <div class="col-sm-4">
                <label for="endDate">{{ __('home.Thời gian kết thúc ứng tuyển') }}</label>
                <input type="datetime-local" class="form-control" id="endDate" name="endDate"></div>
            <div class="col-sm-4">
                <label for="type">{{ __('home.type') }}</label>
                <select class="form-select" id="type" name="type">
                    @foreach(TypeCoupon::getArray() as $value)
                        <option value="{{ $value }}">{{ $value }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-4">
                <label for="start_selective">{{ __('home.	Thời gian bắt đầu chọn lọc') }}</label>
                <input type="datetime-local" class="form-control" id="start_selective" name="start_selective"></div>
            <div class="col-sm-4">
                <label for="end_selective">{{ __('home.Thời gian kết thúc chọn lọc') }}</label>
                <input type="datetime-local" class="form-control" id="end_selective" name="end_selective"></div>
            <div class="col-sm-4">
                <label for="status">{{ __('home.Status') }}</label>
                <select class="form-select" id="status" disabled>
                    <option value="{{ CouponStatus::ACTIVE }}">{{ CouponStatus::ACTIVE }}</option>
                    <option value="{{ CouponStatus::INACTIVE }}">{{ CouponStatus::INACTIVE }}</option>
                </select>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-4">
                <label for="start_post">{{ __('home.Thời gian bắt đầu đăng bài') }}</label>
                <input type="datetime-local" class="form-control" id="start_post" name="start_post"></div>
            <div class="col-sm-4">
                <label for="end_post">{{ __('home.Thời gian kết thúc đăng bài') }}</label>
                <input type="datetime-local" class="form-control" id="end_post" name="end_post"></div>
            <div class="col-sm-4">
                <label for="max_register">{{ __('home.Số lượng đký tối đa') }}</label>
                <input type="number" min="1" value="1" class="form-control" id="max_register" name="max_register">
            </div>
        </div>
        <div class="row">
            <div class="col-sm-4">
                <label for="start_evaluate">{{ __('home.Thời gian bắt đầu đánh giá') }}</label>
                <input type="datetime-local" class="form-control" id="start_evaluate" name="start_evaluate"></div>
            <div class="col-sm-4">
                <label for="end_evaluate">{{ __('home.Thời gian kết thúc đánh giá') }}</label>
                <input type="datetime-local" class="form-control" id="end_evaluate" name="end_evaluate"></div>
            <div class="col-sm-4">
                <label for="clinic_id">{{ __('home.Đơn vị áp dụng') }}</label>
                <select class="form-select" id="clinic_id">
                    <option selected>{{ __('home.Choose...') }}</option>
                </select>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <label for="is_facebook">{{ __('home.Có phải coupon facebook không') }}</label>
                <input type="checkbox" class="" id="is_facebook" name="is_facebook" value="1">
            </div>
            <div class="col">
                <label for="is_google">{{ __('home.Có phải coupon google không') }}</label>
                <input type="checkbox" class="" id="is_google" name="is_google" value="1">
            </div>
            <div class="col">
                <label for="is_youtube">{{ __('home.Có phải coupon youtube không') }}</label>
                <input type="checkbox" class="" id="is_youtube" name="is_youtube" value="1">
            </div>
            <div class="col">
                <label for="is_instagram">{{ __('home.Có phải coupon instagram không') }}</label>
                <input type="checkbox" class="" id="is_instagram" name="is_instagram" value="1">
            </div>
            <div class="col">
                <label for="is_tiktok">{{ __('home.Có phải coupon tiktok không') }}</label>
                <input type="checkbox" class="" id="is_tiktok" name="is_tiktok" value="1">
            </div>

        </div>

        <div class="row">
            <div class="col-sm-6"><label>{{ __('home.Ảnh bìa') }}</label>
                <div class="box">
                    <div class="js--image-preview"></div>
                    <div class="upload-options">
                        <label>
                            <input type="file" class="image-upload" accept="image/*" id="thumbnail"
                                   name="thumbnail"/>
                        </label>
                    </div>
                </div>
            </div>
        </div>
        <input type="hidden" value="{{ Auth::user()->id }}" name="user_id" id="user_id">

        <button type="button" class="btn btn-primary up-date-button mt-md-4">{{ __('home.Save') }}</button>
    </form>
    <script>
        $(document).ready(function () {
            $('.up-date-button').on('click', function () {
                const headers = {
                    'Authorization': `Bearer ${token}`
                };
                const formData = new FormData();

                const arrFieldEmptyChecked = [
                    'is_facebook', 'is_google', 'is_youtube', 'is_instagram', 'is_tiktok'
                ];

                const fieldNames = [
                    "title", "startDate", "endDate",
                    "max_register", "clinic_id", 'type', 'start_selective', 'end_selective',
                    'start_post', 'end_post', 'start_evaluate', 'end_evaluate', 'status', 'user_id'

                ];
                const fieldTextareaTiny = [
                    "short_description", "description", "condition", "conduct", "instruction", "website"
                ];
                arrFieldEmptyChecked.forEach(data => {
                    let checked = document.getElementById(data).checked;
                    if (checked) {
                        formData.append(data, $(`#${data}`).val());
                    }
                });

                let item = $('#max_register');
                let quantity = item.val();
                if (quantity < 1) {
                    quantity = 1;
                }
                item.val(quantity);

                let isValid = true

                let checking = true;
                for (let i = 0; i < fieldTextareaTiny.length; i++) {
                    let fieldTextarea = fieldTextareaTiny[i];
                    const content = tinymce.get(fieldTextarea).getContent();
                    if (!content) {
                        let labelElement = $(`label[for='${fieldTextarea}']`);
                        let text = labelElement.text();
                        if (!text) {
                            text = 'The input'
                        }
                        text = text + ' not empty!'
                        alert(text);
                        checking = false;
                        break;
                    }
                    formData.append(fieldTextarea, content);
                }

                if (!checking) {
                    return;
                }

                /* Tạo fn appendDataForm ở admin blade*/
                isValid = appendDataForm(fieldNames, formData, isValid);

                if (!isValid) {
                    return;
                }

                formData.append("user_id", '{{ Auth::user()->id }}');
                let photo = $('#thumbnail')[0].files[0];
                formData.append('thumbnail', photo);
                if (!photo) {
                    alert('Please check input require!')
                    isValid = false;
                    return;
                }

                try {
                    $.ajax({
                        url: `{{route('api.backend.coupons.create')}}`,
                        method: 'POST',
                        headers: headers,
                        contentType: false,
                        cache: false,
                        processData: false,
                        data: formData,
                        success: function (res) {
                            console.log(res);
                            alert('Create success!');
                            window.location.href = '{{ route('homeAdmin.list.coupons') }}'
                        },
                        error: function (exception) {
                            if (exception.status === 400) {
                                toastr.error(exception.responseText, 'Error');
                            } else {
                                toastr.error('Create error, Please try again!', 'Error');
                            }
                        }
                    });
                } catch (error) {
                    console.log(error);
                    alert('Error, Please try again!');
                }
            })
        })

        genSelectOption();

        async function genSelectOption() {
            const headers = {
                'Authorization': `Bearer ${token}`
            };
            let response = await fetch(`{{route('api.backend.clinics.all-clinic-active')}}`, {
                method: 'GET',
                headers: headers,
            });
            let html = '';
            if (response.ok) {
                const data = await response.json();
                data.forEach(item => {
                    html += `<option value="${item.id}">${item.name}</option>`
                })
                $('#clinic_id').html(html);
            }
        }
    </script>

    <script>
        function initImageUpload(box) {
            let uploadField = box.querySelector('.image-upload');

            uploadField.addEventListener('change', getFile);

            function getFile(e) {
                let file = e.currentTarget.files[0];
                checkType(file);
            }

            function previewImage(file) {
                let thumb = box.querySelector('.js--image-preview'),
                    reader = new FileReader();

                thumb.innerHTML = '';
                reader.onload = function () {
                    thumb.style.backgroundImage = 'url(' + reader.result + ')';
                }
                reader.readAsDataURL(file);
                thumb.className += ' js--no-default';
            }

            function checkType(file) {
                let imageType = /image.*/;
                if (!file.type.match(imageType)) {
                    throw 'Datei ist kein Bild';
                } else if (!file) {
                    throw 'Kein Bild gewählt';
                } else {
                    previewImage(file);
                }
            }

        }

        var boxes = document.querySelectorAll('.box');

        for (let i = 0; i < boxes.length; i++) {
            let box = boxes[i];
            initDropEffect(box);
            initImageUpload(box);
        }

        function initDropEffect(box) {
            let area, drop, areaWidth, areaHeight, maxDistance, dropWidth, dropHeight, x, y;

            // get clickable area for drop effect
            area = box.querySelector('.js--image-preview');
            area.addEventListener('click', fireRipple);

            function fireRipple(e) {
                area = e.currentTarget
                // create drop
                if (!drop) {
                    drop = document.createElement('span');
                    drop.className = 'drop';
                    this.appendChild(drop);
                }
                // reset animate class
                drop.className = 'drop';

                // calculate dimensions of area (longest side)
                areaWidth = getComputedStyle(this, null).getPropertyValue("width");
                areaHeight = getComputedStyle(this, null).getPropertyValue("height");
                maxDistance = Math.max(parseInt(areaWidth, 10), parseInt(areaHeight, 10));

                // set drop dimensions to fill area
                drop.style.width = maxDistance + 'px';
                drop.style.height = maxDistance + 'px';

                // calculate dimensions of drop
                dropWidth = getComputedStyle(this, null).getPropertyValue("width");
                dropHeight = getComputedStyle(this, null).getPropertyValue("height");

                // calculate relative coordinates of click
                // logic: click coordinates relative to page - parent's position relative to page - half of self height/width to make it controllable from the center
                x = e.pageX - this.offsetLeft - (parseInt(dropWidth, 10) / 2);
                y = e.pageY - this.offsetTop - (parseInt(dropHeight, 10) / 2) - 30;

                // position drop and animate
                drop.style.top = y + 'px';
                drop.style.left = x + 'px';
                drop.className += ' animate';
                e.stopPropagation();

            }
        }

    </script>

@endsection
