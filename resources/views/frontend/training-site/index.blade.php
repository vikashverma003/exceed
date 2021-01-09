@extends('frontend.layouts.app')
@section('title', 'Training Site Content')

@section('content')

    @include('frontend.layouts.header')

    <div class="main_section">
        <div class="press-rlaes-page">
            <div class="container">
                <div class="row">
                    <div class="col col-md-12 text-center">
                        <h2>{{ucfirst($content->key)}}</h2>
                    </div>
                </div>
            </div>
        </div>
        <div class="press-both">
            <div class="container">
                <div class="row">
                    <div class="col col-md-12">
                    	{!! $content->value !!}
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('frontend.layouts.footer',['homeFooter'=>0])
    @include('frontend.includes.contact-us')
@endsection