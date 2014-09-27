@extends('admin.partials.admin-master')
@section('content')

<section class="page-head margin">
	<div class="container small">
		<h1>Banned Users</h1>
	</div>
</section>

<div class="container small">
	<div class="alert alert-info">Banned users' posts will not be imported to the social feed.</div>
	<ul class="banned-users">
		@foreach($banned_users as $user)
			@if($user['type'] == 'instagram')
			<li>
				<i class="icon-instagram"></i>
				<strong><a href="http://instagram.com/{{$user['screen_name']}}" target="_blank" class="screenname">{{$user['screen_name']}}</a></strong>
				<span class="pull-right"><a href="#" class="btn btn-mini btn-primary unban" data-id="{{$user['id']}}">Unban</a></span>
			</li>
			@else
			<li>
				<i class="icon-twitter"></i>
				<strong><a href="http://twitter.com/{{$user['screen_name']}}" target="_blank" class="screenname">{{$user['screen_name']}}</a></strong>
				<span class="pull-right"><a href="#" class="btn btn-mini btn-primary unban" data-id="{{$user['id']}}">Unban</a></span>
			</li>
			@endif
		@endforeach
	</ul>
</div>

@stop

@section('footercontent')
<script>
function unban(id, item)
{
	$.ajax({
		url: '{{URL::route('unban')}}',
		data: {
			id: id
		},
		success: function(data){
			$(item).fadeOut(function(){
				$(item).remove();
			});
		}
	});
}

$(document).on('click', '.unban', function(e){
	e.preventDefault();
	var item = $(this).parents('li');
	var id = $(this).data('id');
	unban(id, item);
});
</script>
@stop