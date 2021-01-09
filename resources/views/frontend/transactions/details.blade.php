@extends('frontend.layouts.app')
@section('title', 'Transaction Details')

@section('css')
   
    <style type="text/css">
    body{
        font-size: 12px;
    }
    
    </style>
@endsection

@section('content')
    @include('frontend.layouts.header')
    <div class="main_section">
        <div class="press-rlaes-page">
            <div class="container">
                <div class="row">
                    <div class="col col-md-12 text-center">
                        <h2>Transaction Details</h2>
                    </div>
                </div>
            </div>
        </div>
        <div class="press-both pt-4 transctionDetail">
            <div class="container">
                <div class="portlet">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="fa fa-shopping-cart"></i>Order #{{$transaction->id}} <span class="hidden-480">
                            | {{date("d/m/Y h:i", strtotime($transaction->created_at))}} </span>
                        </div>
                        <div class="actions">
                            <a href="{{url('transactions')}}" class="btn yellow mr-2">
                                <i class="fa fa-angle-left"></i>
                                <span class="hidden-480">Back </span>
                            </a>
                            <!-- <a href="javascript:;" class="btn btn-xs default btn-editable"><i class="fa fa-print"></i> Print</a> -->
                        </div>
                    </div>
                    <div class="portlet-body">
                        <div class="row">
                            <div class="col-md-6 col-sm-12">
                                <div class="portlet red-sunglo box">
                                    <div class="portlet-title">
                                        <div class="caption">
                                            <i class="fa fa-cogs"></i>Billing Details
                                        </div>
                                    </div>
                                    <div class="portlet-body">
                                        
                                        
                                        <div class="row static-info">
                                            <div class="col-md-5 name">
                                                 Order #:
                                            </div>
                                            <div class="col-md-7 value">
                                                 {{$transaction->id}} 
                                            </div>
                                        </div>
                                        <div class="row static-info">
                                            <div class="col-md-5 name">
                                                 Order Date &amp; Time:
                                            </div>
                                            <div class="col-md-7 value">
                                                 {{date("d/m/Y h:i", strtotime($transaction->created_at))}}
                                            </div>
                                        </div>

                                        <div class="row static-info">
                                            <div class="col-md-5 name">
                                                 Payment Information:
                                            </div>
                                            <div class="col-md-7 value">
                                                 Credit Card
                                            </div>
                                        </div>
                                        <div class="row static-info">
                                            <div class="col-md-5 name">
                                                Coupon Discount:
                                            </div>
                                            <div class="col-md-7 value">
                                                @if($transaction->coupon_applied==1)
                                                    {{$transaction->discount}}%
                                                @else
                                                    0
                                                @endif
                                            </div>
                                        </div>
                                        <div class="row static-info">
                                            <div class="col-md-5 name">
                                                Total Amount Paid:
                                            </div>
                                            <div class="col-md-7 value">
                                                {{$transaction->currency ? $transaction->currency: 'AED'}} {{$transaction->total_amount_paid}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 col-sm-12">
                                <div class="portlet grey-cascade box">
                                    <div class="portlet-title">
                                        <div class="caption">
                                            <i class="fa fa-cogs"></i>Courses List
                                        </div>
                                    </div>
                                    <div class="portlet-body">
                                        <div class="table-responsive">
                                            <table class="table table-hover table-bordered table-striped">
                                                <thead>
                                                    <tr class="text-center">
                                                        <th>
                                                            Product
                                                        </th>

                                                        
                                                        <th>
                                                            Course Date
                                                        </th>
                                                        <th>
                                                            Course Time
                                                        </th>
                                                        <th>
                                                            Location
                                                        </th>
                                                        <th>
                                                            Training Method
                                                        </th>
                                                        <th>
                                                            Seats
                                                        </th>
                                                        <th>
                                                            Original Price
                                                        </th>
                                                        <th>
                                                            Discount Price
                                                        </th>
                                                        <th>
                                                           Total Amount
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($transaction['items'] as $subrow)
                                                        <tr class="text-center">
                                                            <td>
                                                                {{$subrow->course->name}}
                                                            </td>
                                                            
                                                            <td>
                                                                {{$subrow->start_date ? $subrow->start_date: ""}} To {{$subrow->date}}
                                                            </td>
                                                            
                                                            <td>
                                                               {{$subrow->start_time}} To {{$subrow->end_time}}
                                                            </td>
                                                            <td>
                                                                {{$subrow->location}}, {{$subrow->city}}, {{$subrow->country}}
                                                            </td>
                                                            <td>
                                                                {{$subrow->training_type ? $subrow->training_type: 'N/A'}}
                                                            </td>
                                                            <td>
                                                                {{$subrow->seats}}
                                                            </td>
                                                            <td>
                                                                {{$subrow->price ? $subrow->price : 0}}
                                                            </td>
                                                            <td>
                                                                {{$subrow->offer_price ? $subrow->offer_price: 0}}
                                                            </td>
                                                            
                                                            <td>
                                                                AED {{(int)$subrow->amount_paid*(int)$subrow->seats}}
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>

   @include('frontend.layouts.footer',['homeFooter'=>0])
   @include('frontend.includes.contact-us')
@endsection