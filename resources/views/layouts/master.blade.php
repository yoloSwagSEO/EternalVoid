<!DOCTYPE html>
<html lang="{{ Config::get('app.locale') }}">
	<head>
		<meta charset="UTF-8">
		<title>Eternal Void :: @yield('pagetitle')</title>
		{!! HTML::style('http://fonts.googleapis.com/css?family=Roboto:900,700,400,500,300,100|Roboto+Condensed:400,300,700') !!}
		{!! HTML::style('css/font-awesome.min.css') !!}
		{!! HTML::style('css/bootstrap.min.css') !!}
		{!! HTML::style('css/bootstrap-theme.min.css') !!}
		{!! HTML::style('css/helpers.min.css') !!}
		{!! HTML::style('css/eternalvoid.css') !!}
		@yield('pagecss')

	</head>
	<body>
		<div class="container">
			<h1><a href="/"><span>eternalvoid.de</span></a></h1>
			<nav>
				<ul>
					<li><a href="/">Entwickler-Blog</a></li>
					<li><a href="/earlyaccess">Early Access</a></li>
					<li><a href="/screenshots">Screenshots</a></li>
					<li><a href="/projektstatus">Projektstatus</a></li>
				</ul>
			</nav>
			<div class="wrapper">
				<div class="wrapper_top"></div>
				<div class="wrapper_inner">
					@yield('content')

				</div>
				<div class="wrapper_btm"></div>
			</div>
		</div>
		{!! HTML::script('js/jquery.js') !!}
		{!! HTML::script('js/bootstrap.min.js') !!}
		{!! HTML::script('js/main/eternalvoid.js') !!}
		@yield('pagejs')

	</body>
</html>