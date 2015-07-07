@extends('pages.game.phoenix.game')
@section('content')
	<div class="row">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<ul class="nav nav-tabs">
				<li class="active"><a href="/alliance">{{ $alliance->alliance_tag }} &mdash; {{ $alliance->alliance_name }}</a></li>
				@if($permissions['edit_alliance'])<li><a href="/alliance/edit">Bearbeiten</a></li>@endif
				@if($permissions['view_applications'])<li><a href="/alliance/applications">Bewerbungen (0)</a></li>@endif
				@if($permissions['view_members'])<li><a href="/alliance/members">Mitglieder ({{ $alliance->memberCount->count() }})</a></li>@endif
				@if($permissions['view_messages'])<li><a href="/alliance/messages">Nachrichten</a></li>@endif
				@if($permissions['view_reports'])<li><a href="/alliance/reports">Berichte</a></li>@endif
				<li><a href="/alliance/leave" class="dellink" data-message="Willst du diese Allianz wirklich verlassen?">Verlassen</a></li>
			</ul>
			<div class="gcontainer">
				<div class="panel panel-default mb0">
					<table class="table table-condensed table-bordered">
						@if(!empty(Crypt::decrypt($alliance->alliance_logo)))

							<tr>
								<td colspan="2" class="p0"{!! !empty(Crypt::decrypt($alliance_background)) ? ' style="background:'.Crypt::decrypt($alliance_background).';"' : '' !!}">
									<img src="{{ Crypt::decrypt($alliance->alliance_logo) }}" alt="Logo von {{ $alliance->alliance_name }}" title="Logo von {{ $alliance->alliance_name }}" />
								</td>
							</tr>
						@endif
						@if(!empty(Crypt::decrypt($alliance->alliance_description)))

							<tr>
								<td colspan="2" class="p0"{!! !empty(Crypt::decrypt($alliance->alliance_background)) ? ' style="background:'.Crypt::decrypt($alliance->alliance_background).';"' : ''; !!}>
									{{ Crypt::decrypt($alliance->alliance_description) }}
								</td>
							</tr>
						@endif

						<tr>
							<td class="text-right bold w50">Allianz-TAG:</td>
							<td>{{ $alliance->alliance_tag }}</td>
						</tr>
						<tr>
							<td class="text-right bold w50">Allianz-Name:</td>
							<td>{{ $alliance->alliance_name }}</td>
						</tr>
						<tr>
							<td class="text-right bold w50">Gründungsdatum:</td>
							<td>{{ $alliance->created_at->format('d.m.Y - H:i:s') }}</td>
						</tr>
						<tr>
							<td class="text-right bold w50">Mitglieder:</td>
							<td>
								@if($permissions['view_members'])
								<a href="/alliance/members">{{ $alliance->memberCount->count() }}</a>
								@else
								{{ $alliance->memberCount->count() }}
								@endif
							</td>
						</tr>
						@if(!empty(Crypt::decrypt($alliance->alliance_website)))

							<tr>
								<td class="text-right bold w50">Website:</td>
								<td><a href="{{ !strstr(Crypt::decrypt($alliance->alliance_website),'http') ? 'http://'.Crypt::decrypt($alliance->alliance_website) : Crypt::decrypt($alliance->alliance_website) }}">{{ Crypt::decrypt($alliance->alliance_website) }}</a></td>
							</tr>
						@endif

					</table>
				</div>
			</div>
		</div>
	</div>
@stop