@extends('frontend.layouts.app')
@section('title', 'Home Page')

@section('css')
    <link rel="stylesheet" href="{{asset('css/datepicker.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.2/assets/owl.theme.default.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.1.3/assets/owl.carousel.min.css" />
    <style type="text/css">
        .manufacture-images {
            height:80px;
            margin-bottom : 15px;
        }
        .manufacture-images img {
            max-width: 100%;
            width: auto!important;
            object-fit: contain;
            height: 80px;
        }
    </style>
@endsection

@section('content')

    @include('frontend.layouts.header')

    <div class="main_section">
        @php
            if(isset($cmsContent->background_video) &&  $cmsContent->background_video!='')
                $background_video = $cmsContent->background_video;
            else
                $background_video = url('/video.mp4');
        @endphp
		<div class="video_div">
			<video autoplay muted loop id="myVideo">
				<source src="{{$background_video}}" type="video/mp4">
			</video>
		</div>
        <div class="content_section">
          
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="traning-txt">
                            <h2 class="wow fadeInUp">
                                {{$cmsContent->page_heading ?? 'Training company specializing in digital media'}}
                            </h2>
                            <div class="search_part">
                                <form method="post" action="{{url('/products')}}" name="simple_course_name_form">
                                    @csrf
                                    <input type="search" class="search" placeholder="{{$cmsContent->search_placeholder ?? 'What do you want to learn?'}}" name="course_name" id="simple_course_name" style="min-width: 290px;">
                                    
                                    <a href="javascript:;">
                                        <button type="submit" class="search-btn btn btn-large course_name_only_search" data-url="{{url('products')}}" style="color: #ffff"> {{$cmsContent->search_button_title ?? ' Search'}}</button>
                                    </a>
                                </form>
                            </div>
                            <p>
                                {{$cmsContent->advance_search_heading ?? 'Want more specific results?'}}
                                <a data-toggle="collapse" class="advance_serch" data-target="#demo1">{{$cmsContent->advance_search_title ?? 'Advanced Search'}}</a>
                            </p>

                            @include('frontend.home.advance-filter')
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- services section -->
        @include('frontend.home.services')


        @include('frontend.home.training-category')

        
        @include('frontend.home.manufacturer-courses')
        
        @include('frontend.home.testimonial-company')
        
        
    </div>

    @include('frontend.layouts.footer')

    <!-- The contact us Modal -->
    @include('frontend.includes.contact-us')
    <!-- The Modal -->
    <!-- request a quote modal -->
@endsection
@section('scripts')

@if(session('verifymessage'))
    <script type="text/javascript">
        Swal.fire({
            title: 'Thank You!',
            text: "{{ session('verifymessage') }}",
            icon: 'success',
            confirmButtonText: 'Ok'
        });
    </script>
@endif
@if(session('verifyinfo'))
    <script type="text/javascript">
        Swal.fire({
            title: 'Thank You!',
            text: "{{ session('verifyinfo') }}",
            icon: 'info',
            confirmButtonText: 'Ok'
        });
    </script>
@endif

<script type="text/javascript">
    if (window.location.hash && window.location.hash == '#_=_') {
        window.location.hash = '';
    }
</script>
@endsection
