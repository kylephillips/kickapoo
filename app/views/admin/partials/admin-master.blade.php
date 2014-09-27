<!DOCTYPE html>
<html lang="en-US">
<head>
	<meta charset="UTF-8" />

	<title>Kickapoo Admin</title>
	
	<link rel="icon" href="/favicon.ico">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	
	<link rel="stylesheet" href="{{URL::asset('assets/css/admin/redactor.css')}}">
	<link rel="stylesheet" href="{{URL::asset('assets/css/admin/admin-styles.css')}}">

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
	<div class="pagewrap">

	@if(Auth::check())
	@include('admin.partials.nav')
	@endif

	@yield('content')

	@include('admin.partials.footer')
	</div><!-- .pagewrap -->

	<script>
		var urls = {
			'editor_upload' : "{{URL::route('editor_upload')}}",
			'editor_styles' : "{{URL::asset('assets/css/editor-styles.css')}}",
			'media_library_route' : "{{URL::route('media_library')}}",
			'media_library_upload' : "{{URL::route('media_library_upload')}}",
			'site_index' : "{{URL::route('home')}}"
		}
	</script>

	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
	<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.1/jquery-ui.min.js"></script>
	<script src="{{URL::asset('assets/js/bootstrap.min.js')}}"></script>
	<script src="{{URL::asset('assets/js/jquery.jscroll.min.js')}}"></script>
	<script src="{{URL::asset('assets/js/dropzone.min.js')}}"></script>
	<script src="{{URL::asset('assets/js/admin-scripts.js')}}"></script>
	<script src="{{URL::asset('assets/js/admin-media-library.js')}}"></script>
	<script src="{{URL::asset('assets/js/redactor.min.js')}}"></script>
	
	@include('admin.partials.media-library')
	
	@yield('footercontent')
	<script>
	$(window).load(function(){
		function hideFlash(){
			$('.flash-message').addClass('moveup');
		}
		window.setTimeout(hideFlash, 5000);
	});

	$('.admin-nav-toggle').on('click', function(e){
		e.preventDefault();
		$('.nav').toggle();
	});
	</script>
</body>
</html>