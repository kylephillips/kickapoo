<?php namespace Kickapoo\SocialImport;
use Kickapoo\SocialFeed\TwitterFeed;
use Kickapoo\SocialImport\TwitterImport;
use Kickapoo\SocialFeed\InstagramFeed;
use Kickapoo\SocialImport\InstagramImport;
use \AppLog;

/**
* Import all the Feeds
*/
class Import {


	/**
	* Number of Items Imported
	* @var int
	*/
	private $import_count;


	/**
	* Number of Twitter Items Imported
	* @var int
	*/
	private $twitter_count;


	/**
	* Number of Instagram Items Imported
	* @var int
	*/
	private $instagram_count;


	public function __construct()
	{
		$this->import_count = 0;
		$this->twitter_count = 0;
		$this->instagram_count = 0;
		$this->twitterImport();
		$this->instagramImport();
		$this->setCount();
		$this->log();
	}


	/**
	* Twitter Import
	*/
	public function twitterImport()
	{
		$feed = new TwitterFeed;
		$feed = ( $feed ) ? $feed->formatted() : false;
		if ( $feed ){
			$import = new TwitterImport($feed);
			$this->twitter_count = $import->getCount();
		}
	}


	/**
	* Instagram Import
	*/
	public function instagramImport()
	{
		$feed = new InstagramFeed;
		$feed = ( $feed ) ? $feed->formatted() : false;
		if ( $feed ){
			$import = new InstagramImport($feed);
			$this->instagram_count = $import->getCount();
		}
	}

	/**
	* Add a log of the Import
	*/
	public function log()
	{
		AppLog::create([
			'type' => 'import',
			'description' => $this->import_count
		]);
	}

	/**
	* Set the import count
	*/
	private function setCount()
	{
		$this->import_count = $this->twitter_count + $this->instagram_count;
	}


	/**
	* Get the import count
	* @return int
	*/
	public function getCount()
	{
		return $this->import_count;
	}

}