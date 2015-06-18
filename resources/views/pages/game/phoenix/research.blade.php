@extends('pages.game.phoenix.game')
@section('pagecss')
	{!! HTML::style('css/'.session('universe').'/phoenix-build.css') !!}
@stop
@section('content')
	<div class="row">
		<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
			@if($planet->buildings->forschungszentrum > 0)
			@if(!$current_research_jobs->isEmpty())

			<div class="ccontainer mb20">
				<div class="panel panel-default mb0">
					<table class="table table-bordered table-hover">
						<thead class="ttu">
							<tr>
								<th class="w15 pt10 pb10 pl5">Objekt</th>
								<th class="w15 pt10 pb10 pl5">Benötigte Zeit</th>
								<th colspan="4" class="w70 pt10 pb10 pl5">Fertigstellung</th>
							</tr>
						</thead>
						<{{ $current_research_jobs->count() == 1 ? 'tfoot' : 'tbody' }}>
						@foreach($current_research_jobs as $key => $tech)
						<?php $data = unserialize($tech['data']); ?>

							<tr>
								<td class="p5 vmiddle">{{ $data['name'] }}</td>
								<td class="p5 vmiddle">{{ $help->htime($data['time']) }}</td>
								<td class="w15 p5 vmiddle"><span class="countdown" id="countdown-{{ str_random() }}" data-until="{{ $data['remaining'] }}">{{ $help->htime($data['remaining']) }}</span></td>
								<td class="w15 p5 vmiddle">{{ $tech->finished_at->format('d.m.Y - H:i:s') }}</td>
								<td class="w75 p5 vmiddle">
									<div class="progress mb0" data-time="{{ $data['time'] }}" data-remaining="{{ $data['remaining'] }}">
										<div class="progress-bar progress-bar-success" role="progressbar" style="width:{{ round(100 - (($data['remaining'] / $data['time']) * 100),2) }}%">
											{{ round(100 - (($data['remaining'] / $data['time']) * 100),2) }}%
										</div>
									</div>
								</td>
								<td class="w5 text-center">
									<a href="/research/cancel/{{ $tech->id }}" title="Abbrechen"><i class="fa fa-times-circle fa-lg"></i></a>
								</td>
							</tr>
						@endforeach

						</{{ $current_research_jobs->count() == 1 ? 'tfoot' : 'tbody' }}>
					</table>
				</div>
			</div>
			@endif
			<div class="row">
			@foreach($techs as $t => $tech)

				<div class="col-lg-2 col-md-2 col-sm-3 col-xs-4 item">
					<div class="gcontainer">
						<div class="posrel">
							<div class="overlay_top">{{ $tech['name'] }}</div>
							<img src="{{ $tech['image'] }}" alt="{{ $tech['name'] }}" class="m0 w100 ha" />
							<div class="overlay_btm">{{ $research->{$t} }}{!! $tech['level'] != 0 ? '<span class="green"> + '.$tech['level'].'</span>' : '' !!}</div>
						</div>
						<div class="row m0">
							<div class="col-xl-12 col-lg-12 col-sm-12 col-sm-12 p0">
								<div class="btn-group btn-group-justified posrel mb0">
									<span class="btn btn-default tt" data-toggle="tooltip" title="{{ $tech['description'] }}"><i class="fa fa-info fa-lg"></i></span>
									<span class="btn btn-default tt" data-toggle="tooltip" title="
										{!! $tech['aluminium'] > 0 ? 'Aluminium: <span class=\''.($tech['aluminium'] > $resources->aluminium ? 'red' : 'green').'\'>'.$help->nf($tech['aluminium']).'</span><br />' : '' !!}
										{!! $tech['titan'] > 0 ? 'Titan: <span class=\''.($tech['titan'] > $resources->titan ? 'red' : 'green').'\'>'.$help->nf($tech['titan']).'</span><br />' : '' !!}
										{!! $tech['silizium'] > 0 ? 'Silizium: <span class=\''.($tech['silizium'] > $resources->silizium ? 'red' : 'green').'\'>'.$help->nf($tech['silizium']).'</span><br />' : '' !!}
										{!! $tech['arsen'] > 0 ? 'Arsen: <span class=\''.($tech['arsen'] > $resources->arsen ? 'red' : 'green').'\'>'.$help->nf($tech['arsen']).'</span><br />' : '' !!}
										{!! $tech['wasserstoff'] > 0 ? 'Wasserstoff: <span class=\''.($tech['wasserstoff'] > $resources->wasserstoff ? 'red' : 'green').'\'>'.$help->nf($tech['wasserstoff']).'</span><br />' : '' !!}
										{!! $tech['antimaterie'] > 0 ? 'Antimaterie: <span class=\''.($tech['antimaterie'] > $resources->antimaterie ? 'red' : 'green').'\'>'.$help->nf($tech['antimaterie']).'</span><br />' : '' !!}
										<br />Forschungszeit: {{ $help->htime($tech['time']) }}<br /><br />
										Rohstoffe verfügbar in: {!! $tech['restime'] > 0 ? '<span class=\'red\'>'.$help->htime($tech['restime']).'</span>' : '<span class=\'green\'>Sofort verfügbar</span>' !!}">
										<i class="fa fa-bar-chart-o fa-lg"></i>
									</span>
									@if($tech['build'] === false)

									<span class="btn btn-default"><i class="fa fa-arrow-circle-up fa-lg"></i></span>
									@else

									<a href="/research/start/{{ $t }}" class="btn btn-default"><i class="fa fa-arrow-circle-up fa-lg"></i></a>
									@endif
								</div>
							</div>
						</div>
					</div>
				</div>
			@endforeach

			</div>
			@else

			<h2 class="text-center"><i class="fa fa-i$help->nfo-circle fa-4x"></i></h2>
			<h3 class="text-center ttu">Um zu forschen musst du zuerst das Forschungszentrum ausbauen.</h3>
			@endif

		</div>
	</div>
@stop