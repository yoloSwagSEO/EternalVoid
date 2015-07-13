@extends('pages.game.phoenix.game')
@section('content')
<div class="row">
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<div class="gcontainer">
						<div class="panel panel-default mb0">
							<table class="table table-condensed table-bordered">
								<tr>
									<td rowspan="7" class="col-xs-1 p0">
										<img src="/img/game/planets/{{ $game['planets'][$plt->image] }}" />
									</td>
									<td class="vmiddle text-right">Besitzer:</td>
									<td class="vmiddle">{{ is_null($plt->user) ? 'Unbewohnt' : $plt->user->username }}</td>
								</tr>
								<tr>
									<td class="vmiddle text-right">Besiedelt am:</td>
									<td class="vmiddle">{{ !is_null($plt->settled_at) ? $plt->settled_at->format('d.m.Y - H:i:s') : '&mdash;' }}</td>
								</tr>
								<tr>
									<td class="vmiddle text-right">Durchmesser:</td>
									<td class="vmiddle">{{ $help->nf($plt->diameter) }} km</td>
								</tr>
								<tr>
									<td class="vmiddle text-right">Temperatur:</td>
									<td class="vmiddle">{{ $plt->temp_min }} °c bis {{ $plt->temp_max }} °c</td>
								</tr>
								<tr>
									<td class="vmiddle text-right">Planetentoplist:</td>
									<td class="vmiddle">&mdash;</td>
								</tr>
								<tr>
									<td class="vmiddle text-right">Aktionen:</td>
									<td class="vmiddle">
										<div class="btn-group btn-group-sm">
											<a href="/galaxy/{{ $plt->galaxy }}/{{ $plt->system }}" class="btn btn-default">
												<i class="fa fa-globe pr5"></i> Zur Galaxieansicht
											</a>
											<a href="/fleet/spy/{{ $plt->galaxy }}/{{ $plt->system }}" class="btn btn-default">
												<i class="fa fa-eye pr5"></i> Sondieren
											</a>
											<a href="/fleet/{{ $plt->galaxy }}/{{ $plt->system }}" class="btn btn-default">
												<i class="fa fa-plane pr5"></i> Flotte senden
											</a>
										</div>
									</td>
								</tr>
							</table>
						</div>
					</div>
				</div>
			</div>
@stop