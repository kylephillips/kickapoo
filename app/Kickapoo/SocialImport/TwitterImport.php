<?php namespace Kickapoo\SocialImport;
use \Tweet;
use \DB;
use \Image;
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
				$date = strtotime($item['date']);
				$date = date('Y-m-d H:i:s');
				$language = ( isset($item['language_code']) ) ? $item['language_code'] : null;
				$location = ( isset($item['location']) ) ? $item['location'] : null;
				$media = ( isset($item['media']) ) ? $item['media'] : null;
				$image = ( $item['media'] ) ? $this->importImage($item['media'], $item['id']) : null;

				Tweet::create([
					'twitter_id' => $item['id'],
					'text' => $item['text'],
					'datetime' => $date,
					'language' => $language,
					'retweet_count' => $item['retweet_count'],
					'favorite_count' => $item['favorite_count'],
					'screen_name' => $item['screen_name'],
					'profile_image' => $item['profile_image'],
					'image' => $image
				]);

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
	* Import the Image if there is one
	*/
	private function importImage($image, $id)
	{
		// Get the file extension
		$image_parts = pathinfo($image);
		$extension = $image_parts['extension'];

		// Get the file itself, set the name & destination
		$image_file = file_get_contents($image);
		$filename = time() . '-' . $id . '.' . $extension;
		$destination = public_path() . '/assets/uploads/twitter_images/' . $filename;

		// Upload the file and return the generated filename
		$upload = Image::make($image_file)->save($destination, 80);
		
		return $filename;
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