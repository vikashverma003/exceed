$(document).ready(function () {
    var table = $('#dataTableBuilder').DataTable();
    ckEditoCustomSettings();
    const swalWithBootstrapButtons = Swal.mixin({
      confirmButtonClass: 'btn btn-success',
      cancelButtonClass: 'btn btn-danger',
      buttonsStyling: false,
    });

    

    $(document).on('click','.change-status', function(e){

        var id = $(this).data("id");
        var status = $(this).data("status");
        $.ajax({
            async : false,
            url: 'email-template/'+id, //url
            type: 'PUT', //request method
            data: {'status':status,'update':'status'},
            success: function(data) {
                window.LaravelDataTables["dataTableBuilder"].draw();
                show_FlashMessage(data.message,'success');

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
                    url: 'email-template/'+id, //url
                    type: 'DELETE', //request method
                    success: function(result) {
/*                        swalWithBootstrapButtons(
                          'Deleted!',
                          'Your file has been deleted.',
                        )*/
                        window.LaravelDataTables["dataTableBuilder"].draw();
                        //show_FlashMessage(result.message,'success');
                    },
                    
                });
          }
        })
    });


    $("form[name='create_form']").submit(function(e){
        e.preventDefault();
        updateCkEditorInstance();        
        $.ajax({
            url: 'email-template', //url
            type: 'POST', //request method
            data: $(this).serialize(),
            success: function(data) {

                window.LaravelDataTables["dataTableBuilder"].draw();
                $('#createModal').modal('toggle');
                show_FlashMessage(data.message,'success');

            }
        });

    });



    $(document).on('click','.view-contract', function(e){
        var id = $(this).data("id");
        $.ajax({
            url: 'email-template/'+id, //url
            type: 'GET', //request method
            success: function(data) {console.log();
                $.each(data.data.email,function(index, el) {
                    $('#'+index+'_td').html(el);
                });
                $('#viewModal').modal('toggle');
                //window.LaravelDataTables["dataTableBuilder"].draw();
            }
        });
    });


    $(document).on('click','.edit-contract', function(e){
        updateCkEditorInstance();
        var id = $(this).data("id");
        $.ajax({
            url: 'email-template/'+id+'/edit', //url
            type: 'GET', //request method
            success: function(data) {
                $('#edit_email_template_parameter').empty();
                $.each(data.data.email,function(index, el) {
                    $('input[name="'+index+'"]').val(el);
                    $('select[name="'+index+'"]').val(el);
                });
                $.each(data.data.content,function(index, el) {
                    $('#edit_email_template_parameter').append($("<option class='email_template_parameter'></option>")
                    .attr("value",el.parameter)
                    .text(el.parameter)); 
                });
                
                CKEDITOR.instances.edit_description.setData(data.data.email.description);
                $('#editModal').modal('toggle');
                //window.LaravelDataTables["dataTableBuilder"].draw();
            }
        });
    });


    $("form[name='edit_form']").submit(function(e){
        e.preventDefault();
        updateCkEditorInstance();
        var id = $( "#id" ).val();
        $.ajax({
            url: 'email-template/'+id, //url
            type: 'PUT', //request method
            data: $(this).serialize()+'&update=update',
            success: function(data) {
                window.LaravelDataTables["dataTableBuilder"].draw();
                $('#editModal').modal('toggle');
                show_FlashMessage(data.message,'success');

            }
        });

    });

    $('#editModal').on('hidden.bs.modal', function (e) {
        $('.error').empty();
      $("form[name='edit_form']")[0].reset();
      $("form[name='create_form']")[0].reset();
      CKEDITOR.instances.edit_description.setData('');
    });
    $('#createModal').on('hidden.bs.modal', function (e) {
        $('.error').empty();
      $("form[name='create_form']")[0].reset();
      $("form[name='edit_form']")[0].reset();
      CKEDITOR.instances.description.setData('');
    });

    $('#dataTableBuilder').on('preXhr.dt', function ( e, settings, data ) {
        data["searchData"] = $("#dataTableBuilder_filter input").val();
    });

    $(document).on('click', '.email_template_parameter', function(event) {
        CKEDITOR.instances.edit_description.insertText($(this).val());
    });

});    