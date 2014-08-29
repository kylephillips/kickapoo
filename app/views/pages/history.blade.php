@extends('partials.master')
@section('content')

	@if( $page->get_field('Header Image', $page->id) )
		<img src="{{URL::asset('assets/uploads/page_images')}}/{{$page->get_field('Header Image', $page->id)}}" class="header-image" alt="Swig Some Swag!" />
	@else
		<h1>{{$page['title']}}</h1>
	@endif

</section><!-- page-hero -->

<div class="container">
	
</div>

@stop