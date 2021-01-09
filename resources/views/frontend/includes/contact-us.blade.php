<div class="modal fade bs-example-modal-lg home_contact-model homePageContactUsModal" id="myModal" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
        	<form method="post" name="contact-us-form" id="contact-us-form">
        		@csrf
	            <!-- Modal Header -->
	            <div class="modal-header">
	                <h4 class="modal-title">Contact Us </h4>
	                <p>Please fill in the details and we will get back within 24 hrs to help you & your team.</p>
	                <button type="button" class="close" data-dismiss="modal">&times;</button>
	            </div>
	            <!-- Modal body -->
	            <div class="modal-body">
	            	 @guest
                    <div class="row">
                    	<div class="form_section col-md-6" style="margin-right:0px;">
	                        <label>First Name<span class="asterisk">*</span></label>
	                        <input value="@auth {{Auth::user()->first_name}} @endauth" type="text" placeholder="Enter First name" class="name-txt" name="first_name">
	                        <span class="error"></span>
	                    </div>
	                    <div class="form_section col-md-6" style="margin-right:0px;">
	                        <label>Last Name<span class="asterisk">*</span></label>
	                        <input value="@auth {{Auth::user()->last_name}} @endauth" type="text" placeholder="Enter Last name" class="name-txt" name="last_name">
	                        <span class="error"></span>
	                    </div>
                    </div>

                    <div class="row">
                    	<div class="form_section col-md-6" style="margin-right:0px;">
	                        <label>Email Address<span class="asterisk">*</span></label>
	                        <input value="@auth {{Auth::user()->email}} @endauth" type="email" placeholder="Enter Email"  name="email" class="name-txt">
	                        <span class="error"></span>
	                    </div>
	                    <div class="form_section col-md-6" style="margin-right:0px;">
	                        <label>Company Name <small>(write "Individual" for personal)</small></label>
	                        <input value="@auth {{Auth::user()->company_name}} @endauth" type="text" placeholder="Enter Company Name" name="company_name" class="name-txt">
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
	                        		<option value="{{$row['nicename']}}" data-id="{{$row['id']}}" @auth @if(Auth::user()->country==$row['nicename']) selected @endif @endauth>{{ucfirst($row['nicename'])}}</option>
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
	                        		<option value="{{$row['phonecode']}}" @auth @if(Auth::user()->country_code==$row['phonecode']) selected @endif @endauth> +{{$row['phonecode']}}</option>
	                        	@endforeach
	                        </select>
	                        <span class="error"></span>
	                    </div>
	                    <div class="form_section col-md-4" style="margin-right:0px;">
	                        <label>Phone<span class="asterisk">*</span></label>
	                        <input value="@auth {{Auth::user()->phone}} @endauth" type="text" placeholder="Enter Phone" name="phone" class="name-txt" min="1">
	                        <span class="error"></span>
	                    </div>
	                   
                    </div>
                    <div class="row">
                    	<div class="form_section col-md-6" style="margin-right:0px;">
	                        <label>City<span class="asterisk">*</span></label>
	                        <input value="@auth {{Auth::user()->city}} @endauth" type="text" placeholder="Enter City" name="city" class="name-txt" min="1">
	                        <span class="error"></span>
	                    </div>
                    	<div class="form_section col-md-6" style="margin-right:0px;">
	                        <label>State</label>
	                        <input value="@auth {{Auth::user()->state}} @endauth" type="text" placeholder="Enter State" name="state" class="name-txt" min="1">
	                        <span class="error"></span>
	                    </div>
                	</div>

                    <div class="row">
	                    <div class="form_section col-md-6" style="margin-right:0px;">
	                        <label>Zipcode/P.O.Box</label>
	                        <input value="@auth {{Auth::user()->zipcode}} @endauth" type="text" placeholder="Enter Zipcode/P.O.Box" name="zipcode" class="name-txt" min="1">
	                        <span class="error"></span>
	                    </div>
                    </div>
                    @endguest
                    <div class="form_section text-area-part" style="margin-right:0px;">
                        <label>Enter your message<span class="asterisk">*</span></label>
                        <textarea placeholder="Write down your message…" name="message" class="messege"></textarea>
                        <span class="error" style="top: 0px !important;"></span>
                    </div>
	            </div>
	            <!-- Modal footer -->
	            <div class="modal-footer">
	                <button type="button" class="btn btn-secondary" id="contact-us-form-btn">submit</button>
	            </div>
            </form>
        </div>
    </div>
</div>
