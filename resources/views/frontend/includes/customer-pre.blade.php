<div class="modal fade bs-example-modal-lg home_contact-model select-customer-modal" id="myModal3" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <button type="button" class="close"
                    data-dismiss="modal">&times;</button>
                <h1 class="model-titile">Select your type</h1>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
               
                <div class="checkbox-here">
                    <label>
                    <input type="radio" name="customer-select-radio" value="individual">
                    <span class="checkmark"><img src="{{asset('img/ic_Individual.svg')}}">
                    Individual</span>
                    </label>
                </div>
                <div class="checkbox-here">
                    <label>
                    <input type="radio" name="customer-select-radio" value="corporate">
                    <span class="checkmark"><img src="{{asset('img/ic_corporate.svg')}}">
                    Corporate</span>
                    </label>
                </div>
                <div class="button btn-continue">
                    <button class="btn btn-large continuess" id="customer-select-save">Continue</button>
                </div>
            </div>
        </div>
    </div>
</div>
