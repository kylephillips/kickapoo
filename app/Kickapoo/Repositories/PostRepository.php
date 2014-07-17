<?php namespace Kickapoo\Repositories;
use \Post;

class PostRepository {

	/**
	* Get all Posts
	*/
	public function getPosts()
	{
		$posts = Post::with('tweet', 'gram')->get();
		return $posts;
	}

}