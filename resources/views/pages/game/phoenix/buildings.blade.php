@extends('pages.game.phoenix.game')
@section('pagecss')
	{!! HTML::style('css/'.session('universe').'/phoenix-build.css') !!}
@stop
@section('content')
	<div class="row">
		<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
			@if(!$current_build_jobs->isEmpty())

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
						<{{ $current_build_jobs->count() == 1 ? 'tfoot' : 'tbody' }}>
						@foreach($current_build_jobs as $key => $build)
						<?php $data = unserialize($build['data']); ?>

							<tr>
							<td class="p5 vmiddle">{{ $data['name'] }}</td>
							<td class="p5 vmiddle">{{ $help->htime($data['time']) }}</td>
							<td class="w15 p5 vmiddle"><span class="countdown" id="countdown-{{ str_random() }}" data-until="{{ $data['remaining'] }}">{{ $help->htime($data['remaining']) }}</span></td>
								<td class="w15 p5 vmiddle">{{ $build->finished_at->format('d.m.Y - H:i:s') }}</td>
								<td class="w75 p5 vmiddle">
									<div class="progress mb0" data-time="{{ $data['time'] }}" data-remaining="{{ $data['remaining'] }}">
										<div class="progress-bar progress-bar-success" role="progressbar" style="width: {{ round(100 - (($data['remaining'] / $data['time']) * 100), 2) }}%">
											{{ round(100 - (($data['remaining'] / $data['time']) * 100),2) }}%
										</div>
									</div>
								</td>
								<td class="w5 text-center">
									<a href="/buildings/cancel/{{ $build->id }}" title="Abbrechen"><i class="fa fa-times-circle fa-lg"></i></a>
								</td>
							</tr>
						@endforeach

						</{{ $current_build_jobs->count() == 1 ? 'tfoot' : 'tbody' }}>
					</table>
				</div>
			</div>
			@endif

			<div class="row">
			@foreach($buildings as $build => $building)

				<div class="col-lg-2 col-md-2 col-sm-3 col-xs-4 item">
					<div class="gcontainer">
						<div class="posrel">
							<div class="overlay_top">{{ $building['name'] }}</div>
							<img src="{{ $building['image'] }}" alt="{{ $building['name'] }}" class="m0 w100 ha" />
							<div class="overlay_btm">{{ $planet->buildings->{$build} }}{!! $building['level'] != 0 ? '<span class="green"> + '.$building['level'].'</span>' : '' !!}</div>
						</div>
						<div class="row m0">
							<div class="col-xl-12 col-lg-12 col-sm-12 col-sm-12 p0">
								<div class="btn-group btn-group-justified posrel mb0">
									<span class="btn btn-default tt" data-toggle="tooltip" title="{{ $building['description'] }}"><i class="fa fa-info fa-lg"></i></span>
									<span class="btn btn-default tt" data-toggle="tooltip" title="Aluminium: <span class='{{ $building['aluminium'] > $resources->aluminium ? 'red' : 'green'}}'>{{ $help->nf($building['aluminium']) }}</span><br />
										Titan: <span class='{{ $building['titan'] > $resources->titan ? 'red' : 'green' }}'>{{ $help->nf($building['titan']) }}</span><br />
										{!! $building['silizium'] > 0 ? 'Silizium: <span class=\''.($building['silizium'] > $resources->silizium ? 'red' : 'green').'\'>'.$help->nf($building['silizium']).'</span><br /><br />' : '<br />' !!}
										{!! $building['production'] > 0 ? 'Produktion: '.$help->nf($building['production']).'<br />' : '' !!}
										{!! $building['capacity'] > 0 ? 'Kapazität: '.$help->nf($building['capacity']).'<br />' : '' !!}
										Bauzeit: {{ $help->htime($building['time']) }}<br /><br />
										Rohstoffe verfügbar in: {!! $building['restime'] > 0 ? '<span class=\'red\'>'.$help->htime($building['restime']).'</span>' : '<span class=\'green\'>Sofort verfügbar</span>' !!}">
										<i class="fa fa-bar-chart-o fa-lg"></i>
									</span>
									@if($building['build'] === false)

										<span class="btn btn-default"><i class="fa fa-arrow-circle-up fa-lg"></i></span>
									@else

										<a href="/buildings/start/{{ $build }}" class="btn btn-default"><i class="fa fa-arrow-circle-up fa-lg"></i></a>
									@endif
								</div>
							</div>
						</div>
					</div>
				</div>
			@endforeach

			</div>
		</div>
	</div>
@stop