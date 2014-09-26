@extends('partials.master')
@section('content')
<div class="container">
		@if( $page->get_field('Header Image', $page->id) )
			<img src="{{URL::asset($page->get_field('Header Image', $page->id))}}" class="header-image" alt="{{$page['title']}}" />
		@else
			<h1>{{$page['title']}}</h1>
		@endif
	</div>

	<hr class="bubble-pattern">

	</section><!-- page-hero -->
@stop