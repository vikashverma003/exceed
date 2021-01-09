@if(count($courses))
	@foreach($courses as $row)
		<div class="box_part-result border-top">
            <div class="row">
                <div class="col col-md-4">
                    <div class="images_section">
                        @if($row->image)
							<img src="{{asset('uploads/courses/'.$row->image)}}">
						@else
							<img src="{{asset('img/6.jpg')}}">
						@endif
                    </div>
                </div>
                <div class="col col-md-6">
                    <div class="online_livetraning">
                        
                        <p class="mb-0 pb-0">{{$row->name}}</p>
                        <p class="course-list-cat-tag white-bg pt-0 mt-0">
                            <span>{{$row->category->name}}</span>
                        </p>
                        <div class="during_days">
                            <img src="{{asset('img/ic_duration.svg')}}">
                            <span>Duration: {{$row->duration}} {{$row->duration_type}}</span>
                        </div>
                        <div class="during_days">
                            <img src="{{asset('img/ic1_viewed_by.svg')}}">
                            <span>Views: {{$row->views}}</span>
                        </div>
                        @if($row->short_note)
                            <div class="during_days">
                                <p class="traning_bottom-txt">
                                    <i class="fa fa-info-circle" aria-hidden="true"></i> {{ Str::limit( strip_tags($row->short_note), $limit = 20, $end = '...') }}  
                                </p>
                            </div>
                        @endif

                        <p class="traning_bottom-txt" style="word-break: normal !important;">
                        	{{ Str::limit( strip_tags($row->description), $limit = 150, $end = '...') }}
                        </p>
                    </div>
                </div>
                <div class="col col-md-2 text-right">
                    <div class="price_part">
                        <h2>AED {{$row->offer_price}}</h2>
                        <p>AED {{$row->price}}</p>


                        <a href="javascript:;" class=" stleClassColor courseLocationBtn " data-id="{{$row->id}}" data-name="{{$row->name}}" data-term="{{encrypt($row->id)}}" style="text-align: right;float: right;position: inherit;right: 0">
                            <button class="mt-2 mr-0 read-more traning-part btn btn-large white" style="width: 122px;">
                                <i class="fa fa-map-marker white " aria-hidden="true"></i> <test class="white"> Schedules</test>
                            </button>
                        </a>

                       <a href="javascript:;" class=" stleClassColor productBuyNow" data-id="{{$row->id}}" data-name="{{$row->name}}" data-term="{{encrypt($row->id)}}" style="text-align: right;float: right;">
                            <button class="mt-2 mr-0 read-more traning-part btn btn-large">
                                <i class="fa fa-shopping-cart white"></i> <test class="white"> Add To Cart</test>
                            </button>
                        </a>

                        
                        <a href="{{url('course/'.$row->course_name_slug)}}" class=" stleClassColor" style="text-align: right;float: right;">
                            <button class="mt-2 mr-0 read-more traning-part btn btn-large white" style="width: 122px;">
                                <test class="white"> Read More</test>
                            </button>
                        </a>
                    </div>
                </div>
            </div>
        </div>
	@endforeach
    <div class="col-md-12 text-center">
        <div class="pagination pagination--left">
            {{ $courses->links() }}
        </div>
    </div>
@else
	<div class="col-md-12 noitems">
	<p>No Course Found</p>
	</div>
@endif