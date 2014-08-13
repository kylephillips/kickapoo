<?php
/**
* Seed the DB with the default product sizes
*/
class ProductSizeSeeder extends Seeder {

	public function run()
	{
		DB::table('productsizes')->delete();
		ProductSize::create([
			'title' => '12oz Glass Bottle',
			'slug' => '12oz-glass-bottle'
		]);
		ProductSize::create([
			'title' => '12oz Slim Can',
			'slug' => '12oz-slim-can'
		]);
		ProductSize::create([
			'title' => '1L PET Bottle',
			'slug' => '1l-pet-bottle'
		]);
	}

}