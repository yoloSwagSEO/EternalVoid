@extends('pages.game.phoenix.game')
@section('pagecss')
	{!! HTML::style('css/phoenix/sceditor.default.min.css') !!}
@stop
@section('content')

	<div class="row">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<ul class="nav nav-tabs">
				<li class="active"><a href="/messages/new">Neue Nachricht</a></li>
				<li><a href="/messages/inbox">Posteingang ({{ !is_null($message_count) ? $message_count->num_inbox : 0 }})</a></li>
				<li><a href="/messages/outbox">Postausgang ({{ !is_null($message_count) ? $message_count->num_outbox : 0 }})</a></li>
				<li><a href="/messages/trash">Papierkorb ({{ !is_null($message_count) ? $message_count->num_trash : 0 }})</a></li>
				<li><a href="/messages/export">Nachrichten exportieren</a></li>
			</ul>
			<div class="gcontainer">
				<div class="panel panel-default p20 mb0">
					@include('misc.messages')
					@include('misc.preview')

					<form action="/messages/new" enctype="multipart/form-data" method="post" class="form-horizontal">
						<div class="form-group">
							<label for="receiver" class="col-md-2 control-label pt3">Empfänger:</label>
							<div class="col-md-10 posrel">
								<input type="text" id="receiver" name="receiver" class="form-control input-sm" value="{{ Request::old('receiver', isset($message) ? $message->sender->username : '') }}" autocomplete="off" />
								<div class="receivers posabs zi100">
									<ul>

									</ul>
								</div>
							</div>
						</div>
						<div class="form-group">
							<label for="subject" class="col-md-2 control-label pt3">Betreff:</label>
							<div class="col-md-10">
								<input type="text" id="subject" name="subject" class="form-control input-sm" value="{{ Request::old('subject', isset($message) ? 'RE: '.$message->subject : '') }}"/>
							</div>
						</div>
						<div class="form-group">
							<label for="message" class="col-md-2 control-label pt3">Nachricht:</label>
							<div class="col-md-10">
									<textarea name="message" id="message" class="form-control input-sm sceditor" rows="15">{{ Request::old('message', isset($message) ? $message->sender->username.' schrieb:[QUOTE]'.$message->message.'[/QUOTE]' : '') }}</textarea>
							</div>
						</div>
						<div class="form-group">
							<div class="col-md-10 col-md-offset-2 btn-group btn-group-sm">
								<button type="submit" id="send" name="send" class="btn btn-default"><i class="fa fa-check pr5"></i> Absenden</button>
								<button type="button" id="preview" name="preview" class="btn btn-default" data-toggle="modal" data-target="#preview-modal">
									<i class="fa fa-eye pr5"></i> Vorschau
								</button>
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