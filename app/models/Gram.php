<?php
/**
* Instagram Model
*/
class Gram extends Eloquent {

	protected $table = 'grams';
	public $timestamps = false;
	protected $fillable = ['instagram_id', 'datetime', 'link', 'type', 'like_count', 'image', 'video_url', 'text', 'user_id', 'screen_name', 'profile_image', 'latitude', 'longitude'];

}