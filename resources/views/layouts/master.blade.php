<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<title>Eternal Void :: @yield('pagetitle')</title>
		{!! HTML::style('http://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900') !!}
		{!! HTML::style('css/bootstrap.min.css') !!}
		{!! HTML::style('css/bootstrap-theme.min.css') !!}
		{!! HTML::style('css/font-awesome.min.css') !!}
		@yield('pagecss')

	</head>
	<body>
		<div class="container-fluid">
			@yield('content')

		</div>
		{!! HTML::script('js/jquery.js') !!}
		{!! HTML::script('js/bootstrap.min.js') !!}
		@yield('pagejs')

	</body>
</html>