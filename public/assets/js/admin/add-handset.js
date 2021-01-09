$(document).ready(function () {

    ckEditoCustomSettings();

    $(document).on('submit', '#add_handset_form', function(event) {
		event.preventDefault();
        var formData = new FormData($(this)[0]);
        for (instance in CKEDITOR.instances) {
            CKEDITOR.instances[instance].updateElement();
        }        
        $.ajax({
            url: 'store-handset', //url
            type: 'POST', //request method
            data: formData,
            processData: false,
            contentType: false,
            beforeSend: function() {
                startLoader('.page-content');
            },
            complete: function() {
                stopLoader('.page-content');
            },
            success: function(data) {
                $("#add_handset_form")[0].reset();
                $(".error").html("");
                show_FlashMessage(data.message,'success');
                window.location = data.url;
            }
        });

    });

});    