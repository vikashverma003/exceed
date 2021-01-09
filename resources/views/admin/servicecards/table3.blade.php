<form name="filter_listing">
	<table class="table table-striped table-bordered table-hover dataTable no-footer" id="datatable3_ajax" aria-describedby="datatable_ajax_info" role="grid">
		<thead>
			<tr role="row" class="heading">
				<th style="text-align: center;"  width="10%" class="sorting" tabindex="0" aria-controls="datatable3_ajax" rowspan="1" colspan="1">
					Sr. No
				</th>
				<th  class="sorting" tabindex="0" aria-controls="datatable3_ajax" rowspan="1" colspan="1">
					{{\App\Models\Cms::first()->service_card_3_title }} Service
				</th>
				<th  class="sorting" tabindex="0" aria-controls="datatable3_ajax" rowspan="1" colspan="1">
					Actions
				</th>
			</tr>
		</thead>
		<tbody id="dynamicContent">
			@if(count($data)>0)
				@php
				$i= 1;
				@endphp

				@foreach($data->where('card_number', 3) as $row)
				<tr>
					<td style="text-align: center;">{{$i}}</td>
					
					<td>{{$row->title ? $row->title : 'N/A'}}</td>
					<td>
						<div class="actions">
							<div class="btn-group">
								<a class="label label-primary dropdown-toggle" href="javascript:;" data-toggle="dropdown" aria-expanded="true">
									Actions <i class="fa fa-angle-down"></i>
								</a>
								<ul class="dropdown-menu pull-right">
									<li>
										<a href="{{url('admin/servicecards/'.$row->id.'/edit')}}" class="view">
											<i class="icon-pencil "></i> Edit
										</a>
									</li>
									<li>
										<a href="javascript:;" class="view delete-record" data-id="{{$row->id}}">
											<i class="icon-trash "></i> Delete
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
		</tbody>
	</table>
</form>