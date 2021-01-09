$(document).ready(function () {

    ckEditoCustomSettings();
        

    $("form[name='add_provider_form']").submit(function(e){
        e.preventDefault();
        for (instance in CKEDITOR.instances) {
            CKEDITOR.instances[instance].updateElement();
        }
        $(document).find('span.error').empty().hide();

        $.ajax({
            url: 'store-provider', //url
            type: 'POST', //request method
            data: $(this).serialize(),
            beforeSend: function() {
                startLoader('.portlet');
            },
            complete:function(){
                // stopLoader('.portlet');
            },
            success: function(data) {
                $("#add_provider_form")[0].reset();
                $(".error").html(""); 
                setTimeout(function(){
                    stopLoader('.portlet');
                    window.location = data.url;
                }, 2000);

                show_FlashMessage(data.message, 'success');

            },
            error: function(error){

                if(error.status == 0 || error.readyState == 0) {
                    return;
                }
                else if(error.status == 401){
                    errors = $.parseJSON(error.responseText);
                    window.location = errors.redirectTo;
                }
                else if(error.status == 422) {
                    errors = error.responseJSON;
                    $.each(errors.errors, function(key, value) {
                        if(key.indexOf('.') != -1) {
                            let keys = key.split('.');
                            /*let keys_length = keys.length;*/
                            $('.'+keys[0]+'_'+keys[1]).find('span.error').empty().addClass('text-danger').text(value).finish().fadeIn();
                        }
                        else {
                            $('.'+key).find('span.error').empty().addClass('text-danger').text(value).finish().fadeIn();
                        }
                    });

                    $('html, body').animate({
                         scrollTop: ($('.error').offset().top - 300)
                    }, 2000);
                    
                }
                else if(error.status == 400) {
                    errors = error.responseJSON;
                    if(errors.hasOwnProperty('message')) {
                        show_FlashMessage(errors.message, 'error');
                    }
                    else {
                        show_FlashMessage('Something went wrong!', 'error');
                    }
                }
                else {
                    show_FlashMessage('Something went wrong!', 'error');
                }
                //stop ajax loader
                stopLoader('.portlet');
            }
        });

    });

});    