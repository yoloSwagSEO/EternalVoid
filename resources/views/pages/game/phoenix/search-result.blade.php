@extends('pages.game.phoenix.game')
@section('content')
	<div class="row">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="gcontainer text-center mb30">
				<div class="panel panel-default mb0">
					<div class="panel-body white">
						<form action="/search" enctype="multipart/form-data" method="post" class="form-inline">
							<div class="form-group">
								<label class="control-label mr5" for="searchtype">Wonach suchen?</label>
								<select name="searchtype" class="form-control input-sm" id="searchtype">
									<option value="user"{!! $searchtype == 'user' ? ' selected="selected"' : '' !!}>Spieler</option>
									<option value="alliance"{!! $searchtype == 'alliance' ? ' selected="selected"' : '' !!}>Allianzen</option>
									<option value="planet"{!! $searchtype == 'planet' ? ' selected="selected"' : '' !!}>Planeten</option>
								</select>
								<input type="text" name="searchterm" id="searchterm" class="form-control input-sm" value="{{ $searchterm }}"/>
								<button type="submit" name="search" id="search" class="btn btn-default btn-sm">
									<i class="fa fa-search"></i>
								</button>
							</div>
							{!! Form::token() !!}
						</form>
					</div>
				</div>
			</div>
			<div class="gcontainer">
				<div class="panel panel-default mb0">
					<table class="table table-bordered table-hover mb0">
						<thead class="ttu">
							<tr>
								@if($searchtype == 'user')

								<th>Spielername</th>
								<th>Allianz</th>
								<th>Heimatplanet</th>
								<th>Position</th>
								<th>Highscoreplatz</th>
								<th>Aktion</th>
								@elseif($searchtype == 'planet')

								<th>Spielername</th>
								<th>Allianz</th>
								<th>Planet</th>
								<th>Position</th>
								<th>Highscoreplatz</th>
								<th>Aktion</th>
								@else

								<th>Tag</th>
								<th>Allianzname</th>
								<th>Mitglieder</th>
								<th>Punkte</th>
								<th>Aktion</th>
								@endif

							</tr>
						</thead>
						<t{{ $results->count() > 1 ? 'body' : 'foot'}}>
						@forelse($results as $result)
							<tr>
								@if($searchtype == 'user')

								<td>{{ $result->username }}</td>
								<td></td>
								<td>{{ empty($result->planet->planetname) ? 'Planet' : $result->planet->planetname }}</td>
								<td>{{ $result->planets->first()->galaxy.':'.$result->planets->first()->system.':'.$result->planets->first()->position }}</td>
								<td></td>
								<td></td>
								@elseif($searchtype == 'planet')

								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								@else

								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								@endif

							</tr>
						@empty
							<tr>
								<td colspan="6" class="text-center p10">
									<strong>Es wurden keine Ergebnisse gefunden.</strong>
								</td>
							</tr>
						@endforelse
						</t{{ $results->count() > 1 ? 'body' : 'foot'}}>
					</table>
				</div>
			</div>
		</div>
	</div>
@stop