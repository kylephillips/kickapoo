<?php namespace Kickapoo\Repositories;

use \DB;
use \Post;
use \Tweet;
use \Gram;
use \Paginator;

class PostRepository {


	/**
	* Get all approved Posts
	*/
	public function getApprovedPosts()
	{
		$posts = Post::with('tweet', 'gram')->get();
		return $posts;
	}


	/**
	* Get all Tweets & Grams
	*/
	public function getPosts()
	{
		$tweets = Tweet::whereRaw('approved IS NULL')->orWhere('approved', 1)->get();
		$grams = Gram::whereRaw('approved IS NULL')->orWhere('approved', 1)->get();
		$posts = $tweets->merge($grams)->sortByDesc('datetime');

		return $posts;
		
	}

}