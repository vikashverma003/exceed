@extends('frontend.layouts.app')
@section('title', 'Purchase history')
@section('css')
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/jquery.dataTables.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/datepicker.css')}}">
@endsection
@section('content')

    @include('frontend.layouts.header')
    <div class="main_section">
        <div class="press-rlaes-page">
            <div class="container">
                <div class="row">
                    <div class="col col-md-12 text-center">
                        <h2> Purchase history</h2>
                    </div>
                </div>
            </div>
        </div>
        <div class="press-both">
            <div class="container">
                <div class="row">
                    <div class="col col-md-12 mb-4">
                        @include('frontend.transactions.table')
                    </div>
                </div>
            </div>
        </div>
    </div>

   @include('frontend.layouts.footer',['homeFooter'=>0])
   @include('frontend.includes.contact-us')
@endsection

@section('scripts')
    <script type="text/javascript" src="{{asset('assets/js/jquery.dataTables.min.js')}}"></script>

    <script type="text/javascript">
        var filter_data = $("form[name=filter_listing]").serialize();
        var jqxhr = {abort: function () {  }};
        var $start_date = $('.start-date');
        var $end_date = $('.end-date');

        $(document).ready(function () {

            $start_date.datepicker({
                autoHide: true,
                format: "dd/mm/yyyy",
            });
            $end_date.datepicker({
                autoHide: true,
                format: "dd/mm/yyyy",
                startDate: $start_date.datepicker('getDate'),
            });

            $start_date.on('change', function () {
                $end_date.datepicker('setStartDate', $start_date.datepicker('getDate'));
            });

            $end_date.on('change', function () {
                if($('#from_dates').val()!=''){
                    loadListings(WEBSITE_URL + '/transactions?page=', 'filter_listing');
                }
            });


            $(document).on('keyup', '#amount,#discount', function () {
                loadListings(WEBSITE_URL + '/transactions?page=', 'filter_listing');
            });

            $(document).on("click", ".pagination li a", function (e){
                e.preventDefault();
                startLoader('body');
                var url = $(this).attr('href');
                var page = url.split('page=')[1];   ;       
                loadListings(url, 'filter_listing');
            });

            function loadListings(url,filter_form_name){

                var filtering = $("form[name=filter_listing]").serialize();
                //abort previous ajax request if any
                jqxhr.abort();
                jqxhr =$.ajax({
                    type : 'get',
                    url : url,
                    data : filtering,
                    dataType : 'html',
                    beforeSend:function(){
                        startLoader('body');
                    },
                    success : function(data){
                        data = data.trim();
                        $("#dynamicContent").empty().html(data);
                    },
                    error : function(response){
                        stopLoader('body');
                    },
                    complete:function(){
                        stopLoader('body');
                    }
                });
            }

            // reset form data
            $(document).on('click', '.filter-cancel', function (e) {
                e.preventDefault();
                $("form[name='filter_listing']")[0].reset();
                loadListings(WEBSITE_URL +'/transactions/?page=', 'filter_listing');
            });
        });
    </script>
@endsection