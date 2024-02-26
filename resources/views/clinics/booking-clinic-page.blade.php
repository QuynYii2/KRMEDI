@extends('layouts.master')
@section('title', 'Booking Clinic')
@section('content')
    <link rel="stylesheet" href="{{asset('css/homeSpecialist.css')}}">
    <link href="{{ asset('css/detailclinics.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/foundation/6.1.0/foundation.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css">
    <link href="{{ asset('css/selectdate.css') }}" rel="stylesheet">
    <style>
        input[type=radio] {
            accent-color: #088180;
        }
        .border-booking-sv .font-weight-600 label{
            color: #000;
            font-size: 18px;
            font-style: normal;
            font-weight: 800;
            line-height: normal;
        }
        .date-active {
            background-color: blue;

        }

        a.hollow.button {
            border-radius: 8px;
            background: #F3F3F3;
            color: #929292;
            font-size: 24px;
            font-style: normal;
            font-weight: 800;
            line-height: normal;
            border: 1px solid #FFFFFF;
            margin: 0 16px 0 0;
        }

        a.hollow.button:hover {
            border-radius: 8px;
            border: 1px solid #088180;
            background: #F3F3F3;
        }

        a.hollow.button:active {
            border-radius: 8px;
            background: #088180;
            color: #FFF;
            font-size: 24px;
            font-style: normal;
            font-weight: 800;
            line-height: normal;
        }

        .ui-state-active {
            border-radius: 85px;
            background-color: #088180 !important;
        }

        .ui-datepicker-inline.ui-datepicker.ui-widget.ui-widget-content.ui-helper-clearfix.ui-corner-all {
            border-radius: 8px;
            background: #FFF;
            box-shadow: 0 8px 12px 0 rgba(0, 0, 0, 0.20);
            border: none;
            padding: 16px;

        }

        tbody, tfoot, thead {
            border: none;
            background-color: #FFFFFF;
        }

        tbody tr:nth-child(even) {
            background-color: white;
        }

        .ui-datepicker-calendar tbody tr td .ui-state-default {
            border: none;
            background-color: #ffffff;
        }

        .ui-datepicker-header.ui-widget-header.ui-helper-clearfix.ui-corner-all {
            background: white;
            border: none;
        }

        .ui-datepicker td {
            padding: 12px;
        }

        .select-memberFamily label {
            color: #000;
            font-size: 24px;
            font-style: normal;
            font-weight: 800;
            line-height: normal;
        }

        .select-service {
            margin-top: 40px;
            color: #000;
            font-size: 18px;
            font-style: normal;
            font-weight: 600;
            line-height: normal;
        }

        .checkbox-button label {
            width: 24px;
            height: 24px;
            border-radius: 30px;
        }

        .border-booking-sv {
            padding: 16px;
        }

        .button-apply-bookingNew {
            display: flex;
            width: 470px;
            padding: 14px 50px;
            justify-content: center;
            align-items: center;
            gap: 10px;
            border-radius: 8px;
            background: #088180;
            border: none;
        }

        .avtMember img {
            width: 71px;
            height: 71px;
            border-radius: 71px;
            object-fit: cover;
        }

        .border-8 {
            border-radius: 8px;
            border: 1px solid #EAEAEA;
            background: #FFF;
            box-shadow: 0 4px 4px 0 rgba(0, 0, 0, 0.25);
            padding: 16px;
        }
    </style>
    @include('layouts.partials.header')
    <div class="container">
        <div class="detail-clinic-theo-chuyen-khoa-title border-bottom">
            <a href="{{route('home.specialist')}}">
                <div class="title-detail-clinic"><i class="fa-solid fa-arrow-left"></i> {{ __('home.Detail') }}</div>
            </a>
            <div class="specialList-clinics col-md-12 mt-5 mb-5">
                <div class="border-specialList">
                    <div class="content__item d-md-flex gap-3">
                        @php
                            $arrayGallery = explode(',', $clinicDetail->gallery);

                        @endphp
                        <div class="specialList-clinics--img">
                            <img class="content__item__image" src="{{$arrayGallery[0] ?? ''}}"
                                 alt=""/>
                        </div>
                        <div class="specialList-clinics--main">
                            <div class="title-specialList-clinics">
                                {{$clinicDetail->name}}
                            </div>
                            <div class="address-specialList-clinics d-flex">
                                <i class="fas fa-map-marker-alt"></i>
                                @php
                                    $array = explode(',', $clinicDetail->address);
                                    $addressP = \App\Models\Province::where('id', $array[1] ?? null)->first();
                                    $addressD = \App\Models\District::where('id', $array[2] ?? null)->first();
                                    $addressC = \App\Models\Commune::where('id', $array[3] ?? null)->first();
                                @endphp
                                <div class="ml-1">{{$clinicDetail->address_detail}}
                                    , {{$addressC->name ?? ''}} , {{$addressD->name ?? ''}}
                                    , {{$addressP->name ?? ''}}</div>
                            </div>
                            <div class="time-working">
                                <i class="fa-solid fa-clock"></i>
                                {{$clinicDetail->time_work}}
                                | {{ \Carbon\Carbon::parse($clinicDetail->open_date)->format('H:i') }}
                                - {{ \Carbon\Carbon::parse($clinicDetail->close_date)->format('H:i') }}
                            </div>
                            <div class="group-button d-flex mt-3">
                                <a href="" class="mr-2">
                                    <div class="button-follow-specialList">
                                        {{ __('home.Theo dõi') }}

                                    </div>
                                </a>
                                <a href="{{route('clinic.detail',$clinicDetail->id)}}" class="">
                                    <div class="button-direct-specialList">
                                        {{ __('home.Chỉ đường') }}
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <form action="{{route('booking.create.new')}}" method="post">
            @csrf
            @method('POST')
            <input type="hidden" name="check_in" id="check_in" value=''>
            <input type="hidden" name="check_in_time" id="check_in_time" value=''>
            <input type="hidden" name="clinic_id" id="clinic_id" value='{{$clinicDetail->id}}'>
            <div>
                <div></div>
                <section>
                    <div class="d-md-flex">
                        <div class="small-12 col-md-3 pl-0">
                            <div>{{ __('home.Chọn Ngày') }}</div>
                            <div id="datepicker"></div>
                        </div>
                        <div class="small-12 col-md-9">
                            <div>{{ __('home.Chọn thời gian') }}</div>
                            <div class="spin-me"></div>
                            <div class="master-container-slots" id="select-time-booking">
                                <div class="morning-container fs-16px">
                                    <p>AM</p>
                                    <div class="flex-container-morning"></div>
                                </div>
                                <div class="afternoon-container fs-16px">
                                    <p>PM</p>
                                    <div class="flex-container-afternoon"></div>
                                </div>
                            </div>
                        </div>
                        <input hidden="" type="text" id="selectedTime" name="selectedTime"
                               readonly>
                    </div>
                </section>
            </div>
            <div class="mt-5">
                @if(Auth::check())
                    <div class="d-flex align-items-center select-memberFamily">
                        <input class="m-0 inputBookingFor" style="width: 20px;height: 20px;" type="radio" name="memberFamily" checked
                               id="yourself"  value="yourself"><label for="yourself">{{ __('home.Cho mình') }}</label>
                        <input class="m-0 inputBookingFor" style="width: 20px;height: 20px;" type="radio" name="memberFamily"
                               id="family" value="family"><label for="family">{{ __('home.Cho người thân') }}</label>
                    </div>
                @endif
            </div>
            <div class="d-flex mt-5 d-none" id="my-family">
                @if($memberFamilys->count() == 0)
                    <div class="col-auto mr-3 border-8">
                        <div class="avtMember d-flex justify-content-center align-items-center">
                            <img
                                src="https://i0.wp.com/sbcf.fr/wp-content/uploads/2018/03/sbcf-default-avatar.png"
                                alt="">
                        </div>
                        <div class="d-flex align-items-center justify-content-center">
                            <label for="yourself">{{ __('home.Bạn chưa có người thân') }}</label>
                            <input hidden="" type="radio" name="memberFamily" id="yourself"  value="yourself"><label for="yourself">{{ __('home.Cho mình') }}</label>
                        </div>
                    </div>
                @else
                    @foreach($memberFamilys as $memberFamily)
                        <div class="col-auto mr-3 border-8">
                            <div class="avtMember">
                                <img
                                    src="{{$memberFamily->avatar ?? 'https://i0.wp.com/sbcf.fr/wp-content/uploads/2018/03/sbcf-default-avatar.png'}}"
                                    alt="">
                            </div>
                            <div class="d-flex align-items-center justify-content-center">
                                <label for="{{$memberFamily->id}}">{{$memberFamily->name}}</label>
                            </div>
                            <div class="d-flex align-items-center justify-content-center">
                                # {{ \App\Enums\RelationshipFamily::getLabels()[$memberFamily->relationship] ?? $memberFamily->relationship }}</div>
                            <input style="right: 0" class="position-absolute top-0 m-2" type="radio" name="membersFamily"
                                   id="{{$memberFamily->id}}" value="{{$memberFamily->id}}">
                        </div>
                    @endforeach
                @endif
            </div>
            <div>
                <div class="select-service">{{ __('home.Select service') }}</div>
                <div>
                    @foreach($services as $service)
                        <div class="d-flex justify-content-between mt-md-2 border-booking-sv align-items-center">
                            <div class="fs-14 font-weight-600">
                                <label class="d-flex" for="myCheckbox{{$service->id}}">{{$service->name}}</label>
                            </div>
                            <div class="checkbox-button">
                                <input type="checkbox" id="myCheckbox{{$service->id}}" value="{{$service->id}}"
                                       name="service[]">
                                <label class="d-flex" for="myCheckbox{{$service->id}}"></label>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="d-flex justify-content-center">
                <button type="submit"
                        class=" btn col-md-6 mt-4 btn-primary btn-block up-date-button button-apply-bookingNew "
                        id="activate">{{ __('home.Xác nhận đặt khám') }}
                </button>
            </div>

        </form>
    </div>
    <script>
        $(document).ready(function () {
            loadData();

            $('.inputBookingFor').on('change', function () {
                checkMyFamily();
            });
        });

        function checkMyFamily() {
            let inputChecked = document.querySelector('input[name="memberFamily"]:checked');
            let value = inputChecked.value;
            console.log(value);
            if (value === 'yourself') {
                document.getElementById('my-family').classList.add('d-none');
            } else {
                document.getElementById('my-family').classList.remove('d-none');
            }
        }

        function loadData() {
            let cachedData = {};

            function serviceCallSlots(date) {
                const dt = new Date(date);
                let ms = dt.getTime();
                let startMs = ms - (60 * 60 * 24 * 1000 * 2);
                const dtArr = [1, 2, 3, 4, 5].map((e) => {
                    const innerDt = new Date(startMs);
                    startMs += 60 * 60 * 24 * 1000;
                    return innerDt;
                });
                const timeArrs = [
                    ['9', '10', '11', '12', '1', '2', '3', '4', '5'],
                    ['9', '10', '11', '1', '2', '3', '4', '5'],
                    ['9', '10', '11', '12', '3', '4', '5'],
                    ['10', '11', '2', '4'],
                    ['11', '12', '1', '4', '5']
                ];
                return new Promise((resolve, reject) => {
                    setTimeout(() => {
                        const obj = dtArr.reduce((accum, e) => {
                            const randomNum = Math.floor(Math.random() * 5);
                            const dtString = e.toLocaleDateString();
                            let parts = dtString.split('/');
                            parts[0] = parts[0].length === 1 ? '0' + parts[0] : parts[0];
                            parts[1] = parts[1].length === 1 ? '0' + parts[1] : parts[1];
                            accum[parts.join('/')] = timeArrs[randomNum];
                            return accum;
                        }, {});
                        resolve(obj);
                    }, 2000);
                })
            }

            function spinner(startOrStop) {
                const spin = document.querySelector('.spin-me');
                if (startOrStop === 'start') {
                    const spinner = document.createElement('i');
                    spinner.setAttribute('class', 'fas fa-spinner fa-4x fa-spin');
                    spin.appendChild(spinner);
                } else {
                    spin.innerHTML = '';
                }
            }

            function createSlotsDom(formSubmit, morning, afternoon, arr) {
                [9, 10, 11, 12, 1, 2, 3, 4, 5].map((e) => {
                    const div = document.createElement('div');
                    div.setAttribute('class', 'item');

                    const anchor = document.createElement('a');
                    anchor.setAttribute('class', 'hollow button');
                    anchor.setAttribute('href', 'javascript:void(0)');

                    const time = (e < 10 ? '0' : '') + e + ':00';
                    const txt = document.createTextNode(time);
                    anchor.appendChild(txt);

                    anchor.onclick = function (event) {
                        const selectedTime = event.target.innerText;
                        let date = document.getElementById('check_in').value;
                        const selectedDateTime = date + ' ' + selectedTime;

                        document.getElementById('selectedTime').value = selectedDateTime;

                        formSubmit.classList.remove('disabled');
                    }

                    if (!arr.filter(r => r == e).length) {
                        anchor.setAttribute('disabled', 'true');
                    }

                    div.appendChild(anchor);

                    if (e >= 9 && e < 12) {
                        morning.appendChild(div);
                    } else {
                        afternoon.appendChild(div);
                    }
                });
                selectTime();
            }

            function selectTime() {
                const divTime = document.querySelectorAll('#select-time-booking .item > a.hollow.button');

                divTime.forEach((item) => {
                    item.addEventListener('click', (e) => {
                        e.preventDefault();
                        console.log(item.text)

                        divTime.forEach((otherItem) => {
                            otherItem.classList.remove('bg-primary');
                        });

                        $(item).toggleClass('bg-primary');
                        document.getElementById('check_in_time').value = item.text;
                    })
                })

            }


            $("#datepicker").datepicker({
                onSelect: function (date) {
                    const container = document.querySelector('.master-container-slots');
                    const morning = document.querySelector('.flex-container-morning');
                    const afternoon = document.querySelector('.flex-container-afternoon');
                    const formSubmit = document.querySelector('.button-apply-bookingNew');
                    const checkInInput = document.getElementById('check_in');

                    formSubmit.classList.add('disabled');
                    container.classList.add('hide');

                    if (cachedData[date]) {
                        spinner('start');
                        setTimeout(() => {
                            morning.innerHTML = '';
                            afternoon.innerHTML = '';
                            createSlotsDom(formSubmit, morning, afternoon, cachedData[date]);
                            spinner('stop');
                            container.classList.remove('hide');
                            container.classList.add('fade-in');
                            checkInInput.value = date;
                        }, 500);
                    } else {
                        spinner('start');
                        const prom = serviceCallSlots(date);
                        setTimeout(() => {
                            morning.innerHTML = '';
                            afternoon.innerHTML = '';
                            prom.then((payload) => {
                                Object.keys(payload).map((e) => {
                                    const cachedKeys = Object.keys(cachedData);
                                    if (!cachedKeys.includes(e)) {
                                        cachedData[e] = payload[e];
                                    }
                                });
                                createSlotsDom(formSubmit, morning, afternoon, cachedData[date]);
                                spinner('stop');
                                container.classList.remove('hide');
                                container.classList.add('fade-in');
                                checkInInput.value = date;
                            });
                        }, 500);
                    }
                    document.getElementById('check_in').value = date;
                    console.log(date)
                }
            });


        }
    </script>
@endsection
