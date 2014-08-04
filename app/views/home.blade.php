@extends('partials.master')
@section('content')

<section class="headline">
	<img src="{{URL::asset('assets/images/home-headline.png')}}" />
	<p>#<em>kickapoo</em> to share your joy face with the world!</p>
	<a href="#" class="button">Or share it here</a>
</section>

<img src="{{URL::asset('assets/images/home-yellowbubbles-left.png')}}" class="left-bubbles" />
<img src="{{URL::asset('assets/images/home-yellowbubbles-right.png')}}" class="right-bubbles" />

<hr class="bubble-pattern">
</section><!-- .home-hero -->

<section id="posts" class="social-posts loading">
	@if( count($posts) > 0 )
		@foreach($posts as $i=>$post)
			<div class="item @if($i % 3 == 0)white @elseif($i % 2 == 0)lime @elseif($i % 1 == 0)yellow @endif">
				<section class="post">
				@if($post->type == 'instagram')
					@include('partials.gram')
				@else
					@include('partials.tweet')
				@endif
				</section>
			</div>
		@endforeach
	@else
		<p class="center">No Posts Yet!</p>
	@endif
</section>


@if(count($posts) > 0)
	<div class="pagination hidden">{{$posts->links()}}</div>
	<p class="center nextposts"><a href="#" class="load-more">Load More Joy! <i class="icon-loop2"></i></a></p>
@endif


<section class="home-callouts">
	<div class="container">
		<section class="joy-meter">
			<div class="meter-interior">
				<img src="{{URL::asset('assets/images/joy-meter-pointer.png')}}" alt="Gauge Needle" class="needle">
			</div>
		</section>
		<a href="#" class="products">
			<span>Products</span>
			<img src="{{URL::asset('assets/images/homepage-products.jpg')}}" alt="Product Image" />
		</a>
		<a href="#" class="history">
			<span>History</span>
			<img src="{{URL::asset('assets/images/homepage-history.jpg')}}" alt="History Image" />
		</a>
	</div>
</section>

@stop


@section('footercontent')
<script type="text/javascript" src="//platform.twitter.com/widgets.js"></script>
<script>

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

	// Infinite Scroll
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