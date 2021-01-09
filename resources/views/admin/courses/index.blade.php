@extends('admin.layouts.app')
@section('title', 'Products')

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
        width: 250px;
    }
    </style>
    <!-- BEGIN PAGE HEADER-->
    <div class="page-head">
        <div class="page-title">
            <h1>
                Manage Products
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
                <a href="{{url('admin/courses/create')}}" class="btn  btn-primary pull-left black" style="margin-top: 4px;margin-right: 5px;"><i class="fa fa-plus"></i>&nbsp;&nbsp; Add Product</a>

                <a href="javascript:;" class="btn  btn-primary pull-right black print" style="margin-top: 4px;margin-right: 5px;"><i class="fa fa-cloud-download"></i>&nbsp;&nbsp;Download CSV</a>

                
            </div>
        </div>
        <div class="portlet-body">
            <div id="dashboard-report-range" class="pull-right tooltips btn btn-fit-height grey-salt" data-placement="top" data-original-title="Change dashboard date range" style="color: black">
                    <i class="icon-calendar"></i>&nbsp; <span class="thin uppercase visible-lg-inline-block"></span>&nbsp; <i class="fa fa-angle-down"></i>
            </div>

            <div class="table-responsive" style="width: 100%;max-width: 100%;overflow-x: scroll;">
                @include('admin.courses.table')
            </div>
        </div>
    </div>
    <div class="clearfix"></div>
    @include('admin.courses.locations')
@endsection


@section('pagejs')
<script src="{{ asset('assets/js/datepicker.js') }}" type="text/javascript"></script>

<script src="{{ asset('assets/js/sweetalert2@9.js') }}" type="text/javascript"></script>
<script type="text/javascript">
     var filter_data = $("form[name=filter_listing]").serialize();
    var jqxhr = {abort: function () {  }};
    var start = moment().subtract(29, 'days');
    var end = moment();
    const showDesc =  function(data){
        var course_id = $(data).data('id');

        $.ajax({
            async : true,
            url:"{{url('admin/course/schedule')}}", //url
            type: 'get', //request method
            data: {
                'course_id':course_id,
            },
            beforeSend:function(){
                startLoader('body');
            },
            complete:function(){
                stopLoader('body');
            },
            success: function(data) {
                if(data.status)
                {
                    var html='';
                    if(data.data.length>0)
                    {
                        $.each(data.data, function(key, value){
                            html+='<tr>\
                            <td>'+value.country+'</td>\
                            <td>'+value.city+'</td>\
                            <td>'+value.location+'</td>\
                            <td>'+value.training_type+'</td>\
                            <td>'+value.start_date+'</td>\
                            <td>'+value.end_date+'</td>\
                            <td>'+value.start_time+' - '+value.end_time+'</td>';
                            html+='</tr>';
                        });
                        $('.yes_location').show();
                        $('.no_location').hide();
                    }else
                    {
                        html='<tr>\
                            <td>N/A</td>\
                            <td>N/A</td>\
                            <td>N/A</td>\
                            <td>N/A</td>\
                            <td>N/A</td>\
                            <td>N/A</td>\
                        </tr>';
                        $('.no_location').show();
                        $('.yes_location').hide();
                    }
                    $('.course_location_body').html(html);
                    $('#courseLocationModal').modal('show');
                }else
                {

                }
            },
            error: function(xhr) {
                
            }
        });
    }
    function upperFilterManufacturers(obj)
    {
        var id = [$(obj).val()];
        $.ajax({
            url: '/advance-filter-manufactuer-data', //url
            type: 'get', //request method
            data: {
                'manufacturer':id ? id : [],
            },
            beforeSend:function(){
                startLoader('.page-content');
            },
            complete:function(){
                stopLoader('.page-content');
            },
            success: function (data) {
                console.log(data);
                if(data.status){
                    $('#category_name').find('option').remove();
                    $('#product_name').find('option').remove();
                    $('#category_name').append("<option value=''>Select</option>");
                    $('#product_name').append("<option value=''>Select</option>");
                    data.categories.forEach(appendCategories);
                    data.courses.forEach(appendProductFamily);
                                
                }
            },
            error:function(data){
                stopLoader('.page-content');
            }
        });
    }
    function upperFilterCategories(obj)
    {
        var category_id = [$(obj).val()];
        // var manufacturer_id = $('#manufacturer_name').val();
        var id = [$('#manufacturer_name').val()];
        $.ajax({
            url: '/advance-filter-catgory-data', //url
            type: 'get', //request method
            data: {
                'manufacturer':id ? id: [],
                'category':category_id ? category_id : []
            },
            beforeSend:function(){
                startLoader('.page-content');
            },
            complete:function(){
                stopLoader('.page-content');
            },
            success: function(data) {
                if(data.status){
                    $('#product_name').find('option').remove();
                    $('#product_name').append("<option value=''>Select</option>");
                    data.courses.forEach(appendProductFamily);
                }
            },
            error:function(data){
                stopLoader('.page-content');
            }
        });
    }
    function appendCategories(item, index) {
        $('#category_name').append("<option value='"+item.id+"'>"+item.name+"</option>");
    }
    function appendProductFamily(item, index) {
        $('#product_name').append("<option value='"+item.id+"'>"+item.name+"</option>");
    }
    $(document).ready(function () {


        function cb(start, end) {
            $('#dashboard-report-range span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
            
            $('input[name="start"]').val(start.format('DD/MM/YYYY'))
            $('input[name="end"]').val(end.format('DD/MM/YYYY'))
            loadListings(full_path + '/courses/?page=', 'filter_listing');
        }

        $('#dashboard-report-range').daterangepicker({
            startDate: start,
            endDate: end,
            ranges: {
               'Today': [moment(), moment()],
               'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
               'Last 7 Days': [moment().subtract(6, 'days'), moment()],
               'Last 30 Days': [moment().subtract(29, 'days'), moment()],
               'This Month': [moment().startOf('month'), moment().endOf('month')],
               'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
               'This Year': [moment().startOf('year'), moment()],
               'Last Year': [moment().subtract(1, 'year').startOf('year'), moment().subtract(1, 'year').endOf('year')],
            }
        }, cb);

        // cb(start, end);

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
            loadListings(full_path + '/courses/?page=', 'filter_listing');
        });

        $endDate.on('change', function () {
            $startDate.datepicker('setEndDate', $endDate.datepicker('getDate'));
            loadListings(full_path + '/courses/?page=', 'filter_listing');
        });

        $(document).on('click','.print', function(){
            var filtering = $("form[name=filter_listing]").serialize();
            $.ajax({
                type : 'get',
                url : full_path+'/courses-export',
                data : filtering,
          
                beforeSend:function(){
                    startLoader('.page-content');
                },
                success : function(data){
                    
                    var downloadLink = document.createElement("a");
                    var fileData = ['\ufeff'+data];

                    var blobObject = new Blob(fileData,{
                        type: "text/csv;charset=utf-8;"
                    });

                    var url = URL.createObjectURL(blobObject);
                    downloadLink.href = url;
                    console.log(url)
                    downloadLink.download = "report.csv";
                    document.body.appendChild(downloadLink);
                    downloadLink.click();
                    document.body.removeChild(downloadLink);
                },
                error : function(response){

                    stopLoader('.page-content');
                    show_FlashMessage(response.responseJSON.message,'error');
                    return false;
                },
                complete:function(){
                    stopLoader('.page-content');
                }
            });
        });
        
        $(document).on('click','.change-status', function(e){
            var status = $(this).data("status");
            if(status==1){
                var text="You want to Publish this course?"
            }else{
                var text="You want to Unpublish this course?"
            }
            
            Swal.fire({
              title: 'Are you sure?',
              text: text,
              showCancelButton: true,
              confirmButtonText: 'Yes',
              cancelButtonText: 'No',
              reverseButtons: true
            }).then((result) => {
            if (result.value) {
                var id = $(this).data("id");
                
                $.ajax({
                    async : false,
                    url:"{{url('admin/course/status')}}", //url
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
                    async : false,
                    url: "{{url('admin/courses')}}"+'/'+id, //url
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

        $(document).on('keyup', '#name', function () {
            if($(this).val().length > 2)
            {
                loadListings(full_path + '/courses?page=', 'filter_listing');
            }

            if($(this).val().length == 0)
            {
                loadListings(full_path + '/courses/?page=', 'filter_listing');
            }
        });

        $(document).on('change', '#filterStatus,#category_name,#manufacturer_name,#product_name', function () {
            loadListings(full_path + '/courses/?page=', 'filter_listing');
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
            $('input[name="start"]').val('');
            $('input[name="end"]').val('');
            $('#dashboard-report-range span').html(' - ');
            loadListings(full_path +'/courses/?page=', 'filter_listing');
        });

    });
</script>
@endsection
