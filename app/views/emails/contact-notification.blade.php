<!DOCTYPE html>
<html lang="en-US">
	<head>
		<meta charset="utf-8">
	</head>
	<body>
		<h2>Kickapoo Contact Form</h2>
		<div>
			<h4>The following form was submitted on the kickapoo website:</h4>
			<p><strong>From: </strong>{{$name}}</p>
			<p><strong>Email: </strong><a href="mailto:{{$email}}">{{$email}}</a></p>
			<p><strong>Message: </strong><br />{{$user_message}}</p>
		</div>
	</body>
</html>
