@extends('pages.game.phoenix.game')
@section('pagecss')
	{!! HTML::style('css/phoenix/sceditor.default.min.css') !!}
@stop
@section('content')
	<div class="row">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			@include('misc.messages')
			@include('misc.preview')

			<ul class="nav nav-tabs">
				<li><a href="/notes">Alle Notizen</a></li>
				<li class="active"><a href="/notes/new">Neue Notiz erstellen</a></li>
			</ul>
			<div class="gcontainer">
				<div class="panel panel-default p20 mb0">
					<form action="/notes/new" enctype="multipart/form-data" method="post" class="form-horizontal">
						<div class="form-group">
							<label for="subject" class="col-md-2 control-label pt3">Betreff:</label>
							<div class="col-md-10">
								<input type="text" id="subject" name="subject" class="form-control input-sm" value="{{ Request::old('subject') }}"/>
							</div>
						</div>
						<div class="form-group">
							<label for="note" class="col-md-2 control-label pt3">Nachricht:</label>
							<div class="col-md-10">
								<textarea name="note" id="note" class="form-control input-sm sceditor" rows="10">{{ Request::old('note') }}</textarea>
							</div>
						</div>
						<div class="form-group">
							<div class="col-md-10 col-md-offset-2 btn-group">
								<button type="submit" id="send" name="send" class="btn btn-default"><i class="fa fa-check pr5"></i> Erstellen</button>
								<button type="button" id="preview" name="preview" class="btn btn-default" data-toggle="modal" data-target="#preview-modal"><i class="fa fa-eye pr5"></i> Vorschau</button>
							</div>
						</div>
						{!! Form::token() !!}
					</form>
				</div>
			</div>
		</div>
	</div>
@stop
@section('pagejs')
	{!! HTML::script('js/game/jquery.sceditor.js') !!}
	{!! HTML::script('js/game/jquery.sceditor.bbcode.js') !!}
@stop