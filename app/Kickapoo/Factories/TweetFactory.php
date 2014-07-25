<?php namespace Kickapoo\Factories;

use \Tweet;
use \Image;

class TweetFactory {

	public function createTweet($item)
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


}