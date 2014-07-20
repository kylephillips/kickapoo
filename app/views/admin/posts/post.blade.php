@extends('admin.partials.admin-master')
@section('content')
	<div class="container small">
		<h1>Social Posts</h1>

		{{Form::open(['url'=>URL::route('update_search'), 'class'=>'searchterm'])}}
			@if(Session::has('errors'))
				<div class="alert alert-danger">{{Session::get('errors')->first()}}</div>
			@endif
			@if(Session::has('searchsuccess'))
				<div class="alert alert-success">{{Session::get('searchsuccess')}}</div>
			@endif
			<ul>
				<li>
					<label for="twitter_search"><i class="icon-twitter"></i></label>
					{{Form::text('twitter_search', $twitter_search)}}
				</li>
				<li>
					<label for="instagram_search"><i class="icon-instagram"></i></label>
					{{Form::text('instagram_search', $instagram_search)}}
				</li>
			</ul>
			{{Form::submit('Save', ['class'=>'btn btn-small btn-primary'])}}
		{{Form::close()}}

		<div class="alert alert-info">
			Last Import: {{$last_import}} 
			<span class="pull-right import-buttons">
				<span id="import-loading">
					<img src="{{URL::asset('assets/images/loading-small-blue.gif')}}" alt="loading" />
				</span>
				<button class="btn btn-min btn-default run-import">Run Import</button>
				<button class="btn btn-min btn-default import-single-toggle">Import Single</button>
			</span>
		</div>

		<!-- Single Import Form -->
		<div class="single-form">
			{{Form::open(['url'=>''])}}
				<div class="btn-group" data-toggle="buttons">
					<label class="btn btn-default active">
						<input type="radio" name="social-type" value="twitter" checked>
						<i class="icon-twitter"></i>
					</label>
					<label class="btn btn-default">
						<input type="radio" name="social-type" value="instagram">
						<i class="icon-instagram"></i>
					</label>
				</div>
				<div class="inputs">
					{{Form::text('id', null, ['class'=>'social-id', 'placeholder'=>'Tweet ID'])}}
					<button id="single-submit" class="btn btn-mini btn-default">Import</button>
				</div>
			{{Form::close()}}
		</div><!-- .single-form -->

	</div><!-- .container -->

	<!-- Post Feed -->
	<div class="container small admin-posts">

		<ul id="postfeed">
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
						<ul class="info">
							<li><a href="https://twitter.com/{{$post['screen_name']}}/status/{{$post['twitter_id']}}" target="_blank"><i class="icon-twitter"></i></a></li>
							<li>{{$post['retweet_count']}} <i class="icon-loop"></i></li>
							<li>{{$post['favorite_count']}} <i class="icon-star"></i></li>
						</ul>
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
				@if($post['approved'] == 1)
				@else
				<div class="status">
					<ul>
						<li><a href="#" class="remove" data-id="{{$post['twitter_id']}}" data-type="{{$post_type}}"><i class="icon-close"></i> Delete</a></li>
						<li><a href="#" class="approve" data-id="{{$post['twitter_id']}}" data-type="{{$post_type}}"><i class="icon-checkmark"></i> Approve</a></li>
					</ul>
				</div>
				@endif
			</li>
			
			@else
			<li class="gram post @if($post['approved'] == 1)approved @endif">
				<div class="content">
					<div class="avatar">
						<img src="{{$post['profile_image']}}" alt="user icon">
					</div>
					<div class="main">
						<ul class="info">
							<li><a href="{{$post['link']}}" target="_blank"><i class="icon-instagram"></i></a></li>
							<li>{{$post['like_count']}} <i class="icon-heart"></i></li>
						</ul>
						<strong><a href="http://instagram.com/{{$post['screen_name']}}" target="_blank">{{$post['screen_name']}}</a></strong>
						<span class="date">{{$date}}</span>
						@if($post['text'])<p>{{$post['text']}}</p>@endif
						@if($post['type'] == 'image')
						<div class="image">
							<img src="/assets/uploads/instagram_images/{{$post['image']}}" />
						</div>
						@else
						<video width="480" height="480" controls>
							<source src="{{$post['video_url']}}" type="video/mp4"/>
						</video>
						@endif
					</div>
					@if($post['approved'] == 1)
					<div class="status-approved">
						<p><i class="icon-checkmark"></i> Approved {{$postdate}}</p>
						<a href="#" class="remove-approved" data-id="{{$post['instagram_id']}}" data-type="{{$post_type}}" data-postid="{{$post['post']['id']}}">Unapprove and Delete</a>
					</div>
					@else
					<div class="status">
						<ul>
							<li><a href="#" class="remove" data-id="{{$post['instagram_id']}}" data-type="{{$post_type}}"><i class="icon-close"></i> Delete</a></li>
							<li><a href="#" class="approve" data-id="{{$post['instagram_id']}}" data-type="{{$post_type}}"><i class="icon-checkmark"></i> Approve</a></li>
						</ul>
					</div>
					@endif
				</div><!-- .content -->
			</li>
			@endif

		@endforeach
		</ul>

		<?php echo $posts->links(); ?>

	</div>
@stop

@section('footercontent')
<script>
/**
* Remove Post from list
*/
function removePost(id, type, item)
{
	$.ajax({
		url: '{{URL::route('remove_post')}}',
		data: {
			id: id,
			type: type
		},
		success: function(data){
			if (data == 'success'){
				$(item).fadeOut();
			}
		}
	});
}

/**
* Run an Import Manually
*/
function doImport()
{
	$.ajax({
		url: '{{URL::route('do_import')}}',
		success: function(data){
			if ( data.status == 'success' ){
				window.location.reload();
			}
		}
	});
}

/**
* Approve a Post
*/
function approvePost(id, type, item)
{
	$.ajax({
		url: '{{URL::route('admin.post.store')}}',
		method: 'POST',
		data: {
			id : id,
			type : type
		},
		success: function(data){
			console.log(data);
			$(item).addClass('approved');
			$(item).find('.status').remove();
			addApprovedStatus(id, item, type, data);
		}
	});
}

function addApprovedStatus(id, item, type, post)
{
	var out = '<div class="status-approved"><p><i class="icon-checkmark"></i> Approved ' + post.approval_date + '</p><a href="#" class="remove-approved" data-id="' + id + '" data-type="' + type + '" data-postid="' + post.postid + '">Unapprove and Delete</a></div>';
	$(item).find('.content').append(out);
}

/**
* Remove an approved Post
*/
function removeApproved(id, type, item, postid)
{
	$.ajax({
		url: '{{URL::route('remove_post')}}',
		data: {
			id: id,
			type: type,
			postid: postid
		},
		success: function(data){
			if (data == 'success'){
				$(item).fadeOut();
			}
		}
	});
}

$(document).on('click', '.remove', function(e){
	e.preventDefault();
	var id = $(this).data('id');
	var type = $(this).data('type');
	var item = $(this).parents('.post');
	removePost(id, type, item);
});

// Approve Button
$(document).on('click', '.approve', function(e){
	e.preventDefault();
	var id = $(this).data('id');
	var type = $(this).data('type');
	var item = $(this).parents('.post');
	approvePost(id, type, item);
});

// Remove Approved Link
$(document).on('click', '.remove-approved', function(e){
	e.preventDefault();
	var id = $(this).data('id');
	var type = $(this).data('type');
	var item = $(this).parents('.post');
	var postid = $(this).data('postid');
	removeApproved(id, type, item, postid);
});

// Manual Import Button
$(document).on('click', '.run-import', function(e){
	e.preventDefault();
	$('#import-loading').show();
	$(this).attr('disabled', 'disabled');
	$(this).text('Importing');
	doImport();
});

// Update single import label on change
$(document).on('change', 'input[name="social-type"]', function(){
	var text = ( $('input[name="social-type"]:checked').val() === 'twitter' ) ? 'Tweet ID' : 'Instagram ID';
	$('.social-id').attr('placeholder', text);
});

// Toggle the single import form
$(document).on('click', '.import-single-toggle', function(){
	$('.single-form').toggle();
	$(this).toggleClass('active');
});

</script>
@stop