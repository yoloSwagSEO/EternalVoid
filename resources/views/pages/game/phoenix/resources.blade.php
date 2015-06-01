@extends('pages.game.phoenix.game')
@section('content')
	<div class="row" id="resources">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mb30">
			<h3>Ressourcen &raquo; Übersicht</h3>
			<div class="gcontainer">
				<div class="panel panel-default mb0">
					<table class="table table-bordered table-condensed table-hover">
						<thead class="ttu">
						<tr>
							<th class="text-center">Rohstoff</th>
							<th class="text-center">Minenstufe</th>
							<th class="text-center">Bonus</th>
							<th class="text-center">Förderung / Minute</th>
							<th class="text-center">Förderung / Stunde</th>
							<th class="text-center">Förderung / Tag</th>
							<th class="text-center">Vorhanden</th>
						</tr>
						</thead>
						<tbody>
						<tr>
							<td class="text-center">Aluminium</td>
							<td class="text-center">{{ $planet->buildings->aluminiummine }}</td>
							<td class="text-center">{{ $aluminium_bonus }}%</td>
							<td class="text-center tt" data-toggle="tooltip" title="<dl class='dl-horizontal mb0'><dt>Grundproduktion:</dt><dd>{{ $aluminium_base_production_min }}</dd><dt>Aluminiummine:</dt><dd>{{ $aluminium_mine_production_min }}</dd><dt>Bonus:</dt><dd>{{ $aluminium_bonus_production_min }}</dd></dl>">
								{{ $aluminium_all_production_min }}

							</td>
							<td class="text-center tt" data-toggle="tooltip" title="<dl class='dl-horizontal mb0'><dt>Grundproduktion:</dt><dd>{{ $aluminium_base_production_hour }}</dd><dt>Aluminiummine:</dt><dd>{{ $aluminium_mine_production_hour }}</dd><dt>Bonus:</dt><dd>{{ $aluminium_bonus_production_hour }}</dd></dl>">
								{{ $aluminium_all_production_hour }}

							</td>
							<td class="text-center tt" data-toggle="tooltip" title="<dl class='dl-horizontal mb0'><dt>Grundproduktion:</dt><dd>{{ $aluminium_base_production_daily }}</dd><dt>Aluminiummine:</dt><dd>{{ $aluminium_mine_production_daily }}</dd><dt>Bonus:</dt><dd>{{ $aluminium_bonus_production_daily }}</dd></dl>">
								{{ $aluminium_all_production_daily }}

							</td>
							<td class="text-center" id="res-aluminium">{{ $help->nf($resources->aluminium) }}</td>
						</tr>
						<tr>
							<td class="text-center">Titan</td>
							<td class="text-center">{{ $planet->buildings->titanfertigung }}</td>
							<td class="text-center">{{ $titan_bonus }}%</td>
							<td class="text-center tt" data-toggle="tooltip" title="<dl class='dl-horizontal mb0'><dt>Grundproduktion:</dt><dd>{{ $titan_base_production_min }}</dd><dt>Titanfertigung:</dt><dd>{{ $titan_mine_production_min }}</dd><dt>Bonus:</dt><dd>{{ $titan_bonus_production_min }}</dd></dl>">
								{{ $titan_all_production_min }}

							</td>
							<td class="text-center tt" data-toggle="tooltip" title="<dl class='dl-horizontal mb0'><dt>Grundproduktion:</dt><dd>{{ $titan_base_production_hour }}</dd><dt>Titanfertigung:</dt><dd>{{ $titan_mine_production_hour }}</dd><dt>Bonus:</dt><dd>{{ $titan_bonus_production_hour }}</dd></dl>">
								{{ $titan_all_production_hour }}

							</td>
							<td class="text-center tt" data-toggle="tooltip" title="<dl class='dl-horizontal mb0'><dt>Grundproduktion:</dt><dd>{{ $titan_base_production_daily }}</dd><dt>Titanfertigung:</dt><dd>{{ $titan_mine_production_daily }}</dd><dt>Bonus:</dt><dd>{{ $titan_bonus_production_daily }}</dd></dl>">
								{{ $titan_all_production_daily }}

							</td>
							<td class="text-center" id="res-titan">{{ $help->nf($resources->titan) }}</td>
						</tr>
						<tr>
							<td class="text-center">Silizium</td>
							<td class="text-center">{{ $planet->buildings->siliziummine }}</td>
							<td class="text-center">{{ $planet->bonus + ($research->geologie * 5) }}%</td>
							<td class="text-center tt" data-toggle="tooltip" title="<dl class='dl-horizontal mb0'><dt>Grundproduktion:</dt><dd>{{ $silizium_base_production_min }}</dd><dt>Siliziummine:</dt><dd>{{ $silizium_mine_production_min }}</dd><dt>Bonus:</dt><dd>{{ $silizium_bonus_production_min }}</dd></dl>">
								{{ $silizium_all_production_min }}

							</td>
							<td class="text-center tt" data-toggle="tooltip" title="<dl class='dl-horizontal mb0'><dt>Grundproduktion:</dt><dd>{{ $silizium_base_production_hour }}</dd><dt>Siliziummine:</dt><dd>{{ $silizium_mine_production_hour }}</dd><dt>Bonus:</dt><dd>{{ $silizium_bonus_production_hour }}</dd></dl>">
								{{ $silizium_all_production_hour }}

							</td>
							<td class="text-center tt" data-toggle="tooltip" title="<dl class='dl-horizontal mb0'><dt>Grundproduktion:</dt><dd>{{ $silizium_base_production_daily }}</dd><dt>Siliziummine:</dt><dd>{{ $silizium_mine_production_daily }}</dd><dt>Bonus:</dt><dd>{{ $silizium_bonus_production_daily }}</dd></dl>">
								{{ $silizium_all_production_daily }}

							</td>
							<td class="text-center" id="res-silizium">{{ $help->nf($resources->silizium) }}</td>
						</tr>
						<tr>
							<td class="text-center">Arsen</td>
							<td class="text-center">{{ $planet->buildings->arsenfertigung }}</td>
							<td class="text-center">{{ $arsen_bonus }}%</td>
							<td class="text-center tt" data-toggle="tooltip" title="<dl class='dl-horizontal mb0'><dt>Arsenfertigung:</dt><dd>{{ $arsen_mine_production_min }}</dd><dt>Bonus:</dt><dd>{{ $arsen_bonus_production_min }}</dd></dl>">
								{{ $arsen_all_production_min }}

							</td>
							<td class="text-center tt" data-toggle="tooltip" title="<dl class='dl-horizontal mb0'><dt>Arsenfertigung:</dt><dd>{{ $arsen_mine_production_hour }}</dd><dt>Bonus:</dt><dd>{{ $arsen_bonus_production_hour }}</dd></dl>">
								{{ $arsen_all_production_hour }}

							</td>
							<td class="text-center tt" data-toggle="tooltip" title="<dl class='dl-horizontal mb0'><dt>Arsenfertigung:</dt><dd>{{ $arsen_mine_production_daily }}</dd><dt>Bonus:</dt><dd>{{ $arsen_bonus_production_daily }}</dd></dl>">
								{{ $arsen_all_production_daily }}

							</td>
							<td class="text-center" id="res-arsen">{{ $help->nf($resources->arsen) }}</td>
						</tr>
						<tr>
							<td class="text-center">Wasserstoff</td>
							<td class="text-center">{{ $planet->buildings->wasserstofffabrik }}</td>
							<td class="text-center">{{ $wasserstoff_bonus }}%</td>
							<td class="text-center tt" data-toggle="tooltip" title="<dl class='dl-horizontal mb0'><dt>Wasserstofffabrik:</dt><dd>{{ $wasserstoff_mine_production_min }}</dd><dt>Bonus:</dt><dd>{{ $wasserstoff_bonus_production_min }}</dd></dl>">
								{{ $wasserstoff_all_production_min }}

							</td>
							<td class="text-center tt" data-toggle="tooltip" title="<dl class='dl-horizontal mb0'><dt>Wasserstofffabrik:</dt><dd>{{ $wasserstoff_mine_production_hour }}</dd><dt>Bonus:</dt><dd>{{ $wasserstoff_bonus_production_hour }}</dd></dl>">
								{{ $wasserstoff_all_production_hour }}

							</td>
							<td class="text-center tt" data-toggle="tooltip" title="<dl class='dl-horizontal mb0'><dt>Wasserstofffabrik:</dt><dd>{{ $wasserstoff_mine_production_daily }}</dd><dt>Bonus:</dt><dd>{{ $wasserstoff_bonus_production_daily }}</dd></dl>">
								{{ $wasserstoff_all_production_daily }}

							</td>
							<td class="text-center" id="res-wasserstoff">{{ $help->nf($resources->wasserstoff) }}</td>
						</tr>
						<tr>
							<td class="text-center">Antimaterie</td>
							<td class="text-center">{{ $planet->buildings->antimateriefabrik }}</td>
							<td class="text-center">{{ $antimaterie_bonus }}%</td>
							<td class="text-center tt" data-toggle="tooltip" title="<dl class='dl-horizontal mb0'><dt>Antimateriefabrik:</dt><dd>{{ $antimaterie_mine_production_min }}</dd><dt>Bonus:</dt><dd>{{ $antimaterie_bonus_production_min }}</dd></dl>">
								{{ $antimaterie_all_production_min }}

							</td>
							<td class="text-center tt" data-toggle="tooltip" title="<dl class='dl-horizontal mb0'><dt>Antimateriefabrik:</dt><dd>{{ $antimaterie_mine_production_hour }}</dd><dt>Bonus:</dt><dd>{{ $antimaterie_bonus_production_hour }}</dd></dl>">
								{{ $antimaterie_all_production_hour }}

							</td>
							<td class="text-center tt" data-toggle="tooltip" title="<dl class='dl-horizontal mb0'><dt>Antimateriefabrik:</dt><dd>{{ $antimaterie_mine_production_daily }}</dd><dt>Bonus:</dt><dd>{{ $antimaterie_bonus_production_daily }}</dd></dl>">
								{{ $antimaterie_all_production_daily }}

							</td>
							<td class="text-center" id="res-antimaterie">{{ $help->nf($resources->antimaterie) }}</td>
						</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mb30">
			<h3>Lager &raquo; Übersicht</h3>
			<div class="gcontainer">
				<div class="panel panel-default mb0">
					<table class="table table-bordered table-condensed table-hover">
						<thead class="ttu">
						<tr>
							<th class="text-center">Objekt</th>
							<th class="text-center">Lagerstufe</th>
							<th class="text-center">Kapazität / Auslastung</th>
							<th class="text-center">Überlauf in</th>
							<th class="text-center">Füllstand</th>
						</tr>
						</thead>
						<tbody>
						<tr>
							<td class="text-center">Lager<br />(Aluminium, Titan, Silizium)</td>
							<td class="text-center vmiddle">{{ $buildings->lager }}</td>
							<td class="text-center vmiddle">{{ $help->nf($resources->lager_cap) }} / <span id="lager-resources">{{ $help->nf($resources->aluminium + $resources->titan + $resources->silizium) }}</span></td>
							<td class="text-center vmiddle countdown{{ $ltime < 86400 ? ' red' : ' green' }}" id="lager-countdown" data-until="{{ $ltime }}">{{ $help->htime($ltime) }}</td>
							<td class="text-center vmiddle" id="lager-int">{{ $help->nf($resources->lager_int,2) }}%</td>
						</tr>
						<tr>
							<td class="text-center">Speziallager<br />(Arsen, Wasserstoff)</td>
							<td class="text-center vmiddle">{{ $buildings->speziallager }}</td>
							<td class="text-center vmiddle">{{ $help->nf($resources->speziallager_cap) }} / <span id="speziallager-resources">{{ $help->nf($resources->arsen + $resources->wasserstoff) }}</span></td>
							<td class="text-center vmiddle countdown{{ $stime < 86400 ? ' red' : ' green' }}" id="speziallager-countdown" data-until="{{ $stime }}">{{ $help->htime($stime) }}</td>
							<td class="text-center vmiddle" id="speziallager-int">{{ $help->nf($resources->speziallager_int,2) }}%</td>
						</tr>
						<tr>
							<td class="text-center">Tanks<br />(Antimaterie)</td>
							<td class="text-center vmiddle">{{ $buildings->tanks }}</td>
							<td class="text-center vmiddle">{{ $help->nf($resources->tanks_cap) }} / <span id="tanks-resources">{{ $help->nf($resources->antimaterie) }}</span></td>
							<td class="text-center vmiddle countdown{{ $ttime < 86400 ? ' red' : ' green' }}" id="tanks-countdown" data-until="{{ $ttime }}">{{ $help->htime($ttime) }}</td>
							<td class="text-center vmiddle" id="tanks-int">{{ $help->nf($resources->tanks_int,2) }}%</td>
						</tr>
						<tr>
							<td class="text-center">Bunker<br />(alle Rohstoffe)</td>
							<td class="text-center vmiddle">{{ $buildings->bunker }}</td>
							<td class="text-center vmiddle">{{ $help->nf($resources->bunker_cap) }}</td>
							<td class="text-center vmiddle">-</td>
							<td class="text-center vmiddle" id="bunker-int">{{ $help->nf($resources->bunker_int,2) }}%</td>
						</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
		<div class="col-lg-12 col-sm-12 col-xs-12 col-sm-12 mb30">
			<h3>Rohstoffrechner</h3>
			<div class="gcontainer">
				<div class="panel panel-default mb0">
					<div class="panel-body white">
						<div class="col-md-6">
							<form class="form-inline" id="resprod">
								<div class="form-group">
									<label class="control-label mr5">Wie lange benötige ich für die Produktion von</label>
									<input type="text" name="amount" id="resprod-amount" class="form-control input-sm w15" />
									<select name="resource" class="form-control input-sm" id="resprod-resource">
										<option value="aluminium">Aluminium</option>
										<option value="titan">Titan</option>
										<option value="silizium">Silizium</option>
										<option value="arsen">Arsen</option>
										<option value="wasserstoff">Wasserstoff</option>
										<option value="antimaterie">Antimaterie</option>
									</select>
								</div>
								<br /><br />
								<div class="form-group">
									<input type="text" name="resprod-htime" id="resprod-htime" class="form-control input-sm text-center" value="-" readonly="disabled" />
									<input type="text" name="resprod-date" id="resprod-date" class="form-control input-sm text-center" value="-" readonly="disabled" />
								</div>
								<br /><br />
								<div class="form-group">
									<label class="control-label mr10">Vorhandene Rohstoffe einbeziehen?</label>
									<div class="checkbox">
										<input type="checkbox" id="resprod-useres" name="resprod-useres" value="1" />
									</div>
								</div>
							</form>
						</div>
						<div class="col-md-6">
							<form class="form-inline" id="restime">
								<div class="form-group">
									<label class="control-label mr5">Wieviel</label>
									<select name="resource" class="form-control input-sm" id="restime-resource">
										<option value="aluminium">Aluminium</option>
										<option value="titan">Titan</option>
										<option value="silizium">Silizium</option>
										<option value="arsen">Arsen</option>
										<option value="wasserstoff">Wasserstoff</option>
										<option value="antimaterie">Antimaterie</option>
									</select>
									<label class="control-label mr5 ml5">produziere ich in</label>
									<input type="text" name="amount" id="restime-hours" class="form-control input-sm w25" />
									<label class="control-label inline ml5">Stunden?</label>
								</div>
								<br /><br />
								<div class="form-group">
									<input type="text" name="restime-prod" id="restime-prod" class="form-control input-sm text-center" value="-" readonly="disabled" />
									<input type="text" name="restime-date" id="restime-date" class="form-control input-sm text-center" value="-" readonly="disabled" />
								</div>
								<br /><br />
								<div class="form-group">
									<label class="control-label">Vorhandene Rohstoffe einbeziehen?</label>
									<div class="checkbox">
										<input type="checkbox" id="restime-useres" name="resprod-useres" value="1" />
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<h3>Rohstoffdesintegrator</h3>
			<div class="gcontainer">
				<div class="panel panel-default mb0">
					<div class="panel-body white">
						<div class="col-md-12 text-center">
							<form class="form-inline" id="resdesint">
								<div class="form-group">
									<label class="control-label mr5">Wieviel</label>
									<select name="resdesint-resource" class="form-control input-sm" id="resdesint-resource">
										<option value="aluminium">Aluminium</option>
										<option value="titan">Titan</option>
										<option value="silizium">Silizium</option>
										<option value="arsen">Arsen</option>
										<option value="wasserstoff">Wasserstoff</option>
										<option value="antimaterie">Antimaterie</option>
									</select>
									<label class="control-label mr5 ml5">möchtest du vernichten?</label>
									<input type="text" name="resdesint-amount" id="resdesint-amount" class="form-control input-sm" />
									<button type="button" name="desintegrate" id="desintegrate" class="btn btn-default btn-sm"><i class="fa fa-check pr5"></i> Desintegrieren</button>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
@stop