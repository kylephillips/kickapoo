@extends('partials.master')
@section('content')

	<div class="container">
		@if( $page->get_field('Header Image', $page->id) )
		<?php $header_image = $page->get_field('Header Image', $page->id); ?>
			<img src="{{URL::asset($header_image['image'])}}" class="header-image" alt="{{$header_image['alt']}}" />
		@else
			<h1>{{$page['title']}}</h1>
		@endif
	</div>

	<hr class="bubble-pattern">

</section><!-- page-hero -->

<div class="container">
	@if( $page->get_field('Hero Image', $page->id) )
	<?php $hero_image = $page->get_field('Hero Image', $page->id); ?>
		<img src="{{URL::asset($hero_image['image'])}}" class="history-hero" alt="{{$hero_image['alt']}}" />
	@endif

	@if($page->get_field('Intro Text', $page->id))
		<section class="intro-text">
			{{$page->get_field('Intro Text', $page->id)}}
			<hr>
		</section>
	@endif
</div>

@if( $page['content'] )
<div class="container history">

	@if($page->get_field('Large Bottle', $page->id))
	<?php $bottle = $page->get_field('Large Bottle', $page->id); ?>
		<aside>
			<img src="{{URL::asset($bottle['image'])}}" alt="{{$bottle['alt']}}" />
		</aside>
		<section class="main">
			{{$page['content']}}
		</section>
	@else
		{{$page['content']}}
	@endif
</div>
@endif

@stop