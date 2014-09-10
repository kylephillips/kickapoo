@extends('partials.master')
@section('content')

	<div class="container">
		@if( $page->get_field('Header Image', $page->id) )
			<img src="{{URL::asset('assets/uploads/page_images')}}/{{$page->get_field('Header Image', $page->id)}}" class="header-image" alt="{{$page['title']}}" />
		@else
			<h1>{{$page['title']}}</h1>
		@endif
	</div>

	<hr class="bubble-pattern-small">

	</section><!-- page-hero -->

	<section class="page-content locate-page">

		<div class="container full">
			@if($page['content'])
				{{$page['content']}}
			@endif

			@if($store_link)
			<br />
			<a href="{{$store_link}}" target="_blank" class="store-button">
				@if($page->get_field('Button Text', $page->id))
					{{$page->get_field('Button Text', $page->id)}}
				@else
					Or purchase online
				@endif
			</a>
			@endif
		</div>

		@if( $page->get_field('Flavors Image', $page->id) )
			<div class="large-image" data-image="{{$page->get_field('Flavors Image', $page->id)}}" data-title="Kickapoo Flavors"></div>
		@endif
	</section><!-- .locate-page -->

@stop

@section('footercontent')
<script>
/**
* Only load large images on big screens
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
			var html = '<img src="{{URL::asset('assets/uploads/page_images')}}/' + image + '" alt="Kickapoo Flavors" />';
			$(this).html(html);
		});
	}
}
</script>
@stop