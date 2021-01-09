<h2 style="padding: 12px;background: #efa91f2e;margin-bottom: 0;font-size: 20px;">
	Training Categories 
</h2>

@foreach(@$categories as $row)
	@if(in_array(str_slug($row->name),$urlCategories) || $family==$row->id)
		<h2 style="cursor: pointer; margin-bottom: 0px;border-bottom: 1px solid #ddd;" data-toggle="collapse" href="#collapseCategory{{$row->id}}" class="top_heading_class">
			<strong style="font-size: 14px;">
				{{strtoupper($row->name)}}
			</strong>
			<span class="plus-sign float-right">^</span>
			<span class="minus-sign float-right">^</span>
		</h2>
		<div class="collapse show" id="collapseCategory{{$row->id}}">
			<div>
			    @foreach(@$manufacturers as $rrow)
		            @php
		                $manufacturersAvail = \App\Models\Product::where('category_id', $row->id)->where('status', 1)->where('manufacturer_id', $rrow->id)->get(); 
		            @endphp

		            @if($manufacturersAvail->count())
		                <h2>{{$rrow->name}}</h2>
		                <ul class="pl-3">
		                    @foreach($manufacturersAvail as $subrow)
		                        <li>
		                            <label style="cursor: pointer;">
		                            	<input type="checkbox" name="courses[]" value="{{str_slug($subrow->name)}}" data-name="{{str_slug($subrow->name)}}" 
			                            data-categoryid="{{$row->id}}"
			                            class="mr-2 productLeftFilter leftFilter" @if(in_array($subrow->id, $products_id)) checked @endif>
		                            	{{ucfirst($subrow->name)}}
		                            </label>
		                        </li>
		                    @endforeach
		                </ul>
		            @endif
		        @endforeach
			</div>
		</div>
	@endif
@endforeach

@foreach(@$categories as $row)
@php
                                            $check_status = 0;
                                            $course_count = 0;
                                            if($row->courses->count() && $row->manufacturerlists->count())
                                            {
                                                foreach($row->manufacturerlists as $list)
                                                {
                                                    if($list->manufacturer->status == 1 && isset($list->manufacturer->courses))
                                                    {
                                                            $listProducts = \App\Models\Product::where('status',1)->where('category_id',$row->id)->where('manufacturer_id', $list->manufacturer->id)->get();
                                                            if($listProducts->count())
                                                            {
                                                                foreach($listProducts as $product)
                                                                {
                                                                    $productCourses = \App\Models\Course::where('status',1)->where('category_id',$row->id)->where('manufacturer_id', $list->manufacturer->id)->where('product_id',$product->id)->get();
                                                                    if($productCourses->count() > 0)
                                                                    {
                                                                     $course_count = $course_count + 1;   
                                                                    }
                                                                }
                                                            }
                                                    }     
                                                }
                                                foreach($row->courses as $course)
                                                {
                                                    if($course->status == 1)
                                                    {
                                                        $check_status = 1;
                                                    }
                                                }   
                                            }
                                        @endphp
                                         @if($check_status && $course_count)
	@if(!in_array(str_slug($row->name),$urlCategories) && $family!=$row->id)
		<h2 data-toggle="collapse" href="#collapseCategory{{$row->id}}" style="cursor: pointer; margin-bottom: 0px;border-bottom: 1px solid #ddd;" class="top_heading_class collapsed" aria-expanded="false">
			<strong style="font-size: 14px;">
				{{strtoupper($row->name)}}
			</strong>
			<span class="plus-sign float-right">^</span>
			<span class="minus-sign float-right">^</span>
		</h2>
		<div class="collapse" id="collapseCategory{{$row->id}}">
			<div>
			    @foreach(@$manufacturers as $rrow)
		            @php
		                $manufacturersAvail = \App\Models\Product::where('category_id', $row->id)->where('status', 1)->where('manufacturer_id', $rrow->id)->get(); 
		            @endphp

		            @if($manufacturersAvail->count())
		                <h2>{{$rrow->name}}</h2>
		                <ul class="pl-3">
		                    @foreach($manufacturersAvail as $subrow)
		                     @php
                                $product_courses = \App\Models\Course::where('status',1)->where('product_id',$subrow->id)->get();
                             @endphp
                             @if($product_courses->count() > 0)
		                        <li>
		                            <label style="cursor: pointer;">
		                            	<input type="checkbox" name="courses[]" value="{{str_slug($subrow->name)}}" data-name="{{str_slug($subrow->name)}}" 
			                            data-categoryid="{{$row->id}}"
			                            class="mr-2 productLeftFilter leftFilter" @if(in_array($subrow->id, $products_id)) checked @endif>
		                            	{{ucfirst($subrow->name)}}
		                            </label>
		                        </li>
		                       @endif
		                    @endforeach
		                </ul>
		            @endif
		        @endforeach
			</div>
		</div>
	@endif
	@endif
@endforeach
<div class="div_right social float-left mt-3 w-100 text-center">
                            <ul>
                               <li><a href="https://www.facebook.com/exceed.media.training" target="_blank"><i class="fa fa-facebook"></i></a></li>
                               <li><i class="fa fa-twitter" style="margin: 0 10px;"></i></li>
                               <li><i class="fa fa-linkedin"></i></li>
                            </ul>
                        </div>