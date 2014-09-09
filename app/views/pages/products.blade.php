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

<?php $i = 1; ?>
@foreach($flavors as $flavor)
<section class="flavor {{$flavor->css_class}} <?php if ( $i % 2 == 0 ) echo 'even'; ?>">
	<div class="container">
	
		<div class="large-image" data-image="{{$flavor->image}}" data-title="{{$flavor->title}}"></div>

		<section class="content">

			<section class="description">
				<h2>{{$flavor['title']}}</h2>
				{{$flavor['content']}}
			</section>

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
							<a href="#productmodal" class="open-modal" data-title="{{$flavor['title']}} {{$product->size->title}} Ingredients" data-id="{{$product->id}}" data-type="ingredients">Ingredients</a>
							<a href="#productmodal" class="open-modal" data-title="{{$flavor['title']}} {{$product->size->title}} Nutrition" data-id="{{$product->id}}" data-type="nutrition">Nutrition</a>
						</p>
					</li>
				@endforeach
				</ul>
			</section>

		</section><!-- .content -->

	</div><!-- .container -->
</section><!-- .flavor -->
<?php $i++; ?>
@endforeach

<!-- Product Info Modal -->
<div class="modal fade" id="productmodal">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close btn btn-mini" data-dismiss="modal">&times;</button>
				<h4 class="modal-title"></h4>
			</div>
			<div class="modal-body"></div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div><!-- /.modal -->

@stop

@section('footercontent')

@if(!Auth::check())
<script src="{{URL::asset('assets/js/modal.js')}}"></script>
@endif

<script>

/**
* Load in modal info
*/
$('.open-modal').on('click', function(e){
	e.preventDefault();
	
	var modal = $(this).attr('href');
	var title = $(this).data('title');
	var content = $(this).data('type');
	var id = $(this).data('id');
	
	$(modal).find('.modal-body').addClass('loading').empty();
	$(modal).find('.modal-title').text(title);

	$(modal).modal('show');

	load_modal_content(modal, content, id);

});
function load_modal_content(modal, content, id)
{
	$.ajax({
		url : "{{URL::route('modal_info')}}",
		type: 'GET',
		data : {
			content: content,
			id: id
		},
		success: function(data){
			if ( content === 'ingredients' ){
				load_ingredients(data, modal);
			} else {
				load_nutrition(data, modal);
			}
		}
	});
}
function load_ingredients(data, modal)
{
	var html = "";
	if ( data.content ) html += data.content;
	html += data.ingredients;
	$(modal).find('.modal-body').html(html).removeClass('loading');
}
function load_nutrition(data, modal)
{
	var html = '<img src="{{URL::asset('assets/uploads/product_images')}}/' + data.nutrition + '">';
	$(modal).find('.modal-body').html(html).removeClass('loading');
}

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

/**
* Parallax Cans
*/
$(window).bind('scroll',function(e){
	parallaxScroll();
});
function parallaxScroll(){
	var scrolled = $(window).scrollTop();
	$('.joy-juice .large-image').css('top', (-30+(scrolled * .15))+'px');
	$('.fruit-shine .large-image').css('top', (200-(scrolled * .15))+'px');
	$('.fuzzy-navel .large-image').css('top', (200-(scrolled * .15))+'px');
}

</script>
@stop




