@extends('partials.master')
@section('content')

	<div class="container">

		@if( $page->get_field('Header Image', $page->id) )
			<img src="{{URL::asset('assets/uploads/page_images')}}/{{$page->get_field('Header Image', $page->id)}}" class="header-image" alt="Swig Some Swag!" />
		@else
			<h1>{{$page['title']}}</h1>
		@endif

		{{$page['content']}}

	</div>
	<hr class="bubble-pattern">

</section><!-- page-hero -->

@foreach($flavors as $flavor)
<section class="flavor {{$flavor->css_class}}">
	<div class="container">
	
		<div class="large-image" data-image="{{$flavor->image}}" data-title="{{$flavor->title}}"></div>

		<section class="content">

			<section class="description">
				<h2>{{$flavor['title']}}</h2>
				{{$flavor['content']}}
			</section>
			@if($flavor->css_class == 'joy-juice')
				<img src="{{URL::asset('assets/images/superior-flavor-green.png')}}" alt="Superior Flavor" class="description-image right" />
			@endif

			<section class="products">
				<div class="heading">
					<span></span>
						<h3><strong>Available in</strong></h3>
					<span class="right"></span>
				</div>
				
				@if( count($flavor->products) == 4 ) <ul class="four">
				@elseif( count($flavor->products) == 3 ) <ul class="three">
				@elseif( count($flavor->products) == 2 ) <ul class="two">
				@else <ul class="one">
				@endif

				@foreach($flavor->products as $product)
					<li>
						<strong>{{$product->size->title}}</strong>
						@if($product->image)
						{{$product->size->ingredients}}
							<img src="{{URL::asset('assets/uploads/product_images')}}/{{$product->image}}" alt="{{$flavor['title']}} in {{$product->size->title}}" />
						@else
							<img src="{{URL::asset('assets/images/product-size-fpo.png')}}" alt="{{$flavor['title']}} in {{$product->size->title}}" />
						@endif
						<p>
							<a href="#">Ingredients</a>
							<a href="#">Nutrition</a>
						</p>
					</li>
				@endforeach
				</ul>
			</section>

		</section><!-- .content -->

	</div><!-- .container -->
</section><!-- .flavor -->
@endforeach

@stop

@section('footercontent')
<script>
/**
* Only load large flavor images 
*/
$(document).ready(function(){
	load_large_images();
});

$(window).resize(function(){
	delay(function(){
		load_large_images();
	}, 100);
});

var delay = (function(){
	var timer = 0;
	return function(callback, ms){
		clearTimeout (timer);
		timer = setTimeout(callback, ms);
	};
})();

function load_large_images()
{
	if ( $(window).width() > 767 ){
		var images = $('.large-image');
		$.each(images, function(i, v){
			var image = $(this).data('image');
			var title = $(this).data('title');
			var html = '<img src="{{URL::asset('assets/uploads/product_images')}}/' + image + '" alt="' + title + '" />';
			$(this).html(html);
		});
	}
}

</script>
@stop




