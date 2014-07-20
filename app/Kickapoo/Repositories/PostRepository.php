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
	* Get all Posts that haven't been trashed
	*/
	public function getPosts()
	{
		$tweets = Tweet::with('post')->whereRaw('approved IS NULL')->orWhere('approved', 1)->get();
		$grams = Gram::with('post')->whereRaw('approved IS NULL')->orWhere('approved', 1)->get();
		$posts = $tweets->merge($grams)->sortByDesc('datetime');
		return $posts;
	}


	/**
	* Get Trashed Posts
	*/
	public function getTrash()
	{
		$tweets = Tweet::with('post')->where('approved', 0)->get();
		$grams = Gram::with('post')->where('approved', 0)->get();
		$posts = $tweets->merge($grams)->sortByDesc('datetime');
		return $posts;
	}

}