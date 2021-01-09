@extends('admin.layouts.app')
@section('title', 'Order Details')
@section('content')
    <style type="text/css">
    body{
        font-size: 12px;
    }
    
    </style>

    <!-- BEGIN PAGE HEADER-->
    <div class="page-head">
        <div class="page-title">
            <h1>
                Order Details
            </h1>
        </div>
    </div>
    <ul class="page-breadcrumb breadcrumb">
        <li>
            <i class="fa fa-circle"></i>
            <a href="{{ route('admin.dashboard') }}">Dashboard</a>
            <i class="fa fa-circle"></i>
            <a href="{{ url('admin/orders') }}">Orders Listing</a>

        </li>
    </ul>
    <!-- END PAGE HEADER-->
    <div class="portlet light md-shadow-z-2-i">
        
        <div class="portlet-body">
            @include('admin.orders.details.detail')
        </div>
    </div>
    <div class="clearfix"></div>
@endsection


@section('pagejs')
@endsection
