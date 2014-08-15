@extends('admin.partials.admin-master')
@section('content')

<div class="container small">

	<h1>Edit {{$flavor->title}} <span class="pull-right"><a href="{{URL::route('edit_products')}}">Back to Flavors</a></span></h1>

	<div class="well flavor-form">

		@if(Session::has('success'))
			<div class="alert alert-success">{{Session::get('success')}}</div>
		@endif

		{{Form::open(['url'=>URL::route('update_flavor', ['id'=>$flavor->id])])}}
		<div class="flavor-fields">
			@if($flavor->image)
				<img src="{{URL::asset('assets/uploads/product_images')}}/{{$flavor->image}}" alt="{{$flavor->title}}" />
			@else
				<img src="{{URL::asset('assets/images/product-fpo.png')}}" alt="{{$flavor->title}}" />
			@endif
			<div class="fields">
				<p>
					{{Form::label('flavor_title', 'Flavor Name')}}
					{{Form::text('flavor_title', $flavor->title)}}
				</p>
				<p>
					{{Form::label('flavor_content', 'Flavor Description')}}
					{{Form::textarea('flavor_content', $flavor->content, ['class'=>'redactor'])}}
				</p>
				<p>
					{{Form::label('flavor_image', 'Image (365px &times; 690px)')}}
					{{Form::file('flavor_image')}}
				</p>
			</div>
		</div>

		<div class="products">
		<?php $i = 1; ?>
		@foreach($flavor->products as $product)
			<div class="flavor_{{$i}} flavor">
				<h4>{{$product->size->title}}<i class="icon-caret-down"></i></h4>
				<section>
					@if($product->image)
						<img src="{{URL::asset('assets/uploads/product_images')}}/{{$flavor->image}}" alt="{{$flavor->title}}" />
					@else
						<img src="{{URL::asset('assets/images/product-fpo.png')}}" alt="{{$flavor->title}}" />
					@endif
					<div class="product-fields">
						<p class="size">
							{{Form::select('size[' . $i . ']', $sizes, $product->size->id, ['class'=>'size'])}}
							<a href="{{URL::route('admin.size.index')}}" class="btn btn-mini">Edit Types</a>
						</p>
						<p>
							{{Form::label('description[' . $i . ']', 'Description')}}
							{{Form::textarea('description[' . $i . ']', $product->content, ['class'=>'redactor'])}}
						</p>
						<p>
							{{Form::label('ingredients[' . $i . ']', 'Ingredients')}}
							{{Form::textarea('ingredients[' . $i . ']', $product->ingredients)}}
						</p>
						<p>
							{{Form::label('image[' . $i . ']', 'Image')}}
							{{Form::file('image[' . $i . ']')}}
						</p>
						<p>
							<a href="#" class="btn btn-danger"><i class="icon-remove"></i> Delete</a>
						</p>
					</div>
				</section>
			</div>
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
* Add a new product
*/
function add_product_field()
{
	var flavor_count = $('.flavor').length;
	var count = flavor_count + 1;
	var select = '{{Form::select('size[]', $sizes, null, ['class'=>'size'])}}';

	var html = '<div class="flavor_' + count + ' flavor"><h4>New Product Type</h4><section><p>' + select + '</p>';
	html += '<p><label>Description</label><textarea name="description[]" class="redactor"></textarea></p>';
	html += '<p><label>Ingredients</label><textarea name="ingredients[]"></textarea></p></section></div>';

	$('.products').append(html);
	$('.flavor:last-child section').show();
	apply_redactor();
}

$('.add-product').on('click', function(e){
	e.preventDefault();
	add_product_field();
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