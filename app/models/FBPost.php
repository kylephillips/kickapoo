<?php
class FBPost extends Eloquent {

	protected $table = 'fbposts';

	protected $primaryKey = 'facebook_id';
	
	protected $fillable = [
		'facebook_id', 'datetime', 'message', 'user_id', 'screen_name', 'profile_image', 'type', 'link', 'image', 'story', 'caption', 'caption_image', 'caption_description', 'approved'
	];

	/**
	* Post Relationship
	*/
	public function post()
	{
		return $this->hasOne('Post', 'facebook_id', 'id');
	}

	/**
	* Banned Users Relationship
	*/
	public function banned()
	{
		return $this->belongsTo('Banned', 'screen_name', 'screen_name');
	}


}