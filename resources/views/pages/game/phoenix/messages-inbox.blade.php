@extends('pages.game.phoenix.game')
@section('content')
	<div class="row">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			@include('misc.messages')

			<ul class="nav nav-tabs">
				<li><a href="/messages/new">Neue Nachricht</a></li>
				<li class="active"><a href="/messages/inbox">Posteingang ({{ !is_null($message_count) ? $message_count->num_inbox : 0 }})</a></li>
				<li><a href="/messages/outbox">Postausgang ({{ !is_null($message_count) ? $message_count->num_outbox : 0 }})</a></li>
				<li><a href="/messages/trash">Papierkorb ({{ !is_null($message_count) ? $message_count->num_trash : 0 }})</a></li>
				<li><a href="/messages/export">Nachrichten exportieren</a></li>
			</ul>
			<div class="gcontainer">
				<div class="panel panel-default mb0">
					<table class="table table-condensed table-hover table-bordered">
						<thead>
						<tr>
							<th class="text-center w1">Status</th>
							<th class="text-center">Betreff</th>
							<th class="text-center w15">Absender</th>
							<th class="text-center w20">Datum</th>
							<th class="text-center w9">Aktionen</th>
						</tr>
						</thead>
						<t{{ $messages->count() <= 1 ? 'foot' : 'body'}}>
						@forelse($messages as $key => $message)

							<tr>
								<td class="text-center cur-p">
									@if(is_null($message->read_at))

									<i class="fa fa-folder fa-lg" title="Neue Nachricht"></i>
									@else

									<i class="fa fa-folder-open fa-lg" title="Nachricht gelesen am: {{ $help->dt($message->read_at)->format('d.m.Y') }} um {{ $help->dt($message->read_at)->format('H:i:s') }} Uhr"></i>
									@endif

								</td>
								<td class="text-center"><a href="/messages/read/{{ $message->id }}">{{ $message->subject }}</a></td>
								<td class="text-center">
								@if(!is_null($message->sender))

									<a href="/user/detail/{{ $message->sender->username }}">{{ $message->sender->username }}</a>
								@else
									UniCom
								@endif
								</td>
								<td class="text-center">{{ $help->dt($message->created_at)->format('d.m.Y - H:i:s') }}</td>
								<td class="text-center">
								@if(is_null($message->read_at))

									<a href="/messages/markasread/{{ $message->id }}" title="Nachricht als gelesen markieren"><i class="fa fa-square-o fa-lg pr10 posrel t1"></i></a>
								@else

									<i class="fa fa-check-square-o fa-lg posrel t1 pr10 cur-p" title="Nachricht gelesen oder als gelesen markiert am: {{ $help->dt($message->read_at)->format('d.m.Y') }} um {{ $help->dt($message->read_at)->format('H:i:s') }} Uhr"></i>
								@endif

									<a href="/messages/move/trash/{{ $message->id }}" title="Nachricht in Papierkorb verschieben"><i class="fa fa-trash-o fa-lg pr10"></i></a>
									<a href="/messages/move/delete/{{ $message->id }}" title="Nachricht löschen"><i class="fa fa-times-circle fa-lg"></i></a>
								</td>
							</tr>
						@empty

							<tr>
								<td colspan="5" class="text-center p10"><strong>Es sind keine Nachrichten im Posteingang vorhanden.</strong></td>
							</tr>
						@endforelse

						</t{{ $messages->count() == 1 || $messages->count() == 0 ? 'foot' : 'body'}}>

					</table>
				</div>
			</div>
		</div>
	</div>
@stop