@extends('frontend.layouts.app')
@section('title', 'Manufacturer\'s Courses')

@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.2/assets/owl.theme.default.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.1.3/assets/owl.carousel.min.css" />
@endsection
@section('content')

    @include('frontend.layouts.header')

    <div class="main_section">
        @php
            $banner = $manufacturerdata->banner;
            if($banner)
                $banner = asset('uploads/manufacturers/'.$banner);
            else
                $banner = asset('/img/testimonial_bg.png');
        @endphp

        <div class="press-rlaes-page manufacturers_page" 
            style="
                background-image: url('{{$banner}}');
                background-position: center;
                background-repeat: no-repeat;
                background-size: cover;
                padding: 60px 0 50px;
                background-attachment: fixed;">
            <div class="container">
                <div class="row">
                    <div class="col col-md-12">
                        <!-- <img src="{{asset('uploads/manufacturers/'.$manufacturerdata->logo)}}" class="img.manufac-img manufac-img"> -->
                        <h2>{{ucfirst($manufacturerdata->name)}}</h2>
                        <p><img src="{{asset('img/ic_my_courses.svg')}}"><span>{{$courses->total()}} Courses in total</span></p>
                        <!-- <p><span>&nbsp;</span></p> -->
                    </div>
                </div>
            </div>
        </div>
        
        <div class="manufactures-main-section">
            <div class="container">
                <div class="row">
                    <div class="col col-md-6 mb-2">
                        <div class="manuf-left-txt">
                            <h2>{{ucwords($manufacturerdata->name)}} Courses</h2>
                        </div>
                    </div>
                    
                   	<div class="col-md-12">
                        <div class="container">
                            <div class="row">
                                <div class="col col-md-3 pl-0 pr-0">
                                    <div class="left_sidebar LeftSideBarFilter">
                                        @include('frontend.manufacturers.left-filter')
                                    </div>
                                </div>
                                <div class="col col-md-9 mb-4">
                                	
                                    <div class="result_found">
                                    	<div class="sort_by-txt">
		                                	<div class="row d-flex align-items-center mb-2">
		                                		<div class="col-md-6">
		                                			<h2 style="font-size: 13px;">
					                                     <span class="result_count">
                                                         @if($courses->count()>0)
		                                                    Showing {{$courses->count()}} results out of {{$courses->total()}} Courses.
                                                        @else
                                                         Their is no schedule found
                                                        @endif
		                                                </span>
					                                </h2>
		                                		</div>
		                                		<div class="col-md-6">
		                                			<div class="text-right">
				                                        <select class="b-select slect_boxss manufacturer_course_filter sortByFilter" name="filter_by" style="float: none;width: 35%">
				                                            <option value="new">Latest</option>
				                                            
				                                            <option value="asc">Price Low to High</option>
		                                                    
				                                            <option value="desc">Price High to Low</option>
				                                        </select>
				                                    </div>
		                                		</div>
		                                	</div>
		                                </div>

                                        <div class="manufacturer_course_div">
                                            @include('frontend.manufacturers.list')
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                   </div>

                    <div class="col-md-12">
                    	<div class="service_sction">
						    <div class="container">
						        <div class="row">
						            <div class="col-md-12 mb-3 pl-0" >
						                <div class="service_txt">
						                    <h2>Courses by Manufacturers</h2>
						                </div>
						            </div>
						            <!-- scrolling-box -->
						            <div class="scrolling-box">
						                <div class="row">
						                    <div class="carousel-wrap">
						                        <div class="owl-carousel">
						                            @foreach($manufacturers as $row)
						                                <div class="item">
						                                    <div class="cbox text-center">
						                                        <div class="orange_box no_color-manufa">
						                                           <img src="{{asset('uploads/manufacturers/'.$row->logo)}}" style="max-width: 100%;max-height: 100px;height: 100px;" class="img-circle">
						                                            <!-- <p>{{ucfirst($row->name)}}</p> -->
						                                            
						                                            <div class="img_manu-txt">
						                                                <h2><img src="{{asset('img/ic_courses_note.svg')}}"><span>{{$row->courses_count}} Courses in total</span></h2>
						                                            </div>

						                                            <div class="view_coures_btn manufacturerCourseBtn">
						                                                <a href="{{url('manufacturers/'.str_slug($row->name))}}" class=" btn btn_large btn-fill view-btn">View Courses</a>
						                                            </div>
						                                        </div>
						                                    </div>
						                                </div>
						                            @endforeach
						                        </div>
						                    </div>
						                </div>
						            </div>
						        </div>
						    </div>
						</div>
					</div>
                </div>
            </div>
        </div>
    </div>
   @include('frontend.layouts.footer',['homeFooter'=>0])
   @include('frontend.includes.contact-us')
   @include('frontend.products.modal.locations')
   @include('frontend.courseDetails.modals.addCart')

   @include('frontend.products.modal.quote-request')
@endsection
    
@section('scripts')
    <script type="text/javascript">        

        $(document).ready(function(){

            $(document).on('click','.showCourseListingQuoteModal', function(){
                if(!customerLoggedIn ){
                    showLoginModal();
                    return false;
                }
                
                $('.courseListingQuote').find('input[name="course_page_course_id"]').val($(this).attr('data-id'));
                $('.courseListingQuote').find('input[name="course"]').val($(this).attr('data-name'));
                closeAllModals();
                $('.courseListingQuote').modal('show');
            });

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
                            $('.courseListingQuote').modal('hide');
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



        	$(document).on("click", ".pagination li a", function (e){
                e.preventDefault();
                startLoader('.page-content');
                var url = $(this).attr('href');
                var page = url.split('page=')[1];      
                loadListings(page);
            });

        	$(document).on('click','.productLeftFilter', function(e){
                val = ($('.sortByFilter').val()!=undefined) ? $('.sortByFilter').val(): '';
                var products =[];
                $('.LeftSideBarFilter input:checked').each(function() {
                    products.push($(this).val());
                });

                $.ajax({
                    url: "{{url('/manufacturers/'.$title)}}", //url
                    type: 'get', //request method
                    data:{
                        'products':products,
                        'val':val,
                    },
                    beforeSend:function(){
                        startLoader('.main_section');
                    },
                    complete:function(){
                        stopLoader('.main_section');
                    },
                    success: function(data) {
                        $(".manufacturer_course_div").html(data.html);
                        showTotalCount(data);
                    },
                    error:function(data){
                        stopLoader('.main_section');
                    }
                });
            });

            $(document).on('change','.manufacturer_course_filter', function(){
                var val = $(this).val();
                var products =[];
	            $('.LeftSideBarFilter input:checked').each(function() {
	                products.push($(this).val());
	            });
                $.ajax({
                    url: "{{url('/manufacturers/'.$title)}}", //url
                    type: 'get', //request method
                    data:{
                        'val':val,
                        'products':products
                    },
                    beforeSend:function(){
                        startLoader('.main_section');
                    },
                    complete:function(){
                        stopLoader('.main_section');
                    },
                    success: function(data) {
                        $(".manufacturer_course_div").html(data.html);
                        showTotalCount(data);
                    },
                    error:function(data){
                        stopLoader('.main_section');
                    }
                });
            });

        });

        // pagination load courses
        const loadListings = function(page){
            val = ($('.sortByFilter').val()!=undefined) ? $('.sortByFilter').val(): '';
            var products =[];
            $('.LeftSideBarFilter input:checked').each(function() {
                products.push($(this).val());
            });

            $.ajax({
                url: "{{url('/manufacturers/'.$title)}}"+'?page='+page,
                type: 'get', //request method
                data:{
                    'val':val,
                    'products':products,
                },
                               
                beforeSend:function(){
                    startLoader('.main_section');
                },
                complete:function(){
                    stopLoader('.main_section');
                },
                success: function(data) {
                    $(".manufacturer_course_div").html(data.html);
                    showTotalCount(data);
                },
                error:function(data){
                    stopLoader('.main_section');
                }
            });
        }

        const showTotalCount = function(data){
            if(data.totalCount > 0)
        	{
                // $('.result_count').html('Showing '+data.totalCount+' results out of '+data.dataTotal+' Courses.');
            }else{
                // $('.result_count').html('There is no schedule found.');
            }
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