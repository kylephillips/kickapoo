<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFbpostsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('fbposts', function(Blueprint $table)
		{
			$table->engine = 'InnoDB';
			$table->increments('id')->unsigned();
			$table->bigInteger('facebook_id')->unsigned()->nullable();
			$table->datetime('datetime');
			$table->text('message')->nullable();
			$table->bigInteger('user_id')->nullable();
			$table->string('profile_image')->nullable();
			$table->string('type')->nullable();
			$table->string('link')->nullable();
			$table->string('image')->nullable();
			$table->text('story')->nullable();
			$table->text('caption')->nullable();
			$table->string('caption_image')->nullable();
			$table->text('caption_description')->nullable();
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
		Schema::drop('fbposts');
	}

}
