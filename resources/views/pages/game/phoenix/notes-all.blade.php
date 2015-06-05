@extends('pages.game.phoenix.game')
@section('content')
	<div class="row">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			@include('misc.messages')

			<ul class="nav nav-tabs">
				<li class="active"><a href="/notes">Alle Notizen</a></li>
				<li><a href="/notes/new">Neue Notiz erstellen</a></li>
			</ul>
			<div class="gcontainer">
				<div class="panel panel-default mb0">
					<table class="table table-condensed table-hover table-bordered">
						<thead>
						<tr>
							<th class="text-center w1">#</th>
							<th class="text-center">Betreff</th>
							<th class="text-center w20">Datum</th>
							<th class="text-center w9">Aktionen</th>
						</tr>
						</thead>
						<t{{ $notes->count() > 1 ? 'body' : 'foot'}}>
						@forelse($notes as $key => $note)

							<tr>
								<td class="text-center">{{ $key + 1 }}</td>
								<td class="text-center"><a href="/notes/read/{{ $note->id }}">{{{ $note->subject }}}</a></td>
								<td class="text-center">{{ $note->created_at->format('d.m.Y - H:i:s') }}</td>
								<td class="text-center">
									<a href="/notes/edit/{{ $note->id }}" title="Notiz bearbeiten"><i class="fa fa-edit fa-lg pr10"></i></a>
									<a href="/notes/delete/{{ $note->id }}" title="Notiz löschen" class="dellink" data-message="Willst du diese Notiz wirklich löschen?"><i class="fa fa-trash-o fa-lg"></i></a>
								</td>
							</tr>
						@empty

							<tr>
								<td colspan="4" class="text-center p10"><strong>Es wurden noch keine Notizen erstellt.</strong></td>
							</tr>
						@endforelse

						</t{{ $notes->count() > 1 ? 'body' : 'foot'}}>
					</table>
				</div>
			</div>
		</div>
	</div>
@stop