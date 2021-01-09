@extends('frontend.layouts.app')
@section('title', 'Help')
@section('content')
@include('frontend.layouts.header')
<div class="main_section">
    <div class="press-rlaes-page">
        <div class="container">
            <div class="row">
                <div class="col col-md-12 text-center">
                    <h2>Help</h2>
                </div>
            </div>
        </div>
    </div>
    <div class="press-both">
        <div class="container">
            <div class="row">
                <div class="col col-md-12">
                    <div class="accordion" id="accordionExampleFaq">
                        @php
                            $faqi = 0;
                        @endphp
                        @foreach($data as $key=>$value)
                            <div class="card">
                                <div class="card-header" id="headingOne{{$key}}">
                                    <h5 class="mb-0" data-toggle="collapse" data-target="#collapseOne{{$key}}" aria-expanded="true" aria-controls="collapseOne" style="cursor: pointer;">
                                        <button class="btn btn-link" type="button" >
                                        {{$value->title}}
                                        </button>
                                    </h5>
                                </div>
                                <div id="collapseOne{{$key}}" class="collapse @if($faqi==0)show @endif" aria-labelledby="headingOne{{$key}}" data-parent="#accordionExampleFaq">
                                    <div class="card-body">
                                        {!! $value->content !!}
                                    </div>
                                </div>
                            </div>
                            @php
                                $faqi++;
                            @endphp
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@include('frontend.layouts.footer',['homeFooter'=>0])
@include('frontend.includes.contact-us')
@endsection