@extends('admin.partials.admin-master')
@section('content')


<div class="container small">

	<h1>Edit Page <a href="{{URL::route('page', ['page'=>$page['slug']])}}" class="btn pull-right">View Page</a></h1>

	<div class="well">

		@if(Session::has('errors'))
		<div class="alert alert-danger">Ooops! Looks like there were some errors. That's not Joyful!</div>
		@endif

		@if(Session::has('success'))
		<div class="alert alert-success">{{Session::get('success')}}</div>
		@endif

		{{Form::open(['url'=>URL::route('update_page', ['id'=>$page['id']])])}}
		
		<h3>{{$page['title']}}</h3>

		<p>
			{{$errors->first('title', '<span class="text-danger"><strong>:message</strong></span><br>')}}
			{{Form::label('title', 'Page Title')}}
			{{Form::text('title', $page['title'], ['class'=>'form-control'])}}
		</p>

		<p>
			{{$errors->first('slug', '<span class="text-danger"><strong>:message</strong></span><br>')}}
			@if($page['slug'] == 'home')
			{{Form::label('slug', 'Page Slug (Home slug cannot be changed)')}}
			{{Form::text('slug', $page['slug'], ['class'=>'form-control readonly', 'readonly'])}}
			@else
			{{Form::label('slug', 'Page Slug')}}
			{{Form::text('slug', $page['slug'], ['class'=>'form-control'])}}
			@endif
		</p>

		<div class="well">
			<h4>General Settings</h4>
			<p class="half">
				{{Form::label('status', 'Status')}}
				{{Form::select('status', ['publish'=>'Published', 'draft'=>'Draft'], $page['status'])}}
			</p>

			<p class="half right">
				{{Form::label('template', 'Page Template')}}
				{{Form::select('template', $templates, $page['template'])}}
			</p>
		</div>

		<hr>

		<p>
			{{Form::label('content', 'Content')}}
			{{Form::textarea('content', $page['content'], ['class'=>'page-content'])}}
		</p>

		<hr>

		<div class="well">
			<h4>SEO Settings</h4>
			<p>
				{{Form::label('seo_title', 'SEO Title')}}
				{{Form::text('seo_title', $page['seo_title'])}}
			</p>
			<p>
				{{Form::label('seo_description', 'SEO Description')}}
				{{Form::textarea('seo_description', $page['seo_description'])}}
				<div id="description_count" class="alert alert-info"><span><strong>150</strong></span> Characters Remaining</div>
			</p>
		</div>

		{{Form::submit('Save Page', ['class'=>'btn btn-block btn-primary'])}}
		{{Form::close()}}

	</div><!-- .well -->
</div><!-- .container -->

@stop

@section('footercontent')
<script src="{{URL::asset('assets/js/redactor.min.js')}}"></script>
<script>
function seo_characters_remaining(count)
{
	var remaining = 160 - count;
	var info = $('#description_count');

	$('#description_count span').text(remaining);
	if ( remaining < 0 ){
		$(info).addClass('alert-danger');
	} else {
		$(info).removeClass('alert-danger');
	}
}

$('#seo_description').on('keyup', function(){
	var count = $(this).val().length;
	seo_characters_remaining(count);
});

$(document).ready(function(){

	var desc_count = $('#seo_description').val().length;
	seo_characters_remaining(desc_count);

	$('.page-content').redactor({
		imageUpload : '{{URL::route("editor_upload")}}',
		imageUploadCallback: function(image, json){
			console.log(json);
		},
		imageUploadErrorCallback: function(json){
			console.log(json.error);
		}
	});
});
</script>
@stop