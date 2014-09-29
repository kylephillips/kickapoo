<a href="{{URL::route('home')}}" class="logo">
	<img src="{{URL::asset('assets/images/kickapoo-joy-juice-logo.png')}}" alt="Kickapoo Joy Juice Logo" />
</a>

@include('partials.language-select')

<ul class="nav">
	@foreach($page_navigation as $page)
	<li><a href="{{url('/')}}/{{$page->slug}}">{{$page->title}}</a></li>
	@endforeach
	@if($store_link)
	<li><a href="{{$store_link}}">Buy Kickapoo</a></li>
	@endif
</ul>

<ul class="social">
	@foreach($social_links as $link)
		@if( ($link->value_two != "") && ($link->value != "") )
			<li><a href="{{$link->value}}" target="_blank"><i class="{{$link->value_two}}"></i></a></li>
		@endif
	@endforeach
</ul>