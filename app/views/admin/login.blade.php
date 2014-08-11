@extends('admin.partials.admin-master')
@section('content')

<div class="container small">
	
	<div class="login">

		<a href="{{URL::route('home')}}">
			<img src="{{URL::asset('assets/images/kickapoo-admin-logo-full.png')}}" class="logo">
		</a>

		@if(!Auth::check())
		{{Form::open(['url'=>'/login', 'method'=>'post'])}}	
			<h3><strong>Sign In</strong></h3>
			<section>
				@if(Session::has('success'))
					<div class="alert alert-success">{{Session::get('success')}}</div>
				@endif

				@if(Session::has('error'))
					<div class="alert alert-danger">{{Session::get('error')}}</div>
				@endif
				
				{{Form::label('email', 'Email')}}
				{{Form::email('email', null, ['placeholder'=>'Enter Email', 'class'=>'form-control'])}}
			
				<label for="password">Password <a href="/password/remind/">(forgot password)</a></label>
				{{Form::password('password', ['placeholder'=>'Password', 'class'=>'form-control'])}}
			
				<label>{{Form::checkbox('remember', 'remember', true)}} Remember Me</label>
				
				{{Form::submit('Sign In')}}
			</section>
		{{Form::close()}}

		@else
		<div class="panel panel-default">
			<p>Welcome back {{Auth::user()->first_name}}.</p>
			<p><a href="/logout" class="btn btn-primary btn-large">Log Out</a></p>
		</div>
		@endif

	</div><!-- .login -->
	
</div><!-- .container -->

@stop

@section('footercontent')
@if(!Auth::check())
<script>
$(document).ready(function(){
	$('#email').focus();
});
</script>
@endif
@stop