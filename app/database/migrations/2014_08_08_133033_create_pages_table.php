<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePagesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('pages', function(Blueprint $table)
		{
			$table->increments('id')->unsigned();
			$table->string('title');
			$table->string('slug')->unique();
			$table->text('content');
			$table->integer('author')->unsigned();
			$table->foreign('author')->references('id')->on('users');
			$table->string('status')->default('draft');
			$table->integer('menu_order');
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
		Schema::drop('pages');
	}

}
