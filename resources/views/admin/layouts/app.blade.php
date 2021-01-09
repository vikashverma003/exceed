@include('admin.layouts.header')
    @include('admin.layouts.sidebar')
    <!-- BEGIN CONTENT -->
	<div class="page-content-wrapper">
		<div class="page-content">
			@yield('content')
		</div>
	</div>
	<!-- END CONTENT -->
@include('admin.layouts.footer')