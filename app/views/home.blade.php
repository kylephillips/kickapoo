@extends('partials.master')
@section('content')
@foreach($posts as $post)
	@if($post->type == 'tweet')
		<p>Tweet:<br />{{$post->tweet->datetime}}<br />{{$post->tweet->text}}</p>
	@else
		<p>Gram</p>
		<img src="{{URL::asset('assets/uploads/instagram_images')}}/{{$post->gram->image}}" />
	@endif
@endforeach
@stop