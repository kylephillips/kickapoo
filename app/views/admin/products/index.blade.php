@extends('admin.partials.admin-master')
@section('content')

<div class="container small">

	<h1>Products</h1>	

	<div class="well">

		@if(Session::has('success'))
		<div class="alert alert-success">{{Session::get('success')}}</div>
		@endif

		<div class="alert alert-success remove-success" style="display:none;"></div>

		<ul class="product-list">
			@foreach($flavors as $flavor)
			<li>
				@if($flavor->image)
					<img src="{{URL::asset('assets/uploads/product_images')}}/{{$flavor->image}}" alt="{{$flavor->title}}" class="flavor-image" />
				@else
					<img src="{{URL::asset('assets/images/product-fpo.png')}}" alt="{{$flavor->title}}" class="flavor-image" />
				@endif
				<section>
					<h3>{{$flavor->title}}</h3>
					<p>{{$flavor->content}}</p>
					<p><strong>Product Types:</strong></p>
					<ul>
						@foreach($flavor->products as $product)
							<li>{{$product->size->title}}</li>
						@endforeach
					</ul>
					<a href="{{URL::route('edit_flavor', ['id'=>$flavor->id])}}" class="btn btn-warning">Edit Product</a>
					<a href="{{URL::route('delete_flavor', ['id'=>$flavor->id])}}" class="btn btn-danger delete-product">Delete Product</a>
				</section>
			</li>
			@endforeach
		</ul>

		<a href="{{URL::route('create_flavor')}}" class="btn btn-large btn-success">+ Add Product</a>

	</div><!-- .well -->
</div><!-- .container -->

@stop
@section('footercontent')
<script>
$('.delete-product').on('click', function(e){
	e.preventDefault();
	if ( confirm('Are you sure you want to delete this product?') ) {
		var item = $(this).parents('li');
		var url = $(this).attr('href');

		$.ajax({
			url: url,
			type: 'GET',
			success: function(data){
				console.log(data);
				$(item).fadeOut('slow', function(){
					$(item).remove();
				});
			}
		});
	}
});
</script>
@stop