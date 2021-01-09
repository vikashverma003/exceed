@extends('admin.layouts.app')
@section('title', 'Customers')

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
                Manage Customers
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
            <div class="caption pull-right">
                <a href="javascript:;" class="btn  btn-primary pull-right black print" style="margin-top: 4px;margin-right: 5px;"><i class="fa fa-cloud-download"></i>&nbsp;&nbsp;Download CSV</a>
            </div>
        </div>
        <div class="portlet-body">
            <div class="table-responsive" style="width: 100%;max-width: 100%;overflow-x: scroll;">
                @include('admin.users.table')
            </div>
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
	        loadListings(full_path + '/users/?page=');
	    });

	    $endDate.on('change', function () {
	        $startDate.datepicker('setEndDate', $endDate.datepicker('getDate'));
	        loadListings(full_path + '/users/?page=');
	    });

	    $(document).on('click','.print', function(){
	    	var filtering = $("form[name=filter_listing]").serialize();
           	$.ajax({
                type : 'get',
                url : full_path+'/users/export',
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
                    url: 'user/status', //url
                    type: 'post', //request method
                    data: {'status':status,'update':'status','id':id},
                    success: function(data) {
                        if(data.status){
                            loadListings(full_path + '/users?page=');
                            show_FlashMessage(data.message,'success');
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

        $(document).on('keyup', '#name, #email, #phone', function () {
            if($(this).val().length > 2)
            {
                loadListings(full_path + '/users?page=');
            }

            if($(this).val().length == 0)
            {
                loadListings(full_path + '/users/?page=');
            }
        });

        $(document).on('change', '#filterStatus,#filterRole', function () {
            loadListings(full_path + '/users/?page=');
        });

        $(document).on("click", ".pagination li a", function (e){
            e.preventDefault();
            startLoader('.page-content');
            var url = $(this).attr('href');
            var page = url.split('page=')[1];   ;       
            loadListings(url);
        });

        function loadListings(url){

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
            loadListings(full_path +'/users/?page=');
        });
    });
</script>
@endsection
