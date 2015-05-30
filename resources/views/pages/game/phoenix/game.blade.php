<!DOCTYPE html>
<html lang="{{ Config::get('app.locale') }}">
	<head>
		<meta charset="UTF-8">
		<title>Eternal Void &raquo; {{ $game['name'] }}</title>
		{!! HTML::style('http://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900%7CRoboto+Condensed:400,300,700') !!}
		{!! HTML::style('css/font-awesome.min.css') !!}
		{!! HTML::style('css/bootstrap.min.css') !!}
		{!! HTML::style('css/bootstrap-theme.min.css') !!}
		{!! HTML::style('css/helpers.min.css') !!}
		{!! HTML::style('css/'.Session::get('universe').'/'.Session::get('universe').'-default.css') !!}
		@yield('pagecss')

	</head>
	<body>
		<div class="container-fluid trow posfix t0 zi1000">
			<div class="row">
				<div class="col-lg-12 col-md-12 col-sm-12 col-sm-12">
					<dl class="dl-horizontal dl-o pull-left mt10 mb10 f16">
						<dt>Universum:</dt>
						<dd>{{ $game['name'] }}</dd>
						<dt>Speed:</dt>
						<dd id="gamespeed" data-speed="{{ $game['speed'] }}">{{ $game['speed'] }}x</dd>
						<dt>Spieler online:</dt>

						<dt>Letzte Aktion:</dt>
						<dd id="time" data-lastupdate="{{ $planet->lastupdate_at }}" data-servertime="{{ time() }}">{{ date("H:i:s", $planet->lastupdate_at) }}</dd>
					</dl>
					<h1 class="text-center w50 acenter pt15">{{ Crypt::decrypt($planet->planetname) }}</h1>
				</div>
				<div class="col-lg-12 col-md-12 col-sm-12 col-sm-12 p0">
					<div class="btn-group btn-group-sm btn-group-justified btn-group-top">
						<a href="/planet" class="btn btn-default" data-toggle="popover" data-placement="bottom" data-content="Planet">
							<i class="fa fa-home fa-lg"></i>
							<span class="visible-lg">Planet</span>
						</a>
						<a href="/account" class="btn btn-default" data-toggle="popover" data-placement="bottom" data-content="Account">
							<i class="fa fa-user fa-lg"></i>
							<span class="visible-lg">Account</span>
						</a>
						<a href="/alliance" class="btn btn-default" data-toggle="popover" data-placement="bottom" data-content="Allianz">
							<i class="fa fa-group fa-lg"></i>
							<span class="visible-lg">Allianz</span>
						</a>
						<a href="/buildings" class="btn btn-default" data-toggle="popover" data-placement="bottom" data-content="Bauen">
							<i class="fa fa-wrench fa-lg"></i>
							<span class="visible-lg">Bauen</span>
						</a>
						<a href="/research" class="btn btn-default" data-toggle="popover" data-placement="bottom" data-content="Forschen">
							<i class="fa fa-flask fa-lg"></i>
							<span class="visible-lg">Forschen</span>
						</a>
						<a href="/shipyard" class="btn btn-default" data-toggle="popover" data-placement="bottom" data-content="Schiffswerft">
							<i class="fa fa-rocket fa-lg"></i>
							<span class="visible-lg">Schiffswerft</span>
						</a>
						<a href="/spaceport" class="btn btn-default" data-toggle="popover" data-placement="bottom" data-content="Raumhafen">
							<i class="fa fa-anchor fa-lg"></i>
							<span class="visible-lg">Raumhafen</span>
						</a>
						<a href="/defense" class="btn btn-default" data-toggle="popover" data-placement="bottom" data-content="Verteidigung">
							<i class="fa fa-shield fa-lg pt2"></i>
							<span class="visible-lg">Verteidigung</span>
						</a>
						<a href="/exchange" class="btn btn-default" data-toggle="popover" data-placement="bottom" data-content="Handelsbörse">
							<i class="fa fa-dollar fa-lg"></i>
							<span class="visible-lg">Handelsbörse</span>
						</a>
						<a href="/shiptrade" class="btn btn-default" data-toggle="popover" data-placement="bottom" data-content="Schiffsbörse">
							<i class="fa fa-plane fa-lg pt1"></i>
							<span class="visible-lg">Schiffsbörse</span>
						</a>
						<a href="/fleetcommand" class="btn btn-default" data-toggle="popover" data-placement="bottom" data-content="Kommando">
							<i class="fa fa-sitemap fa-lg"></i>
							<span class="visible-lg">Kommando</span>
						</a>
						<a href="/fleets" class="btn btn-default" data-toggle="popover" data-placement="bottom" data-content="Flotten">
							<i class="fa fa-space-shuttle fa-lg"></i>
							<span class="visible-lg">Flotten</span>
						</a>
						<a href="/galaxy" class="btn btn-default" data-toggle="popover" data-placement="bottom" data-content="Galaxie">
							<i class="fa fa-globe fa-lg"></i>
							<span class="visible-lg">Galaxie</span>
						</a>
						<a href="/resources" class="btn btn-default" data-toggle="popover" data-placement="bottom" data-content="Ressourcen">
							<i class="fa fa-cogs fa-lg"></i>
							<span class="visible-lg">Ressourcen</span>
						</a>
						<a href="/technology" class="btn btn-default" data-toggle="popover" data-placement="left" data-content="Technologie">
							<i class="fa fa-code-fork fa-lg"></i>
							<span class="visible-lg">Technologie</span>
						</a>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="resources pt0">
					<table class="f16 ttu w100">
						<tr>
							<th class="text-center w12">Aluminium</th>
							<th class="text-center w12">Titan</th>
							<th class="text-center w12">Silizium</th>
							<th class="text-center w12">Arsen</th>
							<th class="text-center w12">Wasserstoff</th>
							<th class="text-center w12">Antimaterie</th>
							<th class="text-center w9">Lager</th>
							<th class="text-center w9">Speziallager</th>
							<th class="text-center w9">Tanks</th>
						</tr>
						<tr>
							<td class="text-center" id="aluminium" data-amount="{{ $resources->aluminium }}" data-production="{{ $production->aluminium * (1 + ($planet->bonus + $research->geologie * 5) / 100) + $game['aluminium'] }}">{{ $help->nf($resources->aluminium) }}</td>
							<td class="text-center" id="titan" data-amount="{{ $resources->titan }}" data-production="{{ $production->titan * (1 + ($planet->bonus + $research->speziallegierungen * 5) / 100) + $game['titan'] }}">{{ $help->nf($resources->titan) }}</td>
							<td class="text-center" id="silizium" data-amount="{{ $resources->silizium }}" data-production="{{ $production->silizium * (1 + ($planet->bonus + $research->geologie * 5) / 100) + $game['silizium'] }}">{{ $help->nf($resources->silizium) }}</td>
							<td class="text-center" id="arsen" data-amount="{{ $resources->arsen }}" data-production="{{ $production->arsen * (1 + ($planet->bonus + $research->speziallegierungen * 5) / 100) }}">{{ $help->nf($resources->arsen) }}</td>
							<td class="text-center" id="wasserstoff" data-amount="{{ $resources->wasserstoff }}" data-production="{{ $production->wasserstoff * (1 + ($planet->bonus + $research->materiestabilisierung * 5) / 100) }}">{{ $help->nf($resources->wasserstoff) }}</td>
							<td class="text-center" id="antimaterie" data-amount="{{ $resources->antimaterie }}" data-production="{{ $production->antimaterie * (1 + ($planet->bonus + $research->materiestabilisierung * 5) / 100) }}">{{ $help->nf($resources->antimaterie) }}</td>
							<td class="text-center" id="lager" data-int="{{ $resources->lager_int }}" data-storage="{{ $resources->lager_cap }}">{{ $help->nf($resources->lager_int,2) }}%</td>
							<td class="text-center" id="speziallager" data-int="{{ $resources->speziallager_int }}" data-storage="{{ $resources->speziallager_cap }}">{{ $help->nf($resources->speziallager_int,2) }}%</td>
							<td class="text-center" id="tanks" data-int="{{ $resources->tanks_int }}" data-storage="{{ $resources->tanks_cap }}">{{ $help->nf($resources->tanks_int,2) }}%</td>
						</tr>
					</table>
				</div>
			</div>
		</div>
		<div class="container-fluid mb30 pb30">
			@yield('content')
		</div>
		<div class="container-fluid posfix zi1000 b0">
			<div class="row">
				<div class="btn-group btn-group-sm btn-group-justified btn-group-btm">
					<a href="/missions/" class="btn btn-default" data-toggle="popover" data-placement="top" data-content="Missionen">
						<i class="fa fa-briefcase fa-lg pt1"></i>
						<span class="visible-lg">Missionen</span>
					</a>
					<a href="/messages/" class="btn btn-default{{ $newmessage ? ' green' : '' }}" data-toggle="popover" data-placement="top" data-content="Nachrichten ({{ $user->messages->count() }})">
						<i class="fa fa-envelope fa-lg"></i>
						<span class="visible-lg">Nachrichten ({{ $user->messages->count() }})</span>
					</a>
					<a href="/reports/" class="btn btn-default" data-toggle="popover" data-placement="top" data-content="Berichte (0)">
						<i class="fa fa-file-text fa-lg"></i>
						<span class="visible-lg">Berichte (0)</span>
					</a>
					<a href="/notes/" class="btn btn-default" data-toggle="popover" data-placement="top" data-content="Notizen">
						<i class="fa fa-clipboard fa-lg"></i>
						<span class="visible-lg">Notizen</span>
					</a>
					<a href="/toplist/" class="btn btn-default" data-toggle="popover" data-placement="top" data-content="Toplist">
						<i class="fa fa-list fa-lg pt1"></i>
						<span class="visible-lg">Toplist</span>
					</a>
					<a href="/search/" class="btn btn-default" data-toggle="popover" data-placement="top" data-content="Suche">
						<i class="fa fa-search fa-lg"></i>
						<span class="visible-lg">Suche</span>
					</a>
					<a href="/options/" class="btn btn-default" data-toggle="popover" data-placement="top" data-content="Optionen">
						<i class="fa fa-cog fa-lg pt1"></i>
						<span class="visible-lg">Optionen</span>
					</a>
					<a href="/simulator/" class="btn btn-default" data-toggle="popover" data-placement="top" data-content="Simulator">
						<i class="fa fa-gamepad fa-lg"></i>
						<span class="visible-lg">Simulator</span>
					</a>
					<a href="/forum/" class="btn btn-default" data-toggle="popover" data-placement="top" data-content="Forum">
						<i class="fa fa-list-alt fa-lg pt1"></i>
						<span class="visible-lg">Forum</span>
					</a>
					<a href="/users/logout/" class="btn btn-default" data-toggle="popover" data-placement="top" data-content="Logout">
						<i class="fa fa-sign-out fa-lg pt1"></i>
						<span class="visible-lg">Logout</span>
					</a>
				</div>
			</div>
		</div>
		{!! HTML::script('js/jquery.js') !!}
		{!! HTML::script('js/bootstrap.min.js') !!}
		{!! HTML::script('js/bootbox.min.js') !!}
		{!! HTML::script('js/game/eternalvoid.js') !!}
		@yield('pagejs')
	</body>
</html>