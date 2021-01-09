<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en" class="no-js">
<!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
<meta charset="utf-8"/>
<title>@yield('title') | Admin - {{ config('app.name', 'Laravel') }}</title>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta content="width=device-width, initial-scale=1" name="viewport"/>
<meta content="" name="description"/>
<meta content="" name="author"/>
<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="icon" href="{{asset('img/exceed-fav.png')}}" sizes="16x16" type="image/png">
<!-- BEGIN GLOBAL MANDATORY STYLES -->
<!-- <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css"/> -->
<link href="{{ asset('assets/css/font-awesome.min.css') }}" rel="stylesheet" type="text/css"/>
<link href="{{ asset('assets/css/simple-line-icons.css') }}" rel="stylesheet" type="text/css"/>
<link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css"/>
<link href="{{ asset('assets/css/uniform.default.css') }}" rel="stylesheet" type="text/css"/>

<!-- END GLOBAL MANDATORY STYLES -->
<!-- BEGIN THEME STYLES -->
<link href="{{ asset('assets/css/components.css') }}" id="style_components" rel="stylesheet" type="text/css"/>
<link href="{{ asset('assets/css/layout.css') }}" rel="stylesheet" type="text/css"/>
<link href="{{ asset('assets/css/darkblue.css') }}" rel="stylesheet" type="text/css" id="style_color"/>
<!-- Pnotify Css -->
<link href="{{ asset('assets/css/pnotify.custom.min.css') }}" rel="stylesheet" type="text/css"/>
<!-- Waitme Css -->
<link href="{{ asset('assets/css/waitMe.min.css') }}" rel="stylesheet" type="text/css"/>
<!-- Datepicker Css -->
<link href="{{ asset('assets/css/jquery-ui.css') }}" rel="stylesheet" type="text/css"/>

<!-- Developer Css -->
<link href="{{ asset('assets/css/developer.css') }}" rel="stylesheet" type="text/css"/>
<!-- END THEME STYLES -->
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/bootstrap-fileinput.css') }}"/>
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/default.css') }}"/>
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/light.css') }}"/>
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/jquery.dataTables.min.css') }}"/>

<!-- Add fancyBox CSS -->
<link rel="stylesheet" href="{{ asset('assets/css/jquery.fancybox.min.css') }}" />

<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
<link rel="shortcut icon" href="{{ asset('favicon.ico') }}"/>
 <style>
/* Chrome, Safari, Edge, Opera */
input::-webkit-outer-spin-button,
input::-webkit-inner-spin-button {
  -webkit-appearance: none;
  margin: 0;
}

/* Firefox */
input[type=number] {
  -moz-appearance: textfield;
}

</style>
@yield('css')
@yield('pagecss')
<style type="text/css">
#datepicker_from , #datepicker_to {
 background-color: #fff;
}
</style>

<!-- <link href="{{ asset('assets/color-picker/material_design_colors_full.css') }}" rel="stylesheet"> -->

</head>
<!-- END HEAD -->
<!-- BEGIN BODY -->
<body class="page-md page-header-fixed page-sidebar-closed-hide-logo">
<!-- BEGIN HEADER -->
<div class="page-header md-shadow-z-1-i navbar navbar-fixed-top">
	<!-- BEGIN HEADER INNER -->
	<div class="page-header-inner">
		<!-- BEGIN LOGO -->
		<div class="page-logo">	
			<!-- <a data-fancybox="gallery" href="{{ asset('/images/logo.png') }}">
				<img src="{{ asset('/images/logo.png') }}" class="logo-default" alt="logo" width="100px" />
			</a> -->
			<a href="javascript::void(0)">
				<img src="{{ asset('/img/exceed-logo.png') }}" class="logo-default" alt="logo" width="120px" style="margin-top: 12px;" />
			</a>
			<div class="menu-toggler sidebar-toggler">
				<!-- DOC: Remove the above "hide" to enable the sidebar toggler button on header -->
			</div>
		</div>
		<a href="javascript:;" class="menu-toggler responsive-toggler" data-toggle="collapse" data-target=".navbar-collapse"></a>
		<div class="page-top">
			<!-- BEGIN HEADER SEARCH BOX -->
			<!-- DOC: Apply "search-form-expanded" right after the "search-form" class to have half expanded search box -->
			<!-- END HEADER SEARCH BOX -->
			<!-- BEGIN TOP NAVIGATION MENU -->
			<div class="top-menu">
				<ul class="nav navbar-nav pull-right">
					<li class="separator hide">
					</li>
					
					<!-- END INBOX DROPDOWN -->
					<li class="separator hide">
					</li>
					
					<!-- END TODO DROPDOWN -->
					<!-- BEGIN USER LOGIN DROPDOWN -->
					<!-- DOC: Apply "dropdown-dark" class after below "dropdown-extended" to change the dropdown styte -->
					<li class="dropdown dropdown-user dropdown-dark">
						<a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
							<span class="username username-hide-on-mobile">
							Admin Panel</span>
							<i class="fa fa-angle-down"></i>
						</a>
						<ul class="dropdown-menu dropdown-menu-default">
							<li>
								<a href="{{url('admin/profile')}}">
								<i class="icon-user"></i> My Profile </a>
							</li>
							<li>
								<a href="{{ route('admin.logout') }}">
								<i class="icon-key"></i> Log Out </a>
							</li>
						</ul>
					</li>
					<!-- END USER LOGIN DROPDOWN -->
				</ul>
			</div>
			<!-- END TOP NAVIGATION MENU -->
		</div>
		<!-- END RESPONSIVE MENU TOGGLER -->
		<!-- BEGIN TOP NAVIGATION MENU -->
		
		<!-- END TOP NAVIGATION MENU -->
	</div>
	<!-- END HEADER INNER -->
</div>
<!-- END HEADER -->
<div class="clearfix">
</div>
<!-- BEGIN CONTAINER -->
<div class="page-container">