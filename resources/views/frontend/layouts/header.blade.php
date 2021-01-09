<header class="main_header">
    <div class="container">
        <div class="row">
            <div class="col col-md-12 pl-0 pr-0">
                <nav class="navbar navbar-expand-lg navbar-light">
                    <a class="navbar-brand mobile_view" href="{{url('/')}}"><img src="{{asset('img/main_header_logo.svg')}}"></a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse"
                        data-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false"
                        aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarTogglerDemo01">
                        <a class="navbar-brand desktop_view" href="{{url('/')}}">
                            <img src="{{asset('img/main_header_logo.svg')}}">
                        </a>
                                                
                        <ul class="nav navbar-nav mr-auto ml-auto mt-2 mt-lg-0">
                            
                            <div class="dropdown browse-drop-down browseCourseMenu">
                                <button class="btn btn-secondary browse-drop-down-btn dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <a href="#" class="nav-link">
                                <span class="browse_course"><img src="{{asset('img/ic_browse_course.svg')}}">Browse Courses</span><b class="caret"></b>
                                </a>
                                </button>
                                <ul class="dropdown-menu browseCourseUL multi-level high-zindex" role="menu" aria-labelledby="dropdownMenu">
                                    @php
                                        $categoriesmenu = \App\Models\Category::where('status', 1)->with(['manufacturerlists','manufacturerlists.manufacturer'])->get();
                                    @endphp
                                    @foreach($categoriesmenu as $row)
                                        @php
                                            $check_status = 0;
                                            $course_count = 0;
                                            if($row->courses->count() && $row->manufacturerlists->count())
                                            {
                                                foreach($row->manufacturerlists as $list)
                                                {
                                                    if($list->manufacturer->status == 1 && isset($list->manufacturer->courses))
                                                    {
                                                            $listProducts = \App\Models\Product::where('status',1)->where('category_id',$row->id)->where('manufacturer_id', $list->manufacturer->id)->get();
                                                            if($listProducts->count())
                                                            {
                                                                foreach($listProducts as $product)
                                                                {
                                                                    $productCourses = \App\Models\Course::where('status',1)->where('category_id',$row->id)->where('manufacturer_id', $list->manufacturer->id)->where('product_id',$product->id)->get();
                                                                    if($productCourses->count() > 0)
                                                                    {
                                                                     $course_count = $course_count + 1;   
                                                                    }
                                                                }
                                                            }
                                                    }     
                                                }
                                                foreach($row->courses as $course)
                                                {
                                                    if($course->status == 1)
                                                    {
                                                        $check_status = 1;
                                                    }
                                                }   
                                            }
                                        @endphp
                                        @if($check_status && $course_count)
                                        <li class="dropdown-submenu main_heading_menu_section">
                                            <a  class="dropdown-item" tabindex="-1" href="{{url('/products?categories[]='.str_slug($row->name))}}">
                                                {{--@if(!$row->icon)
                                                    <img src="{{asset('img/ic_web_development.svg')}}" alt="Icon">
                                                @else
                                                    <img src="{{asset('uploads/categories/'.$row->icon)}}" height="24px" width="24px" alt="icon">
                                                @endif--}}
                                                {{ucfirst($row->name)}} 
                                            </a>
                                            
                                            @if(isset($row['manufacturerlists']) && count($row['manufacturerlists'])>0)
                                            @php $check = 0; @endphp
                                                @foreach(@$row['manufacturerlists'] as $subrow)
                                                    @if($subrow['manufacturer']->status)    
                                                        @php
                                                            $manufacturersAvailheader = \App\Models\Product::where('status',1)->where('category_id',$row->id)->where('manufacturer_id', $subrow['manufacturer']->id)->get();
                                                        @endphp
                                                        @if($manufacturersAvailheader->count())
                                                            @php $check =1 @endphp 
                                                        @endif
                                                    @endif
                                                @endforeach
                                                @if($check == 1)
                                                <ul class="dropdown-menu main_heading_submenu_section">

                                                    @foreach(@$row['manufacturerlists'] as $subrow)
                                                        @if($subrow['manufacturer']->status)
                                                        
                                                        @php
                                                            $manufacturersAvailheader = \App\Models\Product::where('status',1)->where('category_id',$row->id)->where('manufacturer_id', $subrow['manufacturer']->id)->get(); 
                                                        @endphp

                                                        @if($manufacturersAvailheader->count())
                                                            <li class="dropdown-submenu dropdown-submenu-heading">
                                                                <strong>{{$subrow['manufacturer']->name}}</strong>
                                                            </li>
                                                            
                                                            @foreach($manufacturersAvailheader as $subroww)
                                                            @php
                                                                $product_courses = \App\Models\Course::where('status',1)->where('product_id',$subroww->id)->get();
                                                            @endphp
                                                                @if($product_courses->count())
                                                                <li class="dropdown-submenu">
                                                                    <a class="dropdown-item" href="{{url('/products?courses[]='.str_slug($subroww->name).'&manufactuers[]='.str_slug($subrow['manufacturer']->name).'&categories[]='.str_slug($row->name))}}">{{ucfirst($subroww->name)}}</a>
                                                                </li>
                                                                @endif
                                                            @endforeach
                                                            
                                                        @endif
                                                        @endif
                                                    @endforeach
                                                </ul>
                                                @endif
                                            @endif
                                        </li>
                                        @endif
                                    @endforeach
                                </ul>
                            </div>

                           

                            <li class="nav-item">
                                <a class="nav-link" href="javascript:;" onclick="showContactUsModal();">Contact</a>
                                
                            </li>

                            <li class="nav-item dropdown">
                                <a href="#" class="dropdown-toggle nav-link data-toggle"  data-toggle="dropdown">Training Methods
                                </a>
                                <ul class="dropdown-menu high-zindex">
                                    @php
                                        $cards = \App\Models\ServiceCardContent::select('card_number','title')->get();
                                    @endphp
                                    @foreach($cards as $row)
                                        @if($row->card_number==1)
                                            <li class="nav-item">
                                                <a href="{{url('/services/'.str_slug($row->title))}}" class="nav-link">{{$row->title}}</a>
                                            </li>
                                        @endif
                                    @endforeach
                                </ul>
                            </li>
                        </ul>
                        <div class="profile_txt">
                        
                            <a href="{{url('cart')}}">
                                <img src="{{asset('img/shopping-cart-new.png')}}">
                                @guest
                                    @php
                                        $cartdata = 0;
                                    @endphp
                                    <?php

                                        if(\Session::has('carts'))
                                        {
                                            $cartdata = session()->get('carts');
                                            $cartdata = count($cartdata);
                                        }
                                    ?>
                                    @if($cartdata)
                                        <span class="cart_count">{{$cartdata}}</span>
                                    @endif
                                @endguest

                                @auth
                                <span class="cart_count">{{\App\Models\Cart::where('user_id', Auth::user()->id)->count()}}</span>
                            @endauth
                            </a>
                                    
                        </div>
                        <div class="profile_txt">
                            @auth
                                <div class="dropdown">
                                    <button class="dropbtn">
                                        <!-- <img class="img-circle img mr-2" src="{{asset('img/ic_profile_fill@2x.png')}}"> -->
                                        <span class="stleClassColor" style="line-height: 3">
                                            {{Auth::user()->name}}
                                        </span>
                                        
                                    </button>
                                    <div class="dropdown-content high-zindex">
                                        
                                        <a href="{{url('/profile')}}"><img src="{{asset('img/ic_account_settings.svg')}}">Edit Account</a>

                                        <a href="{{url('/mycourses')}}"><img src="{{asset('img/ic_my_courses.svg')}}">My Courses</a>

                                        <a href="{{url('/transactions')}}"><img src="{{asset('img/ic_purchase_history.svg')}}"> Purchase history</a>
                                        
                                        <a href="{{url('/help')}}"><img src="{{asset('img/ic_help.svg')}}"> Help</a>
                                        
                                        <a href="{{route('user.logout')}}"> <img src="{{asset('img/ic_log_out.svg')}}"> Logout</a>
                                    </div>
                                </div>
                            @endauth

                            @guest
                                <button class="btn btn-large sign-in sign-up" onclick="showLoginModal();">Log In </button>
                            @endguest
                        </div>
                            @include('frontend.includes.login-modal')
                            
                            @auth
                                @include('frontend.includes.customer-pre')
                            @endauth
                            
                            @guest
                                @include('frontend.includes.customer-type')
                            @endguest
                            
                            @include('frontend.includes.signup-modal')

                            @include('frontend.includes.forgot-password')
                        
                    </div>
                </nav>
            </div>
        </div>
    </div>
</header>