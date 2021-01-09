$(document).ready(function () {
    var table = $('#dataTableBuilder').DataTable();
    ckEditoCustomSettings();
    const swalWithBootstrapButtons = Swal.mixin({
      confirmButtonClass: 'btn btn-success',
      cancelButtonClass: 'btn btn-danger',
      buttonsStyling: false,
    });

    

    $(document).on('click','.change-status', function(e){
        swalWithBootstrapButtons({
          title: 'Are you sure?',
          text: "You want to change status!",
          showCancelButton: true,
          confirmButtonText: 'Yes, change it!',
          cancelButtonText: 'No, cancel!',
          reverseButtons: true
        }).then((result) => {
        if (result.value) {
            var id = $(this).data("id");
            var status = $(this).data("status");
            $.ajax({
                async : false,
                url: 'user/'+id, //url
                type: 'PUT', //request method
                data: {'status':status,'update':'status'},
                success: function(data) {
                    window.LaravelDataTables["dataTableBuilder"].draw();
                    show_FlashMessage(data.message,'success');

                },
                error: function(xhr) {
                    
                }
            });
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
                    url: 'user/'+id, //url
                    type: 'DELETE', //request method
                    success: function(result) {
                        window.LaravelDataTables["dataTableBuilder"].draw();
                        show_FlashMessage(result.message,'success');
                    },
                    
                });
          }
        })
    });


    $("form[name='create_form']").submit(function(e){
        e.preventDefault();
        updateCkEditorInstance();        
        $.ajax({
            url: 'user', //url
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
            url: 'user/'+id, //url
            type: 'GET', //request method
            success: function(data) {console.log();
                $.each(data.data,function(index, el) {
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
            url: 'user/'+id+'/edit', //url
            type: 'GET', //request method
            success: function(data) {
                $.each(data.data,function(index, el) {
                    $('input[name="'+index+'"]').val(el);
                    $('select[name="'+index+'"]').val(el);
                });
                $('input[name="id"]').val(data.data._id);
                $('#editModal').modal('toggle');
                //window.LaravelDataTables["dataTableBuilder"].draw();
            }
        });
    });


    $("form[name='edit_form']").submit(function(e){
        e.preventDefault();
        var id = $( "#id" ).val();
        $.ajax({
            url: 'user/'+id, //url
            type: 'PUT', //request method
            data: $(this).serialize()+'&update=update',
            success: function(data) {
                console.log(data);
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
    });
    $('#createModal').on('hidden.bs.modal', function (e) {
        $('.error').empty();
      $("form[name='create_form']")[0].reset();
      $("form[name='edit_form']")[0].reset();
    });

    $('#dataTableBuilder').on('preXhr.dt', function ( e, settings, data ) {
        data["status"] = $(".status").val();
        data["searchData"] = $("#dataTableBuilder_filter input").val();
    });

    $(document).on('change','.status', function(e) {
        window.LaravelDataTables["dataTableBuilder"].draw();
        e.preventDefault();
    });

});    
