<div class="modal fade bs-example-modal-lg home_contact-model courseListingQuote" id="myModal1" data-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Request a Quote </h4>
                
                <p>Please fill in the details and we will get back within 24 hrs to help you & your team. We will send the quote to this email - <strong>@auth {{Auth::user()->email}} @endauth</strong></p>

                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <form method="post" name="quote-query-form" id="quote-query-form">
                @csrf
                <input type="hidden" name="course_page" value="1">
                <input type="hidden" name="course_page_course_id" id="course_page_course_id" value="">
                <div class="modal-body">
                    
                    <div class="form_section full-width">
                        <label>Course </label>
                        <input type="text" placeholder="Enter Course Name" class="name-txt" name="course" readonly>
                        <span class="error invalid-feedback course"></span>
                    </div>
                    <div class="form_section text-area-part">
                        <label>Enter your message</label>
                        <textarea placeholder="Write down your message…" class="messege" name="message"></textarea>
                        <span class="error invalid-feedback message" style="top: 0px !important;"></span>
                    </div>  
                </div>
                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" id="quote-query-form-btn">submit</button>
                </div>
            </form>
        </div>
    </div>
</div>
