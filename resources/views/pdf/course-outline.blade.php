<!DOCTYPE html>
<html>
	<head>
		<title>Course Outlines</title>
		<style>
			/*table {
				font-family: arial, sans-serif;
				border-collapse: collapse;
				width: 100%;
			}*/
			/*td, th {
				border: 1px solid #dddddd;
				text-align: left;
				padding: 8px;
			}
			tr:nth-child(even) {
				background-color: #dddddd;
			}*/
			.card-body {
			    -webkit-box-flex: 1;
			    -ms-flex: 1 1 auto;
			    flex: 1 1 auto;
			    padding: 1.25rem;
			}
		</style>
	</head>
	<body>
		<div >
				<img src="{{public_path('img/main_header_logo.svg')}}" style="width: 100px;">
				<h1 style="text-align: center;"> Course Outlines </h1>
				<h3 style="text-align: center;">{{$course_name ?? ''}}</h3>
			@foreach(@$data as $key=>$row)
				<table class="table" style="{{$key == 0?'':'page-break-before: always;'}}">
				    <thead>
				      	<tr>
				        	<th style="text-align: center;">{{$row->title}}</th>
				      	</tr>
				    </thead>
				    <tbody>
				      	<tr>
					        <td>
					        	<div class="card-body">
					        		<br>
						        	<!-- <strong>Content</strong>:  -->
						        	{!! $row->description !!}
						        </div>
					        </td>
				      	</tr>
				    </tbody>
				</table>
				<br>
				<div class="page_breaking"></div> 
			@endforeach
		</div>
	</body>
</html>