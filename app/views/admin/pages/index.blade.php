@extends('admin.partials.admin-master')
@section('content')

<div class="container small">

	<h1>All Pages</h1>

	<div class="well">

		@if(Session::has('success'))
		<div class="alert alert-success">{{Session::get('success')}}</div>
		@endif

		<div class="alert alert-info">Click and drag rows to reorder pages</div>

		<ul class="page-list">
			@foreach($pages as $page)
			<li id="{{$page->id}}">
				<strong>{{$page->title}}</strong>
				<a href="{{URL::route('edit_page', ['slug'=>$page->slug])}}" class="btn btn-warning pull-right">Edit Page</a>
			</li>
			@endforeach
		</ul>

	</div><!-- .well -->
</div><!-- .container -->

@stop
@section('footercontent')
<script>
$(document).ready(function(){
	$('.page-list').sortable({
		stop : function(event, ui){
			var order = $(this).sortable('toArray');
			var url = "{{URL::route('order_pages')}}?order=" + order;
			$.ajax({
				type:"GET",
				url: url,
				success:function(data){
					console.log(data);
				}
			});
		}
	});
});
</script>
@stop