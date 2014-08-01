<footer>
	<section>
		<a href="{{URL::route('home')}}" class="logo"><img src="{{URL::asset('assets/images/kickapoo-joy-juice-logo.png')}}" alt="Kickapoo Joy Juice Logo" /></a>

		<p>&copy;{{date('Y')}} Monarch Beverage Company</p>
	</section>

	<nav>
		<ul class="main">
			<li><a href="#">History</a></li>
			<li><a href="#">Products</a></li>
			<li><a href="#">Locate</a></li>
			<li><a href="#">Contact</a></li>
		</ul>

		<br />

		<ul class="social">
			@foreach($social_links as $link)
			@if( ($link->value_two != "") && ($link->value != "") )
			<li>
				<a href="{{$link->value}}" target="_blank"><i class="{{$link->value_two}}"></i></a></li>
			</li>
			@endif
			@endforeach
		</ul>
	</nav>
</footer>