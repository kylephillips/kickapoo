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
			$table->engine = 'InnoDB';
			$table->increments('id')->unsigned();
			$table->string('type')->default('tweet');
			$table->unsignedInteger('tweet_id')->nullable();
			$table->unsignedInteger('gram_id')->nullable();
			$table->unsignedInteger('facebook_id')->nullable();
			$table->integer('user_id')->unsigned()->nullable();
			$table->foreign('tweet_id')->references('id')->on('tweets')->onDelete('cascade');
			$table->foreign('gram_id')->references('id')->on('grams')->onDelete('cascade');
			$table->foreign('facebook_id')->references('id')->on('fbposts')->onDelete('cascade');
			$table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
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
