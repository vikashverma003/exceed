@extends('admin.layouts.app')
@section('title', 'Add Training Site Content')
@section('content')
<!-- BEGIN PAGE HEADER-->
<div class="page-head">
    <div class="page-title">
        <h1>
            Add Training Site Content
        </h1>
    </div>
</div>
<ul class="page-breadcrumb breadcrumb">
    <li>
        <i class="fa fa-circle"></i>
        <a href="{{ route('admin.dashboard') }}">Dashboard</a>
        <i class="fa fa-circle"></i>
        <a href="{{ url('admin/settings/training-sites') }}">Training Sites Contents Listing</a>
    </li>
</ul>
<!-- END PAGE HEADER-->
<div class="row">
    <div class="col-md-12">
        <div class="portlet light md-shadow-z-2-i">
            <div class="portlet-body form">
                <form role="form" method="POST" name="add_form" id="add_form" enctype="multipart/form-data">
                    <div class="col-md-6">
                        <div class="form-body">
                            <div class="form-group type">
                                <label>Location Name</label>
                                <select name="type" class="form-control">
                                    @foreach($data as $row)
                                        <option value="{{$row->name}}">{{$row->name}}</option>
                                    @endforeach
                                </select>
                                <span class="error"></span>
                            </div>
                        </div>
                    </div>

                    <div class="clearfix"></div>

                    <div class="col-md-12">
                        <div class="form-body">
                            <div class="form-group content">
                                <label> Content</label>&nbsp;<span style="color: red;">*</span>
                                <textarea name="content" id="content" class="form-control" placeholder="Enter content">
                                </textarea>
                                <span class="error"></span>
                            </div>
                        </div>
                    </div>
                    

                    <div class="clearfix"></div>
                    <div class="form-actions">
                        <button type="submit" class="btn blue">Submit</button>
                        <a href="{{url('admin/settings/training-sites')}}"><button type="button" class="btn default">Cancel</button></a>
                    </div>
                    <div class="clearfix"></div>
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
    CKEDITOR.replace('content');

    $(document).ready(function () {
        
        var html = jQuery("#content").text();
        //set editor data
        CKEDITOR.instances['content'].setData(html);
        $("form[name='add_form']").submit(function(e){
            e.preventDefault();
            $(document).find('span.error').empty().hide();
            var data = new FormData($('#add_form')[0])
            var content = CKEDITOR.instances['content'].getData();
            data.append('content',content);

            $.ajax({
                url: "{{url('admin/settings/training-site/store')}}", //url
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