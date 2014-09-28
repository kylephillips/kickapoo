@extends('admin.partials.admin-master')
@section('content')

<section class="page-head margin">
	<div class="container">
		@if( count($flavor->translation_of) > 0 )
		<h1>
			<i class="icon-admin-bubbles"></i> 
			Edit 
			@foreach($translations as $key => $translation)
				@if($key !== $flavor->language)
				{{$translation['name']}} translation of
				@endif
			@endforeach
			{{$flavor->translation_of[0]->title}} 
			<span class="pull-right"><a href="{{URL::route('edit_products')}}">Back to Products</a></span>
		</h1>
		@else
		<h1><i class="icon-admin-pencil"></i> Edit {{$flavor->title}} <span class="pull-right"><a href="{{URL::route('edit_products')}}">Back to Products</a></span></h1>
		@endif
	</div>
</section>

<div class="container">

	<div class="flavor-form">

		@if(Session::has('success'))
			<div class="alert alert-success">{{Session::get('success')}}</div>
		@endif

		{{Form::open(['url'=>URL::route('update_flavor', ['id'=>$flavor->id]), 'files'=>true])}}
		<div class="flavor-fields">
			<div class="image">
				@if( $flavor->upload ) 
					<img src="{{$flavor->upload->folder}}{{$flavor->upload->file}}" alt="{{$flavor->title}}" />
				@else
					<img src="{{URL::asset('assets/images/product-fpo.png')}}" alt="{{$flavor->title}}" />
				@endif
			</div>
			<div class="fields">
				@if ( count($flavor->translation_of) > 0 )
				<p>
					<strong>Translation of <a href="{{URL::route('edit_flavor', ['id'=>$flavor->translation_of[0]->id])}}">{{$flavor->translation_of[0]->title}}</a></strong>
					{{Form::hidden('language', $flavor->language)}}
				</p>
				@endif
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
					{{Form::label('css_class', 'CSS Class (for display)')}}
					{{Form::text('css_class', $flavor->css_class)}}
				</p>
				<p>
					{{Form::label('status', 'Publish Settings')}}
					{{Form::select('status', ['publish'=>'Published','draft'=>'Draft'], $flavor->status)}}
				</p>
				<p>
					{{Form::label('flavor_image', 'Image (365px &times; 690px)')}}
					@if( $flavor->upload ) 
						<div>
							<?php 
							$folder = $flavor->upload->folder;
							$folder = substr($folder, 16);
							$folder = rtrim($folder, '/');
							?>
							<a href="#" class="btn btn-success open-media-library" data-folder="{{$folder}}" data-field="flavor_image" style="display:none;"><i class="icon-admin-image"></i> Add from Media Library</a>
							<input type="hidden" id="flavor_image" name="flavor_image" value="{{$flavor->upload->id}}">
							<div class="image-preview">
								<div class="image-thumb">
									<button class="remove-thumb">&times;</button>
									<img src="{{$flavor->upload->folder}}/_thumbs/{{$flavor->upload->file}}" />
								</div>
								<p class="image-name">{{$flavor->upload->title}}</p>
							</div>
						</div>
					@else
						<div>
							<a href="#" class="btn btn-success open-media-library" data-folder="product_images" data-field="flavor_image"><i class="icon-admin-image"></i> Add from Media Library</a>
							<input type="hidden" id="flavor_image" name="flavor_image" value="">
						</div>
					@endif
				</p>
				@if ( count($flavor->translation_of) == 0 )
				<hr>
				<p>
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
							@if($key !== $flavor->language)
								<option value="{{URL::route('edit_flavor', ['id'=>$translation['id']])}}">
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
			</div><!-- .fields -->
		</div><!-- .flavor-fields -->

		@if($flavor->products)
			<div class="alert alert-info">Click a row to edit the product, or click and drag the number to reorder products.</div>
		@endif

		<ul class="products">
		<?php $i = 1; ?>
		@foreach($flavor->products as $product)
			<li class="flavor_{{$i}} flavor" id="{{$product->id}}">
				<h4><span class="sort-handle">{{$i}}</span> {{$product->size->title}}<i class="icon-admin-caret-down"></i></h4>
				<section>
					<div class="image">
						@if($product->upload)
							<img src="{{$product->upload->folder}}/{{$product->upload->file}}" alt="{{$flavor->title}}" />
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
							
						<div>
							{{Form::label('product[' . $i . '][image]', 'Image')}}
							@if($product->upload)
								<div>
									<?php 
									$folder = $product->upload->folder;
									$folder = substr($folder, 16);
									$folder = rtrim($folder, '/');
									?>
									<a href="#" class="btn btn-success open-media-library" data-folder="{{$folder}}" data-field="product_image_{{$i}}" style="display:none;"><i class="icon-admin-image"></i> Add from Media Library</a>
									<input type="hidden" id="product_image_{{$i}}" name="product[{{$i}}][image]" value="{{$product->upload->id}}">
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
									<a href="#" class="btn btn-success open-media-library" data-folder="product_images" data-field="product_image_{{$i}}"><i class="icon-admin-image"></i> Add from Media Library</a>
									<input type="hidden" id="product_image_{{$i}}" name="product[{{$i}}][image]" value="">
								</div>
							@endif
						</div><!-- Product Image -->
						
						<p>&nbsp;</p>

						<div>
							{{Form::label('product[' . $i . '][nutrition_label]', 'Nutrition Label')}}
							@if($product->nutrition_upload)
								<div>
									<?php 
									$folder = $product->nutrition_upload->folder;
									$folder = substr($folder, 16);
									$folder = rtrim($folder, '/');
									?>
									<a href="#" class="btn btn-success open-media-library" data-folder="{{$folder}}" data-field="product_nutrition_{{$i}}" style="display:none;"><i class="icon-admin-image"></i> Add from Media Library</a>
									<input type="hidden" id="product_nutrition_{{$i}}" name="product[{{$i}}][nutrition_label]" value="{{$product->nutrition_upload->id}}">
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
									<a href="#" class="btn btn-success open-media-library" data-folder="product_images" data-field="product_nutrition_{{$i}}"><i class="icon-admin-image"></i> Add from Media Library</a>
									<input type="hidden" id="product_nutrition_{{$i}}" name="product[{{$i}}][nutrition_label]" value="">
								</div>
							@endif
						</div><!-- nutrition label -->

						<p>
							{{Form::hidden('product[' . $i . '][product_id]', $product->id)}}
						</p>

						<div class="delete-well">
							<a href="#" class="btn btn-danger delete-product" data-id="{{$product->id}}"><i class="icon-admin-remove"></i> Delete Product</a>
						</div>

					</div><!-- .product-fields -->
				</section>
			</li><!-- .field -->
		<?php $i++; ?>
		@endforeach
		</ul><!-- .products -->

		<a href="#" class="btn add-product">+ Add a Product Type</a>

		<div class="flavor-save">
			{{Form::submit('Save Changes', ['class'=>'btn btn-success'])}}
		</div>

		{{Form::close()}}

	</div><!-- .flavor-form -->
</div><!-- .container -->


@if ( count($flavor->translation_of) == 0 )
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
					<p><a href="{{URL::route('add_flavor_translation', ['parent_flavor'=>$flavor->id, 'language'=>$code, 'language_name'=>$properties['name']])}}">{{$properties['name']}}</a></p>
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
<script src="{{URL::asset('assets/js/redactor.min.js')}}"></script>
<script>
/**
* Sortable ordering
*/
$(document).ready(function(){
	$('.products').sortable({
		handle: '.sort-handle',
		stop : function(event, ui){
			var order = $(this).sortable('toArray');
			var url = "{{URL::route('product_order')}}?order=" + order;
			change_sort_numbers();
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
* Change the numbers after sorting
*/
function change_sort_numbers()
{
	var numbers = $('.sort-handle');
	$.each(numbers, function(index, value){
		$(this).text(index + 1);
	});
}

/**
* Add a new product type
*/
function add_product_field()
{
	var count = $('.flavor').length + 1;
	var options = '<?php foreach ($sizes as $id=>$size){	echo '<option value="' . $id . '">' . $size . '</option>'; } ?>';

	var html = '<div class="flavor_' + count + ' flavor new-flavor"><h4><span class="sort-handle">' + count + '</span> New Product Type</h4><section><p class="size"><select name="new_product[' + count + '][size]">' + options + '</select><a href="{{URL::route('admin.size.index')}}" class="btn btn-mini">Edit Types</a></p>';
	html += '<p><label>Description</label><textarea name="new_product[' + count + '][description]" class="redactor"></textarea></p>';
	html += '<p><label>Ingredients</label><textarea name="new_product[' + count + '][ingredients]"></textarea></p>';
	
	html += '<div><label>Image</label><div><a href="#" class="btn btn-success open-media-library" data-folder="product_images" data-field="product_image_' + count + '"><i class="icon-admin-image"></i> Add from Media Library</a><input type="hidden" id="product_image_' + count + '" name="new_product[' + count + '][image]"></div></div><p>&nbsp;</p>';
	
	html += '<div><label>Nutrition Label</label><div><a href="#" class="btn btn-success open-media-library" data-folder="product_images" data-field="product_nutrition_' + count + '"><i class="icon-admin-image"></i> Add from Media Library</a><input type="hidden" id="product_nutrition_' + count + '" name="new_product[' + count + '][nutrition_label]"></div></div>';

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
		$(this).find('i').removeClass('icon-admin-caret-up').addClass('icon-admin-caret-down');
	} else {
		$(section).slideDown();
		$(this).find('i').removeClass('icon-admin-caret-down').addClass('icon-admin-caret-up');
	}
});


$(document).ready(function(){
	apply_redactor('.redactor');
});

/**
* Translation Select
*/
$('#translations').on('change', function(){
	var href = $(this).val();
	if ( href !== '' ){
		window.location = href;
	}
});
</script>
@stop