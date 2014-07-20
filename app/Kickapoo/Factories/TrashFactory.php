<?php namespace Kickapoo\Factories;

use \Kickapoo\Repositories\PostRepository;
use \AppLog;
use \Tweet;
use \Gram;
use \Trash;

class TrashFactory {

	/**
	* Post Repository
	*/
	protected $post_repo;


	public function __construct(PostRepository $post_repo)
	{
		$this->post_repo = $post_repo;
	}


	/**
	* Empty all the trash
	*/
	public function emptyTrash()
	{
		$posts = $this->post_repo->getTrash();
		foreach($posts as $post)
		{
			$this->deletePost($post);
		}
		$this->log();
	}


	/**
	* Delete a Post
	*/
	public function deletePost($post)
	{
		$type = ( isset($post['twitter_id']) ) ? 'twitter' : 'instagram';
		$twitter_id = ( $type == 'twitter' ) ? $post['twitter_id'] : null;
		$instagram_id = ( $type != 'twitter' ) ? $post['instagram_id'] : null;
		
		Trash::create([
			'type' => $type,
			'twitter_id' => $twitter_id,
			'instagram_id' => $instagram_id
		]);

		if ( $post['image'] ) $this->removeImage($post['image'], $type);
		$this->removePost($post['id'], $type);
	}


	/**
	* Remove Image from server
	*/
	private function removeImage($image, $type)
	{
		$directory = ( $type == 'twitter' ) ? public_path() . '/assets/uploads/twitter_images/' : public_path() . '/assets/uploads/instagram_images';
		$file = $directory . '/' . $image;
		unlink($file);
	}


	/**
	* Remove Post
	*/
	public function removePost($id, $type)
	{
		$post = $this->post_repo->getSingle($id, $type);
		$post->delete();
	}

	/**
	* Create Log Item
	*/
	private function log()
	{
		AppLog::create([
			'type' => 'trash',
			'description' => 'All trash emptied.'
		]);
	}

}