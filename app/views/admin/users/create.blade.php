@extends('admin.partials.admin-master')
@section('content')

<div class="container">

	<h1>
		Add New User
		<span class="pull-right"><a href="{{URL::route('admin.user.index')}}">&laquo; Back to Users</a></span>
	</h1>

	<div class="well">

		@if(Session::has('errors'))
		<div class="alert alert-danger">Ooops! Looks like there were some errors. That's not Joyful!</div>
		@endif

		{{Form::open(['url'=>URL::route('admin.user.store')])}}
		<div class="form-group half">
			@if($errors->firstname)
				<span class="text-danger"><strong>{{$errors->first('firstname')}}</strong></span><br />
			@endif
			{{Form::label('firstname', 'First Name')}}
			{{Form::text('firstname', null, ['class'=>'form-control'])}}
		</div>
		<div class="form-group half right">
			@if($errors->lastname)
				<span class="text-danger"><strong>{{$errors->first('lastname')}}</strong></span><br />
			@endif
			{{Form::label('lastname', 'Last Name')}}
			{{Form::text('lastname', null, ['class'=>'form-control'])}}
		</div>
		<div class="form-group">
			@if($errors->email)
				<span class="text-danger"><strong>{{$errors->first('email')}}</strong></span><br />
			@endif
			{{Form::label('email', 'Email')}}
			{{Form::email('email', null, ['class'=>'form-control'])}}
		</div>
		<div class="form-group">
			{{Form::label('group', 'User Level')}}
			{{Form::select('group', $groups, null, ['class'=>'form-control'])}}
		</div>
		<hr>
		<div class="form-group">
			@if($errors->password)
				<span class="text-danger"><strong>{{$errors->first('password')}}</strong></span><br />
			@endif
			{{Form::label('password', 'Password')}}
			{{Form::password('password', ['class'=>'form-control'])}}
		</div>
		<div class="form-group">
			@if($errors->password_confirmation)
				<span class="text-danger"><strong>{{$errors->first('password_confirmation')}}</strong></span><br />
			@endif
			{{Form::label('password_confirmation', 'Confirm Password')}}
			{{Form::password('password_confirmation', ['class'=>'form-control'])}}
		</div>
		{{Form::submit('Add User', ['class'=>'btn btn-block btn-primary'])}}
		{{Form::close()}}

	</div><!-- .well -->
</div><!-- .container -->

@stop