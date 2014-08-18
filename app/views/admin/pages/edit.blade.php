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

		<h4>Custom Fields</h4>
		@if(count($page->customfields) > 0 )
			@foreach($page->customfields as $field)
			<div class="customfield-existing">
				{{$field->key}}<br />
				<a href="{{URL::route('destroy_custom_field', ['id'=>$field->id])}}" class="btn btn-danger delete-field">Delete Field</a>
			</div>
			@endforeach
		@else
			<p>No custom fields.</p>
		@endif

		<div class="alert alert-danger" id="customfielderrors" style="display:none;"></div>
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

		{{Form::submit('Save Page', ['class'=>'btn btn-block btn-primary'])}}
		{{Form::close()}}

	</div><!-- .well -->
</div><!-- .container -->

@stop

@section('footercontent')
<script src="{{URL::asset('assets/js/redactor.min.js')}}"></script>
<script>

/**
* Cancel adding a custom field
*/
$(document).on('click', '.cancel-new-field', function(e){
	e.preventDefault();
	var item = $(this).parents('.newfield');
	$(item).fadeOut('slow', function(){
		$(item).remove();
	});
});

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
* Change the new custom field type
*/
$(document).on('change', '.fieldtype', function(){
	var type = $(this).val();
	var item = $(this).parents('.newfield');
	var count = $(item).find('.field_count').text();
	$('#fieldvalue').val('');
	$('#newfieldcont').empty();
	custom_field_type(type, item, count);
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
	html += '<p><label for="fieldvalue">Content</label><span class="newfieldcont"><input type="text" id="fieldvalue" name="newcustomfield[' + count + '][fieldvalue]" /></p></span><p><button class="btn cancel-new-field">Cancel</button></div>';
	$('#newfields').append(html);
}
function custom_field_type(type, item, count)
{
	switch (type){
		case 'text' :
		html = '<input type="text" name="newcustomfield[' + count + '][fieldvalue]" />';
		break;

		case 'textarea' :
		html = '<textarea name="newcustomfield[' + count + '][fieldvalue]"></textarea>';
		break;

		case 'editor' :
		html = '<textarea class="redactor" name="newcustomfield[' + count + '][fieldvalue]"></textarea>';
		break;

		case 'image' :
		html = '<input type="file" name="newcustomfield[' + count + '][fieldvalue]">';
		break;
	}
	$(item).find('.newfieldcont').html(html);
	apply_redactor();
}

/**
* SEO preview update
*/
function seo_characters_remaining(count)
{
	var remaining = 160 - count;
	var info = $('#description_count');

	$('#description_count span').text(remaining);
	if ( remaining < 0 ){
		var over = 'true';
		truncate_seo_description(over);
		$(info).addClass('alert-danger');
	} else {
		truncate_seo_description();
		$(info).removeClass('alert-danger');
	}
}

function truncate_seo_description(over)
{
	var text = $('#seo_description').val();
	truncated = text.substring(0, 160);
	if (over === 'true'){ truncated = truncated + '...'; }
	$('.seo-description').text(truncated);
}

$('#seo_description').on('keyup', function(){
	var count = $(this).val().length;
	seo_characters_remaining(count);
});

$('#seo_title').on('keyup', function(){
	var title = $(this).val();
	$('.seo-title').text(title);
});


/**
* Update the slug based on input
*/
function update_slug()
{
	var slug = $('#slug').val();
	$('.slug em').text(slug);
	$('.slug-seo').text(slug);
}

/**
* Page Slug Switch Edit
*/
$('#slug').on('keyup', function(){
	update_slug();
});
$('.slug p').on('click', function(){
	$('.slug').find('em').hide();
	$('.slug').find('.hidden').show();
});
$('.slug-ok').on('click', function(e){
	$('.slug').find('.hidden').hide();
	$('.slug em').show();
	e.preventDefault();
});

function apply_redactor()
{
	$('.redactor').redactor({
		imageUpload : '{{URL::route("editor_upload")}}',
		imageUploadCallback: function(image, json){
			console.log(json);
		},
		imageUploadErrorCallback: function(json){
			console.log(json.error);
		}
	});
}

$(document).ready(function(){
	var desc_count = $('#seo_description').val().length;
	seo_characters_remaining(desc_count);
	update_slug();
	apply_redactor();	
});
</script>
@stop