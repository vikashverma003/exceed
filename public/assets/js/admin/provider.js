$(document).ready(function () {
    // var full_path = path + '/admin';
    var pageNumber = 1;
    var count  = 1;
    var processing;
    var filter_data = $("form[name=filter_providers]").serialize();

    var jqxhr = {abort: function () {  }};
    //onwindowscroll(filter_data);
    loadListings(full_path +'/list-provider?page=', 'filter_providers');
    const swalWithBootstrapButtons = Swal.mixin({
        confirmButtonClass: 'btn btn-success',
        cancelButtonClass: 'btn btn-danger',
        buttonsStyling: false,
    });

    $(document).scroll(function(e){
        if (processing)
            return false;

        var scrollHeight = $(document).height();
        var scrollPosition = $(window).height() + $(window).scrollTop();
        if ((scrollHeight - scrollPosition) / scrollHeight === 0) {
            processing = true;
            var filter_data = $("form[name=filter_providers]").serialize();
            onwindowscroll(filter_data);
        }
    });


    function onwindowscroll(filter_data) {
        //alert('loadListings');
        $.ajax({
            type : 'GET',
            url: full_path +'/list-provider?page='+pageNumber+'&count='+count,
            data: filter_data,
            dataType : 'html',
            beforeSend:function(){
                startLoader('.loadmorediv');
            },
            success : function(data){

                data = data.trim();
                if(data){
                    $('#dynamicContent').append(data);
                    count = $("table tr").length;
                    processing = false;
                } else{
                    if(pageNumber == 1) {
                        $("#dynamicContent").empty().html('<tr><td colspan="7">Sorry, No Data Found</td></tr>');
                    }
                    processing = true;
                }
                pageNumber +=1;
            },error: function(data){
                stopLoader('.loadmorediv');
            },
            complete:function(){
                stopLoader('.loadmorediv');
            }
        });
    }

    $(document).on('click', '.filter-cancel', function (e) {
        $("form[name='filter_providers']")[0].reset();
        e.preventDefault();
        loadListings(full_path +'/list-provider?page=', 'filter_providers');
    });


    $(document).on('keyup', '#provider_name,#provider_email,#provider_phone', function () {
        if(($(this).val().length) >= 2 || $(this).val().length ==0)
        {
            loadListings(full_path +'/list-provider?page=', 'filter_providers');
        }
    });

    $(document).on('change', '#filterStatus', function (e) {
        loadListings(full_path +'/list-provider?page=', 'filter_providers');
    });


    //render updated data based on filter,search and pagination
    function loadListings(url,filter_form_name){
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
                //console.log('Error',"Unable to fetch the list");
                stopLoader('.portlet');
            },
            complete:function(){
                count = $("table tr").length;
                //sale_id = $('table tr:last').attr('data-sale_id');
                sale_id = [];
                $("table tr:nth-last-child(-n+1)").each(function(){
                    sale_id.push($(this).attr('data-sale_id'));
                });
                processing = false;
                stopLoader('.portlet');
            }
        });
    }

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
                    url: 'provider/delete', //url
                    type: 'POST', //request method
                    data: {'id':id},
                    beforeSend:function(){
                        startLoader('.portlet');
                    },
                    complete:function(){
                        stopLoader('.portlet');
                    },
                    success: function(data) {
                        loadListings(full_path +'/list-provider?page=', 'filter_providers');
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
                    url: 'provider/status/'+id, //url
                    type: 'PUT', //request method
                    data: {'status':status,'update':'status'},
                    beforeSend: function() {
                        startLoader('.portlet');
                    },
                    complete: function() {
                        stopLoader('.portlet');
                    },
                    success: function(data) {
                        loadListings(full_path +'/list-provider?page=', 'filter_providers');
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


    $(document).on('click','.view-provider', function(e){
        let url = $(this).data("href");
        $.ajax({
            url: url, //url
            type: 'GET', //request method
            success: function(data) {
                if(data.data.logo.length)
                    img = data.data.logo[0].url;
                else
                    img = data.no_image;



                $('.td_logo').html("<div><a data-fancybox='gallery' href='"+img+"' data-toggle='tooltip' title='Logo'><img src='"+img+"' width='50px' height='50px'></a></div>");
                $('.td_bName').html('<div>'+data.data.business_name+'</div>');
                $('.td_abn').html('<div>'+data.data.abn+'</div>');
                $('.td_legalName').html('<div>'+data.data.legal_name+'</div>');
                $('.td_number').html('<div>'+data.data.contact_no+'</div>');
                $('.td_email').html('<div>'+data.data.email+'</div>');
                if(data.data.support_email){
                    $('.td_sEmail').html('<div>'+data.data.support_email+'</div>');
                }else{
                    $('.td_sEmail').html('<div>-</div>');
                }
                if(data.data.complaint_email){
                    $('.td_cEmail').html('<div>'+data.data.complaint_email+'</div>');
                }else{
                    $('.td_cEmail').html('<div>-</div>');
                }
                $('.td_address').html('<div>'+data.data.address+'</div>');
                $('#viewModal').modal('toggle');
                $('.edit-button-view').attr('href',data.url);
                //window.LaravelDataTables["dataTableBuilder"].draw();
            }
        });
    });

});    