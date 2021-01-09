@extends('frontend.layouts.app')
@section('title', 'Cart')

@section('content')

    @include('frontend.layouts.header')

    <div class="main_section">
        <div class="top-request-quet">
            <div class="container">
                <div class="row">
                    <div class="col col-md-12">
                        <!-- <div class="qoute_btn-box">
                            <span><i class="fa fa-info-circle" aria-hidden="true" style="color: #e64747;font-size: 30px;
                                    padding-right: 7px;
                                    padding-top: 7px;"></i>
                            Still if you need help with course information or want to request a quote?</span>
                            <button type="button" class="btn btn-large qoute_now" onclick="showCartQuoteModal();">Request a Quote Now</button>
                            
                        </div> -->
                    </div>
                </div>
            </div>
        </div>
        <div class="together_coures">
            <div class="container">
                <div class="row">
                    @php
                        $timelineExpired = false;
                    @endphp
                    @if(count($cart) >0)
                        <div class="col col-md-8">
                            <div class="together_section-course">
                                <div class="row">
                                    <div class="col-md-6">
                                        <h2>Shopping Cart</h2>
                                        
                                    </div>
                                    <div class="col-md-6">
                                        
                                        <h2 class="text-right">{{count($cart)}} Courses in Cart</h2>
                                    </div>
                                </div>
                                <hr>
                                
                                @include('frontend.cart.items')

                                <div class="more_coursess">
                                    <a href="{{url('products')}}">
                                        <button class="btn btn-large plus-more-btn"> + Add More Courses </button>
                                    </a>
                                </div>
                            </div>
                            
                            <!-- include related courses -->
                           
                        </div>
                        <div class="col col-md-4">
                            <div class="togerther-2 cart-shoping">
                                <div class="right-side-course">
                                    <h3>Order details</h3>
                                    
                                    @include('frontend.cart.total')

                                    <div class="form-part-full ">
                                        <div class="form_section full-width button-addto">
                                            <a href="javascript:;" class="gotoCheckout">
                                                <button type="button" class="add-cart btn btn-large">Checkout</button>
                                            </a>

                                            <button type="button" class="form_section btn btn-large qoute_now m-0 full-width cartQuoteShow" >Request a Quote Now</button>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            

                            <!-- <div class="right-side-course need-course mb-4">
                                <p>Need More information of this course or Want to talk to the experts?</p>
                                <hr>
                                <p class="contact-us-course stleClassColor" style="cursor: pointer;" onclick="showContactUsModal();">Contact Us</p>
                            </div> -->
                        </div>
                    @else
                        <div class="col col-md-12">
                            <div class="together_section-course">
                                <div class="noitems">
                                    <p class="p-0 m-0">Your Cart Is Empty</p>
                                    <p class="p-0 m-0">
                                        <a href="{{url('products')}}" class="stleClassColor">Click Here</a> to browse more courses.
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endif
                    
                </div>
            </div>
        </div>
    </div>
    @include('frontend.layouts.footer',['homeFooter'=>0])
    @include('frontend.includes.contact-us')
    @include('frontend.includes.cart-quote-request')
@endsection
    
@section('scripts')
    <script type="text/javascript">
        var timelineExpired = "{{$timelineExpired}}";

        const changeCourseSeatsCount = function(val, course_timing_id, course){
            var url ="{{url('update-course-seats')}}";
            $.ajax({
                url: url, //url
                type: 'post', //request method
                data: {
                    'course_timing_id':course_timing_id,
                    'course':course,
                    'val':val
                },
                headers: {
                    'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                },
                beforeSend:function(){
                   startLoader('body');
                },
                complete:function(){
                    stopLoader('body');
                },
                success: function(data) {
                    if(data.status){
                        $('.total_span').text(data.total);
                        Swal.fire({
                            title: 'Success!',
                            text: data.message,
                            icon: 'success',
                            confirmButtonText: 'Ok'
                        }).then((result) => {
                            // window.location.reload();
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
                    stopLoader('body');
                    if(data.responseJSON){
                        var err_response = data.responseJSON;
                        if(err_response.message) {
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
        $(document).ready(function(){

            $('.seat_minus').click(function () {
                var $input = $(this).parent().find('input');
                 if(parseInt($input.val()) == 1)
                {
                    return false;
                }
                var count = parseInt($input.val()) - 1;
                count = count < 1 ? 1 : count;
                $input.val(count);
                $input.change();
                var course_timing_id = $input.data('id');
                var course = $input.data('course');
                $(this).parent().find('.seat_count').html(count+' Seats');
                if(count > 0)
                {
                    changeCourseSeatsCount(count,course_timing_id, course);
                }
            });
            $('.seat_plus').click(function () {
                var $input = $(this).parent().find('input');
                $input.val(parseInt($input.val()) + 1);
                $input.change();
                var course_timing_id = $input.data('id');
                var course = $input.data('course');
                $(this).parent().find('.seat_count').html($input.val()+' Seats');
                changeCourseSeatsCount($input.val(),course_timing_id, course);
            });

            // cart page css
            $(document).on('click','.cart_change_seat', function(){
                $(this).hide();
                $(this).next('select').show();
            });
            $(document).on('click','.gotoCheckout', function(){
            	if(customerLoggedIn!=1){
		            showLoginModal();
		            return false;
		        }

                if($('.expiredNote').length>0){
                    Swal.fire("Please remove timeline expired courses from cart.");
                    return false;
                }
                var currentvalue = $("#countNotAvailable").val();
                if(currentvalue == 0 || currentvalue=="0")
                {
                    window.location.href = "{{url('/checkout')}}";
                }
                else
                {
                    Swal.fire("Please remove courses from cart which is not available now.");
                    return false;
                }
            });

            $(document).on('click','.cartQuoteShow', function(){
                if(customerLoggedIn!=1){
                    showLoginModal();
                    return false;
                }
                if($('.expiredNote').length>0){
                    Swal.fire("Please remove timeline expired courses from cart.");
                    return false;
                }
                showCartQuoteModal();
            });
    
            $(document).on('click','.removeCourse', function(e){
                e.preventDefault();
                var course = $(this).data('course');
                var id = $(this).data('id');
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You want to remove this course from cart!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.value) {
                        $.ajax({
                            url: '{{url("removeCartCourse")}}', //url
                            type: 'post', //request method
                            data:{
                                'course':course,
                                'id':id,
                            },
                            headers: {'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')},
                            
                            beforeSend:function(){
                                startLoader('.main_section');
                            },
                            complete:function(){
                                stopLoader('.main_section');
                            },
                            
                            success: function(data) {
                                if(data.status){
                                    if(localStorage.getItem("course-contact")!=undefined){
                                        course_contact = $.parseJSON(localStorage.getItem("course-contact"));
                                        
                                        course_contact = jQuery.grep(course_contact, function(value) {
                                                            return value != val;
                                                        });
                                        localStorage.setItem("course-contact", JSON.stringify(course_contact));
                                    }

                                    Swal.fire({
                                        title: 'Success!',
                                        text: data.message,
                                        icon: 'success',
                                        confirmButtonText: 'Ok'
                                    }).then((result) => {
                                        window.location.reload();
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
                });
            });
        });
    </script>
@endsection