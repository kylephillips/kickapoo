@extends('admin.partials.admin-master')
@section('content')

<div class="container small">

	<h1>{{$flavor->title}} <span class="pull-right"><a href="{{URL::route('edit_products')}}">Back to Flavors</a></span></h1>
	

	<div class="well">

		@if(Session::has('success'))
		<div class="alert alert-success">{{Session::get('success')}}</div>
		@endif

		<div class="alert alert-success remove-success" style="display:none;">User successfully removed.</div>
		{{Form::open()}}
		<p>
			{{Form::label('flavor_title', 'Flavor Name')}}
			{{Form::text('flavor_title', $flavor->title)}}
		</p>
		<p>
			{{Form::label('flavor_content', 'Flavor Description')}}
			{{Form::textarea('flavor_content', $flavor->content, ['class'=>'redactor'])}}
		</p>
		<p>
			TODO: image field
		</p>
		<hr>
		<h2>Products</h2>
		<div class="products">
		<?php $i = 1; ?>
		@foreach($flavor->products as $product)
			<div class="flavor_{{$i}} flavor">
				<h4>{{$product->size->title}}</h4>
				<section>
					<p class="size">
						{{Form::label('size[' . $i . ']', 'Size')}}
						{{Form::select('size[' . $i . ']', $sizes, $product->size->id, ['class'=>'size'])}}
						<a href="#" class="btn btn-mini">+ Size</a>
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
						<a href="#" class="btn btn-danger">Delete Product</a>
					</p>
				</section>
			</div>
		<?php $i++; ?>
		@endforeach
		</div><!-- .products -->

		<a href="#" class="btn btn-primary add-product">Add a Product</a>
		{{Form::close()}}

	</div><!-- .well -->
</div><!-- .container -->

@stop
@section('footercontent')
<script src="{{URL::asset('assets/js/redactor.min.js')}}"></script>
<script>
function add_product_field()
{
	var flavor_count = $('.flavor').length;
	var count = flavor_count + 1;
	var select = '{{Form::select('size[]', $sizes, null, ['class'=>'size'])}}';

	var html = '<div class="flavor_' + count + ' flavor"><h4>New Product</h4><section><p><label>Size</label>' + select + '</p>';
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


function update_size_title()
{

}
$(document).on('change', '.size', function(){
	var size = $("option:selected", this).text();
	$(this).parents('.flavor').find('h4').text(size);
});

$(document).on('click', '.flavor h4', function(){
	$(this).parent('.flavor').children('section').slideToggle();
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