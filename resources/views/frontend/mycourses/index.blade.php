@extends('frontend.layouts.app')
@section('title', 'My Courses')


@section('content')

    @include('frontend.layouts.header')

    <div class="main_section">
        <div class="press-rlaes-page manufacturers_page my-courese_page">
            <div class="container">
                <div class="row">
                    <div class="col col-md-12">
                        <h2>My Courses</h2>
                    </div>
                </div>
            </div>
        </div>
        <div class="my-courese-main_page">
            <div class="container">
                <div class="row">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="activecourse-tab" data-toggle="tab" href="#activecourse" role="tab" aria-controls="activecourse" aria-selected="true" >Active Courses</a>
                        </li>
                        <li class="nav-item"><a class="nav-link" id="pastcourse-tab" data-toggle="tab" href="#pastcourse" role="tab" aria-controls="pastcourse" aria-selected="false" >Past Courses</a>
                        </li>
                    </ul>
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="activecourse" role="tabpanel" aria-labelledby="activecourse-tab">
                            @if(count($courses))
                                
                                @foreach($courses as $row)

                                    @foreach($row['items'] as $subrow)
                                        <div class="photo_txt-both">
                                            <div class="photoshop-img">
                                                <img src="{{asset('uploads/courses/'.($subrow->course->image ?? ''))}}" class="photosss" style="height: 130px">
                                                <div class="imgae-bottom-txt">
                                                    
                                                    <p>{{isset($subrow->course->name)?$subrow->course->name:""}}</p>
                                                    <div class="duration-box">
                                                        <img src="img/ic_duration.svg"><span> Duration: {{$subrow->course->duration}} days</span>
                                                    </div>
                                                    <div class="duration-box box-smal">
                                                        <img src="img/ic1_viewed_by.svg"><span> {{$subrow->course->views}} View</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="txt-photo">
                                                <ul class="photoshop_ul row" style="display: flex">
                                                    <li class="col-md-3 pr-0 pt-0">
                                                        <div class="ul_li-txt">
                                                            <p>{{$subrow->start_date ? date('d/m/Y', strtotime($subrow->start_date)): 'N/A'}}-{{$subrow->date ? date('d/m/Y', strtotime($subrow->date)): 'N/A'}}</p>
                                                            <p><strong>Date</strong></p>
                                                        </div>
                                                    </li>
                                                   <li class="col-md-3 pr-0 pt-0">
                                                        <div class="ul_li-txt">
                                                            <p>
                                                                {{$subrow->location ? $subrow->location : 'N/A'}},
                                                                {{$subrow->city ? $subrow->city : 'N/A'}},
                                                                {{$subrow->country ? $subrow->country : 'N/A'}}
                                                            </p>
                                                            <p><strong>Location</strong></p>
                                                        </div>
                                                    </li>
                                                    <li class="col-md-2 pr-0 pt-0">
                                                        <div class="ul_li-txt">
                                                            <p>{{$subrow->seats ? $subrow->seats: 0}}</p>
                                                            <p><strong>Seats</strong></p>
                                                        </div>
                                                    </li>
                                                    <li class="col-md-2 pr-0 pt-0">
                                                        <div class="ul_li-txt">
                                                            <p>{{$subrow->training_type ? $subrow->training_type: 'N/A'}}</p>
                                                            <p><strong>Training Type</strong></p>
                                                        </div>
                                                    </li>
                                                    <li class="col-md-2 pr-0 pt-0">
                                                        <div class="ul_li-txt">
                                                            <p onclick='showCourseShareModal("{{$subrow->course->id}}");' style="cursor: pointer;color: #EFA91F; font-size: 17px;"><strong><i class="fa fa-share"></i></strong></p>
                                                            <p><strong>Share</strong></p>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    @endforeach
                                    
                                @endforeach 
                            @else
                                <div class="" style="display: block;
                                                    height: auto;
                                                    text-align: center;
                                                    background-color: #d6e9c6;
                                                    line-height: 4;">
                                    
                                    <p style="font-size: 16px;font-weight: 700;">No Active Courses</p>
                                </div>
                            @endif
                        </div>


                        <div class="tab-pane fade" id="pastcourse" role="tabpanel" aria-labelledby="pastcourse-tab">
                            <div class="" style="display: block;
                                                    height: auto;
                                                    text-align: center;
                                                    background-color: #d6e9c6;
                                                    line-height: 4;">
                                    
                                    <p style="font-size: 16px;font-weight: 700;">No Past Courses</p>
                                </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('frontend.layouts.footer',['homeFooter'=>0])
    @include('frontend.includes.contact-us')
    @include('frontend.includes.sharecourse')

@endsection