<?php namespace Kickapoo\Repositories;

use \DB;
use \Post;
use \Tweet;
use \Gram;
use \Paginator;
use \Carbon\Carbon;

class PostRepository {


	/**
	* Get all approved Posts
	*/
	public function getApproved()
	{
		$posts = Post::with('tweet', 'gram')->paginate(8);
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
	public function getPosts($type = null, $status = null)
	{
		if ( $type == 'twitter' ){
			$posts = $this->getPostType($status, $type = 'twitter');
		} elseif ( $type == 'instagram' ){
			$posts = $this->getPostType($status, $type = 'instagram');
		} else {
			$tweets = $this->getPostType($status, $type = 'twitter');
			$grams = $this->getPostType($status, $type = 'instagram');
			$posts = $tweets->merge($grams)->sortByDesc('datetime');
		}
		return $posts;
	}


	/**
	* Get Posts of a Specified Type
	*/
	private function getPostType($status = null, $type = null)
	{
		if ( $type == 'twitter' ) $query = Tweet::with('post', 'post.user', 'banned');
		if ( $type == 'instagram' ) $query = Gram::with('post', 'post.user', 'banned');
		
		// Filter by status
		if ( $status == null ){
			$query->whereRaw('approved IS NULL')->orWhere('approved', 1);
		} elseif ( $status == 'approved' ){
			$query->where('approved', 1);
		} elseif ( $status == 'unmoderated' ){
			$query->whereRaw('approved IS NULL');
		}

		return $query->get();
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

	/**
	* Get count of posts awaiting moderation
	*/
	public function getPendingCount()
	{
		$tweets = Tweet::with('post', 'banned')->whereRaw('approved IS NULL')->count();
		$grams = Gram::with('post', 'banned')->whereRaw('approved IS NULL')->count();
		$count = $tweets + $grams;
		return $count;
	}

	/**
	* Clean out old Posts
	*/
	public function cleanOldPosts()
	{
		$monthOld = Carbon::now()->subMonth();
		$tweets = Tweet::where('created_at','<=',$monthOld)->whereRaw('approved IS NULL')->delete();
		$tweets = Gram::where('created_at','<=',$monthOld)->whereRaw('approved IS NULL')->delete();
		return 'cleaned';
	}

}