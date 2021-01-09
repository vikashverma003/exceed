@if($relatedCourse->count()>0)
    <div class="testimonial_section course-tesimonial related_courses" style="overflow: hidden;">
        <div class="container">
            <div class="row">
                <h2 class="related-courses">Related Courses</h2>
                <div class="col-md-12">
                    <div class="carousel-wrap" >
                    <div class="owl-carousel" style="display: flex">
                        @foreach($relatedCourse as $row)
                            <div class="item">
                                <a href="{{url('/course/'.$row->course_name_slug)}}">
                                    <div class="togerther_img">
                                        <img src="{{asset('uploads/courses/'.$row->image)}}">
                                        <div class="bottom_together">
                                            <h2>{{str_limit($row->name, 50)}}</h2>
                                            <span class="ade-txt">AED {{!is_null($row->offer_price) ? $row->offer_price : '(N/A)'}}</span>
                                            <span class="crosss">AED {{!is_null($row->price) ? $row->price : '(N/A)'}}</span>
                                            @if(!is_null($row->duration))
                                            <div class="during_days">
                                                <img src="{{asset('img/ic_duration.svg')}}">
                                                <span>Duration: {{$row->duration}} {{$row->duration_type}}</span>
                                            </div>
                                            @endif
                                            <div class="during_days">
                                                <img src="{{asset('img/ic1_viewed_by.svg')}}">
                                                <span>Views: {{$row->views}}</span>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div></div>
            </div>
        </div>
    </div>
@endif