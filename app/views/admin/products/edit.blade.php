@extends('admin.partials.admin-master')
@section('content')

<div class="container small">

	<h1>Edit {{$flavor->title}} <span class="pull-right"><a href="{{URL::route('edit_products')}}">Back to Flavors</a></span></h1>

	<div class="well flavor-form">

		@if(Session::has('success'))
			<div class="alert alert-success">{{Session::get('success')}}</div>
		@endif

		{{Form::open(['url'=>URL::route('update_flavor', ['id'=>$flavor->id]), 'files'=>true])}}
		<div class="flavor-fields">
			<div class="image">
				@if($flavor->image)
					<img src="{{URL::asset('assets/uploads/product_images')}}/{{$flavor->image}}" alt="{{$flavor->title}}" />
				@else
					<img src="{{URL::asset('assets/images/product-fpo.png')}}" alt="{{$flavor->title}}" />
				@endif
			</div>
			<div class="fields">
				<p>
					{{$errors->first('flavor_title', '<span class="text-danger"><strong>:message</strong></span><br>')}}
					{{Form::label('flavor_title', 'Flavor Name')}}
					{{Form::text('flavor_title', $flavor->title)}}
				</p>
				<p>
					{{Form::label('flavor_content', 'Flavor Description')}}
					{{Form::textarea('flavor_content', $flavor->content, ['class'=>'redactor'])}}
				</p>
				<p>
					{{Form::label('flavor_image', 'Image (365px &times; 690px)')}}
					@if($flavor->image)
						<div class="image-thumb">
							<button class="remove-thumb">&times;</button>
							<img src="{{URL::asset('assets/uploads/product_images/_thumbs')}}/{{$flavor->image}}">
						</div>
						<div class="image-file" style="display:none;">
							{{Form::file('flavor_image')}}
						</div>
					@else
						{{Form::file('flavor_image')}}
					@endif
				</p>
			</div><!-- .fields -->
		</div><!-- .flavor-fields -->

		<div class="products">
		<?php $i = 1; ?>
		@foreach($flavor->products as $product)
			<div class="flavor_{{$i}} flavor">
				<h4>{{$product->size->title}}<i class="icon-caret-down"></i></h4>
				<section>
					<div class="image">
						@if($product->image)
							<img src="{{URL::asset('assets/uploads/product_images')}}/{{$flavor->image}}" alt="{{$flavor->title}}" />
						@else
							<img src="{{URL::asset('assets/images/product-fpo.png')}}" alt="{{$flavor->title}}" />
						@endif
					</div>
					<div class="product-fields">
						<p class="size">
							{{Form::select('product[' . $i . '][size_id]', $sizes, $product->size->id, ['class'=>'size'])}}
							<a href="{{URL::route('admin.size.index')}}" class="btn btn-mini">Edit Types</a>
						</p>
						<p>
							{{Form::label('product[' . $i . '][description]', 'Description')}}
							{{Form::textarea('product[' . $i . '][description]', $product->content, ['class'=>'redactor'])}}
						</p>
						<p>
							{{Form::label('product[' . $i . '][ingredients]', 'Ingredients')}}
							{{Form::textarea('product[' . $i . '][ingredients]', $product->ingredients)}}
						</p>
						<div class="half">
							{{Form::label('product[' . $i . '][image]', 'Image')}}
							@if($product->image)
								<div class="image-thumb">
									<button class="remove-thumb">&times;</button>
									<img src="{{URL::asset('assets/uploads/product_images/_thumbs')}}/{{$product->image}}">
								</div>
								<div class="image-file" style="display:none;">
									{{Form::file('product[' . $i . '][image]')}}
								</div>
							@else
								{{Form::file('product[' . $i . '][image]')}}
							@endif
						</div>
						<div class="half right">
							{{Form::label('product[' . $i . '][nutrition_label]', 'Nutrition Label')}}
							@if($product->nutrition_label)
								<div class="image-thumb">
									<button class="remove-thumb">&times;</button>
									<img src="{{URL::asset('assets/uploads/product_images/_thumbs')}}/{{$product->nutrition_label}}">
								</div>
								<div class="image-file" style="display:none;">
									{{Form::file('product[' . $i . '][nutrition_label]')}}
								</div>
							@else
								{{Form::file('product[' . $i . '][nutrition_label]')}}
							@endif
						</div>
						<p>
							{{Form::hidden('product[' . $i . '][product_id]', $product->id)}}
							<a href="#" class="btn btn-danger delete-product" data-id="{{$product->id}}"><i class="icon-remove"></i> Delete Product</a>
						</p>
					</div><!-- .product-fields -->
				</section>
			</div><!-- .field -->
		<?php $i++; ?>
		@endforeach
		</div><!-- .products -->

		<a href="#" class="btn add-product">+ Add a Product Type</a>

		<div class="flavor-save">
			{{Form::submit('Save Changes', ['class'=>'btn btn-success'])}}
		</div>

		{{Form::close()}}

	</div><!-- .well -->
</div><!-- .container -->

@stop
@section('footercontent')
<script src="{{URL::asset('assets/js/redactor.min.js')}}"></script>
<script>
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
	html += '<p><label>Image</label><input type="file" name="new_product[' + count + '][image]"></p>';
	html += '<p><label>nutrition Label</label><input type="file" name="new_product[' + count + '][nutitional_label]"></p>';
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
* Delete an existing product type
*/
function delete_product(id, item)
{
	$.ajax({
		url: '{{URL::route("delete_product")}}',
		type: 'get',
		data: {
			id: id
		},
		success: function(data){
			$(item).fadeOut('slow', function(){
				$(item).remove();
			});
		}
	});
}
$('.delete-product').on('click', function(e){
	e.preventDefault();
	if ( confirm('Are you sure you want to delete this product?') ){
		var id = $(this).data('id');
		var item = $(this).parents('.flavor');
		delete_product(id, item);
	}
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

/**
* Remove an Image Thumbnail
*/
$('.remove-thumb').on('click', function(e){
	e.preventDefault();
	var thumb = $(this).parents('.image-thumb');
	var input = $(thumb).siblings('.image-file');
	$(thumb).hide();
	$(input).show();
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