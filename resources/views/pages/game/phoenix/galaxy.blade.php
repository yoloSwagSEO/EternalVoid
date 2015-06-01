@extends('pages.game.phoenix.game')
@section('content')
	<div class="row">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<form action="/galaxy" enctype="multipart/form-data" method="post" class="form-inline w100 center-block mb20" id="galaxyform">
				<a href="/options/planetimages" class="btn btn-default btn-sm posabs t30 mt5 r15">
					<i class="fa fa-{{ $user->profile->planetimages ? 'eye-slash' : 'eye' }} pr2 pl2"></i>
					Planetenbilder {{ $user->profile->planetimages ? 'ausblenden' : 'einblenden' }}
				</a>
				<div class="form-group w100 text-center mb3">
					<button type="submit" id="ok" name="ok" class="btn btn-default btn-sm ml2" title="Springe zu eingegebenen Koordinaten"><i class="fa fa-check fa-lg"></i></button>
				</div>
				<div class="w100 text-center">
					<div class="input-group">
							<span class="input-group-btn">
								<button type="submit" id="prevgalaxy" name="prevgalaxy" class="btn btn-default btn-sm" title="Vorherige Galaxie"><i class="fa fa-minus fa-lg"></i></button>
							</span>
						<input type="text" id="galaxy" name="galaxy" value="{{ $galaxy }}" class="form-control input-sm text-center"/>
							<span class="input-group-btn">
								<button type="submit" id="nextgalaxy" name="nextgalaxy" class="btn btn-default btn-sm ml-1" title="Nächste Galaxie"><i class="fa fa-plus fa-lg"></i></button>
							</span>
							<span class="input-group-btn">
								<button type="submit" id="home" name="home" class="btn btn-default btn-sm mr-2 ml-2" title="Heimatkoordinaten"><i class="fa fa-home fa-lg"></i></button>
							</span>
							<span class="input-group-btn">
								<button type="submit" id="prevsystem" name="prevsystem" class="btn btn-default btn-sm mr-1" title="Vorheriges System"><i class="fa fa-minus fa-lg"></i></button>
							</span>
						<input type="text" id="system" name="system" value="{{ $system }}" class="form-control input-sm text-center"/>
							<span class="input-group-btn">
								<button type="submit" id="nextsystem" name="nextsystem" class="btn btn-default btn-sm" title="Nächstes System"><i class="fa fa-plus fa-lg"></i></button>
							</span>
					</div>
				</div>
				{!! Form::token() !!}
			</form>
			<div class="gcontainer">
				<div class="panel panel-default mb0">
					<table class="table table-bordered table-hover table-condensed">
						<thead>
						<tr>
							<th colspan="{{ $user->profile->planetimages ? 2 : 1 }}" class="text-center">Bild</th>
							<th class="text-center">Trümmerfeld</th>
							<th class="text-center">Planetenname</th>
							<th class="text-center">Besitzer</th>
							<th class="text-center">Rasse</th>
							<th class="text-center">Allianz</th>
							<th class="text-center">Punkte</th>
							<th class="text-center">Aktionen</th>
						</tr>
						</thead>
						<tbody>
						@foreach($planets as $key => $p)
							<tr>
								<td class="w2 p0 text-center vmiddle">{{ $p->position }}</td>
								@if($user->profile->planetimages)

									<td class="w2 p0 text-center vmiddle"><img src="/img/game/planets/small/{{ $game['planets'][$p->image] }}" /></td>
								@endif

								<td class="w5 p0 text-center vmiddle">Nein</td>
								<td class="text-center vmiddle w20"><a href="/planet/detail/{{ $p->galaxy }}/{{ $p->system }}/{{ $p->position }}">{{ !empty($p->planetname) ? Crypt::decrypt($p->planetname) : 'Planet' }}</a></td>
								<td class="text-center vmiddle w20">
									@if(isset($p->user))
										<a href="/user/detail/{{ $p->user->username }}">{{{ $p->user->username }}}</a>
									@else
										-
									@endif
								</td>
								<td class="text-center vmiddle w20">
									@if(isset($p->user))
										<a href="/race/detail/{{ $p->user->profile->rid }}">{{ $p->user->profile->race->racename }}</a>
									@else
										-
									@endif
								</td>
								<td class="text-center vmiddle w8">
									@if(isset($p->user) && $p->user->profile->aid != 0)
										<a href="/alliance/detail/{{ $p->user->profile->alliance->alliance_tag }}">{{ $p->user->profile->alliance->alliance_tag }}</a>
									@else
										-
									@endif
								</td>
								<td class="text-center vmiddle w3">{{ $p->pkt }}</td>
								<td class="text-center vmiddle w20"></td>
							</tr>
						@endforeach
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
@stop