@if(count($data)>0)
	@php
	$i= ($data->currentPage() - 1) * $data->perPage() + 1;
	@endphp

	@foreach($data as $row)
	<tr>
		<td>{{$i}}</td>
		<td>{{$row->name ? $row->name : 'N/A'}}</td>
		<td>{{$row->manufacturer['name'] ? $row->manufacturer['name'] : 'N/A'}}</td>
		<td>{{$row->categories['name'] ? $row->categories['name'] : 'N/A'}}</td>
		<td>
			<a href="{{asset('uploads/categories/'.$row->banner)}}" target="_blank">
				<img src="{{asset('uploads/categories/'.$row->banner)}}" class="img-circle" style="height: 35px; width: 35px;">
			</a>
		</td>
		<td>
			<a class="btn btn-xs default btn-editable view-desc" data-desc="{{$row->description}}" onclick="showDesc(this);">
				<i class="fa fa-search"></i> View Comment
			</a>
		</td>
		<td>
			@if($row->status)
				<a class="label label-sm label-success " data-status="0" data-id="{{$row->id}}">Enabled</a>
			@else
				<a class="label label-sm label-danger" data-status="1" data-id="{{$row->id}}">Disabled</a>
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
							<a href="{{url('admin/products/'.$row->id.'/edit')}}" class="view">
								<i class="icon-pencil"></i> Edit
							</a>
						</li>
						<li>
							<a href="javascript:;" class="view delete-record" data-id="{{$row->id}}">
								<i class="icon-trash"></i> Delete
							</a>
						</li>
						<li>
							@if($row->status)
								<a class="view change-status" data-status="0" data-id="{{$row->id}}"><i class="icon-info"></i> Disable</a>
							@else
								<a class="view change-status" data-status="1" data-id="{{$row->id}}"><i class="icon-info"></i> Enable</a>
							@endif
							
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
	<td colspan="12">No Data Available</td>
</tr>
@endif