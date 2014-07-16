@extends('admin.partials.admin-master')
@section('content')

<div class="container" style="margin-top:30px">
	<div class="col-md-4 col-md-offset-4">
		@if(Session::has('success'))
			<div class="alert alert-success">{{Session::get('success')}}</div>
		@endif
		@if(Session::has('error'))
			<div class="alert alert-danger">{{Session::get('error')}}</div>
		@endif
		@if(!Auth::check())
		<div class="panel panel-default">
			<div class="panel-heading"><h3 class="panel-title"><strong>Sign in </strong></h3></div>
			<div class="panel-body">
				{{Form::open(['url'=>'/login', 'method'=>'post'])}}
					<div class="form-group">
						{{Form::label('email', 'Email')}}
						{{Form::email('email', null, ['placeholder'=>'Enter Email', 'class'=>'form-control', 'style'=>'border-radius:0px'])}}
					</div>
					<div class="form-group">
						<label for="password">Password <a href="/forgot_password">(forgot password)</a></label>
						{{Form::password('password', ['placeholder'=>'Password', 'class'=>'form-control', 'style'=>'border-radius:0px'])}}
					</div>
					<div class="checkbox">
						<label>{{Form::checkbox('remember', 'remember', true)}} Remember Me</label>
					</div>
					<button type="submit" class="btn btn-block btn-primary">Sign in</button>
				{{Form::close()}}
			</div>
		</div>
		@else
		<div class="panel panel-default">
			<p>Welcome back {{Auth::user()->first_name}}.</p>
			<p><a href="/logout" class="btn btn-primary btn-large">Log Out</a></p>
		</div>
		@endif
	</div>
</div>

@stop