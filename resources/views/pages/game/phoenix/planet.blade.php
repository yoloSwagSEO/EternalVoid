@extends('pages.game.phoenix.game')
@section('content')
	<div class="row">
		<div class="col-lg-2 col-md-3 col-sm-4 col-xs-12 text-center">
			<div class="thumbnail posfix">
				<img src="/img/game/planets/{{ $game['planets'][$planet->image] }}" alt="...">
				<div class="caption">
					<h3 class="mt0">{{ Crypt::decrypt($planet->planetname) }}</h3>
					<dl class="dl-horizontal dl-o2 text-left">
						<dt>Besiedelung:</dt>
						<dd>{{ $help->dt($planet->settled_at)->format('d.m.Y') }}</dd>
						<dt>Bonus:</dt>
						<dd>{{ $planet->bonus }}%</dd>
						<dt>Durchmesser:</dt>
						<dd>{{ $help->nf($planet->diameter) }} km</dd>
						<dt>Temperatur:</dt>
						<dd>{{ $planet->temp_min }}°c bis {{ $planet->temp_max }}°c</dd>
					</dl>
					<dl class="dl-horizontal dl-o2 text-left">
						<dt>Verteidigungsstärke:</dt>
						<dd></dd>
						<dt>Flottenstärke:</dt>
						<dd></dd>
						<dt>Schildstärke:</dt>
						<dd></dd>
						<dt class="u">Gesamtstärke:</dt>
						<dd></dd>
					</dl>
					<dl class="dl-horizontal dl-o2 text-left">
						<dt class="u">Kommandopunkte<br />({{ $planet->galaxy }}:{{ $planet->system }}:{{ $planet->position }})</dt>
						<dd>{{ $help->nf($planet->pkt) }}</dd>
						<dt>&nbsp;</dt>
						<dd></dd>
						<dt>Kommandopunkte:</dt>
						<dd></dd>
						<dt>Forschungspunkte:</dt>
						<dd>{{ $help->nf($research->pkt) }}</dd>
						<dt class="u">Gesamtpunkte:</dt>
						<dd></dd>
					</dl>
					<dl class="dl-horizontal dl-o2 text-left mb0">
						<dt>Planetentoplist:</dt>
						<dd></dd>
						<dt>Techtoplist:</dt>
						<dd></dd>
						<dt>Allianztoplist:</dt>
						<dd></dd>
						<dt>Spielertoplist:</dt>
						<dd></dd>
					</dl>
				</div>
			</div>
		</div>
		<div class="col-lg-10 col-md-9 col-sm-8 col-xs-12">
			<h3 class="mt0">Flottenbewegungen</h3>
			<div class="gcontainer">
				<div class="panel panel-default mb0">
					<table class="table table-bordered table-condensed table-hover">
						<thead class="ttu">
						<tr>
							<th class="w15 pt10 pb10 pl5">Flotten-ID</th>
							<th class="w15 pt10 pb10 pl5">Start</th>
							<th class="w15 pt10 pb10 pl5">Ziel</th>
						</tr>
						</thead>
					</table>
				</div>
			</div>
			<h3>Ereignisse</h3>
			<div class="gcontainer">
				<div class="panel panel-default mb0">
					<table class="table table-bordered table-condensed table-hover">
						<thead class="ttu">
						<tr>
							<th class="w15 pt10 pb10 pl5">Objekt</th>
							<th class="w15 pt10 pb10 pl5">Benötigte Zeit</th>
							<th colspan="4" class="w70 pt10 pb10 pl5">Fertigstellung</th>
						</tr>
						</thead>
					</table>
				</div>
			</div>
		</div>
	</div>
@stop