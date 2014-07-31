<?php
class Setting extends Eloquent {

	protected $table = 'settings';
	protected $fillable = ['key', 'value'];

	public static $search_required = [
		'twitter_search' => 'required',
		'instagram_search' => 'required'
	];

	public static $settings_required = [
		'store_link' => 'url',
		'twitter_link' => 'url',
		'instagram_link' => 'url',
		'vine_link' => 'url',
		'youtube_link' => 'url',
		'twitter_api_key' => 'required',
		'twitter_api_secret' => 'required',
		'twitter_access_token' => 'required',
		'twitter_access_token_secret' => 'required',
		'instagram_client_id' => 'required',
		'instagram_client_secret' => 'required'
	];

}