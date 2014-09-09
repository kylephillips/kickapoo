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
			<a href="{{$store_link}}" target="_blank" class="store-button">Or purchase online</a>
			@endif
		</div>

		@if( $page->get_field('Flavors Image', $page->id) )
			<img src="{{URL::asset('assets/uploads/page_images')}}/{{$page->get_field('Flavors Image', $page->id)}}" class="flavors-image" alt="Kickapoo Flavors" />
		@endif
	</section><!-- .locate-page -->

@stop