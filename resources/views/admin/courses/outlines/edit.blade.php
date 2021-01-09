@extends('admin.layouts.app')
@section('title', 'Course Outlines')
@section('content')
<!-- BEGIN PAGE HEADER-->
<div class="page-head">
    <div class="page-title">
        <h1>
            Edit Course Outlines For- -{{ucfirst($course->name)}}
        </h1>
    </div>
</div>
<ul class="page-breadcrumb breadcrumb">
    <li>
        <i class="fa fa-circle"></i>
        <a href="{{ route('admin.dashboard') }}">Dashboard</a>
        <i class="fa fa-circle"></i>
        <a href="{{url('admin/courses')}}">Courses Listing</a>
        <i class="fa fa-circle"></i>
        <a href="{{url('admin/outlines/'.$course->id)}}">Outlines Listing</a>
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
                    <div class="col-md-12">
                        <div class="form-body">
                            <div class="form-group title">
                                <label> Title</label>&nbsp;<span style="color: red;">*</span>
                                <input type="text" name="title" class="form-control" value="{{$data->title}}">
                                <span class="error"></span>
                            </div>
                        </div>
                    </div>
                    <!-- <div class="col-md-6">
                        <div class="form-body">
                            <div class="form-group day">
                                <label> Day</label>&nbsp;<span style="color: red;">*</span>
                                <input type="text" name="day" readonly="true" class="form-control" value="{{$data->day}}">
                                <span class="error"></span>
                            </div>
                        </div>
                    </div> -->
                    <div class="clearfix"></div>
                    <div class="col-md-12">
                        <div class="form-body">
                            <div class="form-group description">
                                <label> Description (Description must not be greater than 5000 characters)</label>&nbsp;<span style="color: red;">*</span>
                                <textarea name="description" id="description" placeholder="Enter Description" class="form-control">{{$data->description}}</textarea>
                                <span class="error"></span>
                            </div>
                        </div>
                    </div>

                    <div class="clearfix"></div>
                    
                    <div class="form-actions">
                        <button type="submit" class="btn blue">Submit</button>
                        <a href="{{url('admin/outlines/'.$course->id)}}"><button type="button" class="btn default">Cancel</button></a>
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

        $(document).ready(function () {
            var html = jQuery("#description").text();
            //set editor data
            CKEDITOR.instances['description'].setData(html);

            $("form[name='add_form']").submit(function(e){
                e.preventDefault();
                $(document).find('span.error').empty().hide();
                var data = new FormData($('#add_form')[0])
                var description = CKEDITOR.instances['description'].getData();
                data.append('description',description);

                $.ajax({
                    url: "{{url('admin/outline/update')}}", //url
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