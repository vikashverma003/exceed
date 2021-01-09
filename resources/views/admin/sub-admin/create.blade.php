@extends('admin.layouts.app')
@section('title', 'Add User')
@section('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />
@endsection
@section('content')
<!-- BEGIN PAGE HEADER-->
<div class="page-head">
    <div class="page-title">
        <h1>
            Add User
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

                    <div class="row">
                    	<div class="col-md-6">
                            <div class="form-body">
                                <div class="form-group name">
                                    <label> Name</label>&nbsp;<span style="color: red;">*</span>
                                    <input type="text" name="name" class="form-control" placeholder="Enter Name">
                                    <span class="error"></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-body">
                                <div class="form-group email">
                                    <label> Email</label>&nbsp;<span style="color: red;">*</span>
                                    <input type="text" name="email" class="form-control" placeholder="Enter Email">
                                    <span class="error"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="clearfix"></div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-body">
                                <div class="form-group password">
                                    <label> Password</label>&nbsp;<span style="color: red;">*</span>
                                    <input type="text" name="password" class="form-control" placeholder="Enter Password">
                                    <span class="error"></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div><b>Permissions</b></div>
                            <div class="form-group permissions">
                                <select class="js-example-basic-multiple form-control" name="permissions[]" multiple="multiple">
                                    @foreach($all_permissions as $row)
                                        <option value="{{$row->id}}">{{$row->title}}</option>
                                    @endforeach
                                </select>
                                <span class="error"></span>
                            </div>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    
                    <div class="form-actions">
                        <button type="button" class="btn blue form_submit_btn">Submit</button>
                        <a href="{{url('admin/sub-admin')}}"><button type="button" class="btn default">Cancel</button></a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="clearfix"></div>
</div>
<div class="clearfix"></div>

@endsection
<!-- @section('pagejs')
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
<script type="text/javascript">
    
    $(document).ready(function () {
        $('.js-example-basic-multiple').select2({
            placeholder:'Select Permission'
        });

        $(document).on('click','.form_submit_btn', function(e){
            e.preventDefault();
            $(document).find('span.error').empty().hide();
            var data = new FormData($('#add_form')[0])
            
            $.ajax({
                url: "{{url('admin/sub-admin')}}", //url
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

@endsection -->