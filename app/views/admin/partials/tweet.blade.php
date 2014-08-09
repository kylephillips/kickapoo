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
			&nbsp;&nbsp;|&nbsp;&nbsp;
			@if($post['banned'])
				<span class="ban-user banned">Banned</span>
			@else
				<a href="#" class="ban-user" data-user="{{$post['screen_name']}}" data-type="twitter" data-id="{{$post['twitter_id']}}">Ban this User</a>
			@endif
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
		<p><i class="icon-checkmark"></i> Approved {{$postdate}} by {{$postdate}} by {{$post['post']['user']['first_name']}} {{$post['post']['user']['last_name']}}
</p>
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