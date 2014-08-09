<?php namespace Kickapoo\Factories;

use \FBPost;
use \Image;
use \Error;

class FBPostFactory {

	public function createPost($item)
	{
		$date = date('Y-m-d H:i:s', $item['date']);
		$image = ( isset($item['picture']) ) ? $this->importImage($item['picture'], $item['id']) : null;
		$caption_image = ( isset($item['caption_picture']) ) ? $this->importImage($item['caption_picture'], $item['id']) : null;

		FBPost::create([
			'facebook_id' => $item['id'],
			'datetime' => $date,
			'user_id' => $item['user_id'],
			'screen_name' => ( isset($item['screen_name']) ) ? $item['screen_name'] : null,
			'profile_image' => ( isset($item['profile_image']) ) ? $item['profile_image'] : null,
			'link' => ( isset($item['link']) ) ? $item['link'] : null,
			'story' => ( isset($item['story']) ) ? $item['story'] : null,
			'caption' => ( isset($item['caption']) ) ? $item['caption'] : null,
			'caption_title' => ( isset($item['caption_title']) ) ? $item['caption_title'] : null,
			'caption_description' => ( isset($item['caption_description']) ) ? $item['caption_description'] : null,
			'type' => $item['type'],
			'message' => ( isset($item['message']) ) ? $item['message'] : null,
			'image' => $image,
			'caption_image' => $caption_image
		]);
	}

	/**
	* Import the Image if there is one
	*/
	private function importImage($image, $id)
	{
		try {
			// Get the file extension
			$image_parts = pathinfo($image);
			$extension = $image_parts['extension'];
			$extension = explode('?', $extension, 2); // remove FB query string

			// Get the file itself, set the name & destination
			$image_file = file_get_contents($image);
			$filename = time() . '-' . $id . '.' . $extension[0];
			$destination = public_path() . '/assets/uploads/facebook_images/' . $filename;

			// Upload the file and return the generated filename
			$upload = Image::make($image_file)->save($destination, 80);
		} catch (\Exception $e){
			Error::create(['time' => date("Y-m-d H:i:s"), 'message' => $e->getMessage()]);
			return null;
		}
		
		return $filename;
	}

}