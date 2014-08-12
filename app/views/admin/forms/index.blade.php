@extends('admin.partials.admin-master')
@section('content')

<div class="container small">

	<h1>Contact Form Entries</h1>

	<div class="well">

		@if(Session::has('success'))
			<div class="alert alert-success">{{Session::get('success')}}</div>
		@endif

		<div class="alert alert-success remove-success" style="display:none;">Entry successfully removed.</div>
		
		@if(count($entries) > 0)
		{{Form::open(['url'=>URL::route('bulk_delete_form_entries')])}}
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
						<td>
							{{Form::checkbox('id[]', $entry['id'])}}
							{{$date}}
						</td>
						<td><a href="mailto:{{$entry['email']}}">{{$entry['name']}}</a></td>
						<td>{{$entry['message']}}</td>
						<td><a href="{{$entry['id']}}" class="btn btn-mini btn-danger delete-entry">Delete</a></td>
					</tr>
					@endforeach
				</tbody>
			</table>
			{{Form::submit('Delete Selected', ['class'=>'btn btn-danger'])}}
			{{Form::close()}}
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
<script>
$('.delete-entry').on('click', function(e){
	e.preventDefault();
	var entry_id = $(this).attr('href');
	var item = $(this).parents('tr');

	$.ajax({
		url: "{{URL::route('delete_form_entry')}}",
		data: {
			id: entry_id
		},
		method: 'GET',
		success: function(data){
			$(item).fadeOut('slow', function(){
				$(this).remove();
				$('.remove-success').show().delay(5000).fadeOut();
			});
		}
	});

});
</script>
@stop