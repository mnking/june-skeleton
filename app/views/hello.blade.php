<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>June CMS</title>
    {{ HTML::getBootstrap() }}
	<style>

		body {
			margin:0;
			font-family:sans-serif;
			text-align:center;
		}

		.welcome {
            margin: 200px auto;
		}

	</style>
</head>
<body>
	<div class="welcome">
		<a href="#" title="June CMS"><img src="{{ June::asset('june.png') }}" alt="June CMS"></a>
		<h1><label class="label label-default">Hello. I'm June</label></h1>
	</div>
    {{ HTML::getJquery() }}
    {{ HTML::getBootstrap('script') }}
</body>
</html>
