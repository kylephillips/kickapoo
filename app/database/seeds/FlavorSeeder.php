<?php
/**
* Seed the DB with the default flavors
*/
class FlavorSeeder extends Seeder {

	public function run()
	{
		DB::table('flavors')->delete();
		Flavor::create([
			'title' => 'Kickapoo Joy Juice',
			'slug' => 'kickapoo-joy-juice',
			'content' => 'Test Kickapoo Joy Juice content lorem ipsum'
		]);
		Flavor::create([
			'title' => 'Kickapoo Fruit Shine',
			'slug' => 'kickapoo-fruit-shine',
			'content' => 'Test Kickapoo Fruit Shine content lorem ipsum'
		]);
	}

}