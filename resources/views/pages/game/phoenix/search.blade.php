@extends('pages.game.phoenix.game')
@section('content')
	<div class="row">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			@include('misc.messages')

			<div class="gcontainer text-center">
				<div class="panel panel-default mb0">
					<div class="panel-body white">
						<form action="/search" enctype="multipart/form-data" method="post" class="form-inline">
							<div class="form-group">
								<label class="control-label mr5" for="searchtype">Wonach suchen?</label>
								<select name="searchtype" class="form-control" id="searchtype">
									<option value="user">Spieler</option>
									<option value="alliance">Allianzen</option>
									<option value="planet">Planeten</option>
								</select>
								<input type="text" name="searchterm" id="searchterm" class="form-control" />
								<button type="submit" name="search" id="search" class="btn btn-default">
									<i class="fa fa-search"></i>
								</button>
							</div>
							{!! Form::token() !!}
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
@stop