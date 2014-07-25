<?php namespace Kickapoo\SocialImport;
use Kickapoo\SocialFeed\InstagramFeed;
use \Gram;
use \Image;
use \Trash;
use \Banned;

class InstagramImport {


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
	* Import the Posts
	*/
	private function doImport()
	{
		if ( $this->feed ) :
			foreach ( $this->feed as $key=>$item )
			{
				if ( $this->validates($item) ){
					$date = strtotime($item['date']);
					$date = date('Y-m-d H:i:s');
					$image = ( isset($item['image']) ) ? $this->importImage($item['image'], $item['id']) : null;

					Gram::create([
						'instagram_id' => $item['id'],
						'datetime' => $date,
						'link' => $item['link'],
						'type' => $item['type'],
						'like_count' => $item['like_count'],
						'image' => ( $image ) ? $image : null,
						'video_url' => ( isset($item['video_url']) ) ? $item['video_url'] : null,
						'text' => ( isset($item['caption']) ) ? $item['caption'] : null,
						'user_id' => $item['user_id'],
						'screen_name' => $item['screen_name'],
						'profile_image' => ( isset($item['profile_image']) ) ? $item['profile_image'] : null,
						'latitude' => ( isset($item['latitude']) ) ? $item['latitude'] : null,
						'longitude' => ( isset($item['longitude']) ) ? $item['longitude'] : null
					]);

					$this->import_count++;
				} elseif ( count($this->feed) == 1 ){
					if ( $this->exists($item['id']) ) throw new \Kickapoo\Exceptions\PostExistsException;
					if ( $this->trashed($item['id']) ) throw new \Kickapoo\Exceptions\PostTrashedException;
					if ( $this->banned($item['screen_name']) ) throw new \Kickapoo\Exceptions\BannedUserException;
				}
			}
		endif;
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
		return ( Gram::where('instagram_id', $id)->count() ) ? true : false;
	}


	/**
	* Check if trashed
	* @param int
	*/
	private function trashed($id)
	{
		return ( Trash::where('instagram_id', $id)->count() ) ? true : false;
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
		$destination = public_path() . '/assets/uploads/instagram_images/' . $filename;

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