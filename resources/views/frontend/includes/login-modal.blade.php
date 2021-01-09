<div class="modal fade bs-example-modal-lg home_contact-model loginModal" id="myModal2" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <button type="button" class="close"
                    data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                <form name="login-form-modal" id="login-form-modal" method="post">
                    @csrf
                    <div class="right-login">
                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs mb-0" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" data-toggle="tab"
                                    href="#home">Login</a>
                            </li>
                        </ul>
                        <!-- Tab panes -->
                        <div class="tab-content">
                            <div id="home" class="container tab-pane active">
                                <br>
                                <div class="form_login-signup">
                                    <div class="form-log">
                                        <label> Email ID<span class="asterisk">*</span> </label>
                                        <input type="email" placeholder="Abc@gmail.com" name="email">
                                        <span class="error"></span>
                                    </div>
                                    <div class="form-log">
                                        <label> Password<span class="asterisk">*</span> </label>
                                        <input type="password" placeholder="*********" name="password">
                                        <span class="error"></span>
                                    </div>
                                    <div class="remeber_me">
                                        <label>
                                        <input type="checkbox" {{ old('remember') ? 'checked' : '' }} name="remember"> <span> Remember me
                                        </span> </label>
                                    </div>
                                    <div class="login_btn">
                                        <button class="btn btn-large login_button " id="login-form-btn">
                                        Login </button>
                                    </div>
                                    <a href="javascript:;" class="forget_pass" onclick="showForgotPasswordModal();"> Forgot Password?
                                    </a>
                                    <!-- Modal footer -->
                                    <div class="modal-footer">
                                        <a class="btn btn-secondary fb facebook-button mb-0" href="{{route('login.social.redirect',['provider'=>'facebook'])}}"> Login With
                                        Facebook</a>
                                        
                                    </div>
                                    <div class="col-md-12">
                                        <p class="ask_for_acc" style="
                                            margin-top: 20px;
                                            text-align: center;
                                            color: #0E0E0E;
                                            font-size: 15px;
                                        ">Don't have an account ? <a href="javascript:;" onclick="showCustomerSelectModal();" class="register-btn stleClassColor">Register</a>
                                        </p>

                                        <p class="ask_for_acc" style="
                                            margin-top: 20px;
                                            text-align: center;
                                            color: #0E0E0E;
                                            font-size: 15px;
                                        ">Account Not Verified ? <a href="javascript:;" onclick="showAccountActivationModal();" class="register-btn stleClassColor">Resend Link</a>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
