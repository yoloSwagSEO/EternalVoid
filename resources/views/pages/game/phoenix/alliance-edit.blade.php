@extends('pages.game.phoenix.game')
@section('content')
	<div class="row crow">
		<div class="col-md-12">
			<ul class="nav nav-tabs">
				<li><a href="/alliance">{{ $alliance->alliance_tag }} &mdash; {{ $alliance->alliance_name }}</a></li>
				@if($permissions['edit_alliance'])<li class="active"><a href="/alliance/edit">Bearbeiten</a></li>@endif
				@if($permissions['view_applications'])<li><a href="/alliance/applications">Bewerbungen (0)</a></li>@endif
				@if($permissions['view_members'])<li><a href="/alliance/members">Mitglieder ({{ $alliance->memberCount->count() }})</a></li>@endif
				@if($permissions['view_messages'])<li><a href="/alliance/messages">Nachrichten</a></li>@endif
				@if($permissions['view_reports'])<li><a href="/alliance/reports">Berichte</a></li>@endif
				<li><a href="/alliance/leave" class="dellink" data-message="Willst du diese Allianz wirklich verlassen?">Verlassen</a></li>
			</ul>
			<div class="gcontainer">
				<div class="panel panel-default mb0 p20">
					@include('misc.messages')

					<form action="/alliance/edit" enctype="multipart/form-data" method="post" class="form-horizontal">
						<div class="form-group">
							<label for="alliancename" class="control-label col-md-2 pt5">Allianz-Name:</label>
							<div class="col-md-10">
								<input type="text" id="alliance-name" name="alliance-name" class="form-control input-sm" value="{{ Request::old('alliance-name', $alliance->alliance_name) }}" />
							</div>
						</div>
						<div class="form-group">
							<label for="alliancetag" class="control-label col-md-2 pt5">Allianz-TAG:</label>
							<div class="col-md-10">
								<input type="text" id="alliance-tag" name="alliance-tag" class="form-control input-sm" value="{{ Request::old('alliance-tag', $alliance->alliance_tag) }}" />
							</div>
						</div>
						<div class="form-group">
							<label for="alliancelogo" class="control-label col-md-2 pt5">Allianz-Logo:</label>
							<div class="col-md-10">
								<input type="text" id="alliance-logo" name="alliance-logo" class="form-control input-sm" value="{{ Request::old('alliance-logo', Crypt::decrypt($alliance->alliance_logo)) }}" />
							</div>
						</div>
						<div class="form-group">
							<label for="alliancewebsite" class="control-label col-md-2 pt5">Allianz-Website:</label>
							<div class="col-md-10">
								<input type="text" id="alliance-website" name="alliance-website" class="form-control input-sm" value="{{ Request::old('alliance-website', Crypt::decrypt($alliance->alliance_website)) }}" />

							</div>
						</div>
						<div class="form-group">
							<label for="alliancebackground" class="control-label col-md-2 pt25">Beschreibung-Hintergrund:</label>
							<div class="col-md-10">
								<small>URL zum Bild oder Farbwert in HEX &mdash; <a href="http://www.hexfarben.de/">Farbwähler <i class="fa fa-external-link"></i></a></small>
								<input type="text" id="alliance-background" name="alliance-background" class="form-control input-sm" value="{{ Request::old('alliance-background', Crypt::decrypt($alliance->alliance_background)) }}" />
							</div>
						</div>
						<div class="form-group">
							<label for="alliancedescription" class="control-label col-md-2 pt5">Beschreibung:<br /><small><a href="/alliance/bbcode">BBCode-Hilfe</a></small></label>
							<div class="col-md-10">
								<textarea name="alliance-description" id="alliance-description" class="form-control input-sm" rows="10">{{ Request::old('alliance-description', Crypt::decrypt($alliance->alliance_description)) }}</textarea>
							</div>
						</div>
						<div class="form-group">
							<div class="col-lg-offset-2 col-lg-10 col-md-offset-3 col-md-9 col-sm-12 col-xs-12">
								<button type="submit" id="savealliance" name="savealliance" class="btn btn-default">
									<i class="fa fa-check"></i> Allianz bearbeiten
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