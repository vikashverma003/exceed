@extends('frontend.layouts.app')
@section('title', 'Cookie Policy')


@section('content')

    @include('frontend.layouts.header')

    <div class="main_section">
        <div class="press-rlaes-page">
            <div class="container">
                <div class="row">
                    <div class="col col-md-12 text-center">
                        <h2>Cookie Policy</h2>
                    </div>
                </div>
            </div>
        </div>
        <div class="press-both">
            <div class="container">
                <div class="row">
                    <div class="col col-md-12">
                    	{!! $content !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
   @include('frontend.layouts.footer',['homeFooter'=>0])
   @include('frontend.includes.contact-us')
@endsection