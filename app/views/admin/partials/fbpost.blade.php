<li class="fbpost post @if($post['approved'] == 1)approved @endif">
	<div class="content">
		<div class="avatar">
			<img src="{{$post['profile_image']}}" alt="user icon">
		</div>
		<div class="main">
			@if(isset($post['link']))
			<ul class="info">
				<li><a href="{{$post['link']}}" target="_blank"><i class="icon-twitter"></i></a></li>
			</ul>
			@endif
			<strong>{{$post['screen_name']}}</strong>
			
			@if($post['type'] == 'link')
			shared a <a href="{{$post['link']}}" target="_blank">link</a>
			@endif

			@if($post['type'] == 'status')
			posted a status update
			@endif
			
			<span class="date">{{$date}}</span>
			
			@if($post['message'])
				<p>{{$post['message']}}</p>
			@endif

			@if($post['story'])
				<p>{{$post['story']}}</p>
			@endif

			@if( $post['caption'] || $post['caption_image'] || $post['caption_description'] )
				<div class="fb-caption">
					@if($post['caption_image'] && !$post['image'])
						<img src="{{URL::asset('assets/uploads/facebook_images')}}/{{$post['caption_image']}}" >
						<section class="caption-text">
					@endif
					@if($post['caption_title'])
						<strong>{{$post['caption_title']}}</strong><br />
					@endif
					@if($post['caption_description'])
						{{$post['caption_description']}}<br/>
					@endif
					@if($post['caption'])
						<span>{{$post['caption']}}</span>
					@endif
					@if($post['caption_image'] && !$post['image'])
						</section>
					@endif
				</div>
			@endif

			@if($post['image'])
			<div class="image">
				<img src="/assets/uploads/facebook_images/{{$post['image']}}" />
			</div>
			@endif
		</div>
	</div><!-- .content -->

	@if(isset($trash))

		<div class="status">
			<ul>
				<li><a href="#" class="remove" data-id="{{$post['facebook_id']}}" data-type="facebook"><i class="icon-remove"></i> Remove Permanently</a></li>
				<li><a href="#" class="restore" data-id="{{$post['facebook_id']}}" data-type="facebook"><i class="icon-checkmark"></i> Restore</a></li>
			</ul>
		</div>

	@else

		@if($post['approved'] == 1)
		<div class="status-approved">
			<p><i class="icon-checkmark"></i> Approved {{$postdate}} by {{$postdate}} by {{$post['post']['user']['first_name']}} {{$post['post']['user']['last_name']}}
	</p>
			<a href="#" class="remove-approved" data-id="{{$post['facebook_id']}}" data-type="facebook" data-postid="{{$post['post']['id']}}">Unapprove and Trash</a>
		</div>
		@else
		<div class="status">
			<ul>
				<li><a href="#" class="remove" data-id="{{$post['facebook_id']}}" data-type="facebook"><i class="icon-remove"></i> Trash</a></li>
				<li><a href="#" class="approve" data-id="{{$post['facebook_id']}}" data-type="facebook"><i class="icon-checkmark"></i> Approve</a></li>
			</ul>
		</div>
		@endif

	@endif
</li>