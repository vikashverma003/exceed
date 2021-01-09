@extends('admin.layouts.app')
@section('title', 'Manage Coupons')
@section('content')
    <style type="text/css">
    .modal-dialog{
        width: 800px;
    }
    .dataTables_empty{
        text-align: center !important;
    }
    .logo-td{
        padding-top: 24px !important;
    }
    .btn + .btn {
         margin-left: 0px !important; 
    }
    .width-50{
        width: 50% !important;
    }
    td {
        font-size:14px;
    }
    </style>
    <!-- BEGIN PAGE HEADER-->
    <div class="page-head">
        <div class="page-title">
            <h1>
                Manage Coupons
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
    <div class="portlet light md-shadow-z-2-i">
        <div class="portlet-title">
            <div class="caption">
                <a href="javascript:;" class="btn  btn-primary pull-right black add-record" style="margin-top: 4px;margin-right: 5px;"><i class="fa fa-plus"></i>&nbsp;&nbsp; Add Coupon</a>
            </div>
        </div>
        <div class="portlet-body">
            @include('admin.coupons.table')
        </div>
    </div>

    <div id="myModal" class="modal fade" role="dialog" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog" style="max-width: 40%">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title" style="text-align: center;">Add Coupon</h4>
                </div>
                <div class="modal-body">
                    <form method="post" name="add_form" id="add_form" onsubmit="addForm()">
                        @csrf
                        <div class="form-group code">
                            <label for="recipient-name" class="col-form-label">Code :</label>
                            <input type="text" class="form-control" name="code" required="true"> 
                            <span class="error"></span>
                        </div>

                        <div class="row">
                        	<div class="col-md-6">
                        		<div class="form-group limit">
		                            <label for="recipient-name" class="col-form-label">No. of Usage Limits :</label>
		                            <input type="text" class="form-control" name="limit" required="true"> 
		                            <span class="error"></span>
		                        </div>
                        	</div>
                        	<div class="col-md-6">
                        		<div class="form-group user_type">
		                            <label for="recipient-name" class="col-form-label">User Type :</label>
		                            <select name="user_type" class="form-control user_type_select">
		                                <option value="">Select</option>
		                                <option value="indivisual">Individual</option>
		                                <option value="corporate">Corporate</option>
		                            </select>
		                            <span class="error"></span>
		                        </div>
                        	</div>
                        </div>

                        <div class="form-group user">
                            <label for="recipient-name" class="col-form-label">User Email:</label>
                            <select name="user" class="form-control user_email_select">
                                <option value="">Select User</option>
                            </select>
                            <span class="error"></span>
                        </div>
                        <div class="row">
                        	<div class="col-md-6">
                        		<div class="form-group discount">
		                            <label for="recipient-name" class="col-form-label">Discount :</label>
		                            <input type="text" class="form-control" name="discount" required="true"> 
		                            <span class="error"></span>
		                        </div>
                        	</div>
                        	<div class="col-md-6">
                        		<div class="form-group expiry_date">
		                            <label for="recipient-name" class="col-form-label">Expiry Date :</label>
		                            <input type="text" class="form-control datepicker" readonly="" name="expiry_date" required="true"> 
		                            <span class="error"></span>
		                        </div>
                        	</div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary add_form_btn">Save</button>
                </div>
            </div>
        </div>
    </div>

    <div id="myEditModal" class="modal fade" role="dialog" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog" style="max-width: 40%">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title" style="text-align: center;">Edit Coupon</h4>
                </div>
                <div class="modal-body">
                    <form method="post" name="edit_form" id="edit_form" onsubmit="editForm()">
                        <input type="hidden" name="id" value=""> 
                        <input type="hidden" name="_method" value="put">
                        @csrf
                        <div class="form-group code">
                            <label for="recipient-name" class="col-form-label">Code :</label>
                            <input type="text" class="form-control" name="code" required="true" disabled="" readonly=""> 
                            <span class="error"></span>
                        </div>

                        <div class="form-group limit">
                            <label for="recipient-name" class="col-form-label">No. of Usage Limits :</label>
                            <input type="text" class="form-control" name="limit" required="true"> 
                            <span class="error"></span>
                        </div>

                        <div class="form-group user">
                            <label for="recipient-name" class="col-form-label">User Email:</label>
                            <input type="text" class="form-control" name="user" required="true" disabled="" readonly=""> 
                            <span class="error"></span>
                        </div>
                        <div class="form-group discount">
                            <label for="recipient-name" class="col-form-label">Discount :</label>
                            <input type="text" class="form-control" name="discount" required="true"> 
                            <span class="error"></span>
                        </div>

                        <div class="form-group expiry_date">
                            <label for="recipient-name" class="col-form-label">Expiry Date :</label>
                            <input type="text" class="form-control datepicker" readonly="" name="expiry_date" required="true"> 
                            <span class="error"></span>
                        </div>

                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary edit_form_btn">Save</button>
                </div>
            </div>
        </div>
    </div>
    <div class="clearfix"></div>
@endsection


@section('pagejs')
<script src="{{ asset('assets/js/sweetalert2@9.js') }}" type="text/javascript"></script>
<script type="text/javascript">

    $('#datatable_ajax').DataTable();
    var jqxhr = {abort: function () {  }};
    $('.datepicker').datepicker({
        'minDate': new Date(),
        'dateFormat':'dd/mm/yy'
    });

    $(document).ready(function () {
        $('#myModal,#myEditModal').on('hidden.bs.modal', function (e) {
            $('#add_form')[0].reset();
            $('#edit_form')[0].reset();
        });

        // add sub category
        $(document).on('click','.add-record', function(){
            $('#myModal').modal('show');
        });

        $(document).on('click','.edit-record', function(){
            var id = $(this).data('id');
            var code = $(this).data('code');
            var limit = $(this).data('limit');
            var used = $(this).data('used');
            var email = $(this).data('email');
            var discount = $(this).data('discount');
            var expired = $(this).data('expired');
            $('#myEditModal').find('input[name="id"]').val(id);
            $('#myEditModal').find('input[name="code"]').val(code);
            $('#myEditModal').find('input[name="limit"]').val(limit);
            $('#myEditModal').find('input[name="user"]').val(email);
            $('#myEditModal').find('input[name="expiry_date"]').val(expired);
            $('#myEditModal').find('input[name="discount"]').val(discount);

            $('#myEditModal').modal('show');
        });

        $(document).on('change','.user_type_select', function(){
        	var val = $(this).val();
        	if(!val){
        		return false;
        	}
        	$.ajax({
                async : true,
                url: "{{url('admin/coupon/user')}}", //url
                type: 'get', //request method
                data: {
                	'val':val
                },
                // processData: false,  // Important!
                // contentType: false,
                beforeSend:function(){
                    startLoader('.modal-content');
                },
                complete:function(){
                    stopLoader('.modal-content');
                },
                success: function(data) {
                    if(data.status){
                    	var html='<option value="">Select Email</option>';
                        $.each(data.data, function(key, value){
                        	html+='<option value="'+value.id+'">'+value.email+'</option>';
                        });
                        $('.user_email_select').html(html);
                    }else{
                        show_FlashMessage(data.message,'error');
                        return false;
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

        $(document).on('click','.add_form_btn', function(e){
            e.preventDefault();
            $(document).find('span.error').empty().hide();
            var formdata = new FormData($('#add_form')[0]);

            $.ajax({
                async : true,
                url: "{{url('admin/coupons')}}", //url
                type: 'post', //request method
                data: formdata,
                processData: false,  // Important!
                contentType: false,
                beforeSend:function(){
                    startLoader('.modal-content');
                },
                complete:function(){
                    
                },
                success: function(data) {
                    if(data.status){
                        show_FlashMessage(data.message,'success');
                        setTimeout(function(){ 
                            window.location.reload(); 
                        }, 1000);
                    }else{
                        console.log("message");
                        console.log(data.message);
                        show_FlashMessage(data.message,'error');
                        stopLoader('.modal-content');
                        return false;
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
                    stopLoader('.modal-content');
                }
            });
        });

        $(document).on('click','.edit_form_btn', function(e){
            e.preventDefault();
            $(document).find('span.error').empty().hide();
            var formdata = new FormData($('#edit_form')[0]);
            var id = $('#edit_form').find('input[name="id"]').val();

            $.ajax({
                async : true,
                url: "{{url('admin/coupons')}}"+'/'+id, //url
                type: 'post', //request method
                data: formdata,
                processData: false,  // Important!
                contentType: false,
                beforeSend:function(){
                    startLoader('.modal-content');
                },
                complete:function(){
                    stopLoader('.modal-content');
                },
                success: function(data) {
                    if(data.status){
                        show_FlashMessage(data.message,'success');
                        setTimeout(function(){ 
                            window.location.reload(); 
                        }, 1000);
                    }else{
                        show_FlashMessage(data.message,'error');
                        return false;
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

        $(document).on('click','.change-status', function(e){
            Swal.fire({
              title: 'Are you sure?',
              text: "You want to change status!",
              showCancelButton: true,
              confirmButtonText: 'Yes, change it!',
              cancelButtonText: 'No, cancel!',
              reverseButtons: true
            }).then((result) => {
            if (result.value) {
                var id = $(this).data("id");
                var status = $(this).data("status");
                $.ajax({
                    async : true,
                    url: 'coupon/status', //url
                    type: 'post', //request method
                    data: {'status':status,'update':'status','id':id},
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

        $(document).on('click','.delete-record', function(e){
            Swal.fire({
              title: 'Are you sure?',
              text: "You want to delete this!",
              showCancelButton: true,
              confirmButtonText: 'Yes, delete it!',
              cancelButtonText: 'No, cancel!',
              reverseButtons: true
            }).then((result) => {
            if (result.value) {
                var id = $(this).data("id");
                $.ajax({
                    async : true,
                    url: "{{url('admin/coupons')}}"+'/'+id, //url
                    type: 'post', //request method
                    data: {'id':id,'_method':'delete'},
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
    });
</script>
@endsection
