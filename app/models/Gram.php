<?php
/**
* Instagram Model
*/
class Gram extends Eloquent {

	protected $table = 'grams';

	protected $primaryKey = 'instagram_id';
	
	protected $fillable = ['instagram_id', 'datetime', 'link', 'type', 'like_count', 'image', 'video_url', 'text', 'user_id', 'screen_name', 'profile_image', 'latitude', 'longitude'];

	/**
	* Post Relationship
	*/
	public function post()
	{
		return $this->hasOne('Post', 'gram_id', 'id');
	}

	/**
	* Banned Users Relationship
	*/
	public function banned()
	{
		return $this->belongsTo('Banned', 'screen_name', 'screen_name');
	}

}