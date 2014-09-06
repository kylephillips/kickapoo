@extends('partials.master')
@section('content')
<h1>{{$page['title']}}</h1>

@if(Session::has('success'))
<div class="alert alert-success">{{Session::get('success')}}</div>
@else

{{Form::open(['url'=>URL::route('process_form')])}}

@if(Session::has('errors'))
<div class="alert alert-danger">Ooops! Looks like there were some errors. That's not Joyful!</div>
@endif

<p>
	{{$errors->first('name', '<span class="text-danger"><strong>:message</strong></span><br>')}}
	{{Form::label('name', 'Your Name')}}
	{{Form::text('name')}}
</p>
<p>
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
	{{$errors->first('user-captcha', '<span class="text-danger"><strong>:message</strong></span><br>')}}
	<img src="{{ URL::to('/captcha')}}">
	<input type="text" name="user-captcha">
</p>
{{Form::submit('Send')}}
{{Form::close()}}

@endif

@stop