<?php
/**
* Posts are single approved social posts
*/
class Post extends Eloquent {

	protected $table = 'posts';
	
	protected $fillable = ['type', 'tweet_id', 'gram_id', 'user_id'];


	/**
	* Tweet Relationship
	*/
	public function tweet()
	{
		return $this->belongsTo('Tweet', 'id', 'tweet_id');
	}

	/**
	* Gram Relationship
	*/
	public function gram()
	{
		return $this->belongsTo('Gram', 'id', 'gram_id');
	}

	/**
	* User Relationship
	*/
	public function user()
	{
		return $this->belongsTo('User');
	}

}