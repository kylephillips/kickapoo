<?php namespace Kickapoo\Repositories;
use \Post;

class PostRepository {

	/**
	* Get all Posts
	*/
	public function getPosts()
	{
		$posts = Post::with('tweet', 'gram')->get();

		// $posts = Post::with([
		// 	'tweet' => function($query){
		// 		$query->orderBy('tweets.datetime', 'desc');
		// 	},
		// 	'gram' => function($query){
		// 		$query->orderBy('grams.datetime', 'asc');
		// 	}
		// ])->get();

		return $posts;
	}

}