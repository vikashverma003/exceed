@extends('frontend.layouts.app')
@section('title', 'Profile')


@section('content')

    @include('frontend.layouts.header')

    <div class="main_section">
        <div class="progile-main-section">
            <div class="container">
                <div class="row">

                    <div class="tab">
                        <h4>Account Settings</h4>
                        <button class="tablinks" onclick="openTab(event, 'profile')" id="defaultOpen"><i class="fa fa-user mr-2"></i>Profile
                        </button>
                        <button class="tablinks" onclick="openTab(event, 'password')"><i class="fa fa-unlock-alt mr-2"></i>Change Password
                        </button>
                       {{--<button class="tablinks" onclick="openTab(event, 'notification')"><i class="fa fa-bell mr-2"></i>Notification Settings
                        </button>--}}
                    </div>

                    <div id="profile" class="tabcontent">
                        <h3>Profile information</h3>

                        <div class="profile_section-img">
                            <img src="{{asset('img/ic_corporate.svg')}}">
                        </div>
                        <div class="profile_section-txt">
                            <h2>{{ucfirst(\Auth::user()->name)}}</h2>
                            
                            <div class="bio-section row bio_summary">
                                <div class="contact-number col-md-4 mr-0">
                                    <h4>Email</h4>
                                    <p>{{\Auth::user()->email}}</p>
                                </div>
                                <div class="contact-number col-md-4 mr-0">
                                    <h4>Contact Number</h4>
                                    <p>+{{\Auth::user()->country_code}}-{{\Auth::user()->phone}}</p>
                                </div>
                                <div class="contact-number col-md-4 mr-0">
                                    <h4>Company Name</h4>
                                    <p>{{\Auth::user()->company_name ?? 'N/A'}}</p>
                                </div>
                                <div class="contact-number col-md-4 mr-0">
                                    <h4>City </h4>
                                    <p>{{\Auth::user()->city ?? 'N/A'}}</p>
                                </div>
                                <div class="contact-number col-md-4 mr-0">
                                    <h4>State </h4>
                                    <p>{{\Auth::user()->state ?? 'N/A'}}</p>
                                </div>
                                <div class="contact-number col-md-4 mr-0">
                                    <h4>Country </h4>
                                    <p>{{\Auth::user()->country ?? 'N/A'}}</p>
                                </div>
                                <div class="contact-number col-md-4 mr-0">
                                    <h4>Zipcode/P.O.Box </h4>
                                    <p>{{\Auth::user()->zipcode ?? 'N/A'}}</p>
                                </div>
                            </div>

                            <a href="javascript:;" class="edit_profile stleClassColor" >Edit Profile</a>
                            
                            <div class="bio-section bio-form-section bio-section-form" style="display: none;">
                                <form method="post" name="profile-form" id="profile-form">
                                    @csrf
                                    <div class="row">
                                        <div class="form_group col-md-6">
                                            <label>First Name</label>
                                            <input type="text" class="txt-box" placeholder="Enter First Name" value="{{\Auth::user()->first_name}}" name="first_name">
                                            <span class="error" style="top: 5px !important;"></span>
                                        </div>
                                        <div class="form_group col-md-6">
                                            <label>Last Name</label>
                                            <input type="text" class="txt-box" placeholder="Enter Last Name" value="{{\Auth::user()->last_name}}" name="last_name">
                                            <span class="error" style="top: 5px !important;"></span>
                                        </div>
                                        
                                        
                                    </div>
                                    <div class="row">
                                        <div class="form_group col-md-6">
                                            <label>Company Name</label>
                                            <input type="text" class="txt-box" placeholder="Company Name" value="{{\Auth::user()->company_name}}" name="company_name">
                                             <span class="error" style="top: 5px !important;"></span>
                                        </div>

                                        <div class="form_group col-md-6">
                                            <label>Country</label>
                                            <select class="form-control name-txt contact_country" name="country" style="height: 48px;background: none; padding: 0 0 0 10px;margin-top: 10px;">
                                                <?php
                                                    $country = \App\Models\Country::get();
                                                ?>
                                                @foreach($country as $row)
                                                    <option value="{{$row['nicename']}}" data-id="{{$row['id']}}" @if(\Auth::user()->country==$row['nicename']) selected @endif>{{ucfirst($row['nicename'])}}</option>
                                                @endforeach
                                            </select>
                                             <span class="error" style="top: 5px !important;"></span>
                                        </div> 
                                    </div>
                                    <div class="row">
                                        <div class="form_group col-md-2">
                                            <label>Code<span class="asterisk">*</span></label>
                                            <select class="form-control name-txt contact_code" name="country_code" style="height: 45px;background: none;    padding: 0 0 0 10px;margin-top: -4px;">
                                                <?php
                                                    $codes = \App\Models\Country::get();
                                                ?>
                                                @foreach($codes as $row)
                                                    <option value="{{$row['phonecode']}}" @if(\Auth::user()->country_code==$row['phonecode']) selected @endif>{{$row['phonecode']}}</option>
                                                @endforeach
                                            </select>
                                            <span class="error"></span>
                                        </div>
                                        <div class="form_group col-md-4">
                                            <label>Phone</label>
                                            <input type="text" class="txt-box" placeholder="Phone Number" value="{{\Auth::user()->phone}}" name="phone">
                                             <span class="error" style="top: 5px !important;"></span>
                                        </div>

                                        <div class="form_group col-md-6">
                                            <label>City</label>
                                            <input type="text" class="txt-box" placeholder="City Name" value="{{\Auth::user()->city}}" name="city">
                                             <span class="error" style="top: 5px !important;"></span>
                                        </div>
                                        
                                    </div>

                                    <div class="row">
                                        <div class="form_group col-md-6">
                                            <label>State</label>
                                            <input type="text" class="txt-box" placeholder="State Name" value="{{\Auth::user()->state}}" name="state">
                                             <span class="error" style="top: 5px !important;"></span>
                                        </div>
                                        <div class="form_group col-md-6">
                                            <label>Zipcode/P.O.Box</label>
                                            <input type="text" class="txt-box" placeholder="Enter Zipcode/P.O.Box" value="{{\Auth::user()->zipcode}}" name="zipcode">
                                             <span class="error" style="top: 5px !important;"></span>
                                        </div>
                                    </div>
                                   

                                    <div class="button_changre-pass">
                                        <button type="button" class="btn btn-large changeProfileBtn">Update</button>
                                    </div>
                                </form>
                            </div>
                            
                        </div>

                    </div>

                    <div id="password" class="tabcontent">
                        <h2>Change Account Password</h2>
                        <form class="form_change-pass" method="post" name="change-password-form" id="change-password-form">
                            @csrf
                            <div class="form_group">
                                <input type="password" class="txt-box" placeholder="Current Password" value="" name="current_password">
                                <span toggle="current_password" class="fa fa-fw field-icon toggle-password fa-eye" style="float: right;
                                                margin-left: -25px;
                                                margin-top: 16px;
                                                position: relative;
                                                z-index: 2;
                                                right: 12px;">
                                </span>
                                 <span class="error" style="top: 5px !important;"></span>
                            </div>
                            <div class="form_group">
                                <input type="password" class="txt-box" placeholder="New Password" value="" name="new_password">
                                <span toggle="new_password" class="fa fa-fw field-icon toggle-password fa-eye" style="float: right;
                                                margin-left: -25px;
                                                margin-top: 16px;
                                                position: relative;
                                                z-index: 2;
                                                right: 12px;">
                                </span>
                                 <span class="error" style="top: 5px !important;"></span>
                            </div>
                            <div class="form_group">
                                <input type="password" class="txt-box" placeholder="Confirm Password" value="" name="confirmed_password">
                                <span toggle="confirmed_password" class="fa fa-fw field-icon toggle-password fa-eye" style="float: right;
                                                margin-left: -25px;
                                                margin-top: 16px;
                                                position: relative;
                                                z-index: 2;
                                                right: 12px;">
                                </span>
                                 <span class="error" style="top: 5px !important;"></span>
                            </div>
                            <div class="button_changre-pass">
                                <button type="button" class="btn btn-large changePasswordBtn">Change Password</button>
                            </div>
                        </form>
                    </div>

                    <div id="notification" class="tabcontent">
                        <div class="profile_section-txt radio_buttons">
                            <form>
                                <h2>Notification</h2>
                                <p>Turn promotional email notifications from exceed media on or off</p>
                                <span>I want to receive:</span>
                                <div class="radio-section">
                                    <label>
                                        <input type="checkbox" class="checkboxss">
                                        <p>Discount coupons from Exceed. </p>
                                    </label>
                                </div>
                                <div class="radio-section">
                                    <label>
                                        <input type="checkbox" class="checkboxss">
                                        <p>Promotions, course recommendations, and helpful resources from Exceed. </p>
                                    </label>
                                </div>
                                <div class="radio-section">
                                    <label>
                                        <input type="checkbox" class="checkboxss">
                                        <p>Don't send me any promotional emails.</p>
                                    </label>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
   @include('frontend.layouts.footer',['homeFooter'=>0])
   @include('frontend.includes.contact-us')
@endsection
    
@section('scripts')
    <script type="text/javascript">
        function openTab(evt, cityName) {
            var i, tabcontent, tablinks;
            tabcontent = document.getElementsByClassName("tabcontent");
            for (i = 0; i < tabcontent.length; i++) {
                tabcontent[i].style.display = "none";
            }
            tablinks = document.getElementsByClassName("tablinks");
            for (i = 0; i < tablinks.length; i++) {
                tablinks[i].className = tablinks[i].className.replace(" active", "");
            }
            document.getElementById(cityName).style.display = "block";
            evt.currentTarget.className += " active";
        }

        // Get the element with id="defaultOpen" and click on it
        document.getElementById("defaultOpen").click();

        $(document).ready(function(){

            $(".toggle-password").click(function() {
                $(this).toggleClass("fa-eye fa-eye-slash");
                var input = $(this).attr("toggle");
                
                var selector = $('input[name="'+input+'"]');
                if (selector.attr("type") == "password") {
                    selector.attr("type", "text");
                } else {
                    selector.attr("type", "password");
                }
            });

            $(document).on('click','.edit_profile', function() {
                $(this).hide()
                $('.bio_summary').hide()
                if($('.bio-section-form').is(':visible')){
                    $('.bio-section-form').hide();
                }else{
                    $('.bio-section-form').show();
                }
            });

            $(document).on('click','.changePasswordBtn', function(e){
                var $form = $('#change-password-form');
                e.preventDefault();
                $form.find('.is-invalid').removeClass('is-invalid');
                $form.find('.error').text('');

                $.ajax({
                    url: '/change-password', //url
                    type: 'POST', //request method
                    data: $form.serialize(),
                    beforeSend:function(){
                        startLoader('.main_section');
                    },
                    complete:function(){
                        stopLoader('.main_section');
                    },
                    success: function(data) {
                        if(data.status){
                            Swal.fire({
                                title: 'Success!',
                                text: data.message,
                                icon: 'success',
                                confirmButtonText: 'Ok'
                            }).then(function(){
                                window.location = data.url;
                            });
                        }else{
                           Swal.fire({
                                title: 'Error!',
                                text: data.message,
                                icon: 'error',
                                confirmButtonText: 'Ok'
                            });
                        }
                    },
                    error:function(data){
                        stopLoader('.main_section');
                        if(data.responseJSON){
                            var err_response = data.responseJSON;
                            if(err_response.errors==undefined && err_response.message) {
                                Swal.fire({
                                    title: 'Error!',
                                    text: err_response.message,
                                    icon: 'error',
                                    confirmButtonText: 'Ok'
                                });
                            } 
                            $.each(err_response.errors, function(i, obj){
                                $form.find('input[name="'+i+'"]').next().next('span.error').text(obj);
                                $form.find('input[name="'+i+'"]').addClass('is-invalid');
                            });
                        }
                    }
                });
            });

            $(document).on('click','.changeProfileBtn', function(e){
                var $form = $('#profile-form');
                e.preventDefault();
                $form.find('.is-invalid').removeClass('is-invalid');
                $form.find('.error').text('');

                $.ajax({
                    url: '/update-profile', //url
                    type: 'POST', //request method
                    data: $form.serialize(),
                    beforeSend:function(){
                        startLoader('.main_section');
                    },
                    complete:function(){
                        stopLoader('.main_section');
                    },
                    success: function(data) {
                        if(data.status){
                            Swal.fire({
                                title: 'Success!',
                                text: data.message,
                                icon: 'success',
                                confirmButtonText: 'Ok'
                            }).then(function(){
                                window.location.reload();
                            });
                        }else{
                           Swal.fire({
                                title: 'Error!',
                                text: data.message,
                                icon: 'error',
                                confirmButtonText: 'Ok'
                            });
                        }
                    },
                    error:function(data){
                        stopLoader('.main_section');
                        if(data.responseJSON){
                            var err_response = data.responseJSON;
                            if(err_response.errors==undefined && err_response.message) {
                                Swal.fire({
                                    title: 'Error!',
                                    text: err_response.message,
                                    icon: 'error',
                                    confirmButtonText: 'Ok'
                                });
                            } 
                            $.each(err_response.errors, function(i, obj){
                                $form.find('input[name="'+i+'"]').next('span.error').text(obj);
                                $form.find('input[name="'+i+'"]').addClass('is-invalid');
                            });
                        }
                    }
                });
            });
        });
    </script>
@endsection