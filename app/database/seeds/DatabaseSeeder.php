<?php

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Eloquent::unguard();
		$this->call('GroupSeeder');
		$this->call('LanguageSeeder');
		if ( (App::environment() == 'local') || (App::environment() == 'staging' ) ){
			$this->deleteImages();
			$this->call('SettingsSeeder');
			$this->call('UserSeeder');
		}
	}

	/**
	* Delete all the uploaded images from social imports
	*/
	private function deleteImages()
	{
		$twitter_images = glob(public_path() . '/assets/uploads/twitter_images/*');
		foreach($twitter_images as $file){
			if(is_file($file))
			unlink($file);
		}
		$instagram_images = glob(public_path() . '/assets/uploads/instagram_images/*');
		foreach($instagram_images as $file){
			if(is_file($file))
			unlink($file);
		}
	}

}
