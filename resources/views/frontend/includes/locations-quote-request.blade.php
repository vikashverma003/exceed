<div class="modal fade bs-example-modal-lg home_contact-model locationsQuoteQueryModal" id="locationsQuoteQueryModal" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Request a Quote </h4>
                <p>Please fill in the details and we will get back within 24 hrs to help you & your team. We will send the quote to this email - <strong>@auth {{Auth::user()->email}} @endauth</strong></p>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <form method="post" name="locations-quote-query-form" id="locations-quote-query-form" class="quote-query-form-home">
                @csrf
                <input type="hidden" name="locations_course_id" id="locations_course_id" value="">
                <div class="modal-body">
                    <div class="form_section text-area-part">
                        <label>Enter your message<span class="asterisk">*</span></label>
                        <textarea placeholder="Write down your message…" class="messege" name="message"></textarea>
                        <span class="error invalid-feedback message" style="top: 0px !important;"></span>
                    </div>  
                </div>
                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" id="locations-quote-query-form-btn">submit</button>
                </div>
            </form>
        </div>
    </div>
</div>
