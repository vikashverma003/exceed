<div class="modal fade bs-example-modal-lg home_contact-model courseLocationModal" id="courseLocationModal" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content" role="document">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title yes_location" style="text-align: center;">Schedules</h4>
            </div>
            <form name="course_location_form" id="course_location_form">
                <input type="hidden" name="location_modal_term" value="" id="location_modal_term">
                <input type="hidden" name="location_modal_name" value="" id="location_modal_name">
                <div class="modal-body">
                    <div class="table-wrapper-scroll-y my-custom-scrollbar" style="max-height: 400px;overflow-y: scroll;">
                        <table class="table table-bordered yes_location">
        				    <thead>
        						<tr class="danger">
        							<th>Country</th>
                                    <th>City</th>
                                    <th>Location</th>
                                    <th>TimeZone</th>
                                    <th>Training Method</th>
        							<th>Start Date</th>
                                    <th>End Date</th>
        							<th>Time</th>
                                    <th>Select</th>
        						</tr>
        				    </thead>
        				    <tbody class="course_location_body ">
        				      	
        				    </tbody>
        				</table>
                    </div>
                    <p class="no_location text-center" style="display: none;">There is no schedule for this course yet !!</p>
                    <p class="no_location_price text-center" style="display: none;">There is no price available for this course yet !!</p>
                    <p class="no_location stleClassColor text-center showCourseListingQuoteModal" data-name="" data-id="" style="display: none; cursor: pointer;">
                        <span>Request a Quote Now</span>
                        <p class="no_location_price stleClassColor text-center showCourseListingQuoteModal" data-name="" data-id="" style="display: none; cursor: pointer;">
                        <span>Request a Quote Now</span>
                    </p>
                    <div class="yes_location full-width text-center row" style="text-align: center;">
                        <div class="col-md-6 text-right">
                            <button type="button" class="add-cart btn btn-large addCartShortCutBtn" data-course="" style="width: 50%;background: #efa91e;" value="0">
                                Add to Cart
                            </button>
                        </div>
                        <div class="col-md-6 text-left">
                            <button type="button" class="add-cart btn btn-large courseLocationQuoteNow" data-course="" style="width: 50%;background: #535274;">
                                Request a Quote Now
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>