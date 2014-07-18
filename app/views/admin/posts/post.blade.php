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

		<div class="alert alert-info">Last Import: {{$last_import}}</div>
	</div>

	<div class="container small admin-posts">
		<h3>Posts</h3>

		<ul id="postfeed">
		@foreach($posts as $post)
			<?php 
				$date = date('D, M jS Y - g:i a', strtotime($post['datetime'])); 
				$post_type = ( isset($post['twitter_id']) ) ? 'twitter' : 'instagram';
			?>
			
			@if(isset($post['twitter_id']))
			<li class="tweet">
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
				<div class="status">
					<ul>
						<li><a href="#" class="remove" data-id="{{$post['id']}}" data-type="{{$post_type}}"><i class="icon-close"></i> Delete</a></li>
						<li><a href="#" class="approve" data-id="{{$post['id']}}" data-type="{{$post_type}}"><i class="icon-checkmark"></i> Approve</a></li>
					</ul>
				</div>
			</li>
			
			@else
			<li class="gram">
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
				</div><!-- .content -->
				<div class="status">
					<ul>
						<li><a href="#" class="remove" data-id="{{$post['id']}}" data-type="{{$post_type}}"><i class="icon-close"></i> Delete</a></li>
						<li><a href="#" class="approve" data-id="{{$post['id']}}" data-type="{{$post_type}}"><i class="icon-checkmark"></i> Approve</a></li>
					</ul>
				</div>
			</li>
			@endif

		@endforeach
		</ul>

		<?php echo $posts->links(); ?>

	</div>
@stop

@section('footercontent')
<script>

function removePost(id, type)
{
	$.ajax({
		url: '{{URL::route('remove_post')}}',
		data: {
			id: id,
			type: type
		},
		success: function(data){
			console.log(data);
		}
	});
}

$(document).on('click', '.remove', function(e){
	e.preventDefault();
	var id = $(this).data('id');
	var type = $(this).data('type');
	removePost(id, type);
});

$(document).on('click', '.approve', function(e){
	e.preventDefault();
});

</script>
@stop