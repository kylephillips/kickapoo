@extends('partials.master')
@section('content')
@foreach($posts as $post)
	@if($post->type == 'tweet')
		<p>Tweet:<br />{{$post->tweet->datetime}}<br />{{$post->tweet->text}}</p>
	@else
		<p>Gram</p>
		<img src="{{URL::asset('assets/uploads/instagram_images')}}/{{$post->gram->image}}" />
	@endif
@endforeach
@stop

@section('footercontent')
<script src="/assets/js/video.js"></script>
<script src="/assets/js/bigvideo.js"></script>
<script>
$(function(){
var BV = new $.BigVideo({
		useFlashForFirefox:false,
		doLoop: true,
		shrinkable: true
	});
    BV.init();
    BV.show('assets/videos/test_bubbles.mp4', {altSource:'assets/videos/test_bubbles.ogv'});
});
</script>
@stop