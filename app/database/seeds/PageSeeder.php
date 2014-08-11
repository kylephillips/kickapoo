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
			'menu_order' => 0
		]);
		Page::create([
			'title' => 'History',
			'slug' => 'history',
			'content' => '<p>History Lorem Ipsum</p>',
			'author' => 1,
			'status' => 'publish',
			'template' => 'history',
			'menu_order' => 1
		]);
		Page::create([
			'title' => 'Products',
			'slug' => 'products',
			'content' => '<p>Products Lorem Ipsum</p>',
			'author' => 1,
			'status' => 'publish',
			'template' => 'products',
			'menu_order' => 2
		]);
		Page::create([
			'title' => 'Locate',
			'slug' => 'locate',
			'content' => '<p>Locate Lorem Ipsum</p>',
			'author' => 1,
			'status' => 'publish',
			'template' => 'locate',
			'menu_order' => 3
		]);
		Page::create([
			'title' => 'Contact',
			'slug' => 'contact',
			'content' => '<p>Contact Lorem Ipsum</p>',
			'author' => 1,
			'status' => 'publish',
			'template' => 'contact',
			'menu_order' => 4
		]);
	}

}