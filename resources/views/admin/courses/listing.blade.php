@if(count($data)>0)
	@php
	$i= ($data->currentPage() - 1) * $data->perPage() + 1;
	@endphp

	@foreach($data as $row)
		<tr>
			<td>{{$i}}</td>
			
			<td>{{$row->name ? $row->name : 'N/A'}}</td>
			
			<td>{{$row->manufacturer->name ? $row->manufacturer->name : 'N/A'}}</td>
			
			<td>{{$row->category->name ? $row->category->name : 'N/A'}}</td>
			
			<td>{{$row->product->name ? $row->product->name : 'N/A'}}</td>

			<td>
				<a class="btn btn-xs default btn-editable view-desc" data-id="{{$row->id}}" onclick="showDesc(this);">
				<i class="fa fa-search"></i> View Schedule
			</a>
			</td>
			
			<td>
				<span><strong>Original</strong>: {{$row->price ? $row->price : 0}}</span> 
				<span><strong>Offer</strong>: {{$row->offer_price ? $row->offer_price : 0}}</span>
			</td>
			<td>{{$row->order}}</td>
			<td>
				@if($row->status)
					<a class="label label-sm label-success" data-status="0" data-id="{{$row->id}}">Published</a>
				@else
					<a class="label label-sm label-danger" data-status="1" data-id="{{$row->id}}">Unpublished</a>
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
								@if($row->status)
									<a class="view change-status" data-status="0" data-id="{{$row->id}}"><i class="icon-info"></i> Unpublish</a>
								@else
									<a class="view change-status" data-status="1" data-id="{{$row->id}}"><i class="icon-info"></i> Publish</a>
								@endif
								
							</li>
							<li>
								<a href="javascript:;" class="view delete-record" data-id="{{$row->id}}">
									<i class="icon-trash"></i> Delete
								</a>
							</li>
							<li>
								<a href="{{url('admin/courses/'.$row->id.'/edit')}}" class="view">
									<i class="icon-pencil"></i> Edit
								</a>
							</li>
							<li>
								<a href="{{url('admin/outlines/'.$row->id)}}" class="view">
									<i class="icon-list"></i> Course Outlines
								</a>
							</li>

							<li>
								<a href="{{url('admin/course-time/'.$row->id)}}" class="view">
									<i class="icon-list"></i> Locations & Timings
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
		<td colspan="12">No Data Available</td>
	</tr>
@endif