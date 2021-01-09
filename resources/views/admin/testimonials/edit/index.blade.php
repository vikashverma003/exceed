@extends('admin.layouts.app')
@section('title', 'Edit Testimonial')
@section('content')
<!-- BEGIN PAGE HEADER-->
<div class="page-head">
    <div class="page-title">
        <h1>
            Edit Testimonial
        </h1>
    </div>
</div>
<ul class="page-breadcrumb breadcrumb">
    <li>
       <i class="fa fa-circle"></i>
        <a href="{{ route('admin.dashboard') }}">Dashboard</a>
        <i class="fa fa-circle"></i>
        <a href="{{ url('admin/testimonials') }}">Testimonials Listing</a>
    </li>
</ul>
<!-- END PAGE HEADER-->
<div class="row">
    <div class="col-md-12">
        <div class="portlet light md-shadow-z-2-i">
            <div class="portlet-body form">
                <form role="form" method="POST" name="add_form" id="add_form" enctype="multipart/form-data">
                    @csrf
                     <input type="hidden" name="_method" value="PUT">
                    <div class="row">
                        <div class="col-md-6">
                        <div class="form-body">
                            <div class="form-group user_name">
                                <label> Name</label>&nbsp;<span style="color: red;">*</span>
                                <input type="text" name="user_name" class="form-control" placeholder="Enter Name" value="{{$data->user_name}}">
                                <span class="error"></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-body">
                            <div class="form-group user_role">
                                <label>Role</label>&nbsp;<span style="color: red;">*</span>
                                <input type="text" name="user_role" class="form-control" placeholder="Enter Role" value="{{$data->user_role}}">
                                <span class="error"></span>
                            </div>
                        </div>
                    </div>
                    </div>
                    <div class="clearfix"></div>

                    <div class="row">
                        <div class="col-md-12">
                        <div class="form-body">
                            <div class="form-group comment">
                                <label> Comment</label>&nbsp;<span style="color: red;">*</span>
                                <textarea name="comment" class="form-control" placeholder="Enter Description">{{$data->comment}}</textarea>
                                <span class="error"></span>
                            </div>
                        </div>
                    </div></div>
                    <div class="clearfix"></div>
                    <div class="row">
                        <div class="col-md-6">
                        <div class="form-body">
                            <div class="form-group user_image">
                                <label>Image (Type: jpeg, png, jpg) Max Size:2MB, Preferred Size: 100*100</label>
                                <input type="file" name="user_image" class="form-control" onchange="readURL(this,'image_prev')">
                                <span class="error"></span>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                    </div></div>

                    <div class="row">
                        <div class="col-md-6">
                            <label>Preview</label>
                            <div class="clearfix"></div>
                            <div class="fileinput fileinput-new" data-provides="fileinput">
                                <div class="fileinput-new thumbnail" style="width: 200px; height: 150px;">
                                    @if(!$data->user_image)
                                        <img src="http://www.placehold.it/200x150/EFEFEF/AAAAAA&amp;text=no+image" alt="Logo" style="width: 200px; height: 150px;" class="image_prev">
                                    @else
                                        <img src="{{asset('uploads/testimonials/'.$data->user_image)}}" alt="Logo" style="width: 200px; height: 150px;" class="image_prev">
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="clearfix"></div>
                    <div class="form-actions">
                        <button type="submit" class="btn blue">Submit</button>
                        <a href="{{url('admin/testimonials')}}"><button type="button" class="btn default">Cancel</button></a>
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
    $(document).ready(function () {

        $("form[name='add_form']").submit(function(e){
            e.preventDefault();
            $(document).find('span.error').empty().hide();
            var data = new FormData($('#add_form')[0])
            var id = "{{$data->id}}";
            $.ajax({
                url: "{{url('admin/testimonials')}}"+'/'+id, //url
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
                        stopLoader('.portlet');
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