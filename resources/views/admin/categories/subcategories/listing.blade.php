@if(count($data)>0)
	@php
	$i= 1;
	@endphp

	@foreach($data as $row)
	<tr>
		<td>{{$i}}</td>
		<td>{{$row->name ? $row->name : 'N/A'}}</td>
		<td>
			@if($row->status)
				<a class="label label-sm label-success change-status" data-status="0" data-id="{{$row->id}}">Enabled</a>
			@else
				<a class="label label-sm label-danger change-status" data-status="1" data-id="{{$row->id}}">Disabled</a>
			@endif
		</td>
		<td>
			<div class="actions">
				<div class="btn-group">
					<a class="label label-primary dropdown-toggle" href="javascript:;" data-toggle="dropdown" aria-expanded="true">
						Actions <i class="fa fa-angle-down"></i>
					</a>
					<ul class="dropdown-menu pull-right">
						<li>
							<a href="javascript::" class="view">
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