@extends('frontend.layouts.app')
@section('title', 'Gallery Page')


@section('content')

    @include('frontend.layouts.header')

    <div class="main_section gallery-page" style="padding-bottom: 0;">
        <div class="press-rlaes-page">
            <div class="container">
                <div class="row">
                    <div class="col col-md-12 text-center">
                        <h2>Gallery</h2>
                    </div>
                </div>
            </div>
        </div>
        <div class="press-both">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="gallery-txt">
                            <h2>Sachtler artemis workshop - Camera stabilizer system</h2>
                        </div>
                    </div>
                    <div class="col col-md-4">
                        <div class="press-left-img">
                            <img src="{{asset('img/1.jpg')}}">
                        </div>
                    </div>
                    <div class="col col-md-5">
                        <div class="press-right-img">
                            <img src="{{asset('img/2.jpg')}}">
                            <img src="{{asset('img/3.jpg')}}">
                        </div>
                    </div>
                    <div class="col col-md-3">
                        <div class="press-left-img">
                            <img src="{{asset('img/4.jpg')}}">
                        </div>
                    </div>


                    <div class="col-md-12 mt-4">
                        <div class="gallery-txt">
                            <h2>Blackmagic Design DaVinci Resolve </h2>
                        </div>
                    </div>

                    <div class="col col-md-4">
                        <div class="press-left-img last">
                            <img src="{{asset('img/5.jpg')}}">
                        </div>
                    </div>
                    <div class="col col-md-8">
                        <div class="press-right-img">
                        <img src="{{asset('img/6.jpg')}}">
                        <img src="{{asset('img/7.jpg')}}">
                    </div>
                </div>
            </div>
            </div>
        </div>
    </div>
    @include('frontend.layouts.footer',['homeFooter'=>0])
    @include('frontend.includes.contact-us')
@endsection