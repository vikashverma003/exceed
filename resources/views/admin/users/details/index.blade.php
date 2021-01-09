@extends('admin.layouts.app')
@section('title', 'Customer Details')
@section('content')
    
    <!-- BEGIN PAGE HEADER-->
    <div class="page-head">
        <div class="page-title">
            <h1>
                Customer Details
            </h1>
        </div>
    </div>
    <ul class="page-breadcrumb breadcrumb">
        <li>
            <i class="fa fa-circle"></i>
            <a href="{{ route('admin.dashboard') }}">Dashboard</a>
            <i class="fa fa-circle"></i>
            <a href="{{ url('admin/users') }}">Customers Listing</a>

        </li>
    </ul>
    <!-- END PAGE HEADER-->
    <div class="portlet light md-shadow-z-2-i">
        
        <div class="portlet-body">
            @include('admin.users.details.detail')
        </div>
    </div>
    <div class="clearfix"></div>
@endsection


@section('pagejs')
@endsection
