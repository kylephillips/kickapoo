<?php namespace Kickapoo\SocialImport;
use \Tweet;
use \DB;
use \Image;
use \Trash;

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
	* Import the Tweets
	*/
	private function doImport()
	{
		foreach ( $this->feed as $key=>$tweet )
		{
			if ( (!$tweet['is_retweet']) && (!$this->exists($tweet['id'])) && (!$this->trashed($tweet['id'])) )
			{
				$date = strtotime($tweet['date']);
				$date = date('Y-m-d H:i:s');
				$language = ( isset($tweet['language_code']) ) ? $tweet['language_code'] : null;
				$location = ( isset($tweet['location']) ) ? $tweet['location'] : null;
				$media = ( isset($tweet['media']) ) ? $tweet['media'] : null;
				$image = ( $tweet['media'] ) ? $this->importImage($tweet['media'], $tweet['id']) : null;

				Tweet::create([
					'twitter_id' => $tweet['id'],
					'text' => $tweet['text'],
					'datetime' => $date,
					'language' => $language,
					'retweet_count' => $tweet['retweet_count'],
					'favorite_count' => $tweet['favorite_count'],
					'screen_name' => $tweet['screen_name'],
					'profile_image' => $tweet['profile_image'],
					'image' => $image
				]);

				$this->import_count++;
			} elseif ( count($this->feed) == 1 ) {
				if ( $this->exists($tweet['id']) ) throw new \Kickapoo\Exceptions\PostExistsException;
				if ( $tweet['is_retweet'] ) throw new \Kickapoo\Exceptions\TweetRetweetException;
				if ( $this->trashed($tweet['id']) ) throw new \Kickapoo\Exceptions\PostTrashedException;
			}
		}
	}


	/**
	* Check if a Tweet is already imported
	*/
	private function exists($tweet)
	{
		return ( Tweet::where('twitter_id', $tweet)->count() ) ? true : false;		
	}

	/**
	* Check if Tweet has been trashed
	*/
	private function trashed($tweet)
	{
		return ( Trash::where('twitter_id', $tweet)->count() ) ? true : false;
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