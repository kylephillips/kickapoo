@extends('admin.partials.admin-master')
@section('content')
<div class="container small">
	<div class="col-md-6 col-md-offset-3">
		<h1>Password Reset</h1>

		@if(Session::get('error'))
			<div class="alert alert-danger">{{Session::get('error')}}</div>
		@endif

		@if(Session::get('status'))
			<div class="alert alert-info">{{Session::get('status')}}</div>

		@else
		<div class="panel panel-default">
			<div class="panel-body">
				<form action="{{ action('RemindersController@postRemind') }}" method="POST">
					<div class="form-group">
						<label for="email">Your Email</label>
				    	<input type="email" name="email" class="form-control">
					</div>
				    <input type="submit" value="Send Reset Link" class="btn btn-block btn-primary">
				</form>
			</div>
		</div>
		@endif
	</div>
</div>
@stop