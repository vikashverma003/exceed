<div class="testimonial_section">
    <div class="container">
        <div class="row">
            <div class="good_hand-txt">
                <h2>{{$cmsContent->testimonial_title ?? 'You’re in a good hand'}}</h2>
                <p>{{$cmsContent->testimonial_sub_title ?? 'Millions of people around the world have already working with us.'}} </p>
            </div>

            <div class="carousel-wrap">
                <div class="owl-carousel">
                    @foreach($testimonials as $row)
                        <div class="item">
                            <div class="box_testimonial">
                                <p>
                                    {{ Str::limit($row->comment, $limit = 200, $end = '...') }}
                                </p>
                                <div class="testimonial_img">
                                    <img src="{{asset('uploads/testimonials/'.$row->user_image)}}">
                                    <h2><strong>{{$row->user_name}}</strong> {{$row->user_role}}</h2>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

<!-- company logo -->

<div class="companys_name">
    <div class="container">
        <div class="row">
            <div class="carousel-wrap">
                <div class="owl-carousel">
                    @foreach($companies as $row)
                        <div class="item">
                            <img src="{{asset('uploads/companieslogo/'.$row->logo)}}" alt="{{$row->title}}">
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>