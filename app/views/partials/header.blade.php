<header>
	<a href="{{URL::route('home')}}" class="logo">
		<img src="{{URL::asset('assets/images/kickapoo-joy-juice-logo.png')}}" alt="Kickapoo Joy Juice Logo" />
	</a>
	
	<nav class="main-nav">
		<ul>
			<li><a href="#">History</a></li>
			<li><a href="#">Products</a></li>
			<li><a href="#">Locate</a></li>
			<li><a href="#">Contact</a></li>
		</ul>
	</nav>

	<nav class="social-links">
		<ul>
			@foreach($social_links as $link)
			@if( ($link->value_two != "") && ($link->value != "") )
			<li>
				<a href="{{$link->value}}" target="_blank"><i class="{{$link->value_two}}"></i></a></li>
			</li>
			@endif
			@endforeach
		</ul>
	</nav>

	@if($store_link)
	<a href="{{$store_link}}" class="buy-button" target="_blank"><i class="icon-cart"></i> Buy Kickapoo</a>
	@endif

	<a href="#" class="nav-toggle"><i class="icon-menu"></i> Menu</a>

</header>