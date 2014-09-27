@extends('admin.partials.admin-master')
@section('content')

<section class="page-head margin">
	<div class="container small">
		@if( Auth::user()->id == $user->id )
			<h1>Edit Your Profile
		@else
			<h1>Edit User: {{$user->first_name}} {{$user->last_name}}
		@endif
		<span class="pull-right"><a href="{{URL::route('admin.user.index')}}">&laquo; Back to Users</a></span>
		</h1>
	</div>
</section>

<div class="container small">

	<div class="well">

		@if(Session::has('errors'))
		<div class="alert alert-danger">Ooops! Looks like there were some errors. That's not Joyful!</div>
		@endif

		{{Form::open(['url'=>URL::route('admin.user.update', ['id'=>$user->id]), 'method'=>'PUT'])}}
		<div class="well">
			<h4>Basic Details</h4>
			<div class="well-interior">
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
			@if ( Auth::user()->group_id == 1 )
			<div class="form-group">
				{{Form::label('group', 'User Level')}}
				{{Form::select('group', $groups,  $user->group_id, ['class'=>'form-control'])}}
			</div>
			</div><!-- .well-interior -->
		</div><!-- .well -->
		@endif
		<hr>
		<div class="well">
			<h4>Notifications</h4>
			<div class="well-interior">
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
			</div><!-- .well-interior -->
		</div><!-- .well -->
		<hr>
		<div class="well">
			<h4>Change Password</h4>
			<div class="well-interior">
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
			</div><!-- .well-interior -->
		</div><!-- .well -->
		{{Form::submit('Update User', ['class'=>'btn btn-block btn-primary'])}}
		{{Form::close()}}

	</div><!-- .well -->
</div><!-- .container -->

@stop