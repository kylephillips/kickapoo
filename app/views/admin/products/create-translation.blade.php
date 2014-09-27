@extends('admin.partials.admin-master')
@section('content')

<section class="page-head margin">
	<div class="container small">
		<h1>Add a {{$language_name}} Translation of <a href="{{URL::route('edit_flavor', ['id'=>$parent_flavor->id])}}">{{$parent_flavor->title}}</a></h1>
	</div>
</section>

<div class="container small">

	<div class="well flavor-form">

		@if(Session::has('success'))
			<div class="alert alert-success">{{Session::get('success')}}</div>
		@endif

		{{Form::open(['url'=>URL::route('store_flavor'), 'files'=>true])}}
		<div class="flavor-fields">
			<p>
				{{$errors->first('title', '<span class="text-danger"><strong>:message</strong></span><br>')}}
				{{Form::label('flavor_title', 'Flavor Name')}}
				{{Form::text('flavor_title', $parent_flavor->title)}}
			</p>
			<p>
				{{Form::label('content', 'Flavor Description')}}
				{{Form::textarea('content', $parent_flavor->content, ['class'=>'redactor'])}}
			</p>
			<p>
				{{Form::label('css_class', 'CSS Class (for display)')}}
				{{Form::text('css_class', $parent_flavor->css_class)}}
			</p>
			
			<p>
				{{Form::label('flavor_image', 'Image (365px &times; 690px)')}}
				@if( $parent_flavor->upload ) 
					<div>
						<?php 
						$folder = $parent_flavor->upload->folder;
						$folder = substr($folder, 16);
						$folder = rtrim($folder, '/');
						?>
						<a href="#" class="btn btn-success open-media-library" data-folder="{{$folder}}" data-field="flavor_image" style="display:none;"><i class="icon-image"></i> Add from Media Library</a>
						<input type="hidden" id="flavor_image" name="image" value="{{$parent_flavor->upload->id}}">
						<div class="image-preview">
							<div class="image-thumb">
								<button class="remove-thumb">&times;</button>
								<img src="{{$parent_flavor->upload->folder}}/_thumbs/{{$parent_flavor->upload->file}}" />
							</div>
							<p class="image-name">{{$parent_flavor->upload->title}}</p>
						</div>
					</div>
				@else
					<div>
						<a href="#" class="btn btn-success open-media-library" data-folder="product_images" data-field="flavor_image"><i class="icon-image"></i> Add from Media Library</a>
						<input type="hidden" id="flavor_image" name="image" value="">
					</div>
				@endif
			</p>
			
			{{Form::hidden('parent_flavor', $parent_flavor->id)}}
			{{Form::hidden('language', $language)}}
			
		</div><!-- .flavor-fields -->

		<ul class="products">
		<?php $i = 1; ?>
		@foreach($parent_flavor->products as $product)
			<li class="flavor_{{$i}} flavor" id="{{$product->id}}">
				<h4><span class="sort-handle">{{$i}}</span> {{$product->size->title}}<i class="icon-caret-down"></i></h4>
				<section>
					<div class="image">
						@if($product->upload)
							<img src="{{$product->upload->folder}}/{{$product->upload->file}}" alt="{{$parent_flavor->title}}" />
						@else
							<img src="{{URL::asset('assets/images/product-fpo.png')}}" alt="{{$parent_flavor->title}}" />
						@endif
					</div>
					<div class="product-fields">
						<p class="size">
							{{Form::select('new_product[' . $i . '][size]', $sizes, $product->size->id, ['class'=>'size'])}}
							<a href="{{URL::route('admin.size.index')}}" class="btn btn-mini">Edit Types</a>
						</p>
						<p>
							{{Form::label('new_product[' . $i . '][description]', 'Description')}}
							{{Form::textarea('new_product[' . $i . '][description]', $product->content, ['class'=>'redactor'])}}
						</p>
						<p>
							{{Form::label('new_product[' . $i . '][ingredients]', 'Ingredients')}}
							{{Form::textarea('new_product[' . $i . '][ingredients]', $product->ingredients)}}
						</p>
							
						<div>
							{{Form::label('new_product[' . $i . '][image]', 'Image')}}
							@if($product->upload)
								<div>
									<?php 
									$folder = $product->upload->folder;
									$folder = substr($folder, 16);
									$folder = rtrim($folder, '/');
									?>
									<a href="#" class="btn btn-success open-media-library" data-folder="{{$folder}}" data-field="product_image_{{$i}}" style="display:none;"><i class="icon-image"></i> Add from Media Library</a>
									<input type="hidden" id="product_image_{{$i}}" name="new_product[{{$i}}][image]" value="{{$product->upload->id}}">
									<div class="image-preview">
										<div class="image-thumb">
											<button class="remove-thumb">&times;</button>
											<img src="{{$product->upload->folder}}/_thumbs/{{$product->upload->file}}" />
										</div>
										<p class="image-name">{{$product->upload->title}}</p>
									</div>
								</div>
							@else
								<div>
									<a href="#" class="btn btn-success open-media-library" data-folder="product_images" data-field="product_image_{{$i}}"><i class="icon-image"></i> Add from Media Library</a>
									<input type="hidden" id="product_image_{{$i}}" name="new_product[{{$i}}][image]" value="">
								</div>
							@endif
						</div><!-- Product Image -->
						
						<p>&nbsp;</p>

						<div>
							{{Form::label('new_product[' . $i . '][nutrition_label]', 'Nutrition Label')}}
							@if($product->nutrition_upload)
								<div>
									<?php 
									$folder = $product->nutrition_upload->folder;
									$folder = substr($folder, 16);
									$folder = rtrim($folder, '/');
									?>
									<a href="#" class="btn btn-success open-media-library" data-folder="{{$folder}}" data-field="product_nutrition_{{$i}}" style="display:none;"><i class="icon-image"></i> Add from Media Library</a>
									<input type="hidden" id="product_nutrition_{{$i}}" name="new_product[{{$i}}][nutrition_label]" value="{{$product->nutrition_upload->id}}">
									<div class="image-preview">
										<div class="image-thumb">
											<button class="remove-thumb">&times;</button>
											<img src="{{$product->nutrition_upload->folder}}/_thumbs/{{$product->nutrition_upload->file}}" />
										</div>
										<p class="image-name">{{$product->nutrition_upload->title}}</p>
									</div>
								</div>
							@else
								<div>
									<a href="#" class="btn btn-success open-media-library" data-folder="product_images" data-field="product_nutrition_{{$i}}"><i class="icon-image"></i> Add from Media Library</a>
									<input type="hidden" id="product_nutrition_{{$i}}" name="new_product[{{$i}}][nutrition_label]" value="">
								</div>
							@endif
						</div><!-- nutrition label -->

						<p>
							{{Form::hidden('new_product[' . $i . '][product_id]', $product->id)}}
						</p>

						<div class="delete-well">
							<a href="#" class="btn btn-danger delete-product" data-id="{{$product->id}}"><i class="icon-remove"></i> Delete Product</a>
						</div>

					</div><!-- .product-fields -->
				</section>
			</li><!-- .field -->
		<?php $i++; ?>
		@endforeach
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


$(document).ready(function(){
	apply_redactor('.redactor');
});
</script>
@stop