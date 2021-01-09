@extends('admin.layouts.app')
@section('title', 'Manage Training Types')
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
                Manage Training Types
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
                <a href="javascript:;" class="btn  btn-primary pull-right black add-record" style="margin-top: 4px;margin-right: 5px;"><i class="fa fa-plus"></i>&nbsp;&nbsp; Add Training Type</a>
            </div>
        </div>
        <div class="portlet-body">
            @include('admin.training_types.table')
        </div>
    </div>
    <div id="myModal" class="modal fade" role="dialog" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog" style="max-width: 40%">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title" style="text-align: center;">Add Training Type</h4>
                </div>
                <div class="modal-body">
                    <form method="post" name="add_form" id="add_form" onsubmit="addForm()">
                        @csrf
                        <input type="hidden" name="formval" value="">
                        <div class="form-group name">
                            <label for="recipient-name" class="col-form-label">Name :</label>
                            <input type="text" class="form-control" name="name" required="true"> 
                            <span class="error"></span>
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
                    <h4 class="modal-title" style="text-align: center;">Edit Training Type</h4>
                </div>
                <div class="modal-body">
                    <form method="post" name="edit_form" id="edit_form" onsubmit="editForm()">
                        <input type="hidden" name="id" value=""> 
                        <input type="hidden" name="_method" value="put">
                        @csrf
                        <div class="form-group name">
                            <label for="recipient-name" class="col-form-label">Name :</label>
                            <input type="text" class="form-control" name="name" required="true"> 
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
    
    const addForm = function(e){
		e.preventDefault();
		if(e && e.keyCode == 13) {
			return false;	
		}
		addRecord();
		
    }
    const editForm = function(e){
         e.preventDefault();
        editRecord();
    }
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
            var location = $(this).data('name');
            $('#myEditModal').find('input[name="id"]').val(id);
            $('#myEditModal').find('input[name="name"]').val(location);
            $('#myEditModal').modal('show');
        });


        $(document).on('click','.add_form_btn', function(e){
            e.preventDefault();
            addRecord();
        });

        function addRecord() {
            $(document).find('span.error').empty().hide();
            var formdata = new FormData($('#add_form')[0]);

            $.ajax({
                async : false,
                url: "{{url('admin/training-types')}}", //url
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
                    stopLoader('.modal-content');
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
                    
                }
            });
        }

        $(document).on('click','.edit_form_btn', function(e){
            e.preventDefault();
            editRecord();
        });
        
        function editRecord(){
            $(document).find('span.error').empty().hide();
            var formdata = new FormData($('#edit_form')[0]);
            var id = $('#edit_form').find('input[name="id"]').val();

            $.ajax({
                async : false,
                url: "{{url('admin/training-types')}}"+'/'+id, //url
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
                    stopLoader('.modal-content');
                }
            });
        }
        
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
                    async : false,
                    url: 'training-type/status', //url
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

        // $(document).on('click','.delete-record', function(e){
        //     Swal.fire({
        //       title: 'Are you sure?',
        //       text: "You want to delete this!",
        //       showCancelButton: true,
        //       confirmButtonText: 'Yes, delete it!',
        //       cancelButtonText: 'No, cancel!',
        //       reverseButtons: true
        //     }).then((result) => {
        //     if (result.value) {
        //         var id = $(this).data("id");
        //         $.ajax({
        //             async : false,
        //             url: "{{url('admin/locations')}}"+'/'+id, //url
        //             type: 'post', //request method
        //             data: {'id':id,'_method':'delete'},
        //             success: function(data) {
        //                 if(data.status){
        //                     show_FlashMessage(data.message,'success');
        //                     setTimeout(function(){ window.location.reload() }, 1000);
        //                 }else{
        //                     show_FlashMessage(data.message,'error');
        //                 }
        //             },
        //             error: function(xhr) {
                        
        //             }
        //         });
        //     }
        //     });
        // });
    });
</script>
@endsection
