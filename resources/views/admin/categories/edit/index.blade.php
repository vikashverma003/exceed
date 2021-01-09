@extends('admin.layouts.app')
@section('title', 'Edit Category')

@section('css')
<link rel="stylesheet" type="text/css" href="{{asset('assets/admin/css/jquery.colorpicker.css')}}">
@endsection

@section('content')
<!-- BEGIN PAGE HEADER-->
<div class="page-head">
    <div class="page-title">
        <h1>
            Edit Category
        </h1>
    </div>
</div>
<ul class="page-breadcrumb breadcrumb">
    <li>
        <i class="fa fa-circle"></i>
        <a href="{{ route('admin.dashboard') }}">Dashboard</a>
        <i class="fa fa-circle"></i>
        <a href="{{ url('admin/categories') }}">Categories Listing</a>
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
                                <div class="form-group name">
                                    <label> Name</label>&nbsp;<span style="color: red;">*</span>
                                    <input type="text" name="name" class="form-control" placeholder="Enter Name" value="{{$data->name}}">
                                    <span class="error"></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-body">
                                <div class="form-group color">
                                    <label>Home Page Listing Color</label><span style="color: red;"> *</span>
                                    <input type="text" name="color" class="form-control" id="colorpicker-popup" value="{{$data->color}}">
                                    <span class="error"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="row">
                         <div class="col-md-6">
                            <div class="form-body">
                                <div class="form-group meta_tags">
                                    <label> Meta Title</label>&nbsp;
                                    <!-- <span style="color: red;">*</span> -->
                                    <input type="text" name="meta_tags" class="form-control" placeholder="Enter Meta Title" value="{{$data->meta_tags}}">
                                    <span class="error"></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-body">
                                <div class="form-group meta_keywords">
                                    <label> Meta Keywords</label>&nbsp;
                                    <!-- <span style="color: red;">*</span> -->
                                    <input type="text" name="meta_keywords" class="form-control" placeholder="Enter Meta Keywords" value="{{$data->meta_keywords}}">
                                    <span class="error"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="row">
                     <div class="col-md-6">
                            <div class="form-body">
                                <div class="form-group meta_description">
                                    <label> Meta Description</label>&nbsp;
                                    <!-- <span style="color: red;">*</span> -->
                                    <input type="text" name="meta_description" class="form-control" placeholder="Enter Meta Description" value="{{$data->meta_description}}">
                                    <span class="error"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-body">
                                <div class="form-group logo">
                                    <label>Logo (Type: jpeg, png, jpg, gif, svg) Max Size:2MB, Preferred Size: 120*120 (max width* max height)</label>
                                    <input type="file" name="logo" class="form-control" onchange="readURL(this,'image_prev')">
                                    <span class="error"></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-body">
                                <div class="form-group icon">
                                    <label>Icon (Type: jpeg, png, jpg, gif, svg) Max Size:2MB, Preferred Size: 24*24 (max width* max height)</label>
                                    <input type="file" name="icon" class="form-control" onchange="readURL(this,'icon_prev')">
                                    <span class="error"></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <label>Logo Preview</label>
                            <div class="clearfix"></div>
                            <div class="fileinput fileinput-new" data-provides="fileinput">
                                <div class="fileinput-new thumbnail" style="width: 200px; height: 150px;">
                                    @if(!$data->logo)
                                        <img src="http://www.placehold.it/200x150/EFEFEF/AAAAAA&amp;text=no+image" alt="Logo" style="width: 200px; height: 150px;" class="image_prev">
                                    @else
                                        <img src="{{asset('uploads/categories/'.$data->logo)}}" alt="Logo" style="width: 200px; height: 150px;" class="image_prev">
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label>Icon Preview</label>
                            <div class="clearfix"></div>
                            <div class="fileinput fileinput-new" data-provides="fileinput">
                                <div class="fileinput-new thumbnail" style="width: 200px; height: 150px;">
                                    @if(!$data->icon)
                                        <img src="http://www.placehold.it/200x150/EFEFEF/AAAAAA&amp;text=no+image" alt="Logo" style="width: 200px; height: 150px;" class="icon_prev">
                                    @else
                                        <img src="{{asset('uploads/categories/'.$data->icon)}}" alt="Logo" style="width: 200px; height: 150px;" class="icon_prev">
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                   <div class="col-md-6">
                            <div class="form-body">
                                <div class="form-group banner">
                                    <label> Banner (jpeg,png,jpg,gif,svg) Max: 2MB, Preferred Size: 1600*250 (width*height)</label>&nbsp;<span style="color: red;">*</span>
                                    <input type="file" name="banner" class="form-control" onchange="readURL(this,'banner_prev')">
                                    <span class="error"></span>
                                </div>
                            </div>
                        </div>
                      <div class="clearfix"></div>
                       <div class="col-md-6">
                            <label>Banner Preview</label>
                            <div class="clearfix"></div>
                            <div class="fileinput fileinput-new" data-provides="fileinput">
                                <div class="fileinput-new thumbnail" style="width: 200px; height: 150px;">
                                    @if(!$data->banner)
                                        <img src="http://www.placehold.it/200x150/EFEFEF/AAAAAA&amp;text=no+image" alt="Logo" style="width: 200px; height: 150px;" class="banner_prev">
                                    @else
                                        <img src="{{asset('uploads/categories/'.$data->banner)}}" alt="Logo" style="width: 200px; height: 150px;" class="banner_prev">
                                    @endif
                                </div>
                            </div>
                        </div>
                    
                    <div class="clearfix"></div>

                    <div class="row">
                        <div class="col-md-12">
                        <div class="form-body">
                            <div class="form-group desc">
                                <label> Description (Description must not be greater than 5000 characters)</label>&nbsp;<span style="color: red;">*</span>
                                <textarea name="desc" id="desc" class="form-control" placeholder="Enter Description">{{$data->desc}}</textarea>
                                <span class="error"></span>
                            </div>
                        </div>
                    </div></div>

                    <div class="clearfix"></div>
                    <div class="form-actions">
                        <button type="submit" class="btn blue">Submit</button>
                        <a href="{{url('admin/categories')}}"><button type="button" class="btn default">Cancel</button></a>
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
<script type="text/javascript" src="{{ asset('assets/plugins/ckeditor/ckeditor.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/admin/js/jquery.colorpicker.js') }}"></script>

<script type="text/javascript">
    CKEDITOR.replace('desc');
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
        $('#colorpicker-popup').colorpicker();

        var html = jQuery("#desc").text();
        //set editor data
        CKEDITOR.instances['desc'].setData(html);

        $("form[name='add_form']").submit(function(e){
            e.preventDefault();
            $(document).find('span.error').empty().hide();
            var data = new FormData($('#add_form')[0])
            var desc = CKEDITOR.instances['desc'].getData();
            data.append('desc',desc);

            var id = "{{$data->id}}";
            $.ajax({
                url: "{{url('admin/categories')}}"+'/'+id, //url
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