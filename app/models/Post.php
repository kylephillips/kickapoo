<?php
/**
* Posts are single approved social posts
*/
class Post extends Eloquent {

	protected $table = 'posts';
	
	protected $fillable = ['type', 'tweet_id', 'gram_id', 'facebook_id', 'user_id'];


	/**
	* Tweet Relationship
	*/
	public function tweet()
	{
		return $this->hasOne('Tweet', 'id', 'tweet_id');
	}

	/**
	* Gram Relationship
	*/
	public function gram()
	{
		return $this->hasOne('Gram', 'id', 'gram_id');
	}

	/**
	* Facebook Post Relationship
	*/
	public function fbpost()
	{
		return $this->hasOne('FBPost', 'id', 'facebook_id');
	}

	/**
	* User Relationship
	*/
	public function user()
	{
		return $this->belongsTo('User');
	}

}