@php use App\Enums\TypeProductCart; @endphp
@php use App\Models\online_medicine\ProductMedicine; @endphp
@php use App\Models\ProductInfo;use Illuminate\Support\Facades\Auth; @endphp
<link href="{{ asset('css/modalcart.css') }}" rel="stylesheet">
<div class="modal modal-cart fade" id="modalCart" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{ __('home.Carts') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                @if(Auth::check())
                    @foreach($carts as $cart)
                        @php
                            switch ($cart->type_product){
                                case TypeProductCart::MEDICINE:
                                    $product = ProductMedicine::find($cart->product_id);
                                    break;
                                case TypeProductCart::FLEA_MARKET:
                                    $product = ProductInfo::find($cart->product_id);
                                    break;
                            }
                        @endphp
                        <div class="product-cart row position-relative">
                            <div class="col-2 img">
                                <img src="{{asset($product->thumbnail)}}" alt="">
                            </div>
                            <div class="col-7 title">
                                <div class="title-name">
                                    {{ $product->name }}
                                </div>
                                <div class="price">
                                    {{ number_format($product->price, 0, ',', '.') }}  {{ $product->unit_price }}
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="change-quantity">
                                    <div class="value-button btnChangeQty" data-type="decrease"
                                         onclick="decreaseQuantity('{{ $cart->id }}')">-
                                    </div>
                                    <input id="number_quantity_{{$cart->id}}" type="number" class="number mr-2 ml-2"
                                           value="{{ $cart->quantity }}" min="0"/>
                                    <div class="value-button btnChangeQty" data-type="increase"
                                         onclick="increaseQuantity('{{ $cart->id }}')">+
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex align-items-center justify-content-end ">
                                <i class="position-absolute delete-product" onclick="deleteProductCart('{{ $cart->id }}')">&times;</i></div>
                        </div>
                    @endforeach
                @endif
            </div>
            <div class="modal-footer">
                <button type="button" class="btn cancel" data-dismiss="modal">{{ __('home.CANCEL') }}</button>
                @if(Auth::check())
                    @if($carts->isNotEmpty())
                        <a href="{{ route('user.checkout.index') }}" class="btn pay">{{ __('home.Pay') }}</a>
                    @else
                        <button disabled class="btn pay">{{ __('home.Pay') }}</button>
                    @endif
                @endif
            </div>
        </div>
    </div>
</div>
@if(Auth::check())
    <input type="text" id="accessToken" class="d-none" value="{{ $_COOKIE['accessToken' ?? ''] }}">
@endif
<script>

    function decreaseQuantity(cartId) {
        var inputElement = $('#number_quantity_' + cartId);
        var currentValue = parseInt(inputElement.val());

        if (currentValue > 1) {
            let newQuantity = currentValue - 1;
            inputElement.val(newQuantity);
            changeQuantity(cartId, newQuantity);
        }
    }

    function increaseQuantity(cartId) {
        var inputElement = $('#number_quantity_' + cartId);
        var currentValue = parseInt(inputElement.val());
        let newQuantity = currentValue + 1;

        inputElement.val(newQuantity);
        changeQuantity(cartId, newQuantity);
    }

    function deleteProductCart(id) {
        let ok = confirm('{{ __('home.Bạn có chắc chắn muốn xóa sản phẩm này không') }}?');
        if (!ok) {
            return;
        }
        loadingMasterPage();
        const headers = {
            'Authorization': `Bearer ${token}`
        };
        const formData = new FormData();

        formData.append('_token', '{{ csrf_token() }}');

        let url = `{{route('api.backend.cart.delete', ['id' => ':id'])}}`;
        url = url.replace(':id', id);

        try {
            $.ajax({
                url: url,
                method: 'DELETE',
                headers: headers,
                contentType: false,
                cache: false,
                processData: false,
                data: formData,
                success: function (data) {
                    loadingMasterPage();
                    //reload
                    window.location.reload();
                },
                error: function (exception) {
                    loadingMasterPage();
                }
            });
        } catch (error) {
            loadingMasterPage();
            throw error;
        }
    }

    async function changeQuantity(id, quantity) {

        const headers = {
            'Authorization': `Bearer ${token}`
        };

        let route = `{{route('api.backend.cart.change.quantity', ['id' => ':id'])}}`;
        route = route.replace(':id', id);

        let data = {
            quantity: quantity
        }

        try {
            $.ajax({
                url: route,
                method: 'POST',
                headers: headers,
                data: data,
            });
        } catch (error) {
            throw error;
        }
    }
</script>
