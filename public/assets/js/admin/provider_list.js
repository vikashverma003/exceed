$(document).ready(function () {
    var pageNumber = 1;
    var count  = 1;
    var processing;
    var filter_data = $("form[name=filter_providers_list]").serialize();

    var jqxhr = {abort: function () {  }};
    //onwindowscroll(filter_data);
    loadListings(full_path +'/settings/provider-list?page=', 'filter_providers_list');
    const swalWithBootstrapButtons = Swal.mixin({
        confirmButtonClass: 'btn btn-success',
        cancelButtonClass: 'btn btn-danger',
        buttonsStyling: false,
    });  
    //To add & edit Provider   
    $("form[name='add_provider_form']").submit(function(e){
        e.preventDefault();
        var url = 'provider-list/add-new';
        var type = 'post';
        if ($("[name='id']").val() != ""){
            var url = 'provider-list/update';
            var type = 'post';
        }
        $(document).find('span.error').empty().hide();
        var fd = new FormData($("#add_provider_form")[0]);

        $.ajax({
            url: url, //url
            type: type, //request method
            data: fd,
            contentType: false,
            processData: false,
            async: true,
            cache: false,
            beforeSend: function() {
                startLoader('.portlet');
            },
            success: function(data) {
                $("#add_provider_form")[0].reset();
                $(".error").html(""); 
                setTimeout(function(){
                    stopLoader('.portlet');
                }, 2000);
                $('#createModal').modal('hide');
                show_FlashMessage(data.message, 'success');
                loadListings(full_path +'/settings/provider-list?page=', 'filter_providers_list');
            },
            error: function(error){

                if(error.status == 0 || error.readyState == 0) {
                    return;
                }
                else if(error.status == 401){
                    errors = $.parseJSON(error.responseText);
                }
                else if(error.status == 422) {
                    errors = error.responseJSON;
                    $.each(errors.errors, function(key, value) {
                        if(key.indexOf('.') != -1) {
                            let keys = key.split('.');
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
    //To add data in Modal Fields
    $(document).on('click','.edit', function(e){
        $(document).find('span.error').empty().hide();
        var id = $(this).data("id");
        var providerName = $(this).data("provider");    
        $("[name='id']").val(id);
        $("[name='name']").val(providerName);
        $('#createModal').modal('show');
    });
    //To clear pervious From Data
    $(document).on('click','#add', function(e){
        $("[name='id']").val('');
        $("[name='name']").val('');
        $('[name="logo"]').val('');
    });

    //To prevent page load while click on page number
    $(document).on('click', '.pagination a',function(event){
        event.preventDefault();
        $('li').removeClass('active');
        $(this).parent('li').addClass('active');
        var myurl = $(this).attr('href');
        var page=$(this).attr('href').split('page=')[1];
        loadListings(full_path +'/settings/provider-list?page='+page);
    });
    //filter Table Part start
    $(document).on('click', '.filter-cancel', function (e) {
        $("form[name='filter_providers_list']")[0].reset();
        e.preventDefault();
        loadListings(full_path +'/settings/provider-list?page=', 'filter_providers_list');
    });
    $(document).on('keyup', '#provider_name', function () {
        if(($(this).val().length) >= 2 || $(this).val().length ==0)
        {
            loadListings(full_path +'/settings/provider-list?page=', 'filter_providers_list');
        }
    });
    $(document).on('change', '#filterStatus', function (e) {
        loadListings(full_path +'/settings/provider-list?page=', 'filter_providers_list');
    });

    $('#createModal').on('hidden.bs.modal', function (e) {
        $('#add_provider_form')[0].reset();
    });
    //filter Table Part ends


    //render updated data based on filter,search and pagination
    function loadListings(url,filter_form_name=null){
        var filter_data = $("form[name="+filter_form_name+"]").serialize();
        pageNumber = 2;
        processing = true;
        //abort previous ajax request if any
        jqxhr.abort();
        jqxhr =$.ajax({
            type : 'get',
            url : url,
            data : filter_data,
            dataType : 'html',
            beforeSend:function(){
                startLoader('.portlet');
            },
            success : function(data){
                //$("#ReloadListing").empty().html(data);//render new data to table based on filter,search
                data = data.trim();
                if(data){
                    $("#dynamicContent").empty().html(data);//render new data to table based on filter,search
                    processing = false;
                } else{

                    $("#dynamicContent").empty().html('<tr><td colspan="14">Sorry, no data found</td></tr>');
                    processing = true;
                }
                total_rows = ($('#datatable_ajax tbody tr').length)-1;
            },
            error : function(response){
                stopLoader('.portlet');
            },
            complete:function(){
                count = $("table tr").length;
                sale_id = [];
                $("table tr:nth-last-child(-n+1)").each(function(){
                    sale_id.push($(this).attr('data-sale_id'));
                });
                processing = false;
                stopLoader('.portlet');
            }
        });
    }

    //Detete Provider from Provider-List
    $(document).on('click','.provider-delete', function(e){
        swalWithBootstrapButtons({
            title: 'Are you sure?',
            text: "You want to Delete Provider and all it's related data!",
            showCancelButton: true,
            confirmButtonText: 'Yes, Delete it!',
            cancelButtonText: 'No, cancel!',
            reverseButtons: true
        }).then((result) => {
            if (result.value) {
                var id = $(this).data("id");
                $.ajax({
                    async : false,
                    url: 'provider-list/delete', //url
                    type: 'delete', //request method
                    data: {'id':id},
                    beforeSend:function(){
                        startLoader('.portlet');
                    },
                    complete:function(){
                        stopLoader('.portlet');
                    },
                    success: function(data) {
                        loadListings(full_path +'/settings/provider-list?page=', 'filter_providers_list');
                        show_FlashMessage(data.message,'success');

                    },
                    error: function(error) {
                        if(error.status==422){
                            show_FlashMessage(error.responseJSON.message,'error')
                        }
                    }
                });
            }
        });

    });

    //Change Status of  provider from Provider-List
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
                    url: 'provider-list/status/'+id, //url
                    type: 'PUT', //request method
                    data: {'status':status,'update':'status'},
                    beforeSend: function() {
                        startLoader('.portlet');
                    },
                    complete: function() {
                        stopLoader('.portlet');
                    },
                    success: function(data) {
                        loadListings(full_path +'/settings/provider-list?page=', 'filter_providers_list');
                        show_FlashMessage(data.message,'success');
                    },
                    error: function(error) {
                        if(error.status==422){
                            show_FlashMessage(error.responseJSON.message,'error')
                        }
                    }
                });
            }
        });
    });
});    