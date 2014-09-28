@extends('admin.partials.admin-master')
@section('content')

<section class="page-head margin">
	<div class="container">
		<h1><i class="icon-admin-users"></i> Kickapoo Users <span class="pull-right"><a href="{{URL::route('admin.user.create')}}" class="btn btn-large btn-primary">+ Add User</a></span></h1>
	</div>
</section>

<div class="container">	

	@if(Session::has('success'))
		<div class="alert alert-success">{{Session::get('success')}}</div>
	@endif

	<div class="alert alert-success remove-success" style="display:none;">User successfully removed.</div>

	<?php 
		$i = 1;
		foreach ($users as $user) :
		$signup = date('M jS, Y', strtotime($user->created_at));
		$avatar = "http://www.gravatar.com/avatar/" . md5( strtolower( trim( $user->email ) ) ) . "?s=100x100";
	?>
	<div class="user-row @if($i == 1)first @endif">
		<img src="{{$avatar}}" alt="{{$user->first_name}} {{$user->last_name}}" />
		<section>
			<p>
				<span class="pull-right">
					<a href="mailto:{{$user->email}}" class="btn btn-sm btn-default">Email</a>
					@if(Auth::user()->group_id == 1)
					<a href="{{URL::route('admin.user.edit', ['id'=>$user->id])}}" class="btn btn-sm btn-warning">Edit</a>
					@endif
					@if( (Auth::user()->group_id == 1) && (Auth::user()->id !== $user->id) )
					<a href="{{URL::route('admin.user.destroy', ['id'=>$user->id])}}" class="btn btn-sm btn-danger remove-user">Remove</a>
					@endif
				</span>

				<strong>{{$user->first_name}} {{$user->last_name}}</strong><br>
				<span class="text-muted">User level: {{$user->group->title}}<br />
				Registered: {{$signup}}</span>
			</p>
		</section>
	</div><!-- .user-row -->
	<?php 
		$i++;
		endforeach;
	?>
</div><!-- .container -->

@stop
@section('footercontent')
<script>
$('.remove-user').on('click', function(e){
	e.preventDefault();
	var target = $(this).attr('href');
	var user = $(this).parents('.user-row');
	if ( confirm('Are you sure you want to remove this user permanently?') ){
		$.ajax({
			url: target,
			method: 'DELETE',
			success: function(){
				$(user).fadeOut().promise().done(function(){
					$('.remove-success').fadeIn();
				});
			}
		});
	}
});
</script>
@stop