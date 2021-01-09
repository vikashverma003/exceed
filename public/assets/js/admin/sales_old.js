var pageNumber = 2;
var count  = 1;
var processing;
var filter_data = $("form[name=filter_sales]").serialize();
var jqxhr = {abort: function () {  }};
var selectedStartdate;
var selectedEnddate;

$(document).ready(function () {
    // var table = $('#dataTableBuilder').DataTable();
    // ckEditoCustomSettings();
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

    $(document).on('change', '#affiliateName, #ConnectionType, #PlanType', function () {

            loadListings(full_path +'/frame/filter?page=', 'filter_sales');
    });

    function loadListings(url,filter_form_name){

        var filtering = $("form[name=filter_sales]").serialize() + "&startDate=" + selectedStartdate + "&endDate=" + selectedEnddate;
        pageNumber = 2;
        processing = true;
        //abort previous ajax request if any
        jqxhr.abort();
        jqxhr =$.ajax({
            type : 'get',
            url : url,
            data : filtering,
            dataType : 'html',
            beforeSend:function(){
                startLoader('.page-content');
            },
            success : function(data){
                console.log(data);
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
                stopLoader('.page-content');
                //console.log('Error',"Unable to fetch the list");
            },
            complete:function(){
                count = $("table tr").length;
                // sale_id = $('table tr:last').attr('data-sale_id');
                // sale_id = [];
                // $("table tr:nth-last-child(-n+1)").each(function(){
                //     sale_id.push($(this).attr('data-sale_id'));
                // });
                processing = false;
                stopLoader('.page-content');
            }
        });
    }


    $(document).scroll(function(e){

        if (processing)
            return false;

        var scrollHeight = $(document).height();
        var scrollPosition = $(window).height() + $(window).scrollTop();
        if ((scrollHeight - scrollPosition) / scrollHeight === 0) {
            processing = true;
            var filtering = $("form[name=filter_sales]").serialize();
            onwindowscroll(filtering);
        }

    });
    function onwindowscroll(filter) {
        $.ajax({
            type : 'GET',
            url: full_path +'/frame/visits?page='+pageNumber+'&count='+count,
            data: filter,
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
                        $("#dynamicContent").empty().html('<tr><td colspan="7">Sorry, no data found</td></tr>');
                    }
                    processing = true;
                }
                pageNumber +=1;
            },error: function(data){

            },
            complete:function(){
                stopLoader('.loadmorediv');
            }
        });
    }

    $(document).on('click', '.filter-cancel', function (e) {
        $("form[name='filter_sales']")[0].reset();
            e.preventDefault();
        selectedStartdate='';
        selectedEnddate='';
        loadListings(full_path +'/frame/filter?page=', 'filter_sales');
    });

    $(function() {

        var start = moment().subtract(29, 'days');
        var end = moment();

        function cb(start, end) {
            $('#visitListDatePicker span').html(start.format('DD/MM/YYYY') + ' - ' + end.format('DD/MM/YYYY'));
        }

        $('#visitListDatePicker').daterangepicker({
            startDate: start,
            endDate: end,
            autoApply:false,
            format: "dd/mm/yyyy",
            setDate: new Date(),
            ranges: {
                'Today': [moment(), moment()],
                'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                'This Month': [moment().startOf('month'), moment().endOf('month')],
                'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
            }
        }, cb);

        cb(start, end);

    });

    $('#visitListDatePicker').on('apply.daterangepicker',function (ev,picker) {

       selectedStartdate =   picker.startDate.format('DD/MM/YYYY');
       selectedEnddate =  picker.endDate.format('DD/MM/YYYY');

       loadListings(full_path +'/frame/filter?page=', 'filter_sales');


    });

}); // Main closing braces

