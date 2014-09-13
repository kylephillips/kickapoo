@extends('admin.partials.admin-master')
@section('content')

<div class="container small">

	<h1>Product Types <span class="pull-right"><a href="{{URL::route('edit_products')}}"> Back to Products</a></span></h1>

	<div class="well">

		@if(Session::has('success'))
		<div class="alert alert-success">{{Session::get('success')}}</div>
		@endif

		<div class="alert alert-success" style="display:none;"></div>
		<div class="alert alert-success edit-success" style="display:none;"></div>

		<ul class="sizes-table">
			@foreach($sizes as $size)
			<li>
				<strong class="title_{{$size->id}}">{{$size->title}}</strong>
				<div class="buttons">
					<a href="#" class="btn toggle-translations">Translations</a>
					<a href="#" class="btn btn-warning edit-size edit_{{$size->id}}" data-id="{{$size->id}}" data-title="{{$size->title}}">Edit</a>
					<a href="{{$size->id}}" class="btn btn-danger delete-size">Delete</a>
				</div>
				<div class="translations">
					<p>
					@foreach(LaravelLocalization::getSupportedLocales() as $code => $properties)
					@if($code !== 'en')
						<em>{{$properties['name']}}:</em>
						@if ( array_key_exists($code, $translations[$size->id]) )
							{{$translations[$size->id][$code]['title']}} 
							<span id="edit_trans_{{$translations[$size->id][$code]['id']}}">
								(<a href="#" data-id="{{$translations[$size->id][$code]['id']}}" data-language="{{$properties['name']}}" data-code="{{$code}}">edit</a>)
							</span>
						@else
							<span id="add_{{$code}}_{{$size->id}}">
								<a href="#" data-parentname="{{$size->title}}" data-language="{{$properties['name']}}" data-code="{{$code}}" data-parent="{{$size->id}}" class="add-translation">Add</a>
							</span>
						@endif
						<br />
					@endif
					@endforeach
					</p>
				</div>
			</li>
			@endforeach
		</ul>

		@if(Session::has('errors'))
		<div class="add-size-form" style="display:block;">
		@else
		<div class="add-size-form">
		@endif
			{{Form::open(['url'=>URL::route('admin.size.store')])}}
				{{$errors->first('title', '<span class="text-danger"><strong>:message</strong></span><br>')}}
				{{Form::label('title', 'Size Name')}}
				{{Form::text('title')}}
				{{Form::submit('Save Size', ['class'=>'btn'])}}
				<button class="btn add-cancel">Cancel</button>
			{{Form::close()}}
		</div>

		<a href="#" class="btn btn-success add-size">Add New Type</a>

	</div><!-- .well -->
</div><!-- .container -->

<!-- Edit existing type modal form -->
<div class="modal fade" id="edit-size-modal">
	<div class="modal-dialog">
		<div class="modal-content">
			{{Form::open(['url'=>URL::route('update_size'), 'id'=>'edit-form'])}}
			<div class="modal-header">
				<h4 class="modal-title">Edit Type</h4>
			</div>
			<div class="modal-body">

				<div class="alert alert-danger edit-error" style="display:none;"></div>
				
				<input type="hidden" value="" id="edit-id" name="id">
				<p>
					<label>Title</label>
					<input type="text" name="title" id="edit-title" value="" />
				</p>
			</div>
			<div class="modal-footer">
				<button class="btn btn-success" id="edit-button">Save</button>
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
			{{Form::close()}}
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<!-- Add Translation Modal Form -->
<div class="modal fade" id="add-translation-modal">
	<div class="modal-dialog">
		<div class="modal-content">
			{{Form::open(['url'=>URL::route('add_size_translation'), 'id'=>'add-translation-form'])}}
			<div class="modal-header">
				<h4 class="modal-title"></h4>
			</div>
			<div class="modal-body">

				<div id="translation-error" class="alert alert-danger edit-error" style="display:none;"></div>
				
				<input type="hidden" value="" id="parent-id" name="parent">
				<input type="hidden" value="" id="language" name="language">

				<p>
					<label>Title</label>
					<input type="text" name="title" id="add-translation-title" value="" />
				</p>
			</div>
			<div class="modal-footer">
				<button class="btn btn-success" id="add-translation-button">Save</button>
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
			{{Form::close()}}
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->


@stop
@section('footercontent')
<script>
/**
* Translations
*/
$('.toggle-translations').on('click', function(e){
	e.preventDefault();
	var trans = $(this).parents('li').children('.translations');
	$(trans).toggle();
});

/**
* Add a Translation – open modal and populate form
*/
$('.add-translation').on('click', function(e){
	e.preventDefault();
	$('#parent-id').val($(this).data('parent'));
	$('#language').val($(this).data('code'));

	var element = $(this).parent('span');
	var language = $(this).data('language');
	var parent_name = $(this).data('parentname');
	add_translation_modal(language, parent_name);
});

function add_translation_modal(language, parent_name)
{
	$('#add-translation-form').find('h4').text('Add ' + language + ' Translation for ' + parent_name);	
	$('#add-translation-modal').modal('show');
}

/**
* Add a Translation - submit the form
*/
$('#add-translation-button').on('click', function(e){
	e.preventDefault();
	add_size_translation();
});
function add_size_translation()
{
	$('#translation-error').hide();
	var url = $('#add-translation-form').attr('action');
	var data = $('#add-translation-form').serialize();
	$.ajax({
		url: url,
		type: 'POST',
		data: data,
		success: function(data){
			if ( data.status === 'success' ){
				update_translation_text();
			} else {
				$('#translation-error').text(data.message).show();
			}
		}
	});
}
function update_translation_text()
{
	var element = '#add_' + $('#language').val() + '_' + $('#parent-id').val();
	$(element).text($('#add-translation-title').val());
	$('#add-translation-modal').modal('hide');
}

/**
* Edit an existing Size
*/
$('.edit-size').on('click', function(e){
	var id = $(this).data('id');
	var title = $(this).data('title');
	$('.edit-success').hide();
	$('.edit-error').hide();
	$('#edit-id').val(id);
	$('#edit-title').val(title);
	$('#edit-size-modal').modal('show');
	e.preventDefault();
});

$('#edit-button').on('click', function(e){
	e.preventDefault();
	$(this).attr('disabled', 'disabled');
	submit_edit();
});

function submit_edit()
{
	var url = $('#edit-form').attr('action');
	var data = $('#edit-form').serialize();
	console.log(data);

	$.ajax({
		url: url,
		type: 'post',
		data: data,
		success: function(data){
			$('#edit-button').removeAttr('disabled');
			if (data.status === 'error'){
				$('.edit-error').text(data.message).show();
			} else {
				update_title();
				$('.edit-error').hide();
				$('.edit-success').text('Size saved').show();
				$('#edit-size-modal').modal('hide');
			}
		}
	});
}

function update_title()
{
	// Update the title in the size table cell and button data attr
	var title = $('#edit-title').val();
	var titlecell = '.title_' + $('#edit-id').val();
	var editbtn = '.edit_' + $('#edit-id').val();
	$(editbtn).data('title', title);
	$(titlecell).text(title);
}

/**
* Add a new Size
*/
$('.add-size').on('click', function(e){
	e.preventDefault();
	$('.add-size-form').toggle();
});
$('.add-cancel').on('click', function(e){
	e.preventDefault();
	$('.add-size-form input[name="title"]').val('');
	$('.add-size-form').hide();
});

/**
* Delete a Size
*/
$('.delete-size').on('click', function(e){
	e.preventDefault();
	if (confirm('Are you sure you want to delete this type? This will remove all instances of this type from current products.')){
		var row = $(this).parents('li');
		var id = $(this).attr('href');
		delete_size(id, row);
	}
});

function delete_size(id, row)
{
	$.ajax({
		url: "{{URL::route('delete_size')}}",
		type: 'GET',
		data: {
			id: id
		},
		success: function(data){
			if ( data.status === 'success' ){
				$(row).fadeOut('slow', function(){
					$(row).remove();
				});
			} else {
				$('.alert-error').text('There was an error removing the size.').show();
			}
		}
	});
}

</script>
@stop