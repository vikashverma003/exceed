@extends('frontend.layouts.app')
@section('title', 'Course Details')
@section('meta_description',$course->meta_description)
@section('meta_keywords',$course->meta_keywords)
@section('css')
<link rel="stylesheet" href="{{asset('css/datepicker.css')}}">
<style type="text/css">
    .course-image
    {
        max-height: 230px;
    }
</style>
@endsection
@section('content')

    @include('frontend.layouts.header')

    <div class="main_section">
        <div class="bk_image1 product-section search_sections">
            <div class="container">
                <div class="row">
                    <div class="search_part product_page-part">
                        <form method="get" action="{{url('/products')}}" name="details_search_form" id="details_search_form" class="mr-2">
                            <img src="{{asset('img/ic_search.svg')}}">
                            <input type="search" class="search" placeholder="Search Course Name … " name="course_name" value="" autofocus="autofocus" autocomplete="off" required="true">
                        </form>
                    </div>
                    <p class="advance_serch" onclick="$('#demo').toggle();">&nbsp;&nbsp; Advance Search</p>

                    @include('frontend.courseDetails.advance-filter')
                </div>
            </div>
        </div>
        @php
            $banner = $course->banner;
            if($banner)
                $banner = asset('uploads/courses/'.$banner);
            else
                $banner = asset('/img/testimonial_bg.png');
        @endphp
        <div class="top_banner-section" style="background-image: url('{{$banner}}');background-position: center;background-repeat: no-repeat;background-size: cover;padding: 60px 0 50px;">
            <div class="container">
                <div class="row">
                    <div class="col col-md-12">
                        <div class="photo_shop-funda">
                           <!--  <span class="online-live">· Design</span>
                            <span class="online-live">· Online Live Training </span> -->
                            <!-- course name -->
                            <p style="width: 65%">{{ucfirst($course->name)}}</p>
                            <!-- course views -->
                            <img src="{{asset('img/ic1_viewed_by.svg')}}">
                            <span class="view_coursse">{{$course->views}} Views</span>
                            <!-- course duration -->
                            <img src="{{asset('img/ic_duration.svg')}}">
                            <span class="view_coursse">
                                @if(!is_null($course->duration))
                                Duration: {{$course->duration}} {{$course->duration_type}}
                                @endif
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="together_coures">
            <div class="container">
                <div class="row">
                    <div class="col col-md-8 pl-0">
                        
                        <!-- bought togther section -->
                        <!-- @include('frontend.courseDetails.bought') -->

                        <!-- about course -->
                        <div class="about_this-course">
                            {!! $course->description !!}

<!-- 
                            <div class="course-detail-manufacturer">
                                <img src="{{asset('uploads/manufacturers/'.$course->manufacturer->logo)}}" style="margin-top: 20px;width: 100%;max-width: 162px;height: auto">
                            </div> -->
                        </div>

                        <!-- course outlines -->
                        @if(count(@$course->outlines)>0)
	                        <h2 class="course_outline">
	                            Course Outlines 
	                            @guest
	                                <a href="javascript:;" class="stleClassColor" onclick="showLoginModal();">
	                                    <img src="{{asset('img/ic_print.svg')}}" class="print-screens">
	                                </a>
	                            @endguest

	                            @auth
	                                <a href="{{url('outline-pdf')}}" class="stleClassColor" target="_blank">
	                                    <img src="{{asset('img/ic_print.svg')}}" class="print-screens">
	                                </a>
	                            @endauth
	                        </h2>
                        
	                        <div class="about_this-course outline-coursess">
	                            <!-- outline -->
	                            @include('frontend.courseDetails.outline')
	                        </div>
                        @endif
                       


                        <!-- course related courses -->
                        @include('frontend.courseDetails.relatedcourse')
                    </div>


                    <!-- course deatail page right side bar -->
                    <div class="col col-md-4">
                        <div class="right-side-top togerther-2 sticky-top mb-5">
                            <div class="right-side-course">
                                <div class="course-image-section video_course_helper">
                                    @if($course->inner_image)
                                    <img src="{{asset('uploads/courses/'.$course->inner_image)}}" class="course-image">
                                    @elseif($course->image)
                                    <img src="{{asset('uploads/courses/'.$course->image)}}" class="course-image">
                                    @else
                                        <img src="{{asset('img/banner_bg.png')}}" class="course-image">
                                    @endif
                                </div>
                            
                                @if($course->short_note)
                                    <p>
                                       <i class="fa fa-info-circle" aria-hidden="true"></i> {{ Str::limit( strip_tags($course->short_note), $limit = 30, $end = '...') }}  
                                    </p>
                               @endif
                                <!-- <h2>This Course Included in Combo Offers</h2> -->
                                <div class="ade-section course-detail-price">
                                    <span>
                                        <strong>AED {{!is_null($course->offer_price) ? $course->offer_price : '(N/A)'}}</strong> 
                                        <small> per seat </small>
                                    </span>
                                    <p class="ade-txt">
                                        @if(!is_null($course->price))
                                        AED {{!is_null($course->price) ? $course->price : '(N/A)'}}
                                        @endif
                                    </p>
                                </div>
                                <div class="ade-right">
                                     @if(!is_null($course->duration))
                                    <img src="{{asset('img/ic_duration.svg')}}">
                                    <span> Duration: {{$course->duration}} {{$course->duration_type}}</span>
                                    @endif
                                </div>
                                <div class="form-part-full">
                                    <div class="form_section full-width">
                                        <label>Seats</label>
                                        <div class="number">
                                            <span class="minus seat_minus">-</span>
                                            <input type="text" value="1" min="1" max="50" name="course_seat" id="course_seat" style="box-shadow: none; width: 40px !important;height: 30px; text-align: center;" readonly="" />
                                            <span class="plus seat_plus">+</span>
                                        </div>
                                        
                                        <span class="error course_error"></span>
                                    </div>
                                    

                                    <div class="time-loction form_section full-width button-addto">
                                    	<button type="button" class="courseLocationBtn add-cart btn btn-large mb-0" data-id="{{$course->id}}" data-name="{{$course->name}}" data-term="{{encrypt($course->id)}}"><i class="fa fa-map-marker" aria-hidden="true"></i> Schedules</button>
                                    </div>

                                    @if(!is_null($course->offer_price))
                                    <div class="time-loction form_section full-width button-addto">
                                        <button type="button" class="courseLocationBtn add-cart btn btn-large" data-id="{{$course->id}}" data-name="{{$course->name}}" data-term="{{encrypt($course->id)}}">Add to Cart</button>
                                    </div>
                                    @endif

                                    <input type="hidden" name="course_term_val" id="course_term_val" value="{{encrypt($course->id)}}">
                                    <input type="hidden" name="course_imp_id" id="course_imp_id" value="{{$course->id}}">

                                    <input type="hidden" name="course_term_name" id="course_term_name" value="{{$course->name}}">

                                    <!-- <div class="form_section full-width button-addto">
                                        <button type="button" class="add-cart btn btn-large addCartBtn" data-course="{{encrypt($course->id)}}">Add to Cart</button>
                                    </div>

                                    <div class="form_section full-width button-addto">
                                        <button type="button" class="buy-course-cart btn btn-large BuyNowBtn" data-course="{{encrypt($course->id)}}">Buy this Course</button>
                                    </div> -->

                                    <div>
                                        <span class="info" style="opacity: 0.7;color: #2C2C2C;font-family: 'Google Sans';font-size: 14px;font-weight: 500;line-height: 24px;">Note: Buy has the option to pay by Credit/Debit cards or by purchase order.</span>
                                    </div>
                                   
                                </div>
                            </div>

                            <div class="right-side-course need-course">
                                <p>Need More information of this course or Want to
                                    talk to the experts?
                                </p>
                                <hr>
                                <p class="contact-us-course showDetailRequestQuoteModal" style="cursor: pointer;"> 
                                    Request Quote
                                </p>
                                 <hr>
                                <p class="contact-us-course stleClassColor" onclick="showLiveChat();" style="cursor: pointer;">Live Chat</p>
                                <hr>
                                <p class="contact-us-course" onclick='showCourseShareModal("{{$course->id}}");' style="cursor: pointer;"><i class="fa fa-share"></i> Share</p>
                               
                                
                            </div>
                            <div class="right-side-course need-course">
                                <iframe src="https://www.facebook.com/plugins/like.php?href=https%3A%2F%2Fwww.facebook.com%2Fexceed.media.training&width=450&layout=standard&action=like&size=large&share=true&height=35&appId=1103571003329710" width="450" height="35" style="border:none;display:block;width:96%;overflow:hidden" scrolling="no" frameborder="0" allowTransparency="true" allow="encrypted-media"></iframe>

                                <!-- <div class="fb-like" data-href="https://www.facebook.com/exceed.media.training" data-width="" data-layout="standard" data-action="like" data-size="small" scrolling="no" data-share="true" style="max-width:96%;word-break: break-all;display:block"></div> -->
                            </div>
                            <!-- <img src="{{asset('img/ic_degital_video_editing.svg')}}"> -->
                            @if($course->sample_video && $course->sample_video!="")
                                <div class="right-side-course need-course video_course_helper cursor-pointer" onclick="showVideoPlayer('{{$course->sample_video}}')">
                                    <div class="video-txt" style="position: relative;">
                                        <span class="video-view">View/Play Course Video</span>
                                        <p class="p-0 m-0">&nbsp; </p>
                                        <img src="{{asset('img/ic_play@2x.png')}}" class="video-icon">
                                        <!-- <img src="{{asset('img/thumb.png')}}" id="play-image" class="course-image play-image"> -->
                                    
                                      <iframe id="play-image" src="{{$course->sample_video}}" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                                    </div>
                                </div>
                            @endif
                            

                            <a id="scrollToTop" class="hide">
                                 <div class="right-side-course need-course">
                                    <div class="courseLocationBtn time-loction" data-id="{{$course->id}}" data-name="{{$course->name}}" data-term="{{encrypt($course->id)}}" style="text-align: center;">
                                        <h4 style="
                                            display: inline-block;
                                            font-size: 16px;
                                            margin-bottom: 0;margin-right: 2px;
                                        ">
                                            <i class="fa fa-map-marker" aria-hidden="true"></i> <span>Locations</span>
                                        </h4>
                                        &
                                        <h4 style="
                                            display: inline-block;
                                            margin-left: 2px;
                                            font-size: 16px;
                                            margin-bottom: 0;
                                        ">
                                            <i class="fa fa-clock-o" aria-hidden="true"></i>
                                            <span>Time</span>
                                        </h4>
                                    </div>
                                    <hr>

                                    <div class="scroll-to-top">
                                        <div class="video_section">
                                            <img src="{{asset('img/video-call.svg')}}">
                                        </div>
                                        <div class="video-txt">
                                            <p>Interested ?</p>
                                            <span class="video-view">Fill the Form</span>
                                        </div>
                                    </div>
                                </div>
                            </a>

							@include('frontend.courseDetails.modals.terms')
							@include('frontend.courseDetails.modals.addCart')
							
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    

	@include('frontend.layouts.footer',['homeFooter'=>0])
	@include('frontend.includes.contact-us')
	@include('frontend.includes.sharecourse')
	@include('frontend.products.modal.locations')
	@include('frontend.courseDetails.modals.quote-request')
	@include('frontend.courseDetails.modals.video')

@endsection
    
@section('scripts')
    <script src="{{asset('js/jquery.cookie.js')}}"></script>
    <script type="text/javascript">
        var buyCartClick = '';
        const courseName = $('#course_term_name').val();
        const courseTermVal = $('#course_term_val').val();
        
        

        const copyCourseText = function(){
			var copyText = document.getElementById("myInput");
			copyText.select();
			copyText.setSelectionRange(0, 99999);
			document.execCommand("copy");
        }

        const showCourseQuoteModal = function(){
		    closeAllModals();
		    $('.courseQueryModal').modal('show');
		}

       
        $(document).ready(function(){
            
            $(document).on('click','.showCourseListingQuoteModal', function(){
                if(!customerLoggedIn ){
                    showLoginModal();
                    return false;
                }
                
                $('.courseQueryModal').find('input[name="course"]').val($('#course_term_name').val());
                $('.courseQueryModal').find('input[name="course_page_course_id"]').val($('#course_imp_id').val());
                showCourseQuoteModal();
            });


            var viewport = jQuery(window).width();
            var itemCount = jQuery(".related_courses .owl-item").length;

            if((viewport>=500 && itemCount>2) || (viewport>=900 && itemCount>3))
            {
                jQuery('.related_courses .owl-prev,.related_courses .owl-next').show();
            } 
            else
            {
                jQuery('.related_courses .owl-prev,.related_courses .owl-next').hide();
            }

            var scrollToTop = $('#scrollToTop');


            $(document).on('click','#quote-query-form-btn', function(e){
                var $form = $('#quote-query-form');
                e.preventDefault();
                $form.find('.is-invalid').removeClass('is-invalid');
                $form.find('.error').text('');

                $.ajax({
                    url: '/quote-query', //url
                    type: 'POST', //request method
                    data: $form.serialize(),
                    headers: {'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')},
                    beforeSend:function(){
                        startLoader('.modal-content');
                    },
                    complete:function(){
                        stopLoader('.modal-content');
                    },
                    success: function(data) {
                        if(data.status){
                            Swal.fire({
                                title: 'Success!',
                                text: data.message,
                                icon: 'success',
                                confirmButtonText: 'Ok'
                            });
                            $('.courseQueryModal').modal('hide');
                            $('.modal').modal('hide');
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
                        stopLoader('.modal-content');
                        if(data.responseJSON){
                            var err_response = data.responseJSON;
                            show_FlashMessage('Please fill all required fields.','error');
                            $.each(err_response.errors, function(i, obj){
                                $form.find('.invalid-feedback.'+i+'').text(obj).show();
                                $form.find('input[name="'+i+'"]').addClass('is-invalid');
                                $form.find('select[name="'+i+'"]').addClass('is-invalid');
                                $form.find('textarea[name="'+i+'"]').addClass('is-invalid');
                            });
                        }
                    }
                });
            });

            $(document).on('click','.course_details_advance_filter_submit', function(e){
                e.preventDefault();
                var $form = $("form[name='advance_search_form']");
                var url = $form.attr('action');
                var course_name = $form.find('input[name="course_name"]').val();
                var fromDate = $startDate.val();
                var toDate = $endDate.val();
                
                url+='?course_name='+course_name+'&start_date='+fromDate+'&end_date='+toDate;
                $('.advance_filter_manufacturers ul>li').each(function(i){
                    if($(this).is('.active')){
                        url+='&manufacturers[]='+$(this).data('name');
                    }
                });
                $('.advance_filter_categories ul>li').each(function(i){
                    if($(this).is('.active')){
                        url+='&categories[]='+$(this).data('name');
                    }
                });
                $('.advance_filter_locations ul>li').each(function(i){
                    if($(this).is('.active')){
                        url+='&locations[]='+$(this).data('name');
                    }
                });
                $('.advance_filter_courses ul>li').each(function(i){
                    if($(this).is('.active')){
                        url+='&courses[]='+$(this).data('name');
                    }
                });
                startLoader('body');
                window.location = url;
            });
            // $(window).scroll(function() {
            //     if ($(window).scrollTop() >  $( '.video_course_helper').offset().top + $('.video_course_helper'). outerHeight()) 
            //     {
            //         scrollToTop.addClass('show');
            //     } 
            //     else {
            //         scrollToTop.removeClass('show');
            //     }
            // });

            $(window).scroll(function() {
                if ($(window).scrollTop() > 150) 
                {
                    $('.course-image-section').fadeOut();
                } 
                else {
                    $('.course-image-section').fadeIn();
                }
            });

            $('.seat_minus').click(function () {
                var $input = $(this).parent().find('input');
                var count = parseInt($input.val()) - 1;
                count = count < 1 ? 1 : count;
                $input.val(count);
                $input.change();
                return false;
            });
            $('.seat_plus').click(function () {
                var $input = $(this).parent().find('input');
                $input.val(parseInt($input.val()) + 1);
                $input.change();
                return false;
            });

            
            $('.scroll-to-top').on('click', function(e) {
                e.preventDefault();
                $('html, body').animate({
                   scrollTop: $(".course-detail-price").offset().top
                }, 1000);
            });

            $('#add-tocartpop').on('hidden.bs.modal', function (e) {
                $(this).find("input[type='text']").val('').end();
                $(document).find('.error').text('');
            });

            $('#video').on('hidden.bs.modal', function (e) {
                $('#course_video_player').attr('src', "");
            });
            

            $('#buy-couse').on('hidden.bs.modal', function (e) {
                $(this).find("input[type=checkbox]").prop("checked", "").end();
                $(document).find('.error').text('');
            });

            $(document).on('change','select', function(){
                $(document).find('.error').text('');
            });

            $(document).on('click','.showDetailRequestQuoteModal', function(){
                if(!customerLoggedIn ){
                    showLoginModal();
                    return false;
                }
            	$('.courseQueryModal').find('input[name="course"]').val($('#course_term_name').val());
                $('.courseQueryModal').find('input[name="course_page_course_id"]').val($('#course_imp_id').val());
                showCourseQuoteModal();
            });

            // sort filter change event
            $(document).on('change','#course_location', function(e){
                $(document).find('.error').text('');

                var location  = $(this).val();
                var course  = $(this).find(':selected').attr('data-course')
                var id  = $(this).find(':selected').attr('data-id')
                if(!course){
                    return false;
                }
                $.ajax({
                    url: '{{url("course-timings")}}', //url
                    type: 'get', //request method
                    data:{
                        'location':location,
                        'course':course,
                        'id':id
                    },
                    beforeSend:function(){
                        startLoader('.main_section');
                    },
                    complete:function(){
                        stopLoader('.main_section');
                    },
                    success: function(data) {
                        if(data.status){
                            var html='<option value="">Select Date</option>';
                            $.each(data.data, function(key, val){
                                html+='<option value="'+val.original_date+'" data-id="'+val.id+'">'+val.start_date+'-'+val.date+' '+val.start_time+'-'+val.end_time+'</option>';
                            });
                            $('#course_date').html(html);

                        }else{
                           $('#course_date').html('<option value="">Select Date</option>');
                        }
                    },
                    error:function(data){
                        stopLoader('.main_section');
                        $('#course_date').html('<option value="">Select Date</option>');
                    }
                });
            });

            // add cart click
            $(document).on('click','.addCartBtn,.BuyNowBtn', function(e){
                $(document).find('.error').text('');
                help_clicked = false;

                var course = $('#course_term_val').val();
                var seat = $('#course_seat').val();
                var location = $('#course_location').val();
                var date = $('#course_date').val();
                $('span.course_error').text('').hide();
                if(!seat){
                    show_FlashMessage('Please Select Seats.','error');
                    return false;
                }else{
                    if(seat <1 || seat > 100){
                        show_FlashMessage('Please Select between 1-100 seats.','error');
                        return false;
                    }
                    if(!jQuery.isNumeric(seat)){
                        show_FlashMessage('Please enter valid numeric seats.','error');
                        return false;
                    }
                }
                
                if(!location){
                    show_FlashMessage('Please Select Course Location.','error');
                    return false;
                }
                if(!date){
                    show_FlashMessage('Please Select Course Date.','error');
                    return false;
                }
                if(!course){
                    show_FlashMessage('Something went wrong, Please try again.','error');
                    return false;
                }
            
                if($.cookie('course-term')==undefined){
                    $('#buy-couse').modal('show');
                }else
                {
                    AddToCart();
                }
            });

            // buy now click
            $(document).on('click','.TermConfirmButton', function(e){
                $(document).find('.error').text('');
            	if($('input[name="course_term"]:checked').length==0){
            		show_FlashMessage('Please accept terms and conditions.','warning');
                    return false;
            	}
            	else{
                    help_clicked = false;
                    closeAllModals();
                    AddToCart();
            	}
            });
        });
        
        // function to add to cart
        const AddToCart = function(){
            $(document).find('.error').text('');
            var course = $('#course_term_val').val();
            var seat = $('#course_seat').val();
            var location = $('#course_location').val();
            var date = $('#course_date').val();
            $('span.course_error').text('').hide();
            if(!seat){
                show_FlashMessage('Please Select Seats.','error');
                return false;
            }else{
                if(seat <1 || seat > 100){
                    show_FlashMessage('Please Select between 1-100 seats.','error');
                    return false;
                }
                if(!jQuery.isNumeric(seat)){
                    show_FlashMessage('Please enter valid numeric seats.','error');
                    return false;
                }
            }
            
            if(!location){
                show_FlashMessage('Please Select Course Location.','error');
                return false;
            }
            if(!date){
                show_FlashMessage('Please Select Course Date.','error');
                return false;
            }
            if(!course){
                show_FlashMessage('Something went wrong, Please try again.','error');
                return false;
            }

            $.ajax({
                url: '{{url("addToCart")}}', //url
                type: 'post', //request method
                data:{
                    'course':course,
                    'seat':seat,
                    'location':location,
                    'date':date,
                    'course_timing_id':$('#course_date').find(':selected').data('id'),
                },
                dataType : 'json',
                beforeSend:function(){
                    startLoader('.main_section');
                },
                complete:function(){
                    stopLoader('.main_section');
                },
                headers: {'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')},
                success: function(data) {
                    if(data.status){
                        Swal.fire({
                            title: 'Success!',
                            text: data.message,
                            icon: 'success',
                            cancelButtonText: 'Continue Shopping',
                            confirmButtonText: 'Go to Cart',
                            showCancelButton: true,
                        }).then((result) => {
                            $('.cart_count').text(data.count);
                            $('.modal').modal('hide');
                            if (result.value) {
                                window.location.href="{{url('cart')}}"
                            }else{
                                scrollToCartIcon();
                            }
                        });
                    }
                    else
                    {
                       show_FlashMessage(data.message,'error');
                       return false;
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
                    }
                }
            });
        }

        
        const saveContactCourses = function(e){
            if(help_clicked){
                saveContactCoursesHelp();
            }
            else
            {
                $(document).find('.error').text('');
                var contactType = $('.course_contact_Active.active').attr('data-val');
                
                if(contactType=='individual')
                    var $form = $('#single_attendence_contacts');
                else
                    var $form = $('#multiple_attendence_contacts');
                
                $form.find('.is-invalid').removeClass('is-invalid');
                $form.find('.error').text('');

                $.ajax({
                    url: '{{url("save-attendence")}}', //url
                    type: 'post', //request method
                    data: $form.serialize(),
                    dataType : 'json',
                    beforeSend:function(){
                        startLoader('.modal-content');
                    },
                    complete:function(){
                        stopLoader('.modal-content');
                    },
                    headers: {'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')},
                    success: function(data) {
                        if(data.status)
                        {
                            closeAllModals();
                            var course_contact =[];
                            if(localStorage.getItem("course-contact")==undefined){
                                course_contact = [];
                            }else{
                                course_contact = $.parseJSON(localStorage.getItem("course-contact"));
                            }
                            course_contact.push($('#course_imp_id').val());
             
                            localStorage.setItem("course-contact", JSON.stringify(course_contact));

                            if(buyCartClick=='buy'){
                                AddToCart("{{url('/checkout')}}");
                            }else{
                                AddToCart("{{url('/cart')}}");
                            }
                        }
                        else
                        {
                           Swal.fire({
                                title: 'Error!',
                                text: data.message,
                                icon: 'error',
                                confirmButtonText: 'Ok'
                            });
                        }
                    },
                    error:function(data){
                        stopLoader('.modal-content');
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
                            $.each(err_response.errors, function(key, value){
                                if(contactType=='individual'){
                                    $form.find('input[name="'+key+'"]').next('span').text(value);
                                    $form.find('input[name="'+key+'"]').addClass('is-invalid');
                                    $form.find('select[name="'+key+'"]').next('span').text(value);
                                    $form.find('select[name="'+key+'"]').addClass('is-invalid');
                                    $form.find('textarea[name="'+key+'"]').next('span').text(value);
                                    $form.find('textarea[name="'+key+'"]').addClass('is-invalid');
                                }else{
                                    if(key.indexOf('.') != -1) {
                                        let keys = key.split('.');                                
                                        $form.find('input[name="'+keys[0]+'[]"]').eq(keys[1]).addClass('is-invalid').next('span').text(value).show();                         
                                    }
                                    else {
                                        $form.find('input[name="'+key+'[]"]').eq(0).addClass('is-invalid').next('span').text(value).show();
                                    }
                                }
                            });
                        }
                    }
                });
            }
        }

        const saveContactCoursesHelp = function(e){
            $(document).find('.error').text('');
            var contactType = $('.course_contact_Active.active').attr('data-val');
            
            if(contactType=='individual')
                var $form = $('#single_attendence_contacts');
            else
                var $form = $('#multiple_attendence_contacts');
            
            $form.find('.is-invalid').removeClass('is-invalid');
            $form.find('.error').text('');

            $.ajax({
                url: '{{url("save-attendence")}}', //url
                type: 'post', //request method
                data: $form.serialize(),
                dataType : 'json',
                beforeSend:function(){
                    startLoader('.modal-content');
                },
                complete:function(){
                    stopLoader('.modal-content');
                },
                headers: {'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')},
                success: function(data) {
                    if(data.status)
                    {
                        // closeAllModals();
                        var course_ttt_id= $form.find('input[name=course_contact_id]').val();
                        AddToCartShortCut(course_ttt_id, "{{url('/cart')}}");
                    }
                    else
                    {
                       Swal.fire({
                            title: 'Error!',
                            text: data.message,
                            icon: 'error',
                            confirmButtonText: 'Ok'
                        });
                    }
                },
                error:function(data){
                    stopLoader('.modal-content');
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
                        $.each(err_response.errors, function(key, value){
                            if(contactType=='individual'){
                                $form.find('input[name="'+key+'"]').next('span').text(value);
                                $form.find('input[name="'+key+'"]').addClass('is-invalid');
                                $form.find('select[name="'+key+'"]').next('span').text(value);
                                $form.find('select[name="'+key+'"]').addClass('is-invalid');
                                $form.find('textarea[name="'+key+'"]').next('span').text(value);
                                $form.find('textarea[name="'+key+'"]').addClass('is-invalid');
                            }else{
                                if(key.indexOf('.') != -1) {
                                    let keys = key.split('.');                                
                                    $form.find('input[name="'+keys[0]+'[]"]').eq(keys[1]).addClass('is-invalid').next('span').text(value).show();                         
                                }
                                else {
                                    $form.find('input[name="'+key+'[]"]').eq(0).addClass('is-invalid').next('span').text(value).show();
                                }
                            }
                        });
                    }
                }
            });
        }

        const AddToCartShortCut = function(course_ttt_id, returnUrl){
            $(document).find('.error').text('');
            var course = course_ttt_id;
            $('span.course_error').text('').hide();
        
            if(!course){
                Swal.fire({
                    title: 'Error!',
                    text: 'Something went wrong, Please try again.',
                    icon: 'error',
                    confirmButtonText: 'Ok'
                });
                return false;
            }               

            $.ajax({
                url: '{{url("addToCartMultiple")}}', //url
                type: 'post', //request method
                data:{
                    'course':course,
                    'course_timing_id':course_timing_ids,
                    'seat':$('#course_seat').val()
                },
                dataType : 'json',
                beforeSend:function(){
                    startLoader('.main_section');
                },
                complete:function(){
                    stopLoader('.main_section');
                },
                headers: {'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')},
                success: function(data) {
                    if(data.status){
                        Swal.fire({
                            title: 'Success!',
                            text: data.message,
                            icon: 'success',
                            confirmButtonText: 'Ok'
                        }).then((result) => {
                            $('.modal').modal('hide');
                            window.location = returnUrl;
                        });
                    }
                    else
                    {
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
                    }
                }
            });
        }
        const showVideoPlayer = function(url){
            $('#video').modal('show');
            $('#course_video_player').attr('src', url);
            $('.modal-backdrop').remove();
        }

        // add to cart method
		const addToCartMultiple = function(course_ttt_id){
		    $(document).find('.error').text('');
		    $('span.course_error').text('').hide();

		    if(!course_ttt_id){
		        Swal.fire({
		            title: 'Error!',
		            text: 'Something went wrong, Please try again.',
		            icon: 'error',
		            confirmButtonText: 'Ok'
		        });
		        return false;
		    }

		    $.ajax({
		        url: WEBSITE_URL+'/addToCartMultiple', //url
		        type: 'post', //request method
		        data:{
		            'course':course_ttt_id,
		            'seat':$('#course_seat').val(),
		            'course_timing_id':course_timing_ids,
		        },
		        dataType : 'json',
		        beforeSend:function(){
		            startLoader('body');
		        },
		        complete:function(){
		            stopLoader('body');
		        },
		        headers: {'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')},
		        success: function(data) {
		            if(data.status){
		            	Swal.fire({
		                    title: 'Success!',
		                    text: data.message,
		                    icon: 'success',
		                    cancelButtonText: 'Continue Shopping',
		                    confirmButtonText: 'Go to Cart',
		                    showCancelButton: true,
		                }).then((result) => {
		                    $('.cart_count').text(data.count);
		                    $('.modal').modal('hide');
		                    if (result.value) {
		                        window.location.href=WEBSITE_URL+'/cart'
		                    }else{
		                        window.location.href=WEBSITE_URL+'/products'
		                    }
		                });
		            }
		            else
		            {
		               show_FlashMessage(data.message,'error');
		               return false;
		            }
		        },
		        error:function(data){
		            stopLoader('body');
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
		            }
		        }
		    });
		}
        
    </script>
@endsection