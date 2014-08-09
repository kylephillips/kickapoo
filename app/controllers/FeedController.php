<?php
use Kickapoo\SocialFeed\FacebookFeed;
use Kickapoo\SocialImport\FacebookImport;

class FeedController extends BaseController {


	public function __construct()
	{
		
	}

	public function facebookFeed()
	{
		$feed = new FacebookFeed;
		$feed = $feed->formatted();
		dd($feed);
	}

}