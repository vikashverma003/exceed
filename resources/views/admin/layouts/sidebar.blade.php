<div class="page-sidebar-wrapper">
	<!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
	<!-- DOC: Change data-auto-speed="200" to adjust the sub menu slide up/down speed -->
	<div class="page-sidebar md-shadow-z-2-i  navbar-collapse collapse">
		<!-- BEGIN SIDEBAR MENU -->
		<!-- DOC: Apply "page-sidebar-menu-light" class right after "page-sidebar-menu" to enable light sidebar menu style(without borders) -->
		<!-- DOC: Apply "page-sidebar-menu-hover-submenu" class right after "page-sidebar-menu" to enable hoverable(hover vs accordion) sub menu mode -->
		<!-- DOC: Apply "page-sidebar-menu-closed" class right after "page-sidebar-menu" to collapse("page-sidebar-closed" class must be applied to the body element) the sidebar sub menu mode -->
		<!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
		<!-- DOC: Set data-keep-expand="true" to keep the submenues expanded -->
		<!-- DOC: Set data-auto-speed="200" to adjust the sub menu slide up/down speed -->
		<ul class="page-sidebar-menu " data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200">
			<!-- DOC: To remove the sidebar toggler from the sidebar you just need to completely remove the below "sidebar-toggler-wrapper" LI element -->
			<li class="sidebar-toggler-wrapper">
				<!-- BEGIN SIDEBAR TOGGLER BUTTON -->
				<div class="sidebar-toggler margin-bottom-20">
				</div>
				<!-- END SIDEBAR TOGGLER BUTTON -->
			</li>
			<li class="start @if($active == 'dashboard') active @endif">
				<a href="{{url('/admin/dashboard')}}">
					<span><i class="icon-home"></i></span>
					<span class="title">Dashboard</span>
				</a>
			</li>

			@if(helperCheckPermission('customer_management_access'))
				<li class="start @if($active == 'users') active @endif">
					<a href="{{url('/admin/users')}}">
						<span><i class="icon-users"></i></span>
						<span class="title">Customers</span>
					</a>
				</li>
			@endif

			@if(Auth::guard('admin')->user()->isAdmin())
	            <li class="start @if($active == 'sub-admin') active @endif">
					<a href="{{url('/admin/sub-admin')}}">
						<span><i class="icon-users"></i></span>
						<span class="title">Sub-Admins</span>
					</a>
				</li>
	        @endif
			
	        @if(helperCheckPermission('order_management_access'))
			<li class="start @if($active == 'orders') active @endif">
				<a href="{{url('/admin/orders')}}">
					<span><i class="fa fa-usd" aria-hidden="true"></i></span>
					<span class="title">Orders</span>
				</a>
			</li>
			@endif

			@if(helperCheckPermission('manufactuers_management_access'))
			<li class="start @if($active == 'manufacturers') active @endif">
				<a href="{{url('/admin/manufacturers')}}">
					<span><i class="fa fa-industry" aria-hidden="true"></i></span>
					<span class="title">Manufacturers</span>
				</a>
			</li>
			@endif

			@if(helperCheckPermission('products_management_access'))
			<li class="start @if($active == 'products') active @endif">
				<a href="{{url('/admin/products')}}">
					<span><i class="fa fa-product-hunt" aria-hidden="true"></i></span>
					<span class="title">Products Family</span>
				</a>
			</li>
			@endif

			@if(helperCheckPermission('courses_management_access'))
			<li class="start @if($active == 'courses') active @endif">
				<a href="{{url('/admin/courses')}}">
					<span><i class="fa fa-info" aria-hidden="true"></i></span>
					<span class="title">Products</span>
				</a>
			</li>
			@endif

			@if(helperCheckPermission('categories_management_access'))
			<li class="start @if($active == 'categories') active @endif">
				<a href="{{url('/admin/categories')}}">
					<span><i class="fa fa-list-alt" aria-hidden="true"></i></span>
					<span class="title">Training Categories</span>
				</a>
			</li>
			@endif
			
			@if(helperCheckPermission('location_management_access'))
			<li class="start @if($active == 'location') active @endif">
				<a href="{{url('/admin/locations')}}">
					<span><i class="fa fa-map" aria-hidden="true"></i></span>
					<span class="title">Locations</span>
				</a>
			</li>
			@endif

			@if(helperCheckPermission('trainingtypes_management_access'))
			<li class="start @if($active == 'trainingtypes') active @endif">
				<a href="{{url('/admin/training-types')}}">
					<span><i class="fa fa-map" aria-hidden="true"></i></span>
					<span class="title">Training Types</span>
				</a>
			</li>
			@endif

			@if(helperCheckPermission('coupon_management_access'))
			<li class="start @if($active == 'coupons') active @endif">
				<a href="{{url('/admin/coupons')}}">
					<span><i class="fa fa-money" aria-hidden="true"></i></span>
					<span class="title">Coupons</span>
				</a>
			</li>
			@endif

			@if(helperCheckPermission('cms_management_access'))
			<li class="@if($active == 'cms') active open @endif">
				<a href="javascript:;">
					<i class="fa fa-info-circle"></i>
					<span class="title">Manage CMS</span>
					<span class=""></span>
					<span class="arrow"></span>
					<span class="@if($active == 'cms') selected @endif"></span>
				</a>
				<ul class="sub-menu class="@if($active == 'cms') style="display: block;" @endif">

					<li class="start @if($subactive == 'cms') active @endif">
						<a href="{{url('/admin/cms')}}">
							<span><i class="fa fa-file-text-o" aria-hidden="true"></i></span>
							<span class="title">Home Page Content</span>
						</a>
					</li>
					<li class="start @if($subactive == 'servicecards') active @endif">
						<a href="{{url('/admin/servicecards')}}">
							<span><i class="fa fa-credit-card" aria-hidden="true"></i></span>
							<span class="title">Service Board Content</span>
						</a>
					</li>
					
					<li class="start @if($subactive == 'testimonials') active @endif">
						<a href="{{url('/admin/testimonials')}}">
							<span><i class="fa fa-quote-left"></i></span>
							<span class="title">Testimonials</span>
						</a>
					</li>
					<li class="start @if($subactive == 'companylogo') active @endif">
						<a href="{{url('/admin/companylogos')}}">
							<span><i class="fa fa-image"></i></span>
							<span class="title">Companies Logo</span>
						</a>
					</li>
					<li class="start @if($subactive == 'faqs') active @endif">
						<a href="{{url('/admin/faqs')}}">
							<span><i class="fa fa-list" aria-hidden="true"></i></span>
							<span class="title">FAQs Content</span>
						</a>
					</li>
				</ul>
			</li>
			@endif

			@if(helperCheckPermission('queries_management_access'))
			<li class="@if($active == 'queries') active open @endif">
				<a href="javascript:;">
					<i class="fa fa-info-circle"></i>
					<span class="title">Queries</span>
					<span class=""></span>
					<span class="arrow"></span>
					<span class="@if($active == 'queries') selected @endif"></span>
				</a>
				<ul class="sub-menu class="@if($active == 'queries') style="display: block;" @endif" >
					<li class="@if($subactive=='contact-us') active @endif">
						<a href="{{url('/admin/contactus')}}">
						<span class="title submenu_custom_css"><i class="fa fa-info-circle"></i> Contact-Us Queries</span></a>
					</li>
					<li class="@if($subactive=='quotes') active @endif">
						<a href="{{url('/admin/quotes')}}">
						<span class="title submenu_custom_css"><i class="fa fa-question-circle"></i> Quotes Queries</span></a>
					</li>
				</ul>
			</li>
			@endif

			<li class="@if($active == 'mastersettings') active open @endif">
				<a href="javascript:;">
					<i class="fa fa-info-circle"></i>
					<span class="title">Master Settings</span>
					<span class=""></span>
					<span class="arrow"></span>
					<span class="@if($active == 'mastersettings') selected @endif"></span>
				</a>
				<ul class="sub-menu class="@if($active == 'mastersettings') style="display: block;" @endif" >
					
					@if(Auth::guard('admin')->user()->isAdmin())
						<li class="@if($subactive=='contactemails') active @endif">
							<a href="{{url('/admin/settings/contact-mails')}}">
							<span class="title submenu_custom_css"><i class="fa fa-envelope"></i> Emails Notifications</span></a>
						</li>
					@endif

					<li class="@if($subactive=='termspage') active @endif">
						<a href="{{url('/admin/settings/termspage')}}">
						<span class="title submenu_custom_css"><i class="fa fa-info"></i> Terms Content</span></a>
					</li>
					<li class="@if($subactive=='privacypage') active @endif">
						<a href="{{url('/admin/settings/privacypage')}}">
						<span class="title submenu_custom_css"><i class="fa fa-info"></i> Privacy Content</span></a>
					</li>
					<li class="@if($subactive=='cookiepage') active @endif">
						<a href="{{url('/admin/settings/cookiepage')}}">
						<span class="title submenu_custom_css"><i class="fa fa-info"></i> Cookie Content</span></a>
					</li>
					<li class="@if($subactive=='training-site') active @endif">
						<a href="{{url('/admin/settings/training-sites')}}">
						<span class="title submenu_custom_css"><i class="fa fa-info"></i> Training Site Content</span></a>
					</li>
				</ul>
			</li>
			

			<li class="start">
				<a class="dropdown-item" href="{{ route('admin.logout') }}">
                    <span><i class="icon-key"></i></span>
					<span class="title">Logout</span>
                </a>
			</li>
		</ul>
		<!-- END SIDEBAR MENU -->
	</div>
</div>