<?php
class PageSeeder extends Seeder {

	public function run()
	{
		DB::table('pages')->delete();
		Page::create([
			'title' => 'History',
			'slug' => 'history',
			'content' => '<p>History Lorem Ipsum</p>',
			'author' => 1,
			'status' => 'publish',
			'menu_order' => 1
		]);
		Page::create([
			'title' => 'Products',
			'slug' => 'products',
			'content' => '<p>Products Lorem Ipsum</p>',
			'author' => 1,
			'status' => 'publish',
			'menu_order' => 2
		]);
		Page::create([
			'title' => 'Locate',
			'slug' => 'locate',
			'content' => '<p>Locate Lorem Ipsum</p>',
			'author' => 1,
			'status' => 'publish',
			'menu_order' => 3
		]);
		Page::create([
			'title' => 'Contact',
			'slug' => 'contact',
			'content' => '<p>Contact Lorem Ipsum</p>',
			'author' => 1,
			'status' => 'publish',
			'menu_order' => 4
		]);
	}

}