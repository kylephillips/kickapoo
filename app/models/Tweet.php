<?php
/**
* Individual Tweets
*/
class Tweet extends Eloquent {

	protected $table = 'tweets';

	protected $primaryKey = 'twitter_id';
	
	public $timestamps = false;
	
	protected $fillable = ['twitter_id', 'text', 'datetime', 'retweet_count', 'favorite_count', 'screen_name', 'profile_image', 'language', 'location', 'image'];

	/**
	* Post Relationship
	*/
	public function post()
	{
		return $this->hasOne('Post');
	}

}