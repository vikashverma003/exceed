<div class="modal fade bs-example-modal-lg home_contact-model myModalCustom cartQuoteQueryModal" id="cartQuoteQueryModal" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Request a Quote </h4>
                
                @guest
                    <p>Please fill in the details and we will get back within 24 hrs to help you & your team.</p>
                    <br>
                	<p>If you already have an account with us, please <a onclick="showLoginModal();" class="" href="javascript:;">Login</a> and request the quote again.</p>
                @endguest

                @auth
                    <p>Please fill in the details and we will get back within 24 hrs to help you & your team. We will send the quote to this email - <strong>@auth {{Auth::user()->email}} @endauth</strong></p>
                @endauth

                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <form method="post" class="cart-quote-query-form" name="cart-quote-query-form" id="cart-quote-query-form">
                @csrf
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
                            <label>Company Name <small>(write "Individual" for personal)</small><span class="asterisk">*</span></label>
                            <input type="text" placeholder="Enter Company Name" class="name-txt" name="company_name" value="@auth {{Auth::user()->company_name}} @endauth">
                            <span class="error"></span>
                        </div>
                        <div class="form_section col-md-6" style="margin-right:0px;">
                            <label>Email Address<span class="asterisk">*</span></label>
                            <input value="@auth {{Auth::user()->email}} @endauth" type="email" placeholder="Enter Email"  name="email" class="name-txt">
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
                    @endguest
                    <div class="row">
                        @guest
                        <div class="form_section col-md-6" style="margin-right:0px;">
                            <label>Zipcode/P.O.Box</label>
                            <input value="@auth {{Auth::user()->zipcode}} @endauth" type="text" placeholder="Enter Zipcode/P.O.Box" name="zipcode" class="name-txt" min="1">
                            <span class="error"></span>
                        </div>
                         @endguest

                        <div class=" col-md-6" style="margin-right:0px;">
                            <label>Quotes For New Course/ Cart Courses</label>
                            <label class="col-md-12 pl-0" style="cursor: pointer;">
                                <input type="radio" name="quote_selection" onchange="handleCartQuoteOption(this);" value="cart" class="form-control" checked="" style="display: inline-block;width: 10%;">The current cart items
                            </label>
                            <label class="col-md-12 pl-0" style="cursor: pointer;">
                                <input type="radio" name="quote_selection" onchange="handleCartQuoteOption(this);" class="form-control" value="new" style="display: inline-block;width: 10%;">New Course
                            </label>
                            <span class="error"></span>
                        </div>   
                    </div>

                    <div class="row cartQuoteCourse" style="display: none;">
                        <div class="form_section col-md-6 full-width" style="margin-right:0px;">
                            <label>Training Category<span class="asterisk">*</span></label>
                            <select name="category" class="form-control name-txt quote_category" style="height: 48px;background: none;">
                                <option value="">Select</option>
                                @php 
                                    $quoteCategories = \App\Models\Category::where('status', 1)->select('id','name')->orderBy('name','asc')->get();
                                @endphp

                                @foreach($quoteCategories as $row)
                                    <option value="{{$row->id}}">{{ucfirst($row->name)}}</option>
                                @endforeach
                            </select>
                            <span class="error"></span>
                        </div>

                        <div class="form_section col-md-6 full-width quote_manufacturer_div" style="margin-right:0px;display: none;">
                            <label>Manufacturer<span class="asterisk">*</span></label>
                            <select name="manufacturer" class="form-control name-txt quote_manufacturer" style="height: 48px;background: none;">
                                <option value="">Select</option>
                                
                            </select>
                            <span class="error"></span>
                        </div>
                        <div class="form_section col-md-6 full-width quote_products_div" style="margin-right:0px;display: none;">
                            <label>Product<span class="asterisk">*</span></label>
                            <select name="product" class="form-control name-txt quote_products" style="height: 48px;background: none;">
                                <option value="">Select</option>
                                
                            </select>
                            <span class="error"></span>
                        </div>

                        <div class="form_section col-md-12 full-width quote_courses_div" style="margin-right:0px;display: none;">
                            <label>Course<span class="asterisk">*</span></label>
                            <select name="course" class="form-control name-txt quote_courses" style="height: 48px;background: none;">
                                <option value="">Select</option>
                            </select>
                            <span class="error"></span>
                        </div>
                    </div>

                    <div class="form_section text-area-part">
                        <label>Enter your message<span class="asterisk">*</span></label>
                        <textarea placeholder="Write down your message…" class="messege" name="message"></textarea>
                        <span class="error" style="top: 0px !important;"></span>
                    </div>  
                </div>
                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" id="cart-quote-query-form-btn">submit</button>
                </div>
            </form>
        </div>
    </div>
</div>
