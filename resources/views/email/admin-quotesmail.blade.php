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
            table {
                width: auto;
                max-width: auto;
                margin-bottom: 1rem;
                background-color: transparent;
            }
            .table-responsive {
    display: block;
    width: 100%;
    overflow-x: auto;
    -webkit-overflow-scrolling: touch;
    -ms-overflow-style: -ms-autohiding-scrollbar;
}
        </style>
    </head>
<body>
    <div style="width: 85%; margin: 20px auto;">
    <h1 style="margin-top:0pt; margin-bottom:14pt; font-size:14.5pt;"><span style="font-family:Helvetica; color:#3d4852;">Hello Admin!</span></h1>
    <p style="margin-top:0pt; margin-bottom:14pt; line-height:18pt;"><span style="font-family:Helvetica; font-size:12pt; color:#3d4852;">A prospect has sent a request for quote with below information.</span></p>


    <p style="margin-top:0pt; margin-bottom:14pt; line-height:18pt;"><strong><span style="font-family:Helvetica; font-size:12pt; color:#3d4852;">First Name</span></strong><span style="font-family:Helvetica; font-size:12pt; color:#3d4852;">: {{$data['first_name']}}</span></p>
    <p style="margin-top:0pt; margin-bottom:14pt; line-height:18pt;"><strong><span style="font-family:Helvetica; font-size:12pt; color:#3d4852;">Last Name</span></strong><span style="font-family:Helvetica; font-size:12pt; color:#3d4852;">: {{$data['last_name']}}</span></p>
    <p style="margin-top:0pt; margin-bottom:14pt; line-height:18pt;"><strong><span style="font-family:Helvetica; font-size:12pt; color:#3d4852;">Email</span></strong><span style="font-family:Helvetica; font-size:12pt; color:#3d4852;">:</span><span style="font-family:Helvetica; font-size:12pt; color:#3d4852;">&nbsp;</span><a href="mailto:{{$data['email']}}" style="text-decoration:none;"><u><span style="font-family:Helvetica; font-size:12pt; color:#0000ff;">{{$data['email']}}</span></u></a></p>
    <p style="margin-top:0pt; margin-bottom:14pt; line-height:18pt;"><strong><span style="font-family:Helvetica; font-size:12pt; color:#3d4852;">Phone</span></strong><span style="font-family:Helvetica; font-size:12pt; color:#3d4852;">: {{$data['phone']}}</span></p>
    <p style="margin-top:0pt; margin-bottom:14pt; line-height:18pt;"><strong><span style="font-family:Helvetica; font-size:12pt; color:#3d4852;">Company Name</span></strong><span style="font-family:Helvetica; font-size:12pt; color:#3d4852;">: {{$data['company_name']}}</span></p>
    <p style="margin-top:0pt; margin-bottom:14pt; line-height:18pt;"><strong><span style="font-family:Helvetica; font-size:12pt; color:#3d4852;">Address</span></strong><span style="font-family:Helvetica; font-size:12pt; color:#3d4852;">: {{$data['city'] ?? ''}}, {{$data['state'] ?? ''}}, {{$data['country'] ?? ''}} - {{$data['zipcode']}}</span><span style="font-family:Helvetica; font-size:12pt; color:#3d4852;">&nbsp;</span></p>

    <p style="margin-top:0pt; margin-bottom:14pt; line-height:18pt;"><strong><span style="font-family:Helvetica; font-size:12pt; color:#3d4852;">Message</span></strong><span style="font-family:Helvetica; font-size:12pt; color:#3d4852;">: {{$data['message']}}</span></p>

    @if(isset($data['courseTimings']) && count($data['courseTimings']) > 0)
            @foreach(@$data['courseTimings'] as $key=>$subarr)
                <?php
                    $course = \App\Models\Course::where('id', $key)->first(); 
                ?>
                <p style="margin-top:0pt; margin-bottom:14pt; line-height:18pt;"><span style="font-family:Hero; font-size:12pt; color:#3d4852;">&nbsp;</span></p>
                <div class="table-responsive">
                <table cellpadding="0" cellspacing="0" style="width:100%; border:1pt solid #000000; border-collapse:collapse;">
                    <tbody>
                        <tr style="height:15.75pt;">
                            <td colspan="3" style="border-right-style:solid; border-right-width:1pt; border-bottom-style:solid; border-bottom-width:1pt; padding:1pt 1.75pt; vertical-align:bottom; background-color:#d9d9d9;">
                                <p style="margin-top:0pt; margin-bottom:0pt; font-size:8pt;"><span style="font-family:Hero;">{{$course->name}}</span></p>
                            </td>
                            <td colspan="2" style="border-right-style:solid; border-right-width:1pt; border-bottom-style:solid; border-bottom-width:1pt; padding:1pt 1.75pt 1pt 2.25pt; vertical-align:bottom; background-color:#d9d9d9;">
                                <p style="margin-top:0pt; margin-bottom:0pt; font-size:8pt;"><span style="font-family:Hero;">Course code&nbsp;</span><span style="font-family:Hero;">{{$key}}</span></p>
                            </td>
                            <td style="border-right-style:solid; border-right-width:1pt; border-bottom-style:solid; border-bottom-width:1pt; padding:1pt 1.75pt 1pt 2.25pt; vertical-align:bottom; background-color:#d9d9d9;">
                                <p style="margin-top:0pt; margin-bottom:0pt; text-align:right; font-size:8pt;"><span style="font-family:Hero;">Duration</span><span style="font-family:Cambria;">&nbsp;</span></p>
                            </td>
                            <td style="width:30%!important; border-right-style:solid; border-right-width:1pt; border-bottom-style:solid; border-bottom-width:1pt; padding:1pt 1.75pt 1pt 2.25pt; vertical-align:bottom; background-color:#d9d9d9;">
                                <p style="margin-top:0pt; margin-bottom:0pt; font-size:8pt;"><span style="font-family:Hero;">{{$course->duration}}{{$course->duration_type}}</span></p>
                            </td>
                            <td style="width:50.5pt; border-right-style:solid; border-right-width:1pt; border-bottom-style:solid; border-bottom-width:1pt; padding:1pt 1.75pt 1pt 2.25pt; vertical-align:bottom; background-color:#d9d9d9;">
                                <p style="margin-top:0pt; margin-bottom:0pt; font-size:8pt;"><span style="font-family:Hero;">Price AED</span></p>
                            </td>
                            <td style="width:50.5pt; border-right-style:solid; border-right-width:1pt; border-bottom-style:solid; border-bottom-width:1pt; padding:1pt 1.75pt 1pt 2.25pt; vertical-align:bottom; background-color:#d9d9d9;">
                                <p style="margin-top:0pt; margin-bottom:0pt; font-size:8pt;"><span style="font-family:Hero;">Seats</span></p>
                            </td>
                            

                            
                        </tr>
                        <tr style="height:15.75pt;">
                            <td style="border-right:1pt solid #dee2e6; border-bottom:1pt solid #dee2e6; padding:1.5pt 1.75pt 1pt; vertical-align:bottom; background-color:#f3f3f3;">
                                <p style="margin-top:0pt; margin-bottom:0pt; font-size:8pt;"><span style="font-family:Hero; color:#212529;">Country</span></p>
                            </td>
                            <td style="border-right:1pt solid #dee2e6; border-bottom:1pt solid #dee2e6; padding:1.5pt 1.75pt 1pt 2.25pt; vertical-align:bottom; background-color:#f3f3f3;">
                                <p style="margin-top:0pt; margin-bottom:0pt; font-size:8pt;"><span style="font-family:Hero; color:#212529;">City</span></p>
                            </td>
                            <td style="border-right:1pt solid #dee2e6; border-bottom:1pt solid #dee2e6; padding:1.5pt 1.75pt 1pt 2.25pt; vertical-align:bottom; background-color:#f3f3f3;">
                                <p style="margin-top:0pt; margin-bottom:0pt; font-size:8pt;"><span style="font-family:Hero; color:#212529;">Location</span></p>
                            </td>
                            <td style="border-right:1pt solid #dee2e6; border-bottom:1pt solid #dee2e6; padding:1.5pt 1.75pt 1pt 2.25pt; vertical-align:bottom; background-color:#f3f3f3;">
                                <p style="margin-top:0pt; margin-bottom:0pt; font-size:8pt;"><span style="font-family:Hero; color:#212529;">Training Method</span></p>
                            </td>
                            <td style="border-right:1pt solid #dee2e6; border-bottom:1pt solid #dee2e6; padding:1.5pt 1.75pt 1pt 2.25pt; vertical-align:bottom; background-color:#f3f3f3;">
                                <p style="margin-top:0pt; margin-bottom:0pt; font-size:8pt;"><span style="font-family:Hero; color:#212529;">Start Date</span></p>
                            </td>
                            <td style="border-right:1pt solid #dee2e6; border-bottom:1pt solid #dee2e6; padding:1.5pt 1.75pt 1pt 2.25pt; vertical-align:bottom; background-color:#f3f3f3;">
                                <p style="margin-top:0pt; margin-bottom:0pt; font-size:8pt;"><span style="font-family:Hero; color:#212529;">End Date</span></p>
                            </td>
                            <td style="width:30%!important; border-right-style:solid; border-right-width:1pt; border-bottom:1pt solid #dee2e6; padding:1.5pt 1.75pt 1pt 2.25pt; vertical-align:bottom; background-color:#f3f3f3;">
                                <p style="margin-top:0pt; margin-bottom:0pt; font-size:8pt;"><span style="font-family:Hero; color:#212529;">Time</span></p>
                            </td>
                            <td style="width:50.5pt; border-right-style:solid; border-right-width:1pt; border-bottom:1pt solid #dee2e6; padding:1.5pt 1.75pt 1pt 2.25pt; vertical-align:bottom; background-color:#f3f3f3;">
                                <p style="margin-top:0pt; margin-bottom:0pt; font-size:8pt;"><span style="font-family:Hero; color:#212529;"></span></p>
                            </td>
                            <td style="width:50.5pt; border-right-style:solid; border-right-width:1pt; border-bottom:1pt solid #dee2e6; padding:1.5pt 1.75pt 1pt 2.25pt; vertical-align:bottom; background-color:#f3f3f3;">
                                <p style="margin-top:0pt; margin-bottom:0pt; font-size:8pt;"><span style="font-family:Hero; color:#212529;">&nbsp;</span></p>
                            </td>
                        </tr>

                        @foreach(@$subarr as $row)
                            <tr style="height:15.75pt;">
                                <td style="border-right:1pt solid #cccccc; border-bottom:1pt solid #cccccc; padding:1.5pt 1.75pt 1pt; vertical-align:top;">
                                    <p style="margin-top:0pt; margin-bottom:0pt; font-size:8pt;"><span style="font-family:Hero; color:#212529;">{{$row['country'] ?? 'N/A'}}</span></p>
                                </td>
                                <td style="border-right:1pt solid #cccccc; border-bottom:1pt solid #cccccc; padding:1.5pt 1.75pt 1pt 2.25pt; vertical-align:top;">
                                    <p style="margin-top:0pt; margin-bottom:0pt; font-size:8pt;"><span style="font-family:Hero; color:#212529;">{{$row['city'] ?? 'N/A'}}</span></p>
                                </td>
                                <td style="border-right:1pt solid #cccccc; border-bottom:1pt solid #cccccc; padding:1.5pt 1.75pt 1pt 2.25pt; vertical-align:top;">
                                    <p style="margin-top:0pt; margin-bottom:0pt; font-size:8pt;"><span style="font-family:Hero; color:#0000ff;">{{$row['location'] ?? 'N/A'}}</span></p>
                                </td>
                                <td style="border-right:1pt solid #cccccc; border-bottom:1pt solid #cccccc; padding:1.5pt 1.75pt 1pt 2.25pt; vertical-align:top;">
                                    <p style="margin-top:0pt; margin-bottom:0pt; font-size:8pt;"><span style="font-family:Hero; color:#212529;">{{$row['training_type'] ?? 'N/A'}}</span></p>
                                </td>
                                <td style="border-right:1pt solid #cccccc; border-bottom:1pt solid #cccccc; padding:1.5pt 1.75pt 1pt 2.25pt; vertical-align:top;">
                                    <p style="margin-top:0pt; margin-bottom:0pt; font-size:8pt;"><span style="font-family:Hero; color:#212529;">{{$row['start_date'] ?? 'N/A'}}</span></p>
                                </td>
                                <td style="border-right:1pt solid #cccccc; border-bottom:1pt solid #cccccc; padding:1.5pt 1.75pt 1pt 2.25pt; vertical-align:top;">
                                    <p style="margin-top:0pt; margin-bottom:0pt; font-size:8pt;"><span style="font-family:Hero; color:#212529;">{{$row['date'] ?? 'N/A'}}</span></p>
                                </td>
                                <td style="width:30%!important; border-right-style:solid; border-right-width:1pt; border-bottom:1pt solid #cccccc; padding:1.5pt 1.75pt 1pt 2.25pt; vertical-align:top;">
                                    <p style="margin-top:0pt; margin-bottom:0pt; font-size:8pt;"><span style="font-family:Hero; color:#212529;">{{$row['start_time'] ?? ''}} - {{$row['end_time'] ?? ''}}</span></p>
                                </td>
                                <td style="width:50.5pt; border-right-style:solid; border-right-width:1pt; border-bottom:1pt solid #cccccc; padding:1.5pt 1.75pt 1pt 2.25pt; vertical-align:top;">
                                    <p style="margin-top:0pt; margin-bottom:0pt; font-size:8pt;"><span style="font-family:Hero; color:#212529;">{{$course->offer_price}}</span></p>
                                </td>
                                <td style="width:50.5pt; border-right-style:solid; border-right-width:1pt; border-bottom:1pt solid #cccccc; padding:1.5pt 1.75pt 1pt 2.25pt; vertical-align:top;">
                                    <p style="margin-top:0pt; margin-bottom:0pt; font-size:8pt;"><span style="font-family:Hero; color:#212529;">{{$row['seats'] ?? 'N/A'}}</span></p>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                </div>
            @endforeach
        @else
            <p style="margin-top:0pt; margin-bottom:14pt; line-height:18pt;"><span style="font-family:Hero; font-size:12pt; color:#3d4852;">Course Name: {{$data['course']}}</span></p>
        @endif

    <p style="margin-top:0pt; margin-bottom:14pt; line-height:18pt;"><span style="font-family:Hero; font-size:12pt; color:#3d4852;">&nbsp;</span></p>
        <p style="margin-top:0pt; margin-bottom:14pt; line-height:18pt; border-bottom:1.5pt solid #000000; padding-bottom:1pt;"><span style="font-family:Hero; font-size:12pt; color:#3d4852;">Regards,</span><br><span style="font-family:Hero; font-size:12pt; color:#3d4852;">Exceed Media Team</span></p>
        <p style="margin-top:0pt; margin-bottom:0pt; text-align:center; font-size:12pt;"><span style="font-family:Hero; color:#ff0000;">&nbsp;</span></p>
        <p style="margin-top:0pt; margin-bottom:0pt; text-align:center; font-size:12pt;"><span style="font-family:Hero; color:#ff0000;">&nbsp;</span></p>  
    </div>
</body>
</html>