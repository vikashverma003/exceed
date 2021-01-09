<form name="filter_listing">
	<input type="hidden" name="start" value="">
     <input type="hidden" name="end" value="">
	<table class="table table-striped table-bordered table-hover dataTable no-footer" id="datatable_ajax" aria-describedby="datatable_ajax_info" role="grid">
		<thead>
			<tr role="row" class="heading">
				<th width="3%" class="sorting" tabindex="0" aria-controls="datatable_ajax" rowspan="1" colspan="1">
					Sr. No
				</th>
				<th width="15%" class="sorting" tabindex="0" aria-controls="datatable_ajax" rowspan="1" colspan="1">
					Course Name
				</th>
				<th width="20%" class="sorting" tabindex="0" aria-controls="datatable_ajax" rowspan="1" colspan="1">
					Manufacturer
				</th>
				<th width="20%" class="sorting" tabindex="0" aria-controls="datatable_ajax" rowspan="1" colspan="1">
					Category
				</th>
				<th width="20%" class="sorting" tabindex="0" aria-controls="datatable_ajax" rowspan="1" colspan="1">
					Product Family
				</th>
				<th width="5%" class="sorting" tabindex="0" aria-controls="datatable_ajax" rowspan="1" colspan="1">
					Schedules
				</th>
				<th width="5%" class="sorting" tabindex="0" aria-controls="datatable_ajax" rowspan="1" colspan="1">
					Original/Offer Price
				</th>
				<th width="15%" class="sorting" tabindex="0" aria-controls="datatable_ajax" rowspan="1" colspan="1">
					Order
				</th>
				<th width="15%" class="sorting" tabindex="0" aria-controls="datatable_ajax" rowspan="1" colspan="1">
					Status
				</th>
				<th width="15%" class="sorting" tabindex="0" aria-controls="datatable_ajax" rowspan="1" colspan="1">
					Creation Date
				</th>
				<th width="10%" class="sorting" tabindex="0" aria-controls="datatable_ajax" rowspan="1" colspan="1">
					Actions
				</th>
			</tr>
			<tr role="row" class="filter">
				<td rowspan="1" colspan="1"></td>
				<td rowspan="1" colspan="1">
					<input type="text" class="form-control form-filter input-sm" name="name" id="name" placeholder="Name" value="{{@$inputs['name']}}">
				</td>
				<td rowspan="1" colspan="1">
					<select name="manufacturer_name" class="form-control" id="manufacturer_name" onchange="upperFilterManufacturers(this)">
						<option value="">Select</option>
						@foreach($manufacturers as $row)
							<option value="{{$row->id}}" {{$row->id == @$inputs['manufacturer_name']?'selected':''}}>{{ucfirst($row->name)}}</option>
						@endforeach
					</select>
				</td>
				<td rowspan="1" colspan="1">
					<select name="category_name" class="form-control" id="category_name" onchange="upperFilterCategories(this)">
						<option value="">Select</option>
						@foreach($categories as $row)
							<option value="{{$row->id}}" {{$row->id == @$inputs['category_name']?'selected':''}}>{{ucfirst($row->name)}}</option>
						@endforeach
					</select>
				</td>
				<td rowspan="1" colspan="1">
					<select name="product_name" class="form-control" id="product_name">
						<option value="">Select</option>
						@foreach($products as $row)
							<option value="{{$row->id}}" {{$row->id == @$inputs['product_name']?'selected':''}}>{{ucfirst($row->name)}}</option>
						@endforeach
					</select>
				</td>
				<td rowspan="1" colspan="1">
					<input type="text" class="form-control form-filter input-sm" name="from_date" id="from_date" placeholder="From" value="{{@$inputs['from_date']}}" />
					&nbsp;
					<input type="text" class="form-control form-filter input-sm" name="to_date" id="to_date" placeholder="To" value="{{@$inputs['to_date']}}" />
				</td>
				<td rowspan="1" colspan="1"></td>
				<td rowspan="1" colspan="1"></td>
				<td rowspan="1" colspan="1">
					<select name="status" class="form-control" id="filterStatus">
						<option value="">Status</option>
						<option value="1" {{@$inputs['status'] == '1'?'selected':''}}>Published</option>
						<option value="0" {{@$inputs['status'] == '0'?'selected':''}}>Unpublished</option>
					</select>
				</td>
				<td rowspan="1" colspan="1"></td>
				<td rowspan="1" colspan="1">
					<a class="btn btn-sm red " href="{{route('courses.index',['reset'=>'1'])}}"><i class="fa fa-times"></i> Reset</a>
				</td>
			</tr>
		</thead>
		<tbody id="dynamicContent">
			@include('admin.courses.listing')
		</tbody>
	</table>
</form>