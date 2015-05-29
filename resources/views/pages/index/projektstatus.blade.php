@extends('layouts.master')
@section('content')
	<h2 class="f32 u mb30">Projektstatus</h2>
	<p>
		Hier könnt ihr einsehen, was geschafft wurde, was derzeit umgesetzt wird und was noch fehlt.
	</p>
	<p>
		Das ganze ist eine persönliche Einschätzung, insbesondere was den Prozentbalken angeht. Daher ist das keine absolute Garantie über den Fortschritt des Spiels.
	</p>
	<div class="progress mt30">
		<div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width: 55%">
			<span class="black f28">55%</span>
		</div>
	</div>
	<div class="panel panel-default mb0">
		<table class="table table-bordered">
			<thead>
			<tr>
				<th class="green">Fertig:</th>
				<th class="warn">In Umsetzung:</th>
				<th class="red">Fehlend:</th>
			</tr>
			</thead>
			<tbody>
			<tr>
				<td class="green vtop">
					<ul class="ls-s">
						<li>Benuterzoberfläche</li>
						<li>Nachrichtensystem</li>
						<li>Galaxieansicht</li>
						<li style="color:#99cc00;">Planetenübersicht (75%)</li>
						<li>Ressourcenübersicht</li>
						<li>Technologieübersicht</li>
						<li>Berechnungsformeln</li>
						<li style="color:#99cc00;">Allianzsystem (90%)</li>
						<li>Baumöglichkeiten</li>
						<li>Notizen</li>
						<li>Forschungsm&ouml;glichkeiten</li>
						<li style="color:#99cc00;">Verteidigungsanlagen (80%)</li>
						<li>Kampfsystem</li>
						<li>Kampfsimulator</li>
					</ul>
				</td>
				<td class="warn vtop">
					<ul class="ls-s">
						<li>Schiffswerft</li>
						<li>Zivilhangar</li>
						<li>Berichte</li>
						<li>Toplisten</li>
						<li>Suche</li>
						<li>Optionen</li>
						<li>Missionen</li>
					</ul>
				</td>
				<td class="red vtop">
					<ul class="ls-s">
						<li>Flottenbewegungen</li>
						<li>Flottenkommando</li>
						<li>Flottenübersicht</li>
						<li>Handelsbörse</li>
						<li>Schiffsbörse</li>
					</ul>
				</td>
			</tr>
			</tbody>
		</table>
	</div>
@stop