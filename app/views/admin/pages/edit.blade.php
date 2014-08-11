@extends('admin.partials.admin-master')
@section('content')


<div class="container small">

	<h1>Edit Page</h1>

	<div class="well">

		@if(Session::has('errors'))
		<div class="alert alert-danger">Ooops! Looks like there were some errors. That's not Joyful!</div>
		@endif

		@if(Session::has('success'))
		<div class="alert alert-success">{{Session::get('success')}}</div>
		@endif

		{{Form::open(['url'=>URL::route('update_settings')])}}
		
		<h3>{{$page['title']}}</h3>

		<p>
			{{$errors->first('title', '<span class="text-danger"><strong>:message</strong></span><br>')}}
			{{Form::label('title', 'Page Title')}}
			{{Form::text('title', $page['title'], ['class'=>'form-control'])}}
		</p>
		<p>
			{{$errors->first('slug', '<span class="text-danger"><strong>:message</strong></span><br>')}}
			{{Form::label('slug', 'Page Slug')}}
			{{Form::text('slug', $page['slug'], ['class'=>'form-control'])}}
		</p>
		<p>
			{{Form::label('status', 'Status')}}
			{{Form::select('status', ['publish'=>'Published', 'draft'=>'Draft'], $page['status'])}}
		</p>

		<hr>

		<p>
			{{Form::label('content', 'Content')}}
			{{Form::textarea('content', $page['content'], ['class'=>'page-content'])}}
		</p>


		{{Form::submit('Save Page', ['class'=>'btn btn-block btn-primary'])}}
		{{Form::close()}}

	</div><!-- .well -->
</div><!-- .container -->

@stop

@section('footercontent')
<script src="{{URL::asset('assets/js/redactor.min.js')}}"></script>
<script>
$(document).ready(function(){
	$('.page-content').redactor();
});
</script>
@stop