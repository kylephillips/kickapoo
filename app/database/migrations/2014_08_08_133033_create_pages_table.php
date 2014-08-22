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
			$table->foreign('author')->references('id')->on('users')->onDelete('cascade');
			$table->string('status')->default('draft');
			$table->string('template')->nullable();
			$table->string('seo_title')->nullable();
			$table->text('seo_description')->nullable();
			$table->integer('menu_order');
			$table->integer('show_in_menu')->default(1);
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
