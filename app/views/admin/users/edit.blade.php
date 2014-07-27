@extends('admin.partials.admin-master')
@section('content')

<div class="container small">

	@if( Auth::user()->id == $user->id )
		<h1>Edit Your Profile
	@else
		<h1>Edit User: {{$user->first_name}} {{$user->last_name}}
	@endif
		<span class="pull-right"><a href="{{URL::route('admin.user.index')}}">&laquo; Back to Users</a></span>
		</h1>

	<div class="well">

		@if(Session::has('errors'))
		<div class="alert alert-danger">Ooops! Looks like there were some errors. That's not Joyful!</div>
		@endif

		{{Form::open(['url'=>URL::route('admin.user.update', ['id'=>$user->id]), 'method'=>'PUT'])}}
		<h3>Basic Details</h3>
		<div class="form-group">
			{{$errors->first('firstname', '<span class="text-danger"><strong>:message</strong></span><br>')}}
			{{Form::label('firstname', 'First Name')}}
			{{Form::text('firstname', $user->first_name, ['class'=>'form-control'])}}
		</div>
		<div class="form-group">
			{{$errors->first('lastname', '<span class="text-danger"><strong>:message</strong></span><br>')}}
			{{Form::label('lastname', 'Last Name')}}
			{{Form::text('lastname', $user->last_name, ['class'=>'form-control'])}}
		</div>
		<div class="form-group">
			{{$errors->first('email', '<span class="text-danger"><strong>:message</strong></span><br>')}}
			{{Form::label('email', 'Email')}}
			{{Form::email('email', $user->email, ['class'=>'form-control'])}}
		</div>
		<div class="form-group">
			{{Form::label('group', 'User Level')}}
			{{Form::select('group', $groups,  $user->group_id, ['class'=>'form-control'])}}
		</div>
		<hr>
		<h3>Notifications</h3>
		<div class="form-group">
			<label>
				@if($user->notify_unmoderated)
				{{Form::checkbox('notify_unmoderated', '1', true)}}
				@else
				{{Form::checkbox('notify_unmoderated', '1', false)}}
				@endif
				Send me an email when unmoderated posts reach a certain count
			</label>
		</div>
		<div class="form-group">
			{{$errors->first('notify_unmoderated_count', '<span class="text-danger"><strong>:message</strong></span><br>')}}
			{{Form::label('notify_unmoderated_count', 'Number of maximum unmoderated posts:')}}
			{{Form::text('notify_unmoderated_count', $user->notify_unmoderated_count, ['class'=>'form-control'])}}
		</div>
		<hr>
		<h3>Change Password</h3>
		<div class="form-group">
			{{$errors->first('password', '<span class="text-danger"><strong>:message</strong></span><br>')}}
			{{Form::label('password', 'New Password')}}
			{{Form::password('password', ['class'=>'form-control'])}}
		</div>
		<div class="form-group">
			{{$errors->first('password_confirmation', '<span class="text-danger"><strong>:message</strong></span><br>')}}
			{{Form::label('password_confirmation', 'Confirm New Password')}}
			{{Form::password('password_confirmation', ['class'=>'form-control'])}}
		</div>
		{{Form::submit('Update User', ['class'=>'btn btn-block btn-primary'])}}
		{{Form::close()}}

	</div><!-- .well -->
</div><!-- .container -->

@stop