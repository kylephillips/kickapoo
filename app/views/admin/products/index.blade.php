@extends('admin.partials.admin-master')
@section('content')

<section class="page-head margin">
	<div class="container">
		<h1>Products</h1>
	</div>
</section>

<div class="container">

	@if(Session::has('success'))
		<div class="alert alert-success">{{Session::get('success')}}</div>
	@endif

	<div class="alert alert-success remove-success" style="display:none;"></div>

	<ul class="product-list">
		@foreach($flavors as $flavor)
		<li id="{{$flavor->id}}">
			@if($flavor->upload)
				<img src="{{$flavor->upload->folder}}/{{$flavor->upload->file}}" alt="{{$flavor->title}}" class="flavor-image" />
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

</div><!-- .container -->

@stop
@section('footercontent')
<script>

$(document).ready(function(){
	$('.product-list').sortable({
		stop : function(event, ui){
			var order = $(this).sortable('toArray');
			var url = "{{URL::route('flavor_order')}}?order=" + order;
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