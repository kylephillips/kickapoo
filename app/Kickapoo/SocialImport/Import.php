<?php namespace Kickapoo\SocialImport;
use Kickapoo\SocialFeed\TwitterFeed;
use Kickapoo\SocialFeed\InstagramFeed;
use Kickapoo\SocialImport\TwitterImport;
use Kickapoo\SocialImport\InstagramImport;
/**
* Import all the Feeds
*/
class Import {

	public function __construct()
	{
		$this->twitterFeed();
		$this->instagramFeed();
	}


	/**
	* Twitter Feed
	*/
	public function twitterFeed()
	{
		$feed = new TwitterFeed;
		$feed = ( $feed ) ? $feed->formatted() : false;
		if ( $feed ) $import = new TwitterImport($feed);
	}


	/**
	* Instagram Feed
	*/
	public function instagramFeed()
	{
		$feed = new InstagramFeed;
		$feed = ( $feed ) ? $feed->formatted() : false;
		if ( $feed ) $import = new InstagramImport($feed);
	}

}