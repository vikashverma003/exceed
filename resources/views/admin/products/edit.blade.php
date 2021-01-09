@extends('admin.layouts.app')
@section('title', 'Edit Product Family')
@section('content')
<!-- BEGIN PAGE HEADER-->
<div class="page-head">
    <div class="page-title">
        <h1>
            Edit Product Family
        </h1>
    </div>
</div>
<ul class="page-breadcrumb breadcrumb">
    <li>
        <i class="fa fa-circle"></i>
        <a href="{{ route('admin.dashboard') }}">Dashboard</a>
        <i class="fa fa-circle"></i>
        <a href="{{ url('admin/products') }}">Products Family Listing</a>
    </li>
</ul>
<!-- END PAGE HEADER-->
<div class="row">
    <div class="col-md-12">
        <div class="portlet light md-shadow-z-2-i">
            <div class="portlet-body form">
                <form role="form" method="POST" name="add_form" id="add_form" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id" value="{{$data->id}}">
                    <input type="hidden" name="_method" value="PUT">
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
                            <div class="form-group manufacturer">
                                <label>Manufacturer</label><span style="color: red;"> *</span>
                                <select name="manufacturer" id="manufacturer" class="form-control">
                                    <option value="">Select Manufacturer</option>
                                    @foreach($manufacturers as $row)
                                        <option value="{{$row->id}}" @if($data->manufacturer_id==$row->id) selected @endif>{{$row->name}}</option>
                                    @endforeach
                                </select>
                                <span class="error"></span>
                            </div>
                        </div>
                    </div>
                    <div class="clearfix"></div>

                    <div class="col-md-6">
                        <div class="form-body">
                            <div class="form-group category">
                                <label>Category</label><span style="color: red;"> *</span>
                                <select name="category" id="category" class="form-control">
                                    <option value="">Select Category</option>
                                    @foreach($categories as $row)
                                        <option value="{{$row->id}}" @if($data->category_id==$row->id) selected @endif>{{$row->name}}</option>
                                    @endforeach
                                </select>
                                <span class="error"></span>
                                <div class="clearfix"></div>
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

                    <div class="clearfix"></div>
                     <div class="col-md-6">
                            <div class="form-body">
                                <div class="form-group meta_tags">
                                    <label> Meta Title</label>&nbsp;
                                    <!-- <span style="color: red;">*</span> -->
                                    <input type="text" name="meta_tags" class="form-control" placeholder="Enter Meta Keywords" value="{{$data->meta_tags}}">
                                    <span class="error"></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-body">
                                <div class="form-group meta_description">
                                    <label> Meta Description</label>&nbsp;
                                    <!-- <span style="color: red;">*</span> -->
                                    <input type="text" name="meta_description" class="form-control" placeholder="Enter Meta Keywords" value="{{$data->meta_description}}">
                                    <span class="error"></span>
                                </div>
                            </div>
                        </div>

                    <div class="clearfix"></div>
                      <div class="row">
                        <div class="col-md-6">
                            <div class="form-body">
                                <div class="form-group banner">
                                    <label> Banner (jpeg,png,jpg,gif,svg) Max: 2MB, Preferred Size: 1600*250 (width*height)</label>&nbsp;<span style="color: red;">*</span>
                                    <input type="file" name="banner" class="form-control" onchange="readURL(this,'banner_prev')">
                                    <span class="error"></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label></label>
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
                    </div>
                    <div class="clearfix"></div>

                    <div class="col-md-12">
                        <div class="form-body">
                            <div class="form-group description">
                                <label> Description (Description must not be greater than 5000 characters)</label>&nbsp;<span style="color: red;">*</span>
                                <textarea name="description" id="description" class="form-control" placeholder="Enter Description">{{$data->description}}</textarea>
                                <span class="error"></span>
                            </div>
                        </div>
                    </div>

                    <div class="clearfix"></div>
                    <div class="form-actions">
                        <button type="button" class="btn blue form_submit_btn">Submit</button>
                        <a href="{{url('admin/products')}}"><button type="button" class="btn default">Cancel</button></a>
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

        $(document).on('click','.form_submit_btn', function(e){
            e.preventDefault();
            $(document).find('span.error').empty().hide();
            var data = new FormData($('#add_form')[0])
            var description = CKEDITOR.instances['description'].getData();
            data.append('description',description);

            var id = $('input[name="id"]').val();
            $.ajax({
                url: "{{url('admin/products')}}"+'/'+id, //url
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
                    alert(error)
                    
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