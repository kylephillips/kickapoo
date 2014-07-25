<?php namespace Kickapoo\Factories;

use \Gram;
use \Image;

class GramFactory {

	public function createGram($item)
	{
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

}