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
				<th width="12%" class="sorting" tabindex="0" aria-controls="datatable_ajax" rowspan="1" colspan="1">
					Status
				</th>
				<th width="12%" class="sorting" tabindex="0" aria-controls="datatable_ajax" rowspan="1" colspan="1">
					Action
				</th>
			</tr>
		</thead>
		<tbody id="dynamicContent">
			@include('admin.training_types.listing')
		</tbody>
	</table>
</form>