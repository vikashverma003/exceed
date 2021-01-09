@extends('admin.layouts.app')
@section('title','Dashboard')
@section('content')

@section('css')
<style type="text/css">
    .invalid-feedback {
        display: block;
        width: 100%;
        margin-top: .25rem;
        font-size: 12px;
        color: #e3342f;
    }
</style>
@endsection
<!-- BEGIN PAGE HEADER-->

<h4>
    <!-- flash message -->
</h4>
<div class="page-head">
    <div class="page-title">
        <h1>PROFILE ACCOUNT</h1>
    </div>
</div>
<ul class="page-breadcrumb breadcrumb">
    <li>
        <i class="fa fa-circle"></i>
        <a href="{{url('admin/dashboard')}}">Dashboard</a>
    </li>
</ul>
<!-- END PAGE HEADER-->
<!-- BEGIN DASHBOARD STATS -->
<div class="row">
    <div class="col-md-6">
        <div class="portlet light">
            
            <div class="portlet-body">
                <div class="tab-content">
                    <!-- END CHANGE AVATAR TAB -->
                    <!-- CHANGE PASSWORD TAB -->
                    <div class="tab-pane active" id="tab_1_3">
                        <form action="{{ route('admin.postProfile') }}" method="post">
                            @csrf
                            @include('flash::message')
                            <div class="form-group">
                                <label class="control-label">Current Password</label>
                                <input type="password" class="form-control @error('old_password') is-invalid @enderror" value="{{ old('old_password') }}" name="old_password">

                                @error('old_password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label class="control-label">New Password</label>
                                <input type="password" class="form-control @error('password') is-invalid @enderror" value="{{ old('password') }}" name="password">
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label class="control-label">Re-type New Password</label>
                                <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" value="{{ old('password_confirmation') }}" name="password_confirmation">
                                @error('password_confirmation')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="margin-top-10">
                                <button type="submit" class="btn green-haze">
                                Change Password </button>
                                <a href="{{route('admin.dashboard')}}" class="btn default">
                                Cancel </a>
                            </div>
                        </form>
                    </div>
                    <!-- END PRIVACY SETTINGS TAB -->
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END DASHBOARD STATS -->
<div class="clearfix">
</div>
@endsection

