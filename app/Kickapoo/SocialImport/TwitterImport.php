<?php namespace Kickapoo\SocialImport;
use \Kickapoo\Factories\TweetFactory;
use \Tweet;
use \Trash;
use \Banned;

/**
* Import a Twitter Feed into the DB
*/
class TwitterImport {

	
	/**
	* The Feed to Import
	* @var array
	*/
	private $feed;

	
	/**
	* Import Count
	* @var int
	*/
	private $import_count;


	public function __construct($feed)
	{
		$this->feed = $feed;
		$this->import_count = 0;
		$this->doImport();
	}


	/**
	* Import the Feed
	*/
	private function doImport()
	{
		foreach ( $this->feed as $key=>$item )
		{
			if ( (!$item['is_retweet']) && ($this->validates($item)) )
			{
				$factory = new TweetFactory;
				$factory->createTweet($item);
				$this->import_count++;

			} elseif ( count($this->feed) == 1 ) {
				if ( $this->exists($item['id']) ) throw new \Kickapoo\Exceptions\PostExistsException;
				if ( $item['is_retweet'] ) throw new \Kickapoo\Exceptions\TweetRetweetException;
				if ( $this->trashed($item['id']) ) throw new \Kickapoo\Exceptions\PostTrashedException;
				if ( $this->banned($item['screen_name']) ) throw new \Kickapoo\Exceptions\BannedUserException;
			}
		}
	}


	/**
	* Validate the Item
	*/
	private function validates($item)
	{
		if ( $this->exists($item['id']) ) return false;
		if ( $this->trashed($item['id']) ) return false;
		if ( $this->banned($item['screen_name']) ) return false;
		return true;
	}


	/**
	* Check if already imported
	* @param int
	*/
	private function exists($id)
	{
		return ( Tweet::where('twitter_id', $id)->count() ) ? true : false;		
	}


	/**
	* Check if trashed
	* @param int
	*/
	private function trashed($id)
	{
		return ( Trash::where('twitter_id', $id)->count() ) ? true : false;
	}


	/**
	* Check if user has been banned
	*/
	private function banned($screen_name)
	{
		return ( Banned::where('screen_name', $screen_name)->count() ) ? true : false;
	}

	
	/**
	* Get the Import Count
	* @return int
	*/
	public function getCount()
	{
		return $this->import_count;
	}

}