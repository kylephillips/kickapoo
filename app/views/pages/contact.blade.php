@extends('partials.master')
@section('content')
	
	<div class="container">
		@if( $page->get_field('Header Image', $page->id) )
		<?php $header_image = $page->get_field('Header Image', $page->id); ?>
			<img src="{{URL::asset($header_image['image'])}}" class="header-image" alt="{{$header_image['alt']}}" />
		@else
			<h1>{{$page['title']}}</h1>
		@endif

		@if($page->content)
			{{$page->content}}
		@endif
	</div>

	<hr class="bubble-pattern-small">

	</section><!-- page-hero -->

	<section class="page-content">
		<div class="container full contact-page">

			@if(Session::has('success'))
				@if( $page->get_field('Success Message', $page->id) )
				<div class="alert alert-success">{{$page->get_field('Success Message', $page->id)}}</div>
				@else
				<div class="alert alert-success">{{Session::get('success')}}</div>
				@endif
			@else

			{{Form::open(['url'=>URL::route('process_form'), 'class'=>'contact-form'])}}

				@if(Session::has('errors'))
				<div class="alert alert-danger">Ooops! Looks like there were some errors. That's not Joyful!</div>
				@endif

				<p class="left">
					{{$errors->first('name', '<span class="text-danger"><strong>:message</strong></span><br>')}}
					{{Form::label('name', 'Your Name')}}
					{{Form::text('name')}}
				</p>
				<p class="right">
					{{$errors->first('email', '<span class="text-danger"><strong>:message</strong></span><br>')}}
					{{Form::label('email', 'Your Email')}}
					{{Form::email('email')}}
				</p>
				<p>
					{{$errors->first('message', '<span class="text-danger"><strong>:message</strong></span><br>')}}
					{{Form::label('message', 'Message')}}
					{{Form::textarea('message')}}
				</p>
				<p>
					<label>{{Form::checkbox('email_opt_in', '1', true)}} Sign me up to receive emails from Kickapoo team about the latest products, special offers and more.</label>
				</p>
				{{$errors->first('user-captcha', '<span class="text-danger"><strong>:message</strong></span><br>')}}
				<p class="captcha">
					{{Form::label('user-captcha', 'Please enter the following')}}
					<img src="{{Captcha::getImage()}}">
					<input type="text" name="user-captcha" id="user-captcha">
				</p>
				{{Form::submit('Send')}}
			{{Form::close()}}
			@endif
		</div><!-- .container -->
	</section><!-- .page-content -->

@stop