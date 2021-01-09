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

    $(document).on('change', '#affiliateName, #ConnectionType, #PlanType, #providerName, #salesorting, #boughtThrough', function () {

            loadListings(full_path +'/sales/filter?page=', 'filter_sales');
    });

    $(document).on('keyup', '#searchUserName', function () {

        if($('#searchUserName').val().length > 2)
        {
            loadListings(full_path + '/sales/filter?page=', 'filter_sales');
        }

        if($('#searchUserName').val().length == 0)
        {
            loadListings(full_path + '/sales/filter?page=', 'filter_sales');
        }
    });

    $(document).on('keyup', '#searchSaleId', function () {

        if($('#searchSaleId').val().length > 2)
        {
            loadListings(full_path + '/sales/filter?page=', 'filter_sales');
        }

        if($('#searchSaleId').val().length == 0)
        {
            loadListings(full_path + '/sales/filter?page=', 'filter_sales');
        }
    });

    $(document).on('keyup', '#searchEmail', function () {

        if($('#searchEmail').val().length > 2)
        {
            loadListings(full_path + '/sales/filter?page=', 'filter_sales');
        }

        if($('#searchEmail').val().length == 0)
        {
            loadListings(full_path + '/sales/filter?page=', 'filter_sales');
        }
    });

    $(document).on('keyup', '#searchPhone', function () {

        if($('#searchPhone').val().length > 2)
        {
            loadListings(full_path + '/sales/filter?page=', 'filter_sales');
        }

        if($('#searchPhone').val().length == 0)
        {
            loadListings(full_path + '/sales/filter?page=', 'filter_sales');
        }
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
                processing = false;
                stopLoader('.page-content');
                fillNA();
                fillSpan();

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
            url: full_path +'/sales/list?page='+pageNumber+'&count='+count,
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
                fillNA();
                fillSpan();

            }
        });
    }

    $(document).on('click', '.filter-cancel', function (e) {
        $("form[name='filter_sales']")[0].reset();
            e.preventDefault();
        selectedStartdate='';
        selectedEnddate='';
        loadListings(full_path +'/sales/filter?page=', 'filter_sales');
    });

    $(function() {

        var start = moment().subtract(29, 'days');
        var end = moment();

        function cb(start, end) {
            $('#saleListDatePicker span').html(start.format('DD/MM/YYYY') + ' - ' + end.format('DD/MM/YYYY'));
        }

        $('#saleListDatePicker').daterangepicker({
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
                'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
                'This Year': [moment().startOf('year'), moment().endOf('year')],
                'Last year': [moment().subtract(1, 'year'), moment()]

            }
        }, cb);

        cb(start, end);

    });

    $('#saleListDatePicker').on('apply.daterangepicker',function (ev,picker) {

        // ('#saleListDatePicker').data('daterangepicker').setEndDate(currentDate.format('DD/MM/YYYY'));

       selectedStartdate =   picker.startDate.format('DD/MM/YYYY');
       selectedEnddate =  picker.endDate.format('DD/MM/YYYY');

        loadListings(full_path +'/sales/filter?page=', 'filter_sales');


    });

    function fillNA()
    {
        $('.table tr td').each(function () {

            if($(this).html().trim() == ''){
                $(this).html('N/A');
            }
        });

    }
    function fillSpan() {
        $('.portlet-body span').each(function () {

            if ($(this).html().trim() == '') {
                $(this).html('N/A');
            }
        });
    }

    fillNA();
    fillSpan();

}); // Main closing braces

