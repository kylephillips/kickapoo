<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Kickapoo Password Reset</title>   
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
					<td style="text-align:center; padding:20px;">
						<img src="{{$image}}" >
					</td>
				</tr>
				<tr>
					<td style="padding:20px;">
						<p style="font-family: Arial, Helvetica, sans-serif; line-height: 1.4; font-size:15px;">To reset your password, complete this form: {{ URL::to('password/reset', array($token)) }}.<br/>
			This link will expire in {{ Config::get('auth.reminder.expire', 60) }} minutes.</p>
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
