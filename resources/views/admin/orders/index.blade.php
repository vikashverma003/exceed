@extends('admin.layouts.app')
@section('title', 'Orders')
@section('css')
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/datepicker.css')}}">
@endsection
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
                Manage Orders
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
        
        <div class="portlet-body">
            @include('admin.orders.table')
        </div>
    </div>
    <div class="clearfix"></div>
@endsection


@section('pagejs')
<script src="{{ asset('assets/js/datepicker.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/js/sweetalert2@9.js') }}" type="text/javascript"></script>
<script type="text/javascript">
    var filter_data = $("form[name=filter_listing]").serialize();
    var jqxhr = {abort: function () {  }};

    $(document).ready(function () {


        var $startDate = $("#from_date");
        var $endDate = $("#to_date");

        $startDate.datepicker({
            autoHide: true,
            format: "dd/mm/yyyy"
        });
        $endDate.datepicker({
            autoHide: true,
            format: "dd/mm/yyyy",
            startDate: $startDate.datepicker('getDate'),
        });

        $startDate.on('change', function () {
            $endDate.datepicker('setStartDate', $startDate.datepicker('getDate'));
            loadListings(full_path + '/orders/?page=', 'filter_listing');
        });

        $endDate.on('change', function () {
            $startDate.datepicker('setEndDate', $endDate.datepicker('getDate'));
            loadListings(full_path + '/orders/?page=', 'filter_listing');
        });
        
        $(document).on('keyup', '#discount, #email, #amount,#order_id', function () {
            loadListings(full_path + '/orders/?page=', 'filter_listing');
        });

        $(document).on('change', '#filterStatus,#filterRole', function () {
            loadListings(full_path + '/orders/?page=', 'filter_listing');
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
                success : function(data){
                    data = data.trim();
                    $("#dynamicContent").empty().html(data);
                },
                error : function(response){
                    stopLoader('.page-content');
                    //console.log('Error',"Unable to fetch the list");
                },
                complete:function(){
                    stopLoader('.page-content');
                }
            });
        }

        // reset form data
        $(document).on('click', '.filter-cancel', function (e) {
            e.preventDefault();
            $("form[name='filter_listing']")[0].reset();
            loadListings(full_path +'/orders/?page=', 'filter_listing');
        });
    });
</script>
@endsection
