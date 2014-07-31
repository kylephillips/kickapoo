<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8" />

	<title>Kickapoo Joy Juice</title>
	
	<link rel="icon" href="/favicon.ico">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	
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

</head>

<body>

	<nav class="mobile-nav">
		@include('partials.mobilenav')
	</nav>

	<div class="page-wrap">
		@include('partials.header')
		@yield('content')
	</div><!-- .page-wrap -->

	@include('partials.scripts')

	@yield('footercontent')

</body>
</html>