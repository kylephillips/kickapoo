<section class="user-info">
	<a href="http://twitter.com/{{$post->tweet->screen_name}}" target="_blank">
		<img src="{{$post->tweet->profile_image}}" alt="{{$post->tweet->screen_name}}'s Profile Image" />
	</a>
	<p>
		<a href="http://twitter.com/{{$post->tweet->screen_name}}" target="_blank">
			{{$post->tweet->screen_name}}
		</a>
	</p>
	<span>
		<a href="http://twitter.com/{{$post->tweet->screen_name}}/status/{{$post->tweet->twitter_id}}" target="_blank"><i class="icon-twitter"></i></a>
	</span>
</section>
<section class="content">
	{{$post->tweet->text}}
</section>
@if($post->tweet->image)
<section class="image-margin">
	<img src="{{URL::asset('assets/uploads/twitter_images')}}/{{$post->tweet->image}}" />
</section>
@endif
<section class="twitter-links">
	<ul>
		<li><a href="https://twitter.com/intent/retweet?tweet_id={{$post->tweet->twitter_id}}"><i class="icon-loop"></i></a></li>
		<li><a href="https://twitter.com/intent/favorite?tweet_id={{$post->tweet->twitter_id}}"><i class="icon-star"></i></a></li>
		<li><a href="https://twitter.com/intent/tweet?in_reply_to={{$post->tweet->twitter_id}}"><i class="icon-redo"></i></a></li>
	</ul>
</section>