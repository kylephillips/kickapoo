<footer>
	<section>
		<a href="{{URL::route('home')}}" class="logo"><img src="{{URL::asset('assets/images/kickapoo-joy-juice-logo.png')}}" alt="Kickapoo Joy Juice Logo" /></a>

		<p>&copy;{{date('Y')}} Monarch Beverage Company. 
			@if($media_page)
				@if ($media_page['status'] == 'publish')
				<a href="{{URL::route('page', ['slug'=>$media_page['slug']])}}">{{$media_page['title']}}</a></p>
				@endif
			@endif
	</section>

	<nav>
		<ul class="main">
			@foreach($page_navigation as $page)
			<li><a href="{{URL::route('page', ['page'=>$page->slug])}}">{{$page->title}}</a></li>
			@endforeach
		</ul>

		<br />

		<ul class="social">
			@foreach($social_links as $link)
			@if( ($link->value_two != "") && ($link->value != "") )
			<li>
				<a href="{{$link->value}}" target="_blank"><i class="{{$link->value_two}}"></i></a>
			</li>
			@endif
			@endforeach
		</ul>
	</nav>
</footer>