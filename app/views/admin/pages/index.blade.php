@extends('admin.partials.admin-master')
@section('content')

<section class="page-head margin">
	<div class="container">
		@if( isset($_GET['name']) )
			<h1>All {{$_GET['name']}} Pages</h1>
		@else
			<h1>All Pages</h1>
		@endif
		<select id="language-select">
			<option>Select Language</option>
			@foreach( LaravelLocalization::getSupportedLocales() as $code => $properties )
			<option value="{{URL::route('page_index', ['lang'=>$code])}}&name={{$properties['name']}}">{{$properties['name']}}</option>
			@endforeach
		</select>
	</div>
</section>

<div class="container">

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
				<label><input type="checkbox" class="show-in-menu" name="show" data-slug="{{$page->slug}}" @if( $page->show_in_menu == 1) checked @endif> 
					Show in Navigation
				</label>
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

$('.show-in-menu').on('change', function(){
	var slug = $(this).data('slug');
	var show = '0';
	if ( $(this).is(':checked') ) show = '1';
	toggle_show(slug, show);
});

function toggle_show(slug, show)
{
	$.ajax({
		url: "{{URL::route("menu_toggle")}}",
		type: 'POST',
		data: {
			slug : slug,
			show: show
		},
		success: function(data){
			console.log(data);
		}
	});
}

$('#language-select').on('change', function(){
	var href = $(this).val();
	if ( href !== '' ){
		window.location = href;
	}
});
</script>
@stop