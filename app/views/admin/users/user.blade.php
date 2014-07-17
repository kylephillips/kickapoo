@extends('admin.partials.admin-master')
@section('content')

<div class="container">

	<div class="col-lg-8 col-lg-offset-2">
		<h1>Users <span class="pull-right"><a href="{{URL::route('admin.user.create')}}" class="btn btn-large btn-primary">+ Add User</a></span></h1>
	</div>

	<div class="well col-lg-8 col-lg-offset-2">

		@foreach($users as $user)
		<?php
			$signup = date('M jS, Y', strtotime($user->created_at));
			$avatar = "http://www.gravatar.com/avatar/" . md5( strtolower( trim( $user->email ) ) ) . "?s=100x100";
		?>
		<div class="row user-row">
			<div class="col-xs-3 col-sm-2 col-md-2 col-lg-2">
				<img src="{{$avatar}}" alt="{{$user->first_name}} {{$user->last_name}}" />
			</div>
			<div class="col-xs-8 col-sm-9 col-md-9 col-lg-6">
				<p>
					<strong>{{$user->first_name}} {{$user->last_name}}</strong><br>
					<span class="text-muted">User level: {{$user->group->title}}<br />
					Registered: {{$signup}}</span>
				</p>
			</div>
			<div class="col-lg-4">
				<span class="pull-right">
					<a href="mailto:{{$user->email}}" class="btn btn-sm btn-default">Email</a>
					@if(Auth::user()->group_id == 1)
					<a href="{{URL::route('admin.user.edit', ['id'=>$user->id])}}" class="btn btn-sm btn-warning">Edit</a>
					@endif
					@if( (Auth::user()->group_id == 1) && (Auth::user()->id !== $user->id) )
					<a href="{{URL::route('admin.user.destroy', ['id'=>$user->id])}}" class="btn btn-sm btn-danger">Remove</a>
					@endif
				</span>
			</div>
		</div><!-- .user-row -->
		@endforeach

	</div><!-- .well -->
</div><!-- .container -->

@stop