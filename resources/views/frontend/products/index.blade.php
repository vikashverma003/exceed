@extends('frontend.layouts.app')
@section('title', 'Courses Listing')

@section('css')
<link rel="stylesheet" href="{{asset('css/datepicker.css')}}">
@endsection
@section('content')

    @include('frontend.layouts.header')

    <div class="main_section productListingSection">
        <div class="bk_image1 product-section">
            <div class="search_sections">
                <div class="container">
                    <div class="row">
                        <div class="search_part product_page-part">
                            
                            <form method="get" action="{{url('/products')}}" style="padding-right: 10px;margin-right: 10px;">
                                <img src="{{asset('img/ic_search.svg')}}">
                                <input type="search" class="search product_page_simple_search" placeholder="Search Course Name… " name="course_name" value="" autofocus="autofocus">
                            </form>
                        </div>
                        <p onclick="$('#demo').toggle();" class="advance_serch">&nbsp; Advanced Search</p>

                        @include('frontend.products.advance-filter')
                    </div>
                </div>
            </div>
            <div class="traning_section-full">
                <div class="container pl-0">
                    <div class="row">
                        <div class="col col-md-3 pr-0">
                            <div class="left_sidebar LeftSideBarFilter">
                                @include('frontend.products.left-filter')
                            </div>
                        </div>
                        <div class="col col-md-9">
                            <div class="result_found">
                                <div class="hide-banner">
                                 @if($category_count_banner==1)
                                    <div class="common_banner">
                                        <div class="banner-details position-relative">    
                                            <img  src="{{asset('uploads/categories/'.$category_banner_image->banner)}}">
                                            <div class="banner_title position-absolute d-flex align-items-end justify-content-between">
                                                <h3 class="text-uppercase m-0">{{$category_banner_image->name}}</h3>
                                                <span>Total Courses :  {{$count_Course}}</span>
                                            </div>
                                        </div>
                                        <div class="baner-description p-3">
                                            <p>{{strip_tags($category_banner_image->desc)}}</p>
                                        </div>
                                    </div>
                                     <div class="list-items-box px-3">
                                    @foreach($show_Course as $show_Courses)
                                   
                                        <a href="{{url('/products-filter-course')}}/{{$show_Courses->category_id}}/{{$show_Courses->name}}"><span>{{$show_Courses->name}}</span></a>
                                    
                                    @endforeach
                                    </div>
                                    @if(count($count_Course_product)>5)
                                    <div id="tableview1" class="list-items-box px-3"><a class="passingID" style="float:right;" data-id="{{$category_banner_image['id']}}" href="#">Show more</a></div> 
                                    @endif
                                 @else
                                 @endif
                                </div>      
                                <div class="replace-banner" style="display:none">.</div>
                               <div class="search_res"> @if(count($products_data) || count($manufacturer_data) || count($location_data) || count($category_data)) 
                                   @if(count($category_data)>1)
                                   <strong class="text-h2">Search Result :</strong>
                                   @endif
                                @endif </div>
                                 <div class="sort_by-txt category-list-menu">
                                   @foreach(@$category_data as $crow)
                                    @if(count($category_data)>1)
                                        <span class="product-notify-span type4" title="Category Name">{{strtoupper($crow)}}</span>
                                    @endif
                                    @endforeach
                                </div>
                                 <div class="sort_by-txt manufacturer-list-menu">
                                   @foreach(@$manufacturer_data as $manurow)
                                        <span class="product-notify-span type2" title="Manufacturer Name">{{strtoupper($manurow)}}</span>
                                    @endforeach
                                </div>
                                <div class="sort_by-txt sub-category-list-menu selectedProducts">
                                    @if(count(@$products_data)>1)
                                    <!--<strong class="text-h2">Search Results For Courses:</strong>-->

                                   @foreach(@$products_data as $catrow)
                                        <span class="product-notify-span type1" title="Product Name">   {{strtoupper($catrow['name'])}}
                                            <!--<span class="RemoveProduct" data-name="{{str_slug($catrow['slug'])}}"> -->
                                        </span>
                                    @endforeach
                                      @endif
                                </div>
                                <!--<div class="sort_by-txt sub-category-list-menu selectedProductsss" style="display:none">
                                </div>-->

                                <div class="sort_by-txt location-list-menu">
                                   @foreach(@$location_data as $locrow)
                                        <span class="product-notify-span type3" title="Location Name">{{strtoupper($locrow)}}</span>
                                    @endforeach
                                </div>

                                <div class="sort_by-txt" style="display:none">
                                    <div class="row d-flex align-items-center mb-2">
                                        <div class="col-md-6">
                                            <h2 style="font-size: 13px;">
                                                 <span class="products_count">
                                                    @if(isset($data['start_date']) || isset($data['end_date']))
                                                    @if($data->count() > 0)
                                                        Showing {{$data->count()}} results out of {{$dataTotal}} Courses.
                                                    @else
                                                        There is no schedule found.
                                                    @endif
                                                    @endif
                                                </span>
                                            </h2>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="text-right">
                                                @if($data->count() > 0)
                                                <select class="b-select slect_boxss products_course_filter sortByFilter" name="course_filter_by" style="float: none;width: 35%">
                                                    <option value="new">Latest</option>
                                                    
                                                    <option value="priceasc">Price Low to High</option>
                                                    
                                                    <option value="pricedesc">Price High to Low</option>
                                                </select>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    @if((isset($_GET['start_date']) && $_GET['start_date']!='') || isset($_GET['end_date']) && $_GET['end_date']!='')
                                    <div class="row filterDates">
                                        <div class="d-flex align-items-center mb-2">
                                            <div class="col-md-12">
                                                <h2 style="font-size: 13px;">
                                                    @if(isset($_GET['start_date']) && $_GET['start_date']!='')
                                                    <span>
                                                        <strong>From Date: </strong> <span class="date_from_span">{{$_GET['start_date'] ?? ''}}</span>
                                                    </span>
                                                    @endif
                                                    @if(isset($_GET['end_date']) && $_GET['end_date']!='')
                                                    <span>
                                                         <strong>To Date:</strong> <span class="date_to_span">{{$_GET['end_date'] ?? ''}}</span> 
                                                    </span>
                                                    @endif
                                                </h2>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="row advanceFilterHint" style="display: @if((url()->current() != url()->full()) && $totalCount==0) show @else none @endif">
                                    
                                        <div class="d-flex align-items-center mb-2">
                                            <div class="col-md-12">
                                                <h2 style="font-size: 13px;">
                                                     <span>
                                                        <strong>Hint:</strong> Try modifying your search criteria using <span onclick="scrollAdvance();" style="cursor: pointer;color: orange">Advance Search</span>.
                                                    </span>
                                                </h2>
                                            </div>
                                        </div>
                                    </div>
                                    @endif


                                </div>
                                <div class="filter_course_div">
                                    @include('frontend.products.courses')
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
    @include('frontend.products.modal.quote-request')
    @include('frontend.courseDetails.modals.addCart')

@endsection
    
@section('scripts')

    <script type="text/javascript">
        startLoader('.main_section');
        $("form[name='advance_search_form']").find("input[name='start_date']").val('{{$from_date??''}}');
        $("form[name='advance_search_form']").find("input[name='end_date']").val('{{$to_date??''}}');
        var course_timing_ids = [];
        var k=[];

        $(document).ready(function(){
            
            window.addEventListener( "pageshow", function ( event ) {
              var historyTraversal = event.persisted || 
                                     ( typeof window.performance != "undefined" && 
                                          window.performance.navigation.type === 2 );
              if ( historyTraversal ) {
                // Handle page restore.
                window.location.reload(true);
              }
            });

            setTimeout(function(){ stopLoader('.main_section'); }, 1000);
            
            $(document).on("click", ".pagination li a", function (e){
                e.preventDefault();
                startLoader('.page-content');
                var url = $(this).attr('href');
                var page = url.split('page=')[1];
                
                if($('.LeftSideBarFilter input:checked').length==0)
                {
                    val = ($('.sortByFilter').val()!=undefined) ? $('.sortByFilter').val(): '';
                    loadListingsExtra(page, val);
                }else{
                    loadListings(page);
                }
            });

            $(document).on('click','#quote-query-form-btn', function(e){
                
                var $form = $('#quote-query-form');
                
                e.preventDefault();
                $form.find('.is-invalid').removeClass('is-invalid');
                $form.find('.error').text('');
                alert(2342);
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

            $(document).on('click','.advance_filter_submit', function(e){

                e.preventDefault();
                $('#demo').toggle();
                var $form = $("form[name='advance_search_form']");
                var url = $form.attr('action');
                var course_name = $form.find('input[name="course_name"]').val();
                var fromDate = $startDate.val();
                var toDate = $endDate.val();
                var manufacturers =[];
                var categories =[];
                var locations =[];
                var courses =[];

                url+='?course_name='+course_name+'&start_date='+fromDate+'&end_date='+toDate;
                $('.advance_filter_manufacturers ul>li').each(function(i){
                    if($(this).is('.active'))
                    {
                        manufacturers.push($(this).data('name'));
                    }
                });
                $('.advance_filter_categories ul>li').each(function(i){
                    if($(this).is('.active')){
                        categories.push($(this).data('name'));
                    }
                });
                $('.advance_filter_locations ul>li').each(function(i){
                    if($(this).is('.active')){
                        locations.push($(this).data('name'));
                    }
                });
                $('.advance_filter_courses ul>li').each(function(i){
                    if($(this).is('.active')){
                        courses.push($(this).data('name'));
                    }
                });

                if($('.productListingSection').is(":visible")){
                    var val = $(this).val();
                    $.ajax({
                        url: "{{url('/courseListingAjax')}}", //url
                        type: 'get', //request method
                        data:{
                            'courses':courses,
                            'locations':locations,
                            'manufacturers':manufacturers,
                            'categories':categories,
                            'start_date':fromDate,
                            'end_date':toDate,
                            'course_name':course_name,

                        },
                        headers: {'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')},
                        beforeSend:function(){
                            startLoader('.main_section');
                        },
                        complete:function(){
                            stopLoader('.main_section');
                        },
                        success: function(data) {
                            showPaginationCount(data);
                            $(".filter_course_div").html(data.html);
                        },
                        error:function(data){
                            stopLoader('.main_section');
                        }
                    });
                }
            });

            // course name search filter
            $(document).on('keyup','.product_page_simple_search', function(e){
                var val = $(this).val();
                $.ajax({
                    url: "{{url('/products-filter')}}", //url
                    type: 'post', //request method
                    data:{
                        'course_name':val,
                        'search_flag':'q',
                    },
                    headers: {'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')},
                    beforeSend:function(){
                        startLoader('.main_section');
                    },
                    complete:function(){
                        stopLoader('.main_section');
                    },
                    success: function(data) {
                        showPaginationCount(data);
                        $(".filter_course_div").html(data.html);
                    },
                    error:function(data){
                        stopLoader('.main_section');
                    }
                });
            });

            // sort by filter
            $(document).on('change','.sortByFilter', function(){
                var val = $(this).val();
                
                var courses =[];
                var pcategories =[];
                $('.LeftSideBarFilter input:checked').each(function() {
                    courses.push($(this).data('name'));
                    pcategories.push($(this).data('categoryid'));
                });
                var start_date = "{{$from_date??''}}";
                var end_date = "{{$to_date??''}}";

                $.ajax({
                    url: "{{url('/products-filter')}}", //url
                    type: 'post', //request method
                    data:{
                        'val':val,
                        'courses':courses,
                        'Pcategories':pcategories,
                        'start_date':start_date,
                        'end_date':end_date,
                        'search_flag':'q',
                    },
                    headers: {'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')},
                    beforeSend:function(){
                        startLoader('.main_section');
                    },
                    complete:function(){
                        stopLoader('.main_section');
                    },
                    success: function(data) {
                        showPaginationCount(data);
                        $(".filter_course_div").html(data.html);
                        // $(".manufacturers_products_section").html(data.product_html);
                    },
                    error:function(data){
                        stopLoader('.main_section');
                    }
                });
            });

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

            // product based selection filter
            $(document).on('click','.productLeftFilter', function(e){

                console.log("plf");
                val = ($('.sortByFilter').val()!=undefined) ? $('.sortByFilter').val(): '';
                var courses =[];
                var pcategories =[];
                $('.LeftSideBarFilter input:checked').each(function() {
                    courses.push($(this).data('name'));
                    pcategories.push($(this).data('categoryid'));
                });

                if(courses.length==0){
                    $(".hide-banner").css("display", "block");
                    $(".replace-banner").css("display", "none");

                    $.ajax({
                        url: WEBSITE_URL+'/courseListingAjax'+window.location.search, //url
                        type: 'get', //request method
                        beforeSend:function(){
                            startLoader('.main_section');
                        },
                        complete:function(){
                            stopLoader('.main_section');
                        },
                        success: function(data) {
                            showPaginationCount(data);
                            $('.selectedProducts').html('');
                            $(".filter_course_div").html(data.html);
                        },
                        error:function(data){
                            stopLoader('.main_section');
                        }
                    });
                }else{
                    console.log("plf11");
                    var start_date = "{{$from_date??''}}";
                    console.log("startdata"+start_date);
                    var end_date = "{{$to_date??''}}";
                    //console.log("enddata"+end_date);
                    //console.log("courses"+courses);
                    //console.log("categories"+pcategories);
                    console.log("val"+val);

                   $.ajax({
                        url: "{{url('/products-filter')}}", //url
                        type: 'post', //request method
                        data:{
                            'val':val,
                            'courses':courses,
                            'Pcategories':pcategories,
                            'start_date':start_date,
                            'end_date':end_date,
                            'search_flag':'q'
                        },
                        headers: {'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')},
                        beforeSend:function(){
                            startLoader('.main_section');
                        },
                        complete:function(){
                            stopLoader('.main_section');
                        },
                        success: function(data) {
                            console.log("data1");
                            console.log(data);
                            showPaginationCount(data);
                            showSelectedProducts(data);
                            $(".filter_course_div").html(data.html);
                        },
                        error:function(data){
                            stopLoader('.main_section');
                        }
                    }); 
                }
            });

            $('#demo').on('shown', function (e) {
                $('html, body').animate({
                   scrollTop: $("#demo").offset().top
                }, 1000);
            });

            //var count_unchecked_item=[];
            $(document).on('click','.RemoveProduct', function(e){ 
                var name = $(this).data('name');
                if(name){
                    $('.LeftSideBarFilter').find('input[name="courses[]"][value='+name+']').trigger('click');
                }
                var trimString=name.replace("-", " ");
                //console.log("trimString"+trimString.toLocaleUpperCase());
                var remove_name=trimString.toLocaleUpperCase();
                var filtered = k.filter(function(value, index, arr){ return value !=remove_name;});
               //var filtered=k.push(trimString.toLocaleUpperCase());
               k=filtered;
               //console.log(filtered);  // work on filtered arr.
                var checkedArrayLength=k.length;
                if(checkedArrayLength<1)
                {
                 $(".hide-banner").show();
                 $(".replace-banner").hide();
                }
                else if(checkedArrayLength==1){
                     $(".hide-banner").hide();
                     $(".replace-banner").show();
                }
                else if(checkedArrayLength>1){
                      $(".hide-banner").hide();
                      $(".replace-banner").hide();
                }
                
            });

        });

        const showPaginationCount = function(data){
            $('.filterDates').hide();

            if(data.from_date!='' || data.to_date!=''){
                $('.filterDates').show();
                $('.date_from_span').html(data.from_date);
                $('.date_to_span').html(data.to_date);
            }

            $('.advanceFilterHint').hide();
            if(data.totalCount==0){
                $('.advanceFilterHint').show();
            }else{
                $('.advanceFilterHint').hide();
            }
            if(data.totalCount > 0)
            {
                // $('.products_count').html('Showing '+data.totalCount+' results out of '+data.dataTotal+' Courses.').show();
            }else{
                // $('.products_count').html('There is no schedule found.').show();
            }
        }

        const showSelectedProducts = function(data){
           // var search_fll="{{$search_flag}}";
            //alert(search_fll);
            console.log(data);
            var html='';
            var banner_image='';
            $.each(data.products_data, function(key, val){
                if(k.indexOf(val.name) === -1) {
                    k.push(val.name);
                }
                var cat_id=val.category_id; 
                console.log("cat_id"+cat_id);
                var course_name=val.slug;
                console.log("course_name"+course_name);
                if(data.products_data.length==1){ 
                    $(".hide-banner").hide();
                    $(".replace-banner").css("display", "block");
                  // banner_image='<img style="width:800px; height:200px;" src="'+val.product_banner+'">';
                banner_image='<div class="common_banner">'+'<div class="banner-details position-relative">'+'<img src="'+val.product_banner+'">'+
                             '<div class="banner_title position-absolute d-flex align-items-end justify-content-between">'+'<h3 class="text-uppercase m-0">'+val.name+'</h3>'+
                             '<span>Total Courses : '+val.count_Course+'</span>'+'</div>'+'</div>'+'<div class="baner-description p-3">'+'<p>'+val.desc+'</p>'+'</div>'+'</div>';
                $(".replace-banner").html(banner_image);
                }
                html+='<a style="padding:4px; margin:0px;" href="{{url('/products-filter-course')}}/'+cat_id+'/'+course_name+'"><span class="product-notify-span type1">'+val.name+'<span class="" data-name="'+val.slug+'"></span></span></a>';
            })
            //$('.selectedProducts').html(html);
             /*if($(".search_res").is(":visible")){
                $('.selectedProducts').html(html);

            } else{
            $('.selectedProducts').html("<strong class="+'text-h2'+">Search Results For Courses:</strong>"+html);
            }*/
            if($('.type4').text().length > 0) {  // Checking the text inside a div
                $('.selectedProducts').html(html);
            }
            else{
            $('.selectedProducts').html("<strong class="+'text-h2'+">Search Results For Courses:</strong>"+html);

            }

            //$('.selectedProducts').html("<strong class="+'text-h2'+">Search Results For Courses:</strong>"+html);
            if(data.products_data.length==1){ 
                $(".hide-banner").hide();
                $(".replace-banner").show();
                $(".selectedProducts").css("display", "none");
               // $(".selectedProducts").css("display", "block");
                // $.each(data.products_data, function(key, val){
                //     banner_image='<img style="width:800px; height:200px;" src="'+val.product_banner+'">';
                //     $(".replace-banner").html(banner_image);
                // });
            }
            else if(data.products_data.length<1)
            {
            $(".hide-banner").show();
            $(".replace-banner").hide();
           $(".selectedProducts").css("display", "none");
            }
            else if(data.products_data.length>1){
                 $(".hide-banner").hide();
                 $(".replace-banner").hide();  

                $(".selectedProducts").css("display", "block");
            }
            
        }

        // save course attendees
        const saveContactCourses = function(e){
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
                            AddToCart(course_ttt_id, "{{url('/cart')}}");
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

        const scrollAdvance = function(){
            $('#demo').toggle();
            $('html, body').animate({
               scrollTop: $("#demo").offset().top
            }, 1000);
        }
        // add to cart method
        const AddToCart = function(course_ttt_id, returnUrl){
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

        // pagination load courses
        const loadListings = function(page){
            
            val = ($('.sortByFilter').val()!=undefined) ? $('.sortByFilter').val(): '';
            var courses =[];
            var pcategories =[];
            $('.LeftSideBarFilter input:checked').each(function() {
                courses.push($(this).data('name'));
                pcategories.push($(this).data('categoryid'));
            });
            var start_date = "{{$from_date??''}}";
            var end_date = "{{$to_date??''}}";

            $.ajax({
                url: "{{url('/products-filter')}}"+'?page='+page,
                type: 'post', //request method
                data:{
                    'val':val,
                    'courses':courses,
                    'Pcategories':pcategories,
                    'start_date':start_date,
                    'end_date':end_date,
                    'search_flag':'q',

                },
                headers: {'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')},
                
                beforeSend:function(){
                    startLoader('.main_section');
                },
                complete:function(){
                    stopLoader('.main_section');
                },
                success: function(data) {
                    showPaginationCount(data);
                    $(".filter_course_div").html(data.html);
                },
                error:function(data){
                    stopLoader('.main_section');
                }
            });
        }

        const loadListingsExtra = function(page, filterVal){
            var manufacturers =[];
            var categories =[];
            var locations =[];
            var courses =[];
            var AdvancedFilterSelected = false;
            $('.advance_filter_manufacturers ul>li').each(function(i){
                if($(this).is('.active')){
                    manufacturers.push($(this).data('name'));
                    AdvancedFilterSelected = true;
                }
            });
            $('.advance_filter_categories ul>li').each(function(i){
                if($(this).is('.active')){
                    categories.push($(this).data('name'));
                    AdvancedFilterSelected = true;
                }
            });
            $('.advance_filter_locations ul>li').each(function(i){
                if($(this).is('.active')){
                    locations.push($(this).data('name'));
                    AdvancedFilterSelected = true;
                }
            });
            $('.advance_filter_courses ul>li').each(function(i){
                if($(this).is('.active')){
                    courses.push($(this).data('name'));
                    AdvancedFilterSelected = true;
                }
            });


            var formdatas ={};
            formdatas.val = filterVal;
            formdatas.page = page;

            var $form = $("form[name='advance_search_form']");
            var course_name = $form.find('input[name="course_name"]').val();
            var fromDate = $startDate.val();
            var toDate = $endDate.val();

            if(course_name || fromDate || toDate){
                AdvancedFilterSelected = true;
            }
            
            if(AdvancedFilterSelected){
                formdatas.courses = courses;
                formdatas.locations = locations;
                formdatas.manufacturers = manufacturers;
                formdatas.categories = categories;
                formdatas.start_date = fromDate;
                formdatas.end_date = toDate;
                formdatas.course_name = course_name;
            }else{
                formdatas.family = $form.find('input[name="family"]').val();
            }
            $.ajax({
                url: "{{url('/courseListingAjax')}}", //url
                type: 'get', //request method
                data : formdatas,
                headers: {'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')},
                beforeSend:function(){
                    startLoader('.main_section');
                },
                complete:function(){
                    stopLoader('.main_section');
                },
                success: function(data) {
                    console.log("CLA");
                    showPaginationCount(data);
                    $(".filter_course_div").html(data.html);
                },
                error:function(data){
                    stopLoader('.main_section');
                }
            });
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
     <script>
    $(document).on("click", ".passingID", function () {
          var cat_id= $(this).attr('data-id');
          var op ="";
          $.ajax({
    type : 'POST',
    url : '{{route("products-append-course")}}',
    beforeSend:function(){
                    startLoader('.main_section');
                },
                complete:function(){
                    stopLoader('.main_section');
                },
    data:{"_token": "{{ csrf_token() }}",'cat_id':cat_id},
    success:function(data2){
      //console.log(data2);
      var d=data2.data;
      console.log(d);
      console.log(data2.data.length);
      for(var i=0;i<d.length;i++){
      op+='<a href="{{url('/products-filter-course')}}/'+d[i].category_id+'/'+d[i].name+'">'+d[i].name+'</a>';
      }
        $('#tableview1').html(op);     
    }
    });       
    });
  </script>
@endsection