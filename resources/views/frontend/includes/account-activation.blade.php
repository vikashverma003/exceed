<div class="modal fade bs-example-modal-lg home_contact-model accountActivationModal" id="accountActivationModal" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <button type="button" class="close"
                    data-dismiss="modal">&times;</button>
                <h1 class="model-titile">Resend Account Activation Link</h1>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                <form method="post" name="account-activation-form" id="account-activation-form">
                    @csrf
                    <div class="right-login form_login-signup">
                        <div class="form-log">
                            <label> Email Address<span class="asterisk">*</span></label>
                            <input type="email" placeholder="Abc@gmail.com" name="email">
                            <span class="error"></span>
                        </div>
                    </div>
                    <div class="button btn-continue">
                        <button  class="btn btn-large continuess color_conti" id="resent-account-activation-btn">Continue</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
