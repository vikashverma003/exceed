<div class="service_sction">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="service_txt">
                    <h2>{{$cmsContent->manufacturer_title ?? 'Courses by Manufacturers'}}</h2>
                    <p>{{$cmsContent->manufacturer_sub_title ?? 'Browse Exceed Media Services'}}</p>
                </div>
            </div>
            <!-- scrolling-box -->
            <div class="scrolling-box">
                <div class="row">
                    <div class="carousel-wrap">
                        <div class="owl-carousel">
                            @foreach($manufacturers as $row)
                                <div class="item">
                                    <div class="cbox text-center">
                                        <div class="orange_box no_color-manufa">
                                            <div class="manufacture-images">
                                           <img src="{{asset('uploads/manufacturers/'.$row->logo)}}" class="img-circle"></div>
                                            <!-- <p>{{ucfirst($row->name)}}</p> -->
                                            
                                            <div class="img_manu-txt mt-2">
                                                <h2>
                                                    <!-- <img src="{{asset('img/ic_courses_note.svg')}}"> -->
                                                    <span>{{$row->courses_count}} Courses in total</span>
                                                </h2>
                                            </div>

                                            <div class="view_coures_btn manufacturerCourseBtn">
                                                <a href="{{'manufacturers/'.str_slug($row->name)}}" class=" btn btn_large btn-fill view-btn">View Courses</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>