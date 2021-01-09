$(document).ready(function(){
    $(document).on('click', '#pdf_invite', function(e){
        e.preventDefault();
        startLoader("body");
        if($(this).data("redirect"))
        $('.invitation_details')[0].reset();
        $(".invitation_details").attr("data-redirect", $(this).data("redirect"));
        $('div.error-msg').empty().hide();
        $('#pdf_form').modal('show');
        stopLoader("body");
    });

    $(document).on('click', '#camera_invite', function(e){
        e.preventDefault();
        startLoader("body");
        $('.invitation_details')[1].reset();
        $("#previewimage").attr("src", "");
        $('#image').val('');
        $(".invitation_details").attr("data-redirect", $(this).data("redirect"));
        $('div.error-msg').empty().hide();
        $('#file_upload').modal('show');
        stopLoader("body");
    });

	$('#end_time').timepicker({
        disableTextInput: true,
        step: 15,
        timeFormat: "h:i A",
        useSelect: false,
        appendTo: function(element) {
            return $(element).parent('div');
        },
        className: 'setScheduleTimePicker',
        noneOption: 'End Time',
        orientation: 'b'
    });

    $('#start_time').timepicker({
        disableTextInput: true,
        step: 15,
        timeFormat: "h:i A",
        useSelect: false,
        appendTo: function(element) {
            return $(element).parent('div');
        },
        className: 'setScheduleTimePicker',
        noneOption: 'Start Time',
        orientation: 'b'
    });

    $(document).on('change', 'input#start_time', function(event) {
        let element = $(event.target);
        let sibling_element = element.parents('.pop-form-sch').next('.pop-form-sch.brdr-none').find('input#end_time');

        if($(element).val() == '') {
            sibling_element.val('').attr('disabled', true);
        }else{
            // set the minTime of the Sibling element
            sibling_element.val('').attr('disabled', false).timepicker('option', 'minTime', moment(element.timepicker('getTime')).add(15, 'minutes').format('hh:mm A'));
        }
    });

    /**
     * Set the Date picker also
     */
    $('#date').datepicker({
        changeMonth: true,
        changeYear: true,
        dateFormat: "M dd, yy",
        defaultDate: new Date(),
        minDate: new Date(),
    });

    /*
    * Set data to session on submit of form.
    */
    $(document).on('submit', '.invitation_details', function(e){
        e.preventDefault();
        startLoader();
        $('div.error-msg').empty().hide();
        // set data to session
        let current = $(this);

        if(!parseInt(current.attr('data-type'))) {
            // pdf invite
            // set the datepicker date
            sendRequest(current);
            return true;
        }
        let image = $('#image_upload')[0].files[0];
        if (image) 
        {
            if($('#image').val()) {
                sendRequest(current);
            }
            else {
                storeinviteImage(image, sendRequest, current);                
            }
            return true;
        }
        stopLoader("body");
        $('#image').val('');
        $('div.error-msg.image').text('Please upload a valid image.').fadeIn();
    });

    function isImage(file){
       return file['type'].split('/')[0]=='image';
    }

    $(document).on('change', '#image_upload', function(e) {
        $('div.error-msg.image').empty().hide();

        if(isImage(e.target.files[0])) {
            if(e.target.files[0].size/1024/1024 > 2) {
                $('div.error-msg.image').text('Please uplaod an image of size less than 2 mb.').fadeIn();
                return;
            }
            var reader = new FileReader();
            reader.onload = function() {
                $('#previewimage').attr('src', reader.result);
            }
            reader.readAsDataURL(e.target.files[0]);
            return;
        }
        $('div.error-msg.image').text('Please upload a valid image.').fadeIn();
        stopLoader("body");
    });

    /**
     * Sends the Ajax to add the data
     * @param  {[type]} current [description]
     * @return {[type]}         [description]
     */
    function sendRequest(form)
    {
        let formdata = new FormData(form[0]);
        $.ajax({
            url: form.attr('action'),
            data: formdata,
            processData: false,
            contentType: false,
            method: 'post',
            success: function(data) {
                // hide modal
                $('#pdf_form').modal('hide');
                $('#file_upload').modal('hide');
                if(form.data("redirect")) 
                {
                 window.location = data.redirectTo;   
                }else{
                    $("#date").datepicker('setDate', moment.utc($("#date").val()).format("MMM DD, YYYY"));
                    $(".image").attr("src", '');
                    $(".image").attr("src", $("#image").val());
                    $("#zoom_data_image").attr("href", $("#image").val());
                    $(".date").html(moment.utc($("#date").val()).format("MMM DD, YYYY"));
                    $(".start_time").html($("#start_time").val());
                    $(".end_time").html($("#end_time").val());
                }
                stopLoader();
            }
        });
    }
})
