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
				<button class="btn btn-mini btn-default run-import">
					<i class="icon-loop2"></i> Run Import
				</button>
				<button class="btn btn-mini btn-default import-single-toggle">
					<i class="icon-box-add"></i> Import Single
				</button>
				<a href="{{URL::route('post_trash')}}" class="btn btn-mini btn-default trash-toggle">
					<i class="icon-remove"></i> Trash
				</a>
			</span>
		</div>

		<!-- Single Import Form -->
		<div class="single-form">
			<div id="single-error" class="alert alert-danger" style="display:none;"></div>
			<div id="single-success" class="alert alert-success" style="display:none;"></div>
			
			{{Form::open(['url'=>''])}}
				<span class="buttons">
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
					<a href="#twitterhelp" class="btn btn-default help-btn" data-toggle="modal"><strong>?</strong></a>
				</span>
				<div class="inputs">
					{{Form::text('id', null, ['class'=>'social-id', 'placeholder'=>'Tweet ID'])}}
					<input type="hidden" id="import-type" value="twitter" />
					<button id="single-submit" class="btn btn-mini btn-default import-single">Import</button>
				</div>
			{{Form::close()}}
		</div><!-- .single-form -->

	</div><!-- .container -->

	<!-- Post Feed -->
	<div class="container small admin-posts">

		<div class="scroll">

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
				<div class="status-approved">
					<p><i class="icon-checkmark"></i> Approved {{$postdate}}</p>
					<a href="#" class="remove-approved" data-id="{{$post['twitter_id']}}" data-type="{{$post_type}}" data-postid="{{$post['post']['id']}}">Unapprove and Trash</a>
				</div>
				@else
				<div class="status">
					<ul>
						<li><a href="#" class="remove" data-id="{{$post['twitter_id']}}" data-type="{{$post_type}}"><i class="icon-remove"></i> Trash</a></li>
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
						<a href="#" class="remove-approved" data-id="{{$post['instagram_id']}}" data-type="{{$post_type}}" data-postid="{{$post['post']['id']}}">Unapprove and Trash</a>
					</div>
					@else
					<div class="status">
						<ul>
							<li><a href="#" class="remove" data-id="{{$post['instagram_id']}}" data-type="{{$post_type}}"><i class="icon-remove"></i> Trash</a></li>
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

		</div><!-- .scroll -->

	</div><!-- .container -->
@stop

@section('footercontent')
<!-- Twitter help modal -->
<div class="modal fade" id="twitterhelp">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
				<h4 class="modal-title">Finding a Tweet's ID</h4>
			</div>
			<div class="modal-body">
				<ol>
					<li>Within your timeline, click the tweet to expand it (or click "more").</li>
					<li>Once the tweet is expanded, look for the date of the tweet in gray lettering. Click the "Details" link next to the date. This will open the single view of the tweet.<br />
						<img src="{{URL::asset('assets/images/twitter-help-one.jpg')}}"></li>
					<li>The ID of the tweet is the last line of numbers in the browser address bar. It will appear as a long string of numbers:.<br />
						<img src="{{URL::asset('assets/images/twitter-help-two.jpg')}}"></li>
				</ol>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div><!-- /.modal -->

<!-- Instagram help modal -->
<div class="modal fade" id="instagramhelp">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
				<h4 class="modal-title">Finding an Instagram ID</h4>
			</div>
			<div class="modal-body">
				<ol>
					<li>Under the user's timelime, click the image to embed. This will open a modal window.</li>
					<li>The ID of the post will be in the address bar:<br />
						<img src="{{URL::asset('assets/images/instagram-help.jpg')}}">
					</li>
				</ol>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				<button type="button" class="btn btn-primary">Save changes</button>
			</div>
		</div>
	</div>
</div><!-- /.modal -->

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

/**
* Add Approved Status to newly approved post
*/
function addApprovedStatus(id, item, type, post)
{
	var out = '<div class="status-approved"><p><i class="icon-checkmark"></i> Approved ' + post.approval_date + '</p><a href="#" class="remove-approved" data-id="' + id + '" data-type="' + type + '" data-postid="' + post.postid + '">Unapprove and Trash</a></div>';
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

/**
* Import a single post
*/
function importSingle(type, id)
{
	$.ajax({
		url: '{{URL::route('import_single')}}',
		method: 'POST',
		data: {
			id: id,
			type: type
		},
		success: function(data){
			if ( data.status === 'success' ){
				$('#single-success').text(data.message).show();
				$('.import-single').removeAttr('disabled');
				if ( type == 'twitter' ) { addNewTweet(data.post[0], data.post_id); }
				if ( type == 'instagram' ) { addNewGram(data.post[0], data.post_id); }
			} else {
				$('#single-error').text(data.message);
				$('#single-error').show();
				$('.import-single').removeAttr('disabled');
			} 
		}
	});
}

/**
* Add a newly imported tweet to the feed
*/
function addNewTweet(tweet, id)
{
	var out = '<li class="tweet post"><div class="content"><div class="avatar"><img src="' + tweet.profile_image + '" alt="user icon"></div><div class="main"><ul class="info"><li><a href="https://twitter.com/' + tweet.screen_name + '/status/' + id + '" target="_blank"><i class="icon-twitter"></i></a></li><li>' + tweet.retweet_count + ' <i class="icon-loop"></i></li><li>' + tweet.favorite_count + ' <i class="icon-star"></i></li></ul><strong><a href="http://twitter.com/' + tweet.screen_name + '" target="_blank">' + tweet.screen_name + '</a></strong><span class="date">DATE HERE</span><p>' + tweet.text + '</p>';
	if ( tweet.image ){
		out += '<div class="image"><img src="/assets/uploads/twitter_images/' + tweet.image + '" /></div>';
	}
	out += '</div></div><div class="status"><ul><li><a href="#" class="remove" data-id="' + id + '" data-type="twitter"><i class="icon-remove"></i> Trash</a></li><li><a href="#" class="approve" data-id="' + id + '" data-type="twitter"><i class="icon-checkmark"></i> Approve</a></li></ul></div></li>';
	$('#postfeed').prepend(out);
}

/**
* Add a new imported gram to the feed
*/
function addNewGram(gram, id)
{
	var out = '<li class="gram post"><div class="content"><div class="avatar"><img src="' + gram.profile_image + '" alt="user icon"></div><div class="main"><ul class="info"><li><a href="' + gram.link + '" target="_blank"><i class="icon-instagram"></i></a></li><li>' + gram.like_count +' <i class="icon-heart"></i></li></ul><strong><a href="http://instagram.com/' + gram.screen_name + '" target="_blank">' + gram.screen_name + '</a></strong><span class="date">DATE HERE</span>';
	if ( gram.text ){
		out += '<p>' + gram.text + '</p>';
	}
	if ( gram.type === 'image' ){
		out += '<div class="image"><img src="' + gram.image + '" /></div>';
	} else {
		out += '<video width="480" height="480" controls><source src="' + gram.video_url + '" type="video/mp4"/></video>';
	}
	out += '</div><div class="status"><ul><li><a href="#" class="remove" data-id="' + gram.id + '" data-type="instagram"><i class="icon-remove"></i> Trash</a></li><li><a href="#" class="approve" data-id="' + gram.id + '" data-type="instagram"><i class="icon-checkmark"></i> Approve</a></li></ul></div></div></li>';
	$('#postfeed').prepend(out);
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

// Import Single Button
$(document).on('click', '.import-single', function(e){
	e.preventDefault();
	$(this).attr('disabled', 'disabled');
	$('#single-error, #single-success').hide();
	var type = $('input[name="social-type"]:checked').val();
	var id = $('.social-id').val();
	importSingle(type, id);
});

// Update single import label & help modal on change
$(document).on('change', 'input[name="social-type"]', function(){
	var text = ( $('input[name="social-type"]:checked').val() === 'twitter' ) ? 'Tweet ID' : 'Instagram ID';
	var modal = ( text === 'Tweet ID' ) ? '#twitterhelp' : '#instagramhelp';
	var type = ( text === 'Tweet ID' ) ? 'twitter' : 'instagram';
	$('.social-id').attr('placeholder', text);
	$('.help-btn').attr('href', modal);
	$('#import-type').val(type);
});

// Toggle the single import form
$(document).on('click', '.import-single-toggle', function(){
	$('.single-form').toggle();
	$(this).toggleClass('active');
});
</script>

@if($num_posts > 4)
<script>
// Infinite Scroll
$(function() {
	$('.scroll').jscroll({
		loadingHtml: '<div class="loading-infinite"><img src="{{URL::asset('assets/images/loading-small-white.gif')}}" alt="Loading" /></div>',
		autoTrigger: true,
		nextSelector: '.pagination li.active + li a', 
		contentSelector: 'div.scroll',
		callback: function() {
			$('ul.pagination:visible:first').hide();
		}
	});
});
</script>
@endif
@stop