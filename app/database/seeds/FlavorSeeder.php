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
			'order' => 0,
			'css_class' => 'joy-juice',
			'content' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque pretium rutrum massa, vel vulputate velit eleifend eu. Aliquam semper quam et magna egestas, vitae scelerisque urna vulputate. In sem velit, molestie sed consectetur nec, luctus sed mi.'
		]);
		Flavor::create([
			'title' => 'Kickapoo Fruit Shine',
			'slug' => 'kickapoo-fruit-shine',
			'order' => 1,
			'css_class' => 'fruit-shine',
			'content' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque pretium rutrum massa, vel vulputate velit eleifend eu. Aliquam semper quam et magna egestas, vitae scelerisque urna vulputate. In sem velit, molestie sed consectetur nec, luctus sed mi.'
		]);
	}

}