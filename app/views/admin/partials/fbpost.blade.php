<li class="fbpost post @if($post['approved'] == 1)approved @endif">
	<div class="content">
		<div class="avatar">
			<img src="{{$post['profile_image']}}" alt="user icon">
		</div>
		<div class="main">
			@if(isset($post['link']))
			<ul class="info">
				<li><a href="{{$post['link']}}" target="_blank"><i class="icon-facebook"></i></a></li>
			</ul>
			@endif
			
		</div>
	</div>
</li>