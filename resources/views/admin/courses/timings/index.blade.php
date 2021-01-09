@extends('admin.layouts.app')
@section('title', 'Timings')

@section('css')
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/datepicker.css')}}">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.css">
@endsection

@section('content')
    <style type="text/css">
    .modal-dialog{
        width: 800px;
    }
    .dataTables_empty{
        text-align: center !important;
    }
    .logo-td{
        padding-top: 24px !important;
    }
    .btn + .btn {
         margin-left: 0px !important; 
    }
    .width-50{
        width: 50% !important;
    }
    td {
        font-size:14px;
    }
    .ui-timepicker-container,.datepicker-container{
        z-index: 9999 !important
    }
    .ui-timepicker-container{
        
        height: 50px;
        overflow: auto;
    }
    .ui-timepicker-viewport{
        width: 225px !important
    }
    </style>
    <!-- BEGIN PAGE HEADER-->
    <div class="page-head">
        <div class="page-title">
            <h1>
                Manage Timings For-{{ucfirst($course->name)}}
            </h1>
        </div>
    </div>
    <ul class="page-breadcrumb breadcrumb">
        <li>
            <i class="fa fa-circle"></i>
            <a href="{{ route('admin.dashboard') }}">Dashboard</a>
            <i class="fa fa-circle"></i>
             <a href="{{ url('admin/courses') }}">Courses Listing</a>
             <i class="fa fa-circle"></i>
             <a href="javascript:;">{{ucfirst($course->name)}}</a>
        </li>
    </ul>
    <!-- END PAGE HEADER-->
    <div class="portlet light md-shadow-z-2-i">
        <div class="portlet-title">
            <div class="caption">
                <a href="javascript:;" class="btn  btn-primary pull-right black add_btn" style="margin-top: 4px;margin-right: 5px;"><i class="fa fa-plus"></i>&nbsp;&nbsp; Add Time & Location</a>
            </div>
        </div>
        <div class="portlet-body">
            @include('admin.courses.timings.table')
        </div>
    </div>
    <input type="hidden" name="course_id" value="{{$course->id}}" id="course_id">

    <div id="myModal" class="modal fade" role="dialog" data-backdrop="static" data-keyboard="false" style="z-index: 9999;">
        <div class="modal-dialog" style="max-width: 40%">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title" style="text-align: center;">Add Location & Time</h4>
                </div>
                <div class="modal-body">
                    <form method="post" name="add_form" id="add_form" onsubmit="addForm()">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group country">
                                    <label for="recipient-name" class="col-form-label">Country :</label>
                                    <select name="country" class="form-control">
                                        <option value="">Select Country</option>
                                        @foreach(@$locations as $row)
                                            <option value="{{$row->name}}">{{$row->name}}</option>
                                        @endforeach
                                    </select>
                                    <span class="error"></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group location">
                                    <label for="recipient-name" class="col-form-label">Address :</label>
                                    <input type="text" class="form-control" name="location"> 
                                    <span class="error"></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group city">
                                    <label for="recipient-name" class="col-form-label">City :</label>
                                    <input type="text" class="form-control" name="city"> 
                                    <span class="error"></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group training_type">
                                    <label for="recipient-name" class="col-form-label">Training Method :</label>
                                        <select name="training_type" class="form-control">
                                        @foreach(@$training_types as $row)
                                            <option value="{{$row->name}}">{{$row->name}}</option>
                                        @endforeach
                                        </select>
                                    <span class="error"></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group start_date">
                                    <label for="recipient-name" class="col-form-label">Start Date :</label>
                                    <input type="text" class="form-control datepicker start_date_picker" name="start_date" required="true" readonly='true'> 
                                    <span class="error"></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group expiry_date">
                                    <label for="recipient-name" class="col-form-label">Expiry Date :</label>
                                    <input type="text" class="form-control datepicker expiry_date_picker" name="expiry_date" required="true" readonly='true'> 
                                    <span class="error"></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group start_time">
                                    <label for="recipient-name" class="col-form-label">Start Time :</label>
                                    <input type="text" class="form-control timepicker" name="start_time" required="true" readonly='true'> 
                                    <span class="error"></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group end_time">
                                    <label for="recipient-name" class="col-form-label">End TIme :</label>
                                    <input type="text" class="form-control timepicker" name="end_time" required="true" readonly='true'> 
                                    <span class="error"></span>
                                </div>
                            </div>
                        </div>
                         <div class="row">
                            <div class="col-md-6">
                                <div class="form-group timezone">
                                    <label for="recipient-name" class="col-form-label">Timezone :</label>
                                    <select name="timezone" class="form-control">
                                        <option value="">Select Timezone</option>
                                        @foreach(@$timezones as $row)
                                            <option value="{{$row->timezone}}">{{$row->timezone}}</option>
                                        @endforeach
                                    </select>
                                    <span class="error"></span>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary add_form_btn">Save</button>
                </div>
            </div>
        </div>
    </div>


    <div id="editmyModal" class="modal fade" role="dialog" data-backdrop="static" data-keyboard="false" style="z-index: 9999;">
        <div class="modal-dialog" style="max-width: 40%">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title" style="text-align: center;">Edit Location & Time</h4>
                </div>
                <div class="modal-body">
                    <form method="post" name="edit_form" id="edit_form" onsubmit="editForm()">
                        @csrf
                        <input type="hidden" name="id" value="" id="hidden_id">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group country">
                                    <label for="recipient-name" class="col-form-label">Country :</label>
                                    <select name="country" id="country" class="form-control">
                                        <option value="">Select Country</option>
                                        @foreach(@$locations as $row)
                                            <option value="{{$row->name}}">{{$row->name}}</option>
                                        @endforeach
                                    </select>
                                    <span class="error"></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group location">
                                    <label for="recipient-name" class="col-form-label">Address :</label>
                                    <input type="text" class="form-control" name="location"> 
                                    <span class="error"></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group city">
                                    <label for="recipient-name" class="col-form-label">City :</label>
                                    <input type="text" class="form-control" name="city"> 
                                    <span class="error"></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group training_type">
                                    <label for="recipient-name" class="col-form-label">Training Method :</label>
                                    <select name="training_type" class="form-control">
                                        @foreach(@$training_types as $row)
                                            <option value="{{$row->name}}">{{$row->name}}</option>
                                        @endforeach
                                        </select>
                                    <span class="error"></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group start_date">
                                    <label for="recipient-name" class="col-form-label">Start Date :</label>
                                    <input type="text" class="form-control datepicker start_date_picker" name="start_date" required="true" readonly='true'> 
                                    <span class="error"></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group expiry_date">
                                    <label for="recipient-name" class="col-form-label">Expiry Date :</label>
                                    <input type="text" class="form-control datepicker expiry_date_picker" name="expiry_date" required="true" readonly='true'> 
                                    <span class="error"></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group start_time">
                                    <label for="recipient-name" class="col-form-label">Start Time :</label>
                                    <input type="text" class="form-control timepicker" name="start_time" required="true" readonly='true'> 
                                    <span class="error"></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group end_time">
                                    <label for="recipient-name" class="col-form-label">End TIme :</label>
                                    <input type="text" class="form-control timepicker" name="end_time" required="true" readonly='true'> 
                                    <span class="error"></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group timezone">
                                    <label for="recipient-name" class="col-form-label">Timezone :</label>
                                    <select name="timezone" id="timezone" class="form-control">
                                        <option value="">Select Timezone</option>
                                        @foreach(@$timezones as $row)
                                            <option value="{{$row->timezone}}">{{$row->timezone}}</option>
                                        @endforeach
                                    </select>
                                    <span class="error"></span>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary edit_form_btn">Save</button>
                </div>
            </div>
        </div>
    </div>
    <div class="clearfix"></div>
@endsection


@section('pagejs')
<script src="{{ asset('assets/js/datepicker.js') }}" type="text/javascript"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js"></script>

<script src="{{ asset('assets/js/sweetalert2@9.js') }}" type="text/javascript"></script>
<script type="text/javascript">
    $('#datatable_ajax').DataTable();
    var jqxhr = {abort: function () {  }};

    var startDate = $(".start_date_picker");
    var $endDate = $(".expiry_date_picker");

    $(document).ready(function () {

        startDate.datepicker({
            autoHide: true,
            format: "dd/mm/yyyy",
            startDate: new Date()
        });
        $endDate.datepicker({
            autoHide: true,
            format: "dd/mm/yyyy",
            startDate: new Date(),
            setStartDate: $(".start_date_picker").datepicker('getDate'),
        });

        startDate.on('change', function () {
            $endDate.datepicker('setStartDate', $(".start_date_picker").datepicker('getDate'));
        });

        $('input.timepicker').timepicker({
             timeFormat: 'HH:mm:ss',
        });

        $('#myModal').on('hidden.bs.modal', function (e) {
            $('#add_form').find('input,select').val('');
            $('body').css('overflow', 'auto');
             $('body').css('position','static');
            $(document).find('span.error').empty().hide();

        });
         $('#editmyModal').on('hidden.bs.modal', function (e) {
            $('#add_form').find('input,select').val('');
            $('body').css('overflow', 'auto');
             $('body').css('position','static');
            $(document).find('span.error').empty().hide();

        });

        // add sub category
        $(document).on('click','.add_btn', function(){
            $('body').css('overflow','hidden');
            $('body').css('position','fixed');
            $('#myModal').modal('show');
        });

        $(document).on('click','.edit_btn', function(){
            var country = $(this).data('country');
            var timezone = $(this).data('timezone');
            var location = $(this).data('location');
            var training_type = $(this).data('training');
            var city = $(this).data('city');
            var id = $(this).data('id');
            var start_date = $(this).data('start_date');
            var date = $(this).data('date');
            var start = $(this).data('start');
            var end = $(this).data('end');
            $('#editmyModal').find('select#country').val(country);
            $('#editmyModal').find('select#timezone').val(timezone);
            $('#editmyModal').find('input[name="city"]').val(city);
            $('#editmyModal').find('input[name="location"]').val(location);
            $('#editmyModal').find('select[name="training_type"]').val(training_type);
            $('#editmyModal').find('input[name="id"]').val(id);
            $('#editmyModal').find('input[name="start_date"]').val(start_date);
            $('#editmyModal').find('input[name="expiry_date"]').val(date);
            $('#editmyModal').find('input[name="start_time"]').val(start);
            $('#editmyModal').find('input[name="end_time"]').val(end);
            $('body').css('overflow','hidden');
            $('body').css('position','fixed');
            $('#editmyModal').modal('show');
        });


        $('#add_form').on('submit', function(e){
            e.preventDefault();
            addForm();
        });

         $('#edit_form').on('submit', function(e){
            e.preventDefault();
            editForm();
        });


        // add sub category
        $(document).on('click','.add_form_btn', function(e){
            e.preventDefault();
            addForm();
        });

        $(document).on('click','.edit_form_btn', function(e){
            e.preventDefault();
            editForm();
        });

        function addForm(){
            $(document).find('span.error').empty().hide();

            var allData = new FormData($('#add_form')[0]);
            allData.append('course_id', $('#course_id').val());
            $.ajax({
                async : true,
                url: "{{url('admin/course-time/create')}}", //url
                type: 'post', //request method
                data: allData,
                processData: false,  // Important!
                contentType: false,
                beforeSend:function(){
                    startLoader('.modal-content');
                },
                complete:function(){
                    
                },
                success: function(data) {
                    if(data.status){
                        show_FlashMessage(data.message,'success');
                        setTimeout(function(){ 
                            window.location.reload(); 
                        }, 1000);
                    }else{
                        stopLoader('.modal-content');
                        show_FlashMessage(data.message,'error');
                    }
                },
                error: function(error){
                    
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
                            if(key.indexOf('.') != -1) {
                                let keys = key.split('.');
                                /*let keys_length = keys.length;*/
                                $('.'+keys[0]+'_'+keys[1]).find('span.error').empty().addClass('text-danger').text(value).finish().fadeIn();
                            }
                            else {
                                $('.'+key).find('span.error').empty().addClass('text-danger').text(value).finish().fadeIn();
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
                    stopLoader('.modal-content');
                }
            });
        }

        function editForm(){
            $(document).find('span.error').empty().hide();
            var allData = new FormData($('#edit_form')[0]);

            $.ajax({
                async : true,
                url: "{{url('admin/course-time/update')}}", //url
                type: 'post', //request method
                data: allData,
                processData: false,  // Important!
                    contentType: false,
                beforeSend:function(){
                    startLoader('.modal-content');
                },
                complete:function(){
                    
                },
                success: function(data) {
                    if(data.status){
                        show_FlashMessage(data.message,'success');
                        setTimeout(function(){ 
                            window.location.reload(); 
                        }, 1000);
                    }else{
                        stopLoader('.modal-content');
                        show_FlashMessage(data.message,'error');
                    }
                },
                error: function(error){
                    stopLoader('.modal-content');
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
                            if(key.indexOf('.') != -1) {
                                let keys = key.split('.');
                                /*let keys_length = keys.length;*/
                                $('.'+keys[0]+'_'+keys[1]).find('span.error').empty().addClass('text-danger').text(value).finish().fadeIn();
                            }
                            else {
                                $('.'+key).find('span.error').empty().addClass('text-danger').text(value).finish().fadeIn();
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
        }
    });
</script>
@endsection
