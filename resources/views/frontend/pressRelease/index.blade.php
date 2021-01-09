@extends('frontend.layouts.app')
@section('title', 'Press Release')


@section('content')

    @include('frontend.layouts.header')

    <div class="main_section">
        <div class="press-rlaes-page">
            <div class="container">
                <div class="row">
                    <div class="col col-md-12 text-center">
                        <h2>Press Release</h2>
                    </div>
                </div>
            </div>
        </div>
        <div class="press-both">
            <div class="container">
                <div class="row">
                    <div class="col col-md-6">
                        <div class="press-left-img">
                            <img src="{{asset('img/banner_bg.png')}}">
                        </div>
                    </div>
                    <div class="col col-md-6">
                        <div class="press-right-txt">
                            <h2>May 1, 2015</h2>
                            <h3>Future Media Concepts and Exceed Media Bring Digital Media Training Services To The Middle East and Africa.</h3>
                            <p>New York, NY – May 1st, 2015,  – Future Media Concepts (FMC), the nation's premier digital media training organization, today announced that it has teamed up with Exceed Media to offer its digital media training services in the Middle East and Africa.
                            <br><br>

                            The new expansion, headed by Mohamad Kharsaw, a long-time, established FMC License.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
   @include('frontend.layouts.footer',['homeFooter'=>0])
   @include('frontend.includes.contact-us')
@endsection