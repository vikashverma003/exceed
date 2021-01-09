$(document).ready(function() {
    var table = $('#dataTableBuilder').DataTable();
    const swalWithBootstrapButtons = Swal.mixin({
        confirmButtonClass: 'btn btn-success',
        cancelButtonClass: 'btn btn-danger',
        buttonsStyling: false,
    });


    $(document).on('click', '.change-status', function(e) {

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
                    async: false,
                    url: 'brand/' + id, //url
                    type: 'PUT', //request method
                    data: { 'status': status, 'update': 'status' },
                    beforeSend:function(){
                    startLoader('.portlet-body');
                },complete:function(){
                    stopLoader('.portlet-body');
                },
                    success: function(data) {
                        window.LaravelDataTables["dataTableBuilder"].draw();
                        show_FlashMessage(data.message, 'success');

                    }
                });
            }
        })

    });


    $(document).on('click', '.delete-contract', function(e) {

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
                    url: 'brand/' + id, //url
                    type: 'DELETE', //request method
                    beforeSend:function(){
                    startLoader('.portlet-body');
                },complete:function(){
                    stopLoader('.portlet-body');
                },
                    success: function(result) {
                        window.LaravelDataTables["dataTableBuilder"].draw();
                        show_FlashMessage(result.message, 'success');
                    },
                    error:function(err)
                    {
                        if(err.status == 402)
                        {
                            show_FlashMessage(err.responseJSON.message, 'error');
                        }
                    }

                });
            }
        })
    });


    $("form[name='create_form']").submit(function(e) {
        e.preventDefault();
        $.ajax({
            url: 'brand', //url
            type: 'POST', //request method
            data: $(this).serialize(),
             beforeSend:function(){
                    startLoader('.modal-content');
                },complete:function(){
                    stopLoader('.modal-content');
                },
            success: function(data) {

                window.LaravelDataTables["dataTableBuilder"].draw();
                $('#createModal').modal('toggle');
                show_FlashMessage(data.message, 'success');

            }
        });

    });



    $(document).on('click', '.view-contract', function(e) {
        var id = $(this).data("id");
        $.ajax({
            url: 'brand/' + id, //url
            type: 'GET', //request method
            success: function(data) {
                console.log();
                $.each(data.data, function(index, el) {
                    $('#' + index + '_td').html('<div class="modal_description">' + el + '</div>');
                });
                $('#viewModal').modal('toggle');
                $('.edit-button-view').attr('id', data.data.url);
                //window.LaravelDataTables["dataTableBuilder"].draw();
            }
        });
    });


    $(document).on('click', '.edit-contract', function(e) {
        var id = $(this).data("id");
        $.ajax({
            url: 'brand/' + id + '/edit', //url
            type: 'GET', //request method
            beforeSend:function(){
                    startLoader('.portlet-body');
                },complete:function(){
                    stopLoader('.portlet-body');
                },
            success: function(data) {
                $.each(data.data, function(index, el) {
                    $('input[name="' + index + '"]').val(el);
                    $('select[name="' + index + '"]').val(el);
                });
                $('#editModal').modal('toggle');
                // window.LaravelDataTables["dataTableBuilder"].draw();
            }
        });
    });

    $(document).on('click', '.edit-button-view', function() {
        var id = $(this).attr("id");
        $.ajax({
            url: 'brand/' + id + '/edit', //url
            type: 'GET', //request method
            success: function(data) {
                $.each(data.data, function(index, el) {
                    $('input[name="' + index + '"]').val(el);
                    $('select[name="' + index + '"]').val(el);
                });
                $('#editModal').modal('toggle');
                //window.LaravelDataTables["dataTableBuilder"].draw();
            }
        });
    });

    $("form[name='edit_form']").submit(function(e) {
        e.preventDefault();
        var id = $("#id").val();
        $.ajax({
            url: 'brand/' + id, //url
            type: 'PUT', //request method
            data: $(this).serialize() + '&update=update',
            beforeSend:function(){
                    startLoader('.modal-content');
                },complete:function(){
                    stopLoader('.modal-content');
                },
            success: function(data) {
                window.LaravelDataTables["dataTableBuilder"].draw();
                $('#editModal').modal('toggle');
                show_FlashMessage(data.message, 'success');
            }
        });

    });

    $('#editModal').on('hidden.bs.modal', function(e) {
        $('.error').empty();
        $("form[name='edit_form']")[0].reset();
        $("form[name='create_form']")[0].reset();
    });
    $('#createModal').on('hidden.bs.modal', function(e) {
        $('.error').empty();
        $("form[name='create_form']")[0].reset();
        $("form[name='edit_form']")[0].reset();
    });

    $('#dataTableBuilder').on('preXhr.dt', function(e, settings, data) {
        data["status"] = $(".status").val();
        data["searchData"] = $("#dataTableBuilder_filter input").val();
    });

    $(document).on('change', '.status', function(e) {
        window.LaravelDataTables["dataTableBuilder"].draw();
        e.preventDefault();
    });

});