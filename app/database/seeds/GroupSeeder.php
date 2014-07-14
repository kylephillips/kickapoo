<?php
/**
* Seed the DB with the default groups
*/
class GroupSeeder extends Seeder {

	public function run()
	{
		DB::table('groups')->delete();
		Group::create([
			'title' => 'Admin',
			'slug' => 'admin'
		]);
		Group::create([
			'title' => 'Editor',
			'slug' => 'editor'
		]);
		Group::create([
			'title' => 'Member',
			'slug' => 'member'
		]);
	}

}