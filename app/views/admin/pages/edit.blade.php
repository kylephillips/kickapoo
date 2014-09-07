@extends('admin.partials.admin-master')
@section('content')


<div class="container small">

	<h1>Edit {{$page['title']}} 
		@if( count($page['translation_of']) > 0 )
		<?php
		$link = LaravelLocalization::getLocalizedURL($page['language'], URL::route('page', ['page'=>$page['slug']]));
		?>
		<a href="{{$link}}" class="btn pull-right">View Page</a>
		@else
		<a href="{{URL::route('page', ['page'=>$page['slug']])}}" class="btn pull-right">View Page</a>
		@endif
	</h1>

	<div class="well">

		@if(Session::has('errors'))
		<div class="alert alert-danger">Ooops! Looks like there were some errors. That's not Joyful!</div>
		@endif

		@if(Session::has('success'))
		<div class="alert alert-success">{{Session::get('success')}}</div>
		@endif

		{{Form::open(['url'=>URL::route('update_page', ['id'=>$page['id']]), 'files'=>true])}}
		
		<h3>
			{{$page['title']}}
			@if ( count($page['translation_of']) > 0 )
			 (Translation of <a href="{{URL::route('edit_page', ['slug'=>$page['translation_of'][0]->slug])}}">{{$page['translation_of'][0]->title}}</a> Page)
			@endif
		</h3>

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

			@if ( count($page['translation_of']) == 1 )
			<p class="half">
			@else
			<p class="third">
			@endif			
				{{Form::label('status', 'Status')}}
				{{Form::select('status', ['publish'=>'Published', 'draft'=>'Draft'], $page['status'])}}
			</p>

			@if ( count($page['translation_of']) == 1 )
			<p class="half right">
			@else
			<p class="third">
			@endif
				{{Form::label('template', 'Page Template')}}
				{{Form::select('template', $templates, $page['template'])}}
			</p>

			@if ( count($page['translation_of']) == 0 )
			<p class="third last">
				<label>
					Translations 
					@if( count($translations) < count(LaravelLocalization::getSupportedLocales()) )
						(<a href="#translation-modal" data-toggle="modal" class="new-translation">New</a>)
					@endif
				</label>
				@if ( count($translations) > 1 )
					<select id="translations">
						<option>Select to Edit</option>
						@foreach($translations as $key => $translation)
						@if($key !== $page['language'])
							<option value="{{URL::route('edit_page', ['slug'=>$translation['slug']])}}">
								{{$translation['name']}}
							</option>
						@endif
						@endforeach
					</select>
				@else
					No translations yet.
				@endif
			</p>
			@endif
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


@if ( count($page['translation_of']) == 0 )
<!-- Translation modal -->
<div class="modal fade" id="translation-modal">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close btn btn-mini" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Available Translations</h4>
			</div>
			<div class="modal-body">
				<div class="alert alert-info">Select an available language to add a new translation. To add a new language, contact the system administrator at Object 9.</div>
				
				@foreach( LaravelLocalization::getSupportedLocales() as $code => $properties )
					@if ( count(array_only($translations, [$code])) == 0 )
					<p><a href="{{URL::route('add_translation', ['parent_page'=>$page['id'], 'language'=>$code, 'language_name'=>$properties['name']])}}">{{$properties['name']}}</a></p>
					@endif
				@endforeach

			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div><!-- /.modal -->
@endif

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

/**
* Translation Select
*/
$('#translations').on('change', function(){
	var href = $(this).val();
	if ( href !== '' ){
		window.location = href;
	}
});

$(document).ready(function(){
	var desc_count = $('#seo_description').val().length;
	seo_characters_remaining(desc_count);
	update_slug();
	apply_redactor();	
});
</script>
@stop