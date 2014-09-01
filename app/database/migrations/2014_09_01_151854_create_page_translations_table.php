<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePageTranslationsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('page_translations', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('parent_page');
			$table->integer('translated_page');
			$table->timestamps();
			$table->foreign('parent_page')->references('id')->on('pages')->onDelete('cascade');
			$table->foreign('translated_page')->references('id')->on('pages')->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('page_translations');
	}

}
