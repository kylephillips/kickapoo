<?php namespace Kickapoo\Factories;

use \Tweet;
use \Gram;
use \FBPost;
use \Post;
use \Auth;

class PostFactory {

	public function savePost($id, $type)
	{
		if ( $type == 'twitter' ){
			$post = Tweet::findOrFail($id);
		} elseif ($type == 'instagram') {
			$post = Gram::findOrFail($id);
		} else {
			$post = FBPost::findOrFail($id);
		}

		$tweet_id = ( $type == 'twitter' ) ? $post->id : null;
		$gram_id = ( $type == 'instagram' ) ? $post->id : null;
		$facebook_id = ( $type == 'facebook' ) ? $post->id : null;

		$post->approved = 1;
		$post->save();

		$newpost = Post::create([
			'type' => $type,
			'tweet_id' => $tweet_id,
			'gram_id' => $gram_id,
			'facebook_id' => $facebook_id,
			'user_id' => Auth::user()->id
		]);

		return $newpost;
	}

}