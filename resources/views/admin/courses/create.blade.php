@extends('admin.layouts.app')
@section('title', 'Add Product')
@section('content')
<!-- BEGIN PAGE HEADER-->
<div class="page-head">
    <div class="page-title">
        <h1>
            Add Product
        </h1>
    </div>
</div>
<ul class="page-breadcrumb breadcrumb">
    <li>
        <i class="fa fa-circle"></i>
        <a href="{{ route('admin.dashboard') }}">Dashboard</a>
        <i class="fa fa-circle"></i>
        <a href="{{ url('admin/courses') }}">Products Listing</a>
    </li>
</ul>
<!-- END PAGE HEADER-->
<div class="row">
    <div class="col-md-12">
        <div class="portlet light md-shadow-z-2-i">
            <div class="portlet-body form">
                <form role="form" method="POST" name="add_form" id="add_form" enctype="multipart/form-data">
                    @csrf

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-body">
                                <div class="form-group manufacturer">
                                    <label>Manufacturer</label>&nbsp;<span style="color: red;">*</span>
                                    <select class="form-control" name="manufacturer" id="manufacturer">
                                        <option value="" selected="" disabled="">Select</option>
                                        @foreach($manufacturers as $row)
                                            <option value="{{$row->id}}">{{$row->name}}</option>
                                        @endforeach
                                    </select>
                                    <span class="error"></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-body">
                                <div class="form-group category">
                                    <label>Training Category</label>&nbsp;<span style="color: red;">*</span>
                                    <select class="form-control" name="category" id="category">
                                        <option value="" selected="" disabled="">Select</option>
                                        
                                    </select>
                                    <span class="error"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-body">
                                <div class="form-group product">
                                    <label>Product Family</label>&nbsp;<span style="color: red;">*</span>
                                    <select class="form-control" name="product" id="product">
                                        <option value="" selected="" disabled="">Select</option>
                                        
                                    </select>
                                    <span class="error"></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-body">
                                <div class="form-group name">
                                    <label> Name</label>&nbsp;<span style="color: red;">*</span>
                                    <input type="text" name="name" class="form-control" placeholder="Enter Name">
                                    <span class="error"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-body">
                                <div class="form-group price">
                                    <label> Price (AED)</label>&nbsp;
                                    <!-- <span style="color: red;">*</span> -->
                                    <input type="number" name="price" class="form-control" placeholder="Enter Price">
                                    <span class="error"></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-body">
                                <div class="form-group offer_price">
                                    <label>Offer Price (AED)</label>&nbsp;
                                    <!-- <span style="color: red;">*</span> -->
                                    <input type="number" name="offer_price" class="form-control" placeholder="Enter Offer Price">
                                    <span class="error"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-body">
                                <div class="form-group duration">
                                    <label> Duration </label>&nbsp;
                                    <!-- <span style="color: red;">*</span> -->
                                    <input type="number" name="duration" class="form-control" placeholder="Enter Duration">
                                    <span class="error"></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-body">
                                <div class="form-group duration_type">
                                    <label> Duration Type</label>&nbsp;
                                    <!-- <span style="color: red;">*</span> -->
                                    <select name="duration_type" class="form-control">
                                        <option value="">Select Duration Type</option>
                                        <option value="days">Days</option>
                                        <option value="weeks">Weeks</option>
                                        <option value="months">Months</option>
                                    </select>
                                    <span class="error"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="clearfix"></div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-body">
                                <div class="form-group meta_keywords">
                                    <label> Meta Keywords</label>&nbsp;
                                    <!-- <span style="color: red;">*</span> -->
                                    <input type="text" name="meta_keywords" class="form-control" placeholder="Enter Meta Keywords">
                                    <span class="error"></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-body">
                                <div class="form-group meta_description">
                                    <label> Meta Description</label>&nbsp;
                                    <!-- <span style="color: red;">*</span> -->
                                    <input type="text" name="meta_description" class="form-control" placeholder="Enter Meta Description">
                                    <span class="error"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="clearfix"></div>

                    <div class="row">
                        
                         <div class="col-md-6">
                            <div class="form-body">
                                <div class="form-group short_note">
                                    <label> Short Note</label>&nbsp;
                                    <!-- <span style="color: red;">*</span> -->
                                    <input type="text" name="short_note" class="form-control" placeholder="Enter Note">
                                    <span class="error"></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-body">
                                <div class="form-group order">
                                    <label> Order (The course  will show in this sequence to the users)</label>&nbsp;<span style="color: red;">*</span>
                                    <input type="text" name="order" class="form-control" placeholder="Enter Order" value="{{$order}}">
                                    <span class="error"></span>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-body">
                                <div class="form-group sample_video">
                                    <label> Sample Video URL (Youtube embed url, vimeo etc.)</label>&nbsp;
                                    <small>check this example <a onclick="showGuidelineModal()">Click</a> </small>
                                    
                                    <input type="text" name="sample_video" class="form-control">
                                    <span class="error"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-body">
                                <div class="form-group image">
                                    <label> Image (jpeg,png,jpg,gif,svg) Max: 2MB, Preferred Size: 250*200 (width*height)</label>&nbsp;<span style="color: red;">*</span>
                                    <input type="file" name="image" class="form-control" onchange="readURL(this,'image_prev')">
                                    <span class="error"></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-body">
                                <div class="form-group banner">
                                    <label> Banner (jpeg,png,jpg,gif,svg) Max: 2MB, Preferred Size: 1600*250 (width*height)</label>&nbsp;<span style="color: red;">*</span>
                                    <input type="file" name="banner" class="form-control" onchange="readURL(this,'banner_prev')">
                                    <span class="error"></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <!-- <label>Image Preview</label> -->
                            <div class="clearfix"></div>
                            <div class="fileinput fileinput-new" data-provides="fileinput">
                                <div class="fileinput-new thumbnail" style="width: 200px; height: 150px;">
                                    <img src="http://www.placehold.it/200x150/EFEFEF/AAAAAA&amp;text=no+image" alt="Logo" style="width: 200px; height: 150px;" class="image_prev">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <!-- <label>Banner Preview</label> -->
                            <div class="clearfix"></div>
                            <div class="fileinput fileinput-new" data-provides="fileinput">
                                <div class="fileinput-new thumbnail" style="width: 200px; height: 150px;">
                                    <img src="http://www.placehold.it/200x150/EFEFEF/AAAAAA&amp;text=no+image" alt="Logo" style="width: 200px; height: 150px;" class="banner_prev">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-body">
                                <div class="form-group image">
                                    <label>Internal Product Image (jpeg,png,jpg,gif,svg) Max: 2MB, Preferred Size: 250*200 (width*height)</label>&nbsp;<span style="color: red;">*</span>
                                    <input type="file" name="inner_image" class="form-control" onchange="readURL(this,'inner_image_prev')">
                                    <span class="error"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <!-- <label>Internal Product Image Preview</label> -->
                            <div class="clearfix"></div>
                            <div class="fileinput fileinput-new" data-provides="fileinput">
                                <div class="fileinput-new thumbnail" style="width: 200px; height: 150px;">
                                    <img src="http://www.placehold.it/200x150/EFEFEF/AAAAAA&amp;text=no+image" alt="Logo" style="width: 200px; height: 150px;" class="inner_image_prev">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-body">
                                <div class="form-group description">
                                    <label> Description (Description must not be greater than 5000 characters)</label>&nbsp;<span style="color: red;">*</span>
                                    <textarea name="description" id="description" placeholder="Enter Description" class="form-control"></textarea>
                                    <span class="error"></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="clearfix"></div>
                    
                    <div class="form-actions">
                        <button type="button" class="btn blue form_submit_btn">Submit</button>
                        <a href="{{url('admin/courses')}}"><button type="button" class="btn default">Cancel</button></a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="clearfix"></div>
    <div id="guidelines" class="modal fade" role="dialog" data-backdrop="static" data-keyboard="false" style="z-index: 9999;">
        <div class="modal-dialog" style="max-width: 40%">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title" style="text-align: center;"><b>Steps to add the video link in the product link filed.</b></h4>
                </div>
                <div class="modal-body">
                    <b>For Adding Video Vimeo.</b>
                    <ul>
                        <li>For an example of  Vimeo Link:- https://vimeo.com/455901369</li>
                        <li>Now change this link like this:- https://player.vimeo.com/video/455901369</li>
                        <li>Now paste on the product link filed and save it.</li>
                    </ul>
                    <b>For Adding the Youtube video Link.</b>
                    <ul>
                        <li>Open any video on youtube.</li>
                        <li>Now choose the share option from the video description and copy the link of the video.</li>
                        <li>For example, the Youtube video link is like this:- https://youtu.be/yAoLSRbwxL8</li>
                        <li>Next change the video link like this :-https://www.youtube.com/embed/yAoLSRbwxL8</li>
                        <li>Now copy the changed video link and paste on the product link and save it.</li>
                    <ul>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="clearfix"></div>
@endsection
@section('pagejs')
<script type="text/javascript" src="{{ asset('assets/plugins/ckeditor/ckeditor.js') }}"></script>
<script type="text/javascript">
    CKEDITOR.replace('description');

    function readURL(input,type) {
        var site = "http://www.placehold.it/200x150/EFEFEF/AAAAAA&amp;text=no+image";
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('.'+type).attr('src', e.target.result);
            };
            reader.readAsDataURL(input.files[0]);
        }else{
            $('.'+type).attr('src', site);
        }
    }
    function showGuidelineModal()
    {
        $('#guidelines').modal('show');
    }

    $(document).ready(function () {
        
        $(document).on('change','#manufacturer', function(e){
            var val = $(this).val();
            $.ajax({
                url: "{{url('admin/manufacturercategory')}}", //url
                type: 'get', //request method
                data: {
                    'val':val
                },
                // processData: false,  // Important!
                // contentType: false,
                beforeSend: function() {
                    startLoader('.portlet');
                },
                complete:function(){
                    
                },
                success: function(data) {
                    if(data.status){
                        var html = '<option value="">Select</option>';
                        $.each(data.data, function(key, val){
                            html+='<option value="'+val.id+'">'+val.name+'</option>';
                        });
                        $('#category').html(html);
                        stopLoader('.portlet');
                    }else{
                        stopLoader('.portlet');
                        show_FlashMessage(data.message, 'error');
                    }
                },
                error: function(error){
                    var html = '<option value="">Select</option>';
                    $('#category').html(html);

                    if(error.status == 400) {
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

        $(document).on('change','#category', function(e){
            var category_id = $(this).val();
            var manufacturer_id = $('#manufacturer').val();
            $.ajax({
                url: "{{url('admin/manufacturerproducts')}}", //url
                type: 'get', //request method
                data: {
                    'manufacturer_id':manufacturer_id,
                    'category_id':category_id
                },
                // processData: false,  // Important!
                // contentType: false,
                beforeSend: function() {
                    startLoader('.portlet');
                },
                complete:function(){
                    
                },
                success: function(data) {
                    if(data.status){
                        var html = '<option value="">Select</option>';
                        $.each(data.data, function(key, val){
                            html+='<option value="'+val.id+'">'+val.name+'</option>';
                        });
                        $('#product').html(html);
                        stopLoader('.portlet');
                    }else{
                        stopLoader('.portlet');
                        show_FlashMessage(data.message, 'error');
                    }
                },
                error: function(error){
                    var html = '<option value="">Select</option>';
                    $('#product').html(html);

                    if(error.status == 400) {
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

        $(document).on('click','.form_submit_btn', function(e){
            e.preventDefault();
            $(document).find('span.error').empty().hide();
            var data = new FormData($('#add_form')[0])
            var description = CKEDITOR.instances['description'].getData();
            data.append('description',description);

            $.ajax({
                url: "{{url('admin/courses')}}", //url
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
                        stopLoader('.portlet');
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

                        $('html, body').animate({
                             scrollTop: ($('.error').offset().top - 300)
                        }, 2000);
                        
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