@extends('partials.master')
@section('content')

<section class="headline">
	@if( $page->get_field('Headline', $page->id) )
	<?php $headline = $page->get_field('Headline', $page->id); ?>
		<img src="{{URL::asset($headline['image'])}}" class="header-image" alt="{{$headline['alt']}}" />
	@else
		<img src="{{URL::asset('assets/images/home-headline.png')}}" class="home-headline" />
	@endif
	
	{{$page['content']}}
	@if($contact_page)
	<a href="{{URL::route('page', ['page'=>$contact_page->slug])}}" class="button">{{Lang::get('messages.share')}} <i class="icon-arrow-right"></i></a>
	@endif
</section>

@if( $page->get_field('Can One', $page->id) )
<?php $can_one = $page->get_field('Can One', $page->id); ?>
<img src="{{URL::asset( $can_one['image'] )}}" class="home-green-can" alt="{{$can_one['alt']}}" />
@else
<img src="{{URL::asset('assets/images/kickapoo-joy-juice-can.png')}}" class="home-green-can" alt="Kickapoo Joy Juice Slim Can" />
@endif

@if( $page->get_field('Can Two', $page->id) )
<?php $can_two = $page->get_field('Can Two', $page->id); ?>
<img src="{{URL::asset( $can_two['image'] )}}" class="home-red-can" alt="{{$can_two['alt']}}" />
@else
<img src="{{URL::asset('assets/images/kickapoo-fruit-shine-can.png')}}" class="home-red-can" alt="Kickapoo Fruit Shine Slim Can" />
@endif

<img src="{{URL::asset('assets/images/home-yellowbubbles-left.png')}}" class="left-bubbles" alt="Yellow Bubbles" aria-hidden="true" />
<img src="{{URL::asset('assets/images/home-yellowbubbles-right.png')}}" class="right-bubbles" alt="Yellow Bubbles" aria-hidden="true" />

<hr class="bubble-pattern">

</div><!-- .home-hero -->

<div class="post-area">
	<div id="posts" class="social-posts loading">
		@if( count($posts) > 0 )
			@foreach($posts as $i=>$post)
				<div class="item @if($i % 3 == 0)white @elseif($i % 2 == 0)lime @elseif($i % 1 == 0)yellow @endif">
					<div class="post">
					@if($post->type == 'instagram')
						@include('partials.gram')
					@elseif($post->type == 'twitter')
						@include('partials.tweet')
					@else
						@include('partials.fbpost')
					@endif
					</div>
				</div>
			@endforeach
		@else
			<p class="center">No Posts Yet!</p>
		@endif
	</div>
</div>


@if(count($posts) > 0)
	<div class="pagination hidden">{{$posts->links()}}</div>
	<p class="center nextposts"><a href="#" class="load-more" rel="nofollow">{{Lang::get('messages.load_more')}}! <i class="icon-loop2"></i></a></p>
@endif


<div class="home-callouts">
	<div class="container">
		<div class="joy-meter">
			<div class="meter-interior">
				<img src="{{URL::asset('assets/images/joy-meter-pointer.png')}}" alt="Gauge Needle" class="needle" />
				<img src="{{URL::asset('assets/images/joy-meter-bg.png')}}" alt="Guage" class="background" />
				<img src="{{URL::asset('assets/images/joy-meter-gauge.png')}}" alt="Guage" class="gauge" />
			</div>
		</div>
		
		@if($products_page)
		<a href="{{URL::route('page', ['page'=>$products_page->slug])}}" class="products">
			<span>{{$products_page->title}}</span>
			<img src="{{URL::asset('assets/images/homepage-products.jpg')}}" alt="Product Image" />
		</a>
		@endif

		@if($history_page)
		<a href="{{URL::route('page', ['page'=>$history_page->slug])}}" class="history">
			<span>{{$history_page->title}}</span>
			<img src="{{URL::asset('assets/images/homepage-history.jpg')}}" alt="History Image" />
		</a>
		@endif

	</div>
</div>

<!-- Parallax Bubbles -->
<div class="bubbles one" aria-hidden="true">
	<div class="bubble xlarge" id="b1-1"></div>
	<div class="bubble xlarge" id="b1-2"></div>
	<div class="bubble large" id="b1-3"></div>
	<div class="bubble large" id="b1-4"></div>
	<div class="bubble medium" id="b1-5"></div>
	<div class="bubble large" id="b1-6"></div>
	<div class="bubble small" id="b1-7"></div>
</div>

<div class="bubbles two" aria-hidden="true">
	<div class="bubble medium" id="b2-1"></div>
	<div class="bubble xlarge" id="b2-2"></div>
	<div class="bubble small" id="b2-3"></div>
	<div class="bubble medium" id="b2-4"></div>
	<div class="bubble large" id="b2-5"></div>
	<div class="bubble xlarge" id="b2-6"></div>
	<div class="bubble medium" id="b2-7"></div>
</div>

<div class="bubbles three" aria-hidden="true">
	<div class="bubble small" id="b3-1"></div>
	<div class="bubble large" id="b3-2"></div>
	<div class="bubble medium" id="b3-3"></div>
	<div class="bubble xlarge" id="b3-4"></div>
	<div class="bubble xsmall" id="b3-5"></div>
	<div class="bubble xsmall" id="b3-6"></div>
</div>

@stop


@section('footercontent')
<script type="text/javascript" src="//platform.twitter.com/widgets.js"></script>
<script>
/**
* Initialize masonry on posts container
*/
function loadMasonry()
{
	var $container = $('#posts');
	$container.imagesLoaded(function(){
		$container.masonry({
			itemSelector: '.item'
		});
	});
}

$(window).load(function(){
	loadMasonry();
	
	$('#posts').removeClass('loading');

	/**
	* Infinite Scroll
	*/
	$('#posts').infinitescroll({
		navSelector  : '.pagination',
		nextSelector : '.pagination li:last-child a',
	  	itemSelector : '.item',
		extraScrollPx: 0,
		errorCallback: function(){
			$('.load-more').remove();
		},
	  	loading: {
			finishedMsg: undefined,
			img: null,
		}
	},
	// trigger Masonry as a callback
	function( newElements ){
		$('.load-more').removeClass('loading').removeClass('disabled');
		$('.load-more').html('Load More Joy! <i class="icon-loop2"></i>');
		var $newElems = $( newElements ).css({ opacity: 0 });
		$newElems.imagesLoaded(function(){
			$newElems.animate({ opacity: 1 });
			$('#posts').masonry( 'appended', $newElems, true ); 
		});
	});

	// Unbind Infinite Scroll for Manual Click
	$(window).unbind('.infscr');

});

/**
* Trigger Infinite Scroll load
*/
$(document).on('click', '.load-more', function(e){
	$(this).addClass('loading').addClass('disabled');
	$(this).html('Loading <i class="icon-loop2"></i>');
	$('#posts').infinitescroll('retrieve');
	$('.nextposts').show();
	return false;
});

</script>
@stop