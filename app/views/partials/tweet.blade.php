<div class="user-info">
	<a href="http://twitter.com/{{$post->tweet->screen_name}}" target="_blank">
		<img src="{{$post->tweet->profile_image}}" alt="{{$post->tweet->screen_name}}'s Profile Image" onerror="this.src='{{URL::asset('assets/images/avatar-default.png')}}'" />
	</a>
	<p>
		<a href="http://twitter.com/{{$post->tweet->screen_name}}" target="_blank">
			{{$post->tweet->screen_name}}
		</a>
	</p>
	<span>
		<a href="http://twitter.com/{{$post->tweet->screen_name}}/status/{{$post->tweet->twitter_id}}" target="_blank"><i class="icon-twitter"></i></a>
	</span>
</div>
<div class="content">
	{{$post->tweet->text}}
</div>
@if($post->tweet->image)
<div class="image-margin">
	<img src="{{URL::asset('assets/uploads/twitter_images')}}/{{$post->tweet->image}}" alt="Twitter Image" />
</div>
@endif
<div class="twitter-links">
	<ul>
		<li><a href="https://twitter.com/intent/retweet?tweet_id={{$post->tweet->twitter_id}}"><i class="icon-loop"></i></a></li>
		<li><a href="https://twitter.com/intent/favorite?tweet_id={{$post->tweet->twitter_id}}"><i class="icon-star"></i></a></li>
		<li><a href="https://twitter.com/intent/tweet?in_reply_to={{$post->tweet->twitter_id}}"><i class="icon-redo"></i></a></li>
	</ul>
</div>