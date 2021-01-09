$(document).ready(function () {
    $(".dataTable1").DataTable({"serverSide":false,"processing":true,"colReorder": true,'searching': false,"bSort" : false})
    $(".dataTable3").DataTable({"serverSide":false,"processing":true,'searching': false,'searching': false,"bSort" : false})
    const swalWithBootstrapButtons = Swal.mixin({
      confirmButtonClass: 'btn btn-success',
      cancelButtonClass: 'btn btn-danger',
      buttonsStyling: false,
    });    
    ckEditoCustomSettings();
    $(document).on('click', '.manage_contacts_tab', function(event) {
        window.LaravelDataTables["dataTableBuilder"].draw();
    });
	//account detail form
	
	$(document).on('submit', '.account_detail_form', function(event) {
		event.preventDefault();
		$.ajax({
            url: 'account_details', //url
            type: 'POST', //request method
            data: $(this).serialize(),
            beforeSend: function() {
                startLoader('.account-portlet-body');
            },
            complete: function() {
                stopLoader('.account-portlet-body');
            },
            success: function(data) {
                $(".error").html("");
                //CKEDITOR.instances.description.setData('');
                show_FlashMessage(data.message,'success');
                scrollTop();             
            }
        });
	});

	//term and conditions
	
	$(document).on('submit', '.terms_conditions_form', function(event) {
        event.preventDefault();
        $.ajax({
            url: 'terms_and_conditions', //url
            type: 'POST', //request method
            data: $(this).serialize(),
            success: function(data) {
                $(".error").html("");
                //CKEDITOR.instances.description.setData('');
                show_FlashMessage(data.message,'success');
                scrollTop();             
            }
        });
    });


    $(document).on('click', '.get_term_page', function() {
        var checkbox_url=$(this).attr('check');
		$.ajax({
            url: $(this).attr('url'), //url
            type: 'get', //request method
            beforeSend: function() {
                startLoader('.terms_conditions-portlet-body');
            },
            complete: function() {
                stopLoader('.terms_conditions-portlet-body');
            },
            success: function(data) {
                $("#tab_2").empty().html(data);
                CKEDITOR.replace('terms_textarea_new');
                //CKEDITOR.replace('validation_terms');
               // CKEDITOR.replace('content_terms');
                //$(".dataTable2").DataTable({"serverSide":false,"processing":true,'searching': false,"bSort" : false})
                //CKEDITOR.instances.description.setData('');
                get_terms_checkbox(checkbox_url); 
            }
        });
	});

    function get_terms_checkbox(url){
        
        $.ajax({
            url: url, //url
            type: 'get', //request method
            beforeSend: function() {
                startLoader('.terms_conditions-portlet-body');
            },
            complete: function() {
                stopLoader('.terms_conditions-portlet-body');
            },
            success: function(data) {
                $(".term_checkbox_content").empty().html(data);
                $("#term_checkbox_content_value").val(url);
               // CKEDITOR.replace('terms_textarea_new');
                CKEDITOR.replace('validation_terms');
                CKEDITOR.replace('content_terms');
                $(".dataTable2").DataTable({"serverSide":false,"processing":true,'searching': false,"bSort" : false})
                //CKEDITOR.instances.description.setData('');          
            }
        });
    }
    $(document).on('submit', '.terms_conditions_view_form', function(event) {
        event.preventDefault();
        $.ajax({
            url: 'update-terms/'+$(this).attr('id'), //url
            type: 'put', //request method
            data:$(this).serialize(),
            beforeSend: function() {
                startLoader('.terms_conditions-portlet-body');
            },
            complete: function() {
                stopLoader('.terms_conditions-portlet-body');
            },
            success: function(data) {
                show_FlashMessage(data.message,'success');
                scrollTop();             
            }
        });
    });
    $(document).on('click', '.back_terms_conditions', function() {
        $.ajax({
            url: $(this).attr('page-url')+'?terms=1', //url
            type: 'get', //request method
            beforeSend: function() {
                startLoader('.terms_conditions-portlet-body');
            },
            complete: function() {
                stopLoader('.terms_conditions-portlet-body');
            },
            success: function(data) {
                $("#tab_2").empty().html(data);             
            }
        });
    });

	//permission form
	
	$(document).on('submit', '.permission_form', function(event) {
		event.preventDefault();
		$.ajax({
            url: 'permission',
            type: 'POST', 
            data: $(this).serialize(),
            beforeSend: function() {
                startLoader('.permission-portlet-body');
            },
            complete: function() {
                stopLoader('.permission-portlet-body');
            },
            success: function(data) {
                $(".error").html("");
                //CKEDITOR.instances.description.setData('');
                show_FlashMessage(data.message,'success');
                scrollTop();             
            }
        });
	});

	//billling form
    
    $(document).on('submit', '.billing_form', function(event) {
        event.preventDefault();
        $.ajax({
            url: 'billing',
            type: 'POST',
            data: $(this).serialize(),
            beforeSend: function() {
                startLoader('.billing-portlet-body');
            },
            complete: function() {
                stopLoader('.billing-portlet-body');
            },
            success: function(data) {
                $(".error").html("");
                //CKEDITOR.instances.description.setData('');
                show_FlashMessage(data.message,'success');
                scrollTop();             
            },
            error: function(error) {
                $(document).find('span.error').empty();
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
            }
        });
    });

    //pop up form
	
	$(document).on('submit', '.checkbox_popup_form', function(event) {
		event.preventDefault();
        var page_url = $("#provider_logo").attr('page-url');
		$.ajax({
            url: 'pop-up-checkbox',
            type: 'POST',
            data: $(this).serialize(),
            success: function(data) {
                $(".error").html("");
                $('#myModal').modal('toggle');
                $(".error").html("");
                show_FlashMessage(data.message,'success');            
                $.ajax({
                    url: page_url, //url
                    type: 'GET', //request method,
                    success: function(data) {
                        $(".ajax-div").empty();
                        $(".ajax-div").html(data);
                        $('.nav-tabs li.active').removeClass('active');
                        $('.tab-pane').removeClass('active');
                        $("#tab_7").addClass("active");
                        $("#pop-tab").addClass("active");
                        CKEDITOR.replaceAll('ckeditor');
                    }
                });
            }
        });
	});

    $(document).on('submit', '.add_checkbox_popup_form', function(event) {
        event.preventDefault();
        var page_url = $("#provider_logo").attr('page-url');
        $.ajax({
            url: 'add-pop-up-checkbox',
            type: 'POST',
            data: $(this).serialize(),
            success: function(data) {
                $(".error").html("");
                $('#addModal').modal('toggle');
                show_FlashMessage(data.message,'success');   
                $.ajax({
                    url: page_url, //url
                    type: 'GET', //request method,
                    success: function(data) {
                        $(".ajax-div").empty();
                        $(".ajax-div").html(data);
                        $('#createDirectPopup').modal('toggle');
                        CKEDITOR.replaceAll('ckeditor');
                    }
                });                   
            }
        });
    });


	//post submission form
	
	$(document).on('submit', '.pop_up_form', function(event) { 
		event.preventDefault();
        for (instance in CKEDITOR.instances) {
            CKEDITOR.instances[instance].updateElement();
        }  
		$.ajax({
            url: 'pop-up',
            type: 'POST',
            data: $(this).serialize(),
            
            beforeSend: function() {
                startLoader('.pop_up-portlet-body');
            },
            complete: function() {
                stopLoader('.pop_up-portlet-body');
            },
            success: function(data) {
                $(".error").html("");
                //CKEDITOR.instances.description.setData('');
                show_FlashMessage(data.message,'success');
                scrollTop(); 
            },
            error: function(error) {
                $(document).find('span.error').empty();
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
            }
        });
	});

	//post submission form
    
    $(document).on('submit', '.post_submission_form', function(event) {
        event.preventDefault();
        $.ajax({
            url: 'post-submission',
            type: 'POST',
            data: $(this).serialize(),
            beforeSend: function() {
                startLoader('.post_submission-portlet-body');
            },
            complete: function() {
                stopLoader('.post_submission-portlet-body');
            },
            success: function(data) {
                $(".error").html("");
                //CKEDITOR.instances.description.setData('');
                show_FlashMessage(data.message,'success');
                scrollTop();             
            }
        });
    });

    //footer form
    
    $(document).on('submit', '.footer_form', function(event) {
        event.preventDefault();
        $.ajax({
            url: 'footer',
            type: 'POST',
            data: $(this).serialize(),
            beforeSend: function() {
                startLoader('.footer-loader');
            },
            complete: function() {
                stopLoader('.footer-loader');
            },
            success: function(data) {
                $(".error").html("");
                //CKEDITOR.instances.description.setData('');
                show_FlashMessage(data.message,'success');
                scrollTop();             
            }
        });
    });

    //direct_debit form
    
    $(document).on('submit', '.direct_debit', function(event) {
        event.preventDefault();
        $.ajax({
            url: 'direct_debit',
            type: 'POST',
            data: $(this).serialize(),
            beforeSend: function() {
                startLoader('.debit-loader');
            },
            complete: function() {
                stopLoader('.debit-loader');
            },
            success: function(data) {
                $(".error").html("");
                //CKEDITOR.instances.description.setData('');
                show_FlashMessage(data.message,'success');
                scrollTop();             
            }
        });
    });

    //direct_debit pop up form
    
    $(document).on('click', '.add-pop-up-btn', function(event) {
        event.preventDefault();
        CKEDITOR.instances.direct_debit_validation.updateElement();
        CKEDITOR.instances.direct_debit_content.updateElement();
        var page_url = $(this).attr('page-url');
        $.ajax({
            url: 'create/direct_debit_popup',
            type: 'POST',
            data: $('.directDebit_checkbox_popup_form').serialize(),
            beforeSend: function() {
                startLoader('.modal-body');
            },
            complete: function() {
                stopLoader('.modal-body');
            },
            success: function(data) {
                $(".error").html("");
                //CKEDITOR.instances.description.setData('');
                show_FlashMessage(data.message,'success');
                scrollTop();
                $.ajax({
                    //url: page_url+'?direct-debit=1', //url
                    url: page_url+'?direct-debit-checkbox=1', //url
                    type: 'GET', //request method,
                    success: function(data) {
                        
                        $(".direct_debit_method_content_html").empty().html(data);
                        $(".dataTable3").DataTable({"serverSide":false,"processing":true,'searching': false,"bSort" : false})            
                       // $('#createDirectPopup').modal('toggle');  
                        CKEDITOR.replace('direct_debit_validation');                      
                        CKEDITOR.replace('direct_debit_content');                    
                    }
                });        
            }
        });
    });

    //term and condition pop up form
	
	$(document).on('click', '.add-term-popup-btn', function(event) {
        event.preventDefault();
        CKEDITOR.instances.validation_terms.updateElement();
        CKEDITOR.instances.content_terms.updateElement();
        var term = $(this).attr('term');
        var page_url = $(this).attr('page-url');
        $.ajax({
            url: 'create/term_popup',
            type: 'POST',
            data: $('.term_checkbox_popup_form').serialize(),
            beforeSend: function() {
                startLoader('.modal-body');
            },
            complete: function() {
                stopLoader('.modal-body');
            },
            success: function(data) {
                $(".error").html("");
                //CKEDITOR.instances.description.setData('');
                show_FlashMessage(data.message,'success');
                // $.ajax({
                //     url: page_url+'?new-term='+term, //url
                //     type: 'GET', //request method,
                //     success: function(data) {
                //         $("#tab_2").empty();
                //         $("#tab_2").html(data);
                //         //$('#createTermPopup').modal('toggle'); 
                //         $(".dataTable2").DataTable({"serverSide":false,"processing":true,'searching': false,"bSort" : false}); 
                //         CKEDITOR.replace('validation_terms');                      
                //         CKEDITOR.replace('content_terms');                    
                //         CKEDITOR.replace('terms_textarea_new');                    
                //     }
                // });
                get_terms_checkbox($("#term_checkbox_content_value").val());
            },
            error: function(error) {
                $(document).find('span.error').empty();
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
            }
        });
    });

    $(document).on('click', '.edit-term-popup-btn', function(event) {
        event.preventDefault();
        CKEDITOR.instances.validation_terms.updateElement();
        CKEDITOR.instances.content_terms.updateElement();
        var page_url = $(this).attr('page-url');
        var term = $(this).attr('term');
        $.ajax({
            url: 'edit/terms_popup',
            type: 'POST',
            data: $('.term_checkbox_popup_form').serialize(),
            beforeSend: function() {
                startLoader('.modal-body');
            },
            complete: function() {
                stopLoader('.modal-body');
            },
            success: function(data) {
                $(".error").html("");
                show_FlashMessage(data.message,'success');
                // $.ajax({
                //     url: page_url+'?new-term='+term, //url
                //     type: 'GET', //request method,
                //     success: function(data) {
                //         $("#tab_2").empty();
                //         $("#tab_2").html(data);  
                //         $(".dataTable2").DataTable({"serverSide":false,"processing":true,'searching': false,"bSort" : false})
                //         CKEDITOR.replace('validation_terms');                      
                //         CKEDITOR.replace('content_terms');        
                //         CKEDITOR.replace('terms_textarea_new');                     
                //     }
                // });    
                get_terms_checkbox($("#term_checkbox_content_value").val());       
            },
            error: function(error) {
                $(document).find('span.error').empty();
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
            }
        });
    });

    $(document).on('click', '.edit-pop-up-btn', function(event) {
		event.preventDefault();
        CKEDITOR.instances.direct_debit_validation.updateElement();
        CKEDITOR.instances.direct_debit_content.updateElement();
        var page_url = $(this).attr('page-url');
		$.ajax({
            url: 'edit/direct_debit_popup',
            type: 'POST',
            data: $('.directDebit_checkbox_popup_form').serialize(),
            beforeSend: function() {
                startLoader('.modal-body');
            },
            complete: function() {
                stopLoader('.modal-body');
            },
            success: function(data) {
                $(".error").html("");
                show_FlashMessage(data.message,'success');
                scrollTop();
                $.ajax({
                    url: page_url+'?direct-debit=1', //url
                    type: 'GET', //request method,
                    success: function(data) {
                        $("#tab_9").empty();
                        $("#tab_9").html(data);  
                        CKEDITOR.replace('direct_debit_validation');                      
                        CKEDITOR.replace('direct_debit_content');
                        $(".dataTable3").DataTable({"serverSide":false,"processing":true,'searching': false,"bSort" : false})                                  
                    }
                });           
            }
        });
	});

	//add contacts form
    
    $(document).on('submit', '.contact_form', function(event) {
        event.preventDefault();
        $.ajax({
            url: 'add-contact',
            type: 'POST',
            data: $(this).serialize(),
            success: function(data) {
                $(".error").html("");
                //CKEDITOR.instances.description.setData('');
                show_FlashMessage(data.message,'success');
                scrollTop();             
            }
        });
    });

    //add state consent form
	
	$(document).on('submit', '.state_consent_form', function(event) {
		event.preventDefault();
		$.ajax({
            url: 'state-consent',
            type: 'POST',
            data: $(this).serialize(),
            
            beforeSend: function() {
                startLoader('.state_consent_loader');
            },
            complete: function() {
                stopLoader('.state_consent_loader');
            },
            success: function(data) {
                $(".error").html("");
                //CKEDITOR.instances.description.setData('');
                show_FlashMessage(data.message,'success');           
            },
            error: function(error) {
                $(document).find('span.error').empty();
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
            }
        });
	});

    //change state in consent
    $(document).on('change', 'select[name="state"]', function(event) {
        if ($(this).val()) {
            $.ajax({
                url: $(this).attr('url'), //url
                type: 'get', //request method
                data: $('.state_consent_form').serialize(),
                beforeSend: function() {
                    startLoader('.state_consent_loader');
                },
                complete: function() {
                    stopLoader('.state_consent_loader');
                },
                success: function(data) {
                    if(data.data){
                        CKEDITOR.instances.consent_text.setData(data.data.description);
                    }else{
                        CKEDITOR.instances.consent_text.setData("");
                    }
                }
            });
        }else{
            CKEDITOR.instances.consent_text.setData("");
        }
    });

    $(document).on('submit', '#provider_logo', function(event) {
        event.preventDefault();
        $('#provider_logo').find('.error').text('').removeClass('text-danger');
        var formData = new FormData($(this)[0]);
        $.each($('.logo_file'),function(index, el) {
            if($(el).val() == ""){
                formData.append($(el).attr('name'), "");
            }
        });
        var url = $(this).attr('action');
        var page_url = $(this).attr('page-url');
        $.ajax({
            url: url, //url
            type: 'POST', //request method
            data: formData,
            processData: false,
            contentType: false,
            beforeSend: function() {
                startLoader('.logo-portlet-body');
            },
            complete: function() {
                stopLoader('.logo-portlet-body');
            },
            success: function(data) {
                //$(".error").html("");
                show_FlashMessage(data.message,'success'); 

                $.ajax({
                    url: page_url+'?logo=1', //url
                    type: 'GET', //request method,
                    success: function(data) {
                        $("#tab_1").empty().html(data);
                        $(".dataTable1").DataTable({"serverSide":false,"processing":true,'searching': false,"bSort" : false})
                        //CKEDITOR.replaceAll('ckeditor');
                    }
                });


            },
            error: function(jqXHR,textStatus,errorThrown) {
                stopLoader('.modal-content');
                if(jqXHR.status==422){      
                    var responseText = $.parseJSON(jqXHR.responseText);
                    $.each(responseText.errors,function(key,value){
                        $('#provider_logo').find('[name="'+key+'"]').next('span').text(value).addClass('text-danger');
                        if(value=='The category id has already been taken.'){
                            $('#provider_logo').find('[name="'+key+'"]').next('span').text('Category already assigned').addClass('text-danger');
                        }
                        if(key=='logo.0'){
                            $('#provider_logo').find('.logo_file').next('span').text(value).addClass('text-danger');
                        }
                    });
                }else{
                    var responseText = $.parseJSON(jqXHR.responseText);
                    show_FlashMessage(responseText.message,'error');
                }
            }
        });
    });




	$(document).on('click','.add-contact',function(){
        $(".error").html("");
         $("form[name='create_form']")[0].reset();
         CKEDITOR.instances.description.setData("");

	});
    $("form[name='create_form']").submit(function(e){
        e.preventDefault();
        updateCkEditorInstance();       
        $.ajax({
            url: 'create/contact', //url
            type: 'POST', //request method
            data: $(this).serialize(),
            beforeSend: function() {
                startLoader('.contract-loader');
            },
            complete: function() {
                stopLoader('.contract-loader');
            },
            success: function(data) {

                window.LaravelDataTables["dataTableBuilder"].draw();
                $('#createContact').modal('toggle');
                show_FlashMessage(data.message,'success');

            }
        });

    });

    $(document).on('click','.view-contract', function(e){
        var id = $(this).data("id");
        $('.edit-button-view').attr('id', id);
        $.ajax({
            url: 'show/contact/'+id, //url
            type: 'GET', //request method
            beforeSend: function() {
                startLoader('.manage-contract-loader');
            },
            complete: function() {
                stopLoader('.manage-contract-loader');
            },
            success: function(data) {
                $.each(data.data,function(index, el) {
                    if(el){
                        $('#'+index+'_td').html('<div class="modal_description">'+el+'</div>');
                    }else{
                        $('#'+index+'_td').html('<div class="modal_description">-</div>');
                    }
                    
                });
                $('#viewModal').modal('toggle');
                $('.edit-button-view').attr('id',data.data.url);
                //window.LaravelDataTables["dataTableBuilder"].draw();
            }
        });
    });

    $(document).on('click','.edit-contract', function(e){
        $(".error").html("");
        updateCkEditorInstance();
        var id = $(this).data("id");
        $.ajax({
            url: 'show/contact/'+id, //url
            type: 'GET', //request method
            beforeSend: function() {
                startLoader('.manage-contract-loader');
            },
            complete: function() {
                stopLoader('.manage-contract-loader');
            },
            success: function(data) {
                $.each(data.data,function(index, el) {
                    $('input[name="'+index+'"]').val(el);
                    $('select[name="'+index+'"]').val(el);
                });
                updateCkEditorInstance(); 
                CKEDITOR.instances.edit_description.setData(data.data.description);
                $('#editContact').modal('toggle');
                //window.LaravelDataTables["dataTableBuilder"].draw();
            }
        });
    });

    $(document).on('click','.delete-contract', function(e){

        swalWithBootstrapButtons({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'No, cancel!',
            reverseButtons: true
        }).then((result) => {
            if (result.value) {
                var id = $(this).data("id");
                $.ajax({
                    url: 'contact/delete/'+id, //url
                    type: 'POST', //request method
                    beforeSend: function() {
                        startLoader('.manage-contract-loader');
                    },
                    complete: function() {
                        stopLoader('.manage-contract-loader');
                    },
                    success: function(result) {
                        window.LaravelDataTables["dataTableBuilder"].draw();
                        show_FlashMessage(result.message,'success');
                    },
                    error: function (error) {
                        show_FlashMessage(error.message,'error');
                    }
                });
            }
        })
    });




    $("form[name='edit_form']").submit(function(e){
        e.preventDefault();
        updateCkEditorInstance();
        $.ajax({
            url: 'contact/update', //url
            type: 'post', //request method
            data: $(this).serialize(),
            beforeSend: function() {
                startLoader('.modal-body');
            },
            complete: function() {
                stopLoader('.modal-body');
            },
            success: function(data) {
                window.LaravelDataTables["dataTableBuilder"].draw();
                $('#editContact').modal('toggle');
                show_FlashMessage(data.message,'success');
            }
        });

    });

    $(document).on('click','.add-logo',function(){
        $('.error').empty();
        /*$.ajax({
            url: 'get-logo-category', //url
            type: 'GET', //request method
            success: function(data) {
                $("#logoModal").modal();
                $('.add_logo_id').empty().append('<option value="">Please Select Category</option>')
                $.each(data.category,function(index, el) {
                     $('.edit_category_id').append('<option value="'+el.id+'">'+el.title+'</option>')
                });
            }
        }); */ 
    });

    $(document).on("click", ".edit-provider-logo", function (e) {
        $('.error').empty();
        var logo_id = $(this).data("id");
        $.ajax({
            url: 'edit-provider-logo-details/'+logo_id, //url
            type: 'GET', //request method
            beforeSend: function() {
                startLoader('.logo-page-loader');
            },
            complete: function() {
                stopLoader('.logo-page-loader');
            },
            success: function(data) {
                $("#logoModal").modal();
                $('.edit_category_id').empty().append('<option value="">Please Select Category</option>')
                $.each(data.category,function(index, el) {
                     $('.edit_category_id').append('<option value="'+el.id+'">'+el.title+'</option>')
                });
                $(".edit_category_id  option[value="+data.logo.category_id+"]").attr('selected', true);
                $(".field_name").val(data.logo.description);
                $(".logo_id").val(data.logo.id);
                $('.logo_src').attr("src",data.logo.url);
                //show_FlashMessage(data,'success');
            }
        });        

    });

    var _URL = window.URL || window.webkitURL;
    $(document).on('change',".logo_file",function (e) {
    var file, img;
    if ((file = this.files[0])) {
        img = new Image();
        img.onload = function () {

            $('.img_width').val(this.width);
            $('.img_height').val(this.height);
        };
        img.src = _URL.createObjectURL(file);
    }
});
    //   var option_value=[];
    //   var option_text=[];
    // $("#category_id option").each(function(){
    //      option_value.push($(this).val());
    //      option_text.push($(this).text());
    // })
    // $("#category_id").change(function(){
    //      if (jQuery.inArray($(this).val(), option_value) =='-1') {
    //         show_FlashMessage('Category Not Found','error');
    //         $('#category_id').empty();
    //         for (i=0;i<option_text.length;i++)
    //         {
    //             $('#category_id').append('<option value="'+option_value[i]+'">'+option_text[i]+'</option>');
    //         }
    //     }   
    // });
    $(document).on('submit', '#update_provider_logo', function(event) {
        event.preventDefault();
        var page_url = $(this).attr('page-url');
        var formData = new FormData($(this)[0]);
        $.ajax({
            url: 'update-provider-logo/update', //url
            type: 'POST', //request method
            data: formData,
            processData: false,
            contentType: false,
            success: function(data) {
                show_FlashMessage(data.message,'success');
                $.ajax({
                    url: page_url+'?logo=1', //url
                    type: 'GET', //request method,
                    beforeSend: function() {
                        startLoader('.logo-portlet-body');
                    },
                    complete: function() {
                        stopLoader('.logo-portlet-body');
                    },
                    success: function(data) {
                        $("#tab_1").empty().html(data);
                        $( ".close-modal" ).trigger( "click" );
                        $('.nav-tabs li.active').removeClass('active');
                        $('.tab-pane').removeClass('active');
                        $("#tab_1").addClass("active");
                        $("#logo-tab").addClass("active"); 
                        $(".dataTable1").DataTable({"serverSide":false,"processing":true,'searching': false,"bSort" : false})                   
                    }
                });
            }
        });
    });    

    $(document).on('click', '.add-debit-popup', function(event) {
        $('.add-pop-up-btn').show();
        $('.edit-pop-up-btn').hide();
        /*CKEDITOR.instances.pop_up_checkbox_text.setData('');
        CKEDITOR.instances.validation_message.setData('');*/
    });
    $(document).on('click', '.add-term-popup', function(event) {
        $('.add-term-popup-btn').show();
        $('.edit-term-popup-btn').hide();
        CKEDITOR.instances.validation_terms.setData('');
        CKEDITOR.instances.content_terms.setData('');
    });
    
	$(document).on('click','.remove',function(){
		$(this).parent().parent().remove()
	});

    $(document).on('click','.delete-logo',function(){
        let vl = this;
        var page_url = $(this).attr('page-url');
        swalWithBootstrapButtons({
          title: 'Are you sure?',
          text: "You won't be able to revert this!",
          showCancelButton: true,
          confirmButtonText: 'Yes, delete it!',
          cancelButtonText: 'No, cancel!',
          reverseButtons: true
        }).then((result) => {
          if (result.value) {
            var logo_id = $(this).data('id');
            $.ajax({
                url: 'delete-provider-logo/'+logo_id+'/delete', //url
                type: 'DELETE', //request method
                success: function(data) {
                    $.ajax({
                    url: page_url+'?logo=1', //url
                    type: 'GET', //request method,
                    success: function(data) {
                        $("#tab_1").empty().html(data);
                        $( ".close-modal" ).trigger( "click" );
                        $('.nav-tabs li.active').removeClass('active');
                        $('.tab-pane').removeClass('active');
                        $("#tab_1").addClass("active");
                        $("#logo-tab").addClass("active"); 
                        $(".dataTable1").DataTable({"serverSide":false,"processing":true,'searching': false,"bSort" : false})                   
                    }
                });
                show_FlashMessage(data.message,'success');       
                }
            });
          } 
        })

    });


    $(document).on('click','.delete-direct-debit-pop-up',function(){
        let vl = this;
        swalWithBootstrapButtons({
          title: 'Are you sure?',
          text: "You won't be able to revert this!",
          showCancelButton: true,
          confirmButtonText: 'Yes, delete it!',
          cancelButtonText: 'No, cancel!',
          reverseButtons: true
        }).then((result) => {
          if (result.value) {

            var logo_id = $(this).data('id');
            $.ajax({
                url: 'delete-direct-debit-popup/'+logo_id, //url
                type: 'DELETE', //request method
                    beforeSend: function() {
                    startLoader('.debit-loader');
                },
                complete: function() {
                    stopLoader('.debit-loader');
                },
                success: function(data) {
                    $(this).parent().parent().remove()
                    show_FlashMessage(data.message,'success');
                    scrollTop();    
                    $(vl).parent().parent().remove()         
                }
            });
          } 
        })

    });

    /*click on billing parameter*/
    $(document).on('click', '.billing_parameter', function(event) {
        CKEDITOR.instances.biling_text.insertText($(this).val());
    });
    /*click on billing parameter*/
    $(document).on('click', '.post_sub_parameter', function(event) {
        CKEDITOR.instances.post_sub_textarea.insertText($(this).val());
    });
    /*click on billing parameter*/
    $(document).on('click', '.pop_up_parameter', function(event) {
        CKEDITOR.instances.pop_up_text.insertText($(this).val());
    });
    /*click on direct pop up pop up checkbox*/
    $(document).on('click', '.pop_up_checkbox_parameter', function(event) {
        CKEDITOR.instances.direct_debit_content.insertText($(this).val());
    });

    $(document).on('click', '.term_pop_up_checkbox_parameter', function(event) {
        CKEDITOR.instances.content_terms.insertText($(this).val());
    });

    $(document).on('click', '.add_pop_up_checkbox_parameter', function(event) {
        CKEDITOR.instances.add_pop_up_checkbox_text.insertText($(this).val());
    });
    $(document).on('click', '.consent_parameter', function(event) {
        CKEDITOR.instances.consent_text.insertText($(this).val());
    });


    $(document).on('click','.cancel_button',function(){

        window.location=url;

    });       

    $(document).on('click','.edit-pop-up',function(){

        var data_id = $(this).data('id');
        $.ajax({
            url: 'get-pop-up/'+data_id+'/edit', //url
            type: 'GET', //request method
            success: function(data) {
                CKEDITOR.instances.validation_message.setData(data.validation_message);
                CKEDITOR.instances.pop_up_checkbox_text.setData(data.content);
                $("#pop_id").val(data.id);
                if(data.checkbox_required)
                    $("#checkbox10").attr('checked', 'checked');
                else
                    $("#checkbox11").attr('checked', 'checked');
                
                $('#myModal').modal('toggle');
            }
        });        

    });  

    $(document).on('click','.edit-direct-debit-pop-up',function(){
        $('.add-pop-up-btn').hide();
        $('.edit-pop-up-btn').show();
        CKEDITOR.instances.direct_debit_validation.updateElement();
        CKEDITOR.instances.direct_debit_content.updateElement();
        var data_id = $(this).data('id');
        $.ajax({
            url: 'get-pop-up/'+data_id+'/edit', //url
            type: 'GET', //request method
            beforeSend: function() {
                startLoader('.debit-checkbox-loader');
            },
            complete: function() {
                stopLoader('.debit-checkbox-loader');
            },
            success: function(data) {
               CKEDITOR.instances.direct_debit_validation.setData(data.validation_message);
               CKEDITOR.instances.direct_debit_content.setData(data.content);
                $("#pop_id").val(data.id);
                if(data.checkbox_required)
                    $("#checkbox22").attr('checked', 'checked');
                else
                    $("#checkbox21").attr('checked', 'checked');
                
               $('#createDirectPopup').modal('toggle');
                $('#popup_id').val(data.id);
            }
        });        

    });   

    //edit button for popup on terms and condition
    $(document).on('click','.edit-pop-up-term',function(){
        $('.add-term-popup-btn').hide();
        $('.edit-term-popup-btn').show();
        CKEDITOR.instances.validation_terms.updateElement();
        CKEDITOR.instances.content_terms.updateElement();
        var data_id = $(this).data('id');
        $.ajax({
            url: 'get-pop-up/'+data_id+'/edit', //url
            type: 'GET', //request method
            success: function(data) {
               CKEDITOR.instances.validation_terms.setData(data.validation_message);
               CKEDITOR.instances.content_terms.setData(data.content);
                $("#pop_id").val(data.id);
                if(data.checkbox_required)
                    $("#checkbox30").attr('checked', 'checked');
                else
                    $("#checkbox31").attr('checked', 'checked');
                
               $('#createTermPopup').modal('toggle');
                $('#popup_id').val(data.id);
            }
        });        

    });   
    $(document).on('click','.delete-term-pop-up',function(){
        var term = $(this).attr('term');
        var page_url = $(this).attr('page-url');
        swalWithBootstrapButtons({
                  title: 'Are you sure?',
                  text: "You won't be able to revert this!",
                  showCancelButton: true,
                  confirmButtonText: 'Yes, delete it!',
                  cancelButtonText: 'No, cancel!',
                  reverseButtons: true
                }).then((result) => {
                  if (result.value) {

                var data_id = $(this).data('id');
                $.ajax({
                    url: 'delete-pop-up/'+data_id+'/delete', //url
                    type: 'DELETE', //request method
                    success: function(data) {
                        // $.ajax({
                        //     url: page_url+'?new-term='+term, //url
                        //     type: 'GET', //request method,
                        //     success: function(data) {
                        //         $("#tab_2").empty();
                        //         $("#tab_2").html(data);
                        //         //$('#createTermPopup').modal('toggle');  
                        //         $(".dataTable2").DataTable({"serverSide":false,"processing":true,'searching': false,"bSort" : false})
                        //         CKEDITOR.replace('validation_terms');                      
                        //         CKEDITOR.replace('content_terms');                    
                        //         CKEDITOR.replace('terms_textarea_new');                       
                        //     }
                        // });
                        get_terms_checkbox($("#term_checkbox_content_value").val());
                    }
                });
            } 
        })
    });     

    $(document).on('click','.submit_pop_form',function(e){
        e.preventDefault();
        $('.pop_up_form').submit();
    }); 

    $(document).on('click','.edit-button-view',function(){
        var id = $(this).attr("id");
        $.ajax({
            url: 'show/contact/'+id, //url
            type: 'GET', //request method
            success: function(data) {
                $('#editContact').modal('toggle');
                $.each(data.data,function(index, el) {
                    $('input[name="'+index+'"]').val(el);
                    $('select[name="'+index+'"]').val(el);
                });
                CKEDITOR.instances.edit_description.setData(data.data.description);
               // CKEDITOR.instances.edit_description.setData(data.data.description);
               
                //window.LaravelDataTables["dataTableBuilder"].draw();
            }
        });
    });

    /*$(document).on('click', '.manage_contacts_tab', function(event) {
        event.preventDefault();
        var page_url = $(this).attr('url');
        $.ajax({
            url: page_url+'?contact=1', //url
            type: 'GET', //request method,
            success: function(data) {
                $("#tab_8").empty().html(data);

            }
        });
    }); */
});