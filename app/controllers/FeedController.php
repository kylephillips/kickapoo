<?php
use Kickapoo\SocialImport\Import;
use Kickapoo\SocialFeedSingle\Tweet;

class FeedController extends BaseController {

	protected $tweet_feed;

	public function __construct(Tweet $tweet_feed)
	{
		$this->tweet_feed = $tweet_feed;
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
		$feed = $this->tweet_feed->feed('491000645302767616');
		dd($feed);
	}


}