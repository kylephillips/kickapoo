<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTrashTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('trash', function(Blueprint $table)
		{
			$table->increments('id')->unsigned();
			$table->string('type')->default('twitter');
			$table->bigInteger('twitter_id')->nullable();
			$table->bigInteger('instagram_id')->nullable();
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
		Schema::drop('trash');
	}

}
