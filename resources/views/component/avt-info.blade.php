    <div class=" row d-flex align-content-center mb-42">
        <div class="col-md-2 d-flex justify-content-center">
            <img STYLE="width: 148px" src="{{asset('img/flea-market/avatar-phi.png')}}">
        </div>
        <div class="col-md-8">
            <div class="info">
                <div class="name">Trần đình phi</div>
                <p class="location-info">Location: <strong class="hanoi">HANOI</strong></p>
            </div>
            <div class="d-flex margin-info">
                <p>Product: <span>10</span></p>
                <p>Sold: <span>1000</span></p>
                <p>Sold out: <span>10</span></p>
                <p>Following: <span>50</span></p>
            </div>
        </div>
        <div class="col-md-2">
            <div class="d-flex col-md-4">
                <form action="{{route('flea.market.sell.product')}}" class=" flea-button mr-3">
                    <button class="flea-btn width-88">Sell my product</button>
                </form>
            </div>
        </div>
    </div>

