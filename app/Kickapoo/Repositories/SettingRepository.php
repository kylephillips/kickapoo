<?php namespace Kickapoo\Repositories;
use \DB;

class SettingRepository {

	/**
	* Get the Twitter Search Term
	* @return string
	*/ 
	public function twitterSearch()
	{
		return DB::table('settings')->where('key', 'twitter_search')->pluck('value');
	}

	/**
	* Get the Instagram Search Term
	*/
	public function instagramSearch()
	{
		return DB::table('settings')->where('key', 'instagram_search')->pluck('value');
	}

}