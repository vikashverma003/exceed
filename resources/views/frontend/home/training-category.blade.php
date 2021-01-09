<div class="traning-catgoary testimonial_section">
    <div class="container">
        <div class="row">
            <div class="col col-md-6">
                <div class="taning-txt">
                    <h2> {{$cmsContent->category_title ?? 'Training Category'}}</h2>
                    <p>{{$cmsContent->category_sub_title ?? 'Browse Exceed Media training category'}}</p>
                </div>
            </div>
            <div class="col col-md-6 text-right">
                <div class="view_class">
                    <h2> <a href="{{url('/products')}}" class="stleClassColor">View all Courses <img src="{{asset('img/ic_view_more_arrow.svg')}}"></a> </h2>
                </div>
            </div>
        </div>
        <!-- category_scroll -->
        <div class="">
            <div class="row">
                @php 
                    $category_i = 1;
                    $key = 0;
                @endphp
                @foreach($categories as $value)
                    @php
                        $check_status = 0;
                        $course_count = 0;
                        if($value->courses->count() && $value->manufacturerlists->count())
                        {
                            foreach($value->manufacturerlists as $list)
                            {
                                if($list->manufacturer->status == 1 && isset($list->manufacturer->courses))
                                {
                                    $listProducts = \App\Models\Product::where('status',1)->where('category_id',$value->id)->where('manufacturer_id', $list->manufacturer->id)->get();
                                    if($listProducts->count())
                                    {
                                        foreach($listProducts as $product)
                                        {
                                            $productCourses = \App\Models\Course::where('status',1)->where('category_id',$value->id)->where('manufacturer_id', $list->manufacturer->id)->where('product_id',$product->id)->get();
                                            if($productCourses->count() > 0)
                                            {
                                                $course_count = $course_count + 1;   
                                            }
                                        }
                                    }
                                }     
                            }
                            foreach($value->courses as $course)
                            {
                                if($course->status == 1)
                                {
                                    $check_status = 1;
                                }
                            }   
                        }
                    @endphp
                    @if($check_status && $course_count)
                    @if($key==0)
                        <div class="col col-md-6 mt-4 mb-4 wow zoomIn">
                            <div class="design_animation" style="background: #{{$value->color}} !important;">
                    @elseif($key==1)
                        <div class="col col-md-3 mt-4 mb-4 wow zoomIn">
                            <div class="design_animation color_change1" style="background: #{{$value->color}} !important;">
                    @elseif($key==2)
                        <div class="col col-md-3 mt-4 mb-4 wow zoomIn">
                            <div class="design_animation color_change2" style="background: #{{$value->color}} !important;">
                    @elseif($key==3)
                        <div class="col col-md-6 mt-4 mb-4 wow zoomIn">
                            <div class="design_animation color_chnge-grey" style="background: #{{$value->color}} !important;">
                    @elseif($key==4)
                        <div class="col col-md-6 mt-4 mb-4 wow zoomIn">
                            <div class="design_animation color_chnge-grey1" style="background: #{{$value->color}} !important;">
                    @elseif($key==5)
                        <div class="col col-md-3 mt-4 mb-4 wow zoomIn">
                            <div class="design_animation color_change1" style="background: #{{$value->color}} !important;">
                    @elseif($key==6)
                        <div class="col col-md-3 mt-4 mb-4 wow zoomIn">
                            <div class="design_animation color_change2" style="background: #{{$value->color}} !important;">
                    @elseif($key==7)
                        <div class="col col-md-6 mt-4 mb-4 wow zoomIn">
                            <div class="design_animation" style="background: #{{$value->color}} !important;">
                    @elseif($key==8)
                        <div class="col col-md-6 mt-4 mb-4 wow zoomIn">
                            <div class="design_animation color_change1" style="background: #{{$value->color}} !important;">
                    @elseif($key==9)
                        <div class="col col-md-6 mt-4 mb-4 wow zoomIn">
                            <div class="design_animation color_change2" style="background: #{{$value->color}} !important;">
                    @else
                        <div class="col col-md-3 mt-4 mb-4 wow zoomIn">
                            <div class="design_animation color_change2" style="background: #{{$value->color}} !important;">
                    @endif
                    
                                <a href="{{url('/products?family='.$value->id)}}">
                                    <div class="animation_img text-right">
                                        <img src="{{asset('uploads/categories/'.$value->logo)}}">
                                    </div>
                                    <div class="animation_txt">
                                        @if($key == 0 || $key == 3 || $key == 4 || $key == 7 || $key == 8 || $key== 9)
                                        <h2>{{Str::limit(ucfirst($value->name), $limit = 60, $end = '...')}} </h2>
                                           <!-- desc with limit -->
                                        <p>{{str_replace("&nbsp;", " ",Str::limit(strip_tags($value->desc), $limit = 200, $end = '...')) }}</p>
                                        @else
                                        <h2>{{Str::limit(ucfirst($value->name), $limit = 35, $end = '...')}} </h2>
                                           <!-- desc with limit -->
                                        <p>{{str_replace("&nbsp;", " ",Str::limit(strip_tags($value->desc), $limit = 40, $end = '...')) }}</p>
                                        @endif
                                         
                                    </div>
                                </a>
                            </div>
                        </div>
                    @php 
                        $category_i++;
                        $key++;
                    @endphp
                    @endif
                @endforeach
            </div>
        </div>
    </div>
</div>