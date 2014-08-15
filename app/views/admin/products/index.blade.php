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
				</section>
			</li>
			@endforeach
		</ul>

		<a href="{{URL::route('admin.user.create')}}" class="btn btn-large btn-success">+ Add Product</a>

	</div><!-- .well -->
</div><!-- .container -->

@stop
@section('footercontent')
@stop