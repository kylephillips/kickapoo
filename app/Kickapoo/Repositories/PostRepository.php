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
	* Get a single Post
	*/
	public function getSingle($id, $type)
	{
		$post = ( $type == 'twitter' ) ? Tweet::where('id', $id)->first() : Gram::where('id', $id)->first();
		return $post;
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

	/**
	* Get Trash count
	*/
	public function trashCount()
	{
		$tweets = Tweet::with('post')->where('approved', 0)->count();
		$grams = Gram::with('post')->where('approved', 0)->count();
		$count = $tweets + $grams;		
		return $count;
	}

}