<?php
class Banned extends Eloquent {

	protected $table = 'bannedusers';
	protected $fillable = ['screen_name', 'type'];

	/**
	* Banned Twitter User Relationship
	*/
	public function twitterbanned()
	{
		return $this->hasMany('tweet', 'screen_name', 'screen_name');
	}

	/**
	* Banned Instagram User Relationship
	*/
	public function instagrambanned()
	{
		return $this->hasMany('gram', 'screen_name', 'screen_name');
	}

}