@if(isset($translations))
	<nav class="language-select dropdown">
		<a href="#" class="dropdown-toggle" data-toggle="dropdown">{{ LaravelLocalization::getCurrentLocaleName() }} 
			<span class="caret"></span>
		</a>
		
		<ul class="dropdown-menu pull-right" role="menu">
			@foreach($translations as $localeCode => $data)
			<li>
				<?php 
					$route = ( Route::currentRouteName() == 'home' ) ? URL::route('home') : URL::route('page', ['page'=>$data['slug']]); 
					$link = LaravelLocalization::getLocalizedURL($localeCode, $route);
				?>
				<a rel="alternate" hreflang="{{$localeCode}}" href="{{$link}}">
					{{$data['native']}}
				</a>
			</li>
			@endforeach
		</ul>
	</nav>
	@endif