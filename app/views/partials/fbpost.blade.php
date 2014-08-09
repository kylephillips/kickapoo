<section class="user-info">
	<img src="{{$post->fbpost->profile_image}}" alt="{{$post->fbpost->screen_name}}'s Profile Image" onerror="this.src='{{URL::asset('assets/images/avatar-default.png')}}'" />
	<p>{{$post->fbpost->screen_name}}</p>
	<span>
		<i class="icon-facebook"></i>
	</span>
</section>
<section class="content">

	@if($post->fbpost->message)
		<p>{{$post->fbpost->message}}</p>
	@endif

	@if($post->fbpost->story)
		<p>{{$post->fbpost->story}}</p>
	@endif

	@if( $post->fbpost->caption || $post->fbpost->caption_description )
		<div class="facebook-caption">
			@if($post->fbpost->caption_image && !$post->fbpost->image)
				<img src="{{URL::asset('assets/uploads/facebook_images')}}/{{$post->fbpost->caption_image}}" >
				<section class="caption-text">
			@endif
			@if($post->fbpost->caption_title)
				<strong>{{$post->fbpost->caption_title}}</strong><br />
			@endif
			@if($post->fbpost->caption_description)
				{{$post->fbpost->caption_description}}<br/>
			@endif
			@if($post->fbpost->caption)
				<span>{{$post->fbpost->caption}}</span>
			@endif
			@if($post->fbpost->caption_image && !$post->fbpost->image)
				</section>
			@endif
		</div>
	@endif

</section>
@if($post->fbpost->image)
<section class="image">
	<img src="/assets/uploads/facebook_images/{{$post->fbpost->image}}" />
</section>
@endif