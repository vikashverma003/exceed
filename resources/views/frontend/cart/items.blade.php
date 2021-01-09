@php
	$now = now()->setTimezone(config('constants.TIMEZONE'));
	$date_now = $now->format("Y-m-d");
	$time_now = $now->format("H:i:s");
	$now_time  =$now->format('Y-m-d H:i:s');
	$countNotAvailable = 0;
@endphp
@foreach(@$cart as $row)
	<div class="row cart-block">
	    <div class="col-md-2">
	        @if($row['course']->image)
				<img src="{{asset('uploads/courses/'.$row['course']->image)}}" class="img-fluid">
			@else
				<img src="{{asset('img/banner_bg.png')}}" class="img-fu">
			@endif
	    </div>
	    <div class="col-md-7 pr-0">
	        <h2 class="mb-0">{{str_limit(ucfirst($row['course']->name), 40)}}</h2>
	        <div class="plus-mius-click">
	            <span class="minus-click seat_minus">-</span>
	            <input class="" type="hidden" min="1" max="20" name="change_course_seat_select" class="change_course_seat_select" value="{{$row['seat']}}" readonly="true" data-id="{{$row['course_timing_id']}}" data-course="{{$row['course_id']}}">
	            <span class="seat_count">{{$row['seat']}} Seats</span>
	            <span class="plus-click seat_plus">+</span>&nbsp;
	        </div>
	        <h2>AED {{$row['offer_price']}} 
	        	<small>
	        	@if($row['price'] != 0)
	        	{{number_format((float)(($row['price']-$row['offer_price'])/$row['price'])*100, 2, '.', '')}}
	        	@else
	        	0
	        	@endif
	        % Off</small>
	        </h2>
	        @if(@$row['course']->status == "0"|| @$row['course']->manufacturer->status == 0 || @$row['course']->category->status == 0 || @$row['course']->product->status == 0 )
	        <p class="removeCourse" style="color: red;">Currently, this course is not available</p>
	        @php $countNotAvailable = $countNotAvailable + 1; @endphp
	        @endif
	    </div>
	    <div class="col-md-3 text-right pl-0 pr-1">
	        <p class="mb-0"><small>
	        	@if(isset($row['timings']->start_date))
	        		{{$row['timings']->start_date ? \Carbon\Carbon::parse($row['timings']->start_date)->format('d/m/Y') : ''}}-
	    		@endif
	    		@if(isset($row['timings']->date))
	    			{{$row['timings']->date ? \Carbon\Carbon::parse($row['timings']->date)->format('d/m/Y') : ''}}
	    		@endif
		    </small></p>
		    @if(!isset($row['timings']->dubai_start_date_time) && isset($row['timings']->start_date))
		    	@if ($date_now > \Carbon\Carbon::parse($row['timings']->start_date))
		    		@php
                        $timelineExpired = true;
                    @endphp
		    		<p class="mb-0"><small class="alert-danger expiredNote">Course Timeline Expired</small></p>
		    	@endif
		    @endif
		    
		    <p class="mb-0"><small>
		    	@if(isset($row['timings']->start_time))
	    			{{$row['timings']->start_time ? date("h:i A", strtotime($row['timings']->start_time)) : 'N/A'}}
	    		@else
	    			N/A
	    		@endif
	    		 - 
	    		@if(isset($row['timings']->end_time))
	    			{{$row['timings']->start_time ? date("h:i A", strtotime($row['timings']->end_time)) : 'N/A'}}
	    		@else
	    			N/A
	    		@endif
		    </small></p>
		    @if(isset($row['timings']->dubai_start_date_time))
		    	@if($row['timings']->dubai_start_date_time < $now_time)
		    		@php
                        $timelineExpired = true;
                       
                    @endphp
		    		<p class="mb-0"><small class="alert-danger expiredNote">Course Timeline Expired</small></p>
		    	@endif
		    @elseif(isset($row['timings']->start_date) && isset($row['timings']->start_time))
		    	@if ((@$date_now == @$row['timings']->start_date && @$time_now > @$row['timings']->start_time))
		    		@php
                        $timelineExpired = true; 
                    @endphp
		    		<p class="mb-0"><small class="alert-danger expiredNote">Course Timeline Expired</small></p>
		    	@endif
		    @endif
		    <p class="mb-0">
		    	<small>
		    	{{isset($row['timings']->training_type) ? $row['timings']->training_type : "Instructor"}}
		    	</small>
		    </p>
	        <p class="mb-0"><img src="{{asset('img/ic_duration.svg')}}"><span>Duration: {{$row['course']->duration}} {{$row['course']->duration_type}}</span></p>
	        <p class="mb-0">
	        	<img src="{{asset('img/ic_location.svg')}}">
		    	<span>{{$row['timings']->city ?? 'city'}}, {{$row['timings']->country ?? 'country'}}</span>
	        </p>
	        <a href="javascript:void();" class="removeCourse" data-course="{{($row['course_id'])}}" data-id="{{$row['course_timing_id']}}">REMOVE <img class="ml-1 failure_remove" src="{{asset('images/failure.png')}}"></a>
	        
	    </div>
	</div>
	<input type="hidden" name='countNotAvailable' id="countNotAvailable" value="{{$countNotAvailable}}">
	<hr>
@endforeach
