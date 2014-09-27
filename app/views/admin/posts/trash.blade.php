@extends('admin.partials.admin-master')
@section('content')

<section class="page-head margin">
	<div class="container small">
		<h1>Trashed Posts <span class="pull-right"><a href="{{URL::route('admin.post.index')}}">&laquo; Back to Posts</a></span></h1>
	</div>
</section>

<div class="container small">
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
	<div class="container small admin-posts">	
		<ul class="trash">
		@foreach($posts as $post)
			<?php 
				$date = date('D, M jS Y - g:i a', strtotime($post['datetime'])); 
				$postdate = date('D, M jS y - g:i a', strtotime($post['post']['created_at']));
				$post_type = ( isset($post['twitter_id']) ) ? 'twitter' : 'instagram';
			?>
			@if(isset($post['twitter_id']))
				@include('admin.partials.tweet', array('trash'=>true))			
			@elseif(isset($post['instagram_id']))
				@include('admin.partials.gram', array('trash'=>true))
			@else
				@include('admin.partials.fbpost', array('trash'=>true))
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

/**
* Delete an Item Permanently
*/
function deletePost(id, type, item)
{
	$.ajax({
		url: '{{URL::route('delete_post')}}',
		method: 'POST',
		data: {
			id: id,
			type: type
		},
		success: function(data){
			console.log(data);
			$(item).fadeOut('fast', function(){
				$(item).remove();
			});
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

$(document).on('click', '.remove', function(e){
	e.preventDefault();
	$(this).addClass('disabled');
	var id = $(this).data('id');
	var type = $(this).data('type');
	var item = $(this).parents('.post');
	deletePost(id, type, item);
});
</script>
@stop


