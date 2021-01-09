@if(count($data)>0)
	@php
	$i= 1;
	@endphp

	@foreach($data as $row)
	<tr>
		<td>{{$i}}</td>
		<td>{{$row->code ? $row->code : 'N/A'}}</td>
		<td>{{$row->discount ? $row->discount : '0'}}</td>
		<td>{{$row->limit ? $row->limit : '0'}}</td>
		<td>{{$row->used ? $row->used : '0'}}</td>
		<td>{{$row->user->email ? $row->user->email : '0'}}</td>
		<td>
			{{$row->expired_at ? \Carbon\Carbon::parse($row->expired_at)->format('d/m/Y') : 'N/A'}}
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
							<a href="javascript:;" class="class edit-record" data-code="{{$row->code}}" data-discount="{{$row->discount}}" data-limit="{{$row->limit}}" data-used="{{$row->used}}" data-user="{{$row->user_id}}" data-email="{{$row->user->email}}" data-expired="{{\Carbon\Carbon::parse($row->expired_at)->format('d/m/Y')}}" data-id="{{$row->id}}"><i class="fa fa-pencil"></i> Edit</a>
						</li>
						<li>
							<a href="javascript:;" class="view delete-record" data-id="{{$row->id}}">
								<i class="icon-trash"></i> Delete
							</a>
						</li>
						<li>
							@if($row->status)
								<a class="view change-status" data-status="0" data-id="{{$row->id}}"><i class="fa fa-list"></i> Disable</a>
							@else
								<a class="view change-status" data-status="1" data-id="{{$row->id}}"><i class="fa fa-list"></i> Enable</a>
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