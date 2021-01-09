@extends('admin.layouts.app')
@section('title','Dashboard')
@section('content')
<!-- BEGIN PAGE HEADER-->

<h4>
    @include('flash::message')
</h4>
<div class="page-head" style="background-color: #8f8282 !important;margin-bottom: 5px;">
    <div class="page-title">
        <h1 style="color: white !important; margin-left: 10px;">Dashboard</h1>
    </div>
</div>
<!-- END PAGE HEADER-->
<!-- BEGIN DASHBOARD STATS -->
<div class="row">
    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 ">
        <div class="dashboard-stat blue-madison">
            <div class="visual">
                <i class="icon-user"></i>
            </div>
            <div class="details">
                <div class="number">
                    {{isset($data['users']) ? $data['users'] : 0 }}
                </div>
                <div class="desc">
                    Total Active Customers
                </div>
            </div>
            @if(helperCheckPermission('customer_management_access'))
            <a class="more" href="{{url('admin/users')}}">
            View more <i class="m-icon-swapright m-icon-white"></i>
            </a>
            @else
           <a class="more"><i class="m-icon-swapright m-icon-white"></i>
            </a>
            @endif
        </div>
    </div>
    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <div class="dashboard-stat red-intense">
            <div class="visual">
                <i class="fa fa-bar-chart-o"></i>
            </div>
            <div class="details">
                <div class="number">
                  {{isset($data['courses']) ? $data['courses'] : 0 }}
                </div>
                <div class="desc">
                    Total Courses
                </div>
            </div>
            @if(helperCheckPermission('courses_management_access'))
            <a class="more" href="{{url('admin/courses')}}">
            View more <i class="m-icon-swapright m-icon-white"></i>
              @else
           <a class="more"> <i class="m-icon-swapright m-icon-white"></i>
            </a>
            @endif
            </a>
        </div>
    </div>

    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <div class="dashboard-stat green-haze">
            <div class="visual">
                <i class="fa fa-globe"></i>
            </div>
            <div class="details">
                <div class="number">
                    {{isset($data['manufacturers']) ? $data['manufacturers'] : 0 }}
                </div>
                <div class="desc">
                     Total Active Manufacturers
                </div>
            </div>
            @if(helperCheckPermission('manufactuers_management_access'))
            <a class="more" href="{{url('admin/manufacturers')}}">
            View more <i class="m-icon-swapright m-icon-white"></i>
            </a>
              @else
           <a class="more"> <i class="m-icon-swapright m-icon-white"></i>
            </a>
            @endif
        </div>
    </div>

    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <div class="dashboard-stat purple-plum">
            <div class="visual">
                <i class="fa fa-globe"></i>
            </div>
            <div class="details">
                <div class="number">
                     {{isset($data['quotes']) ? $data['quotes'] : 0 }}
                </div>
                <div class="desc">
                     Quotes Queries
                </div>
            </div>
            @if(helperCheckPermission('queries_management_access'))
            <a class="more" href="{{url('admin/quotes')}}">
            View more <i class="m-icon-swapright m-icon-white"></i>
            </a>
              @else
           <a class="more"> <i class="m-icon-swapright m-icon-white"></i>
            </a>
            @endif
        </div>
    </div>

    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <div class="dashboard-stat green-haze">
            <div class="visual">
                <i class="fa fa-globe"></i>
            </div>
            <div class="details">
                <div class="number">
                    {{isset($data['contactus']) ? $data['contactus'] : 0 }}
                </div>
                <div class="desc">
                     Contact Queries
                </div>
            </div>
            @if(helperCheckPermission('queries_management_access'))
            <a class="more" href="{{url('admin/contactus')}}">
            View more <i class="m-icon-swapright m-icon-white"></i>
            </a>
              @else
           <a class="more"> <i class="m-icon-swapright m-icon-white"></i>
            </a>
            @endif
        </div>
    </div>
    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 ">
        <div class="dashboard-stat blue-madison">
            <div class="visual">
                <i class="icon-user"></i>
            </div>
            <div class="details">
                <div class="number">
                    {{isset($data['coupons']) ? $data['coupons'] : 0 }}
                </div>
                <div class="desc">
                    Total Active Coupons
                </div>
            </div>
            @if(helperCheckPermission('coupon_management_access'))
            <a class="more" href="{{url('admin/coupons')}}">
            View more <i class="m-icon-swapright m-icon-white"></i>
            </a>
              @else
           <a class="more"> <i class="m-icon-swapright m-icon-white"></i>
            </a>
            @endif
        </div>
    </div>
    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <div class="dashboard-stat red-intense">
            <div class="visual">
                <i class="icon-basket"></i>
            </div>
            <div class="details">
                <div class="number">
                  {{isset($data['orders']) ? $data['orders'] : 0 }}
                </div>
                <div class="desc">
                    Total Orders
                </div>
            </div>
             @if(helperCheckPermission('order_management_access'))
            <a class="more" href="{{url('admin/orders')}}">
            View more <i class="m-icon-swapright m-icon-white"></i>
            </a>
              @else
           <a class="more"> <i class="m-icon-swapright m-icon-white"></i>
            </a>
            @endif
        </div>
    </div>
    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <div class="dashboard-stat blue-madison">
            <div class="visual">
                <i class="fa fa-usd" aria-hidden="true"></i>
            </div>
            <div class="details">
                <div class="number">
                  {{isset($data['revenue']) ? $data['revenue'] : 0 }}
                </div>
                <div class="desc">
                    Total Revenue
                </div>
            </div>
             @if(helperCheckPermission('order_management_access'))
            <a class="more" href="{{url('admin/orders')}}">
            View more <i class="m-icon-swapright m-icon-white"></i>
            </a>
            @else
            <a class="more"><i class="m-icon-swapright m-icon-white"></i></a>
            @endif
        </div>
    </div>
</div>
<!-- END DASHBOARD STATS -->
<div class="clearfix">
</div>

<div class="page-head" style="background-color: #8f8282 !important;">
    <div class="page-title">
        <h1 style="color: white !important; margin-left: 10px;">Analytics <small style="color: white">statistics &amp; reports</small></h1>
    </div>
    <div class="page-bar">
    	<div class="page-toolbar">
			<div id="dashboard-report-range" class="pull-right tooltips btn btn-fit-height grey-salt" data-placement="top" data-original-title="Change dashboard date range" style="color: black">
				<i class="icon-calendar"></i>&nbsp; <span class="thin uppercase visible-lg-inline-block">April 5, 2020 - May 4, 2020</span>&nbsp; <i class="fa fa-angle-down"></i>
			</div>
		</div>
	</div>
</div>
<!-- END PAGE HEADER-->
<!-- BEGIN DASHBOARD STATS -->
<div class="row margin-top-10">
	<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
		<div class="dashboard-stat2">
			<div class="display">
				<div class="number">
					<h3 class="font-green-sharp quotes_count">0</h3>
					<small> Quotes Queries</small>
				</div>
				<div class="icon">
					<i class="icon-info"></i>
				</div>
			</div>
			<div class="progress-info">
				<div class="progress">
					<span style="width: 0%;" class="progress-bar progress-bar-success green-sharp">
				</div>
			</div>
		</div>
	</div>
	<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
		<div class="dashboard-stat2">
			<div class="display">
				<div class="number">
					<h3 class="font-red-haze contact_count">0</h3>
					<small> Contact Queries</small>
				</div>
				<div class="icon">
					<i class="icon-info"></i>
				</div>
			</div>
			<div class="progress-info">
				<div class="progress">
					<span style="width: 0%;" class="progress-bar progress-bar-success red-haze">
				</div>
			</div>
		</div>
	</div>
	<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
		<div class="dashboard-stat2">
			<div class="display">
				<div class="number">
					<h3 class="font-blue-sharp orders_count">0</h3>
					<small>NEW ORDERS</small>
				</div>
				<div class="icon">
					<i class="icon-basket"></i>
				</div>
			</div>
			<div class="progress-info">
				<div class="progress">
					<span style="width: 0%;" class="progress-bar progress-bar-success blue-sharp">
				</div>
			</div>
		</div>
	</div>
    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <div class="dashboard-stat2">
            <div class="display">
                <div class="number">
                    <h3 class="font-green-sharp revenue_count">0</h3>
                    <small>Revenue</small>
                </div>
                <div class="icon">
                    <i class="fa fa-usd" aria-hidden="true"></i>
                </div>
            </div>
            <div class="progress-info">
                <div class="progress">
                    <span style="width: 0%;" class="progress-bar progress-bar-success blue-sharp">
                </div>
            </div>
        </div>
    </div>
	<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
		<div class="dashboard-stat2">
			<div class="display">
				<div class="number">
					<h3 class="font-purple-soft users_count">0</h3>
					<small>NEW USERS</small>
				</div>
				<div class="icon">
					<i class="icon-user"></i>
				</div>
			</div>
			<div class="progress-info">
				<div class="progress">
					<span style="width: 0%;" class="progress-bar progress-bar-success purple-soft">
				</div>
			</div>
		</div>
	</div>
</div>
<!-- graphs -->
<div class="row">
    <div class="col-md-6" id="chart-container-users"></div>
    <!-- <div class="col-md-6" id="chart-container-query"></div> -->
    <div class="col-md-6" id="chart-container-orders"></div>
</div>

<div class="row " style="margin-top: 10px;">
    <div class="col-md-6" id="chart-container-revenue"></div>
</div>

@endsection


@section('js')
<script type="text/javascript" src="https://cdn.fusioncharts.com/fusioncharts/latest/fusioncharts.js"></script>
    <!-- Step 2 - Include the fusion theme -->
<script type="text/javascript" src="https://cdn.fusioncharts.com/fusioncharts/latest/themes/fusioncharts.theme.fusion.js"></script>
<script type="text/javascript">

	var start = moment().subtract(29, 'days');
    var end = moment();
    const graphRename = ()=>{
        document.body.innerHTML = document.body.innerHTML.replace('FusionCharts Trial', 'Graph');
    }

    function make_users_chart(material){
        if(!material.length>0){
            var data = [{
                "label": "No Result",
                "value": "0"
            }];
        }else{
            var data = material;
        }
        

        //STEP 3 - Chart Configurations
        var chartConfig = {
            type: 'column2d',
            renderAt: 'chart-container-users',
            width: '100%',
            height: '400',
            dataFormat: 'json',
            dataSource: {
            // Chart Configuration
            "chart": {
                "caption": "New Users",
                "subCaption": "",
                "xAxisName": "Date",
                "yAxisName": "Count",
                "numberSuffix": "",
                "theme": "fusion",
            },
            // Chart Data
            "data": data
            }
        };
        var fusioncharts = new FusionCharts(chartConfig);
        fusioncharts.render();
    }
    function make_compartive_chart(material){
        if(!material.length>0){
            var category = [{
                "label": "No Result",
            }];
            var contactus = [{
                "value": 0,
            }];
            var quotes = [{
                "value": 0,
            }];
        }else{
            var category = Object.keys(material);
            var contactus = [{
                "value": 0,
            }];
            var quotes = [{
                "value": 0,
            }];
        }
        var fusioncharts = new FusionCharts({
            type: 'scrollColumn2d',//scroll type
            //dataLoadStartMessage: "Fetching records, Please wait...",//msg displayed while loading data
            renderAt: 'chart-container-query',//div where graph rendered
            width: '100%',//width
            height: '400',//height
            dataFormat: 'json',//data type
            dataSource: {
                "chart": {
                    "caption": "Quotes And Contact-Us Query",
                    "xaxisname": "Date",
                    "yaxisname": "Count Values",
                    "showvalues": "1",
                    "numberprefix": "",
                    "suseroundedges": "1",
                    "legendborderalpha": "50",
                    "showborder": "0",
                    "bgcolor": "FFFFFF,FFFFFF",
                    "plotgradientcolor": " ",
                    "showalternatehgridcolor": "0",
                    "showplotborder": "0",
                    "labeldisplay": "WRAP",
                    "divlinecolor": "CCCCCC",
                    "showcanvasborder": "0",
                    "canvasborderalpha": "0",
                    "legendshadow": "0"
                },
                "categories": [
                    {
                        "category": category
                    }
                ],
                "dataset": [
                    {
                        "seriesname": "ContactUs",
                        "color": "008ee4",
                        "data": contactus
                    },
                    {
                        "seriesname": "Quotes",
                        "color":'#d05454',//color code for bars
                        "data": quotes
                    }
                ]
            } 
        });
        fusioncharts.render();
    }
    function make_orders_chart(material){
        if(!material.length>0){
            var data = [{
                "label": "No Result",
                "value": "0"
            }];
        }else{
            var data = material;
        }

        //STEP 3 - Chart Configurations
        var chartConfig = {
            type: 'column2d',
            renderAt: 'chart-container-orders',
            width: '100%',
            height: '400',
            dataFormat: 'json',
            dataSource: {
            // Chart Configuration
            "chart": {
                "caption": "New Orders",
                "subCaption": "",
                "xAxisName": "Date",
                "yAxisName": "Count",
                "numberSuffix": "",
                "theme": "fusion",
            },
            // Chart Data
            "data": data
            }
        };
        var fusioncharts = new FusionCharts(chartConfig);
        fusioncharts.render();
    }
    function make_revenue_chart(material){
        if(!material.length>0){
            var data = [{
                "label": "No Result",
                "value": "0"
            }];
        }else{
            var data = material;
        }

        //STEP 3 - Chart Configurations
        var chartConfig = {
            type: 'column2d',
            renderAt: 'chart-container-revenue',
            width: '100%',
            height: '400',
            dataFormat: 'json',
            dataSource: {
            // Chart Configuration
            "chart": {
                "caption": "Revenue",
                "subCaption": "",
                "xAxisName": "Date",
                "yAxisName": "Count",
                "numberSuffix": "",
                "theme": "fusion",
            },
            // Chart Data
            "data": data
            }
        };
        var fusioncharts = new FusionCharts(chartConfig);
        fusioncharts.render();
    }

    const getdashboardGraphs = (start, end)=>{
        $.ajax({
            url:"{{url('admin/dashboardGraphs')}}",
            type:'get',
            data:{
                'start':start,
                'end':end
            },
            beforeSend:function(){
                startLoader('body');
            },
            complete:function(){
                stopLoader('body');
            },
            success:function(data){
                $('.quotes_count').html(0);
                $('.contact_count').html(0);
                $('.orders_count').html(0);
                $('.users_count').html(0);
                $('.revenue_count').html(0);
                $('.progress-bar-success').css('width','0%');
                if(data.status)
                {
                    $('.quotes_count').html(data.data.quotes);
                    $('.contact_count').html(data.data.contact);
                    $('.orders_count').html(data.data.orders);
                    $('.revenue_count').html(data.data.revenue);
                    $('.users_count').html(data.data.users);
                    $('.progress-bar-success').css('width','100%');

                    FusionCharts.ready(
                        function(){
                            make_compartive_chart(data.data.compareResponse)
                            make_orders_chart(data.data.orderResponse);
                            make_revenue_chart(data.data.revenueResponse);
                            make_users_chart(data.data.userResponse);
                        }
                    );
                }else{
                    show_FlashMessage('something went wrong.','error');
                    return false;
                }
            },
            error:function(){
                stopLoader('body');
                show_FlashMessage('something went wrong.','error');
                return false;
            }
        });
    }
    
    function cb(start, end) {
        $('#dashboard-report-range span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
        getdashboardGraphs(start.format('DD/MM/YYYY'), end.format('DD/MM/YYYY'));
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

    cb(start, end);

    // setInterval(function(){ graphRename() }, 3000);

</script>
@endsection