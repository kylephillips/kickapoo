<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTweetsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tweets', function(Blueprint $table)
		{
			$table->engine = 'InnoDB';
			$table->increments('id')->unsigned();
			$table->bigInteger('twitter_id');
			$table->text('text');
			$table->datetime('datetime');
			$table->string('language')->nullable();
			$table->integer('retweet_count');
			$table->integer('favorite_count');
			$table->string('screen_name');
			$table->string('profile_image');
			$table->string('location')->nullable();
			$table->string('image')->nullable();
			$table->integer('approved')->nullable();
			$table->timeStamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('tweets');
	}

}
