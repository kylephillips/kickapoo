@extends('admin.partials.admin-master')
@section('content')

<div class="container">

	<div class="col-lg-8 col-lg-offset-2">
		<h1>Edit User: {{$user->first_name}} {{$user->last_name}}</h1>
	</div>

	<div class="well col-lg-8 col-lg-offset-2">

		@if(Session::has('errors'))
		<div class="alert alert-danger">Ooops! Looks like there were some errors. That's not Joyful!</div>
		@endif

		{{Form::open(['url'=>URL::route('admin.user.update', ['id'=>$user->id]), 'method'=>'PUT'])}}
		<div class="form-group">
			@if($errors->firstname)
				<span class="text-danger"><strong>{{$errors->first('firstname')}}</strong></span><br />
			@endif
			{{Form::label('firstname', 'First Name')}}
			{{Form::text('firstname', $user->first_name, ['class'=>'form-control'])}}
		</div>
		<div class="form-group">
			@if($errors->lastname)
				<span class="text-danger"><strong>{{$errors->first('lastname')}}</strong></span><br />
			@endif
			{{Form::label('lastname', 'Last Name')}}
			{{Form::text('lastname', $user->last_name, ['class'=>'form-control'])}}
		</div>
		<div class="form-group">
			@if($errors->email)
				<span class="text-danger"><strong>{{$errors->first('email')}}</strong></span><br />
			@endif
			{{Form::label('email', 'Email')}}
			{{Form::email('email', $user->email, ['class'=>'form-control'])}}
		</div>
		<div class="form-group">
			{{Form::label('group', 'User Level')}}
			{{Form::select('group', $groups,  $user->group_id, ['class'=>'form-control'])}}
		</div>
		<hr>
		<h3>Change Password</h3>
		<div class="form-group">
			@if($errors->password)
				<span class="text-danger"><strong>{{$errors->first('password')}}</strong></span><br />
			@endif
			{{Form::label('password', 'New Password')}}
			{{Form::password('password', ['class'=>'form-control'])}}
		</div>
		<div class="form-group">
			@if($errors->password_confirmation)
				<span class="text-danger"><strong>{{$errors->first('password_confirmation')}}</strong></span><br />
			@endif
			{{Form::label('password_confirmation', 'Confirm New Password')}}
			{{Form::password('password_confirmation', ['class'=>'form-control'])}}
		</div>
		{{Form::submit('Update User', ['class'=>'btn btn-block btn-primary'])}}
		{{Form::close()}}

	</div><!-- .well -->
</div><!-- .container -->

@stop