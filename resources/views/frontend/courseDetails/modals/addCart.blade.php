<div class="modal fade bs-example-modal-lg home_contact-model" id="add-tocartpop" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Contact Information </h4>
                <p class="mt-4">Confirm Attendees</p>
                <button type="button" class="close"
                    data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                <ul class="nav nav-tabs">
                    <li>
                        <a data-toggle="tab" href="#menu2" class="active course_contact_Active" data-val="individual">
                            <div class="img-check">
                                <img src="{{asset('img/ic_check_tik.svg')}}">
                            </div>
                            <h3>I will attend as an individual </h3>
                            <p> Using the contact information below</p>
                        </a>
                    </li>
                    <li>
                        <a data-toggle="tab" href="#menu3" class="course_contact_Active" data-val="corporate">
                            <div class="img-check">
                                <img src="{{asset('img/ic_check_tik.svg')}}">
                            </div>
                            <h3>I am the point of contact </h3>
                            <p>for the attendees from my organization</p>
                        </a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div id="menu2" class="tab-pane fade show active">
                        <div class="form-group">
                            <label>Course Name</label>
                            <input type="text" class="name-txt form-control" disabled="" value="" name="course_name">
                        </div>
                        <form method="post" name="single_attendence_contacts" id="single_attendence_contacts">
                            <input type="hidden" name="course_contact_type" value="individual">
                            <input type="hidden" name="course_contact_id" value="">
                            
                            <div class="row col-md-12">
                                <div class="form_section">
                                    <label>First Name<span class="asterisk">*</span></label>
                                    <input type="text" placeholder="Enter First name" class="name-txt" name="first_name" value="@auth {{Auth::user()->first_name}} @endauth">
                                    <span class="error"></span>
                                </div>
                                <div class="form_section">
                                    <label>Last Name<span class="asterisk">*</span></label>
                                    <input type="text" placeholder="Enter Last name" class="name-txt" name="last_name" value="@auth {{Auth::user()->last_name}} @endauth"><span class="error"></span>
                                </div>
                            </div>
                            <div class="clearfix"></div>

                            <div class="row col-md-12">
                                <div class="form_section">
                                    <label>Email Address<span class="asterisk">*</span></label>
                                    <input type="text" placeholder="Enter email" class="name-txt" name="email" value="@auth {{Auth::user()->email}} @endauth">
                                    <span class="error"></span>
                                </div>
                                <div class="form_section">
                                    <label>Position<span class="asterisk">*</span></label>
                                    <input type="text" placeholder="Enter position" class="name-txt" name="position"><span class="error"></span>
                                </div>
                                
                            </div>
                            <div class="clearfix"></div>

                            <div class="row col-md-12">
                                
                                <div class="form_section">
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
			                        		<option value="{{$row['phonecode']}}" @auth @if(Auth::user()->country_code==$row['phonecode']) selected @endif @endauth>{{$row['phonecode']}}</option>
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
                            <div class="clearfix"></div>

                            <div class="row col-md-12">
                                
                                <div class="form_section">
                                    <label>Company Name<span class="asterisk">*</span></label>
                                    <input type="text" placeholder="Enter company name" class="name-txt" name="company_name" value="@auth {{Auth::user()->company_name}} @endauth"><span class="error"></span>
                                </div>
                                <div class="form_section">
                                    <label>City<span class="asterisk">*</span></label>
                                    <input type="text" placeholder="Enter city" class="name-txt" value="@auth {{Auth::user()->city}} @endauth" name="city"><span class="error"></span>
                                </div>
                            </div>
                            <div class="clearfix"></div>                            
                            
                            <div class="form_section text-area-part">
                                <label>Enter your message<span class="asterisk">*</span></label>
                                <textarea placeholder="Write down your message…"
                                    class="messege" name="message"></textarea>
                                <span class="error" style="top: 0px !important;"></span>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary single_attendence_btn" onclick="saveContactCourses();">submit</button>
                            </div>
                        </form>
                    </div>
                    <div id="menu3" class="tab-pane fade">
                        <div class="form-group">
                            <label>Course Name</label>
                            <input type="text" class="name-txt form-control" disabled="" value="" name="course_name">
                        </div>
                        <form method="post" name="multiple_attendence_contacts" id="multiple_attendence_contacts">
                            <input type="hidden" name="course_contact_type" value="corporate">
                            <input type="hidden" name="course_contact_id" value="">

                            <div class="attendees_master_div">
                                <div class="attendees_div">
                                    <div class="row col-md-12">
                                        <div class="form_section">
                                            <label>First Name<span class="asterisk">*</span></label>
                                            <input type="text" placeholder="First name" class="name-txt" name="first_name[]" value="@auth {{Auth::user()->first_name}} @endauth">
                                            <span class="error"></span>
                                        </div>  
                                        <div class="form_section">
                                            <label>Last Name<span class="asterisk">*</span></label>
                                            <input type="text" placeholder="Last name" class="name-txt" name="last_name[]" value="@auth {{Auth::user()->last_name}} @endauth">
                                            <span class="error"></span>
                                        </div>
                                    </div>
                                    <div class="row col-md-12">
                                        <div class="form_section col-md-2 full-width pl-0" style="margin-right:0px;">
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
                                            <label>Phone<span class="asterisk">*</span></label>
                                            <input value="@auth {{Auth::user()->phone}} @endauth" type="text" placeholder="Enter Phone" name="phone" class="name-txt" min="1">
                                            <span class="error"></span>
                                        </div>
                                        <div class="form_section col-md-6 pl-0 mr-0">
                                            <label>Email Address<span class="asterisk">*</span></label>
                                            <input type="text" placeholder="Enter email" class="name-txt" name="email[]" value="@auth {{Auth::user()->email}} @endauth">
                                            <span class="error"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="attebdence_btn">
                                <button type="button" onclick="addMoreAttendence();" class="btn btn-secondary save-attendence add_more_attendence">Add New Attendees</button>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary bootom-btn multiple_attendence_btn" onclick="saveContactCourses();">submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
