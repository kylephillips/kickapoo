<?php
class FBPost extends Eloquent {

	protected $table = 'fbposts';

	protected $primaryKey = 'facebook_id';
	
	protected $fillable = [
		'facebook_id', 'datetime', 'message', 'user_id', 'type', 'link', 'image', 'story', 'caption', 'caption_image', 'caption_description', 'approved'
	];

	/**
	* Post Relationship
	*/
	public function post()
	{
		return $this->hasOne('Post', 'facebook_id', 'id');
	}


}