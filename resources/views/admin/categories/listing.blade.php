@if(count($data)>0)
	@php
	$i= 1;
	@endphp

	@foreach($data as $row)
	<tr>
		<td>{{$i}}</td>
		<td>{{$row->name ? $row->name : 'N/A'}}</td>
		<td>
			<a href="{{asset('uploads/categories/'.$row->logo)}}" target="_blank">
				<img src="{{asset('uploads/categories/'.$row->logo)}}" class="img-circle" style="height: 35px; width: 35px;">
			</a>
		</td>
		<td>
			<a href="{{asset('uploads/categories/'.$row->icon)}}" target="_blank">
				<img src="{{asset('uploads/categories/'.$row->icon)}}" class="img-circle" style="height: 35px; width: 35px;">
			</a>
		</td>
		<td>
			<a href="{{asset('uploads/categories/'.$row->banner)}}" target="_blank">
				<img src="{{asset('uploads/categories/'.$row->banner)}}" class="img-circle" style="height: 35px; width: 35px;">
			</a>
		</td>
		<td>
			<div style="background-color: #{{$row->color ? $row->color : ''}}; height: 30px;">#{{$row->color}}</div>
		</td>
		
		<td>
			<a class="btn btn-xs default btn-editable view-desc" data-desc="{{$row->desc}}" onclick="showDesc(this);">
				<i class="fa fa-search"></i> View Description
			</a>
		</td>
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
							<a href="{{url('admin/categories/'.$row->id.'/edit')}}" class="view">
								<i class="icon-pencil"></i> Edit
							</a>
						</li>
						<li>
							<a href="javascript:;" class="view delete-record" data-id="{{$row->id}}">
								<i class="icon-trash"></i> Delete
							</a>
						</li>
						<!-- <li>
							<a href="{{url('admin/subcategories/'.$row->id)}}" class="view">
								<i class="icon-list"></i> Sub-Categories
							</a>
						</li> -->
					</ul>
				</div>
			</div>
		</td>
	</tr>
	@php $i++; @endphp
	@endforeach
@endif