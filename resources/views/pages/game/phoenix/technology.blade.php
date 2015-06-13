@extends('pages.game.phoenix.game')
@section('content')
	<div class="row">
		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 mb30">
			<h3>Gebäude</h3>
			<div class="gcontainer">
				<div class="panel panel-default mb0">
					<table class="table table-bordered table-hover mb0">
						<thead class="ttu">
							<tr>
								<th class="w50">Objekt</th>
								<th class="w50">Voraussetzungen</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td class="green left w50">Aluminiummine ({{ $buildings->aluminiummine }})</td>
								<td class="green w50">keine</td>
							</tr>
							<tr>
								<td class="green left w50">Titanfertigung ({{ $buildings->titanfertigung }})</td>
								<td class="green w50">keine</td>
							</tr>
							<tr>
								<td class="green left w50">Siliziummine ({{ $buildings->siliziummine }})</td>
								<td class="green w50">keine</td>
							</tr>
							<tr>
								<td class="{{ $planet->base_id == 1 ? 'red' : 'green' }} left">Arsenfertigung ({{ $buildings->arsenfertigung }})</td>
								<td class="{{ $planet->base_id == 1 ? 'red' : 'green' }}">Nur auf Kolonien</td>
							</tr>
							<tr>
								<td class="green left w50">Wasserstofffabrik ({{ $buildings->wasserstofffabrik }})</td>
								<td class="green w50">keine</td>
							</tr>
							<tr>
								<td class="green left w50">Antimateriefabrik ({{ $buildings->antimateriefabrik }})</td>
								<td class="green w50">keine</td>
							</tr>
							<tr>
								<td class="green left w50">Lager ({{ $buildings->lager }})</td>
								<td class="green w50">keine</td>
							</tr>
							<tr>
								<td class="{{ $buildings->wasserstofffabrik > 0 ? 'green' : 'red' }} left w50">Speziallager ({{ $buildings->speziallager }})</td>
								<td class="{{ $buildings->wasserstofffabrik > 0 ? 'green' : 'red' }} w50">Wasserstofffabrik 1</td>
							</tr>
							<tr>
								<td class="{{ $buildings->antimateriefabrik > 0 ? 'green' : 'red' }} left w50">Tanks ({{ $buildings->tanks }})</td>
								<td class="{{ $buildings->antimateriefabrik > 0 ? 'green' : 'red' }} w50">Antimateriefabrik 1</td>
							</tr>
							<tr>
								<td class="green left w50">Bunker ({{ $buildings->bunker }})</td>
								<td class="green w50">keine</td>
							</tr>
							<tr>
								<td class="green left w50">Schiffswerft ({{ $buildings->schiffswerft }})</td>
								<td class="green w50">keine</td>
							</tr>
							<tr>
								<td class="green left w50">Raumhafen ({{ $buildings->raumhafen }})</td>
								<td class="green w50">keine</td>
							</tr>
							<tr>
								<td class="green left w50">Sternenbasis ({{ $buildings->sternenbasis }})</td>
								<td class="green w50">keine</td>
							</tr>
							<tr>
								<td class="{{ $buildings->sternenbasis > 0 ? 'green' : 'red' }} left w50">Flottenkommando ({{ $buildings->flottenkommando }})</td>
								<td class="{{ $buildings->sternenbasis > 0 ? 'green' : 'red' }} w50">Sternenbasis 1</td>
							</tr>
							<tr>
								<td class="{{ $buildings->sternenbasis > 9 && $research->schildtechnologie > 0 ? 'green' : 'red' }} left w50">Planetarer Schild ({{ $buildings->planetarer_schild }})</td>
								<td><span class="{{ $buildings->sternenbasis > 9 ? 'green' : 'red' }} w50">Sternenbasis 10</span>, <span class="{{ $buildings->schildtechnologie > 0 ? 'green' : 'red' }}">Schildtechnologie 1</span></td>
							</tr>
							<tr>
								<td class="green left w50">Kommandozentrale ({{ $buildings->kommandozentrale }})</td>
								<td class="green w50">keine</td>
							</tr>
							<tr>
								<td class="green left w50">Forschungszentrum ({{ $buildings->forschungszentrum }})</td>
								<td class="green w50">keine</td>
							</tr>
							<tr>
								<td class="{{ $buildings->flottenkommando > 0 ? 'green' : 'red' }} left w50">Handelsbörse ({{ $buildings->handelsboerse }})</td>
								<td class="{{ $buildings->flottenkommando > 0 ? 'green' : 'red' }} w50">Flottenkommando 1</td>
							</tr>
							<tr>
								<td class="{{ $buildings->flottenkommando > 0 ? 'green' : 'red' }} left w50">Schiffsbörse ({{ $buildings->schiffsboerse }})</td>
								<td class="{{ $buildings->flottenkommando > 0 ? 'green' : 'red' }} w50">Flottenkommando 1</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 mb30">
			<h3>Forschungen</h3>
			<div class="gcontainer">
				<div class="panel panel-default mb0">
					<table class="table table-bordered table-hover mb0">
						<thead class="ttu">
							<tr>
								<th class="w50">Objekt</th>
								<th class="w50">Voraussetzungen</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td class="{{ $buildings->forschungszentrum > 0 ? 'green' : 'red' }} left w50">Pulsantrieb ({{ $research->pulsantrieb }})</td>
								<td class="{{ $buildings->forschungszentrum > 0 ? 'green' : 'red' }} w50">Forschungszentrum 1</td>
							</tr>
							<tr>
								<td class="{{ $buildings->forschungszentrum > 3 ? 'green' : 'red' }} left w50">Antimaterieantrieb ({{ $research->antimaterieantrieb }})</td>
								<td class="{{ $buildings->forschungszentrum > 3 ? 'green' : 'red' }} w50">Forschungszentrum 4</td>
							</tr>
							<tr>
								<td class="{{ $buildings->forschungszentrum > 0 ? 'green' : 'red' }} left w50">Projektilwaffen ({{ $research->projektilwaffen }})</td>
								<td class="{{ $buildings->forschungszentrum > 0 ? 'green' : 'red' }} w50">Forschungszentrum 1</td>
							</tr>
							<tr>
								<td class="{{ $buildings->forschungszentrum > 1 ? 'green' : 'red' }} left w50">Laserwaffen ({{ $research->laserwaffen }})</td>
								<td class="{{ $buildings->forschungszentrum > 1 ? 'green' : 'red' }} w50">Forschungszentrum 2</td>
							</tr>
							<tr>
								<td class="{{ $buildings->forschungszentrum > 3 ? 'green' : 'red' }} left w50">Plasmawaffen ({{ $research->plasmawaffen }})</td>
								<td class="{{ $buildings->forschungszentrum > 3 ? 'green' : 'red' }} w50">Forschungszentrum 4</td>
							</tr>
							<tr>
								<td class="{{ $buildings->forschungszentrum > 7 ? 'green' : 'red' }} left w50">Phasenwaffen ({{ $research->phasenwaffen }})</td>
								<td class="{{ $buildings->forschungszentrum > 7 ? 'green' : 'red' }} w50">Forschungszentrum 8</td>
							</tr>
							<tr>
								<td class="{{ $buildings->forschungszentrum > 0 ? 'green' : 'red' }} left w50">Strukturelle Integrität ({{ $research->strukturelle_integritaet }})</td>
								<td class="{{ $buildings->forschungszentrum > 0 ? 'green' : 'red' }} w50">Forschungszentrum 1</td>
							</tr>
							<tr>
								<td class="{{ $buildings->forschungszentrum > 1 ? 'green' : 'red' }} left w50">Mikroarchitektur ({{ $research->mikroarchitektur }})</td>
								<td class="{{ $buildings->forschungszentrum > 1 ? 'green' : 'red' }} w50">Forschungszentrum 2</td>
							</tr>
							<tr>
								<td class="{{ $buildings->forschungszentrum > 4 && $research->strukturelle_integritaet > 4 && $research->mikroarchitektur > 1 ? 'green' : 'red' }} left w50">Oribtalkonstruktion ({{ $research->orbitalkonstruktion }})</td>
								<td><span class="{{ $buildings->forschungszentrum > 4 ? 'green' : 'red' }} w50">Forschungszentrum 5</span>, <span class="{{ $research->strukturelle_integritaet > 4 ? 'green' : 'red' }}">Strukturelle Integrität 5</span>, <span class="{{ $research->mikroarchitektur > 1 ? 'green' : 'red' }}">Mikroarchitektur 2</span></td>
							</tr>
							<tr>
								<td class="{{ $research->strukturelle_integritaet > 1 ? 'green' : 'red' }} left w50">Lagererweiterung ({{ $research->lagererweiterung }})</td>
								<td class="{{ $research->strukturelle_integritaet > 1 ? 'green' : 'red' }} w50">Strukturelle Integrität 2</td>
							</tr>
							<tr>
								<td class="{{ $research->lagererweiterung > 7 && $research->orbitalkonstruktion > 3 ? 'green' : 'red' }} left w50">Schiffskapazität ({{ $research->schiffskapazitaet }})</td>
								<td><span class="{{ $research->lagererweiterung > 7 ? 'green' : 'red' }} w50">Strukturelle Integrität 2</span>, <span class="{{ $research->orbitalkonstruktion > 3 ? 'green' : 'red' }}">Orbitalkonstruktion 4</span></td>
							</tr>
							<tr>
								<td class="{{ $buildings->forschungszentrum > 14 && $research->schiffskapazitaet > 9 ? 'green' : 'red' }} left w50">Rumpfstatik ({{ $research->rumpfstatik }})</td>
								<td><span class="{{ $buildings->forschungszentrum > 14 ? 'green' : 'red' }} w50">Forschungszentrum 15</span>, <span class="{{ $research->schiffskapazitaet > 9 ? 'green' : 'red' }}">Schiffskapazität 10</span></td>
							</tr>
							<tr>
								<td class="{{ $buildings->forschungszentrum > 9 && $research->strukturelle_integritaet > 3 && $research->mikroarchitektur > 4 ? 'green' : 'red' }} left w50">Werftarchitektur ({{ $research->werftarchitektur }})</td>
								<td><span class="{{ $buildings->forschungszentrum > 9 ? 'green' : 'red' }} w50">Forschungszentrum 10</span>, <span class="{{ $research->strukturelle_integritaet > 3 ? 'green' : 'red' }}">Strukturelle Integrität 4</span>, <span class="{{ $research->mikroarchitektur > 4 ? 'green' : 'red' }}">Mikroarchitektur 5</span></td>
							</tr>
							<tr>
								<td class="{{ $buildings->forschungszentrum > 5 && $research->strukturelle_integritaet > 2 ? 'green' : 'red' }} left w50">Schildtechnologie ({{ $research->schildtechnologie }})</td>
								<td><span class="{{ $buildings->forschungszentrum > 5 ? 'green' : 'red' }} w50">Forschungszentrum 6</span>, <span class="{{ $research->strukturelle_integritaet > 2 ? 'green' : 'red' }}">Strukturelle Integrität 3</span></td>
							</tr>
							<tr>
								<td class="{{ $buildings->forschungszentrum > 0 && $research->sternenbasis > 9 ? 'green' : 'red' }} left w50">Kommunikation ({{ $research->kommunikation }})</td>
								<td><span class="{{ $buildings->forschungszentrum > 0 ? 'green' : 'red' }} w50">Forschungszentrum 1</span>, <span class="{{ $buildings->sternenbasis > 9 ? 'green' : 'red' }}">Sternenbasis 10</span></td>
							</tr>
							<tr>
								<td class="{{ $buildings->forschungszentrum > 4 ? 'green' : 'red' }} left w50">Imperiale Verwaltung ({{ $research->imperiale_verwaltung }})</td>
								<td class="{{ $buildings->forschungszentrum > 4 ? 'green' : 'red' }} w50">Forschungszentrum 5</td>
							</tr>
							<tr>
								<td class="{{ $buildings->forschungszentrum > 0 ? 'green' : 'red' }} left w50">Spionage ({{ $research->spionage }})</td>
								<td class="{{ $buildings->forschungszentrum > 0 ? 'green' : 'red' }} w50">Forschungszentrum 1</td>
							</tr>
							<tr>
								<td class="{{ $buildings->forschungszentrum > 2 && $buildings->lager > 4 && $research->lagererweiterung > 1 && $research->mikroarchitektur > 2 ? 'green' : 'red' }} left w50">Recycling ({{ $research->recycling }})</td>
								<td><span class="{{ $buildings->forschungszentrum > 2 ? 'green' : 'red' }} w50">Forschungszentrum 3</span>, <span class="{{ $buildings->lager > 4 ? 'green' : 'red' }}">Lager 5</span>, <span class="{{ $research->lagererweiterung > 1 ? 'green' : 'red' }}">Lagererweiterung 2</span>, <span class="{{ $research->mikroarchitektur > 2 ? 'green' : 'red' }}">Mikroarchitektur 3</span></td>
							</tr>
							<tr>
								<td class="{{ $buildings->forschungszentrum > 0 && $buildings->aluminiummine > 9 && $buildings->siliziummine > 9 ? 'green' : 'red' }} left w50">Geologie ({{ $research->geologie }})</td>
								<td><span class="{{ $buildings->forschungszentrum > 0 ? 'green' : 'red' }} w50">Forschungszentrum 1</span>, <span class="{{ $buildings->aluminiummine > 9 ? 'green' : 'red' }}">Aluminiummine 10</span>, <span class="{{ $buildings->siliziummine > 10 ? 'green' : 'red' }}">Siliziummine 10</span></td>
							</tr>
							<tr>
								<td class="{{ $buildings->forschungszentrum > 3 && $buildings->titanfertigung > 9 ? 'green' : 'red' }} left w50">Speziallegierungen ({{ $research->speziallegierungen }})</td>
								<td><span class="{{ $buildings->forschungszentrum > 3 ? 'green' : 'red' }} w50">Forschungszentrum 4</span>, <span class="{{ $buildings->titanfertigung > 9 ? 'green' : 'red' }}">Titanfertigung 10</span></td>
							</tr>
							<tr>
								<td class="{{ $buildings->forschungszentrum > 5 && $buildings->wasserstofffabrik > 9 && $buildings->antimateriefabrik > 9 ? 'green' : 'red' }} left w50">Materiestabilisierung ({{ $research->materiestabilisierung }})</td>
								<td><span class="{{ $buildings->forschungszentrum > 5 ? 'green' : 'red' }} w50">Forschungszentrum 6</span>, <span class="{{ $buildings->wasserstofffabrik > 9 ? 'green' : 'red' }}">Wasserstofffabrik 10</span>, <span class="{{ $buildings->antimateriefabrik > 9 ? 'green' : 'red' }}">Antimateriefabrik 10</span></td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 mb30">
			<h3>Verteidiungsanlagen</h3>
			<div class="gcontainer">
				<div class="panel panel-default mb0">
					<table class="table table-bordered table-hover mb0">
						<thead class="ttu">
							<tr>
								<th class="w50">Objekt</th>
								<th class="w50">Voraussetzungen</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td class="{{ $buildings->sternenbasis > 0 && $research->projektilwaffen > 0 ? 'green' : 'red' }} left w50">Raketenstellung ({{ $defenses->raketenstellung }})</td>
								<td><span class="{{ $buildings->sternenbasis > 0 ? 'green' : 'red' }} w50">Sternenbasis 1</span>, <span class="{{ $research->projektilwaffen > 0 ? 'green' : 'red' }}">Projektilwaffen 1</span></td>
							</tr>
							<tr>
								<td class="{{ $buildings->sternenbasis > 2 && $research->laserwaffen > 0 ? 'green' : 'red' }} left w50">Lasergeschütz ({{ $defenses->lasergeschuetz }})</td>
								<td><span class="{{ $buildings->sternenbasis > 2 ? 'green' : 'red' }} w50">Sternenbasis 3</span>, <span class="{{ $research->laserwaffen > 0 ? 'green' : 'red' }}">Laserwaffen 1</span></td>
							</tr>
							<tr>
								<td class="{{ $buildings->sternenbasis > 5 && $research->plasmawaffen > 4 ? 'green' : 'red' }} left w50">Plasmablaster ({{ $defenses->plasmablaster }})</td>
								<td><span class="{{ $buildings->sternenbasis > 5 ? 'green' : 'red' }} w50">Sternenbasis 6</span>, <span class="{{ $research->plasmawaffen > 4 ? 'green' : 'red' }}">Plasmawaffen 5</span></td>
							</tr>
							<tr>
								<td class="{{ $buildings->sternenbasis > 7 && $research->phasenwaffen > 4 ? 'green' : 'red' }} left w50">Phasenemitter ({{ $defenses->phasenemitter }})</td>
								<td><span class="{{ $buildings->sternenbasis > 7 ? 'green' : 'red' }} w50">Sternenbasis 8</span>, <span class="{{ $research->phasenwaffen > 4 ? 'green' : 'red' }}">Phasenwaffen 5</span></td>
							</tr>
							<tr>
								<td class="{{ $buildings->sternenbasis > 9 && $research->projektilwaffen > 9 ? 'green' : 'red' }} left w50">Projektilblaster ({{ $defenses->projektilblaster }})</td>
								<td><span class="{{ $buildings->sternenbasis > 9 ? 'green' : 'red' }} w50">Sternenbasis 10</span>, <span class="{{ $research->projektilwaffen > 9 ? 'green' : 'red' }}">Projektilwaffen 10</span></td>
							</tr>
							<tr>
								<td class="{{ $buildings->sternenbasis > 14 && $research->projektilwaffen > 24 ? 'green' : 'red' }} left w50">Flak ({{ $defenses->flak }})</td>
								<td><span class="{{ $buildings->sternenbasis > 14 ? 'green' : 'red' }} w50">Sternenbasis 15</span>, <span class="{{ $research->projektilwaffen > 24 ? 'green' : 'red' }}">Projektilwaffen 25</span></td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
			<h3>Schiffe</h3>
			<div class="gcontainer">
				<div class="panel panel-default mb0">
					<table class="table table-bordered table-hover mb0">
						<thead class="ttu">
							<tr>
								<th class="w50">Objekt</th>
								<th class="w50">Voraussetzungen</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td class="{{ $buildings->schiffswerft > 0 && $research->pulsantrieb > 0 && $research->spionage > 0 ? 'green' : 'red' }} left w50">Spy ({{ $units->spy }})</td>
								<td><span class="{{ $buildings->schiffswerft > 0 ? 'green' : 'red' }} w50">Schiffswerft 1</span>, <span class="{{ $research->pulsantrieb > 0 ? 'green' : 'red' }}">Pulsantrieb 1</span>, <span class="{{ $research->spionage > 0 ? 'green' : 'red' }}">Spionage 1</span></td>
							</tr>
							<tr>
								<td class="{{ $buildings->raumhafen > 9 && $research->antimaterieantrieb > 7 && $research->schiffskapazitaet > 2 ? 'green' : 'red' }} left w50">Colonizer ({{ $units->colonizer }})</td>
								<td><span class="{{ $buildings->raumhafen > 9 ? 'green' : 'red' }} w50">Raumhafen 10</span>, <span class="{{ $research->antimaterieantrieb > 7 ? 'green' : 'red' }}">Antimaterieantrieb 8</span>, <span class="{{ $research->schiffskapazitaet > 2 ? 'green' : 'red' }}">Schiffskapazität 3</span></td>
							</tr>
							<tr>
								<td class="{{ $buildings->raumhafen > 7 && $research->pulsantrieb > 11 && $research->recycling > 0 ? 'green' : 'red' }} left w50">Recycler ({{ $units->recycler }})</td>
								<td><span class="{{ $buildings->raumhafen > 7 ? 'green' : 'red' }} w50">Raumhafen 8</span>, <span class="{{ $research->pulsantrieb > 11 ? 'green' : 'red' }}">Pulsantrieb 12</span>, <span class="{{ $research->recycling > 0 ? 'green' : 'red' }}">Recycling 1</span></td>
							</tr>
							<tr>
								<td class="{{ $buildings->raumhafen > 0 && $research->pulsantrieb > 0 ? 'green' : 'red' }} left w50">Piranha ({{ $units->piranha }})</td>
								<td><span class="{{ $buildings->raumhafen > 0 ? 'green' : 'red' }} w50">Raumhafen 1</span>, <span class="{{ $research->pulsantrieb > 0 ? 'green' : 'red' }}">Pulsantrieb 1</span></td>
							</tr>
							<tr>
								<td class="{{ $buildings->raumhafen > 3 && $research->antimaterieantrieb > 4 ? 'green' : 'red' }} left w50">Dolphin ({{ $units->dolphin }})</td>
								<td><span class="{{ $buildings->raumhafen > 3 ? 'green' : 'red' }} w50">Raumhafen 3</span>, <span class="{{ $research->antimaterieantrieb > 4 ? 'green' : 'red' }}">Antimaterieantrieb 5</span></td>
							</tr>
							<tr>
								<td class="{{ $buildings->raumhafen > 5 && $research->antimaterieantrieb > 9 ? 'green' : 'red' }} left w50">Whale ({{ $units->whale }})</td>
								<td><span class="{{ $buildings->raumhafen > 5 ? 'green' : 'red' }} w50">Raumhafen 6</span>, <span class="{{ $research->antimaterieantrieb > 9 ? 'green' : 'red' }}">Antimaterieantrieb 10</span></td>
							</tr>
							<tr>
								<td class="{{ $buildings->schiffswerft > 0 && $research->pulsantrieb > 0 && $research->projektilwaffen > 0 ? 'green' : 'red' }} left w50">Hornet ({{ $units->hornet }})</td>
								<td><span class="{{ $buildings->schiffswerft > 0 ? 'green' : 'red' }} w50">Schiffswerft 1</span>, <span class="{{ $research->pulsantrieb > 0 ? 'green' : 'red' }}">Pulsantrieb 1</span>, <span class="{{ $research->projektilwaffen > 0 ? 'green' : 'red' }}">Projektilwaffen 1</span></td>
							</tr>
							<tr>
								<td class="{{ $buildings->schiffswerft > 1 && $research->pulsantrieb > 2 && $research->laserwaffen > 0 ? 'green' : 'red' }} left w50">Scorpion ({{ $units->scorpion }})</td>
								<td><span class="{{ $buildings->schiffswerft > 1 ? 'green' : 'red' }} w50">Schiffswerft 2</span>, <span class="{{ $research->pulsantrieb > 2 ? 'green' : 'red' }}">Pulsantrieb 3</span>, <span class="{{ $research->laserwaffen > 0 ? 'green' : 'red' }}">Laserwaffen 1</span></td>
							</tr>
							<tr>
								<td class="{{ $buildings->schiffswerft > 2 && $research->pulsantrieb > 4 && $research->projektilwaffen > 9 ? 'green' : 'red' }} left w50">Vulpine ({{ $units->vulpine }})</td>
								<td><span class="{{ $buildings->schiffswerft > 2 ? 'green' : 'red' }} w50">Schiffswerft 3</span>, <span class="{{ $research->pulsantrieb > 4 ? 'green' : 'red' }}">Pulsantrieb 5</span>, <span class="{{ $research->projektilwaffen > 9 ? 'green' : 'red' }}">Projektilwaffen 10</span></td>
							</tr>
							<tr>
								<td class="{{ $buildings->schiffswerft > 3 && $research->pulsantrieb > 6 && $research->phasenwaffen > 4 ? 'green' : 'red' }} left w50">Wasp ({{ $units->wasp }})</td>
								<td><span class="{{ $buildings->schiffswerft > 3 ? 'green' : 'red' }} w50">Schiffswerft 4</span>, <span class="{{ $research->pulsantrieb > 6 ? 'green' : 'red' }}">Pulsantrieb 7</span>, <span class="{{ $research->phasenwaffen > 4 ? 'green' : 'red' }}">Phasenwaffen 5</span></td>
							</tr>
							<tr>
								<td class="{{ $buildings->schiffswerft > 4 && $research->pulsantrieb > 9 && $research->plasmawaffen > 4 ? 'green' : 'red' }} left w50">Gator ({{ $units->gator }})</td>
								<td><span class="{{ $buildings->schiffswerft > 4 ? 'green' : 'red' }} w50">Schiffswerft 5</span>, <span class="{{ $research->pulsantrieb > 9 ? 'green' : 'red' }}">Pulsantrieb 10</span>, <span class="{{ $research->plasmawaffen > 4 ? 'green' : 'red' }}">Plasmawaffen 5</span></td>
							</tr>
							<tr>
								<td class="{{ $buildings->schiffswerft > 5 && $research->pulsantrieb > 9 && $research->laserwaffen > 11 ? 'green' : 'red' }} left w50">Tiger ({{ $units->tiger }})</td>
								<td><span class="{{ $buildings->schiffswerft > 5 ? 'green' : 'red' }} w50">Schiffswerft 6</span>, <span class="{{ $research->pulsantrieb > 9 ? 'green' : 'red' }}">Pulsantrieb 10</span>, <span class="{{ $research->laserwaffen > 11 ? 'green' : 'red' }}">Laserwaffen 12</span></td>
							</tr>
							<tr>
								<td class="{{ $buildings->schiffswerft > 7 && $research->antimaterieantrieb > 7 && $research->projektilwaffen > 19 ? 'green' : 'red' }} left w50">Orca ({{ $units->orca }})</td>
								<td><span class="{{ $buildings->schiffswerft > 7 ? 'green' : 'red' }} w50">Schiffswerft 8</span>, <span class="{{ $research->antimaterieantrieb > 7 ? 'green' : 'red' }}">Antimaterieantrieb 8</span>, <span class="{{ $research->projektilwaffen > 19 ? 'green' : 'red' }}">Projektilwaffen 20</span></td>
							</tr>
							<tr>
								<td class="{{ $buildings->schiffswerft > 9 && $research->antimaterieantrieb > 9 && $research->laserwaffen > 9 ? 'green' : 'red' }} left w50">Grizzly ({{ $units->grizzly }})</td>
								<td><span class="{{ $buildings->schiffswerft > 9 ? 'green' : 'red' }} w50">Schiffswerft 10</span>, <span class="{{ $research->antimaterieantrieb > 9 ? 'green' : 'red' }}">Antimaterieantrieb 10</span>, <span class="{{ $research->laserwaffen > 9 ? 'green' : 'red' }}">Laserwaffen 10</span></td>
							</tr>
							<tr>
								<td class="{{ $buildings->schiffswerft > 11 && $research->antimaterieantrieb > 14 && $research->plasmawaffen > 9 && $research->rumpfstatik > 4 ? 'green' : 'red' }} left w50">Sabertooth ({{ $units->sabertooth }})</td>
								<td><span class="{{ $buildings->schiffswerft > 11 ? 'green' : 'red' }} w50">Schiffswerft 12</span>, <span class="{{ $research->antimaterieantrieb > 14 ? 'green' : 'red' }}">Antimaterieantrieb 15</span>, <span class="{{ $research->plasmawaffen > 9 ? 'green' : 'red' }}">Plasmawaffen 10</span>, <span class="{{ $research->rumpfstatik > 4 ? 'green' : 'red' }}">Rumpfstatik 5</span></td>
							</tr>
							<tr>
								<td class="{{ $buildings->schiffswerft > 13 && $research->antimaterieantrieb > 19 && $research->phasenwaffen > 9 && $research->rumpfstatik > 9 ? 'green' : 'red' }} left w50">Mammoth ({{ $units->mammoth }})</td>
								<td><span class="{{ $buildings->schiffswerft > 13 ? 'green' : 'red' }} w50">Schiffswerft 14</span>, <span class="{{ $research->antimaterieantrieb > 19 ? 'green' : 'red' }}">Antimaterieantrieb 20</span>, <span class="{{ $research->phasenwaffen > 9 ? 'green' : 'red' }}">Phasenwaffen 10</span>, <span class="{{ $research->rumpfstatik > 9 ? 'green' : 'red' }}">Rumpfstatik 10</span></td>
							</tr>
							<tr>
								<td class="{{ $buildings->schiffswerft > 14 && $research->antimaterieantrieb > 7 && $research->schiffskapazitaet > 5 ? 'green' : 'red' }} left w50">Invader ({{ $units->invader }})</td>
								<td><span class="{{ $buildings->schiffswerft > 14 ? 'green' : 'red' }} w50">Schiffswerft 15</span>, <span class="{{ $research->antimaterieantrieb > 7 ? 'green' : 'red' }}">Antimaterieantrieb 8</span>, <span class="{{ $research->schiffskapazitaet > 5 ? 'green' : 'red' }}">Schiffskapazitaet 6</span></td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
@stop