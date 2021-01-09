<div class="modal fade bs-example-modal-lg home_contact-model quoteQueryModal" id="myModal1" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Request a Quote </h4>
                <p>Please fill in the details and we will get back within 24 hrs to help you & your team. We will send the quote to this email - <strong>@auth {{Auth::user()->email}} @endauth</strong></p>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <form method="post" name="footer-quote-query-form" id="footer-quote-query-form" class="quote-query-form-home">
                @csrf
                <div class="modal-body">
                    @guest
                        <div class="row">
                            <div class="form_section col-md-6" style="margin-right:0px;">
                                <label>First Name<span class="asterisk">*</span></label>
                                <input value="@auth {{Auth::user()->first_name}} @endauth" type="text" placeholder="Enter First name" class="name-txt" name="first_name">
                                <span class="error invalid-feedback first_name"></span>
                            </div>
                            <div class="form_section col-md-6" style="margin-right:0px;">
                                <label>Last Name<span class="asterisk">*</span></label>
                                <input value="@auth {{Auth::user()->last_name}} @endauth" type="text" placeholder="Enter Last name" class="name-txt" name="last_name">
                                <span class="error invalid-feedback last_name"></span>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form_section col-md-6" style="margin-right:0px;">
                                <label>Company Name <small>(write "Individual" for personal)</small><span class="asterisk">*</span></label>
                                <input type="text" placeholder="Enter Company Name" class="name-txt" name="company_name" value="@auth {{Auth::user()->company_name}} @endauth">
                                <span class="error invalid-feedback company_name"></span>
                            </div>
                            <div class="form_section col-md-6" style="margin-right:0px;">
                                <label>Email Address<span class="asterisk">*</span></label>
                                <input value="@auth {{Auth::user()->email}} @endauth" type="email" placeholder="Enter Email"  name="email" class="name-txt">
                                <span class="error invalid-feedback email"></span>
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
                                <span class="error invalid-feedback country"></span>
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
                                <span class="error invalid-feedback country_code"></span>
                            </div>
                            <div class="form_section col-md-4" style="margin-right:0px;">
                                <label>Phone<span class="asterisk">*</span></label>
                                <input value="@auth {{Auth::user()->phone}} @endauth" type="text" placeholder="Enter Phone" name="phone" class="name-txt" min="1">
                                <span class="error invalid-feedback phone"></span>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form_section col-md-6" style="margin-right:0px;">
                                <label>City<span class="asterisk">*</span></label>
                                <input value="@auth {{Auth::user()->city}} @endauth" type="text" placeholder="Enter City" name="city" class="name-txt" min="1">
                                <span class="error invalid-feedback city"></span>
                            </div>
                            <div class="form_section col-md-6" style="margin-right:0px;">
                                <label>Zipcode/P.O.Box </label>
                                <input value="@auth {{Auth::user()->zipcode}} @endauth" type="text" placeholder="Enter Zipcode/P.O.Box" name="zipcode" class="name-txt" min="1">
                                <span class="error invalid-feedback"></span>
                            </div>
                        </div>
                    @endguest
                    
                    <div class="row mb-1">
                    	<div class="form_section col-md-12 full-width mb-1" style="margin-right:0px;">
                            <label>Training Category <small>(Make multiple selections by holding CTRL key)</small><span class="asterisk">*</span></label>
                            <div class="dropdown form-control name-txt customRequestCheck mb-3" style="height: auto;">
                            	@php 
                                    $quoteCategories = \App\Models\Category::where('status', 1)->select('id','name')->orderBy('name','asc')->get();
                                @endphp
                            	<select data-placeholder="Choose a Category" name="category[]" class="chosen-select form-control name-txt quote_category_checkbox" multiple style="height: auto;background: none;">
                            		
										@foreach($quoteCategories as $row)
											<option value="{{$row->id}}">{{ucfirst($row->name)}}</option>
										@endforeach
								</select>
                            </div>
                            <span class="error invalid-feedback category"></span>
                        </div>
                     </div>

                    <div class="row mb-1 manufacturer_multi_loader">
                        <div class="form_section col-md-12 full-width quote_manufacturer_div" style="margin-right:0px;display: none;">
                            <label>Manufacturer <small>(Make multiple selections by holding CTRL key)</small><span class="asterisk">*</span></label>
                            <div class="dropdown form-control name-txt customRequestCheck mb-3" style="height: auto;">
	                            <select data-placeholder="Choose a Manufacturer" name="manufacturer[]" class="chosen-select form-control name-txt quote_manufacturer_checkbox" multiple style="height: auto;background: none;">
	                            </select>
	                        </div>
                            <span class="error invalid-feedback manufacturer"></span>
                        </div>
                    </div>
                    <div class="row mb-1 product_multi_loader">
                        <div class="form_section col-md-12 full-width quote_products_div" style="margin-right:0px;display: none;">
                            <label>Product <small>(Make multiple selections by holding CTRL key)</small><span class="asterisk">*</span></label>
                            <div class="dropdown form-control name-txt customRequestCheck mb-3" style="height: auto;">
                                <select data-placeholder="Choose a Product" name="product[]" class="chosen-select form-control name-txt quote_products_checkbox" multiple style="height: auto;background: none;">
                                </select>
                            </div>
                            <span class="error invalid-feedback product"></span>
                        </div>
                    </div>

                        
                    <div class="row quote_courses_div mb-1 course_multi_loader" style="display: none;">
                        <div class="form_section col-md-12 full-width" style="margin-right:0px;">
                            <label>Course <small>(Make multiple selections by holding CTRL key)</small><span class="asterisk">*</span></label>
                            
                            <div class="dropdown form-control name-txt customRequestCheck mb-3" style="height: auto;">
                                <select data-placeholder="Choose a Course" name="course[]" class="chosen-select form-control name-txt quote_courses_checkbox" multiple style="height: auto;background: none;">
                            	
                            	</select>
                            </div>
                            <span class="error invalid-feedback course"></span>
                        </div>
                    </div>

                    <div class="form_section text-area-part">
                        <label>Enter your message<span class="asterisk">*</span></label>
                        <textarea placeholder="Write down your message…" class="messege" name="message"></textarea>
                        <span class="error invalid-feedback message" style="top: 0px !important;"></span>
                    </div>  
                </div>
                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" id="footer-quote-query-form-btn">submit</button>
                </div>
            </form>
        </div>
    </div>
</div>
