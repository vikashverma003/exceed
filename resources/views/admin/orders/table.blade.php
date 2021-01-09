<form name="filter_listing">
	<table class="table table-striped table-bordered table-hover dataTable no-footer" id="datatable_ajax" aria-describedby="datatable_ajax_info" role="grid">
		<thead>
			<tr role="row" class="heading">
				<th width="5%" class="sorting" tabindex="0" aria-controls="datatable_ajax" rowspan="1" colspan="1">
					Sr. No
				</th>

				<th width="10%" class="sorting" tabindex="0" aria-controls="datatable_ajax" rowspan="1" colspan="1">
					Order Id
				</th>
				<th width="15%" class="sorting" tabindex="0" aria-controls="datatable_ajax" rowspan="1" colspan="1">
					Email
				</th>
				<th width="15%" class="sorting" tabindex="0" aria-controls="datatable_ajax" rowspan="1" colspan="1">
					Company Name
				</th>
				<th width="15%" class="sorting" tabindex="0" aria-controls="datatable_ajax" rowspan="1" colspan="1">
					Total Amount
				</th>
				<th width="15%" class="sorting" tabindex="0" aria-controls="datatable_ajax" rowspan="1" colspan="1">
					Discount
				</th>
				<th width="15%" class="sorting" tabindex="0" aria-controls="datatable_ajax" rowspan="1" colspan="1">
					Date
				</th>
				
				<th width="10%" class="sorting" tabindex="0" aria-controls="datatable_ajax" rowspan="1" colspan="1">
					Actions
				</th>
			</tr>
			<tr role="row" class="filter">
				<td rowspan="1" colspan="1"></td>
				
				<td rowspan="1" colspan="1">
					<input type="text" class="form-control form-filter input-sm" name="order_id" id="order_id" placeholder="Order id">
				</td>
				<td rowspan="1" colspan="1">
					<input type="text" class="form-control form-filter input-sm" name="email" id="email" placeholder="Email">
				</td>
				<td rowspan="1" colspan="1"></td>
				<td rowspan="1" colspan="1">
					<input type="text" class="form-control form-filter input-sm" name="amount" id="amount" placeholder="Amount">
				</td>
				<td rowspan="1" colspan="1">
					<input type="text" class="form-control form-filter input-sm" name="discount" id="discount" placeholder="Discount">
				</td>
				<td rowspan="1" colspan="1">
					<input type="text" class="form-control form-filter input-sm" name="from_date" id="from_date" placeholder="From" />
					&nbsp;
					<input type="text" class="form-control form-filter input-sm" name="to_date" id="to_date" placeholder="To" />
				</td>
				<td rowspan="1" colspan="1">
					<button type="button" class="btn btn-sm red filter-cancel"><i class="fa fa-times"></i> Reset</button>
				</td>
			</tr>
		</thead>
		<tbody id="dynamicContent">
			@include('admin.orders.listing')
		</tbody>
	</table>
</form>