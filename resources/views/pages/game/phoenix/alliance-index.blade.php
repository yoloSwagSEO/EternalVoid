@extends('pages.game.phoenix.game')
@section('content')
<div class="row">
				<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-xs-12">
					<h3 class="text-center">Allianz erstellen</h3>
					<div class="gcontainer">
						<div class="panel panel-default mb0">
							<div class="panel-body">
								@if(session('create'))
								@include('misc.messages')
								@endif

								<form action="/alliance/create" enctype="multipart/form-data" method="post" class="form-horizontal">
									<div class="form-group">
										<label for="alliance-name" class="col-xl-2 col-lg-2 col-md-4 col-sm-12 col-xs-12 control-label">Name deiner Allianz:</label>
										<div class="col-xl-10 col-lg-10 col-md-8 col-sm-12 col-xs-12">
											<input type="text" id="alliance-name" name="alliance-name" class="form-control" />
										</div>
									</div>
									<div class="form-group">
										<label for="alliance-tag" class="col-xl-2 col-lg-2 col-md-4 col-sm-12 col-xs-12 control-label">TAG deiner Allianz:</label>
										<div class="col-xl-10 col-lg-10 col-md-8 col-sm-12 col-xs-12">
											<input type="text" id="alliance-tag" name="alliance-tag" class="form-control" />
										</div>
									</div>
									<div class="form-group">
										<div class="col-xl-offset-2 col-lg-offset-2 col-md-offset-4 col-xl-10 col-lg-10 col-md-8 col-sm-12 col-xs-12">
											<button type="submit" id="alliance-create" name="alliance-create" class="btn btn-default"><i class="fa fa-check"></i> Allianz erstellen</button>
										</div>
									</div>
									{!! Form::token() !!}
								</form>
							</div>
						</div>
					</div>
				</div>
				<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-xs-12">
					<h3 class="text-center">Allianz beitreten</h3>
					<div class="gcontainer">
						<div class="panel panel-default mb0">
							<div class="panel-body">
								@if(Request::old('alliance-apply'))
								@include('misc.messages');
								@endif

								<form action="/alliance/applications/apply" enctype="multipart/form-data" method="post" class="form-horizontal">
									<div class="form-group">
										<label for="alliance-apply-tag" class="col-xl-2 col-lg-2 col-md-4 col-sm-12 col-xs-12 control-label">Allianz:</label>
										<div class="col-xl-10 col-lg-10 col-md-8 col-sm-12 col-xs-12">
											<select name="alliance-apply-tag" id="alliance-apply-tag" class="form-control">
												<option value="">&mdash;</option>
											@foreach($alliances as $alliance)

												<option value="{{ $alliance->id }}">{{ $alliance->alliance_tag }}</option>
											@endforeach

											</select>
										</div>
									</div>
									<div class="form-group">
										<label for="alliance-apply-text" class="col-xl-2 col-lg-2 col-md-4 col-sm-12 col-xs-12 control-label">Bewerbungstext:</label>
										<div class="col-xl-10 col-lg-10 col-md-8 col-sm-12 col-xs-12">
											<textarea id="alliance-apply-text" name="alliance-apply-text" class="form-control" rows="4" cols="40"></textarea>
										</div>
									</div>
									<div class="form-group">
										<div class="col-xl-offset-2 col-lg-offset-2 col-md-offset-4 col-xl-10 col-lg-10 col-md-8 col-sm-12 col-xs-12">
											<button type="submit" id="alliance-apply" name="alliance-apply" class="btn btn-default"><i class="fa fa-check"></i> Jetzt bewerben</button>
										</div>
									</div>
									{!! Form::token() !!}
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
@stop