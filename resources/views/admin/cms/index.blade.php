@extends('admin.layouts.app')
@section('title', 'CMS Content')
@section('content')
<!-- BEGIN PAGE HEADER-->
<div class="page-head">
    <div class="page-title">
        <h1>
            Manage Home-Page Content
        </h1>
    </div>
</div>
<ul class="page-breadcrumb breadcrumb">
    <li>
        <i class="fa fa-circle"></i>
        <a href="{{ route('admin.dashboard') }}">Dashboard</a>
    </li>
</ul>
<!-- END PAGE HEADER-->
<div class="row">
    <div class="col-md-12">
        <div class="portlet light md-shadow-z-2-i">
            <div class="portlet-body form">
                <form role="form" method="POST" name="add_form" id="add_form" enctype="multipart/form-data">
                    @csrf
                    <div class="col-md-6">
                        <div class="form-body">
                            <div class="form-group page_heading">
                                <label>Home Page Heading</label>&nbsp;<span style="color: red;">*</span>
                                <input type="text" name="page_heading" class="form-control" placeholder="Page Heading" value="{{$cmsContent->page_heading ?? ''}}">
                                <span class="error"></span>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-body">
                            <div class="form-group search_placeholder">
                                <label>Home Page Course Search Placeholder</label>&nbsp;<span style="color: red;">*</span>
                                <input type="text" name="search_placeholder" class="form-control" placeholder="Course Search Placeholder" value="{{$cmsContent->search_placeholder ?? ''}}">
                                <span class="error"></span>
                            </div>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="col-md-6">
                        <div class="form-body">
                            <div class="form-group search_button_title">
                                <label>Home Page Course Search Title</label>&nbsp;<span style="color: red;">*</span>
                                <input type="text" name="search_button_title" class="form-control" placeholder="Course Search Title" value="{{$cmsContent->search_button_title ?? ''}}">
                                <span class="error"></span>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-body">
                            <div class="form-group advance_search_heading">
                                <label>Home Page Advance Search Heading</label>&nbsp;<span style="color: red;">*</span>
                                <input type="text" name="advance_search_heading" class="form-control" placeholder="Advance Search Heading" value="{{$cmsContent->advance_search_heading ?? ''}}">
                                <span class="error"></span>
                            </div>
                        </div>
                    </div>
                    <div class="clearfix"></div>

                    <div class="col-md-6">
                        <div class="form-body">
                            <div class="form-group advance_search_title">
                                <label>Home Page Advance Search Title</label>&nbsp;<span style="color: red;">*</span>
                                <input type="text" name="advance_search_title" class="form-control" placeholder="Advance Search Title" value="{{$cmsContent->advance_search_title ?? ''}}">
                                <span class="error"></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-body">
                            <div class="form-group services_title">
                                <label>Home Page Services Section Title</label>&nbsp;<span style="color: red;">*</span>
                                <input type="text" name="services_title" class="form-control" placeholder="Services Title" value="{{$cmsContent->services_title ?? ''}}">
                                <span class="error"></span>
                            </div>
                        </div>
                    </div>
                    <div class="clearfix"></div>

                    <div class="col-md-6">
                        <div class="form-body">
                            <div class="form-group services_sub_title">
                                <label>Home Page Services Section Sub-Title</label>&nbsp;<span style="color: red;">*</span>
                                <input type="text" name="services_sub_title" class="form-control" placeholder="Services Sub-Title" value="{{$cmsContent->services_sub_title ?? ''}}">
                                <span class="error"></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-body">
                            <div class="form-group category_title">
                                <label>Home Page Category Section Title</label>&nbsp;<span style="color: red;">*</span>
                                <input type="text" name="category_title" class="form-control" placeholder="Category Title" value="{{$cmsContent->category_title ?? ''}}">
                                <span class="error"></span>
                            </div>
                        </div>
                    </div>
                    <div class="clearfix"></div>

                    <div class="col-md-6">
                        <div class="form-body">
                            <div class="form-group category_sub_title">
                                <label>Home Page Category Section Sub-Title</label>&nbsp;<span style="color: red;">*</span>
                                <input type="text" name="category_sub_title" class="form-control" placeholder="Category Sub-Title" value="{{$cmsContent->category_sub_title ?? ''}}">
                                <span class="error"></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-body">
                            <div class="form-group manufacturer_title">
                                <label>Home Page Manufacturers Section Title</label>&nbsp;<span style="color: red;">*</span>
                                <input type="text" name="manufacturer_title" class="form-control" placeholder="Manufacturer Title" value="{{$cmsContent->manufacturer_title ?? ''}}">
                                <span class="error"></span>
                            </div>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="col-md-6">
                        <div class="form-body">
                            <div class="form-group manufacturer_sub_title">
                                <label>Home Page Manufacturers Section Sub-Title</label>&nbsp;<span style="color: red;">*</span>
                                <input type="text" name="manufacturer_sub_title" class="form-control" placeholder="Manufacturer Sub-Title" value="{{$cmsContent->manufacturer_sub_title ?? ''}}">
                                <span class="error"></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-body">
                            <div class="form-group testimonial_title">
                                <label>Home Page Testimonials Section Title</label>&nbsp;<span style="color: red;">*</span>
                                <input type="text" name="testimonial_title" class="form-control" placeholder="Testimonial Title" value="{{$cmsContent->testimonial_title ?? ''}}">
                                <span class="error"></span>
                            </div>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="col-md-12">
                        <div class="form-body">
                            <div class="form-group testimonial_sub_title">
                                <label>Home Page Testimonials Section Sub-Title</label>&nbsp;<span style="color: red;">*</span>
                                <input type="text" name="testimonial_sub_title" class="form-control" placeholder="Testimonial Sub-Title" value="{{$cmsContent->testimonial_sub_title ?? ''}}">
                                <span class="error"></span>
                            </div>
                        </div>
                    </div>

                    </div>
                    <div class="clearfix"></div>
                    
                
                    <div class="col-md-6">
                        <div class="form-body">
                            <div class="form-group background_video">
                                <label>Home Page Background Video Url</label>&nbsp;<span style="color: red;">*</span>
                                <input type="text" name="background_video" class="form-control" value="{{$cmsContent->background_video ?? ''}}">
                                <span class="error"></span>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                    </div>

                    <div class="clearfix"></div>
                    <div class="form-actions">
                        <button type="submit" class="btn blue">Submit</button>
                        <a href="{{url('admin')}}"><button type="button" class="btn default">Cancel</button></a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="clearfix"></div>
</div>
<div class="clearfix"></div>
@endsection
@section('pagejs')
<script type="text/javascript">

    $(document).ready(function () {

        $("form[name='add_form']").submit(function(e){
            e.preventDefault();
            $(document).find('span.error').empty().hide();
            var data = new FormData($('#add_form')[0])
            if($("input[name='service_card_2']:checked").length>0){
                data.append('service_card_2','1');
            }
            if($("input[name='service_card_3']:checked").length>0){
                data.append('service_card_3','1');
            }
            $.ajax({
                url: "{{url('admin/cms-content')}}", //url
                type: 'POST', //request method
                data: data,
                processData: false,  // Important!
                contentType: false,
                beforeSend: function() {
                    startLoader('.portlet');
                },
                complete:function(){
                    
                },
                success: function(data) {
                    if(data.status){
                        show_FlashMessage(data.message, 'success');
                        setTimeout(function(){
                            stopLoader('.portlet');
                            window.location = data.url;
                        }, 2000);                        
                    }else{
                        show_FlashMessage(data.message, 'error');
                    }
                },
                error: function(error){
                    
                    if(error.status == 0 || error.readyState == 0) {
                        return;
                    }
                    else if(error.status == 401){
                        errors = $.parseJSON(error.responseText);
                        window.location = errors.redirectTo;
                    }
                    else if(error.status == 422) {
                        errors = error.responseJSON;
                        $.each(errors.errors, function(key, value) {
                            if(key.indexOf('.') != -1) {
                                let keys = key.split('.');
                                /*let keys_length = keys.length;*/
                                $('.'+keys[0]+'_'+keys[1]).find('span.error').empty().addClass('text-danger').text(value).finish().fadeIn();
                            }
                            else {
                                $('.'+key).find('span.error').empty().addClass('text-danger').text(value).finish().fadeIn();
                            }
                        });

                        // $('html, body').animate({
                        //      scrollTop: ($('.error').offset().top - 300)
                        // }, 2000);
                        
                    }
                    else if(error.status == 400) {
                        errors = error.responseJSON;
                        if(errors.hasOwnProperty('message')) {
                            show_FlashMessage(errors.message, 'error');
                        }
                        else {
                            show_FlashMessage('Something went wrong!', 'error');
                        }
                    }
                    else {
                        show_FlashMessage('Something went wrong!', 'error');
                    }
                    //stop ajax loader
                    stopLoader('.portlet');
                }
            });
        });
    });
</script>
@endsection