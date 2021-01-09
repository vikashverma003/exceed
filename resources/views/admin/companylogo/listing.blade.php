@if(count($data)>0)
	@php
	$i= 1;
	@endphp

	@foreach($data as $row)
	<tr>
		<td>{{$i}}</td>
		<td>{{$row->title ? $row->title : 'N/A'}}</td>
		
		<td>
			<a href="{{asset('uploads/companieslogo/'.$row->logo)}}" target="_blank">
				<img src="{{asset('uploads/companieslogo/'.$row->logo)}}" class="img-circle" style="max-height: 25px;">
			</a>
		</td>
		
		<td>
			@if($row->status)
				<a class="label label-sm label-success" data-status="0" data-id="{{$row->id}}">Enabled</a>
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
							<a href="{{url('admin/companylogos/'.$row->id.'/edit')}}" class="view">
								<i class="icon-pencil "></i> Edit
							</a>
						</li>
						<li>
							<a href="javascript:;" class="view delete-record" data-id="{{$row->id}}">
								<i class="icon-trash "></i> Delete
							</a>
						</li>
						<li>
							@if($row->status)
								<a href="javascript:;" class="change-status view" data-status="0" data-id="{{$row->id}}">
									<i class="icon-info "></i> Disable
								</a>
							@else
								<a href="javascript:;" class="change-status view" data-status="1" data-id="{{$row->id}}">
									<i class="icon-info "></i> Enable
								</a>
							@endif
						</li>
					</ul>
				</div>
			</div>
		</td>
	</tr>
	@php $i++; @endphp
	@endforeach
@endif