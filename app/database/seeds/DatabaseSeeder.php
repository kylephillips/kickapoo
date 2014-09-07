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
		if ( (App::environment() == 'local') || (App::environment() == 'staging' ) ){
			$this->deleteImages();
			$this->call('SettingsSeeder');
			$this->call('UserSeeder');
		}
		$this->call('PageSeeder');
		$this->call('ProductSizeSeeder');
		$this->call('FlavorSeeder');
		$this->call('ProductSeeder');
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
		$facebook_images = glob(public_path() . '/assets/uploads/facebook_images/*');
		foreach($facebook_images as $file){
			if(is_file($file))
			unlink($file);
		}
		$page_images = glob(public_path() . '/assets/uploads/page_images/*');
		foreach($page_images as $file){
			if(is_file($file))
			unlink($file);
		}
		$product_images = glob(public_path() . '/assets/uploads/product_images/*');
		foreach($product_images as $file){
			if(is_file($file))
			unlink($file);
		}
	}

}
