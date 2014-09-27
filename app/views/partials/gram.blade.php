<div class="user-info">
	<a href="http://instagram.com/{{$post->gram->screen_name}}" target="_blank">
		<img src="{{$post->gram->profile_image}}" alt="{{$post->gram->screen_name}}'s Profile Image" onerror="this.src='{{URL::asset('assets/images/avatar-default.png')}}'" />
	</a>
	<p>
		<a href="http://instagram.com/{{$post->gram->screen_name}}" target="_blank">
			{{$post->gram->screen_name}}
		</a>
	</p>
	<span>
		<a href="{{$post->gram->link}}" target="_blank"><i class="icon-instagram"></i></a>
	</span>
</div>
<div class="content">
	{{$post->gram->text}}
</div>
<div class="image">
	@if($post->gram->type == 'image')
	<a href="{{$post->gram->link}}" target="_blank">
		<img src="{{URL::asset('assets/uploads/instagram_images')}}/{{$post->gram->image}}" alt="Instagram Image" />
	</a>
	@else
	<video width="100%" controls>
		<source src="{{$post->gram->video_url}}" type="video/mp4"/>
	</video>
	@endif
</div>