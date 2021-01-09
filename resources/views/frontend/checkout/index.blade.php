@extends('frontend.layouts.app')
@section('title', 'Cart')
@section('content')
@include('frontend.layouts.header')
<div class="main_section checkout-page">
    <div class="together_coures">
        <div class="container">
            <div class="row">
                <div class="col col-md-8">
                    <div class="togerther-2 cart-shoping checkout_left-part">
                        <div class="txt-checkout">
                            <h3>Checkout</h3>
                        </div>
                        <div id="accordion">
                            <div class="card">
                                <div class="card-header" id="headingOne">
                                    <h5 class="mb-0">
                                        <button type="button" class="btn btn-link">
                                            Card
                                            <div class="img-cards-sec">
                                                <img src="{{asset('images/cardicon/mastercard.png')}}">
                                                <img src="{{asset('images/cardicon/credit-card.png')}}">
                                                <img src="{{asset('images/cardicon/visa.png')}}">
                                            </div>
                                            <p>Safe money transfer using your bank card. Visa, Maestro, Discover, American Express etc.</p>
                                        </button>
                                    </h5>
                                </div>
                                <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
                                    <div class="card-body">
                                        <div class="card-body">
                                            <div class="form-card card-number">
                                                <label>
                                                    Card Number
                                                    <input type="text" placeholder="0000 0000 000 0000">
                                                    <img src="{{asset('img/ic_policy_accept_check.svg')}}">
                                                </label>
                                            </div>
                                            <div class="form-card">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <label>
                                                        NAME ON CARD
                                                        <input type="text" name="name_on_card" placeholder="">
                                                        </label>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <label>
                                                        EXPIRE MONTH
                                                        <input type="text" placeholder="MM" maxlength="2">
                                                        </label>
                                                    </div>
                                                     <div class="col-md-3">
                                                        <label>
                                                        EXPIRE YEAR
                                                        <input type="text" placeholder="YY" maxlength="2">
                                                        </label>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <label>
                                                        CVV CODE
                                                        <input type="text" placeholder="" maxlength="4">
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- <div class="form-card checkbox-card">
                                                <label>
                                                <input type="checkbox" name="checkbox">
                                                Save this card for future transation
                                                </label>
                                            </div> -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                </div>
                <div class="col col-md-4">
                    <div class="togerther-2 cart-shoping">
                        <div class="right-side-course">
                            <h3>Order details</h3>
                            <ul>

                                <li class="green"><strong>Total Amount</strong></li>
                                <li>AED {{$total ?? 0}}</li>
                                <li class="green">Coupon Discount</li>
                                <li>{{$discount ?? 0}} %</li>
                                <li class="total"><strong>Grand Total</strong></li>
                                <li class="total"><strong>AED {{$grandTotal ?? 0}} </strong></li>


                            </ul>
                            <div class="form-part-full">
                                <div class="form_section full-width button-addto">
                                    <button type="button" class="add-cart btn btn-large proceedPaymentBtn">Pay</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if($coupon_applied==1)
                        @php
                            $coupon_success = 'block';
                            $coupon_input = 'none';
                        @endphp
                    @else
                        @php
                            $coupon_success = 'none';
                            $coupon_input = 'block';
                        @endphp
                    @endif
                    <div class="discount_copun">
                        <h3>Discount Coupon</h3>
                        <div class="coupon_success" style="display: {{$coupon_success}};">
                            <p>
                                <span class="coupon_success_code">{{$coupon_applied_code}}</span> 
                                is applied
                            </p>
                            <span style="float: right; margin-top: 4px;cursor: pointer;" onclick="removeCoupon()">Remove X</span>
                        </div>
                        <div class="coupon_input" style="display: {{$coupon_input}}">
                            <label>
                                <input type="text" placeholder="Enter Coupon Code" name="coupon_code">
                                <h4 class="apply-btn" onclick="applyCoupon();" style="cursor: pointer;">Apply</h4>
                            </label>
                            <span class="coupon_error"></span>
                        </div>
                    </div>
                    <div class="right-side-course need-course mb-3">
                        <p>Need More information of this course or Want to talk to the experts?</p>
                        <hr>
                        <p class="contact-us-course stleClassColor" style="cursor: pointer;" onclick="showContactUsModal();">Contact Us</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@include('frontend.layouts.footer',['homeFooter'=>0])
@include('frontend.includes.contact-us')
@include('frontend.includes.quote-request')
@endsection
@section('scripts')
<script type="text/javascript">

    const removeCoupon = function(){
        $('.coupon_error').html('');
        $.ajax({
            url: '{{url("remove-coupon")}}', //url
            type: 'post', //request method
            headers: {'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')},
            dataType : 'json',
            beforeSend:function(){
                startLoader('.main_section');
            },
            complete:function(){
                stopLoader('.main_section');
            },
            success: function(data) {
                if(data.status){
                    $('.coupon_success').hide();
                    $('.coupon_input').show();
                    $('input[name="coupon_code"]').val('');
                    $('.coupon_error').html('');
                    Swal.fire({
                        title: 'Success!',
                        text: data.message,
                        icon: 'success',
                        confirmButtonText: 'Ok'
                    }).then((result) => {
                      window.location.reload();
                    });
                }else{
                    $('.coupon_error').html(data.message);
                }
                $('.filter_course_div').html(data);
            },
            error:function(data){
                stopLoader('.main_section');
            }
        });
    }

    const applyCoupon = function(){
        $('.coupon_error').html('');
        $.ajax({
            url: '{{url("apply-coupon")}}', //url
            type: 'post', //request method
            
            data : {
                'coupon':$('input[name="coupon_code"]').val()
            },
            headers: {'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')},
            dataType : 'json',
            beforeSend:function(){
                startLoader('.main_section');
            },
            complete:function(){
                stopLoader('.main_section');
            },
            success: function(data) {
                if(data.status){
                    $('.coupon_success').show();
                    $('.coupon_input').hide();
                    $('.coupon_success_code').html($('input[name="coupon_code"]').val());
                    Swal.fire({
                        title: 'Success!',
                        text: data.message,
                        icon: 'success',
                        confirmButtonText: 'Ok'
                    }).then((result) => {
                      window.location.reload();
                    });
                }else{
                    $('.coupon_error').html(data.message);
                }
                $('.filter_course_div').html(data);
            },
            error:function(data){
                stopLoader('.main_section');
            }
        });
    }

    $(document).ready(function(){
        // buy now click
        $(document).on('click','.proceedPaymentBtn', function(e){
            e.preventDefault();

            $.ajax({
                url: '{{url("payment")}}', //url
                type: 'post', //request method
                data:{
                    'amount':'12',
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
                            localStorage.removeItem("course-contact");
                            window.location = data.url
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
        });
    });
</script>
@endsection