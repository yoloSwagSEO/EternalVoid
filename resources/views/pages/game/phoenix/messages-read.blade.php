@extends('pages.game.phoenix.game')
@section('content')

	<div class="row">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<ul class="nav nav-tabs">
				<li><a href="/messages/new">Neue Nachricht</a></li>
				<li class="active"><a href="/messages/inbox">Posteingang ({{ !is_null($message_count) ? $message_count->num_inbox : 0 }})</a></li>
				<li><a href="/messages/outbox">Postausgang ({{ !is_null($message_count) ? $message_count->num_outbox : 0 }})</a></li>
				<li><a href="/messages/trash">Papierkorb ({{ !is_null($message_count) ? $message_count->num_trash : 0 }})</a></li>
				<li><a href="/messages/export">Nachrichten exportieren</a></li>
			</ul>
			<div class="gcontainer">
				<div class="panel panel-default mb0">
					<div class="panel-body white pt30">
						<div class="row mb10">
							<div class="col-md-2 text-right"><strong>Absender:</strong></div>
							<div class="col-md-10">
								@if(!is_null($message->sender))
									{{ $message->sender->username }}
								@else
									UniCom
								@endif
							</div>
						</div>
						<div class="row mb10">
							<div class="col-md-2 text-right"><strong>Empfänger:</strong></div>
							<div class="col-md-10">{{ $message->receiver->username }}</div>
						</div>
						<div class="row mb30">
							<div class="col-md-2 text-right"><strong>Gesendet am:</strong></div>
							<div class="col-md-10">{{ $help->dt($message->read_at)->format('d.m.Y') }} um {{ $help->dt($message->read_at)->format('H:i:s') }} Uhr</div>
						</div>
						<div class="row mb30">
							<div class="col-md-2 text-right"><strong>Betreff:</strong></div>
							<div class="col-md-10">{{ $message->subject }}</div>
						</div>
						<div class="row mb30">
							<div class="col-md-2 text-right"><strong>Nachricht:</strong></div>
							<div class="col-md-10">{{ $message->message }}</div>
						</div>
						<div class="form-group">
							<div class="btn-group btn-group-sm col-md-10 col-md-offset-2 pl0">
								<a href="/messages/reply/{{ $message->id }}" class="btn btn-default"><i class="fa fa-reply pr5"></i> Antworten</a>
								<a href="/messages/move/{{ $message->receiver_folder == 3 || $message->sender_folder == 3 ? 'recover/'.$message->id : 'trash/'.$message->id }}" class="btn btn-default">
									<i class="fa fa-{{ $message->receiver_folder == 3 || $message->sender_folder == 3 ? 'undo' : 'trash-o' }} pr5"></i>
									{{ $message->receiver_folder == 3 || $message->sender_folder == 3 ? 'Wiederherstellen' : 'In Papierkorb verschieben' }}
								</a>
								<a href="/messages/move/delete/{{ $message->id }}" class="btn btn-default"><i class="fa fa-times-circle pr5"></i> Löschen</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
@stop