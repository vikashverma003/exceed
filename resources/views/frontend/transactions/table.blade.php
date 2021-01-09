<form name="filter_listing" class="col-md-12">
    <table class="table table-striped table-bordered table-hover dataTable no-footer" id="datatable_ajax" aria-describedby="datatable_ajax_info" role="grid">
        <thead>
            <tr role="row" class="heading text-center">
                <th class="">Sr. No.</th>
                <th class="">Order ID</th>
                <th class="">Purchase Date</th>
                <th class="">Total Amount</th>
                <th class="">Coupon Discount</th>
                <th class="">Action</th>
            </tr>
            <tr role="row" class="filter">
                <td rowspan="1" colspan="1" class="text-center">#</td>
                <td rowspan="1" colspan="1" class="text-center">#</td>
                <td rowspan="1" colspan="1">
                    <input type="text" class="form-control form-filter input-sm start-date" name="from_dates" id="from_dates" placeholder="From" autocomplete="off">
                    <input type="text" class="form-control form-filter input-sm end-date" name="to_dates" id="to_dates" placeholder="To" autocomplete="off">

                </td>
                <td rowspan="1" colspan="1">
                    <input type="text" class="form-control form-filter input-sm" name="amount" id="amount" placeholder="Search Amount" autocomplete="off">
                </td>
                <td rowspan="1" colspan="1">
                    <input type="text" class="form-control form-filter input-sm" name="discount" id="discount" placeholder="Search Discount" autocomplete="off">
                </td>
                <td rowspan="1" colspan="1">
                    <button type="button" class="btn btn-sm btn-danger filter-cancel"><i class="fa fa-times"></i> Reset</button>
                    
                </td>
            </tr>
        </thead>
        <tbody id="dynamicContent">
            @include('frontend.transactions.listing')
        </tbody>
    </table>
</form>