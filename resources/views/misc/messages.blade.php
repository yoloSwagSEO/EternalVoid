@if(session()->has('success'))
	<div class="alert alert-success text-center">
		<p class="text-success bold"><i class="fa fa-check pr10"></i> {{ session('success') }}</p>
	</div>
@endif
@if(session()->has('info'))
	<div class="alert alert-info text-center">
		<p class="text-info bold"><i class="fa fa-info-circle pr10"></i> {{ session('info') }}</p>
	</div>
@endif
@if(session()->has('warning'))
	<div class="alert alert-warning text-center">
		<p class="text-warning bold"><i class="fa fa-warning pr10"></i> {{ session('warning') }}</p>
	</div>
@endif
@if(!$errors->isEmpty())
	<div class="alert alert-danger text-center">
		<p class="text-danger bold"><i class="fa fa-times pr10"></i> {{ $errors->first() }}</p>
	</div>
@endif
@if(session()->has('error'))
	<div class="alert alert-danger text-center">
		<p class="text-danger bold"><i class="fa fa-times pr10"></i> {{ session('error') }}</p>
	</div>
@endif