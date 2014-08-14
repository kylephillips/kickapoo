@extends('partials.master')
@section('content')

<h1>{{$page['title']}}</h1>
@foreach($flavors as $flavor)
	<h2>{{$flavor['title']}}</h2>
	<p>{{$flavor['content']}}</p>
	<h3><strong>Available in</strong></h3>
	@foreach($flavor->products as $product)
		<p><strong>{{$product->size->title}}</strong><br />
		Ingredients: {{$product->ingredients}}</p>
	@endforeach
@endforeach

@stop