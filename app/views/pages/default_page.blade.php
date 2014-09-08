@extends('partials.master')
@section('content')
<div class="container">
		@if( $page->get_field('Header Image', $page->id) )
			<img src="{{URL::asset('assets/uploads/page_images')}}/{{$page->get_field('Header Image', $page->id)}}" class="header-image" alt="{{$page['title']}}" />
		@else
			<h1>{{$page['title']}}</h1>
		@endif
	</div>

	<hr class="bubble-pattern">

	</section><!-- page-hero -->
@stop