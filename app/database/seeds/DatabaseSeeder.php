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
			$this->call('SettingsSeeder');
			$this->call('UserSeeder');
		}
		$this->call('PageSeeder');
	}

}
