<?php namespace Kickapoo\Factories;

use \Setting;

class SettingFactory {

	/**
	* Update the social searh terms
	*/
	public function updateSearchTerms($input)
	{
		$twitter_search = Setting::where('key', 'twitter_search')->firstOrFail();
		$twitter_search->value = $input['twitter_search'];
		$twitter_search->save();

		$instagram_search = Setting::where('key', 'instagram_search')->firstOrFail();
		$instagram_search->value = $input['instagram_search'];
		$instagram_search->save();		
	}

}