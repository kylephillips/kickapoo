<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8" />

	<title>Kickapoo Admin</title>
	
	<link rel="icon" href="/favicon.ico">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	
	<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
	<link rel="stylesheet" href="{{URL::asset('assets/css/admin-temp.css')}}">

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

	@if(Auth::check())
	<style type="text/css">
	body {
		padding-top: 60px;
	}
	</style>
	@endif

</head>

<body>
	@if(Auth::check())
	@include('admin.partials.nav')
	@endif
	
	@yield('content')

	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
	<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>

	@yield('footercontent')
</body>
</html>