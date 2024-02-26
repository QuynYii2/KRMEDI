@php
    $isFavourite = \App\Models\WishList::where([
                ['user_id', '=', Auth::user()->id ?? ''],
                ['product_id', '=', $medicine->id],
                ['type_product', '=', \App\Enums\TypeProductCart::MEDICINE],
            ])->first();

            $heart = 'bi-heart d-flex';
            if ($isFavourite == true){
                $heart = 'bi-heart-fill d-flex';
            }
            $isSoldOut = $medicine->quantity == 0;

@endphp
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
</style>
<div class="col-sm-3 mb-3 col-6">
    <div class="m-md-2 {{ $isSoldOut ? 'sold-out-overlay' : '' }}">
        <div class="frame component-medicine w-100">
            <div class="img-pro justify-content-center d-flex img_product--homeNew">
                    <img loading="lazy" class="rectangle border-img"
                         src="{{asset($medicine->thumbnail)}}"/>
                    <div class="{{ $isSoldOut ? 'sold-out-overlay-text d-flex justify-content-center align-items-center w-100' : 'd-none' }} ">
                        <h1 class="sold-out">{{ __('home.Sold Out') }}</h1>
                    </div>

            </div>
            <div class="div">
                <div class="div-2">
                    <a target="_blank" class="w-100" href="{{ route('medicine.detail', $medicine->id) }}">
                        <div
                            class="text-wrapper text-nowrap overflow-hidden text-ellipsis w-100">{{ $medicine->name }}</div>
                    </a>
                    <div class="div-3"><img loading="lazy" class="marker-pin"
                                            src="{{ asset('img/location.png') }}"/>

                        <div
                            class="text-wrapper-2">{{ \App\Models\Province::getNameById($medicine->province_id) ?? ( __('home.Toàn quốc')) }}</div>
                    </div>
                    <div
                        class="text-wrapper-3">{{ number_format($medicine->price, 0, ',', '.' ) }} {{ $medicine->unit_price ?? 'VND'}}</div>
                </div>
                <div class="div-wrapper">
                    <a href="{{ route('medicine.detail', $medicine->id) }}">
                        <div class="text-wrapper-4">{{ __('home.See details') }}</div>
                    </a>
                </div>
            </div>

            @if(Auth::check())
                <div class="frame-wrapper-heart" onclick="handleAddMedicineToWishList('{{ $medicine->id }}')"><i
                        class="{{ $heart }} bi" id="heart-icon-{{ $medicine->id }}"></i></div>
            @endif
            <div class="group">
                <div class="overlap-group">
                    <div class="text-wrapper-5">75%</div>
                </div>
            </div>

        </div>
    </div>

</div>
