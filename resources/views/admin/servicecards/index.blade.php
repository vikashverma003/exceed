@extends('admin.layouts.app')
@section('title', 'Service Cards')
@section('content')
    <!-- BEGIN PAGE HEADER-->
    <div class="page-head">
        <div class="page-title">
            <h1>
                Manage Service Cards Content
            </h1>
        </div>
    </div>
    <ul class="page-breadcrumb breadcrumb">
        <li>
            <i class="fa fa-circle"></i>
            <a href="{{ route('admin.dashboard') }}">Dashboard</a>
        </li>
    </ul>
    <div class="row">
        <div class="col-md-12">
            <div class="portlet light md-shadow-z-2-i">
                <div class="portlet-body form">
                    <form role="form" method="POST" name="add_form" id="add_form" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-body">
                                    <div class="form-group service_card_1_title">
                                        <label>Home Page Service Section 1st Title</label>&nbsp;<span style="color: red;">*</span>
                                        <input type="text" name="service_card_1_title" class="form-control" placeholder="Card Title" value="{{$cmsContent->service_card_1_title ?? ''}}">
                                        <span class="error"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-body">
                                    <div class="form-group service_card_2_title">
                                        <label>Home Page Service Section 2nd Title</label>&nbsp;<span style="color: red;">*</span>
                                        <input type="text" name="service_card_2_title" class="form-control" placeholder="Card Title" value="{{$cmsContent->service_card_2_title ?? ''}}">
                                        <span class="error"></span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-body">
                                    <div class="form-group service_card_3_title">
                                        <label>Home Page Service Section 3rd Title</label>&nbsp;<span style="color: red;">*</span>
                                        <input type="text" name="service_card_3_title" class="form-control" placeholder="Card Title" value="{{$cmsContent->service_card_3_title ?? ''}}">
                                        <span class="error"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-5">
                                <div class="form-body">
                                    <div class="form-group service_card_2">
                                        <label>
                                            <input type="checkbox" name="service_card_2" class="form-control" value="service_card_2" @if(@$cmsContent->service_card_2==1) checked @endif>
                                            <span class="error"></span>
                                            Home Page Service Section 2nd (Tick this if required)
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="form-body">
                                    <div class="form-group service_card_3">
                                        <label>
                                            <input type="checkbox" name="service_card_3" class="form-control" value="service_card_3" @if(@$cmsContent->service_card_3==1) checked @endif>
                                            <span class="error"></span>
                                            Home Page Service Section 3rd (Tick this if required) 
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="clearfix"></div>
                        <div class="form-actions">
                            <button type="submit" class="btn blue">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="clearfix"></div>
    </div>
    <!-- END PAGE HEADER-->
    <div class="portlet light md-shadow-z-2-i">
        <div class="portlet-title">
            <div class="caption">
                <a href="{{url('admin/servicecards/create')}}" class="btn  btn-primary pull-right black" style="margin-top: 4px;margin-right: 5px;"><i class="fa fa-plus"></i>&nbsp;&nbsp; Add Service Content</a>
            </div>
        </div>
        <div class="portlet-body">
            @include('admin.servicecards.table')
            <hr>
            @include('admin.servicecards.table2')
            <hr>
            @include('admin.servicecards.table3')
        </div>
    </div>
    <div class="clearfix"></div>
@endsection


@section('pagejs')
<script src="{{ asset('assets/js/sweetalert2@9.js') }}" type="text/javascript"></script>
<script type="text/javascript">
    $('#datatable_ajax').DataTable();
    $('#datatable2_ajax').DataTable();
    $('#datatable3_ajax').DataTable();
    $(document).ready(function () {

        $(document).on('click','.delete-record', function(e){
            Swal.fire({
              title: 'Are you sure?',
              text: "You want to change delete this!",
              showCancelButton: true,
              confirmButtonText: 'Yes, delete it!',
              cancelButtonText: 'No, cancel!',
              reverseButtons: true
            }).then((result) => {
            if (result.value) {
                var id = $(this).data("id");
                $.ajax({
                    async : false,
                    url: 'servicecards/'+id, //url
                    type: 'delete', //request method
                    data: {
                        'id':id
                    },
                    success: function(data) {
                        if(data.status){
                            show_FlashMessage(data.message,'success');
                            setTimeout(function(){ window.location.reload() }, 1000);
                        }else{
                            show_FlashMessage(data.message,'error');
                        }
                    },
                    error: function(xhr) {
                        
                    }
                });
            }
            });
        });

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
                url: "{{url('admin/service-content')}}", //url
                type: 'POST', //request method
                data: data,
                processData: false,  // Important!
                contentType: false,
                beforeSend: function() {
                    startLoader('body');
                },
                complete:function(){
                    
                },
                success: function(data) {
                    if(data.status){
                        show_FlashMessage(data.message, 'success');
                        setTimeout(function(){
                            
                            window.location.reload();
                        }, 2000);                        
                    }else{
                        stopLoader('body');
                        show_FlashMessage(data.message, 'error');
                        return false;
                    }
                },
                error: function(error){
                    stopLoader('body');
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
                }
            });
        });
    });
</script>
@endsection
