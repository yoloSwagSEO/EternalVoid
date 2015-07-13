@extends('pages.game.phoenix.game')
@section('content')
	<div class="row">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<ul class="nav nav-tabs">
				<li><a href="/notes">Alle Notizen</a></li>
				<li class="active"><a href="/notes/read/{{ $note->id }}">Notiz "{{ $note->subject }}" lesen</a></li>
			</ul>
			<div class="gcontainer">
				<div class="panel panel-default mb0">
					<div class="panel-body white pt30">
						<div class="row mb10">
							<div class="col-md-2 text-right"><strong>Betreff:</strong></div>
							<div class="col-md-10">{{{ $note->subject }}}</div>
						</div>
						<div class="row mb30">
							<div class="col-md-2 text-right"><strong>Notiz:</strong></div>
							<div class="col-md-10">{{ $note->note }}</div>
						</div>
						<div class="form-group">
							<div class="btn-group col-md-10 col-md-offset-2 pl0">
								<a href="/notes/edit/{{ $note->id }}" class="btn btn-default"><i class="fa fa-edit pr5"></i> Notiz bearbeiten</i></a>
								<a href="/notes/delete/{{ $note->id }}" class="btn btn-default dellink" data-message="Willst du diese Notiz wirklich löschen?"><i class="fa fa-trash-o pr5"></i> Notiz löschen</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
@stop