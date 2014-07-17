<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8" />

	<title>Kickapoo Admin</title>
	
	<link rel="icon" href="/favicon.ico">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	
	<link rel="stylesheet" href="{{URL::asset('css/styles.css')}}">
	<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">

</head>

<body>

	@yield('content')

	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
	<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
	@yield('footercontent')
</body>
</html>