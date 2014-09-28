@extends('admin.partials.admin-master')
@section('content')

<section class="page-head">
	<div class="container">
		<h1><i class="icon-admin-bubbles"></i> Add {{$language_name}} Translation of <a href="{{URL::route('edit_page', ['slug'=>$parent_page->slug])}}">{{$parent_page->title}}</a></h1>
	</div>
</section>

<div class="container">

	@if(Session::has('errors'))
	<div class="alert alert-danger">Ooops! Looks like there were some errors. That's not Joyful!</div>
	@endif

	@if(Session::has('success'))
	<div class="alert alert-success">{{Session::get('success')}}</div>
	@endif

	{{Form::open(['url'=>URL::route('create_page'), 'files'=>true])}}
	
	<p>
		{{$errors->first('title', '<span class="text-danger"><strong>:message</strong></span><br>')}}
		{{Form::label('title', 'Page Title')}}
		{{Form::text('title', $parent_page->title, ['class'=>'form-control'])}}
	</p>

	<p>
		<div class="slug">
			{{$errors->first('slug', '<span class="text-danger"><strong>:message</strong></span><br>')}}
			{{Form::label('slug', 'Page Link:')}}
			<p>
				{{URL::route('home')}}/<?php if ( isset($language) ) echo $language . '/'; ?>
				<em>{{$parent_page->slug}}-{{$language}}</em>
			</p>
			{{Form::text('slug', $parent_page->slug . '-' . $language, ['class'=>'form-control hidden'])}}
			<button class="slug-ok btn hidden">Ok</button>
		</div>
	</p>

	<div class="well">
		<h4>General Settings</h4>
		<div class="well-interior">
			<p class="half">
				{{Form::label('status', 'Status')}}
				{{Form::select('status', ['publish'=>'Published', 'draft'=>'Draft'], 'draft')}}
			</p>

			<p class="half right">
				{{Form::label('template', 'Page Template')}}
				{{Form::select('template', $templates, $parent_page['template'])}}
			</p>
		</div>
	</div>

	<p>
		{{$errors->first('content', '<span class="text-danger"><strong>:message</strong></span><br>')}}
		{{Form::label('content', 'Content')}}
		{{Form::textarea('content', $parent_page->content, ['class'=>'redactor'])}}
	</p>

	<h3>Custom Fields</h3>

	@if(count($parent_page->customfields) > 0 )
	<ul class="customfields-existing">
		<?php $c = 0; ?>
		@foreach($parent_page->customfields as $field)
		<li class="customfield-existing">
			<h4>{{$field->name}} <i class="icon-admin-caret-down"></i></h4>
			<section>
				
				<p>
					<label>Name</label>
					{{Form::text('newcustomfield[' . $c . '][fieldname]', $field->name)}}
				</p>
				
				@if($field->field_type == 'text')
					<p>
						<label>Content</label>
						{{Form::text('newcustomfield[' . $c . '][fieldvalue]', $field->value)}}
					</p>

				@elseif($field->field_type == 'textarea')
					<p>
						<label>Content</label>
						{{Form::textarea('newcustomfield[' . $c . '][fieldvalue]', $field->value)}}
					</p>

				@elseif($field->field_type == 'editor')
					<p>
						<label>Content</label>
						{{Form::textarea('newcustomfield[' . $c . '][fieldvalue]', $field->value, ['class'=>'redactor'])}}
					</p>

				@else
					<div>
						<?php 
						$folder = $field->image->folder;
						$folder = substr($folder, 16);
						$folder = rtrim($folder, '/');
						?>
						<a href="#" class="btn btn-success open-media-library" data-folder="{{$folder}}" data-field="customfield_image_{{$c}}" style="display:none;"><i class="icon-admin-image"></i> Add from Media Library</a>
						<input type="hidden" id="customfield_image_{{$c}}" name="newcustomfield[{{$c}}][fieldvalue]" value="{{$field->image->id}}">
						<div class="image-preview">
							<div class="image-thumb">
								<button class="remove-thumb">&times;</button>
								<img src="{{$field->image->folder}}/_thumbs/{{$field->image->file}}" />
							</div>
							<p class="image-name">{{$field->image->title}}</p>
						</div>
					</div>
				@endif
				{{Form::hidden('newcustomfield[' . $c . '][fieldtype]', $field->field_type)}}
				<a href="#" class="btn btn-danger delete-field">Delete Field</a>
			</section>
		</li>
		<?php $c++; ?>
		@endforeach
	</ul>
	@endif


	<div id="newfields"></div>
	<a href="#" class="btn btn-success add-custom">Add Custom Field</a>
	<p>&nbsp;</p>

	<div class="well">
		<h4>SEO Settings</h4>
		<div class="well-interior">
			<div class="seo-preview">
				<h4>Kickapoo Joy Juice - <span class="seo-title"></span></h4>
				<p>
					<em>www.kickapoo.com/<span class="slug-seo"></span></em>
					<span class="seo-description"></span>
				</p>
			</div>
			<p>
				{{Form::label('seo_title', 'SEO Title')}}
				{{Form::text('seo_title', null, ['id'=>'seo_title'])}}
			</p>
			<p>
				{{Form::label('seo_description', 'SEO Description')}}
				{{Form::textarea('seo_description', null, ['id'=>'seo_description'])}}
				<div id="description_count" class="alert alert-info"><span><strong>150</strong></span> Characters Remaining</div>
			</p>
		</div>
	</div>

	@if ( isset($language) )
	{{Form::hidden('language', $language)}}
	{{Form::hidden('parent_page', $parent_page->id)}}
	@endif

	{{Form::submit('Save Page', ['class'=>'btn btn-block btn-primary'])}}
	{{Form::close()}}

</div><!-- .container -->
@stop

@section('footercontent')
<script>
/**
* Update the slug & title in various locations
*/
$('#title').on('keyup', function(){
	var title = $(this).val();
	$('.seo-title').text(title);
	$('#seo_title').val(title);
	$('#slug').val(convert_to_slug(title));
	$('.slug em').text(convert_to_slug(title));
	$('.slug-seo').text(convert_to_slug(title));
});
function convert_to_slug(text)
{
	return text.toLowerCase().replace(/ /g,'-').replace(/[^\w-]+/g,'');
}


/**
* Add new custom fields
*/
$('.add-custom').on('click', function(e){
	e.preventDefault();
	add_custom_field();
});

function add_custom_field()
{
	var count = $('.newfield').length;
	var html = '<div class="newfield"><span class="field_count" style="display:none;">' + count + '</span><p class="half"><label>Field Name</label><input type="text" name="newcustomfield[' + count + '][fieldname]" ></p>';
	html += '<p class="half right"><label for="fieldtype">Type of Field</label><select class="fieldtype" name="newcustomfield[' + count + '][fieldtype]"><option value="text">Text</option><option value="textarea">Textarea</option><option value="editor">Editor</option><option value="image">Image</option></select></p>';
	html += '<p><label>Content</label><span class="newfieldcont"><input type="text" class="fieldvalue" name="newcustomfield[' + count + '][fieldvalue]" /></p></span><p><button class="btn cancel-new-field">Cancel</button></div>';
	html += '<input type="hidden" name="has-custom" value="true">';
	$('#newfields').append(html);
}


$(document).ready(function(){
	var desc_count = $('#seo_description').val().length;
	seo_characters_remaining(desc_count);
	apply_redactor('.redactor');
});
</script>
@stop