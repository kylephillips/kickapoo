<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ConvertSettingsValueToText extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::drop('settings');

		Schema::create('settings', function(Blueprint $table)
		{
			$table->engine = 'InnoDB';
			$table->increments('id')->unsigned();
			$table->string('key')->unique();
			$table->string('description')->nullable();
			$table->text('value');
			$table->text('value_two')->nullable();
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('settings');
	}

}
