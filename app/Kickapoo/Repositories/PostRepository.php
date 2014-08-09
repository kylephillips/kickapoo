<?php namespace Kickapoo\Repositories;

use \DB;
use \Post;
use \Tweet;
use \Gram;
use \FBPost;
use \Paginator;
use \Carbon\Carbon;

class PostRepository {


	/**
	* Get all approved Posts
	*/
	public function getApproved()
	{
		$posts = Post::with('tweet', 'gram')->orderBy('created_at', 'DESC')->paginate(8);
		return $posts;
	}


	/**
	* Get a single Post
	*/
	public function getSingle($id, $type)
	{
		if ( $type == 'twitter' ) $post = Tweet::where('id', $id)->first();
		if ( $type == 'instagram' ) $post = Gram::where('id', $id)->first();
		if ( $type == 'facebook' ) $post = FBPost::where('id', $id)->first();
		return $post;
	}

	/**
	* Get a single Post by it's social id
	*/
	public function getSingleBySocialId($id, $type)
	{
		if ( $type == 'twitter' ) $post = Tweet::findOrFail($id);
		if ( $type == 'instagram' ) $post = Gram::findOrFail($id);
		if ( $type == 'facebook' ) $post = FBPost::findOrFail($id);
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
		} elseif ( $type == 'facebook' ) {
			$posts = $this->getPostType($status, $type = 'facebook');
		} else {
			$tweets = $this->getPostType($status, $type = 'twitter');
			$grams = $this->getPostType($status, $type = 'instagram');
			$fbposts = $this->getPostType($status, $type = 'facebook');

			$posts = $tweets->merge($grams)->merge($fbposts)->sortByDesc('datetime');
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
		if ( $type == 'facebook' ) $query = FBPost::with('post', 'post.user');
		
		// Filter by status
		if ( $status == 'all' ){
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
		$fbposts = FBPost::with('post')->where('approved', 0)->get();
		$posts = $tweets->merge($grams)->merge($fbposts)->sortByDesc('datetime');
		return $posts;
	}

	/**
	* Get Trash count
	*/
	public function trashCount()
	{
		$tweets = Tweet::with('post')->where('approved', 0)->count();
		$grams = Gram::with('post')->where('approved', 0)->count();
		$fbposts = FBPost::with('post')->where('approved', 0)->count();
		$count = $tweets + $grams + $fbposts;		
		return $count;
	}

	/**
	* Get count of posts awaiting moderation
	*/
	public function getPendingCount()
	{
		$fbposts = FBPost::with('post')->whereRaw('approved IS NULL')->count();
		$tweets = Tweet::with('post')->whereRaw('approved IS NULL')->count();
		$grams = Gram::with('post')->whereRaw('approved IS NULL')->count();
		$count = $tweets + $grams + $fbposts;
		return $count;
	}

	/**
	* Clean out old Posts
	*/
	public function cleanOldPosts()
	{
		$monthOld = Carbon::now()->subMonth();
		$tweets = Tweet::where('created_at','<=',$monthOld)->whereRaw('approved IS NULL')->delete();
		$grams = Gram::where('created_at','<=',$monthOld)->whereRaw('approved IS NULL')->delete();
		$fbposts = FBPost::where('created_at','<=',$monthOld)->whereRaw('approved IS NULL')->delete();
		return 'cleaned';
	}

}