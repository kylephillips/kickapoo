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


	/**
	* Update the Settings
	*/
	public function updateSettings($input)
	{
		foreach( $input as $key=>$value ){
			// Save the settings
			if ( ($key != '_token') && ( substr($key, 0, 5) != 'icon_' ) ){
				$setting = Setting::where('key', $key)->firstOrFail();
				$setting->value = $value;
				$setting->save();
			}
			// Save Icon Classes
			if ( ($key != '_token') && ( substr($key, 0, 5) == 'icon_' ) ){
				$column = str_replace('icon_', '', $key);
				$setting = Setting::where('key', $column)->firstOrFail();
				$setting->value_two = $value;
				$setting->save();
			}
		}
	}


}