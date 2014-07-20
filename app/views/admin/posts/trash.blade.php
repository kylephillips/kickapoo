@extends('admin.partials.admin-master')
@section('content')
<div class="container small">
	<h1><i class="icon-remove"></i> Trash <span class="pull-right"><a href="{{URL::route('admin.post.index')}}">&laquo; Back to Posts</a></span></h1>
	<div class="alert alert-info">
		Last emptied: {{$last_trash}}
		<button class="btn btn-danger pull-right"><i class="icon-remove2"></i> Empty Trash</button>
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
						<li><a href="#" class="approve" data-id="{{$post['twitter_id']}}" data-type="{{$post_type}}"><i class="icon-checkmark"></i> Restore</a></li>
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
							<li><a href="#" class="approve" data-id="{{$post['instagram_id']}}" data-type="{{$post_type}}"><i class="icon-checkmark"></i> Restore</a></li>
						</ul>
					</div>
				@endif
		@endforeach
		</ul>
	</div><!-- .container -->
@endif
@stop