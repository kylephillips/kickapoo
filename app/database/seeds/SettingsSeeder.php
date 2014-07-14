<?php
/**
* Seed the DB with the site settings
*/
class SettingsSeeder extends Seeder {

	public function run()
	{
		DB::table('settings')->delete();
		Setting::create([
			'key' => 'twitter_search',
			'value' => '#worldcup'
		]);
		Setting::create([
			'key' => 'instagram_search',
			'value' => 'worldcup'
		]);
	}

}