<div class="modal fade bs-example-modal-lg home_contact-model signupModal" id="myModal4" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <button type="button" class="close"
                    data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                <div class="right-login">
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="#menu1">
                                Sign Up</a>
                        </li>
                    </ul>
                    <!-- Tab panes -->
                    <div class="tab-content">
                        <div id="menu1" class="container tab-pane fade">
                            
                            <form method="post" name="signup-modal-form" id="signup-modal-form">
                                @csrf
                                <div class="form_login-signup">
                                    <div class="row">
                                        <div class="form_section col-md-6" style="margin-right:0px;">
                                            <label>First Name<span class="asterisk">*</span></label>
                                            <input value="" type="text" placeholder="Enter First Name" class="name-txt" name="first_name">
                                            <span class="error"></span>
                                        </div>
                                        <div class="form_section col-md-6" style="margin-right:0px;">
                                            <label>Last Name<span class="asterisk">*</span></label>
                                            <input value="" type="text" placeholder="Enter Last Name" class="name-txt" name="last_name">
                                            <span class="error"></span>
                                        </div>
                                        
                                    </div>

                                    <div class="row">
                                        <div class="form_section col-md-6" style="margin-right:0px;">
                                            <label>Company Name </label>
                                            <input value="" type="text" placeholder="Enter Company Name" name="company_name" class="name-txt">
                                            <span class="error"></span>
                                        </div>
                                        <div class="form_section col-md-6" style="margin-right:0px;">
                                            <label>Email Address<span class="asterisk">*</span></label>
                                            <input value="" type="email" placeholder="Enter Email"  name="email" class="name-txt">
                                            <span class="error"></span>
                                        </div>
                                        
                                    </div>

                                    <div class="row">
                                        <div class="form_section col-md-6 full-width" style="margin-right:0px;">
                                            <label>Country<span class="asterisk">*</span></label>
                                            <select class="form-control name-txt contact_country" name="country" style="height: 48px;background: none;">
                                                <?php
                                                    $country = \App\Models\Country::get();
                                                ?>
                                                @foreach($country as $row)
                                                    <option value="{{$row['nicename']}}" data-id="{{$row['id']}}">{{ucfirst($row['nicename'])}}</option>
                                                @endforeach
                                            </select>
                                            <span class="error"></span>
                                        </div>
                                        <div class="form_section col-md-2 full-width" style="margin-right:0px;">
                                            <label>Code<span class="asterisk">*</span></label>
                                            <select class="form-control name-txt contact_code" name="country_code" style="height: 48px;background: none;">
                                                <?php
                                                    $codes = \App\Models\Country::get();
                                                ?>
                                                @foreach($codes as $row)
                                                    <option value="{{$row['phonecode']}}">{{$row['phonecode']}}</option>
                                                @endforeach
                                            </select>
                                            <span class="error"></span>
                                        </div>
                                        <div class="form_section col-md-4" style="margin-right:0px;">
                                            <label>Phone <span class="asterisk">*</span></label>
                                            <input value="" type="text" placeholder="Enter Phone" name="phone" class="name-txt" min="1">
                                            <span class="error"></span>
                                        </div>
                                        
                                        
                                    </div>

                                    <div class="row">
                                        <div class="form_section col-md-6" style="margin-right:0px;">
                                            <label>City  <span class="asterisk">*</span></label>
                                            <input value="" type="text" placeholder="Enter City Name" name="city" class="name-txt">
                                            <span class="error"></span>
                                        </div>
                                        <div class="form_section col-md-6" style="margin-right:0px;">
                                            <label>State</label>
                                            <input value="" type="text" placeholder="Enter State Name" name="state" class="name-txt">
                                            <span class="error"></span>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form_section col-md-6" style="margin-right:0px;">
                                            <label>Zipcode/P.O.Box</label>
                                            <input value="" type="text" placeholder="Enter Zipcode/P.O.Box" name="zipcode" class="name-txt" min="1">
                                            <span class="error"></span>
                                        </div>
                                        <div class="form_section col-md-6" style="margin-right:0px;">
                                            <label>Password  <span class="asterisk">*</span></label>
                                            <input value="" type="password" placeholder="*********" name="password" class="name-txt">
                                            <span class="error"></span>
                                        </div>
                                    </div>
                                    <div class="login_btn">
                                        <button type="button" class="btn btn-large login_button signup-modal-btn">
                                            Sign Up 
                                        </button>
                                    </div>
                                    <div class="txt-remeber_me">
                                        <p>By signing up, you agree to our <a href="{{url('terms')}}" target="_blank">
                                            Terms of Use </a> and <a href="{{url('privacy-policy')}}" target="_blank">
                                            Privacy Policy. </a>
                                        </p>
                                        <p class="ask_for_acc">Already a member? <a href="javascript:;" class="login-btn" onclick="showLoginModal();"> Log In</a></p>
                                    </div>
                                    <!-- Modal footer -->
                                    <div class="modal-footer">
                                        
                                        <a class="btn btn-secondary fb facebook-button mb-0" href="{{route('login.social.redirect',['provider'=>'facebook'])}}"> Sign Up with
                                        Facebook</a>

                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
