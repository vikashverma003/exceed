<!doctype html>
<html lang="en">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <style type="text/css">
            td {
                width: 13%;
            }
            td p{
                font-size: 14px!important;
            }
        </style>
    </head>
    <body style="width: 50%; margin: 20px auto;">
		<p style="margin-top:0pt; margin-bottom:0pt; font-size:12pt;"><img src="{{asset('img/order-confirm-img.png')}}" width="169" height="81" alt="Img">
			<br>
			<!-- <span style="width:36pt; display:inline-block;">&nbsp;</span> -->
			<span style="font-family:Calibri;">Order Confirmation#{{$data['order_id']}}&nbsp;</span>
		</p>
		
		<p style="margin-top:0pt; margin-bottom:0pt; font-size:12pt;">
			<br>
			<!-- <span style="width:36pt; display:inline-block;">&nbsp;</span> -->
			<span style="font-family:Calibri;">Placed on {{date('d/M/Y', strtotime($data['order_date']))}}</span>
		</p>
		
		<p style="margin-top:0pt; margin-bottom:0pt; font-size:12pt;">
			<br>
			<!-- <span style="width:36pt; display:inline-block;">&nbsp;</span> -->
			<u><span style="font-family:Calibri;"><a href="{{url('/transactions')}}" target="_blank">View your order</a>&nbsp;</span></u></p>
		
		<p style="margin-top:0pt; margin-bottom:0pt; font-size:12pt;"><span style="font-family:Calibri;">&nbsp;</span></p>
		<p style="margin-top:0pt; margin-bottom:0pt; font-size:12pt;"><span style="font-family:Calibri;">We would like to thank you for your booking the courses with us,&nbsp;</span><span style="font-family:Arial; font-size:9pt;">your order details are indicated below. To view your order history please&nbsp;</span><u><span style="font-family:Arial; font-size:9pt;"><a href="{{url('/')}}" target="_blank">LOGIN</a></span></u></p>

		<p style="margin-top:0pt; margin-bottom:0pt; font-size:12pt;"><span style="font-family:Calibri;">&nbsp;</span></p>
		<p style="margin-top:0pt; margin-bottom:0pt; font-size:12pt;"><span style="font-family:Calibri;">&nbsp;</span></p>


@if(isset($data['courseTimings']) && count($data['courseTimings']) > 0)
	@foreach(@$data['courseTimings'] as $key=>$subarr)
		<?php
			$course = \App\Models\Course::where('id', $key)->first(); 
		?>
		<p style="margin-top:0pt; margin-bottom:0pt; font-size:12pt;"><span style="font-family:Calibri;">&nbsp;</span></p>
		<p style="margin-top:0pt; margin-bottom:0pt; font-size:12pt;"><span style="font-family:Calibri;">&nbsp;</span></p>

		<p style="margin-top:0pt; margin-bottom:0pt; font-size:12pt;">
			<span style="font-family:Calibri;">{{$course->name}}&nbsp;</span>
		</p>

		<p style="margin-top:0pt; margin-bottom:0pt; font-size:12pt;">
			<span style="font-family:Calibri;">Course code: {{$key}}</span>
		</p>
		<table cellpadding="0" cellspacing="0" style="width:503.75pt; border:0.75pt solid #000000; border-collapse:collapse;">
		    <tbody>
		        <tr style="height:15.75pt;">
		            <td style="width:57.15pt; border-right-style:solid; border-right-width:0.75pt; border-bottom-style:solid; border-bottom-width:0.75pt; padding:1.12pt 1.88pt; vertical-align:bottom; background-color:#f2f2f2;">
		                <p style="margin-top:0pt; margin-bottom:0pt; font-size:8pt;"><span style="font-family:Hero;">Country</span></p>
		            </td>
		            <td style="width:45pt; border-right-style:solid; border-right-width:0.75pt; border-left-style:solid; border-left-width:0.75pt; border-bottom-style:solid; border-bottom-width:0.75pt; padding:1.12pt 1.88pt; vertical-align:bottom; background-color:#f2f2f2;">
		                <p style="margin-top:0pt; margin-bottom:0pt; font-size:8pt;"><span style="font-family:Hero;">City</span></p>
		            </td>
		            <td style="width:63.25pt; border-right-style:solid; border-right-width:0.75pt; border-left-style:solid; border-left-width:0.75pt; border-bottom-style:solid; border-bottom-width:0.75pt; padding:1.12pt 1.88pt; vertical-align:bottom; background-color:#f2f2f2;">
		                <p style="margin-top:0pt; margin-bottom:0pt; font-size:8pt;"><span style="font-family:Hero;">Location</span></p>
		            </td>
		             <td style="width:50.5pt; border-right-style:solid; border-right-width:0.75pt; border-left-style:solid; border-left-width:0.75pt; border-bottom-style:solid; border-bottom-width:0.75pt; padding:1.12pt 1.88pt; vertical-align:bottom; background-color:#f2f2f2;">
                        <p style="margin-top:0pt; margin-bottom:0pt; font-size:8pt;"><span style="font-family:Hero;">Timezone</span></p>
                    </td>
		            <td style="width:44.8pt; border-right-style:solid; border-right-width:0.75pt; border-left-style:solid; border-left-width:0.75pt; border-bottom-style:solid; border-bottom-width:0.75pt; padding:1.12pt 1.88pt; vertical-align:bottom; background-color:#f2f2f2;">
		                <p style="margin-top:0pt; margin-bottom:0pt; font-size:8pt;"><span style="font-family:Hero;">Method</span></p>
		            </td>
		            <td style="width:57.1pt; border-right-style:solid; border-right-width:0.75pt; border-left-style:solid; border-left-width:0.75pt; border-bottom-style:solid; border-bottom-width:0.75pt; vertical-align:top; background-color:#f2f2f2;">
		                <p style="margin-top:0pt; margin-bottom:14pt; font-size:8pt;"><span style="font-family:Hero;">&nbsp;</span></p>
		                <p style="margin-top:14pt; margin-bottom:0pt; font-size:8pt;"><span style="font-family:Hero;">Duration</span></p>
		            </td>
		            <td style="width:38.35pt; border-right-style:solid; border-right-width:0.75pt; border-left-style:solid; border-left-width:0.75pt; border-bottom-style:solid; border-bottom-width:0.75pt; padding:1.12pt 1.88pt; vertical-align:bottom; background-color:#f2f2f2;">
		                <p style="margin-top:0pt; margin-bottom:0pt; font-size:8pt;"><span style="font-family:Hero;">Start Date</span></p>
		            </td>
		            <td style="width:36pt; border-right-style:solid; border-right-width:0.75pt; border-left-style:solid; border-left-width:0.75pt; border-bottom-style:solid; border-bottom-width:0.75pt; padding:1.12pt 1.88pt; vertical-align:bottom; background-color:#f2f2f2;">
		                <p style="margin-top:0pt; margin-bottom:0pt; font-size:8pt;"><span style="font-family:Hero;">End Date</span></p>
		            </td>
		            <td style="width:72.4pt; border-right-style:solid; border-right-width:0.75pt; border-left-style:solid; border-left-width:0.75pt; border-bottom-style:solid; border-bottom-width:0.75pt; padding:1.12pt 1.88pt; vertical-align:bottom; background-color:#f2f2f2;">
		                <p style="margin-top:0pt; margin-bottom:0pt; font-size:8pt;"><span style="font-family:Hero;">Time</span></p>
		            </td>
		            <td style="width:50.5pt; border-right-style:solid; border-right-width:0.75pt; border-left-style:solid; border-left-width:0.75pt; border-bottom-style:solid; border-bottom-width:0.75pt; padding:1.12pt 1.88pt; vertical-align:bottom; background-color:#f2f2f2;">
                        <p style="margin-top:0pt; margin-bottom:0pt; font-size:8pt;"><span style="font-family:Hero;">Seats</span></p>
                    </td>
		            <td style="width:55.95pt; border-left-style:solid; border-left-width:0.75pt; border-bottom-style:solid; border-bottom-width:0.75pt; vertical-align:bottom; background-color:#f2f2f2;">
		                <p style="margin-top:0pt; margin-bottom:0pt; font-size:8pt;"><span style="font-family:Hero;">Price AED</span></p>
		            </td>
		        </tr>
		        @foreach(@$subarr as $row)
		        <tr style="height:15.75pt;">
		            <td style="width:57.15pt; border-top-style:solid; border-top-width:0.75pt; border-right-style:solid; border-right-width:0.75pt; padding:1.12pt 1.88pt; vertical-align:top;">
		                <p style="margin-top:0pt; margin-bottom:0pt; font-size:8pt;"><span style="font-family:Hero; color:#212529;">{{$row['country'] ?? 'N/A'}}</span></p>
		            </td>
		            <td style="width:45pt; border-top-style:solid; border-top-width:0.75pt; border-right-style:solid; border-right-width:0.75pt; border-left-style:solid; border-left-width:0.75pt; padding:1.12pt 1.88pt; vertical-align:top;">
		                <p style="margin-top:0pt; margin-bottom:0pt; font-size:8pt;"><span style="font-family:Hero; color:#212529;">{{$row['city'] ?? 'N/A'}}</span></p>
		            </td>
		            <td style="width:63.25pt; border-top-style:solid; border-top-width:0.75pt; border-right-style:solid; border-right-width:0.75pt; border-left-style:solid; border-left-width:0.75pt; padding:1.12pt 1.88pt; vertical-align:top;">
		                <p style="margin-top:0pt; margin-bottom:0pt; font-size:8pt;"><span style="font-family:Hero; color:#0000ff;">{{$row['location'] ?? 'N/A'}}</span></p>
		            </td>
		            <td style="width:50.5pt; border-top-style:solid; border-top-width:0.75pt; border-right-style:solid; border-right-width:0.75pt; border-left-style:solid; border-left-width:0.75pt; padding:1.12pt 1.88pt; vertical-align:top;">
                        <p style="margin-top:0pt; margin-bottom:0pt; font-size:8pt;"><span style="font-family:Hero; color:#212529;">{{$row['timezone'] ?? 'N/A'}}</span></p>
                    </td>
		            <td style="width:44.8pt; border-top-style:solid; border-top-width:0.75pt; border-right-style:solid; border-right-width:0.75pt; border-left-style:solid; border-left-width:0.75pt; padding:1.12pt 1.88pt; vertical-align:top;">
		                <p style="margin-top:0pt; margin-bottom:0pt; font-size:8pt;"><span style="font-family:Hero; color:#212529;">{{$row['training_type'] ?? 'N/A'}}</span></p>
		            </td>
		            <td style="width:57.1pt; border-top-style:solid; border-top-width:0.75pt; border-right-style:solid; border-right-width:0.75pt; border-left-style:solid; border-left-width:0.75pt; vertical-align:top;">
		                <p style="margin-top:0pt; margin-bottom:0pt; font-size:8pt;"><span style="font-family:Hero;">{{$course->duration}} {{$course->duration_type}}</span></p>
		            </td>
		            <td style="width:38.35pt; border-top-style:solid; border-top-width:0.75pt; border-right-style:solid; border-right-width:0.75pt; border-left-style:solid; border-left-width:0.75pt; padding:1.12pt 1.88pt; vertical-align:top;">
		                <p style="margin-top:0pt; margin-bottom:14pt; font-size:8pt;"><span style="font-family:Hero; color:#212529;">{{$row['start_date'] ?? 'N/A'}}</span></p>
		                <p style="margin-top:14pt; margin-bottom:0pt; font-size:8pt;"><span style="font-family:Hero;">&nbsp;</span></p>
		            </td>
		            <td style="width:36pt; border-top-style:solid; border-top-width:0.75pt; border-right-style:solid; border-right-width:0.75pt; border-left-style:solid; border-left-width:0.75pt; padding:1.12pt 1.88pt; vertical-align:top;">
		                <p style="margin-top:0pt; margin-bottom:0pt; font-size:8pt;"><span style="font-family:Hero; color:#212529;">{{$row['date'] ?? 'N/A'}}</span></p>
		            </td>
		            <td style="width:72.4pt; border-top-style:solid; border-top-width:0.75pt; border-right-style:solid; border-right-width:0.75pt; border-left-style:solid; border-left-width:0.75pt; padding:1.12pt 1.88pt; vertical-align:top;">
		                <p style="margin-top:0pt; margin-bottom:0pt; font-size:8pt;"><span style="font-family:Hero; color:#212529;">{{$row['start_time'] ?? ''}} - {{$row['end_time'] ?? ''}}</span></p>
		            </td>
		             <td style="width:50.5pt; border-top-style:solid; border-top-width:0.75pt; border-right-style:solid; border-right-width:0.75pt; border-left-style:solid; border-left-width:0.75pt; padding:1.12pt 1.88pt; vertical-align:top;">
                        <p style="margin-top:0pt; margin-bottom:0pt; font-size:8pt;"><span style="font-family:Hero; color:#212529;">{{$row['seats'] ?? 'N/A'}}</span></p>
                    </td>
		            <td style="width:55.95pt; border-top-style:solid; border-top-width:0.75pt; border-left-style:solid; border-left-width:0.75pt; vertical-align:top;">
		                <p style="margin-top:0pt; margin-bottom:0pt; font-size:8pt;">
		                	<span style="font-family:Hero; color:#212529;">&nbsp;</span>
		                	<span style="font-family:Hero; color:#212529;">&nbsp;{{$course->offer_price}}</span>
		                </p>
		            </td>
		        </tr>
		        @endforeach
		    </tbody>
		</table>
	@endforeach
@endif

<p style="margin-top:0pt; margin-bottom:0pt; font-size:12pt;"><span style="font-family:Calibri;">&nbsp;</span></p>
<p style="margin-top:0pt; margin-bottom:0pt; font-size:12pt;"><span style="font-family:Calibri;">&nbsp;</span></p>
<table cellpadding="0" cellspacing="0" style="width:653.05pt; border-collapse:collapse;">
    <tbody>
        <tr>
            <td style="width:394.65pt; border-top-style:solid; border-top-width:0.75pt; padding:0.38pt 0.75pt 0.75pt 1.5pt; vertical-align:top;">
                <p style="margin-top:0pt; margin-bottom:0pt; font-size:12pt;"><span style="font-family:Calibri;">&nbsp;</span></p>
                <p style="margin-top:0pt; margin-bottom:0pt; font-size:12pt;"><span style="font-family:Calibri;">&nbsp;</span></p>
                <p style="margin-top:0pt; margin-bottom:0pt; font-size:12pt;"><span style="font-family:Calibri;">&nbsp;</span></p>
                <p style="margin-top:0pt; margin-bottom:0pt; font-size:12pt;"><span style="font-family:Calibri;">&nbsp;</span></p>
                <p style="margin-top:0pt; margin-bottom:0pt; font-size:12pt;"><span style="font-family:Calibri;">&nbsp;</span></p>
                <p style="margin-top:0pt; margin-bottom:0pt; font-size:12pt;"><span style="font-family:Calibri;">&nbsp;</span></p>
                <table cellpadding="0" cellspacing="0" style="width:425.35pt; border-collapse:collapse;">
                    <tbody>
                        <tr>
                            <td colspan="2" style="width:425.35pt; padding-bottom:12pt; vertical-align:top;">
                                <p style="margin-top:0pt; margin-bottom:0pt; line-height:13.5pt;"><span style="font-family:'Times New Roman'; font-size:10pt;">&nbsp;</span></p>
                            </td>
                        </tr>
                        <tr>
                            <td style="width:127.6pt; padding-right:7.5pt; vertical-align:top;">
                                <p style="margin-top:0pt; margin-bottom:0pt; line-height:13.5pt;"><span style="font-family:Arial; font-size:10pt;">Item Subtotal:</span><span style="font-family:Arial; font-size:10pt;">&nbsp;</span></p>
                            </td>
                            <td style="width:282.75pt; padding-right:7.5pt; vertical-align:top;">
                                <p style="margin-top:0pt; margin-bottom:0pt; line-height:13.5pt;"><span style="font-family:Arial; font-size:10pt;">AED {{$data['order_total']}}</span><span style="font-family:Arial; font-size:10pt;">&nbsp;</span></p>
                            </td>
                        </tr>
                        <tr>
                            <td style="width:127.6pt; padding-right:7.5pt; vertical-align:top;">
                                <p style="margin-top:0pt; margin-bottom:0pt; line-height:13.5pt;"><span style="font-family:Arial; font-size:10pt;">VAT:</span><span style="font-family:Arial; font-size:10pt;">&nbsp;</span></p>
                            </td>
                            <td style="width:282.75pt; padding-right:7.5pt; vertical-align:top;">
                                <p style="margin-top:0pt; margin-bottom:0pt; line-height:13.5pt;"><span style="font-family:Arial; font-size:10pt;">AED 0</span><span style="font-family:Arial; font-size:10pt;">&nbsp;</span></p>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" style="width:417.85pt; padding-right:7.5pt; vertical-align:top;">
                                <p style="margin-top:0pt; margin-bottom:0pt; font-size:10pt;"><span style="font-family:Arial;">&nbsp;</span></p>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" style="width:417.85pt; padding-right:7.5pt; vertical-align:top;">
                                <p style="margin-top:0pt; margin-bottom:0pt; font-size:10pt;"><span style="font-family:'Times New Roman';">&nbsp;</span></p>
                            </td>
                        </tr>
                        <tr>
                            <td style="width:127.6pt; padding-right:7.5pt; vertical-align:top;">
                                <p style="margin-top:0pt; margin-bottom:0pt; line-height:13.5pt;"><strong><span style="font-family:Arial; font-size:9pt;">Order Total:</span></strong></p>
                            </td>
                            <td style="width:282.75pt; padding-right:7.5pt; vertical-align:top;">
                                <p style="margin-top:0pt; margin-bottom:0pt; line-height:13.5pt;"><strong><span style="font-family:Arial; font-size:9pt;">AED {{$data['order_total']}}</span></strong></p>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" style="width:425.35pt; padding-bottom:12pt; vertical-align:top;">
                                <p style="margin-top:0pt; margin-bottom:0pt; line-height:13.5pt;"><span style="font-family:Arial; font-size:9pt;">&nbsp;</span></p>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" style="width:425.35pt; border-top:0.75pt solid #eaeaea; padding-bottom:12pt; vertical-align:top;">
                                <p style="margin-top:0pt; margin-bottom:0pt; line-height:13.5pt;"><span style="font-family:'Times New Roman'; font-size:10pt;">&nbsp;</span></p>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <p style="margin-top:0pt; margin-bottom:0pt; line-height:13.5pt;"><br></p>
            </td>
        </tr>
        <tr>
            <td style="width:395.4pt; padding:0.75pt; vertical-align:top;">
                <p style="margin-top:0pt; margin-bottom:0pt; line-height:13.5pt;"><span style="font-family:Arial; font-size:10pt;">&nbsp;</span></p>
            </td>
        </tr>
        <tr>
            <td style="width:395.4pt; padding:0.75pt; vertical-align:top;">
                <table cellpadding="0" cellspacing="0" style="width:448.5pt; border-collapse:collapse;">
                    <tbody>
                        <tr>
                            <td style="width:448.5pt; vertical-align:top;">
                                <p style="margin-top:0pt; margin-bottom:0pt; line-height:12pt; border-bottom:0.75pt solid #eaeaea; padding-bottom:15pt;"><span style="font-family:Arial; font-size:9pt;">We hope to see you soon!</span><br><span style="font-family:Arial; font-size:9pt;">exceed-media.com</span></p>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <p style="margin-top:0pt; margin-bottom:0pt; line-height:13.5pt;"><br></p>
            </td>
        </tr>
    </tbody>
</table>
<p style="margin-top:0pt; margin-bottom:0pt; font-size:12pt;"><span style="font-family:Calibri;">&nbsp;</span></p>
<p style="margin-top:0pt; margin-bottom:0pt; font-size:12pt;"><span style="font-family:Calibri;">&nbsp;</span></p>
<p style="margin-top:0pt; margin-bottom:0pt; font-size:12pt;"><span style="font-family:Calibri;">&nbsp;</span></p>
<p style="margin-top:0pt; margin-bottom:0pt; font-size:12pt;"><span style="font-family:Calibri;">&nbsp;</span></p>
<p style="margin-top:0pt; margin-bottom:0pt; font-size:12pt;"><span style="font-family:Calibri;">&nbsp;</span></p>
</body>
</html>