@extends('admin.partials.admin-master')
@section('content')

<section class="panel-side">

	<!-- Last Import -->
	<div class="alert alert-gray">
		<i class="icon-admin-clock"></i> Last Import: 
		@if(isset($last_import['date']))
			{{$last_import['count']}} items on {{$last_import['date']}}
		@else
			{{$last_import}}
		@endif
		&ndash; <strong><span id="pending_count">{{$pending_count}}</span> awaiting moderation</strong>
	</div>

	<!-- Manual Import -->
	<div class="alert alert-info" id="import-alert" style="display:none;"></div>
	<div class="import-buttons run-import">
		<span class="text">
			<i class="icon-admin-loop2"></i> Run Import
		</span>
		<span id="import-loading">
			<img src="{{URL::asset('assets/images/loading-black-white.gif')}}" alt="loading" />
		</span>
	</div>
	
	<!-- Social Search Terms -->
	<div class="social-search-terms">
		<h4><i class="icon-admin-search"></i> Search Term <i class="icon-admin-caret-down caret-toggle"></i></h4>
		{{Form::open(['url'=>URL::route('update_search'), 'class'=>'search-term-form'])}}
			@if(Session::has('errors'))
				<div class="alert alert-danger">{{Session::get('errors')->first()}}</div>
			@endif
			@if(Session::has('searchsuccess'))
				<div class="alert alert-success">{{Session::get('searchsuccess')}}</div>
			@endif
			<ul>
				<li>
					<label for="twitter_search"><i class="icon-admin-twitter"></i></label>
					{{Form::text('twitter_search', $twitter_search)}}
				</li>
				<li>
					<label for="instagram_search"><i class="icon-admin-instagram"></i></label>
					{{Form::text('instagram_search', $instagram_search)}}
				</li>
			</ul>
			{{Form::submit('Save', ['class'=>'btn btn-small btn-primary'])}}
		{{Form::close()}}
	</div><!-- social-search-terms -->

	<!-- Single Import Form -->
	<div class="single-form">
		<h4><i class="icon-admin-box-remove"></i> Import Single <i class="icon-admin-caret-down caret-toggle"></i></h4>
		
		{{Form::open(['url'=>''])}}
			<div id="single-error" class="alert alert-danger" style="display:none;"></div>
			<div id="single-success" class="alert alert-success" style="display:none;"></div>

			<div class="buttons">
				<select name="social-type">
					<option value="twitter">Twitter</option>
					<option value="instagram">Instagram</option>
				</select>
				<a href="#twitterhelp" class="btn btn-default help-btn" data-toggle="modal"><strong>?</strong></a>
			</div>
			<div class="inputs">
				{{Form::text('id', null, ['class'=>'social-id', 'placeholder'=>'Tweet ID'])}}
				<input type="hidden" id="import-type" value="twitter" />
				<button id="single-submit" class="btn btn-mini btn-default import-single">Import</button>
			</div>
		{{Form::close()}}
	</div><!-- .single-form -->

	<!-- Post Filters -->
	<div class="post-filters">
		<p>Filter Posts</p>
		<ul class="filter">
			<li class="dropdown">
				<a href="#" data-toggle="dropdown" class="dropdown-toggle">
					Type: <em>{{$type}}</em> <span class="caret"></span>
				</a>
				<ul class="dropdown-menu">
					<li><a href="{{$type_link}}&type=all" class="filter-type">All</a></li>
					<li><a href="{{$type_link}}&type=twitter" class="filter-type">Twitter</a></li>
					<li><a href="{{$type_link}}&type=instagram" class="filter-type">Instagram</a></li>
					<li><a href="{{$type_link}}&type=facebook" class="filter-type">Facebook</a></li>
				</ul>
			</li>
			<li class="dropdown">
				<a href="#" data-toggle="dropdown" class="dropdown-toggle">
					Status: <em>{{$status}}</em> <span class="caret"></span>
				</a>
				<ul class="dropdown-menu">
					<li><a href="{{$status_link}}&status=all" class="filter-type">All</a></li>
					<li><a href="{{$status_link}}&status=unmoderated" class="filter-type">Unmoderated</a></li>
					<li><a href="{{$status_link}}&status=approved" class="filter-type">Approved</a></li>
				</ul>
			</li>
		</ul>
	</div><!-- post-filters -->

</section><!-- .panel-side -->

<section class="panel-body">

	<!-- Post Feed -->
	<div class="admin-posts">

		@if(count($posts) < 1)
		<div class="alert alert-danger">No Posts Found.</div>
		@endif

		<div class="scroll">

		<ul id="postfeed" class="postfeed">
		@foreach($posts as $post)
			
			<?php 
				$date = date('D, M jS Y - g:i a', strtotime($post['datetime'])); 
				$postdate = date('D, M jS y - g:i a', strtotime($post['post']['created_at']));
				$post_type = ( isset($post['twitter_id']) ) ? 'twitter' : 'instagram';
			?>
			
			@if(isset($post['twitter_id']))
				@include('admin.partials.tweet')
			@elseif(isset($post['instagram_id']))
				@include('admin.partials.gram')
			@else
				@include('admin.partials.fbpost')
			@endif

		@endforeach
		</ul>

		{{$posts->links()}}

		</div><!-- .scroll -->
	</div><!-- .admin-posts -->

</section><!-- .panel-body -->
@stop

@section('footercontent')
<script src="{{URL::asset('assets/js/imagesloaded.pkgd.min.js')}}"></script>
<script src="{{URL::asset('assets/js/masonry.pkgd.min.js')}}"></script>

@include('admin.modals.modal-help-twitter')
@include('admin.modals.modal-help-instagram')

<script>

/**
* Initialize masonry on posts container
*/
$(document).ready(function(){
	loadMasonry();
});
function loadMasonry()
{
	var $container = $('#postfeed').masonry();
	$container.imagesLoaded( function() {
		$container.masonry();
	});
	
}

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
				$('#postfeed').masonry( 'remove', item );
				$('#postfeed').masonry();
				getPending();
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
			console.log(data);
			$('#import-loading').hide();
			$('.run-import').removeClass('disabled');
			$('.run-import').find('.text').html('<i class="icon-admin-loop2"></i> Run Import')
			if ( data.status == 'success' ){
				if ( data.import_count === 0 ){
					$('#import-alert').text('There were no new items to import').show();
				} else {
					window.location.reload();
				}
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
			$(item).addClass('approved');
			$(item).find('.status').remove();
			addApprovedStatus(id, item, type, data);
			$('#postfeed').masonry();
			getPending();
		}
	});
}

/**
* Add Approved Status to newly approved post
*/
function addApprovedStatus(id, item, type, post)
{
	var out = '<div class="status-approved"><p><i class="icon-admin-checkmark"></i> Approved ' + post.approval_date + ' by ' + post.firstname + ' ' + post.lastname + '</p><a href="#" class="remove-approved" data-id="' + id + '" data-type="' + type + '" data-postid="' + post.postid + '">Unapprove and Trash</a></div>';
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
				$('#postfeed').masonry( 'remove', item );
				$('#postfeed').masonry();
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
				getPending();
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
	var out = '<li class="tweet post"><div class="content"><div class="avatar"><img src="' + tweet.profile_image + '" alt="user icon"></div><div class="main"><ul class="info"><li><a href="https://twitter.com/' + tweet.screen_name + '/status/' + id + '" target="_blank"><i class="icon-admin-twitter"></i></a></li><li>' + tweet.retweet_count + ' <i class="icon-admin-loop"></i></li><li>' + tweet.favorite_count + ' <i class="icon-admin-star"></i></li></ul><strong><a href="http://twitter.com/' + tweet.screen_name + '" target="_blank">' + tweet.screen_name + '</a></strong><span class="date">DATE HERE</span><p>' + tweet.text + '</p>';
	if ( tweet.image ){
		out += '<div class="image"><img src="/assets/uploads/twitter_images/' + tweet.image + '" /></div>';
	}
	out += '</div></div><div class="status"><ul><li><a href="#" class="remove" data-id="' + id + '" data-type="twitter"><i class="icon-admin-remove"></i> Trash</a></li><li><a href="#" class="approve" data-id="' + id + '" data-type="twitter"><i class="icon-admin-checkmark"></i> Approve</a></li></ul></div></li>';
	$('#postfeed').prepend(out);
	$('#postfeed').masonry();
}

/**
* Add a new imported gram to the feed
*/
function addNewGram(gram, id)
{
	var out = '<li class="gram post"><div class="content"><div class="avatar"><img src="' + gram.profile_image + '" alt="user icon"></div><div class="main"><ul class="info"><li><a href="' + gram.link + '" target="_blank"><i class="icon-admin-instagram"></i></a></li><li>' + gram.like_count +' <i class="icon-admin-heart"></i></li></ul><strong><a href="http://instagram.com/' + gram.screen_name + '" target="_blank">' + gram.screen_name + '</a></strong><span class="date">DATE HERE</span>';
	if ( gram.text ){
		out += '<p>' + gram.text + '</p>';
	}
	if ( gram.type === 'image' ){
		out += '<div class="image"><img src="' + gram.image + '" /></div>';
	} else {
		out += '<video width="480" height="480" controls><source src="' + gram.video_url + '" type="video/mp4"/></video>';
	}
	out += '</div><div class="status"><ul><li><a href="#" class="remove" data-id="' + gram.id + '" data-type="instagram"><i class="icon-admin-remove"></i> Trash</a></li><li><a href="#" class="approve" data-id="' + gram.id + '" data-type="instagram"><i class="icon-admin-checkmark"></i> Approve</a></li></ul></div></div></li>';
	$('#postfeed').prepend(out);
	$('#postfeed').masonry();
}

/**
* Add a user to the banned list
*/
function banUser(user, type, id, item)
{
	$.ajax({
		url: '{{URL::route('admin.ban.store')}}',
		method: 'POST',
		data: {
			id: user,
			type: type
		},
		success: function(data){
			$(item).removeAttr('href');
			removeBanned(id, type, user);
			getPending();
		}
	});
}

/**
* Remove all posts by a banned user & put them in the trash
*/
function removeBanned(id, type, user)
{
	trashBanned(type, user)
	$('.ban-user').each(function(){
		if ( $(this).data('user') === user ){
			var item = $(this).parents('.post');
			$('#postfeed').masonry( 'remove', item );
			$('#postfeed').masonry();
		}
	});
}

/**
* Trash all posts by banned user
*/
function trashBanned(type, user)
{
	$.ajax({
		url: '{{URL::route('trash_banned')}}',
		method: 'POST',
		data: {
			type: type,
			user: user
		},
		success: function(data){
			console.log(data);
		}
	});
}

/**
* Update the pending count on approval of post
*/
function getPending()
{
	$.ajax({
		url: '{{URL::route('pending_count')}}',
		method: 'GET',
		success: function(data){
			$('#pending_count').text(data);
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
	$(this).addClass('disabled');
	$(this).find('.text').text('Importing...');
	doImport();
});

// Import Single Button
$(document).on('click', '.import-single', function(e){
	e.preventDefault();
	$(this).attr('disabled', 'disabled');
	$('#single-error, #single-success').hide();
	var type = $('select[name="social-type"]').val();
	var id = $('.social-id').val();
	importSingle(type, id);
});

// Update single import label & help modal on change
$(document).on('change', 'select[name="social-type"]', function(){
	var text = ( $('select[name="social-type"]').val() === 'twitter' ) ? 'Tweet ID' : 'Instagram ID';
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

// Ban a user & trash all their posts
$(document).on('click', 'a.ban-user', function(e){
	e.preventDefault();
	var user = $(this).data('user');
	var type = $(this).data('type');
	var id = $(this).data('id');
	var item = $(this);
	banUser(user, type, id, item);
});

</script>

@if($num_posts > 4)
<script>
// Infinite Scroll
$(function() {	
	/**
	* Infinite Scroll
	*/
	$('#postfeed').infinitescroll({
		navSelector  : '.pagination',
		nextSelector : '.pagination li:last-child a',
	  	itemSelector : '.post',
		extraScrollPx: 0,
	  	loading: {
			finishedMsg: undefined,
			img: null,
		}
	},
	// trigger Masonry as a callback
	function( newElements ){
		var $newElems = $( newElements ).css({ opacity: 0 });
		$newElems.imagesLoaded(function(){
			$newElems.animate({ opacity: 1 });
			$('#postfeed').masonry( 'appended', $newElems, true ); 
		});
	});
});
</script>
@endif
@stop