@extends('partials.master')
@section('content')

	<div class="container">
		@if( $page->get_field('Header Image', $page->id) )
			<img src="{{URL::asset('assets/uploads/page_images')}}/{{$page->get_field('Header Image', $page->id)}}" class="header-image" alt="Swig Some Swag!" />
		@else
			<h1>{{$page['title']}}</h1>
		@endif
	</div>

	<hr class="bubble-pattern">

</section><!-- page-hero -->

<div class="container">
	@if( $page->get_field('Hero Image', $page->id) )
		<img src="{{URL::asset('assets/uploads/page_images')}}/{{$page->get_field('Hero Image', $page->id)}}" class="history-hero" alt="Kickapoo Joy Juice History" />
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
		<aside>
			<img src="{{URL::asset('assets/uploads/page_images')}}/{{$page->get_field('Large Bottle', $page->id)}}" alt="Kickapoo Joy Juice 12oz Glass Bottle" />
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