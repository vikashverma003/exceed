<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        
        <title>@yield('title') | {{ config('app.name', 'Laravel') }}</title>
        
        <meta name="description" content="@yield('meta_description')">
        <meta name="keywords" content="@yield('meta_keywords')">

        <link rel="icon" href="{{asset('img/exceed-fav.png')}}" sizes="16x16" type="image/png">

        <link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}">
        <link rel="stylesheet" href="{{asset('css/style.css')}}">
        <link rel="stylesheet" href="{{asset('css/developer.css')}}">
        <link rel="stylesheet" href="{{asset('css/waitMe.min.css')}}">
        <link rel="stylesheet" href="{{asset('css/animate.css')}}">
        <link rel="stylesheet" href="{{asset('css/responsive.css')}}">
        <link rel="stylesheet" href="{{asset('css/chosen.css')}}">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
        <link href="{{ asset('assets/css/pnotify.custom.min.css') }}" rel="stylesheet" type="text/css"/>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.2/assets/owl.carousel.min.css" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.2/assets/owl.theme.default.min.css" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.2/assets/owl.theme.green.min.css" />

        @yield('css')
    </head>
    
    <body>
        <div id="fb-root"></div>
        <script async defer crossorigin="anonymous" src="https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v7.0&appId=1103571003329710&autoLogAppEvents=1"></script>
        <input type="hidden" name="auth_user_val" value="{{isset(Auth::user()->id) ? Auth::user()->id: ''}}">
    	
        @yield('content')
        @include('frontend.includes.quote-request')
        @include('frontend.includes.locations-quote-request')
        @include('frontend.includes.account-activation')
        
        <script src="{{asset('js/jquery.min.js')}}"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>

        <script src="{{asset('js/bootstrap.min.js')}}"></script>
        <script src="{{asset('js/sweetalert2@9.js')}}"></script>
        <script src="{{asset('js/jquery.cookie.js')}}"></script>
        <script src="{{asset('js/wow.min.js')}}"></script>
        <script src="{{asset('js/waitMe.min.js')}}"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.2/owl.carousel.min.js"></script>
        <script src="{{asset('js/datepicker.js')}}"></script>
        <script src="{{asset('js/chosen.jquery.js')}}"></script>
        <script src="{{ asset('assets/js/pnotify.custom.min.js') }}" type="text/javascript"></script>
        <script src="{{asset('js/frame-common.js')}}"></script>
        <script src="{{asset('js/landingPage.js')}}"></script>
        <script type="text/javascript">
        	new WOW().init();
            const WEBSITE_URL="{{env('APP_URL')}}";
            let customerSelected = '{{isset(Auth::user()->customer_type_selected) ? Auth::user()->customer_type_selected : 0 }}';
            @auth
                let customerLoggedIn = 1;
            @endauth

            @guest
                let customerLoggedIn = 0;
            @endguest
        </script>
        <script type="text/javascript"> var $zoho=$zoho || {};$zoho.salesiq = $zoho.salesiq || {widgetcode:"b3928113cae4d05ccff4ef05b692e31d886bbadc5e2dbf86fcfb6f2f936bb86c1a2010ab7b6727677d37b27582c0e9c4", values:{},ready:function(){}};var d=document;s=d.createElement("script");s.type="text/javascript";s.id="zsiqscript";s.defer=true;s.src="https://salesiq.zoho.com/widget";t=d.getElementsByTagName("script")[0];t.parentNode.insertBefore(s,t);d.write("<div id='zsiqwidget'></div>"); </script>

        <script type="text/javascript">
            $(document).ready(function(){
                window.addEventListener( "pageshow", function ( event ) {
                  var historyTraversal = event.persisted || 
                                         ( typeof window.performance != "undefined" && 
                                              window.performance.navigation.type === 2 );
                  if ( historyTraversal ) {
                    // Handle page restore.
                    window.location.reload(true);
                  }
                });
            });
        </script>
        @yield('scripts')
    </body>
</html>
