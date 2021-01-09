@extends('admin.layouts.app')
@section('title', 'Training Sites Content')
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
                Manage Training Sites Content
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
                <a href="{{url('admin/settings/training-site/create')}}" class="btn  btn-primary pull-right black" style="margin-top: 4px;margin-right: 5px;"><i class="fa fa-plus"></i>&nbsp;&nbsp; Add Training Site Content</a>
            </div>
        </div>
        <div class="portlet-body">
            @include('admin.settings.training-sites.table')
        </div>
    </div>
    <div class="clearfix"></div>
@endsection


@section('pagejs')

<script src="{{ asset('assets/js/sweetalert2@9.js') }}" type="text/javascript"></script>
<script type="text/javascript">
    const datatable = $('#datatable_ajax').DataTable();
    var jqxhr = {abort: function () {  }};

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
                    url: '{{url("admin/settings/training-site/status")}}', //url
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
</script>
@endsection
