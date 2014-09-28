<!-- Twitter help modal -->
<div class="modal fade" id="twitterhelp">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close btn btn-mini" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Finding a Tweet's ID</h4>
			</div>
			<div class="modal-body">
				<ol>
					<li>Within your timeline, click the tweet to expand it (or click "more").</li>
					<li>Once the tweet is expanded, look for the date of the tweet in gray lettering. Click the "Details" link next to the date. This will open the single view of the tweet.<br />
						<img src="{{URL::asset('assets/images/twitter-help-one.jpg')}}"></li>
					<li>The ID of the tweet is the last line of numbers in the browser address bar. It will appear as a long string of numbers:.<br />
						<img src="{{URL::asset('assets/images/twitter-help-two.jpg')}}"></li>
				</ol>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div><!-- /.modal -->