$(document).ready(function () {

    //Init variable
    var table = $('#dataTableBuilder').DataTable();
    ckEditoCustomSettings();
    const swalWithBootstrapButtons = Swal.mixin({
      confirmButtonClass: 'btn btn-success',
      cancelButtonClass: 'btn btn-danger',
      buttonsStyling: false,
    });

    //Change Status of manage Contract  

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

            var contract = $(this).data("contract");
            var status = $(this).data("status");
            $.ajax({
                url: 'contract/'+contract, //url
                type: 'PUT', //request method
                data: {
                   'status':status,
                   'update':'status'
                },
                beforeSend:function(){
                    startLoader('.portlet-body');
                },complete:function(){
                    stopLoader('.portlet-body');
                },
                success: function(data) {
                    window.LaravelDataTables["dataTableBuilder"].draw();
                    show_FlashMessage(data.message,'success');

                },
                error: function(xhr) {
                    
                }
            });
         }
        })
    });

    //Delete Contract from Listing 
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

                var contract = $(this).data("contract");
                $.ajax({
                    url: 'contract/'+contract, //url
                    type: 'DELETE', //request method
                    data: {
                       action:'get_provider_list'
                    },
                    beforeSend:function(){
                    startLoader('.portlet-body');
                },complete:function(){
                    stopLoader('.portlet-body');
                },
                    success: function(data) {
                         show_FlashMessage(data.message,'success');
                        window.LaravelDataTables["dataTableBuilder"].draw();
                       // show_FlashMessage(result.message,'success');
                    },
                    
                });
          }
        })
    });

    // Submit form for add Contract
    $("#contract_form").submit(function(e){
        e.preventDefault();
        for (instance in CKEDITOR.instances) {
            CKEDITOR.instances[instance].updateElement();
        }        
        var contract_name = $( "#contract_name" ).val();
        var validity = $( "#validity" ).val();
        var description = $( "#description" ).val();
        $.ajax({
            url: 'contract', //url
            type: 'POST', //request method
            data: {
               'contract_name':contract_name,
               'validity':validity,
               'description':description
            },
            beforeSend:function(){
                    startLoader('.modal-content');
                },complete:function(){
                    stopLoader('.modal-content');
                },
            success: function(data) {

                window.LaravelDataTables["dataTableBuilder"].draw();
                $('#createModal').modal('toggle');
                show_FlashMessage(data.message,'success');

            }
        });

    });


    // View Contract on click view button 
    $(document).on('click','.view-contract', function(e){
        var contract = $(this).data("contract");
        $.ajax({
            url: 'contract/'+contract, //url
            type: 'GET', //request method
            beforeSend: function() {
                startLoader();
            },
            complete: function() {
                stopLoader();
            },
            success: function(result) {
                $("#contract_name_td").html(result.contract_name);
                $("#validity_td").html(result.validity);
                $("#description_td").html('<div class="modal_description">'+result.description+'</div>');
                $('#viewModal').modal('toggle');
                $('.edit-view-modal').attr('id',result.id);
                //window.LaravelDataTables["dataTableBuilder"].draw();
            }
        });
    });

    //Edit Contract form
    $(document).on('click','.edit-contract', function(e){

        for (instance in CKEDITOR.instances) {
            CKEDITOR.instances[instance].updateElement();
        }

        var contract = $(this).data("contract");
        $.ajax({
            url: 'contract/'+contract+'/edit', //url
            type: 'GET', //request method
            beforeSend:function(){
                    startLoader('.portlet-body');
                },complete:function(){
                    stopLoader('.portlet-body');
                },
            success: function(result) {
                $("#contract_data").val(result.id);
                $("#edit_contract_name").val(result.contract_name);
                $("#edit_validity").val(result.validity);
                $('#edit_description').val(result.description);

                $('#editModal').modal('toggle');
                //window.LaravelDataTables["dataTableBuilder"].draw();
            }
        });
    });

    //Edit Contract form
    $(document).on('click','.edit-view-modal', function(e){

        for (instance in CKEDITOR.instances) {
            CKEDITOR.instances[instance].updateElement();
        }

        var contract = $(this).attr("id");
        $.ajax({
            url: 'contract/'+contract+'/edit', //url
            type: 'GET', //request method
            beforeSend: function() {
                startLoader();
            },
            complete: function() {
                stopLoader();
            },
            success: function(result) {
                $("#contract_data").val(result.id);
                $("#edit_contract_name").val(result.contract_name);
                $("#edit_validity").val(result.validity);
                $('#edit_description').val(result.description);
                $('#editModal').modal('toggle');
                //window.LaravelDataTables["dataTableBuilder"].draw();
            }
        });
    });

    //Submit edit form for update information of Contract
    $("#edit_contract_form").submit(function(e){
        e.preventDefault();
        for (instance in CKEDITOR.instances) {
            CKEDITOR.instances[instance].updateElement();
        }
        var contract_name = $( "#edit_contract_name" ).val();
        var validity = $( "#edit_validity" ).val();
        var description = $( "#edit_description" ).val();
        var contract = $( "#contract_data" ).val();
        $.ajax({
            url: 'contract/'+contract, //url
            type: 'PUT', //request method
            data: {
               'contract_name':contract_name,
               'validity':validity,
               'description':description,
               'update': 'update'
            },
            beforeSend:function(){
                    startLoader('.modal-content');
                },complete:function(){
                    stopLoader('.modal-content');
                },
            success: function(data) {
                console.log(data);
                window.LaravelDataTables["dataTableBuilder"].draw();
                $('#editModal').modal('toggle');
                show_FlashMessage(data.message,'success');

            }
        });

    });
    //Event on hide Edit contract modal
    $('#editModal').on('hidden.bs.modal', function (e) {
        $('.error').empty();
      $('#edit_contract_form')[0].reset();
      $('#contract_form')[0].reset();
        $('#edit_description').val('');

      // CKEDITOR.instances.edit_description.setData('');
    });
    //Event on hide Add contract modal
    $('#createModal').on('hidden.bs.modal', function (e) {
        $('.error').empty();
      $('#contract_form')[0].reset();
      $('#edit_contract_form')[0].reset();
       $('#description').val('');

        // CKEDITOR.instances.description.setData('');
    });

    $('#dataTableBuilder').on('preXhr.dt', function ( e, settings, data ) {
        data["status"] = $(".status").val();
        data["searchData"] = $("#dataTableBuilder_filter input").val();
    });
    //Filtering option
    $(document).on('change','.status', function(e) {
        window.LaravelDataTables["dataTableBuilder"].draw();
        e.preventDefault();
    });

});    