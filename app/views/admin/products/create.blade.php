@extends('admin.partials.admin-master')
@section('content')

<div class="container small">

	<h1>Add a Product <span class="pull-right"><a href="{{URL::route('edit_products')}}">Back to Products</a></span></h1>

	<div class="well flavor-form">

		@if(Session::has('success'))
			<div class="alert alert-success">{{Session::get('success')}}</div>
		@endif

		{{Form::open(['url'=>URL::route('store_flavor'), 'files'=>true])}}
		<div class="flavor-fields">
			<p>
				{{$errors->first('title', '<span class="text-danger"><strong>:message</strong></span><br>')}}
				{{Form::label('flavor_title', 'Flavor Name')}}
				{{Form::text('flavor_title')}}
			</p>
			<p>
				{{Form::label('content', 'Flavor Description')}}
				{{Form::textarea('content', null, ['class'=>'redactor'])}}
			</p>
			<p>
				{{Form::label('css_class', 'CSS Class (for display)')}}
				{{Form::text('css_class')}}
			</p>
			<div>
				<label>Image</label>
				<a href="#" class="btn btn-success open-media-library" data-folder="product_images" data-field="flavor_image"><i class="icon-image"></i> Add from Media Library</a>
				<input type="hidden" id="flavor_image" name="image" value="">
			</div>
		</div><!-- .flavor-fields -->

		<ul class="products">
		</ul><!-- .products -->

		<a href="#" class="btn add-product">+ Add a Product Type</a>

		<div class="flavor-save">
			{{Form::submit('Save', ['class'=>'btn btn-success'])}}
		</div>

		{{Form::close()}}

	</div><!-- .well -->
</div><!-- .container -->

@stop
@section('footercontent')
<script src="{{URL::asset('assets/js/redactor.min.js')}}"></script>
<script>
/**
* Sortable ordering
*/
$(document).ready(function(){
	$('.products').sortable({
		stop : function(event, ui){
			var order = $(this).sortable('toArray');
			var url = "{{URL::route('product_order')}}?order=" + order;
			console.log(order);
			$.ajax({
				type:"GET",
				url: url,
				success:function(data){
					console.log(data);
				}
			});
		}
	});
});


/**
* Add a new product type
*/
function add_product_field()
{
	var flavor_count = $('.flavor').length;
	var count = flavor_count + 1;
	var options = '<?php foreach ($sizes as $id=>$size){	echo '<option value="' . $id . '">' . $size . '</option>'; } ?>';

	var html = '<div class="flavor_' + count + ' flavor new-flavor"><h4>New Product Type</h4><section><p class="size"><select name="new_product[' + count + '][size]">' + options + '</select><a href="{{URL::route('admin.size.index')}}" class="btn btn-mini">Edit Types</a></p>';
	html += '<p><label>Description</label><textarea name="new_product[' + count + '][description]" class="redactor"></textarea></p>';
	html += '<p><label>Ingredients</label><textarea name="new_product[' + count + '][ingredients]"></textarea></p>';
	
	html += '<div><label>Image</label><div><a href="#" class="btn btn-success open-media-library" data-folder="product_images" data-field="product_image_' + count + '"><i class="icon-image"></i> Add from Media Library</a><input type="hidden" id="product_image_' + count + '" name="new_product[' + count + '][image]"></div></div><p>&nbsp;</p>';
	
	html += '<div><label>Nutrition Label</label><div><a href="#" class="btn btn-success open-media-library" data-folder="product_images" data-field="product_nutrition_' + count + '"><i class="icon-image"></i> Add from Media Library</a><input type="hidden" id="product_nutrition_' + count + '" name="new_product[' + count + '][nutrition_label]"></div></div>';
	
	html += '<input type="hidden" name="add_new" value="true">';
	html += '<a href="#" class="btn btn-danger remove-new-product">Cancel</a></section></div>';

	$('.products').append(html);
	$('.flavor:last-child section').show();
	apply_redactor();
}
$('.add-product').on('click', function(e){
	e.preventDefault();
	add_product_field();
});
$(document).on('click', '.remove-new-product', function(e){
	e.preventDefault();
	$(this).parents('.flavor').remove();
	$('.add-product').show();
});


/**
* Update the Product title to chosen select option
*/
$(document).on('change', '.size', function(){
	var size = $("option:selected", this).text();
	$(this).parents('.flavor').find('h4').text(size);
});

// Toggle Individual Products
$(document).on('click', '.flavor h4', function(){
	var section = $(this).parent('.flavor').children('section');
	if ( $(section).is(':visible') ){
		$(section).slideUp();
		$(this).find('i').removeClass('icon-caret-up').addClass('icon-caret-down');
	} else {
		$(section).slideDown();
		$(this).find('i').removeClass('icon-caret-down').addClass('icon-caret-up');
	}
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
	apply_redactor();
});
</script>
@stop