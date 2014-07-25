@extends('admin.partials.admin-master')
@section('content')


<div class="container small">

	<h1>Site Settings</h1>

	<div class="well">

		@if(Session::has('errors'))
		<div class="alert alert-danger">Ooops! Looks like there were some errors. That's not Joyful!</div>
		@endif

		{{Form::open(['url'=>URL::route('admin.user.store')])}}
		
		<div class="form-group">
			@if($errors->twitter_api_key)
				<span class="text-danger"><strong>{{$errors->first('twitter_api_key')}}</strong></span><br />
			@endif
			{{Form::label('twitter_api_key', 'Twitter API Key')}}
			{{Form::text('twitter_api_key', $settings['twitter_api_key'], ['class'=>'form-control'])}}
		</div>
		<div class="form-group">
			@if($errors->twitter_api_secret)
				<span class="text-danger"><strong>{{$errors->first('twitter_api_secret')}}</strong></span><br />
			@endif
			{{Form::label('twitter_api_secret', 'Twitter API Secret')}}
			{{Form::text('twitter_api_secret', $settings['twitter_api_secret'], ['class'=>'form-control'])}}
		</div>
		<div class="form-group">
			@if($errors->twitter_access_token)
				<span class="text-danger"><strong>{{$errors->first('twitter_access_token')}}</strong></span><br />
			@endif
			{{Form::label('twitter_access_token', 'Twitter Access Token')}}
			{{Form::text('twitter_access_token', $settings['twitter_access_token'], ['class'=>'form-control'])}}
		</div>
		<div class="form-group">
			@if($errors->twitter_access_token_secret)
				<span class="text-danger"><strong>{{$errors->first('twitter_access_token_secret')}}</strong></span><br />
			@endif
			{{Form::label('twitter_access_token_secret', 'Twitter Access Token Secret')}}
			{{Form::text('twitter_access_token_secret', $settings['twitter_access_token_secret'], ['class'=>'form-control'])}}
		</div>
		
		<hr>

		<div class="form-group">
			@if($errors->instagram_client_id)
				<span class="text-danger"><strong>{{$errors->first('instagram_client_id')}}</strong></span><br />
			@endif
			{{Form::label('instagram_client_id', 'Instagram Client ID')}}
			{{Form::text('instagram_client_id', $settings['instagram_client_id'], ['class'=>'form-control'])}}
		</div>
		<div class="form-group">
			@if($errors->instagram_client_secret)
				<span class="text-danger"><strong>{{$errors->first('instagram_client_secret')}}</strong></span><br />
			@endif
			{{Form::label('instagram_client_secret', 'Twitter API Secret')}}
			{{Form::text('instagram_client_secret', $settings['instagram_client_secret'], ['class'=>'form-control'])}}
		</div>

		{{Form::submit('Save Settings', ['class'=>'btn btn-block btn-primary'])}}
		{{Form::close()}}

	</div><!-- .well -->
</div><!-- .container -->

@stop
