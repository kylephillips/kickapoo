@extends('admin.partials.admin-master')
@section('content')

<div class="container">

	<div class="col-lg-8 col-lg-offset-2">
		<h1>Add New User</h1>
	</div>

	<div class="well col-lg-8 col-lg-offset-2">

		{{Form::open()}}
		<div class="form-group">
			{{Form::label('firstname', 'First Name')}}
			{{Form::text('firstname', null, ['class'=>'form-control'])}}
		</div>
		<div class="form-group">
			{{Form::label('lastname', 'Last Name')}}
			{{Form::text('lastname', null, ['class'=>'form-control'])}}
		</div>
		<div class="form-group">
			{{Form::label('email', 'Email')}}
			{{Form::email('email', null, ['class'=>'form-control'])}}
		</div>
		<div class="form-group">
			{{Form::label('group', 'User Level')}}
			{{Form::select('group', $groups, null, ['class'=>'form-control'])}}
		</div>
		<hr>
		<div class="form-group">
			{{Form::label('password', 'Password')}}
			{{Form::password('password', ['class'=>'form-control'])}}
		</div>
		<div class="form-group">
			{{Form::label('password_confirm', 'Confirm Password')}}
			{{Form::password('password_confirm', ['class'=>'form-control'])}}
		</div>
		{{Form::submit('Add User', ['class'=>'btn btn-block btn-primary'])}}
		{{Form::close()}}

	</div><!-- .well -->
</div><!-- .container -->

@stop