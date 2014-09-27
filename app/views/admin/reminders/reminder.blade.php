@extends('admin.partials.admin-master')
@section('content')
<div class="container">
	
	<div class="login">
	<img src="{{URL::asset('assets/images/kickapoo-admin-logo-full.png')}}" class="logo">

		@if(Session::get('status'))
			<div class="alert alert-info">{{Session::get('status')}}</div>

		@else
			<form action="{{ action('RemindersController@postRemind') }}" method="POST">
			<h3>Reset your password</h3>
				<section>
					@if(Session::get('error'))
						<div class="alert alert-danger">{{Session::get('error')}}</div>
					@endif

					<label for="email">Your Email (<a href="{{URL::route('login')}}">Login</a>)</label>
			    	<input type="email" name="email" class="form-control">

				    <input type="submit" value="Send Reset Link" class="btn btn-block btn-primary">
				</section>
			</form>
		@endif

	</div><!-- .login -->
</div><!-- .container -->
@stop