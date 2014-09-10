@extends('partials.master')
@section('content')
	
	<div class="container">
		@if( $page->get_field('Header Image', $page->id) )
			<img src="{{URL::asset('assets/uploads/page_images')}}/{{$page->get_field('Header Image', $page->id)}}" class="header-image" alt="{{$page['title']}}" />
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
				{{$errors->first('user-captcha', '<span class="text-danger"><strong>:message</strong></span><br>')}}
				<p class="captcha">
					{{Form::label('user-captcha', 'Please enter the following')}}
					<img src="{{ URL::to('/captcha')}}" alt="captcha">
					<input type="text" name="user-captcha" id="user-captcha">
				</p>
				{{Form::submit('Send')}}
			{{Form::close()}}
		</div><!-- .container -->
	</section><!-- .page-content -->

	@endif

@stop