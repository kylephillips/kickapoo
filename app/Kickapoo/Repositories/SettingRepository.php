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

	/**
	* Get Social API Creds
	*/
	public function socialCreds()
	{
		$settings_array = [
			'twitter_api_key',
			'twitter_api_secret',
			'twitter_access_token',
			'twitter_access_token_secret',
			'instagram_client_id',
			'instagram_client_secret'
		];
		$all_settings = DB::table('settings')->whereIn('key', $settings_array)->get();
		foreach( $all_settings as $setting )
		{
			$settings[$setting->key] = $setting->value;
		}
		return $settings;
	}

}