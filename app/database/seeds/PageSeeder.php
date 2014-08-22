<?php
class PageSeeder extends Seeder {

	public function run()
	{
		DB::table('pages')->delete();
		Page::create([
			'title' => 'Home',
			'slug' => 'home',
			'content' => '<p>#<em>kickapoo</em> to share your joy face with the world!</p>',
			'author' => 1,
			'status' => 'publish',
			'template' => 'home',
			'menu_order' => 0,
			'show_in_menu' => 0
		]);
		Page::create([
			'title' => 'History',
			'slug' => 'history',
			'content' => '<p>History Lorem Ipsum</p>',
			'author' => 1,
			'status' => 'publish',
			'template' => 'history',
			'seo_title' => 'History',
			'seo_description' => 'The history of Kickapoo Joy Juice',
			'menu_order' => 1,
			'show_in_menu' => 1
		]);
		Page::create([
			'title' => 'Products',
			'slug' => 'products',
			'content' => '<p>Kickapoo Joy Juice and Kickapoo Fruit Shine sodas offer unique flavors such as heavy citrus and sangria that will have your taste buds exploding. Delighting soft drink customers since 1934, Kickapoo has the superior flavor and the caffeine to give you the kick you crave.</p>',
			'author' => 1,
			'status' => 'publish',
			'template' => 'products',
			'seo_title' => 'Products',
			'seo_description' => 'Kickapoo Joy Juice products',
			'menu_order' => 2,
			'show_in_menu' => 1
		]);
		Page::create([
			'title' => 'Locate',
			'slug' => 'locate',
			'content' => '<p>Locate Lorem Ipsum</p>',
			'author' => 1,
			'status' => 'publish',
			'template' => 'locate',
			'seo_title' => 'Locate',
			'seo_description' => 'Find Kickapoo Joy Juice near you',
			'menu_order' => 3,
			'show_in_menu' => 1
		]);
		Page::create([
			'title' => 'Contact',
			'slug' => 'contact',
			'content' => '<p>Contact Lorem Ipsum</p>',
			'author' => 1,
			'status' => 'publish',
			'template' => 'contact',
			'seo_title' => 'Contact',
			'seo_description' => 'Contact Kickapoo Joy Juice',
			'menu_order' => 4,
			'show_in_menu' => 1
		]);
	}

}