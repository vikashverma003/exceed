@extends('admin.layouts.app')
@section('title', 'Permissions')

@section('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />
@endsection

@section('content')
<!-- BEGIN PAGE HEADER-->
<div class="page-head">
    <div class="page-title">
        <h1>
            Permissions
        </h1>
    </div>
</div>
<ul class="page-breadcrumb breadcrumb">
    <li>
       <i class="fa fa-circle"></i>
        <a href="{{ route('admin.dashboard') }}">Dashboard</a>
        <i class="fa fa-circle"></i>
        <a href="{{ url('admin/sub-admin') }}">Users Listing</a>
    </li>
</ul>
<!-- END PAGE HEADER-->
<div class="row">
    <div class="col-md-12">
        <div class="portlet light md-shadow-z-2-i">
            <div class="portlet-body form">

                <form role="form" method="POST" name="add_form" id="add_form" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id" value="{{$user->id}}">

                    <div class="row">
                        <div class="form-group">
                            <div class="col-md-12 field-holder">
                                <div class="checkbox-list">
                                        <label class="checkbox-inline">
                                            <input type="checkbox" name="lead_permissions[]" id="leads_name_title" value="leads_name_title" @if(in_array('leads_name_title', $all_permissions)) checked="true" @endif /> Name Title</label>
                                        <label class="checkbox-inline"><input type="checkbox" name="lead_permissions[]"  id="leads_first_name" value="leads_first_name" @if(in_array('leads_first_name', $all_permissions)) checked="true" @endif /> First Name</label>
                                        <label class="checkbox-inline"><input type="checkbox" name="lead_permissions[]" id="leads_last_name" value="leads_last_name" @if(in_array('leads_last_name', $all_permissions)) checked="true" @endif /> Last Name</label>
                                        <label class="checkbox-inline"><input type="checkbox" name="lead_permissions[]" id="leads_email" value="leads_email" @if(in_array('leads_email', $all_permissions)) checked="true" @endif /> Email</label>
                                        
                                    </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <select class="js-example-basic-multiple form-control" name="permissions[]" multiple="multiple">
                              <option value="AL">Alabama</option>
                                ...
                              <option value="WY">Wyoming</option>
                            </select>
                        </div>
                    </div>

                    <div class="clearfix"></div>
                    
                    <div class="form-actions">
                        <button type="button" class="btn blue form_submit_btn">Submit</button>
                        <a href="{{url('admin/sub-admin')}}"><button type="button" class="btn default">Cancel</button></a>
                    </div>
                </form>

            </div>
            <div class="clearfix"></div>
        </div>
    </div>
    <div class="clearfix"></div>
</div>
<div class="clearfix"></div>
@endsection
@section('pagejs')
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
<script type="text/javascript">

    $(document).ready(function () {
        $('.js-example-basic-multiple').select2();


        $(document).on('click','.form_submit_btn', function(e){
            e.preventDefault();
            $(document).find('span.error').empty().hide();
            var data = new FormData($('#add_form')[0])
            
            var id = "{{$user->id}}";
            $.ajax({
                url: "{{url('admin/sub-admin')}}"+'/'+id, //url
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