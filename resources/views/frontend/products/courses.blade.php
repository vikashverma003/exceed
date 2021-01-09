@if(((isset($_GET['start_date']) && $_GET['start_date']!='') || isset($_GET['end_date']) && $_GET['end_date']!='') || ((isset($inputs['start_date']) && $inputs['start_date']!='') || isset($inputs['end_date']) && inputs['end_date']!=''))
@if($data->count() > 0)
    @foreach(@$data as $row)
        <div class="box_part-result border-top">
            <div class="row">
                <div class="col col-md-4">
                    <div class="images_section">
                        
                        @if($row->image)
                            <img src="{{asset('uploads/courses/'.$row->image)}}">
                        @else
                            <img src="{{asset('img/banner_bg.png')}}">
                        @endif                    
                    </div>
                </div>
                <div class="col col-md-6">
                    <div class="online_livetraning">
                        
                        <p class="mb-0 pb-0">{{$row->name}}</p>
                        <p class="course-list-cat-tag white-bg pt-0 mt-0">
                            <span>{{$row->category->name ?? ''}}</span>
                        </p>
                        <!-- course duration -->
                        @if(!is_null($row->duration))
                        <div class="during_days">
                            <img src="{{asset('img/ic_duration.svg')}}">
                            <span>Duration: {{$row->duration}} {{$row->duration_type}}</span>
                        </div>
                        @endif

                        <!-- course views -->
                        <div class="during_days">
                            <img src="{{asset('img/ic1_viewed_by.svg')}}">
                            <span>{{$row->views}} Views</span>
                        </div>
                        @if($row->short_note)
                            <div class="during_days">
                                <p class="traning_bottom-txt">
                                    <i class="fa fa-info-circle" aria-hidden="true"></i> {{ Str::limit( strip_tags($row->short_note), $limit = 20, $end = '...') }}  
                                </p>
                            </div>
                        @endif

                        

                        <!-- course description -->
                        <p class="traning_bottom-txt" style="word-break: normal !important;">
                            {{str_replace("&nbsp;", " ",Str::limit( strip_tags($row->description), $limit = 150, $end = '...')) }}  
                        </p>
                    </div>

                </div>
                <div class="col col-md-2 text-right">
                    <div class="price_part">
                        <h2>AED  {{!is_null($row->offer_price) ? $row->offer_price : '(N/A)'}}</h2>
                        <p> 
                            @if(!is_null($row->price))
                            AED  {{!is_null($row->price) ? $row->price : '(N/A)'}}
                            @endif
                        </p>
                        
                        
                        <a href="javascript:;" class=" stleClassColor courseLocationBtn " data-id="{{$row->id}}" data-name="{{$row->name}}" data-term="{{encrypt($row->id)}}" style="text-align: right;float: right;position: inherit;right: 0">
                            <button class="mt-2 mr-0 read-more traning-part btn btn-large white" style="width: 122px;">
                                <i class="fa fa-map-marker white " aria-hidden="true"></i> <test class="white"> Schedules</test>
                            </button>
                        </a>

                        @if(!is_null($row->offer_price))
                       <a href="javascript:;" class=" stleClassColor productBuyNow" data-id="{{$row->id}}" data-name="{{$row->name}}" data-term="{{encrypt($row->id)}}" style="text-align: right;float: right;">
                            <button class="mt-2 mr-0 read-more traning-part btn btn-large white">
                                <i class="fa fa-shopping-cart white"></i> <test class="white"> Add To Cart</test>
                            </button>
                        </a>
                         @else
                            <a href="javascript:;" class=" stleClassColor productBuyNow" data-id="{{$row->id}}" data-name="{{$row->name}}" data-term="{{encrypt($row->id)}}" style="text-align: right;float: right;">
                                <button class="mt-2 mr-0 read-more traning-part btn btn-large white">
                                    <i class="fa fa-shopping-cart white"></i> <test class="white"> Add To Cart11</test>
                                </button>
                            </a>
                        @endif

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
            {{ $data->links() }}
            
        </div>
    </div>
@else
    <div class="noitems">
        <p>There is no schedule available for this course. </p>
       
    </div>
@endif
@endif
 

    @if(count($extra_data) > 0)

    @if(count($extra_data) == 1) 
        <h2 class="other_course px-3"> Course</h2>
    @else
        <h2 class="other_course px-3"> Courses</h2>
    @endif
        @foreach(@$extra_data as $row)
            <div class="box_part-result border-top">
                <div class="row">
                    <div class="col col-md-4">
                        <div class="images_section">
                            
                            @if($row->image)
                                <img src="{{asset('uploads/courses/'.$row->image)}}">
                            @else
                                <img src="{{asset('img/banner_bg.png')}}">
                            @endif                    
                        </div>
                    </div>
                    <div class="col col-md-6">
                        <div class="online_livetraning">
                            <!-- <span class="traning_part">· {{$row->category->name}}</span>
                            <span class="traning_part">· {{$row->manufacturer->name}}</span> -->
                            <!-- course name -->
                            <p class="mb-0 pb-0">{{$row->name}}</p>
                            <a href="{{url('/products?family='.$row->category->id)}}"><p class="course-list-cat-tag white-bg pt-0 mt-0 pl-0">
                                <span>{{$row->category->name}}</span><?php echo("&nbsp&nbsp"); ?><span> {{$row->product->name}}</span>
                            </p></a>
                             <p class="course-list-cat-tag white-bg pt-0 mt-0 pl-0"><span>Design Online Live Training</span></p>
                            <!-- course duration -->
                            @if(!is_null($row->duration))
                            <div class="during_days">
                                <img src="{{asset('img/ic_duration.svg')}}">
                                <span>Duration: {{$row->duration}}{{$row->duration_type}}</span>
                            </div>
                            @endif

                            <!-- course views -->
                            <div class="during_days">
                                <img src="{{asset('img/ic1_viewed_by.svg')}}">
                                <span>{{$row->views}} Views</span>
                            </div>
                            @if($row->short_note)
                                <div class="during_days">
                                    <p class="traning_bottom-txt">
                                        <i class="fa fa-info-circle" aria-hidden="true"></i> {{ Str::limit( strip_tags($row->short_note), $limit = 20, $end = '...') }}  
                                        <a class="fav_link ml-1" href="#"><img src="{{asset('img/like.png')}}"> </a>
                                    </p>
                                </div>
                            @endif

                            <!-- course description -->
                            <p class="traning_bottom-txt" style="word-break: normal !important;">
                                {{ Str::limit( strip_tags($row->description), $limit = 150, $end = '...') }}  
                            </p>
                        </div>

                    </div>
                    <div class="col col-md-2 text-right">
                        <div class="price_part">
                            <h2>AED {{!is_null($row->offer_price) ? $row->offer_price : '(N/A)'}}</h2>
                            
                            <p> 
                                @if(!is_null($row->price))
                                AED {{!is_null($row->price) ? $row->price : '(N/A)'}}
                                 @endif
                            </p>
                           
                            
                            <a href="javascript:;" class=" stleClassColor courseLocationBtn " data-id="{{$row->id}}" data-name="{{$row->name}}" data-term="{{encrypt($row->id)}}" style="text-align: right;float: right;position: inherit;right: 0">
                                <button class="mt-2 mr-0 read-more traning-part btn btn-large white" style="width: 122px;">
                                    <i class="fa fa-map-marker white " aria-hidden="true"></i> <test class="white"> Schedules</test>
                                </button>
                            </a>

                            @if(!is_null($row->offer_price))

                           <a href="javascript:;" class=" stleClassColor productBuyNow" data-id="{{$row->id}}" data-name="{{$row->name}}" data-term="{{encrypt($row->id)}}" style="text-align: right;float: right;">
                                <button class="mt-2 mr-0 read-more traning-part btn btn-large white">
                                    <i class="fa fa-shopping-cart white"></i> <test class="white"> Add To Cart</test>
                                </button>
                            </a>
                            @else
                      <a href="javascript:;" class=" stleClassColor productBuyNow" data-id="{{$row->id}}" data-name="{{$row->name}}" data-term="{{encrypt($row->id)}}" style="text-align: right;float: right;">
                                <button class="mt-2 mr-0 read-more traning-part btn btn-large white">
                                    <i class="fa fa-shopping-cart white"></i> <test class="white"> Add To Cart</test>
                                </button>
                            </a>
                            @endif

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

        {{-- <div class="col-md-12 text-center">
            <div class="pagination pagination--left">
                {{ $extra_data->links() }}
                
            </div>
        </div> --}}
    @endif
    <br>
    <br>

    @if(count($suggestions) > 0)
    <h2 class="other_course px-3">Other Suggested Courses</h2>
        @foreach(@$suggestions as $row)
            <div class="box_part-result border-top">
                <div class="row">
                    <div class="col col-md-4">
                        <div class="images_section">
                            
                            @if($row->image)
                                <img src="{{asset('uploads/courses/'.$row->image)}}">
                            @else
                                <img src="{{asset('img/banner_bg.png')}}">
                            @endif                    
                        </div>
                    </div>
                    <div class="col col-md-6">
                        <div class="online_livetraning">
                            <!-- <span class="traning_part">· {{$row->category->name}}</span>
                            <span class="traning_part">· {{$row->manufacturer->name}}</span> -->
                            <!-- course name -->
                            
                            <p class="mb-0 pb-0">{{$row->name}}</p>
                            <a href="{{url('/products?family='.$row->category->id)}}"><p class="course-list-cat-tag white-bg pt-0 mt-0 pl-0">
                                <span>{{$row->category->name}}</span><?php echo("&nbsp&nbsp"); ?><span> {{$row->product->name}}</span>
                            </p></a>
                            <!--<a href="{{url('/products?family='.$row->category->id)}}"><p class="course-list-cat-tag white-bg pt-0 mt-0">
                                <span>{{$row->category->name}}</span>
                            </p></a>-->
                             <p class="course-list-cat-tag white-bg pt-0 mt-0"><span>Design Online Live Training</span></p>
                            <!-- course duration -->
                            @if(!is_null($row->duration))
                            <div class="during_days">
                                <img src="{{asset('img/ic_duration.svg')}}">
                                <span>Duration: {{$row->duration}} {{$row->duration_type}}</span>
                            </div>
                            @endif

                            <!-- course views -->
                            <div class="during_days">
                                <img src="{{asset('img/ic1_viewed_by.svg')}}">
                                <span>{{$row->views}} Views</span>
                            </div>
                            @if($row->short_note)
                                <div class="during_days">
                                    <p class="traning_bottom-txt">
                                        <i class="fa fa-info-circle" aria-hidden="true"></i> {{ Str::limit( strip_tags($row->short_note), $limit = 20, $end = '...') }}  
                                    </p>
                                </div>
                            @endif

                            

                            <!-- course description -->
                            <p class="traning_bottom-txt" style="word-break: normal !important;">
                                {{ Str::limit( strip_tags($row->description), $limit = 150, $end = '...') }}  
                            </p>
                        </div>

                    </div>
                    <div class="col col-md-2 text-right">
                        <div class="price_part">
                            <h2>AED {{!is_null($row->offer_price) ? $row->offer_price : '(N/A)'}}</h2>
                            <p>
                                 @if(!is_null($row->price))
                                 AED {{!is_null($row->price) ? $row->price : '(N/A)'}}
                                 @endif
                             </p>
                            
                            <a href="javascript:;" class=" stleClassColor courseLocationBtn " data-id="{{$row->id}}" data-name="{{$row->name}}" data-term="{{encrypt($row->id)}}" style="text-align: right;float: right;position: inherit;right: 0">
                                <button class="mt-2 mr-0 read-more traning-part btn btn-large white" style="width: 122px;">
                                    <i class="fa fa-map-marker white " aria-hidden="true"></i> <test class="white"> Schedules</test>
                                </button>
                            </a>

                            @if(!is_null($row->offer_price))
                           <a href="javascript:;" class=" stleClassColor productBuyNow" data-id="{{$row->id}}" data-name="{{$row->name}}" data-term="{{encrypt($row->id)}}" style="text-align: right;float: right;">
                                <button class="mt-2 mr-0 read-more traning-part btn btn-large white">
                                    <i class="fa fa-shopping-cart white"></i> <test class="white"> Add To Cart</test>
                                </button>
                            </a>
                           
                            @endif

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
                {{ $suggestions->links() }}
                
            </div>
        </div>
    @endif
    
