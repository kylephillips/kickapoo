@extends('admin.partials.admin-master')
@section('content')

<section class="page-head margin">
	<div class="container small">
		<h1> Add New User <span class="pull-right"><a href="{{URL::route('admin.user.index')}}">&laquo; Back to Users</a></span></h1>
	</div>
</section>

<div class="container small">

	<div class="well">

		@if(Session::has('errors'))
		<div class="alert alert-danger">Ooops! Looks like there were some errors. That's not Joyful!</div>
		@endif

		{{Form::open(['url'=>URL::route('admin.user.store')])}}
		<div class="well">
			<h4>Basic Information</h4>
			<div class="well-interior">
				<div class="form-group half">
					{{$errors->first('firstname', '<span class="text-danger"><strong>:message</strong></span><br>')}}
					{{Form::label('firstname', 'First Name')}}
					{{Form::text('firstname', null, ['class'=>'form-control'])}}
				</div>
				<div class="form-group half right">
					{{$errors->first('lastname', '<span class="text-danger"><strong>:message</strong></span><br>')}}
					{{Form::label('lastname', 'Last Name')}}
					{{Form::text('lastname', null, ['class'=>'form-control'])}}
				</div>
				<div class="form-group">
					{{$errors->first('email', '<span class="text-danger"><strong>:message</strong></span><br>')}}
					{{Form::label('email', 'Email')}}
					{{Form::email('email', null, ['class'=>'form-control'])}}
				</div>
				<div class="form-group">
					{{Form::label('group', 'User Level')}}
					{{Form::select('group', $groups, null, ['class'=>'form-control'])}}
				</div>
			</div><!-- .well-interior -->
		</div><!-- .well -->

		<hr>

		<div class="well">
			<h4>Password</h4>
			<div class="well-interior">
				<div class="form-group">
					{{$errors->first('password', '<span class="text-danger"><strong>:message</strong></span><br>')}}
					{{Form::label('password', 'Password')}}
					{{Form::password('password', ['class'=>'form-control'])}}
				</div>
				<div class="form-group">
					{{$errors->first('password_confirmation', '<span class="text-danger"><strong>:message</strong></span><br>')}}
					{{Form::label('password_confirmation', 'Confirm Password')}}
					{{Form::password('password_confirmation', ['class'=>'form-control'])}}
				</div>
			</div><!-- .well-interior -->
		</div><!-- .well -->
		{{Form::submit('Add User', ['class'=>'btn btn-block btn-primary'])}}
		{{Form::close()}}

	</div><!-- .well -->
</div><!-- .container -->

@stop