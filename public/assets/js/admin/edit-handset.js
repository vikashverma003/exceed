$(document).ready(function () { 
    ckEditoCustomSettings();
    const swalWithBootstrapButtons = Swal.mixin({
      confirmButtonClass: 'btn btn-success',
      cancelButtonClass: 'btn btn-danger',
      buttonsStyling: false,
    });
    
    $(document).on('submit', '#handset_detail_form', function(event) {
		event.preventDefault();
        var formData = new FormData($(this)[0]);
        
		$.ajax({
            url: 'handset_detail', //url
            type: 'POST', //request method
            // data: $(this).serialize(),
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
                $(".error").html("");
                //CKEDITOR.instances.description.setData('');
                show_FlashMessage(data.message,'success');
                location.reload();
                scrollTop();             
            }
        });
	});

	$(document).on('submit', '#tech_handset_form', function(event) {
		event.preventDefault();
		$.ajax({
            url: 'network-handset', //url
            type: 'POST', //request method
            data: $(this).serialize(),
            beforeSend: function() {
                startLoader('.page-content');
            },
            complete: function() {
                stopLoader('.page-content');
            },
            success: function(data) {
                $(".error").html("");
                //CKEDITOR.instances.description.setData('');
                show_FlashMessage(data.message,'success');
                scrollTop();             
            }
        });
	});

	$(document).on('submit', '#body_handset_form', function(event) {
		event.preventDefault();
		$.ajax({
            url: 'body-handset', //url
            type: 'POST', //request method
            data: $(this).serialize(),
             beforeSend: function() {
                startLoader('.page-content');
            },
            complete: function() {
                stopLoader('.page-content');
            },
            success: function(data) {
                $(".error").html("");
                //CKEDITOR.instances.description.setData('');
                show_FlashMessage(data.message,'success');
                scrollTop();             
            }
        });
	});

	$(document).on('submit', '#screen_handset_form', function(event) {
		event.preventDefault();
		$.ajax({
            url: 'screen-handset', //url
            type: 'POST', //request method
            data: $(this).serialize(),
             beforeSend: function() {
                startLoader('.page-content');
            },
            complete: function() {
                stopLoader('.page-content');
            },
            success: function(data) {
                $(".error").html("");
                //CKEDITOR.instances.description.setData('');
                show_FlashMessage(data.message,'success');
                scrollTop();             
            }
        });
	});

	$(document).on('submit', '#os_handset_form', function(event) {
		event.preventDefault();
		$.ajax({
            url: 'os-handset', //url
            type: 'POST', //request method
            data: $(this).serialize(),
             beforeSend: function() {
                startLoader('.page-content');
            },
            complete: function() {
                stopLoader('.page-content');
            },
            success: function(data) {
                $(".error").html("");
                //CKEDITOR.instances.description.setData('');
                show_FlashMessage(data.message,'success');
                scrollTop();             
            }
        });
	});

	$(document).on('submit', '#camera_handset_form', function(event) {
		event.preventDefault();
		$.ajax({
            url: 'camera-handset', //url
            type: 'POST', //request method
            data: $(this).serialize(),
             beforeSend: function() {
                startLoader('.page-content');
            },
            complete: function() {
                stopLoader('.page-content');
            },
            success: function(data) {
                $(".error").html("");
                //CKEDITOR.instances.description.setData('');
                show_FlashMessage(data.message,'success');
                scrollTop();             
            }
        });
	});

	$(document).on('submit', '#feature_handset_form', function(event) {
		event.preventDefault();
		$.ajax({
            url: 'feature-handset', //url
            type: 'POST', //request method
            data: $(this).serialize(),
            beforeSend: function() {
                startLoader('.page-content');
            },
            complete: function() {
                stopLoader('.page-content');
            },
            success: function(data) {
                $(".error").html("");
                //CKEDITOR.instances.description.setData('');
                show_FlashMessage(data.message,'success');
                scrollTop();             
            }
        });
	});

	$(document).on('submit', '#box_handset_form', function(event) {
        event.preventDefault();
        $.ajax({
            url: 'box-handset', //url
            type: 'POST', //request method
            data: $(this).serialize(),
             beforeSend: function() {
                startLoader('.page-content');
            },
            complete: function() {
                stopLoader('.page-content');
            },
            success: function(data) {
                $(".error").html("");
                //CKEDITOR.instances.description.setData('');
                show_FlashMessage(data.message,'success');
                scrollTop();             
            }
        });
    });

    $(document).on('click', '.add-info-form', function(event) {
        event.preventDefault();

        var id = $(this).attr('data-id');
        var page_url = $(this).attr('page_url');
        $('.error').html('');

        var fd = new FormData();

        var files = $('#add_info_form .image_file')[0].files[0];
        
        var what_to_upload=$('#add_info_form input[name=radio_what_to_upload]:checked').val();
        if(what_to_upload=='' || what_to_upload==undefined){
            show_FlashMessage('Please Select An Option','error');
            return false;
        }

        fd.append('what_to_upload',what_to_upload);
        fd.append('s_no',$("#add_info_form #s_no").val());
        fd.append('title',$("#add_info_form #title").val());
        fd.append('action','add');
        
        if(what_to_upload=='url'){
            if($("#add_info_form #link").val()=='')
            {
                show_FlashMessage('Please Enter URL','error');
                return false;
            }
            fd.append('image[0]',$("#add_info_form #link").val());
        }else{
            if (typeof files == "undefined") {
                // fd.append('image[1]','');
            }else{
                fd.append('image[1]',files);
            }
        }
        console.log(fd);
        $.ajax({
            url: 'add-info/'+id, //url
            type: 'POST', //request method
            beforeSend: function() {
                startLoader('.modal-body');
            },
            complete: function() {
                stopLoader('.modal-body');
            },
            data: fd,
            contentType: false,
            processData: false,
            success: function(data) {
                $(".error").html("");
                $.ajax({
                    url: page_url+'?info=1', //url
                    type: 'GET', //request method,
                    success: function(data) {
                        $("#tab_8").empty();
                        $('#tab_8').html(data);
                    }
                });
                show_FlashMessage(data.message,'success');
                scrollTop();
            },
            error:function(error){

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
                        if(key=='image.0'){
                            $('.error_info_url').empty().addClass('text-danger').text(value).finish().fadeIn();
                        }
                        else if(key=='image.1'){
                            $('.error_info_image').empty().addClass('text-danger').text(value).finish().fadeIn();
                        }else{
                            $('.error_'+key).empty().addClass('text-danger').text(value).finish().fadeIn();
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

    $(document).on('click', '.edit-submit', function(event) {
        event.preventDefault();

        var form_data = new FormData();
        var handset_id = $(this).attr('data-id');
        var page_url = $(this).attr('page_url');

        form_data.append('infoID',$('#info_id').val());
        form_data.append('handsetid',handset_id);
        form_data.append('s_no',$('#editModal #s_no').val());
        form_data.append('title',$('#editModal #edit_title').val());
        form_data.append('action','edit');
        
        var edit_what_to_upload=$('#edit_info_form input[name=radio_what_to_upload]:checked').val();

        if(edit_what_to_upload=='' || edit_what_to_upload==undefined){
            show_FlashMessage('Please Select An Option','error');
            return false;
        }

        form_data.append('what_to_upload',edit_what_to_upload);

        if(edit_what_to_upload=='url'){
            if($("#edit_info_form #link").val()=='')
            {
                show_FlashMessage('Please Enter URL','error');
                return false;
            }

            form_data.append('image[0]',$("#edit_info_form #link").val());
        }else{
            var input = document.querySelector('#editModal input[type=file]'),
            file = input.files[0];
            if (typeof file == "undefined") {
                form_data.append('image[1]','');
            }else{
                form_data.append('image[1]',file);
            }
            
        }

        $.ajax({
            url: 'update-info/'+handset_id, //url
            type: 'POST', //request method
            beforeSend: function() {
                startLoader('.modal-body');
            },
            complete: function() {
                stopLoader('.modal-body');
            },  
            data: form_data,
            cache: false,
            processData: false,
            contentType: false,
            success: function(data) {
                $(".error").html("");
                $.ajax({
                    url: page_url+'?info=1', //url
                    type: 'GET', //request method,
                    success: function(data) {
                        $("#tab_8").empty().html(data);
                    }
                });
                show_FlashMessage(data.message,'success');
                scrollTop();             
            },
            error:function(error){

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
                        if(key=='image.0'){
                            $('.error_info_url').empty().addClass('text-danger').text(value).finish().fadeIn();
                        }
                        else if(key=='image.1'){
                            $('.error_info_image').empty().addClass('text-danger').text(value).finish().fadeIn();
                        }else{
                            $('.error_'+key).empty().addClass('text-danger').text(value).finish().fadeIn();
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

    $(document).on('click', '.delete', function(event) {
		event.preventDefault();
        swalWithBootstrapButtons({
          title: 'Are you sure?',
          text: "You won't be able to revert this!",
          showCancelButton: true,
          confirmButtonText: 'Yes, delete it!',
          cancelButtonText: 'No, cancel!',
          reverseButtons: true
        }).then((result) => {
            if (result.value) {
                var id = $(this).attr('data-id');
                var page_url = $(this).attr('page_url');
        		$.ajax({
                    url: 'delete-info/'+id, //url
                    type: 'delete', //request method
                    data: $(this).serialize(),
                     beforeSend: function() {
                        startLoader('.tab-content');
                    },
                    complete: function() {
                        stopLoader('.tab-content');
                    },
                    success: function(data) {
                        $(".error").html("");
                        $.ajax({
                            url: page_url+'?info=1', //url
                            type: 'GET', //request method,
                            success: function(data) {
                                $("#tab_8").empty().html(data);
                            }
                        });
                        show_FlashMessage(data.message,'success');
                                 
                    }
                });
            }
        })
	});

    $(document).on('click', '.add-btn', function(event) {
        $('#createModal').modal('toggle');
        $("[name='create_form']")[0].reset();
        $('#createModal #title').val('');
        $('.error').text('');
        /* Act on the event */
    });

    $(document).on('click', '.edit-btn', function(event) {
        var id = $(this).attr('data-id');
        $('#info_id').val(id);
        $('#editModal #link').val('');
        $('.error').html('');

        $.ajax({
            url: 'show/info/'+id, //url
            type: 'GET', //request method
            beforeSend: function() {
                startLoader('.tab-content');
            },
            complete: function() {
                stopLoader('.tab-content');
            },
            success: function(result) {

                $("#editModal input[name='title']").val(result.data.title);
                $("#editModal select[name='s_no']").val(result.data.s_no);

                if (result.data.linktype == 'url') {
                    $("#editModal input[name='image[0]']").val(result.data.image);
                    $("#editModal #inlineRadio3").prop('checked',true).click();
                    // $("select[name='url_or_image']").val(result.data.linktype);
                }
                else if(result.data.linktype == 'img')
                {
                    $("#editModal #inlineRadio4").prop('checked',true).click();//('checked','checked');
                }

                $('#editModal').modal('toggle');
            }
        });
    });

});


// $('#url_link').click(function () {
//     // alert("cksjkd");
//     $('#image_link').prop('checked','');
//     $('#link').prop('disabled','');
//     $(this).prop('disabled','disabled');
//     $('#image_link').prop('disabled','');
//
// });
//
//
// $('#image_link').click(function () {
//
//     $('#url_link').prop('checked','');
//     $('#link').prop('disabled','');
//     $(this).prop('disabled','disabled');
//     $('.image_file').prop('disabled','');
//
//
// });

