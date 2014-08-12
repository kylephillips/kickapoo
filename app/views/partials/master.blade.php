<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8" />

	<title>Kickapoo Joy Juice @if($page['seo_title'])- {{$page['seo_title']}} @endif</title>

@if($page['seo_description'])
	<meta name="description" content="{{$page['seo_description']}}">
@endif

	<link rel="icon" href="/favicon.ico">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	
@if(Auth::check())
	<link rel="stylesheet" href="{{URL::asset('assets/css/admin/admin-styles.css')}}">
@endif
	
	<link rel="stylesheet" href="{{URL::asset('assets/css/styles.css')}}">

	<!--[if IE 8]>
		<link rel="stylesheet" type="text/css" href="/assets/css/ie8.css" />
	<![endif]-->

	<!--[if IE 7]>
		<link rel="stylesheet" type="text/css" href="/assets/css/ie7.css">
	<![endif]-->

	<!--[if lt IE 9]>
    	<script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script>
		<script>window.html5 || document.write('<script src="/assets/js/html5shiv.js"><\/script>')</script>
	<![endif]-->

	<script type="text/javascript" src="//use.typekit.net/yoo1qfa.js"></script>
	<script type="text/javascript">try{Typekit.load();}catch(e){}</script>
	<script src="{{URL::asset('assets/js/modernizr.js')}}"></script>

</head>

<body>

	@if(Auth::check())
		@include('admin.partials.nav')
	@endif

	@if( $page_slug == 'home' )
	<img src="{{URL::asset('assets/images/preloader.png')}}" class="preloader">
	<div class="page loading">
	@endif

	<nav class="mobile-nav">
		@include('partials.mobilenav')
	</nav>

	<div class="page-wrap">
		@if( $page_slug == 'home' )
		<section class="home-hero">
		@endif

		@include('partials.header')
		
		@yield('content')
		
		@include('partials.footer')
	</div><!-- .page-wrap -->

	@include('partials.scripts')
	
	@if(Auth::check())
		<script src="{{URL::asset('assets/js/bootstrap.min.js')}}"></script>
		<script>
		$('.admin-nav-toggle').on('click', function(e){
			e.preventDefault();
			$('.nav').toggle();
		});
		</script>
	@endif

	@yield('footercontent')

	@if( $page_slug == 'home' )
	</div><!-- .page -->
	@endif

</body>
</html>