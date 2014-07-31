@extends('admin.partials.admin-master')
@section('content')


<div class="container small">

	<h1>Site Settings</h1>

	<div class="well">

		@if(Session::has('errors'))
		<div class="alert alert-danger">Ooops! Looks like there were some errors. That's not Joyful!</div>
		@endif

		@if(Session::has('success'))
		<div class="alert alert-success">{{Session::get('success')}}</div>
		@endif

		{{Form::open(['url'=>URL::route('update_settings')])}}
		
		<h3>Links</h3>
		<div class="form-group">
			{{$errors->first('store_link', '<span class="text-danger"><strong>:message</strong></span><br>')}}
			{{Form::label('store_link', 'Store Link')}}
			{{Form::text('store_link', $links['store_link'], ['class'=>'form-control'])}}
		</div>
		<div class="form-group">
			{{$errors->first('twitter_link', '<span class="text-danger"><strong>:message</strong></span><br>')}}
			{{Form::label('twitter_link', 'Twitter Link')}}
			{{Form::text('twitter_link', $links['twitter_link'], ['class'=>'form-control'])}}
		</div>
		<div class="form-group">
			{{$errors->first('instagram_link', '<span class="text-danger"><strong>:message</strong></span><br>')}}
			{{Form::label('instagram_link', 'Instagram Link')}}
			{{Form::text('instagram_link', $links['instagram_link'], ['class'=>'form-control'])}}
		</div>
		<div class="form-group">
			{{$errors->first('vine_link', '<span class="text-danger"><strong>:message</strong></span><br>')}}
			{{Form::label('vine_link', 'Vine Link')}}
			{{Form::text('vine_link', $links['vine_link'], ['class'=>'form-control'])}}
		</div>
		<div class="form-group">
			{{$errors->first('youtube_link', '<span class="text-danger"><strong>:message</strong></span><br>')}}
			{{Form::label('youtube_link', 'Youtube Link')}}
			{{Form::text('youtube_link', $links['youtube_link'], ['class'=>'form-control'])}}
		</div>

		<hr>

		<h3>API Settings</h3>
		<div class="form-group">
			{{$errors->first('twitter_api_key', '<span class="text-danger"><strong>:message</strong></span><br>')}}
			{{Form::label('twitter_api_key', 'Twitter API Key')}}
			{{Form::text('twitter_api_key', $settings['twitter_api_key'], ['class'=>'form-control'])}}
		</div>
		<div class="form-group">
			{{$errors->first('twitter_api_secret', '<span class="text-danger"><strong>:message</strong></span><br>')}}
			{{Form::label('twitter_api_secret', 'Twitter API Secret')}}
			{{Form::text('twitter_api_secret', $settings['twitter_api_secret'], ['class'=>'form-control'])}}
		</div>
		<div class="form-group">
			{{$errors->first('twitter_access_token', '<span class="text-danger"><strong>:message</strong></span><br>')}}
			{{Form::label('twitter_access_token', 'Twitter Access Token')}}
			{{Form::text('twitter_access_token', $settings['twitter_access_token'], ['class'=>'form-control'])}}
		</div>
		<div class="form-group">
			{{$errors->first('twitter_access_token_secret', '<span class="text-danger"><strong>:message</strong></span><br>')}}
			{{Form::label('twitter_access_token_secret', 'Twitter Access Token Secret')}}
			{{Form::text('twitter_access_token_secret', $settings['twitter_access_token_secret'], ['class'=>'form-control'])}}
		</div>
		
		<hr>

		<div class="form-group">
			{{$errors->first('instagram_client_id', '<span class="text-danger"><strong>:message</strong></span><br>')}}
			{{Form::label('instagram_client_id', 'Instagram Client ID')}}
			{{Form::text('instagram_client_id', $settings['instagram_client_id'], ['class'=>'form-control'])}}
		</div>
		<div class="form-group">
			{{$errors->first('instagram_client_secret', '<span class="text-danger"><strong>:message</strong></span><br>')}}
			{{Form::label('instagram_client_secret', 'Twitter API Secret')}}
			{{Form::text('instagram_client_secret', $settings['instagram_client_secret'], ['class'=>'form-control'])}}
		</div>

		{{Form::submit('Save Settings', ['class'=>'btn btn-block btn-primary'])}}
		{{Form::close()}}

	</div><!-- .well -->
</div><!-- .container -->

@stop
