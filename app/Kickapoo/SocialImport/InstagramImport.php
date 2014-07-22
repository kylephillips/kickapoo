<?php namespace Kickapoo\SocialImport;
use Kickapoo\SocialFeed\InstagramFeed;
use \Gram;
use \Image;
use \Trash;

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
	* Import the Instagram Posts
	* @todo copy images locally
	*/
	private function doImport()
	{
		if ( $this->feed ) :
			foreach ( $this->feed as $key=>$gram )
			{
				if ( (!$this->exists($gram['id'])) && (!$this->trashed($gram['id'])) ){
					$date = strtotime($gram['date']);
					$date = date('Y-m-d H:i:s');
					$image = ( isset($gram['image']) ) ? $this->importImage($gram['image'], $gram['id']) : null;

					Gram::create([
						'instagram_id' => $gram['id'],
						'datetime' => $date,
						'link' => $gram['link'],
						'type' => $gram['type'],
						'like_count' => $gram['like_count'],
						'image' => ( $image ) ? $image : null,
						'video_url' => ( isset($gram['video_url']) ) ? $gram['video_url'] : null,
						'text' => ( isset($gram['caption']) ) ? $gram['caption'] : null,
						'user_id' => $gram['user_id'],
						'screen_name' => $gram['screen_name'],
						'profile_image' => ( isset($gram['profile_image']) ) ? $gram['profile_image'] : null,
						'latitude' => ( isset($gram['latitude']) ) ? $gram['latitude'] : null,
						'longitude' => ( isset($gram['longitude']) ) ? $gram['longitude'] : null
					]);

					$this->import_count++;
				} elseif ( count($this->feed) == 1 ){
					if ( $this->exists($gram['id']) ) throw new \Kickapoo\Exceptions\PostExistsException;
					if ( $this->trashed($gram['id']) ) throw new \Kickapoo\Exceptions\PostTrashedException;
				}
			}
		endif;
	}

	/**
	* Check if a Gram is already imported
	*/
	private function exists($gram)
	{
		return ( Gram::where('instagram_id', $gram)->count() ) ? true : false;
	}


	/**
	* Check if Gram has been trashed
	*/
	private function trashed($gram)
	{
		return ( Trash::where('instagram_id', $gram)->count() ) ? true : false;
	}


	/**
	* Import the Image if there is one
	* @todo apply any crops needed from design
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