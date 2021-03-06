@extends('admin.layouts.app')
@section('title', 'Training Sub-Categories')
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
                Manage Training Sub-Categories
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
    <div class="portlet light md-shadow-z-2-i">
        <div class="portlet-title">
            <div class="caption">
                <a href="javascript:;" class="btn  btn-primary pull-right black add_sub_category" style="margin-top: 4px;margin-right: 5px;"><i class="fa fa-plus"></i>&nbsp;&nbsp; Add Sub-Category</a>
            </div>
        </div>
        <div class="portlet-body">
            @include('admin.categories.subcategories.table')
        </div>
    </div>

    <div id="myModal" class="modal fade" role="dialog" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog" style="max-width: 40%">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title" style="text-align: center;">Add Sub Category</h4>
                </div>
                <div class="modal-body">
                    <form method="post" name="add_sub_category_form" id="add_sub_category_form" onsubmit="addSubCategory()">
                        @csrf
                        <input type="hidden" name="category_id" value="{{$category_id}}">
                        <div class="form-group name">
                            <label for="recipient-name" class="col-form-label">Sub-Category Name :</label>
                            <input type="text" class="form-control" name="name" required="true"> 
                            <span class="error"></span>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary add_sub_category_btn">Save</button>
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

    $(document).ready(function () {
        $('#myModal').on('hidden.bs.modal', function (e) {
            $('#add_sub_category_form').find('input[name="name"]').val('');
        });

        // add sub category
        $(document).on('click','.add_sub_category', function(){
            $('#myModal').modal('show');
        });


        $('#add_sub_category_form').on('submit', function(e){
            e.preventDefault();
            addSubCategory();
        });


        // add sub category
        $(document).on('click','.add_sub_category_btn', function(e){
            e.preventDefault();
            addSubCategory();
        });

        function addSubCategory(){
            $(document).find('span.error').empty().hide();
            $.ajax({
                async : false,
                url: "{{url('admin/subcategory/add')}}", //url
                type: 'post', //request method
                data: {
                    'category_id':$('#add_sub_category_form').find('input[name="category_id"]').val(),
                    'name':$('#add_sub_category_form').find('input[name="name"]').val(),
                },
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
                            window.location = data.url; 
                        }, 1000);
                    }else{
                        show_FlashMessage(data.message,'error');
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
                    url: 'category/status', //url
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
    });

    const showDesc =  function(data){
        $('.modal').modal('show');
        $('.modal_content').html($(data).data('desc'));
    }
</script>
@endsection
