<li class="gram post @if($post['approved'] == 1)approved @endif">
	<div class="content">
		<div class="avatar">
			<img src="{{$post['profile_image']}}" alt="user icon">
		</div>
		
		<div class="main">
			<ul class="info">
				<li><a href="{{$post['link']}}" target="_blank"><i class="icon-admin-instagram"></i></a></li>
			</ul>
			<strong><a href="http://instagram.com/{{$post['screen_name']}}" target="_blank">{{$post['screen_name']}}</a></strong>
			&nbsp;|&nbsp;
			@if($post['banned'])
				<span class="ban-user banned">Banned</span>
			@else
				<a href="#" class="ban-user" data-user="{{$post['screen_name']}}" data-type="instagram" data-id="{{$post['instagram_id']}}">Ban</a>
			@endif
			<span class="date">{{$date}}</span>
		</div>

		<div class="post-content">
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

		@if(isset($trash))
			
			<div class="status">
				<ul>
					<li><a href="#" class="remove" data-id="{{$post['instagram_id']}}" data-type="{{$post_type}}"><i class="icon-admin-remove"></i> Remove Permanently</a></li>
					<li><a href="#" class="restore" data-id="{{$post['instagram_id']}}" data-type="{{$post_type}}"><i class="icon-admin-checkmark"></i> Restore</a></li>
				</ul>
			</div>

		@else
			
			@if($post['approved'] == 1)
			<div class="status-approved">
				<p><i class="icon-admin-checkmark"></i> Approved {{$postdate}} by {{$post['post']['user']['first_name']}} {{$post['post']['user']['last_name']}}</p>
				<a href="#" class="remove-approved" data-id="{{$post['instagram_id']}}" data-type="{{$post_type}}" data-postid="{{$post['post']['id']}}">Unapprove and Trash</a>
			</div>
			@else
			<div class="status">
				<ul>
					<li><a href="#" class="remove" data-id="{{$post['instagram_id']}}" data-type="{{$post_type}}"><i class="icon-admin-remove"></i> Trash</a></li>
					<li><a href="#" class="approve" data-id="{{$post['instagram_id']}}" data-type="{{$post_type}}"><i class="icon-admin-checkmark"></i> Approve</a></li>
				</ul>
			</div>
			@endif
			
		@endif
	</div><!-- .content -->
</li>