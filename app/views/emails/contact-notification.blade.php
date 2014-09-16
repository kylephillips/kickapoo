<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Kickapoo Website Notification</title>   
</head>
<body style="margin: 0;padding: 0;">
	<table width="100%" cellpadding="0" cellspacing="0" style="padding-top:30px;">
		<tr><td>

			<table id="main" width="600" align="center" cellpadding="0" cellspacing="0" bgcolor="ffffff" style="border:1px solid #ccc;margin-bottom:10px;">
				<tr>
					<td style="background-color:#006c23; text-align:center; border-bottom:3px solid #ccc; padding:10px 0;">
						<img src="{{$logo}}" style="width:150px;">
					</td>
				</tr>
				<tr>
					<td>
						<h2 style="font-family: Arial, Helvetica, sans-serif; line-height: 1.4; margin: 0px 0 10px 0; background-color:#ebebec; padding: 10px; text-align:center; font-size:18px; color:#00581c;">Kickapoo Contact Form Notification</h2>
					</td>
				</tr>
				<tr>
					<td style="padding:20px;">
						<h4 style="font-family: Arial, Helvetica, sans-serif; line-height: 1.4; margin: 0px 0 20px 0; background-color:#d9edf7; font-size:16px; color:#31708f; font-weight:normal; padding:8px; border:1px solid #bce8f1;">The following form was submitted on the kickapoo website:</h4>
						<p style="font-family: Arial, Helvetica, sans-serif; line-height: 1.4; margin: 0px 0 10px 0; border-bottom:1px solid #ebebec; padding-bottom:10px;"><strong>From: </strong>{{$name}}</p>
						<p style="font-family: Arial, Helvetica, sans-serif; line-height: 1.4; margin: 0px 0 10px 0; border-bottom:1px solid #ebebec; padding-bottom:10px;"><strong>Email: </strong><a href="mailto:{{$email}}" style="color:#00581c; text-decoration:none;">{{$email}}</a></p>
						<p style="font-family: Arial, Helvetica, sans-serif; line-height: 1.4; margin: 0px 0 10px 0;"><strong>Message: </strong><br />{{$user_message}}</p>
						<p style="font-family: Arial, Helvetica, sans-serif; line-height: 1.4; margin: 0px 0 10px 0;"><strong>Opt-In to Email: </strong><br />{{$opt_in}}</p>
					</td>
				</tr>
			</table>

			<table width="600" cellpadding="0" cellspacing="0" align="center">
				<tr>
					<td>
						<p style="font-family: Arial, Helvetica, sans-serif; line-height: 1.4; font-size:15px;">This email was generated and sent from <a href="http://drinkkickapoo.com" style="color:#00581c; text-decoration:none;">drinkkickapoo.com</a>. Crafted by your friends at <a href="http://object9.com" style="color:#00581c; text-decoration:none;">Object 9</a>.</p>
					</td>
				</tr>
			</table>

		</td></tr>
	</table>
</body>
</html>
