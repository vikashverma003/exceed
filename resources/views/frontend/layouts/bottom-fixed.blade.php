<div class="bottom_fixed">
    <div class="container">
        <div class="row">
            <div class="request_quete">
                <p>
                    <img src="{{asset('img/ic_request_quote.svg')}}">
                    <span><a href="javascript:;" @guest onclick="showLoginModal();" @endguest @auth onclick="showFooterQuoteModal();" @endauth class="stleClassColor">Request a Quote Now</a></span>
                </p>
            </div>
        </div>
    </div>
</div>
