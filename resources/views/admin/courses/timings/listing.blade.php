@if(count($data)>0)
	@php
	$i= 1;
	@endphp

	@foreach($data as $row)
	<tr>
		<td>{{$i}}</td>
		<td>{{$row->country ? $row->country : 'N/A'}}</td>
		
		<td>{{$row->city ? $row->city : 'N/A'}}</td>

		<td>{{$row->location ? $row->location : 'N/A'}}</td>

		<td>{{$row->timezone ? $row->timezone : 'N/A'}}</td>
		
		<td>{{$row->training_type ? $row->training_type : 'N/A'}}</td>
		
		<td>
			{{$row->start_date ? \Carbon\Carbon::parse($row->start_date)->format('d/m/Y') : 'N/A'}}
		</td>

		<td>
			{{$row->date ? \Carbon\Carbon::parse($row->date)->format('d/m/Y') : 'N/A'}}
		</td>
		<td>{{$row->start_time ? $row->start_time : 'N/A'}} - {{$row->end_time ? $row->end_time : 'N/A'}}</td>
		<td>
			<div class="actions">
				<div class="btn-group">
					<a class="label label-primary dropdown-toggle" href="javascript:;" data-toggle="dropdown" aria-expanded="true">
						Actions <i class="fa fa-angle-down"></i>
					</a>
					<ul class="dropdown-menu pull-right">
						<li>
							<a href="javascript:;" class="view edit_btn" data-location="{{$row->location}}" data-timezone="{{$row->timezone??''}}" data-country="{{$row->country}}" data-city="{{$row->city}}" data-id="{{$row->id}}" data-start_date="{{\Carbon\Carbon::parse($row->start_date)->format('d/m/Y')}}" data-date="{{\Carbon\Carbon::parse($row->date)->format('d/m/Y')}}" data-training="{{$row->training_type}}" data-start="{{$row->start_time}}" data-end="{{$row->end_time}}">
								<i class="icon-pencil"></i> Edit
							</a>
						</li>
					</ul>
				</div>
			</div>
		</td>
	</tr>
	@php $i++; @endphp
	@endforeach
@endif