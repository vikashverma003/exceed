</div>
<!-- END CONTAINER -->
<!-- BEGIN FOOTER -->
<div class="page-footer text-center">
	<div class="page-footer-inner" style="text-align: center;">
		{{ config('app.name', 'Laravel') }} &copy; Copyright {{ date('Y') }}. All rights reserved.
	</div>
	<div class="scroll-to-top">
		<i class="icon-arrow-up"></i>
	</div>
</div>
<!-- END FOOTER -->
<!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->
<!-- BEGIN CORE PLUGINS -->
<!--[if lt IE 9]>
<script src="{{ asset('assets/js/respond.min.js') }}"></script>
<script src="{{ asset('assets/js/excanvas.min.js') }}"></script> 
<![endif]-->
<script src="{{ asset('assets/js/jquery.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/js/jquery-migrate.min.js') }}" type="text/javascript"></script>
<!-- IMPORTANT! Load jquery-ui.min.js before bootstrap.min.js to fix bootstrap tooltip conflict with jquery ui tooltip -->
<script src="{{ asset('assets/js/jquery-ui.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/js/bootstrap.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/js/bootstrap-hover-dropdown.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/js/jquery.slimscroll.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/js/jquery.blockui.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/js/jquery.uniform.min.js') }}" type="text/javascript"></script>
<!-- END CORE PLUGINS -->
<!-- BEGIN PAGE LEVEL PLUGINS -->
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="{{ asset('assets/js/metronic.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/js/layout.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/js/quick-sidebar.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/js/bootbox.min.js') }}" type="text/javascript"></script>
<!-- Pnotify JS -->
<script src="{{ asset('assets/js/pnotify.custom.min.js') }}" type="text/javascript"></script>
<!-- Waitme JS -->
<script src="{{ asset('assets/js/waitMe.min.js') }}" type="text/javascript"></script>
<script type="text/javascript" src="{{ asset('assets/js/jquery-ui.js') }}"></script>

<!-- developer js common function functions -->
<script src="{{ asset('assets/js/developer.js') }}" type="text/javascript"></script>
{{--<script src="{{ asset('js/path.js') }}" type="text/javascript"></script>--}}

<!-- Add fancyBox JS -->
<script src="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.6/dist/jquery.fancybox.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<script type="text/javascript" src="{{asset('assets/js/jquery.dataTables.min.js')}}"></script>
<script type="text/javascript">
	const path = "{{ env('APP_URL') }}";
	const role = "admin";
	const full_path = path+'/'+role;
</script>
<!-- END PAGE LEVEL SCRIPTS -->
<script type="text/javascript">

$(document).ready(function() {
	$(".fancybox").fancybox();
	Metronic.init(); // init metronic core componets
	Layout.init(); // init layout
	QuickSidebar.init(); // init quick sidebar
	//$.fancybox.defaults.buttons = ['close'];
        // set user timezone
        //set the common ajax parameters
		$.ajaxSetup({
		    headers: {
		        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		    }
		});
        
        
	// Hide Flash Message
	$('div.alert').delay(3000).slideUp(300);
});
</script>

@yield('js')
@yield('pagejs')

<!-- END JAVASCRIPTS -->
</body>
<!-- END BODY -->
</html>

