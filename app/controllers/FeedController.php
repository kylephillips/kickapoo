<?php
use Kickapoo\SocialImport\Import;
use Kickapoo\SocialFeed\TwitterFeedSingle as Tweet;

class FeedController extends BaseController {


	public function __construct()
	{
		
	}

	/**
	* Manually run an import
	*/
	public function doImport()
	{
		if ( Request::ajax() ){
			new Import;
			return Response::json(['status' => 'success']);
		}
	}

	/**
	* Single Tweet - DEV ONLY
	*/
	public function tweet()
	{
		$twitter_feed = new Tweet('491236743224377346');
		$feed = $twitter_feed->formatted();
		
		if (!$feed) dd('not found');

		dd($feed);
	}


}