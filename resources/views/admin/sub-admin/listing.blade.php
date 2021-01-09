@if(count($users)>0)
@php
	$i= ($users->currentPage() - 1) * $users->perPage() + 1;
@endphp

@foreach($users as $user)
<tr>
	<td>{{$i}}</td>
	<td>{{$user->name ? $user->name : 'N/A'}}</td>
	<td>{{$user->email ? $user->email : 'N/A'}}</td>
	
	<td>
		@if($user->status)
			<a class="label label-sm label-success" data-status="0" data-id="{{$user->id}}">Enabled</a>
		@else
			<a class="label label-sm label-danger" data-status="1" data-id="{{$user->id}}">Disabled</a>
		@endif
	</td>

	<td>
		{{date('d/m/Y', strtotime($user->created_at))}}
	</td>
	<td>
		<div class="actions">
			<div class="btn-group">
				<a class="label label-primary dropdown-toggle" href="javascript:;" data-toggle="dropdown" aria-expanded="true">
					Actions <i class="fa fa-angle-down"></i>
				</a>
				<ul class="dropdown-menu pull-right">
					
					<li>
						<a href="{{url('admin/sub-admin/'.$user->id)}}" class="view">
							<i class="icon-eye"></i> View Detail
						</a>
					</li>
					<li>
						<a href="{{url('admin/sub-admin/'.$user->id.'/edit')}}" class="view">
							<i class="icon-pencil"></i> Edit
						</a>
					</li>
					<li>
						<a href="javascript:;" class="view delete-record" data-id="{{$user->id}}">
							<i class="icon-trash"></i> Delete
						</a>
					</li>
					<li>
						@if($user->status)
							<a class="view change-status" data-status="0" data-id="{{$user->id}}"><i class="icon-info"></i>Disable</a>
						@else
							<a class="view change-status" data-status="1" data-id="{{$user->id}}"><i class="icon-info"></i>Enable</a>
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
	<td colspan="12">{{ $users->links() }}</td>
</tr>
@else
<tr>
	<td colspan="12">No Data Available</td>
</tr>
@endif