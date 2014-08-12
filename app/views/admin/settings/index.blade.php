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

		<h3>Notification Emails</h3>
		<div class="form-group">
			{{$errors->first('contact_emails', '<span class="text-danger"><strong>:message</strong></span><br>')}}
			{{Form::label('contact_emails', 'Emails for contact form notifications (comma separated list)')}}
			{{Form::text('contact_emails', $contact_emails, ['class'=>'form-control'])}}
		</div>
		
		<h3>Store Link</h3>

		<div class="form-group">
			{{$errors->first('store_link', '<span class="text-danger"><strong>:message</strong></span><br>')}}
			{{Form::label('store_link', 'Store Link')}}
			{{Form::text('store_link', $store_link, ['class'=>'form-control'])}}
		</div>

		<hr>

		<h3>Social Links</h3>
		<div class="alert alert-info">
			Both the link and icon class are required to display on the site. Leave either off to hide from the site.
		</div>
		@foreach($social_links as $link)
		<div class="form-group half">
			{{$errors->first($link->key, '<span class="text-danger"><strong>:message</strong></span><br>')}}
			{{Form::label($link->key, $link->description)}}
			{{Form::text($link->key, $link->value, ['class'=>'form-control'])}}
		</div>
		<div class="form-group half right">
			{{Form::label($link->key, 'Icon Class')}}
			{{Form::text('icon_' . $link->key, $link->value_two, ['class'=>'form-control'])}}
		</div>
		@endforeach

		<hr>

		<h3>API Settings</h3>
		<div class="alert alert-info">Twitter Keys</div>
		<div class="form-group">
			{{$errors->first('twitter_api_key', '<span class="text-danger"><strong>:message</strong></span><br>')}}
			{{Form::label('twitter_api_key', 'Twitter API Key')}}
			{{Form::text('twitter_api_key', $social_creds['twitter_api_key'], ['class'=>'form-control'])}}
		</div>
		<div class="form-group">
			{{$errors->first('twitter_api_secret', '<span class="text-danger"><strong>:message</strong></span><br>')}}
			{{Form::label('twitter_api_secret', 'Twitter API Secret')}}
			{{Form::text('twitter_api_secret', $social_creds['twitter_api_secret'], ['class'=>'form-control'])}}
		</div>
		<div class="form-group">
			{{$errors->first('twitter_access_token', '<span class="text-danger"><strong>:message</strong></span><br>')}}
			{{Form::label('twitter_access_token', 'Twitter Access Token')}}
			{{Form::text('twitter_access_token', $social_creds['twitter_access_token'], ['class'=>'form-control'])}}
		</div>
		<div class="form-group">
			{{$errors->first('twitter_access_token_secret', '<span class="text-danger"><strong>:message</strong></span><br>')}}
			{{Form::label('twitter_access_token_secret', 'Twitter Access Token Secret')}}
			{{Form::text('twitter_access_token_secret', $social_creds['twitter_access_token_secret'], ['class'=>'form-control'])}}
		</div>
		
		<hr>

		<div class="alert alert-info">Instagram Keys</div>
		<div class="form-group">
			{{$errors->first('instagram_client_id', '<span class="text-danger"><strong>:message</strong></span><br>')}}
			{{Form::label('instagram_client_id', 'Instagram Client ID')}}
			{{Form::text('instagram_client_id', $social_creds['instagram_client_id'], ['class'=>'form-control'])}}
		</div>
		<div class="form-group">
			{{$errors->first('instagram_client_secret', '<span class="text-danger"><strong>:message</strong></span><br>')}}
			{{Form::label('instagram_client_secret', 'Instagram Client Secret')}}
			{{Form::text('instagram_client_secret', $social_creds['instagram_client_secret'], ['class'=>'form-control'])}}
		</div>

		<hr>

		<div class="alert alert-info">Facebook Keys</div>
		<div class="form-group">
			{{$errors->first('facebook_page_id', '<span class="text-danger"><strong>:message</strong></span><br>')}}
			{{Form::label('facebook_page_id', 'Facebook Page ID')}}
			{{Form::text('facebook_page_id', $social_creds['facebook_page_id'], ['class'=>'form-control'])}}
		</div>
		<div class="form-group">
			{{$errors->first('facebook_app_id', '<span class="text-danger"><strong>:message</strong></span><br>')}}
			{{Form::label('facebook_app_id', 'Facebook App ID')}}
			{{Form::text('facebook_app_id', $social_creds['facebook_app_id'], ['class'=>'form-control'])}}
		</div>
		<div class="form-group">
			{{$errors->first('facebook_app_secret', '<span class="text-danger"><strong>:message</strong></span><br>')}}
			{{Form::label('facebook_app_secret', 'Facebook App Secret')}}
			{{Form::text('facebook_app_secret', $social_creds['facebook_app_secret'], ['class'=>'form-control'])}}
		</div>
		<div class="form-group">
			{{$errors->first('facebook_app_token', '<span class="text-danger"><strong>:message</strong></span><br>')}}
			{{Form::label('facebook_app_token', 'Facebook App Token')}}
			{{Form::text('facebook_app_token', $social_creds['facebook_app_token'], ['class'=>'form-control'])}}
		</div>


		{{Form::submit('Save Settings', ['class'=>'btn btn-block btn-primary'])}}
		{{Form::close()}}

	</div><!-- .well -->
</div><!-- .container -->

@stop
