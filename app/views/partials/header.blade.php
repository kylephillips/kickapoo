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
			<li><a href="#"><i class="icon-twitter"></i></a></li>
			<li><a href="#"><i class="icon-instagram"></i></a></li>
			<li><a href="#"><i class="icon-youtube"></i></a></li>
			<li><a href="#"><i class="icon-facebook"></i></a></li>
		</ul>
	</nav>

	@if($store_link)
	<a href="{{$store_link}}" class="buy-button"><i class="icon-cart"></i> Buy Kickapoo</a>
	@endif

	<a href="#" class="nav-toggle"><i class="icon-menu"></i> Menu</a>

</header>