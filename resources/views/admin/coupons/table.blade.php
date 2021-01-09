<form name="filter_listing">
	<table class="table table-striped table-bordered table-hover dataTable no-footer" id="datatable_ajax" aria-describedby="datatable_ajax_info" role="grid">
		<thead>
			<tr role="row" class="heading">
				<th width="5%" class="sorting" tabindex="0" aria-controls="datatable_ajax" rowspan="1" colspan="1">
					Sr. No
				</th>
				<th width="15%" class="sorting" tabindex="0" aria-controls="datatable_ajax" rowspan="1" colspan="1">
					Code
				</th>
				<th width="15%" class="sorting" tabindex="0" aria-controls="datatable_ajax" rowspan="1" colspan="1">
					Discount (%)
				</th>
				<th width="15%" class="sorting" tabindex="0" aria-controls="datatable_ajax" rowspan="1" colspan="1">
					Usage Limit
				</th>
				<th width="15%" class="sorting" tabindex="0" aria-controls="datatable_ajax" rowspan="1" colspan="1">
					No. of Times Used
				</th>
				<th width="15%" class="sorting" tabindex="0" aria-controls="datatable_ajax" rowspan="1" colspan="1">
					User Email
				</th>
				<th width="15%" class="sorting" tabindex="0" aria-controls="datatable_ajax" rowspan="1" colspan="1">
					Expiry Date
				</th>
				<th width="12%" class="sorting" tabindex="0" aria-controls="datatable_ajax" rowspan="1" colspan="1">
					Status
				</th>
				<th width="12%" class="sorting" tabindex="0" aria-controls="datatable_ajax" rowspan="1" colspan="1">
					Action
				</th>
			</tr>
		</thead>
		<tbody id="dynamicContent">
			@include('admin.coupons.listing')
		</tbody>
	</table>
</form>