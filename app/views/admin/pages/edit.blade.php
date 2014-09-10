@extends('admin.partials.admin-master')
@section('content')


<div class="container small">

	<h1>Edit {{$page['title']}} Page <a href="{{URL::route('page', ['page'=>$page['slug']])}}" class="btn pull-right">View Page</a></h1>

	<div class="well">

		@if(Session::has('errors'))
		<div class="alert alert-danger">Ooops! Looks like there were some errors. That's not Joyful!</div>
		@endif

		@if(Session::has('success'))
		<div class="alert alert-success">{{Session::get('success')}}</div>
		@endif

		{{Form::open(['url'=>URL::route('update_page', ['id'=>$page['id']]), 'files'=>true])}}
		
		<h3>{{$page['title']}}</h3>

		<p>
			{{$errors->first('title', '<span class="text-danger"><strong>:message</strong></span><br>')}}
			{{Form::label('title', 'Page Title')}}
			{{Form::text('title', $page['title'], ['class'=>'form-control'])}}
		</p>

		@if($page['slug'] !== 'home' && $page['slug'] !== 'products')
		<p>
			<div class="slug">
				{{$errors->first('slug', '<span class="text-danger"><strong>:message</strong></span><br>')}}
				{{Form::label('slug', 'Page Link:')}}
				<p>
					{{URL::route('home')}}/
					<em>{{$page['slug']}}</em>
				</p>
				{{Form::text('slug', $page['slug'], ['class'=>'form-control hidden'])}}
				<button class="slug-ok btn hidden">Ok</button>
			</div>
		</p>
		@else
		{{Form::hidden('slug', $page['slug'])}}
		@endif

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
			{{Form::textarea('content', $page['content'], ['class'=>'redactor'])}}
		</p>

		<hr>

		<h3>Custom Fields</h3>
		
		<div class="alert alert-danger" id="customfielderrors" style="display:none;"></div>

		@if(count($page->customfields) > 0 )
		<ul class="customfields-existing">
			<?php $c = 0; ?>
			@foreach($page->customfields as $field)
			<li class="customfield-existing">
				<h4>{{$field->name}} <i class="icon-caret-down"></i></h4>
				<section>
					
					<p>
						<label>Name</label>
						{{Form::text('customfield[' . $c . '][name]', $field->name)}}
					</p>
					
					@if($field->field_type == 'text')
						<p>
							<label>Content</label>
							{{Form::text('customfield[' . $c . '][value]', $field->value)}}
						</p>

					@elseif($field->field_type == 'textarea')
						<p>
							<label>Content</label>
							{{Form::textarea('customfield[' . $c . '][value]', $field->value)}}
						</p>

					@elseif($field->field_type == 'editor')
						<p>
							<label>Content</label>
							{{Form::textarea('customfield[' . $c . '][value]', $field->value, ['class'=>'redactor'])}}
						</p>

					@else
						<div>
							<label>Image</label>
							<div class="image-thumb">
								<button class="remove-thumb">&times;</button>
								<img src="{{URL::asset('assets/uploads/page_images/_thumbs')}}/{{$field->value}}">
							</div>
							<div class="image-file" style="display:none;">
								{{Form::file('customfield[' . $c . '][value]')}}
							</div>
							<p class="image-name">{{substr($field->value, 11)}}</p>
						</div>
					@endif
					{{Form::hidden('customfield[' . $c . '][field_type]', $field->field_type)}}
					{{Form::hidden('customfield[' . $c . '][id]', $field->id)}}
					<a href="{{URL::route('destroy_custom_field', ['id'=>$field->id])}}" class="btn btn-danger delete-field">Delete Field</a>
				</section>
			</li>
			<?php $c++; ?>
			@endforeach
		</ul>
		@else
			<p>No custom fields.</p>
		@endif

		<div id="newfields"></div>
		<a href="#" class="btn btn-success add-custom">Add Custom Field</a>

		<hr>

		<div class="well">
			<h4>SEO Settings</h4>
			<div class="seo-preview">
				@if($page['seo_title'])
				<h4>Kickapoo Joy Juice - <span class="seo-title">{{$page['seo_title']}}</span></h4>
				@else
				<h4>Kickapoo Joy Juice</h4>
				@endif
				<p>
					<em>www.kickapoo.com/<span class="slug-seo">{{$page['slug']}}</span></em>
					<span class="seo-description">{{$page['seo_description']}}</span>
				</p>
			</div>
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

		{{Form::submit('Save Page', ['class'=>'btn btn-primary'])}}
		
		@if($page['slug'] !== 'home')
		<div class="delete-well">
			<a href="{{URL::route('destroy_page', ['slug'=>$page['slug']])}}" class="btn btn-danger">Delete Page</a>
		</div>
		@endif

		{{Form::close()}}

	</div><!-- .well -->
</div><!-- .container -->

@stop

@section('footercontent')
<script>
/**
* Delete a custom field
*/
$('.delete-field').on('click', function(e){
	e.preventDefault();
	var url = $(this).attr('href');
	var item = $(this).parents('.customfield-existing');
	if ( confirm('Are you sure you want to delete this field?') ){
		$.ajax({
			url: url,
			type: 'GET',
			success: function(data){
				$(item).fadeOut('slow', function(){
					$(item).remove();
				});
			}
		});
	}
});

/**
* Validate custom fields titles
*/
$('form').on('submit', function(e){
	e.preventDefault();
	$('#customfielderrors').hide();
	var data = $('form').serialize();
	$.ajax({
		url: '{{URL::route('validate_custom_fields')}}',
		data: data,
		type: 'POST',
		success: function(data){
			console.log(data);
			if ( data.status === 'success' ){
				$('form').unbind('submit');
				$('form').submit();
			} else {
				$('#customfielderrors').text(data.message).show();
			}
		}
	});
});

$('.add-custom').on('click', function(e){
	e.preventDefault();
	add_custom_field();
});

function add_custom_field()
{
	var count = $('.newfield').length;
	var html = '<div class="newfield"><span class="field_count" style="display:none;">' + count + '</span><p class="half"><label>Field Name</label><input type="text" name="newcustomfield[' + count + '][fieldname]" ></p>';
	html += '<p class="half right"><label for="fieldtype">Type of Field</label><select class="fieldtype" name="newcustomfield[' + count + '][fieldtype]"><option value="text">Text</option><option value="textarea">Textarea</option><option value="editor">Editor</option><option value="image">Image</option></select></p>';
	html += '<input type="hidden" name="newcustomfield[' + count + '][page_id]" id="page_id" value="{{$page["id"]}}">';
	html += '<p><label>Content</label><span class="newfieldcont"><input type="text" class="fieldvalue" name="newcustomfield[' + count + '][fieldvalue]" /></p></span><p><button class="btn cancel-new-field">Cancel</button></div>';
	$('#newfields').append(html);
}


$(document).ready(function(){
	var desc_count = $('#seo_description').val().length;
	seo_characters_remaining(desc_count);
	update_slug();
	apply_redactor();	
});
</script>
@stop