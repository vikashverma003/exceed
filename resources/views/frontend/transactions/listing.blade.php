@if(count($transactions)>0)
@php
    $i= ($transactions->currentPage() - 1) * $transactions->perPage() + 1;
@endphp

@foreach($transactions as $row)
<tr class="text-center">
    <td class="">{{$i}}</td>
    <td class="">#{{$row->id ? $row->id : 'N/A'}}</td>
    <td class="">{{$row->created_at ? date("d/m/Y", strtotime($row->created_at)) : 'N/A'}}</td>
    <td class="">{{$row->currency ? $row->currency :'AED'}} {{$row->total_amount_paid ? $row->total_amount_paid : '0'}}</td>
    <td>
        @if($row->coupon_applied==1)
            {{$row->discount}}%
        @else
            0%
        @endif
    </td>
    <td data-list-label="Action" class="action">
        <a title="View Transaction Detail" href="{{ url('/transaction-detail/'.($row->id)) }}" data-id="{{ ($row->id) }}"><i class="fa fa-eye" aria-hidden="true"></i></a>       
    </td>
</tr>
@php $i++; @endphp
@endforeach
<tr>
    <td colspan="8" class="p-0">{{ $transactions->links() }}</td>
</tr>
@else
<tr>
    <td colspan="8" style="text-align: center;">No Transactions Available</td>
</tr>
@endif