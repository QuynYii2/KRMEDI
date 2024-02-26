@extends('layouts.master')
@section('title', 'Flea Market')
@section('content')
    <link href="{{ asset('css/selectdate.css') }}" rel="stylesheet">
<section>
    <div class="row col-md-2 d-block">
        <div class="small-12 ">
            <div id="datepicker"></div>
        </div>
        <div class="small-12 ">
            <div class="spin-me"></div>
            <div class="master-container-slots">
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
    </div>
    <div class="row col-md-2">
        <div class=" medium-centered d-md-flex justify-content-between">
            <div class="col-md-6 pl-0">
            <a class= 'button form-submit button-Reset-booking w-100'>{{ __('home.Reset') }}</a>
            </div>
            <div class="col-md-6 pr-0">
            <a class='button form-submit w-100 button-apply-booking disabled'>{{ __('home.Apply') }}</a>
            </div>
        </div>
    </div>
</section>


<script>
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
                //construct object
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
            const button = document.createElement('button');
            button.setAttribute('class', 'hollow button');
            button.setAttribute('href', 'javascript:void(0)');
            const time = (e < 10 ? '0' : '') + e + ':00';
            const txt = document.createTextNode(time);
            button.appendChild(txt);
            button.onclick = function (e) {
                formSubmit.classList.remove('disabled');
            }
            if (!arr.filter(r => r == e).length) {
                button.setAttribute('disabled', 'true');
            }
            div.appendChild(button);
            if (e >= 9 && e < 12) {
                morning.appendChild(div);
            } else {
                afternoon.appendChild(div);
            }
        });
    }

    $("#datepicker").datepicker({
        onSelect: function (date) {
            const container = document.querySelector('.master-container-slots');
            const morning = document.querySelector('.flex-container-morning');
            const afternoon = document.querySelector('.flex-container-afternoon');
            const formSubmit = document.querySelector('.button-apply-booking');
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
                    });
                }, 500);
            }
        }
    });
</script>
@endsection
