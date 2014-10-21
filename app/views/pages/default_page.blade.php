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

	<div class="container full default">
		{{$page['content']}}
	</div>

	</section><!-- page-hero -->
@stop