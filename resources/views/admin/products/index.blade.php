@extends('admin.layouts.app')
@section('title', 'Products Family Listing')
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
                Manage Products Family
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
                <a href="{{url('admin/products/create')}}" class="btn  btn-primary pull-right black" style="margin-top: 4px;margin-right: 5px;"><i class="fa fa-plus"></i>&nbsp;&nbsp; Add Product Family</a>
            </div>
        </div>
        <div class="portlet-body">
            @include('admin.products.table')
        </div>
    </div>
    <div id="myModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title" style="text-align: center;">Description</h4>
                </div>
                <div class="modal-body">
                    <p class="modal_content"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <div class="clearfix"></div>
@endsection


@section('pagejs')

<script src="{{ asset('assets/js/sweetalert2@9.js') }}" type="text/javascript"></script>
<script type="text/javascript">
    var filter_data = $("form[name=filter_listing]").serialize();
    var jqxhr = {abort: function () {  }};

    const showDesc =  function(data){
        $('.modal').modal('show');
        $('.modal_content').html($(data).data('desc'));
    }

    $(document).ready(function () {

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
                    url:"{{url('admin/product/status')}}", //url
                    type: 'post', //request method
                    data: {
                        'status':status,
                        'update':'status',
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
                    beforeSend:function(){
                        startLoader('body');
                    },
                    complete:function(){
                        stopLoader('body');
                    },
                    url: "{{url('admin/products')}}"+'/'+id, //url
                    type: 'post', //request method
                    data: {'id':id,'_method':'delete'},
                    success: function(data) {
                        if(data.status){
                            show_FlashMessage(data.message,'success');
                            setTimeout(function(){ window.location.reload() }, 1000);
                        }else{
                            show_FlashMessage(data.message,'error');
                            stopLoader('body');
                        }
                    },
                    error: function(xhr) {
                        stopLoader('body');
                        
                    }
                });
            }
            });
        });

        $(document).on('keyup', '#name', function () {
            if($(this).val().length > 2)
            {
                loadListings(full_path + '/products?page=', 'filter_listing');
            }

            if($(this).val().length == 0)
            {
                loadListings(full_path + '/products/?page=', 'filter_listing');
            }
        });

        $(document).on('change', '#filterStatus,#category_name,#manufacturer_name', function () {
            loadListings(full_path + '/products/?page=', 'filter_listing');
        });

        $(document).on("click", ".pagination li a", function (e){
            e.preventDefault();
            startLoader('.page-content');
            var url = $(this).attr('href');
            var page = url.split('page=')[1];   ;       
            loadListings(url, 'filter_listing');
        });

        function loadListings(url,filter_form_name){

            var filtering = $("form[name=filter_listing]").serialize();
            //abort previous ajax request if any
            jqxhr.abort();
            jqxhr =$.ajax({
                type : 'get',
                url : url,
                data : filtering,
                dataType : 'html',
                beforeSend:function(){
                    startLoader('.page-content');
                },
                complete:function(){
                    stopLoader('.page-content');
                },
                success : function(data){
                    data = data.trim();
                    $("#dynamicContent").empty().html(data);
                },
                error : function(response){
                    stopLoader('.page-content');
                    //console.log('Error',"Unable to fetch the list");
                },
                
            });
        }

        // reset form data
        $(document).on('click', '.filter-cancel', function (e) {
            e.preventDefault();
            $("form[name='filter_listing']")[0].reset();
            loadListings(full_path +'/products/?page=', 'filter_listing');
        });
    });
</script>
@endsection
