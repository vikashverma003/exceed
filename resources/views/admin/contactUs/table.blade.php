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
				<th width="15%" class="sorting" tabindex="0" aria-controls="datatable_ajax" rowspan="1" colspan="1">
					Email
				</th>
				<th width="10%" class="sorting" tabindex="0" aria-controls="datatable_ajax" rowspan="1" colspan="1">
					Phone
				</th>
				<th width="12%" class="sorting" tabindex="0" aria-controls="datatable_ajax" rowspan="1" colspan="1">
					Company Name
				</th>
				<th width="12%" class="sorting" tabindex="0" aria-controls="datatable_ajax" rowspan="1" colspan="1">
					Address
				</th>
				<th width="12%" class="sorting" tabindex="0" aria-controls="datatable_ajax" rowspan="1" colspan="1">
					Status
				</th>
				<th width="10%" class="sorting" tabindex="0" aria-controls="datatable_ajax" rowspan="1" colspan="1">
					Date
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
					<input type="text" class="form-control form-filter input-sm" name="email" id="email" placeholder="Email">
				</td>
				<td rowspan="1" colspan="1">
					<input type="text" class="form-control form-filter input-sm" name="phone" id="phone" placeholder="Phone">
				</td>
				<td rowspan="1" colspan="1"></td>
				<td rowspan="1" colspan="1"></td>
				<td rowspan="1" colspan="1">
					<select name="status" class="form-control" id="filterStatus">
						<option value="">Status</option>
						<option value="1">Completed</option>
						<option value="0">Pending</option>
					</select>
				</td>
				<td rowspan="1" colspan="1">
					<input type="text" class="form-control form-filter input-sm" name="from_date" id="from_date" placeholder="From" />
					&nbsp;
					<input type="text" class="form-control form-filter input-sm" name="to_date" id="to_date" placeholder="To" />

				</td>
				<td rowspan="1" colspan="1">
					<button class="btn btn-sm red filter-cancel"><i class="fa fa-times"></i> Reset</button>
				</td>
			</tr>
		</thead>
		<tbody id="dynamicContent">
			@include('admin.contactUs.listing')
		</tbody>
	</table>
</form>