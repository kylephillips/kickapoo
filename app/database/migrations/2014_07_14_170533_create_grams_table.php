<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGramsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('grams', function(Blueprint $table)
		{
			$table->engine = 'InnoDB';
			$table->increments('id')->unsigned();
			$table->bigInteger('instagram_id');
			$table->datetime('datetime');
			$table->string('link');
			$table->string('type');
			$table->integer('like_count');
			$table->string('image')->nullable();
			$table->string('video_url')->nullable();
			$table->text('text')->nullable();
			$table->bigInteger('user_id');
			$table->string('screen_name');
			$table->string('profile_image')->nullable();
			$table->string('latitude')->nullable();
			$table->string('longitude')->nullable();
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
		Schema::drop('grams');
	}

}
