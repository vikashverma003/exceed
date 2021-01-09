@if(count($transactions)>0)
@php
	$i= ($transactions->currentPage() - 1) * $transactions->perPage() + 1;
@endphp

@foreach($transactions as $row)
<tr>
	<td>{{$i}}</td>
	<td>{{isset($row->id) ? $row->id : 'N/A'}}</td>
	<td>{{isset($row->user->email) ? $row->user->email : 'N/A'}}</td>
	<td>{{isset($row->user->company_name) ? $row->user->company_name : 'N/A'}}</td>
	<td>{{$row->currency ? $row->currency :'AED'}} {{$row->total_amount_paid ? $row->total_amount_paid : '0'}}</td>
	<td>
        @if($row->coupon_applied==1)
            {{$row->discount}}%
        @else
            0%
        @endif
    </td>
	<td class="">{{$row->created_at ? date("d/m/Y", strtotime($row->created_at)) : 'N/A'}}</td>
	<td>
		<div class="actions">
			<div class="btn-group">
				<a class="label label-primary dropdown-toggle" href="javascript:;" data-toggle="dropdown" aria-expanded="true">
					Actions <i class="fa fa-angle-down"></i>
				</a>
				<ul class="dropdown-menu pull-right">
					<li>

						<a href="{{url('admin/order/detail/'.$row->id)}}" class="view">
							<i class="icon-eye"></i> View Detail
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
	<td colspan="12">{{ $transactions->links() }}</td>
</tr>
@else
<tr>
	<td colspan="12">No Data Available</td>
</tr>
@endif