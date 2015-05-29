@extends('layouts.master')
@section('content')
	<h2 class="f32 u mb20">Early Access</h2>
	<p>
		Da durch den Neubau der Software vieles einfacher und auch in Zukunft schneller umsetzbar sein wird, habe
		ich mich dazu entschlossen, den bisherigen Stand als Early Access zugänglich zu machen. So könnt ihr, wenn ihr denn wollt,
		mit den bisher gebauten Features rum experimentieren und euch ebenso einen ersten Eindruck von dem Spiel verschaffen.<br /><br />
		Darüber hinaus wäre es schön, wenn jeder der testet, mir Feedback über den bisherigen Stand geben kann.
	</p>
	<p>

		Wie ist die Handhabung, Benutzerführung, Geschwindigkeit oder sind euch schwerwiegende Fehler in den bisher fertigen
		Abschnitten aufgefallen? Dann schreibt entweder in's Forum unterhalb der "Bugreport" Sektion oder direkt eine Mail an mich,
		sollte eure Bug-Entdeckung doch schwerwiegender sein.
	</p>
	<h3 class="f28 u mb20">Disclaimer:</h3>
	<p>
		Damit keine Enttäuschung eintritt - denn vieles funktioniert wirklich noch nicht - will ich eines hiermit hervorheben:<br /><br />
		<strong>Early Access heißt zu gut Deutsch, dass ihr in einer <span class="red">(Pre)Alpha-Version</span> rumspielt, die NICHT das endgültige Produkt darstellt.</strong>
	</p>
	<div class="row mt30">
		<div class="col-md-6">
			<h3 class="f28 u mb30">Registrierung</h3>
			@if(Request::old('register'))
				@include('messages')
			@endif
			<form action="/users/register" enctype="multipart/form-data" method="post" class="form-horizontal">
				<div class="form-group mb30">
					<label for="universe" class="control-label col-md-4 pt5">Universum:</label>
					<div class="col-md-8">
						<select name="universe" id="universe" class="form-control input-sm">
							<option value="phoenix"{!! Request::old('universe') == 'phoenix' ? ' selected="selected"' : '' !!}>Phoenix</option>
						</select>
					</div>
				</div>
				<div class="form-group mt30">
					<label for="email" class="control-label col-md-4 pt5">E-Mail Adresse:</label>
					<div class="col-md-8">
						<input type="text" id="email" name="email" class="form-control input-sm" value="{!! Request::old('email') !!}" />
					</div>
				</div>
				<div class="form-group">
					<label for="password" class="control-label col-md-4 pt5">Passwort:</label>
					<div class="col-md-8">
						<input type="password" id="password" name="password" class="form-control input-sm" />
					</div>
				</div>
				<div class="form-group mb30">
					<label for="password_cnf" class="control-label col-md-4 pt5">Passwort bestätigen:</label>
					<div class="col-md-8">
						<input type="password" id="password_cnf" name="password_cnf" class="form-control input-sm" />
					</div>
				</div>
				<div class="form-group mt30">
					<label for="username" class="control-label col-md-4 pt5">Spielername:</label>
					<div class="col-md-8">
						<input type="text" id="username" name="username" class="form-control input-sm" value="{!! Request::old('username') !!}" />
					</div>
				</div>
				<div class="form-group">
					<label for="race" class="control-label col-md-4 pt5">Rasse:</label>
					<div class="col-md-8">
						<select name="race" id="race" class="form-control input-sm">
							<option value="1"{!! Request::old('race') == 1 ? ' selected="selected"' : '' !!}>Menschen</option>
							<option value="2"{!! Request::old('race') == 2 ? ' selected="selected"' : '' !!}>Sleirk</option>
							<option value="3"{!! Request::old('race') == 3 ? ' selected="selected"' : '' !!}>Tektrons</option>
							<option value="4"{!! Request::old('race') == 4 ? ' selected="selected"' : '' !!}>Arakani</option>
						</select>
					</div>
				</div>
				<div class="form-group">
					<div class="col-md-offset-4 col-md-8">
						<button type="submit" id="register" name="register" class="btn btn-default btn-block"><i class="fa fa-check"></i> Jetzt registrieren</button>
					</div>
				</div>
				{!! Form::token() !!}
			</form>
		</div>
		<div class="col-md-6">
			<h3 class="f28 u mb30">Login</h3>
			@if(Request::old('login'))
				@include('messages')
			@endif

			<form action="/users/login" enctype="multipart/form-data" method="post" class="form-horizontal">
				<div class="form-group mb30">
					<label for="universe" class="control-label col-md-4 pt5">Universum:</label>
					<div class="col-md-8">
						<select name="universe" id="universe" class="form-control input-sm">
							<option value="phoenix">Phoenix</option>
						</select>
					</div>
				</div>
				<div class="form-group mt30">
					<label for="username" class="control-label col-md-4 pt5">Spielername:</label>
					<div class="col-md-8">
						<input type="text" id="username" name="username" class="form-control input-sm" />
					</div>
				</div>
				<div class="form-group">
					<label for="password" class="control-label col-md-4 pt5">Passwort:</label>
					<div class="col-md-8">
						<input type="password" id="password" name="password" class="form-control input-sm" />
					</div>
				</div>
				<div class="form-group">
					<div class="col-md-offset-4 col-md-8">
						<button type="submit" id="login" name="login" class="btn btn-default btn-block"><i class="fa fa-sign-in"></i> Anmelden</button>
					</div>
				</div>
				{!! Form::token() !!}
			</form>
		</div>
	</div>
@stop