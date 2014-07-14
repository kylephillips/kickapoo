<?php
class LanguageSeeder extends Seeder {

	public function run()
	{
		DB::table('languages')->delete();
		Language::create([
			'title' => 'English',
			'slug' => 'en-US'
		]);
	}

}