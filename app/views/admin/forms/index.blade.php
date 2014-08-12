@extends('admin.partials.admin-master')
@section('content')

<div class="container small">

	
	<h1>Contact Form Entries</h1>
	

	<div class="well">

		<div class="alert alert-success remove-success" style="display:none;">Entry successfully removed.</div>
		@if(count($entries) > 0)
			<table class="form-entries">
				<thead>
					<tr>
						<th>Date</th>
						<th>Name</th>
						<th>Message</th>
						<th>Delete</th>
					</tr>
				</thead>
				<tbody>
					@foreach($entries as $entry)
					<?php
					$date = date('M jS, Y', strtotime($entry['created_at']));
					?>
					<tr>
						<td>{{$date}}</td>
						<td><a href="mailto:{{$entry['email']}}">{{$entry['name']}}</a></td>
						<td>{{$entry['message']}}</td>
						<td><a href="" class="btn btn-mini btn-danger">Delete</a></td>
					</tr>
					@endforeach
				</tbody>
			</table>
		@else
			No contact form entries at this time.
		@endif
	</div><!-- .well -->
	
	<div class="pagination-cont">
		{{$entries->links()}}
	</div>

</div><!-- .container -->

@stop
@section('footercontent')

@stop