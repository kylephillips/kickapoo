@extends('partials.master')
@section('content')

<hr class="bubble-pattern">
</section><!-- .home-hero -->

<section id="posts" class="social-posts">
	<ul>
		@foreach($posts as $i=>$post)
			<li class="item @if($i % 3 == 0)white @elseif($i % 2 == 0)lime @elseif($i % 1 == 0)yellow @endif">
				<section class="post">
				@if($post->type == 'instagram')
					@include('partials.gram')
				@else
					@include('partials.tweet')
				@endif
				</section>
			</li>
		@endforeach
	</ul>
</section>

@stop

@section('footercontent')
<script type="text/javascript" src="//platform.twitter.com/widgets.js"></script>
<script>
$(window).load(function(){

	var $container = $('#posts');
		$container.masonry({
			itemSelector: '.item'
		});
})
</script>
@stop