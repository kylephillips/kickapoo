@extends('admin.partials.admin-master')
@section('content')
<?php print_r($errors); ?>
<div class="container small">

	<h1>Add a New Page </h1>

	<div class="well">

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
			{{Form::text('title', null, ['class'=>'form-control'])}}
		</p>

		<p>
			<div class="slug">
				{{$errors->first('slug', '<span class="text-danger"><strong>:message</strong></span><br>')}}
				{{Form::label('slug', 'Page Link:')}}
				<p>
					{{URL::route('home')}}/
					<em></em>
				</p>
				{{Form::text('slug', null, ['class'=>'form-control hidden'])}}
				<button class="slug-ok btn hidden">Ok</button>
			</div>
		</p>

		<div class="well">
			<h4>General Settings</h4>
			<p class="half">
				{{Form::label('status', 'Status')}}
				{{Form::select('status', ['publish'=>'Published', 'draft'=>'Draft'], 'draft')}}
			</p>

			<p class="half right">
				{{Form::label('template', 'Page Template')}}
				{{Form::select('template', $templates, 'default_page')}}
			</p>
		</div>

		<hr>

		<p>
			{{$errors->first('content', '<span class="text-danger"><strong>:message</strong></span><br>')}}
			{{Form::label('content', 'Content')}}
			{{Form::textarea('content', null, ['class'=>'redactor'])}}
		</p>

		<hr>

		<h3>Custom Fields</h3>

		@if(Input::old('newcustomfield'))
			<ul class="customfields-existing">
				<?php $c = 0; ?>
				@foreach(Input::old('newcustomfield') as $field)
				<div class="newfield">
					<span class="field_count" style="display:none;">{{$c}}</span>
					<p class="half">
						@if($field['fieldname'] == '')
							<span class="text-danger"><strong>The Field Name is Required</strong></span>
						@endif
						<label>Field Name</label>
						<input type="text" name="newcustomfield[{{$c}}][fieldname]" value="{{$field['fieldname']}}">
					</p>
					<p class="half right">
						<label for="fieldtype">Type of Field</label>
						<select class="fieldtype" name="newcustomfield[{{$c}}][fieldtype]">
							<option value="text" <?php if ($field['fieldtype'] == 'text') echo 'selected'; ?>>Text</option>
							<option value="textarea" <?php if ($field['fieldtype'] == 'textarea') echo 'selected'; ?>>Textarea</option>
							<option value="editor" <?php if ($field['fieldtype'] == 'editor') echo 'selected'; ?>>Editor</option>
							<option value="image" <?php if ($field['fieldtype'] == 'image') echo 'selected'; ?>>Image</option>
						</select>
					</p>
					<p>
						<label>Content</label>
						<span class="newfieldcont">
							@if($field['fieldtype'] == 'text')
							<input type="text" class="fieldvalue" name="newcustomfield[{{$c}}][fieldvalue]" value="{{$field['fieldvalue']}}" />
							@elseif($field['fieldtype'] == 'textarea')
							<textarea name="newcustomfield[{{$c}}][fieldvalue]">{{$field['fieldvalue']}}</textarea>
							@elseif($field['fieldtype'] == 'editor')
							<textarea name="newcustomfield[{{$c}}][fieldvalue]" class="redactor">{{$field['fieldvalue']}}</textarea>
							@else
							<input type="file" name="newcustomfield[{{$c}}][fieldvalue]" >
							@endif
						</span>
					</p>
					{{Form::hidden("has-custom", 'true')}}
					<p><button class="btn cancel-new-field">Remove Field</button></div>
				<?php $c++; ?>
				@endforeach
			</ul>
		@endif


		<div id="newfields"></div>
		<a href="#" class="btn btn-success add-custom">Add Custom Field</a>

		<hr>

		<div class="well">
			<h4>SEO Settings</h4>
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

		{{Form::submit('Save Page')}}
		{{Form::close()}}
	</div>

</div>
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
	apply_redactor();
});
</script>
@stop