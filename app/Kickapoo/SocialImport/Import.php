<?php namespace Kickapoo\SocialImport;
use Kickapoo\SocialFeed\TwitterFeed;
use Kickapoo\SocialImport\TwitterImport;
use Kickapoo\SocialFeed\InstagramFeed;
use Kickapoo\SocialImport\InstagramImport;
/**
* Import all the Feeds
*/
class Import {


	public function __construct()
	{
		$this->twitterImport();
		$this->instagramImport();
	}


	/**
	* Twitter Import
	*/
	public function twitterImport()
	{
		$feed = new TwitterFeed;
		$feed = ( $feed ) ? $feed->formatted() : false;
		if ( $feed ) $import = new TwitterImport($feed);
	}


	/**
	* Instagram Import
	*/
	public function instagramImport()
	{
		$feed = new InstagramFeed;
		$feed = ( $feed ) ? $feed->formatted() : false;
		if ( $feed ) $import = new InstagramImport($feed);
	}

}