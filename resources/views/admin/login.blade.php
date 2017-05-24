<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="description" content="" />
	<meta name="keywords" content="" />
	<title>Own Admin</title>

	<link href="https://fonts.googleapis.com/css?family=Ubuntu" rel="stylesheet">
	<link rel="stylesheet" href="{{ URL::asset('css/reset.css') }}">
	<link rel="stylesheet" href="{{ URL::asset('css/admin.css') }}">

</head>
<body>

<div class="login-wrap">
	<div class="login-container">
		<form action="{{ route('login-as-admin') }}" method="POST" target="_self">
			<input name="_token" type="hidden" value="{{ csrf_token() }}">
			<div><input name="email" type="email" required="required" placeholder="Login&hellip;"></div>
			<div><input name="password" type="password" required="required" placeholder="Password&hellip;"></div>
			<div><button name="submit" type="submit">Enter Admin</button></div>
		</form>
	</div>
</div>

</body>
</html>