<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('posts', function(Blueprint $table)
		{
			$table->increments('id')->unsigned();
			$table->string('type')->default('tweet');
			$table->integer('tweet_id')->unsigned()->nullable();
			$table->integer('gram_id')->unsigned()->nullable();
			$table->foreign('tweet_id')->references('id')->on('tweets')->onDelete('cascade');
			$table->foreign('gram_id')->references('id')->on('grams')->onDelete('cascade');
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
		Schema::drop('posts');
	}

}
