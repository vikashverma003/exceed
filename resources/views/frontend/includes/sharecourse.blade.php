<div class="modal fade bs-example-modal-lg home_contact-model shareCourseModal" id="shareCourseModal" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" role="document">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title" style="text-align: center;">Share this course</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <form method="post" name="shareForm" id="share_course_form">
                            <input type="hidden" name="share_course_id" value="">
                            <div class="form-group">
                                <label for="recipient-name" class="col-form-label">Recipient Email:</label>
                                <input type="text" class="form-control" id="recipient-name" name="email">
                                <span class="error share_email_error" style="top: 5px !important;"></span>
                            </div>
                            <div class="form-group">
                                <label for="recipient-name" class="col-form-label">Message:</label>
                                <textarea name="message" class="form-control" placeholder="Enter message for recipient"></textarea>
                                <span class="error share_message_error" style="top: 5px !important;"></span>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal-footer" style="text-align: center;">
                <button type="button" class="btn btn-secondary share_course_btn" style="width: 100%">Share</button>
            </div>
        </div>
    </div>
</div>