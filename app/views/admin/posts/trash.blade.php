@extends('admin.partials.admin-master')
@section('content')
<div class="container small">
	<h1><i class="icon-remove"></i> Trash <span class="pull-right"><a href="{{URL::route('admin.post.index')}}">&laquo; Back to Posts</a></span></h1>
	<div class="alert alert-info">
		Last emptied: {{$last_trash}}
		<button class="btn btn-danger pull-right"><i class="icon-remove2"></i> Empty Trash</button>
	</div>
</div>
@stop