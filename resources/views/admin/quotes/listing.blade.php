@if(count($data)>0)
	@php
	$i= ($data->currentPage() - 1) * $data->perPage() + 1;
	@endphp

	@foreach($data as $row)
		<tr>
			<td>{{$i}}</td>
			<td>{{$row->first_name}} {{$row->last_name}}</td>
			<td>{{$row->email ? $row->email : 'N/A'}}</td>
			<td>
				{{$row->country_code ? $row->country_code : ''}}-{{$row->phone ? $row->phone : 'N/A'}}
			</td>
			<td>{{$row->company_name ? $row->company_name : 'N/A'}}</td>
			<td>{{$row->course ? $row->course : 'N/A'}}</td>
			<td>{{$row->city}}, {{$row->state}}, {{$row->country}}, {{$row->zipcode}}</td>
			<td>
				@if($row->status)
				<a class="label label-sm label-success change-status" data-id="{{$row->id}}" data-status="1">Completed</a>
				@else
				<a class="label label-sm label-danger change-status" data-id="{{$row->id}}" data-status="0">Pending</a>
				@endif
			</td>
			<td>
				{{date('d/m/Y', strtotime($row->created_at))}}
			</td>
			<td>
				<div class="actions">
					<div class="btn-group">
						<a class="label label-primary dropdown-toggle" href="javascript:;" data-toggle="dropdown" aria-expanded="true">
							Actions <i class="fa fa-angle-down"></i>
						</a>
						<ul class="dropdown-menu pull-right">
							<li>
								<a data-href="" class="view view_message" data-message="{{$row->message}}">
									<i class="icon-eye"></i> View Message
								</a>
							</li>
						</ul>
					</div>
				</div>
			</td>
		</tr>
		@php $i++; @endphp
	@endforeach
	<tr>
		<td colspan="12">{{ $data->links() }}</td>
	</tr>
	@else
	<tr>
		<td colspan="12" style="text-align: center !important;">No Data Available</td>
	</tr>
@endif