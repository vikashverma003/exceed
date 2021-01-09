<form name="filter_listing">
	<table class="table table-striped table-bordered table-hover dataTable no-footer" id="datatable_ajax" aria-describedby="datatable_ajax_info" role="grid">
		<thead>
			<tr role="row" class="heading">
				<th width="5%" class="sorting" tabindex="0" aria-controls="datatable_ajax" rowspan="1" colspan="1">
					Sr. No
				</th>
				<th width="15%" class="sorting" tabindex="0" aria-controls="datatable_ajax" rowspan="1" colspan="1">
					Name
				</th>
				<th width="20%" class="sorting" tabindex="0" aria-controls="datatable_ajax" rowspan="1" colspan="1">
					Manufacturer Name
				</th>
				<th width="20%" class="sorting" tabindex="0" aria-controls="datatable_ajax" rowspan="1" colspan="1">
					Category Name
				</th>
				<th width="20%" class="sorting" tabindex="0" aria-controls="datatable_ajax" rowspan="1" colspan="1">
					Banner Image
				</th>
				<th width="10%" class="sorting" tabindex="0" aria-controls="datatable_ajax" rowspan="1" colspan="1">
					Description
				</th>
				<th width="12%" class="sorting" tabindex="0" aria-controls="datatable_ajax" rowspan="1" colspan="1">
					Status
				</th>
				<th width="10%" class="sorting" tabindex="0" aria-controls="datatable_ajax" rowspan="1" colspan="1">
					Actions
				</th>
			</tr>
			<tr role="row" class="filter">
				<td rowspan="1" colspan="1"></td>
				<td rowspan="1" colspan="1">
					<input type="text" class="form-control form-filter input-sm" name="name" id="name" placeholder="Name">
				</td>
				<td rowspan="1" colspan="1">
					<select name="manufacturer_name" class="form-control" id="manufacturer_name">
						<option value="">Manufacturer</option>
						@foreach($manufacturers as $row)
							<option value="{{$row->id}}">{{ucfirst($row->name)}}</option>
						@endforeach
					</select>
				</td>
				<td rowspan="1" colspan="1">
					<select name="category_name" class="form-control" id="category_name">
						<option value="">Category</option>
						@foreach($categories as $row)
							<option value="{{$row->id}}">{{ucfirst($row->name)}}</option>
						@endforeach
					</select>
				</td>
				<td rowspan="1" colspan="1">
					
				</td>
				<td rowspan="1" colspan="1">
					<select name="status" class="form-control" id="filterStatus">
						<option value="">Status</option>
						<option value="1">Enabled</option>
						<option value="0">Disabled</option>
					</select>
				</td>
				<td rowspan="1" colspan="1">
					<button class="btn btn-sm red filter-cancel"><i class="fa fa-times"></i> Reset</button>
				</td>
			</tr>
		</thead>
		<tbody id="dynamicContent">
			@include('admin.products.listing')
		</tbody>
	</table>
</form>