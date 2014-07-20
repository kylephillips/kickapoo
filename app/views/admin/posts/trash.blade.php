@extends('admin.partials.admin-master')
@section('content')
<div class="container small">
	<h1><i class="icon-remove"></i> Trash <span class="pull-right"><a href="{{URL::route('admin.post.index')}}">&laquo; Back to Posts</a></span></h1>
	<div class="alert alert-info">
		Last emptied: {{$last_trash}}
		@if( count($posts) > 0 )
		<button class="btn btn-danger pull-right empty-trash"><i class="icon-remove2"></i> Empty Trash</button>
		<span id="trash-loading" class="pull-right">
			<img src="{{URL::asset('assets/images/loading-small-blue.gif')}}" alt="loading" />
		</span>
		@else
		<button class="btn btn-default pull-right" disabled="disabled">No Trash to Empty</button>
		@endif
	</div>
</div>

@if(count($posts) == 0)
	<div class="container small">
		<div class="alert alert-success">The trash is empty.</div>
	</div>
@else
	<div class="container small trash admin-posts">	
		<ul>
		@foreach($posts as $post)
		<?php 
			$date = date('D, M jS Y - g:i a', strtotime($post['datetime'])); 
			$postdate = date('D, M jS y - g:i a', strtotime($post['post']['created_at']));
			$post_type = ( isset($post['twitter_id']) ) ? 'twitter' : 'instagram';
		?>
		@if(isset($post['twitter_id']))
			<li class="tweet post @if($post['approved'] == 1)approved @endif">
				<div class="content">
					<div class="avatar">
						<img src="{{$post['profile_image']}}" alt="user icon">
					</div>
					<div class="main">
						<strong><a href="http://twitter.com/{{$post['screen_name']}}" target="_blank">{{$post['screen_name']}}</a></strong>
						<span class="date">{{$date}}</span>
						<p>{{$post['text']}}</p>
						@if($post['image'])
						<div class="image">
							<img src="/assets/uploads/twitter_images/{{$post['image']}}" />
						</div>
						@endif
					</div><!-- .main -->
				</div><!-- .content -->
				<div class="status">
					<ul>
						<li><a href="#" class="remove" data-id="{{$post['twitter_id']}}" data-type="{{$post_type}}"><i class="icon-remove"></i> Remove Permanently</a></li>
						<li><a href="#" class="restore" data-id="{{$post['twitter_id']}}" data-type="{{$post_type}}"><i class="icon-checkmark"></i> Restore</a></li>
					</ul>
				</div>
			</li>
			
			@else
			<li class="gram post @if($post['approved'] == 1)approved @endif">
				<div class="content">
					<div class="avatar">
						<img src="{{$post['profile_image']}}" alt="user icon">
					</div>
					<div class="main">
						<strong><a href="http://instagram.com/{{$post['screen_name']}}" target="_blank">{{$post['screen_name']}}</a></strong>
						<span class="date">{{$date}}</span>
						@if($post['type'] == 'image')
						<div class="image">
							<img src="/assets/uploads/instagram_images/{{$post['image']}}" />
						</div>
						@else
						<video width="480" height="480" controls>
							<source src="{{$post['video_url']}}" type="video/mp4"/>
						</video>
						@endif
						@if($post['text'])<p>{{$post['text']}}</p>@endif
					</div>
					<div class="status">
						<ul>
							<li><a href="#" class="remove" data-id="{{$post['instagram_id']}}" data-type="{{$post_type}}"><i class="icon-remove"></i> Remove Permanently</a></li>
							<li><a href="#" class="restore" data-id="{{$post['instagram_id']}}" data-type="{{$post_type}}"><i class="icon-checkmark"></i> Restore</a></li>
						</ul>
					</div>
				@endif
		@endforeach
		</ul>
	</div><!-- .container -->
@endif
@stop

@section('footercontent')
<script>
/**
* Restore a post back to the feed
*/
function restorePost(id, type, item)
{
	$.ajax({
		url: '{{URL::route('restore_post')}}',
		method: 'POST',
		data: {
			id: id,
			type: type
		},
		success: function(data){
			$(item).fadeOut('fast', function(){
				$(item).remove();
			});
		}
	});
}

/**
* Empty the trash
*/
function emptyTrash()
{
	$.ajax({
		url: '{{URL::route('empty_trash')}}',
		method: 'GET',
		success: function(data){
			window.location.reload();
		}
	});
}

$(document).on('click', '.restore', function(e){
	e.preventDefault();
	$(this).addClass('disabled');
	var id = $(this).data('id');
	var type = $(this).data('type');
	var item = $(this).parents('.post');
	restorePost(id, type, item);
});

$(document).on('click', '.empty-trash', function(e){
	e.preventDefault();
	$(this).attr('disabled', 'disabled');
	$('#trash-loading').show();
	emptyTrash();
});
</script>
@stop


