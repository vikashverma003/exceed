let customerTempSelected = 'individual';
let help_clicked = false;
var manufacturer_screen_course_id = '';
var course_timing_ids = [];
var $startDate = $('.start-date');
var $endDate = $('.end-date');

$(document).ready(function () {
    if(customerLoggedIn==1 && customerSelected==0){
        showCustomerSelectModal();
    }
    // save customer type

    $('select.chosen-select').chosen();
    $('.chosen-select-deselect').chosen({ allow_single_deselect: true,'width':'100%'});


    $startDate.datepicker({
        autoHide: true,
        format: "dd/mm/yyyy",
        startDate : new Date()
    });
    $endDate.datepicker({
        autoHide: true,
        format: "dd/mm/yyyy",
        startDate: $startDate.datepicker('getDate'),
    });

    $startDate.on('change', function () {
        $endDate.datepicker('setStartDate', $startDate.datepicker('getDate'));
    });

    $(document).on('click','.advanceFilterLi', function(){
    	$(this).toggleClass('active');
    });

    $('#demo1').on('shown.bs.collapse', function () {
	    $('html, body').animate({
	       scrollTop: $("#demo1").offset().top
	    }, 1000);
	});

    

    $(document).on('click', '.customRequestCheck .dropdown-menu', function (e) {
      e.stopPropagation();
    });

    // on change on advance search manufacturer.
    $(document).on('click','.advance_filter_manufacturers_li', function(e){
        var id = [];
        $('.advance_filter_manufacturers ul>li').each(function(i){
            if($(this).is('.active')){
                id.push($(this).data('id'));
            }
        });

    	e.preventDefault();
        getManufacturersForAdvanceFilter(id);
    });
    
    function getManufacturersForAdvanceFilter(id){
        $.ajax({
            url: '/advance-filter-manufactuer-data', //url
            type: 'get', //request method
            data: {
                'manufacturer':id ? id : [],
            },
            beforeSend:function(){
                startLoader('.main_section');
            },
            complete:function(){
                stopLoader('.main_section');
            },
            success: function(data) {
                if(data.status){
                    var cat_html = '';
                    $.each(data.categories, function(key, val){
                        cat_html+='<li data-id="'+val.id+'" data-name="'+val.slug_name+'" class="customhoverclass advanceFilterLi advance_filter_categories_li" style="cursor: pointer;">'+val.name+'</li>';
                    });
                    $('.advance_filter_categories_ul').html(cat_html);

                    var cour_html = '';
                    $.each(data.courses, function(key, val){
                        cour_html+='<li data-id="'+val.id+'" data-name="'+val.slug_name+'" class="customhoverclass advanceFilterLi advance_filter_courses_li" style="cursor: pointer;">'+val.name+'</li>';
                    });
                    $('.advance_filter_courses_ul').html(cour_html);
                }
            },
            error:function(data){
                stopLoader('.main_section');
            }
        });
    }

     $(document).on('click','.product_already_added', function(){
        if($(this).prop("checked") == true){
            $(".addCartShortCutBtn").val(1);
            // Swal.fire({
            //     title: 'Error!',
            //     text: 'Already added into the cart, do you want to add one more?',
            //     icon: 'warning',
            //     showCancelButton: true,
            //     confirmButtonText: 'Yes, add it!',
            //     cancelButtonText: 'No, cancel!',
            //     reverseButtons: true
            // }).then((result) => {
            //     if (result.value) {
            //         $(this).prop( "checked", true );
            //     }
            //     else
            //     {
            //         $(this).prop( "checked", false );
            //     }
            // })
        }
        else{
            $(".addCartShortCutBtn").val(0);
        }
    });

    $(document).on('click','.removeMultipleattendance', function(){
        $(document).find('.error').text('');
        $(this).parent().remove();
    });

    // show particular course location and timings.
    $(document).on('click','.productBuyNow', function(e){
    	manufacturer_screen_course_id = $(this).data('term');
        var val = $(this).data('id');
       
        
        var term = $(this).data('term');
        var name = $(this).data('name');
        $('#location_modal_term').val(term);
        $('#location_modal_name').val(name);

        $('.showCourseListingQuoteModal').attr('data-id', val);
        $('.showCourseListingQuoteModal').attr('data-name', name);

        $.ajax({
            url: "/course-locations", //url
            type: 'get', //request method
            data:{
                'id':val
            },
            beforeSend:function(){
                startLoader('.main_section');
            },
            complete:function(){
                stopLoader('.main_section');
            },
            success: function(data) {
                var html='';
                if(data.course.offer_price == null)
                {

                    $('.addCartShortCutBtn').attr('disabled', true);
                    $('.addCartShortCutBtn').parent().css('display', 'none');
                    $('.courseLocationQuoteNow').parent().removeClass(['col-md-6','text-left']).addClass(['col-md-12','text-center']);
                }
                if(data.data.length>0)
                {
                    $.each(data.data, function(key, value){
                        html+='<tr>\
                        <td>'+value.country+'</td>\
                        <td>'+value.city+'</td>\
                        <td class="checkSiteUrl" data-name="'+value.location+'" style="cursor:pointer;color:blue">'+value.location+'</td>\
                        <td>'+value.timezone+'</td>\
                        <td>'+value.training_type+'</td>\
                        <td>'+value.start_date+'</td>\
                        <td>'+value.date+'</td>\
                        <td>'+value.start_time+' - '+value.end_time+'</td>';
                        if(value.already_added==true)
                        {
                            html+='<td><input type="checkbox" class="product_already_added" name="course_time_table_selection" value="'+value.id+'"></td>';
                        }
                        else
                        {
                            html+='<td><input type="checkbox" name="course_time_table_selection" value="'+value.id+'"></td>';
                        }
                        html+='</tr>';
                    });
                    $('.yes_location').show();
                    $('.no_location').hide();
                    $('.addCartShortCutBtn').attr('disabled', false);
                    $('.no_location_price').hide();


                }else{
                    html='<tr>\
                        <td>N/A</td>\
                        <td>N/A</td>\
                        <td>N/A</td>\
                        <td>N/A</td>\
                        <td>N/A</td>\
                        <td>N/A</td>\
                        <td>N/A</td>\
                    </tr>';
                    $('.addCartShortCutBtn').attr('disabled', true);
                    if(data.course.offer_price == null){ 
                         $('.no_location_price').show();
                         $('.yes_location').hide();
                        $('.no_location').hide();

                    }
                    else{
                        $('.no_location_price').hide();
                         $('.no_location').show();
                         $('.yes_location').hide();
                    }
                }
                $('.course_location_body').html(html);
                $('#courseLocationModal').modal('show');
            },
            error:function(data){
                stopLoader('.main_section');
            }
        });
    });
    
    // for no price
     $(document).on('click','.courseLocationBtn', function(e){
        manufacturer_screen_course_id = $(this).data('term');
        var val = $(this).data('id');
       
        
        var term = $(this).data('term');
        var name = $(this).data('name');
        $('#location_modal_term').val(term);
        $('#location_modal_name').val(name);

        $('.showCourseListingQuoteModal').attr('data-id', val);
        $('.showCourseListingQuoteModal').attr('data-name', name);

        $.ajax({
            url: "/course-locations", //url
            type: 'get', //request method
            data:{
                'id':val
            },
            beforeSend:function(){
                startLoader('.main_section');
            },
            complete:function(){
                stopLoader('.main_section');
            },
            success: function(data) {
                var html='';
                if(data.course.offer_price == null)
                {

                    $('.addCartShortCutBtn').attr('disabled', true);
                    $('.addCartShortCutBtn').parent().css('display', 'none');
                    $('.courseLocationQuoteNow').parent().removeClass(['col-md-6','text-left']).addClass(['col-md-12','text-center']);
                }
                if(data.data.length>0)
                {
                    $.each(data.data, function(key, value){
                        html+='<tr>\
                        <td>'+value.country+'</td>\
                        <td>'+value.city+'</td>\
                        <td class="checkSiteUrl" data-name="'+value.location+'" style="cursor:pointer;color:blue">'+value.location+'</td>\
                        <td>'+value.timezone+'</td>\
                        <td>'+value.training_type+'</td>\
                        <td>'+value.start_date+'</td>\
                        <td>'+value.date+'</td>\
                        <td>'+value.start_time+' - '+value.end_time+'</td>';
                        if(value.already_added==true)
                        {
                            html+='<td><input type="checkbox" class="product_already_added" name="course_time_table_selection" value="'+value.id+'"></td>';
                        }
                        else
                        {
                            html+='<td><input type="checkbox" name="course_time_table_selection" value="'+value.id+'"></td>';
                        }
                        html+='</tr>';
                    });
                    $('.yes_location').show();
                    $('.no_location').hide();
                    $('.addCartShortCutBtn').attr('disabled', false);
                    $('.no_location_price').hide();


                }else{
                    html='<tr>\
                        <td>N/A</td>\
                        <td>N/A</td>\
                        <td>N/A</td>\
                        <td>N/A</td>\
                        <td>N/A</td>\
                        <td>N/A</td>\
                        <td>N/A</td>\
                    </tr>';
                    $('.addCartShortCutBtn').attr('disabled', true);
                        $('.no_location_price').hide();
                         $('.no_location').show();
                         $('.yes_location').hide();
                    
                }
                $('.course_location_body').html(html);
                $('#courseLocationModal').modal('show');
            },
            error:function(data){
                stopLoader('.main_section');
            }
        });
    });

    // add to cart from course location and timing modal.
    $(document).on('click','.addCartShortCutBtn', function(e){
        help_clicked = true;
        if($(this).val() == 1 || $(this).val() == "1")
        {
            Swal.fire({
                title: 'Error!',
                text: 'Already added into the cart, do you want to add one more?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, add it!',
                cancelButtonText: 'No, cancel!',
                reverseButtons: true
            }).then((result) => {
                if (result.value) {
                    var term = $('#location_modal_term').val();
                    var name = $('#location_modal_name').val();
                    course_timing_ids =[];
        
                    $("input:checkbox[name=course_time_table_selection]:checked").each(function () {
                        course_timing_ids.push($(this).val());
                    });
                    addToCartMultiple(manufacturer_screen_course_id);
                }
                else
                {
                    return false;
                }
            })
        }
        else{
            if($('input[name="course_time_table_selection"]').length==0){
                Swal.fire({
                    title: 'Info!',
                    text: 'Please select some locations if available.',
                    icon: 'info',
                    confirmButtonText: 'Ok'
                });
                return false;
            }
            if($('input[name="course_time_table_selection"]:checked').length==0){
                Swal.fire({
                    title: 'Error!',
                    text: 'Please select some course.',
                    icon: 'error',
                    confirmButtonText: 'Ok'
                });
                return false;
            }else{
                
                var term = $('#location_modal_term').val();
                var name = $('#location_modal_name').val();
                course_timing_ids =[];
    
                $("input:checkbox[name=course_time_table_selection]:checked").each(function () {
                    course_timing_ids.push($(this).val());
                });
                addToCartMultiple(manufacturer_screen_course_id);
            }
        }
    });

    // request a quote from course location modal
    $(document).on('click','.courseLocationQuoteNow', function(e){
        help_clicked = true;
        if($('input[name="course_time_table_selection"]').length==0){
            Swal.fire({
                title: 'Info!',
                text: 'Please select some locations if available.',
                icon: 'info',
                confirmButtonText: 'Ok'
            });
            return false;
        }
        if($('input[name="course_time_table_selection"]:checked').length==0){
            Swal.fire({
                title: 'Error!',
                text: 'Please select some course.',
                icon: 'error',
                confirmButtonText: 'Ok'
            });
            return false;
        }else{
            var term = $('#location_modal_term').val();
            var name = $('#location_modal_name').val();
            course_timing_ids =[];

            $("input:checkbox[name=course_time_table_selection]:checked").each(function () {
                course_timing_ids.push($(this).val());
            });
            if(!customerLoggedIn ){
                showLoginModal();
                return false;
            }
            showLocationsQuoteModal(manufacturer_screen_course_id);
        }
    });

    // quote request from locations modal
    $(document).on('click','#locations-quote-query-form-btn', function(e){
        var $form = $('#locations-quote-query-form');
        e.preventDefault();
        $form.find('.is-invalid').removeClass('is-invalid');
        $form.find('.error').text('');

        $.ajax({
            url: '/locations-quote-query', //url
            type: 'POST', //request method
            data: {
                "course":$form.find('input[name="locations_course_id"]').val(),
                "message":$form.find('textarea[name="message"]').val(),
                'course_timing_id':course_timing_ids,
            },
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
                    $('.locationsQuoteQueryModal').modal('hide');
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
                    if(err_response.errors==undefined && err_response.message) {
                        Swal.fire({
                            title: 'Error!',
                            text: err_response.message,
                            icon: 'error',
                            confirmButtonText: 'Ok'
                        });
                    }
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
    
    $(document).on('click','.advance_filter_categories_li', function(e){
        var id = [];
        $('.advance_filter_manufacturers ul>li').each(function(i){
            if($(this).is('.active')){
                id.push($(this).data('id'));
            }
        });
        var category_id = [];
        $('.advance_filter_categories ul>li').each(function(i){
            if($(this).is('.active')){
                category_id.push($(this).data('id'));
            }
        });

        e.preventDefault();
        $.ajax({
            url: '/advance-filter-catgory-data', //url
            type: 'get', //request method
            data: {
                'manufacturer':id ? id: [],
                'category':category_id ? category_id : []
            },
            beforeSend:function(){
                startLoader('.main_section');
            },
            complete:function(){
                stopLoader('.main_section');
            },
            success: function(data) {
                if(data.status){

                    var cour_html = '';
                    $.each(data.courses, function(key, val){
                        cour_html+='<li data-id="'+val.id+'" data-name="'+val.slug_name+'" class="customhoverclass advanceFilterLi advance_filter_courses_li" style="cursor: pointer;">'+val.name+'</li>';
                    });
                    $('.advance_filter_courses_ul').html(cour_html);
                }
            },
            error:function(data){
                stopLoader('.main_section');
            }
        });
    });

    // course detail page related courses
    $('.related_courses .owl-carousel').owlCarousel({
        loop:false,
        margin:25,
        nav:true,
        responsive: {
            0: {
                items: 1
            },
            600: {
                items: 2
            },
            1000: {
                items: 3
            }
        }
    });

    $('.scrolling-box .owl-carousel').owlCarousel({
       loop: true,
       margin: 20,
       nav: true,
       rtl:false,
       autoplay: false,
       responsive: {
           0: {
               items: 1
           },
           600: {
               items: 2
           },
           1000: {
               items: 3
           }
       }
    });
    // testimonials
    $('.testimonial_section .owl-carousel').owlCarousel({
        loop: true,
        margin: 25,
        nav: true,
       
        rtl:false,
        
        responsive: {
            0: {
                items: 1
            },
            600: {
                items: 2
            },
            1000: {
                items: 3
            }
        }
    });

    // list all available company
    $('.companys_name .owl-carousel').owlCarousel({
        loop: true,
        margin: 35,
        nav: false,
        // navText: [
        //   "<i class='fa fa-caret-left'></i>",
        //   "<i class='fa fa-caret-right'></i>"
        // ],
        rtl:false,
        autoplay: true,
        autoplayTimeout:1000,
        autoplayHoverPause: true,
        responsive: {
            0: {
                items: 2
            },
            600: {
                items: 4
            },
            1000: {
                items: 6
            }
        }
    });
    
    // clear advance serch form
    $(document).on('click','.clear_advance_filter', function(){

        // $(".serch_filtss").find("input[name='start_date']").val('');
        // $("form[name='advance_search_form']").find("input[name='start_date']").val('');
        // $("form[name='advance_search_form']").find("input[name='end_date']").val('');

        $("form[name='advance_search_form'] input[name='start_date']").val('');
        $("form[name='advance_search_form'] input[name='end_date']").val('');
        $("form[name='advance_search_form']")[0].reset();
        $("form[name='advance_search_form']").find('.advanceFilterLi').removeClass('active');
        getManufacturersForAdvanceFilter([]);
    });

    // submit advance search form
    $(document).on('click','.home_advance_filter_submit', function(e){
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
        window.location = url;
    });

    // submit advance search form
    $(document).on('click','.course_name_only_search', function(e){
        e.preventDefault();
        var val = $('#simple_course_name').val().trim();
        if(val==''){
            return false;
        }
        $('form[name="simple_course_name_form"]').submit();
    });


    $('ul.nav li.dropdown').hover(function () {
    	$("#dropdownMenu1").dropdown('hide');
        $(this).find('.dropdown-menu').stop(true, true).delay(200).fadeIn(500);
    }, function () {
        $(this).find('.dropdown-menu').stop(true, true).delay(200).fadeOut(500);
    });

    // $('.browseCourseMenu').hover(function () {
    // 	$(this).find('.main_heading_menu_section').fadeIn(500);
    // 	$(this).find('.browseCourseUL').fadeIn(500);
    // }, function () {
    //     $(this).find('.main_heading_menu_section').delay(200).fadeOut(500);
    //     $(this).find('.browseCourseUL').delay(200).fadeOut(500);
    // });

    $('.main_heading_menu_section').hover(function () {
        $(this).removeClass('active');
        $('.main_heading_submenu_section').scrollTop(0,0);
    });

    $('.main_heading_submenu_section').hover(function () {
        $('.main_heading_menu_section').removeClass('active');
        $(this).parent().addClass('active');
    });
    
    // contact us form submit event
    $(document).on('click','#contact-us-form-btn', function(e){
        var $form = $('#contact-us-form');
        e.preventDefault();
        
        $form.find('.is-invalid').removeClass('is-invalid');
        $form.find('.error').text('');

        $.ajax({
            url: '/contact-us', //url
            type: 'POST', //request method
            data: $form.serialize(),
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
                    $('.homePageContactUsModal').modal('hide');
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
                    if(err_response.errors==undefined && err_response.message) {
                        Swal.fire({
                            title: 'Error!',
                            text: err_response.message,
                            icon: 'error',
                            confirmButtonText: 'Ok'
                        });
                    } 
                    $.each(err_response.errors, function(i, obj){
                        $form.find('input[name="'+i+'"]').next('span').text(obj);
                        $form.find('input[name="'+i+'"]').addClass('is-invalid');
                        
                        $form.find('select[name="'+i+'"]').next('span').text(obj);
                        $form.find('select[name="'+i+'"]').addClass('is-invalid');

                        $form.find('textarea[name="'+i+'"]').next('span').text(obj);
                        $form.find('textarea[name="'+i+'"]').addClass('is-invalid');
                    });
                }
            }
        });
    });
    
    $('input[type=radio][name=customer-select-radio]').change(function() {
        $('.select-customer-modal').find('.continuess').addClass('stleClassBgColor');
    });

    // save temp customer selected value
    $(document).on('click','#customer-select-continue', function(e){
        e.preventDefault();
        if($('.select-customer-modal input[type="radio"]:checked').attr('value')=='individual'){
            customerTempSelected = 'individual';
            showSignupModal();
        }
        else if($('.select-customer-modal input[type="radio"]:checked').attr('value')=='corporate'){
            customerTempSelected ='corporate';
            showSignupModal();
        }else{
            Swal.fire({
                title: 'Error!',
                text: 'Please select customer type',
                icon: 'error',
                confirmButtonText: 'Ok'
            });
            return false;
        }
    });

    // save customer selected value
    $(document).on('click','#customer-select-save', function(e){
        e.preventDefault();
        var selectedVal = $('.select-customer-modal input[type="radio"]:checked').attr('value');
        if(selectedVal=='individual'){
            saveCustomerType(selectedVal);
        }
        else if(selectedVal=='corporate'){
            saveCustomerType(selectedVal);
        }else{
            Swal.fire({
                title: 'Error!',
                text: 'Please select customer type',
                icon: 'error',
                confirmButtonText: 'Ok'
            });
            return false;
        }
    });

    // quote query form submit event
    $(document).on('click','#footer-quote-query-form-btn', function(e){
        var $form = $('#footer-quote-query-form');
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
                    $('.quoteQueryModal').modal('hide');
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
                    if(err_response.errors==undefined && err_response.message) {
                        Swal.fire({
                            title: 'Error!',
                            text: err_response.message,
                            icon: 'error',
                            confirmButtonText: 'Ok'
                        });
                    }
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



    $(document).on('click','#cart-quote-query-form-btn', function(e){
        var $form = $('#cart-quote-query-form');
        e.preventDefault();
        $form.find('.is-invalid').removeClass('is-invalid');
        $form.find('.error').text('');

        $.ajax({
            url: '/cart-quote-query', //url
            type: 'POST', //request method
            data: $form.serialize(),
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
                    $.each(err_response.errors, function(i, obj){
                        $form.find('input[name="'+i+'"]').next('span').text(obj);
                        $form.find('input[name="'+i+'"]').addClass('is-invalid');
                        
                        $form.find('select[name="'+i+'"]').next('span').text(obj);
                        $form.find('select[name="'+i+'"]').addClass('is-invalid');

                        $form.find('textarea[name="'+i+'"]').next('span').text(obj);
                        $form.find('textarea[name="'+i+'"]').addClass('is-invalid');
                    });
                }
            }
        });
    });


    // forgot password form submit event
    $(document).on('click','#forgot-password-btn', function(e){
        var $form = $('#forgot-password-form');

        e.preventDefault();
        $form.find('.is-invalid').removeClass('is-invalid');
        $form.find('.error').text('');

        $.ajax({
            url: '/forgot-password', //url
            type: 'POST', //request method
            data: $form.serialize(),
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
                    $('.forgotPasswordModal').modal('hide');
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
                    if(err_response.errors==undefined && err_response.message) {
                        Swal.fire({
                            title: 'Error!',
                            text: err_response.message,
                            icon: 'error',
                            confirmButtonText: 'Ok'
                        });
                    } 
                    $.each(err_response.errors, function(i, obj){
                        $form.find('input[name="'+i+'"]').next('span').text(obj);
                        $form.find('input[name="'+i+'"]').addClass('is-invalid');
                    });
                }
            }
        });
    });

    $(document).on('click','#resent-account-activation-btn', function(e){
        var $form = $('#account-activation-form');

        e.preventDefault();
        $form.find('.is-invalid').removeClass('is-invalid');
        $form.find('.error').text('');

        $.ajax({
            url: '/resend-account-activation', //url
            type: 'POST', //request method
            data: $form.serialize(),
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
                    $('.accountActivationModal').modal('hide');
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
                    if(err_response.errors==undefined && err_response.message) {
                        Swal.fire({
                            title: 'Error!',
                            text: err_response.message,
                            icon: 'error',
                            confirmButtonText: 'Ok'
                        });
                    } 
                    $.each(err_response.errors, function(i, obj){
                        $form.find('input[name="'+i+'"]').next('span').text(obj);
                        $form.find('input[name="'+i+'"]').addClass('is-invalid');
                    });
                }
            }
        });
    });

    // on submit of register form event
    $(document).on('click','.signup-modal-btn', function(e){
        e.preventDefault();
        // clear all errors
        $('#signup-modal-form').find('.is-invalid').removeClass('is-invalid');
        $('#signup-modal-form').find('span.error').text('');

        let formFields = new FormData($('#signup-modal-form')[0]);
        formFields.append("customer_type",customerTempSelected);

        let ajax_url = WEBSITE_URL+"/register";
        
        $.ajax({
            url : ajax_url,
            type:'post',
            data : formFields,
            dataType : 'json',
            processData: false,
            contentType: false,
            beforeSend:function(){
                startLoader('.modal-content');
            },
            complete:function(){
                stopLoader('.modal-content');
            },
            success : function(data){
                Swal.fire({
                    title: 'Success!',
                    text: data.message,
                    icon: 'success',
                    confirmButtonText: 'Ok'
                }).then((result) => {
                    $('.signupModal').modal('hide');
                    window.location.reload();
                });
            },
            error : function(data){
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
                                              
                    $.each(err_response.errors, function(i, obj){
                        $('#signup-modal-form').find('input[name="'+i+'"]').next().text(obj);
                        $('#signup-modal-form').find('input[name="'+i+'"]').addClass('is-invalid');

                        $('#signup-modal-form').find('select[name="'+i+'"]').next().text(obj);
                        $('#signup-modal-form').find('select[name="'+i+'"]').addClass('is-invalid');
                    });
                }
            }
        });
    });

    // login form submit event
    $(document).on('click','#login-form-btn', function(e){
        e.preventDefault();
        $('#login-form-modal').find('.is-invalid').removeClass('is-invalid');
        $('#login-form-modal').find('span.error').text('');

        let loginformFields = new FormData($('#login-form-modal')[0]);
        let loginAjaxUrl = WEBSITE_URL+"/login";
        
        $.ajax({
            url : loginAjaxUrl,
            type:'post',
            data : loginformFields,
            dataType : 'json',
            processData: false,
            contentType: false,
            beforeSend:function(){
                startLoader('.modal-content');
            },
            complete:function(){
                
            },
            success : function(data){
                if(data.status){
                    setTimeout(function(){ 
                        window.location = data.redirect_to; 
                    }, 1000);
                }else{
                    stopLoader('.modal-content');
                }
            },
            error : function(data){
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
                    $.each(err_response.errors, function(i, obj){
                        $('#login-form-modal').find('input[name="'+i+'"]').next().text(obj);
                        $('#login-form-modal').find('input[name="'+i+'"]').addClass('is-invalid');
                    });
                }
            }
        });
    });

    $('#shareCourseModal').on('hidden.bs.modal', function (e) {
        $(this).find("input[type='text']").val('').end();
        $(this).find("textarea[name='message']").val('').end();
        $(document).find('.error').text('');
    });

    $('.courseLocationModal').on('hidden.bs.modal', function (e) {
        $('.course_location_body').html('');
        $("form[name='course_location_form']")[0].reset();
    });

    $('#add-tocartpop').on('hidden.bs.modal', function (e) {
        $('.attendes_extra_div').remove()
        $("form[name='single_attendence_contacts']")[0].reset();
        $("form[name='multiple_attendence_contacts']")[0].reset();
    });

    // contact modal on hidden reset form data
    $('.homePageContactUsModal').on('hidden.bs.modal', function (e) {
        $('#contact-us-form').find('.is-invalid').removeClass('is-invalid');
        $('#contact-us-form').find('.error').text('');
        $("form[name='contact-us-form']")[0].reset();
    });

    // quote query modal on hidden reset form data
    $('.quoteQueryModal').on('hidden.bs.modal', function (e) {
        $('#footer-quote-query-form').find('.is-invalid').removeClass('is-invalid');
        $('#footer-quote-query-form').find('.error').text('');
        $("form[name='footer-quote-query-form']")[0].reset();
        $(".quote_category_checkbox").val('').trigger("chosen:updated");
        $('.quoteQueryModal').find('.quote_manufacturer_div,.quote_products_div,.quote_courses_div').hide();
    });

    $('.courseQueryModal').on('hidden.bs.modal', function (e) {
        $('#quote-query-form').find('.is-invalid').removeClass('is-invalid');
        $('#quote-query-form').find('.error').text('');
        $("form[name='quote-query-form']")[0].reset();
    });

    $('.cartQuoteQueryModal').on('hidden.bs.modal', function (e) {
        $('#cart-quote-query-form').find('.is-invalid').removeClass('is-invalid');
        $('#cart-quote-query-form').find('.error').text('');
        $("form[name='cart-quote-query-form']")[0].reset();
        $('#cart-quote-query-form').find('input[name="quote_selection"][value="cart"]').prop('checked', true);
        $('#cart-quote-query-form').find('.cartQuoteCourse').hide();
        $('#cart-quote-query-form').find('.quote_manufacturer_div,.quote_products_div,.quote_courses_div').hide();
    });

    // login modal on hidden reset form data
    $('.loginModal').on('hidden.bs.modal', function (e) {
        $('#login-form-modal').find('.is-invalid').removeClass('is-invalid');
        $('#login-form-modal').find('.error').text('');
        $("form[name='login-form-modal']")[0].reset();
    });

    // signup modal on hidden reset form data
    $('.signupModal').on('hidden.bs.modal', function (e) {
        $('#signup-modal-form').find('.is-invalid').removeClass('is-invalid');
        $('#signup-modal-form').find('.error').text('');
        $("form[name='signup-modal-form']")[0].reset();
    });

    // forgot password modal on hidden reset form data
    $('.forgotPasswordModal').on('hidden.bs.modal', function (e) {
        $('#forgot-password-form').find('.is-invalid').removeClass('is-invalid');
        $('#forgot-password-form').find('.error').text('');
        $("form[name='forgot-password-form']")[0].reset();
    });

    $('.select-customer-modal').on('hidden.bs.modal', function (e) {
    	$('.select-customer-modal').find('.continuess').removeClass('stleClassBgColor');
        $('.select-customer-modal')
            .find(':input')
            .prop('checked', false)
            .prop('selected', false);
    });
    

    // share course
    $(document).on('click','.share_course_btn', function(e){
        $(document).find('.error').text('');
        var email = $('#share_course_form').find('input[name="email"]').val();
        var share_course_id = $('#share_course_form').find('input[name="share_course_id"]').val();
        var message = $('#share_course_form').find('textarea[name="message"]').val();
        if(email==''){
            $('.share_email_error').html('The email is required.').show();
            return false;
        }
        if(message.length==0){
            $('.share_message_error').html('The message is required.').show();
            return false;
        }

        $.ajax({
            url: WEBSITE_URL+'/shareCourse', //url
            type: 'post', //request method
            data:{
                'email':email,
                'message':message,
                'id':share_course_id,
            },
            dataType : 'json',
            beforeSend:function(){
                startLoader('.modal-content');
            },
            complete:function(){
                stopLoader('.modal-content');
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
                        $('#shareCourseModal').modal('hide');
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
                        $('#share_course_form').find('input[name="'+key+'"]').next('span').text(value);
                        $('#share_course_form').find('textarea[name="'+key+'"]').next('span').text(value);
                    });
                }
            }
        });
    });

    $(document).on('change','.contact_country', function(){

        if(!$(this).val()){
            $('.contact_code').val('');
            return false;
        }
        $.ajax({
            url: '/country-code', //url
            type: 'get', //request method
            data: {
                'id':$(this).find(':selected').data('id')
            },
            headers: {'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')},
            beforeSend:function(){
               startLoader('body');
            },
            complete:function(){
                stopLoader('body');
            },
            success: function(data) {
                if(data.status){
                    $('.contact_code').val(data.data.phonecode);
                }else{
                    $('.contact_code').val('');
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
    });

    // multiple selection based
    $(document).on('change','.quote_category_checkbox', function(){
        var $form = $('.quote-query-form-home');
        $form.find('.is-invalid').removeClass('is-invalid');
        $form.find('.error').text('');

        $form.find('.quote_products_div').hide();
        $form.find('.quote_courses_div').hide();

        if(!$(this).val()){
            $form.find('.quote_manufacturer_checkbox').html('<option value="">Select</option>');
            $form.find('.quote_products_checkbox').html('<option value="">Select</option>');
            $form.find('.quote_courses_checkbox').html('<option value="">Select</option>');
            $form.find('.quote_manufacturer_div').hide();
            
            return false;
        }

        var category =[];
        category = $form.find('.quote_category_checkbox').val();

        $.ajax({
            url: '/quote-manufacturers', //url
            type: 'get', //request method
            data: {
                'category':category
            },
            headers: {'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')},
            beforeSend:function(){
               startLoader('.modal-footer');
            },
            complete:function(){
                stopLoader('.modal-footer');
            },
            success: function(data) {
                if(data.status){
                    var html='';
                    $.each(data.manufacturers, function(key, value){
                        html+='<option value="'+value.id+'">'+value.name+'</option>';
                    });
                    $form.find('.quote_manufacturer_checkbox').html(html);
                    $form.find('.quote_manufacturer_div').show();
                    $(".quote_manufacturer_checkbox").trigger("chosen:updated");

                }else{
                   Swal.fire({
                        title: 'Error!',
                        text: data.message,
                        icon: 'error',
                        confirmButtonText: 'Ok'
                    });
                   return false;
                }
            },
            error:function(data){
                stopLoader('.modal-footer');
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
    });
    $(document).on('change','.quote_manufacturer_checkbox', function(){
        var $form = $('.quote-query-form-home');
        $form.find('.is-invalid').removeClass('is-invalid');
        $form.find('.error').text('');
        $form.find('.quote_courses_div').hide();

        if(!$(this).val()){
            $form.find('.quote_products_checkbox').html('<option value="">Select</option>');
            $form.find('.quote_courses_checkbox').html('<option value="">Select</option>');
            $form.find('.quote_products_div').hide();
            
            return false;
        }

        var category =[];
        var manufacturer =[];
        category = $form.find('.quote_category_checkbox').val();
        manufacturer = $form.find('.quote_manufacturer_checkbox').val();

        $.ajax({
            url: '/quote-products', //url
            type: 'get', //request method
            data: {
                'category':category,
                'manufacturer':manufacturer,
            },
            headers: {'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')},
            beforeSend:function(){
               startLoader('.modal-footer');
            },
            complete:function(){
                stopLoader('.modal-footer');
            },
            success: function(data) {
                if(data.status){
                    var html='';
                    $.each(data.products, function(key, value){
                        html+='<option value="'+value.id+'">'+value.name+'</option>';
                    });
                    $form.find('.quote_products_checkbox').html(html);
                    $form.find('.quote_products_div').show();
                    $(".quote_products_checkbox").trigger("chosen:updated");
            
                }else{
                   Swal.fire({
                        title: 'Error!',
                        text: data.message,
                        icon: 'error',
                        confirmButtonText: 'Ok'
                    });
                   return false;
                }
            },
            error:function(data){
                stopLoader('.modal-footer');
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
    });
    $(document).on('change','.quote_products_checkbox', function(){
        var $form = $('.quote-query-form-home');
        $form.find('.is-invalid').removeClass('is-invalid');
        $form.find('.error').text('');

        if(!$(this).val()){
            $form.find('.quote_courses_checkbox').html('<option value="">Select</option>');
            $form.find('.quote_courses_div').hide();
            return false;
        }

        var category =[];
        var manufacturer =[];
        var product =[];
        category = $form.find('.quote_category_checkbox').val();
        manufacturer = $form.find('.quote_manufacturer_checkbox').val();
        product = $form.find('.quote_products_checkbox').val();
        
        $.ajax({
            url: '/quote-courses', //url
            type: 'get', //request method
            data: {
                'category':category,
                'manufacturer':manufacturer,
                'product':product,
            },
            headers: {'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')},
            beforeSend:function(){
               startLoader('.modal-footer');
            },
            complete:function(){
                stopLoader('.modal-footer');
            },
            success: function(data) {
                if(data.status){
                    var html='';
                    $.each(data.courses, function(key, value){
                        html+='<option value="'+value.name+'">'+value.name+'</option>';
                    });
                    $form.find('.quote_courses_checkbox').html(html);
                    $form.find('.quote_courses_div').show();
                    $(".quote_courses_checkbox").trigger("chosen:updated");
                    

                }else{
                   Swal.fire({
                        title: 'Error!',
                        text: data.message,
                        icon: 'error',
                        confirmButtonText: 'Ok'
                    });
                   return false;
                }
            },
            error:function(data){
                stopLoader('.modal-footer');
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
    });


    // single selection based used on cart page
    $(document).on('change','.quote_category', function(){
        var $form = $('.cart-quote-query-form');
        $form.find('.is-invalid').removeClass('is-invalid');
        $form.find('.error').text('');

        if(!$(this).val()){
            $('.quote_manufacturer').html('<option value="">Select</option>');
            $('.quote_products').html('<option value="">Select</option>');
            $('.quote_courses').html('<option value="">Select</option>');
            $('.quote_manufacturer_div').hide();
            $('.quote_products_div').hide();
            $('.quote_courses_div').hide();
            return false;
        }
        $.ajax({
            url: '/quote-manufacturers', //url
            type: 'get', //request method
            data: {
                'category':$(this).val()
            },
            headers: {'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')},
            beforeSend:function(){
               startLoader('body');
            },
            complete:function(){
                stopLoader('body');
            },
            success: function(data) {
                if(data.status){
                    var html='<option value="">Select</option>';
                    $.each(data.manufacturers, function(key, value){
                        html+='<option value="'+value.id+'">'+value.name+'</option>';
                    });
                    $('.quote_manufacturer').html(html);
                    $('.quote_manufacturer_div').show();
                }else{
                   Swal.fire({
                        title: 'Error!',
                        text: data.message,
                        icon: 'error',
                        confirmButtonText: 'Ok'
                    });
                   return false;
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
    });
    $(document).on('change','.quote_manufacturer', function(){
    	var $form = $('.cart-quote-query-form');
        $form.find('.is-invalid').removeClass('is-invalid');
        $form.find('.error').text('');

    	if(!$(this).val()){
    		$('.quote_products').html('<option value="">Select</option>');
    		$('.quote_courses').html('<option value="">Select</option>');
            $('.quote_products_div').hide();
            $('.quote_courses_div').hide();
            return false;
    	}
        $.ajax({
            url: '/quote-products', //url
            type: 'get', //request method
            data: {
                'category':$('.quote_category').val(),
                'manufacturer':$(this).val(),
            },
            headers: {'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')},
            beforeSend:function(){
               startLoader('body');
            },
            complete:function(){
                stopLoader('body');
            },
            success: function(data) {
                if(data.status){
                    var html='<option value="">Select</option>';
                    $.each(data.products, function(key, value){
                        html+='<option value="'+value.id+'">'+value.name+'</option>';
                    });
                    $('.quote_products').html(html);
                    $('.quote_products_div').show();
            
                }else{
                   Swal.fire({
                        title: 'Error!',
                        text: data.message,
                        icon: 'error',
                        confirmButtonText: 'Ok'
                    });
                   return false;
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
    });
    $(document).on('change','.quote_products', function(){
    	var $form = $('.cart-quote-query-form');
        $form.find('.is-invalid').removeClass('is-invalid');
        $form.find('.error').text('');

    	if(!$(this).val()){
    		$('.quote_courses').html('<option value="">Select</option>');
            $('.quote_courses_div').hide();
            return false;
    	}
        $.ajax({
            url: '/quote-courses', //url
            type: 'get', //request method
            data: {
                'category':$('.quote_category').val(),
                'manufacturer':$('.quote_manufacturer').val(),
                'product':$(this).val(),
            },
            headers: {'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')},
            beforeSend:function(){
               startLoader('body');
            },
            complete:function(){
                stopLoader('body');
            },
            success: function(data) {
                if(data.status){
                    var html='';
                    $.each(data.courses, function(key, value){
                        html+='<option value="'+value.id+'">'+value.name+'</option>';
                    });
                    $('.quote_courses').html(html);
                    $('.quote_courses_div').show();
                    $(".quote_courses").trigger("chosen:updated");

                }else{
                   Swal.fire({
                        title: 'Error!',
                        text: data.message,
                        icon: 'error',
                        confirmButtonText: 'Ok'
                    });
                   return false;
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
    });

    $(document).on('click','.checkSiteUrl', function(){
    	var url = $(this).data('name');
    	var siteUrl = WEBSITE_URL+'/training-site/'+url;
    	
		$.ajax({
	        url: siteUrl, //url
	        type: 'get',
	        beforeSend:function(){
	           startLoader('body');
	        },
	        complete:function(){
	            stopLoader('body');
	        },
	        success: function(data) {
	        	if(data.status){
	        		window.open(siteUrl, '_blank');
	        	}
	        },
	        error:function(data){
	            stopLoader('body');
	        }
	    });
    });


});    

/**
* Start the loader on the particular element
*/
const startLoader = function(element) {
    // check if the element is not specified
    if(typeof element == 'undefined') {
        element = "body";
    }
    // set the wait me loader
    $(element).waitMe({
        effect : 'stretch',
        text : 'Please Wait..',
        bg : 'rgba(255,255,255,0.7)',
        //color : 'rgb(66,35,53)',
        color : '#EFA91F',
        sizeW : '20px',
        sizeH : '20px',
        source : ''
    });
}

/**
* Start the loader on the particular element
*/
const stopLoader = function(element) {
    // check if the element is not specified
    if(typeof element == 'undefined') {
        element = 'body';
    }
    // close the loader
    $(element).waitMe("hide");
}

const showForgotPasswordModal = function(){
    closeAllModals();
    $('.forgotPasswordModal').modal('show');
}

const showLocationsQuoteModal = function(key){
    closeAllModals();
    $('.locationsQuoteQueryModal').modal('show');
    $('.locationsQuoteQueryModal').find('input[name="locations_course_id"]').val(key);
}

const showAccountActivationModal = function(){
    closeAllModals();
    $('.accountActivationModal').modal('show');
}

const showLoginModal = function(){
    closeAllModals();
    $('.loginModal').modal('show');
}


const showContactCourseModal = function(name, value){
    $(document).find('.error').text('');
    $('#add-tocartpop').modal('show');
    $('#add-tocartpop').find('input[name="course_name"]').val(name);
    $('#add-tocartpop').find('input[name="course_contact_id"]').val(value);
}

const showSignupModal = function(){
    closeAllModals();
    $('.signupModal').modal('show');
}

const closeAllModals = function(){
    $('.modal').modal('hide');
    addModalScroll();
}

const showContactUsModal = function(){
    if(!customerLoggedIn ){
        showLoginModal();
        return false;
    }
    closeAllModals();
    $('.homePageContactUsModal').modal('show');
}

const showLiveChat = function(){
    $('.zsiq_flt_rel').trigger('click');
}

const showFooterQuoteModal = function(){
    closeAllModals();
    $('.quoteQueryModal').modal('show');
}

const showCartQuoteModal = function(){
    closeAllModals();
    $('.cartQuoteQueryModal').modal('show');
}

const showCustomerSelectModal = function(){
    closeAllModals();
    $('.select-customer-modal').modal('show');
}

const addModalScroll = function(){
    $('.modal').css('overflow-y','auto');
}

const handleCartQuoteOption = function(event){
    if(event.value=='new')
    {
        $('.cartQuoteCourse').show();
    }
    else{
        $('.cartQuoteCourse').hide();
    }
}

const saveCustomerType = function(value){
    $.ajax({
        url: '/save-customer-type', //url
        type: 'POST', //request method
        data: {
            'customer_type_selected':value
        },
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
                $('.select-customer-modal').modal('hide');
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

const addMoreAttendence = function(){
    $(document).find('.error').text('');

    if($(".attendees_div").length>10){
        return false;
    }
    var html='<div class="form-group form-multiple-group attendes_extra_div" style="position: relative;border: 1px solid #f3f3f3;padding: 20px;"><button type="button" class="close removeMultipleattendance" title="Delete" style="position: absolute;right:10px;top: 4px;">×</button>';
    var itm = $( "div.attendees_div" ).html();
    html+=itm+'</div>';

    $(".attendees_master_div").append(html);
    $(document).find('.error').text('');
}

const showCourseShareModal = function(content){
    $('#shareCourseModal').modal('toggle');
    $('#shareCourseModal').find('input[name="share_course_id"]').val(content);
}

const show_FlashMessage =function (message, type, title) {
  	// remove all the other messages
  	PNotify.removeAll();

  	// check the type of the flash message and set by default to success
  	if(typeof type == 'undefined'){
  		type = 'success';
  	}

  	// check title is specified or not
  	if(typeof title == 'undefined' && type == 'success'){
  		title = 'Success';
  	}

  	// check title is specified or not
  	if(typeof title == 'undefined' && type == 'error')
  	{
  		title = 'Error';
  	}

  	// check title is specified or not
  	if(typeof title == 'undefined' && type == 'warning')
  	{
  		title = 'Warning!';
  	}
  	// make the new message
  	new PNotify({
  		type: type,
  		title: title,
  		text: message,
  		delay: 2000
  	});
}

const scrollToCartIcon = function(){
	$('html, body').animate({
       scrollTop: 0
    }, 1000);
}