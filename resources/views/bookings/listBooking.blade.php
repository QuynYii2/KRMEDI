@extends('layouts.master')
@section('title', 'Online Medicine')
@section('content')
    @include('layouts.partials.header')
    @include('component.banner')
    <div class="container">
        <div class="d-flex p-0">
            <ul class="nav nav-pills nav-fill d-flex w-100">
                <li class="nav-item col-md-4 justify-content-center p-0">
                    <a class="nav-link active font-14-mobi" id="Pending-tab" data-toggle="tab" href="#Pending"
                       role="tab" aria-controls="home" aria-selected="true">{{ __('home.PENDING') }}</a>
                </li>
                <li class="nav-item col-md-4 justify-content-center">
                    <a class="nav-link font-14-mobi" id="Cancel-tab" data-toggle="tab" href="#Cancel"
                       role="tab" aria-controls="profile" aria-selected="false">{{ __('home.CANCEL') }}</a>
                </li>
                <li class="nav-item col-md-4 justify-content-center">
                    <a class="nav-link font-14-mobi" id="Complete-tab" data-toggle="tab" href="#Complete"
                       role="tab" aria-controls="profile" aria-selected="false">{{ __('home.COMPLETE') }}</a>
                </li>
            </ul>
        </div>
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="Pending" role="tabpanel" aria-labelledby="Pending-tab">
                <div class="section1-content">
                    <div id="listBookingPending">
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="Cancel" role="tabpanel" aria-labelledby="Cancel-tab">
                <div class="section1-content" id="listBookingCancel">

                </div>
            </div>
            <div class="tab-pane fade" id="Complete" role="tabpanel" aria-labelledby="Complete-tab">
                <div class="section1-content" id="listBookingComplete">

                </div>
            </div>
        </div>
    </div>
@endsection
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
    $(document).ready(function () {
        callListProduct();

        // Mặc định trạng thái là "PENDING"
        let defaultStatus = 'PENDING';

        // Gọi hàm để hiển thị danh sách khi trang được tải
        callListProduct(defaultStatus);

        // Hàm xử lý khi click vào tab
        function onTabClick(status) {
            callListProduct(status);
        }

        // Thiết lập sự kiện click cho mỗi tab
        $('#Pending-tab').on('click', function () {
            onTabClick('PENDING');
        });

        $('#Cancel-tab').on('click', function () {
            onTabClick('CANCEL');
        });

        $('#Complete-tab').on('click', function () {
            onTabClick('COMPLETE');
        });

        // Hàm gọi API
        async function callListProduct(status) {
            let routeName = "{{ route('booking.list.users',['id'=>$id,'status'=> ':status'] ) }}";
            routeName = routeName.replace(':status', status);
            let accessToken = `Bearer ` + token;

            await $.ajax({
                url: routeName,
                method: 'GET',
                headers: {
                    "Authorization": accessToken
                },
                success: function (response) {
                    renderClinics(response);
                },
                error: function (exception) {
                    console.log(exception);
                }
            });
        }


        async function renderClinics(res) {
            let htmlPending = ``;
            let htmlCancel = ``;
            let htmlComplete = ``;

            const baseUrl = '{{ route("booking.detail.by.user", ["id" => ":id"]) }}';

            for (let i = 0; i < res.length; i++) {
                let item = res[i];
                console.log(item)
                let urlDetail = baseUrl.replace(':id', item.id);

                let buttonHtml = '';

                if (item.status === 'PENDING') {
                    buttonHtml = `<a href="#" onclick="checkDelete(${item.id})">{{ __('home.Cancel') }}</a>`;
                } else if (item.status === 'CANCEL') {
                    buttonHtml = `<a href="#" onclick="checkDelete(${item.id}, 'PENDING')">{{ __('home.Apply') }}</a>`;
                }

                let productHtml = `
                     <div class="border-radius mb-3 d-flex">
                        <div class="col-md-10">
                            <a href="${urlDetail}">
                              <div>{{ __('home.Thời gian vào') }}: ${item.check_in} </div>
                              <div> {{ __('home.clinics') }}: ${item.clinic_id} </div>
                              {{--<div>{{ __('home.dịch vụ') }}: ${item.service} </div>--}}
                </a>
             </div>
            <div class="col-md-2">
${buttonHtml}
                        </div>
                     </div>
                    `;
                if (item.status === 'PENDING') {
                    htmlPending = htmlPending + productHtml;
                } else if (item.status === 'CANCEL') {
                    htmlCancel = htmlCancel + productHtml;
                } else if (item.status === 'COMPLETE') {
                    htmlComplete = htmlComplete + productHtml;
                }
            }

            $('#listBookingPending').empty().append(htmlPending);
            $('#listBookingCancel').empty().append(htmlCancel);
            $('#listBookingComplete').empty().append(htmlComplete);
        }


    });

    async function checkDelete(id, status) {
        let confirmed = confirm('Are you sure?');

        if (confirmed) {
            loadingMasterPage();
            let accessToken = `Bearer ` + token;
            let urlDelete = `{{ route('api.backend.booking.cancel', ['id' => ':id']) }}`;
            urlDelete = urlDelete.replace(':id', id);

            let data = {
                status: status ?? `{{ \App\Enums\BookingStatus::CANCEL }}`
            }

            await $.ajax({
                url: urlDelete,
                method: 'POST',
                headers: {
                    "Authorization": accessToken,
                },
                data: data,
                success: function (response) {
                    loadingMasterPage();
                    window.location.reload();
                    alert('Success!');
                },
                error: function (exception) {
                    loadingMasterPage();
                    console.log(exception)
                }
            });
        }
    }


</script>
